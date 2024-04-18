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
        Artisan::call('passport:purge');

        $res = Http::get("http://rpi.nankov.mk/api/push/4N7lBOp1u2?status=up&msg=OK&ping=");

        $body = $res->json();

        return $body['ok'] ? Command::SUCCESS : Command::FAILURE;
    }
}
