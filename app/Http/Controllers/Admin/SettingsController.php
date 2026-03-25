<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    
    public function index()
    {
        
        $settings = [
            'site_name' => Setting::get('site_name', config('app.name', 'Lustonex')),
            'site_description' => Setting::get('site_description', 'Plataforma de streaming premium'),
            'maintenance_mode' => (bool) Setting::get('maintenance_mode', false),
            'registration_enabled' => (bool) Setting::get('registration_enabled', true),
            'email_verification_required' => (bool) Setting::get('email_verification_required', true),
            'min_withdrawal_amount' => Setting::get('min_withdrawal_amount', 50),
            'commission_rate' => Setting::get('commission_rate', 20),
            'token_usd_rate' => Setting::get('token_usd_rate', 0.10),
            'max_upload_size' => Setting::get('max_upload_size', 100),
            'stream_quality' => Setting::get('stream_quality', 'hd'),
            'notifications_enabled' => (bool) Setting::get('notifications_enabled', true),
            'email_notifications' => (bool) Setting::get('email_notifications', true),
            'default_locale' => Setting::get('default_locale', 'es'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'maintenance_mode' => 'boolean',
            'registration_enabled' => 'boolean',
            'email_verification_required' => 'boolean',
            'min_withdrawal_amount' => 'required|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'token_usd_rate' => 'required|numeric|min:0.01|max:10',
            'max_upload_size' => 'required|numeric|min:1',
            'stream_quality' => 'required|in:sd,hd,fhd,4k',
            'notifications_enabled' => 'boolean',
            'email_notifications' => 'boolean',
            'default_locale' => 'required|in:es,en,pt_BR',
        ]);

        
        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', __('admin.flash.settings.updated'));
    }
}
