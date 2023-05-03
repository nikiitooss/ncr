<?php

use App\models\User;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if (isset($_POST['btnAdmin'])) {
    $users = User::getUser($_POST['phone'], $_POST['password']);
    if ($users == null) {
        $_SESSION['error'] = "Пользователя не найден";
        header("Location: /app/admin/tables/auth.php");
        die();
    } else {
        if ($users->role == 'Администратор') {
            $_SESSION["id"] = $users->id;
            $_SESSION["role_id"] = true;
            header("Location: /app/admin/tables/product.php");
            die();
        }else{
            $_SESSION['error'] = "Вы не являетесь администратором";
            header("Location: /app/admin/tables/auth.php");
        }
    }
}

?>