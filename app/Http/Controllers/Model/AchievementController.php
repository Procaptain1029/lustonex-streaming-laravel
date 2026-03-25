<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        
        if (!$profile || !$profile->isApproved()) {
            return redirect()->route('model.dashboard')
                           ->with('error', __('admin.flash.model.achievements_required'));
        }
        
        
        $achievements = Achievement::where('is_active', true)
            ->whereIn('role', ['model', 'both'])
            ->orderBy('category')
            ->orderBy('xp_reward')
            ->get();
        
        
        $userProgress = UserProgress::where('user_id', $user->id)->first();
        
        
        $unlockedAchievements = $user->achievements()->pluck('achievement_id')->toArray();
        
        
        $achievementsData = $achievements->map(function($achievement) use ($user, $unlockedAchievements) {
            $isUnlocked = in_array($achievement->id, $unlockedAchievements);
            
            
            $requirements = $achievement->requirements ?? [];
            
            
            $requirementType = key($requirements);
            $requirementValue = $requirements[$requirementType] ?? 0;
            
            $progress = $this->calculateProgress($requirementType, $user);
            
            return [
                'name' => $achievement->name,
                'description' => $achievement->description,
                'icon' => $achievement->icon,
                'rarity' => $achievement->rarity,
                'unlocked' => $isUnlocked,
                'progress' => $progress,
                'target' => $requirementValue,
            ];
        });
        
        
        $stats = [
            'total' => $achievements->count(),
            'unlocked' => count($unlockedAchievements),
            'completion_percentage' => $achievements->count() > 0 
                ? round((count($unlockedAchievements) / $achievements->count()) * 100, 1)
                : 0,
        ];
        
        return view('model.achievements.index', compact(
            'achievementsData',
            'stats',
            'userProgress'
        ));
    }
    
    
    private function calculateProgress($type, $user)
    {
        switch ($type) {
            case 'level':
                $progress = UserProgress::where('user_id', $user->id)->first();
                return $progress ? $progress->current_level : 0;
                
            case 'xp':
            case 'total_xp':
                $progress = UserProgress::where('user_id', $user->id)->first();
                return $progress ? $progress->total_xp : 0;
                
            case 'photos':
            case 'photos_count':
                return $user->photos()->count();
                
            case 'videos':
            case 'videos_count':
                return $user->videos()->count();
                
            case 'streams':
            case 'streams_count':
                return $user->streams()->count();
                
            case 'subscribers':
            case 'subscribers_count':
                return $user->subscriptionsAsModel()->where('status', 'active')->count();
                
            case 'tips':
            case 'tips_count':
                return $user->tipsReceived()->where('status', 'completed')->count();
                
            case 'earnings':
            case 'total_earnings':
                return $user->tipsReceived()->where('status', 'completed')->sum('amount');
                
            default:
                return 0;
        }
    }
}
