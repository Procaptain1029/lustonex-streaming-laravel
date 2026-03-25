<?php

namespace App\Events;

use App\Models\Stream;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StreamStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $stream;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    public function broadcastOn()
    {
        return new Channel('streams');
    }

    public function broadcastWith()
    {
        return [
            'stream_id' => $this->stream->id,
            'model_id' => $this->stream->user_id,
            'model_name' => $this->stream->user->name,
            'title' => $this->stream->title,
        ];
    }
}
