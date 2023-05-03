<?php

use App\models\Admin;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";
unset($_SESSION['error']);

$extensions = ["jpeg", "jpg", "png", "webp"];
$types = ["image/jpg", "image/jpeg", "image/png", "image/webp"];

if (isset($_POST['addAutomobile'])) {

    if (empty($_FILES['photo']) || empty($_FILES['image_one']) || empty($_FILES['image_two']) || empty($_POST['price_hour']) || empty($_POST['model_id']) || empty($_POST['speed_id']) || empty($_POST['transmission_id']) || empty($_POST['power_id']) || empty($_POST['body_id'])) {
        $_SESSION['error'] = "Не все поля заполнены";
    }

    if (!isset($_SESSION['error'])) {
        if (isset($_FILES['photo'])) {
            $name = $_FILES['photo']['name'];
            $tmpName = $_FILES['photo']['tmp_name'];
            $error = $_FILES['photo']['error'];
            $size = $_FILES['photo']['size'];

            $path_parts = pathinfo($name);

            $ext = $path_parts["extension"];
            $mimeType = mime_content_type($tmpName);

            if (in_array($ext, $extensions) && in_array($mimeType, $types)) {

                if ($error == 0) {
                    if (!move_uploaded_file($tmpName, $_SERVER["DOCUMENT_ROOT"] . "/upload/cars/$name")) {
                        $_SESSION['error'] = "Не получилось переместить файл";
                    }
                } else {
                    $_SESSION['error'] = 'Есть ошибка';
                }
            } else {
                $_SESSION['error'] = 'Расширение файла должно быть: ' . implode(", ", $extensions);
            }
        }
    }
    if (!isset($_SESSION['error'])) {
        if (isset($_FILES['image_one'])) {
            $name_image_one = $_FILES['image_one']['name'];
            $tmpName_image_one = $_FILES['image_one']['tmp_name'];
            $error_image_one = $_FILES['image_one']['error'];
            $size_image_one = $_FILES['image_one']['size'];

            $path_parts_image_one = pathinfo($name_image_one);
            $ext_image_one = $path_parts_image_one["extension"];
            $mimeType_image_one = mime_content_type($tmpName_image_one);

            if (in_array($ext_image_one, $extensions) && in_array($mimeType_image_one, $types)) {

                if ($error_image_one == 0) {
                    if (!move_uploaded_file($tmpName_image_one, $_SERVER["DOCUMENT_ROOT"] . "/upload/photo/$name_image_one")) {
                        $_SESSION['error'] = "Не получилось переместить файл";
                    }
                } else {
                    $_SESSION['error'] = 'Есть ошибка';
                }
            } else {
                $_SESSION['error'] = 'Расширение файла должно быть: ' . implode(", ", $extensions);
            }
        }
    }
    if (!isset($_SESSION['error'])) {
        if (isset($_FILES['image_two'])) {
            $name_image_two = $_FILES['image_two']['name'];
            $tmpName_image_two = $_FILES['image_two']['tmp_name'];
            $error_image_two = $_FILES['image_two']['error'];
            $size_image_two = $_FILES['image_two']['size'];

            $path_parts_image_two = pathinfo($name_image_two);

            $ext_image_two = $path_parts_image_two["extension"];
            $mimeType_image_two = mime_content_type($tmpName_image_two);

            if (in_array($ext_image_two, $extensions) && in_array($mimeType_image_two, $types)) {

                if ($error_image_two == 0) {
                    if (!move_uploaded_file($tmpName_image_two, $_SERVER["DOCUMENT_ROOT"] . "/upload/photo/$name_image_two")) {
                        $_SESSION['error'] = "Не получилось переместить файл";
                    }
                } else {
                    $_SESSION['error'] = 'Есть ошибка';
                }
            } else {
                $_SESSION['error'] = 'Расширение файла должно быть: ' . implode(", ", $extensions);
            }
        }
    }
    if (!isset($_SESSION['error'])) {
        Admin::addProduct($name, $_POST['price_hour'], $_POST['model_id'], $_POST['speed_id'], $_POST['transmission_id'], $_POST['power_id'], $_POST['body_id']);
        $product = Admin::getAutomobiles($name);
        Admin::addImage($name_image_one, '', $product->id, 1);
        Admin::addImage($name_image_two, $_POST['text'], $product->id, 0);
    }
}


header("Location: /app/admin/tables/automobile.php");
