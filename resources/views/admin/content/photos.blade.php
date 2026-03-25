@extends('layouts.admin')

@section('title', __('admin.content.photos.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.content.photos.title') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Photo Moderation Professional Styling ----- */

        /* 1. Hero / Title */
        .page-header {
           
            margin-bottom: 32px;
        }


        /* 2. Stats Row */
        .sh-stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .sh-stat-mini-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s ease;
        }

        .sh-stat-mini-card:hover {
            transform: translateY(-2px);
        }

        .sh-stat-mini-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        /* 3. Management Header & Filters */
        .sh-management-header {
            display: flex;
            flex-direction: column;
            gap: 24px;
            margin-bottom: 32px;
        }

        .sh-filter-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .sh-filter-chip {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.2s ease;
            background: transparent;
        }

        .sh-filter-chip:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .sh-filter-chip.active {
            border: 2px solid var(--admin-gold);
            font-weight: 600;
            color: #fff;
            background: rgba(212, 175, 55, 0.05);
        }

        .sh-search-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            gap: 20px;
        }

        .sh-filter-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 10px 15px;
            color: #fff;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .sh-filter-input:focus {
            outline: none;
            border-color: var(--admin-gold);
            background: rgba(255, 255, 255, 0.05);
        }

        .sh-search-box {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .sh-search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
        }

        /* 4. Selection & Mass Actions */
        .sh-mass-actions-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding: 16px 24px;
            background: rgba(212, 175, 55, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.15);
            border-radius: 12px;
        }

        /* 5. Photo Grid */
        .sh-photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .sh-photo-card {
            background: rgba(255, 255, 255, 0.02);
            /* Custom Dark Glass Theme */
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .sh-photo-card:hover {
            transform: translateY(-5px);
            border-color: rgba(212, 175, 55, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .sh-photo-card.selected {
            border-color: var(--admin-gold);
            background: rgba(212, 175, 55, 0.05);
        }

        .sh-photo-preview {
            height: 240px;
            width: 100%;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .sh-photo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .sh-photo-card:hover .sh-photo-img {
            transform: scale(1.05);
        }

        .sh-photo-overlay {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            display: flex;
            justify-content: space-between;
            pointer-events: none;
            z-index: 2;
        }

        .sh-photo-checkbox-wrapper {
            pointer-events: auto;
        }

        .sh-custom-checkbox {
            width: 24px;
            height: 24px;
            background: rgba(15, 15, 18, 0.6);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .sh-photo-checkbox:checked+.sh-custom-checkbox {
            background: var(--admin-gold);
            border-color: var(--admin-gold);
            color: #000;
        }

        /* Badges */
        .sh-badge {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            backdrop-filter: blur(10px);
        }

        .sh-badge-pending {
            background: #f59e0b;
            color: #fff;
            box-shadow: 0 4px 6px rgba(245, 158, 11, 0.4);
            border: none;
        }

        .sh-badge-approved {
            background: #10b981;
            color: #fff;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.4);
            border: none;
        }

        .sh-badge-rejected {
            background: #ef4444;
            color: #fff;
            box-shadow: 0 4px 6px rgba(239, 68, 68, 0.4);
            border: none;
        }

        .sh-photo-info {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .sh-model-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .sh-model-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid rgba(212, 175, 55, 0.3);
            object-fit: cover;
        }

        .sh-model-name {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
        }

        .sh-photo-title {
            font-size: 14px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sh-photo-meta {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.4);
            margin-top: auto;
        }

        .sh-moderation-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .sh-btn-mod {
            padding: 10px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .sh-btn-approve {
            background: #10b981;
            color: #fff !important;
            border: none;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
        }

        .sh-btn-approve:hover {
            background: #059669; /* Darker emerald */
            color: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(16, 185, 129, 0.4);
        }

        .sh-btn-reject {
            background: #ef4444;
            color: #fff !important;
            border: none;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2);
        }

        .sh-btn-reject:hover {
            background: #b91c1c; /* Darker red */
            color: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(239, 68, 68, 0.4);
        }

        .sh-btn-mass-approve {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            font-weight: 700;
            border: none;
        }

        .sh-btn-mass-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .sh-btn-mass-reject {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            color: #fff;
            font-weight: 700;
            border: none;
        }

        .sh-btn-mass-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        @media (max-width: 768px) {
            .sh-management-header {
                gap: 16px;
            }

            .sh-search-row {
                flex-direction: column;
                align-items: stretch;
            }

            .sh-search-box {
                max-width: 100%;
            }

            .sh-filter-input {
                width: 100%;
            }

            .sh-photo-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .sh-photo-preview {
                height: 180px;
            }

            .sh-photo-info {
                padding: 12px;
            }

            /* Make filter chips wrap neatly on mobile and shrink slightly */
            .sh-filter-container {
                flex-wrap: wrap;
                gap: 8px;
                padding-bottom: 4px;
                justify-content: flex-start;
            }
            
            .sh-filter-chip {
                white-space: nowrap;
                flex-shrink: 0;
                padding: 6px 12px;
                font-size: 13px;
            }
        }

        @media (max-width: 600px) {
            .page-header {
                margin-bottom: 20px;
                margin-top: 10px; /* Adjusting top margin to push content up */
            }


            .sh-stats-row {
                grid-template-columns: 1fr; /* Stack stats on small screens */
                gap: 12px;
                margin-bottom: 24px;
            }

            .sh-stat-mini-card {
                padding: 16px;
            }

            .sh-photo-grid {
                grid-template-columns: 1fr;
            }

            .sh-photo-preview {
                height: 240px;
            }

            /* Fix mass action bar overflow on mobile */
            .sh-mass-actions-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
                padding: 15px;
            }

            .sh-mass-actions-bar > div {
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
            }
            
            .sh-btn-mass-approve, .sh-btn-mass-reject {
                flex: 1;
                text-align: center;
                min-width: 120px;
            }
        }

        /* ----- Photo Modal Visor ----- */
        .sh-photo-modal {
            position: fixed;
            inset: 0;
            background: rgba(10, 10, 12, 0.95);
            backdrop-filter: blur(15px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sh-photo-modal.active {
            display: flex;
            opacity: 1;
        }

        .sh-modal-container {
            width: 100%;
            max-width: 1200px;
            height: 90vh;
            display: flex;
            background: #121216;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            position: relative;
        }

        @media (max-width: 991px) {
            .sh-modal-container {
                flex-direction: column;
                height: auto;
                max-height: 95vh;
                overflow-y: auto;
            }
        }

        .sh-modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            z-index: 100;
            transition: all 0.2s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sh-modal-close:hover {
            background: var(--admin-gold);
            color: #000;
            transform: rotate(90deg);
        }

        .sh-modal-viewer {
            flex: 1;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            min-height: 300px;
        }

        .sh-modal-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .sh-modal-sidebar {
            width: 360px;
            padding: 32px;
            display: flex;
            flex-direction: column;
            border-left: 1px solid rgba(255, 255, 255, 0.08);
            background: linear-gradient(180deg, rgba(18, 18, 22, 1) 0%, rgba(10, 10, 12, 1) 100%);
        }

        @media (max-width: 991px) {
            .sh-modal-sidebar {
                width: 100%;
                border-left: none;
                border-top: 1px solid rgba(255, 255, 255, 0.08);
            }
        }

        .sh-modal-section {
            margin-bottom: 24px;
        }

        .sh-modal-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            margin-bottom: 8px;
            display: block;
        }

        .sh-modal-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 12px;
        }

        .sh-modal-model {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-modal-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 2px solid var(--admin-gold);
            object-fit: cover;
        }

        .sh-modal-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .sh-modal-meta-item {
            background: rgba(255, 255, 255, 0.02);
            padding: 12px;
            border-radius: 10px;
            text-align: center;
        }

        .sh-modal-meta-val {
            display: block;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
        }

        .sh-modal-actions {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sh-modal-btn {
            padding: 14px;
            border-radius: 12px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .sh-modal-btn-approve {
            background: #10b981;
            color: #fff;
            border: none;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .sh-modal-btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            filter: brightness(1.1);
        }

        .sh-modal-btn-reject {
            background: #ef4444;
            color: #fff;
            border: none;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .sh-modal-btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
            filter: brightness(1.1);
        }

    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.content.photos.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.content.photos.subtitle') }}</p>
    </div>


    <div class="sh-stats-row">
        <div class="sh-stat-mini-card">
            <div class="sh-stat-mini-icon" style="background: rgba(212, 175, 55, 0.1); color: var(--admin-gold);">
                <i class="fas fa-images"></i>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; font-weight: 700;">
                    {{ __('admin.content.photos.total') }}</div>
                <div style="font-size: 1.5rem; font-weight: 800;">{{ $photos->total() }}</div>
            </div>
        </div>
        <div class="sh-stat-mini-card">
            <div class="sh-stat-mini-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; font-weight: 700;">
                    {{ __('admin.content.status.pending') }}</div>
                <div style="font-size: 1.5rem; font-weight: 800;">
                    {{ \App\Models\Photo::where('status', 'pending')->count() }}</div>
            </div>
        </div>
        <div class="sh-stat-mini-card">
            <div class="sh-stat-mini-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; font-weight: 700;">
                    {{ __('admin.content.status.approved') }}</div>
                <div style="font-size: 1.5rem; font-weight: 800;">
                    {{ \App\Models\Photo::where('status', 'approved')->count() }}</div>
            </div>
        </div>
    </div>


    <div class="sh-management-header">
        <div class="sh-filter-container">
            <a href="{{ route('admin.content.photos') }}"
                class="sh-filter-chip {{ !request('status') ? 'active' : '' }}">{{ __('admin.content.filters.all') }}</a>
            <a href="{{ route('admin.content.photos', ['status' => 'pending']) }}"
                class="sh-filter-chip {{ request('status') == 'pending' ? 'active' : '' }}">{{ __('admin.content.status.pending') }}</a>
            <a href="{{ route('admin.content.photos', ['status' => 'approved']) }}"
                class="sh-filter-chip {{ request('status') == 'approved' ? 'active' : '' }}">{{ __('admin.content.status.approved') }}</a>
            <a href="{{ route('admin.content.photos', ['status' => 'rejected']) }}"
                class="sh-filter-chip {{ request('status') == 'rejected' ? 'active' : '' }}">{{ __('admin.content.status.rejected') }}</a>
        </div>

        <form method="GET" class="sh-search-row">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <input type="text" name="model" value="{{ request('model') }}" placeholder="{{ __('admin.content.filters.filter_by_model') }}"
                class="sh-filter-input" style="flex:1;">

            <div class="sh-search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="sh-filter-input" placeholder="{{ __('admin.content.filters.search_by_title') }}"
                    value="{{ request('search') }}" style="width: 100%; padding-left: 40px;">
            </div>

            <button type="submit" class="btn btn-primary"
                style="background: var(--admin-gold); color: #000;">{{ __('admin.content.filters.filter_btn') }}</button>
        </form>
    </div>

    @if($photos->count() > 0)
        <form method="POST" action="{{ route('admin.photos.mass-action') }}" id="massForm">
            @csrf

            <div class="sh-mass-actions-bar">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <label class="sh-checkbox-wrapper" style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                        <input type="checkbox" id="selectAll" style="display: none;">
                        <div class="sh-custom-checkbox" id="selectAllVisual"><i class="fas fa-check"
                                style="display: none; font-size: 0.7rem;"></i></div>
                        <span style="font-size: 0.9rem; font-weight: 700; color: #fff;">{{ __('admin.content.actions.select_all') }}</span>
                    </label>
                    <span id="selectedCount"
                        style="font-size: 0.9rem; color: rgba(255,255,255,0.5); display: none; font-weight: 600;">(0
                        {{ __('admin.content.actions.selected') }})</span>
                </div>

                <div style="display: flex; gap: 12px;">
                    @if(request('status') !== 'approved')
                        <button type="submit" name="action" value="approve" class="btn sh-btn-mass-approve" id="bulkApproveBtn" style="display: none;">{{ __('admin.content.actions.approve_selection') }}</button>
                    @endif
                    
                    @if(request('status') !== 'rejected')
                        <button type="submit" name="action" value="reject" class="btn sh-btn-mass-reject" id="bulkRejectBtn" style="display: none;">{{ __('admin.content.actions.reject_selection') }}</button>
                    @endif
                </div>
            </div>

            <div class="sh-photo-grid">
                @foreach($photos as $photo)
                    <div class="sh-photo-card" id="card-{{ $photo->id }}">
                        <div class="sh-photo-preview" onclick="openPhotoModal({{ json_encode([
                            'id' => $photo->id,
                            'url' => $photo->url,
                            'title' => $photo->title,
                            'model_name' => $photo->user->name,
                            'model_avatar' => $photo->user->profile->avatar_url ?? asset('images/default-avatar.png'),
                            'views' => $photo->views,
                            'date' => $photo->created_at->diffForHumans(),
                            'status' => $photo->status,
                            'file_size' => $photo->file_size_human
                        ]) }})">
                            <img src="{{ $photo->thumbnail_url }}" alt="{{ $photo->title }}" class="sh-photo-img">

                            <div class="sh-photo-overlay">
                                <label class="sh-photo-checkbox-wrapper" onclick="event.stopPropagation()">
                                    <input type="checkbox" name="selected[]" value="{{ $photo->id }}" class="sh-photo-checkbox"
                                        style="display: none;">
                                    <div class="sh-custom-checkbox"><i class="fas fa-check"
                                            style="display: none; font-size: 0.7rem;"></i></div>
                                </label>

                                @php
                                    $badgeClass = $photo->status === 'pending' ? 'sh-badge-pending' : ($photo->status === 'approved' ? 'sh-badge-approved' : 'sh-badge-rejected');
                                    $statusMap = ['pending' => __('admin.content.status.single_pending'), 'approved' => __('admin.content.status.single_approved'), 'rejected' => __('admin.content.status.single_rejected')];
                                @endphp
                                <span class="sh-badge {{ $badgeClass }}">{{ $statusMap[$photo->status] ?? $photo->status }}</span>
                            </div>
                        </div>


                        <div class="sh-photo-info">
                            <div class="sh-model-info">
                                <img src="{{ $photo->user->profile->avatar_url ?? asset('images/default-avatar.png') }}"
                                    class="sh-model-avatar" onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                <span class="sh-model-name">{{ $photo->user->name }}</span>
                            </div>

                            @if($photo->title)
                                <div class="sh-photo-title">
                                    {{ $photo->title }}
                                </div>
                            @endif

                            <div class="sh-photo-meta">
                                <span><i class="far fa-eye"></i> {{ $photo->views }}</span>
                                <span>{{ $photo->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="sh-moderation-actions">
                                @if($photo->status !== 'approved')
                                    <button type="button" onclick="actionIndividual('approve', {{ $photo->id }})"
                                        class="sh-btn-mod sh-btn-approve" 
                                        {{ $photo->status === 'rejected' ? 'style=grid-column:1/-1;justify-self:center;width:auto;min-width:140px;' : '' }}>
                                        <i class="fas fa-check"></i> {{ __('admin.content.actions.approve') }}
                                    </button>
                                @endif
                                
                                @if($photo->status !== 'rejected')
                                    <button type="button" onclick="actionIndividual('reject', {{ $photo->id }})"
                                        class="sh-btn-mod sh-btn-reject"
                                        {{ $photo->status === 'approved' ? 'style=grid-column:1/-1;justify-self:center;width:auto;min-width:140px;' : '' }}>
                                        <i class="fas fa-times"></i> {{ __('admin.content.actions.reject') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="individual-forms" style="display: none;"></div>

            <div class="sh-pagination-container" style="margin-top: 40px; display: flex; justify-content: center;">
                {{ $photos->links('custom.pagination') }}
            </div>
        </form>

        <!-- Photo Viewer Modal -->
        <div id="photoModal" class="sh-photo-modal">
            <div class="sh-modal-container">
                <div class="sh-modal-close" onclick="closePhotoModal()">
                    <i class="fas fa-times"></i>
                </div>
                
                <div class="sh-modal-viewer">
                    <img id="modalImg" src="" class="sh-modal-img">
                </div>
                
                <div class="sh-modal-sidebar">
                    <div class="sh-modal-section">
                        <span class="sh-modal-label">{{ __('admin.content.photos.info') }}</span>
                        <h2 id="modalTitle" class="sh-modal-title"></h2>
                        <div class="sh-modal-model">
                            <img id="modalAvatar" src="" class="sh-modal-avatar">
                            <span id="modalModelName" style="font-weight: 700; color: #fff;"></span>
                        </div>
                    </div>

                    <div class="sh-modal-section">
                        <span class="sh-modal-label">{{ __('admin.content.photos.meta') }}</span>
                        <div class="sh-modal-meta-grid">
                            <div class="sh-modal-meta-item">
                                <span class="sh-modal-label" style="margin-bottom: 2px;">{{ __('admin.content.photos.views') }}</span>
                                <span id="modalViews" class="sh-modal-meta-val"></span>
                            </div>
                            <div class="sh-modal-meta-item">
                                <span class="sh-modal-label" style="margin-bottom: 2px;">{{ __('admin.content.photos.uploaded') }}</span>
                                <span id="modalDate" class="sh-modal-meta-val" style="font-size: 0.8rem;"></span>
                            </div>
                            <div class="sh-modal-meta-item" style="grid-column: span 2;">
                                <span class="sh-modal-label" style="margin-bottom: 2px;">{{ __('admin.content.photos.file_size') }}</span>
                                <span id="modalFileSize" class="sh-modal-meta-val"></span>
                            </div>
                        </div>
                    </div>

                    <div id="modalActions" class="sh-modal-actions">
                        <button id="modalApproveBtn" type="button" class="sh-modal-btn sh-modal-btn-approve">
                            <i class="fas fa-check"></i> {{ __('admin.content.actions.approve') }}
                        </button>
                        <button id="modalRejectBtn" type="button" class="sh-modal-btn sh-modal-btn-reject">
                            <i class="fas fa-times"></i> {{ __('admin.content.actions.reject') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div style="padding: 100px; text-align: center; color: rgba(255,255,255,0.2);">
            <i class="fas fa-images" style="font-size: 4rem; opacity: 0.1; margin-bottom: 20px;"></i>
            <h3 style="color: #dab843; font-weight: 800; font-size: 24px; margin-bottom: 10px;">{{ __('admin.content.photos.no_photos_title') }}</h3>
            <p style="font-size: 16px;">{{ __('admin.content.photos.no_photos_desc') }}</p>
            <a href="{{ route('admin.content.photos') }}"
                style="margin-top: 24px; display: inline-block; color: var(--admin-gold); font-weight: 600;">{{ __('admin.content.filters.clear_filters') }}</a>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.sh-photo-checkbox');
            const selectedCount = document.getElementById('selectedCount');

            const updateVisuals = () => {
                let count = 0;
                checkboxes.forEach(cb => {
                    const card = document.getElementById('card-' + cb.value);
                    const visual = cb.nextElementSibling;
                    const icon = visual.querySelector('i');

                    if (cb.checked) {
                        card.classList.add('selected');
                        visual.style.background = 'var(--admin-gold)';
                        visual.style.borderColor = 'var(--admin-gold)';
                        icon.style.display = 'block';
                        count++;
                    } else {
                        card.classList.remove('selected');
                        visual.style.background = 'rgba(15, 15, 18, 0.6)';
                        visual.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                        icon.style.display = 'none';
                    }
                });

                if (count > 0) {
                    selectedCount.style.display = 'block';
                    selectedCount.textContent = `(${count} {{ __('admin.content.actions.selected') }})`;
                    
                    const bulkApproveBtn = document.getElementById('bulkApproveBtn');
                    const bulkRejectBtn = document.getElementById('bulkRejectBtn');
                    
                    if (bulkApproveBtn) bulkApproveBtn.style.display = 'block';
                    if (bulkRejectBtn) bulkRejectBtn.style.display = 'block';
                } else {
                    selectedCount.style.display = 'none';
                    
                    const bulkApproveBtn = document.getElementById('bulkApproveBtn');
                    const bulkRejectBtn = document.getElementById('bulkRejectBtn');
                    
                    if (bulkApproveBtn) bulkApproveBtn.style.display = 'none';
                    if (bulkRejectBtn) bulkRejectBtn.style.display = 'none';
                }

                // Sync select all visual
                const saVisual = document.getElementById('selectAllVisual');
                const saIcon = saVisual.querySelector('i');
                if (selectAll && selectAll.checked) {
                    saVisual.style.background = 'var(--admin-gold)';
                    saVisual.style.borderColor = 'var(--admin-gold)';
                    saIcon.style.display = 'block';
                } else if (selectAll) {
                    saVisual.style.background = 'transparent';
                    saVisual.style.borderColor = 'rgba(212, 175, 55, 0.4)';
                    saIcon.style.display = 'none';
                }
            };

            if (selectAll) {
                selectAll.addEventListener('change', () => {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    updateVisuals();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', () => {
                    if (selectAll) selectAll.checked = Array.from(checkboxes).every(c => c.checked);
                    updateVisuals();
                });
            });

            // Initialize
            updateVisuals();
        });

        function actionIndividual(type, id) {
            const url = type === 'approve'
                ? "{{ route('admin.photos.approve', ':id') }}"
                : "{{ route('admin.photos.reject', ':id') }}";

            const finalizedUrl = url.replace(':id', id);

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = finalizedUrl;

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = "{{ csrf_token() }}";

            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        }

        function openPhotoModal(data) {
            const modal = document.getElementById('photoModal');
            const img = document.getElementById('modalImg');
            const title = document.getElementById('modalTitle');
            const avatar = document.getElementById('modalAvatar');
            const modelName = document.getElementById('modalModelName');
            const views = document.getElementById('modalViews');
            const date = document.getElementById('modalDate');
            const fileSize = document.getElementById('modalFileSize');
            const approveBtn = document.getElementById('modalApproveBtn');
            const rejectBtn = document.getElementById('modalRejectBtn');

            img.src = data.url;
            title.textContent = data.title || 'Sin título';
            avatar.src = data.model_avatar;
            modelName.textContent = data.model_name;
            views.textContent = data.views;
            date.textContent = data.date;
            fileSize.textContent = data.file_size;

            // Moderation actions
            approveBtn.onclick = () => actionIndividual('approve', data.id);
            rejectBtn.onclick = () => actionIndividual('reject', data.id);

            // Button visibility based on status
            if (data.status === 'approved') {
                approveBtn.style.display = 'none';
                rejectBtn.style.display = 'flex';
            } else if (data.status === 'rejected') {
                approveBtn.style.display = 'flex';
                rejectBtn.style.display = 'none';
            } else {
                approveBtn.style.display = 'flex';
                rejectBtn.style.display = 'flex';
            }

            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }

        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }, 300);
        }

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closePhotoModal();
        });

        // Close on clicking outside container
        document.getElementById('photoModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('photoModal')) closePhotoModal();
        });
    </script>

@endsection