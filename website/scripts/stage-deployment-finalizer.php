<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

return static function (string $expectedRevision, string $expectedHost): array {
    set_time_limit(0);

    $applicationRoot = dirname(__DIR__);
    $actualRevision = trim((string) @file_get_contents($applicationRoot.'/REVISION'));

    if (! hash_equals($expectedRevision, $actualRevision)) {
        throw new RuntimeException('The extracted release does not match the expected Git revision.');
    }

    if (! app()->environment('staging')) {
        throw new RuntimeException('APP_ENV must be staging before the stage finalizer can run.');
    }

    $configuredHost = parse_url((string) config('app.url'), PHP_URL_HOST);

    if ($configuredHost !== $expectedHost) {
        throw new RuntimeException("APP_URL must use {$expectedHost}; found ".($configuredHost ?: 'no host').'.');
    }

    $steps = [];
    $maintenanceActive = false;

    $run = static function (string $command, array $arguments = []) use (&$steps): void {
        $exitCode = Artisan::call($command, $arguments);
        $output = trim(Artisan::output());

        $steps[] = [
            'command' => $command,
            'exit_code' => $exitCode,
            'output' => $output,
        ];

        if ($exitCode !== 0) {
            throw new RuntimeException("Artisan command failed: {$command}\n{$output}");
        }
    };

    try {
        $run('down', ['--retry' => 15]);
        $maintenanceActive = true;

        // On the first deployment the database-backed cache tables do not
        // exist until the initial migration has run. The gateway already
        // removes stale bootstrap cache files before Laravel boots, so it is
        // safe to migrate first and clear application caches immediately
        // afterwards.
        $run('migrate', ['--force' => true]);
        $run('optimize:clear');
        $run('db:seed', ['--force' => true]);
        $run('storage:link', ['--force' => true]);
        $run('filament:upgrade');
        $run('sitemap:generate');
        $run('config:cache');
        $run('route:cache');
        $run('view:cache');
        $run('event:cache');
        $run('queue:restart');

        if (array_key_exists('horizon:terminate', Artisan::all())) {
            $horizonExitCode = Artisan::call('horizon:terminate');
            $steps[] = [
                'command' => 'horizon:terminate',
                'exit_code' => $horizonExitCode,
                'output' => trim(Artisan::output()),
            ];
        } else {
            // Horizon registers its commands only for console requests. The
            // cPanel finalizer deliberately runs through a web gateway because
            // shared hosting does not expose a shell API.
            $steps[] = [
                'command' => 'horizon:terminate',
                'exit_code' => null,
                'output' => 'Skipped: unavailable in the cPanel web finalizer.',
            ];
        }

        $run('up');
        $maintenanceActive = false;

        return [
            'success' => true,
            'revision' => $actualRevision,
            'steps' => $steps,
        ];
    } catch (Throwable $exception) {
        return [
            'success' => false,
            'revision' => $actualRevision,
            'maintenance_active' => $maintenanceActive,
            'error' => $exception->getMessage(),
            'steps' => $steps,
        ];
    }
};
