
@props([
    'mission' => null
])

@if($mission)
<div class="mission-progress-mini">
    <div class="mission-icon-mini">
        <i class="fas fa-bullseye"></i>
    </div>
    <div class="mission-info-mini">
        <div class="mission-header-mini">
            <span class="mission-name-mini">{{ $mission['title'] ?? $mission->title }}</span>
            <span class="mission-progress-text-mini">{{ $mission['current'] ?? $mission->current }}/{{ $mission['target'] ?? $mission->target }}</span>
        </div>
        <div class="progress-bar-mini">
            <div class="progress-fill-mini" style="width: {{ $mission['progress'] ?? $mission->progress }}%"></div>
        </div>
    </div>
</div>
@endif

<style>
.mission-progress-mini {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 10px;
    border: 1px solid rgba(212, 175, 55, 0.2);
    transition: all 0.3s ease;
}

.mission-progress-mini:hover {
    background: rgba(212, 175, 55, 0.1);
    border-color: rgba(212, 175, 55, 0.4);
}

.mission-icon-mini {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--color-oro-sensual), #f4e37d);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.mission-info-mini {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.mission-header-mini {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.mission-name-mini {
    font-size: 0.85rem;
    font-weight: 600;
    color: white;
}

.mission-progress-text-mini {
    font-size: 0.75rem;
    color: var(--color-oro-sensual);
    font-weight: 600;
}

.progress-bar-mini {
    height: 6px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill-mini {
    height: 100%;
    background: linear-gradient(90deg, var(--color-oro-sensual), #f4e37d);
    border-radius: 3px;
    transition: width 0.5s ease-out;
}
</style>
