<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\Withdrawal;
use App\Models\Stream;
use App\Models\Subscription;
use App\Models\TokenTransaction;
use App\Models\Tip;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    /**
     * Show Export index (Admin only)
     */
    public function index()
    {
        $this->authorizeAdmin();
        return view('admin.reports.exports');
    }

    /**
     * Show Export index for Models
     */
    public function modelIndex()
    {
        $this->authorizeModel();
        return view('model.reports.exports');
    }

    /**
     * Export Users CSV (Admin only)
     */
    public function exportUsers()
    {
        $this->authorizeAdmin();

        $fileName = 'usuarios_' . date('Y-m-d') . '.csv';
        $headers = [
            'ID', 'Nombre Real', 'Alias', 'Email', 'País', 'Fecha Registro', 'Rol', 'Estado', 'Último Login', 'KYC Status'
        ];

        return $this->generateCsv($fileName, $headers, function($file) {
            User::with('profile')->chunk(100, function($users) use ($file) {
                foreach ($users as $user) {
                    fputcsv($file, [
                        $user->id,
                        $user->profile->legal_name ?? 'N/A',
                        $user->profile->display_name ?? $user->name,
                        $user->email,
                        $user->profile->country ?? 'N/A',
                        $user->created_at->format('Y-m-d H:i'),
                        $user->role,
                        $user->is_active ? 'Activo' : 'Suspendido',
                        $user->last_login_at ?? 'Nunca',
                        $user->profile->verification_status ?? 'No Iniciado'
                    ]);
                }
            });
        });
    }

    /**
     * Export Transactions CSV (Admin only)
     */
    public function exportTransactions()
    {
        $this->authorizeAdmin();

        $fileName = 'transacciones_' . date('Y-m-d') . '.csv';
        $headers = [
            'ID Transacción', 'Usuario', 'Monto USD', 'Tokens', 'Pasarela', 'Estado'
        ];

        return $this->generateCsv($fileName, $headers, function($file) {
            Payment::with('user')->chunk(100, function($payments) use ($file) {
                foreach ($payments as $payment) {
                    fputcsv($file, [
                        $payment->transaction_id ?? $payment->id,
                        $payment->user->name ?? 'Usuario Eliminado',
                        $payment->amount,
                        $payment->tokens_purchased,
                        $payment->payment_method,
                        $payment->status
                    ]);
                }
            });
        });
    }

    /**
     * Export Withdrawals CSV (Admin only)
     */
    public function exportWithdrawals()
    {
        $this->authorizeAdmin();

        $fileName = 'liquidaciones_' . date('Y-m-d') . '.csv';
        $headers = [
            'ID Retiro', 'Modelo', 'Tokens Netos', 'Monto USD', 'Método Pago', 'Fecha', 'Estado'
        ];

        return $this->generateCsv($fileName, $headers, function($file) {
            Withdrawal::with('user')->chunk(100, function($withdrawals) use ($file) {
                foreach ($withdrawals as $withdrawal) {
                    fputcsv($file, [
                        $withdrawal->id,
                        $withdrawal->user->name ?? 'N/A',
                        $withdrawal->amount, // Assuming tokens
                        $withdrawal->net_amount, // Assuming USD
                        $withdrawal->payment_method,
                        $withdrawal->created_at->format('Y-m-d'),
                        $withdrawal->status
                    ]);
                }
            });
        });
    }

    /**
     * Export Streams CSV (Admin only)
     */
    public function exportStreams()
    {
        $this->authorizeAdmin();

        $fileName = 'actividad_streams_' . date('Y-m-d') . '.csv';
        $headers = [
            'ID Stream', 'Modelo', 'Fecha', 'Duración', 'Viewers Max', 'Tokens Generados'
        ];

        return $this->generateCsv($fileName, $headers, function($file) {
            Stream::with(['user', 'tips'])->chunk(100, function($streams) use ($file) {
                foreach ($streams as $stream) {
                    fputcsv($file, [
                        $stream->id,
                        $stream->user->name ?? 'N/A',
                        $stream->started_at ? $stream->started_at->format('Y-m-d') : 'N/A',
                        $stream->formatted_duration,
                        $stream->viewers_count,
                        $stream->tips->sum('amount')
                    ]);
                }
            });
        });
    }

    /**
     * Export Subscriptions CSV (Admin only)
     */
    public function exportSubscriptions()
    {
        $this->authorizeAdmin();

        $fileName = 'suscripciones_' . date('Y-m-d') . '.csv';
        $headers = [
            'ID', 'Fan', 'Modelo', 'Fecha Inicio', 'Expiración', 'Estado'
        ];

        return $this->generateCsv($fileName, $headers, function($file) {
            Subscription::with(['fan', 'model'])->chunk(100, function($subs) use ($file) {
                foreach ($subs as $sub) {
                    fputcsv($file, [
                        $sub->id,
                        $sub->fan->name ?? 'N/A',
                        $sub->model->name ?? 'N/A',
                        $sub->starts_at ? $sub->starts_at->format('Y-m-d') : 'N/A',
                        $sub->expires_at ? $sub->expires_at->format('Y-m-d') : 'N/A',
                        $sub->status
                    ]);
                }
            });
        });
    }

    /**
     * Export Model Earnings CSV
     */
    public function exportModelEarnings()
    {
        $user = $this->authorizeModel();
        $fileName = 'mis_ganancias_' . date('Y-m-d') . '.csv';
        $headers = [
            'Fecha', 'Tipo', 'Concepto', 'Tokens', 'Fan (Alias)', 'Estado'
        ];

        return $this->generateCsv($fileName, $headers, function($file) use ($user) {
            // Tips
            Tip::where('model_id', $user->id)
                ->with('fan.profile')
                ->chunk(100, function($tips) use ($file) {
                    foreach ($tips as $tip) {
                        fputcsv($file, [
                            $tip->created_at->format('Y-m-d H:i'),
                            'Propina',
                            'Propina recibida en stream',
                            $tip->amount,
                            $tip->fan->profile->display_name ?? 'Anónimo',
                            'Completado'
                        ]);
                    }
                });

            // Subscriptions
            Subscription::where('model_id', $user->id)
                ->with('fan.profile')
                ->chunk(100, function($subs) use ($file) {
                    foreach ($subs as $sub) {
                        fputcsv($file, [
                            $sub->created_at->format('Y-m-d H:i'),
                            'Suscripción',
                            'Suscripción VIP',
                            $sub->amount ?? 0,
                            $sub->fan->profile->display_name ?? 'Anónimo',
                            $sub->status
                        ]);
                    }
                });
            
            // Note: PPV Earnings would go here too if that model exists.
        });
    }

    /**
     * Export Model Performance Metrics CSV
     */
    public function exportModelPerformance()
    {
        $user = $this->authorizeModel();
        $fileName = 'rendimiento_' . date('Y-m-d') . '.csv';
        $headers = [
            'Fecha/Stream ID', 'Duración', 'Viewers Max', 'Tokens Generados', 'Fans Nuevos', 'TPM Promedio'
        ];

        return $this->generateCsv($fileName, $headers, function($file) use ($user) {
            Stream::where('user_id', $user->id)
                ->withCount('tips')
                ->chunk(100, function($streams) use ($file) {
                    foreach ($streams as $stream) {
                        fputcsv($file, [
                            $stream->started_at ? $stream->started_at->format('Y-m-d') : 'ID: ' . $stream->id,
                            $stream->formatted_duration,
                            $stream->viewers_count,
                            $stream->tips->sum('amount'), // Using sum if tips relationship is loaded or tips_count if just count needed
                            'N/A', // New fans for this specific stream might need more complex logic
                            $stream->duration > 0 ? round($stream->tips->sum('amount') / ($stream->duration / 60), 2) : 0
                        ]);
                    }
                });
        });
    }

    /**
     * Export Model Withdrawals CSV
     */
    public function exportModelWithdrawals()
    {
        $user = $this->authorizeModel();
        $fileName = 'mis_liquidaciones_' . date('Y-m-d') . '.csv';
        $headers = [
            'ID', 'Fecha Solicitud', 'Tokens Convertidos', 'Monto USD', 'Método Pago', 'Estado'
        ];

        return $this->generateCsv($fileName, $headers, function($file) use ($user) {
            Withdrawal::where('user_id', $user->id)
                ->chunk(100, function($withdrawals) use ($file) {
                    foreach ($withdrawals as $w) {
                        fputcsv($file, [
                            $w->id,
                            $w->created_at->format('Y-m-d'),
                            $w->amount, // Tokens
                            $w->net_amount, // USD
                            $w->payment_method,
                            $w->status
                        ]);
                    }
                });
        });
    }

    /**
     * Export Model Data CSV (Legacy/General)
     */
    public function exportModelData()
    {
        $user = $this->authorizeModel();
        $fileName = 'mis_datos_' . date('Y-m-d') . '.csv';
        // ... (existing logic)
        $headers = [
            'Tipo', 'Fecha', 'Concepto', 'Tokens', 'Fan (Alias)', 'Estado'
        ];

        return $this->generateCsv($fileName, $headers, function($file) use ($user) {
            // Re-using existing legacy logic or redirecting to Earnings
            // For now, keep as is but use authorizeModel
            Tip::where('model_id', $user->id)
                ->with('fan.profile')
                ->chunk(100, function($tips) use ($file) {
                    foreach ($tips as $tip) {
                        fputcsv($file, [
                            'Propina',
                            $tip->created_at->format('Y-m-d H:i'),
                            'Propina recibida',
                            $tip->amount,
                            $tip->fan->profile->display_name ?? 'Anónimo',
                            'Completado'
                        ]);
                    }
                });

            Subscription::where('model_id', $user->id)
                ->with('fan.profile')
                ->chunk(100, function($subs) use ($file) {
                    foreach ($subs as $sub) {
                        fputcsv($file, [
                            'Suscripción',
                            $sub->created_at->format('Y-m-d H:i'),
                            'Nueva suscripción/renovación',
                            $sub->amount,
                            $sub->fan->profile->display_name ?? 'Anónimo',
                            $sub->status
                        ]);
                    }
                });
            
            Withdrawal::where('user_id', $user->id)
                ->chunk(100, function($withdrawals) use ($file) {
                    foreach ($withdrawals as $w) {
                        fputcsv($file, [
                            'Retiro',
                            $w->created_at->format('Y-m-d H:i'),
                            'Solicitud de retiro',
                            $w->amount,
                            'N/A',
                            $w->status
                        ]);
                    }
                });
        });
    }

    /**
     * Helper to generate CSV stream
     */
    private function generateCsv($fileName, $headers, $callback)
    {
        $response = new StreamedResponse(function() use ($headers, $callback) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            $callback($file);
            fclose($file);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }

    /**
     * Ensure user is admin
     */
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado.');
        }
    }

    /**
     * Ensure user is model
     */
    private function authorizeModel()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'model') {
            abort(403, 'Acceso denegado.');
        }
        return $user;
    }
}
