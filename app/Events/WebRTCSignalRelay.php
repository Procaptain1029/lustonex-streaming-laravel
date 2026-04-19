<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebRTCSignalRelay implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $streamId,
        public int $senderUserId,
        public string $senderPeerId,
        public string $signalEvent,
        public array $payload = []
    ) {}

    public function broadcastOn(): array
    {
        // Public channel: WebRTC signaling must work for guests and any authenticated role
        // without /broadcasting/auth (presence/private channels reject guests and some roles).
        return [new Channel("webrtc-stream.{$this->streamId}")];
    }

    public function broadcastAs(): string
    {
        return 'webrtc.signal';
    }

    public function broadcastWith(): array
    {
        return array_merge(
            [
                'streamId' => $this->streamId,
                'senderUserId' => $this->senderUserId,
                'senderPeerId' => $this->senderPeerId,
                'signalEvent' => $this->signalEvent,
            ],
            $this->payload
        );
    }
}

