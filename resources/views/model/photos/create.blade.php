@extends('layouts.model')

@section('title', __('model.photos.create.title_tag'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.photos.index.breadcrumb_dashboard') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.photos.index') }}" class="breadcrumb-item">{{ __('model.photos.create.breadcrumb_photos') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.photos.create') }}" class="breadcrumb-item active">{{ __('model.photos.create.breadcrumb_active') }}</a>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
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

    /* Upload Zone */
    .premium-dropzone {
        border: 2px dashed rgba(212, 175, 55, 0.3);
        border-radius: 20px;
        padding: 3.5rem 2rem;
        text-align: center;
        background: rgba(255, 255, 255, 0.02);
        cursor: pointer;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .premium-dropzone:hover, .premium-dropzone.drag-active {
        background: rgba(212, 175, 55, 0.05);
        border-color: var(--model-gold);
        transform: scale(1.01);
    }

    .dropzone-icon {
        font-size: 4rem;
        color: var(--model-gold);
        margin-bottom: 1.5rem;
        filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.2));
    }

    .dropzone-text h3 {
        font-size: 1.5rem;
        color: #fff;
        margin-bottom: 0.5rem;
    }

    .dropzone-text p {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.9rem;
    }

    /* Multi-Preview */
    .previews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .preview-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 15px;
        overflow: hidden;
        border: 2px solid rgba(212, 175, 55, 0.2);
        animation: fadeIn 0.4s ease forwards;
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .remove-preview {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 28px;
        height: 28px;
        background: rgba(220, 53, 69, 0.9);
        color: #fff;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    .remove-preview:hover { transform: scale(1.1); background: #dc3545; }

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
        .premium-dropzone { padding: 2rem 1rem; }
        .dropzone-icon { font-size: 2.5rem; margin-bottom: 1rem; }
        .dropzone-text h3 { font-size: 1.2rem; }
        .dropzone-text p { font-size: 0.8rem; }
        .section-title { font-size: 1.1rem; margin-bottom: 1.5rem; }
        .form-actions { flex-direction: column-reverse; gap: 1rem; margin-top: 2rem; }
        .form-actions a, .form-actions button { width: 100%; justify-content: center; text-align: center; }
        .modern-checkbox { padding: 1rem; gap: 0.75rem; }
        .previews-grid { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 1rem; }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@endsection

@section('content')
<div class="upload-view-container">
    <div class="page-header-container">
        <h1 class="page-title-main">{{ __('model.photos.create.header_title') }}</h1>
        <p class="page-subtitle-main">{{ __('model.photos.create.header_subtitle') }}</p>
    </div>

    <form action="{{ route('model.photos.store') }}" method="POST" enctype="multipart/form-data" id="premiumUploadForm">
        @csrf

        <div class="glass-card">
            <h2 class="section-title"><i class="fas fa-cloud-upload-alt"></i> {{ __('model.photos.create.section_upload') }}</h2>
            
            <div class="premium-dropzone" id="dropzone" onclick="document.getElementById('fileInput').click()">
                <div class="dropzone-icon"><i class="fas fa-images"></i></div>
                <div class="dropzone-text">
                    <h3>{{ __('model.photos.create.dropzone_title') }}</h3>
                    <p>{{ __('model.photos.create.dropzone_subtitle') }}</p>
                    <p style="font-size: 0.75rem; color: var(--model-gold); margin-top: 8px;">
                        {{ __('model.photos.create.dropzone_hint') }}
                    </p>
                </div>
                <input type="file" name="photos[]" id="fileInput" multiple accept="image/*" hidden onchange="handleFileSelect(event)">
            </div>

            <div id="filePreviews" class="previews-grid"></div>

            @error('photos')
                <div style="color: #dc3545; font-size: 0.85rem; margin-top: 1rem; padding: 0.5rem; background: rgba(220,53,69,0.1); border-radius: 8px;">
                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <div class="glass-card">
            <h2 class="section-title"><i class="fas fa-info-circle"></i> {{ __('model.photos.create.section_details') }}</h2>
            
            <div class="premium-field">
                <label class="premium-label">{{ __('model.photos.create.label_title') }}</label>
                <input type="text" name="title" class="premium-input" placeholder="{{ __('model.photos.create.placeholder_title') }}" value="{{ old('title') }}">
                @error('title') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="premium-field">
                <label class="premium-label">{{ __('model.photos.create.label_description') }}</label>
                <textarea name="description" class="premium-textarea" rows="4" placeholder="{{ __('model.photos.create.placeholder_description') }}">{{ old('description') }}</textarea>
                @error('description') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="premium-field">
                <label class="modern-checkbox">
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: #fff; margin-bottom: 0.25rem;">{{ __('model.photos.create.label_visibility') }}</div>
                        <div style="font-size: 0.85rem; color: rgba(255,255,255,0.5);">{{ __('model.photos.create.hint_visibility') }}</div>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </label>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('model.photos.index') }}" class="btn-back-settings">
                <i class="fas fa-chevron-left"></i> {{ __('model.photos.create.back_button') }}
            </a>
            <button type="submit" class="btn-submit-premium" id="btnSubmit">
                <i class="fas fa-check-circle"></i> {{ __('model.photos.create.submit_button') }}
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const dropzone = document.getElementById('dropzone');
    const previewsContainer = document.getElementById('filePreviews');
    const fileInput = document.getElementById('fileInput');
    let dataTransfer = new DataTransfer();

    // Drag & Drop Handlers
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => dropzone.classList.add('drag-active'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => dropzone.classList.remove('drag-active'), false);
    });

    dropzone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        processFiles(e.dataTransfer.files);
    }

    function handleFileSelect(e) {
        processFiles(e.target.files);
    }

    function processFiles(newFiles) {
        const currentCount = dataTransfer.items.length;
        const filesToAdd = Array.from(newFiles);
        
        if (currentCount + filesToAdd.length > 10) {
            Swal.fire({
                icon: 'error',
                title: '{{ __('model.photos.create.swal.limit_title') }}',
                text: '{{ __('model.photos.create.swal.limit_text') }}',
                confirmButtonColor: '#d4af37',
                background: '#1a1a1a',
                color: '#fff'
            });
            return;
        }

        filesToAdd.forEach(file => {
            if (!file.type.startsWith('image/')) {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('model.photos.create.swal.format_title') }}',
                    text: '{{ __('model.photos.create.swal.format_text', ['name' => 'FILE_NAME']) }}'.replace('FILE_NAME', file.name),
                    confirmButtonColor: '#d4af37',
                    background: '#1a1a1a',
                    color: '#fff'
                });
                return;
            }
            if (file.size > 10 * 1024 * 1024) { // 10MB
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('model.photos.create.swal.size_title') }}',
                    text: '{{ __('model.photos.create.swal.size_text', ['name' => 'FILE_NAME']) }}'.replace('FILE_NAME', file.name),
                    confirmButtonColor: '#d4af37',
                    background: '#1a1a1a',
                    color: '#fff'
                });
                return;
            }
            
            // Agregar al DataTransfer
            dataTransfer.items.add(file);
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                const fileIdentifier = file.name + '_' + file.size; // Identificador simple
                previewItem.dataset.id = fileIdentifier;
                
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="remove-preview" onclick="removeFile('${fileIdentifier}', this)">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                previewsContainer.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });

        // Sincronizar con el input real para el submit del form
        fileInput.files = dataTransfer.files;
    }

    function removeFile(fileIdentifier, btnElement) {
        const newDt = new DataTransfer();
        
        for (let i = 0; i < dataTransfer.items.length; i++) {
            const file = dataTransfer.items[i].getAsFile();
            if ((file.name + '_' + file.size) !== fileIdentifier) {
                newDt.items.add(file);
            }
        }
        
        dataTransfer = newDt;
        fileInput.files = dataTransfer.files; 
        
        // Quitar la vista previa visual
        btnElement.parentElement.remove();
    }

    document.getElementById('premiumUploadForm').addEventListener('submit', function(e) {
        if (dataTransfer.items.length === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: '{{ __('model.photos.create.swal.warning_title') }}',
                text: '{{ __('model.photos.create.swal.warning_text') }}',
                confirmButtonColor: '#d4af37',
                background: '#1a1a1a',
                color: '#fff'
            });
            return;
        }
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('model.photos.create.submit_loading') }}';
    });
</script>
@endsection
