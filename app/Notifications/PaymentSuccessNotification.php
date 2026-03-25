<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Payment;

class PaymentSuccessNotification extends Notification
{
    use Queueable;

    protected $payment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
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
            'title' => __('admin.notifications.payment.success_title'),
            'message' => __('admin.notifications.payment.success_msg', ['tokens' => number_format($this->payment->tokens_purchased)]),
            'icon' => 'fa-check-circle',
            'color' => 'success',
            'action_url' => route('fan.tokens.index'),
            'action_text' => __('admin.notifications.payment.success_btn'),
            'image' => null,
            'metadata' => [
                'payment_id' => $this->payment->id,
                'transaction_id' => $this->payment->transaction_id,
                'amount' => $this->payment->amount,
                'tokens' => $this->payment->tokens_purchased,
                'payment_method' => $this->payment->payment_method,
                'type' => 'payment_success',
            ],
        ];
    }
}
