<?php
session_start();
unset($_SESSION['contact']);

use App\models\User;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if (isset($_POST['btnReg'])) {

    $_SESSION['contact']['name'] = $_POST['name'];
    $_SESSION['contact']['surname'] = $_POST['surname'];
    $_SESSION['contact']['login'] = $_POST['login'];
    $_SESSION['contact']['email'] = $_POST['email'];

    
    var_dump($_POST);
    if ($_POST['password'] == $_POST['password_confirmation']) {
        if (User::insert($_POST)) {
            $user = User::getUser($_POST['login'], $_POST['password']);
            $_SESSION['auth'] = true;
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['id'] = $user->id;
            header("Location: /");
            die();
        } else {
            $_SESSION['auth'] = false;
            header("Location: /app/tables/users/create.php");
            die();
        }
    }
}
