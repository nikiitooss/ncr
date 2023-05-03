<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/app/config/db.php";

include $_SERVER['DOCUMENT_ROOT'] . "/app/helpers/Connection.php";

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Booking.php";

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Admin.php";

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Text.php";

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Car.php";

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Body.php";

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Automobyle.php";

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Order.php";