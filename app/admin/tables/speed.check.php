<?php

use App\models\Admin;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if (isset($_POST['btn-add-speed'])) {
    if (empty($_POST['number'])) {
        $_SESSION['error'] = "Не все поля заполнены";
    }

    if (empty($_SESSION['error'])) {
        Admin::addSpeeds($_POST['number']);
    }
}

header("Location: /app/admin/tables/speed.php");
