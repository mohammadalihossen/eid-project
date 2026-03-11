<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalamiController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

// মেইন পেজ এবং ইমেইল রাউট
Route::get('/', [SalamiController::class, 'index'])->name('home');
Route::post('/send-warning-email', [SalamiController::class, 'sendEmail'])->name('send.email');

// SSLCommerz পেমেন্ট রাউট
Route::post('/pay-salami', [SalamiController::class, 'payWithSSLCommerz'])->name('pay.salami');

// SSLCommerz Callbacks (CSRF Bypass করা হয়েছে)
Route::post('/payment/success', [SalamiController::class, 'paymentSuccess'])->name('sslc.success')->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/payment/fail', [SalamiController::class, 'paymentFail'])->name('sslc.fail')->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/payment/cancel', [SalamiController::class, 'paymentCancel'])->name('sslc.cancel')->withoutMiddleware([VerifyCsrfToken::class]);