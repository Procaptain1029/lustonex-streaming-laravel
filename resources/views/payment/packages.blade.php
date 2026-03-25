@extends('layouts.app')

@section('title', __('payment.packages.title'))

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="mb-4">
        <h1 class="h3 mb-2">{{ __('payment.packages.title') }}</h1>
        <p class="text-muted">{{ __('payment.packages.desc') }}</p>
    </div>

    
    <div class="alert alert-info mb-4">
        <i class="fas fa-coins"></i> {{ __('payment.packages.balance') }} <strong>{{ number_format($userTokens, 0, ',', '.') }} tokens</strong>
    </div>

    
    <div class="row g-4">
        @foreach($packages as $tokens => $price)
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 {{ $tokens == 1000 ? 'border-primary' : '' }}">
                @if($tokens == 1000)
                <div class="card-header bg-primary text-white text-center">
                    <i class="fas fa-star"></i> {{ __('payment.packages.popular') }}
                </div>
                @endif
                <div class="card-body text-center">
                    <div class="display-4 mb-3">
                        <i class="fas fa-coins text-warning"></i>
                    </div>
                    <h3 class="card-title">{{ number_format($tokens, 0, ',', '.') }}</h3>
                    <p class="text-muted">{{ __('payment.card.tokens') }}</p>
                    <div class="display-6 text-primary mb-3">
                        ${{ number_format($price, 2) }}
                    </div>
                    @if($tokens >= 500)
                    <p class="text-success small">
                        <i class="fas fa-check-circle"></i> 
                        {{ $tokens >= 5000 ? __('payment.packages.discount_20') : ($tokens >= 1000 ? __('payment.packages.discount_10') : __('payment.packages.discount_5')) }}
                    </p>
                    @endif
                    <form action="{{ route('fan.payment.select-method') }}" method="POST">
                        @csrf
                        <input type="hidden" name="package" value="{{ $tokens }}">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            {{ __('payment.packages.buy_now') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    
    <div class="card mt-5">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-gift"></i> {{ __('payment.packages.why_buy') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="text-center mb-3">
                        <i class="fas fa-heart fa-3x text-danger mb-2"></i>
                        <h6>{{ __('payment.packages.reason_tips') }}</h6>
                        <p class="text-muted small">{{ __('payment.packages.reason_tips_desc') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center mb-3">
                        <i class="fas fa-star fa-3x text-warning mb-2"></i>
                        <h6>{{ __('payment.packages.reason_exclusive') }}</h6>
                        <p class="text-muted small">{{ __('payment.packages.reason_exclusive_desc') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center mb-3">
                        <i class="fas fa-crown fa-3x text-primary mb-2"></i>
                        <h6>{{ __('payment.packages.reason_vip') }}</h6>
                        <p class="text-muted small">{{ __('payment.packages.reason_vip_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="alert alert-light mt-4">
        <h6><i class="fas fa-shield-alt"></i> {{ __('payment.packages.secure_methods') }}</h6>
        <p class="mb-0 small">
            <i class="fab fa-cc-visa"></i>
            <i class="fab fa-cc-mastercard"></i>
            <i class="fab fa-cc-amex"></i>
            <i class="fab fa-paypal"></i>
            {{ __('payment.packages.accepted_payment') }}
        </p>
    </div>
</div>
@endsection
