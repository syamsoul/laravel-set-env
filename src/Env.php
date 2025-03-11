<?php

namespace SoulDoit\SetEnv;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class Env
{
    private $env_file_content = '';

    function __construct(
        private string $env_file = ".env"
    )
    {
        $this->loadEnvContent();
    }

    public function get(string $key): string
    {
        return Str::of($this->env_file_content)
            ->match("/^$key=(.*)$/m")
            ->trim()
            ->when(
                fn (Stringable $str) => $str->startsWith('"') && $str->endsWith('"'),
                fn ($value) => Str::of($value)->substr(1, -1)
            );
    }

    public function set(string $key, string|bool $value): bool
    {
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        } else if (! empty($value) && ! preg_match('/^[0-9A-Za-z]+$/', $value)) {
            $value = "\"$value\"";
        }

        $new_env_var_final = "$key=$value";
        
        $is_already_exist = Str::of($this->env_file_content)->isMatch("/^$key=/m");
        
        if ($is_already_exist) {
            $replaced_env = Str::of($this->env_file_content)->replaceMatches("/^$key=.*$/m", $new_env_var_final);
            File::put(base_path($this->env_file), $replaced_env);
        } else {
            $is_last_env_have_newline = Str::of($this->env_file_content)->isMatch("/\n$/");
            if(!$is_last_env_have_newline) $new_env_var_final = "\n$new_env_var_final";

            File::append(base_path($this->env_file), $new_env_var_final);
        }

        $this->loadEnvContent();
        
        return true;
    }
    
    private function loadEnvContent()
    {
        $this->env_file_content = File::get(base_path($this->env_file));
    }
}
