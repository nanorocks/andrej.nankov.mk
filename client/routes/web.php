<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/posts', [HomeController::class, 'posts'])->name('posts');
Route::get('/projects/{slug}', [HomeController::class, 'project'])->name('projects.slug');
Route::get('/posts/{slug}', [HomeController::class, 'post'])->name('posts.slug');

Route::get('/welcome', function () {
    return redirect('/');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/cache/clear', [HomeController::class, 'cacheClear'])->name('cache.clear');
    Route::get('/optimize', [HomeController::class, 'optimize'])->name('optimize');

    Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';