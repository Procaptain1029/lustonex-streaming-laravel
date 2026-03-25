<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Stream;
use App\Models\Tip;

class TestTokenDeduction extends Command
{
    protected $signature = 'test:token-deduction';
    protected $description = 'Test token deduction when sending tips';

    public function handle()
    {
        $this->info('Testing token deduction functionality...');
        
        // Get a fan and a model with stream
        $fan = User::where('role', 'fan')->first();
        $model = User::where('role', 'model')->first();
        
        if (!$fan || !$model) {
            $this->error('No fan or model found. Run the seeder first.');
            return;
        }
        
        // Create a test stream
        $stream = Stream::firstOrCreate([
            'user_id' => $model->id,
            'title' => 'Test Stream',
            'status' => 'live'
        ]);
        
        $this->info("Fan: {$fan->name} (ID: {$fan->id})");
        $this->info("Model: {$model->name} (ID: {$model->id})");
        $this->info("Stream: {$stream->title} (ID: {$stream->id})");
        
        // Check initial token balance
        $initialBalance = $fan->tokens;
        $this->info("Initial token balance: {$initialBalance}");
        
        if ($initialBalance < 10) {
            $this->info("Adding tokens to fan for testing...");
            $fan->update(['tokens' => 100]);
            $initialBalance = 100;
            $this->info("Updated token balance: {$initialBalance}");
        }
        
        // Test tip amount
        $tipAmount = 25;
        
        $this->info("Sending tip of {$tipAmount} tokens...");
        
        try {
            \DB::beginTransaction();
            
            // Simulate the tip creation process
            $fan->decrement('tokens', $tipAmount);
            
            $tip = Tip::create([
                'fan_id' => $fan->id,
                'model_id' => $model->id,
                'stream_id' => $stream->id,
                'amount' => $tipAmount,
                'message' => 'Test tip from command',
                'status' => 'completed',
            ]);
            
            \DB::commit();
            
            // Check new balance
            $newBalance = $fan->fresh()->tokens;
            $expectedBalance = $initialBalance - $tipAmount;
            
            $this->info("Tip created successfully (ID: {$tip->id})");
            $this->info("Previous balance: {$initialBalance}");
            $this->info("Tip amount: {$tipAmount}");
            $this->info("Expected balance: {$expectedBalance}");
            $this->info("Actual balance: {$newBalance}");
            
            if ($newBalance == $expectedBalance) {
                $this->info("✅ Token deduction working correctly!");
            } else {
                $this->error("❌ Token deduction failed!");
            }
            
        } catch (\Exception $e) {
            \DB::rollback();
            $this->error("Error: " . $e->getMessage());
        }
        
        $this->info('Token deduction test completed!');
    }
}
