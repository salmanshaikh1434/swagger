<?php
	header("Access-Control_allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include_once '../config/core.php';
	include_once '../shared/utilities.php';
	include_once '../config/database.php';
	include_once '../objects/spiritsgla.php';

	$database = new Database();
	$db = $database->getConnection();

	$product = new spiritsGla($db);
	$getSku=isset($_GET['glaccount']) ? $_GET['glaccount'] : die();

	$stmt = $product->readGla($getSku);
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
		"sequence" => $sequence,
		"type" => $type,
		"glaccount" => $glaccount,
		"short" => $short,
		"descript" => $descript,
		"balance" => $balance,
		"lastcheck" => $lastcheck,
		"who" => $who,
		"qbooks" => $qbooks,
		"qbooksac" => $qbooksac,
		"skipstat" => $skipstat,
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