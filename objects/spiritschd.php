<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

require ($_SERVER['DOCUMENT_ROOT'] . '/apidb/vendor/autoload.php');


use OpenApi\Annotations as OA;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class spiritschd{
	private $conn;
	protected $key = '0987654321!@#$';


	public function __construct($db){
		$this->conn = $db;
	}
	/**
	 * @OA\Get(
	 *   tags={"readChd"},
	 *   path="/apidb/product/readChd.php",
	 *   summary="get attribute data by Chd",
	 *   @OA\Parameter(
	 *     name="chd", 
	 *     in="query", 
	 *     required=true, 
	 *     description="getdata  by Chd",
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
	function readChd($getbankacct){
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_ireplace('Bearer ', '', $headers['Authorization']);

			$decoded = JWT::decode($token, new Key($this->key, 'HS256'));
			if (isset($decoded->username) && $decoded->username == 'u_asidb') {
		$query = "select * from chd where chd.bankacct = $getbankacct and isdel = 0";
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

	function getUpdatedChd($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from chd where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getChd($getbankacct,$records_per_page){
			$query = "select * from chd where chd.bankacct >= $getbankacct and isdel = 0 order by bankacct";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}

	function updateChd(){
		$query = "INSERT INTO chd (dl_state,dl_number,bankacct,chk_nbr,chk_dte,chk_amt,reason,pd_amt,cntr,file_loc,status,customer,store,who,memo,tstamp,isdel,lreg,lstore)
			VALUES 
		(:dl_state,:dl_number,:bankacct,:chk_nbr,:chk_dte,:chk_amt,:reason,:pd_amt,:cntr,:file_loc,:status,:customer,:store,:who,:memo,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		dl_state = :dl_state,
		dl_number = :dl_number,
		chk_nbr = :chk_nbr,
		chk_dte = :chk_dte,
		chk_amt = :chk_amt,
		reason = :reason,
		pd_amt = :pd_amt,
		cntr = :cntr,
		file_loc = :file_loc,
		status = :status,
		customer = :customer,
		store = :store,
		who = :who,
		memo = :memo,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->dl_state=strip_tags($this->dl_state);
		$this->dl_number=strip_tags($this->dl_number);
		$this->bankacct=strip_tags($this->bankacct);
		$this->chk_nbr=strip_tags($this->chk_nbr);
		$this->chk_dte=strip_tags($this->chk_dte);
		$this->chk_amt=strip_tags($this->chk_amt);
		$this->reason=strip_tags($this->reason);
		$this->pd_amt=strip_tags($this->pd_amt);
		$this->cntr=strip_tags($this->cntr);
		$this->file_loc=strip_tags($this->file_loc);
		$this->status=strip_tags($this->status);
		$this->customer=strip_tags($this->customer);
		$this->store=strip_tags($this->store);
		$this->who=strip_tags($this->who);
		$this->memo=strip_tags($this->memo);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':dl_state', $this->dl_state);
		$stmt->bindParam(':dl_number', $this->dl_number);
		$stmt->bindParam(':bankacct', $this->bankacct);
		$stmt->bindParam(':chk_nbr', $this->chk_nbr);
		$stmt->bindParam(':chk_dte', $this->chk_dte);
		$stmt->bindParam(':chk_amt', $this->chk_amt);
		$stmt->bindParam(':reason', $this->reason);
		$stmt->bindParam(':pd_amt', $this->pd_amt);
		$stmt->bindParam(':cntr', $this->cntr);
		$stmt->bindParam(':file_loc', $this->file_loc);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':customer', $this->customer);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);


		if($stmt->execute()){	
			return 'OK';
		}else{
			$stmtError = $stmt->errorInfo();
		return $stmtError;
		}
	}
}
		
?>
