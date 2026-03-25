<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewFollowerNotification extends Notification
{
    use Queueable;

    protected $follower;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $follower)
    {
        $this->follower = $follower;
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
            'title' => __('admin.notifications.follower.title'),
            'message' => __('admin.notifications.follower.msg', ['name' => $this->follower->name]),
            'icon' => 'fa-user-plus',
            'icon_color' => 'primary',
            'action_url' => route('profiles.show', $this->follower->id),
            'action_text' => __('admin.notifications.follower.btn'),
            'image' => $this->follower->profile->avatar_url ?? null,
            'metadata' => [
                'follower_id' => $this->follower->id,
                'follower_name' => $this->follower->name,
                'type' => 'new_follower',
            ],
        ];
    }
}
