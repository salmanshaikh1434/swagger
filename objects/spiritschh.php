<?php
class spiritschh{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function readChh($getbankacct){
		$query = "select * from chh where chh.bankacct = $getbankacct and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedChh($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from chh where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getChh($getbankacct,$records_per_page){
			$query = "select * from chh where chh.bankacct >= $getbankacct and isdel = 0 order by bankacct LIMIT ?";
			$stmt = $this->conn->prepare($query); 
			$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);	
			$stmt->execute();
		return $stmt;
	}

	function updateChh(){
		$query = "INSERT INTO chh (dl_state,dl_number,bankacct,acct_name,acct_addr1,acct_addr2,acct_city,acct_st,acct_zip,dl_name,dl_addr1,dl_addr2,dl_city,dl_st,dl_zip,ssn_taxid,phone1,desc1,phone2,desc2,phone3,desc3,phone4,desc4,cust_since,lst_chk,ret_amt,ret_nbr,upd_dte,status,desc,dl_exp_dte,dl_bday,dl_desc,dl_sex,dl_ht,dl_wt,dl_hair,dl_eyes,customer,store,who,memo,sent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:dl_state,:dl_number,:bankacct,:acct_name,:acct_addr1,:acct_addr2,:acct_city,:acct_st,:acct_zip,:dl_name,:dl_addr1,:dl_addr2,:dl_city,:dl_st,:dl_zip,:ssn_taxid,:phone1,:desc1,:phone2,:desc2,:phone3,:desc3,:phone4,:desc4,:cust_since,:lst_chk,:ret_amt,:ret_nbr,:upd_dte,:status,:desc,:dl_exp_dte,:dl_bday,:dl_desc,:dl_sex,:dl_ht,:dl_wt,:dl_hair,:dl_eyes,:customer,:store,:who,:memo,:sent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		dl_state = :dl_state,
		dl_number = :dl_number,
		acct_name = :acct_name,
		acct_addr1 = :acct_addr1,
		acct_addr2 = :acct_addr2,
		acct_city = :acct_city,
		acct_st = :acct_st,
		acct_zip = :acct_zip,
		dl_name = :dl_name,
		dl_addr1 = :dl_addr1,
		dl_addr2 = :dl_addr2,
		dl_city = :dl_city,
		dl_st = :dl_st,
		dl_zip = :dl_zip,
		ssn_taxid = :ssn_taxid,
		phone1 = :phone1,
		desc1 = :desc1,
		phone2 = :phone2,
		desc2 = :desc2,
		phone3 = :phone3,
		desc3 = :desc3,
		phone4 = :phone4,
		desc4 = :desc4,
		cust_since = :cust_since,
		lst_chk = :lst_chk,
		ret_amt = :ret_amt,
		ret_nbr = :ret_nbr,
		upd_dte = :upd_dte,
		status = :status,
		desc = :desc,
		dl_exp_dte = :dl_exp_dte,
		dl_bday = :dl_bday,
		dl_desc = :dl_desc,
		dl_sex = :dl_sex,
		dl_ht = :dl_ht,
		dl_wt = :dl_wt,
		dl_hair = :dl_hair,
		dl_eyes = :dl_eyes,
		customer = :customer,
		store = :store,
		who = :who,
		memo = :memo,
		sent = :sent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->dl_state=strip_tags($this->dl_state);
		$this->dl_number=strip_tags($this->dl_number);
		$this->bankacct=strip_tags($this->bankacct);
		$this->acct_name=strip_tags($this->acct_name);
		$this->acct_addr1=strip_tags($this->acct_addr1);
		$this->acct_addr2=strip_tags($this->acct_addr2);
		$this->acct_city=strip_tags($this->acct_city);
		$this->acct_st=strip_tags($this->acct_st);
		$this->acct_zip=strip_tags($this->acct_zip);
		$this->dl_name=strip_tags($this->dl_name);
		$this->dl_addr1=strip_tags($this->dl_addr1);
		$this->dl_addr2=strip_tags($this->dl_addr2);
		$this->dl_city=strip_tags($this->dl_city);
		$this->dl_st=strip_tags($this->dl_st);
		$this->dl_zip=strip_tags($this->dl_zip);
		$this->ssn_taxid=strip_tags($this->ssn_taxid);
		$this->phone1=strip_tags($this->phone1);
		$this->desc1=strip_tags($this->desc1);
		$this->phone2=strip_tags($this->phone2);
		$this->desc2=strip_tags($this->desc2);
		$this->phone3=strip_tags($this->phone3);
		$this->desc3=strip_tags($this->desc3);
		$this->phone4=strip_tags($this->phone4);
		$this->desc4=strip_tags($this->desc4);
		$this->cust_since=strip_tags($this->cust_since);
		$this->lst_chk=strip_tags($this->lst_chk);
		$this->ret_amt=strip_tags($this->ret_amt);
		$this->ret_nbr=strip_tags($this->ret_nbr);
		$this->upd_dte=strip_tags($this->upd_dte);
		$this->status=strip_tags($this->status);
		$this->desc=strip_tags($this->desc);
		$this->dl_exp_dte=strip_tags($this->dl_exp_dte);
		$this->dl_bday=strip_tags($this->dl_bday);
		$this->dl_desc=strip_tags($this->dl_desc);
		$this->dl_sex=strip_tags($this->dl_sex);
		$this->dl_ht=strip_tags($this->dl_ht);
		$this->dl_wt=strip_tags($this->dl_wt);
		$this->dl_hair=strip_tags($this->dl_hair);
		$this->dl_eyes=strip_tags($this->dl_eyes);
		$this->customer=strip_tags($this->customer);
		$this->store=strip_tags($this->store);
		$this->who=strip_tags($this->who);
		$this->memo=strip_tags($this->memo);
		$this->sent=strip_tags($this->sent);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':dl_state', $this->dl_state);
		$stmt->bindParam(':dl_number', $this->dl_number);
		$stmt->bindParam(':bankacct', $this->bankacct);
		$stmt->bindParam(':acct_name', $this->acct_name);
		$stmt->bindParam(':acct_addr1', $this->acct_addr1);
		$stmt->bindParam(':acct_addr2', $this->acct_addr2);
		$stmt->bindParam(':acct_city', $this->acct_city);
		$stmt->bindParam(':acct_st', $this->acct_st);
		$stmt->bindParam(':acct_zip', $this->acct_zip);
		$stmt->bindParam(':dl_name', $this->dl_name);
		$stmt->bindParam(':dl_addr1', $this->dl_addr1);
		$stmt->bindParam(':dl_addr2', $this->dl_addr2);
		$stmt->bindParam(':dl_city', $this->dl_city);
		$stmt->bindParam(':dl_st', $this->dl_st);
		$stmt->bindParam(':dl_zip', $this->dl_zip);
		$stmt->bindParam(':ssn_taxid', $this->ssn_taxid);
		$stmt->bindParam(':phone1', $this->phone1);
		$stmt->bindParam(':desc1', $this->desc1);
		$stmt->bindParam(':phone2', $this->phone2);
		$stmt->bindParam(':desc2', $this->desc2);
		$stmt->bindParam(':phone3', $this->phone3);
		$stmt->bindParam(':desc3', $this->desc3);
		$stmt->bindParam(':phone4', $this->phone4);
		$stmt->bindParam(':desc4', $this->desc4);
		$stmt->bindParam(':cust_since', $this->cust_since);
		$stmt->bindParam(':lst_chk', $this->lst_chk);
		$stmt->bindParam(':ret_amt', $this->ret_amt);
		$stmt->bindParam(':ret_nbr', $this->ret_nbr);
		$stmt->bindParam(':upd_dte', $this->upd_dte);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':desc', $this->desc);
		$stmt->bindParam(':dl_exp_dte', $this->dl_exp_dte);
		$stmt->bindParam(':dl_bday', $this->dl_bday);
		$stmt->bindParam(':dl_desc', $this->dl_desc);
		$stmt->bindParam(':dl_sex', $this->dl_sex);
		$stmt->bindParam(':dl_ht', $this->dl_ht);
		$stmt->bindParam(':dl_wt', $this->dl_wt);
		$stmt->bindParam(':dl_hair', $this->dl_hair);
		$stmt->bindParam(':dl_eyes', $this->dl_eyes);
		$stmt->bindParam(':customer', $this->customer);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':sent', $this->sent);
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
