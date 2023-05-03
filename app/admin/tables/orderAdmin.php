<?php

use App\models\Admin;
use App\models\Order;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if (!isset($_SESSION['role_id'])) {
    header("Location: /");
}
if (!$_SESSION['role_id']) {
    header("Location: /app/admin/tables/auth.php");
}

$orders = Admin::allOrder();
$statuses = Admin::allStatus();

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'all') {
        $orders = Order::all();
    } else {
        $orders = Order::ordersByManyStatuses($_GET['status']);
    }
}

include $_SERVER['DOCUMENT_ROOT'] . "/views/admin/orderAdmin.view.php";