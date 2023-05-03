<?php

use App\models\Admin;

session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if (isset($_POST['addBody'])) {
    $category = Admin::getCategory($_POST['name']);
    if (empty($_POST['name'])) {
        $_SESSION['error'] = 'Заполните поле';
    } else {
        if ($category != null) {
            $_SESSION['error'] = 'Такая категория уже есть';
        } else {
            Admin::addCategory($_POST['name']);
        }
    }
}

header("Location: /app/admin/tables/category.php");
