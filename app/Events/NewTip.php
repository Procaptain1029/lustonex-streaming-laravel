<?php

namespace App\Events;

use App\Models\Tip;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTip implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tip;

    public function __construct(Tip $tip)
    {
        $this->tip = $tip;
    }

    public function broadcastOn()
    {
        return new Channel('stream.' . $this->tip->stream_id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->tip->id,
            'fan' => [
                'id' => $this->tip->fan->id,
                'name' => $this->tip->fan->name,
            ],
            'amount' => $this->tip->amount,
            'message' => $this->tip->message,
            'created_at' => $this->tip->created_at->toISOString(),
        ];
    }
}
