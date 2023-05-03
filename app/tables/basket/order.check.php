<?php

use App\models\Order;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

Order::create($_SESSION['id'], $_POST);

header("Location: /app/tables/basket/booking.php");