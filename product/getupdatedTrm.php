<?phpheader("Access-Control-Allow-Origin: *");header("Access-Control-Allow-Headers: access");header("Access-Control-Allow-Methods: GET");header("Access-Control-Allow-Credentials: true");header('Content-Type: application/json');include_once '../config/database.php';include_once '../config/core.php';include_once '../objects/spiritstrm.php';$database = new Database();$db = $database->getConnection();$product = new spiritsTrm($db);$getTstamp=isset($_GET['tstamp']) ? $_GET['tstamp'] : die();$stmt = $product->getUpdatedTrm($getTstamp,$startingRecord,$records_per_page);$num = $stmt->rowCount();if($num>0){    $products_arr=array();    $products_arr["records"]=array();    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){		extract($row);		$product_item=array(		"terms" => $terms,		"descript" => $descript,		"priority" => $priority,		"invoice" => $invoice,		"credit" => $credit,		"purchase" => $purchase,		"vcredit" => $vcredit,		"netdays" => $netdays,		"billby" => $billby,		"dueday1" => $dueday1,		"dueday2" => $dueday2,		"who" => $who,		"sent" => $sent,		"lreg" => $lreg,		"lstore" => $lstore,		"tstamp" => $tstamp,		"isdel" => $isdel       );        array_push($products_arr["records"], $product_item);    }		http_response_code(200);		echo json_encode($products_arr);	}else{		http_response_code(404);		echo json_encode(		array("message" => "NOT FOUND.")	);}?>