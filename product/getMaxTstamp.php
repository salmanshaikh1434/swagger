<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsmfg.php';

$database = new Database();
$db = $database->getConnection();
$table = isset($_GET["table"]) ? $_GET["table"] : "";

if (!empty($table)) {
    
    $query = "SHOW TABLES LIKE :table_name";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':table_name', $table, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
       
        $query = "SELECT MAX(tstamp) AS max_tstamp FROM $table WHERE isdel = 0";

        $stmt = $db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

      
        if (isset($row['max_tstamp'])) {
            http_response_code(200);
            echo json_encode($row);
        } else {
            // if tstamp not found
            http_response_code(404);
            echo json_encode(
                array("message" => "NOT FOUND.")
            );
        }
    } else {
        // IF table does not exist
        http_response_code(404);
        echo json_encode(
            array("message" => "NOT FOUND.")
        );
    }
} else {
    // If table name not passed
    http_response_code(400);
    echo json_encode(
        array("message" => "NOT FOUND.")
    );
}
?>
