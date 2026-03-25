<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewSubscriberNotification extends Notification
{
    use Queueable;

    protected $subscriber;
    protected $model;
    protected $type; // 'model' or 'fan'

    /**
     * Create a new notification instance.
     */
    public function __construct(User $subscriber, User $model, $type = 'model')
    {
        $this->subscriber = $subscriber;
        $this->model = $model;
        $this->type = $type;
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
        if ($this->type === 'fan') {
            return [
                'title' => __('admin.notifications.subscriber.fan_title'),
                'message' => __('admin.notifications.subscriber.fan_msg', ['name' => $this->model->name]),
                'icon' => 'fa-check-circle',
                'icon_color' => 'success',
                'action_url' => route('profiles.show', $this->model->id),
                'action_text' => __('admin.notifications.subscriber.fan_btn'),
                'image' => $this->model->profile->avatar_url ?? null,
                'metadata' => [
                    'model_id' => $this->model->id,
                    'model_name' => $this->model->name,
                    'type' => 'subscription_success_fan',
                ],
            ];
        }

        return [
            'title' => __('admin.notifications.subscriber.model_title'),
            'message' => __('admin.notifications.subscriber.model_msg', ['name' => $this->subscriber->name]),
            'icon' => 'fa-star',
            'icon_color' => 'warning',
            'action_url' => route('model.earnings.index'),
            'action_text' => __('admin.notifications.subscriber.model_btn'),
            'image' => $this->subscriber->profile->avatar_url ?? null,
            'metadata' => [
                'subscriber_id' => $this->subscriber->id,
                'subscriber_name' => $this->subscriber->name,
                'type' => 'new_subscriber_model',
            ],
        ];
    }
}
