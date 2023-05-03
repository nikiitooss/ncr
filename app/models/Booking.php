<?php

namespace App\models;

use App\helpers\Connection;

class Booking
{
    public static function productInOrders($user_id)
    {
        $query = Connection::make()->prepare("SELECT baskets.*, automobiles.photo as photo, automobiles.price_hour as price, models.name as model, bodies.name as body FROM baskets INNER JOIN automobiles ON baskets.automobile_id = automobiles.id INNER JOIN bodies ON automobiles.body_id = bodies.id INNER JOIN models ON automobiles.model_id = models.id WHERE baskets.user_id = :user_id");
        $query->execute([
            ':user_id' => $user_id
        ]);
        return $query->fetchAll();
    }

    public static function search($product_id, $user_id)
    {
        $query = Connection::make()->prepare("SELECT baskets.*, automobiles.photo FROM baskets INNER JOIN automobiles ON baskets.automobile_id = automobiles.id WHERE baskets.user_id = :user_id AND baskets.automobile_id = :automobile_id");
        $query->execute([
            ':automobile_id' => $product_id,
            ':user_id' => $user_id
        ]);
        return $query->fetch();
    }

    public static function add($product_id, $user_id)
    {
        $productInBasket = self::search($product_id, $user_id);
        if (!$productInBasket) {
            $query = Connection::make()->prepare("INSERT INTO baskets (user_id,automobile_id) VALUE (:user_id,:automobile_id)");
            $query->execute([
                ':automobile_id' => $product_id,
                ':user_id' => $user_id
            ]);
        }
        return self::search($product_id, $user_id);
    }

    public static function delete($product_id, $user_id)
    {
        $query = Connection::make()->prepare("DELETE FROM baskets WHERE user_id = :user_id AND automobile_id = :automobile_id");
        $query->execute([
            ':automobile_id' => $product_id,
            ':user_id' => $user_id
        ]);
        return false;
    }

    public static function totalCount($user_id)
    {
        $query = Connection::make()->prepare("SELECT COUNT(automobile_id) as count_car FROM baskets WHERE user_id = :user_id");
        $query->execute([
            ':user_id' => $user_id
        ]);
        return $query->fetch();
    }

    public static function totalPrice($user_id)
    {
        $query = Connection::make()->prepare("SELECT SUM(automobiles.price_hour) as total_sum FROM baskets INNER JOIN automobiles ON baskets.automobile_id = automobiles.id WHERE user_id = :user_id");
        $query->execute([
            ':user_id' => $user_id
        ]);
        return $query->fetch(\PDO::FETCH_COLUMN);
    }

    public static function allInfoUserBooking($id)
    {
        $query = Connection::make()->prepare("SELECT * FROM users WHERE id = :id");
        $query->execute([
            ':id' => $id
        ]);
        return $query->fetch(); 
    }

    public static function clear($user_id, $connect = null)
    {
        $connect = $connect ?? Connection::make();

        $query = $connect->prepare("DELETE FROM baskets WHERE user_id = :user_id");
        $query->execute([
            ':user_id' => $user_id
        ]);
    }
}
