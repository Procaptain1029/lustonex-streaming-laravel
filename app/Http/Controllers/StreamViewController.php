<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use App\Models\ChatMessage;
use App\Models\Tip;
use App\Models\TokenTransaction;
use App\Events\NewChatMessage;
use App\Events\NewTip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StreamViewController extends Controller
{
    public function show(Stream $stream)
    {
        if ($stream->status !== 'live') {
            return redirect()->back()->with('error', __('admin.flash.stream_view.not_active'));
        }

        $model = $stream->user;
        
        
        $hasAccess = auth()->check() && (
            auth()->id() === $model->id ||
            auth()->user()->isAdmin() ||
            auth()->user()->hasActiveSubscriptionTo($model->id)
        );

        if (!$hasAccess) {
            return redirect()->route('profiles.show', $model)
                ->with('error', __('admin.flash.stream_view.subscribe_required'));
        }

        
        $stream->incrementViewers();

        $chatMessages = $stream->chatMessages()
            ->visible()
            ->with('user')
            ->latest()
            ->take(50)
            ->get()
            ->reverse()
            ->values();

        return view('streams.show', compact('stream', 'chatMessages'));
    }

    public function sendMessage(Request $request, Stream $stream)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $message = $stream->chatMessages()->create([
            'user_id' => auth()->id(),
            'model_id' => $stream->user_id,
            'message' => $validated['message'],
        ]);

        $message->load('user');

        
        event(new NewChatMessage($message));

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function sendTip(Request $request, Stream $stream)
{
    $validated = $request->validate([
        'amount' => 'required|numeric|min:1',
        'message' => 'nullable|string|max:500',
    ]);

    $fan = auth()->user();
    $amount = (int) $validated['amount'];

    
    if ($fan->tokens < $amount) {
        return response()->json([
            'success' => false,
            'message' => __('admin.flash.stream_view.insufficient_tokens', ['count' => $fan->tokens])
        ], 400);
    }

    try {
        \DB::beginTransaction();

        
        $fan->decrement('tokens', $amount);

        
        $model = $stream->user;

        
        $model->increment('tokens', $amount);

        
        $tip = Tip::create([
            'fan_id'    => $fan->id,
            'model_id'  => $model->id,
            'stream_id' => $stream->id,
            'amount'    => $amount,
            'message'   => $validated['message'] ?? null,
            'status'    => 'completed',
        ]);

        $tip->load('fan', 'model');

        
        TokenTransaction::create([
            'user_id' => $fan->id,
            'type' => 'spent',
            'amount' => $amount,
            'description' => __('admin.flash.stream_view.tx_tip_fan', ['title' => $stream->title, 'name' => $model->name]),
            'balance_after' => $fan->fresh()->tokens,
        ]);

        TokenTransaction::create([
            'user_id' => $model->id,
            'type' => 'earned',
            'amount' => $amount,
            'description' => __('admin.flash.stream_view.tx_tip_model', ['title' => $stream->title, 'name' => $fan->name]),
            'balance_after' => $model->fresh()->tokens,
        ]);

        \DB::commit();

        
        event(new NewTip($tip));

        return response()->json([
            'success' => true,
            'tip' => $tip,
            'new_balance' => $fan->fresh()->tokens,
            'model_balance' => $model->fresh()->tokens
        ]);

    } catch (\Exception $e) {
        \DB::rollBack();
        \Log::error('Error sending tip: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => __('admin.flash.stream_view.tip_error')
        ], 500);
    }
}


    public function hideMessage(Request $request, ChatMessage $message)
    {
        
        if (auth()->id() !== $message->stream->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $message->update(['is_hidden' => true]);

        return response()->json(['success' => true]);
    }
}
