<?php
// public/post_deploy.php
// Run post-deployment artisan commands

require __DIR__ . '/../vendor/autoload.php';

// Run composer install
exec('composer install');

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Run migrations
$kernel->call('migrate', ['--force' => true]);
// Optimize
$kernel->call('optimize');

echo "Composer install and post-deploy commands executed.";
