<?php

namespace SoulDoit\SetEnv\Providers;
 
use Illuminate\Support\ServiceProvider;
use SoulDoit\SetEnv\Commands\SetEnvCommand;
use SoulDoit\SetEnv\Env;

final class SetEnvServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('souldoit-set-env', function ($app) {
            return new Env();
        });
    }

    public function boot(): void
    {
        $this->commands(
            commands: [
                SetEnvCommand::class,
            ],
        );
    }
}