# Laravel Artisan Forge Deploy

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)


This will give you the power to deploy your Laravel project on your configured Forge server site with this needfull artisan command:

``` bash
php artisan forge:deploy
```

## Installation and usage

This package requires PHP 7 and Laravel 5.7 or higher. 

Require this package in your project you like to deploy on forge by this artisan command:

``` bash
composer require-dev tobischulz/artisan-forge-deploy
``` 

Add the Key **FORGE_DEPLOY_URL** to your .env file.

![readme/artisan-forge-deploy-env.png](readme/artisan-forge-deploy-env.png)

You´re ready to go!

## Credits

- [Tobias Schulz](https://github.com/tobischulz)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.