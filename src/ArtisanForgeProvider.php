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
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
