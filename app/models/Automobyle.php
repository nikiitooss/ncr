<?php

namespace App\models;

use App\helpers\Connection;

class Automobyle
{

    public static function all()
    {
        $query = Connection::make()->query("SELECT automobiles.*,
        models.name as model, speeds.number as speed, transmissions.name as transmission, powers.name as power, bodies.name as body
        FROM automobiles 
        INNER JOIN models ON models.id = automobiles.model_id 
        INNER JOIN speeds ON speeds.id = automobiles.speed_id 
        INNER JOIN transmissions ON transmissions.id = automobiles.transmission_id 
        INNER JOIN powers ON powers.id = automobiles.power_id
        INNER JOIN bodies ON bodies.id = automobiles.body_id");
        return $query->fetchAll();
    }
}



