<?php

use App\models\Body;
use App\models\Text;


include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

$bodiesForFIlter = Body::all();
$bodies = Body::all();
$textBrons = Text::textBron();
$textRoutes = Text::textRoutes();

if (isset($_POST['btn-body-filter'])) {
    $bodies = [Body::find($_POST['body_id'])];
}

include $_SERVER['DOCUMENT_ROOT'] . "/views/products/index.view.php";
