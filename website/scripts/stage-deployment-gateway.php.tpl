<?php

declare(strict_types=1);

const DEPLOY_TOKEN = '__DEPLOY_TOKEN__';
const EXPECTED_REVISION = '__EXPECTED_REVISION__';
const EXPECTED_HOST = '__EXPECTED_HOST__';

$providedToken = $_SERVER['HTTP_X_DEPLOY_TOKEN'] ?? '';
$requestHost = strtolower(preg_replace('/:\d+$/', '', $_SERVER['HTTP_HOST'] ?? ''));

if (
    ($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST'
    || $requestHost !== EXPECTED_HOST
    || ! hash_equals(DEPLOY_TOKEN, $providedToken)
) {
    http_response_code(404);
    exit;
}

register_shutdown_function(static function (): void {
    @unlink(__FILE__);
});

header('Content-Type: application/json');

try {
    $applicationRoot = dirname(__DIR__);

    foreach (['config.php', 'events.php', 'routes-v7.php'] as $cacheFile) {
        $path = $applicationRoot.'/bootstrap/cache/'.$cacheFile;

        if (is_file($path) && ! @unlink($path)) {
            throw new RuntimeException("Unable to remove stale cache file: {$cacheFile}");
        }
    }

    require $applicationRoot.'/vendor/autoload.php';
    $app = require $applicationRoot.'/bootstrap/app.php';
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    $finalize = require $applicationRoot.'/scripts/stage-deployment-finalizer.php';
    $result = $finalize(EXPECTED_REVISION, EXPECTED_HOST);

    if (($result['success'] ?? false) !== true) {
        http_response_code(500);
    }

    echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
} catch (Throwable $exception) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $exception->getMessage(),
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

