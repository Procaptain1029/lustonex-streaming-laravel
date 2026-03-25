<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\UserMission;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        
        if (!$profile || !$profile->isApproved()) {
            return redirect()->route('model.dashboard')
                           ->with('error', __('admin.flash.model.missions_required'));
        }
        
        
        $currentLevel = $user->progress ? $user->progress->currentLevel : null;
        $currentLevelId = $currentLevel ? $currentLevel->id : null;
        
        
        $allMissions = Mission::where('is_active', true)
            ->forRole('model')
            ->with('level')
            ->get();
        
        
        $userMissions = UserMission::where('user_id', $user->id)
            ->with('mission')
            ->get()
            ->keyBy('mission_id');
        
        
        foreach ($allMissions as $mission) {
            if (!isset($userMissions[$mission->id])) {
                
                if (!$mission->level_id || $mission->level_id == $currentLevelId) {
                    $mission->assignTo($user);
                }
            }
        }
        
        
        $userMissions = UserMission::where('user_id', $user->id)
            ->with('mission')
            ->get()
            ->keyBy('mission_id');
        
        
        $totalMissions = $userMissions->count();
        $completedToday = UserMission::where('user_id', $user->id)
            ->where('completed', true)
            ->whereDate('completed_at', today())
            ->count();
        $ticketsBalance = $user->tickets ?? 0;
        $xpEarnedToday = UserMission::where('user_id', $user->id)
            ->where('completed', true)
            ->whereDate('completed_at', today())
            ->join('missions', 'user_missions.mission_id', '=', 'missions.id')
            ->sum('missions.reward_xp');
        
        $stats = [
            'total_missions' => $totalMissions,
            'completed_today' => $completedToday,
            'tickets_balance' => $ticketsBalance,
            'xp_earned_today' => $xpEarnedToday,
        ];
        
        
        $formatMission = function($userMission) {
            $mission = $userMission->mission;
            $progress = $userMission->progress ?? 0;
            $goalAmount = $mission->goal_amount ?? 1;
            
            
            $iconMap = [
                'upload_photo' => 'fa-camera',
                'upload_video' => 'fa-video',
                'receive_tip' => 'fa-coins',
                'start_stream' => 'fa-broadcast-tower',
                'get_subscriber' => 'fa-users',
                'earn_tokens' => 'fa-gem',
                'complete_profile' => 'fa-user-circle',
                'daily_login' => 'fa-calendar-check',
            ];
            
            $icon = $iconMap[$mission->target_action] ?? 'fa-tasks';
            
            return [
                'id' => $mission->id,
                'title' => $mission->name,
                'description' => $mission->description,
                'icon' => $icon,
                'current' => $progress,
                'target' => $goalAmount,
                'xp_reward' => $mission->reward_xp ?? 0,
                'ticket_reward' => $mission->reward_tickets ?? 0,
                'completed' => $userMission->completed ?? false,
                'can_claim' => ($progress >= $goalAmount) && !$userMission->completed,
            ];
        };
        
        
        $obligatoryMissions = collect();
        $dailyMissions = collect();
        $weeklyMissions = collect();
        $monthlyMissions = collect();
        
        foreach ($userMissions as $userMission) {
            if (!$userMission->mission) continue;
            
            $formattedMission = $formatMission($userMission);
            
            switch ($userMission->mission->type) {
                case 'LEVEL_UP':
                    $obligatoryMissions->push($formattedMission);
                    break;
                case 'DAILY':
                    $dailyMissions->push($formattedMission);
                    break;
                case 'WEEKLY':
                    $weeklyMissions->push($formattedMission);
                    break;
                case 'MONTHLY':
                    $monthlyMissions->push($formattedMission);
                    break;
                case 'PARALLEL':
                    
                    if ($formattedMission['target'] <= 10) {
                        $weeklyMissions->push($formattedMission);
                    } else {
                        $monthlyMissions->push($formattedMission);
                    }
                    break;
            }
        }
        
        return view('model.missions.index', compact(
            'stats',
            'obligatoryMissions',
            'dailyMissions',
            'weeklyMissions',
            'monthlyMissions'
        ));
    }
    
    public function claim($id)
    {
        $user = auth()->user();
        
        $userMission = UserMission::where('user_id', $user->id)
            ->where('mission_id', $id)
            ->with('mission')
            ->first();
        
        if (!$userMission || !$userMission->mission) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.model.mission_not_found')
            ], 404);
        }
        
        
        if ($userMission->completed) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.model.mission_already_claimed')
            ], 400);
        }
        
        
        if ($userMission->progress < $userMission->mission->goal_amount) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.model.mission_not_complete')
            ], 400);
        }
        
        
        $userMission->mission->complete($user->id);
        
        return response()->json([
            'success' => true,
            'reward' => [
                'xp' => $userMission->mission->reward_xp,
                'tickets' => $userMission->mission->reward_tickets,
            ],
            'message' => __('admin.flash.model.mission_reward_claimed')
        ]);
    }
}
