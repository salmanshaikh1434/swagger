<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/spiritsany.php';

$database = new Database();
$db = $database->getConnection();


$input_data = file_get_contents("php://input");
if (empty($input_data)) {
  
    echo "No data provided.";
    exit;
}
$data = json_decode($input_data);
if (!isset($data->query)) {
    echo "Query not provided.";
    exit;
}
try {
    $stmt = $db->prepare($data->query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
        echo "No results found.";
    } else {
        echo json_encode($result);
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}

