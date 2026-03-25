<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LevelUpNotification extends Notification
{
    use Queueable;

    protected $newLevel;
    protected $rewards;

    public function __construct($newLevel, $rewards = [])
    {
        $this->newLevel = $newLevel;
        $this->rewards = $rewards;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'level_up',
            'level' => $this->newLevel->level_number,
            'level_name' => $this->newLevel->name,
            'liga' => $this->newLevel->liga,
            'rewards' => $this->rewards,
            'icon' => 'fa-arrow-up',
            'color' => 'success',
            'message' => __('admin.notifications.level.up', ['level' => $this->newLevel->level_number, 'name' => $this->newLevel->name]),
        ];
    }
}
