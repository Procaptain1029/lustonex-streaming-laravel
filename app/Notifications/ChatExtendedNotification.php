<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Conversation;

class ChatExtendedNotification extends Notification
{
    use Queueable;

    protected $conversation;
    protected $otherUser;
    protected $type; // 'fan' or 'model'

    /**
     * Create a new notification instance.
     */
    public function __construct(Conversation $conversation, User $otherUser, $type)
    {
        $this->conversation = $conversation;
        $this->otherUser = $otherUser;
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
        if ($this->type === 'model') {
            return [
                'title' => __('admin.notifications.chat.extended.model_title'),
                'message' => __('admin.notifications.chat.extended.model_msg', ['name' => $this->otherUser->name]),
                'icon' => 'fa-clock',
                'icon_color' => 'info',
                'action_url' => $this->getActionUrl(),
                'action_text' => __('admin.notifications.chat.extended.model_btn'),
                'image' => $this->otherUser->profile->avatar_url ?? null,
                'metadata' => [
                    'conversation_id' => $this->conversation->id,
                    'fan_id' => $this->otherUser->id,
                    'type' => 'chat_extended_model',
                ],
            ];
        }

        return [
            'title' => __('admin.notifications.chat.extended.fan_title'),
            'message' => __('admin.notifications.chat.extended.fan_msg', ['name' => $this->otherUser->name]),
            'icon' => 'fa-history',
            'icon_color' => 'success',
            'action_url' => $this->getActionUrl(),
            'action_text' => __('admin.notifications.chat.extended.fan_btn'),
            'image' => $this->otherUser->profile->avatar_url ?? null,
            'metadata' => [
                'conversation_id' => $this->conversation->id,
                'model_id' => $this->otherUser->id,
                'type' => 'chat_extended_fan',
            ],
        ];
    }

    protected function getActionUrl()
    {
        try {
            return route('chat.show', $this->conversation->id);
        } catch (\Exception $e) {
            return '/chat/' . $this->conversation->id;
        }
    }
}
