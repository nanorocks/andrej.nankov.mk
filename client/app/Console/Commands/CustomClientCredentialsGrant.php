<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Passport\ClientRepository;

class CustomClientCredentialsGrant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:custom-client-credentials-grant {--userId= : The user ID} {--appName= : The application name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Passport client credentials grant with user ID and app name';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('userId');
        $appName = $this->option('appName');

        if (!$userId) {
            $this->error('User ID is required.');

            return;
        }

        if (!$appName) {
            $this->error('App name is required.');

            return;
        }

        $clientRepository = app(ClientRepository::class);

        $client = $clientRepository->create(
            $userId,
            $appName,
            ''
        );

        $this->info('Passport client credentials grant created successfully:');
        $this->line('Client ID: ' . $client->id);
        $this->line('Client secret: ' . $client->secret);
    }
}