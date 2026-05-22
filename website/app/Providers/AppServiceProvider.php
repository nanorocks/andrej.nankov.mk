<?php

namespace App\Providers;

use App\Filament\Livewire\Profile\UpdateProfileInformation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Blade::component('social-icons', \App\View\Components\SocialIcons::class);

        Livewire::component(
            'filament-jetstream::livewire.profile.update-profile-information',
            UpdateProfileInformation::class,
        );
    }
}
