<?php

namespace App\Services;

use App\Models\User;
use App\Models\CoinTransaction;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class CoinTransferService
{
    /**
     * Transfer coins from buyer to seller with database transaction
     */
    public function transfer(Purchase $purchase): bool
    {
        return DB::transaction(function () use ($purchase) {
            // Lock user records to prevent race conditions
            $buyer = User::lockForUpdate()->find($purchase->buyer_id);
            $seller = User::lockForUpdate()->find($purchase->seller_id);

            // Validate buyer has sufficient balance
            if ($buyer->coins < $purchase->amount) {
                return false;
            }

            // Debit buyer
            $buyer->decrement('coins', $purchase->amount);

            // Credit seller
            $seller->increment('coins', $purchase->amount);

            // Record buyer transaction
            CoinTransaction::create([
                'user_id' => $buyer->id,
                'type' => 'debit',
                'amount' => $purchase->amount,
                'reason' => 'Purchase - ' . $purchase->userSkill->skill->name,
                'reference_id' => 'purchase_' . $purchase->id,
                'status' => 'success',
            ]);

            // Record seller transaction
            CoinTransaction::create([
                'user_id' => $seller->id,
                'type' => 'credit',
                'amount' => $purchase->amount,
                'reason' => 'Sale - ' . $purchase->userSkill->skill->name,
                'reference_id' => 'purchase_' . $purchase->id,
                'status' => 'success',
            ]);

            return true;
        });
    }

    /**
     * Refund coins from seller to buyer
     */
    public function refund(Purchase $purchase): bool
    {
        return DB::transaction(function () use ($purchase) {
            $buyer = User::lockForUpdate()->find($purchase->buyer_id);
            $seller = User::lockForUpdate()->find($purchase->seller_id);

            // Validate seller has sufficient balance
            if ($seller->coins < $purchase->amount) {
                return false;
            }

            // Refund to buyer
            $buyer->increment('coins', $purchase->amount);

            // Debit from seller
            $seller->decrement('coins', $purchase->amount);

            // Record transactions
            CoinTransaction::create([
                'user_id' => $buyer->id,
                'type' => 'credit',
                'amount' => $purchase->amount,
                'reason' => 'Refund - ' . $purchase->userSkill->skill->name,
                'reference_id' => 'refund_' . $purchase->id,
                'status' => 'success',
            ]);

            CoinTransaction::create([
                'user_id' => $seller->id,
                'type' => 'debit',
                'amount' => $purchase->amount,
                'reason' => 'Refund - ' . $purchase->userSkill->skill->name,
                'reference_id' => 'refund_' . $purchase->id,
                'status' => 'success',
            ]);

            return true;
        });
    }

    /**
     * Add coins as topup (demo logic)
     */
    public function addTopup(User $user, float $amount): bool
    {
        return DB::transaction(function () use ($user, $amount) {
            $user->increment('coins', $amount);

            CoinTransaction::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $amount,
                'reason' => 'Wallet topup',
                'status' => 'success',
            ]);

            return true;
        });
    }

    /**
     * Withdraw coins (demo validation)
     */
    public function withdraw(User $user, float $amount): bool
    {
        return DB::transaction(function () use ($user, $amount) {
            if ($user->coins < $amount) {
                return false;
            }

            $user->decrement('coins', $amount);

            CoinTransaction::create([
                'user_id' => $user->id,
                'type' => 'debit',
                'amount' => $amount,
                'reason' => 'Wallet withdrawal',
                'status' => 'success',
            ]);

            return true;
        });
    }
}
