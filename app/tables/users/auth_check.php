<?php

use App\models\User;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

unset($_SESSION['error']);

if (isset($_POST['btnAuth'])) {
    $user = User::getUser($_POST['email'], $_POST['password']);
    if ($user == null) {
        $_SESSION['auth'] = false;
        $_SESSION['error'] = "Пользователь не найден";
        die();
    } else {
        $_SESSION["auth"] = true;
        $_SESSION["id"] = $user->id;
        $_SESSION['name'] = $user->name;
        header("Location: /app/tables/users/profile.php");
    }
}
