<?php

namespace App\models;

use App\helpers\Connection;

class User
{
    public static function all()
    {
        $query = Connection::make()->query("SELECT * FROM users");

        return $query->fetchAll();
    }

    public static function infoUser($id)
    {
        $query = Connection::make()->prepare("SELECT * FROM users WHERE id = :id");
        $query->execute(([
            ':id' => $id
        ]));
        return $query->fetch();
    }

    public static function insert($data)
    {
        $user = self::getUser($data['phone'], $data['password']);
        if ($user == null) {
            $query = Connection::make()->prepare("INSERT INTO users (name,surname,password,phone,data_of_birth) VALUES (:name,:surname,:password,:phone,:data_of_birth)");

            return $query->execute([
                ':name' => $data['name'],
                ':surname' => $data['surname'],
                ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
                ':phone' => $data['phone'],
                ':data_of_birth' => $data['data_of_birth'],
            ]);
        } else {
            return null;
        }
    }

    public static function getUser($phone, $password)
    {
        $query = Connection::make()->prepare("SELECT users.*, roles.title as role FROM users INNER JOIN roles ON roles.id = users.role_id WHERE users.phone = :phone");
        $query->execute([':phone' => $phone]);

        $user = $query->fetch();
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return null;
    }

    public static function find($id)
    {
        $query = Connection::make()->prepare("SELECT * FROM users WHERE users.id = :id");
        $query->execute(['id' => $id]);
        $user = $query->fetch();
        return $user;
    }

    public static function findOrder($id)
    {
        $query = Connection::make()->prepare("SELECT orders.*, statuses.name as status, system_blocks.price * sb_in_order.count as sumPrice FROM orders INNER JOIN statuses ON statuses.id = orders.status_id INNER JOIN sb_in_order ON sb_in_order.order_id = orders.id INNER JOIN system_blocks ON system_blocks.id = sb_in_order.system_block_id  WHERE orders.user_id = :id");
        $query->execute(['id' => $id]);
        $orders = $query->fetchAll();
        return $orders;
    }

    public static function findProductsInOrder($id, $order_id)
    {
        $query = Connection::make()->prepare("SELECT sb_in_order.*, system_blocks.name as name, system_blocks.price as price, system_blocks.image as image FROM sb_in_order INNER JOIN orders ON orders.id = sb_in_order.order_id INNER JOIN system_blocks ON system_blocks.id = sb_in_order.system_block_id WHERE orders.user_id = :id AND sb_in_order.order_id = :order_id");
        $query->execute([
            ':id' => $id,
            ':order_id' => $order_id
        ]);
        $productsInOrder = $query->fetchAll();
        return $productsInOrder;
    }

    public static function addAdmin($data)
    {
        $user = self::getUser($data['phone'], $data['password']);
        if ($user == null) {
            $query = Connection::make()->prepare("INSERT INTO users (name,surname,password,phone,data_of_birth,role_id) VALUES (:name,:surname,:password,:phone,:data_of_birth,2)");
            return $query->execute([
                ':name' => $data['name'],
                ':surname' => $data['surname'],
                ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
                ':phone' => $data['phone'],
                ':data_of_birth' => $data['data_of_birth'],
            ]);
        } else {
            return null;
        }
    }
}
