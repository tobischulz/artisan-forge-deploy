<?php

namespace TobiSchulz\ArtisanForgeDeploy\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ForgeDeployCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forge:deploy

                            {--force : Deploy without confirmation}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use forge deployment trigger url';

    /**
     * The GuzzleHttp Client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->isForced()) {
            $goAhead = $this->confirm('Whould you like to trigger deploy on Forge server?');

            if (!$goAhead) {
                return;
            }
        }

        $deploymentUrl = env('FORGE_DEPLOY_URL');

        if (!$deploymentUrl) {
            $this->error('No forge deployment trigger url found.');

            return;
        }

        $this->line('Calling forge deployment trigger url...');

        $response = Http::withOptions([
            'http_errors' => false,
        ])->post($deploymentUrl);

        if ($response->failed()) {
            $this->error("Error using forge deployment trigger url. {$response->getStatusCode()}");
            return 1;
        }

        if ($response->body() !== 'OK') {
            $this->error("Forge error response: {$response->body()}");
            return 1;
        }

        $this->info('Deployment has been triggered!');

        return 0;
    }

    /**
     * Return if param force is set
     *
     * @return bool
     */
    private function isForced()
    {
        if ($this->option('force')) {
            return true;
        }

        return false;
    }
}
