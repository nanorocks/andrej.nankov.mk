<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EbookDownloadController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StorefrontController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'homepage')->name('home');
Route::view('/offline', 'offline')->name('offline');

Route::view('/get-started', 'get-started')
    ->name('get.started');

Route::view('/about', 'about')
    ->name('about');

Route::view('/newsletter', 'newsletter')
    ->name('newsletter');

Route::view('/privacy', 'legal.privacy')->name('legal.privacy');
Route::view('/cookies', 'legal.cookies')->name('legal.cookies');
Route::view('/terms', 'legal.terms')->name('legal.terms');
Route::view('/refunds', 'legal.refunds')->name('legal.refunds');
Route::view('/shipping', 'legal.shipping')->name('legal.shipping');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->name('newsletter.subscribe');

Route::get('/shop', StorefrontController::class)->name('shop.index');
Route::get('/cart', [CartController::class, 'index'])->name('shop.cart');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('shop.cart.store');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('shop.cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('shop.cart.destroy');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('shop.checkout');
    Route::get('/checkout/{order}/status', [CheckoutController::class, 'status'])->name('shop.checkout.status');
    Route::get('/checkout/{order}/success', [CheckoutController::class, 'success'])->name('shop.checkout.success');
    Route::post('/orders/{order}/checkout', [CheckoutController::class, 'retry'])->name('orders.checkout');
    Route::delete('/orders/{order}', [CheckoutController::class, 'cancel'])->name('orders.cancel');
});

Route::post('/downloads/{product}', EbookDownloadController::class)
    ->middleware(['auth', 'throttle:20,1'])
    ->name('downloads.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('profile', ProfileController::class)
    ->middleware(['auth'])
    ->name('profile');

Route::get('orders', OrderHistoryController::class)
    ->middleware(['auth'])
    ->name('orders.index');

Route::get('logout', [VerifyEmailController::class, 'logout'])
    ->middleware(['auth'])
    ->name('logout');

require __DIR__.'/auth.php';
