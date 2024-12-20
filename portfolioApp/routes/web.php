<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/categories', \App\Livewire\Categories\Index::class)->name('categories.index');
    Route::get('/categories/create', \App\Livewire\Categories\Create::class)->name('categories.create');
    Route::get('/categories/show/{category}', \App\Livewire\Categories\Show::class)->name('categories.show');
    Route::get('/categories/update/{category}', \App\Livewire\Categories\Edit::class)->name('categories.edit');

    Route::get('/users', \App\Livewire\Users\Index::class)->name('users.index');
    Route::get('/users/create', \App\Livewire\Users\Create::class)->name('users.create');
    Route::get('/users/show/{user}', \App\Livewire\Users\Show::class)->name('users.show');
    Route::get('/users/update/{user}', \App\Livewire\Users\Edit::class)->name('users.edit');

    Route::get('/projects', \App\Livewire\Projects\Index::class)->name('projects.index');
    Route::get('/projects/create', \App\Livewire\Projects\Create::class)->name('projects.create');
    Route::get('/projects/show/{project}', \App\Livewire\Projects\Show::class)->name('projects.show');
    Route::get('/projects/update/{project}', \App\Livewire\Projects\Edit::class)->name('projects.edit');

    Route::get('/videos', \App\Livewire\Videos\Index::class)->name('videos.index');
    Route::get('/videos/create', \App\Livewire\Videos\Create::class)->name('videos.create');
    Route::get('/videos/show/{video}', \App\Livewire\Videos\Show::class)->name('videos.show');
    Route::get('/videos/update/{video}', \App\Livewire\Videos\Edit::class)->name('videos.edit');

    Route::get('/stories', \App\Livewire\Stories\Index::class)->name('stories.index');
    Route::get('/stories/create', \App\Livewire\Stories\Create::class)->name('stories.create');
    Route::get('/stories/show/{story}', \App\Livewire\Stories\Show::class)->name('stories.show');
    Route::get('/stories/update/{story}', \App\Livewire\Stories\Edit::class)->name('stories.edit');

    Route::get('/services', \App\Livewire\Services\Index::class)->name('services.index');
    Route::get('/services/create', \App\Livewire\Services\Create::class)->name('services.create');
    Route::get('/services/show/{service}', \App\Livewire\Services\Show::class)->name('services.show');
    Route::get('/services/update/{service}', \App\Livewire\Services\Edit::class)->name('services.edit');

    Route::get('/menus', \App\Livewire\Menus\Index::class)->name('menus.index');
    Route::get('/menus/create', \App\Livewire\Menus\Create::class)->name('menus.create');
    Route::get('/menus/show/{menu}', \App\Livewire\Menus\Show::class)->name('menus.show');
    Route::get('/menus/update/{menu}', \App\Livewire\Menus\Edit::class)->name('menus.edit');

    Route::get('/highlights', \App\Livewire\Highlights\Index::class)->name('highlights.index');
    Route::get('/highlights/create', \App\Livewire\Highlights\Create::class)->name('highlights.create');
    Route::get('/highlights/show/{highlight}', \App\Livewire\Highlights\Show::class)->name('highlights.show');
    Route::get('/highlights/update/{highlight}', \App\Livewire\Highlights\Edit::class)->name('highlights.edit');

    Route::get('/tools', \App\Livewire\Tools\Index::class)->name('tools.index');
    Route::get('/tools/create', \App\Livewire\Tools\Create::class)->name('tools.create');
    Route::get('/tools/show/{tool}', \App\Livewire\Tools\Show::class)->name('tools.show');
    Route::get('/tools/update/{tool}', \App\Livewire\Tools\Edit::class)->name('tools.edit');

    Route::get('/seo-pages', \App\Livewire\SeoPages\Index::class)->name('seo-pages.index');
    Route::get('/seo-pages/create', \App\Livewire\SeoPages\Create::class)->name('seo-pages.create');
    Route::get('/seo-pages/show/{seoPage}', \App\Livewire\SeoPages\Show::class)->name('seo-pages.show');
    Route::get('/seo-pages/update/{seoPage}', \App\Livewire\SeoPages\Edit::class)->name('seo-pages.edit');
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

require __DIR__ . '/auth.php';
