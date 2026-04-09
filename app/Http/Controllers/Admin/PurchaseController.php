<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['buyer', 'userSkill.skill'])->latest()->paginate(10);
        return view('admin.purchases.index', compact('purchases'));
    }

    /**
     * Show the form for editing purchase status
     */
    public function edit(Purchase $purchase)
    {
        $purchase->load(['buyer', 'seller', 'userSkill.skill']);
        $statuses = ['pending', 'accepted', 'completed', 'cancelled'];
        return view('admin.purchases.edit', compact('purchase', 'statuses'));
    }

    /**
     * Update purchase status
     */
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,completed,cancelled',
        ]);

        $purchase->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.purchases.index')->with('success', 'Purchase status updated successfully.');
    }
}
