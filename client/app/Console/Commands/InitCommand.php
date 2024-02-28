<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command before startup';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $schema = config('database.connections.mysql.database');

        // $query = "CREATE DATABASE IF NOT EXISTS `$schema`";

        // DB::connection()->statement($query);

        Artisan::call('migrate:fresh');

        Artisan::call('passport:install');

        Artisan::call('db:seed');

        return 0;
    }
}
