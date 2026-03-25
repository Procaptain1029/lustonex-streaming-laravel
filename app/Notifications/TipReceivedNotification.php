<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Tip;

class TipReceivedNotification extends Notification
{
    use Queueable;

    protected $tip;
    protected $fan;

    /**
     * Create a new notification instance.
     */
    public function __construct(Tip $tip, User $fan)
    {
        $this->tip = $tip;
        $this->fan = $fan;
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
        return [
            'title' => __('admin.notifications.tip.received_title'),
            'message' => __('admin.notifications.tip.received_msg', ['name' => $this->fan->name, 'amount' => $this->tip->amount]),
            'icon' => 'fa-coins',
            'icon_color' => 'warning',
            'action_url' => route('model.earnings.index'),
            'action_text' => __('admin.notifications.tip.received_btn'),
            'image' => $this->fan->profile->avatar_url ?? null,
            'metadata' => [
                'tip_id' => $this->tip->id,
                'fan_id' => $this->fan->id,
                'fan_name' => $this->fan->name,
                'amount' => $this->tip->amount,
                'message' => $this->tip->message,
                'type' => 'tip_received',
            ],
        ];
    }
}
