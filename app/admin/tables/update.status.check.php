<?php

use App\models\Order;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";


if (isset($_POST["canceled"])) {
    if (!empty($_POST["reason_cancel"])) {
        Order::statusCansel($_POST['id'], $_POST["canceled-id"], $_POST["reason_cancel"]);
    } else {
        $_SESSION["error"] = "Заполните поле причина отмены";
        header("Location: /app/admin/tables/update.status.php");
        die();
    }
} else {
    var_dump($_POST);
    Order::updateStatus($_POST['id'], $_POST['status-id']);
    Order::updateStatusCarByOrder($_POST['id']);
}



header("Location: /app/admin/tables/orderAdmin.php");
