<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritssll.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsSll($db);
$getlistnum = isset($_GET["listnum"]) ? $_GET["listnum"] : 0;
$getstore = isset($_GET["store"]) ? $_GET["store"] : 0;

$stmt = $product->readSllBackroom($getlistnum,$getstore);
$num = $stmt->rowCount();

if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"listnum" => $listnum,
		"line" => $line,
		"listname" => $listname,
		"sku" => $sku,
		"pack" => $pack,
		"type" => $type,
		"descript" => $descript,
		"sname" => $sname,
		"ml" => $ml,
		"level" => $level,
		"qty" => $qty,
		"price" => $price,
		"lcost" => $lcost,
		"acost" => $acost,
		"percent" => $percent,
		"dcode" => $dcode,
		"status" => $status,
		"onsale" => $onsale,
		"prevqty" => $prevqty,
		"prevprice" => $prevprice,
		"prevdcode" => $prevdcode,
		"prevonsale" => $prevonsale,
		"actdate" => $actdate,
		"units" => $units,
		"sales" => $sales,
		"profit" => $profit,
		"store" => $store,
		"labels" => $labels,
		"prevpromo" => $prevpromo,
		"adate" => $adate,
		"mcost" => $mcost,
		"stype" => $stype
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
