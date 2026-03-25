<div id="age-verification-modal" class="age-modal-overlay">
    <div class="age-modal-content">
        <div class="age-modal-header">
            <h1 class="age-modal-logo">
                <span>LUSTONEX</span>
            </h1>
        </div>

        <h2 class="age-modal-title">{{ __('pages.age_verification.warning') }}</h2>

        <div class="age-modal-badge">
            {{ __('pages.age_verification.restricted') }}
        </div>

        <p class="age-modal-text">
            {!! __('pages.age_verification.text') !!}
        </p>

        <div class="age-modal-buttons">
            <button id="btn-enter" class="btn-verification">
                {{ __('pages.age_verification.enter') }}
            </button>
            <button id="btn-exit" class="btn-verification-outline">
                {{ __('pages.age_verification.exit') }}
            </button>
        </div>

        <div class="age-modal-footer">
            <p>{{ __('pages.age_verification.parental_control') }}</p>
            <a href="#" class="age-modal-link">{{ __('pages.age_verification.terms') }}</a>
        </div>

        <div class="age-modal-copyright">
            &copy; Lustonex {{ date('Y') }}. {{ __('pages.age_verification.copyright') }}
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;600;700&display=swap');

    .age-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #0B0B0D;
        z-index: 9999;
        justify-content: center;
        align-items: center;
        color: white;
        font-family: 'Raleway', sans-serif;
        padding: 20px;
        box-sizing: border-box;
        overflow-y: auto;
    }

    .age-modal-content {
        text-align: center;
        width: 100%;
        max-width: 600px;
        padding: 40px 30px;
        border: 1px solid rgba(222, 184, 42, 0.3);
        border-radius: 12px;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(10px);
        box-sizing: border-box;
        margin: auto;
    }

    .age-modal-header {
        margin-bottom: 25px;
    }

    .age-modal-logo {
        font-size: 2.5rem;
        margin-bottom: 10px;
        font-weight: 700;
        letter-spacing: 2px;
    }

    .age-modal-logo span {
        color: #deb82a;
    }

    .age-modal-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        font-weight: 300;
        letter-spacing: 0.5px;
    }

    .age-modal-badge {
        display: inline-block;
        padding: 8px 20px;
        margin-bottom: 25px;
        border-bottom: 2px solid #deb82a;
        color: #deb82a;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }

    .age-modal-text {
        font-size: 0.95rem;
        line-height: 1.8;
        color: #e0e0e0;
        margin-bottom: 35px;
        text-align: justify;
        text-align-last: center;
    }

    .age-modal-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-verification {
        background: linear-gradient(135deg, #deb82a 0%, #b89620 100%);
        border: none;
        color: #000;
        padding: 15px 35px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 15px rgba(222, 184, 42, 0.3);
        flex: 1;
        min-width: 240px;
    }

    .btn-verification:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(222, 184, 42, 0.5);
        background: linear-gradient(135deg, #ebd060 0%, #d4ae26 100%);
    }

    .btn-verification-outline {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #aaa;
        padding: 15px 35px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 1px;
        flex: 1;
        min-width: 240px;
    }

    .btn-verification-outline:hover {
        border-color: #666;
        color: #fff;
        background: rgba(255, 255, 255, 0.05);
    }

    .age-modal-footer {
        margin-top: 40px;
        font-size: 0.8rem;
        color: #888;
    }

    .age-modal-link {
        color: #deb82a;
        text-decoration: none;
        border-bottom: 1px dotted #deb82a;
        transition: all 0.3s;
        font-size: 0.75rem;
    }

    .age-modal-copyright {
        margin-top: 25px;
        font-size: 0.7rem;
        color: #555;
    }

    /* Notebook and Tablet adjustments */
    @media (max-width: 1024px) {
        .age-modal-content {
            padding: 30px 20px;
        }
        
        .age-modal-logo {
            font-size: 2rem;
        }
    }

    /* Mobile adjustments */
    @media (max-width: 600px) {
        .age-modal-overlay {
            padding: 15px;
            align-items: flex-start; /* Start from top on mobile to allow scrolling */
        }

        .age-modal-content {
            padding: 25px 20px;
            border-radius: 8px;
        }

        .age-modal-logo {
            font-size: 1.8rem;
        }

        .age-modal-title {
            font-size: 1.2rem;
        }

        .age-modal-text {
            font-size: 0.85rem;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .age-modal-buttons {
            flex-direction: column;
            gap: 12px;
        }

        .btn-verification, .btn-verification-outline {
            width: 100%;
            min-width: unset;
            padding: 12px 20px;
            font-size: 0.9rem;
        }

        .age-modal-footer {
            margin-top: 30px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('age-verification-modal');
        const btnEnter = document.getElementById('btn-enter');
        const btnExit = document.getElementById('btn-exit');

        // Comprobar si ya se verificó la edad
        const isVerified = localStorage.getItem('age_verified');

        if (!isVerified) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        btnEnter.addEventListener('click', function () {
            localStorage.setItem('age_verified', 'true');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        btnExit.addEventListener('click', function () {
            window.location.href = 'https://www.google.com';
        });
    });
</script>