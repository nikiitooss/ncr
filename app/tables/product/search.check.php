<?php

use App\models\Automobyle;
use App\models\Body;

include $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

$bodies = [];
if (!isset($_GET['body']) || empty($_GET['body']) || $_GET['body'] == 'all') {
    $bodies = Body::all();
} else {
    $bodies[] = Body::find($_GET['body']);
    
}
echo json_encode([
    'automobiles' =>  Automobyle::all(),
    'bodies' => $bodies
], JSON_UNESCAPED_UNICODE);
