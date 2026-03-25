@extends('layouts.app')

@section('title', __('payment.card.title'))

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="mb-4">
                <a href="{{ route('payment.select-method', ['package' => $package]) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> {{ __('payment.card.change_method') }}
                </a>
                <h1 class="h3 mt-3 mb-2">{{ __('payment.card.title') }}</h1>
                <p class="text-muted">{{ number_format($package, 0, ',', '.') }} {{ __('payment.card.tokens') }} por ${{ number_format($amount, 2) }}</p>
            </div>

            
            @if(config('payment.simulation_mode'))
            <div class="alert alert-warning">
                <h6><i class="fas fa-flask"></i> {{ __('payment.card.simulation_mode') }}</h6>
                <p class="mb-2 small">{{ __('payment.card.simulation_desc') }}</p>
                <ul class="small mb-0">
                    <li><code>{{ $testCards['success'] }}</code> - Pago exitoso</li>
                    <li><code>{{ $testCards['declined'] }}</code> - Tarjeta declinada</li>
                    <li><code>{{ $testCards['insufficient_funds'] }}</code> - Fondos insuficientes</li>
                </ul>
                <p class="small mb-0 mt-2">{{ __('payment.card.simulation_info') }}</p>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('fan.payment.card.process') }}" method="POST" id="cardPaymentForm">
                        @csrf
                        <input type="hidden" name="package" value="{{ $package }}">

                        
                        <div class="mb-3">
                            <label for="card_number" class="form-label">{{ __('payment.card.card_number') }} *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                <input type="text" 
                                       class="form-control @error('card_number') is-invalid @enderror" 
                                       id="card_number" 
                                       name="card_number" 
                                       placeholder="{{ __('payment.card.card_number_placeholder') }}"
                                       maxlength="19"
                                       value="{{ old('card_number') }}"
                                       required>
                            </div>
                            @error('card_number')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">{{ __('payment.card.card_number_desc') }}</small>
                        </div>

                        
                        <div class="mb-3">
                            <label for="card_name" class="form-label">{{ __('payment.card.card_name') }} *</label>
                            <input type="text" 
                                   class="form-control @error('card_name') is-invalid @enderror" 
                                   id="card_name" 
                                   name="card_name" 
                                   placeholder="{{ __('payment.card.card_name_placeholder') }}"
                                   value="{{ old('card_name') }}"
                                   required>
                            @error('card_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('payment.card.exp_date') }} *</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <select class="form-select @error('exp_month') is-invalid @enderror" 
                                                name="exp_month" 
                                                required>
                                            <option value="">{{ __('payment.card.month') }}</option>
                                            @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ old('exp_month') == $i ? 'selected' : '' }}>
                                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                            </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <select class="form-select @error('exp_year') is-invalid @enderror" 
                                                name="exp_year" 
                                                required>
                                            <option value="">{{ __('payment.card.year') }}</option>
                                            @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                            <option value="{{ $i }}" {{ old('exp_year') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                @error('exp_month')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cvv" class="form-label">{{ __('payment.card.cvv') }} *</label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-control @error('cvv') is-invalid @enderror" 
                                           id="cvv" 
                                           name="cvv" 
                                           placeholder="123"
                                           maxlength="4"
                                           value="{{ old('cvv') }}"
                                           required>
                                    <span class="input-group-text" data-bs-toggle="tooltip" title="{{ __('payment.card.cvv_desc') }}">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </div>
                                @error('cvv')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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

                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="fas fa-lock"></i> {{ __('payment.card.pay_btn') }} ${{ number_format($amount, 2) }}
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
    // Format card number
    const cardNumberInput = document.getElementById('card_number');
    cardNumberInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formattedValue;
    });

    // Only allow numbers in CVV
    const cvvInput = document.getElementById('cvv');
    cvvInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });

    // Form submission
    const form = document.getElementById('cardPaymentForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>{{ __('payment.card.processing') }}';
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
@endsection
