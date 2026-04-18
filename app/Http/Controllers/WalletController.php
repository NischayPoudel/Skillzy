<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletTopupRequest;
use App\Models\CoinTransaction;
use App\Models\Notification;
use App\Models\RedeemRequest;
use App\Models\User;
use App\Services\KhaltiService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WalletController extends Controller
{
    private KhaltiService $khaltiService;

    public function __construct(KhaltiService $khaltiService)
    {
        $this->middleware('auth');
        $this->khaltiService = $khaltiService;
    }

    /**
     * Show wallet page
     */
    public function show(): View|RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        $transactions = CoinTransaction::where('user_id', $user->id)
            ->latest()
            ->paginate(10);
        
        return view('wallet.show', [
            'coins' => $user->coins,
            'transactions' => $transactions,
            'khaltiPublicKey' => $this->khaltiService->getPublicKey(),
        ]);
    }

    /**
     * Initiate wallet top-up payment
     */
    public function topup(WalletTopupRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $amount = (float) $request->amount;

        // Validate amount
        if ($amount <= 0 || $amount > 999999.99) {
            return redirect()->route('wallet.show')->withErrors([
                'amount' => 'Invalid amount. Please enter a value between 0.01 and 999999.99',
            ]);
        }

        try {
            // Generate unique purchase order ID
            $purchaseOrderId = $this->khaltiService->generatePurchaseOrderId($user->id, 'wallet_topup');
            
            // Prepare Khalti payment
            $paymentData = [
                'return_url' => route('wallet.callback'),
                'purchase_order_id' => $purchaseOrderId,
                'purchase_order_name' => 'Wallet Top-up - ' . $user->name,
                'amount' => $amount,
                'customer_info' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone_number ?? '',
                ],
            ];

            $response = $this->khaltiService->initiatePayment($paymentData);

            if ($response['success']) {
                // Store the payment initiation in session for verification
                session([
                    'khalti_pidx' => $response['pidx'],
                    'khalti_purchase_order_id' => $purchaseOrderId,
                    'khalti_amount' => $amount,
                    'khalti_type' => 'wallet_topup',
                    'khalti_user_id' => $user->id,
                ]);

                Log::info('Khalti payment initiated', [
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'pidx' => $response['pidx'],
                ]);

                // Redirect to Khalti payment page
                return redirect($response['payment_url']);
            } else {
                // Handle failed response
                $errorMsg = $response['error'] ?? 'Failed to initiate payment. Please try again.';
                
                Log::error('Failed to initiate Khalti payment', [
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'error' => $errorMsg,
                ]);

                return redirect()->route('wallet.show')->withErrors([
                    'payment' => $errorMsg,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Error initiating Khalti payment', [
                'message' => $e->getMessage(),
                'user_id' => $user->id,
            ]);

            return redirect()->route('wallet.show')->withErrors([
                'payment' => 'An error occurred while processing your payment: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle Khalti payment callback
     */
    public function callback(Request $request): RedirectResponse
    {
        try {
            $pidx = $request->query('pidx');
            $status = $request->query('status');

            if (!$pidx) {
                Log::warning('Khalti callback without pidx');
                return redirect()->route('wallet.show')->withErrors([
                    'payment' => 'Invalid payment reference.',
                ]);
            }

            // Check session data
            $sessionPidx = session('khalti_pidx');
            $userId = session('khalti_user_id');
            $amount = session('khalti_amount');
            $type = session('khalti_type');

            if (!$sessionPidx || $pidx !== $sessionPidx) {
                Log::warning('Khalti callback pidx mismatch', [
                    'session_pidx' => $sessionPidx,
                    'callback_pidx' => $pidx,
                ]);
                return redirect()->route('wallet.show')->withErrors([
                    'payment' => 'Payment reference mismatch.',
                ]);
            }

            // Verify payment with Khalti
            $verificationResponse = $this->khaltiService->verifyPayment($pidx);

            if ($verificationResponse['success'] && $verificationResponse['status'] === 'Completed') {
                // Get or create user
                $user = User::find($userId);

                if (!$user) {
                    Log::error('User not found for payment', ['user_id' => $userId]);
                    return redirect()->route('wallet.show')->withErrors([
                        'payment' => 'User not found.',
                    ]);
                }

                // Process the payment
                return $this->processPaymentSuccess($user, $amount, $pidx, $type);
            } else {
                Log::warning('Khalti payment verification failed', [
                    'pidx' => $pidx,
                    'status' => $verificationResponse['status'] ?? 'unknown',
                ]);

                session()->forget(['khalti_pidx', 'khalti_purchase_order_id', 'khalti_amount', 'khalti_type', 'khalti_user_id']);

                return redirect()->route('wallet.show')->withErrors([
                    'payment' => 'Payment was not successful. Status: ' . ($verificationResponse['status'] ?? 'Unknown'),
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Error processing Khalti callback', [
                'message' => $e->getMessage(),
                'pidx' => $request->query('pidx'),
            ]);

            session()->forget(['khalti_pidx', 'khalti_purchase_order_id', 'khalti_amount', 'khalti_type', 'khalti_user_id']);

            return redirect()->route('wallet.show')->withErrors([
                'payment' => 'An error occurred while verifying your payment.',
            ]);
        }
    }

    /**
     * Process successful payment
     */
    private function processPaymentSuccess(User $user, float $amount, string $referenceId, string $type = 'wallet_topup'): RedirectResponse
    {
        try {
            DB::transaction(function () use ($user, $amount, $referenceId, $type) {
                // Add coins to user wallet
                $user->increment('coins', $amount);

                // Record transaction
                CoinTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'credit',
                    'amount' => $amount,
                    'reason' => 'topup',
                    'reference_id' => $referenceId,
                    'status' => 'success',
                ]);

                // Create notification
                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'Top-up Successful',
                    'message' => 'You successfully added ' . number_format($amount, 0) . ' coins to your wallet via Khalti.',
                ]);
            });

            Log::info('Payment processed successfully', [
                'user_id' => $user->id,
                'amount' => $amount,
                'reference_id' => $referenceId,
                'type' => $type,
            ]);

            // Clear session data
            session()->forget(['khalti_pidx', 'khalti_purchase_order_id', 'khalti_amount', 'khalti_type', 'khalti_user_id']);

            return redirect()->route('wallet.show')->with('success', 'Top-up successful! ' . number_format($amount, 0) . ' coins added to your wallet.');
        } catch (\Throwable $e) {
            Log::error('Payment processing failed', [
                'message' => $e->getMessage(),
                'user_id' => $user->id,
            ]);

            session()->forget(['khalti_pidx', 'khalti_purchase_order_id', 'khalti_amount', 'khalti_type', 'khalti_user_id']);

            return redirect()->route('wallet.show')->withErrors([
                'payment' => 'Failed to process payment. Please contact support.',
            ]);
        }
    }

    /**
     * Store redeem request
     */
    public function storeRedeem(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'coins_amount' => 'required|integer|min:1|max:' . (int)$user->coins,
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ]);

        try {
            // Use transaction to ensure atomicity
            DB::transaction(function () use ($user, $validated, $request) {
                // Store the proof image
                $imagePath = $request->file('proof_image')->store('redeem-proofs', 'public');

                // Create redeem request
                $redeemRequest = RedeemRequest::create([
                    'user_id' => $user->id,
                    'coins_amount' => $validated['coins_amount'],
                    'proof_image' => $imagePath,
                    'status' => 'pending',
                ]);

                // Deduct coins immediately from user balance
                $user->decrement('coins', $validated['coins_amount']);

                // Create transaction record for the deduction
                CoinTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'debit',
                    'amount' => $validated['coins_amount'],
                    'reason' => 'Coin Redemption - Request #' . $redeemRequest->id . ' (Pending)',
                    'reference_id' => 'REDEEM_' . $redeemRequest->id,
                    'status' => 'pending',
                ]);
            });

            return redirect()->route('wallet.show')->with('success', "Your redeem request has been submitted! {$validated['coins_amount']} coins have been deducted from your balance. Admins will review it shortly.");
        } catch (\Throwable $e) {
            Log::error('Error creating redeem request', [
                'message' => $e->getMessage(),
                'user_id' => $user->id,
            ]);

            return redirect()->route('wallet.show')->withErrors([
                'redeem' => 'Failed to submit redeem request. Please try again.',
            ]);
        }
    }

    /**
     * Get user's redeem requests
     */
    public function redeemHistory(): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $redeemRequests = RedeemRequest::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('wallet.redeem-history', [
            'redeemRequests' => $redeemRequests,
        ]);
    }
}

