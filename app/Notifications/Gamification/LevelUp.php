<?php

namespace App\Notifications\Gamification;

use App\Models\Level;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class LevelUp extends Notification
{
    use Queueable;

    public $level;

    public function __construct(Level $level)
    {
        $this->level = $level;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'level_up',
            'title' => __('admin.notifications.gamification.level_title'),
            'message' => __('admin.notifications.gamification.level_msg', ['level' => $this->level->level_number, 'name' => $this->level->name]),
            'icon' => 'fa-arrow-up',
            'link' => '#', // Profile link or levels page
            'color' => 'success',
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}
