<?php

namespace App\models;

use App\helpers\Connection;
use App\models\Booking;

class Order
{
    public static function create($user_id, $data)
    {
        $conn = Connection::make();

        $order_id = self::addOrder($user_id, $conn);

        self::addOrderProducts($data, $order_id, $conn);

        Booking::clear($user_id, $conn);

    }

    public static function addOrder($user_id, $conn)
    {
        $query = $conn->prepare('INSERT INTO orders (registration_date,user_id) VALUES (:registration_date,:user_id)');
        $query->execute([
            ':user_id' => $user_id,
            ':registration_date' => date("Y-m-d H:i:s"),
        ]);
        return $conn->lastInsertId();
    }


    public static function addOrderProductsTemp($product_id, $user_id, $count)
    {
        $query = Connection::make()->prepare('INSERT INTO products_orders (user_id,product_id,count) VALUES (:user_id,:product_id,:count');
        $query->execute([
            ':user_id' => $user_id,
            'product_id' => $product_id,
            'count' => $count
        ]);
    }

    private static function getParams($array, $value)
    {
        return implode(",", array_fill(0, count($array), $value));
    }

    public static function addOrderProducts($data, $order_id, $conn)
    {
        $n = count($data['car_id']);
        $queryText = "INSERT INTO products_orders (date_time_biginning,date_time_eding,order_id,car_id) VALUES ";

        $str = '';
        $values = [];
        for ($i = 0; $i < $n; $i++) {

            $queryDop = Connection::make()->prepare("SELECT * FROM `cars` WHERE automobiles_id = :car_id AND status_car_id = 1");
            $queryDop->execute(["car_id" => $data['car_id'][$i]]);
            $car = $queryDop->fetch();
            if ($car != null) {
                $dateStart = mktime(0, 0, 0, $data['start-month'][$i], $data['start-day'][$i], $data['start-year'][$i]);
                $dateEnd = mktime(0, 0, 0, $data['start-month'][$i], $data['start-day'][$i] + $data['count-day'][$i], $data['start-year'][$i]);
                $str .= '(?,?,?,?),';
                $values[] = date('Y-m-d', $dateStart);
                $values[] = date('Y-m-d', $dateEnd);
                $values[] = $order_id;
                $values[] = $car->id;
                $queryDop2 = Connection::make()->prepare("UPDATE `cars` SET `status_car_id`=2 WHERE id =:id");
                $queryDop2->execute(["id" => $car->id]);
            }
        }
        $str = rtrim($str, ',');
        $queryText .= $str;

        $query = $conn->prepare($queryText);
        if (count($values) > 0) {
            $query->execute($values);
        } else {
            return "все машины уже забронированны";
        }
    }

    public static function getCar($car_id)
    {
        $query = Connection::make()->prepare("SELECT cars.*, statuses_cars.name as status FROM cars INNER JOIN statuses_cars ON statuses_cars.id = cars.status_car_id WHERE cars.id = :car_id");
        $query->execute([
            ':car_id' => $car_id
        ]);
        return $query->fetch();
    }

    public static function updateStatusCar($car_id)
    {
        $query = Connection::make()->prepare("UPDATE cars SET status_car_id = 2 WHERE cars.id = :car_id");
        $query->execute([
            ':car_id' => $car_id
        ]);
    }

    public static function all()
    {
        $query = Connection::make()->query("SELECT orders.*, users.name as user, statuses.name as statuse FROM orders INNER JOIN users ON users.id = orders.user_id INNER JOIN statuses ON statuses.id = orders.status_id");
        return $query->fetchAll();
    }

    public static function totalPrice($id)
    {
        $query = Connection::make()->prepare("SELECT SUM(products.price) as total_price FROM order_products INNER JOIN products ON order_products.product_id = products.id WHERE order_id = :id");
        $query->execute([
            ':id' => $id
        ]);
        return $query->fetch(\PDO::FETCH_COLUMN);
    }

    public static function totalCount($id)
    {
        $query = Connection::make()->prepare("SELECT SUM(order_products.count) as total_count FROM order_products INNER JOIN products ON order_products.product_id = products.id WHERE order_id = :id");
        $query->execute([
            ':id' => $id
        ]);
        return $query->fetch(\PDO::FETCH_COLUMN);
    }

    public static function allStatus()
    {
        $query = Connection::make()->query("SELECT * FROM statuses");
        return $query->fetchAll();
    }

    public static function updateStatus($id, $status_id)
    {
        $query = Connection::make()->prepare("UPDATE orders SET status_id = :status_id WHERE id = :id");
        $query->execute([
            ':id' => $id,
            ':status_id' => $status_id
        ]);
    }

    public static function getCarByOrder($order_id)
    {
        $query = Connection::make()->prepare("SELECT * FROM products_orders WHERE products_orders.order_id = :order_id");
        $query->execute([
            ':order_id' => $order_id
        ]);
        return $query->fetchAll();
    }

    public static function updateStatusCarByOrder($order_id)
    {
        $cars = self::getCarByOrder($order_id);
        foreach ($cars as $car) {
            $query = Connection::make()->prepare("UPDATE cars SET status_car_id = 1 WHERE (SELECT products_orders.car_id FROM products_orders WHERE products_orders.order_Id = :Order_Id AND products_orders.car_id = :Car_id) = :car_id AND (SELECT products_orders.order_id FROM products_orders WHERE products_orders.order_Id = :Order_Id AND products_orders.car_id = :Car_id)");
            $query->execute([
                ':car_id' => $car->car_id,
                ':Car_id' => $car->car_id,
                ':order_id' => $order_id,
                ':Order_Id' => $order_id
            ]);
        }
    }

    public static function statusCansel($id, $status_id, $reason_cancel)
    {
        $query = Connection::make()->prepare("UPDATE orders SET status_id = :status_id, reason_cancel = :reason_cancel WHERE id = :id");
        $query->execute([
            ':id' => $id,
            ':status_id' => $status_id,
            ':reason_cancel' => $reason_cancel
        ]);
    }

    public static function getUserInOrder($id)
    {
        $query = Connection::make()->prepare("SELECT order_products.*,orders.updated_at,users.name as userName FROM order_products INNER JOIN users ON orders.user_id = users.id INNER JOIN orders ON orders.id = order_products.order_id WHERE order_id = :id");
        $query->execute([
            ':id' => $id
        ]);
        return $query->fetch();
    }

    public static function ordersByManyStatuses($status)
    {
        $query = Connection::make()->prepare("SELECT orders.*, users.name as user, statuses.name as statuse FROM orders INNER JOIN users ON users.id = orders.user_id INNER JOIN statuses ON orders.status_id = statuses.id WHERE orders.status_id = :status");
        $query->execute([
            ':status' => $status
        ]);
        return $query->fetchAll();
    }

    public static function findStatusInOrder($id)
    {
        $query = Connection::make()->prepare("SELECT orders.*, statuses.name as status FROM orders INNER JOIN statuses ON orders.status_id = statuses.id WHERE orders.id = :id");
        $query->execute([
            ':id' => $id
        ]);
        return $query->fetch();
    }

    public static function getUserOrder($id)
    {
        $query = Connection::make()->prepare("SELECT orders.*, statuses.name as status FROM orders INNER JOIN statuses ON statuses.id = orders.status_id WHERE orders.user_id = :id");
        $query->execute([
            ':id' => $id
        ]);
        return $query->fetchAll();
    }

    public static function getProductByOrderUser($order_id)
    {
        $query = Connection::make()->prepare("SELECT products_orders.*, cars.photo as photo, cars.number as number, models.name as model, bodies.name as body FROM products_orders INNER JOIN cars ON cars.id = products_orders.car_id INNER JOIN automobiles ON cars.automobiles_id = automobiles.id INNER JOIN models ON automobiles.model_id = models.id INNER JOIN bodies ON automobiles.body_id = bodies.id WHERE products_orders.order_id = :order_id");
        $query->execute([
            ':order_id' => $order_id
        ]);
        return $query->fetchAll();
    }
}
