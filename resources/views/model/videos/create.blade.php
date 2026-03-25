@extends('layouts.model')

@section('title', __('model.videos.create.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">Dashboard</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.videos.index') }}" class="breadcrumb-item">{{ __('model.videos.index.breadcrumb') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.videos.create') }}" class="breadcrumb-item active">{{ __('model.videos.create.breadcrumb_new') }}</a>
@endsection

@section('styles')
<style>
    .upload-view-container {
        padding: 1.5rem;
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Glass Cards */
    .glass-card {
        background: rgba(31, 31, 35, 0.4);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(212, 175, 55, 0.1);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
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

    /* Upload Zones */
    .premium-dropzone {
        border: 2px dashed rgba(212, 175, 55, 0.3);
        border-radius: 20px;
        padding: 3rem 2rem;
        text-align: center;
        background: rgba(255, 255, 255, 0.02);
        cursor: pointer;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .premium-dropzone:hover, .premium-dropzone.drag-active {
        background: rgba(212, 175, 55, 0.05);
        border-color: var(--model-gold);
        transform: scale(1.01);
    }

    .dropzone-icon {
        font-size: 3rem;
        color: var(--model-gold);
        margin-bottom: 1rem;
        filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.2));
    }

    .dropzone-text h3 {
        font-size: 1.25rem;
        color: #fff;
        margin-bottom: 0.3rem;
    }

    .dropzone-text p {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
    }

    /* Selection Previews */
    .file-preview-strip {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: rgba(40, 167, 69, 0.1);
        border: 1px solid rgba(40, 167, 69, 0.2);
        border-radius: 15px;
        margin-top: 1rem;
        animation: slideIn 0.3s ease;
    }

    .preview-info { flex: 1; }
    .preview-name { color: #fff; font-weight: 600; font-size: 0.9rem; }
    .preview-size { color: rgba(255,255,255,0.5); font-size: 0.8rem; }

    /* Form Fields */
    .premium-field { margin-bottom: 2rem; }
    
    .premium-label {
        display: block;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
        padding-left: 0.25rem;
    }

    .premium-input, .premium-textarea {
        width: 100%;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .premium-input:focus, .premium-textarea:focus {
        border-color: var(--model-gold);
        background: rgba(0, 0, 0, 0.5);
        outline: none;
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.1);
    }

    /* Custom Checkbox */
    .modern-checkbox {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .modern-checkbox:hover { background: rgba(212, 175, 55, 0.05); border-color: rgba(212, 175, 55, 0.2); }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }

    .switch input { opacity: 0; width: 0; height: 0; }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: rgba(255, 255, 255, 0.1);
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px; width: 18px;
        left: 4px; bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider { background-color: var(--model-gold); }
    input:checked + .slider:before { transform: translateX(24px); background-color: #000; }

    /* Buttons */
    .btn-submit-premium {
        background: var(--model-gold);
        color: #000;
        padding: 1rem 3rem;
        border-radius: 15px;
        font-weight: 800;
        font-size: 1.1rem;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
    }

    .btn-submit-premium:hover:not(:disabled) {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(212, 175, 55, 0.4);
    }

    .btn-submit-premium:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* --- Upload Modal Styles --- */
    .premium-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    .modal-content-wrapper {
        position: relative;
        z-index: 10;
        width: 90%;
        max-width: 450px;
        animation: modalFadeUp 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .loading-card {
        background: rgba(25, 25, 25, 0.9);
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 30px;
        padding: 3.5rem 2rem;
        text-align: center;
        box-shadow: 0 40px 100px rgba(0,0,0,0.8), 0 0 30px rgba(212, 175, 55, 0.1);
    }

    .loading-card.error-card {
        border-color: rgba(220, 53, 69, 0.4);
        box-shadow: 0 40px 100px rgba(0,0,0,0.8), 0 0 30px rgba(220, 53, 69, 0.1);
    }

    .loading-icon {
        font-size: 5rem;
        color: var(--model-gold);
        margin-bottom: 2.5rem;
        filter: drop-shadow(0 0 20px rgba(212, 175, 55, 0.4));
        display: inline-block;
    }

    .loading-icon.error-icon {
        color: #ff4d4d;
        filter: drop-shadow(0 0 20px rgba(220, 53, 69, 0.4));
    }

    .loading-title {
        color: #fff;
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
        letter-spacing: -0.5px;
    }

    .loading-subtitle {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 2.5rem;
        padding: 0 1rem;
    }

    .progress-container {
        width: 100%;
        height: 8px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .progress-bar-fill {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: linear-gradient(90deg, transparent, var(--model-gold), transparent);
        border-radius: 10px;
        animation: progressShimmer 2s infinite linear;
    }

    @keyframes progressShimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    @keyframes modalFadeUp {
        from { opacity: 0; transform: translateY(30px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .btn-back-settings {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        padding: 1rem 2rem;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-back-settings:hover { background: rgba(255, 255, 255, 0.1); }

    .page-header-container { margin-bottom: 2.5rem; }
    .page-title-main { font-size: 28px; color: #d4af37; margin-bottom: 0.5rem; font-family: 'Poppins', sans-serif; font-weight: 700; line-height: 1.2; }
    .page-subtitle-main { color: #ffffff; font-size: 16px; }

    .form-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 3rem; }

    @media (max-width: 768px) {
        .upload-view-container { padding: 1rem; }
        .glass-card { padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem; }
        .page-header-container { margin-bottom: 1.5rem; }
        .page-title-main { font-size: 24px; }
        .page-subtitle-main { font-size: 14px; }
        .premium-dropzone { padding: 2rem 1rem; margin-bottom: 1rem; }
        .dropzone-icon { font-size: 2.5rem; margin-bottom: 0.8rem; }
        .dropzone-text h3 { font-size: 1.2rem; }
        .dropzone-text p { font-size: 0.8rem; }
        .section-title { font-size: 1.1rem; margin-bottom: 1.5rem; }
        .form-actions { flex-direction: column-reverse; gap: 1rem; margin-top: 2rem; }
        .form-actions a, .form-actions button { width: 100%; justify-content: center; text-align: center; }
        .modern-checkbox { padding: 1rem; gap: 0.75rem; }
        .file-preview-strip { flex-direction: column; align-items: flex-start; text-align: center; gap: 0.5rem; }
        .file-preview-strip img { margin: 0 auto; }
        .preview-info { width: 100%; }
        .preview-name { word-break: break-all; }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="upload-view-container">
    <div class="page-header-container">
        <h1 class="page-title-main">{{ __('model.videos.create.header_title') }}</h1>
        <p class="page-subtitle-main">{{ __('model.videos.create.header_subtitle') }}</p>
    </div>

    <form action="{{ route('model.videos.store') }}" method="POST" enctype="multipart/form-data" id="premiumVideoForm">
        @csrf

        <div class="glass-card">
            <h2 class="section-title"><i class="fas fa-video"></i> {{ __('model.videos.create.section_video') }}</h2>
            
            <div class="premium-dropzone" id="videoDropzone" onclick="document.getElementById('videoInput').click()">
                <div class="dropzone-icon"><i class="fas fa-file-video"></i></div>
                <div class="dropzone-text">
                    <h3>{{ __('model.videos.create.dropzone_video_title') }}</h3>
                    <p>{{ __('model.videos.create.dropzone_video_hint') }}</p>
                </div>
                <input type="file" name="video" id="videoInput" accept="video/*" hidden onchange="handleVideoSelect(event)">
            </div>

            <div id="videoPreview" style="display: none;">
                <div class="file-preview-strip">
                    <div style="color: var(--model-gold); font-size: 1.5rem;"><i class="fas fa-check-circle"></i></div>
                    <div class="preview-info">
                        <div class="preview-name" id="vName">video_file.mp4</div>
                        <div class="preview-size" id="vSize">0.0 MB</div>
                    </div>
                </div>
            </div>

            @error('video')
                <div style="color: #dc3545; font-size: 0.85rem; margin-top: 1rem; padding: 0.5rem; background: rgba(220,53,69,0.1); border-radius: 8px;">
                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <div class="glass-card">
            <h2 class="section-title"><i class="fas fa-image"></i> {{ __('model.videos.create.section_thumb') }}</h2>
            
            <div class="premium-dropzone" id="thumbDropzone" onclick="document.getElementById('thumbInput').click()">
                <div class="dropzone-icon" style="font-size: 2rem;"><i class="fas fa-image"></i></div>
                <div class="dropzone-text">
                    <h3>{{ __('model.videos.create.dropzone_thumb_title') }}</h3>
                    <p>{{ __('model.videos.create.dropzone_thumb_hint') }}</p>
                </div>
                <input type="file" name="thumbnail" id="thumbInput" accept="image/*" hidden onchange="handleThumbSelect(event)">
            </div>

            <div id="thumbPreview" style="display: none;">
                <div class="file-preview-strip" style="background: rgba(212, 175, 55, 0.05); border-color: rgba(212, 175, 55, 0.1); flex-direction: row; text-align: left;">
                    <img id="thumbImg" src="" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                    <div class="preview-info">
                        <div class="preview-name" id="tName">thumbnail.jpg</div>
                        <div class="preview-size">{{ __('model.videos.create.thumb_selected') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-card">
            <h2 class="section-title"><i class="fas fa-edit"></i> {{ __('model.videos.create.section_details') }}</h2>
            
            <div class="premium-field">
                <label class="premium-label">{{ __('model.videos.create.label_title') }}</label>
                <input type="text" name="title" class="premium-input" placeholder="{{ __('model.videos.create.placeholder_title') }}" value="{{ old('title') }}" required>
                @error('title') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="premium-field">
                <label class="premium-label">{{ __('model.videos.create.label_description') }}</label>
                <textarea name="description" class="premium-textarea" rows="4" placeholder="{{ __('model.videos.create.placeholder_description') }}">{{ old('description') }}</textarea>
                @error('description') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="premium-field">
                <label class="modern-checkbox">
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: #fff; margin-bottom: 0.25rem;">{{ __('model.videos.create.label_visibility') }}</div>
                        <div style="font-size: 0.85rem; color: rgba(255,255,255,0.5);">{{ __('model.videos.create.hint_visibility') }}</div>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </label>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('model.videos.index') }}" class="btn-back-settings">
                <i class="fas fa-chevron-left"></i> {{ __('model.videos.create.btn_back') }}
            </a>
            <button type="submit" class="btn-submit-premium" id="btnSubmit">
                <i class="fas fa-cloud-upload-alt"></i> {{ __('model.videos.create.btn_publish') }}
            </button>
        </div>
    </form>

    <!-- Uploading Modal -->
    <div id="uploadModal" class="premium-modal" style="display: none;">
        <div class="modal-backdrop"></div>
        <div class="modal-content-wrapper">
            <div class="loading-card">
                <div class="loading-icon">
                    <i class="fas fa-circle-notch fa-spin"></i>
                </div>
                <h2 class="loading-title">{{ __('model.videos.create.js_processing') }}</h2>
                <p class="loading-subtitle">{{ __('model.videos.create.js_processing_subtitle') }}</p>
                <div class="progress-container">
                    <div class="progress-bar-fill"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="premium-modal" style="display: none;">
        <div class="modal-backdrop" onclick="closeErrorModal()"></div>
        <div class="modal-content-wrapper">
            <div class="loading-card error-card">
                <div class="loading-icon error-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 class="loading-title" id="errorTitle">{{ __('model.videos.create.error_title') }}</h2>
                <p class="loading-subtitle" id="errorSubtitle"></p>
                <div style="padding: 0 1rem;">
                    <button type="button" class="btn-submit-premium" style="width: 100%; justify-content: center; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1);" onclick="closeErrorModal()">
                        {{ __('model.videos.create.error_button') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function handleVideoSelect(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate size
            if (file.size > 50 * 1024 * 1024) { // 50MB limit
                let errorMsg = "{{ __('model.videos.create.js_size_error', ['name' => ':name']) }}";
                showError("{{ __('model.videos.create.error_title') }}", errorMsg.replace(':name', file.name));
                e.target.value = ''; // Reset input
                document.getElementById('videoPreview').style.display = 'none';
                return;
            }

            // Validate format
            const allowedExtensions = ['mp4', 'mov', 'avi'];
            const extension = file.name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(extension)) {
                showError("{{ __('model.videos.create.error_title') }}", "{{ __('model.videos.create.js_format_error') }}");
                e.target.value = ''; // Reset input
                document.getElementById('videoPreview').style.display = 'none';
                return;
            }

            document.getElementById('videoPreview').style.display = 'block';
            document.getElementById('vName').innerText = file.name;
            document.getElementById('vSize').innerText = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
        }
    }

    function showError(title, subtitle) {
        document.getElementById('errorTitle').innerText = title;
        document.getElementById('errorSubtitle').innerText = subtitle;
        document.getElementById('errorModal').style.display = 'flex';
    }

    function closeErrorModal() {
        document.getElementById('errorModal').style.display = 'none';
    }

    function handleThumbSelect(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                document.getElementById('thumbImg').src = event.target.result;
                document.getElementById('thumbPreview').style.display = 'flex';
                document.getElementById('tName').innerText = file.name;
            };
            reader.readAsDataURL(file);
        }
    }

    // Form Loading State
    document.getElementById('premiumVideoForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        const modal = document.getElementById('uploadModal');
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('model.videos.create.js_processing') }}';
        
        // Show Premium Modal
        modal.style.display = 'flex';
    });
</script>
@endsection
