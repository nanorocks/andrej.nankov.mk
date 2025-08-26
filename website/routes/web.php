<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsletterController;

Route::middleware('auth')->group(function () {});


Route::get('/newsletter', [NewsletterController::class, 'showForm']);
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::view('/', 'welcome')->name('home');

Route::view('/get-started', 'get-started')
    ->name('get.started');

Route::view('/about', 'about')
    ->name('about');

Route::view('/newsletter', 'newsletter')
    ->name('newsletter');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('logout', [\App\Http\Controllers\Auth\VerifyEmailController::class, 'logout'])
    ->middleware(['auth'])
    ->name('logout');

require __DIR__ . '/auth.php';
