@if($pendingActions->count() > 0)
    <div>
        <h5
            style="color: rgba(255,255,255,0.5); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.75rem;">
            {{ __('model.streams.admin.actions_list.pending') }}</h5>
        @foreach($pendingActions as $action)
            <div class="action-card" data-action-id="{{ $action->id }}">
                <div class="action-header">
                    <div class="action-icon {{ $action->isRoulette() ? 'roulette' : 'menu' }}">
                        <i class="fas fa-{{ $action->isRoulette() ? 'dharmachakra' : 'star' }}"></i>
                    </div>
                    <div style="flex: 1;">
                        <div class="action-fan">{{ $action->fan->name }}</div>
                        <div class="action-amount">{{ number_format($action->amount) }} Tk</div>
                    </div>
                </div>
                <div class="action-message">{{ $action->message }}</div>
                <button onclick="completeAction({{ $stream->id }}, {{ $action->id }})" class="btn-complete-action">
                    <i class="fas fa-check"></i> {{ __('model.streams.admin.actions_list.mark_as_done') }}
                </button>
            </div>
        @endforeach
    </div>
@else
    <div
        style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0.2;">
        <i class="fas fa-tasks" style="font-size: 3rem; margin-bottom: 1rem;"></i>
        <p>{{ __('model.streams.admin.actions_list.empty') }}</p>
    </div>
@endif