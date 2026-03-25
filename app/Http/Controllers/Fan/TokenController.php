<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use App\Models\TokenTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\LegalAcceptance;
use Carbon\Carbon;

class TokenController extends Controller
{
    protected $paymentService;

    public function __construct(\App\Services\PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return redirect()->route('home')->with('error', __('admin.flash.fan.access_denied'));
        }
        
        
        $tipsSent = $user->tipsSent()->sum('amount') ?? 0;
        $tipsCount = $user->tipsSent()->count();
        
        
        $payments = $user->payments()->where('status', 'completed');
        $tokensPurchased = $payments->sum('tokens_purchased');
        $totalSpent = $payments->sum('amount');
        
        $stats = [
            'balance' => $user->tokens ?? 0,
            'tips_sent' => $tipsSent,
            'tips_count' => $tipsCount,
            'tokens_purchased' => $tokensPurchased,
            'total_spent' => $totalSpent,
        ];
        
        
        $xpFromTokens = $user->getXPFromTokens();
        $xpFromTips = $user->getXPFromTips();
        $tokenMissions = $user->getActiveMissionsByType('tokens');
        $cashbackPercentage = $user->getCashbackPercentage();
        $nextLevelBenefit = $user->getNextTokenBenefit();
        $currentLevel = ($user->progress && $user->progress->currentLevel) ? $user->progress->currentLevel->level_number : 0;
        
        
        // Obtener transacciones directamente de TokenTransaction
        $transactions = TokenTransaction::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function($t) {
                return (object) [
                    'id' => $t->id,
                    'type' => $t->type,
                    'description' => $t->description,
                    'amount' => ($t->type === 'spent') ? -$t->amount : $t->amount,
                    'created_at' => $t->created_at,
                    'status' => 'completed',
                    'balance_after' => $t->balance_after
                ];
            });
        
        return view('fan.tokens.index', compact(
            'user',
            'stats',
            'transactions',
            'xpFromTokens',
            'xpFromTips',
            'tokenMissions',
            'cashbackPercentage',
            'nextLevelBenefit',
            'currentLevel'
        ));
    }
    
    
    public function recharge()
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return redirect()->route('home')->with('error', __('admin.flash.fan.access_denied'));
        }
        
        
        $packages = \App\Models\TokenPackage::where('is_active', true)
            ->where(function ($query) {
                $query->where('is_limited_time', false)
                      ->orWhere('expires_at', '>', now());
            })
            ->orderBy('price')
            ->get()
            ->map(function ($pkg) {
                return [
                    'id' => $pkg->id,
                    'title' => $pkg->name,
                    'name' => $pkg->name,
                    'tokens' => $pkg->tokens,
                    'price' => $pkg->price,
                    'bonus' => $pkg->bonus,
                    'total' => $pkg->tokens + $pkg->bonus,
                    'popular' => ($pkg->tokens == 1000),
                    'best_value' => ($pkg->tokens >= 5000),
                    'is_limited_time' => $pkg->is_limited_time,
                    'expires_at' => $pkg->expires_at ? $pkg->expires_at->format('Y-m-d\TH:i:s') : null
                ];
            });
        
        return view('fan.tokens.recharge', compact('user', 'packages'));
    }
    
    
    public function history()
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return redirect()->route('home')->with('error', __('admin.flash.fan.access_denied'));
        }
        
        // Full history for statistics
        $allTransactions = TokenTransaction::where('user_id', $user->id)->get();
        
        // Paginated transactions for the list
        $transactions = TokenTransaction::where('user_id', $user->id)
            ->latest()
            ->paginate(10)
            ->through(function($t) {
                return (object) [
                    'id' => $t->id,
                    'type' => $t->type,
                    'description' => $t->description,
                    'amount' => ($t->type === 'spent') ? -$t->amount : $t->amount,
                    'created_at' => $t->created_at,
                    'status' => 'completed',
                    'balance_after' => $t->balance_after,
                    'message' => null
                ];
            });
        
        // Estadísticas básicas basadas en todo el historial
        $stats = [
            'total_spent' => $allTransactions->where('type', 'spent')->count(),
            'total_recharges' => $allTransactions->where('type', 'purchase')->count(),
            'total_spent_amount' => abs($allTransactions->where('type', 'spent')->sum('amount')),
            'total_recharged_amount' => $allTransactions->where('type', 'purchase')->sum('amount'),
            'this_month_spent' => $allTransactions->where('type', 'spent')->filter(function($t) {
                return $t->created_at->isCurrentMonth();
            })->count(),
        ];
        
        return view('fan.tokens.history', compact('user', 'transactions', 'stats'));
    }
    
    
    public function quickRecharge(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.access_denied')], 403);
        }
        
        $validator = Validator::make($request->all(), [
            'tokens' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.invalid_data')], 400);
        }

        $packages = \App\Models\TokenPackage::where('is_active', true)->get();
        $package = $packages->first(function($pkg) use ($request) {
            return ($pkg->tokens == $request->tokens || ($pkg->tokens + $pkg->bonus) == $request->tokens) 
                   && round($pkg->price, 2) == round($request->price, 2);
        });

        if (!$package) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.invalid_package')], 400);
        }

        // Use the total tokens from the package to be safe
        $totalTokens = $package->tokens + $package->bonus;
        
        try {
            DB::beginTransaction();
            
            
            
            
            
            $currentTokens = $user->tokens ?? 0;
            $newTokens = $currentTokens + $totalTokens;
            
            $user->update(['tokens' => $newTokens]);
            
            
            TokenTransaction::create([
                'user_id'      => $user->id,
                'type'         => 'purchase',
                'amount'       => $totalTokens,
                'description'  => __('admin.flash.fan.recharge_tx', ['count' => $totalTokens]),
                'balance_after'=> $newTokens,
            ]);

            LegalAcceptance::create([
                'user_id' => $user->id,
                'acceptance_type' => 'purchase',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'accepted_at' => Carbon::now(),
            ]);
            
            DB::commit();
            
            return response()->json([
                'success'     => true,
                'message'     => __('admin.flash.fan.recharge_success'),
                'new_balance' => $newTokens
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.fan.recharge_error')
            ], 500);
        }
    }
    
    
    public function purchase(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.access_denied')], 403);
        }
        
        $validator = Validator::make($request->all(), [
            'tokens' => 'required|integer',
            'total_tokens' => 'required|integer',
            'price' => 'required|numeric',
            'payment_method' => 'required|string|in:card,paypal,skrill',
            'card_data' => 'required_if:payment_method,card|array',
            'email' => 'required_if:payment_method,paypal,skrill|email',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }
        
        $package = \App\Models\TokenPackage::where('tokens', $request->tokens)
            ->where('is_active', true)
            ->first();

        if (!$package || round($package->price, 2) != round($request->price, 2) || ($package->tokens + $package->bonus) != $request->total_tokens) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.invalid_price')], 400);
        }
        
        try {
            $result = null;

            if ($request->payment_method === 'card') {
                $result = $this->paymentService->processCardPayment(
                    $user,
                    $request->price,
                    $request->card_data,
                    'tokens',
                    $request->total_tokens
                );
            } elseif ($request->payment_method === 'paypal') {
                $result = $this->paymentService->processPayPalPayment(
                    $user,
                    $request->price,
                    $request->email,
                    'tokens',
                    $request->total_tokens
                );
            } else {
                $result = $this->paymentService->processSkrillPayment(
                    $user,
                    $request->price,
                    $request->email,
                    'tokens',
                    $request->total_tokens
                );
            }
            
            if ($result['success']) {
                
                TokenTransaction::create([
                    'user_id'      => $user->id,
                    'type'         => 'purchase',
                    'amount'       => $request->total_tokens,
                    'description'  => __('admin.flash.fan.purchase_tx', ['total' => $request->total_tokens, 'base' => $request->tokens]),
                    'balance_after'=> $user->fresh()->tokens,
                ]);

                LegalAcceptance::create([
                    'user_id' => $user->id,
                    'acceptance_type' => 'purchase',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'accepted_at' => Carbon::now(),
                ]);
                
                
                event(new \App\Events\TokensPurchased($user, $request->price, $request->total_tokens));
                
                return response()->json([
                    'success'     => true,
                    'message'     => __('admin.flash.fan.purchase_success'),
                    'new_balance' => $user->fresh()->tokens
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 400);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
