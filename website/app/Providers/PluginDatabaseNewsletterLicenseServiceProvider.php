<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PluginDatabaseNewsletterLicenseService;

class PluginDatabaseNewsletterLicenseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('plugin-database-newsletter-license', function ($app) {
            return new PluginDatabaseNewsletterLicenseService();
        });
    }

    public function boot()
    {
        //
    }
}
