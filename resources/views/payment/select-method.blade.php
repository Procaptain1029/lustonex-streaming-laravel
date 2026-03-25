@extends('layouts.app')

@section('title', __('payment.select.title'))

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <a href="{{ route('payment.packages') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> {{ __('payment.select.back') }}
                </a>
                <h1 class="h3 mt-3 mb-2">{{ __('payment.select.title') }}</h1>
                <p class="text-muted">{{ __('payment.select.purchase_info', ['tokens' => number_format($package, 0, ',', '.'), 'amount' => number_format($amount, 2)]) }}</p>
            </div>

            
            <div class="row g-3">
                
                <div class="col-md-4">
                    <a href="{{ route('fan.payment.card.form', ['package' => $package]) }}" class="text-decoration-none">
                        <div class="card h-100 payment-method-card">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-credit-card fa-4x text-primary"></i>
                                </div>
                                <h5 class="card-title">{{ __('payment.select.card') }}</h5>
                                <p class="text-muted small">{{ __('payment.select.card_desc') }}</p>
                                <div class="mt-3">
                                    <i class="fab fa-cc-visa fa-2x me-2"></i>
                                    <i class="fab fa-cc-mastercard fa-2x me-2"></i>
                                    <i class="fab fa-cc-amex fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                
                <div class="col-md-4">
                    <a href="{{ route('fan.payment.paypal.form', ['package' => $package]) }}" class="text-decoration-none">
                        <div class="card h-100 payment-method-card">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fab fa-paypal fa-4x text-primary"></i>
                                </div>
                                <h5 class="card-title">PayPal</h5>
                                <p class="text-muted small">{{ __('payment.select.paypal_desc') }}</p>
                                <div class="mt-3">
                                    <span class="badge bg-info">{{ __('payment.select.recommended') }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                
                <div class="col-md-4">
                    <a href="{{ route('fan.payment.skrill.form', ['package' => $package]) }}" class="text-decoration-none">
                        <div class="card h-100 payment-method-card">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-wallet fa-4x text-primary"></i>
                                </div>
                                <h5 class="card-title">Skrill</h5>
                                <p class="text-muted small">{{ __('payment.select.skrill_desc') }}</p>
                                <div class="mt-3">
                                    <span class="badge bg-secondary">{{ __('payment.select.available') }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            
            <div class="alert alert-light mt-4">
                <h6><i class="fas fa-lock"></i> {{ __('payment.select.secure_info') }}</h6>
                <p class="mb-0 small">
                    {{ __('payment.select.secure_desc') }}
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.payment-method-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.payment-method-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border-color: #0d6efd;
}
</style>
@endsection
