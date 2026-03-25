<?php

namespace App\Services;

use App\Models\User;
use App\Models\Stream;
use App\Models\Tip;
use App\Models\Subscription;
use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RankingService
{
    /**
     * Calculate RankScore for a given period.
     * 
     * Formula:
     * RankScore = (TokensE / (BroadcastMinutes + 1)) * (1 + Wc * Subs + Ws * ContentSales + Wl * Likes) * Boost
     */
    public function calculateScore(User $model, string $period = 'WEEKLY')
    {
        $startDate = $this->getStartDate($period);
        $endDate = now();

        // 1. Tokens Earned (Tips + Subscriptions)
        $tipsAmount = Tip::where('model_id', $model->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('amount');

        $subsAmount = Subscription::where('model_id', $model->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'active')
            ->sum('amount');

        $tokensE = $tipsAmount + $subsAmount;

        // 2. Broadcast Minutes
        $streams = Stream::where('user_id', $model->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('started_at')
            ->whereNotNull('ended_at')
            ->get();

        $broadcastMinutes = $streams->reduce(function ($carry, $stream) {
            return $carry + $stream->started_at->diffInMinutes($stream->ended_at);
        }, 0) ?? 0;

        // 3. New Subscriptions count (Engagement Factor)
        $newSubsCount = Subscription::where('model_id', $model->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'active')
            ->count();

        // 4. Likes (Engagement Factor)
        $likesCount = Like::whereHasMorph('likeable', ['App\Models\Photo', 'App\Models\Video'], function($query) use ($model) {
                $query->where('user_id', $model->id);
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Define Weights (Adjustable)
        $Wc = 0.5; // Weight for Subscriptions
        $Wl = 0.1; // Weight for Likes
        
        // Base Efficiency: Tokens per minute
        $efficiency = $tokensE / ($broadcastMinutes + 1);

        // Engagement Multiplier
        $engagementMultiplier = 1 + ($newSubsCount * $Wc) + ($likesCount * $Wl);

        // Boost for New Models (Registered in last 14 days)
        $boost = $model->isNew() ? 1.10 : 1.0;

        $finalScore = $efficiency * $engagementMultiplier * $boost;

        return round($finalScore, 4);
    }

    protected function getStartDate(string $period)
    {
        return match (strtoupper($period)) {
            'DAILY' => now()->startOfDay(),
            'WEEKLY' => now()->subDays(7),
            'MONTHLY' => now()->subDays(30),
            'YEARLY' => now()->subDays(365),
            default => now()->subDays(7),
        };
    }
}
