<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class PurgeActionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:purge-action-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        shell_exec('php artisan passport:purge --revoked');
        shell_exec('php artisan passport:purge --expired');

        $res = Http::get(config('app.http_monitor_push_endpoint'));

        $body = $res->json();

        return $body['ok'] ? Command::SUCCESS : Command::FAILURE;
    }
}