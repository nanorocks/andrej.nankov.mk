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

        $run('optimize:clear');
        $run('migrate', ['--force' => true]);
        $run('db:seed', ['--force' => true]);
        $run('storage:link', ['--force' => true]);
        $run('filament:upgrade');
        $run('sitemap:generate');
        $run('config:cache');
        $run('route:cache');
        $run('view:cache');
        $run('event:cache');
        $run('queue:restart');

        $horizonExitCode = Artisan::call('horizon:terminate');
        $steps[] = [
            'command' => 'horizon:terminate',
            'exit_code' => $horizonExitCode,
            'output' => trim(Artisan::output()),
        ];

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

