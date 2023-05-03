<?php

use App\models\User;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if (isset($_POST['btn-add-admin'])) {
    $user = User::getUser($_POST['phone'], $_POST['password']);
    if (empty($_POST['name']) || empty($_POST['surname']) || empty($_POST['data_of_birth']) || empty($_POST['phone']) || empty($_POST['password'])) {
        $_SESSION['error'] = "Не все поля заполнены";
    }

    if($user != null){
        $_SESSION['error'] = "Такой пользователь уже есть";
    }

    if (empty($_SESSION['error'])) {
        User::addAdmin($_POST);
    }
}

header("Location: /app/admin/tables/admin.php");
