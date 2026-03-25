<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class GamificationDebuggerController extends Controller
{
    
    public function show($userId)
    {
        $user = User::with([
            'progress.currentLevel', 
            'missions', 
            'achievements', 
            'badges'
        ])->findOrFail($userId);

        
        $nextLevel = \App\Models\Level::where('level_number', '>', $user->progress->currentLevel->level_number ?? 0)
            ->orderBy('level_number', 'asc')
            ->first();

        return view('admin.gamification.debugger', compact('user', 'nextLevel'));
    }
}
