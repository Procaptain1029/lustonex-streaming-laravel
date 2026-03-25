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
            // Información personal
            $table->string('country')->nullable()->after('bio');
            $table->json('languages')->nullable()->after('country'); // Array de idiomas
            $table->integer('age')->nullable()->after('languages');
            $table->string('interested_in')->nullable()->after('age'); // Todos, Hombres, Mujeres, etc.
            
            // Características físicas
            $table->string('body_type')->nullable()->after('interested_in'); // Delgado, Atlético, etc.
            $table->json('specific_details')->nullable()->after('body_type'); // Array de detalles específicos
            $table->string('ethnicity')->nullable()->after('specific_details'); // Blanca, Latina, etc.
            $table->string('hair_color')->nullable()->after('ethnicity'); // Moreno, Rubio, etc.
            $table->string('eye_color')->nullable()->after('hair_color'); // Color café, Azul, etc.
            
            // Estilo de vida
            $table->string('subculture')->nullable()->after('eye_color'); // Estudiante, Profesional, etc.
            $table->json('interests')->nullable()->after('subculture'); // Array de intereses sexuales
            
            // Redes sociales
            $table->json('social_networks')->nullable()->after('interests'); // Array de redes sociales
            
            // Configuración de perfil
            $table->boolean('profile_completed')->default(false)->after('social_networks');
            $table->timestamp('last_profile_update')->nullable()->after('profile_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'country',
                'languages',
                'age',
                'interested_in',
                'body_type',
                'specific_details',
                'ethnicity',
                'hair_color',
                'eye_color',
                'subculture',
                'interests',
                'social_networks',
                'profile_completed',
                'last_profile_update'
            ]);
        });
    }
};
