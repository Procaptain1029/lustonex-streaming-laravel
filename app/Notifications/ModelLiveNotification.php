<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Stream;

class ModelLiveNotification extends Notification
{
    use Queueable;

    protected $model;
    protected $stream;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $model, Stream $stream)
    {
        $this->model = $model;
        $this->stream = $stream;
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
            'title' => __('admin.notifications.model.live_title'),
            'message' => __('admin.notifications.model.live_msg', ['name' => $this->model->name, 'title' => $this->stream->title]),
            'icon' => 'video',
            'icon_color' => 'danger',
            'action_url' => route('streams.view', $this->stream->id),
            'action_text' => __('admin.notifications.model.live_btn'),
            'image' => $this->stream->thumbnail_url ?? $this->model->profile->avatar_url,
            'metadata' => [
                'model_id' => $this->model->id,
                'model_name' => $this->model->name,
                'stream_id' => $this->stream->id,
                'stream_title' => $this->stream->title,
                'type' => 'model_live',
            ],
        ];
    }
}
