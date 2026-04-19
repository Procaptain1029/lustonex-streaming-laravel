<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stream;
use App\Models\Tip;
use App\Models\TokenTransaction;
use App\Models\ProfileView;
use App\Services\GamificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Notifications\ChatUnlockedNotification;
use App\Notifications\NewSubscriberNotification;
use App\Notifications\TipReceivedNotification;

class ProfilePublicController extends Controller
{
    public function show(User $model, Request $request)
    {
        if (!$model->isModel()) {
            abort(404);
        }

        $model->load('profile');
        $model->loadCount('favoritedBy');


        if ($model->profile && !$request->ajax()) {
            ProfileView::track($model->profile->id);
        }

        $hasSubscription = auth()->check() && auth()->user()->hasActiveSubscriptionTo($model->id);
        $isOwner = auth()->check() && auth()->id() === $model->id;
        $canViewContent = $isOwner || $hasSubscription || (auth()->check() && auth()->user()->isAdmin());


        $photos = $model->photos()
            ->approved()
            ->inRandomOrder()
            ->paginate(20);


        if ($request->ajax()) {
            return response()->json([
                'photos' => $photos->items(),
                'next_page_url' => $photos->nextPageUrl(),
                'current_page' => $photos->currentPage(),
                'last_page' => $photos->lastPage(),
                'canViewContent' => $canViewContent
            ]);
        }

        $videos = $model->videos()
            ->approved()
            ->latest()
            ->paginate(12);

        $activeStream = $model->streams()
            ->whereIn('status', ['live', 'paused'])
            ->orderByRaw("CASE WHEN status = 'live' THEN 0 ELSE 1 END")
            ->orderByDesc('started_at')
            ->orderByDesc('id')
            ->first();

        $fanLivePlayback = $activeStream && in_array($activeStream->status, ['live', 'paused'], true);

        $relatedModels = User::where('role', 'model')
            ->whereHas('profile', function ($query) {
                $query->where('profile_completed', true);
            })
            ->with('profile')
            ->orderBy('created_at', 'desc')
            ->paginate(20);


        $privateConversation = null;
        if (auth()->check()) {
            $privateConversation = Conversation::where('type', 'private')
                ->whereHas('participants', function ($q) use ($model) {
                    $q->where('user_id', $model->id);
                })
                ->whereHas('participants', function ($q) {
                    $q->where('user_id', auth()->id());
                })
                ->first();
        }
        
        $isPrivateChatUnlocked = false;
        $privateConversationId = null;

        if ($privateConversation) {
            $isPrivateChatUnlocked = $privateConversation->is_unlocked && 
                                     (!$privateConversation->unlocked_until || $privateConversation->unlocked_until->isFuture());
            $privateConversationId = $privateConversation->id;
            
            // Si estaba marcado como desbloqueado pero ya expiró, actualizarlo en BD (opcional pero recomendado)
            if ($privateConversation->is_unlocked && $privateConversation->unlocked_until && $privateConversation->unlocked_until->isPast()) {
                $privateConversation->update(['is_unlocked' => false]);
                $isPrivateChatUnlocked = false;
            }
        }

        $unlockedUntil = $privateConversation ? $privateConversation->unlocked_until : null;

        $unlockedUntil = $privateConversation ? $privateConversation->unlocked_until : null;

        // Basic Mobile Detection via User-Agent
        $userAgent = $request->header('User-Agent');
        $isMobile = preg_match('/Mobile|Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i', $userAgent) || $request->has('mobile');

        // Debugging (Remove after verification)
        // if ($model->id == 503) { dd(['isMobile' => $isMobile, 'UA' => $userAgent, 'hasMobileParam' => $request->has('mobile')]); }

        $isStreaming = ($model->profile && $model->profile->is_streaming) || $fanLivePlayback;
        $viewName = ($isMobile && $isStreaming) ? 'profiles.show-mobile' : 'profiles.show';

        // Fetch token packages for quick recharge
        $tokenPackages = \App\Models\TokenPackage::where('is_active', true)
            ->where(function ($query) {
                $query->where('is_limited_time', false)
                      ->orWhere('expires_at', '>', now());
            })
            ->orderBy('price')
            ->get();

        return view($viewName, compact(
            'model',
            'photos',
            'videos',
            'hasSubscription',
            'activeStream',
            'fanLivePlayback',
            'relatedModels',
            'canViewContent',
            'isOwner',
            'isPrivateChatUnlocked',
            'privateConversationId',
            'unlockedUntil',
            'tokenPackages'
        ));
    }

    public function subscribe(Request $request, User $model)
    {
        if (!auth()->check()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.login_required')], 401);
            }
            return redirect()->route('login')->with('error', __('admin.flash.profile_public.login_required'));
        }

        if (!$model->isModel()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.model_not_found')], 404);
            }
            abort(404, __('admin.flash.profile_public.model_not_found'));
        }

        $fan = auth()->user();
        $tier = $request->input('tier', 'Fan');

        $multipliers = [
            'Fan' => 1,
            'VIP' => 5,
            'MVP' => 15
        ];

        if (!isset($multipliers[$tier])) {
            $tier = 'Fan';
        }

        if (!$fan->isFan()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.fans_only')], 403);
            }
            return back()->with('error', __('admin.flash.profile_public.fans_only'));
        }

        if ($fan->id === $model->id) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.no_self_subscribe')], 400);
            }
            return back()->with('error', __('admin.flash.profile_public.no_self_subscribe'));
        }

        $existing = $fan->subscriptionsAsFan()
            ->where('model_id', $model->id)
            ->where('status', 'active')
            ->first();

        if ($existing && $existing->tier === $tier) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.already_subscribed', ['tier' => $tier])], 400);
            }
            return back()->with('info', __('admin.flash.profile_public.already_subscribed', ['tier' => $tier]));
        }

        $basePrice = $model->profile->subscription_price ?? 19.99;
        $subscriptionPrice = (float) $basePrice * $multipliers[$tier];

        if ($fan->tokens < $subscriptionPrice) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.insufficient_tokens')], 400);
            }
            return back()->with('error', __('admin.flash.profile_public.insufficient_tokens'));
        }

        try {

            \DB::beginTransaction();

            if ($existing) {
                $existing->update([
                    'status' => 'active',
                    'starts_at' => now(),
                    'expires_at' => now()->addMonth(),
                    'amount' => $subscriptionPrice,
                    'tier' => $tier,
                    'payment_method' => 'tokens',
                ]);
                $subscription = $existing;
            } else {
                $subscription = $fan->subscriptionsAsFan()->create([
                    'model_id' => $model->id,
                    'status' => 'active',
                    'starts_at' => now(),
                    'expires_at' => now()->addMonth(),
                    'amount' => $subscriptionPrice,
                    'tier' => $tier,
                    'payment_method' => 'tokens',
                ]);
            }

            $fan->decrement('tokens', $subscriptionPrice);
            $model->increment('tokens', $subscriptionPrice);

            TokenTransaction::create([
                'user_id' => $fan->id,
                'type' => 'spent',
                'amount' => $subscriptionPrice,
                'description' => __('admin.flash.profile_public.tx_subscribe_fan', ['tier' => $tier, 'name' => $model->name]),
                'balance_after' => $fan->fresh()->tokens,
            ]);

            TokenTransaction::create([
                'user_id' => $model->id,
                'type' => 'earned',
                'amount' => $subscriptionPrice,
                'description' => __('admin.flash.profile_public.tx_subscribe_model', ['tier' => $tier, 'name' => $fan->name]),
                'balance_after' => $model->fresh()->tokens,
            ]);

            $gamification = new \App\Services\GamificationService();
            $gamification->processMissionProgress($fan, 'subscribe_model');

            \DB::commit();

            // Notify both parties
            $fan->notify(new NewSubscriberNotification($fan, $model, 'fan'));
            $model->notify(new NewSubscriberNotification($fan, $model, 'model'));

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true, 
                'message' => __('admin.flash.profile_public.subscribe_success', ['tier' => $tier, 'amount' => $subscriptionPrice, 'name' => $model->name]),
                    'new_balance' => $fan->fresh()->tokens
                ]);
            }

            return back()->with('success', __('admin.flash.profile_public.subscribe_success', ['tier' => $tier, 'amount' => $subscriptionPrice, 'name' => $model->name]));

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error en suscripción: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.subscribe_error')], 500);
            }
            
            return back()->with('error', __('admin.flash.profile_public.subscribe_error'));
        }
    }

    public function sendTip(Request $request, User $model)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.login_required_short')], 401);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string|max:500',
            'is_menu_item' => 'nullable|boolean'
        ]);

        $fan = auth()->user();
        $amount = (int) $validated['amount'];
        $isMenuItem = (bool) ($validated['is_menu_item'] ?? false);

        if ($fan->tokens < $amount) {
            return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.insufficient_tokens_short')], 400);
        }

        try {
            DB::beginTransaction();

            $fan->decrement('tokens', $amount);
            $model->increment('tokens', $amount);


            $activeStream = $model->streams()->where('status', 'live')->first();

            $tip = Tip::create([
                'fan_id' => $fan->id,
                'model_id' => $model->id,
                'stream_id' => $activeStream?->id,
                'amount' => $amount,
                'message' => $validated['message'] ?? null,
                'status' => 'completed',
                'action_type' => $isMenuItem ? 'menu' : 'tip',
                'completed' => $isMenuItem ? false : true,
            ]);


            TokenTransaction::create([
                'user_id' => $fan->id,
                'type' => 'spent',
                'amount' => $amount,
                'description' => __('admin.flash.profile_public.tx_tip_fan', [
                    'name' => $model->name,
                    'menu' => $isMenuItem ? __('admin.flash.profile_public.tx_tip_menu_suffix') : '',
                ]),
                'balance_after' => $fan->fresh()->tokens,
            ]);

            TokenTransaction::create([
                'user_id' => $model->id,
                'type' => 'earned',
                'amount' => $amount,
                'description' => __('admin.flash.profile_public.tx_tip_model', [
                    'name' => $fan->name,
                    'action' => $isMenuItem ? __('admin.flash.profile_public.tx_tip_action_suffix') : '',
                ]),
                'balance_after' => $model->fresh()->tokens,
            ]);


            $gamification = new GamificationService();
            $gamification->awardXp($fan, $amount * 10);


            $gamification->processMissionProgress($fan, 'tip_sent', $amount);


            if ($model->isNew()) {
                $gamification->processMissionProgress($fan, 'tip_new_model', $amount);
                $gamification->processMissionProgress($fan, 'tip_new_model_weekly', $amount);
            }


            if ($model->isVIP()) {
                $gamification->processMissionProgress($fan, 'tip_vip_model', $amount);
            }


            if ($isMenuItem) {
                $gamification->processMissionProgress($fan, 'tip_menu_item', 1);
            }

            DB::commit();

            // Notify model
            $model->notify(new TipReceivedNotification($tip, $fan));

            return response()->json([
                'success' => true,
                'message' => __('admin.flash.profile_public.tip_success'),
                'new_balance' => $fan->fresh()->tokens
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en propina: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.tip_error')], 500);
        }
    }

    public function spinRoulette(Request $request, User $model)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.login_required_short')], 401);
        }

        $fan = auth()->user();
        $cost = 33;

        if ($fan->tokens < $cost) {
            return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.insufficient_tokens_short')], 400);
        }

        $options = [
            'Mandar un Beso',
            'Mostrar Pies',
            'Baile Corto',
            'Saludo Personalizado',
            'Mostrar Outfit',
            'Guiño a Cámara',
            'Corazón con Manos',
            'Mensaje de Voz'
        ];

        try {
            DB::beginTransaction();

            $fan->decrement('tokens', $cost);
            $model->increment('tokens', $cost);


            $resultIndex = array_rand($options);
            $result = $options[$resultIndex];


            TokenTransaction::create([
                'user_id' => $fan->id,
                'type' => 'spent',
                'amount' => $cost,
                'description' => __('admin.flash.profile_public.tx_roulette_fan', ['name' => $model->name]),
                'balance_after' => $fan->fresh()->tokens,
            ]);

            TokenTransaction::create([
                'user_id' => $model->id,
                'type' => 'earned',
                'amount' => $cost,
                'description' => __('admin.flash.profile_public.tx_roulette_model', ['name' => $fan->name]),
                'balance_after' => $model->fresh()->tokens,
            ]);





            $activeStream = $model->streams()->where('status', 'live')->first();

            Tip::create([
                'fan_id' => $fan->id,
                'model_id' => $model->id,
                'stream_id' => $activeStream?->id,
                'amount' => $cost,
                'message' => "Gira Ruleta: {$result}",
                'status' => 'completed',
                'action_type' => 'roulette',
                'completed' => false,
            ]);


            $gamification = new GamificationService();
            $gamification->awardXp($fan, 300);


            $gamification->processMissionProgress($fan, 'spin_roulette', 1);
            $gamification->processMissionProgress($fan, 'spin_roulette_weekly', 1);


            if ($model->isNew()) {
                $gamification->processMissionProgress($fan, 'tip_new_model', $cost);
                $gamification->processMissionProgress($fan, 'tip_new_model_weekly', $cost);
            }
            if ($model->isVIP()) {
                $gamification->processMissionProgress($fan, 'tip_vip_model', $cost);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'result' => $result,
                'result_index' => $resultIndex,
                'options' => $options,
                'message' => __('admin.flash.profile_public.roulette_success'),
                'new_balance' => $fan->fresh()->tokens
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en ruleta: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.roulette_error')], 500);
        }
    }

    public function getChatHistory(User $model)
    {
        $activeStream = $model->streams()->where('status', 'live')->latest()->first();

        $messagesQuery = ChatMessage::query()
            ->where('model_id', $model->id)
            ->with(['user.profile', 'user.progress.currentLevel'])
            ->latest()
            ->limit(50);

        if ($activeStream) {
            $messagesQuery->where('stream_id', $activeStream->id);
        } else {
            // Si no está en vivo, restringir al último stream para evitar mezclar historia global
            $latestStream = $model->streams()->latest()->first();
            if ($latestStream) {
                $messagesQuery->where('stream_id', $latestStream->id);
            }
        }

        $messages = $messagesQuery->get();

        $tipsQuery = Tip::where('model_id', $model->id)
            ->where('status', 'completed')
            ->with(['fan.profile', 'fan.progress.currentLevel'])
            ->latest()
            ->limit(50);

        if ($activeStream) {
            $tipsQuery->where('stream_id', $activeStream->id);
        } else {
            $latestStream = $model->streams()->latest()->first();
            if ($latestStream) {
                $tipsQuery->where('stream_id', $latestStream->id);
            }
        }

        $tips = $tipsQuery->get();


        $history = collect();

        foreach ($messages as $msg) {
            $history->push([
                'type' => 'message',
                'id' => 'msg_' . $msg->id,
                'user' => $msg->user,
                'content' => $msg->message,
                'amount' => 0,
                'created_at' => $msg->created_at,
                'timestamp' => $msg->created_at->isoFormat('h:mm A'),
                'is_roulette' => false,
                'is_pinned' => $msg->is_pinned
            ]);
        }

        foreach ($tips as $tip) {


            $isRoulette = str_starts_with($tip->message ?? '', 'Gira Ruleta:');

            $history->push([
                'type' => $isRoulette ? 'roulette' : 'tip',
                'id' => 'tip_' . $tip->id,
                'user' => $tip->fan,
                'content' => $tip->message,
                'amount' => $tip->amount,
                'created_at' => $tip->created_at,
                'timestamp' => $tip->created_at->isoFormat('h:mm A'),
                'is_roulette' => $isRoulette
            ]);
        }

        $sortedHistory = $history->sortBy('created_at')->values();

        return response()->json([
            'success' => true,
            'history' => $sortedHistory
        ]);
    }

    public function sendPublicMessage(Request $request, User $model)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        if (!$user->isFan()) {

            if ($user->id !== $model->id) {
                return response()->json(['error' => __('admin.flash.profile_public.chat_fans_only')], 403);
            }
        }

        $request->validate([
            'message' => 'required|string|max:255',
        ]);



        $stream = $model->streams()->latest()->first();

        $msg = ChatMessage::create([
            'stream_id' => $stream ? $stream->id : null,
            'model_id' => $model->id,
            'user_id' => $user->id,
            'message' => $request->message,
            'is_hidden' => false
        ]);


        $msg->load('user.profile', 'user.progress.currentLevel');

        return response()->json([
            'success' => true,
            'data' => [
                'type' => 'message',
                'id' => 'msg_' . $msg->id,
                'user' => $msg->user,
                'content' => $msg->message,
                'amount' => 0,
                'timestamp' => $msg->created_at->isoFormat('h:mm A'),
                'is_pinned' => false
            ]
        ]);
    }

    public function unlockPrivateChat(Request $request, User $model)
    {
        if (!auth()->check())
            return response()->json(['error' => 'Auth required'], 401);

        $fan = auth()->user();
        
        // Get model settings for chat
        $modelProfile = $model->profile;
        $cost = $modelProfile->chat_unlock_price ?? 500;
        $durationHours = $modelProfile->chat_unlock_duration ?? 24;

        if ($fan->tokens < $cost) {
            return response()->json(['success' => false, 'message' => __('admin.flash.profile_public.chat_insufficient_tokens')], 400);
        }

        try {
            DB::beginTransaction();

            $fan->decrement('tokens', $cost);
            $model->increment('tokens', $cost);

            // Calculate expiration
            $unlockedUntil = now()->addHours($durationHours);

            $conversation = Conversation::whereHas('participants', function ($q) use ($fan) {
                $q->where('user_id', $fan->id);
            })
                ->whereHas('participants', function ($q) use ($model) {
                    $q->where('user_id', $model->id);
                })
                ->where('type', 'private')
                ->first();

            if (!$conversation) {
                $conversation = Conversation::create([
                    'type' => 'private',
                    'last_message_at' => now(),
                    'is_unlocked' => true,
                    'unlocked_until' => $unlockedUntil
                ]);
                $conversation->participants()->createMany([
                    ['user_id' => $fan->id],
                    ['user_id' => $model->id],
                ]);
            } else {
                $conversation->update([
                    'is_unlocked' => true,
                    'unlocked_until' => $unlockedUntil
                ]);
            }


            TokenTransaction::create([
                'user_id' => $fan->id,
                'type' => 'spent',
                'amount' => $cost,
                'description' => __('admin.flash.profile_public.tx_chat_fan', ['name' => $model->name, 'hours' => $durationHours]),
                'balance_after' => $fan->fresh()->tokens,
            ]);

            TokenTransaction::create([
                'user_id' => $model->id,
                'type' => 'earned',
                'amount' => $cost,
                'description' => __('admin.flash.profile_public.tx_chat_model', ['name' => $fan->name, 'hours' => $durationHours]),
                'balance_after' => $model->fresh()->tokens,
            ]);

            DB::commit();

            // Notify both parties
            $fan->notify(new ChatUnlockedNotification($conversation, $model, 'fan'));
            $model->notify(new ChatUnlockedNotification($conversation, $fan, 'model'));

            return response()->json([
                'success' => true, 
                'conversation_id' => $conversation->id,
                'expires_at' => $unlockedUntil->toIso8601String()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
