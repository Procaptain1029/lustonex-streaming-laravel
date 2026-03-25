<?php

namespace App\Listeners;

use App\Events\NewTip;
use App\Events\NewSubscription;
use App\Events\TokensPurchased;
use App\Models\Setting;
use App\Services\GamificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GamificationListener
{
    protected $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    public function handle(object $event): void
    {
        if ($event instanceof \App\Events\UserAction) {
            $user = $event->user;
            $this->gamificationService->processMissionProgress(
                $user,
                $event->actionType,
                $event->value
            );
            $this->gamificationService->checkAchievements($user);
            $this->gamificationService->checkBadges($user);
            return;
        }

        if ($event instanceof NewTip) {
            $amount = $event->tip->amount;

            // Fan: XP configurable por tip enviado (ej. 10% del monto)
            $fan = $event->tip->fan;
            if ($fan) {
                $fanRatio = (int) Setting::get('gamification.xp.fan_tip_sent', 10);
                $fanXp    = (int) ceil($amount * $fanRatio / 10); // 10% base
                
                if ($fanXp > 0) {
                    $this->gamificationService->awardXp($fan, $fanXp);
                }
                
                $this->gamificationService->processMissionProgress($fan, 'tip_sent', $amount);
                $this->gamificationService->checkAchievements($fan);
                $this->gamificationService->checkBadges($fan);
            }

            // Modelo: XP configurable por tip recibido
            $model = $event->tip->model;
            if ($model) {
                $modelRatio = (int) Setting::get('gamification.xp.model_tip_received', 10);
                $modelXp    = (int) ceil($amount * $modelRatio / 100); // % convertido
                
                if ($modelXp > 0) {
                    $this->gamificationService->awardXp($model, $modelXp);
                }
                
                $this->gamificationService->processMissionProgress($model, 'tip_received', $amount);
                $this->gamificationService->checkAchievements($model);
                $this->gamificationService->checkBadges($model);
            }
        }

        if ($event instanceof NewSubscription) {
            // Fan: XP fijo configurable por suscripción
            $fan = $event->subscription->fan;
            if ($fan) {
                $fanXp = (int) Setting::get('gamification.xp.fan_subscription', 100);
                if ($fanXp > 0) {
                    $this->gamificationService->awardXp($fan, $fanXp);
                }
                $this->gamificationService->processMissionProgress($fan, 'subscription_purchased', 1);
                $this->gamificationService->checkAchievements($fan);
                $this->gamificationService->checkBadges($fan);
            }

            // Modelo: XP configurable por nuevo suscriptor
            $model = $event->subscription->model;
            if ($model) {
                $modelXp = (int) Setting::get('gamification.xp.model_new_subscriber', 50);
                if ($modelXp > 0) {
                    $this->gamificationService->awardXp($model, $modelXp);
                }
                $this->gamificationService->processMissionProgress($model, 'new_subscriber', 1);
                $this->gamificationService->checkAchievements($model);
                $this->gamificationService->checkBadges($model);
            }
        }

        if ($event instanceof TokensPurchased) {
            $user = $event->user;
            
            // Fan: XP por tokens comprados (ej. 10 base = 1:1)
            $ratio = (int) Setting::get('gamification.xp.fan_tokens_purchased', 10);
            $xp    = (int) ceil($event->tokens * $ratio / 10);
            
            if ($xp > 0) {
                $this->gamificationService->awardXp($user, $xp);
            }

            $this->gamificationService->processMissionProgress($user, 'first_purchase', 1);
            $this->gamificationService->processMissionProgress($user, 'buy_tokens_weekly', $event->tokens);
            $this->gamificationService->processMissionProgress($user, 'tokens_purchased', $event->tokens);
            $this->gamificationService->checkAchievements($user);
            $this->gamificationService->checkBadges($user);
        }

        if ($event instanceof \Illuminate\Auth\Events\Registered) {
            $user = $event->user;
            $this->gamificationService->initializeUser($user);
        }
    }
}
