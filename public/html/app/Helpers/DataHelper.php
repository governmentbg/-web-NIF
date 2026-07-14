<?php

namespace App\Helpers;

class DataHelper
{
    public static function load()
    {
        $path = resource_path('data/data.json');

        if (!file_exists($path)) {
            throw new \Exception("data.json not found at: " . $path);
        }

        return json_decode(file_get_contents($path), true);
    }
}
