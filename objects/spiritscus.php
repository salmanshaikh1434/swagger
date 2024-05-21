<?php
error_reporting(E_ALL);
ini_set('display_error', 1);
require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');

use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritscus{
	private $conn;
	protected $key = '0987654321!@#$';


	public function __construct($db){
		$this->conn = $db;
	}
  /**
	 * @OA\Get(
	 *   tags={"readCus"},
	 *   path="/apidb/product/readCus.php",
	 *   summary="Get customer",
	 *   @OA\Parameter(
	 *     name="customer", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata by customer",
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
	function readCus($getcustomer){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from cus where `customer` = $getcustomer";
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


	function getUpdatedCus($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from cus where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}
  /**
	 * @OA\Get(
	 *   tags={"getCus"},
	 *   path="/apidb/product/getCus.php",
	 *   summary="Get customer",
	 *   @OA\Parameter(
	 *     name="customer", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata by customer",
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
	function getCus($getcustomer,$records_per_page){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
			$query = "select * from cus where cus.customer >= $getcustomer and isdel = 0 order by customer LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
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
	 *   tags={"getLastCus"},
	 *   path="/apidb/product/getLastCus.php",
	 *   summary="Get customer",
	 *   @OA\Parameter(
	 *     name="customer", 
	 *     in="query", 
	 *     required=false, 
	 *     description="getdata by customer",
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

	Function getLastCus($getStore){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		/*select max(customer) as mcus from cus where BETWEEN(customer,startrec,endrec) into cursor ctmp*/
		$query = "select max(`customer`) as cusnum from cus where (`customer` not between 999000 and 999999) and `customer` < (($getStore+1)*10000000)";
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
	
	function getUpdatedFS($getCustomer){
		$query = "select fson,fscpts,fstpts,fsdlrval,fsdlrcrdts from cus where cus.customer = $getCustomer and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	
	function updateFS($thisCredorpts){
		$product->dcredits = $data->dcredits;
		$product->credorpts = $data->credorpts;
		$product->store = $data->store;
		$product->lreg = $data->lreg;
		$product->sale = $data->sale;
		$product->sdate = $data->sdate;
		$product->customer = $data->customer;
		$product->who = $data->who;
		$product->saletotal = $data->saletotal;
		
		if($thisCredorpts == 'C'){
			$query ="insert into fshst (date,storeno,saleno,custid,dcredits,who,tstamp,lstore,lreg,timestamp,credorpts,sent,type,olddcredit,newdcredit) values	
					(:sdate,:store,:sale,:customer,:dcredits,:who,now(),:store,:lreg,now(),0,0,'S',$thisFsdlrcrdts,$thisFsdlrcrdts+$thisDcredits)";
		}else{
			$query ="insert into fshst (date,storeno,saleno,custid,dcredits,who,tstamp,lstore,lreg,timestamp,credorpts,sent,type,olddcredit,newdcredit) values	
					(ctod('$thisDate'),$thisStore,$thisSale,$thisCustomer,$thisDcredits,'$thiswho',datetime(),$thisStore,$thisLreg,datetime(),.T.,.F.,'S',$thisFscpts,$thisFscpts+$thisDcredits)";
		}
		
		$stmt2->execute();
		
		if($thisCredorpts == 'C'){
			$query = "update cus set cus.fsdlrcrdts = cus.fsdlrcrdts + :dcredits,cus.fsdlrcrdts = cus.fsdlrcrdts + $thisSaleTotal,cus.who = :who, cus.tstamp = now() where cus.customer = $thisCustomer";
		}else{
			$query = "update cus set cus.fscpts = cus.fscpts + :dcredits,cus.fstpts = cus.fstpts + :dcredits,cus.FSDLRVAL = cus.fsdlrcrdts + :totalsale, cus.who = :who, cus.sent = .F., cus.tstamp = datetime() where cus.customer = $thisCustomer";
			}
		$stmt = $this->conn->prepare($query);
		
		if($stmt->execute()){	
			return 'OK';
		}else{
			$stmtError = $stmt->errorInfo();
		return $stmtError;
		}
	}
	/**
 * @OA\Post(
 *   path="/apidb/product/updateCus.php",
 *   summary="Update customer information",
 *   tags={"UpdateCus"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="customer",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="firstname",
 *           type="string",
 *           example="Terry"
 *         ),
 *         @OA\Property(
 *           property="lastname",
 *           type="string",
 *           example="Canup"
 *         ),
 *         @OA\Property(
 *           property="status",
 *           type="string",
 *           example=""
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
 *           property="contact",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="phone",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="fax",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="modem",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="startdate",
 *           type="string",
 *           example="2022-08-16"
 *         ),
 *         @OA\Property(
 *           property="taxcode",
 *           type="string",
 *           example="MASTAX"
 *         ),
 *         @OA\Property(
 *           property="terms",
 *           type="string",
 *           example="COD"
 *         ),
 *         @OA\Property(
 *           property="shipvia",
 *           type="string",
 *           example="UPS"
 *         ),
 *         @OA\Property(
 *           property="statement",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="crdlimit",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="balance",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="store",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="salesper",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="clubcard",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="clublist",
 *           type="string",
 *           example="WHOLESALE"
 *         ),
 *         @OA\Property(
 *           property="clubdisc",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="altid",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="types",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="department",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="who",
 *           type="string",
 *           example="S2K"
 *         ),
 *         @OA\Property(
 *           property="memo",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="storelevel",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="billto",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="wslicense",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="wsexpire",
 *           type="string",
 *           example="0000-00-00"
 *         ),
 *         @OA\Property(
 *           property="wetdry",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="taxid",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="invoicemsg",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="statementm",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="territory",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="filter",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="email",
 *           type="string",
 *           example="terry.c@atlanticsystemsinc.com"
 *         ),
 *         @OA\Property(
 *           property="sflag",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="fcflag",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="printbal",
 *           type="string",
 *           example="1"
 *         ),
 *         @OA\Property(
 *           property="cdate",
 *           type="string",
 *           example="0000-00-00"
 *         ),
 *         @OA\Property(
 *           property="scldate",
 *           type="string",
 *           example="0000-00-00"
 *         ),
 *         @OA\Property(
 *           property="fson",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="fscpts",
 *           type="string",
 *           example="0.00"
 *         ),
 *         @OA\Property(
 *           property="fstpts",
 *           type="string",
 *           example="0.00"
 *         ),
 *         @OA\Property(
 *           property="fsdlrval",
 *           type="string",
 *           example="0.00"
 *         ),
 *         @OA\Property(
 *           property="fsdlrcrdts",
 *           type="string",
 *           example="0.00"
 *         ),
 *         @OA\Property(
 *           property="creditcard",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="expire",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="cvv",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="sent",
 *           type="string",
 *           example="0"
 *         ),
 *         @OA\Property(
 *           property="wphone",
 *           type="string",
 *           example=""
 *         ),
 *         @OA\Property(
 *           property="fsfactor",
 *           type="string",
 *           example="0.0"
 *         ),
 *         @OA\Property(
 *           property="webcustid",
 *           type="string",
 *           example=null
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
 *         ),
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
 *   security={ {"bearerToken": {}}}
 * )
 */

	function updateCus(){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "INSERT INTO cus (customer,firstname,lastname,status,street1,street2,city,state,zip,contact,phone,fax,modem,startdate,taxcode,terms,shipvia,statement,crdlimit,balance,store,salesper,clubcard,clublist,clubdisc,altid,types,department,who,memo,storelevel,billto,wslicense,wsexpire,wetdry,taxid,invoicemsg,statementm,territory,filter,email,sflag,fcflag,printbal,cdate,scldate,fson,fscpts,fstpts,fsdlrval,fsdlrcrdts,creditcard,expire,cvv,sent,wphone,fsfactor,tstamp,isdel,lreg,lstore,webcustid)
			VALUES 
		(:customer,:firstname,:lastname,:status,:street1,:street2,:city,:state,:zip,:contact,:phone,:fax,:modem,:startdate,:taxcode,:terms,:shipvia,:statement,:crdlimit,:balance,:store,:salesper,:clubcard,:clublist,:clubdisc,:altid,:types,:department,:who,:memo,:storelevel,:billto,:wslicense,:wsexpire,:wetdry,:taxid,:invoicemsg,:statementm,:territory,:filter,:email,:sflag,:fcflag,:printbal,:cdate,:scldate,:fson,:fscpts,:fstpts,:fsdlrval,:fsdlrcrdts,:creditcard,:expire,:cvv,:sent,:wphone,:fsfactor,now(),0,:lreg,:lstore,:webcustid)
		ON DUPLICATE KEY UPDATE
		firstname = :firstname,
		lastname = :lastname,
		status = :status,
		street1 = :street1,
		street2 = :street2,
		city = :city,
		state = :state,
		zip = :zip,
		contact = :contact,
		phone = :phone,
		fax = :fax,
		modem = :modem,
		startdate = :startdate,
		taxcode = :taxcode,
		terms = :terms,
		shipvia = :shipvia,
		statement = :statement,
		crdlimit = :crdlimit,
		balance = :balance,
		store = :store,
		salesper = :salesper,
		clubcard = :clubcard,
		clublist = :clublist,
		clubdisc = :clubdisc,
		altid = :altid,
		types = :types,
		department = :department,
		who = :who,
		memo = :memo,
		storelevel = :storelevel,
		billto = :billto,
		wslicense = :wslicense,
		wsexpire = :wsexpire,
		wetdry = :wetdry,
		taxid = :taxid,
		invoicemsg = :invoicemsg,
		statementm = :statementm,
		territory = :territory,
		filter = :filter,
		email = :email,
		sflag = :sflag,
		fcflag = :fcflag,
		printbal = :printbal,
		cdate = :cdate,
		scldate = :scldate,
		fson = :fson,
		fscpts = :fscpts,
		fstpts = :fstpts,
		fsdlrval = :fsdlrval,
		fsdlrcrdts = :fsdlrcrdts,
		creditcard = :creditcard,
		expire = :expire,
		cvv = :cvv,
		sent = :sent,
		wphone = :wphone,
		fsfactor = :fsfactor,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		webcustid= :webcustid,
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->customer=strip_tags($this->customer);
		$this->firstname=strip_tags($this->firstname);
		$this->lastname=strip_tags($this->lastname);
		$this->status=strip_tags($this->status);
		$this->street1=strip_tags($this->street1);
		$this->street2=strip_tags($this->street2);
		$this->city=strip_tags($this->city);
		$this->state=strip_tags($this->state);
		$this->zip=strip_tags($this->zip);
		$this->contact=strip_tags($this->contact);
		$this->phone=strip_tags($this->phone);
		$this->fax=strip_tags($this->fax);
		$this->modem=strip_tags($this->modem);
		$this->startdate=strip_tags($this->startdate);
		$this->taxcode=strip_tags($this->taxcode);
		$this->terms=strip_tags($this->terms);
		$this->shipvia=strip_tags($this->shipvia);
		$this->statement=strip_tags($this->statement);
		$this->crdlimit=strip_tags($this->crdlimit);
		$this->balance=strip_tags($this->balance);
		$this->store=strip_tags($this->store);
		$this->salesper=strip_tags($this->salesper);
		$this->clubcard=strip_tags($this->clubcard);
		$this->clublist=strip_tags($this->clublist);
		$this->clubdisc=strip_tags($this->clubdisc);
		$this->altid=strip_tags($this->altid);
		$this->types=strip_tags($this->types);
		$this->department=strip_tags($this->department);
		$this->who=strip_tags($this->who);
		$this->memo=strip_tags($this->memo);
		$this->storelevel=strip_tags($this->storelevel);
		$this->billto=strip_tags($this->billto);
		$this->wslicense=strip_tags($this->wslicense);
		$this->wsexpire=strip_tags($this->wsexpire);
		$this->wetdry=strip_tags($this->wetdry);
		$this->taxid=strip_tags($this->taxid);
		$this->invoicemsg=strip_tags($this->invoicemsg);
		$this->statementm=strip_tags($this->statementm);
		$this->territory=strip_tags($this->territory);
		$this->filter=strip_tags($this->filter);
		$this->email=strip_tags($this->email);
		$this->sflag=strip_tags($this->sflag);
		$this->fcflag=strip_tags($this->fcflag);
		$this->printbal=strip_tags($this->printbal);
		$this->cdate=strip_tags($this->cdate);
		$this->scldate=strip_tags($this->scldate);
		$this->fson=strip_tags($this->fson);
		$this->fscpts=strip_tags($this->fscpts);
		$this->fstpts=strip_tags($this->fstpts);
		$this->fsdlrval=strip_tags($this->fsdlrval);
		$this->fsdlrcrdts=strip_tags($this->fsdlrcrdts);
		$this->creditcard=strip_tags($this->creditcard);
		$this->expire=strip_tags($this->expire);
		$this->cvv=strip_tags($this->cvv);
		$this->sent=strip_tags($this->sent);
		$this->wphone=strip_tags($this->wphone);
		$this->webcustid=strip_tags($this->webcustid);
		$this->fsfactor=strip_tags($this->fsfactor);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':customer', $this->customer);
		$stmt->bindParam(':firstname', $this->firstname);
		$stmt->bindParam(':lastname', $this->lastname);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':street1', $this->street1);
		$stmt->bindParam(':street2', $this->street2);
		$stmt->bindParam(':city', $this->city);
		$stmt->bindParam(':state', $this->state);
		$stmt->bindParam(':zip', $this->zip);
		$stmt->bindParam(':contact', $this->contact);
		$stmt->bindParam(':phone', $this->phone);
		$stmt->bindParam(':fax', $this->fax);
		$stmt->bindParam(':modem', $this->modem);
		$stmt->bindParam(':startdate', $this->startdate);
		$stmt->bindParam(':taxcode', $this->taxcode);
		$stmt->bindParam(':terms', $this->terms);
		$stmt->bindParam(':shipvia', $this->shipvia);
		$stmt->bindParam(':statement', $this->statement);
		$stmt->bindParam(':crdlimit', $this->crdlimit);
		$stmt->bindParam(':balance', $this->balance);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':salesper', $this->salesper);
		$stmt->bindParam(':clubcard', $this->clubcard);
		$stmt->bindParam(':clublist', $this->clublist);
		$stmt->bindParam(':clubdisc', $this->clubdisc);
		$stmt->bindParam(':altid', $this->altid);
		$stmt->bindParam(':types', $this->types);
		$stmt->bindParam(':department', $this->department);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':storelevel', $this->storelevel);
		$stmt->bindParam(':billto', $this->billto);
		$stmt->bindParam(':wslicense', $this->wslicense);
		$stmt->bindParam(':wsexpire', $this->wsexpire);
		$stmt->bindParam(':wetdry', $this->wetdry);
		$stmt->bindParam(':taxid', $this->taxid);
		$stmt->bindParam(':invoicemsg', $this->invoicemsg);
		$stmt->bindParam(':statementm', $this->statementm);
		$stmt->bindParam(':territory', $this->territory);
		$stmt->bindParam(':filter', $this->filter);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':sflag', $this->sflag);
		$stmt->bindParam(':fcflag', $this->fcflag);
		$stmt->bindParam(':printbal', $this->printbal);
		$stmt->bindParam(':cdate', $this->cdate);
		$stmt->bindParam(':scldate', $this->scldate);
		$stmt->bindParam(':fson', $this->fson);
		$stmt->bindParam(':fscpts', $this->fscpts);
		$stmt->bindParam(':fstpts', $this->fstpts);
		$stmt->bindParam(':fsdlrval', $this->fsdlrval);
		$stmt->bindParam(':fsdlrcrdts', $this->fsdlrcrdts);
		$stmt->bindParam(':creditcard', $this->creditcard);
		$stmt->bindParam(':expire', $this->expire);
		$stmt->bindParam(':cvv', $this->cvv);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':wphone', $this->wphone);
		$stmt->bindParam(':webcustid', $this->webcustid);
		$stmt->bindParam(':fsfactor', $this->fsfactor);
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