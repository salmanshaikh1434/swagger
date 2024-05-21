<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsglrpt.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsglrpt($db);

$getTstamp=isset($_GET['tstamp']) ? $_GET['tstamp'] : die();

$stmt = $product->getUpdatedGlrpt($getTstamp,$startingRecord,$records_per_page);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"rname" => $rname,
		"porb" => $porb,
		"sequence" => $sequence,
		"glaccount" => $glaccount,
		"grouplevel" => $grouplevel,
		"descript" => $descript,
		"print" => $print,
		"indent" => $indent,
		"underline" => $underline,
		"skipline" => $skipline,
		"security" => $security,
		"who" => $who,
		"lreg" => $lreg,
		"lstore" => $lstore,
		"tstamp" => $tstamp,
		"isdel" => $isdel
       );

        array_push($products_arr["records"], $product_item);
    }
		http_response_code(200);
		echo json_encode($products_arr);
	}else{
		http_response_code(404);
		echo json_encode(
		array("message" => "NOT FOUND.")
	);
}
?>