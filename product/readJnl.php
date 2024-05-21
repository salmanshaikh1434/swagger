<?php
	header("Access-Control_allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include_once '../config/core.php';
	include_once '../shared/utilities.php';
	include_once '../config/database.php';
	include_once '../objects/spiritsjnl.php';

	$database = new Database();
	$db = $database->getConnection();

	$product = new spiritsJnl($db);
	$getSku=isset($_GET['store']) ? $_GET['store'] : die();
	$getSku=isset($_GET['sale']) ? $_GET['sale'] : die();
	$getSku=isset($_GET['line']) ? $_GET['line'] : die();

	$stmt = $product->readJnl($getSku);
	if ($stmt == false) {
		echo json_encode(
			array("message" => "Unauthorised request.")
		);
		exit;
	}
	$num = $stmt->rowCount();

	if($num>0){

	    $products_arr=array();
	    $products_arr["records"]=array();

	    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			extract($row);

			$product_item=array(
		"store" => $store,
		"sale" => $sale,
		"line" => $line,
		"qty" => $qty,
		"pack" => $pack,
		"sku" => $sku,
		"descript" => $descript,
		"price" => $price,
		"cost" => $cost,
		"discount" => $discount,
		"dclass" => $dclass,
		"promo" => $promo,
		"cat" => $cat,
		"location" => $location,
		"rflag" => $rflag,
		"upc" => $upc,
		"boss" => $boss,
		"memo" => $memo,
		"date" => $date,
		"prclevel" => $prclevel,
		"fspoints" => $fspoints,
		"rtnqty" => $rtnqty,
		"lreg" => $lreg,
		"lstore" => $lstore,
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