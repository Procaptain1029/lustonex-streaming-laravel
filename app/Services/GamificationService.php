<?php

namespace App\Services;

use App\Models\User;
use App\Models\Level;
use App\Models\UserProgress;
use App\Models\UserMission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GamificationService
{
    /**
     * Award XP to a user and check for level up.
     *
     * @param User $user
     * @param int $amount
     * @return void
     */
    public function awardXp(User $user, int $amount)
    {
        try {
            DB::beginTransaction();

            // Ensure user progress record exists
            $progress = $user->progress ?? UserProgress::create(['user_id' => $user->id]);

            $progress->current_xp += $amount;
            $progress->save();

            $this->checkLevelUp($user, $progress);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error awarding XP: ' . $e->getMessage());
        }
    }

    /**
     * Check if user is eligible for a level up.
     *
     * @param User $user
     * @param UserProgress $progress
     * @return void
     */
    protected function checkLevelUp(User $user, UserProgress $progress)
    {
        $currentLevelNumber = $progress->currentLevel ? $progress->currentLevel->level_number : 0;
        $nextLevelNumber = $currentLevelNumber + 1;

        // Filtrar el siguiente nivel por rol del usuario
        $nextLevel = Level::where('level_number', $nextLevelNumber)
            ->where(function ($q) use ($user) {
                $q->where('role', $user->role)->orWhere('role', 'both');
            })
            ->first();

        Log::info("Checking Level Up for User {$user->id}. XP: {$progress->current_xp}, Level: {$currentLevelNumber}, Next Level: " . ($nextLevel ? $nextLevel->level_number : 'None'));

        if (!$nextLevel) {
            return; // Max level reached or next level not found
        }

        if ($progress->current_xp >= $nextLevel->xp_required) {
            $mandatoryMission = $user->missions()
                ->where('type', 'LEVEL_UP')
                ->where('level_id', $progress->current_level_id)
                ->wherePivot('completed', false)
                ->first();

            if ($mandatoryMission) {
                Log::info("Level Up Blocked: Mandatory Mission '{$mandatoryMission->name}' incomplete.");
                return;
            }

            Log::info("Level Up Approved! Promoting to Level {$nextLevel->level_number}");

            $progress->current_level_id = $nextLevel->id;
            $progress->save();

            // Award Level Rewards (JSON)
            if (!empty($nextLevel->rewards_json)) {
                $rewards = $nextLevel->rewards_json;
                if (isset($rewards['tokens']) && $rewards['tokens'] > 0) {
                    $user->increment('tokens', $rewards['tokens']);
                }
            }

            // Otorgar logros vinculados al nivel
            if (!empty($nextLevel->achievement_ids)) {
                foreach ($nextLevel->achievement_ids as $achievementId) {
                    try {
                        $achievement = \App\Models\Achievement::find($achievementId);
                        if ($achievement) {
                            $achievement->unlockFor($user);
                            Log::info("Achievement '{$achievement->name}' awarded at level {$nextLevel->level_number} for user {$user->id}");
                        }
                    } catch (\Exception $e) {
                        Log::error("Failed to award achievement {$achievementId} at level up: " . $e->getMessage());
                    }
                }
            }

            // Otorgar insignias vinculadas al nivel
            if (!empty($nextLevel->badge_ids)) {
                foreach ($nextLevel->badge_ids as $badgeId) {
                    try {
                        $badge = \App\Models\SpecialBadge::find($badgeId);
                        if ($badge) {
                            $badge->awardTo($user);
                            Log::info("Badge '{$badge->name}' awarded at level {$nextLevel->level_number} for user {$user->id}");
                        }
                    } catch (\Exception $e) {
                        Log::error("Failed to award badge {$badgeId} at level up: " . $e->getMessage());
                    }
                }
            }

            // Send Notification
            try {
                $user->notify(new \App\Notifications\Gamification\LevelUp($nextLevel));
            } catch (\Exception $e) {
                Log::error('Failed to send level up notification: ' . $e->getMessage());
            }

            // Assign new missions for this level
            $this->assignMissionsForLevel($user, $nextLevel->id);
        }
    }

    /**
     * Initialize user gamification progress with Level 0.
     *
     * @param User $user
     * @return UserProgress
     */
    public function initializeUser(User $user)
    {
        // Check if progress already exists
        if ($user->progress) {
            return $user->progress;
        }

        // Find initial level (Level 0) filtrado por rol
        $initialLevel = Level::where('level_number', 0)
            ->where(function ($q) use ($user) {
                $q->where('role', $user->role)->orWhere('role', 'both');
            })
            ->first() ?? Level::where('level_number', 0)->first()
            ?? Level::orderBy('level_number', 'asc')->first();

        $progress = UserProgress::create([
            'user_id'          => $user->id,
            'current_level_id' => $initialLevel ? $initialLevel->id : null,
            'current_xp'       => 0,
            'tickets_balance'  => 0,
        ]);

        // Assign initial missions
        $this->assignInitialMissions($user, $progress);

        return $progress;
    }

    /**
     * Assign missions for specific level.
     */
    public function assignMissionsForLevel(User $user, $levelId)
    {
        $role = $user->role ?? 'fan'; // Default to fan if role not set

        $missions = \App\Models\Mission::where('is_active', true)
            ->where('type', 'LEVEL_UP')
            ->where('level_id', $levelId)
            ->where(function ($q) use ($role) {
                $q->where('role', 'both')->orWhere('role', $role);
            })
            ->get();

        foreach ($missions as $mission) {
            if (!$user->missions()->where('mission_id', $mission->id)->exists()) {
                $mission->assignTo($user);
            }
        }
    }

    /**
     * Assign initial missions to a new user.
     * Weekly/Parallel + Level 0/Current Level Up missions.
     *
     * @param User $user
     * @param UserProgress|null $progress
     * @return void
     */
    public function assignInitialMissions(User $user, ?UserProgress $progress = null)
    {
        $role = $user->role ?? 'fan';
        $currentLevelId = $progress ? $progress->current_level_id : ($user->progress->current_level_id ?? null);

        // 1. Weekly & Parallel Missions (Global or Level Independent)
        $generalMissions = \App\Models\Mission::where('is_active', true)
            ->whereIn('type', ['WEEKLY', 'PARALLEL'])
            ->where(function ($q) use ($role) {
                $q->where('role', 'both')->orWhere('role', $role);
            })
            ->get();

        foreach ($generalMissions as $mission) {
            if (!$user->missions()->where('mission_id', $mission->id)->exists()) {
                $mission->assignTo($user);
            }
        }

        // 2. Level Up Missions for Current Level (Level 0 usually)
        if ($currentLevelId !== null) {
            $this->assignMissionsForLevel($user, $currentLevelId);
        }
    }


    /**
     * Process an action to check against active missions.
     *
     * @param User $user
     * @param string $actionType
     * @param int $amount
     * @return void
     */
    public function processMissionProgress(User $user, string $actionType, int $amount = 1)
    {
        // Get active missions for this user compatible with the action using the pivot model directly
        $activeUserMissions = UserMission::where('user_id', $user->id)
            ->where('completed', false)
            ->whereHas('mission', function ($query) use ($actionType) {
                $query->where('target_action', $actionType)
                    ->where('is_active', true);
            })
            ->with('mission.achievement')  // eager load achievement
            ->get();

        foreach ($activeUserMissions as $userMission) {
            $userMission->progress += $amount;

            if ($userMission->progress >= $userMission->mission->goal_amount) {
                $userMission->completed    = true;
                $userMission->completed_at = now();
                $userMission->save();

                // Award XP reward
                if ($userMission->mission->reward_xp > 0) {
                    $this->awardXp($user, $userMission->mission->reward_xp);
                } else {
                    $this->checkLevelUp($user, $user->progress);
                }

                // Award tickets reward
                if ($userMission->mission->reward_tickets > 0) {
                    $user->progress->tickets_balance += $userMission->mission->reward_tickets;
                    $user->progress->save();
                }

                // Desbloquear logro vinculado (si existe)
                if ($userMission->mission->achievement_id && $userMission->mission->achievement) {
                    try {
                        $userMission->mission->achievement->unlockFor($user);
                        Log::info("Achievement '{$userMission->mission->achievement->name}' unlocked via mission for user {$user->id}");
                    } catch (\Exception $e) {
                        Log::error('Failed to unlock mission achievement: ' . $e->getMessage());
                    }
                }
            } else {
                $userMission->save();
            }
        }
    }

    /**
     * Check and unlock achievements for a user based on their current stats.
     *
     * @param User $user
     * @return void
     */
    public function checkAchievements(User $user)
    {
        // Get all active achievements for user's role
        $role = $user->role ?? 'fan';
        $achievements = \App\Models\Achievement::where('is_active', true)
            ->where(function ($q) use ($role) {
                $q->where('role', $role)->orWhere('role', 'both');
            })
            ->get();

        // Get already unlocked achievements
        $unlockedIds = $user->achievements()->pluck('achievement_id')->toArray();

        foreach ($achievements as $achievement) {
            // Skip if already unlocked
            if (in_array($achievement->id, $unlockedIds)) {
                continue;
            }

            // Check if requirements are met
            if ($this->checkAchievementRequirements($user, $achievement)) {
                $achievement->unlockFor($user);
                Log::info("Achievement '{$achievement->name}' unlocked for user {$user->id}");
            }
        }
    }

    /**
     * Check if user meets achievement requirements.
     *
     * @param User $user
     * @param \App\Models\Achievement $achievement
     * @return bool
     */
    protected function checkAchievementRequirements(User $user, $achievement): bool
    {
        $requirements = $achievement->requirements ?? [];

        if (empty($requirements)) {
            return false;
        }

        // Check each requirement
        foreach ($requirements as $type => $targetValue) {
            $currentValue = $this->getAchievementProgress($user, $type);

            if ($currentValue < $targetValue) {
                return false; // Requirement not met
            }
        }

        return true; // All requirements met
    }

    /**
     * Get user's current progress for an achievement requirement type.
     *
     * @param User $user
     * @param string $type
     * @return int|float
     */
    protected function getAchievementProgress(User $user, string $type)
    {
        switch ($type) {
            case 'level':
                $progress = $user->progress;
                return $progress ? ($progress->currentLevel->level_number ?? 0) : 0;

            case 'photos':
            case 'photos_count':
                return $user->photos()->count();

            case 'videos':
            case 'videos_count':
                return $user->videos()->count();

            case 'streams':
            case 'streams_count':
                return $user->streams()->count();

            case 'total_stream_hours':
            case 'stream_hours':
                // Sum duration in hours
                // Calculate from started_at and ended_at since 'duration' column might not exist
                $totalMinutes = $user->streams()
                    ->whereNotNull('started_at')
                    ->whereNotNull('ended_at')
                    ->get()
                    ->sum(function ($stream) {
                        return $stream->ended_at->diffInMinutes($stream->started_at);
                    });

                return $totalMinutes / 60;

            case 'tips_received':
            case 'tips_count':
                return $user->tipsReceived()->where('status', 'completed')->count();

            case 'tips_sent':
                return $user->tipsSent()->where('status', 'completed')->count();

            case 'subscribers':
            case 'subscribers_count':
            case 'followers':
                return $user->subscriptionsAsModel()->where('status', 'active')->count();

            case 'subscriptions':
            case 'subscriptions_count':
                return $user->subscriptionsAsFan()->where('status', 'active')->count();

            case 'earnings':
            case 'total_earnings':
                // Use TokenTransaction for accurate earnings
                return \App\Models\TokenTransaction::where('user_id', $user->id)
                    ->where('type', 'earned')
                    ->sum('amount');

            case 'tokens_spent':
                return \App\Models\TokenTransaction::where('user_id', $user->id)
                    ->where('type', 'spent')
                    ->sum('amount');

            case 'xp':
            case 'total_xp':
                $progress = $user->progress;
                return $progress ? $progress->total_xp : 0;

            default:
                return 0;
        }
    }

    /**
     * Check and auto-assign milestone badges for a user.
     */
    public function checkBadges(User $user): void
    {
        $badges = \App\Models\SpecialBadge::where('is_active', true)
            ->whereIn('type', ['milestone'])
            ->get();

        foreach ($badges as $badge) {
            if ($badge->hasUser($user->id)) continue;

            if ($this->checkBadgeRequirements($user, $badge->requirements ?? [])) {
                $badge->awardTo($user);
                Log::info("Badge '{$badge->name}' awarded to user {$user->id}");
            }
        }
    }

    /**
     * Check if user meets badge requirements.
     */
    protected function checkBadgeRequirements(User $user, array $requirements): bool
    {
        if (empty($requirements)) {
            return false;
        }

        foreach ($requirements as $type => $value) {
            if ($this->getAchievementProgress($user, $type) < $value) {
                return false;
            }
        }

        return true;
    }
}
