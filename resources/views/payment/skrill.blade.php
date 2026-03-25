@extends('layouts.app')

@section('title', __('payment.skrill.title'))

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="mb-4">
                <a href="{{ route('fan.tokens.recharge') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> {{ __('payment.card.change_method') }}
                </a>
                <h1 class="h3 mt-3 mb-2">{{ __('payment.skrill.title') }}</h1>
                <p class="text-muted">{{ number_format($package, 0, ',', '.') }} {{ __('payment.card.tokens') }} por ${{ number_format($amount, 2) }}</p>
            </div>

            
            @if(config('payment.simulation_mode'))
            <div class="alert alert-warning">
                <h6><i class="fas fa-flask"></i> {{ __('payment.card.simulation_mode') }}</h6>
                <p class="mb-0 small">
                    {{ __('payment.skrill.simulation_desc') }}
                </p>
            </div>
            @endif

            <div class="card">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-wallet fa-2x"></i>
                    <span class="ms-2">Skrill</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('fan.payment.skrill.process') }}" method="POST" id="skrillForm">
                        @csrf
                        <input type="hidden" name="package" value="{{ $package }}">

                        <div class="mb-3">
                            <label for="skrill_email" class="form-label">{{ __('payment.skrill.email') }} *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" 
                                       class="form-control @error('skrill_email') is-invalid @enderror" 
                                       id="skrill_email" 
                                       name="skrill_email" 
                                       placeholder="tu@email.com"
                                       value="{{ old('skrill_email', auth()->user()->email) }}"
                                       required>
                            </div>
                            @error('skrill_email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">{{ __('payment.skrill.email_desc') }}</small>
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
                            <h6>{{ __('payment.skrill.advantages') }}</h6>
                            <ul class="small">
                                <li>{{ __('payment.skrill.adv_1') }}</li>
                                <li>{{ __('payment.skrill.adv_2') }}</li>
                                <li>{{ __('payment.skrill.adv_3') }}</li>
                            </ul>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-lg" id="submitBtn">
                                <i class="fas fa-wallet"></i> {{ __('payment.skrill.continue') }}
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
    const form = document.getElementById('skrillForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>{{ __('payment.skrill.connecting') }}';
    });
});
</script>
@endpush
@endsection
