<?phpheader("Access-Control-Allow-Origin: *");header("Access-Control-Allow-Headers: access");header("Access-Control-Allow-Methods: GET");header("Access-Control-Allow-Credentials: true");header("Content-Type: application/json");include_once '../config/database.php';include_once '../config/core.php';include_once '../objects/spiritsStk.php';$database = new Database();$db = $database->getConnection();$product = new spiritsStk($db);$getsku = isset($_GET["sku"]) ? $_GET["sku"] : 0;$stmt = $product->getStk($getsku,$records_per_page);$num = $stmt->rowCount();if($num>0){    $products_arr=array();    $products_arr["records"]=array();    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){		extract($row);		$product_item=array(		"sku" => $sku,		"store" => $store,		"floor" => $floor,		"back" => $back,		"shipped" => $shipped,		"kits" => $kits,		"stat" => $stat,		"mtd_units" => $mtd_units,		"weeks" => $weeks,		"sdate" => $sdate,		"mtd_dol" => $mtd_dol,		"mtd_prof" => $mtd_prof,		"ytd_units" => $ytd_units,		"ytd_dol" => $ytd_dol,		"ytd_prof" => $ytd_prof,		"acost" => $acost,		"lcost" => $lcost,		"pvend" => $pvend,		"lvend" => $lvend,		"pdate" => $pdate,		"smin" => $smin,		"sord" => $sord,		"sweeks" => $sweeks,		"freeze_w" => $freeze_w,		"shelf" => $shelf,		"rshelf" => $rshelf,		"sloc" => $sloc,		"bloc" => $bloc,		"who" => $who,		"inet" => $inet,		"depos" => $depos,		"skipstat" => $skipstat,		"mincost" => $mincost,		"base" => $base,		"sent" => $sent,		"ware" => $ware,		"vintage" => $vintage,		"gosent" => $gosent,		"lreg" => $lreg,		"lstore" => $lstore,		"isdel" => $isdel       );        array_push($products_arr["records"], $product_item);    }		http_response_code(200);		echo json_encode($products_arr);	}else{		http_response_code(404);		echo json_encode(		array("message" => "NOT FOUND.")	);}?>