<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsvpr.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsvpr($db);

$getTstamp=isset($_GET['tstamp']) ? $_GET['tstamp'] : die();

$stmt = $product->getUpdatedVpr($getTstamp,$startingRecord,$records_per_page);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"brand" => $brand,
		"ml" => $ml,
		"vintage" => $vintage,
		"bestbot" => $bestbot,
		"date" => $date,
		"pack" => $pack,
		"vend" => $vend,
		"vid" => $vid,
		"upc" => $upc,
		"frontline" => $frontline,
		"postoff" => $postoff,
		"mixcode" => $mixcode,
		"ripcode" => $ripcode,
		"qty1" => $qty1,
		"corb1" => $corb1,
		"prc1" => $prc1,
		"qty2" => $qty2,
		"corb2" => $corb2,
		"prc2" => $prc2,
		"qty3" => $qty3,
		"corb3" => $corb3,
		"prc3" => $prc3,
		"qty4" => $qty4,
		"corb4" => $corb4,
		"prc4" => $prc4,
		"qty5" => $qty5,
		"corb5" => $corb5,
		"prc5" => $prc5,
		"qty6" => $qty6,
		"corb6" => $corb6,
		"prc6" => $prc6,
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
