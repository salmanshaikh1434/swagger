<?php
	header("Access-Control_allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include_once '../config/core.php';
	include_once '../shared/utilities.php';
	include_once '../config/database.php';
	include_once '../objects/spiritssll.php';

	$database = new Database();
	$db = $database->getConnection();

	$product = new spiritsSll($db);
	
	$stmt = $product->getactiveSll();
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
		"type" => $type,
		"descript" => $descript,
		"sname" => $sname,
		"ml" => $ml,
		"level" => $level,
		"qty" => $qty,
		"price" => $price,
		"cost" => $cost,
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
		"stype" => $stype,
		"gosent" => $gosent,
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