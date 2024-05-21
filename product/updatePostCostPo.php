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

$stmt1 = $product->checkpo($getOrder,$getStore);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

extract($row1);

if($status=='6'){
		
		$stmt = $product->postpocost($getOrder,$getStore);
		$num = $stmt->rowCount();

		if($num>0){
		  
			$products_arr=array();
			$products_arr["records"]=array();
			
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

				extract($row);
				if($cost!==0 or $adjcost!==0){
					$stmtCost = $product->popost_getoldstockcost($sku,$store);
					$rowCost =  $stmtCost->fetch(PDO::FETCH_ASSOC);
					extract($rowCost);
					$stkStoreACost = $acost;
					$stkStoreLCost = $lcost;
					if($invpack==0){
						$invPackSize = $pack;
					}else{
						$invPackSize = $invpack;
					}
					$oldStock = $product->popost_getoldstockall($sku,$store);
					$oldStock = $oldStock-($oqty+$wareoqty);
					$newStockAmt = $oldStock+($oqty+$wareoqty);
					if($adjcost==0){
						$newPOCostVal = $cost;
					}else{
						$newPOCostVal = $adjcost;
					}
					$newLcost = round(($pack * ($newPOCostVal / ($oqty+$wareoqty))),2,PHP_ROUND_HALF_UP);
					if($oldStock==0){
						$newAcost = $newLcost;
					}else{
						$stkAcostUnit = $stkStoreACost/$invPackSize;
						$stkOldValue = $stkAcostUnit*($oldStock);
						$stkNewValue = $stkOldValue+$newPOCostVal;
						$newAcost = round($invPackSize*($stkNewValue/$newStockAmt),2,PHP_ROUND_HALF_UP);
					} 
					$poststkcost = $product->posttostkcost($store,$sku,$newAcost,$newLcost,$getWho,$getLstore,$getLreg);
					if($poststkcost=='OK'){
						$po_podpostingstatus = $product->updatepodcoststatus($store,$order,$line,$who,$lstore,$lreg);
						if($po_podpostingstatus !== 'OK'){
							$finishpostingpo = 0;
							http_response_code(503);
							echo json_encode(array("message" => "ERROR (POD) ORDER ".$order));
							echo json_encode(array($popostingstatus));
						}else{
							$product->updatepoavgcost($sku,$store,$stkStoreACost,$newAcost,$getWho,$getOrder,$getLreg,$getLstore,'A');
							$product->updatepoavgcost($sku,$store,$stkStoreLCost,$newLcost,$getWho,$getOrder,$getLreg,$getLstore,'L');
						}			
					}else{
						$finishpostingpo = 0;
						http_response_code(503);
						echo json_encode(array("message" => "ERROR (STK) SKU ".$sku));
						echo json_encode(array($poststk));
					}
				}else{
					$po_podpostingstatus = $product->updatepodcoststatus($store,$order,$line,$who,$lstore,$lreg);
					if($po_podpostingstatus !== 'OK'){
						$finishpostingpo = 0;
						http_response_code(503);
						echo json_encode(array("message" => "ERROR (POD) ORDER ".$order));
						echo json_encode(array($popostingstatus));
					}		
				}
			}
			
			if($finishpostingpo = 0){
				http_response_code(503);
				echo json_encode(array("message" => "ERROR POSTING."));
			}else{
				$po_pohpostingstatus = $product->updatepohcoststatus($getStore,$getOrder,$who,$lreg,$lstore,$rcvdate);
				if($po_postingstatus='OK'){
				
			   http_response_code(200);
			   echo json_encode(array("message" => "POSTED"));
				}
			}
		}else{
			http_response_code(503);
			echo json_encode(array("message" => "NOTHING TO POST"));
		}	
}else{
	http_response_code(503);
	echo json_encode(array("message" => "CANNOT UPDATE COST"));
}


?>