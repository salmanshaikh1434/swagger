<?php
class spiritspod
{
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function readPod($getOrder)
	{
		$query = "select * from pod where pod.order = $getOrder and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function readPodLine($getOrder, $nextLineNum)
	{
		$query = "select * from pod where pod.order = $getOrder and isdel = 0 and pod.line = $nextLineNum";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	//function created by salman  on 23/03/0223
	function getPod($getPage, $records_per_page)
	{
		$query = "select * from pod where isdel = 0 order by tstamp LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $getPage, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}


	function getUpdatedpod($getTstamp, $startingRecord, $records_per_page)
	{
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from pod where tstamp > '$thisDate' LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function checkpo($getOrder, $getStore)
	{
		$query = "select `status` from poh where poh.order = $getOrder and isdel = 0 and poh.store = $getStore";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getLastPod($getStore, $getOrder)
	{
		$query = "select max(`line`) as linenum from pod where store = $getStore and `order` = $getOrder";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function postpo($getOrder, $getStore)
	{
		$query = "select * from pod where pod.order = $getOrder and isdel = 0 and pod.store=$getStore and pod.status ='8'";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function postpocost($getOrder, $getStore)
	{
		$query = "select * from pod where pod.order = $getOrder and isdel = 0 and pod.store=$getStore and pod.status ='6'";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function unpostpo($getOrder, $getStore)
	{
		$query = "select * from pod where pod.order = $getOrder and isdel = 0 and pod.store=$getStore and (pod.status ='4' or pod.status = '6')";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function popost_getoldstock($getSku, $getStore)
	{
		$query = "select stk.back as stock from stk where stk.sku = $getSku and stk.store=$getStore";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		return $stock;
	}

	function popost_getoldstockall($getSku, $getStore)
	{
		$query = "select stk.back+stk.floor+stk.shipped+stk.ware+stk.kits as stock from stk where stk.sku = $getSku and stk.store=$getStore";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		return $stock;
	}

	function popost_getoldstockcost($getSku, $getStore)
	{
		$query = "select stk.acost,stk.lcost,inv.pack as invpack from stk,inv where stk.sku = $getSku and stk.store=$getStore and inv.sku=stk.sku";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function posttostk($store, $sku, $oqty, $vcode, $rcvdate, $who, $lreg, $lstore)
	{
		$product = new spiritsstk($this->conn);
		if ($rcvdate !== 0) {
			$thisrcvdate = date('Y-m-d', strtotime($rcvdate));
		} else {
			$thisrcvdate = 0;
		}
		if ($thisrcvdate = 0) {
			$query = "INSERT INTO stk (sku,store,floor,back,shipped,kits,stat,mtd_units,weeks,sdate,mtd_dol,mtd_prof,ytd_units,ytd_dol,ytd_prof,acost,lcost,pvend,lvend,pdate,smin,sord,sweeks,freeze_w,shelf,rshelf,sloc,bloc,who,inet,depos,skipstat,mincost,base,sent,ware,vintage,gosent,tstamp,isdel,lreg,lstore)
					VALUES 
				($sku,$store,0,$oqty,0,0,'2',0,0,'',0,0,0,0,0,0,0,'','$vcode',0,0,0,0,0,0,0,'','','$who',2,'',0,0,0,0,0,'',0,now(),0,$lreg,$lstore)
				ON DUPLICATE KEY UPDATE
				back = back+$oqty,
				lvend = '$vcode',
				pdate = $rcvdate,
				who = '$who',
				tstamp = NOW(),
				lstore= $lstore,
				lreg= $lreg,
				isdel = 0";
		} else {
			$query = "INSERT INTO stk (sku,store,floor,back,shipped,kits,stat,mtd_units,weeks,sdate,mtd_dol,mtd_prof,ytd_units,ytd_dol,ytd_prof,acost,lcost,pvend,lvend,pdate,smin,sord,sweeks,freeze_w,shelf,rshelf,sloc,bloc,who,inet,depos,skipstat,mincost,base,sent,ware,vintage,gosent,tstamp,isdel,lreg,lstore)
					VALUES 
				($sku,$store,0,$oqty,0,0,'2',0,0,'',0,0,0,0,0,0,0,'','$vcode',$thisrcvdate,0,0,0,0,0,0,'','','$who',2,'',0,0,0,0,0,'',0,now(),0,$lreg,$lstore)
				ON DUPLICATE KEY UPDATE
				back = back+$oqty,
				lvend = '$vcode',
				who = '$who',
				tstamp = NOW(),
				lstore= $lstore,
				lreg= $lreg,
				isdel = 0";
		}


		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}
	// made changes in function to update average cost
	function postpoavgcost($sku, $store, $order, $who, $lcost, $acost, $cost, $lreg, $lstore)
	{
		$query = "INSERT INTO avgcost (sku, store, oldcost, newcost, who, tstamp, `type`, `number`, costype, posted, isdel, `sent`, lreg, lstore)
                VALUES (:sku, :store, :lcost, :cost, :who, NOW(), 'P', :order, 'L', 1, 0, 0, :lreg, :lstore),
                       (:sku, :store, :acost, :cost, :who, NOW(), 'P', :order, 'A', 1, 0, 0, :lreg, :lstore)
                ON DUPLICATE KEY UPDATE
                sku = VALUES(sku),
                store = VALUES(store),
                oldcost = CASE WHEN oldcost = VALUES(oldcost) THEN oldcost ELSE VALUES(oldcost) END,
                newcost = VALUES(newcost),
                who = VALUES(who),
                tstamp = VALUES(tstamp),
                `type` = VALUES(`type`),
                `number` = VALUES(`number`),
                costype = VALUES(costype),
                posted = VALUES(posted),
                isdel = VALUES(isdel),
                `sent` = VALUES(`sent`),
                lreg = VALUES(lreg),
                lstore = VALUES(lstore)";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':sku', $sku);
		$stmt->bindParam(':store', $store);
		$stmt->bindParam(':lcost', $lcost);
		$stmt->bindParam(':acost', $acost);
		$stmt->bindParam(':cost', $cost);
		$stmt->bindParam(':who', $who);
		$stmt->bindParam(':order', $order);
		$stmt->bindParam(':lreg', $lreg);
		$stmt->bindParam(':lstore', $lstore);

		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}
	// function to update inv table after post po by salman
	function postcosttoinv($lcost, $acost, $sku)
	{
		$query = "UPDATE inv SET lcost = :lcost, acost = :acost WHERE slu = :sku";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':sku', $sku);
		$stmt->bindParam(':lcost', $lcost);
		$stmt->bindParam(':acost', $acost);

		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	//created by salman to update avgcost table after unpost po
	function updatepounpostavgcost($sku, $store, $oldAcost, $oldLcost, $newAcost, $newLcost, $getWho, $getOrder, $getLreg, $getLstore)
	{
		$query = "
			UPDATE avgcost
			SET oldcost = CASE costype
				WHEN 'L' THEN :oldLcost
				WHEN 'A' THEN :oldAcost
			END,
			newcost = CASE costype
				WHEN 'L' THEN :newLcost
				WHEN 'A' THEN :newAcost
			END,
			who = :who,
			`number` = :order,
			lreg = :lreg,
			lstore = :lstore
			WHERE sku = :sku AND store = :store AND costype IN ('L', 'A')
		";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':sku', $sku);
		$stmt->bindParam(':store', $store);
		$stmt->bindParam(':oldLcost', $oldLcost);
		$stmt->bindParam(':newLcost', $newLcost);
		$stmt->bindParam(':oldAcost', $oldAcost);
		$stmt->bindParam(':newAcost', $newAcost);
		$stmt->bindParam(':who', $getWho);
		$stmt->bindParam(':order', $getOrder);
		$stmt->bindParam(':lreg', $getLreg);
		$stmt->bindParam(':lstore', $getLstore);

		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function posttostkcost($store, $sku, $newAcost, $newLcost, $who, $lstore, $lreg)
	{
		$query = "INSERT INTO stk (sku,store,floor,back,shipped,kits,stat,mtd_units,weeks,sdate,mtd_dol,mtd_prof,ytd_units,ytd_dol,ytd_prof,acost,lcost,pvend,lvend,pdate,smin,sord,sweeks,freeze_w,shelf,rshelf,sloc,bloc,who,inet,depos,skipstat,mincost,base,sent,ware,vintage,gosent,tstamp,isdel,lreg,lstore)
				VALUES 
			($sku,$store,0,0,0,0,'2',0,0,'',0,0,0,0,0,$newAcost,$newLcost,'','',0,0,0,0,0,0,0,'','','$who',2,'',0,0,0,0,0,'',0,now(),0,$lreg,$lstore)
			ON DUPLICATE KEY UPDATE
			acost = $newAcost;
			lcost = $newLcost;
			who = '$who',
			tstamp = NOW(),
			lstore= $lstore,
			lreg= $lreg,
			isdel = 0";

		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}



	function updatepodpoststatus($store, $order, $line, $rcvdate, $who, $lstore, $lreg, $oldstock)
	{
		$thisrcvdate = date('Y-m-d', strtotime($rcvdate));
		$thisrcvdate = "'" . $thisrcvdate . "'"; //added by sumeeth for date format quotes
		$query = "UPDATE POD SET
		status = '6',
		tstamp=NOW(),
		rcvdate=$thisrcvdate,
		lstore= $lstore,
		lreg= $lreg,
		upstk= 1,
		fifo=$oldstock,
		who = '$who' 
		where pod.store = $store and pod.order = $order and pod.line = $line";
		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function updatepohpoststatus($store, $order, $who, $lstore, $lreg, $rcvdate)
	{
		$thisrcvdate = date('Y-m-d', strtotime($rcvdate));
		$thisrcvdate = "'" . $thisrcvdate . "'"; //added by sumeeth for date format quotes
		//print_r($thisrcvdate);exit;
		$query = "UPDATE POH SET
		status = '6',
		tstamp=NOW(),
		rcvdate=$thisrcvdate,
		lstore= $lstore,
		lreg= $lreg,
		who = '$who' 
		where poh.store = $store and poh.order = $order";
		$stmt = $this->conn->prepare($query);
		//print_r($stmt);exit;
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function updatepodunpoststatus($store, $order, $line, $who, $lstore, $lreg)
	{
		$query = "UPDATE POD SET
		status = '8',
		tstamp = NOW(),
		lstore = $lstore,
		lreg = $lreg,
		upstk = 0,
		fifo = 0,
		who = '$who' 
		where pod.store = $store and pod.order = $order and pod.line = $line";
		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
		return $query;
	}

	function updatepohunpoststatus($store, $order, $who, $lstore, $lreg)
	{
		$query = "UPDATE POH SET
		status = '8',
		tstamp=NOW(),
		lstore= $lstore,
		lreg= $lreg,
		who = '$who' 
		where poh.store = $store and poh.order = $order";
		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function updatepodcoststatus($store, $order, $line, $who, $lstore, $lreg)
	{
		$query = "UPDATE POD SET
		status = '4',
		tstamp=NOW(),
		lstore= $lstore,
		lreg= $lreg,
		upstk= 1,
		who = '$who' 
		where pod.store = $store and pod.order = $order and pod.line = $line";
		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function updatepohcoststatus($store, $order, $who, $lreg, $lstore, $rcvdate)
	{
		$thisrcvdate = date('Y-m-d', strtotime($rcvdate));
		$query = "UPDATE POH SET
		status = '4',
		tstamp=NOW(),
		lstore= $lstore,
		lreg= $lreg,
		who = '$who' 
		where poh.store = $store and poh.order = $order";
		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function updatepodapstatus($store, $order, $line, $who, $lstore, $lreg)
	{
		$thisrcvdate = date('Y-m-d', strtotime($rcvdate));
		$query = "UPDATE POD SET
		status = '3',
		tstamp=NOW(),
		lstore= $lstore,
		lreg= $lreg,
		upstk= 1,
		who = '$who' 
		where pod.store = $store and pod.order = $order and pod.line = $line";
		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function updatepohapstatus($store, $order, $line, $who, $lreg, $lstore)
	{
		$thisrcvdate = date('Y-m-d', strtotime($rcvdate));
		$query = "UPDATE POH SET
		status = '4',
		tstamp=NOW(),
		lstore= $lstore,
		lreg= $lreg,
		who = '$who' 
		where poh.store = $store and poh.order = $order and poh.line = $line";
		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function updatepoavgcost($sku, $store, $oldcost, $newcost, $who, $number, $lreg, $lstore, $avtype)
	{
		$query = "INSERT INTO avgcost (sku,store,oldcost,newcost,who,type,number,costype,posted,sent,tstamp,isdel,lreg,lstore)
			VALUES ($sku,$store,$oldcost,$newcost,'$who','P',$number,'$avtype',0,0,now(),0,$lreg,$lstore)";
		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function updateunpostpoavgcost($sku, $store, $oldcost, $newcost, $who, $number, $lreg, $lstore, $avtype)
	{
		$query = "INSERT INTO avgcost (sku,store,oldcost,newcost,who,type,number,costype,posted,sent,tstamp,isdel,lreg,lstore)
			VALUES ($sku,$store,$oldcost,$newcost,'$who','U',$number,'$avtype',0,0,now(),0,$lreg,$lstore)";
		$stmt = $this->conn->prepare($query);
		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}

	function getlastpoavgcost($sku, $store, $avtype)
	{
		$query = "select oldcost from avgcost where sku = $sku and store = $store and costype = '$avtype' and `type` = 'P' order by tstamp desc limit 1";
		$stmt = $this->conn->prepare($query);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		return $oldcost;
	}
	/* select * from avgcost where sku = 18965 and store = 10 and `number` = 119516 and type = 'p' and costype = 'L' order by tstamp desc limit 1 */

	/*postatus,rcvdate,poorder,vcode,qty,cqty,cost,ccost,fifo,cfifo,store,who,invoicenbr*/

	function getInvPod($getSku, $getTstamp)
	{
		$thisTstamp = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select status,rcvdate,`order`,vcode,oqty,cost,fifo,store,who,invoicenbr from pod where sku = $getSku and rcvdate >= '$thisTstamp' and isdel=0 ";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getPodVnd($getOrder = null, $vendor = null)
	{
		if ($getOrder != null) {
			$query = "SELECT sku, `order`, name, cbqty, cost, pack, sname, vid, coqty, line, deal FROM pod WHERE `order` = $getOrder AND isdel = 0";
		} else if ($vendor != null) {
			$query = "SELECT sku, `order`, name, cbqty, cost, pack, sname, vid, coqty, line, deal FROM pod WHERE `vendor` = $vendor AND isdel = 0";
		}


		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		// Return the executed statement
		return $stmt;
	}


	function readPodUpdate($getOrder)
	{
		$query = "select `sku`,`name`,`bqty`,`cost`,`pack`,`sname`,`vid`,`recoqty`,`line`,`deal`,`oqty` from pod where `order` = $getOrder and isdel = 0";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function onOrderPO($getStore, $getSku)
	{
		$query = "select sum(pod.oqty) as onorder from pod where isdel = '0' and store = $getStore and sku = $getSku and pod.status = '8'";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}


	function updatePod()
	{
		$query = "INSERT INTO pod (`order`,store,line,sku,name,sname,ml,status,vendor,vcode,vid,orddate,rcvdate,oqty,coqty,bqty,cbqty,fifo,cost,unitcost,pack,glaccount,deal,
									salesman,transfer,sord,creditstat,crdpaydate,who,memo,creditdue,creditpaid,crdpaynbr,deposits,invoice,invoicenbr,upstk,bdrips,adjcost,reccoqty,recoqty,rips,
									freight,tax,discounts,ware,wareoqty,warecoqty,gosent,lstore,lreg,isdel,tstamp) VALUES 
								   (:order,:store,:line,:sku,:name,:sname,:ml,:status,:vendor,:vcode,:vid,:orddate,:rcvdate,:oqty,:coqty,:bqty,:cbqty,:fifo,:cost,:unitcost,:pack,:glaccount,:deal,
								   :salesman,:transfer,:sord,:creditstat,:crdpaydate,:who,:memo,:creditdue,:creditpaid,:crdpaynbr,:deposits,:invoice,:invoicenbr,:upstk,:bdrips,:adjcost,:reccoqty,:recoqty,:rips,
								   :freight,:tax,:discounts,:ware,:wareoqty,:warecoqty,:gosent,:lstore,:lreg,:isdel,NOW())
				  ON DUPLICATE KEY UPDATE
							store = :store,
							sku = :sku,
							name = :name,
							sname = :sname,
							ml = :ml,
							status = :status,
							vendor = :vendor,
							vcode = :vcode,
							vid = :vid,
							orddate = :orddate,
							rcvdate = :rcvdate,
							oqty = :oqty,
							coqty = :coqty,
							bqty = :bqty,
							cbqty = :cbqty,
							fifo = :fifo,
							cost = :cost,
							unitcost = :unitcost,
							pack = :pack,
							glaccount = :glaccount,
							deal = :deal,
							salesman = :salesman,
							transfer = :transfer,
							sord = :sord,
							creditstat = :creditstat,
							crdpaydate = :crdpaydate,
							who = :who,
							memo = :memo,
							creditdue = :creditdue,
							creditpaid = :creditpaid,
							crdpaynbr = :crdpaynbr,
							deposits = :deposits,
							invoice = :invoice,
							invoicenbr = :invoicenbr,
							upstk = :upstk,
							bdrips = :bdrips,
							adjcost = :adjcost,
							reccoqty = :reccoqty,
							recoqty = :recoqty,
							rips = :rips,
							freight = :freight,
							tax = :tax,
							discounts = :discounts,
							ware = :ware,
							wareoqty = :wareoqty,
							warecoqty = :warecoqty,
							gosent = :gosent,
							lreg = :lreg,
							lstore = :lstore,
							tstamp = NOW(),
							isdel = :isdel";

		$stmt = $this->conn->prepare($query);

		$this->order = strip_tags($this->order);
		$this->store = strip_tags($this->store);
		$this->line = strip_tags($this->line);
		$this->sku = strip_tags($this->sku);
		$this->name = strip_tags($this->name);
		$this->sname = strip_tags($this->sname);
		$this->ml = strip_tags($this->ml);
		$this->status = strip_tags($this->status);
		$this->vendor = strip_tags($this->vendor);
		$this->vcode = strip_tags($this->vcode);
		$this->vid = strip_tags($this->vid);
		$this->orddate = strip_tags($this->orddate);
		$this->rcvdate = strip_tags($this->rcvdate);
		$this->oqty = strip_tags($this->oqty);
		$this->coqty = strip_tags($this->coqty);
		$this->bqty = strip_tags($this->bqty);
		$this->cbqty = strip_tags($this->cbqty);
		$this->fifo = strip_tags($this->fifo);
		$this->cost = strip_tags($this->cost);
		$this->unitcost = strip_tags($this->unitcost);
		$this->pack = strip_tags($this->pack);
		$this->glaccount = strip_tags($this->glaccount);
		$this->deal = strip_tags($this->deal);
		$this->salesman = strip_tags($this->salesman);
		$this->transfer = strip_tags($this->transfer);
		$this->sord = strip_tags($this->sord);
		$this->creditstat = strip_tags($this->creditstat);
		$this->crdpaydate = strip_tags($this->crdpaydate);
		$this->who = strip_tags($this->who);
		$this->memo = strip_tags($this->memo);
		$this->creditdue = strip_tags($this->creditdue);
		$this->creditpaid = strip_tags($this->creditpaid);
		$this->crdpaynbr = strip_tags($this->crdpaynbr);
		$this->deposits = strip_tags($this->deposits);
		$this->invoice = strip_tags($this->invoice);
		$this->invoicenbr = strip_tags($this->invoicenbr);
		$this->upstk = strip_tags($this->upstk);
		$this->bdrips = strip_tags($this->bdrips);
		$this->adjcost = strip_tags($this->adjcost);
		$this->reccoqty = strip_tags($this->reccoqty);
		$this->recoqty = strip_tags($this->recoqty);
		$this->rips = strip_tags($this->rips);
		$this->freight = strip_tags($this->freight);
		$this->tax = strip_tags($this->tax);
		$this->discounts = strip_tags($this->discounts);
		$this->ware = strip_tags($this->ware);
		$this->wareoqty = strip_tags($this->wareoqty);
		$this->warecoqty = strip_tags($this->warecoqty);
		$this->gosent = strip_tags($this->gosent);
		$this->lstore = strip_tags($this->lstore);
		$this->lreg = strip_tags($this->lreg);
		$this->isdel = strip_tags($this->isdel);

		$stmt->bindParam(':order', $this->order);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':line', $this->line);
		$stmt->bindParam(':sku', $this->sku);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':sname', $this->sname);
		$stmt->bindParam(':ml', $this->ml);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':vendor', $this->vendor);
		$stmt->bindParam(':vcode', $this->vcode);
		$stmt->bindParam(':vid', $this->vid);
		$stmt->bindParam(':orddate', $this->orddate);
		$stmt->bindParam(':rcvdate', $this->rcvdate);
		$stmt->bindParam(':oqty', $this->oqty);
		$stmt->bindParam(':coqty', $this->coqty);
		$stmt->bindParam(':bqty', $this->bqty);
		$stmt->bindParam(':cbqty', $this->cbqty);
		$stmt->bindParam(':fifo', $this->fifo);
		$stmt->bindParam(':cost', $this->cost);
		$stmt->bindParam(':unitcost', $this->unitcost);
		$stmt->bindParam(':pack', $this->pack);
		$stmt->bindParam(':glaccount', $this->glaccount);
		$stmt->bindParam(':deal', $this->deal);
		$stmt->bindParam(':salesman', $this->salesman);
		$stmt->bindParam(':transfer', $this->transfer);
		$stmt->bindParam(':sord', $this->sord);
		$stmt->bindParam(':creditstat', $this->creditstat);
		$stmt->bindParam(':crdpaydate', $this->crdpaydate);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':creditdue', $this->creditdue);
		$stmt->bindParam(':creditpaid', $this->creditpaid);
		$stmt->bindParam(':crdpaynbr', $this->crdpaynbr);
		$stmt->bindParam(':deposits', $this->deposits);
		$stmt->bindParam(':invoice', $this->invoice);
		$stmt->bindParam(':invoicenbr', $this->invoicenbr);
		$stmt->bindParam(':upstk', $this->upstk);
		$stmt->bindParam(':bdrips', $this->bdrips);
		$stmt->bindParam(':adjcost', $this->adjcost);
		$stmt->bindParam(':reccoqty', $this->reccoqty);
		$stmt->bindParam(':recoqty', $this->recoqty);
		$stmt->bindParam(':rips', $this->rips);
		$stmt->bindParam(':freight', $this->freight);
		$stmt->bindParam(':tax', $this->tax);
		$stmt->bindParam(':discounts', $this->discounts);
		$stmt->bindParam(':ware', $this->ware);
		$stmt->bindParam(':wareoqty', $this->wareoqty);
		$stmt->bindParam(':warecoqty', $this->warecoqty);
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
}