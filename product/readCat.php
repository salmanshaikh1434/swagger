<?php
	header("Access-Control_allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	include_once '../config/core.php';
	include_once '../shared/utilities.php';
	include_once '../config/database.php';
	include_once '../objects/spiritscat.php';

	$database = new Database();
	$db = $database->getConnection();

	$product = new spiritsCat($db);
	$getSku=isset($_GET['cat']) ? $_GET['cat'] : die();

	$stmt = $product->readCat($getSku);
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
		"cat" => $cat,
		"name" => $name,
		"seq" => $seq,
		"lspace" => $lspace,
		"code" => $code,
		"cost" => $cost,
		"taxlevel" => $taxlevel,
		"sur" => $sur,
		"disc" => $disc,
		"dbcr" => $dbcr,
		"cflag" => $cflag,
		"income" => $income,
		"cog" => $cog,
		"inventory" => $inventory,
		"discount" => $discount,
		"who" => $who,
		"wsgroup" => $wsgroup,
		"wscod" => $wscod,
		"wsgallons" => $wsgallons,
		"catnum" => $catnum,
		"fson" => $fson,
		"fsfactor" => $fsfactor,
		"datacap" => $datacap,
		"sent" => $sent,
		"belowcost" => $belowcost,
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
