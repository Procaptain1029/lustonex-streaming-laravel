@extends('layouts.app')

@section('title', __('payment.failed.title'))

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center mb-4">
                <div class="mb-4">
                    <i class="fas fa-times-circle text-danger" style="font-size: 5rem;"></i>
                </div>
                <h1 class="h2 text-danger mb-3">{{ __('payment.failed.title') }}</h1>
                <p class="text-muted">{{ __('payment.failed.desc') }}</p>
            </div>

            @if($payment)
            <div class="card mb-4 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> {{ __('payment.failed.details') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6 text-muted">{{ __('payment.failed.transaction_id') }}:</div>
                        <div class="col-6 text-end">
                            <code>{{ $payment->transaction_id }}</code>
                        </div>
                    </div>
                    @if($payment->error_message)
                    <div class="alert alert-danger mb-3">
                        <small>{{ $payment->error_message }}</small>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-6 text-muted">{{ __('payment.failed.date') }}:</div>
                        <div class="col-6 text-end">
                            {{ $payment->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6><i class="fas fa-question-circle text-primary"></i> {{ __('payment.failed.causes') }}</h6>
                            <ul class="small mb-0 ps-3">
                                <li>{{ __('payment.failed.cause_1') }}</li>
                                <li>{{ __('payment.failed.cause_2') }}</li>
                                <li>{{ __('payment.failed.cause_3') }}</li>
                                <li>{{ __('payment.failed.cause_4') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6><i class="fas fa-lightbulb text-warning"></i> {{ __('payment.failed.actions') }}</h6>
                            <ul class="small mb-0 ps-3">
                                <li>{{ __('payment.failed.action_1') }}</li>
                                <li>{{ __('payment.failed.action_2') }}</li>
                                <li>{{ __('payment.failed.action_3') }}</li>
                                <li>{{ __('payment.failed.action_4') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('payment.packages') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-redo"></i> {{ __('payment.failed.retry') }}
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-home"></i> {{ __('payment.failed.back_home') }}
                </a>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">
                    {{ __('payment.failed.help') }} <a href="{{ route('support.index') }}">{{ __('payment.failed.contact_support') }}</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
