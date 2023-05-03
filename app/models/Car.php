<?php

namespace App\models;

use App\helpers\Connection;

class Car
{

    public static function all()
    {
        $query = Connection::make()->query("SELECT cars.*, bodies.name as body, models.name as model, statuses_cars.name as satus_car FROM cars INNER JOIN automobiles ON cars.automobiles_id = automobiles.id INNER JOIN bodies ON bodies.id = automobiles.body_id INNER JOIN models ON models.id = automobiles.model_id INNER JOIN statuses_cars ON statuses_cars.id = cars.status_car_id");
        return $query->fetchAll();
    }

    public static function searchCar($automobiles_id){
        $query = Connection::make()->prepare("SELECT COUNT(cars.automobiles_id) FROM cars WHERE cars.automobiles_id = :automobiles_id AND cars.status_car_id = 1");
        $query->execute([
            ':automobiles_id' => $automobiles_id
        ]);
        return $query->fetch(\PDO::FETCH_COLUMN);
    }

    public static function allAutomobyle()
    {
        $query = Connection::make()->query("SELECT models.name as model,models.id as id FROM models");
        return $query->fetchAll();
    }

    public static function allCarStatus()
    {
        $query = Connection::make()->query("SELECT * FROM statuses_cars");
        return $query->fetchAll();
    }

    public static function filterStatus($status)
    {
        $query = Connection::make()->prepare("SELECT cars.*, bodies.name as body, models.name as model, statuses_cars.name as satus_car FROM cars INNER JOIN automobiles ON cars.automobiles_id = automobiles.id INNER JOIN bodies ON bodies.id = automobiles.body_id INNER JOIN models ON models.id = automobiles.model_id INNER JOIN statuses_cars ON statuses_cars.id = cars.status_car_id WHERE statuses_cars.name = :status");
        $query->execute([
            ':status' => $status
        ]);
        return $query->fetchAll();
    }

    public static function addCar($number, $photo, $automobiles_id)
    {
        $query = Connection::make()->prepare("INSERT INTO cars (number, photo, automobiles_id) VALUE (:number, :photo, :automobiles_id)");
        $query->execute([
            ':number' => $number,
            ':photo' => $photo,
            ':automobiles_id' => $automobiles_id
        ]);
    }

    public static function getCar($number)
    {
        $query = Connection::make()->prepare("SELECT * FROM cars WHERE number = :number");
        $query->execute([
            ':number' => $number
        ]);
        $car = $query->fetch();
        if ($car > 0) {
            return $car;
        }
        return null;
    }
    public static function serchSvbdn($avto_id){
        $query = Connection::make()->prepare("SELECT `id` FROM `cars` WHERE `automobiles_id` = :automobiles_id AND `status_car_id` = 1");
        $query->execute(['automobiles_id'=>$avto_id]);
        return $query->fetchAll();
    }
}
