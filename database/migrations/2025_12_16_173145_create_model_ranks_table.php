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
        Schema::create('model_ranks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('score', 12, 4)->default(0);
            $table->string('period_type'); // 'DAILY', 'WEEKLY', 'MONTHLY', 'YEARLY'
            $table->date('period_date');
            $table->integer('rank_position')->nullable();
            $table->string('badge_type')->nullable(); // 'top_daily', 'top_weekly', 'top_monthly', 'top_yearly'
            $table->timestamps();
            
            $table->index(['period_type', 'period_date', 'score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_ranks');
    }
};
