@extends('layouts.app')

@section('title', 'Pago Exitoso')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center mb-4">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                </div>
                <h1 class="h2 text-success mb-3">¡Pago Exitoso!</h1>
                <p class="text-muted">Tu compra se ha procesado correctamente</p>
            </div>

            @if($payment)
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-receipt"></i> Detalles de la Transacción</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6 text-muted">ID de Transacción:</div>
                        <div class="col-6 text-end">
                            <code>{{ $payment->transaction_id }}</code>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-muted">Tokens Comprados:</div>
                        <div class="col-6 text-end">
                            <strong class="text-warning">
                                <i class="fas fa-coins"></i> {{ number_format($payment->tokens_purchased, 0, ',', '.') }}
                            </strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-muted">Monto Pagado:</div>
                        <div class="col-6 text-end">
                            <strong>${{ number_format($payment->amount, 2) }} USD</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-muted">Método de Pago:</div>
                        <div class="col-6 text-end">
                            @switch($payment->payment_method)
                                @case('card')
                                    <i class="fas fa-credit-card"></i> Tarjeta
                                    @break
                                @case('paypal')
                                    <i class="fab fa-paypal"></i> PayPal
                                    @break
                                @case('skrill')
                                    <i class="fas fa-wallet"></i> Skrill
                                    @break
                            @endswitch
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-muted">Fecha:</div>
                        <div class="col-6 text-end">
                            {{ $payment->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="alert alert-success">
                <h6><i class="fas fa-info-circle"></i> ¿Qué sigue?</h6>
                <p class="mb-0">Tus tokens han sido agregados a tu cuenta y ya puedes usarlos para:</p>
                <ul class="mb-0 mt-2">
                    <li>Enviar propinas a tus modelos favoritas</li>
                    <li>Comprar contenido exclusivo</li>
                    <li>Suscribirte a modelos VIP</li>
                </ul>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('fan.tokens.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-history"></i> Ver Mi Historial
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-home"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
