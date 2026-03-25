<?php

namespace App\Notifications\Gamification;

use App\Models\Achievement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AchievementUnlocked extends Notification
{
    use Queueable;

    public $achievement;

    public function __construct(Achievement $achievement)
    {
        $this->achievement = $achievement;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'achievement_unlocked',
            'title' => __('admin.notifications.gamification.achievement_title'),
            'message' => __('admin.notifications.gamification.achievement_msg', ['name' => $this->achievement->name]),
            'icon' => $this->achievement->icon ?? 'fa-trophy',
            'link' => route('fan.achievements.index'), // Assuming route exists
            'color' => 'warning',
        ];
    }
    
    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}
