<?php

use App\models\User;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if ($_POST['action'] == 'reg') {
    if (empty($_POST['name']) || empty($_POST['surname']) || empty($_POST['data_of_birth']) || empty($_POST['password']) || empty($_POST['phone']) || empty($_POST['password_confirmation'])) {
        echo json_encode([
            "error" => "Не все поля заполненны",
        ], JSON_UNESCAPED_UNICODE);
        die();
    }
}

if ($_POST['action'] == 'auth') {
    if (empty($_POST['phone']) || empty($_POST['password'])) {
        echo json_encode([
            "error" => "Не все поля заполненны",
        ], JSON_UNESCAPED_UNICODE);
        die();
    }
    if (User::getUser($_POST['phone'], $_POST['password']) == null){
        echo json_encode([
            "error" => "Пользователь не найдет",
        ], JSON_UNESCAPED_UNICODE);
        die();
    }
}

if (isset($_POST['phone']) && isset($_POST['password'])) {
    $user = match ($_POST['action']) {
        "reg" => User::insert($_POST),
        "auth" => User::getUser($_POST['phone'], $_POST['password']),
    };
    if ($_POST['action'] == 'auth') {
        echo json_encode([
            "user" => $user,
        ], JSON_UNESCAPED_UNICODE);

        if ($user == null) {
            $_SESSION["auth"] = false;
        } else {
            $_SESSION["auth"] = true;
            $_SESSION["id"] = $user->id;
        }
    } else {
        if ($user != null) {
            $Newuser = User::getUser($_POST['phone'], $_POST['password']);
            $_SESSION["auth"] = true;
            $_SESSION["id"] = $Newuser->id;
            echo json_encode([
                "user" => $Newuser,
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                "error" => "Вы уже зарегестрированы",
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
