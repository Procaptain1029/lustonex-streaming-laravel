@extends('layouts.model')

@section('title', __('model.earnings.exports.title') . ' - Lustonex')

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}">{{ __('layouts.model.nav.dashboard') }}</a>
    <i class="fas fa-chevron-right"></i>
    <span class="active">{{ __('model.earnings.exports.title') }}</span>
@stop

@section('content')
<div class="sh-container">
    <div class="page-header mb-4">
        <h1 class="sh-title"> {{ __('model.earnings.exports.title') }}</h1>
        <p class="sh-subtitle">{{ __('model.earnings.exports.subtitle') }}</p>
    </div>

    <!-- Export Grid (Similar to Admin) -->
    <div class="sh-export-grid">
        <!-- Earnings Export -->
        <a href="{{ route('model.exports.earnings') }}" class="sh-stat-card">
            <div class="sh-stat-icon-box">
                <i class="fas fa-piggy-bank"></i>
            </div>
            <div class="sh-stat-info">
                <span class="sh-stat-label">{{ __('model.earnings.exports.earnings.label') }}</span>
                <p class="sh-stat-description">{{ __('model.earnings.exports.earnings.desc') }}</p>
                <div class="sh-download-link">
                    <i class="fas fa-cloud-download-alt"></i> {{ __('model.earnings.exports.download') }}
                </div>
            </div>
        </a>

        <!-- Performance Export -->
        <a href="{{ route('model.exports.performance') }}" class="sh-stat-card">
            <div class="sh-stat-icon-box">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="sh-stat-info">
                <span class="sh-stat-label">{{ __('model.earnings.exports.performance.label') }}</span>
                <p class="sh-stat-description">{{ __('model.earnings.exports.performance.desc') }}</p>
                <div class="sh-download-link">
                    <i class="fas fa-cloud-download-alt"></i> {{ __('model.earnings.exports.download') }}
                </div>
            </div>
        </a>

        <!-- Withdrawals Export -->
        <a href="{{ route('model.exports.withdrawals') }}" class="sh-stat-card">
            <div class="sh-stat-icon-box">
                <i class="fas fa-history"></i>
            </div>
            <div class="sh-stat-info">
                <span class="sh-stat-label">{{ __('model.earnings.exports.withdrawals.label') }}</span>
                <p class="sh-stat-description">{{ __('model.earnings.exports.withdrawals.desc') }}</p>
                <div class="sh-download-link">
                    <i class="fas fa-cloud-download-alt"></i> {{ __('model.earnings.exports.download') }}
                </div>
            </div>
        </a>
    </div>

    <!-- Info Box -->
    <div class="sh-export-footer-info">
        <i class="fas fa-info-circle mr-3" style="font-size: 1.5rem; color: var(--model-gold);"></i>
        <div>
            <p class="mb-1"><strong>Nota:</strong> Los archivos se exportan en formato <strong>CSV (UTF-8)</strong>.</p>
            <p class="mb-0 text-muted small">Si al abrir el archivo en Excel los caracteres especiales no se muestran correctamente, use la opción "Importar datos de texto" y seleccione Codificación UTF-8.</p>
        </div>
    </div>
</div>

<style>
    :root {
        --model-gold: #D4AF37;
    }

    .sh-container {
        padding: 2rem;
    }

    .page-header {
        margin-bottom: 32px;
    }

    .sh-title {
        font-family: 'Poppins', sans-serif;
        font-size: 40px;
        font-weight: 700;
        color: #d4af37;
        margin-bottom: 16px;
        line-height: 1.2;
    }

    .sh-subtitle {
        font-size: 18px;
        color: #ffffff;
        max-width: 620px;
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
        border-color: var(--model-gold);
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
        color: var(--model-gold);
        margin-bottom: 16px;
    }

    .sh-stat-info {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .sh-stat-label {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 4px;
        color: rgba(255, 255, 255, 0.9);
    }

    .sh-stat-description {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.45);
        line-height: 1.4;
        margin-bottom: 16px;
    }

    .sh-download-link {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--model-gold);
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
        color: var(--model-gold);
        font-size: 20px;
        margin-top: 2px;
    }

    .sh-export-footer-info p {
        font-size: 14px;
        line-height: 1.5;
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
    }

    @media (max-width: 768px) {
        .sh-title {
            font-size: 28px;
            margin-bottom: 16px;
        }

        .sh-subtitle {
            font-size: 16px;
            margin-bottom: 18px;
            color: #fff;
        }
    }

    @media (max-width: 480px) {
        .sh-title {
            font-size: 24px;
        }

        .sh-subtitle {
            font-size: 14px;
        }
    }

    @media (max-width: 1400px) {
        .sh-export-grid {
            grid-template-columns: repeat(3, 1fr);
        }
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
