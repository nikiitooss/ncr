<?php

use App\models\Admin;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

$stream = file_get_contents("php://input");

if (isset($stream)) {
    $action = json_decode($stream)->action;
    $id = json_decode($stream)->data;

    $productInBasket = match ($action) {
        "deleteCategory" => Admin::deleteCategory($id),
        "deleteSpeed" => Admin::deleteSpeed($id),
        "deleteModel" => Admin::deleteModel($id),
        "deleteAdmin" => Admin::deleteAdmin($id),
    };

    echo json_encode([
        "productInBasket" => $productInBasket,
    ], JSON_UNESCAPED_UNICODE);
}
