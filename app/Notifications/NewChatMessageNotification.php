<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Message;

class NewChatMessageNotification extends Notification
{
    use Queueable;

    protected $chatMessage;
    protected $sender;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $chatMessage, User $sender)
    {
        $this->chatMessage = $chatMessage;
        $this->sender = $sender;
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
            'title' => __('admin.notifications.chat.new_message.title'),
            'message' => $this->sender->name . ': ' . substr($this->chatMessage->message, 0, 50) . (strlen($this->chatMessage->message) > 50 ? '...' : ''),
            'icon' => 'fa-comment-dots',
            'icon_color' => 'primary',
            'action_url' => $this->getActionUrl(),
            'action_text' => __('admin.notifications.chat.new_message.btn'),
            'image' => $this->sender->profile->avatar_url ?? null,
            'metadata' => [
                'conversation_id' => $this->chatMessage->conversation_id,
                'message_id' => $this->chatMessage->id,
                'sender_id' => $this->sender->id,
                'type' => 'new_chat_message',
            ],
        ];
    }

    protected function getActionUrl()
    {
        try {
            return route('chat.show', $this->chatMessage->conversation_id);
        } catch (\Exception $e) {
            return '/chat/' . $this->chatMessage->conversation_id;
        }
    }
}
