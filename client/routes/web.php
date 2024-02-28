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

Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/posts', [HomeController::class, 'posts'])->name('posts');
    Route::get('/projects/{slug}', [HomeController::class, 'project'])->name('projects.slug');
    Route::get('/posts/{slug}', [HomeController::class, 'post'])->name('posts.slug');

    Route::get('/cache/clear', [HomeController::class, 'cacheClear'])->name('cache.clear');

    Route::get('monitoring/record', function () {

        Artisan::call('monitoring:record');

        return 'Monitoring record completed!';
    });

    Route::get('/welcome', function () {
        return redirect('/');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
