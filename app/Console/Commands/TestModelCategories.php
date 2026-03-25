<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestModelCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:model-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test model categories queries';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Probando consultas de categorías de modelos...');
        
        // Modelos Nuevas
        $nuevasModelos = User::where('role', 'model')
            ->whereHas('profile', function($query) {
                $query->where('profile_completed', true);
            })
            ->with('profile')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $this->info("✨ Modelos Nuevas: {$nuevasModelos->count()} encontradas");
        
        // Modelos Nivel Alto
        $nivelAltoModelos = User::where('role', 'model')
            ->whereHas('profile', function($query) {
                $query->where('profile_completed', true)
                      ->where('subscription_price', '>=', 25);
            })
            ->with('profile')
            ->orderBy('profiles.subscription_price', 'desc')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.*')
            ->limit(10)
            ->get();

        $this->info("💎 Modelos Nivel Alto: {$nivelAltoModelos->count()} encontradas");

        // Modelos VIP Popular
        $vipPopularModelos = User::where('role', 'model')
            ->whereHas('profile', function($query) {
                $query->where('profile_completed', true)
                      ->where('age', '<=', 28)
                      ->whereIn('body_type', ['Atlético', 'Con curvas', 'Talla mediana']);
            })
            ->with('profile')
            ->orderBy('profiles.age', 'asc')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.*')
            ->limit(10)
            ->get();

        $this->info("👑 Modelos VIP Popular: {$vipPopularModelos->count()} encontradas");

        // Modelos Favoritas
        $favoritasModelos = User::where('role', 'model')
            ->whereHas('profile', function($query) {
                $query->where('profile_completed', true)
                      ->whereIn('ethnicity', ['Latina', 'Blanca', 'Multiétnica'])
                      ->whereIn('country', ['Colombia', 'Argentina', 'México', 'España', 'Brasil']);
            })
            ->with('profile')
            ->orderBy('profiles.subscription_price', 'asc')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.*')
            ->limit(10)
            ->get();

        $this->info("❤️ Modelos Favoritas: {$favoritasModelos->count()} encontradas");
        
        $this->newLine();
        $this->info('📊 Ejemplos de cada categoría:');
        
        if ($nuevasModelos->isNotEmpty()) {
            $ejemplo = $nuevasModelos->first();
            $this->info("✨ Nueva: {$ejemplo->name} - Registrada: {$ejemplo->created_at->diffForHumans()}");
        }
        
        if ($nivelAltoModelos->isNotEmpty()) {
            $ejemplo = $nivelAltoModelos->first();
            $this->info("💎 Nivel Alto: {$ejemplo->name} - Precio: \${$ejemplo->profile->subscription_price}");
        }
        
        if ($vipPopularModelos->isNotEmpty()) {
            $ejemplo = $vipPopularModelos->first();
            $this->info("👑 VIP: {$ejemplo->name} - Edad: {$ejemplo->profile->age} años - Tipo: {$ejemplo->profile->body_type}");
        }
        
        if ($favoritasModelos->isNotEmpty()) {
            $ejemplo = $favoritasModelos->first();
            $this->info("❤️ Favorita: {$ejemplo->name} - País: {$ejemplo->profile->country} - Etnia: {$ejemplo->profile->ethnicity}");
        }
        
        return Command::SUCCESS;
    }
}
