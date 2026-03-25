@extends('layouts.app')

@section('title', __('payment.paypal.title'))

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="mb-4">
                <a href="{{ route('payment.select-method', ['package' => $package]) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> {{ __('payment.card.change_method') }}
                </a>
                <h1 class="h3 mt-3 mb-2">{{ __('payment.paypal.title') }}</h1>
                <p class="text-muted">{{ number_format($package, 0, ',', '.') }} {{ __('payment.card.tokens') }} por ${{ number_format($amount, 2) }}</p>
            </div>

            
            @if(config('payment.simulation_mode'))
            <div class="alert alert-warning">
                <h6><i class="fas fa-flask"></i> {{ __('payment.card.simulation_mode') }}</h6>
                <p class="mb-0 small">
                    {{ __('payment.paypal.simulation_desc') }}
                </p>
            </div>
            @endif

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fab fa-paypal fa-2x"></i>
                    <span class="ms-2">PayPal</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('fan.payment.paypal.process') }}" method="POST" id="paypalForm">
                        @csrf
                        <input type="hidden" name="package" value="{{ $package }}">

                        <div class="mb-3">
                            <label for="paypal_email" class="form-label">{{ __('payment.paypal.email') }} *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" 
                                       class="form-control @error('paypal_email') is-invalid @enderror" 
                                       id="paypal_email" 
                                       name="paypal_email" 
                                       placeholder="tu@email.com"
                                       value="{{ old('paypal_email', auth()->user()->email) }}"
                                       required>
                            </div>
                            @error('paypal_email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">{{ __('payment.paypal.email_desc') }}</small>
                        </div>

                        
                        <div class="alert alert-light">
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ __('payment.card.tokens') }}:</span>
                                <strong>{{ number_format($package, 0, ',', '.') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>{{ __('payment.card.total') }}:</span>
                                <strong class="text-primary">${{ number_format($amount, 2) }} USD</strong>
                            </div>
                        </div>

                        
                        <div class="mb-3">
                            <h6>{{ __('payment.paypal.advantages') }}</h6>
                            <ul class="small">
                                <li>{{ __('payment.paypal.adv_1') }}</li>
                                <li>{{ __('payment.paypal.adv_2') }}</li>
                                <li>{{ __('payment.paypal.adv_3') }}</li>
                            </ul>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="fab fa-paypal"></i> {{ __('payment.paypal.continue') }}
                            </button>
                        </div>

                        <p class="text-center text-muted small mt-3 mb-0">
                            <i class="fas fa-shield-alt"></i> {{ __('payment.card.secure_payment') }}
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paypalForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>{{ __('payment.paypal.connecting') }}';
    });
});
</script>
@endpush
@endsection
