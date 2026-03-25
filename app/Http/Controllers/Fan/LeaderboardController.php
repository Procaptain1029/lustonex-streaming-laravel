<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LeaderboardController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return redirect()->route('home')->with('error', __('admin.flash.fan.access_denied'));
        }
        
        
        $userProgress = $user->progress;
        $currentLevel = ($userProgress && $userProgress->currentLevel) ? $userProgress->currentLevel->level_number : 0;
        $currentXP = $userProgress ? $userProgress->current_xp : 0;
        
        
        
        $topFans = User::where('role', 'fan')
            ->with('progress.currentLevel')
            ->orderBy('tokens', 'desc')
            ->take(50)
            ->get()
            ->map(function($fan, $index) {
                return [
                    'rank' => $index + 1,
                    'name' => $fan->name,
                    'level' => ($fan->progress && $fan->progress->currentLevel) ? $fan->progress->currentLevel->level_number : 0,
                    'liga'           => ($fan->progress && $fan->progress->currentLevel) ? $fan->progress->currentLevel->name : __('admin.flash.benefits.default_league'),
                    'xp' => $fan->progress ? $fan->progress->current_xp : 0,
                    'is_current_user' => $fan->id === auth()->id(),
                ];
            });
        
        
        $userRank = $topFans->where('is_current_user', true)->first();
        if (!$userRank) {
            $userRank = [
                'rank' => '50+',
                'name' => $user->name,
                'level' => $currentLevel,
                'liga'           => ($userProgress && $userProgress->currentLevel) ? $userProgress->currentLevel->name : __('admin.flash.benefits.default_league'),
                'xp' => $currentXP,
                'is_current_user' => true,
            ];
        }
        
        
        $stats = [
            'your_rank' => is_numeric($userRank['rank']) ? $userRank['rank'] : '50+',
            'your_xp' => $currentXP,
            'total_fans' => User::where('role', 'fan')->count(),
            'top_percentage' => is_numeric($userRank['rank']) ? round(($userRank['rank'] / User::where('role', 'fan')->count()) * 100, 1) : 100,
        ];
        
        return view('fan.leaderboard.index', compact('user', 'topFans', 'userRank', 'stats'));
    }
}
