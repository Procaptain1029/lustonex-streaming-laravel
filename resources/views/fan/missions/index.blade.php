@extends('layouts.public')

@section('title', __('fan.missions.title') . ' - Lustonex')



@section('content')
   <style>
        .missions-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.5rem 2rem 3rem;
        }

        /* Header */
        .missions-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        /* Estilos de encabezado heredados del layout public */

        .btn-back {
            padding: 8px 16px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: rgba(212, 175, 55, 0.08);
            border-color: rgba(212, 175, 55, 0.25);
            color: var(--color-oro-sensual);
        }

        /* Sections */
        .missions-section {
            margin-bottom: 2.5rem;
        }

        .section-label {
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .section-label i {
            color: var(--color-oro-sensual);
            font-size: 0.9rem;
        }

        .section-label .count-badge {
            background: rgba(212, 175, 55, 0.1);
            color: var(--color-oro-sensual);
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 700;
        }

        /* Mission Cards Grid */
        .m-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.25rem;
        }

        /* Mission Card */
        .m-card {
            background: rgba(25, 25, 30, 0.7);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 18px;
            padding: 1.25rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .m-card:hover {
            transform: translateY(-3px);
            border-color: rgba(212, 175, 55, 0.2);
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        }

        .m-card.priority {
            border-color: rgba(212, 175, 55, 0.3);
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.04), rgba(25, 25, 30, 0.7));
        }

        .m-required-tag {
            position: absolute;
            top: 0;
            right: 0;
            background: #e50914;
            color: #fff;
            font-size: 0.6rem;
            font-weight: 800;
            padding: 3px 10px;
            border-bottom-left-radius: 10px;
            letter-spacing: 0.5px;
        }

        .m-card-top {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .m-icon {
            width: 46px;
            height: 46px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--color-oro-sensual);
            flex-shrink: 0;
        }

        .m-icon.gold-bg { background: rgba(212, 175, 55, 0.12); }

        .m-info {
            flex: 1;
            min-width: 0;
        }

        .m-info h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            margin: 0 0 4px 0;
            line-height: 1.3;
        }

        .m-info p {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.5);
            margin: 0;
            line-height: 1.4;
        }

        .m-level-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(212, 175, 55, 0.08);
            padding: 3px 10px;
            border-radius: 15px;
            border: 1px solid rgba(212, 175, 55, 0.15);
            margin-bottom: 6px;
        }

        .m-level-tag i { color: var(--color-oro-sensual); font-size: 0.7rem; }
        .m-level-tag span { font-weight: 700; color: var(--color-oro-sensual); font-size: 0.72rem; }

        /* Progress */
        .m-progress {
            margin-top: auto;
        }

        .m-bar-track {
            height: 7px;
            background: rgba(255,255,255,0.06);
            border-radius: 7px;
            overflow: hidden;
            margin-bottom: 6px;
        }

        .m-bar-fill {
            height: 100%;
            background: var(--gradient-gold);
            border-radius: 7px;
            transition: width 0.8s ease;
        }

        .m-bar-fill.green {
            background: linear-gradient(90deg, #10b981, #34d399);
        }

        .m-progress-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.45);
            font-weight: 600;
        }

        .m-progress-labels .value {
            color: var(--color-oro-sensual);
        }

        /* Rewards */
        .m-rewards {
            display: flex;
            gap: 8px;
            padding-top: 10px;
            border-top: 1px solid rgba(255,255,255,0.04);
            flex-wrap: wrap;
        }

        .m-reward {
            background: rgba(212, 175, 55, 0.08);
            color: var(--color-oro-sensual);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* History Table */
        .m-history-wrap {
            background: rgba(25, 25, 30, 0.6);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 18px;
            overflow: hidden;
        }

        .m-history-table {
            width: 100%;
            border-collapse: collapse;
        }

        .m-history-table th {
            text-align: left;
            padding: 0.85rem 1.25rem;
            color: rgba(255,255,255,0.4);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .m-history-table td {
            padding: 0.85rem 1.25rem;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.03);
            font-size: 0.9rem;
        }

        .m-history-table tr:last-child td {
            border-bottom: none;
        }

        .m-history-table tr:hover td {
            background: rgba(255,255,255,0.02);
        }

        .m-completed-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #10b981;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .m-type-tag {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.35);
            margin-top: 2px;
        }

        .m-empty-row {
            text-align: center;
            color: rgba(255,255,255,0.35);
            font-size: 0.9rem;
            padding: 2.5rem 1rem !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .missions-page {
                padding: 0.25rem 0.75rem 2rem;
            }

            .missions-page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
                margin-bottom: 1.5rem;
            }

            .missions-page-header h1 {
                gap: 8px;
                margin-bottom: 16px;
            }

            /* Estilos responsivos heredados */

            .m-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .m-card {
                padding: 1rem;
                border-radius: 14px;
                gap: 0.75rem;
            }

            .m-icon {
                width: 38px;
                height: 38px;
                font-size: 1rem;
                border-radius: 10px;
            }

            .m-info h3 {
                font-size: 0.9rem;
            }

            .m-info p {
                font-size: 0.78rem;
            }

            .m-reward {
                font-size: 0.7rem;
                padding: 3px 8px;
            }

            .section-label {
                font-size: 0.9rem;
            }

            .missions-section {
                margin-bottom: 2rem;
            }

            /* History table responsive */
            .m-history-table th,
            .m-history-table td {
                padding: 0.65rem 0.75rem;
                font-size: 0.8rem;
            }

            .m-history-table th:nth-child(3),
            .m-history-table td:nth-child(3) {
                display: none;
            }
        }

        @media (max-width: 480px) {
            /* Estilos responsivos heredados */

            .m-history-table th:nth-child(2),
            .m-history-table td:nth-child(2) {
                display: none;
            }
        }
    </style>
<div class="missions-page">
    <div class="missions-page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-bullseye"></i> {{ __('fan.missions.title') }}</h1>
            <p class="page-subtitle">{{ __('fan.missions.subtitle') }}</p>
        </div>
        <a href="{{ route('fan.dashboard') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> {{ __('fan.missions.btn_back') }}
        </a>
    </div>

    {{-- Obligatory Missions --}}
    @if($obligatoryMissions->count() > 0)
    <div class="missions-section">
        <h2 class="section-label">
            <i class="fas fa-crown"></i> {{ __('fan.missions.level_missions') }}
            <span class="count-badge">{{ __('fan.missions.priority') }}</span>
        </h2>
        <div class="m-grid">
            @foreach($obligatoryMissions as $mission)
                <div class="m-card priority">
                    <div class="m-required-tag">{{ __('fan.dashboard.missions.required') }}</div>
                    <div class="m-card-top">
                        <div class="m-icon gold-bg">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div class="m-info">
                            <div class="m-level-tag">
                                <i class="fas fa-level-up-alt"></i>
                                <span>{{ __('fan.missions.unlocks_level', ['level' => ($user->progress ? $user->progress->currentLevel->level_number : 0) + 1]) }}</span>
                            </div>
                            <h3>{{ $mission['title'] }}</h3>
                            <p>{{ $mission['description'] }}</p>
                        </div>
                    </div>

                    <div class="m-progress">
                        <div class="m-bar-track">
                            <div class="m-bar-fill" style="width: {{ $mission['progress'] }}%"></div>
                        </div>
                        <div class="m-progress-labels">
                            <span>{{ __('fan.missions.progress') }}</span>
                            <span class="value">{{ $mission['current'] }} / {{ $mission['target'] }}</span>
                        </div>
                    </div>

                    <div class="m-rewards">
                        @if($mission['xp_reward'] > 0)
                            <div class="m-reward"><i class="fas fa-bolt"></i> +{{ $mission['xp_reward'] }} XP</div>
                        @endif
                        @if($mission['ticket_reward'] > 0)
                            <div class="m-reward"><i class="fas fa-ticket-alt"></i> +{{ $mission['ticket_reward'] }} Tickets</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Weekly Missions --}}
    <div class="missions-section">
        <h2 class="section-label">
            <i class="fas fa-calendar-week"></i> {{ __('fan.missions.weekly_missions') }}
            <span class="count-badge">{{ $weeklyMissions->count() }}</span>
        </h2>
        @if($weeklyMissions->count() > 0)
            <div class="m-grid">
                @foreach($weeklyMissions as $mission)
                    <div class="m-card">
                        <div class="m-card-top">
                            <div class="m-icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="m-info">
                                <h3>{{ $mission['title'] }}</h3>
                                <p>{{ $mission['description'] }}</p>
                            </div>
                        </div>
                        <div class="m-progress">
                            <div class="m-bar-track">
                                <div class="m-bar-fill" style="width: {{ $mission['progress'] }}%"></div>
                            </div>
                            <div class="m-progress-labels">
                                <span>Progreso</span>
                                <span class="value">{{ $mission['current'] }} / {{ $mission['target'] }}</span>
                            </div>
                        </div>
                        <div class="m-rewards">
                            @if($mission['xp_reward'] > 0)
                                <div class="m-reward"><i class="fas fa-bolt"></i> +{{ $mission['xp_reward'] }} XP</div>
                            @endif
                            @if($mission['ticket_reward'] > 0)
                                <div class="m-reward"><i class="fas fa-ticket-alt"></i> +{{ $mission['ticket_reward'] }} Tickets</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: rgba(255,255,255,0.35); font-size: 0.9rem;">{{ __('fan.missions.weekly_completed') }}</p>
        @endif
    </div>

    {{-- Parallel Missions --}}
    @if($parallelMissions->count() > 0)
    <div class="missions-section">
        <h2 class="section-label">
            <i class="fas fa-infinity"></i> {{ __('fan.missions.extra_challenges') }}
            <span class="count-badge">{{ $parallelMissions->count() }}</span>
        </h2>
        <div class="m-grid">
            @foreach($parallelMissions as $mission)
                <div class="m-card">
                    <div class="m-card-top">
                        <div class="m-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div class="m-info">
                            <h3>{{ $mission['title'] }}</h3>
                            <p>{{ $mission['description'] }}</p>
                        </div>
                    </div>
                    <div class="m-progress">
                        <div class="m-bar-track">
                            <div class="m-bar-fill" style="width: {{ $mission['progress'] }}%"></div>
                        </div>
                        <div class="m-progress-labels">
                            <span>{{ __('fan.missions.progress') }}</span>
                            <span class="value">{{ $mission['current'] }} / {{ $mission['target'] }}</span>
                        </div>
                    </div>
                    <div class="m-rewards">
                        @if($mission['xp_reward'] > 0)
                            <div class="m-reward"><i class="fas fa-bolt"></i> +{{ $mission['xp_reward'] }} XP</div>
                        @endif
                        @if($mission['ticket_reward'] > 0)
                            <div class="m-reward"><i class="fas fa-ticket-alt"></i> +{{ $mission['ticket_reward'] }} Tickets</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Completed --}}
    <div class="missions-section">
        <h2 class="section-label">
            <i class="fas fa-check-circle"></i> {{ __('fan.missions.recently_completed') }}
        </h2>
        <div class="m-history-wrap">
            <table class="m-history-table">
                <thead>
                    <tr>
                        <th>{{ __('fan.missions.table.mission') }}</th>
                        <th>{{ __('fan.missions.table.reward') }}</th>
                        <th>{{ __('fan.missions.table.completed') }}</th>
                        <th>{{ __('fan.missions.table.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($completedMissions as $mission)
                        <tr>
                            <td>
                                <div style="font-weight: 600;">{{ $mission->name }}</div>
                                <div class="m-type-tag">{{ $mission->type }}</div>
                            </td>
                            <td>
                                @if($mission->reward_xp > 0) <span style="margin-right: 8px;">+{{ $mission->reward_xp }} XP</span> @endif
                                @if($mission->reward_tickets > 0) <span>+{{ $mission->reward_tickets }} Tickets</span> @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($mission->completed_at)->diffForHumans() }}</td>
                            <td><span class="m-completed-badge"><i class="fas fa-check"></i> {{ __('fan.missions.table.completed_badge') }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="m-empty-row">{{ __('fan.missions.table.no_recent') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
