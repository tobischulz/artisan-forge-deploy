<?php

namespace TobiSchulz\ArtisanForgeDeploy\Tests\Console\Commands;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase;
use TobiSchulz\ArtisanForgeDeploy\ArtisanForgeProvider;

/**
 * Class ForgeDeployCommandTest
 * @covers \TobiSchulz\ArtisanForgeDeploy\Console\Commands\ForgeDeployCommand
 * @covers \TobiSchulz\ArtisanForgeDeploy\ArtisanForgeProvider
 * @package TobiSchulz\ArtisanForgeDeploy\Tests\Console\Commands
 */
class ForgeDeployCommandTest extends TestCase
{
    public function testDoesNotDeployIfAnsweringNoToTriggerConfirmation(): void
    {
        $this->artisan('forge:deploy')
            ->expectsConfirmation('Would you like to trigger deploy on Forge server?')
            ->assertExitCode(0);
    }

    public function testDisplaysErrorMessageWhenDeploymentTriggerUrlUndefined(): void
    {
        $this->artisan('forge:deploy')
            ->expectsConfirmation('Would you like to trigger deploy on Forge server?', 'yes')
            ->expectsOutput('No forge deployment trigger url found.')
            ->assertExitCode(0);
    }

    public function testPrintsErrorMessageWhenResponseFails(): void
    {
        Config::set('FORGE_DEPLOY_URL', 'forge.deploy.url');

        $response = $this->createMock(Response::class);
        $response->method('failed')->willReturn(true);
        $response->method('status')->willReturn(400);

        Http::shouldReceive('withOptions')->andReturnSelf();
        Http::shouldReceive('post')->andReturn($response);

        $this->artisan('forge:deploy')
            ->expectsConfirmation('Would you like to trigger deploy on Forge server?', 'yes')
            ->expectsOutput('Calling forge deployment trigger url...')
            ->expectsOutput('Error using forge deployment trigger url. 400')
            ->assertExitCode(1);
    }

    public function testPrintsErrorMessageWhenResponseBodyIsNotOkay(): void
    {
        Config::set('FORGE_DEPLOY_URL', 'forge.deploy.url');

        $response = $this->createMock(Response::class);
        $response->method('body')->willReturn('FAIL');
        $response->method('failed')->willReturn(false);

        Http::shouldReceive('withOptions')->andReturnSelf();
        Http::shouldReceive('post')->andReturn($response);

        $this->artisan('forge:deploy')
            ->expectsConfirmation('Would you like to trigger deploy on Forge server?', 'yes')
            ->expectsOutput('Calling forge deployment trigger url...')
            ->expectsOutput('Forge error response: FAIL')
            ->assertExitCode(1);
    }

    public function testDeploysWhenAnsweringYesToTriggerQuestion(): void
    {
        Config::set('FORGE_DEPLOY_URL', 'forge.deploy.url');

        $response = $this->createMock(Response::class);
        $response->method('body')->willReturn('OK');
        $response->method('failed')->willReturn(false);

        Http::shouldReceive('withOptions')->andReturnSelf();
        Http::shouldReceive('post')->andReturn($response);

        $this->artisan('forge:deploy')
            ->expectsConfirmation('Would you like to trigger deploy on Forge server?', 'yes')
            ->expectsOutput('Calling forge deployment trigger url...')
            ->expectsOutput('Deployment has been triggered!')
            ->assertExitCode(0);
    }

    public function testSkipsTriggerQuestionWhenUsingForceOption(): void
    {
        Config::set('FORGE_DEPLOY_URL', 'forge.deploy.url');

        $response = $this->createMock(Response::class);
        $response->method('body')->willReturn('OK');
        $response->method('failed')->willReturn(false);

        Http::shouldReceive('withOptions')->andReturnSelf();
        Http::shouldReceive('post')->andReturn($response);

        $this->artisan('forge:deploy --force')
            ->expectsOutput('Calling forge deployment trigger url...')
            ->expectsOutput('Deployment has been triggered!')
            ->assertExitCode(0);
    }

    protected function getApplicationProviders($app)
    {
        return [
            ArtisanForgeProvider::class,
        ];
    }
}