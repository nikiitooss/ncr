<?php

use App\models\Body;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if (!isset($_SESSION['role_id'])) {
    header("Location: /");
}
if (!$_SESSION['role_id']) {
    header("Location: /app/admin/tables/auth.php");
}

$categories = Body::all();

include $_SERVER['DOCUMENT_ROOT'] . "/views/admin/category.php";
