<?php
header("Access-Control_allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/spiritspod.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritspod($db);
$getOrder=isset($_GET['order']) ? $_GET['order'] : die();

$stmt = $product->readPod($getOrder);
$num = $stmt->rowCount();

if($num>0){
  
    $products_arr=array();
    $products_arr["records"]=array();
	
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);
        
		$product_item=array(
			"order" => $order,
			"store" => $store,
			"line" => $line,
			"sku" => $sku,
			"name" => $name,
			"sname" => $sname,
			"ml" => $ml,
			"status" => $status,
			"vendor" => $vendor,
			"vcode" => $vcode,
			"vid" => $vid,
			"orddate" => $orddate,
			"rcvdate" => $rcvdate,
			"oqty" => $oqty,
			"coqty" => $coqty,
			"bqty" => $bqty,
			"cbqty" => $cbqty,
			"fifo" => $fifo,
			"cost" => $cost,
			"unitcost" => $unitcost,
			"pack" => $pack,
			"glaccount" => $glaccount,
			"deal" => $deal,
			"salesman" => $salesman,
			"transfer" => $transfer,
			"sord" => $sord,
			"creditstat" => $creditstat,
			"crdpaydate" => $crdpaydate,
			"who" => $who,
			"memo" => $memo,
			"creditdue" => $creditdue,
			"creditpaid" => $creditpaid,
			"crdpaynbr" => $crdpaynbr,
			"deposits" => $deposits,
			"invoice" => $invoice,
			"invoicenbr" => $invoicenbr,
			"upstk" => $upstk,
			"bdrips" => $bdrips,
			"adjcost" => $adjcost,
			"reccoqty" => $reccoqty,
			"recoqty" => $recoqty,
			"rips" => $rips,
			"freight" => $freight,
			"tax" => $tax,
			"discounts" => $discounts,
			"ware" => $ware,
			"wareoqty" => $wareoqty,
			"warecoqty" => $warecoqty,
			"gosent" => $gosent,
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