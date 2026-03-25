<?php

namespace App\Services;

use App\Models\User;
use App\Models\Tip;
use App\Models\Stream;
use App\Models\Payment;
use App\Models\Withdrawal;
use App\Notifications\NewFollowerNotification;
use App\Notifications\TipReceivedNotification;
use App\Notifications\ModelLiveNotification;
use App\Notifications\PaymentSuccessNotification;

class NotificationService
{
    /**
     * Notify model about new follower
     */
    public function notifyNewFollower(User $model, User $fan)
    {
        $model->notify(new NewFollowerNotification($fan));
    }

    /**
     * Notify model about tip received
     */
    public function notifyTipReceived(User $model, Tip $tip, User $fan)
    {
        $model->notify(new TipReceivedNotification($tip, $fan));
    }

    /**
     * Notify followers that model is live
     */
    public function notifyModelLive(User $model, Stream $stream)
    {
        // Get all followers of the model
        $followers = $model->followers; // Assuming followers relationship exists
        
        foreach ($followers as $follower) {
            $follower->notify(new ModelLiveNotification($model, $stream));
        }
    }

    /**
     * Notify user about successful payment
     */
    public function notifyPaymentSuccess(User $user, Payment $payment)
    {
        $user->notify(new PaymentSuccessNotification($payment));
    }

    /**
     * Notify user about new subscriber
     */
    public function notifyNewSubscriber(User $model, User $fan)
    {
        $model->notify(new \App\Notifications\NewSubscriberNotification($fan));
    }

    /**
     * Notify user about withdrawal processed (approved or rejected)
     */
    public function notifyWithdrawalProcessed(User $user, Withdrawal $withdrawal, bool $approved = true)
    {
        $user->notify(new \App\Notifications\WithdrawalProcessedNotification($withdrawal, $approved));
    }

    /**
     * Send welcome notification to new user
     */
    public function sendWelcomeNotification(User $user)
    {
        // Can create WelcomeNotification class later
    }

    /**
     * Send system announcement to all users or specific role
     */
    public function sendSystemAnnouncement(string $title, string $message, $users = null)
    {
        // Can create SystemAnnouncementNotification class later
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(User $user, string $notificationId)
    {
        $notification = $user->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->markAsRead();
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(User $user)
    {
        $user->unreadNotifications->markAsRead();
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount(User $user): int
    {
        return $user->unreadNotifications()->count();
    }

    /**
     * Delete notification
     */
    public function deleteNotification(User $user, string $notificationId)
    {
        $notification = $user->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->delete();
        }
    }

    /**
     * Delete all notifications
     */
    public function deleteAllNotifications(User $user)
    {
        $user->notifications()->delete();
    }
}
