<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return redirect()->route('home');
        }

        
        $allActiveMissions = $user->getActiveMissions();
        
        $obligatoryMissions = $allActiveMissions->where('type', 'LEVEL_UP');
        $weeklyMissions = $allActiveMissions->where('type', 'WEEKLY');
        $parallelMissions = $allActiveMissions->where('type', 'PARALLEL'); 
        
        
        $completedMissions = $user->missions()
            ->wherePivot('completed', true)
            ->orderByPivot('completed_at', 'desc')
            ->take(20)
            ->get()
            ->map(function($mission) {
                return (object)[
                    'id' => $mission->id,
                    'name' => $mission->name,
                    'description' => $mission->description,
                    'type' => $mission->type,
                    'completed_at' => $mission->pivot->completed_at,
                    'reward_xp' => $mission->reward_xp,
                    'reward_tickets' => $mission->reward_tickets,
                ];
            });

        return view('fan.missions.index', compact(
            'user', 
            'obligatoryMissions', 
            'weeklyMissions', 
            'parallelMissions',
            'completedMissions'
        ));
    }
}
