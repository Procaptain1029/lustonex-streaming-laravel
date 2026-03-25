<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Mission;
use App\Models\UserMission;

class SyncGamificationMissions extends Command
{
    protected $signature = 'gamification:sync-missions {user_id?}';
    protected $description = 'Assign active missions (Weekly, Parallel, LevelUp) to users and reset expired WEEKLY missions.';

    public function handle()
    {
        $userId = $this->argument('user_id');

        if ($userId) {
            $users = User::where('id', $userId)->get();
        } else {
            $users = User::where('role', '!=', 'admin')->get();
        }

        $this->info('Starting mission sync for ' . $users->count() . ' users...');

        $weeklyMissions   = Mission::where('type', 'WEEKLY')->where('is_active', true)->get();
        $parallelMissions = Mission::where('type', 'PARALLEL')->where('is_active', true)->get();
        $levelUpMissions  = Mission::where('type', 'LEVEL_UP')->where('is_active', true)->get();

        $nextMonday = now()->startOfWeek()->next('Monday')->startOfDay();

        foreach ($users as $user) {
            $this->comment("Syncing user: {$user->name} ({$user->id})");
            $count = 0;

            // 1. Misiones WEEKLY — reset si expires_at venció
            foreach ($weeklyMissions as $mission) {
                // Solo misiones del rol del usuario
                if (!in_array($mission->role, [$user->role, 'both'])) {
                    continue;
                }

                $userMission = UserMission::where('user_id', $user->id)
                    ->where('mission_id', $mission->id)
                    ->first();

                // Si existe y expiró → borrar y reasignar
                if ($userMission) {
                    if ($userMission->expires_at && now()->gt($userMission->expires_at)) {
                        $userMission->delete();
                        $userMission = null;
                        $this->line("  [RESET] WEEKLY mission '{$mission->name}' reset for user {$user->id}");
                    }
                }

                if (!$userMission) {
                    UserMission::create([
                        'user_id'    => $user->id,
                        'mission_id' => $mission->id,
                        'progress'   => 0,
                        'completed'  => false,
                        'expires_at' => $nextMonday,
                    ]);
                    $count++;
                }
            }

            // 2. Misiones PARALLEL
            foreach ($parallelMissions as $mission) {
                if (!in_array($mission->role, [$user->role, 'both'])) {
                    continue;
                }

                if (!UserMission::where('user_id', $user->id)->where('mission_id', $mission->id)->exists()) {
                    UserMission::create([
                        'user_id'    => $user->id,
                        'mission_id' => $mission->id,
                        'progress'   => 0,
                        'completed'  => false,
                    ]);
                    $count++;
                }
            }

            // 3. Misiones LEVEL_UP — solo las que no existen (one-time)
            foreach ($levelUpMissions as $mission) {
                if (!in_array($mission->role, [$user->role, 'both'])) {
                    continue;
                }

                $exists = UserMission::where('user_id', $user->id)
                    ->where('mission_id', $mission->id)
                    ->exists();

                if (!$exists) {
                    UserMission::create([
                        'user_id'    => $user->id,
                        'mission_id' => $mission->id,
                        'progress'   => 0,
                        'completed'  => false,
                    ]);
                    $count++;
                }
            }

            $this->info("  -> Assigned/Reset {$count} missions.");
        }

        $this->info('Sync completed successfully.');
    }
}
