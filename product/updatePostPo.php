<?php
header("Access-Control_allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/spiritspod.php';

$database = new Database();
$db = $database->getConnection();
$finishpostingpo = 1;
$product = new spiritspod($db);
$getOrder=isset($_GET['order']) ? $_GET['order'] : die();
$getStore=isset($_GET['store']) ? $_GET['store'] : 1;
$getPostDate=isset($_GET['rcvdate']) ? $_GET['rcvdate'] : date("Ymd");
$getWho=isset($_GET['who']) ? $_GET['who'] : 'zzz';
$getLstore=isset($_GET['lstore']) ? $_GET['lstore'] : 1;
$getLreg=isset($_GET['lreg']) ? $_GET['lreg'] : 1;

$stmt1 = $product->checkpo($getOrder,$getStore);//we are getting status from poh table

$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
extract($row1);
//$status=8;
//print_r($stmt1);exit;
// if($status=='8'){
/* 		if(substr($vcode,0,3)=='ST-'){
			$istrans = 1;
			$transstore = int(substr($vcode,3,3));
		}else{
			$istrans = 0;
		}; */
		
		$stmt = $product->postpo($getOrder,$getStore); //getting number of records from pod 
		$num = $stmt->rowCount();
		//print_r($num);exit;
		if($num>0){
		  
			$products_arr=array();
			$products_arr["records"]=array();
			
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				print_r($row);
				exit();
				extract($row);
				if($upstk==0){
					$oldStock = $product->popost_getoldstock($sku,$store); //getting old stock from stk table
					$stmt3 = $product->popost_getoldstockcost($sku,$store); //getting old stock cost from stk table
					$info= $stmt3->fetch(PDO::FETCH_ASSOC);
					$lcost = $info['lcost'];
					$acost = $info['acost'];
					
					$poststk = $product->posttostk($store,$sku,$oqty,$vcode,$getPostDate,$getWho,$getLstore,$getLreg);//passing these values which we got from pod table
						if($poststk=='OK'){
							//By salman added this function to update costs in avgcost table
							$product->postpoavgcost($sku, $store, $order, $who, $lcost, $acost, $cost, $lreg, $lstore);

							//$po_pohpostingstatus = $product->updatepohpoststatus($getStore,$getOrder,$getWho,$getLstore,$getLreg,$getPostDate); //by sumeeth for updating poh table

							// added function to update inv
							$product->postcosttoinv($lcost,$acost,$sku);

							//update  in pod table status,tstamp,rcvdate,lstore,lreg,upstk,fifo
							$po_podpostingstatus = $product->updatepodpoststatus($store,$order,$line,$getPostDate,$getWho,$getLstore,$getLreg,$oldStock);
							
							if($po_podpostingstatus !== 'OK'){
								$finishpostingpo = 0;
								http_response_code(503);
								echo json_encode(array("message" => "ERROR (POD) ORDER ".$order));
								echo json_encode(array($popostingstatus));
							};			
						}else{
							$finishpostingpo = 0;
							http_response_code(503);
							echo json_encode(array("message" => "ERROR (STK) SKU ".$sku));
							echo json_encode(array($poststk));
						} 
					
					}
				}
			
			if($finishpostingpo = 0){
				http_response_code(503);
				echo json_encode(array("message" => "ERROR POSTING."));
			}else{
				$po_pohpostingstatus = $product->updatepohpoststatus($getStore,$getOrder,$getWho,$getLstore,$getLreg,$getPostDate);
				if($po_postingstatus='OK'){
					http_response_code(200);
					echo json_encode(array("message" => "POSTED"));
				}else{
					http_response_code(503);
					echo json_encode(array("message" => "ERROR (POH) ORDER ".$order));
					echo json_encode(array($po_pohpostingstatus));	
				}
			}
		}else{
			$po_pohpostingstatus = $product->updatepohpoststatus($getStore,$getOrder,$getWho,$getLstore,$getLreg,$getPostDate);
			if($po_postingstatus='OK'){
				http_response_code(200);
				echo json_encode(array("message" => "POSTED"));
			}else{
				http_response_code(503);
				echo json_encode(array("message" => "ERROR (POH) ORDER ".$order));
				echo json_encode(array($po_pohpostingstatus));	
			}
		}	
// }else{
// 	http_response_code(503);
// 	echo json_encode(array("message" => "ALREADY POSTED"));
// }
