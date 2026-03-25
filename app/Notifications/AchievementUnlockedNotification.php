<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AchievementUnlockedNotification extends Notification
{
    use Queueable;

    protected $achievement;

    public function __construct($achievement)
    {
        $this->achievement = $achievement;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'achievement_unlocked',
            'achievement_id' => $this->achievement['id'],
            'achievement_name' => $this->achievement['name'],
            'rarity' => $this->achievement['rarity'],
            'icon' => 'fa-trophy',
            'color' => 'warning',
            'message' => __('admin.notifications.achievement.unlocked', ['name' => $this->achievement['name']]),
        ];
    }
}
