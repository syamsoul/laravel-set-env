<?php

namespace SoulDoit\SetEnv;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Env
{
    private $env_file_content = '';

    function __construct(
        private string $env_file_path = ".env"
    )
    {
        $this->env_file_content = File::get($env_file_path);
    }

    public function get(string $key): string
    {
        $value = Str::of($this->env_file_content)->match("/^$key=(.*)$/m");

        if(Str::of($value)->startsWith('"')) $value = Str::of($value)->substr(1);
        if(Str::of($value)->endsWith('"')) $value = Str::of($value)->substr(0, -1);
        
        return $value;
    }

    public function set(string $key, string $value): bool
    {
        $new_env_var_final = "$key=\"$value\"";
        
        $is_already_exist = Str::of($this->env_file_content)->isMatch("/^$key=/m");
        
        if($is_already_exist){
            $replaced_env = Str::of($this->env_file_content)->replaceMatches("/^$key=.*$/m", $new_env_var_final);
            File::put($this->env_file_path, $replaced_env);
        }else{
            $is_last_env_have_newline = Str::of($this->env_file_content)->isMatch("/\n$/");
            if(!$is_last_env_have_newline) $new_env_var_final = "\n$new_env_var_final";

            File::append($this->env_file_path, $new_env_var_final);
        }
        
        return true;
    }
}