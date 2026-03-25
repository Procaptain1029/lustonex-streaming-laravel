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
        Schema::table('profiles', function (Blueprint $table) {
            $table->integer('chat_unlock_price')->default(500);
            $table->integer('chat_unlock_duration')->default(24); // en horas
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->timestamp('unlocked_until')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['chat_unlock_price', 'chat_unlock_duration']);
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn('unlocked_until');
        });
    }
};
