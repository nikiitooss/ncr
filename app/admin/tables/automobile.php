<?php

use App\models\Admin;
use App\models\Automobyle;
use App\models\Body;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if (!isset($_SESSION['role_id'])) {
    header("Location: /");
}
if (!$_SESSION['role_id']) {
    header("Location: /app/admin/tables/auth.php");
}

$automobilies = Automobyle::all();
$models = Admin::allModels();
$bodies = Body::all();
$speeds = Admin::allSpeeds();
$powers = Admin::allPowers();
$transmissions = Admin::allTransmissions();

include $_SERVER['DOCUMENT_ROOT'] . "/views/admin/automobile.view.php";
