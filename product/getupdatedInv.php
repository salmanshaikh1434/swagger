<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritsinv.php';

$database = new Database();
$db = $database->getConnection();

$product = new spiritsInv($db);

$getTstamp=isset($_GET['tstamp']) ? $_GET['tstamp'] : die();

$stmt = $product->getUpdatedInv($getTstamp,$startingRecord,$records_per_page);
$num = $stmt->rowCount();
if($num>0){

    $products_arr=array();
    $products_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$product_item=array(
		"type" => $type,
		"name" => $name,
		"ml" => $ml,
		"sname" => $sname,
		"pack" => $pack,
		"sku" => $sku,
		"ssku" => $ssku,
		"stat" => $stat,
		"mtd_units" => $mtd_units,
		"weeks" => $weeks,
		"sdate" => $sdate,
		"mtd_dol" => $mtd_dol,
		"mtd_prof" => $mtd_prof,
		"ytd_units" => $ytd_units,
		"ytd_dol" => $ytd_dol,
		"ytd_prof" => $ytd_prof,
		"cat" => $cat,
		"scat" => $scat,
		"depos" => $depos,
		"acost" => $acost,
		"lcost" => $lcost,
		"pvend" => $pvend,
		"lvend" => $lvend,
		"pdate" => $pdate,
		"smin" => $smin,
		"sord" => $sord,
		"pref" => $pref,
		"suprof" => $suprof,
		"scprof" => $scprof,
		"freeze" => $freeze,
		"sweeks" => $sweeks,
		"freeze_w" => $freeze_w,
		"shelf" => $shelf,
		"rshelf" => $rshelf,
		"sloc" => $sloc,
		"bloc" => $bloc,
		"proof" => $proof,
		"cflag" => $cflag,
		"unit_case" => $unit_case,
		"freeform1" => $freeform1,
		"freeform2" => $freeform2,
		"freeform3" => $freeform3,
		"freeform4" => $freeform4,
		"mfg_key" => $mfg_key,
		"sell" => $sell,
		"who" => $who,
		"memo" => $memo,
		"fson" => $fson,
		"fsfactor" => $fsfactor,
		"cdate" => $cdate,
		"image" => $image,
		"sent" => $sent,
		"vintage" => $vintage,
		"websent" => $websent,
		"typename" => $typename,
		"invprice" => $invprice,
		"invsale" => $invsale,
		"invclub" => $invclub,
		"tags" => $tags,
		"esl" => $esl,
		"tstamp" => $tstamp,
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
