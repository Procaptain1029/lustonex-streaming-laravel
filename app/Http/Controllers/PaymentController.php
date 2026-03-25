<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    
    public function showTokenPackages()
    {
        $packages = config('payment.token_packages');
        $userTokens = auth()->user()->tokens ?? 0;
        
        return view('payment.packages', compact('packages', 'userTokens'));
    }

    
    public function selectPaymentMethod(Request $request)
    {
        $validated = $request->validate([
            'package' => 'required|integer|in:' . implode(',', array_keys(config('payment.token_packages'))),
        ]);

        $package = $validated['package'];
        $amount = config('payment.token_packages')[$package];
        $methods = config('payment.supported_methods');

        return view('payment.select-method', compact('package', 'amount', 'methods'));
    }

    
    public function showCardForm(Request $request)
    {
        $package = $request->input('package');
        $amount = config('payment.token_packages')[$package];
        $testCards = config('payment.test_cards');

        return view('payment.card', compact('package', 'amount', 'testCards'));
    }

    
    public function processCardPayment(Request $request)
    {
        $validated = $request->validate([
            'package' => 'required|integer|in:' . implode(',', array_keys(config('payment.token_packages'))),
            'card_number' => 'required|string',
            'card_name' => 'required|string|max:255',
            'exp_month' => 'required|integer|min:1|max:12',
            'exp_year' => 'required|integer|min:' . date('Y'),
            'cvv' => 'required|string|regex:/^\d{3,4}$/',
        ]);

        $package = $validated['package'];
        $amount = config('payment.token_packages')[$package];

        $cardData = [
            'number' => $validated['card_number'],
            'name' => $validated['card_name'],
            'exp_month' => $validated['exp_month'],
            'exp_year' => $validated['exp_year'],
            'cvv' => $validated['cvv'],
        ];

        try {
            $result = $this->paymentService->processCardPayment(
                auth()->user(),
                $amount,
                $cardData,
                'tokens',
                $package
            );

            if ($result['success']) {
                return redirect()->route('fan.payment.success')
                                ->with('payment', $result['payment'])
                                ->with('message', $result['message']);
            } else {
                return redirect()->route('fan.payment.failed')
                                ->with('payment', $result['payment'])
                                ->with('message', $result['message']);
            }
        } catch (\Exception $e) {
            return redirect()->route('fan.payment.failed')
                            ->with('message', $e->getMessage());
        }
    }

    
    public function showPayPalForm(Request $request)
    {
        $package = $request->input('package');
        $amount = config('payment.token_packages')[$package];

        return view('payment.paypal', compact('package', 'amount'));
    }

    
    public function processPayPalPayment(Request $request)
    {
        $validated = $request->validate([
            'package' => 'required|integer|in:' . implode(',', array_keys(config('payment.token_packages'))),
            'paypal_email' => 'required|email',
        ]);

        $package = $validated['package'];
        $amount = config('payment.token_packages')[$package];

        try {
            $result = $this->paymentService->processPayPalPayment(
                auth()->user(),
                $amount,
                $validated['paypal_email'],
                'tokens',
                $package
            );

            if ($result['success']) {
                return redirect()->route('fan.payment.success')
                                ->with('payment', $result['payment'])
                                ->with('message', $result['message']);
            } else {
                return redirect()->route('fan.payment.failed')
                                ->with('payment', $result['payment'])
                                ->with('message', $result['message']);
            }
        } catch (\Exception $e) {
            return redirect()->route('fan.payment.failed')
                            ->with('message', $e->getMessage());
        }
    }

    
    public function showSkrillForm(Request $request)
    {
        $package = $request->input('package');
        $amount = config('payment.token_packages')[$package];

        return view('payment.skrill', compact('package', 'amount'));
    }

    
    public function processSkrillPayment(Request $request)
    {
        $validated = $request->validate([
            'package' => 'required|integer|in:' . implode(',', array_keys(config('payment.token_packages'))),
            'skrill_email' => 'required|email',
        ]);

        $package = $validated['package'];
        $amount = config('payment.token_packages')[$package];

        try {
            $result = $this->paymentService->processSkrillPayment(
                auth()->user(),
                $amount,
                $validated['skrill_email'],
                'tokens',
                $package
            );

            if ($result['success']) {
                return redirect()->route('fan.payment.success')
                                ->with('payment', $result['payment'])
                                ->with('message', $result['message']);
            } else {
                return redirect()->route('fan.payment.failed')
                                ->with('payment', $result['payment'])
                                ->with('message', $result['message']);
            }
        } catch (\Exception $e) {
            return redirect()->route('fan.payment.failed')
                            ->with('message', $e->getMessage());
        }
    }

    
    public function paymentSuccess()
    {
        $payment = session('payment');
        $message = session('message');

        if (!$payment) {
            return redirect()->route('fan.tokens.index');
        }

        return view('payment.success', compact('payment', 'message'));
    }

    
    public function paymentFailed()
    {
        $payment = session('payment');
        $message = session('message', __('admin.flash.payment.failed_default'));

        return view('payment.failed', compact('payment', 'message'));
    }

    
    public function paymentHistory()
    {
        return redirect()->route('fan.tokens.index');
    }
}
