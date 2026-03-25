<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('model.onboarding.step3.title_tag') }}</title>

    
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
            margin-bottom: 2.5rem;
        }

        .form-header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #d4af37;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #ffffff;
            font-size: 1.1rem;
        }

        /* ----- Summary Styled ----- */
        .summary-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .summary-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 20px;
            padding: 1.5rem;
        }

        .summary-card h3 {
            font-size: 1rem;
            color: #D4AF37;
            margin: 0 0 1.2rem 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .summary-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.85rem;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-label {
            color: rgba(255, 255, 255, 0.4);
        }

        .summary-value {
            color: #fff;
            font-weight: 600;
        }

        .badge-completed {
            background: rgba(0, 230, 118, 0.1);
            color: var(--success-green);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            border: 1px solid rgba(0, 230, 118, 0.2);
        }

        /* ----- Roadmap ----- */
        .roadmap {
            background: rgba(212, 175, 55, 0.03);
            border: 1px solid rgba(212, 175, 55, 0.1);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2.5rem;
        }

        .roadmap h3 {
            margin: 0 0 1.5rem 0;
            font-size: 1.1rem;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .timeline {
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 5px;
            bottom: 5px;
            width: 1px;
            background: rgba(212, 175, 55, 0.2);
        }

        .timeline-item {
            position: relative;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -25px;
            top: 5px;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: #D4AF37;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
        }

        .timeline-content h4 {
            margin: 0 0 4px 0;
            font-size: 0.9rem;
            color: #fff;
        }

        .timeline-content p {
            margin: 0;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.4;
        }

        .final-call {
            text-align: center;
            padding: 2.5rem;
            background: linear-gradient(rgba(212, 175, 55, 0.1), rgba(0, 0, 0, 0));
            border-radius: 24px;
            border: 1px solid rgba(212, 175, 55, 0.15);
            margin-bottom: 2.5rem;
        }

        .final-call i {
            font-size: 3rem;
            color: #D4AF37;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .btn-submit {
            padding: 18px 40px;
            border-radius: 18px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 1.1rem;
            width: 100%;
            background: var(--gold-gradient);
            color: #000;
            box-shadow: 0 15px 35px rgba(212, 175, 55, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 45px rgba(212, 175, 55, 0.4);
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            padding: 12px 24px;
            border-radius: 14px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 768px) {
            .summary-wrapper {
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
                <div class="step-dot completed"></div>
                <div class="step-dot active"></div>
            </div>

            <div class="form-header">
                <h1>{{ __('model.onboarding.step3.header_title') }}</h1>
                <p>{{ __('model.onboarding.step3.header_subtitle') }}</p>
            </div>

            <div class="summary-wrapper">
                <div class="summary-card">
                    <h3><i class="fas fa-user-circle"></i> {{ __('model.onboarding.step3.section_profile') }}</h3>
                    <div class="summary-list">
                        <div class="summary-item">
                            <span class="summary-label">{{ __('model.onboarding.step3.label_name') }}</span>
                            <span class="summary-value">{{ $profile->display_name }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">{{ __('model.onboarding.step3.label_price') }}</span>
                            <span class="summary-value">{{ number_format($profile->subscription_price, 0) }}
                                {{ __('model.onboarding.step3.tokens') }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">{{ __('model.onboarding.step3.label_status') }}</span>
                            <span class="badge-completed">{{ __('model.onboarding.step3.status_ready') }}</span>
                        </div>
                    </div>
                </div>

                <div class="summary-card">
                    <h3><i class="fas fa-shield-alt"></i> {{ __('model.onboarding.step3.section_verification') }}</h3>
                    <div class="summary-list">
                        <div class="summary-item">
                            <span class="summary-label">{{ __('model.onboarding.step3.label_legal_name') }}</span>
                            <span class="summary-value">{{ $profile->legal_name ?? __('model.onboarding.step3.provided') }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">{{ __('model.onboarding.step3.label_document') }}</span>
                            <span class="summary-value">{{ ucfirst($profile->id_document_type) }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">{{ __('model.onboarding.step3.label_selfie') }}</span>
                            <span class="summary-value">{{ __('model.onboarding.step3.captured') }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">{{ __('model.onboarding.step3.label_legal_terms') }}</span>
                            <span class="badge-completed">{{ __('model.onboarding.step3.accepted') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="roadmap">
                <h3><i class="fas fa-map-signs"></i> {{ __('model.onboarding.step3.roadmap_title') }}</h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <h4>{{ __('model.onboarding.step3.step1_title') }}</h4>
                            <p>{{ __('model.onboarding.step3.step1_desc') }}</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <h4>{{ __('model.onboarding.step3.step2_title') }}</h4>
                            <p>{{ __('model.onboarding.step3.step2_desc') }}</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <h4>{{ __('model.onboarding.step3.step3_title') }}</h4>
                            <p>{{ __('model.onboarding.step3.step3_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="final-call">
                <i class="fas fa-paper-plane"></i>
                <h2 style="margin: 0 0 10px 0; font-size: 1.4rem;">{{ __('model.onboarding.step3.final_title') }}</h2>
                <p style="margin: 0; font-size: 0.9rem; color: rgba(255,255,255,0.6);">{{ __('model.onboarding.step3.final_subtitle') }}</p>
            </div>

            <form action="{{ route('model.onboarding.step3') }}" method="POST" id="final-form">
                @csrf
                <button type="submit" class="btn-submit">
                    {{ __('model.onboarding.step3.submit_button') }} <i class="fas fa-rocket"></i>
                </button>
            </form>

            <div style="text-align: center;">
                <a href="{{ route('model.onboarding.step', ['step' => 2]) }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> {{ __('model.onboarding.step3.modify_back') }}
                </a>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('final-form').addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: '{{ __('model.onboarding.step3.swal.title') }}',
                text: "{{ __('model.onboarding.step3.swal.text') }}",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#D4AF37',
                cancelButtonColor: 'rgba(255,255,255,0.1)',
                confirmButtonText: '{{ __('model.onboarding.step3.swal.confirm') }}',
                cancelButtonText: '{{ __('model.onboarding.step3.swal.cancel') }}',
                background: '#1F1F23',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
</body>

</html>