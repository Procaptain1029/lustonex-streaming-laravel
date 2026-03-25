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
            $table->string('legal_name')->nullable()->after('display_name');
            $table->date('date_of_birth')->nullable()->after('age');
            $table->string('id_document_selfie')->nullable()->after('id_document_back');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['legal_name', 'date_of_birth', 'id_document_selfie']);
        });
    }
};
