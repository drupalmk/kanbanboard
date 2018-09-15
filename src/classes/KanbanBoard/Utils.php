<?php

namespace KanbanBoard;

use Dotenv\Dotenv;

class Utils
{
    public static function env($name, $default = null)
    {
        $dotenv = new Dotenv(__DIR__ . '/../../../');
        $dotenv->load();
        $value = getenv($name);
        if ($default !== null) {
            if (!empty($value)) {
                return $value;
            }

            return $default;
        }

        return (empty($value) && $default === null) ? die('Environment variable '.$name.' not found or has no value') : $value;
    }

    public static function hasValue($array, $key)
    {
        return is_array($array) && array_key_exists(
            $key,
            $array
          ) && !empty($array[$key]);
    }

    public static function dump($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}