<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FavoriteController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return redirect()->route('home')->with('error', __('admin.flash.fan.access_denied'));
        }
        
        $favorites = $user->favorites()
            ->with('profile')
            ->get();
        
        
        $stats = [
            'total_favorites' => $favorites->count(),
            'online_now' => $favorites->where('profile.is_streaming', true)->count(),
            'new_content' => 0, 
        ];
        
        return view('fan.favorites.index', compact('user', 'favorites', 'stats'));
    }
    
    
    public function toggle(Request $request, User $model)
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.access_denied')], 403);
        }
        
        if (!$model->isModel()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.not_a_model')], 400);
        }
        
        try {
            $isFavorite = $user->toggleFavorite($model->id);
            
            if ($isFavorite) {
                $model->notify(new \App\Notifications\NewFollowerNotification($user));
            }
            
            return response()->json([
                'success'     => true,
                'is_favorite' => $isFavorite,
                'message'     => $isFavorite ? __('admin.flash.fan.favorite_added') : __('admin.flash.fan.favorite_removed')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.fan.favorite_error')
            ], 500);
        }
    }
}
