<?php

namespace TobiSchulz\ArtisanForgeDeploy;

use Illuminate\Support\ServiceProvider;

class ArtisanForgeProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \TobiSchulz\ArtisanForgeDeploy\Console\Commands\ForgeDeployCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../config/artisan-forge-deploy.php' => config_path('artisan-forge-deploy.php'),
        ]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
