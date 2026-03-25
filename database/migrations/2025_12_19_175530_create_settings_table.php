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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            ['key' => 'site_name', 'value' => 'Lustonex', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_description', 'value' => 'Plataforma de streaming premium', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'maintenance_mode', 'value' => '0', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'registration_enabled', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'email_verification_required', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'min_withdrawal_amount', 'value' => '50', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'commission_rate', 'value' => '20', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'token_usd_rate', 'value' => '0.10', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'max_upload_size', 'value' => '100', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'stream_quality', 'value' => 'hd', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'notifications_enabled', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'email_notifications', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
