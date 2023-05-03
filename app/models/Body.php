<?php

namespace App\models;

use App\helpers\Connection;

class Body
{

    public static function automobiles($body_id)
    {
        $query = Connection::make()->prepare("SELECT automobiles.*,
        models.name as model, speeds.number as speed, bodies.name as body, transmissions.name as transmission, powers.name as power 
        FROM automobiles 
        INNER JOIN models ON models.id = automobiles.model_id 
        INNER JOIN speeds ON speeds.id = automobiles.speed_id 
        INNER JOIN transmissions ON transmissions.id = automobiles.transmission_id 
        INNER JOIN powers ON powers.id = automobiles.power_id 
        INNER JOIN bodies ON bodies.id = automobiles.body_id
        WHERE automobiles.body_id = :body_id");

        $query->execute([
            ':body_id' => $body_id
        ]);
        return $query->fetchAll();
    }

    public static function all()
    {
        $query = Connection::make()->query("SELECT * FROM bodies");
        return $query->fetchAll();
    }

    public static function find($id)
    {
        $query = Connection::make()->prepare("SELECT * FROM  bodies WHERE id = :id");
        $query->execute([
            ':id' => $id
        ]);
        return $query->fetch();
    }

    public static function imageInfoAutomobilies($id){
        $query = Connection::make()->prepare("SELECT images.name as img, images.text as info FROM images INNER JOIN automobiles ON automobiles.id = images.automobyle_id WHERE automobiles.id = :id AND images.is_main = 0");
        $query->execute([
            ':id' => $id
        ]);
        return $query->fetchAll();
    }
    
    public static function findAutomobilies($id)
    {
        $query = Connection::make()->prepare("SELECT automobiles.*,

         models.name as model,
         models.text, 
         images.name as image,
         speeds.number as speed, 
         powers.name as power,  
         bodies.name as body FROM automobiles 

        INNER JOIN images ON images.automobyle_id = automobiles.id
        INNER JOIN bodies ON bodies.id = automobiles.body_id 
        INNER JOIN models ON automobiles.model_id = models.id 
        INNER JOIN speeds ON automobiles.speed_id = speeds.id 
        INNER JOIN powers ON automobiles.power_id = powers.id 

        WHERE automobiles.id = :id");
        $query->execute([
            ':id' => $id
        ]);
        return $query->fetch();
    }

    public static function productsByManyCategories($body)
    {
        $query = Connection::make()->prepare("SELECT automobiles.*,model.name as model,bodies.id as body, speeds.number as speed, transmissions.name as transmission, powers.name as power FROM automobiles INNER JOIN model ON model.id = automobiles.model_id INNER JOIN speeds ON speeds.id = automobiles.speed_id INNER JOIN transmissions ON transmissions.id = automobiles.transmission_id INNER JOIN powers ON powers.id = automobiles.power_id INNER JOIN bodies ON bodies.id = automobiles.body_id WHERE bodies.name = :body_id");
        $query->execute([
            ":body_id" => $body
        ]);
        return $query->fetchAll();
    }
}
