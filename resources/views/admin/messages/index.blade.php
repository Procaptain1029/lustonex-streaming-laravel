@extends('layouts.admin')

@section('title', __('admin.messages.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">{{ __('admin.messages.breadcrumb') }}</span>
@endsection

@section('styles')
<style>
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
    .stat-card { background: linear-gradient(135deg, rgba(31, 31, 35, 0.9), rgba(14, 14, 18, 0.9)); border: 1px solid rgba(212, 175, 55, 0.2); border-radius: 12px; padding: 1rem; }
    .stat-label { font-size: 0.8rem; color: rgba(255, 255, 255, 0.7); }
    .stat-value { font-size: 1.5rem; font-weight: 700; color: var(--color-oro-sensual); }
    .filters-card, .table-card { background: linear-gradient(135deg, rgba(31, 31, 35, 0.9), rgba(14, 14, 18, 0.9)); border: 1px solid rgba(212, 175, 55, 0.2); border-radius: 16px; padding: 1.5rem; margin-bottom: 2rem; }
    .filters-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1rem; }
    .form-control { padding: 0.75rem; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 8px; color: #fff; width: 100%; }
    .btn { padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; text-decoration: none; display: inline-block; }
    .btn-primary { background: var(--gradient-gold); color: #000; }
    .btn-danger { background: rgba(239, 68, 68, 0.8); color: #fff; }
    .btn-warning { background: rgba(251, 191, 36, 0.8); color: #000; }
    .btn-sm { padding: 0.4rem 0.8rem; font-size: 0.85rem; }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 1rem; text-align: left; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
    .badge { padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .badge-flagged { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
    .badge-normal { background: rgba(156, 163, 175, 0.2); color: #9ca3af; }
    .message-content { max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .actions { display: flex; gap: 0.5rem; }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ __('admin.messages.title') }}</h1>
    <p class="page-subtitle">{{ __('admin.messages.subtitle') }}</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">{{ __('admin.messages.stats.total') }}</div>
        <div class="stat-value">{{ number_format($stats['total']) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">{{ __('admin.messages.stats.flagged') }}</div>
        <div class="stat-value">{{ number_format($stats['flagged']) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">{{ __('admin.messages.stats.today') }}</div>
        <div class="stat-value">{{ number_format($stats['today']) }}</div>
    </div>
</div>

<div class="filters-card">
    <form method="GET">
        <div class="filters-grid">
            <input type="text" name="search" class="form-control" placeholder="{{ __('admin.messages.filters.search') }}" value="{{ request('search') }}">
            <select name="user_id" class="form-control">
                <option value="">{{ __('admin.messages.filters.all_users') }}</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
            <select name="flagged" class="form-control">
                <option value="">{{ __('admin.messages.filters.all') }}</option>
                <option value="1" {{ request('flagged') === '1' ? 'selected' : '' }}>{{ __('admin.messages.filters.flagged') }}</option>
                <option value="0" {{ request('flagged') === '0' ? 'selected' : '' }}>{{ __('admin.messages.filters.normal') }}</option>
            </select>
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <button type="submit" class="btn btn-primary">{{ __('admin.messages.filters.filter_btn') }}</button>
    </form>
</div>

<div class="table-card">
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('admin.messages.table.from') }}</th>
                <th>{{ __('admin.messages.table.to') }}</th>
                <th>{{ __('admin.messages.table.message') }}</th>
                <th>{{ __('admin.messages.table.status') }}</th>
                <th>{{ __('admin.messages.table.date') }}</th>
                <th>{{ __('admin.messages.table.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
            <tr>
                <td>{{ $message->sender->name ?? 'N/A' }}</td>
                <td>{{ $message->receiver->name ?? 'N/A' }}</td>
                <td>
                    <div class="message-content" title="{{ $message->content }}">
                        {{ $message->content }}
                    </div>
                </td>
                <td>
                    @if($message->is_flagged)
                    <span class="badge badge-flagged">{{ __('admin.messages.table.flagged') }}</span>
                    @else
                    <span class="badge badge-normal">{{ __('admin.messages.table.normal') }}</span>
                    @endif
                </td>
                <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <div class="actions">
                        <form action="{{ route('admin.messages.toggle-flag', $message) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">
                                {{ $message->is_flagged ? __('admin.messages.table.unflag') : __('admin.messages.table.flag') }}
                            </button>
                        </form>
                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('admin.messages.table.delete_confirm') }}')">
                                {{ __('admin.messages.table.delete') }}
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 2rem; color: rgba(255, 255, 255, 0.5);">
                    {{ __('admin.messages.table.empty') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top: 1.5rem;">{{ $messages->links() }}</div>
</div>
@endsection
