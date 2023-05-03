<?php

use App\models\Body;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

$imageInfo = Body::imageInfoAutomobilies($_GET['id']);

$product = Body::findAutomobilies($_GET['id']);


include $_SERVER['DOCUMENT_ROOT'] . "/views/products/show.view.php";