<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('model.onboarding.step1.title_tag') }}</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/premium-design.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    <style>
        :root {
            --glass-bg: rgba(15, 15, 18, 0.75);
            --glass-border: rgba(212, 175, 55, 0.2);
            --gold-gradient: linear-gradient(135deg, #D4AF37 0%, #F4E37D 100%);
            --pink-accent: #FF4081;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: #0B0B0D;
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ----- Background Blobs ----- */
        .auth-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            background: radial-gradient(circle at 50% 50%, #1a1a1f 0%, #0b0b0d 100%);
        }

        .auth-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float 20s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
        }

        .auth-blob-1 {
            width: 500px;
            height: 500px;
            background: #D4AF37;
            top: -100px;
            right: -100px;
        }

        .auth-blob-2 {
            width: 600px;
            height: 600px;
            background: #FF4081;
            bottom: -150px;
            left: -150px;
            animation-duration: 25s;
            animation-delay: -5s;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }

            100% {
                transform: translate(100px, 50px) scale(1.1) rotate(15deg);
            }
        }

        .onboarding-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
            min-height: 100vh;
        }

        .onboarding-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            padding: 3rem;
            width: 100%;
            max-width: 850px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.6);
            animation: cardAppear 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 2.5rem;
        }

        .step-dot {
            width: 40px;
            height: 6px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.4s ease;
        }

        .step-dot.active {
            background: var(--gold-gradient);
            width: 60px;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
        }

        .form-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .form-header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #d4af37;
            margin-bottom: 0.5rem;
            letter-spacing: -1px;
        }

        .form-header p {
            color: #ffffff;
            font-size: 1.1rem;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #D4AF37;
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid rgba(212, 175, 55, 0.15);
        }

        /* ----- Form Styling ----- */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.5);
            margin-left: 4px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #D4AF37;
            font-size: 1rem;
            opacity: 0.7;
        }

        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 14px 16px 14px 45px;
            color: #fff;
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: #D4AF37;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.1);
        }

        .form-control-textarea {
            padding: 16px;
            min-height: 120px;
            resize: vertical;
        }

        /* ----- File Upload Refined ----- */
        .upload-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .file-input {
            display: none;
        }

        .upload-box {
            position: relative;
            height: 180px;
            background: rgba(255, 255, 255, 0.03);
            border: 2px dashed rgba(212, 175, 55, 0.2);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            text-align: center;
            padding: 20px;
        }

        .upload-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .upload-box:hover {
            background: rgba(212, 175, 55, 0.05);
            border-color: #D4AF37;
            transform: translateY(-5px);
        }

        .upload-box i {
            font-size: 2rem;
            color: #D4AF37;
            margin-bottom: 12px;
            transition: transform 0.3s ease;
        }

        .upload-box:hover i {
            transform: scale(1.1);
        }

        .upload-box span {
            font-size: 0.9rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
        }

        .upload-box p {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 8px;
        }

        .preview-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .upload-box.has-file .preview-img {
            display: block;
        }

        .upload-box.has-file .upload-content {
            opacity: 0;
        }

        .change-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .upload-box.has-file:hover .change-overlay {
            opacity: 1;
        }

        /* ----- Custom Selects (Select2 Dark Theme) ----- */
        .select2-container--bootstrap-5 .select2-selection {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 14px !important;
            height: 52px !important;
            display: flex !important;
            align-items: center !important;
            color: #fff !important;
            transition: all 0.3s ease !important;
        }

        .select2-container--bootstrap-5.select2-container--focus .select2-selection {
            border-color: #D4AF37 !important;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.15) !important;
            background: rgba(255, 255, 255, 0.08) !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            color: #fff !important;
            padding-left: 45px !important;
            /* Spacing for the icon */
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__placeholder {
            padding-left: 45px !important;
            color: rgba(255, 255, 255, 0.4) !important;
        }

        /* Dropdown Styling */
        .select2-dropdown {
            background: #1a1a1f !important;
            border: 1px solid rgba(212, 175, 55, 0.3) !important;
            border-radius: 14px !important;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5) !important;
            backdrop-filter: blur(20px) !important;
        }

        .select2-results__option {
            background: transparent !important;
            color: rgba(255, 255, 255, 0.7) !important;
            padding: 12px 16px !important;
            font-size: 0.9rem !important;
            transition: all 0.2s ease !important;
        }

        .select2-results__option--highlighted {
            background: rgba(212, 175, 55, 0.15) !important;
            color: #D4AF37 !important;
        }

        .select2-results__option--selected {
            background: rgba(212, 175, 55, 0.1) !important;
            color: #fff !important;
        }

        .select2-search__field {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 8px !important;
            color: #fff !important;
            padding: 8px 12px !important;
            margin-bottom: 5px !important;
        }

        .select2-search__field:focus {
            border-color: #D4AF37 !important;
            outline: none !important;
        }

        /* Hide the default select during loading to prevent flash */
        select.form-control {
            visibility: hidden;
            height: 52px;
        }

        .select2-container {
            width: 100% !important;
        }

        /* ----- Buttons ----- */
        .btn-onboarding {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 16px 32px;
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
        }

        .btn-primary-sh {
            background: var(--gold-gradient);
            color: #000;
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.2);
        }

        .btn-primary-sh:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3);
        }

        .btn-outline-sh {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
        }

        .btn-outline-sh:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #fff;
        }

        .terms-check {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 2rem;
            cursor: pointer;
            padding: 1rem;
            background: rgba(212, 175, 55, 0.05);
            border-radius: 14px;
            border: 1px solid rgba(212, 175, 55, 0.1);
        }

        .terms-check input {
            width: 22px;
            height: 22px;
            accent-color: #D4AF37;
            margin-top: 2px;
        }

        .terms-check label {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.5;
        }

        .terms-check a {
            color: #D4AF37;
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 768px) {

            .form-grid,
            .upload-grid {
                grid-template-columns: 1fr;
            }

            .onboarding-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="auth-background">
        <div class="auth-blob auth-blob-1"></div>
        <div class="auth-blob auth-blob-2"></div>
    </div>

    <div class="onboarding-container">
        <div class="onboarding-card">
            <div class="step-indicator">
                <div class="step-dot active"></div>
                <div class="step-dot"></div>
                <div class="step-dot"></div>
            </div>

            <div class="form-header">
                <h1>{{ __('model.onboarding.step1.header_title') }}</h1>
                <p>{{ __('model.onboarding.step1.header_subtitle') }}</p>
            </div>

            
            @if(session('error'))
                <div class="alert alert-error"
                    style="background: rgba(255, 64, 129, 0.1); border: 1px solid rgba(255, 64, 129, 0.2); color: #FF4081; padding: 1rem; border-radius: 14px; margin-bottom: 2rem; font-size: 0.9rem;">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error"
                    style="background: rgba(255, 64, 129, 0.1); border: 1px solid rgba(255, 64, 129, 0.2); color: #FF4081; padding: 1rem; border-radius: 14px; margin-bottom: 2rem; font-size: 0.9rem;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('model.onboarding.step1') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="section-title">
                    <i class="fas fa-id-card"></i> {{ __('model.onboarding.step1.section_profile') }}
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label">{{ __('model.onboarding.step1.display_name_label') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-signature"></i>
                        <input type="text" name="display_name" class="form-control"
                            value="{{ old('display_name', $profile->display_name) }}" placeholder="{{ __('model.onboarding.step1.display_name_placeholder') }}"
                            required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label">{{ __('model.onboarding.step1.bio_label') }}</label>
                    <textarea name="bio" class="form-control form-control-textarea"
                        placeholder="{{ __('model.onboarding.step1.bio_placeholder') }}"
                        required>{{ old('bio', $profile->bio) }}</textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">{{ __('model.onboarding.step1.country_label') }}</label>
                        <div class="input-wrapper">
                            <i class="fas fa-globe-americas"></i>
                            <select id="country" name="country" class="form-control" required>
                                <option value="">{{ __('model.onboarding.step1.country_placeholder') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('model.onboarding.step1.subscription_label') }}</label>
                        <div class="input-wrapper">
                            <i class="fas fa-gem"></i>
                            <input type="number" name="subscription_price" class="form-control"
                                value="{{ number_format(old('subscription_price', $profile->subscription_price), 0, '', '') }}"
                                min="5" max="5000" required>
                        </div>
                    </div>
                </div>

                <div class="section-title" style="margin-top: 2rem;">
                    <i class="fas fa-fingerprint"></i> {{ __('model.onboarding.step1.section_appearance') }}
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">{{ __('model.onboarding.step1.ethnicity_label') }}</label>
                        <div class="input-wrapper">
                            <i class="fas fa-dna"></i>
                            <select name="ethnicity" class="form-control" required>
                                <option value="">{{ __('model.onboarding.step1.select_placeholder') }}</option>
                                @foreach(__('model.onboarding.step1.ethnicities') as $eth => $label)
                                    <option value="{{ $eth }}" {{ old('ethnicity', $profile->ethnicity) == $eth ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('model.onboarding.step1.body_type_label') }}</label>
                        <div class="input-wrapper">
                            <i class="fas fa-venus"></i>
                            <select name="body_type" class="form-control" required>
                                <option value="">{{ __('model.onboarding.step1.select_placeholder') }}</option>
                                @foreach(__('model.onboarding.step1.body_types') as $bt => $label)
                                    <option value="{{ $bt }}" {{ old('body_type', $profile->body_type) == $bt ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">{{ __('model.onboarding.step1.hair_color_label') }}</label>
                        <div class="input-wrapper">
                            <i class="fas fa-palette"></i>
                            <select name="hair_color" class="form-control" required>
                                <option value="">{{ __('model.onboarding.step1.select_placeholder') }}</option>
                                @foreach(__('model.onboarding.step1.hair_colors') as $hc => $label)
                                    <option value="{{ $hc }}" {{ old('hair_color', $profile->hair_color) == $hc ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('model.onboarding.step1.interested_in_label') }}</label>
                        <div class="input-wrapper">
                            <i class="fas fa-heart"></i>
                            <select name="interested_in" class="form-control">
                                <option value="">{{ __('model.onboarding.step1.select_placeholder') }}</option>
                                @foreach(__('model.onboarding.step1.interests') as $ii => $label)
                                    <option value="{{ $ii }}" {{ old('interested_in', $profile->interested_in) == $ii ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="section-title" style="margin-top: 2rem;">
                    <i class="fas fa-camera-retro"></i> {{ __('model.onboarding.step1.section_media') }}
                </div>

                <div class="upload-grid">
                    <div class="form-group">
                        <label class="form-label">{{ __('model.onboarding.step1.avatar_label') }}</label>
                        <label class="upload-box" id="avatar-box">
                            <input type="file" name="avatar" class="file-input" accept="image/*"
                                onchange="previewImage(this, 'avatar-preview')">
                            <div class="upload-content">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ __('model.onboarding.step1.avatar_button') }}</span>
                                <p>{{ __('model.onboarding.step1.avatar_hint') }}</p>
                            </div>
                            <img id="avatar-preview"
                                src="{{ $profile->avatar ? asset('storage/' . $profile->avatar) : '' }}"
                                class="preview-img" style="{{ $profile->avatar ? 'display:block' : '' }}">
                            <div class="change-overlay">
                                <i class="fas fa-sync-alt" style="color: #fff; font-size: 1.5rem;"></i>
                            </div>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('model.onboarding.step1.cover_label') }}</label>
                        <label class="upload-box" id="cover-box">
                            <input type="file" name="cover_image" class="file-input" accept="image/*"
                                onchange="previewImage(this, 'cover-preview')">
                            <div class="upload-content">
                                <i class="fas fa-image"></i>
                                <span>{{ __('model.onboarding.step1.cover_button') }}</span>
                                <p>{{ __('model.onboarding.step1.cover_hint') }}</p>
                            </div>
                            <img id="cover-preview"
                                src="{{ $profile->cover_image ? asset('storage/' . $profile->cover_image) : '' }}"
                                class="preview-img" style="{{ $profile->cover_image ? 'display:block' : '' }}">
                            <div class="change-overlay">
                                <i class="fas fa-sync-alt" style="color: #fff; font-size: 1.5rem;"></i>
                            </div>
                        </label>
                    </div>
                </div>

                <label class="terms-check">
                    <input type="checkbox" name="terms_accepted" required {{ old('terms_accepted', $profile->terms_accepted) ? 'checked' : '' }}>
                    <span>
                        {!! __('model.onboarding.step1.terms_text') !!}
                    </span>
                </label>

                <div style="display: flex; gap: 15px;">
                    <a href="{{ route('model.dashboard') }}" class="btn-onboarding btn-outline-sh" style="flex: 1;">
                        <i class="fas fa-times"></i> {{ __('model.onboarding.step1.exit') }}
                    </a>
                    <button type="submit" class="btn-onboarding btn-primary-sh" style="flex: 2;">
                        {{ __('model.onboarding.step1.next') }} <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Lista base de países (Los más comunes para Lustonex)
            const countries = [
                @foreach(__('model.onboarding.step1.countries') as $id => $text)
                { id: '{{ $id }}', text: '{{ $text }}' },
                @endforeach
                { id: 'Otro', text: '{{ __('model.onboarding.step1.other_country') }}' }
            ];

            // Inicializar Select2 para todos los select
            $('select').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Inicialización específica para País con data
            $('#country').select2({
                theme: 'bootstrap-5',
                data: countries,
                placeholder: '{{ __('model.onboarding.step1.country_placeholder') }}',
                width: '100%'
            }).val('{{ old("country", $profile->country) }}').trigger('change');

            // Log de depuración
            console.log('Select2 inicializado correctamente en el tema oscuro.');
        });

        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#' + previewId).attr('src', e.target.result).show();
                    $(input).closest('.upload-box').addClass('has-file');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Inicializar estado de archivos si ya existen
        $(document).ready(function () {
            if ($('#avatar-preview').attr('src') != '') $('#avatar-preview').parent().addClass('has-file');
            if ($('#cover-preview').attr('src') != '') $('#cover-preview').parent().addClass('has-file');
        });
    </script>
</body>

</html>