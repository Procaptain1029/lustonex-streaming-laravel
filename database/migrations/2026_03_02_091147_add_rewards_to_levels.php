<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('levels', function (Blueprint $table) {
            // IDs de logros (achievements) que se otorgan al alcanzar este nivel
            $table->json('achievement_ids')->nullable()->after('image');
            // IDs de insignias (special_badges) que se otorgan al alcanzar este nivel
            $table->json('badge_ids')->nullable()->after('achievement_ids');
        });
    }

    public function down(): void
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->dropColumn(['achievement_ids', 'badge_ids']);
        });
    }
};
