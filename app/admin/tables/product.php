<?php

use App\models\Automobyle;
use App\models\Car;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if (!isset($_SESSION['role_id'])) {
    header("Location: /");
}
if (!$_SESSION['role_id']) {
    header("Location: /app/admin/tables/auth.php");
}

$products = Car::all();
$allAutomobyles = Car::allAutomobyle();
$allCarStatuses = Car::allCarStatus();
$automobyles = Automobyle::all();

include $_SERVER['DOCUMENT_ROOT'] . "/views/admin/cars.view.php";
