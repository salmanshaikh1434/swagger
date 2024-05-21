<?php	header("Access-Control_allow-Origin: *");	header("Content-Type: application/json; charset=UTF-8");	include_once '../config/core.php';	include_once '../shared/utilities.php';	include_once '../config/database.php';	include_once '../objects/spiritstyp.php';	$database = new Database();	$db = $database->getConnection();	$product = new spiritsTyp($db);	$getSku=isset($_GET['type']) ? $_GET['type'] : die();	$stmt = $product->readTyp($getSku);	$num = $stmt->rowCount();	if($num>0){	    $products_arr=array();	    $products_arr["records"]=array();	    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){			extract($row);			$product_item=array(		"type" => $type,		"name" => $name,		"scat1" => $scat1,		"scat2" => $scat2,		"unit_case" => $unit_case,		"suprof" => $suprof,		"scprof" => $scprof,		"sweeks" => $sweeks,		"smin" => $smin,		"sord" => $sord,		"disc" => $disc,		"ml1" => $ml1,		"uprof1" => $uprof1,		"cprof1" => $cprof1,		"weeks1" => $weeks1,		"disc1" => $disc1,		"ml2" => $ml2,		"uprof2" => $uprof2,		"cprof2" => $cprof2,		"disc2" => $disc2,		"weeks2" => $weeks2,		"ml3" => $ml3,		"uprof3" => $uprof3,		"cprof3" => $cprof3,		"weeks3" => $weeks3,		"disc3" => $disc3,		"ml4" => $ml4,		"uprof4" => $uprof4,		"cprof4" => $cprof4,		"weeks4" => $weeks4,		"disc4" => $disc4,		"ml5" => $ml5,		"uprof5" => $uprof5,		"cprof5" => $cprof5,		"weeks5" => $weeks5,		"disc5" => $disc5,		"ml6" => $ml6,		"uprof6" => $uprof6,		"cprof6" => $cprof6,		"weeks6" => $weeks6,		"disc6" => $disc6,		"ml7" => $ml7,		"uprof7" => $uprof7,		"cprof7" => $cprof7,		"weeks7" => $weeks7,		"disc7" => $disc7,		"ml8" => $ml8,		"uprof8" => $uprof8,		"cprof8" => $cprof8,		"weeks8" => $weeks8,		"disc8" => $disc8,		"who" => $who,		"fson" => $fson,		"webupdate" => $webupdate,		"sent" => $sent,		"typenum" => $typenum,		"uvinseas" => $uvinseas,		"browseqty" => $browseqty,		"outofstock" => $outofstock,		"lreg" => $lreg,		"lstore" => $lstore,		"isdel" => $isdel	       );	        array_push($products_arr["records"], $product_item);	    }	    http_response_code(200);	    echo json_encode($products_arr);	}else{		http_response_code(404);		echo json_encode(			array("message" => "NOT FOUND.")		);	}?>