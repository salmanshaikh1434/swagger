<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritsemp{
	private $conn;
	protected $key = '0987654321!@#$';


	public function __construct($db){
		$this->conn = $db;
	}
	/**
	 * @OA\Get(
	 *   tags={"readEmp"},
	 *   path="/apidb/product/readEmp.php",
	 *   summary="get attribute data by id",
	 *   @OA\Parameter(
	 *     name="id", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by id",
	 *     @OA\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found"),
	 *   security={ {"bearerToken": {}}}
	 * )
	 */
	function readEmp($getid){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from emp where emp.id = '$getid' and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	} else {
		return false;
	}
} else {
	return false;
}
	}
	
/**
	 * @OA\Get(
	 *   tags={"getUpdatedEmp"},
	 *   path="/apidb/product/getUpdatedEmp.php",
	 *   summary="get attribute data by tstamp",
	 *   @OA\Parameter(
	 *     name="tstamp", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by tstamp",
	 *     @OA\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found"),
	 *   security={ {"bearerToken": {}}}
	 * )
	 */
	function getUpdatedEmp($getTstamp,$startingRecord,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from emp where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	} else {
		return false;
	}
} else {
	return false;
}
	}
/**
	 * @OA\Get(
	 *   tags={"getEmp"},
	 *   path="/apidb/product/getEmp.php",
	 *   summary="get attribute data by id",
	 *   @OA\Parameter(
	 *     name="id", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata  by id",
	 *     @OA\Schema(
	 *       type="string"
	 *     )
	 *   ),
	 *   @OA\Response(response=200, description="OK"),
	 *   @OA\Response(response=401, description="Unauthorized"),
	 *   @OA\Response(response=404, description="Not Found"),
	 *   security={ {"bearerToken": {}}}
	 * )
	 */
	function getEmp(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
			$query = "select * from emp where isdel = 0";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	} else {
		return false;
	}
} else {
	return false;
}
	}
	/**
 * @OA\Post(
 *   path="/apidb/product/updateEmp.php",
 *   summary="Update emp",
 *   tags={"updateEmp"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="id",
 *           type="string",
 *           example="101"
 *         ),
 *         @OA\Property(
 *           property="uid",
 *           type="string",
 *           example="CSH"
 *         ),
 *         @OA\Property(
 *           property="last_name",
 *           type="string",
 *           example="Cashier"
 *         ),
 *         @OA\Property(
 *           property="first_name",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="store",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="title",
 *           type="string",
 *           example="Cashier"
 *         ),
 *         @OA\Property(
 *           property="street1",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="street2",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="city",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="state",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="zip",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="homephone",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="workphone",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="carphone",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="fax",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="password",
 *           type="string",
 *           example="üüú"
 *         ),
 *         @OA\Property(
 *           property="security",
 *           type="string",
 *           example="N"
 *         ),
 *         @OA\Property(
 *           property="poslevel",
 *           type="string",
 *           example="3"
 *         ),
 *         @OA\Property(
 *           property="invlevel",
 *           type="string",
 *           example="3"
 *         ),
 *         @OA\Property(
 *           property="actlevel",
 *           type="string",
 *           example="3"
 *         ),
 *         @OA\Property(
 *           property="admlevel",
 *           type="string",
 *           example="3"
 *         ),
 *         @OA\Property(
 *           property="hire_date",
 *           type="string",
 *           example="0000-00-00"
 *         ),
 *         @OA\Property(
 *           property="birth_date",
 *           type="string",
 *           example="0000-00-00"
 *         ),
 *         @OA\Property(
 *           property="last_raise",
 *           type="string",
 *           example="0000-00-00"
 *         ),
 *         @OA\Property(
 *           property="ssn",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="notes",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="who",
 *           type="string",
 *           example="GGP"
 *         ),
 *         @OA\Property(
 *           property="lastlogin",
 *           type="string",
 *           example="0000-00-00 00:00:00"
 *         ),
 *         @OA\Property(
 *           property="payrate",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="terminate",
 *           type="string",
 *           example="0000-00-00"
 *         ),
 *         @OA\Property(
 *           property="eserver",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="euser",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="epass",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="port",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="ssl",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="auth",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="from",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="sent",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="email",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="cardnum",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="memo",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="pws",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="lreg",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="lstore",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="isdel",
 *           type="string",
 *           example="0"
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="OK"
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Unauthorized"
 *   ),
 *   @OA\Response(
 *     response=404,
 *     description="Not Found"
 *   ),
 *   security={ {"bearerToken": {}} }
 * )
 */


	function updateEmp(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "insert into emp (id,uid,last_name,first_name,store,title,street1,street2,city,state,zip,homephone,workphone,carphone,fax,password,security,poslevel,invlevel,actlevel,admlevel,hire_date,birth_date,last_raise,ssn,notes,who,lastlogin,payrate,terminate,eserver,euser,epass,port,`ssl`,auth,`from`,sent,email,cardnum,memo,pws,tstamp,isdel,lreg,lstore)
			VALUES 
		(:id,:uid,:last_name,:first_name,:store,:title,:street1,:street2,:city,:state,:zip,:homephone,:workphone,:carphone,:fax,:password,:security,:poslevel,:invlevel,:actlevel,:admlevel,:hire_date,:birth_date,:last_raise,:ssn,:notes,:who,:lastlogin,:payrate,:terminate,:eserver,:euser,:epass,:port,:ssl,:auth,:from,:sent,:email,:cardnum,:memo,:pws,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		uid = :uid,
		last_name = :last_name,
		first_name = :first_name,
		store = :store,
		title = :title,
		street1 = :street1,
		street2 = :street2,
		city = :city,
		state = :state,
		zip = :zip,
		homephone = :homephone,
		workphone = :workphone,
		carphone = :carphone,
		fax = :fax,
		password = :password,
		security = :security,
		poslevel = :poslevel,
		invlevel = :invlevel,
		actlevel = :actlevel,
		admlevel = :admlevel,
		hire_date = :hire_date,
		birth_date = :birth_date,
		last_raise = :last_raise,
		ssn = :ssn,
		notes = :notes,
		who = :who,
		lastlogin = :lastlogin,
		payrate = :payrate,
		terminate = :terminate,
		eserver = :eserver,
		euser = :euser,
		epass = :epass,
		port = :port,
		`ssl` = :ssl,
		auth = :auth,
		`from` = :from,
		sent = :sent,
		email = :email,
		cardnum = :cardnum,
		memo = :memo,
		pws = :pws,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->id=htmlspecialchars(strip_tags($this->id));
		$this->uid=htmlspecialchars(strip_tags($this->uid));
		$this->last_name=htmlspecialchars(strip_tags($this->last_name));
		$this->first_name=htmlspecialchars(strip_tags($this->first_name));
		$this->store=htmlspecialchars(strip_tags($this->store));
		$this->title=htmlspecialchars(strip_tags($this->title));
		$this->street1=htmlspecialchars(strip_tags($this->street1));
		$this->street2=htmlspecialchars(strip_tags($this->street2));
		$this->city=htmlspecialchars(strip_tags($this->city));
		$this->state=htmlspecialchars(strip_tags($this->state));
		$this->zip=htmlspecialchars(strip_tags($this->zip));
		$this->homephone=htmlspecialchars(strip_tags($this->homephone));
		$this->workphone=htmlspecialchars(strip_tags($this->workphone));
		$this->carphone=htmlspecialchars(strip_tags($this->carphone));
		$this->fax=htmlspecialchars(strip_tags($this->fax));
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->security=htmlspecialchars(strip_tags($this->security));
		$this->poslevel=htmlspecialchars(strip_tags($this->poslevel));
		$this->invlevel=htmlspecialchars(strip_tags($this->invlevel));
		$this->actlevel=htmlspecialchars(strip_tags($this->actlevel));
		$this->admlevel=htmlspecialchars(strip_tags($this->admlevel));
		$this->hire_date=htmlspecialchars(strip_tags($this->hire_date));
		$this->birth_date=htmlspecialchars(strip_tags($this->birth_date));
		$this->last_raise=htmlspecialchars(strip_tags($this->last_raise));
		$this->ssn=htmlspecialchars(strip_tags($this->ssn));
		$this->notes=htmlspecialchars(strip_tags($this->notes));
		$this->who=htmlspecialchars(strip_tags($this->who));
		$this->lastlogin=htmlspecialchars(strip_tags($this->lastlogin));
		$this->payrate=htmlspecialchars(strip_tags($this->payrate));
		$this->terminate=htmlspecialchars(strip_tags($this->terminate));
		$this->eserver=htmlspecialchars(strip_tags($this->eserver));
		$this->euser=htmlspecialchars(strip_tags($this->euser));
		$this->epass=htmlspecialchars(strip_tags($this->epass));
		$this->port=htmlspecialchars(strip_tags($this->port));
		$this->ssl=htmlspecialchars(strip_tags($this->ssl));
		$this->auth=htmlspecialchars(strip_tags($this->auth));
		$this->from=htmlspecialchars(strip_tags($this->from));
		$this->sent=htmlspecialchars(strip_tags($this->sent));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->cardnum=htmlspecialchars(strip_tags($this->cardnum));
		$this->memo=htmlspecialchars(strip_tags($this->memo));
		$this->pws=htmlspecialchars(strip_tags($this->pws));
		$this->lreg=htmlspecialchars(strip_tags($this->lreg));
		$this->lstore=htmlspecialchars(strip_tags($this->lstore));
		$this->isdel=htmlspecialchars(strip_tags($this->isdel));

		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':uid', $this->uid);
		$stmt->bindParam(':last_name', $this->last_name);
		$stmt->bindParam(':first_name', $this->first_name);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':title', $this->title);
		$stmt->bindParam(':street1', $this->street1);
		$stmt->bindParam(':street2', $this->street2);
		$stmt->bindParam(':city', $this->city);
		$stmt->bindParam(':state', $this->state);
		$stmt->bindParam(':zip', $this->zip);
		$stmt->bindParam(':homephone', $this->homephone);
		$stmt->bindParam(':workphone', $this->workphone);
		$stmt->bindParam(':carphone', $this->carphone);
		$stmt->bindParam(':fax', $this->fax);
		$stmt->bindParam(':password', $this->password);
		$stmt->bindParam(':security', $this->security);
		$stmt->bindParam(':poslevel', $this->poslevel);
		$stmt->bindParam(':invlevel', $this->invlevel);
		$stmt->bindParam(':actlevel', $this->actlevel);
		$stmt->bindParam(':admlevel', $this->admlevel);
		$stmt->bindParam(':hire_date', $this->hire_date);
		$stmt->bindParam(':birth_date', $this->birth_date);
		$stmt->bindParam(':last_raise', $this->last_raise);
		$stmt->bindParam(':ssn', $this->ssn);
		$stmt->bindParam(':notes', $this->notes);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':lastlogin', $this->lastlogin);
		$stmt->bindParam(':payrate', $this->payrate);
		$stmt->bindParam(':terminate', $this->terminate);
		$stmt->bindParam(':eserver', $this->eserver);
		$stmt->bindParam(':euser', $this->euser);
		$stmt->bindParam(':epass', $this->epass);
		$stmt->bindParam(':port', $this->port);
		$stmt->bindParam(':ssl', $this->ssl);
		$stmt->bindParam(':auth', $this->auth);
		$stmt->bindParam(':from', $this->from);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':cardnum', $this->cardnum);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':pws', $this->pws);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);


		if($stmt->execute()){	
			return 'OK';
		}else{
			$stmtError = $stmt->errorInfo();
		return $stmtError;
		}
	} else {
		return false;
	}
} else {
	return false;
}
	}
}
		
?>
