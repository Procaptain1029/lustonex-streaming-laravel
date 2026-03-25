@extends('layouts.admin')

@section('title', 'Gamification Debugger')

@section('content')
<div class="page-header">
    <h1 class="page-title">Gamification Debugger: {{ $user->name }}</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="row">
    
    <div class="col-md-4">
        <div class="card bg-dark text-white mb-4">
            <div class="card-header">User Progress</div>
            <div class="card-body">
                <p><strong>Level:</strong> {{ $user->progress->currentLevel->level_number ?? 0 }} - {{ $user->progress->currentLevel->name ?? 'Novato' }}</p>
                <p><strong>Current XP:</strong> {{ number_format($user->progress->current_xp ?? 0) }}</p>
                <p><strong>Tickets:</strong> {{ number_format($user->progress->tickets_balance ?? 0) }}</p>
                
                @if($nextLevel)
                    <hr>
                    <p class="text-muted">Next Level: {{ $nextLevel->name }} ({{ number_format($nextLevel->xp_required) }} XP)</p>
                    <div class="progress">
                        @php
                            $percent = 0;
                            if (($user->progress->current_xp ?? 0) > 0 && $nextLevel->xp_required > 0) {
                                $percent = min(100, ($user->progress->current_xp / $nextLevel->xp_required) * 100);
                            }
                        @endphp
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percent }}%"></div>
                    </div>
                @else
                    <p class="text-success">Max Level Reached!</p>
                @endif
            </div>
        </div>
    </div>

    
    <div class="col-md-8">
        <div class="card bg-dark text-white mb-4">
            <div class="card-header">Active Missions</div>
            <div class="card-body p-0">
                <table class="table table-dark table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Mission</th>
                            <th>Type</th>
                            <th>Progress</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->missions as $mission)
                            <tr>
                                <td>{{ $mission->name }}</td>
                                <td>
                                    @if($mission->type == 'LEVEL_UP') <span class="badge bg-danger">Level Up</span>
                                    @elseif($mission->type == 'WEEKLY') <span class="badge bg-info">Weekly</span>
                                    @else <span class="badge bg-secondary">{{ $mission->type }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $mission->pivot->progress }} / {{ $mission->goal_amount }}
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar" style="width: {{ ($mission->pivot->progress / $mission->goal_amount) * 100 }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    @if($mission->pivot->completed)
                                        <span class="text-success"><i class="fas fa-check"></i> Done</span>
                                    @else
                                        <span class="text-warning">In Progress</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">No missions assigned.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    
    <div class="col-12">
        <div class="card bg-dark text-white">
            <div class="card-header">Achievements</div>
            <div class="card-body">
                <div class="row">
                    @forelse($user->achievements as $achievement)
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded text-center" style="border-color: #ffd700 !important; background: rgba(255, 215, 0, 0.1);">
                                <i class="fas {{ $achievement->icon }} fa-2x text-warning mb-2"></i>
                                <h5 class="h6">{{ $achievement->name }}</h5>
                                <small class="text-muted">{{ $achievement->pivot->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="col-12"><p>No achievements unlocked yet.</p></div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
