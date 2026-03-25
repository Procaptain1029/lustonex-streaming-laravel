<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class GamificationXpSettingsController extends Controller
{
    public function index()
    {
        $settings = [
            // Fan
            'fan_tip_sent'           => Setting::get('gamification.xp.fan_tip_sent', 10),
            'fan_subscription'       => Setting::get('gamification.xp.fan_subscription', 100),
            'fan_chat_message'       => Setting::get('gamification.xp.fan_chat_message', 1),
            'fan_stream_view'        => Setting::get('gamification.xp.fan_stream_view', 5),
            'fan_tokens_purchased'   => Setting::get('gamification.xp.fan_tokens_purchased', 10),
            
            // Model
            'model_tip_received'     => Setting::get('gamification.xp.model_tip_received', 10),
            'model_new_subscriber'   => Setting::get('gamification.xp.model_new_subscriber', 50),
            'model_chat_message'     => Setting::get('gamification.xp.model_chat_message', 1),
            'model_stream_view'      => Setting::get('gamification.xp.model_stream_view', 5),
        ];

        return view('admin.gamification.xp-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'fan_tip_sent'           => 'required|integer|min:0|max:1000',
            'fan_subscription'       => 'required|integer|min:0|max:1000',
            'fan_chat_message'       => 'required|integer|min:0|max:100',
            'fan_stream_view'        => 'required|integer|min:0|max:100',
            'fan_tokens_purchased'   => 'required|integer|min:0|max:1000',

            'model_tip_received'     => 'required|integer|min:0|max:1000',
            'model_new_subscriber'   => 'required|integer|min:0|max:1000',
            'model_chat_message'     => 'required|integer|min:0|max:100',
            'model_stream_view'      => 'required|integer|min:0|max:100',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set("gamification.xp.{$key}", $value);
        }

        return back()->with('success', __('admin.flash.settings.xp_updated'));
    }
}
