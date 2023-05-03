<?php

namespace App\helpers;

class Connection
{
    public static function make($config = CONFIG_CONECTION)
    {
        return new \PDO(
            'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'],
            $config['login'],
            $config['password'],
            $config['options']
        );
    }
}