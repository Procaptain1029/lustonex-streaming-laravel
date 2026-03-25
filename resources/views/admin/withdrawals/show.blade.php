@extends('layouts.admin')

@section('title', __('admin.withdrawals.show.title') . $withdrawal->id)

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('admin.withdrawals.index') }}" class="breadcrumb-item">{{ __('admin.withdrawals.index.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.withdrawals.show.breadcrumb') }}{{ $withdrawal->id }}</span>
@endsection

@section('styles')
<style>
    /* Custom Modal - NO BOOTSTRAP */
    .custom-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .custom-modal.active {
        display: flex;
    }

    .custom-modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
    }

    .custom-modal-dialog {
        position: relative;
        max-width: 500px;
        width: 90%;
        z-index: 10000;
    }

    .custom-modal-content {
        background: #1a1a1a;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        color: #fff;
    }

    .custom-modal-header {
        padding: 20px 25px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .custom-modal-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .custom-modal-close {
        background: transparent;
        border: none;
        color: #fff;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.6;
        transition: opacity 0.2s;
    }

    .custom-modal-close:hover {
        opacity: 1;
    }

    .custom-modal-body {
        padding: 25px;
    }

    .custom-modal-footer {
        padding: 20px 25px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .sh-input {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 10px 12px;
        color: #fff;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .sh-input:focus {
        outline: none;
        border-color: var(--admin-gold);
        background: rgba(255, 255, 255, 0.05);
    }

    .form-label {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    .sh-btn-action {
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .sh-btn-approve {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .sh-btn-reject {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .sh-btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
    }

    /* Layout Classes */
    .sh-details-layout {
        display: grid; 
        grid-template-columns: 2fr 1fr; 
        gap: 20px;
    }

    .sh-info-row {
        display: grid; 
        grid-template-columns: 150px 1fr; 
        gap: 10px; 
        padding: 15px; 
        background: rgba(255,255,255,0.02); 
        border-radius: 10px;
    }

    .sh-payment-detail-row {
        display: grid; 
        grid-template-columns: 140px 1fr; 
        gap: 10px; 
        padding: 10px; 
        background: rgba(0,0,0,0.2); 
        border-radius: 8px;
    }

    @media (max-width: 992px) {
        .sh-details-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .sh-info-row {
            grid-template-columns: 1fr;
            gap: 5px;
        }
        
        .sh-payment-detail-row {
            grid-template-columns: 1fr;
            gap: 5px;
        }

        .page-header {
            margin-bottom: 2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ __('admin.withdrawals.show.title') }}{{ $withdrawal->id }}</h1>
    <p class="page-subtitle">{{ __('admin.withdrawals.show.subtitle') }}</p>
</div>

<div class="sh-details-layout">
    
    <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 30px;">
        <h3 style="color: var(--admin-gold); font-size: 0.9rem; font-weight: 800; text-transform: uppercase; margin-bottom: 20px;">
            <i class="fas fa-info-circle"></i> {{ __('admin.withdrawals.show.info.title') }}
        </h3>
        
        <div style="display: grid; gap: 20px;">
            <div class="sh-info-row">
                <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">{{ __('admin.withdrawals.show.info.status') }}</span>
                <div>
                    @switch($withdrawal->status)
                        @case('pending')
                            <span style="background: rgba(251,191,36,0.1); color: #fbbf24; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 800;">{{ __('admin.withdrawals.show.status.pending') }}</span>
                            @break
                        @case('processing')
                            <span style="background: rgba(59,130,246,0.1); color: #3b82f6; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 800;">{{ __('admin.withdrawals.show.status.processing') }}</span>
                            @break
                        @case('completed')
                            <span style="background: rgba(16,185,129,0.1); color: #10b981; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 800;">{{ __('admin.withdrawals.show.status.completed') }}</span>
                            @break
                        @case('rejected')
                            <span style="background: rgba(239,68,68,0.1); color: #ef4444; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 800;">{{ __('admin.withdrawals.show.status.rejected') }}</span>
                            @break
                        @case('cancelled')
                            <span style="background: rgba(107,114,128,0.1); color: #6b7280; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 800;">{{ __('admin.withdrawals.show.status.cancelled') }}</span>
                            @break
                    @endswitch
                </div>
            </div>

            <div class="sh-info-row">
                <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">{{ __('admin.withdrawals.show.info.model') }}</span>
                <div>
                    <div style="color: #fff; font-weight: 700;">{{ $withdrawal->user->name }}</div>
                    <div style="color: rgba(255,255,255,0.5); font-size: 0.8rem;">{{ $withdrawal->user->email }}</div>
                </div>
            </div>

            <div class="sh-info-row">
                <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">{{ __('admin.withdrawals.show.info.requested_amount') }}</span>
                <span style="color: var(--admin-gold); font-weight: 800; font-size: 1.2rem;">${{ number_format($withdrawal->amount, 2) }}</span>
            </div>

            <div class="sh-info-row">
                <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">{{ __('admin.withdrawals.show.info.fee') }}</span>
                <span style="color: #ef4444; font-weight: 700;">${{ number_format($withdrawal->fee, 2) }}</span>
            </div>

            <div class="sh-info-row">
                <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">{{ __('admin.withdrawals.show.info.net_amount') }}</span>
                <span style="color: #10b981; font-weight: 800; font-size: 1.2rem;">${{ number_format($withdrawal->net_amount, 2) }}</span>
            </div>

            <div class="sh-info-row">
                <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">{{ __('admin.withdrawals.show.info.payment_method') }}</span>
                <span style="color: #fff; font-weight: 600;">{{ ucfirst(str_replace('_', ' ', $withdrawal->payment_method)) }}</span>
            </div>

            @if($withdrawal->payment_details)
            <div style="padding: 20px; background: rgba(255,255,255,0.02); border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                <h4 style="color: rgba(255,255,255,0.5); font-size: 0.85rem; font-weight: 700; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-credit-card"></i> {{ __('admin.withdrawals.show.payment_details.title') }}
                </h4>
                <div style="display: grid; gap: 12px;">
                    @php
                        $details = is_array($withdrawal->payment_details) ? $withdrawal->payment_details : json_decode($withdrawal->payment_details, true);
                    @endphp

                    @switch($withdrawal->payment_method)
                        @case('bank_transfer')
                            @if(isset($details['bank_name']) && $details['bank_name'])
                            <div class="sh-payment-detail-row">
                                <span style="color: rgba(255,255,255,0.4); font-size: 0.8rem;">{{ __('admin.withdrawals.show.payment_details.bank') }}</span>
                                <span style="color: #fff; font-weight: 600;">{{ $details['bank_name'] }}</span>
                            </div>
                            @endif
                            @if(isset($details['account_holder']) && $details['account_holder'])
                            <div class="sh-payment-detail-row">
                                <span style="color: rgba(255,255,255,0.4); font-size: 0.8rem;">{{ __('admin.withdrawals.show.payment_details.account_holder') }}</span>
                                <span style="color: #fff; font-weight: 600;">{{ $details['account_holder'] }}</span>
                            </div>
                            @endif
                            @if(isset($details['account_number']) && $details['account_number'])
                            <div class="sh-payment-detail-row">
                                <span style="color: rgba(255,255,255,0.4); font-size: 0.8rem;">{{ __('admin.withdrawals.show.payment_details.account_number') }}</span>
                                <span style="color: var(--admin-gold); font-weight: 700; font-family: monospace;">{{ $details['account_number'] }}</span>
                            </div>
                            @endif
                            @if(isset($details['swift']) && $details['swift'])
                            <div class="sh-payment-detail-row">
                                <span style="color: rgba(255,255,255,0.4); font-size: 0.8rem;">{{ __('admin.withdrawals.show.payment_details.swift') }}</span>
                                <span style="color: #fff; font-weight: 600; font-family: monospace;">{{ $details['swift'] }}</span>
                            </div>
                            @endif
                            @break

                        @case('paypal')
                            @if(isset($details['paypal_email']) && $details['paypal_email'])
                            <div class="sh-payment-detail-row">
                                <span style="color: rgba(255,255,255,0.4); font-size: 0.8rem;">{{ __('admin.withdrawals.show.payment_details.paypal_email') }}</span>
                                <span style="color: var(--admin-gold); font-weight: 700;">{{ $details['paypal_email'] }}</span>
                            </div>
                            @endif
                            @break

                        @case('stripe')
                            @if(isset($details['stripe_account_id']) && $details['stripe_account_id'])
                            <div class="sh-payment-detail-row">
                                <span style="color: rgba(255,255,255,0.4); font-size: 0.8rem;">{{ __('admin.withdrawals.show.payment_details.stripe_account') }}</span>
                                <span style="color: var(--admin-gold); font-weight: 700; font-family: monospace;">{{ $details['stripe_account_id'] }}</span>
                            </div>
                            @endif
                            @break

                        @case('crypto')
                            @if(isset($details['crypto_type']) && $details['crypto_type'])
                            <div class="sh-payment-detail-row">
                                <span style="color: rgba(255,255,255,0.4); font-size: 0.8rem;">{{ __('admin.withdrawals.show.payment_details.crypto_type') }}</span>
                                <span style="color: #fff; font-weight: 700; text-transform: uppercase;">{{ $details['crypto_type'] }}</span>
                            </div>
                            @endif
                            @if(isset($details['wallet_address']) && $details['wallet_address'])
                            <div class="sh-payment-detail-row">
                                <span style="color: rgba(255,255,255,0.4); font-size: 0.8rem;">{{ __('admin.withdrawals.show.payment_details.wallet_address') }}</span>
                                <span style="color: var(--admin-gold); font-weight: 600; font-family: monospace; font-size: 0.75rem; word-break: break-all;">{{ $details['wallet_address'] }}</span>
                            </div>
                            @endif
                            @break
                    @endswitch

                    @if(empty(array_filter($details ?? [])))
                    <div style="text-align: center; padding: 20px; color: rgba(255,255,255,0.3);">
                        <i class="fas fa-info-circle"></i> {{ __('admin.withdrawals.show.payment_details.empty') }}
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if($withdrawal->notes)
            <div style="padding: 15px; background: rgba(255,255,255,0.02); border-radius: 10px;">
                <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem; display: block; margin-bottom: 10px;">{{ __('admin.withdrawals.show.info.notes') }}</span>
                <p style="color: #fff; margin: 0;">{{ $withdrawal->notes }}</p>
            </div>
            @endif

            @if($withdrawal->rejection_reason)
            <div style="padding: 15px; background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.2); border-radius: 10px;">
                <span style="color: #ef4444; font-size: 0.85rem; font-weight: 700; display: block; margin-bottom: 10px;">{{ __('admin.withdrawals.show.info.reject_reason') }}</span>
                <p style="color: rgba(255,255,255,0.8); margin: 0;">{{ $withdrawal->rejection_reason }}</p>
            </div>
            @endif
        </div>
    </div>

    
    <div style="display: flex; flex-direction: column; gap: 20px;">
        
        <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 25px;">
            <h4 style="color: var(--admin-gold); font-size: 0.85rem; font-weight: 800; text-transform: uppercase; margin-bottom: 15px;">
                <i class="fas fa-calendar"></i> {{ __('admin.withdrawals.show.dates.title') }}
            </h4>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div>
                    <span style="color: rgba(255,255,255,0.5); font-size: 0.75rem; display: block;">{{ __('admin.withdrawals.show.dates.requested') }}</span>
                    <span style="color: #fff; font-weight: 600;">{{ $withdrawal->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($withdrawal->processed_at)
                <div>
                    <span style="color: rgba(255,255,255,0.5); font-size: 0.75rem; display: block;">{{ __('admin.withdrawals.show.dates.processed') }}</span>
                    <span style="color: #fff; font-weight: 600;">{{ $withdrawal->processed_at->format('d/m/Y H:i') }}</span>
                </div>
                @endif
            </div>
        </div>

        
        @if($withdrawal->status === 'pending')
        <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 25px;">
            <h4 style="color: var(--admin-gold); font-size: 0.85rem; font-weight: 800; text-transform: uppercase; margin-bottom: 15px;">
                <i class="fas fa-cog"></i> {{ __('admin.withdrawals.show.actions.title') }}
            </h4>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <button type="button" class="sh-btn-action sh-btn-approve" onclick="openModal('approveModal')" style="width: 100%; justify-content: center;">
                    <i class="fas fa-check"></i> {{ __('admin.withdrawals.show.actions.approve') }}
                </button>
                <button type="button" class="sh-btn-action sh-btn-reject" onclick="openModal('rejectModal')" style="width: 100%; justify-content: center;">
                    <i class="fas fa-times"></i> {{ __('admin.withdrawals.show.actions.reject') }}
                </button>
            </div>
        </div>
        @endif

        <a href="{{ route('admin.withdrawals.index') }}" style="display: block; padding: 12px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; text-align: center; text-decoration: none; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.08)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
            <i class="fas fa-arrow-left"></i> {{ __('admin.withdrawals.show.actions.back') }}
        </a>
    </div>
</div>


@if($withdrawal->status === 'pending')
<div class="custom-modal" id="approveModal">
    <div class="custom-modal-backdrop" onclick="closeModal('approveModal')"></div>
    <div class="custom-modal-dialog">
        <div class="custom-modal-content">
            <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST">
                @csrf
                <div class="custom-modal-header">
                    <h5 class="custom-modal-title">{{ __('admin.withdrawals.show.modal.approve_title') }}{{ $withdrawal->id }}</h5>
                    <button type="button" class="custom-modal-close" onclick="closeModal('approveModal')">&times;</button>
                </div>
                <div class="custom-modal-body">
                    <p style="color: rgba(255,255,255,0.7); margin-bottom: 15px;">{{ __('admin.withdrawals.show.modal.approve_desc') }}</p>
                    <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1);">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 0.85rem;">
                            <div>
                                <span style="color: rgba(255,255,255,0.5);">{{ __('admin.withdrawals.show.modal.approve_model') }}</span>
                                <div style="color: #fff; font-weight: 600;">{{ $withdrawal->user->name }}</div>
                            </div>
                            <div>
                                <span style="color: rgba(255,255,255,0.5);">{{ __('admin.withdrawals.show.modal.approve_amount') }}</span>
                                <div style="color: var(--admin-gold); font-weight: 700;">${{ number_format($withdrawal->amount, 2) }}</div>
                            </div>
                            <div>
                                <span style="color: rgba(255,255,255,0.5);">{{ __('admin.withdrawals.show.modal.approve_net') }}</span>
                                <div style="color: #10b981; font-weight: 700;">${{ number_format($withdrawal->net_amount, 2) }}</div>
                            </div>
                            <div>
                                <span style="color: rgba(255,255,255,0.5);">{{ __('admin.withdrawals.show.modal.approve_method') }}</span>
                                <div style="color: #fff;">{{ ucfirst(str_replace('_', ' ', $withdrawal->payment_method)) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="custom-modal-footer">
                    <button type="button" class="sh-btn-action" onclick="closeModal('approveModal')" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1);">{{ __('admin.withdrawals.show.modal.btn_cancel') }}</button>
                    <button type="submit" class="sh-btn-action sh-btn-approve">{{ __('admin.withdrawals.show.modal.btn_approve') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="custom-modal" id="rejectModal">
    <div class="custom-modal-backdrop" onclick="closeModal('rejectModal')"></div>
    <div class="custom-modal-dialog">
        <div class="custom-modal-content">
            <form action="{{ route('admin.withdrawals.reject', $withdrawal) }}" method="POST">
                @csrf
                <div class="custom-modal-header">
                    <h5 class="custom-modal-title">{{ __('admin.withdrawals.show.modal.reject_title') }}{{ $withdrawal->id }}</h5>
                    <button type="button" class="custom-modal-close" onclick="closeModal('rejectModal')">&times;</button>
                </div>
                <div class="custom-modal-body">
                    <div style="margin-bottom: 1rem;">
                        <label class="form-label">{{ __('admin.withdrawals.show.modal.reject_reason_label') }}</label>
                        <textarea name="rejection_reason" class="sh-input" rows="4" required placeholder="{{ __('admin.withdrawals.show.modal.reject_reason_placeholder') }}"></textarea>
                    </div>
                </div>
                <div class="custom-modal-footer">
                    <button type="button" class="sh-btn-action" onclick="closeModal('rejectModal')" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1);">{{ __('admin.withdrawals.show.modal.btn_cancel') }}</button>
                    <button type="submit" class="sh-btn-action sh-btn-reject">{{ __('admin.withdrawals.show.modal.btn_reject') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
function openModal(modalId) {
    document.getElementById(modalId).classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
    document.body.style.overflow = '';
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.custom-modal.active').forEach(modal => {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
});
</script>
@endsection
