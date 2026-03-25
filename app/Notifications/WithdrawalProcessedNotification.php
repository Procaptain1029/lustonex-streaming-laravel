<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Withdrawal;

class WithdrawalProcessedNotification extends Notification
{
    use Queueable;

    protected $withdrawal;
    protected $approved;

    /**
     * Create a new notification instance.
     */
    public function __construct(Withdrawal $withdrawal, bool $approved = true)
    {
        $this->withdrawal = $withdrawal;
        $this->approved = $approved;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        if ($this->approved) {
            return [
                'title' => __('admin.notifications.withdrawal.approved_title'),
                'message' => __('admin.notifications.withdrawal.approved_msg', ['amount' => number_format((float) $this->withdrawal->amount, 2)]),
                'icon' => 'check-circle',
                'icon_color' => 'success',
                'action_url' => route('model.withdrawals.index'),
                'action_text' => __('admin.notifications.withdrawal.approved_btn'),
                'image' => null,
                'metadata' => [
                    'withdrawal_id' => $this->withdrawal->id,
                    'amount' => $this->withdrawal->amount,
                    'status' => 'approved',
                    'type' => 'withdrawal_processed',
                ],
            ];
        } else {
            return [
                'title' => __('admin.notifications.withdrawal.rejected_title'),
                'message' => __('admin.notifications.withdrawal.rejected_msg', ['amount' => number_format((float) $this->withdrawal->amount, 2), 'reason' => $this->withdrawal->rejection_reason ?? __('admin.notifications.withdrawal.not_specified')]),
                'icon' => 'times-circle',
                'icon_color' => 'danger',
                'action_url' => route('model.withdrawals.index'),
                'action_text' => __('admin.notifications.withdrawal.rejected_btn'),
                'image' => null,
                'metadata' => [
                    'withdrawal_id' => $this->withdrawal->id,
                    'amount' => $this->withdrawal->amount,
                    'status' => 'rejected',
                    'reason' => $this->withdrawal->rejection_reason,
                    'type' => 'withdrawal_processed',
                ],
            ];
        }
    }
}
