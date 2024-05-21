<?php	header("Access-Control-Allow-Origin: *");	header("Content-Type: application/json; charset=UTF-8");	header("Access-Control-Allow-Methods: POST");	header("Access-Control-Max-Age: 3600");	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");	include_once '../config/database.php';	$database = new Database();	$db = $database->getConnection();	$bulk = json_decode(file_get_contents("php://input"));	$stmt = $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	$stmt = $db->beginTransaction(); 	foreach($bulk->records as $data){		try {		$query = "INSERT INTO stamps (`series`,`snumber`,`enumber`,`qty`,`order`,`store`,`customer`,`invdate`,`who`,`memo`,`sent`,`tstamp`,`isdel`,`lreg`,`lstore`)			VALUES 		(:series,:snumber,:enumber,:qty,:order,:store,:customer,:invdate,:who,:memo,:sent,now(),0,:lreg,:lstore)		ON DUPLICATE KEY UPDATE		`series` = :series,		`snumber` = :snumber,		`enumber` = :enumber,		`qty` = :qty,		`order` = :order,		`store` = :store,		`customer` = :customer,		`invdate` = :invdate,		`who` = :who,		`memo` = :memo,		`sent` = :sent,		`tstamp` = NOW(),		`lstore` = :lstore,		`lreg` = :lreg,		`isdel` = :isdel";		$stmt = $db->prepare($query);		$thisseries=strip_tags($data->series);		$thissnumber=strip_tags($data->snumber);		$thisenumber=strip_tags($data->enumber);		$thisqty=strip_tags($data->qty);		$thisorder=strip_tags($data->order);		$thisstore=strip_tags($data->store);		$thiscustomer=strip_tags($data->customer);		$thisinvdate=strip_tags($data->invdate);		$thiswho=strip_tags($data->who);		$thismemo=strip_tags($data->memo);		$thissent=strip_tags($data->sent);		$thislreg=strip_tags($data->lreg);		$thislstore=strip_tags($data->lstore);		$thisisdel=strip_tags($data->isdel);		$thiststamp=strip_tags($data->tstamp);		$stmt->bindParam(':series', $thisseries);		$stmt->bindParam(':snumber', $thissnumber);		$stmt->bindParam(':enumber', $thisenumber);		$stmt->bindParam(':qty', $thisqty);		$stmt->bindParam(':order', $thisorder);		$stmt->bindParam(':store', $thisstore);		$stmt->bindParam(':customer', $thiscustomer);		$stmt->bindParam(':invdate', $thisinvdate);		$stmt->bindParam(':who', $thiswho);		$stmt->bindParam(':memo', $thismemo);		$stmt->bindParam(':sent', $thissent);		$stmt->bindParam(':lreg', $thislreg);		$stmt->bindParam(':lstore', $thislstore);		$stmt->bindParam(':isdel', $thisisdel);		$stmt->bindParam(':tstamp', $thiststamp);		$stmt->execute();		} catch (PDOException $e) {			$message = $e->getMessage();			echo $message;		}		}		$spiritsEND=$db->commit();		if($spiritsEND==TRUE){			http_response_code(200);			echo json_encode(array("message" => "UPDATED.."));		}		else{			http_response_code(503);			echo json_encode(array("message" => "ERROR UPDATING!!"));			echo json_encode(array("error" =>$spiritsEND));		}?>