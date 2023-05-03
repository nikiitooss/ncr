<?php

use App\models\Car;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";



if ($_GET['status_id'] == 'all') {
    $products = Car::all();
} else {
    $products = Car::filterStatus($_GET['status_id']);
}


echo json_encode($products, JSON_UNESCAPED_UNICODE);
