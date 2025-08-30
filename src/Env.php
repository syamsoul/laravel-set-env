<?php

namespace SoulDoit\SetEnv;

use Illuminate\Support\Facades\File;
use Illuminate\Support\HigherOrderWhenProxy;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class Env
{
    private string $env_file_content = '';

    function __construct(
        private string $env_file = ".env"
    )
    {
        $this->loadEnvContent();
    }

    public function envFile(string $env_file): self
    {
        return new self($env_file);
    }

    public function get(string $key): Stringable|HigherOrderWhenProxy
    {
        return Str::of($this->env_file_content)
            ->match("/^$key=(.*)$/m")
            ->trim()
            ->when(
                fn (Stringable $str) => $str->startsWith('"') && $str->endsWith('"'),
                fn ($value) => Str::of($value)->substr(1, -1)
            );
    }

    public function set(string $key, string|bool $value, ?string $comments = null, ?string $afterKey = null): bool
    {
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        } else if (! empty($value) && ! preg_match('/^[0-9A-Za-z]+$/', $value)) {
            $value = "\"$value\"";
        }

        $new_env_var_final = "$key=$value";
        
        if (! empty($comments)) {
            $new_env_var_final .= " # $comments";
        }

        $is_already_exist = Str::of($this->env_file_content)->isMatch("/^$key=/m");
        
        if ($is_already_exist) {
            $replaced_env = Str::of($this->env_file_content);

            if (! empty($comments)) {
                $replaced_env = $replaced_env->replaceMatches("/^$key=.*$/m", $new_env_var_final);
            } else {
                $replaced_env = $replaced_env->replaceMatches("/^{$key}=(?:\"[^\"]*\"|[^#\s]*)/m", $new_env_var_final);
            }

            if ($afterKey !== null) {
                if (! Str::of($this->env_file_content)->isMatch("/^$afterKey=.*\n$key/m")) {
                    $new_env_var_final = $replaced_env->match("/^$key=.*/m")->toString();
                    $replaced_env = $replaced_env->replaceMatches("/^$key=.*?(?:\n|$)/m", "");
                    $replaced_env = $replaced_env->replaceMatches(
                        "/^{$afterKey}=.*$/m",
                        fn($match) => $match[0] . "\n" . $new_env_var_final
                    );
                }
            }

            File::put(base_path($this->env_file), $replaced_env);
        } else {
            $isAfterKey = false;

            if ($afterKey !== null) {
                $content = Str::of($this->env_file_content);
                $pattern = "/^{$afterKey}=.*$/m";
                
                if ($content->isMatch($pattern)) {
                    $replaced_env = $content->replaceMatches(
                        $pattern,
                        fn($match) => $match[0] . "\n" . $new_env_var_final
                    );
                    $isAfterKey = true;
                    File::put(base_path($this->env_file), $replaced_env);
                }
            }

            if (! $isAfterKey) {
                $is_last_env_have_newline = Str::of($this->env_file_content)->isMatch("/\n$/");
                if(!$is_last_env_have_newline) $new_env_var_final = "\n$new_env_var_final";

                File::append(base_path($this->env_file), $new_env_var_final);
            }
        }

        $this->loadEnvContent();
        
        return true;
    }
    
    private function loadEnvContent(): void
    {
        $this->env_file_content = File::get(base_path($this->env_file));
    }
}
