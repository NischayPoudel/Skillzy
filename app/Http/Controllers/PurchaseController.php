<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseStoreRequest;
use App\Models\CoinTransaction;
use App\Models\Notification;
use App\Models\Purchase;
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

        $purchase = Purchase::create([
            'buyer_id' => Auth::id(),
            'seller_id' => $userSkill->user_id,
            'user_skill_id' => $userSkill->id,
            'amount' => $userSkill->price,
            'status' => 'pending',
            'note' => $request->note,
        ]);

        // Notify seller
        $buyerName = Auth::user() ? Auth::user()->name : 'A user';
        Notification::create([
            'user_id' => $userSkill->user_id,
            'title' => 'New Purchase Request',
            'message' => $buyerName . ' requested your ' . $userSkill->skill->name . ' listing.',
        ]);

        return redirect()->route('purchases.show', $purchase)->with('success', 'Purchase request sent successfully.');
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
        
        // Allow buyers to cancel pending purchases
        if ($action === 'cancel' && $purchase->status === 'pending') {
            if (Auth::id() !== $purchase->buyer_id) {
                abort(403, 'You cannot cancel this purchase');
            }
        } else {
            // For other actions, only seller can perform them
            $this->authorize('update', $purchase);
        }
        
        if ($action === 'accept') {
            $purchase->update(['status' => 'accepted']);
            
            Notification::create([
                'user_id' => $purchase->buyer_id,
                'title' => 'Purchase Accepted',
                'message' => $purchase->seller->name . ' accepted your request for ' . $purchase->userSkill->skill->name . '.',
            ]);

            return redirect()->route('purchases.show', $purchase)->with('success', 'Purchase accepted.');
        } 
        elseif ($action === 'complete') {
            // Use transaction for safe coin transfer
            DB::transaction(function () use ($purchase) {
                // Lock both users for updates
                $buyer = \App\Models\User::lockForUpdate()->find($purchase->buyer_id);
                $seller = \App\Models\User::lockForUpdate()->find($purchase->seller_id);

                // Check buyer has enough coins
                if ($buyer->coins < $purchase->amount) {
                    throw new \Exception('Insufficient coins');
                }

                // Deduct from buyer
                $buyer->update(['coins' => $buyer->coins - $purchase->amount]);

                // Add to seller
                $seller->update(['coins' => $seller->coins + $purchase->amount]);

                // Record transactions
                CoinTransaction::create([
                    'user_id' => $buyer->id,
                    'type' => 'debit',
                    'amount' => $purchase->amount,
                    'reason' => 'purchase',
                    'reference_id' => $purchase->id,
                    'status' => 'success',
                ]);

                CoinTransaction::create([
                    'user_id' => $seller->id,
                    'type' => 'credit',
                    'amount' => $purchase->amount,
                    'reason' => 'purchase',
                    'reference_id' => $purchase->id,
                    'status' => 'success',
                ]);

                // Update purchase
                $purchase->update(['status' => 'completed']);

                // Notify both users
                Notification::create([
                    'user_id' => $buyer->id,
                    'title' => 'Purchase Completed',
                    'message' => 'Your purchase for ' . $purchase->userSkill->skill->name . ' is complete. You can now leave a review.',
                ]);

                Notification::create([
                    'user_id' => $seller->id,
                    'title' => 'Purchase Completed',
                    'message' => 'You earned ' . number_format($purchase->amount, 2) . ' coins from ' . $buyer->name . '.',
                ]);
            });

            return redirect()->route('purchases.show', $purchase)->with('success', 'Purchase completed and coins transferred.');
        }
        elseif ($action === 'cancel') {
            $purchase->update(['status' => 'cancelled']);

            Notification::create([
                'user_id' => $purchase->buyer_id,
                'title' => 'Purchase Cancelled',
                'message' => 'Your purchase request was cancelled.',
            ]);

            // Also notify seller
            Notification::create([
                'user_id' => $purchase->seller_id,
                'title' => 'Purchase Request Cancelled',
                'message' => $purchase->buyer->name . ' cancelled their purchase request for ' . $purchase->userSkill->skill->name . '.',
            ]);

            return redirect()->route('purchases.show', $purchase)->with('success', 'Purchase cancelled.');
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
