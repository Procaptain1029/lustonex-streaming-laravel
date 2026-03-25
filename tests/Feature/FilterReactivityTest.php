<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterReactivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_filter_routes_return_partial_on_ajax()
    {
        // Setup a model
        $model = User::factory()->create(['role' => 'model']);
        Profile::factory()->create([
            'user_id' => $model->id,
            'country' => 'co',
            'verification_status' => 'approved',
            'profile_completed' => true
        ]);

        $routes = [
            route('filtros.pais', 'co'),
            route('filtros.edad', '18-25'),
            route('filtros.etnia', 'latina'),
            route('filtros.cabello', 'negro'),
            route('search.models')
        ];

        foreach ($routes as $route) {
            $response = $this->get($route, [
                'X-Requested-With' => 'XMLHttpRequest'
            ]);

            $response->assertStatus(200);
            $response->assertViewIs('filters.partials.grid');
            $response->assertSee('sh-models-grid');
            $response->assertSee('ajax-results-data');
        }
    }

    public function test_filter_routes_return_full_view_on_normal_request()
    {
        $route = route('filtros.pais', 'co');
        
        $response = $this->get($route);

        $response->assertStatus(200);
        $response->assertViewIs('filters.results');
        $response->assertSee('filter-results-page-wrapper');
    }
}
