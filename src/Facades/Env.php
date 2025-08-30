<?php

namespace SoulDoit\SetEnv\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\HigherOrderWhenProxy;
use Illuminate\Support\Stringable;

/**
 * @method static void set(string $key, string|bool $value, ?string $comments = null, ?string $afterKey = null)
 * @method static Stringable|HigherOrderWhenProxy get(string $key)
 * @method static \SoulDoit\SetEnv\Env envFile(string $env_file)
 */
class Env extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'souldoit-set-env';
    }
} 