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
$getWho=isset($_GET['who']) ? $_GET['who'] : 'zzz';
$getLstore=isset($_GET['lstore']) ? $_GET['lstore'] : 1;
$getLreg=isset($_GET['lreg']) ? $_GET['lreg'] : 1;
$getPostDate=0;
$stmt1 = $product->checkpo($getOrder,$getStore);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
extract($row1);

if($status=='4' or $status=='6'){		
		$stmt = $product->unpostpo($getOrder,$getStore);
		$num = $stmt->rowCount();

		if($num>0){
		  
			$products_arr=array();
			$products_arr["records"]=array();
			
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

				extract($row);
				if($upstk==1){
					$oldStock = $product->popost_getoldstock($sku,$store);
					$poststk = $product->posttostk($store,$sku,-$oqty,$vcode,$getPostDate,$getWho,$getLstore,$getLreg);
						if($poststk=='OK'){
							$po_podpostingstatus = $product->updatepodunpoststatus($store,$getOrder,$line,$getWho,$getLstore,$getLreg);
							if($po_podpostingstatus !== 'OK'){
								$finishpostingpo = 0;
								http_response_code(503);
								echo json_encode(array("message" => "ERROR (POD) ORDER ".$order));
								echo json_encode(array($po_podpostingstatus));
							};			
						}else{
							$finishpostingpo = 0;
							http_response_code(503);
							echo json_encode(array("message" => "ERROR (STK) SKU ".$sku));
							echo json_encode(array($poststk));
						}
						if($status=='4'){
							$stmtCost = $product->popost_getoldstockcost($sku,$store);//getting old cost from stk
							$rowCost =  $stmtCost->fetch(PDO::FETCH_ASSOC);
							extract($rowCost);
							$oldACost = $acost;
							$oldLCost = $lcost;
							$newAcost = $product->getlastpoavgcost($sku,$store,'A');//getting old cost from avgcost
							$newLcost = $product->getlastpoavgcost($sku,$store,'L');//getting old cost from avgcost
							// update oldcost from avgcost as acost and lcost in stk table
							$poststkcost = $product->posttostkcost($store,$sku,$newAcost,$newLcost,$getWho,$getLstore,$getLreg);

							if($poststkcost=='OK'){
								//update oldcost from avg table as newcost and oldcost from stk table as oldcost in avgcost table
								// added by salman
								$product->updatepounpostavgcost($sku, $store, $oldAcost, $oldLcost, $newAcost, $newLcost, $getWho, $getOrder, $getLreg, $getLstore);
								//update inv table
								$product->postcosttoinv($newLcost,$newAcost,$sku);
							}else{
								$finishpostingpo = 0;
								http_response_code(503);
								echo json_encode(array("message" => "ERROR (STK) SKU ".$sku));
								echo json_encode(array($poststk));
							}
						}
						
					
					}
				}
			
			if($finishpostingpo = 0){
				http_response_code(503);
				echo json_encode(array("message" => "ERROR POSTING."));
			}else{
				$po_pohpostingstatus = $product->updatepohunpoststatus($store,$order,$getWho,$getLstore,$getLreg);
				if($po_postingstatus='OK'){
					http_response_code(200);
					echo json_encode(array("message" => "UNPOSTED"));
				}else{
					http_response_code(503);
					echo json_encode(array("message" => "ERROR (POH) ORDER ".$order));
					echo json_encode(array($po_pohpostingstatus));	
				}
			}
		}else{
			$po_pohpostingstatus = $product->updatepohunpoststatus($getStore,$getOrder,$getWho,$getLstore,$getLreg);
			if($po_postingstatus='OK'){
				http_response_code(200);
				echo json_encode(array("message" => "UNPOSTED"));
			}else{
				http_response_code(503);
				echo json_encode(array("message" => "ERROR (POH) ORDER ".$order));
				echo json_encode(array($po_pohpostingstatus));	
			}
		}	
}else{
	http_response_code(503);
	echo json_encode(array("message" => "CANNOT UNPOST"));
}


?>