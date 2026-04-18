<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RedeemRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class RedeemController extends Controller
{
    /**
     * Display all redeem requests
     */
    public function index(): View
    {
        $redeemRequests = RedeemRequest::with('user', 'reviewedBy')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'pending' => RedeemRequest::where('status', 'pending')->count(),
            'approved' => RedeemRequest::where('status', 'approved')->count(),
            'rejected' => RedeemRequest::where('status', 'rejected')->count(),
            'total' => RedeemRequest::count(),
            'total_coins' => RedeemRequest::where('status', 'pending')->sum('coins_amount'),
        ];

        return view('admin.redeem.index', compact('redeemRequests', 'stats'));
    }

    /**
     * Show redeem request details
     */
    public function show(RedeemRequest $redeem): View
    {
        $redeem->load('user', 'reviewedBy');
        return view('admin.redeem.show', ['redeemRequest' => $redeem]);
    }

    /**
     * Approve redeem request
     */
    public function approve(RedeemRequest $redeem): RedirectResponse
    {
        if ($redeem->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been reviewed.');
        }

        // Mark as approved (coins were already deducted on submission)
        $redeem->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Update the pending transaction to success status
        \App\Models\CoinTransaction::where('reference_id', 'REDEEM_' . $redeem->id)
            ->where('status', 'pending')
            ->update(['status' => 'success']);

        return redirect()->route('admin.redeem.index')->with('success', "Redeem request approved. {$redeem->coins_amount} coins confirmed for redemption.");
    }

    /**
     * Reject redeem request
     */
    public function reject(Request $request, RedeemRequest $redeem): RedirectResponse
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        if ($redeem->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been reviewed.');
        }

        $user = $redeem->user;

        // Refund the coins (they were deducted on submission)
        $user->increment('coins', $redeem->coins_amount);

        // Update the pending transaction to cancelled
        $transaction = \App\Models\CoinTransaction::where('reference_id', 'REDEEM_' . $redeem->id)
            ->where('status', 'pending')
            ->first();
        
        if ($transaction) {
            $transaction->update(['status' => 'cancelled']);
        }

        $redeem->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.redeem.index')->with('success', "Redeem request rejected. {$redeem->coins_amount} coins refunded to user.");
    }

    /**
     * Delete redeem request
     */
    public function destroy(RedeemRequest $redeem): RedirectResponse
    {
        // Delete the proof image
        if ($redeem->proof_image) {
            Storage::disk('public')->delete($redeem->proof_image);
        }

        $redeem->delete();

        return redirect()->route('admin.redeem.index')->with('success', 'Redeem request deleted.');
    }
}
