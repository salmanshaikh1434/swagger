<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();


$bulk = json_decode(file_get_contents("php://input"));
$stmt = $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->beginTransaction();

foreach ($bulk->records as $data) {

	try {
		$query = "INSERT INTO glb (`glaccount`,`date`,`store`,`department`,`edate`,`lamount`,`ramount`,`balance`,`records`,`freeze`,`who`,`transact`,`consol`,`sent`,`tstamp`,`isdel`,`lreg`,`lstore`)
			VALUES 
		(:glaccount,:date,:store,:department,:edate,:lamount,:ramount,:balance,:records,:freeze,:who,:transact,:consol,:sent,:tstamp,0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		`glaccount` = :glaccount,
		`date` = :date,
		`store` = :store,
		`department` = :department,
		`edate` = :edate,
		`lamount` = :lamount,
		`ramount` = :ramount,
		`balance` = :balance,
		`records` = :records,
		`freeze` = :freeze,
		`who` = :who,
		`transact` = :transact,
		`consol` = :consol,
		`sent` = :sent,
		`tstamp` = :tstamp,
		`lstore` = :lstore,
		`lreg` = :lreg";
		// `isdel` = :isdel";

		$stmt = $db->prepare($query);
		$thisglaccount = strip_tags($data->glaccount);
		$thisdate = strip_tags($data->date);
		$thisstore = strip_tags($data->store);
		$thisdepartment = strip_tags($data->department);
		$thisedate = strip_tags($data->edate);
		$thislamount = strip_tags($data->lamount);
		$thisramount = strip_tags($data->ramount);
		$thisbalance = strip_tags($data->balance);
		$thisrecords = strip_tags($data->records);
		$thisfreeze = strip_tags($data->freeze);
		$thiswho = strip_tags($data->who);
		$thistransact = strip_tags($data->transact);
		$thisconsol = strip_tags($data->consol);
		$thissent = strip_tags($data->sent);
		$thislreg = strip_tags($data->lreg);
		$thislstore = strip_tags($data->lstore);
		// $thisisdel=strip_tags($data->isdel);
		$thiststamp = strip_tags($data->tstamp);


		$stmt->bindParam(':glaccount', $thisglaccount);
		$stmt->bindParam(':date', $thisdate);
		$stmt->bindParam(':store', $thisstore);
		$stmt->bindParam(':department', $thisdepartment);
		$stmt->bindParam(':edate', $thisedate);
		$stmt->bindParam(':lamount', $thislamount);
		$stmt->bindParam(':ramount', $thisramount);
		$stmt->bindParam(':balance', $thisbalance);
		$stmt->bindParam(':records', $thisrecords);
		$stmt->bindParam(':freeze', $thisfreeze);
		$stmt->bindParam(':who', $thiswho);
		$stmt->bindParam(':transact', $thistransact);
		$stmt->bindParam(':consol', $thisconsol);
		$stmt->bindParam(':sent', $thissent);
		$stmt->bindParam(':lreg', $thislreg);
		$stmt->bindParam(':lstore', $thislstore);
		// $stmt->bindParam(':isdel', $thisisdel);
		$stmt->bindParam(':tstamp', $thiststamp);

		$stmt->execute();
	} catch (PDOException $e) {
		$message = $e->getMessage();
		echo $message;
	}

}
$spiritsEND = $db->commit();
if ($spiritsEND == TRUE) {
	http_response_code(200);
	echo json_encode(array("message" => "UPDATED.."));
} else {
	http_response_code(503);
	echo json_encode(array("message" => "ERROR UPDATING!!"));
	echo json_encode(array("error" => $spiritsEND));
}
?>