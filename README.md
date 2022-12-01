# Laravel Artisan Forge Deploy

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/tobischulz/artisan-forge-deploy.svg?style=flat-square)](https://packagist.org/packages/tobischulz/artisan-forge-deploy)
[![Total Downloads](https://img.shields.io/packagist/dt/tobischulz/artisan-forge-deploy.svg?style=flat-square)](https://packagist.org/packages/tobischulz/artisan-forge-deploy)


This will give you the power to deploy your Laravel project on your configured Forge server site with this needful artisan command. This package requires PHP 7 and Laravel 5.7 or higher.

``` bash
php artisan forge:deploy
```

![readme/artisan-forge-deploy-demo.gif](readme/artisan-forge-deploy-demo.gif)

## Installation

Pull this package in using composer:

**Use the 3.0 for Laravel 9**

```bash
composer require --dev tobischulz/artisan-forge-deploy "^3.0"
```

Use the 2.0 for Laravel 7 or 8

```bash
composer require --dev tobischulz/artisan-forge-deploy "^2.0"
```

Use 1.0 for Laravel 5.7 or above

```bash
composer require --dev tobischulz/artisan-forge-deploy "^1.0"
```

Next, add the Key **FORGE_DEPLOY_URL** to your .env file and copy the `Deployment Trigger URL` from your forge site details page.

```env
FORGE_DEPLOY_URL=
```

![readme/artisan-forge-deploy-env.png](readme/artisan-forge-deploy-env.png)

You´re ready to go to fire `php artisan forge:deploy` on cli now.


## Credits

- [Tobias Schulz](https://github.com/tobischulz)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
