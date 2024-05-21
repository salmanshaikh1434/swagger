<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/spiritsdb.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsdb($db);
  
$thisTable= isset($_GET['table']) ? $_GET['table'] : die();
$stmt = $product->countrecs($thisTable);
$num = $stmt->rowCount();

if($num>0){
	
	$sptable_arr=array();
	$sptable_arr["paging"]=array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$sptable_items = array(
			"total_rows" => $total_rows,
			"total_pages" => ceil((int)$total_rows / $records_per_page)
		);
	}
	/*$stmt->Fields("totalrw")->value;*/
	array_push($sptable_arr["paging"], $sptable_items);
    http_response_code(200);
    echo json_encode($sptable_arr);
} 
?>