<?php

namespace SoulDoit\SetEnv\Facades;

use Illuminate\Support\Facades\Facade;

class Env extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'souldoit-set-env';
    }
} 