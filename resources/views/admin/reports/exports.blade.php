@extends('layouts.admin')

@section('title', __('admin.reports.exports.title'))

@section('breadcrumb')
    <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard.title') }}</a></span>
    <span class="breadcrumb-item active">{{ __('admin.reports.exports.title') }}</span>
@endsection

@section('styles')
    <style>
        /* Reutilizando los estilos exactos del Dashboard para consistencia total */
        .page-header {
            margin-bottom: 32px;
        }

        .sh-export-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 32px;
        }

        .sh-stat-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            transition: all 0.2s ease-out;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            text-decoration: none;
        }

        .sh-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--admin-gold);
        }

        .sh-stat-icon-box {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            background: rgba(212, 175, 55, 0.1);
            color: var(--admin-gold);
            margin-bottom: 16px;
        }

        .sh-stat-info {
            display: flex;
            flex-direction: column;
        }

        .sh-stat-label {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
            color: rgba(255, 255, 255, 0.7);
        }

        .sh-stat-description {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
            line-height: 1.4;
            margin-bottom: 16px;
        }

        .sh-download-link {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--admin-gold);
            margin-top: auto;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sh-export-footer-info {
            padding: 24px;
            border-radius: 12px;
            background: rgba(212, 175, 55, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.15);
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-top: 16px;
        }

        .sh-export-footer-info i {
            color: var(--admin-gold);
            font-size: 20px;
            margin-top: 2px;
        }

        .sh-export-footer-info p {
            font-size: 14px;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }

        @media (max-width: 1200px) {
            .sh-export-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .sh-export-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.reports.exports.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.reports.exports.subtitle') }}</p>
    </div>

    <div class="sh-export-grid">
        <!-- Usuarios -->
        <a href="{{ route('admin.reports.exports.users') }}" class="sh-stat-card">
            <div class="sh-stat-icon-box">
                <i class="fas fa-users"></i>
            </div>
            <div class="sh-stat-info">
                <span class="sh-stat-label">{{ __('admin.reports.exports.users.label') }}</span>
                <p class="sh-stat-description">{{ __('admin.reports.exports.users.desc') }}</p>
                <div class="sh-download-link">
                    <i class="fas fa-cloud-download-alt"></i> {{ __('admin.reports.exports.download') }}
                </div>
            </div>
        </a>

        <!-- Transacciones -->
        <a href="{{ route('admin.reports.exports.transactions') }}" class="sh-stat-card">
            <div class="sh-stat-icon-box">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div class="sh-stat-info">
                <span class="sh-stat-label">{{ __('admin.reports.exports.transactions.label') }}</span>
                <p class="sh-stat-description">{{ __('admin.reports.exports.transactions.desc') }}</p>
                <div class="sh-download-link">
                    <i class="fas fa-cloud-download-alt"></i> {{ __('admin.reports.exports.download') }}
                </div>
            </div>
        </a>

        <!-- Liquidaciones -->
        <a href="{{ route('admin.reports.exports.withdrawals') }}" class="sh-stat-card">
            <div class="sh-stat-icon-box">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="sh-stat-info">
                <span class="sh-stat-label">{{ __('admin.reports.exports.withdrawals.label') }}</span>
                <p class="sh-stat-description">{{ __('admin.reports.exports.withdrawals.desc') }}</p>
                <div class="sh-download-link">
                    <i class="fas fa-cloud-download-alt"></i> {{ __('admin.reports.exports.download') }}
                </div>
            </div>
        </a>

        <!-- Streams -->
        <a href="{{ route('admin.reports.exports.streams') }}" class="sh-stat-card">
            <div class="sh-stat-icon-box">
                <i class="fas fa-video"></i>
            </div>
            <div class="sh-stat-info">
                <span class="sh-stat-label">{{ __('admin.reports.exports.streams.label') }}</span>
                <p class="sh-stat-description">{{ __('admin.reports.exports.streams.desc') }}</p>
                <div class="sh-download-link">
                    <i class="fas fa-cloud-download-alt"></i> {{ __('admin.reports.exports.download') }}
                </div>
            </div>
        </a>

        <!-- Suscripciones -->
        <a href="{{ route('admin.reports.exports.subscriptions') }}" class="sh-stat-card">
            <div class="sh-stat-icon-box">
                <i class="fas fa-id-badge"></i>
            </div>
            <div class="sh-stat-info">
                <span class="sh-stat-label">{{ __('admin.reports.exports.subscriptions.label') }}</span>
                <p class="sh-stat-description">{{ __('admin.reports.exports.subscriptions.desc') }}</p>
                <div class="sh-download-link">
                    <i class="fas fa-cloud-download-alt"></i> {{ __('admin.reports.exports.download') }}
                </div>
            </div>
        </a>
    </div>

    <div class="sh-export-footer-info">
        <i class="fas fa-info-circle"></i>
        <p>
            <strong>{{ __('admin.reports.exports.info_box.title') }}</strong> 
            {{ __('admin.reports.exports.info_box.text') }}
        </p>
    </div>
@endsection
