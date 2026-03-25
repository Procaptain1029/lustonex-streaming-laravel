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
            // Estados del perfil: pending, under_review, approved, rejected
            $table->enum('verification_status', ['pending', 'under_review', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('profile_completed');
            
            // Documentos de identificación
            $table->string('id_document_front')->nullable()->after('verification_status');
            $table->string('id_document_back')->nullable()->after('id_document_front');
            $table->string('id_document_type')->nullable()->after('id_document_back'); // cedula, pasaporte, etc
            
            // Campos de verificación del admin
            $table->text('admin_notes')->nullable()->after('id_document_type');
            $table->text('rejection_reason')->nullable()->after('admin_notes');
            $table->timestamp('verified_at')->nullable()->after('rejection_reason');
            $table->foreignId('verified_by')->nullable()->constrained('users')->after('verified_at');
            
            // Control de pasos del onboarding
            $table->boolean('step1_completed')->default(false)->after('verified_by'); // Perfil y fotos
            $table->boolean('step2_completed')->default(false)->after('step1_completed'); // Documentos
            $table->boolean('step3_completed')->default(false)->after('step2_completed'); // Envío final
            $table->timestamp('onboarding_completed_at')->nullable()->after('step3_completed');
            
            // Campos adicionales para el proceso
            $table->boolean('terms_accepted')->default(false)->after('onboarding_completed_at');
            $table->boolean('age_verified')->default(false)->after('terms_accepted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'verification_status',
                'id_document_front',
                'id_document_back', 
                'id_document_type',
                'admin_notes',
                'rejection_reason',
                'verified_at',
                'verified_by',
                'step1_completed',
                'step2_completed', 
                'step3_completed',
                'onboarding_completed_at',
                'terms_accepted',
                'age_verified'
            ]);
        });
    }
};
