<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function searchModels(Request $request)
    {
        $query = User::query()
            ->where('role', 'model')
            ->with(['profile' => function($q) {
                $q->where('profile_completed', true);
            }])
            ->whereHas('profile', function($q) {
                $q->where('profile_completed', true);
            });

        
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('profile', function($profileQuery) use ($searchTerm) {
                      $profileQuery->where('display_name', 'LIKE', "%{$searchTerm}%")
                                   ->orWhere('bio', 'LIKE', "%{$searchTerm}%")
                                   ->orWhere('country', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        
        if ($request->filled('age')) {
            $ageRanges = $request->age;
            $query->whereHas('profile', function($q) use ($ageRanges) {
                $q->where(function($ageQuery) use ($ageRanges) {
                    foreach ($ageRanges as $range) {
                        switch ($range) {
                            case '18-25':
                                $ageQuery->orWhereBetween('age', [18, 25]);
                                break;
                            case '26-35':
                                $ageQuery->orWhereBetween('age', [26, 35]);
                                break;
                            case '36-45':
                                $ageQuery->orWhereBetween('age', [36, 45]);
                                break;
                            case '46+':
                                $ageQuery->orWhere('age', '>=', 46);
                                break;
                            case '35-50':
                                $ageQuery->orWhereBetween('age', [35, 50]);
                                break;
                        }
                    }
                });
            });
        }

        
        if ($request->filled('ethnicity')) {
            $query->whereHas('profile', function($q) use ($request) {
                $q->whereIn('ethnicity', $request->ethnicity);
            });
        }

        
        if ($request->filled('body_type')) {
            $query->whereHas('profile', function($q) use ($request) {
                $q->whereIn('body_type', $request->body_type);
            });
        }

        
        if ($request->filled('hair_color')) {
            $query->whereHas('profile', function($q) use ($request) {
                $q->whereIn('hair_color', $request->hair_color);
            });
        }

        
        // Filtro por País (Multiple)
        if ($request->filled('country')) {
            $query->whereHas('profile', function($q) use ($request) {
                $q->whereIn('country', (array)$request->country);
            });
        }

        // Filtro por Disponibilidad
        if ($request->filled('availability')) {
            $query->whereHas('profile', function($q) use ($request) {
                if (in_array('online', (array)$request->availability)) {
                    $q->where('is_online', true);
                }
                if (in_array('live', (array)$request->availability)) {
                    $q->where('is_streaming', true);
                }
            });
        }

        // Filtro por Liga / Nivel
        if ($request->filled('league')) {
            $query->whereHas('progress.currentLevel', function($q) use ($request) {
                $q->whereIn('name', (array)$request->league);
            });
        }

        // Filtro por Idiomas
        if ($request->filled('languages')) {
            $query->whereHas('profile', function($q) use ($request) {
                foreach ((array)$request->languages as $lang) {
                    $q->whereJsonContains('languages', $lang);
                }
            });
        }

        // Filtro por Redes Sociales
        if ($request->filled('social')) {
            $query->whereHas('profile', function($q) {
                $q->whereNotNull('social_networks')->where('social_networks', '!=', '[]');
            });
        }

        // Ordenamiento
        if ($request->filled('popularity') && in_array('most_popular', (array)$request->popularity)) {
            $query->orderByDesc(
                Profile::select('views_count') // Asumiendo que existe o se puede contar
                    ->whereColumn('profiles.user_id', 'users.id')
                    ->limit(1)
            );
        } else {
            $query->orderByDesc(
                Profile::select('is_online')
                    ->whereColumn('profiles.user_id', 'users.id')
                    ->limit(1)
            )->orderByDesc(
                Profile::select('last_profile_update')
                    ->whereColumn('profiles.user_id', 'users.id')
                    ->limit(1)
            );
        }

        $models = $query->paginate(20);

        
        $criteria = [];
        
        if ($request->filled('search')) {
            $criteria[] = [
                'type' => 'busqueda',
                'label' => 'Búsqueda: ' . $request->search,
                'icon' => 'fas fa-search',
                'color' => 'busqueda'
            ];
        }
        
        if ($request->filled('age')) {
            foreach ($request->age as $ageRange) {
                $ageLabels = [
                    '18-25' => '18-25 años',
                    '26-35' => '26-35 años',
                    '36-45' => '36-45 años',
                    '46+' => '46+ años',
                    '35-50' => '35-50 años'
                ];
                $criteria[] = [
                    'type' => 'edad',
                    'label' => $ageLabels[$ageRange] ?? $ageRange,
                    'icon' => 'fas fa-birthday-cake',
                    'color' => 'edad'
                ];
            }
        }
        
        if ($request->filled('ethnicity')) {
            foreach ($request->ethnicity as $ethnicity) {
                $criteria[] = [
                    'type' => 'etnia',
                    'label' => $ethnicity,
                    'icon' => 'fas fa-palette',
                    'color' => 'etnia'
                ];
            }
        }
        
        if ($request->filled('body_type')) {
            foreach ($request->body_type as $bodyType) {
                $criteria[] = [
                    'type' => 'cuerpo',
                    'label' => $bodyType,
                    'icon' => 'fas fa-dumbbell',
                    'color' => 'cuerpo'
                ];
            }
        }
        
        if ($request->filled('hair_color')) {
            foreach ($request->hair_color as $hairColor) {
                $criteria[] = [
                    'type' => 'cabello',
                    'label' => $hairColor,
                    'icon' => 'fas fa-cut',
                    'color' => 'cabello'
                ];
            }
        }
        
        if ($request->filled('country')) {
            foreach ($request->country as $country) {
                $criteria[] = [
                    'type' => 'pais',
                    'label' => $country,
                    'icon' => 'fas fa-globe-americas',
                    'color' => 'pais'
                ];
            }
        }

        $categoryInfo = [
            'title' => __('search.title'),
            'icon' => 'fas fa-search',
            'description' => __('search.filter_description'),
            'color' => 'busqueda',
            'criteria' => $criteria
        ];

        if ($request->ajax() || $request->header('X-Requested-With') == 'XMLHttpRequest') {
            return view('filters.partials.grid', compact('models', 'categoryInfo'))->render();
        }

        return view('filters.results', compact('models', 'categoryInfo'));
    }

    public function getFilterCounts()
    {
        $counts = [
            'age' => [
                '18-25' => Profile::whereBetween('age', [18, 25])->count(),
                '26-35' => Profile::whereBetween('age', [26, 35])->count(),
                '36-45' => Profile::whereBetween('age', [36, 45])->count(),
                '46+' => Profile::where('age', '>=', 46)->count(),
                '35-50' => Profile::whereBetween('age', [35, 50])->count(),
            ],
            'ethnicity' => [
                'Árabe' => Profile::where('ethnicity', 'Árabe')->count(),
                'Asiática' => Profile::where('ethnicity', 'Asiática')->count(),
                'Negra' => Profile::where('ethnicity', 'Negra')->count(),
                'India' => Profile::where('ethnicity', 'India')->count(),
                'Latina' => Profile::where('ethnicity', 'Latina')->count(),
                'Multiétnica' => Profile::where('ethnicity', 'Multiétnica')->count(),
                'Blanca' => Profile::where('ethnicity', 'Blanca')->count(),
            ],
            'body_type' => [
                'Delgado' => Profile::where('body_type', 'Delgado')->count(),
                'Atlético' => Profile::where('body_type', 'Atlético')->count(),
                'Promedio' => Profile::where('body_type', 'Promedio')->count(),
                'Curvilíneo' => Profile::where('body_type', 'Curvilíneo')->count(),
                'Grande' => Profile::where('body_type', 'Grande')->count(),
            ],
            'hair_color' => [
                'Rubio' => Profile::where('hair_color', 'Rubio')->count(),
                'Negro' => Profile::where('hair_color', 'Negro')->count(),
                'Moreno' => Profile::where('hair_color', 'Moreno')->count(),
                'Colorido' => Profile::where('hair_color', 'Colorido')->count(),
                'Pelirrojo' => Profile::where('hair_color', 'Pelirrojo')->count(),
            ],
            'country' => [
                'España' => Profile::where('country', 'España')->count(),
                'México' => Profile::where('country', 'México')->count(),
                'Colombia' => Profile::where('country', 'Colombia')->count(),
                'Argentina' => Profile::where('country', 'Argentina')->count(),
                'Brasil' => Profile::where('country', 'Brasil')->count(),
            ]
        ];

        return response()->json($counts);
    }
}
