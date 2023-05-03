<?php

use App\models\Booking;
use App\models\Car;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

$user_id = $_SESSION["id"];
$infoUser = Booking::allInfoUserBooking($_SESSION['id']);
$products = Booking::productInOrders($user_id);
$svb = [];
$text =  "";
$styleStatus = "";
$class = '';
foreach($products as $proct){
    if(count(Car::serchSvbdn($proct->automobile_id)) > 0 ){
        $text =  "Есть свободные машины";
        $styleStatus = "green";
        $class = 'open';
    }
    else{
        $text =  "Нет свободных машин";
        $styleStatus = "red";
        $class = 'locked';
    }
    $svb[$proct->automobile_id][0] =  $text;
    $svb[$proct->automobile_id][1] = $styleStatus;
    $svb[$proct->automobile_id][2] = $class;
    
}
include $_SERVER['DOCUMENT_ROOT'] . "/views/products/order.view.php";