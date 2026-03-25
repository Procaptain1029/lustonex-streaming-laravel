<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->unsignedBigInteger('achievement_id')->nullable()->after('level_id');
            $table->foreign('achievement_id')
                  ->references('id')->on('achievements')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->dropForeign(['achievement_id']);
            $table->dropColumn('achievement_id');
        });
    }
};
