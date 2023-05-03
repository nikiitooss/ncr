<?php

use App\models\Admin;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

$products = Admin::getProductsInOrder($_GET['id']);

include $_SERVER['DOCUMENT_ROOT'] . "/views/admin/show.order.view.php";