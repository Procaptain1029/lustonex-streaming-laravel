<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return redirect()->route('home')->with('error', __('admin.flash.fan.access_denied'));
        }
        
        
        $userProgress = $user->progress;
        $currentLevel = $userProgress ? $userProgress->currentLevel : null;
        $nextLevel = $currentLevel ? \App\Models\Level::where('level_number', $currentLevel->level_number + 1)->first() : null;
        
        
        $xpPercentage = $user->getXPPercentage();
        $currentXP = $userProgress ? $userProgress->current_xp : 0;
        $requiredXP = $currentLevel ? $currentLevel->xp_required : 0;
        
        
        $gamificationStats = [
            'total_xp' => $currentXP,
            'level' => $currentLevel ? $currentLevel->level_number : 0,
            'liga' => $currentLevel ? $currentLevel->name : 'Gris',
            'tickets_balance' => $userProgress ? $userProgress->tickets_balance : 0,
            'xp_from_tokens' => $user->getXPFromTokens(),
            'xp_from_tips' => $user->getXPFromTips(),
            'xp_from_subscriptions' => $user->getXPFromSubscriptions(),
        ];
        
        
        $generalStats = [
            'tokens_balance' => $user->tokens ?? 0,
            'total_tips_sent' => $user->tipsSent()->count(),
            'total_tokens_spent' => $user->tipsSent()->sum('amount'),
            'active_subscriptions' => $user->subscriptionsAsFan()->where('status', 'active')->count(),
            'total_subscriptions' => $user->subscriptionsAsFan()->count(),
            'member_since' => $user->created_at->format('d/m/Y'),
            'days_active' => $user->created_at->diffInDays(now()),
        ];
        
        
        $levelHistory = collect([
            ['level' => 0, 'date' => $user->created_at, 'xp' => 0],
        ]); 
        
        
        $levelNumber = $currentLevel ? $currentLevel->level_number : 0;
        $unlockedBenefits = $this->getUnlockedBenefits($levelNumber);
        
        return view('fan.profile.index', compact(
            'user',
            'userProgress',
            'currentLevel',
            'nextLevel',
            'xpPercentage',
            'currentXP',
            'requiredXP',
            'gamificationStats',
            'generalStats',
            'levelHistory',
            'unlockedBenefits'
        ));
    }
    
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.access_denied')], 403);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'current_password' => 'required_with:new_password',
            'new_password' => 'sometimes|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.fan.invalid_profile_data'),
                'errors'  => $validator->errors()
            ], 400);
        }
        
        try {
            $updateData = [];
            
            
            if ($request->has('name')) {
                $updateData['name'] = $request->name;
            }
            
            
            if ($request->has('email')) {
                $updateData['email'] = $request->email;
            }
            
            
            if ($request->has('new_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return response()->json([
                        'success' => false,
                        'message' => __('admin.flash.fan.wrong_password')
                    ], 400);
                }
                
                $updateData['password'] = Hash::make($request->new_password);
            }
            
            
            if (!empty($updateData)) {
                $user->update($updateData);
            }
            
            return response()->json([
                'success' => true,
                'message' => __('admin.flash.fan.profile_updated')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.fan.profile_update_error')
            ], 500);
        }
    }
    
    
    private function getUnlockedBenefits($levelNumber)
    {
        $benefits = [];
        
        if ($levelNumber >= 1) {
            $benefits[] = ['icon' => 'fa-comments', 'name' => __('admin.flash.benefits.chat'),       'level' => 1];
        }
        if ($levelNumber >= 6) {
            $benefits[] = ['icon' => 'fa-percent',    'name' => __('admin.flash.benefits.cashback_5'), 'level' => 6];
        }
        if ($levelNumber >= 11) {
            $benefits[] = ['icon' => 'fa-user-secret','name' => __('admin.flash.benefits.invisible'),  'level' => 11];
        }
        if ($levelNumber >= 16) {
            $benefits[] = ['icon' => 'fa-crown',      'name' => __('admin.flash.benefits.vip'),        'level' => 16];
        }
        if ($levelNumber >= 21) {
            $benefits[] = ['icon' => 'fa-star',       'name' => __('admin.flash.benefits.elite'),      'level' => 21];
        }
        
        return $benefits;
    }
}
