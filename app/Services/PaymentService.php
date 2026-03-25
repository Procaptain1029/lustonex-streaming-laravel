<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Configuración de simulación
     */
    protected $simulationMode;
    protected $successRate;
    protected $delay;
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->simulationMode = config('payment.simulation_mode', true);
        $this->successRate = config('payment.simulation_success_rate', 90);
        $this->delay = config('payment.simulation_delay', 2);
        $this->notificationService = $notificationService;
    }

    /**
     * Procesar pago con tarjeta (simulación)
     */
    public function processCardPayment($user, $amount, $cardData, $paymentType = 'tokens', $tokensOrSubscription = null)
    {
        // Validar datos de tarjeta
        $this->validateCardData($cardData);

        // Crear registro de pago
        $payment = $this->createPaymentRecord($user, $amount, 'card', $paymentType, $tokensOrSubscription);

        if ($this->simulationMode) {
            return $this->simulateCardPayment($payment, $cardData);
        }

        // Aquí iría la integración real con Stripe u otra pasarela
        return $this->processRealCardPayment($payment, $cardData);
    }

    /**
     * Procesar pago con PayPal (simulación)
     */
    public function processPayPalPayment($user, $amount, $email, $paymentType = 'tokens', $tokensOrSubscription = null)
    {
        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception(__('admin.services.payment.invalid_paypal_email'));
        }

        // Crear registro de pago
        $payment = $this->createPaymentRecord($user, $amount, 'paypal', $paymentType, $tokensOrSubscription);

        if ($this->simulationMode) {
            return $this->simulatePayPalPayment($payment, $email);
        }

        // Aquí iría la integración real con PayPal
        return $this->processRealPayPalPayment($payment, $email);
    }

    /**
     * Procesar pago con Skrill (simulación)
     */
    public function processSkrillPayment($user, $amount, $email, $paymentType = 'tokens', $tokensOrSubscription = null)
    {
        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception(__('admin.services.payment.invalid_skrill_email'));
        }

        // Crear registro de pago
        $payment = $this->createPaymentRecord($user, $amount, 'skrill', $paymentType, $tokensOrSubscription);

        if ($this->simulationMode) {
            return $this->simulateSkrillPayment($payment, $email);
        }

        // Aquí iría la integración real con Skrill
        return $this->processRealSkrillPayment($payment, $email);
    }

    /**
     * Crear registro de pago
     */
    protected function createPaymentRecord($user, $amount, $method, $type, $tokensOrSubscription)
    {
        $data = [
            'user_id' => $user->id,
            'amount' => $amount,
            'currency' => 'USD',
            'payment_method' => $method,
            'payment_type' => $type,
            'status' => 'pending',
            'transaction_id' => $this->generateTransactionId(),
        ];

        if ($type === 'tokens') {
            $data['tokens_purchased'] = $tokensOrSubscription;
        } else {
            $data['subscription_id'] = $tokensOrSubscription;
        }

        return Payment::create($data);
    }

    /**
     * Simular pago con tarjeta
     */
    protected function simulateCardPayment($payment, $cardData)
    {
        // Simular delay de procesamiento
        sleep($this->delay);

        // Tarjetas de prueba
        $testCards = [
            '4242424242424242' => 'success', // Tarjeta de éxito
            '4000000000000002' => 'declined', // Tarjeta declinada
            '4000000000009995' => 'insufficient_funds', // Fondos insuficientes
        ];

        $cardNumber = str_replace(' ', '', $cardData['number']);
        
        // Si es tarjeta de prueba específica
        if (isset($testCards[$cardNumber])) {
            $result = $testCards[$cardNumber];
        } else {
            // Simular éxito/fallo basado en tasa de éxito
            $result = (rand(1, 100) <= $this->successRate) ? 'success' : 'declined';
        }

        if ($result === 'success') {
            $payment->update([
                'status' => 'completed',
                'payment_details' => [
                    'last4' => substr($cardNumber, -4),
                    'brand' => $this->detectCardBrand($cardNumber),
                    'exp_month' => $cardData['exp_month'],
                    'exp_year' => $cardData['exp_year'],
                ],
            ]);

            // Procesar el pago (agregar tokens o activar suscripción)
            $this->processSuccessfulPayment($payment);

            return [
                'success' => true,
                'payment' => $payment,
                'message' => __('admin.services.payment.processed_successfully'),
            ];
        } else {
            $errorMessages = [
                'declined' => __('admin.services.payment.card_declined'),
                'insufficient_funds' => __('admin.services.payment.insufficient_funds'),
            ];

            $payment->markAsFailed($errorMessages[$result] ?? __('admin.services.payment.unknown_error'));

            return [
                'success' => false,
                'payment' => $payment,
                'message' => $errorMessages[$result] ?? __('admin.services.payment.payment_error'),
            ];
        }
    }

    /**
     * Simular pago con PayPal
     */
    protected function simulatePayPalPayment($payment, $email)
    {
        sleep($this->delay);

        // Simular éxito/fallo
        $success = (rand(1, 100) <= $this->successRate);

        if ($success) {
            $payment->update([
                'status' => 'completed',
                'payment_details' => [
                    'paypal_email' => $email,
                    'payer_id' => 'SIMULATED_' . strtoupper(Str::random(10)),
                ],
            ]);

            $this->processSuccessfulPayment($payment);

            return [
                'success' => true,
                'payment' => $payment,
                'message' => __('admin.services.payment.paypal_success'),
            ];
        } else {
            $payment->markAsFailed(__('admin.services.payment.paypal_rejected_reason'));

            return [
                'success' => false,
                'payment' => $payment,
                'message' => __('admin.services.payment.paypal_rejected'),
            ];
        }
    }

    /**
     * Simular pago con Skrill
     */
    protected function simulateSkrillPayment($payment, $email)
    {
        sleep($this->delay);

        // Simular éxito/fallo
        $success = (rand(1, 100) <= $this->successRate);

        if ($success) {
            $payment->update([
                'status' => 'completed',
                'payment_details' => [
                    'skrill_email' => $email,
                    'transaction_id' => 'SKR_' . strtoupper(Str::random(12)),
                ],
            ]);

            $this->processSuccessfulPayment($payment);

            return [
                'success' => true,
                'payment' => $payment,
                'message' => __('admin.services.payment.skrill_success'),
            ];
        } else {
            $payment->markAsFailed(__('admin.services.payment.skrill_rejected_reason'));

            return [
                'success' => false,
                'payment' => $payment,
                'message' => __('admin.services.payment.skrill_rejected'),
            ];
        }
    }

    /**
     * Procesar pago exitoso (agregar tokens o activar suscripción)
     */
    protected function processSuccessfulPayment($payment)
    {
        if ($payment->payment_type === 'tokens') {
            // Agregar tokens al usuario
            $payment->user->increment('tokens', $payment->tokens_purchased);
        } elseif ($payment->payment_type === 'subscription') {
            // Activar suscripción
            if ($payment->subscription) {
                $payment->subscription->update(['status' => 'active']);
            }
        }
        
        // Enviar notificación de pago exitoso
        $this->notificationService->notifyPaymentSuccess($payment->user, $payment);
    }

    /**
     * Validar datos de tarjeta
     */
    protected function validateCardData($cardData)
    {
        $required = ['number', 'exp_month', 'exp_year', 'cvv'];
        
        foreach ($required as $field) {
            if (!isset($cardData[$field]) || empty($cardData[$field])) {
                throw new \Exception(__('admin.services.payment.required_field', ['field' => $field]));
            }
        }

        // Validar número de tarjeta (Luhn algorithm básico)
        $cardNumber = str_replace(' ', '', $cardData['number']);
        if (!$this->validateLuhn($cardNumber)) {
            throw new \Exception(__('admin.services.payment.invalid_card_number'));
        }

        // Validar CVV
        if (!preg_match('/^\d{3,4}$/', $cardData['cvv'])) {
            throw new \Exception(__('admin.services.payment.invalid_cvv'));
        }

        // Validar fecha de expiración
        $expMonth = (int) $cardData['exp_month'];
        $expYear = (int) $cardData['exp_year'];
        
        if ($expMonth < 1 || $expMonth > 12) {
            throw new \Exception(__('admin.services.payment.invalid_exp_month'));
        }

        $currentYear = (int) date('Y');
        $currentMonth = (int) date('m');
        
        if ($expYear < $currentYear || ($expYear == $currentYear && $expMonth < $currentMonth)) {
            throw new \Exception(__('admin.services.payment.expired_card'));
        }
    }

    /**
     * Algoritmo de Luhn para validar número de tarjeta
     */
    protected function validateLuhn($number)
    {
        $sum = 0;
        $numDigits = strlen($number);
        $parity = $numDigits % 2;

        for ($i = 0; $i < $numDigits; $i++) {
            $digit = (int) $number[$i];
            
            if ($i % 2 == $parity) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            
            $sum += $digit;
        }

        return ($sum % 10) == 0;
    }

    /**
     * Detectar marca de tarjeta
     */
    protected function detectCardBrand($number)
    {
        $patterns = [
            'visa' => '/^4/',
            'mastercard' => '/^5[1-5]/',
            'amex' => '/^3[47]/',
            'discover' => '/^6(?:011|5)/',
        ];

        foreach ($patterns as $brand => $pattern) {
            if (preg_match($pattern, $number)) {
                return $brand;
            }
        }

        return 'unknown';
    }

    /**
     * Generar ID de transacción único
     */
    protected function generateTransactionId()
    {
        return 'TXN_' . strtoupper(Str::random(16)) . '_' . time();
    }

    /**
     * Métodos placeholder para integración real (futuro)
     */
    protected function processRealCardPayment($payment, $cardData)
    {
        throw new \Exception(__('admin.services.payment.integration_not_implemented_card'));
    }

    protected function processRealPayPalPayment($payment, $email)
    {
        throw new \Exception(__('admin.services.payment.integration_not_implemented_paypal'));
    }

    protected function processRealSkrillPayment($payment, $email)
    {
        throw new \Exception(__('admin.services.payment.integration_not_implemented_skrill'));
    }
}
