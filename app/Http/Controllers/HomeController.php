<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stream;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        
        $nuevasModelos = User::where('role', 'model')
            ->whereHas('profile', function ($query) {
                $query->where('profile_completed', true);
                $query->where('verification_status', 'approved');
            })
            ->with('profile')
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();

        
        $nivelAltoModelos = User::where('role', 'model')
            ->whereHas('profile', function ($query) {
                $query->where('profile_completed', true)
                    ->where('verification_status', 'approved');
            })
            ->with('profile')
            ->orderBy('profiles.subscription_price', 'desc')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.*')
            ->limit(12)
            ->get();

        
        $vipPopularModelos = User::where('role', 'model')
            ->whereHas('profile', function ($query) {
                $query->where('verification_status', 'approved');
            })
            ->join('model_ranks', 'users.id', '=', 'model_ranks.user_id')
            ->where('model_ranks.period_type', 'WEEKLY')
            ->where('model_ranks.rank_position', '<=', 100)
            ->with(['profile', 'ranks'])
            ->orderBy('model_ranks.rank_position', 'asc')
            ->select('users.*')
            ->limit(12)
            ->get();

        
        $favoritasModelos = User::where('role', 'model')
            ->whereHas('profile', function ($query) {
                $query->where('verification_status', 'approved');
            })
            ->withCount('favoritedBy')
            ->orderBy('favorited_by_count', 'desc')
            ->limit(12)
            ->get();

        
        $liveStreams = Stream::where('status', 'live')
            ->with('user.profile')
            ->whereHas('user.profile', function ($query) {
                $query->where('verification_status', 'approved');
            })
            ->orderBy('viewers_count', 'desc')
            ->limit(6)
            ->get();

        return view('welcome', compact('nuevasModelos', 'nivelAltoModelos', 'vipPopularModelos', 'favoritasModelos', 'liveStreams'));
    }

    public function nuevasModelos()
    {
        $models = User::where('role', 'model')
            ->whereHas('profile', function ($query) {
                $query->where('profile_completed', true)
                    ->where('verification_status', 'approved');
            })
            ->with('profile')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categoryInfo = [
            'id' => 'new_models',
            'title' => __('categories.new_models.title'),
            'icon' => 'fas fa-sparkles',
            'description' => __('categories.new_models.description'),
            'color' => '#00c851'
        ];

        if (request()->ajax() || request()->header('X-Requested-With') == 'XMLHttpRequest') {
            return view('categories.partials.grid-categories', compact('models', 'categoryInfo'))->render();
        }

        return view('categories.models', compact('models', 'categoryInfo'));
    }

    public function nivelAltoModelos()
    {
        $models = User::where('role', 'model')
            ->whereHas('profile', function ($query) {
                $query->where('profile_completed', true)
                    ->where('verification_status', 'approved');
            })
            ->with('profile')
            ->orderBy('profiles.subscription_price', 'desc')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.*')
            ->paginate(20);

        $categoryInfo = [
            'id' => 'top_level',
            'title' => __('categories.top_level.title'),
            'icon' => 'fas fa-gem',
            'description' => __('categories.top_level.description'),
            'color' => 'rgba(212, 175, 55, 0.9)'
        ];

        if (request()->ajax() || request()->header('X-Requested-With') == 'XMLHttpRequest') {
            return view('categories.partials.grid-categories', compact('models', 'categoryInfo'))->render();
        }

        return view('categories.models', compact('models', 'categoryInfo'));
    }

    public function vipModelos()
    {
        $models = User::where('role', 'model')
            ->whereHas('profile', function ($query) {
                $query->where('verification_status', 'approved');
            })
            ->join('model_ranks', 'users.id', '=', 'model_ranks.user_id')
            ->where('model_ranks.period_type', 'WEEKLY')
            ->where('model_ranks.rank_position', '<=', 100)
            ->with(['profile', 'ranks'])
            ->orderBy('model_ranks.rank_position', 'asc')
            ->select('users.*')
            ->paginate(20);

        $categoryInfo = [
            'id' => 'weekly_vip',
            'title' => __('categories.weekly_vip.title'),
            'icon' => 'fas fa-crown',
            'description' => __('categories.weekly_vip.description'),
            'color' => 'rgba(138, 43, 226, 0.9)'
        ];

        if (request()->ajax() || request()->header('X-Requested-With') == 'XMLHttpRequest') {
            return view('categories.partials.grid-categories', compact('models', 'categoryInfo'))->render();
        }

        return view('categories.models', compact('models', 'categoryInfo'));
    }

    public function favoritasModelos()
    {
        $models = User::where('role', 'model')
            ->whereHas('profile', function ($query) {
                $query->where('verification_status', 'approved');
            })
            ->with('profile')
            ->withCount('favoritedBy')
            ->orderBy('favorited_by_count', 'desc')
            ->paginate(20);

        $categoryInfo = [
            'id' => 'favorite_models',
            'title' => __('categories.favorite_models.title'),
            'icon' => 'fas fa-heart',
            'description' => __('categories.favorite_models.description'),
            'color' => '#e93b76'
        ];

        if (request()->ajax() || request()->header('X-Requested-With') == 'XMLHttpRequest') {
            return view('categories.partials.grid-categories', compact('models', 'categoryInfo'))->render();
        }

        return view('categories.models', compact('models', 'categoryInfo'));
    }

    public function filtrarPorPais($pais)
    {
        
        $paisesMap = [
            'co' => __('global.countries.co') != 'global.countries.co' ? __('global.countries.co') : 'Colombia',
            'ar' => __('global.countries.ar') != 'global.countries.ar' ? __('global.countries.ar') : 'Argentina',
            'mx' => __('global.countries.mx') != 'global.countries.mx' ? __('global.countries.mx') : 'México',
            'es' => __('global.countries.es') != 'global.countries.es' ? __('global.countries.es') : 'España',
            'br' => __('global.countries.br') != 'global.countries.br' ? __('global.countries.br') : 'Brasil'
        ];

        
        $paisNombre = $paisesMap[strtolower($pais)] ?? ucfirst($pais);

        
        $models = User::where('role', 'model')
            ->whereHas('profile', function ($query) use ($pais) {
                $query->where('country', strtolower($pais));
                $query->where('verification_status', 'approved');
            })
            ->with('profile')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        
        $categoryInfo = [
            'title' => __('categories.models_from', ['country' => $paisNombre]),
            'icon' => 'fas fa-globe-americas',
            'description' => __('categories.models_from_desc', ['country' => $paisNombre]),
            'color' => 'pais',
            'criteria' => [
                [
                    'type' => 'pais',
                    'label' => $paisNombre,
                    'icon' => 'fi fi-' . $pais,
                    'color' => 'pais'
                ]
            ]
        ];

        if (request()->ajax()) {
            return view('filters.partials.grid', compact('models', 'categoryInfo'))->render();
        }

        return view('filters.results', compact('models', 'categoryInfo'));
    }


    public function filtrarPorEdad($rango)
    {
        $rangosMap = [
            '18-25' => ['min' => 18, 'max' => 25, 'nombre' => __('categories.age_ranges.18-25')],
            '26-30' => ['min' => 26, 'max' => 30, 'nombre' => __('categories.age_ranges.26-30')],
            '31-35' => ['min' => 31, 'max' => 35, 'nombre' => __('categories.age_ranges.31-35')],
            '36-plus' => ['min' => 36, 'max' => 99, 'nombre' => __('categories.age_ranges.36-plus')]
        ];

        $rangoData = $rangosMap[$rango] ?? $rangosMap['18-25'];

        $models = User::where('role', 'model')
            ->whereHas('profile', function ($query) use ($rangoData) {
                $query->where('profile_completed', true)
                    ->where('verification_status', 'approved')
                    ->whereBetween('age', [$rangoData['min'], $rangoData['max']]);
            })
            ->with('profile')
            ->orderBy('profiles.age', 'asc')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.*')
            ->paginate(20);

        $categoryInfo = [
            'title' => __('categories.models_age', ['range' => $rangoData['nombre']]),
            'icon' => 'fas fa-birthday-cake',
            'description' => __('categories.models_age_desc', ['range' => $rangoData['nombre']]),
            'color' => 'edad',
            'criteria' => [
                [
                    'type' => 'edad',
                    'label' => $rangoData['nombre'],
                    'icon' => 'fas fa-birthday-cake',
                    'color' => 'edad'
                ]
            ]
        ];

        if (request()->ajax()) {
            return view('filters.partials.grid', compact('models', 'categoryInfo'))->render();
        }

        return view('filters.results', compact('models', 'categoryInfo'));
    }

    public function filtrarPorEtnia($etnia)
    {
        $etniasMap = [
            'latina' => __('categories.ethnicities.latina'),
            'blanca' => __('categories.ethnicities.white'),
            'asiatica' => __('categories.ethnicities.asian'),
            'negra' => __('categories.ethnicities.black'),
            'multietnica' => __('categories.ethnicities.multiethnic'),
            'arabe' => __('categories.ethnicities.arabic'),
            'india' => __('categories.ethnicities.indian')
        ];

        $etniaNombre = $etniasMap[$etnia] ?? ucfirst($etnia);

        $models = User::where('role', 'model')
            ->whereHas('profile', function ($query) use ($etniaNombre) {
                $query->where('profile_completed', true)
                    ->where('verification_status', 'approved')
                    ->where('ethnicity', $etniaNombre);
            })
            ->with('profile')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categoryInfo = [
            'title' => __('categories.models_ethnicity', ['ethnicity' => $etniaNombre]),
            'icon' => 'fas fa-palette',
            'description' => __('categories.models_ethnicity_desc', ['ethnicity' => $etniaNombre]),
            'color' => 'etnia',
            'criteria' => [
                [
                    'type' => 'etnia',
                    'label' => $etniaNombre,
                    'icon' => 'fas fa-palette',
                    'color' => 'etnia'
                ]
            ]
        ];

        if (request()->ajax() || request()->header('X-Requested-With') == 'XMLHttpRequest') {
            return view('filters.partials.grid', compact('models', 'categoryInfo'))->render();
        }

        return view('filters.results', compact('models', 'categoryInfo'));
    }

    public function filtrarPorCabello($tipo)
    {
        $cabellosMap = [
            'rubio' => __('categories.hair_colors.rubio'),
            'moreno' => __('categories.hair_colors.moreno'),
            'negro' => __('categories.hair_colors.negro'),
            'pelirroja' => __('categories.hair_colors.pelirroja'),
            'colorido' => __('categories.hair_colors.colorido')
        ];

        $cabelloNombre = $cabellosMap[$tipo] ?? ucfirst($tipo);

        $models = User::where('role', 'model')
            ->whereHas('profile', function ($query) use ($cabelloNombre) {
                $query->where('profile_completed', true)
                    ->where('verification_status', 'approved')
                    ->where('hair_color', $cabelloNombre);
            })
            ->with('profile')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categoryInfo = [
            'title' => __('categories.models_hair', ['hair' => $cabelloNombre]),
            'icon' => 'fas fa-cut',
            'description' => __('categories.models_hair_desc', ['hair' => $cabelloNombre]),
            'color' => 'cabello',
            'criteria' => [
                [
                    'type' => 'cabello',
                    'label' => $cabelloNombre,
                    'icon' => 'fas fa-cut',
                    'color' => 'cabello'
                ]
            ]
        ];

        if (request()->ajax() || request()->header('X-Requested-With') == 'XMLHttpRequest') {
            return view('filters.partials.grid', compact('models', 'categoryInfo'))->render();
        }

        return view('filters.results', compact('models', 'categoryInfo'));
    }
}
