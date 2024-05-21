<?php
	header("Access-Control_allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include_once '../config/core.php';
	include_once '../shared/utilities.php';
	include_once '../config/database.php';
	include_once '../objects/spiritsslh.php';

	$database = new Database();
	$db = $database->getConnection();

	$product = new spiritsSlh($db);
	

	$stmt = $product->getactiveslh();
	$num = $stmt->rowCount();

	if($num>0){

	    $products_arr=array();
	    $products_arr["records"]=array();

	    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			extract($row);

			$product_item=array(
		"listnum" => $listnum,
		"listname" => $listname,
		"by" => $by,
		"descript" => $descript,
		"type" => $type,
		"promo" => $promo,
		"onsale" => $onsale,
		"reprice" => $reprice,
		"store" => $store,
		"status" => $status,
		"start" => $start,
		"stop" => $stop,
		"cases" => $cases,
		"sales" => $sales,
		"profit" => $profit,
		"who" => $who,
		"sent" => $sent,
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