<?php

declare(strict_types=1);

$options = getopt('', ['output:', 'host:']);
$output = $options['output'] ?? null;
$host = $options['host'] ?? null;

if (! is_string($output) || $output === '' || ! is_string($host) || $host === '') {
    fwrite(STDERR, "Usage: create-stage-environment.php --output PATH --host HOST\n");
    exit(2);
}

if (file_exists($output)) {
    fwrite(STDERR, "Refusing to overwrite an existing environment file.\n");
    exit(1);
}

$payload = json_decode(stream_get_contents(STDIN), true);
$data = is_array($payload) && ($payload['status'] ?? 0) === 1
    ? ($payload['data'] ?? null)
    : null;

if (! is_array($data)) {
    fwrite(STDERR, "cPanel did not return database credentials.\n");
    exit(1);
}

$database = $data['database'] ?? null;
$username = $data['database_user'] ?? null;
$password = $data['database_user_password'] ?? null;
$databaseHost = $data['hostname'] ?? 'localhost';

foreach ([$database, $username, $password, $databaseHost] as $value) {
    if (! is_string($value) || $value === '' || str_contains($value, "\n")) {
        fwrite(STDERR, "cPanel returned invalid database credentials.\n");
        exit(1);
    }
}

$quote = static fn (string $value): string => json_encode(
    $value,
    JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES
);

$values = [
    'APP_NAME' => 'Andrej Nankov Stage',
    'APP_ENV' => 'staging',
    'APP_KEY' => 'base64:'.base64_encode(random_bytes(32)),
    'APP_DEBUG' => 'false',
    'APP_TIMEZONE' => 'Europe/Skopje',
    'APP_URL' => "https://{$host}",
    'APP_LOCALE' => 'en',
    'APP_FALLBACK_LOCALE' => 'en',
    'APP_FAKER_LOCALE' => 'en_US',
    'APP_MAINTENANCE_DRIVER' => 'file',
    'BCRYPT_ROUNDS' => '12',
    'LOG_CHANNEL' => 'stack',
    'LOG_STACK' => 'single',
    'LOG_LEVEL' => 'warning',
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => $databaseHost,
    'DB_PORT' => '3306',
    'DB_DATABASE' => $database,
    'DB_USERNAME' => $username,
    'DB_PASSWORD' => $password,
    'SESSION_DRIVER' => 'database',
    'SESSION_LIFETIME' => '120',
    'SESSION_ENCRYPT' => 'false',
    'SESSION_PATH' => '/',
    'SESSION_DOMAIN' => 'null',
    'SESSION_COOKIE' => 'andrej_nankov_stage_session',
    'BROADCAST_CONNECTION' => 'log',
    'FILESYSTEM_DISK' => 'local',
    'QUEUE_CONNECTION' => 'database',
    'CACHE_STORE' => 'database',
    'CACHE_PREFIX' => 'andrej_nankov_stage_cache',
    'MAIL_MAILER' => 'log',
    'MAIL_FROM_ADDRESS' => 'stage@andrej.nankov.mk',
    'MAIL_FROM_NAME' => 'Andrej Nankov Stage',
    'VITE_APP_NAME' => 'Andrej Nankov Stage',
    'PADDLE_CLIENT_SIDE_TOKEN' => '',
    'PADDLE_API_KEY' => '',
    'PADDLE_RETAIN_KEY' => '',
    'PADDLE_WEBHOOK_SECRET' => '',
    'PADDLE_SANDBOX' => 'true',
    'CASHIER_CURRENCY' => 'EUR',
    'CASHIER_CURRENCY_LOCALE' => 'en',
];

$lines = [];
$rawKeys = [
    'APP_DEBUG',
    'BCRYPT_ROUNDS',
    'DB_PORT',
    'SESSION_LIFETIME',
    'SESSION_ENCRYPT',
    'SESSION_DOMAIN',
    'PADDLE_SANDBOX',
];

foreach ($values as $key => $value) {
    $lines[] = $key.'='.(in_array($key, $rawKeys, true) ? $value : $quote($value));
}

$temporary = $output.'.tmp-'.bin2hex(random_bytes(6));

if (file_put_contents($temporary, implode("\n", $lines)."\n", LOCK_EX) === false) {
    fwrite(STDERR, "Unable to write the stage environment.\n");
    exit(1);
}

chmod($temporary, 0600);

if (! rename($temporary, $output)) {
    @unlink($temporary);
    fwrite(STDERR, "Unable to install the stage environment.\n");
    exit(1);
}
