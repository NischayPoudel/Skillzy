<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;

class NotificationService
{
    /**
     * Create a notification for a user
     */
    public function notify(User $user, string $title, string $message): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
        ]);
    }

    /**
     * Notify purchase accepted
     */
    public function notifyPurchaseAccepted($purchase): void
    {
        $this->notify(
            $purchase->buyer,
            'Purchase Accepted',
            'Your purchase for ' . $purchase->userSkill->skill->name . ' has been accepted by the seller.'
        );
    }

    /**
     * Notify purchase rejected
     */
    public function notifyPurchaseRejected($purchase): void
    {
        $this->notify(
            $purchase->buyer,
            'Purchase Rejected',
            'Your purchase for ' . $purchase->userSkill->skill->name . ' has been rejected by the seller.'
        );
    }

    /**
     * Notify purchase completed
     */
    public function notifyPurchaseCompleted($purchase): void
    {
        $this->notify(
            $purchase->buyer,
            'Purchase Completed',
            'Your purchase for ' . $purchase->userSkill->skill->name . ' has been completed. You received ' . $purchase->amount . ' coins.'
        );
    }

    /**
     * Notify new message
     */
    public function notifyNewMessage($message): void
    {
        $this->notify(
            $message->receiver,
            'New Message',
            'You have a new message from ' . $message->sender->name
        );
    }

    /**
     * Notify new review
     */
    public function notifyNewReview($review): void
    {
        $this->notify(
            $review->seller,
            'New Review',
            $review->buyer->name . ' left a ' . $review->rating . '-star review: ' . substr($review->comment ?? '', 0, 50)
        );
    }
}
