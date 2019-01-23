<?php

namespace TobiSchulz\ArtisanForgeDeploy\Console\Commands;

use Illuminate\Console\Command;

class ForgeDeployCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forge:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use Deployment Trigger URL of forge site';

    /**
     * The GuzzleHttp Client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * Create a new command instance.
     *
     * @param \GuzzleHttp\Client $guzzle
     */
    public function __construct(\GuzzleHttp\Client $guzzle)
    {
        parent::__construct();

        $this->guzzle = $guzzle;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $goAhead = $this->confirm('Whould you like to deploy on Forge Server?');

        if (!$goAhead) {
            $this->line('...abort');

            return;
        }

        $deploymentUrl = env('FORGE_DEPLOY_URL');

        if (!$deploymentUrl) {
            $this->error('No forge deployment trigger url found.');

            return;
        }

        $this->line('Calling forge deployment trigger url...');

        $response = $this->guzzle->request('POST', $deploymentUrl, [
            'http_errors' => false,
        ]);

        if ($response->getStatusCode() !== 200) {
            $this->error("Error using forge deployment trigger url. {$response->getStatusCode()}");

            return;
        }

        if ($response->getBody() != 'OK') {
            $this->error("Forge error response: {$response->getBody()}");

            return;
        }

        $this->info('Deployment is running!');
    }
}
