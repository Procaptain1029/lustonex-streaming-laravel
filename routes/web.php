<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilePublicController;
use App\Http\Controllers\StreamViewController;
use App\Http\Controllers\Model\DashboardController as ModelDashboardController;
use App\Http\Controllers\Model\DashboardControllerSimple;
use App\Http\Controllers\Model\ProfileController as ModelProfileController;
use App\Http\Controllers\Model\PhotoController as ModelPhotoController;
use App\Http\Controllers\Model\VideoController as ModelVideoController;
use App\Http\Controllers\Model\StreamController as ModelStreamController;
use App\Http\Controllers\Model\OnboardingController as ModelOnboardingController;
use App\Http\Controllers\Model\NotificationController as ModelNotificationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\VerificationController as AdminVerificationController;
use App\Http\Controllers\Fan\DashboardController as FanDashboardController;
use App\Http\Controllers\Fan\TokenController as FanTokenController;
use App\Http\Controllers\Fan\SubscriptionController as FanSubscriptionController;
use App\Http\Controllers\Model\MissionController as ModelMissionController;
use App\Http\Controllers\Model\AchievementController as ModelAchievementController;
use App\Http\Controllers\Model\LeaderboardController as ModelLeaderboardController;
use App\Http\Controllers\Model\EarningsController as ModelEarningsController;
use App\Http\Controllers\Model\AnalyticsController as ModelAnalyticsController;
use App\Http\Controllers\Model\WithdrawalController as ModelWithdrawalController;
use App\Http\Controllers\Admin\GamificationAchievementController;
use App\Http\Controllers\Admin\GamificationMissionController;
use App\Http\Controllers\Admin\GamificationLevelController;
use App\Http\Controllers\Admin\GamificationBadgeController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\FinanceSubscriptionController;
use App\Http\Controllers\Admin\FinanceTipController;
use App\Http\Controllers\Admin\WithdrawalManagementController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\StreamManagementController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\TokenManagementController;
use App\Http\Controllers\Admin\MessageModerationController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReportController as PublicReportController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ExportController;

use Illuminate\Support\Facades\Route;


Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return 'Cache limpiada correctamente';
});


Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
});


Route::post('/locale', [LocaleController::class, 'update'])->name('locale.update');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/modelos/vip', [HomeController::class, 'vipModelos'])->name('modelos.vip');



Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isModel()) {
        return redirect()->route('model.dashboard');
    } elseif ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isFan()) {
        return redirect()->route('fan.dashboard');
    } else {
        return redirect()->route('home');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified', 'role:model'])->prefix('model')->name('model.')->group(function () {

    Route::get('/onboarding', [ModelOnboardingController::class, 'index'])->name('onboarding.index');
    Route::get('/onboarding/step/{step}', [ModelOnboardingController::class, 'step'])->name('onboarding.step');
    Route::post('/onboarding/step1', [ModelOnboardingController::class, 'processStep1'])->name('onboarding.step1');
    Route::post('/onboarding/step2', [ModelOnboardingController::class, 'processStep2'])->name('onboarding.step2');
    Route::post('/onboarding/step3', [ModelOnboardingController::class, 'processStep3'])->name('onboarding.step3');
});


Route::middleware(['auth', 'verified', 'role:model', 'model.onboarding'])->prefix('model')->name('model.')->group(function () {
    Route::get('/dashboard', [ModelDashboardController::class, 'index'])->name('dashboard');
});


Route::middleware(['auth', 'role:model', 'verified', 'model.onboarding'])->prefix('model')->name('model.')->group(function () {

    Route::resource('photos', ModelPhotoController::class)->except(['show', 'edit', 'update']);


    Route::resource('videos', ModelVideoController::class)->except(['show', 'edit', 'update']);


    Route::get('/streams/settings', [ModelStreamController::class, 'settings'])->name('streams.settings');
    Route::post('/streams/settings', [ModelStreamController::class, 'updateSettings'])->name('streams.updateSettings');


    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::get('/{conversation}', [ChatController::class, 'show'])->name('show');
        Route::get('/{conversation}/messages', [ChatController::class, 'getMessages'])->name('messages');
        Route::post('/{conversation}/message', [ChatController::class, 'sendMessage'])->name('send');
    });


    Route::resource('streams', ModelStreamController::class)->except(['edit', 'update']);
    Route::get('/streams/{stream}/admin', [ModelStreamController::class, 'admin'])->name('streams.admin');
    Route::get('/streams/{stream}/live', [ModelStreamController::class, 'live'])->name('streams.live');
    Route::post('/streams/{stream}/pause', [ModelStreamController::class, 'pause'])->name('streams.pause');
    Route::post('/streams/{stream}/resume', [ModelStreamController::class, 'resume'])->name('streams.resume');
    Route::post('/streams/{stream}/end', [ModelStreamController::class, 'end'])->name('streams.end');
    Route::get('/streams/{stream}/actions', [ModelStreamController::class, 'getActions'])->name('streams.actions.get');
    Route::post('/streams/{stream}/actions/{tip}/complete', [ModelStreamController::class, 'completeAction'])->name('streams.actions.complete');
    Route::post('/streams/{stream}/chat/reply', [ModelStreamController::class, 'sendChatReply'])->name('streams.chat.reply');
    Route::get('/streams/{stream}/chat/new', [ModelStreamController::class, 'getNewChatMessages'])->name('streams.chat.new');
    Route::post('/streams/{stream}/chat/{message}/pin', [ModelStreamController::class, 'pinMessage'])->name('streams.chat.pin');
    Route::post('/streams/{stream}/chat/unpin', [ModelStreamController::class, 'unpinAllMessages'])->name('streams.chat.unpin');
    Route::get('/streams/{stream}/feed', [ModelStreamController::class, 'streamActivityFeed'])->name('streams.feed');


    Route::post('/obs/generate-key', [App\Http\Controllers\RTMPController::class, 'generateStreamKey'])->name('obs.generate-key');
    Route::get('/obs/test-auth', function () {
        $user = auth()->user();
        return response()->json([
            'authenticated' => !!$user,
            'user_id' => $user ? $user->id : null,
            'user_role' => $user ? $user->role : null,
            'is_model' => $user ? $user->isModel() : false
        ]);
    })->name('obs.test-auth');


    Route::get('/streams/{stream}/live-hls', function ($streamId) {

        $m3u8Content = "#EXTM3U\n#EXT-X-VERSION:3\n#EXT-X-TARGETDURATION:10\n#EXT-X-MEDIA-SEQUENCE:0\n#EXT-X-ENDLIST\n";

        return response($m3u8Content)
            ->header('Content-Type', 'application/vnd.apple.mpegurl')
            ->header('Access-Control-Allow-Origin', '*');
    })->name('streams.live-hls');


    Route::get('/debug/hls/{path?}', function ($path = '') {
        $hlsPath = public_path('hls');
        $fullPath = $path ? $hlsPath . '/' . $path : $hlsPath;

        if (is_dir($fullPath)) {
            $files = scandir($fullPath);
            return response()->json([
                'path' => $fullPath,
                'exists' => true,
                'type' => 'directory',
                'contents' => array_diff($files, ['.', '..'])
            ]);
        } elseif (file_exists($fullPath)) {
            return response()->json([
                'path' => $fullPath,
                'exists' => true,
                'type' => 'file',
                'size' => filesize($fullPath),
                'modified' => date('Y-m-d H:i:s', filemtime($fullPath))
            ]);
        } else {
            return response()->json([
                'path' => $fullPath,
                'exists' => false,
                'message' => 'File or directory not found'
            ], 404);
        }
    })->where('path', '.*');
});


Route::get('/hls/{path}', function ($path) {
    $hlsPath = public_path('hls/' . $path);

    if (!file_exists($hlsPath)) {
        abort(404, 'HLS file not found');
    }

    $mimeType = 'application/octet-stream';

    if (str_ends_with($path, '.m3u8')) {
        $mimeType = 'application/vnd.apple.mpegurl';
    } elseif (str_ends_with($path, '.ts')) {
        $mimeType = 'video/mp2t';
    }

    return response()->file($hlsPath, [
        'Content-Type' => $mimeType,
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
        'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept, Authorization',
        'Cache-Control' => str_ends_with($path, '.m3u8') ? 'no-cache, no-store, must-revalidate' : 'public, max-age=31536000'
    ]);
})->where('path', '.*');


Route::middleware(['auth', 'verified', 'role:model', 'model.onboarding'])->prefix('model')->name('model.')->group(function () {
    Route::get('/profile/edit', [ModelProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ModelProfileController::class, 'update'])->name('profile.update');
});


Route::middleware(['auth', 'role:fan'])->prefix('fan')->name('fan.')->group(function () {
    Route::get('/dashboard', [FanDashboardController::class, 'index'])->name('dashboard');


    Route::get('/tokens', [FanTokenController::class, 'index'])->name('tokens.index');
    Route::get('/tokens/recharge', [FanTokenController::class, 'recharge'])->name('tokens.recharge');
    Route::get('/tokens/history', [FanTokenController::class, 'history'])->name('tokens.history');
    Route::post('/tokens/quick-recharge', [FanTokenController::class, 'quickRecharge'])->name('tokens.quick-recharge');
    Route::post('/tokens/purchase', [FanTokenController::class, 'purchase'])->name('tokens.purchase');


    Route::get('/subscriptions', [FanSubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscriptions/{model}/subscribe', [FanSubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
    Route::delete('/subscriptions/{subscription}', [FanSubscriptionController::class, 'cancel'])->name('subscriptions.cancel');


    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/packages', [PaymentController::class, 'showTokenPackages'])->name('packages');
        Route::post('/select-method', [PaymentController::class, 'selectPaymentMethod'])->name('select-method');


        Route::get('/card', [PaymentController::class, 'showCardForm'])->name('card.form');
        Route::post('/card', [PaymentController::class, 'processCardPayment'])->name('card.process');


        Route::get('/paypal', [PaymentController::class, 'showPayPalForm'])->name('paypal.form');
        Route::post('/paypal', [PaymentController::class, 'processPayPalPayment'])->name('paypal.process');


        Route::get('/skrill', [PaymentController::class, 'showSkrillForm'])->name('skrill.form');
        Route::post('/skrill', [PaymentController::class, 'processSkrillPayment'])->name('skrill.process');


        Route::get('/success', [PaymentController::class, 'paymentSuccess'])->name('success');
        Route::get('/failed', [PaymentController::class, 'paymentFailed'])->name('failed');


        Route::get('/history', [PaymentController::class, 'paymentHistory'])->name('history');
    });


    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/', [NotificationController::class, 'destroyAll'])->name('destroy-all');
        Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
    });
});


Route::middleware(['auth', 'verified', 'check.active'])->prefix('fan/chat')->name('fan.chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::get('/new/{user}', [ChatController::class, 'create'])->name('create');
    Route::get('/{conversation}', [ChatController::class, 'show'])->name('show');
    Route::get('/{conversation}/messages', [ChatController::class, 'getMessages'])->name('messages');
    Route::post('/{conversation}/message', [ChatController::class, 'sendMessage'])->name('send');
    Route::post('/{conversation}/extend', [ChatController::class, 'extend'])->name('extend');
    Route::get('/api/unread-count', [ChatController::class, 'unreadCount'])->name('unread-count');
});


Route::get('/profile/{model}', [ProfilePublicController::class, 'show'])->name('profiles.show');
Route::post('/profile/{model}/subscribe', [ProfilePublicController::class, 'subscribe'])
    ->middleware('auth')
    ->name('profiles.subscribe');
Route::post('/profile/{model}/tip', [ProfilePublicController::class, 'sendTip'])
    ->middleware('auth')
    ->name('profiles.tip');
Route::post('/profile/{model}/spin', [ProfilePublicController::class, 'spinRoulette'])
    ->middleware('auth')
    ->name('profiles.spin');
Route::get('/profile/{model}/chat/history', [ProfilePublicController::class, 'getChatHistory'])
    ->name('profiles.chat.history');
Route::post('/profile/{model}/chat', [ProfilePublicController::class, 'sendPublicMessage'])
    ->middleware('auth')
    ->name('profiles.chat.send');
Route::post('/profile/{model}/chat/unlock', [ProfilePublicController::class, 'unlockPrivateChat'])
    ->middleware('auth')
    ->name('profiles.chat.unlock');


Route::get('/stream/{stream}', [StreamViewController::class, 'show'])
    ->middleware(['auth', 'subscription'])
    ->name('streams.show');

Route::post('/stream/{stream}/chat', [StreamViewController::class, 'sendMessage'])
    ->middleware('auth')
    ->name('streams.chat');

Route::get('/stream/{stream}/chat/poll', [StreamViewController::class, 'pollChat'])
    ->middleware(['auth', 'subscription'])
    ->name('streams.chat.poll');

Route::post('/stream/{stream}/tip', [StreamViewController::class, 'sendTip'])
    ->middleware('auth')
    ->name('streams.tip');

Route::post('/chat/{message}/hide', [StreamViewController::class, 'hideMessage'])
    ->middleware('auth')
    ->name('chat.hide');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');



    Route::get('/models', [AdminUserController::class, 'index_model'])->name('models.index');
    Route::get('/models/{user}', [AdminUserController::class, 'showModel'])->name('models.show');
    Route::post('/models/{user}/approve-email', [AdminUserController::class, 'approveEmail'])
        ->name('models.approveEmail');

    Route::post('/models/{user}/resend-verification', [AdminUserController::class, 'resendVerification'])
        ->name('models.resendVerification');



    Route::resource('users', AdminUserController::class);
    Route::post('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');


    Route::get('/photos', [AdminContentController::class, 'photos'])->name('content.photos');
    Route::post('/photos/mass-action', [AdminContentController::class, 'massAction'])->name('photos.mass-action');
    Route::post('/photos/{photo}/approve', [AdminContentController::class, 'approvePhoto'])->name('photos.approve');
    Route::post('/photos/{photo}/reject', [AdminContentController::class, 'rejectPhoto'])->name('photos.reject');
    Route::delete('/photos/{photo}', [AdminContentController::class, 'deletePhoto'])->name('photos.delete');

    Route::get('/videos', [AdminContentController::class, 'videos'])->name('content.videos');
    Route::post('/videos/{video}/approve', [AdminContentController::class, 'approveVideo'])->name('videos.approve');
    Route::post('/videos/{video}/reject', [AdminContentController::class, 'rejectVideo'])->name('videos.reject');
    Route::delete('/videos/{video}', [AdminContentController::class, 'deleteVideo'])->name('videos.delete');


    Route::get('/verification', [AdminVerificationController::class, 'index'])->name('verification.index');
    Route::get('/verification/stats', [AdminVerificationController::class, 'stats'])->name('verification.stats');
    Route::get('/verification/{profile}', [AdminVerificationController::class, 'show'])->name('verification.show');
    Route::post('/verification/{profile}/approve', [AdminVerificationController::class, 'approve'])->name('verification.approve');
    Route::post('/verification/{profile}/reject', [AdminVerificationController::class, 'reject'])->name('verification.reject');
    Route::post('/verification/{profile}/review', [AdminVerificationController::class, 'review'])->name('verification.review');


    Route::prefix('gamification')->name('gamification.')->group(function () {
        Route::resource('achievements', GamificationAchievementController::class);
        Route::resource('missions', GamificationMissionController::class);
        Route::resource('levels', GamificationLevelController::class);
        Route::resource('badges', GamificationBadgeController::class);
        Route::post('badges/{badge}/toggle-active', [GamificationBadgeController::class, 'toggleActive'])->name('badges.toggle-active');
        Route::get('debug/{user}', [\App\Http\Controllers\Admin\GamificationDebuggerController::class, 'show'])->name('debugger');

        Route::get('xp-settings', [\App\Http\Controllers\Admin\GamificationXpSettingsController::class, 'index'])->name('xp-settings.index');
        Route::post('xp-settings', [\App\Http\Controllers\Admin\GamificationXpSettingsController::class, 'update'])->name('xp-settings.update');
    });


    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::get('/subscriptions', [FinanceSubscriptionController::class, 'index'])->name('subscriptions');
        Route::get('/tips', [FinanceTipController::class, 'index'])->name('tips');
    });


    Route::prefix('streams')->name('streams.')->group(function () {
        Route::get('/moderate', [StreamManagementController::class, 'moderate'])->name('moderate');
        Route::get('/', [StreamManagementController::class, 'index'])->name('index');
        Route::post('/{stream}/end', [StreamManagementController::class, 'end'])->name('end');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::post('/{report}/resolve', [ReportController::class, 'resolve'])->name('resolve');
        Route::post('/{report}/dismiss', [ReportController::class, 'dismiss'])->name('dismiss');


        Route::get('/exports', [ExportController::class, 'index'])->name('exports.index');
        Route::get('/exports/users', [ExportController::class, 'exportUsers'])->name('exports.users');
        Route::get('/exports/transactions', [ExportController::class, 'exportTransactions'])->name('exports.transactions');
        Route::get('/exports/withdrawals', [ExportController::class, 'exportWithdrawals'])->name('exports.withdrawals');
        Route::get('/exports/streams', [ExportController::class, 'exportStreams'])->name('exports.streams');
        Route::get('/exports/subscriptions', [ExportController::class, 'exportSubscriptions'])->name('exports.subscriptions');
    });


    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/update', [SettingsController::class, 'update'])->name('update');
    });

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');


    Route::get('/tokens', [TokenManagementController::class, 'index'])->name('tokens.index');
    Route::resource('token-packages', \App\Http\Controllers\Admin\TokenPackageController::class)->except(['show']);


    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageModerationController::class, 'index'])->name('index');
        Route::delete('/{message}', [MessageModerationController::class, 'destroy'])->name('destroy');
        Route::post('/{message}/toggle-flag', [MessageModerationController::class, 'toggleFlag'])->name('toggle-flag');
    });


    Route::prefix('withdrawals')->name('withdrawals.')->group(function () {
        Route::get('/', [WithdrawalManagementController::class, 'index'])->name('index');
        Route::get('/{withdrawal}', [WithdrawalManagementController::class, 'show'])->name('show');
        Route::post('/{withdrawal}/approve', [WithdrawalManagementController::class, 'approve'])->name('approve');
        Route::post('/{withdrawal}/reject', [WithdrawalManagementController::class, 'reject'])->name('reject');
    });


    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
});


Route::get('/search/models', [SearchController::class, 'searchModels'])->name('search.models');
Route::get('/api/filter-counts', [SearchController::class, 'getFilterCounts'])->name('api.filter-counts');


Route::get('/modelos/nuevas', [HomeController::class, 'nuevasModelos'])->name('modelos.nuevas');
Route::get('/modelos/nivel-alto', [HomeController::class, 'nivelAltoModelos'])->name('modelos.nivel-alto');
Route::get('/modelos/vip-popular', [HomeController::class, 'vipPopularModelos'])->name('modelos.vip-popular');
Route::get('/modelos/favoritas', [HomeController::class, 'favoritasModelos'])->name('modelos.favoritas');


Route::get('/filtros/pais/{pais}', [HomeController::class, 'filtrarPorPais'])->name('filtros.pais');
Route::get('/filtros/edad/{rango}', [HomeController::class, 'filtrarPorEdad'])->name('filtros.edad');
Route::get('/filtros/etnia/{etnia}', [HomeController::class, 'filtrarPorEtnia'])->name('filtros.etnia');
Route::get('/filtros/cabello/{tipo}', [HomeController::class, 'filtrarPorCabello'])->name('filtros.cabello');


Route::get('/register/model', function () {
    return view('auth.register-model');
})->middleware('guest')->name('register.model');

Route::post('/register/model', [App\Http\Controllers\Auth\RegisteredUserController::class, 'storeModel'])
    ->middleware('guest')
    ->name('register.model.store');


Route::get('/model-help', function () {
    return view('pages.coming-soon', [
        'title' => 'Centro de Ayuda',
        'description' => 'Estamos construyendo un centro de ayuda completo para resolver todas tus dudas como modelo.'
    ]);
})->name('model.help');

Route::get('/model-safety', function () {
    return view('pages.coming-soon', [
        'title' => 'Seguridad',
        'description' => 'Tu seguridad es nuestra prioridad. Pronto encontrarás aquí guías y recursos para mantener tu privacidad y seguridad.'
    ]);
})->name('model.safety');

Route::get('/model-academy', function () {
    return view('pages.coming-soon', [
        'title' => 'Academia de Modelos',
        'description' => 'Aprende, crece y triunfa. Pronto lanzaremos nuestra academia con consejos expertos para maximizar tus ingresos.'
    ]);
})->name('model.academy');


Route::prefix('legal')->name('legal.')->group(function () {
    Route::get('/terms', [LegalController::class, 'terms'])->name('terms');
    Route::get('/privacy', [LegalController::class, 'privacy'])->name('privacy');
    Route::get('/cookies', [LegalController::class, 'cookies'])->name('cookies');
    Route::get('/dmca', [LegalController::class, 'dmca'])->name('dmca');
    Route::get('/compliance-2257', [LegalController::class, 'compliance'])->name('compliance');


    Route::get('/model-contract', [LegalController::class, 'modelContract'])->name('model-contract');
    Route::get('/studio-contract', [LegalController::class, 'studioContract'])->name('studio-contract');
    Route::get('/affiliate-agreement', [LegalController::class, 'affiliateAgreement'])->name('affiliate-agreement');
    Route::get('/moderation-policy', [LegalController::class, 'moderationPolicy'])->name('moderation-policy');
    Route::get('/protection-policy', [LegalController::class, 'protectionPolicy'])->name('protection-policy');
    Route::get('/model-release', [LegalController::class, 'modelRelease'])->name('model-release');
    Route::get('/tax-policy', [LegalController::class, 'taxPolicy'])->name('tax-policy');
});


Route::prefix('support')->name('support.')->group(function () {
    Route::get('/', function () {
        return view('pages.coming-soon', [
            'title' => 'Soporte 24/7',
            'description' => 'Nuestro equipo de soporte estará disponible las 24 horas. Pronto habilitaremos nuestro centro de ayuda.'
        ]);
    })->name('main');

    Route::get('/billing', function () {
        return view('pages.coming-soon', [
            'title' => 'Facturación',
            'description' => 'Información sobre pagos, historial de transacciones y gestión de métodos de pago.'
        ]);
    })->name('billing');

    Route::get('/faq', function () {
        return view('pages.coming-soon', [
            'title' => 'Preguntas Frecuentes',
            'description' => 'Respuestas a las dudas más comunes sobre el uso de la plataforma.'
        ]);
    })->name('faq');

    Route::get('/contact', function () {
        return view('pages.coming-soon', [
            'title' => 'Contacto',
            'description' => '¿Necesitas ayuda específica? Pronto podrás contactarnos directamente a través de este formulario.'
        ]);
    })->name('contact');
});


Route::middleware(['auth', 'check.active', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/reports', [PublicReportController::class, 'index'])->name('reports.index');
    Route::post('/reports', [PublicReportController::class, 'store'])->name('reports.store');
});

Route::middleware(['auth', 'check.active', 'verified'])->prefix('fan')->name('fan.')->group(function () {


    Route::get('/missions', [App\Http\Controllers\Fan\MissionController::class, 'index'])->name('missions.index');

    Route::get('/dashboard', [App\Http\Controllers\Fan\DashboardController::class, 'index'])->name('dashboard');


    Route::get('/tokens', [App\Http\Controllers\Fan\TokenController::class, 'index'])->name('tokens.index');
    Route::get('/tokens/recharge', [App\Http\Controllers\Fan\TokenController::class, 'recharge'])->name('tokens.recharge');
    Route::get('/tokens/history', [App\Http\Controllers\Fan\TokenController::class, 'history'])->name('tokens.history');
    Route::post('/tokens/quick-recharge', [App\Http\Controllers\Fan\TokenController::class, 'quickRecharge'])->name('tokens.quick-recharge');
    Route::post('/tokens/purchase', [App\Http\Controllers\Fan\TokenController::class, 'purchase'])->name('tokens.purchase');


    Route::get('/subscriptions', [App\Http\Controllers\Fan\SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscriptions/{model}/subscribe', [App\Http\Controllers\Fan\SubscriptionController::class, 'subscribe'])->name('subscriptions.subscribe');
    Route::delete('/subscriptions/{subscription}', [App\Http\Controllers\Fan\SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');


    Route::get('/missions', [App\Http\Controllers\Fan\MissionController::class, 'index'])->name('missions.index');
    Route::post('/missions/{mission}/claim', [App\Http\Controllers\Fan\MissionController::class, 'claim'])->name('missions.claim');


    Route::get('/profile', [App\Http\Controllers\Fan\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\Fan\ProfileController::class, 'update'])->name('profile.update');


    Route::get('/favorites', [App\Http\Controllers\Fan\FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{model}/toggle', [App\Http\Controllers\Fan\FavoriteController::class, 'toggle'])->name('favorites.toggle');


    Route::get('/notifications', [App\Http\Controllers\Fan\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\Fan\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\Fan\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');


    Route::get('/achievements', [App\Http\Controllers\Fan\AchievementController::class, 'index'])->name('achievements.index');


    Route::get('/leaderboard', [App\Http\Controllers\Fan\LeaderboardController::class, 'index'])->name('leaderboard.index');


    Route::post('/media/{type}/{id}/like', [App\Http\Controllers\Fan\MediaInteractionController::class, 'toggleLike'])->name('media.like');
});

Route::prefix('model')->middleware(['auth', 'verified', 'role:model', 'model.onboarding'])->name('model.')->group(function () {

    Route::get('/missions', [ModelMissionController::class, 'index'])->name('missions.index');
    Route::post('/missions/{id}/claim', [ModelMissionController::class, 'claim'])->name('missions.claim');


    Route::get('/achievements', [ModelAchievementController::class, 'index'])->name('achievements.index');


    Route::get('/leaderboard', [ModelLeaderboardController::class, 'index'])->name('leaderboard.index');


    Route::prefix('withdrawals')->name('withdrawals.')->group(function () {
        Route::get('/', [ModelWithdrawalController::class, 'index'])->name('index');
        Route::get('/create', [ModelWithdrawalController::class, 'create'])->name('create');
        Route::post('/', [ModelWithdrawalController::class, 'store'])->name('store');
        Route::delete('/{withdrawal}', [ModelWithdrawalController::class, 'cancel'])->name('cancel');
        Route::get('/export', [ModelWithdrawalController::class, 'export'])->name('export');
    });


    Route::get('/earnings', [ModelEarningsController::class, 'index'])->name('earnings.index');


    Route::get('/analytics', [ModelAnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/export', [ModelAnalyticsController::class, 'export'])->name('analytics.export');


    Route::get('/profile/settings', [ModelProfileController::class, 'settings'])->name('profile.settings');
    Route::put('/profile/settings', [ModelProfileController::class, 'updateSettings'])->name('profile.updateSettings');


    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [ModelNotificationController::class, 'index'])->name('index');
        Route::post('/{id}/read', [ModelNotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [ModelNotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::delete('/{id}', [ModelNotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/', [ModelNotificationController::class, 'destroyAll'])->name('destroy-all');
        Route::get('/unread-count', [ModelNotificationController::class, 'unreadCount'])->name('unread-count');
    });


    Route::prefix('exports')->name('exports.')->group(function () {
        Route::get('/', [ExportController::class, 'modelIndex'])->name('index');
        Route::get('/earnings', [ExportController::class, 'exportModelEarnings'])->name('earnings');
        Route::get('/performance', [ExportController::class, 'exportModelPerformance'])->name('performance');
        Route::get('/withdrawals', [ExportController::class, 'exportModelWithdrawals'])->name('withdrawals');
    });


    Route::get('/export/csv', [ExportController::class, 'exportModelData'])->name('export.csv');
});


require __DIR__ . '/auth.php';
