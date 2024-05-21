<?php	header("Access-Control-Allow-Origin: *");	header("Content-Type: application/json; charset=UTF-8");	header("Access-Control-Allow-Methods: POST");	header("Access-Control-Max-Age: 3600");	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");	include_once '../config/database.php';	$database = new Database();	$db = $database->getConnection();	$bulk = json_decode(file_get_contents("php://input"));	$stmt = $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	$stmt = $db->beginTransaction(); 	foreach($bulk->records as $data){		try {		$query = "INSERT INTO pwd (`class`,`event`,`ask_level`,`do_level`,`question`,`scoptosale`,`who`,`parent`,`key`,`image`,`descript`,`editable`,`sent`,`tstamp`,`isdel`,`lreg`,`lstore`)			VALUES 		(:class,:event,:ask_level,:do_level,:question,:scoptosale,:who,:parent,:key,:image,:descript,:editable,:sent,now(),0,:lreg,:lstore)		ON DUPLICATE KEY UPDATE		`class` = :class,		`event` = :event,		`ask_level` = :ask_level,		`do_level` = :do_level,		`question` = :question,		`scoptosale` = :scoptosale,		`who` = :who,		`parent` = :parent,		`key` = :key,		`image` = :image,		`descript` = :descript,		`editable` = :editable,		`sent` = :sent,		`tstamp` = NOW(),		`lstore` = :lstore,		`lreg` = :lreg,		`isdel` = :isdel";		$stmt = $db->prepare($query);		$thisclass=strip_tags($data->class);		$thisevent=strip_tags($data->event);		$thisask_level=strip_tags($data->ask_level);		$thisdo_level=strip_tags($data->do_level);		$thisquestion=strip_tags($data->question);		$thisscoptosale=strip_tags($data->scoptosale);		$thiswho=strip_tags($data->who);		$thisparent=strip_tags($data->parent);		$thiskey=strip_tags($data->key);		$thisimage=strip_tags($data->image);		$thisdescript=strip_tags($data->descript);		$thiseditable=strip_tags($data->editable);		$thissent=strip_tags($data->sent);		$thislreg=strip_tags($data->lreg);		$thislstore=strip_tags($data->lstore);		$thisisdel=strip_tags($data->isdel);		$thiststamp=strip_tags($data->tstamp);		$stmt->bindParam(':class', $thisclass);		$stmt->bindParam(':event', $thisevent);		$stmt->bindParam(':ask_level', $thisask_level);		$stmt->bindParam(':do_level', $thisdo_level);		$stmt->bindParam(':question', $thisquestion);		$stmt->bindParam(':scoptosale', $thisscoptosale);		$stmt->bindParam(':who', $thiswho);		$stmt->bindParam(':parent', $thisparent);		$stmt->bindParam(':key', $thiskey);		$stmt->bindParam(':image', $thisimage);		$stmt->bindParam(':descript', $thisdescript);		$stmt->bindParam(':editable', $thiseditable);		$stmt->bindParam(':sent', $thissent);		$stmt->bindParam(':lreg', $thislreg);		$stmt->bindParam(':lstore', $thislstore);		$stmt->bindParam(':isdel', $thisisdel);		$stmt->bindParam(':tstamp', $thiststamp);		$stmt->execute();		} catch (PDOException $e) {			$message = $e->getMessage();			echo $message;		}		}		$spiritsEND=$db->commit();		if($spiritsEND==TRUE){			http_response_code(200);			echo json_encode(array("message" => "UPDATED.."));		}		else{			http_response_code(503);			echo json_encode(array("message" => "ERROR UPDATING!!"));			echo json_encode(array("error" =>$spiritsEND));		}?>