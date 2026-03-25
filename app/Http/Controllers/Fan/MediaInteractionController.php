<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Video;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaInteractionController extends Controller
{
    
    public function toggleLike($type, $id)
    {
        $user = Auth::user();
        
        $modelClass = $this->getModelClass($type);
        if (!$modelClass) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.invalid_content_type')], 400);
        }

        $media = $modelClass::findOrFail($id);
        
        $like = Like::where('user_id', $user->id)
            ->where('likeable_id', $media->id)
            ->where('likeable_type', $modelClass)
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'likeable_id' => $media->id,
                'likeable_type' => $modelClass,
            ]);
            $liked = true;
            
            
            app(\App\Services\GamificationService::class)->processMissionProgress($user, 'like_content', 1);
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $media->likes()->count()
        ]);
    }

    
    private function getModelClass($type)
    {
        return match ($type) {
            'photo' => Photo::class,
            'video' => Video::class,
            default => null,
        };
    }
}
