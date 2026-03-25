<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Achievements table
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon');
            $table->enum('rarity', ['common', 'rare', 'epic', 'legendary'])->default('common');
            $table->enum('category', ['content', 'earnings', 'popularity', 'special'])->default('content');
            $table->enum('role', ['fan', 'model', 'both'])->default('both');
            $table->json('requirements'); // Condiciones para desbloquear
            $table->integer('xp_reward')->default(0);
            $table->integer('ticket_reward')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // User Achievements pivot table
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('achievement_id')->constrained()->onDelete('cascade');
            $table->timestamp('unlocked_at');
            $table->timestamps();
            
            $table->unique(['user_id', 'achievement_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('achievements');
    }
};
