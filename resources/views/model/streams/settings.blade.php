@extends('layouts.model')

@section('title', __('model.streams.settings.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">Dashboard</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.streams.index') }}" class="breadcrumb-item">{{ __('model.streams.index.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">Configuración</span>
@endsection

@section('styles')
<style>
    .settings-wrapper {
        max-width: 800px;
        margin: 0 auto;
        padding: 1rem;
    }

    .glass-card {
        background: rgba(18, 18, 22, 0.7);
        backdrop-filter: blur(25px);
        border: 1px solid rgba(212, 175, 55, 0.15);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-label {
        display: block;
        font-weight: 700;
        color: var(--accent-gold);
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-control-custom {
        width: 100%;
        background: rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        color: #fff;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus {
        border-color: var(--accent-gold);
        outline: none;
        box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
    }

    .preview-box {
        margin-top: 1rem;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.05);
        background: #000;
        aspect-ratio: 16/9;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-box img, .preview-box video {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .mode-selector {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .mode-option {
        position: relative;
    }

    .mode-option input {
        position: absolute;
        opacity: 0;
    }

    .mode-label {
        display: block;
        padding: 1rem;
        text-align: center;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: rgba(255,255,255,0.5);
        font-weight: 700;
    }

    .mode-option input:checked + .mode-label {
        background: rgba(212, 175, 55, 0.1);
        border-color: var(--accent-gold);
        color: var(--accent-gold);
    }

    .btn-save {
        background: var(--accent-gold);
        color: #000;
        font-weight: 800;
        padding: 1rem 2rem;
        border-radius: 14px;
        border: none;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        justify-content: center;
        margin-top: 1rem;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(212, 175, 55, 0.4);
    }
</style>
@endsection

@section('content')
<div class="settings-wrapper">
    <div class="glass-card">
        <h2 style="color: #fff; margin-bottom: 2rem; font-family: 'Poppins';">{{ __('model.streams.settings.header_pause') }}</h2>
        
        <form action="{{ route('model.streams.updateSettings') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label class="form-label">{{ __('model.streams.settings.label_pause_mode') }}</label>
                <div class="mode-selector">
                    <div class="mode-option">
                        <input type="radio" name="pause_mode" value="none" id="mode_none" {{ $profile->pause_mode === 'none' ? 'checked' : '' }}>
                        <label for="mode_none" class="mode-label">
                            <i class="fas fa-ban" style="display: block; margin-bottom: 5px;"></i> {{ __('model.streams.settings.mode_none') }}
                        </label>
                    </div>
                    <div class="mode-option">
                        <input type="radio" name="pause_mode" value="image" id="mode_image" {{ $profile->pause_mode === 'image' ? 'checked' : '' }}>
                        <label for="mode_image" class="mode-label">
                            <i class="fas fa-image" style="display: block; margin-bottom: 5px;"></i> {{ __('model.streams.settings.mode_image') }}
                        </label>
                    </div>
                    <div class="mode-option">
                        <input type="radio" name="pause_mode" value="video" id="mode_video" {{ $profile->pause_mode === 'video' ? 'checked' : '' }}>
                        <label for="mode_video" class="mode-label">
                            <i class="fas fa-video" style="display: block; margin-bottom: 5px;"></i> {{ __('model.streams.settings.mode_video') }}
                        </label>
                    </div>
                </div>
                <p style="font-size: 0.8rem; color: rgba(255,255,255,0.4);">{{ __('model.streams.settings.hint_pause_mode') }}</p>
            </div>

            <div id="image_section" class="form-group" style="display: {{ $profile->pause_mode === 'image' ? 'block' : 'none' }}">
                <label class="form-label">{{ __('model.streams.settings.label_pause_image') }}</label>
                <input type="file" name="pause_image" class="form-control-custom" accept="image/*">
                <div class="preview-box">
                    @if($profile->pause_image)
                        <img src="{{ asset('storage/' . $profile->pause_image) }}" alt="Preview">
                    @else
                        <span style="color: rgba(255,255,255,0.2);">{{ __('model.streams.settings.empty_image') }}</span>
                    @endif
                </div>
            </div>

            <div id="video_section" class="form-group" style="display: {{ $profile->pause_mode === 'video' ? 'block' : 'none' }}">
                <label class="form-label">{{ __('model.streams.settings.label_pause_video') }}</label>
                <input type="file" name="pause_video" class="form-control-custom" accept="video/*">
                <div class="preview-box">
                    @if($profile->pause_video)
                        <video src="{{ asset('storage/' . $profile->pause_video) }}" controls></video>
                    @else
                        <span style="color: rgba(255,255,255,0.2);">{{ __('model.streams.settings.empty_video') }}</span>
                    @endif
                </div>
            </div>

            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> {{ __('model.streams.settings.btn_save') }}
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="pause_mode"]');
        const imgSection = document.getElementById('image_section');
        const vidSection = document.getElementById('video_section');

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                imgSection.style.display = (this.value === 'image') ? 'block' : 'none';
                vidSection.style.display = (this.value === 'video') ? 'block' : 'none';
            });
        });
    });
</script>
@endsection
