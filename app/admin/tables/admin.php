<?php

use App\models\Admin;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

$admins = Admin::allAdmin();

include $_SERVER['DOCUMENT_ROOT'] . "/views/admin/addAdmin.view.php";
