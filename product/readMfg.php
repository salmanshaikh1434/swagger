<?php
header("Access-Control_allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/spiritsmsg.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsMsg($db);
$id = isset($_GET['id']) ? $_GET['id'] : die();

$stmt = $product->readMsg($id);
$num = $stmt->rowCount();

if ($num > 0) {

    $products_arr = array();
    $products_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $product_item = array(
            "id" => $id,
            "name" => $name,
            "caseamt" => $caseamt,
            "unitamt" => $unitamt,
            "lreg" => $lreg,
            "tstamp" => $tstamp,
            "isdel" => $isdel,
            "lstore" => $lstore
        );
        array_push($products_arr["records"], $product_item);
    }

    http_response_code(200);
    echo json_encode($products_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "NOT FOUND.")
    );
}
