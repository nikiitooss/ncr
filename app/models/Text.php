<?php

namespace App\models;

use App\helpers\Connection;

class Text
{
    public static function textRoutes()
    {
        $query = Connection::make()->query("SELECT * FROM routes LIMIT 3");
        return $query->fetchAll();
    }

    public static function textBron()
    {
        $query = Connection::make()->query("SELECT * FROM routes LIMIT 3, 3");
        return $query->fetchAll();
    }
}