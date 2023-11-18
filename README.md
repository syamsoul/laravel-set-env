# Env Variable Setter for Laravel



[![Latest Version on Packagist](https://img.shields.io/packagist/v/syamsoul/laravel-set-env.svg?style=flat-square)](https://packagist.org/packages/syamsoul/laravel-set-env)


&nbsp;
## Introduction

This package allows you to programmatically set environment variable into `.env` file.


&nbsp;
* [Requirement](#requirement)
* [Installation](#installation)
* [Usage](#usage)
* [Example](#example)


&nbsp;
&nbsp;
## Requirement

* Laravel 10.x (and above)


&nbsp;
&nbsp;
## Installation


This package can be used in Laravel 9.x or higher. If you are using an older version of Laravel, there's might be some problem. If there's any problem, you can [create new issue](https://github.com/syamsoul/laravel-set-env/issues) and I will fix it as soon as possible.

You can install the package via composer:

``` bash
composer require syamsoul/laravel-set-env
```

&nbsp;
&nbsp;
## Usage

First, you must add this line to import `Env` service.
```php
use SoulDoit\SetEnv\Env;
```


&nbsp;
### Set New Variable or Update Existing Variable


To set/update environment variable in `.env` file, just simply use the `set` method.
```php
$envService = new Env(); 
$envService->set("MY_APP_NAME", "My Laravel Application");

// or set variable in .env.example file
$envService = new Env('.env.example');
$envService->set("MY_APP_NAME", "Localhost");
```

&nbsp;

or you can set/update the environment variable via `Artisan` command.
``` bash
php artisan souldoit:set-env
```

or

``` bash
php artisan souldoit:set-env "MY_APP_NAME=My Laravel Application"
```

or, set variable in .env.example file

``` bash
php artisan souldoit:set-env "MY_APP_NAME=Localhost" -E .env.example

#or

php artisan souldoit:set-env "MY_APP_NAME=Localhost" --env_file_path=.env.example
```

&nbsp;
### Get Variable's Value

To get environment variable in `.env` file, just simply use the `get` method.
```php
$envService = new Env(); 
$the_value = $envService->get("MY_APP_NAME");
// $the_value will return `My Laravel Application`
```


&nbsp;
&nbsp;
## Support me

If you find this package helps you, kindly support me by donating some BNB (BSC) to the address below.

```
0x364d8eA5E7a4ce97e89f7b2cb7198d6d5DFe0aCe
```

<img src="https://info.souldoit.com/img/wallet-address-bnb-bsc.png" width="150">


&nbsp;
&nbsp;
## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.