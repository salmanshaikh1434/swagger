<?php	header("Access-Control-Allow-Origin: *");	header("Content-Type: application/json; charset=UTF-8");	header("Access-Control-Allow-Methods: POST");	header("Access-Control-Max-Age: 3600");	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");	include_once '../config/database.php';	$database = new Database();	$db = $database->getConnection();	$bulk = json_decode(file_get_contents("php://input"));	$stmt = $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	$stmt = $db->beginTransaction(); 	foreach($bulk->records as $data){		try {		$query = "INSERT INTO spl (`glaccount`,`store`,`department`,`date`,`amount`,`balance`,`transact`,`applyto`,`clear`,`memo`,`note`,`line`,`source`,`account`,`type`,`document`,`checkno`,`who`,`skipstat`,`sent`,`tstamp`,`isdel`,`lreg`,`lstore`)			VALUES 		(:glaccount,:store,:department,:date,:amount,:balance,:transact,:applyto,:clear,:memo,:note,:line,:source,:account,:type,:document,:checkno,:who,:skipstat,:sent,now(),0,:lreg,:lstore)		ON DUPLICATE KEY UPDATE		`glaccount` = :glaccount,		`store` = :store,		`department` = :department,		`date` = :date,		`amount` = :amount,		`balance` = :balance,		`transact` = :transact,		`applyto` = :applyto,		`clear` = :clear,		`memo` = :memo,		`note` = :note,		`line` = :line,		`source` = :source,		`account` = :account,		`type` = :type,		`document` = :document,		`checkno` = :checkno,		`who` = :who,		`skipstat` = :skipstat,		`sent` = :sent,		`tstamp` = NOW(),		`lstore` = :lstore,		`lreg` = :lreg,		`isdel` = :isdel";		$stmt = $db->prepare($query);		$thisglaccount=strip_tags($data->glaccount);		$thisstore=strip_tags($data->store);		$thisdepartment=strip_tags($data->department);		$thisdate=strip_tags($data->date);		$thisamount=strip_tags($data->amount);		$thisbalance=strip_tags($data->balance);		$thistransact=strip_tags($data->transact);		$thisapplyto=strip_tags($data->applyto);		$thisclear=strip_tags($data->clear);		$thismemo=strip_tags($data->memo);		$thisnote=strip_tags($data->note);		$thisline=strip_tags($data->line);		$thissource=strip_tags($data->source);		$thisaccount=strip_tags($data->account);		$thistype=strip_tags($data->type);		$thisdocument=strip_tags($data->document);		$thischeckno=strip_tags($data->checkno);		$thiswho=strip_tags($data->who);		$thisskipstat=strip_tags($data->skipstat);		$thissent=strip_tags($data->sent);		$thislreg=strip_tags($data->lreg);		$thislstore=strip_tags($data->lstore);		$thisisdel=strip_tags($data->isdel);		$thiststamp=strip_tags($data->tstamp);		$stmt->bindParam(':glaccount', $thisglaccount);		$stmt->bindParam(':store', $thisstore);		$stmt->bindParam(':department', $thisdepartment);		$stmt->bindParam(':date', $thisdate);		$stmt->bindParam(':amount', $thisamount);		$stmt->bindParam(':balance', $thisbalance);		$stmt->bindParam(':transact', $thistransact);		$stmt->bindParam(':applyto', $thisapplyto);		$stmt->bindParam(':clear', $thisclear);		$stmt->bindParam(':memo', $thismemo);		$stmt->bindParam(':note', $thisnote);		$stmt->bindParam(':line', $thisline);		$stmt->bindParam(':source', $thissource);		$stmt->bindParam(':account', $thisaccount);		$stmt->bindParam(':type', $thistype);		$stmt->bindParam(':document', $thisdocument);		$stmt->bindParam(':checkno', $thischeckno);		$stmt->bindParam(':who', $thiswho);		$stmt->bindParam(':skipstat', $thisskipstat);		$stmt->bindParam(':sent', $thissent);		$stmt->bindParam(':lreg', $thislreg);		$stmt->bindParam(':lstore', $thislstore);		$stmt->bindParam(':isdel', $thisisdel);		$stmt->bindParam(':tstamp', $thiststamp);		$stmt->execute();		} catch (PDOException $e) {			$message = $e->getMessage();			echo $message;		}		}		$spiritsEND=$db->commit();		if($spiritsEND==TRUE){			http_response_code(200);			echo json_encode(array("message" => "UPDATED.."));		}		else{			http_response_code(503);			echo json_encode(array("message" => "ERROR UPDATING!!"));			echo json_encode(array("error" =>$spiritsEND));		}?>