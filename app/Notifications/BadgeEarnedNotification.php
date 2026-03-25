<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BadgeEarnedNotification extends Notification
{
    use Queueable;

    protected $badge;

    public function __construct($badge)
    {
        $this->badge = $badge;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'badge_earned',
            'badge_id' => $this->badge->id,
            'badge_name' => $this->badge->name,
            'badge_type' => $this->badge->type,
            'icon' => $this->badge->icon,
            'color' => $this->badge->color,
            'message' => __('admin.notifications.badge.earned', ['name' => $this->badge->name]),
        ];
    }
}
