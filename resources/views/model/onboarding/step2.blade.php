<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('model.onboarding.step2.title_tag') }}</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/premium-design.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --glass-bg: rgba(15, 15, 18, 0.75);
            --glass-border: rgba(212, 175, 55, 0.2);
            --gold-gradient: linear-gradient(135deg, #D4AF37 0%, #F4E37D 100%);
            --pink-accent: #FF4081;
            --success-green: #00E676;
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
            opacity: 0.3;
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
            max-width: 800px;
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

        .step-dot.completed {
            background: rgba(212, 175, 55, 0.4);
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
            font-size: 2rem;
            font-weight: 800;
            color: #d4af37;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #ffffff;
            font-size: 1.1rem;
        }

        .security-banner {
            background: rgba(0, 230, 118, 0.1);
            border-radius: 16px;
            padding: 1.2rem;
            margin-bottom: 2.5rem;
            border: 1px solid rgba(0, 230, 118, 0.2);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .security-icon {
            width: 45px;
            height: 45px;
            background: rgba(0, 230, 118, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--success-green);
            font-size: 1.2rem;
        }

        .security-text strong {
            display: block;
            color: var(--success-green);
            font-size: 0.95rem;
            margin-bottom: 2px;
        }

        .security-text p {
            margin: 0;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
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

        /* ----- Document Type Selection ----- */
        .doc-type-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2.5rem;
        }

        .doc-type-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 1.5rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .doc-type-card:hover {
            background: rgba(255, 255, 255, 0.06);
            transform: translateY(-5px);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .doc-type-card i {
            font-size: 2rem;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 12px;
            transition: color 0.3s ease;
        }

        .doc-type-card span {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.6);
        }

        .doc-type-card input {
            position: absolute;
            opacity: 0;
        }

        .doc-type-card.active {
            background: rgba(212, 175, 55, 0.1);
            border-color: #D4AF37;
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.15);
        }

        .doc-type-card.active i {
            color: #D4AF37;
        }

        .doc-type-card.active span {
            color: #fff;
        }

        /* ----- Upload Zones ----- */
        .upload-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .upload-zone {
            background: rgba(255, 255, 255, 0.02);
            border: 2px dashed rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .upload-zone:hover {
            border-color: #D4AF37;
            background: rgba(212, 175, 55, 0.04);
        }

        .upload-zone i {
            font-size: 2.4rem;
            color: #D4AF37;
            margin-bottom: 15px;
            opacity: 0.7;
        }

        .upload-zone h4 {
            margin: 0 0 8px 0;
            font-size: 0.95rem;
            font-weight: 700;
        }

        .upload-zone p {
            margin: 0;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.4);
            line-height: 1.4;
        }

        .upload-zone input {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .upload-status {
            display: none;
            position: absolute;
            inset: 0;
            background: rgba(15, 15, 18, 0.9);
            border-radius: 18px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            backdrop-filter: blur(5px);
        }

        .upload-zone.has-file .upload-status {
            display: flex;
        }

        .file-info {
            text-align: center;
        }

        .file-info i {
            color: var(--success-green);
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .file-name {
            display: block;
            font-size: 0.85rem;
            color: #fff;
            margin-bottom: 10px;
            word-break: break-all;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-change {
            font-size: 0.75rem;
            color: #D4AF37;
            text-decoration: underline;
            cursor: pointer;
            background: none;
            border: none;
            font-weight: 600;
        }

        /* ----- Tips Section ----- */
        .tips-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .tips-box h5 {
            color: #D4AF37;
            margin: 0 0 1rem 0;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tips-list {
            margin: 0;
            padding: 0;
            list-style: none;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .tips-list li {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tips-list li::before {
            content: "\f00c";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            color: var(--success-green);
            font-size: 0.7rem;
        }

        .age-confirm {
            background: rgba(212, 175, 55, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.15);
            border-radius: 16px;
            padding: 1.2rem;
            margin-bottom: 2.5rem;
            display: flex;
            gap: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .age-confirm:hover {
            background: rgba(212, 175, 55, 0.08);
        }

        .age-confirm input {
            width: 20px;
            height: 20px;
            accent-color: #D4AF37;
            margin-top: 3px;
        }

        .age-confirm label {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.5;
            cursor: pointer;
        }

        .btn-sh {
            padding: 16px 32px;
            border-radius: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
        }

        .btn-sh-primary {
            background: var(--gold-gradient);
            color: #000;
        }

        .btn-sh-outline {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .btn-sh:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.2);
        }

        @media (max-width: 768px) {

            .form-grid,
            .doc-type-grid,
            .upload-section {
                grid-template-columns: 1fr;
            }

            .tips-list {
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
                <div class="step-dot completed"></div>
                <div class="step-dot active"></div>
                <div class="step-dot"></div>
            </div>

            <div class="form-header">
                <h1>{{ __('model.onboarding.step2.header_title') }}</h1>
                <p>{{ __('model.onboarding.step2.header_subtitle') }}</p>
            </div>

            <div class="security-banner">
                <div class="security-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="security-text">
                    <strong>{{ __('model.onboarding.step2.security_title') }}</strong>
                    <p>{{ __('model.onboarding.step2.security_text') }}</p>
                </div>
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

            <form action="{{ route('model.onboarding.step2') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div
                    style="margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 600; color: rgba(255, 255, 255, 0.5);">
                    {{ __('model.onboarding.step2.section_legal') }}
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">{{ __('model.onboarding.step2.legal_name_label') }}</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" name="legal_name" class="form-control"
                                value="{{ old('legal_name', $profile->legal_name ?? '') }}" placeholder="{{ __('model.onboarding.step2.legal_name_placeholder') }}"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('model.onboarding.step2.dob_label') }}</label>
                        <div class="input-wrapper">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="date" name="date_of_birth" class="form-control" 
                                value="{{ old('date_of_birth', $profile->date_of_birth ?? '') }}"
                                required max="{{ now()->subYears(18)->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <div
                    style="margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 600; color: rgba(255, 255, 255, 0.5);">
                    {{ __('model.onboarding.step2.section_document') }}
                </div>

                <div class="doc-type-grid">
                    <label
                        class="doc-type-card {{ old('id_document_type', $profile->id_document_type) == 'cedula' ? 'active' : '' }}"
                        onclick="selectDocType(this)">
                        <input type="radio" name="id_document_type" value="cedula" {{ old('id_document_type', $profile->id_document_type) == 'cedula' ? 'checked' : '' }} required>
                        <i class="fas fa-id-card"></i>
                        <span>{{ __('model.onboarding.step2.doc_cedula') }}</span>
                    </label>
                    <label
                        class="doc-type-card {{ old('id_document_type', $profile->id_document_type) == 'pasaporte' ? 'active' : '' }}"
                        onclick="selectDocType(this)">
                        <input type="radio" name="id_document_type" value="pasaporte" {{ old('id_document_type', $profile->id_document_type) == 'pasaporte' ? 'checked' : '' }} required>
                        <i class="fas fa-passport"></i>
                        <span>{{ __('model.onboarding.step2.doc_passport') }}</span>
                    </label>
                    <label
                        class="doc-type-card {{ old('id_document_type', $profile->id_document_type) == 'licencia' ? 'active' : '' }}"
                        onclick="selectDocType(this)">
                        <input type="radio" name="id_document_type" value="licencia" {{ old('id_document_type', $profile->id_document_type) == 'licencia' ? 'checked' : '' }} required>
                        <i class="fas fa-id-badge"></i>
                        <span>{{ __('model.onboarding.step2.doc_license') }}</span>
                    </label>
                </div>

                <div
                    style="margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 600; color: rgba(255, 255, 255, 0.5);">
                    {{ __('model.onboarding.step2.section_upload') }}
                </div>

                <div class="upload-section">
                    <div class="upload-zone" id="front-zone">
                        <i class="fas fa-image"></i>
                        <h4>{{ __('model.onboarding.step2.front_label') }}</h4>
                        <p>{{ __('model.onboarding.step2.front_hint') }}</p>
                        <input type="file" name="id_document_front" onchange="handleFile(this, 'front-zone')" required
                            accept="image/*,application/pdf">
                        <div class="upload-status">
                            <div class="file-info">
                                <i class="fas fa-check-circle"></i>
                                <span class="file-name">documento_frontal.jpg</span>
                                <button type="button" class="btn-change">{{ __('model.onboarding.step2.change_file') }}</button>
                            </div>
                        </div>
                    </div>

                    <div class="upload-zone" id="back-zone">
                        <i class="fas fa-image"></i>
                        <h4>{{ __('model.onboarding.step2.back_label') }}</h4>
                        <p>{{ __('model.onboarding.step2.back_hint') }}</p>
                        <input type="file" name="id_document_back" onchange="handleFile(this, 'back-zone')" required
                            accept="image/*,application/pdf">
                        <div class="upload-status">
                            <div class="file-info">
                                <i class="fas fa-check-circle"></i>
                                <span class="file-name">documento_trasero.jpg</span>
                                <button type="button" class="btn-change">{{ __('model.onboarding.step2.change_file') }}</button>
                            </div>
                        </div>
                    </div>

                    <div class="upload-zone" id="selfie-zone">
                        <i class="fas fa-camera-retro"></i>
                        <h4>{{ __('model.onboarding.step2.selfie_label') }}</h4>
                        <p>{{ __('model.onboarding.step2.selfie_hint') }}</p>
                        <input type="file" name="id_document_selfie" onchange="handleFile(this, 'selfie-zone')" required
                            accept="image/*">
                        <div class="upload-status">
                            <div class="file-info">
                                <i class="fas fa-check-circle"></i>
                                <span class="file-name">selfie.jpg</span>
                                <button type="button" class="btn-change">{{ __('model.onboarding.step2.change_file') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tips-box">
                    <h5><i class="fas fa-lightbulb"></i> {{ __('model.onboarding.step2.tips_title') }}</h5>
                    <ul class="tips-list">
                        <li>{{ __('model.onboarding.step2.tip1') }}</li>
                        <li>{{ __('model.onboarding.step2.tip2') }}</li>
                        <li>{{ __('model.onboarding.step2.tip3') }}</li>
                        <li>{{ __('model.onboarding.step2.tip4') }}</li>
                    </ul>
                </div>

                <label class="age-confirm">
                    <input type="checkbox" name="age_verified" required {{ old('age_verified', $profile->age_verified) ? 'checked' : '' }}>
                    <span>
                        {{ __('model.onboarding.step2.age_verified_text') }}
                    </span>
                </label>

                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('model.onboarding.step', ['step' => 1]) }}" class="btn-sh btn-sh-outline"
                        style="flex: 1;">
                        <i class="fas fa-arrow-left"></i> {{ __('model.onboarding.step2.back') }}
                    </a>
                    <button type="submit" class="btn-sh btn-sh-primary" style="flex: 2; justify-content: center;">
                        {{ __('model.onboarding.step2.finish') }} <i class="fas fa-check-double"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function selectDocType(el) {
            document.querySelectorAll('.doc-type-card').forEach(card => card.classList.remove('active'));
            el.classList.add('active');
        }

        function handleFile(input, zoneId) {
            const zone = document.getElementById(zoneId);
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                zone.classList.add('has-file');
                zone.querySelector('.file-name').textContent = fileName;
            }
        }

        // Script para permitir cambiar el archivo al hacer clic en el botón de cambiar
        document.querySelectorAll('.btn-change').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const zone = this.closest('.upload-zone');
                zone.classList.remove('has-file');
                zone.querySelector('input').value = '';
                zone.querySelector('input').click();
            });
        });
    </script>
</body>

</html>