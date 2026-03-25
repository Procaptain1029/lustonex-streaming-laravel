<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Subscription;
use App\Notifications\NewSubscriberNotification;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return redirect()->route('home')->with('error', __('admin.flash.fan.access_denied'));
        }
        
        
        $activeSubscriptions = $user->subscriptionsAsFan()
            ->with(['model.profile'])
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->latest()
            ->get();
        
        
        $stats = [
            'active_count' => $activeSubscriptions->count(),
            'total_spent' => $user->subscriptionsAsFan()->sum('amount'),
            'this_month_spent' => $user->subscriptionsAsFan()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
        ];
        
        
        $xpFromSubscriptions = $user->getXPFromSubscriptions();
        $subscriptionDiscount = $user->getSubscriptionDiscount();
        $recommendedModels = $user->getRecommendedModels();
        $subscriptionMissions = $user->getActiveMissionsByType('subscription');
        $currentLevel = ($user->progress && $user->progress->currentLevel) ? $user->progress->currentLevel->level_number : 0;
        
        return view('fan.subscriptions.index', compact(
            'user',
            'activeSubscriptions',
            'stats',
            'xpFromSubscriptions',
            'subscriptionDiscount',
            'recommendedModels',
            'subscriptionMissions',
            'currentLevel'
        ));
    }
    
    
    public function subscribe(Request $request, User $model)
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.access_denied')], 403);
        }
        
        if (!$model->isModel()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.not_a_model')], 400);
        }
        
        
        $existingSubscription = $user->subscriptions()
            ->where('model_id', $model->id)
            ->where('status', 'active')
            ->first();
            
        if ($existingSubscription) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.already_subscribed')], 400);
        }
        
        try {
            DB::beginTransaction();

            $price = $model->profile->subscription_price ?? 19.99;

            if ($user->tokens < $price) {
                return response()->json(['success' => false, 'message' => __('admin.flash.fan.insufficient_tokens')], 400);
            }

            // Deduct tokens
            $user->decrement('tokens', $price);
            $model->increment('tokens', $price);

            $subscription = Subscription::create([
                'fan_id' => $user->id,
                'model_id' => $model->id,
                'amount' => $price,
                'status' => 'active',
                'started_at' => now(),
                'expires_at' => now()->addMonth(),
            ]);

            // Record Transactions
            \App\Models\TokenTransaction::create([
                'user_id'      => $user->id,
                'type'         => 'spent',
                'amount'       => $price,
                'description'  => __('admin.flash.fan.sub_tx_fan', ['name' => $model->name]),
                'balance_after'=> $user->fresh()->tokens,
            ]);

            \App\Models\TokenTransaction::create([
                'user_id'      => $model->id,
                'type'         => 'earned',
                'amount'       => $price,
                'description'  => __('admin.flash.fan.sub_tx_model', ['name' => $user->name]),
                'balance_after'=> $model->fresh()->tokens,
            ]);

            DB::commit();
            
            // Notify both parties
            $user->notify(new NewSubscriberNotification($user, $model, 'fan'));
            $model->notify(new NewSubscriberNotification($user, $model, 'model'));

            event(new \App\Events\NewSubscription($subscription));
            
            return response()->json([
                'success'      => true,
                'message'      => __('admin.flash.fan.subscription_success'),
                'subscription' => $subscription
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.fan.subscription_error')
            ], 500);
        }
    }
    
    
    public function cancel(Subscription $subscription)
    {
        $user = Auth::user();
        
        if (!$user->isFan() || $subscription->fan_id !== $user->id) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.access_denied')], 403);
        }
        
        try {
            $subscription->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => __('admin.flash.fan.subscription_cancelled')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.fan.subscription_cancel_error')
            ], 500);
        }
    }
}
