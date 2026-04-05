<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseStoreRequest;
use App\Models\CoinTransaction;
use App\Models\Notification;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PurchaseController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $purchases = Purchase::where(function ($query) {
            $query->where('buyer_id', Auth::id())
                  ->orWhere('seller_id', Auth::id());
        })
        ->where('status', '!=', 'cancelled')
        ->with('buyer', 'seller', 'userSkill.skill')
        ->latest()
        ->paginate(10);

        return view('purchases.index', ['purchases' => $purchases]);
    }

    public function create()
    {
        //
    }

    public function store(PurchaseStoreRequest $request): RedirectResponse
    {
        $userSkill = $request->userSkill();
        $amount = $userSkill->price;
        $buyer = Auth::user();

        // Check if buyer has sufficient coins
        if ($buyer->coins < $amount) {
            return redirect()->back()->with('error', 'Insufficient coins. You need ' . number_format($amount, 2) . ' coins to request this listing. You currently have ' . number_format($buyer->coins, 2) . ' coins.');
        }

        // Deduct coins from buyer immediately
        $purchase = DB::transaction(function () use ($buyer, $amount, $userSkill, $request) {
            $buyer = User::lockForUpdate()->find($buyer->id);
            $buyer->decrement('coins', $amount);

            // Create coin transaction record
            CoinTransaction::create([
                'user_id' => $buyer->id,
                'type' => 'debit',
                'amount' => $amount,
                'reason' => 'Listing Request - ' . $userSkill->skill->name,
                'reference_id' => 'listing_request_' . $userSkill->id,
                'status' => 'pending',
            ]);

            // Create purchase with pending status
            return Purchase::create([
                'buyer_id' => $buyer->id,
                'seller_id' => $userSkill->user_id,
                'user_skill_id' => $userSkill->id,
                'amount' => $amount,
                'status' => 'pending',
                'note' => $request->note,
            ]);
        });

        // Notify seller
        $buyerName = $buyer->name;
        Notification::create([
            'user_id' => $userSkill->user_id,
            'purchase_id' => $purchase->id,
            'type' => 'purchase_request',
            'title' => 'New Purchase Request',
            'message' => $buyerName . ' requested your ' . $userSkill->skill->name . ' listing.',
        ]);

        return redirect()->route('purchases.show', $purchase)->with('success', 'Purchase request sent successfully. ' . number_format($amount, 2) . ' coins have been deducted from your balance.');
    }

    public function show(Purchase $purchase): View
    {
        $this->authorize('view', $purchase);
        return view('purchases.show', [
            'purchase' => $purchase->load('buyer', 'seller', 'userSkill.skill', 'messages.sender'),
        ]);
    }

    public function edit(Purchase $purchase)
    {
        //
    }

    public function update(Request $request, Purchase $purchase): RedirectResponse
    {
        $action = $request->input('action');
        
        // Handle cancel action - only buyer can cancel, and only if pending
        if ($action === 'cancel') {
            if (Auth::id() !== $purchase->buyer_id) {
                abort(403, 'Only the buyer can cancel this purchase');
            }

            if ($purchase->status === 'accepted') {
                return redirect()->back()->with('error', 'You cannot cancel this listing after it has been accepted by the seller.');
            }

            if ($purchase->status !== 'pending') {
                return redirect()->back()->with('error', 'You can only cancel pending purchases.');
            }

            // Refund coins to buyer
            DB::transaction(function () use ($purchase) {
                $buyer = \App\Models\User::lockForUpdate()->find($purchase->buyer_id);
                
                // Refund coins
                $buyer->increment('coins', $purchase->amount);

                // Record refund transaction
                CoinTransaction::create([
                    'user_id' => $buyer->id,
                    'type' => 'credit',
                    'amount' => $purchase->amount,
                    'reason' => 'Listing Request Cancelled - ' . $purchase->userSkill->skill->name,
                    'reference_id' => 'listing_cancel_' . $purchase->id,
                    'status' => 'success',
                ]);

                // Update purchase status
                $purchase->update(['status' => 'cancelled']);
            });

            // Notify seller about cancellation
            Notification::create([
                'user_id' => $purchase->seller_id,
                'purchase_id' => $purchase->id,
                'type' => 'purchase_cancelled',
                'title' => 'Purchase Request Cancelled',
                'message' => $purchase->buyer->name . ' cancelled their purchase request for ' . $purchase->userSkill->skill->name . '.',
            ]);

            return redirect()->route('purchases.show', $purchase)->with('success', 'Purchase cancelled. ' . number_format($purchase->amount, 2) . ' coins have been refunded to your account.');
        }

        if ($action === 'accept') {
            // Only seller can accept
            if (Auth::id() !== $purchase->seller_id) {
                abort(403, 'Only the seller can accept this purchase');
            }
            $purchase->update(['status' => 'accepted']);
            
            Notification::create([
                'user_id' => $purchase->buyer_id,
                'purchase_id' => $purchase->id,
                'type' => 'purchase_accepted',
                'title' => 'Purchase Accepted',
                'message' => $purchase->seller->name . ' accepted your request for ' . $purchase->userSkill->skill->name . '.',
            ]);

            return redirect()->route('purchases.show', $purchase)->with('success', 'Purchase accepted.');
        } 
        elseif ($action === 'complete') {
            // Only seller can mark work as complete
            if (Auth::id() !== $purchase->seller_id) {
                abort(403, 'Only the seller can mark work as complete');
            }
            
            if ($purchase->status !== 'accepted') {
                return redirect()->back()->with('error', 'Purchase must be accepted before marking as complete.');
            }

            // Mark work as submitted - waiting for buyer verification
            $purchase->update(['status' => 'work_submitted']);

            // Notify buyer that work is ready for verification
            Notification::create([
                'user_id' => $purchase->buyer_id,
                'purchase_id' => $purchase->id,
                'type' => 'work_submitted',
                'title' => 'Work Submitted for Verification',
                'message' => $purchase->seller->name . ' has submitted the work for ' . $purchase->userSkill->skill->name . '. Please review and verify the work done.',
            ]);

            return redirect()->route('purchases.show', $purchase)->with('success', 'Work submitted for verification. Waiting for buyer to verify.');
        }
        elseif ($action === 'verify') {
            if ($purchase->status !== 'work_submitted') {
                return redirect()->back()->with('error', 'No work submitted for verification yet.');
            }

            // Only buyer can verify
            if (Auth::id() !== $purchase->buyer_id) {
                abort(403, 'Only the buyer can verify completed work');
            }

            // Credit coins to seller (coins were already deducted from buyer when request was made)
            DB::transaction(function () use ($purchase) {
                $seller = User::lockForUpdate()->find($purchase->seller_id);

                // Add coins to seller
                $seller->increment('coins', $purchase->amount);

                // Record seller transaction
                CoinTransaction::create([
                    'user_id' => $seller->id,
                    'type' => 'credit',
                    'amount' => $purchase->amount,
                    'reason' => 'Work Completed - ' . $purchase->userSkill->skill->name,
                    'reference_id' => 'work_complete_' . $purchase->id,
                    'status' => 'success',
                ]);

                // Mark the debit transaction as success
                CoinTransaction::where('reference_id', 'like', 'listing_request_%')
                    ->where('user_id', $purchase->buyer_id)
                    ->where('status', 'pending')
                    ->first()?->update(['status' => 'success']);

                // Update purchase
                $purchase->update(['status' => 'completed']);

                // Notify both users
                Notification::create([
                    'user_id' => $purchase->buyer_id,
                    'purchase_id' => $purchase->id,
                    'type' => 'work_completed',
                    'title' => 'Work Verified & Completed',
                    'message' => 'You verified the work for ' . $purchase->userSkill->skill->name . '. You can now leave a review.',
                ]);

                Notification::create([
                    'user_id' => $seller->id,
                    'purchase_id' => $purchase->id,
                    'type' => 'work_completed',
                    'title' => 'Work Verified & Coins Transferred',
                    'message' => $purchase->buyer->name . ' verified your work. You earned ' . number_format($purchase->amount, 2) . ' coins for ' . $purchase->userSkill->skill->name . '.',
                ]);
            });

            return redirect()->route('reviews.create', $purchase)->with('success', 'Work verified successfully! Please leave a rating and review for this work.');
        }

        return redirect()->back();
    }

    public function destroy(Purchase $purchase): RedirectResponse
    {
        $this->authorize('delete', $purchase);
        
        $purchase->delete();
        
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully.');
    }
}
