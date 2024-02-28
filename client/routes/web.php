<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/posts', [HomeController::class, 'posts'])->name('posts');
    Route::get('/projects/{slug}', [HomeController::class, 'project'])->name('projects.slug');
    Route::get('/posts/{slug}', [HomeController::class, 'post'])->name('posts.slug');

    Route::get('/welcome', function () {
        return redirect('/');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/cache/clear', [HomeController::class, 'cacheClear'])->name('cache.clear');
});

require __DIR__ . '/auth.php';