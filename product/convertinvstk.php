<?php	header("Access-Control-Allow-Origin: *");	header("Content-Type: application/json; charset=UTF-8");	header("Access-Control-Allow-Methods: POST");	header("Access-Control-Max-Age: 3600");	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");	include_once '../config/database.php';	$database = new Database();	$db = $database->getConnection();	$bulk = json_decode(file_get_contents("php://input"));	$stmt = $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	$stmt = $db->beginTransaction(); 	foreach($bulk->records as $data){		try {		$query = "INSERT INTO invstk (`sku`,`name`,`sname`,`pack`,`type`,`store`,`stat`,`pvend`,`lvend`,`sent`,`tstamp`,`isdel`,`lreg`,`lstore`)			VALUES 		(:sku,:name,:sname,:pack,:type,:store,:stat,:pvend,:lvend,:sent,now(),0,:lreg,:lstore)		ON DUPLICATE KEY UPDATE		`sku` = :sku,		`name` = :name,		`sname` = :sname,		`pack` = :pack,		`type` = :type,		`store` = :store,		`stat` = :stat,		`pvend` = :pvend,		`lvend` = :lvend,		`sent` = :sent,		`tstamp` = NOW(),		`lstore` = :lstore,		`lreg` = :lreg,		`isdel` = :isdel";		$stmt = $db->prepare($query);		$thissku=strip_tags($data->sku);		$thisname=strip_tags($data->name);		$thissname=strip_tags($data->sname);		$thispack=strip_tags($data->pack);		$thistype=strip_tags($data->type);		$thisstore=strip_tags($data->store);		$thisstat=strip_tags($data->stat);		$thispvend=strip_tags($data->pvend);		$thislvend=strip_tags($data->lvend);		$thissent=strip_tags($data->sent);		$thislreg=strip_tags($data->lreg);		$thislstore=strip_tags($data->lstore);		$thisisdel=strip_tags($data->isdel);		$thiststamp=strip_tags($data->tstamp);		$stmt->bindParam(':sku', $thissku);		$stmt->bindParam(':name', $thisname);		$stmt->bindParam(':sname', $thissname);		$stmt->bindParam(':pack', $thispack);		$stmt->bindParam(':type', $thistype);		$stmt->bindParam(':store', $thisstore);		$stmt->bindParam(':stat', $thisstat);		$stmt->bindParam(':pvend', $thispvend);		$stmt->bindParam(':lvend', $thislvend);		$stmt->bindParam(':sent', $thissent);		$stmt->bindParam(':lreg', $thislreg);		$stmt->bindParam(':lstore', $thislstore);		$stmt->bindParam(':isdel', $thisisdel);		$stmt->bindParam(':tstamp', $thiststamp);		$stmt->execute();		} catch (PDOException $e) {			$message = $e->getMessage();			echo $message;		}		}		$spiritsEND=$db->commit();		if($spiritsEND==TRUE){			http_response_code(200);			echo json_encode(array("message" => "UPDATED.."));		}		else{			http_response_code(503);			echo json_encode(array("message" => "ERROR UPDATING!!"));			echo json_encode(array("error" =>$spiritsEND));		}?>