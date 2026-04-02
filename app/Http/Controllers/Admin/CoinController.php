<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CoinTransaction;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    /**
     * Display a listing of all users with their coins
     */
    public function index()
    {
        $users = User::where('role', 'user')->latest()->paginate(10);
        return view('admin.coins.index', compact('users'));
    }

    /**
     * Show the form for editing user coins
     */
    public function edit(User $user)
    {
        // Only allow editing user role
        if ($user->role !== 'user') {
            return redirect()->route('admin.coins.index')->with('error', 'Cannot manage coins for non-user accounts.');
        }
        
        $transactions = CoinTransaction::where('user_id', $user->id)->latest()->paginate(10);
        return view('admin.coins.edit', compact('user', 'transactions'));
    }

    /**
     * Update user coins (add or deduct)
     */
    public function update(Request $request, User $user)
    {
        // Only allow updating user role
        if ($user->role !== 'user') {
            return redirect()->route('admin.coins.index')->with('error', 'Cannot manage coins for non-user accounts.');
        }

        $request->validate([
            'action' => 'required|in:add,deduct',
            'amount' => 'required|numeric|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $amount = (float) $request->amount;
        
        // Deduct coins cannot exceed current coins
        if ($request->action === 'deduct' && $amount > $user->coins) {
            return redirect()->route('admin.coins.edit', $user)->with('error', 'User does not have enough coins to deduct.');
        }

        // Update user coins
        if ($request->action === 'add') {
            $user->coins += $amount;
            $type = 'credit';
        } else {
            $user->coins -= $amount;
            $type = 'debit';
        }

        $user->save();

        // Record transaction
        CoinTransaction::create([
            'user_id' => $user->id,
            'type' => $type,
            'amount' => $amount,
            'reason' => $request->reason,
            'reference_id' => null,
            'status' => 'completed',
        ]);

        return redirect()->route('admin.coins.edit', $user)->with('success', 'Coins updated successfully.');
    }

    /**
     * Display coin transactions for a user
     */
    public function transactions(User $user)
    {
        if ($user->role !== 'user') {
            return redirect()->route('admin.coins.index')->with('error', 'User not found.');
        }

        $transactions = CoinTransaction::where('user_id', $user->id)->latest()->paginate(10);
        return view('admin.coins.transactions', compact('user', 'transactions'));
    }
}
