<?php
class spiritsodd{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	function getUpdatedOdd($getTstamp,$startingRecord,$records_per_page){
		$thisDate = date('Y-m-d', strtotime($getTstamp));
		$query = "select * from odd where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}
	function getUpdatedOddReg($getOrder,$getStore){
			$query = "select `line`,`sku`,`qty`,`pack`,`descript`,`price`,`cost`,`discount`,`promo` from odd where `isdel` = 0 and `order` = $getOrder and `store` = $getStore";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
			return $stmt;
	}
	
	function readBackCusOdd($getOrder,$getStore){
			$query = "select `line`,`sku`,`qty`,`pack`,`descript`,`price`,`cost`,`discount`,`promo` from odd where `isdel` = 0 and `order` = $getOrder and `store` = $getStore order by `line`";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
			return $stmt;	
	}
	
	function readOddCustomer($getCustomer){
			$query = "select `order`,`sku`,`status`,`agedate`,`qty`,`pack`,`descript`,`price`,`cost`,`memo`,`discount`,`promo`,`store` from odd where `isdel` = 0 and `customer` = $getCustomer and `sku` > 0 and `status` = '5' order by agedate";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
			return $stmt;	
	}

	function getOdd($getOrder,$getStore){
			$query = "select * from odd where `order` = $getOrder and isdel = 0 and `store` = $getStore order by `line`";
			$stmt = $this->conn->prepare($query); 
			$stmt->execute();
		return $stmt;
	}
	// added new function to resolve rptsync issue by salman
	function getOddPage($getPage, $records_per_page)
	{
		$query = "select * from odd where isdel = 0 order by tstamp LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $getPage, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}
	function getTotalSales($records_per_page){
		$query ="SELECT * FROM vw_totalsalebycustomer";
		$stmt =  $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	function readOdd($getSku){
		$query = "select * from odd where `sku` = $getSku and isdel = 0 ";
		$stmt = $this->conn->prepare($query); 
		$stmt->execute();
	return $stmt;
	}

	function updateOdd(){
		$query = "INSERT INTO odd (`order`,store,line,sku,status,customer,orddate,agedate,qty,pack,descript,price,cost,discount,promo,dflag,dclass,damount,taxlevel,surcharge,cat,location,dml,cpack,onsale,freeze,memo,bqty,extax,isdel,lreg,lstore,tstamp)
			VALUES 
		(:order,:store,:line,:sku,:status,:customer,:orddate,:agedate,:qty,:pack,:descript,:price,:cost,:discount,:promo,:dflag,:dclass,:damount,:taxlevel,:surcharge,:cat,:location,:dml,:cpack,:onsale,:freeze,:memo,:bqty,:extax,0,:lreg,:lstore,NOW())
		ON DUPLICATE KEY UPDATE
		sku=:sku,
		status=:status,
		customer=:customer,
		orddate=:orddate,
		agedate=:agedate,
		qty=:qty,
		pack=:pack,
		descript=:descript,
		price=:price,
		cost=:cost,
		discount=:discount,
		promo=:promo,
		dflag=:dflag,
		dclass=:dclass,
		damount=:damount,
		taxlevel=:taxlevel,
		surcharge=:surcharge,
		cat=:cat,
		location=:location,
		dml=:dml,
		cpack=:cpack,
		onsale=:onsale,
		freeze=:freeze,
		memo=:memo,
		bqty=:bqty,
		extax=:extax,
		lstore= :lstore,
		lreg= :lreg,
		tstamp = NOW(),
		isdel = :isdel";

		$stmt = $this->conn->prepare($query);
		$this->order=strip_tags($this->order);
		$this->store=strip_tags($this->store);
		$this->line=strip_tags($this->line);
		$this->sku=strip_tags($this->sku);
		$this->status=strip_tags($this->status);
		$this->customer=strip_tags($this->customer);
		$this->orddate=strip_tags($this->orddate);
		$this->agedate=strip_tags($this->agedate);
		$this->qty=strip_tags($this->qty);
		$this->pack=strip_tags($this->pack);
		$this->descript=strip_tags($this->descript);
		$this->price=strip_tags($this->price);
		$this->cost=strip_tags($this->cost);
		$this->discount=strip_tags($this->discount);
		$this->promo=strip_tags($this->promo);
		$this->dflag=strip_tags($this->dflag);
		$this->dclass=strip_tags($this->dclass);
		$this->damount=strip_tags($this->damount);
		$this->taxlevel=strip_tags($this->taxlevel);
		$this->surcharge=strip_tags($this->surcharge);
		$this->cat=strip_tags($this->cat);
		$this->location=strip_tags($this->location);
		$this->dml=strip_tags($this->dml);
		$this->cpack=strip_tags($this->cpack);
		$this->onsale=strip_tags($this->onsale);
		$this->freeze=strip_tags($this->freeze);
		$this->memo=strip_tags($this->memo);
		$this->bqty=strip_tags($this->bqty);
		$this->extax=strip_tags($this->extax);
		$this->lreg=strip_tags($this->lreg);
		$this->lstore=strip_tags($this->lstore);
		$this->isdel=strip_tags($this->isdel);

		$stmt->bindParam(':order', $this->order);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':line', $this->line);
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':customer', $this->customer);
		$stmt->bindParam(':orddate', $this->orddate);
		$stmt->bindParam(':agedate', $this->agedate);
		$stmt->bindParam(':qty', $this->qty);
		$stmt->bindParam(':pack', $this->pack);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':cost', $this->cost);
		$stmt->bindParam(':discount', $this->discount);
		$stmt->bindParam(':promo', $this->promo);
		$stmt->bindParam(':dflag', $this->dflag);
		$stmt->bindParam(':dclass', $this->dclass);
		$stmt->bindParam(':damount', $this->damount);
		$stmt->bindParam(':taxlevel', $this->taxlevel);
		$stmt->bindParam(':surcharge', $this->surcharge);
		$stmt->bindParam(':cat', $this->cat);
		$stmt->bindParam(':location', $this->location);
		$stmt->bindParam(':dml', $this->dml);
		$stmt->bindParam(':cpack', $this->cpack);
		$stmt->bindParam(':onsale', $this->onsale);
		$stmt->bindParam(':freeze', $this->freeze);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':bqty', $this->bqty);
		$stmt->bindParam(':extax', $this->extax);
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