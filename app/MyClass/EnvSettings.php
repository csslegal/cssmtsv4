<?php

namespace App\MyClass;


class EnvSettings
{

    /**
     *
     * @input env key
     * @input env value
     */
    public function setEnvironmentValue($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('='.env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
           "{$key}={$value}",
           file_get_contents($path)
        ));
    }
}
