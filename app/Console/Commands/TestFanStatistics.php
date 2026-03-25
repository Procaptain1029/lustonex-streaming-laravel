<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Tip;
use App\Models\Subscription;

class TestFanStatistics extends Command
{
    protected $signature = 'test:fan-statistics';
    protected $description = 'Test fan statistics and transaction history';

    public function handle()
    {
        $this->info('Testing fan statistics and transaction history...');
        
        // Get a fan
        $fan = User::where('role', 'fan')->first();
        
        if (!$fan) {
            $this->error('No fan found. Run the seeder first.');
            return;
        }
        
        $this->info("Testing statistics for fan: {$fan->name} (ID: {$fan->id})");
        $this->info("Current token balance: {$fan->tokens}");
        
        // Test tips statistics
        $tipsCount = $fan->tipsSent()->count();
        $tipsSum = $fan->tipsSent()->sum('amount');
        
        $this->info("Tips sent count: {$tipsCount}");
        $this->info("Tips total amount: {$tipsSum}");
        
        // Test subscriptions statistics
        $subscriptionsCount = $fan->subscriptionsAsFan()->where('status', 'active')->count();
        $subscriptionsSpent = $fan->subscriptionsAsFan()->sum('amount');
        
        $this->info("Active subscriptions: {$subscriptionsCount}");
        $this->info("Total spent on subscriptions: {$subscriptionsSpent}");
        
        // Show recent tips with details
        $this->info("\n--- Recent Tips ---");
        $recentTips = $fan->tipsSent()->with(['model', 'stream'])->latest()->take(5)->get();
        
        if ($recentTips->count() > 0) {
            foreach ($recentTips as $tip) {
                $modelName = $tip->model->name ?? 'Unknown';
                $streamTitle = $tip->stream->title ?? 'No stream';
                $this->info("- {$tip->amount} tokens to {$modelName} in '{$streamTitle}' ({$tip->created_at->diffForHumans()})");
                if ($tip->message) {
                    $this->info("  Message: \"{$tip->message}\"");
                }
            }
        } else {
            $this->info("No tips found.");
        }
        
        // Show recent subscriptions
        $this->info("\n--- Recent Subscriptions ---");
        $recentSubs = $fan->subscriptionsAsFan()->with(['model.profile'])->latest()->take(3)->get();
        
        if ($recentSubs->count() > 0) {
            foreach ($recentSubs as $sub) {
                $modelName = $sub->model->name ?? 'Unknown';
                $status = $sub->status;
                $amount = $sub->amount;
                $this->info("- Subscription to {$modelName}: \${$amount} ({$status}) - {$sub->created_at->diffForHumans()}");
            }
        } else {
            $this->info("No subscriptions found.");
        }
        
        // Test transaction history format
        $this->info("\n--- Transaction History Format ---");
        $tipTransactions = $fan->tipsSent()
            ->with(['model', 'stream'])
            ->latest()
            ->get()
            ->map(function($tip) {
                return (object) [
                    'id' => $tip->id,
                    'type' => 'tip',
                    'description' => 'Propina enviada a ' . ($tip->model->name ?? 'Usuario') . 
                                   ($tip->stream ? ' en stream "' . $tip->stream->title . '"' : ''),
                    'amount' => -$tip->amount,
                    'created_at' => $tip->created_at,
                    'status' => $tip->status,
                    'message' => $tip->message
                ];
            });
        
        $this->info("Formatted transactions count: {$tipTransactions->count()}");
        
        if ($tipTransactions->count() > 0) {
            $firstTransaction = $tipTransactions->first();
            $this->info("Example transaction:");
            $this->info("  Type: {$firstTransaction->type}");
            $this->info("  Description: {$firstTransaction->description}");
            $this->info("  Amount: {$firstTransaction->amount} tokens");
            $this->info("  Status: {$firstTransaction->status}");
            $this->info("  Date: {$firstTransaction->created_at->format('d/m/Y H:i')}");
        }
        
        $this->info("\nFan statistics test completed!");
    }
}
