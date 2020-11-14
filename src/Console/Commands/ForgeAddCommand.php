<?php

namespace TobiSchulz\ArtisanForgeDeploy\Console\Commands;

use Illuminate\Console\Command;

class ForgeAddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forge:add

        {url : Url to deploy on forge}
        {--site= : Name of the site forge}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add site url to deploy on forge in .env';

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
        $this->setEnvironmentValue($this->keyName(), $this->argument('url'));

        $this->line("{$this->keyName()} set to : ".env($this->keyName()));

        return 0;
    }

    private function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $str .= "\n"; // In case the searched variable is in the last line without \n
        $keyPosition = strpos($str, "{$envKey}=");
        $endOfLinePosition = strpos($str, PHP_EOL, $keyPosition);
        if ($keyPosition !== false) {
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
            $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
            $str = substr($str, 0, -1);
        } else {
            //Append to the file
            $str .= "{$envKey}={$envValue}\n";
        }

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }

    private function keyName(): string
    {
        return $this->option('site') ? 'FORGE_DEPLOY_' . strtoupper($this->option('site')) . '_URL' : 'FORGE_DEPLOY_URL';
    }
}
