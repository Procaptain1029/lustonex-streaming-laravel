<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->boolean('completed')->default(false)->after('status');
            $table->timestamp('completed_at')->nullable()->after('completed');
            $table->string('action_type')->nullable()->after('completed_at')->comment('tip, menu, roulette');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->dropColumn(['completed', 'completed_at', 'action_type']);
        });
    }
};
