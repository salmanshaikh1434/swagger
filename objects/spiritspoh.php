<?php
class spiritspoh
{
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function readPoh($getOrder)
	{
		$query = "select * from poh where poh.order = $getOrder";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	//function  created by salman on 23/03/2023

	function getPoh($getPage, $records_per_page)
	{
		$query = "select * from poh where isdel = 0 order by tstamp LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $getPage, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getBroudysPOH($getTstamp)
	{
		$thisTstamp = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select `order`,store,vendor,vcode,status,rcvdate,total,invoicenbr,tstamp from poh where tstamp > '$thisTstamp'";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}


	function getPohNumbers($getFromDate)
	{
		$thisDate = date('Y-m-d', strtotime($getFromDate));
		$query = "select poh.order,poh.vcode from poh where poh.vendor != 99999 and poh.isdel = 0 and poh.orddate >= '$thisDate' order by `order`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getUpdatedpoh($getTstamp, $startingRecord, $records_per_page)
	{
		$thisDate = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from poh where tstamp > '$thisDate'  LIMIT ?,?";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $startingRecord, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt;
	}

	function getVendorPOH($getVendor, $getTstamp)
	{
		$thisTstamp = date('Y-m-d H:i:s', strtotime($getTstamp));
		$query = "select * from poh where vendor = $getVendor and tstamp > '$thisTstamp'";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getVNDPOH($getVendor)
	{
		$query = "select `order`,vendor,status,contact,promdate,rcvdate,customer,total,store from poh where vendor = $getVendor and isdel=0 order by status,promdate,`order` ASC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function readPohUpdate($getStartdate, $getStore, $getVendor, $getInvoice, $getOrder, $getStatus)
	{
		$thisStartDate = date('Y-m-d', strtotime($getStartdate));
		$stringSearch = '';
		//$getInvoice="'".$getInvoice."'"; //by sumeeth // commented by ruthvik (Date: 28 Feb 2023) - to remove string 

		if ($getVendor != 0) {
			$stringSearch = " and vendor =" . $getVendor . " ";
		}
		if ($getStore != 0) {
			$stringSearch = $stringSearch . " and `store` =" . $getStore . " ";
		}
		if ($getInvoice != '') {
			$stringSearch = $stringSearch . " and `invoicenbr` ='" . $getInvoice . "'"; // added (') with in double qoutes by ruthvik (Date: 28 Feb 2023)

		}
		if ($getOrder != 0) {
			$stringSearch = $stringSearch . " and `order` =" . $getOrder . " ";
		}
		if ($getStatus != '') {
			$stringSearch = $stringSearch . " and `status` =" . $getStatus . " ";
		}
		$query = "select `order`,status,contact,promdate,rcvdate,customer,total,store,vcode from poh where promdate >= '$thisStartDate' and isdel=0 " . $stringSearch . " order by status,promdate,`order` ASC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function getLastPoh($getStore)
	{
		$query = "select max(`order`) as ordernum from poh where vendor < 999990 and `order` < (($getStore+1)*1000000)";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function deleteOrder($getOrder)
	{
		$query = "update pod set isdel=1, `tstamp`=NOW() where pod.order = $getOrder";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$query = "update poh set isdel=1,`tstamp`=NOW() where poh.order = $getOrder";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function findOrderPO($getOrder)
	{
		$query = "select vendor from poh where poh.order = $getOrder and isdel = '0'";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function findOrderInvoice($getInvoice)
	{
		$getInvoice = "'" . $getInvoice . "'";//added by sumeeth for getinvoice with quotes format	  
		$query = "select vendor from poh where poh.invoicenbr = $getInvoice and isdel = '0'";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function updatePOH()
	{

		$query = "INSERT INTO poh (`order`,store,vendor,vcode,pay_vendor,contact,phone,status,orddate,promdate,rcvdate,agedate,whoreq,whoord,whorcv,terms,shipvia,
								   customer,taxcode,total,lastline,transact,lstore,lreg,who,tstamp,memo,discounts,tax,newdeposit,rtndeposit,freight,salesman,transfer,
								   includedep,invoicenbr,repost,postcost,bdrips,sent,applytax,applycred,applyship,applybdrip,approved,cstore,isdel) VALUES 
								   (:order,:store,:vendor,:vcode,:pay_vendor,:contact,:phone,:status,:orddate,:promdate,:rcvdate,:agedate,:whoreq,:whoord,:whorcv,:terms,:shipvia,
								   :customer,:taxcode,:total,:lastline,:transact,:lstore,:lreg,:who,NOW(),:memo,:discounts,:tax,:newdeposit,:rtndeposit,:freight,:salesman,:transfer,
								   :includedep,:invoicenbr,:repost,:postcost,:bdrips,:sent,:applytax,:applycred,:applyship,:applybdrip,:approved,:cstore,:isdel)
				  ON DUPLICATE KEY UPDATE
						store = :store,
						vendor = :vendor,
						vcode = :vcode,
						pay_vendor = :pay_vendor,
						contact = :contact,
						phone = :phone,
						status = :status,
						orddate = :orddate,
						promdate = :promdate,
						rcvdate = :rcvdate,
						agedate = :agedate,
						whoreq = :whoreq,
						whoord = :whoord,
						whorcv = :whorcv,
						terms = :terms,
						shipvia = :shipvia,
						customer = :customer,
						taxcode = :taxcode,
						total = :total,
						lastline = :lastline,
						transact = :transact,
						lstore = :lstore,
						lreg = :lreg,
						who = :who,
						tstamp = NOW(),
						memo = :memo,
						discounts = :discounts,
						tax = :tax,
						newdeposit = :newdeposit,
						rtndeposit = :rtndeposit,
						freight = :freight,
						salesman = :salesman,
						transfer = :transfer,
						includedep = :includedep,
						invoicenbr = :invoicenbr,
						repost = :repost,
						postcost = :postcost,
						bdrips = :bdrips,
						sent = :sent,
						applytax = :applytax,
						applycred = :applycred,
						applyship = :applyship,
						applybdrip = :applybdrip,
						approved = :approved,
						cstore = :cstore,
						isdel = :isdel";

		$stmt = $this->conn->prepare($query);

		$this->order = strip_tags($this->order);
		$this->store = strip_tags($this->store);
		$this->vendor = strip_tags($this->vendor);
		$this->vcode = strip_tags($this->vcode);
		$this->pay_vendor = strip_tags($this->pay_vendor);
		$this->contact = strip_tags($this->contact);
		$this->phone = strip_tags($this->phone);
		$this->status = strip_tags($this->status);
		$this->orddate = strip_tags($this->orddate);
		$this->promdate = strip_tags($this->promdate);
		$this->rcvdate = strip_tags($this->rcvdate);
		$this->agedate = strip_tags($this->agedate);
		$this->whoreq = strip_tags($this->whoreq);
		$this->whoord = strip_tags($this->whoord);
		$this->whorcv = strip_tags($this->whorcv);
		$this->terms = strip_tags($this->terms);
		$this->shipvia = strip_tags($this->shipvia);
		$this->customer = strip_tags($this->customer);
		$this->taxcode = strip_tags($this->taxcode);
		$this->total = strip_tags($this->total);
		$this->lastline = strip_tags($this->lastline);
		$this->transact = strip_tags($this->transact);
		$this->lstore = strip_tags($this->lstore);
		$this->lreg = strip_tags($this->lreg);
		$this->who = strip_tags($this->who);
		$this->memo = strip_tags($this->memo);
		$this->discounts = strip_tags($this->discounts);
		$this->tax = strip_tags($this->tax);
		$this->newdeposit = strip_tags($this->newdeposit);
		$this->rtndeposit = strip_tags($this->rtndeposit);
		$this->freight = strip_tags($this->freight);
		$this->salesman = strip_tags($this->salesman);
		$this->transfer = strip_tags($this->transfer);
		$this->includedep = strip_tags($this->includedep);
		$this->invoicenbr = strip_tags($this->invoicenbr);
		$this->repost = strip_tags($this->repost);
		$this->postcost = strip_tags($this->postcost);
		$this->bdrips = strip_tags($this->bdrips);
		$this->sent = strip_tags($this->sent);
		$this->applytax = strip_tags($this->applytax);
		$this->applycred = strip_tags($this->applycred);
		$this->applyship = strip_tags($this->applyship);
		$this->applybdrip = strip_tags($this->applybdrip);
		$this->approved = strip_tags($this->approved);
		$this->cstore = strip_tags($this->cstore);
		$this->isdel = strip_tags($this->isdel);

		$stmt->bindParam(':order', $this->order);
		$stmt->bindParam(':store', $this->store);
		$stmt->bindParam(':vendor', $this->vendor);
		$stmt->bindParam(':vcode', $this->vcode);
		$stmt->bindParam(':pay_vendor', $this->pay_vendor);
		$stmt->bindParam(':contact', $this->contact);
		$stmt->bindParam(':phone', $this->phone);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':orddate', $this->orddate);
		$stmt->bindParam(':promdate', $this->promdate);
		$stmt->bindParam(':rcvdate', $this->rcvdate);
		$stmt->bindParam(':agedate', $this->agedate);
		$stmt->bindParam(':whoreq', $this->whoreq);
		$stmt->bindParam(':whoord', $this->whoord);
		$stmt->bindParam(':whorcv', $this->whorcv);
		$stmt->bindParam(':terms', $this->terms);
		$stmt->bindParam(':shipvia', $this->shipvia);
		$stmt->bindParam(':customer', $this->customer);
		$stmt->bindParam(':taxcode', $this->taxcode);
		$stmt->bindParam(':total', $this->total);
		$stmt->bindParam(':lastline', $this->lastline);
		$stmt->bindParam(':transact', $this->transact);
		$stmt->bindParam(':lstore', $this->lstore);
		$stmt->bindParam(':lreg', $this->lreg);
		$stmt->bindParam(':who', $this->who);
		$stmt->bindParam(':memo', $this->memo);
		$stmt->bindParam(':discounts', $this->discounts);
		$stmt->bindParam(':tax', $this->tax);
		$stmt->bindParam(':newdeposit', $this->newdeposit);
		$stmt->bindParam(':rtndeposit', $this->rtndeposit);
		$stmt->bindParam(':freight', $this->freight);
		$stmt->bindParam(':salesman', $this->salesman);
		$stmt->bindParam(':transfer', $this->transfer);
		$stmt->bindParam(':includedep', $this->includedep);
		$stmt->bindParam(':invoicenbr', $this->invoicenbr);
		$stmt->bindParam(':repost', $this->repost);
		$stmt->bindParam(':postcost', $this->postcost);
		$stmt->bindParam(':bdrips', $this->bdrips);
		$stmt->bindParam(':sent', $this->sent);
		$stmt->bindParam(':applytax', $this->applytax);
		$stmt->bindParam(':applycred', $this->applycred);
		$stmt->bindParam(':applyship', $this->applyship);
		$stmt->bindParam(':applybdrip', $this->applybdrip);
		$stmt->bindParam(':approved', $this->approved);
		$stmt->bindParam(':cstore', $this->cstore);
		$stmt->bindParam(':isdel', $this->isdel);

		if ($stmt->execute()) {
			return 'OK';
		} else {
			$stmtError = $stmt->errorInfo();
			return $stmtError;
		}
	}
}

?>