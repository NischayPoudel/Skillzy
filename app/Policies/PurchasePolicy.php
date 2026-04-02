<?php

namespace App\Policies;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PurchasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Purchase $purchase): bool
    {
        return $user->id === $purchase->buyer_id || $user->id === $purchase->seller_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Purchase $purchase): bool
    {
        return $user->id === $purchase->seller_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Purchase $purchase): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Purchase $purchase): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Purchase $purchase): bool
    {
        return false;
    }

    /**
     * Determine whether the user can accept the purchase.
     */
    public function accept(User $user, Purchase $purchase): bool
    {
        return $user->id === $purchase->seller_id && $purchase->status === 'pending';
    }

    /**
     * Determine whether the user can reject the purchase.
     */
    public function reject(User $user, Purchase $purchase): bool
    {
        return $user->id === $purchase->seller_id && $purchase->status === 'pending';
    }

    /**
     * Determine whether the user can complete the purchase.
     */
    public function complete(User $user, Purchase $purchase): bool
    {
        return $user->id === $purchase->seller_id && $purchase->status === 'accepted';
    }

    /**
     * Determine whether the user can review the purchase.
     */
    public function review(User $user, Purchase $purchase): bool
    {
        return $user->id === $purchase->buyer_id && $purchase->status === 'completed';
    }
}
