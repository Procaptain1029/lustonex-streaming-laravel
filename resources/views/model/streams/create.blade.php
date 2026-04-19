@extends('layouts.model')

@section('title', __('model.streams.create.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.streams.index') }}" class="breadcrumb-item">{{ __('model.streams.index.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.streams.go-live') }}" class="breadcrumb-item">{{ __('model.streams.go_live.breadcrumb') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.streams.create.breadcrumb_new') }}</span>
@endsection

@section('styles')
    <style>
        /* Fill viewport below model header; center content when it is shorter than the screen */
        .stream-create-page {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            min-height: calc(100svh - var(--model-header-height, 55px) - env(safe-area-inset-bottom, 0px));
            padding: clamp(0.75rem, 2.5vh, 1.75rem) 0 clamp(1.25rem, 4vh, 2.5rem);
            box-sizing: border-box;
        }

        .stream-create-page > .setup-container {
            width: 100%;
            flex: 0 1 auto;
        }

        /*
         * OBS: primary CTA stays visible — fixed dock at viewport bottom (content scrolls above).
         * Browser mode keeps vertical centering without a fixed bar.
         */
        .stream-create-page--obs {
            align-items: flex-start;
            min-height: 0;
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }

        .stream-create-page--obs .stream-create-obs-layout {
            padding-bottom: calc(10rem + env(safe-area-inset-bottom, 0px));
        }

        .stream-create-page--obs .stream-create-obs-action-bar {
            position: fixed;
            bottom: 0;
            left: var(--model-sidebar-width, 220px);
            right: 0;
            z-index: 900;
            border-radius: 18px 18px 0 0;
            border-left: none;
            border-right: none;
            border-bottom: none;
            border-top: 1px solid rgba(212, 175, 55, 0.28);
            box-shadow:
                0 -10px 40px rgba(0, 0, 0, 0.55),
                0 0 0 1px rgba(0, 0, 0, 0.35);
        }

        @media (max-width: 1024px) {
            .stream-create-page--obs .stream-create-obs-action-bar {
                left: 0;
            }
        }

        .stream-create-shell {
            --sc-card-pad: 1.85rem 2rem;
            --sc-gap: 1.65rem;
        }

        .stream-create-shell .page-title {
            font-size: 26px !important;
            line-height: 1.25 !important;
        }

        .stream-create-shell .stream-create-obs-col [role="alert"] {
            margin-bottom: 0.75rem !important;
            padding: 0.75rem 0.9rem !important;
            font-size: 0.8rem !important;
            line-height: 1.45 !important;
        }

        .setup-container {
            padding: 1rem 1.25rem 1.5rem;
            max-width: 1320px;
            margin: 0 auto;
        }

        .stream-create-header {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.75rem 1.5rem;
            margin-bottom: 2.35rem;
        }

        .stream-create-header .page-title {
            margin-bottom: 0.4rem !important;
        }

        .stream-create-header .page-subtitle {
            margin-bottom: 0 !important;
            font-size: 15px !important;
            line-height: 1.45;
            max-width: 52rem;
        }

        .stream-create-header-link {
            flex-shrink: 0;
            font-size: 0.88rem;
            font-weight: 700;
            color: #d4af37;
            text-decoration: underline;
            white-space: nowrap;
            padding-top: 0.45rem;
        }

        /* Glass Cards */
        .glass-card {
            background: rgba(31, 31, 35, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.1);
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            position: relative;
        }

        .stream-create-shell .glass-card {
            padding: var(--sc-card-pad);
            margin-bottom: 0;
            border-radius: 22px;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            color: var(--model-gold);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
            padding-bottom: 1rem;
        }

        .stream-create-shell .section-title {
            font-size: 1.15rem;
            margin-bottom: 1.15rem;
            padding-bottom: 0.75rem;
            gap: 0.65rem;
        }

        /* Custom Fields */
        .field-group {
            margin-bottom: 2rem;
        }

        .stream-create-shell .field-group {
            margin-bottom: 1.35rem;
        }

        .stream-create-shell .field-group:last-child {
            margin-bottom: 0;
        }

        .field-label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .stream-create-shell .field-label {
            font-size: 0.88rem;
            margin-bottom: 0.55rem;
        }

        .glass-input,
        .glass-textarea {
            width: 100%;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .stream-create-shell .glass-input,
        .stream-create-shell .glass-textarea {
            padding: 0.9rem 1.1rem;
            font-size: 0.98rem;
            border-radius: 12px;
        }

        .stream-create-shell .glass-textarea {
            min-height: 6.5rem;
            max-height: 16rem;
            resize: vertical;
            line-height: 1.5;
        }

        .glass-input:focus {
            border-color: var(--model-gold);
            outline: none;
            background: rgba(0, 0, 0, 0.5);
        }

        /* OBS Config Blocks */
        .config-block {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 18px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .stream-create-shell .config-block {
            padding: 1.1rem 1.25rem;
            margin-bottom: 1rem;
            border-radius: 16px;
        }

        .stream-create-shell .config-block:last-of-type {
            margin-bottom: 0.35rem;
        }

        .config-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stream-create-shell .config-header {
            margin-bottom: 0.65rem;
        }

        .config-label-text {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(212, 175, 55, 0.8);
            font-weight: 700;
        }

        .copy-panel {
            display: flex;
            gap: 10px;
            position: relative;
        }

        .copy-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 12px 15px;
            color: #fff;
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 0.9rem;
            width: 100%;
            cursor: text;
        }

        .stream-create-shell .copy-input {
            padding: 0.65rem 0.85rem;
            font-size: 0.88rem;
            border-radius: 10px;
        }

        .btn-copy-action {
            background: var(--model-gold);
            color: #000;
            border: none;
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .stream-create-shell .btn-copy-action {
            width: 46px;
            height: 46px;
            min-width: 46px;
            border-radius: 10px;
        }

        .btn-copy-action:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
        }

        /* Step Indicators */
        .setup-steps {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .step-item {
            display: flex;
            gap: 1.5rem;
        }

        .step-badge {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(212, 175, 55, 0.1);
            color: var(--model-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            border: 1px solid rgba(212, 175, 55, 0.3);
            flex-shrink: 0;
        }

        .step-body h4 {
            color: #fff;
            margin-bottom: 0.5rem;
            font-family: 'Poppins', sans-serif;
        }

        .step-body p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .stream-create-shell .setup-steps {
            gap: 1rem;
        }

        .stream-create-shell .step-item {
            gap: 0.65rem;
        }

        .stream-create-shell .step-badge {
            width: 32px;
            height: 32px;
            font-size: 0.82rem;
        }

        .stream-create-shell .step-body h4 {
            font-size: 0.92rem;
            margin-bottom: 0.3rem;
        }

        .stream-create-shell .step-body p {
            font-size: 0.82rem;
            line-height: 1.4;
            margin-bottom: 0;
        }

        /* Horizontal OBS steps (fits one viewport with 3-column layout) */
        .setup-steps-horizontal {
            display: flex;
            flex-direction: row;
            gap: 0.85rem;
            align-items: stretch;
        }

        .setup-steps-horizontal .step-item {
            flex: 1;
            min-width: 0;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.45rem;
        }

        .stream-create-card-divider {
            height: 1px;
            background: rgba(212, 175, 55, 0.12);
            margin: 1.1rem 0 0.85rem;
        }

        .stream-create-obs-layout {
            display: flex;
            flex-direction: column;
            gap: clamp(1.5rem, 3vw, 2rem);
        }

        .stream-create-obs-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1.08fr) minmax(0, 1.02fr);
            gap: clamp(1.5rem, 2.8vw, 2.35rem);
            /* Row height follows the tallest column; shorter columns optically balance via flex below */
            align-items: stretch;
        }

        .stream-create-obs-col {
            display: flex;
            flex-direction: column;
            gap: var(--sc-gap);
            min-width: 0;
            align-self: stretch;
        }

        /* Short columns (data + credentials): vertically center the card block in the row — avoids a huge empty “foot” */
        .stream-create-obs-col:not(.stream-create-obs-col--cta) {
            justify-content: center;
        }

        .stream-create-obs-col--cta {
            justify-content: flex-start;
        }

        /* Cards only as tall as their content */
        .stream-create-obs-col > .glass-card {
            flex: 0 1 auto;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .stream-create-obs-card {
            background: linear-gradient(160deg, rgba(42, 42, 48, 0.55) 0%, rgba(22, 22, 26, 0.88) 100%);
            border: 1px solid rgba(212, 175, 55, 0.14);
            box-shadow:
                0 1px 0 rgba(255, 255, 255, 0.04) inset,
                0 28px 56px rgba(0, 0, 0, 0.42);
            padding: 2rem 1.85rem !important;
        }

        .stream-create-obs-card--accent {
            border-color: rgba(212, 175, 55, 0.28);
        }

        /* OBS Quick Guide: full-width vertical steps (readable; avoids cramped 3-column text) */
        .setup-steps-obs-guide {
            display: flex;
            flex-direction: column;
            gap: 1.1rem;
            flex-shrink: 0;
        }

        .setup-steps-obs-guide .step-item {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 1.05rem;
            width: 100%;
            padding: 1.15rem 1.25rem 1.2rem 1.1rem;
            background: rgba(0, 0, 0, 0.28);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            border-left: 3px solid rgba(212, 175, 55, 0.6);
            box-sizing: border-box;
        }

        .setup-steps-obs-guide .step-badge {
            width: 38px;
            height: 38px;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .setup-steps-obs-guide .step-body {
            flex: 1;
            min-width: 0;
        }

        .setup-steps-obs-guide .step-body h4 {
            font-size: 1.05rem;
            margin-bottom: 0.45rem;
            color: #fff;
            letter-spacing: 0.01em;
        }

        .setup-steps-obs-guide .step-body p {
            font-size: 0.94rem;
            line-height: 1.6;
            margin: 0;
            color: rgba(255, 255, 255, 0.74);
        }

        /* Right column: guide + status — status block absorbs extra height */
        .stream-create-obs-stack-card .setup-steps-obs-guide {
            flex-shrink: 0;
        }

        .stream-create-obs-stack-card .stream-create-card-divider {
            flex-shrink: 0;
        }

        .stream-create-obs-stack-card .section-title {
            flex-shrink: 0;
        }

        .stream-create-obs-stack-card .test-zone {
            flex: 0 1 auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 0;
        }

        footer.stream-create-obs-action-bar {
            margin: 0;
        }

        /* Full-width publish strip — CTA no longer cramped inside the third card */
        .stream-create-obs-action-bar {
            border-radius: 20px;
            padding: clamp(1.35rem, 3vw, 1.85rem) clamp(1.5rem, 3.5vw, 2.25rem);
            background: linear-gradient(180deg, rgba(30, 30, 34, 0.92) 0%, rgba(16, 16, 18, 0.96) 100%);
            border: 1px solid rgba(212, 175, 55, 0.18);
            box-shadow:
                0 0 0 1px rgba(0, 0, 0, 0.35),
                0 20px 50px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .stream-create-obs-action-bar__inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0;
            max-width: 40rem;
            margin: 0 auto;
            text-align: center;
        }

        .stream-create-obs-action-btn {
            flex-shrink: 0;
        }

        .stream-create-obs-action-hint {
            margin: 1.75rem 0 0;
            max-width: 34rem;
            width: 100%;
            font-size: 0.9rem !important;
            line-height: 1.58 !important;
            color: rgba(255, 255, 255, 0.58) !important;
            text-align: center;
        }

        @media (max-width: 540px) {
            .stream-create-obs-action-btn {
                width: 100%;
                max-width: 22rem;
                justify-content: center;
            }
        }

        .stream-create-config-header {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.45rem 1rem;
        }

        .stream-create-warning-pill {
            font-size: 0.72rem;
            color: #ffc107;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .stream-create-hint-key {
            display: flex;
            align-items: flex-start;
            gap: 0.65rem;
            margin-top: auto;
            padding-top: 1.1rem;
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.52);
            line-height: 1.45;
        }

        .stream-create-status-desc {
            margin: 0;
            color: rgba(255, 255, 255, 0.58);
            font-size: 0.86rem;
            line-height: 1.48;
        }

        .stream-create-manual-check-wrap {
            margin-top: 0.7rem;
        }

        .stream-create-test-zone {
            border-color: rgba(212, 175, 55, 0.1) !important;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.055) 0%, rgba(0, 0, 0, 0.22) 100%) !important;
        }

        .stream-create-browser-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            column-gap: 2.35rem;
            row-gap: var(--sc-gap);
            align-items: stretch;
        }

        .stream-create-cta {
            text-align: center;
        }

        /* Browser flow: extra air above the primary button (cards → CTA) */
        .stream-create-cta:not(.stream-create-cta--inline) {
            margin-top: clamp(2.25rem, 5vh, 3rem);
        }

        .stream-create-shell .browser-info-text {
            font-size: 0.92rem !important;
            line-height: 1.55 !important;
        }

        /* Connection Test */
        .test-zone {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .stream-create-shell .test-zone {
            padding: 1.35rem 1.1rem;
            border-radius: 16px;
        }

        .stream-create-shell .test-zone .test-status {
            margin-bottom: 0.65rem;
        }

        .stream-create-shell .test-zone > p {
            margin-bottom: 0.75rem !important;
            font-size: 0.85rem !important;
            line-height: 1.45 !important;
        }

        .stream-create-shell .obs-help-pill {
            margin-bottom: 0;
            padding: 6px 13px;
            font-size: 0.82rem;
        }

        .test-status {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .stream-create-shell .test-status {
            font-size: 1rem;
            gap: 10px;
            flex-wrap: wrap;
        }

        .status-waiting {
            color: #ffc107;
        }

        .status-success {
            color: #28a745;
        }

        .pulse-amber {
            width: 10px;
            height: 10px;
            background: #ffc107;
            border-radius: 50%;
            animation: pulseAmber 2s infinite;
        }

        @keyframes pulseAmber {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
            }
        }

        .btn-main-start {
            background: var(--model-gold);
            color: #000;
            padding: 1.25rem 3.5rem;
            border-radius: 18px;
            font-weight: 800;
            font-size: 1.2rem;
            border: none;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 1rem;
        }

        .stream-create-shell .btn-main-start {
            padding: 1rem 2.75rem;
            border-radius: 16px;
            font-size: 1.1rem;
            gap: 0.75rem;
        }

        .stream-create-shell .stream-create-cta > p {
            margin-top: 1.35rem !important;
            font-size: 0.82rem !important;
        }

        .btn-main-start:disabled {
            opacity: 0.4;
            filter: grayscale(1);
            cursor: not-allowed;
        }

        .btn-main-start:hover:not(:disabled) {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(212, 175, 55, 0.4);
        }

        .obs-help-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.05);
            padding: 6px 14px;
            border-radius: 30px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1.5rem;
        }

        .setup-grid {
            grid-template-columns: 1fr 1fr;
        }

        .setup-grid-browser {
            grid-template-columns: 1fr !important;
            max-width: 720px;
            margin: 0 auto;
        }

        /* --- RESPONSIVE DESIGN --- */

        @media (max-width: 1100px) {
            .stream-create-obs-grid {
                grid-template-columns: 1fr 1fr;
            }

            .stream-create-obs-grid .stream-create-obs-col--cta {
                grid-column: 1 / -1;
            }
        }

        /* Tablat (≤ 900px) */
        @media (max-width: 900px) {
            .setup-grid {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }

            .stream-create-obs-grid {
                grid-template-columns: 1fr;
            }

            .stream-create-browser-grid {
                grid-template-columns: 1fr;
            }

            .stream-create-header {
                flex-direction: column;
            }
        }

        /* Mobile (≤ 768px) */
        @media (max-width: 768px) {
            .setup-container {
                padding: 1rem 0.8rem;
            }

            .glass-card {
                padding: 1.25rem;
                border-radius: 16px;
                margin-bottom: 1.25rem;
            }

            .setup-grid > div {
                gap: 1.25rem !important;
            }

            .section-title {
                font-size: 1.05rem;
                margin-bottom: 1.25rem;
                padding-bottom: 0.75rem;
            }

            h1.page-title {
                font-size: 24px !important;
            }
            p.page-subtitle {
                font-size: 14px !important;
            }

            /* OBS Guide compact */
            .setup-steps {
                gap: 1.25rem;
            }

            .step-item {
                gap: 1rem;
            }

            .step-badge {
                width: 28px;
                height: 28px;
                font-size: 0.85rem;
            }

            .step-body h4 {
                font-size: 0.95rem;
                margin-bottom: 0.25rem;
            }

            .step-body p {
                font-size: 0.8rem;
                margin-bottom: 0;
            }

            /* Form Fields compact */
            .field-group {
                margin-bottom: 1.25rem;
            }

            .field-label {
                font-size: 0.8rem;
                margin-bottom: 0.5rem;
            }

            .glass-input, .glass-textarea {
                padding: 0.8rem 1rem;
                font-size: 0.95rem;
            }

            .glass-textarea {
                min-height: 80px;
            }

            .config-block {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .config-label-text {
                font-size: 0.75rem;
            }

            .copy-input {
                padding: 10px 12px;
                font-size: 0.85rem;
            }

            .btn-main-start {
                padding: 1rem;
                font-size: 1rem;
                border-radius: 14px;
                width: 100%;
                justify-content: center;
            }

            .copy-panel {
                flex-direction: column;
                gap: 8px;
            }

            .copy-panel-row {
                display: flex;
                gap: 8px;
                width: 100%;
            }

            .btn-copy-action {
                height: 42px;
                border-radius: 8px;
                flex: 1;
            }

            .config-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
                margin-bottom: 0.75rem;
            }
        }

        /* Small Mobile (≤ 480px) */
        @media (max-width: 480px) {
            .glass-card {
                padding: 1rem;
                border-radius: 14px;
            }

            h1.page-title {
                font-size: 22px !important;
            }

            .section-title {
                font-size: 1rem;
                margin-bottom: 1rem;
                gap: 0.5rem;
            }

            .glass-input, .glass-textarea {
                padding: 0.75rem;
                font-size: 0.9rem;
            }

            .test-zone {
                padding: 1.25rem 1rem;
            }
            
            .obs-help-pill {
                padding: 5px 12px;
                font-size: 0.8rem;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $isObsMode = ($liveMode ?? 'browser') === 'obs';
    @endphp
    <div class="stream-create-page{{ $isObsMode ? ' stream-create-page--obs' : '' }}">
    <div class="setup-container stream-create-shell">
        <div class="stream-create-header">
            <div>
                <h1 class="page-title" style="color: #d4af37; font-family: 'Poppins', sans-serif;">{{ __('model.streams.create.header') }}</h1>
                <p class="page-subtitle" style="color: #ffffff;">
                    {{ $isObsMode ? __('model.streams.create.subtitle_obs') : __('model.streams.create.subtitle_browser') }}
                </p>
            </div>
            @if ($isObsMode)
                <a href="{{ route('model.streams.create', ['mode' => 'browser']) }}" class="stream-create-header-link">{{ __('model.streams.create.link_switch_browser') }}</a>
            @else
                <a href="{{ route('model.streams.create', ['mode' => 'obs']) }}" class="stream-create-header-link">{{ __('model.streams.create.link_switch_obs') }}</a>
            @endif
        </div>

        <form action="{{ route('model.streams.store') }}" method="POST" id="mainSetupForm">
            @csrf
            <input type="hidden" name="broadcast_mode" value="{{ $isObsMode ? 'obs' : 'browser' }}">

            @if ($isObsMode)
                <div class="stream-create-obs-layout">
                    <div class="stream-create-obs-grid">
                        <div class="stream-create-obs-col">
                            <div class="glass-card stream-create-obs-card">
                                <h3 class="section-title"><i class="fas fa-magic"></i> {{ __('model.streams.create.section_data') }}</h3>

                                <div class="field-group">
                                    <label class="field-label">{{ __('model.streams.create.label_title') }}</label>
                                    <input type="text" name="title" class="glass-input"
                                        placeholder="{{ __('model.streams.create.placeholder_title') }}" value="{{ old('title') }}" required>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">{{ __('model.streams.create.label_description') }}</label>
                                    <textarea name="description" class="glass-textarea" rows="3"
                                        placeholder="{{ __('model.streams.create.placeholder_description') }}">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="stream-create-obs-col">
                            @include('model.streams.partials.rtmp-public-url-warning')

                            <div class="glass-card stream-create-obs-card stream-create-obs-card--accent">
                                <h3 class="section-title"><i class="fas fa-key"></i> {{ __('model.streams.create.section_credentials') }}</h3>

                                <div class="config-block">
                                    <div class="config-header stream-create-config-header">
                                        <span class="config-label-text">{{ __('model.streams.create.label_server_url') }}</span>
                                    </div>
                                    <div class="copy-panel">
                                        <input type="text" value="{{ config('streaming.rtmp_public_url_base') }}" readonly class="copy-input"
                                            id="serverUrl">
                                        <button type="button" class="btn-copy-action" onclick="copyVal('serverUrl', this)">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="config-block">
                                    <div class="config-header stream-create-config-header">
                                        <span class="config-label-text">{{ __('model.streams.create.label_stream_key') }}</span>
                                        <span class="stream-create-warning-pill">{{ __('model.streams.create.warning_no_share') }}</span>
                                    </div>
                                    <div class="copy-panel">
                                        <input type="password" value="{{ $profile->stream_key }}" readonly class="copy-input"
                                            id="streamKey">
                                        <div class="copy-panel-row">
                                            <button type="button" class="btn-copy-action"
                                                style="background: rgba(255,255,255,0.1); color: #fff;"
                                                onclick="toggleVisibility('streamKey')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn-copy-action" onclick="copyVal('streamKey', this)">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <button type="button" class="btn-copy-action"
                                                style="background: rgba(13, 110, 253, 0.2); color: #007bff; border: 1px solid rgba(13, 110, 253, 0.3);"
                                                onclick="regenerateKey(this)" title="{{ __('model.streams.create.swal.regenerate_title') }}">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="stream-create-hint-key">
                                    <i class="fas fa-shield-alt" style="color: #28a745;"></i>
                                    {{ __('model.streams.create.hint_key') }}
                                </div>
                            </div>
                        </div>

                        <div class="stream-create-obs-col stream-create-obs-col--cta">
                            <div class="glass-card stream-create-obs-card stream-create-obs-stack-card">
                                <h3 class="section-title"><i class="fas fa-terminal"></i> {{ __('model.streams.create.section_obs_guide') }}</h3>
                                <div class="setup-steps setup-steps-obs-guide">
                                    <div class="step-item">
                                        <div class="step-badge">1</div>
                                        <div class="step-body">
                                            <h4>{{ __('model.streams.create.step1_title') }}</h4>
                                            <p>{!! __('model.streams.create.step1_desc') !!}</p>
                                        </div>
                                    </div>
                                    <div class="step-item">
                                        <div class="step-badge">2</div>
                                        <div class="step-body">
                                            <h4>{{ __('model.streams.create.step2_title') }}</h4>
                                            <p>{{ __('model.streams.create.step2_desc') }}</p>
                                        </div>
                                    </div>
                                    <div class="step-item">
                                        <div class="step-badge">3</div>
                                        <div class="step-body">
                                            <h4>{{ __('model.streams.create.step3_title') }}</h4>
                                            <p>{{ __('model.streams.create.step3_desc') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="stream-create-card-divider"></div>

                                <h3 class="section-title"><i class="fas fa-signal"></i> {{ __('model.streams.create.section_status') }}</h3>

                                <div class="test-zone stream-create-test-zone">
                                    <div id="connectionStatus" class="test-status status-waiting">
                                        <div class="pulse-amber"></div>
                                        {{ __('model.streams.create.status_waiting') }}
                                    </div>

                                    <p class="stream-create-status-desc">
                                        {{ __('model.streams.create.status_desc') }}
                                    </p>

                                    <div class="stream-create-manual-check-wrap">
                                        <button type="button" class="obs-help-pill" onclick="checkStatusManual()">
                                            <i class="fas fa-sync-alt"></i> {{ __('model.streams.create.btn_manual_check') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <footer class="stream-create-obs-action-bar">
                        <div class="stream-create-obs-action-bar__inner">
                            <button type="submit" class="btn-main-start stream-create-obs-action-btn" id="startBtn">
                                <i class="fas fa-broadcast-tower"></i> {{ __('model.streams.create.btn_start_live') }}
                            </button>
                            <p class="stream-create-obs-action-hint">{{ __('model.streams.create.hint_start') }}</p>
                        </div>
                    </footer>
                </div>
            @else
                <div class="stream-create-browser-grid">
                    <div class="glass-card">
                        <h3 class="section-title"><i class="fas fa-magic"></i> {{ __('model.streams.create.section_data') }}</h3>

                        <div class="field-group">
                            <label class="field-label">{{ __('model.streams.create.label_title') }}</label>
                            <input type="text" name="title" class="glass-input"
                                placeholder="{{ __('model.streams.create.placeholder_title') }}" value="{{ old('title') }}" required>
                        </div>

                        <div class="field-group">
                            <label class="field-label">{{ __('model.streams.create.label_description') }}</label>
                            <textarea name="description" class="glass-textarea" rows="3"
                                placeholder="{{ __('model.streams.create.placeholder_description') }}">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="glass-card" style="border-color: rgba(34, 197, 94, 0.35);">
                        <h3 class="section-title"><i class="fas fa-video"></i> {{ __('model.streams.create.section_browser') }}</h3>
                        <p class="browser-info-text" style="color: rgba(255,255,255,0.82); margin: 0;">
                            {{ __('model.streams.create.browser_info') }}
                        </p>
                    </div>
                </div>

                <div class="stream-create-cta">
                    <button type="submit" class="btn-main-start" id="startBtn">
                        <i class="fas fa-broadcast-tower"></i> {{ __('model.streams.create.btn_start_live') }}
                    </button>
                    <p style="color: rgba(255,255,255,0.4);">
                        {{ __('model.streams.create.hint_start_browser') }}
                    </p>
                </div>
            @endif
        </form>
    </div>
    </div>
@endsection

@section('scripts')
    <script>
        function copyVal(id, btn) {
            const input = document.getElementById(id);
            const originalType = input.type;
            input.type = 'text';
            input.select();
            document.execCommand('copy');
            input.type = originalType;

            const oldContent = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.style.background = '#28a745';

            setTimeout(() => {
                btn.innerHTML = oldContent;
                btn.style.background = '';
            }, 2000);

            Swal.fire({
                icon: 'success',
                title: '{{ __('model.streams.create.swal.copied_title') }}',
                text: '{{ __('model.streams.create.swal.copied_text') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#1f1f23',
                color: '#fff'
            });
        }

        function toggleVisibility(id) {
            const input = document.getElementById(id);
            const btn = event.currentTarget;
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }

        function regenerateKey(btn) {
            Swal.fire({
                title: '{{ __('model.streams.create.swal.regenerate_title') }}',
                text: '{{ __('model.streams.create.swal.regenerate_text') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d4af37',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __('model.streams.create.swal.regenerate_confirm') }}',
                background: '#1f1f23',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    const oldContent = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    btn.disabled = true;

                    fetch("{{ route('model.obs.generate-key') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('streamKey').value = data.stream_key;
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ __('model.streams.create.swal.regenerate_success_title') }}',
                                    text: '{{ __('model.streams.create.swal.regenerate_success_text') }}',
                                    background: '#1f1f23',
                                    color: '#fff'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __('model.streams.create.swal.error_title') }}',
                                    text: data.message || '{{ __('model.streams.create.swal.error_text') }}',
                                    background: '#1f1f23',
                                    color: '#fff'
                                });
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('model.streams.create.swal.server_error_title') }}',
                                text: '{{ __('model.streams.create.swal.server_error_text') }}',
                                background: '#1f1f23',
                                color: '#fff'
                            });
                        })
                        .finally(() => {
                            btn.innerHTML = oldContent;
                            btn.disabled = false;
                        });
                }
            });
        }

        // Detección de señal real
        let checkInterval = null;
        const streamKeyToCheck = "{{ $profile->stream_key }}";

        function startAutoCheck() {
            if (checkInterval) clearInterval(checkInterval);

            checkInterval = setInterval(() => {
                checkStatusReal();
            }, 3000);
        }

        async function checkStatusReal() {
            try {
                const response = await fetch(`/api/rtmp/check-signal/${streamKeyToCheck}`);
                const data = await response.json();

                if (data.active) {
                    const statusBox = document.getElementById('connectionStatus');
                    const startBtn = document.getElementById('startBtn');

                    statusBox.innerHTML = '<i class="fas fa-check-circle" style="color: #28a745;"></i> {{ __('model.streams.create.status_success') }}';
                    statusBox.className = 'test-status status-success';

                    startBtn.innerHTML = '<i class="fas fa-broadcast-tower"></i> {{ __('model.streams.create.btn_start_live') }}';

                    // Detener el polling una vez detectado
                    clearInterval(checkInterval);

                    Swal.fire({
                        icon: 'success',
                        title: '{{ __('model.streams.create.swal.success_conn_title') }}',
                        text: '{{ __('model.streams.create.swal.success_conn_text') }}',
                        background: '#1f1f23',
                        color: '#fff',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000
                    });
                }
            } catch (error) {
                console.error('Error verificando señal:', error);
            }
        }

        function checkStatusManual() {
            const btn = event.currentTarget;
            const oldContent = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('model.streams.create.swal.loading_check') }}';
            btn.disabled = true;

            checkStatusReal().finally(() => {
                setTimeout(() => {
                    btn.innerHTML = oldContent;
                    btn.disabled = false;
                }, 1000);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            startAutoCheck();
        });
    </script>
@endsection