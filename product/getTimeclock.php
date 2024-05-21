<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../config/core.php';
include_once '../objects/spiritstimeclock.php';

$database = new Database();
$db = $database->getConnection();

$clock = new spiritstimeclock($db);

$getTstamp=isset($_GET['tstamp']) ? $_GET['tstamp'] : die();
$stmt = $clock->getupdatedTimeclock($getTstamp, $startingRecord, $records_per_page);
$num = $stmt->rowCount();

if($num>0){

    $clock_arr=array();
    $clock_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

		extract($row);

		$clock_item=array(
		"timeid" => $timeid,
		"loginid" => $loginid,
		"logindate" => $logindate,
		"loginstatus" => $logstatus,
		"logintime" => $logintime,
		"logouttime" => $logouttime,
		"store" => $store,
		"who" => $who,
		"sent" => $sent,
		"tstamp" => $tstamp,
		"isdel" => $isdel

       );

        array_push($clock_arr["records"], $clock_item);
    }
		http_response_code(200);
		echo json_encode($clock_arr);
	}else{
		http_response_code(404);
		echo json_encode(
		array("message" => "NOT FOUND.")
	);
}
?>
