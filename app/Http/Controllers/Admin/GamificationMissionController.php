<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use Illuminate\Http\Request;

class GamificationMissionController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Mission::query();
        
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $missions = $query->latest()->paginate(20);
        
        return view('admin.gamification.missions.index', compact('missions'));
    }

    
    public function create()
    {
        $levels = \App\Models\Level::orderBy('level_number')->get();
        $achievements = \App\Models\Achievement::where('is_active', true)->orderBy('name')->get();
        $badges = \App\Models\SpecialBadge::where('is_active', true)->orderBy('name')->get();
        return view('admin.gamification.missions.create', compact('levels', 'achievements', 'badges'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'type'           => 'required|in:LEVEL_UP,WEEKLY,PARALLEL',
            'role'           => 'required|in:fan,model,both',
            'level_id'       => 'nullable|exists:levels,id',
            'achievement_id' => 'nullable|exists:achievements,id',
            'badge_id'       => 'nullable|exists:special_badges,id',
            'target_action'  => 'required|string|max:255',
            'goal_amount'    => 'required|integer|min:1',
            'reward_xp'      => 'required|integer|min:0',
            'reward_tickets' => 'required|integer|min:0',
            'is_active'      => 'boolean',
        ]);
        
        $validated['is_active'] = $request->has('is_active');
        
        Mission::create($validated);
        
        return redirect()->route('admin.gamification.missions.index')
                        ->with('success', __('admin.flash.missions.created'));
    }

    
    public function edit(Mission $mission)
    {
        $levels = \App\Models\Level::orderBy('level_number')->get();
        $achievements = \App\Models\Achievement::where('is_active', true)->orderBy('name')->get();
        $badges = \App\Models\SpecialBadge::where('is_active', true)->orderBy('name')->get();
        return view('admin.gamification.missions.edit', compact('mission', 'levels', 'achievements', 'badges'));
    }

    
    public function update(Request $request, Mission $mission)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'type'           => 'required|in:LEVEL_UP,WEEKLY,PARALLEL',
            'role'           => 'required|in:fan,model,both',
            'level_id'       => 'nullable|exists:levels,id',
            'achievement_id' => 'nullable|exists:achievements,id',
            'badge_id'       => 'nullable|exists:special_badges,id',
            'target_action'  => 'required|string|max:255',
            'goal_amount'    => 'required|integer|min:1',
            'reward_xp'      => 'required|integer|min:0',
            'reward_tickets' => 'required|integer|min:0',
            'is_active'      => 'boolean',
        ]);
        
        $validated['is_active'] = $request->has('is_active');
        
        $mission->update($validated);
        
        return redirect()->route('admin.gamification.missions.index')
                        ->with('success', __('admin.flash.missions.updated'));
    }

    
    public function destroy(Mission $mission)
    {
        
        if ($mission->users()->count() > 0) {
            return back()->with('error', __('admin.flash.missions.cannot_delete'));
        }
        
        $mission->delete();
        
        return redirect()->route('admin.gamification.missions.index')
                        ->with('success', __('admin.flash.missions.deleted'));
    }
    
    
    public function toggleActive(Mission $mission)
    {
        $mission->update(['is_active' => !$mission->is_active]);

        $key = $mission->is_active ? 'activated' : 'deactivated';
        return back()->with('success', __('admin.flash.missions.' . $key));
    }
}
