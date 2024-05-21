<?php
header("Access-Control_allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/spiritsattd.php';

$database = new Database();
$db = $database->getConnection();

$token = new spiritsAttd($db);

if (!$token->auth()) {
    http_response_code(404);
    echo json_encode([
        "message" => "Authorization failure.",
    ]);
} else {
    http_response_code(200);
    echo json_encode($token->auth());

}

?>