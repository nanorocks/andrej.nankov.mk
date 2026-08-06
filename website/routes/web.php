<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EbookDownloadController;
use App\Http\Controllers\NewsletterController;
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

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->name('newsletter.subscribe');

Route::get('/shop', StorefrontController::class)->name('shop.index');
Route::get('/cart', [CartController::class, 'index'])->name('shop.cart');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('shop.cart.store');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('shop.cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('shop.cart.destroy');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('shop.checkout');
    Route::get('/checkout/{order}/success', [CheckoutController::class, 'success'])->name('shop.checkout.success');
    Route::get('/downloads/{product}', EbookDownloadController::class)
        ->middleware('throttle:20,1')
        ->name('downloads.show');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('profile', ProfileController::class)
    ->middleware(['auth'])
    ->name('profile');

Route::get('logout', [VerifyEmailController::class, 'logout'])
    ->middleware(['auth'])
    ->name('logout');

require __DIR__.'/auth.php';
