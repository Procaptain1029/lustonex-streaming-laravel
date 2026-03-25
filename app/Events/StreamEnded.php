<?php

namespace App\Events;

use App\Models\Stream;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StreamEnded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $stream;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    public function broadcastOn()
    {
        return [
            new Channel('streams'),
            new Channel('stream.' . $this->stream->id),
        ];
    }

    public function broadcastWith()
    {
        return [
            'stream_id' => $this->stream->id,
            'model_id' => $this->stream->user_id,
        ];
    }
}
