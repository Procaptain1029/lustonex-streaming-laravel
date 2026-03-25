<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class GamificationAchievementController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Achievement::query();
        
        
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        
        if ($request->filled('rarity')) {
            $query->where('rarity', $request->rarity);
        }
        
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $achievements = $query->latest()->paginate(20);
        
        return view('admin.gamification.achievements.index', compact('achievements'));
    }

    
    public function create()
    {
        return view('admin.gamification.achievements.create');
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:achievements,slug',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'rarity' => 'required|in:common,rare,epic,legendary',
            'category' => 'required|in:content,earnings,popularity,special',
            'role' => 'required|in:fan,model,both',
            'xp_reward' => 'required|integer|min:0',
            'ticket_reward' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);
        
        
        $requirements = [];
        if ($request->filled('requirement_key') && $request->filled('requirement_value')) {
            $keys = $request->requirement_key;
            $values = $request->requirement_value;
            
            foreach ($keys as $index => $key) {
                if (!empty($key) && !empty($values[$index])) {
                    $requirements[$key] = (int)$values[$index];
                }
            }
        }
        
        $validated['requirements'] = $requirements;
        $validated['is_active'] = $request->has('is_active');
        
        Achievement::create($validated);
        
        return redirect()->route('admin.gamification.achievements.index')
                        ->with('success', __('admin.flash.achievements.created'));
    }

    
    public function edit(Achievement $achievement)
    {
        return view('admin.gamification.achievements.edit', compact('achievement'));
    }

    
    public function update(Request $request, Achievement $achievement)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:achievements,slug,' . $achievement->id,
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'rarity' => 'required|in:common,rare,epic,legendary',
            'category' => 'required|in:content,earnings,popularity,special',
            'role' => 'required|in:fan,model,both',
            'xp_reward' => 'required|integer|min:0',
            'ticket_reward' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);
        
        
        $requirements = [];
        if ($request->filled('requirement_key') && $request->filled('requirement_value')) {
            $keys = $request->requirement_key;
            $values = $request->requirement_value;
            
            foreach ($keys as $index => $key) {
                if (!empty($key) && !empty($values[$index])) {
                    $requirements[$key] = (int)$values[$index];
                }
            }
        }
        
        $validated['requirements'] = $requirements;
        $validated['is_active'] = $request->has('is_active');
        
        $achievement->update($validated);
        
        return redirect()->route('admin.gamification.achievements.index')
                        ->with('success', __('admin.flash.achievements.updated'));
    }

    
    public function destroy(Achievement $achievement)
    {
        
        if ($achievement->users()->count() > 0) {
            return back()->with('error', __('admin.flash.achievements.cannot_delete'));
        }
        
        $achievement->delete();
        
        return redirect()->route('admin.gamification.achievements.index')
                        ->with('success', __('admin.flash.achievements.deleted'));
    }
    
    
    public function toggleActive(Achievement $achievement)
    {
        $achievement->update(['is_active' => !$achievement->is_active]);

        $key = $achievement->is_active ? 'activated' : 'deactivated';
        return back()->with('success', __('admin.flash.achievements.' . $key));
    }
}
