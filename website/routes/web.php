<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsletterController;

Route::redirect('/login', '/admin/login')->name('login');

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
