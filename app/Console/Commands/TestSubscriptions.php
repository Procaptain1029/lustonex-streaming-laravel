<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Subscription;

class TestSubscriptions extends Command
{
    protected $signature = 'test:subscriptions';
    protected $description = 'Test subscription functionality';

    public function handle()
    {
        $this->info('Testing subscription functionality...');
        
        // Get a fan and a model
        $fan = User::where('role', 'fan')->first();
        $model = User::where('role', 'model')->first();
        
        if (!$fan || !$model) {
            $this->error('No fan or model found. Run the seeder first.');
            return;
        }
        
        $this->info("Fan: {$fan->name} (ID: {$fan->id})");
        $this->info("Model: {$model->name} (ID: {$model->id})");
        
        // Check if fan already has subscription
        $existingSubscription = $fan->hasActiveSubscriptionTo($model->id);
        $this->info("Has existing subscription: " . ($existingSubscription ? 'Yes' : 'No'));
        
        if (!$existingSubscription) {
            // Create a test subscription
            $subscription = $fan->subscriptionsAsFan()->create([
                'model_id' => $model->id,
                'status' => 'active',
                'starts_at' => now(),
                'expires_at' => now()->addMonth(),
                'amount' => $model->profile->subscription_price ?? 19.99,
                'payment_method' => 'test',
            ]);
            
            $this->info("Created subscription ID: {$subscription->id}");
        }
        
        // Test the relationship
        $subscriptions = $fan->subscriptionsAsFan()->with('model')->get();
        $this->info("Fan has {$subscriptions->count()} total subscriptions");
        
        foreach ($subscriptions as $sub) {
            $this->info("- Subscription to {$sub->model->name}, Status: {$sub->status}, Expires: {$sub->expires_at}");
        }
        
        // Test the hasActiveSubscriptionTo method
        $hasActive = $fan->hasActiveSubscriptionTo($model->id);
        $this->info("Has active subscription to {$model->name}: " . ($hasActive ? 'Yes' : 'No'));
        
        $this->info('Subscription test completed!');
    }
}
