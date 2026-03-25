@extends('layouts.admin')

@section('title', __('admin.verification.show.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('admin.verification.index') }}" class="breadcrumb-item">{{ __('admin.verification.index.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.verification.show.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Verification Detail Professional Styling ----- */

        .page-header {
            padding-top: 64px;
            margin-bottom: 32px;
        }


        .sh-review-container {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            align-items: start;
            margin-bottom: 50px;
        }

        .sh-review-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .sh-card-header {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.01);
        }

        .sh-card-title {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sh-card-body {
            padding: 32px;
        }

        /* Profile Summary */
        .sh-profile-row {
            display: flex;
            align-items: flex-start;
            gap: 24px;
            margin-bottom: 40px;
        }

        .sh-big-avatar {
            width: 100px;
            height: 100px;
            border-radius: 20px;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .sh-profile-info h2 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 8px 0;
            color: #fff;
        }

        .sh-profile-meta {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        /* Data Grid */
        .sh-data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 24px;
        }

        .sh-data-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 6px;
            display: block;
        }

        .sh-data-value {
            font-size: 16px;
            font-weight: 500;
            color: #fff;
        }

        /* Documents */
        .sh-doc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 24px;
            margin-top: 10px;
        }

        .sh-doc-item {
            background: #000;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s;
        }

        .sh-doc-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border-color: var(--admin-gold);
        }

        .sh-doc-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            cursor: zoom-in;
        }

        .sh-doc-label {
            padding: 12px;
            font-size: 12px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
            background: rgba(255, 255, 255, 0.02);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Action Sidebar */
        .sh-action-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sh-textarea {
            width: 100%;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 16px;
            color: #fff;
            font-size: 14px;
            resize: vertical;
            min-height: 100px;
        }

        .sh-textarea:focus {
            outline: none;
            border-color: var(--admin-gold);
            background: rgba(0, 0, 0, 0.4);
        }

        .sh-btn-block {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sh-btn-approve {
            background: var(--admin-gold);
            color: #000;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
        }

        .sh-btn-approve:hover {
            transform: scale(1.02);
            background: #e5bd3d;
        }

        .sh-btn-reject {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .sh-btn-reject:hover {
            background: #ef4444;
            color: #fff;
            transform: scale(1.02);
        }

        @media (max-width: 1100px) {
            .sh-review-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {


            .sh-profile-row {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .sh-review-card {
                border-radius: 16px;
            }

            .sh-card-body {
                padding: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.verification.show.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.verification.show.subtitle') }}</p>
    </div>

    <div class="sh-review-container">

        <div class="sh-review-main">
            <div class="sh-review-card" style="margin-bottom: 30px;">
                <div class="sh-card-body">
                    <div class="sh-profile-row">
                        <img src="{{ $profile->avatar_url ? asset($profile->avatar_url) : asset('images/default-avatar.png') }}"
                            class="sh-big-avatar" alt="{{ $profile->display_name }}"
                            onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                        <div class="sh-profile-info">
                            <h2>{{ $profile->display_name ?? $profile->user->name }}</h2>
                            <div class="sh-profile-meta">
                                <span>{{ __('admin.verification.show.profile.id') }}{{ $profile->id }}</span>
                                <span>{{ __('admin.verification.show.profile.email') }}{{ $profile->user->email }}</span>
                                @if($profile->user->email_verified_at)
                                    <span style="color: #10b981; font-weight: 600; margin-top: 4px;"><i
                                            class="fas fa-check-circle"></i> {{ __('admin.verification.show.profile.email_verified') }}</span>
                                @else
                                    <span style="color: #ef4444; font-weight: 600; margin-top: 4px;"><i
                                            class="fas fa-times-circle"></i> {{ __('admin.verification.show.profile.email_unverified') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="sh-data-grid">
                        <div>
                            <span class="sh-data-label">{{ __('admin.verification.show.profile.legal_name') }}</span>
                            <div class="sh-data-value">{{ $profile->legal_name ?? __('admin.verification.show.profile.not_provided') }}</div>
                        </div>
                        <div>
                            <span class="sh-data-label">{{ __('admin.verification.show.profile.country') }}</span>
                            <div class="sh-data-value">
                                {{ $profile->country ? App\Helpers\CountryHelper::getCountryName($profile->country) : __('admin.verification.show.profile.not_provided') }}
                            </div>
                        </div>
                        <div>
                            <span class="sh-data-label">{{ __('admin.verification.show.profile.age') }}</span>
                            <div class="sh-data-value">
                                @if($profile->date_of_birth)
                                    {{ \Carbon\Carbon::parse($profile->date_of_birth)->age }} {{ __('admin.verification.show.profile.years') }} ({{ \Carbon\Carbon::parse($profile->date_of_birth)->format('d/m/Y') }})
                                @elseif($profile->age)
                                    {{ $profile->age }} {{ __('admin.verification.show.profile.years') }}
                                @else
                                    {{ __('admin.verification.show.profile.not_provided') }}
                                @endif
                            </div>
                        </div>
                        <div>
                            <span class="sh-data-label">{{ __('admin.verification.show.profile.id_document') }}</span>
                            <div class="sh-data-value">{{ $profile->id_number ?? __('admin.verification.show.profile.not_provided') }}</div>
                        </div>
                        <div>
                            <span class="sh-data-label">{{ __('admin.verification.show.profile.registered_at') }}</span>
                            <div class="sh-data-value">{{ $profile->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sh-review-card">
                <div class="sh-card-header">
                    <i class="fas fa-file-alt" style="color: var(--admin-gold);"></i>
                    <h3 class="sh-card-title">{{ __('admin.verification.show.documents.title') }}</h3>
                </div>
                <div class="sh-card-body">
                    @if($profile->id_document_front || $profile->id_document_back || $profile->id_document_selfie)
                        <div class="sh-doc-grid">
                            @if($profile->id_document_front)
                                <div class="sh-doc-item">
                                    <img src="{{ asset('storage/' . $profile->id_document_front) }}" class="sh-doc-img"
                                        onclick="window.open(this.src, '_blank')">
                                    <div class="sh-doc-label">{{ __('admin.verification.show.documents.front') }}</div>
                                </div>
                            @endif

                            @if($profile->id_document_back)
                                <div class="sh-doc-item">
                                    <img src="{{ asset('storage/' . $profile->id_document_back) }}" class="sh-doc-img"
                                        onclick="window.open(this.src, '_blank')">
                                    <div class="sh-doc-label">{{ __('admin.verification.show.documents.back') }}</div>
                                </div>
                            @endif

                            @if($profile->id_document_selfie)
                                <div class="sh-doc-item">
                                    <img src="{{ asset('storage/' . $profile->id_document_selfie) }}" class="sh-doc-img"
                                        onclick="window.open(this.src, '_blank')">
                                    <div class="sh-doc-label" style="color: var(--admin-gold);">{{ __('admin.verification.show.documents.selfie') }}</div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div
                            style="padding: 40px; text-align: center; color: rgba(255,255,255,0.3); border: 2px dashed rgba(255,255,255,0.1); border-radius: 12px;">
                            <i class="fas fa-folder-open" style="font-size: 32px; margin-bottom: 16px; opacity: 0.5;"></i>
                            <p>{{ __('admin.verification.show.documents.empty') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>


        <div class="sh-review-sidebar">
            <div class="sh-review-card">
                <div class="sh-card-header">
                    <i class="fas fa-gavel" style="color: var(--admin-gold);"></i>
                    <h3 class="sh-card-title">{{ __('admin.verification.show.resolution.title') }}</h3>
                </div>
                <div class="sh-card-body">
                    @if($profile->verification_status !== 'approved')
                        <div class="sh-action-form">
                            <form action="{{ route('admin.verification.approve', $profile) }}" method="POST">
                                @csrf
                                <span class="sh-data-label">{{ __('admin.verification.show.resolution.notes_label') }}</span>
                                <textarea name="admin_notes" class="sh-textarea"
                                    placeholder="{{ __('admin.verification.show.resolution.notes_placeholder') }}"
                                    style="margin-bottom: 16px;"></textarea>

                                <button type="submit" class="sh-btn-block sh-btn-approve">
                                    <i class="fas fa-check"></i> {{ __('admin.verification.show.resolution.btn_approve') }}
                                </button>
                            </form>

                            <div style="height: 1px; background: rgba(255,255,255,0.1); margin: 5px 0;"></div>

                            <form action="{{ route('admin.verification.reject', $profile) }}" method="POST"
                                onsubmit="return confirm('{{ __('admin.verification.show.resolution.confirm_reject') }}')">
                                @csrf
                                <span class="sh-data-label">{{ __('admin.verification.show.resolution.reject_reason_label') }}</span>
                                <textarea name="rejection_reason" class="sh-textarea"
                                    placeholder="{{ __('admin.verification.show.resolution.reject_reason_placeholder') }}" required
                                    style="margin-bottom: 16px; border-color: rgba(239,68,68,0.3);"></textarea>

                                <button type="submit" class="sh-btn-block sh-btn-reject">
                                    <i class="fas fa-times"></i> {{ __('admin.verification.show.resolution.btn_reject') }}
                                </button>
                            </form>
                        </div>
                    @else
                        <div style="text-align: center; padding: 20px;">
                            <div
                                style="width: 64px; height: 64px; border-radius: 50%; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px auto;">
                                <i class="fas fa-check"></i>
                            </div>
                            <h3 style="color: #fff; font-size: 18px; margin-bottom: 8px;">{{ __('admin.verification.show.resolution.verified_title') }}</h3>
                            <p style="color: rgba(255,255,255,0.5); font-size: 14px;">{{ __('admin.verification.show.resolution.verified_desc') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection