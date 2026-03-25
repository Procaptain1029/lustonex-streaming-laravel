<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenPackageController extends Controller
{
    public function index()
    {
        $packages = \App\Models\TokenPackage::orderBy('price', 'asc')->get();
        return view('admin.token_packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.token_packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tokens' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
            'bonus' => 'required|integer|min:0',
            'is_limited_time' => 'boolean',
            'expires_at' => 'required_if:is_limited_time,true|nullable|date',
            'is_active' => 'boolean',
        ]);

        $validated['is_limited_time'] = $request->has('is_limited_time');
        $validated['is_active'] = $request->has('is_active');

        if ($validated['is_limited_time'] && !empty($validated['expires_at'])) {
            $timezone = $request->input('timezone', 'UTC');
            $validated['expires_at'] = \Carbon\Carbon::parse($validated['expires_at'], $timezone)->setTimezone('UTC');
        } else {
            $validated['expires_at'] = null;
        }

        \App\Models\TokenPackage::create($validated);

        return redirect()->route('admin.token-packages.index')
                         ->with('success', __('admin.flash.token_packages.created'));
    }

    public function edit(\App\Models\TokenPackage $tokenPackage)
    {
        return view('admin.token_packages.edit', compact('tokenPackage'));
    }

    public function update(Request $request, \App\Models\TokenPackage $tokenPackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tokens' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
            'bonus' => 'required|integer|min:0',
            'is_limited_time' => 'boolean',
            'expires_at' => 'required_if:is_limited_time,true|nullable|date',
            'is_active' => 'boolean',
        ]);

        $validated['is_limited_time'] = $request->has('is_limited_time');
        $validated['is_active'] = $request->has('is_active');
        
        if ($validated['is_limited_time'] && !empty($validated['expires_at'])) {
            $timezone = $request->input('timezone', 'UTC');
            $validated['expires_at'] = \Carbon\Carbon::parse($validated['expires_at'], $timezone)->setTimezone('UTC');
        } else {
            $validated['expires_at'] = null;
        }

        $tokenPackage->update($validated);

        return redirect()->route('admin.token-packages.index')
                         ->with('success', __('admin.flash.token_packages.updated'));
    }

    public function destroy(\App\Models\TokenPackage $tokenPackage)
    {
        $tokenPackage->delete();
        
        return redirect()->route('admin.token-packages.index')
                         ->with('success', __('admin.flash.token_packages.deleted'));
    }
}
