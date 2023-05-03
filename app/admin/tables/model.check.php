<?php

use App\models\Admin;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

if (isset($_POST['btn-add-model'])) {
    if (empty($_POST['name'])) {
        $_SESSION['error'] = "Не все поля заполнены";
    }

    if (empty($_SESSION['error'])) {
        Admin::addModels($_POST['name'],$_POST['text']);
    }
}

header("Location: /app/admin/tables/model.php");
