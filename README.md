# Laravel Environment Variable Setter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/syamsoul/laravel-set-env.svg?style=flat-square)](https://packagist.org/packages/syamsoul/laravel-set-env)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Total Downloads](https://img.shields.io/packagist/dt/syamsoul/laravel-set-env.svg?style=flat-square)](https://packagist.org/packages/syamsoul/laravel-set-env)
[![PHP Version](https://img.shields.io/packagist/php-v/syamsoul/laravel-set-env.svg?style=flat-square)](https://packagist.org/packages/syamsoul/laravel-set-env)

A Laravel package that enables programmatic modification of environment variables in your `.env` file. Simple, secure, and efficient way to manage your Laravel application's environment configuration.

## ✨ Features

- 🔐 Secure environment variable management
- 🚀 Simple and intuitive API
- 💻 Command-line interface support
- 📝 Support for comments in .env files
- 🎯 Precise variable positioning
- 🔄 Multiple file support (.env, .env.example, etc.)
- ⚡ Production-ready with safety checks

## 📋 Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
  - [Basic Setup](#basic-setup)
  - [Setting Environment Variables](#setting-environment-variables)
  - [Getting Environment Variables](#getting-environment-variables)
  - [Using Artisan Commands](#using-artisan-commands)
- [Production Usage](#production-usage)
- [Support](#support)
- [License](#license)

## 🔧 Requirements

- Laravel 10.x or higher
- PHP 8.0 or higher

## 📦 Installation

You can install the package via Composer:

```bash
composer require syamsoul/laravel-set-env
```

## 🚀 Usage

### Basic Setup

First, import the `Env` facade in your code:

```php
use SoulDoit\SetEnv\Facades\Env;
```

### Setting Environment Variables

There are multiple ways to set or update environment variables:

#### Using PHP Code

1. Basic usage:
```php
// Set/update variable in .env file
Env::set("MY_APP_NAME", "My Laravel Application");

// Set/update variable in .env.example file
Env::envFile('.env.example')->set("MY_APP_NAME", "Localhost");
```

2. Add comments:
```php
// Add a comment to explain the variable
Env::set("ENABLE_CLOCKWORK", false, "Enable or disable the clockwork debugging tools");
// Result in .env:
// ENABLE_CLOCKWORK=false #Enable or disable the clockwork debugging tools
```

3. Control variable positioning:
```php
// Add/update a key after a specific key
Env::set("ENABLE_CLOCKWORK", false, afterKey: "APP_NAME");
// Result in .env:
// APP_NAME=MyApp
// ENABLE_CLOCKWORK=false
```

#### Using Artisan Commands

1. Interactive mode:
```bash
php artisan souldoit:set-env
```

2. Direct mode:
```bash
php artisan souldoit:set-env "MY_APP_NAME=My Laravel Application"
```

3. Specify target env file:
```bash
php artisan souldoit:set-env "MY_APP_NAME=Localhost" -E .env.example
# or
php artisan souldoit:set-env "MY_APP_NAME=Localhost" --env_file=.env.example
```

### Getting Environment Variables

Retrieve environment variable values using the `get` method:

```php
$value = Env::get("MY_APP_NAME");
```

## 🛡️ Production Usage

When working in a production environment, you can use the `--force` flag to bypass confirmation prompts:

```bash
php artisan souldoit:set-env "MY_APP_NAME=Production App" --force
```

## ❤️ Support

If you find this package helpful, consider supporting the development:

BNB (BSC) Donation Address:
```
0x364d8eA5E7a4ce97e89f7b2cb7198d6d5DFe0aCe
```

<img src="https://info.souldoit.com/img/wallet-address-bnb-bsc.png" width="150" alt="BNB Wallet QR Code">

## 📄 License

This package is open-sourced software licensed under the [MIT License](LICENSE).
