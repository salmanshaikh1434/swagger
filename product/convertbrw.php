<?php	header("Access-Control-Allow-Origin: *");	header("Content-Type: application/json; charset=UTF-8");	header("Access-Control-Allow-Methods: POST");	header("Access-Control-Max-Age: 3600");	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");	include_once '../config/database.php';	include_once '../objects/spiritsbrw.php';	$database = new Database();	$db = $database->getConnection();	$spiritsUPDB = new spiritsbrw($db);	$stmt = $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	$stmt = $db->beginTransaction(); 	$bulk = json_decode(file_get_contents("php://input"));	foreach($bulk->records as $data){		$query = "INSERT INTO BRW (`pack`,`sku`,`sname`,`name`,`stock`,`stat`,`sloc`,`type`,`typename`,`invclub`,`tags`,tstamp,isdel,lreg,lstore)			VALUES 		(:pack,:sku,:sname,:name,:stock,:stat,:sloc,:type,:typename,:invclub,:tags,now(),0,:lreg,:lstore)		ON DUPLICATE KEY UPDATE		`pack` = :pack,		`sku` = :sku,		`sname` = :sname,		`name` = :name,		`stock` = :stock,		`stat` = :stat,		`sloc` = :sloc,		`type` = :type,		`typename` = :typename,		`invclub` = :invclub,		`tags` = :tags,		`tstamp` = NOW(),		`lstore`= :lstore,		`lreg`= :lreg,		`isdel` = :isdel";		$stmt = $db->prepare($query);		$thispack=strip_tags($data->pack);		$thissku=strip_tags($data->sku);		$thissname=strip_tags($data->sname);		$thisname=strip_tags($data->name);		$thisstock=strip_tags($data->stock);		$thisstat=strip_tags($data->stat);		$thissloc=strip_tags($data->sloc);		$thistype=strip_tags($data->type);		$thistypename=strip_tags($data->typename);		$thisinvclub=strip_tags($data->invclub);		$thistags=strip_tags($data->tags);		$thislreg=strip_tags($data->lreg);		$thislstore=strip_tags($data->lstore);		$thisisdel=strip_tags($data->isdel);		$thiststamp=strip_tags($data->tstamp);		$stmt->bindParam(':pack', $thispack);		$stmt->bindParam(':sku', $thissku);		$stmt->bindParam(':sname', $thissname);		$stmt->bindParam(':name', $thisname);		$stmt->bindParam(':stock', $thisstock);		$stmt->bindParam(':stat', $thisstat);		$stmt->bindParam(':sloc', $thissloc);		$stmt->bindParam(':type', $thistype);		$stmt->bindParam(':typename', $thistypename);		$stmt->bindParam(':invclub', $thisinvclub);		$stmt->bindParam(':tags', $thistags);		$stmt->bindParam(':lreg', $thislreg);		$stmt->bindParam(':lstore', $thislstore);		$stmt->bindParam(':isdel', $thisisdel);		$stmt->bindParam(':tstamp', $thiststamp);		$stmt->execute();		}		$spiritsEND=$db->commit();		if($spiritsEND==TRUE){			http_response_code(200);			echo json_encode(array("message" => "UPDATED.."));		}		else{			http_response_code(503);			echo json_encode(array("message" => "ERROR UPDATING!!"));			echo json_encode(array("error" =>$spiritsEND));		}?>