<?php

namespace SoulDoit\SetEnv\Providers;
 
use Illuminate\Support\ServiceProvider;
use SoulDoit\SetEnv\Commands\SetEnvCommand;
 
final class SetEnvServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands(
            commands: [
                SetEnvCommand::class,
            ],
        );
    }
}