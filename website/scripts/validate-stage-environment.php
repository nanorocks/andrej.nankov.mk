<?php

declare(strict_types=1);

$options = getopt('', ['file:', 'cpanel-json', 'host:']);
$expectedHost = $options['host'] ?? null;

if (! is_string($expectedHost) || $expectedHost === '') {
    fwrite(STDERR, "Missing --host.\n");
    exit(2);
}

if (isset($options['file']) === isset($options['cpanel-json'])) {
    fwrite(STDERR, "Use exactly one of --file or --cpanel-json.\n");
    exit(2);
}

if (isset($options['file'])) {
    $path = $options['file'];
    $content = is_string($path) ? @file_get_contents($path) : false;
} else {
    $payload = json_decode(stream_get_contents(STDIN), true);
    $content = is_array($payload) && ($payload['status'] ?? 0) === 1
        ? ($payload['data']['content'] ?? null)
        : false;
}

if (! is_string($content)) {
    fwrite(STDERR, "Unable to read the stage environment.\n");
    exit(1);
}

$values = [];

foreach (preg_split('/\R/', $content) ?: [] as $line) {
    if (! preg_match('/^\s*([A-Z][A-Z0-9_]*)\s*=\s*(.*)\s*$/', $line, $matches)) {
        continue;
    }

    $value = trim($matches[2]);

    if (strlen($value) >= 2) {
        $quote = $value[0];

        if (($quote === '"' || $quote === "'") && str_ends_with($value, $quote)) {
            $value = substr($value, 1, -1);
        }
    }

    $values[$matches[1]] = $value;
}

$errors = [];
$expect = static function (bool $condition, string $message) use (&$errors): void {
    if (! $condition) {
        $errors[] = $message;
    }
};

$appUrl = $values['APP_URL'] ?? '';
$appHost = parse_url($appUrl, PHP_URL_HOST);
$appScheme = parse_url($appUrl, PHP_URL_SCHEME);
$marker = static fn (string $value): bool => preg_match('/(?:stage|stg)/i', $value) === 1;

$expect(($values['APP_ENV'] ?? '') === 'staging', 'APP_ENV must be staging.');
$expect($appScheme === 'https' && $appHost === $expectedHost, "APP_URL must be https://{$expectedHost}.");
$expect(($values['APP_DEBUG'] ?? '') === 'false', 'APP_DEBUG must be false.');
$expect(str_starts_with($values['APP_KEY'] ?? '', 'base64:'), 'APP_KEY must be a generated base64 key.');
$expect(($values['DB_CONNECTION'] ?? '') === 'mysql', 'DB_CONNECTION must be mysql.');
$expect(($values['DB_HOST'] ?? '') !== '', 'DB_HOST must be set.');
$expect($marker($values['DB_DATABASE'] ?? ''), 'DB_DATABASE must be dedicated to stage (include stage or stg in its name).');
$expect($marker($values['DB_USERNAME'] ?? ''), 'DB_USERNAME must be dedicated to stage (include stage or stg in its name).');
$expect(($values['DB_PASSWORD'] ?? '') !== '', 'DB_PASSWORD must be set.');
$expect($marker($values['SESSION_COOKIE'] ?? ''), 'SESSION_COOKIE must be stage-specific.');
$expect($marker($values['CACHE_PREFIX'] ?? ''), 'CACHE_PREFIX must be stage-specific.');
$expect(($values['PADDLE_SANDBOX'] ?? '') === 'true', 'PADDLE_SANDBOX must be true.');

if ($errors !== []) {
    fwrite(STDERR, "Unsafe stage environment:\n - ".implode("\n - ", $errors)."\n");
    exit(1);
}

