<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileStatusController extends Controller
{
    public function show(User $model)
    {
        if (!$model->isModel()) {
            return response()->json(['error' => 'Model not found'], 404);
        }

        $model->load('profile');

        $hasLiveOrPaused = $model->streams()->whereIn('status', ['live', 'paused'])->exists();

        return response()->json([
            'is_streaming' => ($model->profile && $model->profile->is_streaming) || $hasLiveOrPaused,
            'is_online' => $model->profile ? $model->profile->is_online : false,
            'last_seen' => $model->profile ? $model->profile->last_seen : null,
            'active_stream' => $hasLiveOrPaused,
        ]);
    }
}
