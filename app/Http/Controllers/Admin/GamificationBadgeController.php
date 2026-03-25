<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialBadge;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GamificationBadgeController extends Controller
{
    
    public function index(Request $request)
    {
        $query = SpecialBadge::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $badges = $query->latest()->get();
        return view('admin.gamification.badges.index', compact('badges'));
    }

    
    public function create()
    {
        return view('admin.gamification.badges.create');
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'type' => 'required|in:hall_of_fame,event,milestone,special',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->has('is_active');
        $validated['requirements'] = []; // evaluados automáticamente por el sistema

        SpecialBadge::create($validated);

        return redirect()->route('admin.gamification.badges.index')
                        ->with('success', __('admin.flash.badges.created'));
    }

    
    public function edit(SpecialBadge $badge)
    {
        return view('admin.gamification.badges.edit', compact('badge'));
    }

    
    public function update(Request $request, SpecialBadge $badge)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'type' => 'required|in:hall_of_fame,event,milestone,special',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->has('is_active');
        $validated['requirements'] = []; // evaluados automáticamente por el sistema

        $badge->update($validated);

        return redirect()->route('admin.gamification.badges.index')
                        ->with('success', __('admin.flash.badges.updated'));
    }

    
    public function destroy(SpecialBadge $badge)
    {
        if ($badge->users()->exists()) {
            return back()->with('error', __('admin.flash.badges.cannot_delete'));
        }

        $badge->delete();

        return redirect()->route('admin.gamification.badges.index')
                        ->with('success', __('admin.flash.badges.deleted'));
    }

    
    public function toggleActive(SpecialBadge $badge)
    {
        $badge->update(['is_active' => !$badge->is_active]);
        return back()->with('success', __('admin.flash.badges.status_updated'));
    }
}
