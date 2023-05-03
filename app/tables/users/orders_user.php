<?php
session_start();

use App\models\Order;
use App\models\User;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";



if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    header("Location: /");
    die();
}

$orders = Order::getUserOrder($_SESSION['id']);

include $_SERVER['DOCUMENT_ROOT'] . "/views/users/order.user.view.php";
