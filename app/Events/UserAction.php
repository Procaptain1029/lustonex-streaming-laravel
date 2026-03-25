<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserAction
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $actionType;
    public $value;
    public $metadata;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param string $actionType (e.g., 'stream.watch', 'comment.create')
     * @param int $value (optional value, e.g., amount, duration)
     * @param array $metadata (optional extra data)
     */
    public function __construct(User $user, string $actionType, int $value = 1, array $metadata = [])
    {
        $this->user = $user;
        $this->actionType = $actionType;
        $this->value = $value;
        $this->metadata = $metadata;
    }
}
