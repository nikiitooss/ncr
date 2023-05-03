<?php

use App\models\Admin;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if (!isset($_SESSION['role_id'])) {
    header("Location: /");
}
if (!$_SESSION['role_id']) {
    header("Location: /app/admin/tables/auth.php");
}

$speeds = Admin::allSpeeds();

include $_SERVER['DOCUMENT_ROOT'] . "/views/admin/speed.view.php";
