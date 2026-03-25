<?php

namespace App\Listeners;

use App\Events\StreamEnded;
use App\Services\GamificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateStreamMissionProgress
{
    protected $gamificationService;

    /**
     * Create the event listener.
     */
    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    /**
     * Handle the event.
     */
    public function handle(StreamEnded $event): void
    {
        $stream = $event->stream;
        $user = $stream->user;

        // Calculate stream duration in minutes
        if ($stream->started_at && $stream->ended_at) {
            $durationMinutes = $stream->ended_at->diffInMinutes($stream->started_at);

            Log::info("Stream ended for user {$user->id}. Duration: {$durationMinutes} minutes");

            // Update mission progress for stream hours (convert minutes to progress)
            // The mission tracks in minutes (goal_amount is in minutes, e.g., 600 for 10 hours)
            $this->gamificationService->processMissionProgress(
                $user,
                'stream_hours_weekly',
                $durationMinutes
            );

            // Also update for any other stream-related missions
            $this->gamificationService->processMissionProgress(
                $user,
                'start_stream',
                1
            );
        }
    }
}
