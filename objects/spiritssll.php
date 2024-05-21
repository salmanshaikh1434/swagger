<?php
class spiritssll
{
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function readSll($getlistnum)
	{
		$query = "select * from sll where sll.listnum = $getlistnum and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedSll($getTstamp, $startingRecord, $records_per_page)
	{
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from sll where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getSll($getlistnum, $getline, $records_per_page)
	{
		$query = "select * from sll where sll.listnum >= $getlistnum and line > $getline and isdel = 0 order by listnum,line LIMIT ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function readPricesOnlist($getSku)
	{
		$query = "select sll.listnum,sll.line,sll.listname,sll.store,sll.level,sll.qty,sll.price,slh.onsale,slh.start,slh.stop,slh.type from sll left join slh on slh.listnum = sll.listnum where sll.sku = $getSku and (slh.type = 'S' or slh.type = 'C') and sll.isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function readSllBackroom($getlistnum, $getstore)
	{
		/* $query = "SELECT sll.listnum, sll.line, sll.listname, sll.sku, inv.type, inv.pack, inv.name as descript, inv.sname, inv.ml, sll.level, sll.qty, sll.price, stk.acost, stk.lcost,sll.percent, sll.dcode, sll.status, 
			sll.onsale, sll.prevqty, prc.price as prevprice, sll.prevdcode, sll.prevonsale, sll.actdate, sll.units, sll.sales, sll.profit, sll.store, 
			sll.labels, sll.prevpromo, sll.adate, stk.mincost as mcost, sll.stype FROM sll,inv,prc,stk WHERE sll.sku = inv.sku and prc.level = sll.level and prc.sku = sll.sku and stk.store = $getstore and stk.sku = sll.sku and sll.listnum >= $getlistnum AND sll.isdel = 0 order by sll.line";
			 */
		$query = "SELECT sll.listnum, sll.line, sll.listname, sll.sku, '' as type, '0' as pack, sll.descript, sll.sname, sll.ml, sll.level, sll.qty, sll.price, '0' as acost, '0' as lcost,sll.percent, sll.dcode, sll.status, 
			sll.onsale, sll.prevqty, '0.00' as prevprice, sll.prevdcode, sll.prevonsale, sll.actdate, sll.units, sll.sales, sll.profit, sll.store, 
			sll.labels, sll.prevpromo, sll.adate, '0' as mcost, sll.stype FROM sll WHERE sll.listnum = $getlistnum AND sll.isdel = 0 order by sll.line";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	// function to replace current price wit new price by salman

	function updateSllCp()
	{

		$sql = "UPDATE sll 
		SET percent = ROUND(100 * (:newprice - cost) / :newprice , 2), 
			price = :newprice 
		WHERE price = :currentprice 
		  AND listnum = :listnum
		  AND store = :store";

		// prepare the statement
		$stmt = $this->conn->prepare($sql);

		// bind the parameters
		$stmt->bindParam(':newprice', $this->newprice);
		$stmt->bindParam(':currentprice', $this->currentprice);
		$stmt->bindParam(':listnum', $this->listnum);
		$stmt->bindParam(':store', $this->store);

		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	// function to increase or decrease the price by salman
	function updateSllPriceChange()
	{
		$sql = "UPDATE sll SET price = price + :price,percent = ROUND(100 * (:price - cost) / :price , 2) WHERE  listnum = :listnum AND store= :store";

		// prepare the statement
		$stmt = $this->conn->prepare($sql);

		// bind the parameters
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':listnum', $this->listnum);
		$stmt->bindParam(':store', $this->store);

		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	// function to update fixed price
	function updateFixedPrice()
	{
		$sql = "UPDATE sll SET price = :price,percent = ROUND(100 * (:price - cost) / :price , 2) WHERE  listnum = :listnum AND store = :store";

		// prepare the statement
		$stmt = $this->conn->prepare($sql);

		// bind the parameters
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':listnum', $this->listnum);
		$stmt->bindParam(':store', $this->store);

		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	// function to update percentage roundup
	function updateRoundPercent()
	{
		$sql = "SELECT price,line,level,sku FROM sll WHERE listnum = :listnum AND store = :store";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute(['listnum' => $this->listnum, 'store' => $this->store]);
		$success = true;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$xPrice = $row['price'];
			$lnPrice = round($xPrice + ($xPrice * ($this->percent * 0.01)), 2);
			$Roundvalue = intval(substr(trim((string)number_format($lnPrice, 2)), -1));
			if ($this->roundit && $Roundvalue !== $this->round) {
				$nNewRound = $this->round - $Roundvalue;
				$lnPrice = $lnPrice + ($nNewRound * 0.01);
				if ($this->rounddown) {
					$lnPrice = $lnPrice - 0.1;
				}
			}

			$sql1 = "UPDATE sll SET price = :price,percent = ROUND(100 * (:price - cost) / :price , 2) WHERE listnum = :listnum AND store = :store AND sku =:sku AND line=:line AND level=:level";
			$stmt1 = $this->conn->prepare($sql1);
			$stmt1->bindParam(':price', $lnPrice);
			$stmt1->bindParam(':listnum', $this->listnum);
			$stmt1->bindParam(':store', $this->store);
			$stmt1->bindParam(':line', $row['line']);
			$stmt1->bindParam(':level', $row['level']);
			$stmt1->bindParam(':sku', $row['sku']);
			if (!$stmt1->execute()) {
				$stmtError = $stmt->errorInfo();
				$success = false;
				break; // Exit the loop on error
			}
		}
		return $success ? 'OK' : $stmtError; // Return the result outside the loop
	}


	// function to update discount code
	function updateDiscountcode()
	{
		$sql = "UPDATE sll SET dcode = :dcode,prevdcode = dcode WHERE  listnum = :listnum AND store = :store";

		// prepare the statement
		$stmt = $this->conn->prepare($sql);

		// bind the parameters
		$stmt->bindParam(':dcode', $this->dcode);
		$stmt->bindParam(':listnum', $this->listnum);
		$stmt->bindParam(':store', $this->store);

		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function deleteSll()
	{
		$stmt = $this->conn->prepare("UPDATE sll SET isdel = 1 WHERE listnum = :listnum AND sku= :sku AND line= :line AND level=:level");

		// Bind the parameters
		$stmt->bindParam(':listnum', $this->listnum);
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':line', $this->line);
		$stmt->bindParam(':level', $this->level);
		// Execute the update query
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}
	function updateSll()
	{

		$query = "INSERT INTO sll (listnum,line,listname,sku,type,descript,sname,ml,level,qty,price,cost,percent,dcode,status,onsale,prevqty,prevprice,prevdcode,prevonsale,actdate,units,sales,profit,store,labels,prevpromo,adate,mcost,stype,gosent,tstamp,isdel,lreg,lstore)
			VALUES 
		(:listnum,:line,:listname,:sku,:type,:descript,:sname,:ml,:level,:qty,:price,:cost,:percent,:dcode,:status,:onsale,:prevqty,:prevprice,:prevdcode,:prevonsale,:actdate,:units,:sales,:profit,:store,:labels,:prevpromo,:adate,:mcost,:stype,:gosent,now(),0,:lreg,:lstore)
		ON DUPLICATE KEY UPDATE
		line = :line,
		listname = :listname,
		sku = :sku,
		type = :type,
		descript = :descript,
		sname = :sname,
		ml = :ml,
		level = :level,
		qty = :qty,
		price = :price,
		cost = :cost,
		percent = :percent,
		dcode = :dcode,
		status = :status,
		onsale = :onsale,
		prevqty = :prevqty,
		prevprice = :prevprice,
		prevdcode = :prevdcode,
		prevonsale = :prevonsale,
		actdate = :actdate,
		units = :units,
		sales = :sales,
		profit = :profit,
		store = :store,
		labels = :labels,
		prevpromo = :prevpromo,
		adate = :adate,
		mcost = :mcost,
		stype = :stype,
		gosent = :gosent,
		tstamp = NOW(),
		lstore= :lstore,
		lreg= :lreg,
		isdel = CASE WHEN isdel <> 1 THEN :isdel ELSE isdel END";

		$stmt = $this->conn->prepare($query);
		$this->listnum = strip_tags($this->listnum);
		$this->line = strip_tags($this->line);
		$this->listname = strip_tags($this->listname);
		$this->sku = strip_tags($this->sku);
		$this->type = strip_tags($this->type);
		$this->descript = strip_tags($this->descript);
		$this->sname = strip_tags($this->sname);
		$this->ml = strip_tags($this->ml);
		$this->level = strip_tags($this->level);
		$this->qty = strip_tags($this->qty);
		$this->price = strip_tags($this->price);
		$this->cost = strip_tags($this->cost);
		$this->percent = strip_tags($this->percent);
		$this->dcode = strip_tags($this->dcode);
		$this->status = strip_tags($this->status);
		$this->onsale = strip_tags($this->onsale);
		$this->prevqty = strip_tags($this->prevqty);
		$this->prevprice = strip_tags($this->prevprice);
		$this->prevdcode = strip_tags($this->prevdcode);
		$this->prevonsale = strip_tags($this->prevonsale);
		$this->actdate = strip_tags($this->actdate);
		$this->units = strip_tags($this->units);
		$this->sales = strip_tags($this->sales);
		$this->profit = strip_tags($this->profit);
		$this->store = strip_tags($this->store);
		$this->labels = strip_tags($this->labels);
		$this->prevpromo = strip_tags($this->prevpromo);
		$this->adate = strip_tags($this->adate);
		$this->mcost = strip_tags($this->mcost);
		$this->stype = strip_tags($this->stype);
		$this->gosent = strip_tags($this->gosent);
		$this->lreg = strip_tags($this->lreg);
		$this->lstore = strip_tags($this->lstore);
		$this->isdel = strip_tags($this->isdel);

		$stmt->bindParam(':listnum', $this->listnum);
		$stmt->bindParam(':line', $this->line);
		$stmt->bindParam(':listname', $this->listname);
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':type', $this->type);
		$stmt->bindParam(':descript', $this->descript);
		$stmt->bindParam(':sname', $this->sname);
		$stmt->bindParam(':ml', $this->ml);
		$stmt->bindParam(':level', $this->level);
		$stmt->bindParam(':qty', $this->qty);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':cost', $this->cost);
		$stmt->bindParam(':percent', $this->percent);
		$stmt->bindParam(':dcode', $this->dcode);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':onsale', $this->onsale);
		$stmt->bindParam(':prevqty', $this->prevqty);
		$stmt->bindParam(':prevprice', $this->prevprice);
		$stmt->bindParam(':prevdcode', $this->prevdcode);
		$stmt->bindParam(':prevonsale', $this->prevonsale);
		$stmt->bindParam(':actdate', $this->actdate);
		$stmt->bindParam(':units', $this->units);
		$stmt->bindParam(':sales', $this->sales);
		$stmt->bindParam(':profit', $this->profit);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':labels', $this->labels);
		$stmt->bindParam(':prevpromo', $this->prevpromo);
		$stmt->bindParam(':adate', $this->adate);
		$stmt->bindParam(':mcost', $this->mcost);
		$stmt->bindParam(':stype', $this->stype);
		$stmt->bindParam(':gosent', $this->gosent);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':isdel', $this->isdel);


		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}
	function updateSllbyPrice()
	{
		$query = "update sll,slh set 
		sll.price = :price,
		slh.tstamp = NOW(),
		sll.lstore= :lstore,
		slh.lstore= :lstore,
		sll.lreg= :lreg,
		slh.lreg= :lreg,
		sll.isdel = '0' 
		where sll.sku = :sku and sll.listnum = :listnum and sll.line = :line and slh.listnum = :listnum";

		$stmt = $this->conn->prepare($query);
		$this->price = strip_tags($this->price);
		$this->sku = strip_tags($this->sku);
		$this->listnum = strip_tags($this->listnum);
		$this->line = strip_tags($this->line);
		$this->lreg = strip_tags($this->lreg);
		$this->lstore = strip_tags($this->lstore);

		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':listnum', $this->listnum);
		$stmt->bindParam(':line', $this->line);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':lstore', $this->lstore);

		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}
}
