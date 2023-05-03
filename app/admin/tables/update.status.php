<?php

use App\models\Order;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if(isset($_POST['btn-status'])){
    $_SESSION['order-id'] = $_POST['id'];
}

$order = Order::findStatusInOrder($_SESSION['order-id']);

include $_SERVER['DOCUMENT_ROOT'] . "/views/admin/update.status.php";