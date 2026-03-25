<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Achievement;
use App\Models\SpecialBadge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GamificationLevelController extends Controller
{
    public function index()
    {
        $levels = Level::orderBy('level_number', 'asc')->get();
        return view('admin.gamification.levels.index', compact('levels'));
    }

    public function create()
    {
        $achievements = Achievement::where('is_active', true)->orderBy('name')->get();
        $badges       = SpecialBadge::where('is_active', true)->orderBy('name')->get();
        return view('admin.gamification.levels.create', compact('achievements', 'badges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'level_number'    => 'required|integer|unique:levels,level_number',
            'xp_required'     => 'required|integer|min:0',
            'reward_tokens'   => 'nullable|integer|min:0',
            'role'            => 'required|in:fan,model,both',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'achievement_ids' => 'nullable|array',
            'achievement_ids.*' => 'exists:achievements,id',
            'badge_ids'       => 'nullable|array',
            'badge_ids.*'     => 'exists:special_badges,id',
        ]);

        $tokens = $request->reward_tokens ?? 0;
        $validated['rewards_json']   = ['tokens' => (int) $tokens];
        $validated['achievement_ids'] = $request->achievement_ids ?? [];
        $validated['badge_ids']       = $request->badge_ids ?? [];

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('levels', 'public');
        }

        unset($validated['reward_tokens']);
        Level::create($validated);

        return redirect()->route('admin.gamification.levels.index')
                        ->with('success', __('admin.flash.levels.created'));
    }

    public function edit(Level $level)
    {
        $achievements = Achievement::where('is_active', true)->orderBy('name')->get();
        $badges       = SpecialBadge::where('is_active', true)->orderBy('name')->get();
        return view('admin.gamification.levels.edit', compact('level', 'achievements', 'badges'));
    }

    public function update(Request $request, Level $level)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'level_number'    => 'required|integer|unique:levels,level_number,' . $level->id,
            'xp_required'     => 'required|integer|min:0',
            'reward_tokens'   => 'nullable|integer|min:0',
            'role'            => 'required|in:fan,model,both',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'achievement_ids' => 'nullable|array',
            'achievement_ids.*' => 'exists:achievements,id',
            'badge_ids'       => 'nullable|array',
            'badge_ids.*'     => 'exists:special_badges,id',
        ]);

        $tokens = $request->reward_tokens ?? $level->rewards_json['tokens'] ?? 0;
        $validated['rewards_json']   = ['tokens' => (int) $tokens];
        $validated['achievement_ids'] = $request->achievement_ids ?? [];
        $validated['badge_ids']       = $request->badge_ids ?? [];

        if ($request->hasFile('image')) {
            if ($level->image) {
                Storage::disk('public')->delete($level->image);
            }
            $validated['image'] = $request->file('image')->store('levels', 'public');
        }

        unset($validated['reward_tokens']);
        $level->update($validated);

        return redirect()->route('admin.gamification.levels.index')
                        ->with('success', __('admin.flash.levels.updated'));
    }

    public function destroy(Level $level)
    {
        if ($level->image) {
            Storage::disk('public')->delete($level->image);
        }
        $level->delete();

        return redirect()->route('admin.gamification.levels.index')
                        ->with('success', __('admin.flash.levels.deleted'));
    }
}
