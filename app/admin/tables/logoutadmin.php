<?php

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

session_unset();
session_destroy();

header("Location: /");