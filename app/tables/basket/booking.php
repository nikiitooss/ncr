<?php

use App\models\Booking;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

$products = Booking::productInOrders($_SESSION['id']);
$infoUser = Booking::allInfoUserBooking($_SESSION['id']);
$totalCount = Booking::totalCount($_SESSION['id']);

include $_SERVER['DOCUMENT_ROOT'] . "/views/products/booking.view.php";