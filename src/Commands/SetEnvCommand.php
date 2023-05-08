<?php

namespace SoulDoit\SetEnv\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use SoulDoit\SetEnv\Env;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class SetEnvCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'souldoit:set-env {new_env_var?} {--E|env_file_path=.env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update/insert env variable';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $env_file_path = $this->option('env_file_path');
        $envService = new Env($env_file_path); 

        $new_env_var_arr = [];

        $new_env_var = $this->argument('new_env_var');
        if(empty($new_env_var)){
            $new_env_var_arr[0] = $this->components->ask('Please insert the variable name');
            if(empty($new_env_var_arr[0])){
                $this->components->error('The variable name should not be empty.');
                return;
            }
            if(Str::of($new_env_var_arr[0])->isMatch('/\w+\s+\w+/')){
                $this->components->error('The variable name should not have whitespaces.');
                return;
            }

            $new_env_var_arr[1] = $this->components->ask('Please insert the value');
            if(empty($new_env_var_arr[1])){
                $this->components->error('The value should not be empty.');
                return;
            }
        }else{
            $new_env_var_arr = explode("=", $new_env_var, 2);

            if(count($new_env_var_arr) !== 2){
                $this->components->error('Invalid argument format. Correct format should be {var}={value}.');
                return;
            }
        }

        $new_env_var_arr = Arr::map($new_env_var_arr, function ($value, $key) {
            return trim(($key === 0 ? strtoupper($value) : $value));
        });

        if(!$this->confirmToProceed()){
            return;
        }

        $envService->set($new_env_var_arr[0], $new_env_var_arr[1]);

        $this->components->info('Success');
    }
}
