<?php
header("Access-Control_allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/spiritspoh.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritspoh($db);
$getOrder=isset($_GET['order']) ? $_GET['order'] : die();

$stmt = $product->readPoh($getOrder);
$num = $stmt->rowCount();

if($num>0){
  
    $products_arr=array();
    $products_arr["records"]=array();
	
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);
        
		$product_item=array(
			"order" => $order,
			"store" => $store,
			"vendor" => $vendor,
			"vcode" => $vcode,
			"pay_vendor" => $pay_vendor,
			"contact" => $contact,
			"phone" => $phone,
			"status" => $status,
			"orddate" => $orddate,
			"promdate" => $promdate,
			"rcvdate" => $rcvdate,
			"agedate" => $agedate,
			"whoreq" => $whoreq,
			"whoord" => $whoord,
			"whorcv" => $whorcv,
			"terms" => $terms,
			"shipvia" => $shipvia,
			"customer" => $customer,
			"taxcode" => $taxcode,
			"total" => $total,
			"lastline" => $lastline,
			"transact" => $transact,
			"lstore" => $lstore,
			"lreg" => $lreg,
			"who" => $who,
			"tstamp" => $tstamp,
			"memo" => $memo,
			"discounts" => $discounts,
			"tax" => $tax,
			"newdeposit" => $newdeposit,
			"rtndeposit" => $rtndeposit,
			"freight" => $freight,
			"salesman" => $salesman,
			"transfer" => $transfer,
			"includedep" => $includedep,
			"invoicenbr" => $invoicenbr,
			"repost" => $repost,
			"postcost" => $postcost,
			"bdrips" => $bdrips,
			"sent" => $sent,
			"applytax" => $applytax,
			"applycred" => $applycred,
			"applyship" => $applyship,
			"applybdrip" => $applybdrip,
			"approved" => $approved,
			"cstore" => $cstore,
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