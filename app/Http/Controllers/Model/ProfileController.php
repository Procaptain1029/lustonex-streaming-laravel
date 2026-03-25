<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile ?? new Profile();
        
        
        if ($profile->verification_status === 'under_review') {
            return redirect()->route('model.dashboard')
                           ->with('error', __('admin.flash.model.edit_blocked_review'));
        }
        
        if ($profile->verification_status === 'rejected') {
            return redirect()->route('model.onboarding.index')
                           ->with('info', __('admin.flash.model.edit_blocked_rejected'));
        }
        
        return view('model.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);
        
        
        if ($profile->verification_status === 'under_review') {
            return redirect()->route('model.dashboard')
                           ->with('error', 'No puedes editar tu perfil mientras está en revisión.');
        }
        
        if ($profile->verification_status === 'rejected') {
            return redirect()->route('model.onboarding.index')
                           ->with('info', 'Tu perfil fue rechazado. Usa el proceso de onboarding para corregir la información.');
        }
        
        
        $allowedFields = ['display_name', 'bio', 'subscription_price'];
        
        
        if ($profile->verification_status === 'approved') {
            $validated = $request->validate([
                'display_name' => 'nullable|string|max:255',
                'bio' => 'nullable|string|max:1000',
                'subscription_price' => 'required|numeric|min:5|max:100',
                'country' => 'nullable|string|max:100',
                'age' => 'nullable|integer|min:18|max:65',
                'body_type' => 'nullable|string|in:delgado,atletico,talla_mediana,con_curvas,bbw',
                'ethnicity' => 'nullable|string|in:blanca,latina,asiatica,negra,arabe,india,multietnica',
                'hair_color' => 'nullable|string|in:rubio,moreno,negro,pelirrojo,colorido,canoso',
                'eye_color' => 'nullable|string|in:cafe,azul,verde,gris,avellana,negro',
                'interested_in' => 'nullable|string|in:todos,hombres,mujeres,parejas,trans',
                'interests' => 'nullable|array',
                'interests.*' => 'string|in:romantico,aventurero,jugueton,sensual,dominante,sumiso,fetichista,roleplay,voyeur,exhibicionista',
                'languages' => 'nullable|array',
                'languages.*' => 'string|in:es,en,pt,fr,it,de,ru,ja,ko,zh',
                'social_networks' => 'nullable|array',
                'social_networks.instagram' => 'nullable|url',
                'social_networks.twitter' => 'nullable|url',
                'social_networks.tiktok' => 'nullable|url',
                'social_networks.onlyfans' => 'nullable|url',
                'avatar' => 'nullable|image|max:2048',
                'cover_image' => 'nullable|image|max:5120',
                'chat_unlock_price' => 'required|integer|min:10',
                'chat_unlock_duration' => 'required|integer|min:1',
            ]);
            
            
            $restrictedFields = [
                'display_name', 'bio', 'subscription_price', 'country', 'age',
                'body_type', 'ethnicity', 'hair_color', 'eye_color', 'interested_in',
                'interests', 'languages', 'social_networks', 'avatar', 'cover_image',
                'chat_unlock_price', 'chat_unlock_duration'
            ];
            $validated = array_intersect_key($validated, array_flip($restrictedFields));
        } else {
            
            $validated = $request->validate([
                'display_name' => 'nullable|string|max:255',
                'bio' => 'nullable|string|max:1000',
                'subscription_price' => 'required|numeric|min:5|max:100',
                'country' => 'nullable|string|max:100',
                'age' => 'nullable|integer|min:18|max:65',
                'body_type' => 'nullable|string|in:delgado,atletico,talla_mediana,con_curvas,bbw',
                'ethnicity' => 'nullable|string|in:blanca,latina,asiatica,negra,arabe,india,multietnica',
                'hair_color' => 'nullable|string|in:rubio,moreno,negro,pelirrojo,colorido,canoso',
                'eye_color' => 'nullable|string|in:cafe,azul,verde,gris,avellana,negro',
                'interested_in' => 'nullable|string|in:todos,hombres,mujeres,parejas,trans',
                'interests' => 'nullable|array',
                'interests.*' => 'string|in:romantico,aventurero,jugueton,sensual,dominante,sumiso,fetichista,roleplay,voyeur,exhibicionista',
                'languages' => 'nullable|array',
                'languages.*' => 'string|in:es,en,pt,fr,it,de,ru,ja,ko,zh',
                'social_networks' => 'nullable|array',
                'social_networks.instagram' => 'nullable|url',
                'social_networks.twitter' => 'nullable|url',
                'social_networks.tiktok' => 'nullable|url',
                'social_networks.onlyfans' => 'nullable|url',
                'avatar' => 'nullable|image|max:2048',
                'cover_image' => 'nullable|image|max:5120',
                'chat_unlock_price' => 'nullable|integer|min:10',
                'chat_unlock_duration' => 'nullable|integer|min:1',
            ]);
        }

        
        if ($request->hasFile('avatar')) {
                if ($profile->avatar) {
                    Storage::disk('public')->delete($profile->avatar);
                }
                $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            if ($request->hasFile('cover_image')) {
                if ($profile->cover_image) {
                    Storage::disk('public')->delete($profile->cover_image);
                }
                $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        
        if (isset($validated['interests'])) {
            $validated['interests'] = json_encode($validated['interests']);
        }
        
        if (isset($validated['languages'])) {
            $validated['languages'] = json_encode($validated['languages']);
        }
        
        if (isset($validated['social_networks'])) {
            
            $socialNetworks = array_filter($validated['social_networks'], function($url) {
                return !empty($url);
            });
            $validated['social_networks'] = json_encode($socialNetworks);
        }

        $profile->fill($validated);
        
        
        $profile->last_profile_update = now();
        
        $profile->save();

        $message = $profile->verification_status === 'approved'
            ? __('admin.flash.model.profile_updated_approved')
            : __('admin.flash.model.profile_updated');

        return redirect()->route('model.profile.edit')->with('success', $message);
    }
    
    
    public function settings()
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        
        if (!$profile || !$profile->isApproved()) {
            return redirect()->route('model.dashboard')
                           ->with('error', __('admin.flash.model.settings_approved_required'));
        }
        
        
        $userProgress = $user->progress;
        $currentLevel = $userProgress ? $userProgress->currentLevel : null;
        $unlockedBenefits = $user->getModelBenefits();
        
        
        $missionsCompleted = \App\Models\UserMission::where('user_id', $user->id)
            ->where('completed', true)
            ->count();
            
        $achievementsUnlocked = $user->achievements()->count();
        
        $gamificationStats = [
            'total_xp' => $userProgress ? $userProgress->total_xp : 0,
            'current_level' => $currentLevel ? $currentLevel->level_number : 0,
            'missions_completed' => $missionsCompleted,
            'achievements_unlocked' => $achievementsUnlocked,
            'current_rank' => $user->getModelRank(),
        ];
        
        
        $settings = [
            'notifications' => [
                'level_up' => true,
                'achievements' => true,
                'missions' => true,
                'tips' => true,
                'new_subscribers' => true,
            ],
            'privacy' => [
                'show_online_status' => true,
                'show_in_leaderboard' => true,
                'allow_messages' => true,
            ],
        ];
        
        return view('model.profile.settings', compact(
            'profile',
            'userProgress',
            'currentLevel',
            'unlockedBenefits',
            'gamificationStats',
            'settings'
        ));
    }
    
    
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'notifications' => 'nullable|array',
            'privacy' => 'nullable|array',
        ]);
        
        
        
        
        return redirect()->route('model.profile.settings')
                       ->with('success', __('admin.flash.model.settings_updated'));
    }
}
