<?php

use App\models\Car;

session_start();
unset($_SESSION['product']);
unset($_SESSION['error']);

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

$extensions = ["jpeg", "jpg", "png", "webp", "jfif"];
$types = ["image/jpg", "image/jpeg", "image/png", "image/webp", "image/jfif"];
$product = Car::getCar($_POST['number']);
if (isset($_POST['btnAddCar'])) {

    if (empty($_POST['number'])) {
        $_SESSION['error']['number'] = 'Заполните price';
    }

    if (isset($_FILES['photo'])) {
        $name = $_FILES['photo']['name'];
        $tmpName = $_FILES['photo']['tmp_name'];
        $error = $_FILES['photo']['error'];
        $size = $_FILES['photo']['size'];
    }

    if (!move_uploaded_file($tmpName, $_SERVER["DOCUMENT_ROOT"] . "/upload/cars/$name")) {
        $_SESSION['error']['file'] = "Не получилось переместить файл";
    }

    if (isset($_SESSION['error'])) {
        header("Location: /app/admin/tables/product.php");
    } else {
        Car::addCar($_POST['number'], $name, $_POST['automobiles_id']);
        unset($_SESSION['product']);
    }
}

header("Location: /app/admin/tables/product.php");
