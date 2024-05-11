<?php

namespace App\Providers;

use Spatie\Health\Facades\Health;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;

class HealthCheckServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Health::checks([
            UsedDiskSpaceCheck::new(),
            DatabaseCheck::new(),
            EnvironmentCheck::new(),
            OptimizedAppCheck::new(),
            SecurityAdvisoriesCheck::new(),
            ScheduleCheck::new(),
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
