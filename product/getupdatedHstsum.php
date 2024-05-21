<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritshstsum.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritshstsum($db);

$getTstamp=isset($_GET['tstamp']) ? $_GET['tstamp'] : die();

$stmt = $product->getUpdatedHstsum($getTstamp,$startingRecord,$records_per_page);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"sku" => $sku,
		"store" => $store,
		"year" => $year,
		"janqty" => $janqty,
		"jancost" => $jancost,
		"janprice" => $janprice,
		"febqty" => $febqty,
		"febcost" => $febcost,
		"febprice" => $febprice,
		"marqty" => $marqty,
		"marcost" => $marcost,
		"marprice" => $marprice,
		"aprqty" => $aprqty,
		"aprcost" => $aprcost,
		"aprprice" => $aprprice,
		"mayqty" => $mayqty,
		"maycost" => $maycost,
		"mayprice" => $mayprice,
		"junqty" => $junqty,
		"juncost" => $juncost,
		"junprice" => $junprice,
		"julqty" => $julqty,
		"julcost" => $julcost,
		"julprice" => $julprice,
		"augqty" => $augqty,
		"augcost" => $augcost,
		"augprice" => $augprice,
		"sepqty" => $sepqty,
		"sepcost" => $sepcost,
		"sepprice" => $sepprice,
		"octqty" => $octqty,
		"octcost" => $octcost,
		"octprice" => $octprice,
		"novqty" => $novqty,
		"novcost" => $novcost,
		"novprice" => $novprice,
		"decqty" => $decqty,
		"deccost" => $deccost,
		"decprice" => $decprice,
		"who" => $who,
		"sent" => $sent,
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
