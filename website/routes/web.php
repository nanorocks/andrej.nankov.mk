<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

});

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('logout', [\App\Http\Controllers\Auth\VerifyEmailController::class, 'logout'])
    ->middleware(['auth'])
    ->name('logout');

require __DIR__.'/auth.php';
