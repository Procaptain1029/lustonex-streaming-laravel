<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TokensPurchased
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $amount; // Amount paid
    public $tokens; // Tokens received

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, $amount, $tokens)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->tokens = $tokens;
    }
}
