<?php
class spirits
{
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function readPoll()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisRegname = $this->regname;
		$thisRegnum = $this->regnum;
		$query = "SELECT regnum from monreg where regnum = $thisRegnum";
		$stmt = $this->conn->Execute($query);
		if ($stmt->eof) {
			return False;
		} else {
			return True;
		}
	}

	function updatePol()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisRegname = $this->regname;
		$thisRegnum = $this->regnum;
		$query = "update monreg set regname = '$thisRegname', lupdate = datetime() where regnum = $thisRegnum";
		$stmt = $this->conn->Execute($query);
		if ($stmt == False) {
			return False;
		} else {
			return True;
		}
	}

	function getUpdatedBrowseTable($getTstamp, $getStore)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$thisStore = $getStore;
		//echo $thisTstamp;
		$this->conn->Execute('SET DELETED OFF');
		$query = "select alltrim(str(prc.price,8,2)) as price,alltrim(str(prc.sale,8,2)) as sale,alltrim(str(inv.invclub,8,2)) as club,inv.pack,inv.sku,inv.sname,inv.name,(stk.back+stk.floor) as stock,inv.type,iif(empty(tags),.F.,.T.) as tags,stk.stat,stk.sloc
		from inv,prc,stk where prc.sku=inv.sku and stk.sku=inv.sku and prc.level = '1' and (inv.tstamp > ctot('$thisTstamp') or stk.tstamp > ctot('$thisTstamp') or prc.tstamp > ctot('$thisTstamp')) and stk.store = $thisStore";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readBrowseTable($thisStore)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "select alltrim(str(prc.price,8,2)) as price,alltrim(str(prc.sale,8,2)) as sale,alltrim(str(inv.invclub,8,2)) as club,inv.pack,inv.sku,inv.sname,inv.name,(stk.back+stk.floor) as stock,inv.type,iif(empty(tags),.F.,.T.) as tags,stk.stat,stk.sloc,inv.typename
		from inv,prc,stk where prc.sku=inv.sku and stk.sku=inv.sku and prc.level = '1' and stk.store = $thisStore";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}
	/* 	select prc.price,prc.sale,inv.invclub,inv.pack,inv.sku,inv.sname,inv.name,stk.back from inv,prc,stk where prc.sku=inv.sku and stk.sku=inv.sku and prc.level = '1' and (inv.tstamp > {7/21/2020} or stk.tstamp > {7/25/2020} or prc.tstamp > {7/21/2020}) and stk.store = $thisStore
	 */
	function readInv($starting_record_num, $ending_record_num)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT sku,name,ml,ssku,sname,pack,cat,scat,alltrim(str(acost,8,2)) as acost,alltrim(str(lcost,8,2)) as lcost,depos,unit_case,type,vintage,fson,stat,
		iif(empty(tags),.F.,.T.) as tags,iif(empty(memo),.F.,.T.) as memo,ttoc(tstamp,1) as tstamp
		from INV where between(recno(),$starting_record_num, $ending_record_num) order by sku";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readOneInv()
	{

		$this->conn->Execute('SET DELETED OFF');
		$thisSku = $this->sku;
		$query = "SELECT sku,name,ml,ssku,sname,pack,cat,scat,alltrim(str(acost,8,2)) as acost,alltrim(str(lcost,8,2)) as lcost,depos,
		unit_case,type,vintage,fson,stat,ttoc(tstamp,1) as tstamp,deleted() as isdeleted from INV where sku = $thisSku";
		$stmt = $this->conn->Execute($query);

		$this->sku = $stmt->Fields("sku")->value;
		$this->name = $stmt->Fields("name")->value;
		$this->ml = $stmt->Fields("ml")->value;
		$this->sname = $stmt->Fields("sname")->value;
		$this->ssku = $stmt->Fields("ssku")->value;
		$this->pack = $stmt->Fields("pack")->value;
		$this->tstamp = $stmt->Fields("tstamp")->value;
		$this->cat = $stmt->Fields("cat")->value;
		$this->scat = $stmt->Fields("scat")->value;
		$this->acost = $stmt->Fields("acost")->value;
		$this->lcost = $stmt->Fields("lcost")->value;
		$this->depos = $stmt->Fields("depos")->value;
		$this->unit_case = $stmt->Fields("unit_case")->value;
		$this->type = $stmt->Fields("type")->value;
		$this->vintage = $stmt->Fields("vintage")->value;
		$this->stat = $stmt->Fields("stat")->value;
		$this->fson = $stmt->Fields("fson")->value;
		$this->isdeleted = $stmt->Fields("isdeleted")->value;
	}

	function getUpdatedInv($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		//echo $thisTstamp;
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT sku,name,ml,ssku,sname,pack,cat,scat,alltrim(str(acost,8,2)) as acost,alltrim(str(lcost,8,2)) as lcost,depos,iif(empty(tags),.F.,.T.) as tags,iif(empty(memo),.F.,.T.) as memo,
		unit_case,type,vintage,fson,stat,ttoc(tstamp,1) as tstamp,deleted() as isdeleted from INV where inv.tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;

	}

	function getUpdatedOhd($getCustomer)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT order,store,customer,shipto,contact,phone,status,dtoc(orddate,1) as orddate,dtoc(promdate,1) as promdate,dtoc(shipdate,1) as shipdate,dtoc(invdate,1) as invdate,dtoc(agedate,1) as agedate,whosold,whoorder,whoship,whoinvoice,terms,shipvia,taxcode,alltrim(str(total,8,2)) as total,
			iif(empty(printmemo),.F.,.T.) as printmemo,iif(empty(shipmemo),.F.,.T.) as shipmemo,iif(empty(memo),.F.,.T.) as memo from ohd where ohd.customer = $getCustomer";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedOhdReg($getCustomer)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT order,store,status,dtoc(orddate,1) as orddate,dtoc(promdate,1) as promdate,dtoc(shipdate,1) as shipdate,dtoc(invdate,1) as invdate,alltrim(str(total,8,2)) as total from ohd where ohd.customer = $getCustomer";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedOhdOrder($getOrder, $getStore)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT order,store,customer,shipto,contact,phone,status,dtoc(orddate,1) as orddate,dtoc(promdate,1) as promdate,dtoc(shipdate,1) as shipdate,dtoc(invdate,1) as invdate,dtoc(agedate,1) as agedate,whosold,whoorder,whoship,whoinvoice,terms,shipvia,taxcode,alltrim(str(total,8,2)) as total,
			iif(empty(printmemo),.F.,.T.) as printmemo,iif(empty(shipmemo),.F.,.T.) as shipmemo,iif(empty(memo),.F.,.T.) as memo from ohd where ohd.order = $getOrder and ohd.store = $getStore";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedOdd($getOrder, $getStore)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT order,store,line,sku,status,customer,dtoc(orddate,1) as orddate,dtoc(agedate,1) as agedate,qty,pack,descript,alltrim(str(price,8,2)) as price,alltrim(str(cost,8,2)) as cost,alltrim(str(discount,8,2)) as discount,
			promo,alltrim(str(dflag,1,0)) as dflag,dclass,alltrim(str(damount,8,2)) as damount,alltrim(str(taxlevel,1,0)) as taxlevel,surcharge,cat,location,dml,cpack,onsale,freeze,alltrim(str(extax,8,2)) as extax,iif(empty(memo),.F.,.T.) as memo from odd where odd.order = $getOrder and odd.store = $getStore";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readPrc($starting_record_num, $ending_record_num)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT sku,level,qty,alltrim(str(price,8,2)) as price,promo,onsale,store,dcode,alltrim(str(sale,8,2)) as sale,
		ttoc(tstamp,1) as tstamp from prc where between(recno(),$starting_record_num, $ending_record_num) order by sku";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readOnePrc()
	{

		$this->conn->Execute('SET DELETED OFF');
		$thisSku = $this->sku;
		$thisLevel = $this->level;
		$thisStore = $this->store;

		$query = "SELECT sku,level,qty,alltrim(str(price,8,2)) as price,promo,onsale,store,dcode,alltrim(str(sale,8,2)) as sale,
		ttoc(tstamp,1) as tstamp,deleted() as isdeleted from prc where sku = $thisSku and level = alltrim(str($thisLevel)) and store = $thisStore";
		$stmt = $this->conn->Execute($query);

		$this->sku = $stmt->Fields("sku")->value;
		$this->level = $stmt->Fields("level")->value;
		$this->qty = $stmt->Fields("qty")->value;
		$this->price = $stmt->Fields("price")->value;
		$this->promo = $stmt->Fields("promo")->value;
		$this->onsale = $stmt->Fields("onsale")->value;
		$this->store = $stmt->Fields("store")->value;
		$this->dcode = $stmt->Fields("dcode")->value;
		$this->sale = $stmt->Fields("sale")->value;
		$this->tstamp = $stmt->Fields("tstamp")->value;
		$this->isdeleted = $stmt->Fields("isdeleted")->value;
	}

	function getUpdatedPrc($getTstamp)
	{

		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		//echo $thisTstamp;
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT sku,level,qty,alltrim(str(price,8,2)) as price,promo,onsale,store,dcode,alltrim(str(sale,8,2)) as sale,ttoc(tstamp,1) as tstamp,deleted() as isdeleted from prc where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;

	}

	function readupc($starting_record_num, $ending_record_num)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT sku,level,upc,dtoc(last,1) as last,ttoc(tstamp,1) as tstamp from upc where between(recno(),$starting_record_num, $ending_record_num) order by sku";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readOneUpc()
	{

		$this->conn->Execute('SET DELETED OFF');
		$thisSku = $this->sku;
		$thisUpc = $this->upc;

		$query = "SELECT sku,level,upc,dtoc(last,1) as last,ttoc(tstamp,1) as tstamp,deleted() as isdeleted from upc where sku = $thisSku and upc = alltrim(str($thisUpc))";
		$stmt = $this->conn->Execute($query);

		$this->sku = $stmt->Fields("sku")->value;
		$this->level = $stmt->Fields("level")->value;
		$this->last = $stmt->Fields("last")->value;
		$this->upc = $stmt->Fields("upc")->value;
		$this->tstamp = $stmt->Fields("tstamp")->value;
		$this->isdeleted = $stmt->Fields("isdeleted")->value;
	}

	function getUpdatedUpc($getTstamp)
	{

		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		//echo $thisTstamp;
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT sku,level,upc,dtoc(last,1) as last,ttoc(tstamp,1) as tstamp,deleted() as isdeleted from upc where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;

	}

	function getUpdatedFs($getcustomer)
	{
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT alltrim(str(fscpts,8,2)) as fscpts,alltrim(str(fstpts,8,2)) as fstpts,alltrim(str(fsdlrval,8,2)) as fsdlrval,alltrim(str(fsdlrcrdts,8,2)) as fsdlrcrdts,fson from cus where customer = $getcustomer";
		$stmt = $this->conn->Execute($query);
		return $stmt;

	}

	function readstk($starting_record_num, $ending_record_num)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT sku,store,floor,back,shipped,kits,ware,vintage,stat,depos,alltrim(str(acost,8,2)) as acost,alltrim(str(lcost,8,2)) as lcost,alltrim(str(mincost,8,2)) as mincost,
		ttoc(tstamp,1) as tstamp,alltrim(str(recno(),10,0)) as recid from stk where between(recno(),$starting_record_num, $ending_record_num) order by sku";
		$stmt = $this->conn->Execute($query);
		return $stmt;
		if ($stmt->eof) {
			return False;
		} else {
			return True;
		}
	}

	function readOneStk()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisSku = $this->sku;
		$thisStore = $this->store;
		$query = "SELECT sku,store from stk where sku = $thisSku and store = $thisStore";
		$stmt = $this->conn->Execute($query);
		if ($stmt->eof) {
			return False;
		} else {
			return True;
		}
	}

	function updateStk()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisSku = $this->sku;
		$thisStore = $this->store;
		$thisSDate = date('m-d-Y', strtotime($this->sdate));
		$thisback = $this->back;
		$thisfloor = $this->floor;
		$thiskits = $this->kits;
		$thisshipped = $this->shipped;
		$thiswho = $this->who;
		$query = "update stk set stk.back = stk.back + $thisback, stk.floor = stk.floor+$thisfloor, stk.kits = stk.kits+$thiskits, stk.sdate=ctod('$thisSDate'),
		stk.lstore = $thisStore, stk.sent = .F., stk.tstamp = datetime(), stk.who = '$thiswho'
		where stk.sku = $thisSku and stk.store = $thisStore";
		$stmt = $this->conn->Execute($query);
		if ($stmt == False) {
			return False;
		} else {
			return True;
		}
	}

	function createStk()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisSku = $this->sku;
		$thisStore = $this->store;
		$thisSDate = date('m-d-Y', strtotime($this->sdate));
		$thisback = $this->back;
		$thisfloor = $this->floor;
		$thiskits = $this->kits;
		$thisshipped = $this->shipped;
		$query = "insert into stk (sku,store,floor,back,shipped,kits,stat,mtd_units,weeks,sdate,mtd_dol,mtd_prof,ytd_units,ytd_dol,ytd_prof,acost,lcost,pvend,lvend,pdate,smin,sord,sweeks,freeze_w,shelf,rshelf,sloc,bloc,lstore,who,tstamp,inet,depos,skipstat,mincost,base,sent,ware,vintage,gosent)
		values
		($thisSku,$thisStore,$thisfloor,$thisback,$thisshipped,$thiskits,'2',0,0,ctod('$thisSDate'),0,0,0,0,0,0,0,'','',{//},0,0,0,.f.,0,0,'','',$thisStore,'pol',datetime(),0,'',.f.,0,0,.f.,0,'',.f.)";
		$stmt = $this->conn->Execute($query);
		if ($stmt == False) {
			return False;
		} else {
			return True;
		}
	}

	function readOneHst()
	{

		$this->conn->Execute('SET DELETED ON');
		$thisSku = $this->sku;
		$thisStore = $this->store;
		$thisDate = date('m-d-Y', strtotime($this->date));
		$thisPromo = $this->promo;
		$thisPack = $this->pack;
		$query = "SELECT sku,store,alltrim(promo) as promo,dtoc(hst.date) as date from hst where pack = $thisPack and sku = $thisSku and store = $thisStore and hst.promo = '$thisPromo' and hst.date=ctod('$thisDate')";
		$stmt = $this->conn->Execute($query);
		if ($stmt->eof) {
			return False;
		} else {
			return True;
		}

	}

	function updateHst()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisSku = $this->sku;
		$thisStore = $this->store;
		$thisDate = date('m-d-Y', strtotime($this->date));
		$thisPromo = $this->promo;
		$thisQty = $this->qty;
		$thisPrice = $this->price;
		$thisCost = $this->cost;
		$thisPack = $this->pack;
		$thisWho = $this->who;
		$thislvlqty = $this->lvlqty;
		if ($thislvlqty == '1') {
			$query = "Update hst set hst.qty = hst.qty + $thisQty, hst.price = hst.price + $thisPrice, hst.cost = hst.cost+$thisCost, hst.who = '$thisWho', hst.tstamp = datetime(),
				hst.lvl1qty = hst.lvl1qty + $thisQty,hst.lvl1price = hst.lvl1price + $thisPrice,hst.lvl1cost = hst.lvl1cost + $thisCost,hst.sent = .F.
				where pack = $thisPack and sku = $thisSku and store = $thisStore and hst.promo = '$thisPromo' and hst.date=ctod('$thisDate')";
		} elseif ($thislvlqty == '2') {
			$query = "Update hst set hst.qty = hst.qty + $thisQty, hst.price = hst.price + $thisPrice, hst.cost = hst.cost+$thisCost, hst.who = '$thisWho', hst.tstamp = datetime(),
				hst.lvl2qty = hst.lvl2qty + $thisQty,hst.lvl2price = hst.lvl2price + $thisPrice,hst.lvl2cost = hst.lvl2cost + $thisCost,hst.sent = .F.				
				where pack = $thisPack and sku = $thisSku and store = $thisStore and hst.promo = '$thisPromo' and hst.date=ctod('$thisDate')";
		} elseif ($thislvlqty == '3') {
			$query = "Update hst set hst.qty = hst.qty + $thisQty, hst.price = hst.price + $thisPrice, hst.cost = hst.cost+$thisCost, hst.who = '$thisWho', hst.tstamp = datetime(),
				hst.lvl3qty = hst.lvl3qty + $thisQty,hst.lvl3price = hst.lvl3price + $thisPrice,hst.lvl3cost = hst.lvl3cost + $thisCost,hst.sent = .F.				
				where pack = $thisPack and sku = $thisSku and store = $thisStore and hst.promo = '$thisPromo' and hst.date=ctod('$thisDate')";
		} elseif ($thislvlqty == '4') {
			$query = "Update hst set hst.qty = hst.qty + $thisQty, hst.price = hst.price + $thisPrice, hst.cost = hst.cost+$thisCost, hst.who = '$thisWho', hst.tstamp = datetime(),
				hst.lvl4qty = hst.lvl4qty + $thisQty,hst.lvl4price = hst.lvl4price + $thisPrice,hst.lvl4cost = hst.lvl4cost + $thisCost,hst.sent = .F.				
				where pack = $thisPack and sku = $thisSku and store = $thisStore and hst.promo = '$thisPromo' and hst.date=ctod('$thisDate')";
		}
		$stmt = $this->conn->Execute($query);
		if ($stmt == False) {
			return False;
		} else {
			return True;
		}

	}

	function createHst()
	{
		$this->conn->Execute('SET NULL ON');
		$thisSku = $this->sku;
		$thisStore = $this->store;
		$thisDate = date('m-d-Y', strtotime($this->date));
		$thisPromo = $this->promo;
		$thisQty = $this->qty;
		$thisPrice = $this->price;
		$thisCost = $this->cost;
		$thisWho = $this->who;
		$thisPack = $this->pack;
		$thislvlqty = $this->lvlqty;

		if ($thislvlqty == '1') {
			$thisLvl1qty = $thisQty;
			$thisLvl1price = $thisPrice;
			$thisLvl1cost = $thisCost;
			$thisLvl2qty = 0;
			$thisLvl2price = 0.00;
			$thisLvl2cost = 0.00;
			$thisLvl3qty = 0;
			$thisLvl3price = 0.00;
			$thisLvl3cost = 0.00;
			$thisLvl4qty = 0;
			$thisLvl4price = 0.00;
			$thisLvl4cost = 0.00;
		} elseif ($thislvlqty == '2') {
			$thisLvl1qty = 0;
			$thisLvl1price = 0.00;
			$thisLvl1cost = 0.00;
			$thisLvl2qty = $thisQty;
			$thisLvl2price = $thisPrice;
			$thisLvl2cost = $thisCost;
			$thisLvl3qty = 0;
			$thisLvl3price = 0.00;
			$thisLvl3cost = 0.00;
			$thisLvl4qty = 0;
			$thisLvl4price = 0.00;
			$thisLvl4cost = 0.00;
		} elseif ($thislvlqty == '3') {
			$thisLvl1qty = 0;
			$thisLvl1price = 0.00;
			$thisLvl1cost = 0.00;
			$thisLvl2qty = 0;
			$thisLvl2price = 0.00;
			$thisLvl2cost = 0.00;
			$thisLvl3qty = $thisQty;
			$thisLvl3price = $thisPrice;
			$thisLvl3cost = $thisCost;
			$thisLvl4qty = 0;
			$thisLvl4price = 0.00;
			$thisLvl4cost = 0.00;
		} elseif ($thislvlqty == '4') {
			$thisLvl1qty = 0;
			$thisLvl1price = 0.00;
			$thisLvl1cost = 0.00;
			$thisLvl2qty = 0;
			$thisLvl2price = 0.00;
			$thisLvl2cost = 0.00;
			$thisLvl3qty = 0;
			$thisLvl3price = 0.00;
			$thisLvl3cost = 0.00;
			$thisLvl4qty = $thisQty;
			$thisLvl4price = $thisPrice;
			$thisLvl4cost = $thisCost;
		}
		$query = "insert into hst (sku,date,edate,qty,price,cost,promo,store,pack,who,tstamp,lvl1qty,lvl1price,lvl1cost,lvl2qty,lvl2price,lvl2cost,lvl3qty,lvl3price,lvl3cost,lvl4qty,lvl4price,lvl4cost,sent) 
				values ($thisSku,ctod('$thisDate'),{//},$thisQty,$thisPrice,$thisCost,'$thisPromo',$thisStore,$thisPack,'$thisWho',datetime(),$thisLvl1qty,$thisLvl1price,$thisLvl1cost,$thisLvl2qty,$thisLvl2price,$thisLvl2cost,$thisLvl3qty,$thisLvl3price,$thisLvl3cost,$thisLvl4qty,$thisLvl4price,$thisLvl4cost,.F.)";
		//$query = "Update hst set hst.qty = hst.qty + $thisQty, hst.price = hst.price + $thisPrice, hst.cost = hst.cost+$thisCost, hst.who = '$thisWho', hst.tstamp = datetime() 
		//where sku = $thisSku and store = $thisStore and hst.promo = '$thisPromo' and hst.date=ctod('$thisDate')";
		$stmt = $this->conn->Execute($query);
		if ($stmt == False) {
			return False;
		} else {
			return True;
		}

	}


	function readOneOhd()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisOrder = $this->order;
		$thisStore = $this->store;
		$query = "SELECT order,store from ohd where order = $thisOrder and store = $thisStore";
		$stmt = $this->conn->Execute($query);
		if ($stmt->eof) {
			return False;
		} else {
			return True;
		}
	}


	function updateOhd()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisorder = $this->order;
		$thisstore = $this->store;
		$thiscustomer = $this->customer;
		$thisshipto = $this->shipto;
		$thiscontact = $this->contact;
		$thisphone = $this->phone;
		$thisstatus = $this->status;
		$thisorddate = date('m-d-Y', strtotime($this->orddate));
		$thispromdate = date('m-d-Y', strtotime($this->promdate));
		$thisshipdate = date('m-d-Y', strtotime($this->shipdate));
		$thisinvdate = date('m-d-Y', strtotime($this->invdate));
		$thisagedate = date('m-d-Y', strtotime($this->agedate));
		$thiswhosold = $this->whosold;
		$thiswhoship = $this->whoship;
		$thiswhoinvoice = $this->whoinvoice;
		$thiswhoorder = $this->whoorder;
		$thisterms = $this->terms;
		$thisshipvia = $this->shipvia;
		$thistaxcode = $this->taxcode;
		$thistotal = $this->total;
		$thisprintmemo = $this->printmemo;
		$thisshipmemo = $this->shipmemo;
		$thismemo = $this->memo;
		$thisisdel = $this->isdel;
		if ($thisisdel == 'True') {
			$query = "delete from ohd where order = $thisorder and store = $thisstore";
		} else {
			$query = "update ohd set customer = $thiscustomer, shipto = $thisshipto,contact='$thiscontact',phone='$thisphone',status='$thisstatus',orddate=ctod('$thisorddate'),promdate=ctod('$thispromdate'),shipdate=ctod('$thisshipdate'),
		invdate=ctod('$thisinvdate'),agedate=ctod('$thisagedate'),whosold='$thiswhosold',whoship='$thiswhoship',whoinvoice='$thiswhoinvoice',terms='$thisterms',shipvia='$thisshipvia',taxcode='$thistaxcode',total=$thistotal,printmemo='$thisprintmemo',
		shipmemo='$thisshipmemo',memo = '$thismemo',who='pos',tstamp =datetime() where order = $thisorder and store = $thisstore";
		}
		$stmt = $this->conn->Execute($query);
		if ($stmt == False) {
			return False;
		} else {
			return True;
		}
	}

	function createOhd()
	{
		$this->conn->Execute('SET NULL ON');
		$thisorder = $this->order;
		$thisstore = $this->store;
		$thiscustomer = $this->customer;
		$thisshipto = $this->shipto;
		$thiscontact = $this->contact;
		$thisphone = $this->phone;
		$thisstatus = $this->status;
		$thisorddate = date('m-d-Y', strtotime($this->orddate));
		$thispromdate = date('m-d-Y', strtotime($this->promdate));
		$thisshipdate = date('m-d-Y', strtotime($this->shipdate));
		$thisinvdate = date('m-d-Y', strtotime($this->invdate));
		$thisagedate = date('m-d-Y', strtotime($this->agedate));
		$thiswhosold = $this->whosold;
		$thiswhoship = $this->whoship;
		$thiswhoinvoice = $this->whoinvoice;
		$thiswhoorder = $this->whoorder;
		$thisterms = $this->terms;
		$thisshipvia = $this->shipvia;
		$thistaxcode = $this->taxcode;
		$thistotal = $this->total;
		$thisprintmemo = $this->printmemo;
		$thisshipmemo = $this->shipmemo;
		$thismemo = $this->memo;
		$thisisdel = $this->isdel;
		if ($thisisdel == 'True') {
			return True;
		} else {
			$query = "insert into ohd (order,store,customer,shipto,contact,phone,status,orddate,promdate,shipdate,invdate,agedate,whosold,whoorder,whoship,whoinvoice,terms,shipvia,taxcode,total,transact,
		printmemo,lreg,lstore,who,tstamp,shipmemo,memo,creditcard,expire,cvv,sent) 
				values ($thisorder,$thisstore,$thiscustomer,$thisshipto,'$thiscontact','$thisphone','$thisstatus',ctod('$thisorddate'),ctod('$thispromdate'),ctod('$thisshipdate'),ctod('$thisinvdate'),
				ctod('$thisagedate'),'$thiswhosold','$thiswhoorder','$thiswhoship','$thiswhoinvoice','$thisterms','$thisshipvia','$thistaxcode',$thistotal,0,'$thisprintmemo',0,$thisstore,'pos',datetime(),
				'$thisshipmemo','$thismemo','','','',.F.)";
			$stmt = $this->conn->Execute($query);
			if ($stmt == False) {
				return False;
			} else {
				return True;
			}
		}
	}

	function readOneOdd()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisOrder = $this->order;
		$thisStore = $this->store;
		$thisLine = $this->line;
		$query = "SELECT order,store,line from odd where order = $thisOrder and store = $thisStore and line = $thisLine";
		$stmt = $this->conn->Execute($query);
		if ($stmt->eof) {
			return False;
		} else {
			return True;
		}
	}

	function updateOdd()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisorder = $this->order;
		$thisstore = $this->store;
		$thisline = $this->line;
		$thissku = $this->sku;
		$thisstatus = $this->status;
		$thiscustomer = $this->customer;
		$thisorddate = date('m-d-Y', strtotime($this->orddate));
		$thisagedate = date('m-d-Y', strtotime($this->agedate));
		$thisqty = $this->qty;
		$thispack = $this->pack;
		$thisdescript = $this->descript;
		$thisprice = $this->price;
		$thiscost = $this->cost;
		$thisdiscount = $this->discount;
		$thispromo = $this->promo;
		$thisdflag = $this->dflag;
		$thisdclass = $this->dclass;
		$thisdamount = $this->damount;
		$thistaxlevel = $this->taxlevel;
		$thissurcharge = $this->surcharge;
		$thiscat = $this->cat;
		$thislocation = $this->location;
		$thisdml = $this->dml;
		$thiscpack = $this->cpack;
		$thisonsale = $this->onsale;
		$thisfreeze = $this->freeze;
		$thismemo = $this->memo;
		$thisbqty = $this->bqty;
		$thisextax = $this->extax;
		$thisisdel = $this->isdel;
		if ($thisisdel == 'True') {
			$query = "delete from odd where order = $thisorder and store = $thisstore and line = $thisline";
		} else {
			$query = "update odd set sku = $thissku,status = '$thisstatus',customer = $thiscustomer,orddate=ctod('$thisorddate'),agedate=ctod('$thisagedate'),qty=$thisqty,pack=$thispack,descript='$thisdescript',price=$thisprice,
		cost=$thiscost,discount=$thisdiscount,promo='$thispromo',dflag=$thisdflag,dclass='$thisdclass',damount=$thisdamount,taxlevel=$thistaxlevel,surcharge=iif('$thissurcharge'='true',.T.,.F.),cat='$thiscat',location='$thislocation',
		dml=$thisdml,cpack=$thiscpack,onsale=iif('$thisonsale'='true',.T.,.F.),freeze=iif('$thisfreeze'='true',.T.,.F.),memo='$thismemo',bqty=$thisbqty,extax=$thisextax where order = $thisorder and store = $thisstore and line = $thisline";
		}
		$stmt = $this->conn->Execute($query);
		if ($stmt == False) {
			return False;
		} else {
			return True;
		}
	}

	function createOdd()
	{
		$this->conn->Execute('SET NULL ON');
		$thisorder = $this->order;
		$thisstore = $this->store;
		$thisline = $this->line;
		$thissku = $this->sku;
		$thisstatus = $this->status;
		$thiscustomer = $this->customer;
		$thisorddate = date('m-d-Y', strtotime($this->orddate));
		$thisagedate = date('m-d-Y', strtotime($this->agedate));
		$thisqty = $this->qty;
		$thispack = $this->pack;
		$thisdescript = $this->descript;
		$thisprice = $this->price;
		$thiscost = $this->cost;
		$thisdiscount = $this->discount;
		$thispromo = $this->promo;
		$thisdflag = $this->dflag;
		$thisdclass = $this->dclass;
		$thisdamount = $this->damount;
		$thistaxlevel = $this->taxlevel;
		$thissurcharge = $this->surcharge;
		$thiscat = $this->cat;
		$thislocation = $this->location;
		$thisdml = $this->dml;
		$thiscpack = $this->cpack;
		$thisonsale = $this->onsale;
		$thisfreeze = $this->freeze;
		$thismemo = $this->memo;
		$thisbqty = $this->bqty;
		$thisextax = $this->extax;
		$thisisdel = $this->isdel;
		if ($thisisdel == 'True') {
			return True;
		} else {
			$query = "insert into odd (order,store,line,sku,status,customer,orddate,agedate,qty,pack,descript,price,cost,discount,promo,dflag,dclass,damount,taxlevel,surcharge,cat,location,dml,cpack,onsale,freeze,memo,bqty,extax) 
				values ($thisorder,$thisstore,$thisline,$thissku,'$thisstatus',$thiscustomer,ctod('$thisorddate'),ctod('$thisagedate'),
				$thisqty,$thispack,'$thisdescript',$thisprice,$thiscost,$thisdiscount,'$thispromo',$thisdflag,'$thisdclass',
				$thisdamount,$thistaxlevel,iif('$thissurcharge'='True',.T.,.F.),'$thiscat','$thislocation',$thisdml,$thiscpack,iif('$thisonsale'='True',.T.,.F.),iif('$thisfreeze'='True',.T.,.F.),
				'$thismemo',$thisbqty,$thisextax)";
			$stmt = $this->conn->Execute($query);
			if ($stmt == False) {
				return False;
			} else {
				return True;
			}
		}
	}





	function readOneGlb()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisDepartment = $this->department;
		$thisStore = $this->store;
		$thisDate = date('m-d-Y', strtotime($this->date));
		$thisGlaccount = $this->glaccount;
		$query = "SELECT department,store,glaccount,dtoc(glb.date) as date from glb where glb.department = $thisDepartment and glb.store = $thisStore and glb.glaccount = '$thisGlaccount' and glb.date=ctod('$thisDate')";
		$stmt = $this->conn->Execute($query);
		if ($stmt->eof) {
			return False;
		} else {
			return True;
		}

	}

	function updateGlb()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisDepartment = $this->department;
		$thisStore = $this->store;
		$thisDate = date('m-d-Y', strtotime($this->date));
		$thisGlaccount = $this->glaccount;
		$thisLamount = $this->lamount;
		$thisRamount = $this->ramount;
		$thiswho = $this->who;
		$query = "update glb set glb.lamount = glb.lamount + $thisLamount, glb.ramount = glb.ramount + $thisRamount, glb.who = '$thiswho', glb.sent = .F., glb.gosent = .F., glb.tstamp = datetime()
		where glb.glaccount = '$thisGlaccount' and glb.store = $thisStore and glb.date=ctod('$thisDate') and glb.department = $thisDepartment";
		$stmt = $this->conn->Execute($query);
		if ($stmt == False) {
			return False;
		} else {
			return True;
		}
	}

	function updateFS()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisLreg = $this->lreg;
		$thisStore = $this->store;
		$thisDate = date('m-d-Y', strtotime($this->sdate));
		$thisDcredits = $this->dcredits;
		$thisCredorpts = $this->credorpts;
		$thisSale = $this->sale;
		$thisCustomer = $this->customer;
		$thiswho = $this->who;
		$thisSaleTotal = $this->saletotal;
		/* 		$query = "SELECT sku,level,qty,alltrim(str(price,8,2)) as price,promo,onsale,store,dcode,alltrim(str(sale,8,2)) as sale,
					  ttoc(tstamp,1) as tstamp,deleted() as isdeleted from prc where sku = $thisSku and level = alltrim(str($thisLevel)) and store = $thisStore";
					  $stmt = $this->conn->Execute($query);

					  $this->sku = $stmt->Fields("sku")->value; */

		$query = "select fscpts,fsdlrcrdts from cus where cus.customer = $thisCustomer";
		$stmtgetcusrec = $this->conn->Execute($query);
		$thisFscpts = $stmtgetcusrec->Fields("fscpts")->value;
		$thisFsdlrcrdts = $stmtgetcusrec->Fields("fsdlrcrdts")->value;
		echo $thisCredorpts;
		if ($thisCredorpts == 'C') {
			$query = "insert into fshst (date,storeno,saleno,custid,dcredits,who,tstamp,lstore,lreg,timestamp,credorpts,sent,type,olddcredit,newdcredit) values	
					(ctod('$thisDate'),$thisStore,$thisSale,$thisCustomer,$thisDcredits,'$thiswho',datetime(),$thisStore,$thisLreg,datetime(),.F.,.F.,'S',$thisFsdlrcrdts,$thisFsdlrcrdts+$thisDcredits)";
		} else {
			$query = "insert into fshst (date,storeno,saleno,custid,dcredits,who,tstamp,lstore,lreg,timestamp,credorpts,sent,type,olddcredit,newdcredit) values	
					(ctod('$thisDate'),$thisStore,$thisSale,$thisCustomer,$thisDcredits,'$thiswho',datetime(),$thisStore,$thisLreg,datetime(),.T.,.F.,'S',$thisFscpts,$thisFscpts+$thisDcredits)";
		}

		$stmt2 = $this->conn->Execute($query);

		if ($thisCredorpts == 'C') {
			$query = "update cus set cus.fsdlrcrdts = cus.fsdlrcrdts + $thisDcredits,cus.FSDLRVAL = cus.fsdlrcrdts + $thisSaleTotal,cus.who = '$thiswho', cus.sent = .F., cus.tstamp = datetime() where cus.customer = $thisCustomer";
		} else {
			$query = "update cus set cus.fscpts = cus.fscpts + $thisDcredits,cus.fstpts = cus.fstpts + $thisDcredits,cus.FSDLRVAL = cus.fsdlrcrdts + $thisSaleTotal, cus.who = '$thiswho', cus.sent = .F., cus.tstamp = datetime() where cus.customer = $thisCustomer";
		}

		$stmt = $this->conn->Execute($query);
		if ($stmt == False) {
			return False;
		} else {
			return True;
		}
	}


	function createGlb()
	{
		$this->conn->Execute('SET DELETED ON');
		$thisDepartment = $this->department;
		$thisStore = $this->store;
		$thisDate = date('m-d-Y', strtotime($this->date));
		$thisGlaccount = $this->glaccount;
		$thisLamount = $this->lamount;
		$thisRamount = $this->ramount;
		$thiswho = $this->who;
		$query = "insert into glb (glaccount,date,store,department,edate,lamount,ramount,balance,records,freeze,who,tstamp,transact,consol,sent,gosent) values 
		('$thisGlaccount',ctod('$thisDate'),$thisStore,$thisDepartment,{//},$thisLamount,$thisRamount,0.00,1,.f.,'$thiswho',datetime(),0,.f.,.f.,.f.)";
		$stmt = $this->conn->Execute($query);
		if ($stmt == False) {
			return False;
		} else {
			return True;
		}
	}

	///$thisGlaccount,ctod('$thisDate'),$thisStore,$thisDepartment,{//},$thisLamount,$thisRamount,0.00,1,.f.,'ajs',datetime(),0,.f.,.f.,.f.";///

	function readOneJNH()
	{

		$this->conn->Execute('SET DELETED ON');
		$thisSale = $this->sale;
		$thisStore = $this->store;
		$query = "SELECT sale,store,dtoc(date) as date from jnh where sale = $thisSale and store = $thisStore";
		$stmt = $this->conn->Execute($query);
		if ($stmt->eof) {
			return False;
		} else {
			return True;
		}

	}

	function createJNH()
	{
		$this->conn->Execute('SET NULL ON');
		$thisDate = date('m-d-Y', strtotime($this->date));
		$thisstore = $this->store;
		$thisRegister = $this->register;
		$thisCashier = $this->cashier;
		$thisSale = $this->sale;
		$thisCustomer = $this->customer;
		$thisOrder = $this->order;
		$thistaxcode = $this->taxcode;
		$thistotal = $this->total;
		$thisMemo = $this->memo;
		$thisSignature = '';
		$thisReference = $this->reference;
		$thisAckrefno = $this->ackrefno;
		$query = "insert into jnh (date,store,register,cashier,sale,customer,order,taxcode,total,receipts,tstamp,memo,signature,reference,ackrefno,voided) values
				(ctod('$thisDate'),$thisstore,$thisRegister,$thisCashier,$thisSale,$thisCustomer,$thisOrder,'$thistaxcode',$thistotal,0,datetime(),'$thisMemo','$thisSignature','$thisReference','$thisAckrefno',.F.)";
		$stmt = $this->conn->Execute($query);
		if ($stmt == False) {
			return False;
		} else {
			return True;
		}

	}

	function createJNL()
	{
		$this->conn->Execute('SET NULL ON');
		$thisDate = date('m-d-Y', strtotime($this->date));
		$thisstore = $this->store;
		$thissale = $this->sale;
		$thisline = $this->line;
		$thisqty = $this->qty;
		$thispack = $this->pack;
		$thissku = $this->sku;
		$thisdescript = $this->descript;
		$thisprice = $this->price;
		$thiscost = $this->cost;
		$thisdiscount = $this->discount;
		$thisdclass = $this->dclass;
		$thispromo = $this->promo;
		$thiscat = $this->cat;
		$thislocation = $this->location;
		$thisrflag = $this->rflag;
		$thisupc = $this->upc;
		$thisboss = $this->boss;
		$thismemo = $this->memo;
		$thisprclevel = $this->prclevel;
		$thisfspoints = $this->fspoints;
		$thisrtnqty = $this->rtnqty;

		$query = "insert into jnl (store,sale,line,qty,pack,sku,descript,price,cost,discount,dclass,promo,cat,location,rflag,upc,boss,memo,date,prclevel,fspoints,rtnqty) values
				($thisstore,$thissale,$thisline,$thisqty,$thispack,$thissku,'$thisdescript',$thisprice,$thiscost,$thisdiscount,'$thisdclass','$thispromo','$thiscat','$thislocation',$thisrflag,'$thisupc','$thisboss','$thismemo',ctod('$thisDate'),'$thisprclevel',$thisfspoints,$thisrtnqty)";
		$stmt = $this->conn->Execute($query);
		if ($stmt == False) {
			return False;
		} else {
			return True;
		}

	}

	function getUpdatedStk($getTstamp)
	{

		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		//echo $thisTstamp;
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT sku,store,floor,back,shipped,kits,ware,vintage,stat,depos,alltrim(str(acost,8,2)) as acost,alltrim(str(lcost,8,2)) as lcost,
		alltrim(str(mincost,8,2)) as mincost,ttoc(tstamp,1) as tstamp,deleted() as isdeleted from stk where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;

	}

	function readTyp($starting_record_num, $ending_record_num)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT type,name,scat1,scat2,uvinseas,fson,typenum,browseqty,
		ttoc(tstamp,1) as tstamp,alltrim(str(recno(),10,0)) as recid from typ where between(recno(),$starting_record_num, $ending_record_num)";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedTyp($getTstamp)
	{

		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		//echo $thisTstamp;
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT type,name,scat1,scat2,uvinseas,fson,typenum,browseqty,
		ttoc(tstamp,1) as tstamp,deleted() as isdeleted from typ where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readCat()
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT cat,name,seq,lspace,code,alltrim(str(cost,5,2)) as cost,alltrim(str(taxlevel,1,0)) as taxlevel,sur,disc,alltrim(str(dbcr,2,0)) as dbcr,
		cflag,income,cog,inventory,discount,wsgroup,wscod,catnum,fson,fsfactor,belowcost,
		ttoc(tstamp,1) as tstamp,alltrim(str(recno(),10,0)) as recid from cat";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedCat($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT cat,name,seq,lspace,code,alltrim(str(cost,5,2)) as cost,alltrim(str(taxlevel,1,0)) as taxlevel,sur,disc,alltrim(str(dbcr,2,0)) as dbcr,
		cflag,income,cog,inventory,discount,wsgroup,wscod,catnum,fson,fsfactor,belowcost,
		ttoc(tstamp,1) as tstamp,deleted() as isdeleted from cat where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readCnt()
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT alltrim(code) as code,seq,alltrim(memvar) as memvar,iif(empty(memo),.F.,.T.) as memo,alltrim(question) as question,data,ttoc(tstamp,1) as tstamp,alltrim(str(recno(),10,0)) as recid from cnt";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedCnt($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT code,seq,question,data,memvar,iif(empty(memo),.F.,.T.) as memo,
		ttoc(tstamp,1) as tstamp,deleted() as isdeleted from cnt where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readCus($starting_record_num, $ending_record_num)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "select customer,ALLTRIM(firstname) as firstname,ALLTRIM(lastname) as lastname,ALLTRIM(status) as status,ALLTRIM(street1) as street1,ALLTRIM(street2) as street2,ALLTRIM(city) as city,
		ALLTRIM(state) as state,ALLTRIM(zip) as zip,ALLTRIM(contact) as contact,ALLTRIM(phone) as phone,ALLTRIM(fax) as fax,ALLTRIM(modem) as modem,startdate,ALLTRIM(taxcode) as taxcode,
		ALLTRIM(terms) as terms,ALLTRIM(shipvia) as shipvia,ALLTRIM(statement) as statement,alltrim(str(crdlimit,8,2)) as crdlimit,alltrim(str(balance,8,2)) as balance,store,
		ALLTRIM(salesper) as salesper,ALLTRIM(clubcard) as clubcard,ALLTRIM(clublist) as clublist,ALLTRIM(altid) as altid,ALLTRIM(types) as types,department,lstore,lreg,ALLTRIM(who) as who,
		ttoc(tstamp,1) as tstamp,iif(empty(memo),.F.,.T.) as memo,storelevel,billto,ALLTRIM(wslicense) as wslicense,wsexpire,ALLTRIM(wetdry) as wetdry,
		ALLTRIM(taxid) as taxid,ALLTRIM(invoicemsg) as invoicemsg,ALLTRIM(statementm) as statementm,ALLTRIM(territory) as territory,ALLTRIM(filter) as filter,ALLTRIM(email) as email,
		sflag,fcflag,printbal,cdate,scldate,fson,alltrim(str(fsfactor,4,4)) as fsfactor,alltrim(str(recno(),10,0)) as recid from cus where between(recno(),$starting_record_num, $ending_record_num)";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedCus($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "select customer,ALLTRIM(firstname) as firstname,ALLTRIM(lastname) as lastname,ALLTRIM(status) as status,ALLTRIM(street1) as street1,ALLTRIM(street2) as street2,ALLTRIM(city) as city,
		ALLTRIM(state) as state,ALLTRIM(zip) as zip,ALLTRIM(contact) as contact,ALLTRIM(phone) as phone,ALLTRIM(fax) as fax,ALLTRIM(modem) as modem,startdate,ALLTRIM(taxcode) as taxcode,
		ALLTRIM(terms) as terms,ALLTRIM(shipvia) as shipvia,ALLTRIM(statement) as statement,alltrim(str(crdlimit,8,2)) as crdlimit,alltrim(str(balance,8,2)) as balance,store,
		ALLTRIM(salesper) as salesper,ALLTRIM(clubcard) as clubcard,ALLTRIM(clublist) as clublist,ALLTRIM(altid) as altid,ALLTRIM(types) as types,department,lstore,lreg,ALLTRIM(who) as who,
		ttoc(tstamp,1) as tstamp,iif(empty(memo),.F.,.T.) as memo,storelevel,billto,ALLTRIM(wslicense) as wslicense,wsexpire,ALLTRIM(wetdry) as wetdry,
		ALLTRIM(taxid) as taxid,ALLTRIM(invoicemsg) as invoicemsg,ALLTRIM(statementm) as statementm,ALLTRIM(territory) as territory,ALLTRIM(filter) as filter,ALLTRIM(email) as email,
		sflag,fcflag,printbal,cdate,scldate,fson,alltrim(str(fsfactor,4,4)) as fsfactor,deleted() as isdeleted from cus where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}


	function readChd()
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT ALLTRIM(dl_state) as dl_state,ALLTRIM(dl_number) as dl_number,ALLTRIM(bankacct) as bankacct,chk_nbr,dtoc(chk_dte) as chk_dte,alltrim(str(chk_amt,8,2)) as chk_amt,
		ALLTRIM(reason) as reason,alltrim(str(pd_amt,8,2)) as pd_amt,ALLTRIM(cntr) as cntr,ALLTRIM(file_loc) as file_loc,ALLTRIM(status) as status,
		customer,store,ttoc(tstamp,1) as tstamp,alltrim(str(recno(),10,0)) as recid from chd";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedChd($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT ALLTRIM(dl_state) as dl_state,ALLTRIM(dl_number) as dl_number,ALLTRIM(bankacct) as bankacct,chk_nbr,dtoc(chk_dte) as chk_dte,alltrim(str(chk_amt,8,2)) as chk_amt,
		ALLTRIM(reason) as reason,alltrim(str(pd_amt,8,2)) as pd_amt,ALLTRIM(cntr) as cntr,ALLTRIM(file_loc) as file_loc,ALLTRIM(status) as status,
		customer,store,ttoc(tstamp,1) as tstamp,deleted() as isdeleted from chd where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readChh($starting_record_num, $ending_record_num)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT ALLTRIM(dl_state) as dl_state,ALLTRIM(dl_number) as dl_number,ALLTRIM(bankacct) as bankacct,ALLTRIM(acct_name) as acct_name,
		ALLTRIM(acct_addr1) as acct_addr1,ALLTRIM(acct_addr2) as acct_addr2,ALLTRIM(acct_city) as acct_city,ALLTRIM(acct_st) as acct_st,
		ALLTRIM(acct_zip) as acct_zip,ALLTRIM(dl_name) as dl_name,ALLTRIM(dl_addr1) as dl_addr1,ALLTRIM(dl_addr2) as dl_addr2,ALLTRIM(dl_city) as dl_city,
		ALLTRIM(dl_st) as dl_st,ALLTRIM(dl_zip) as dl_zip,ALLTRIM(ssn_taxid) as ssn_taxid,ALLTRIM(phone1) as phone1,ALLTRIM(desc1) as desc1,ALLTRIM(phone2) as phone2,
		ALLTRIM(desc2) as desc2,ALLTRIM(phone3) as phone3,ALLTRIM(desc3) as desc3,ALLTRIM(phone4) as phone4,ALLTRIM(desc4) as desc4,cust_since,lst_chk,
		alltrim(str(ret_amt,9,9)) as ret_amt,alltrim(str(ret_nbr,2,2)) as ret_nbr,upd_dte,ALLTRIM(status) as status,ALLTRIM(desc) as desc,ALLTRIM(dl_exp_dte) as dl_exp_dte,
		dl_bday,ALLTRIM(dl_desc) as dl_desc,ALLTRIM(dl_sex) as dl_sex,ALLTRIM(dl_ht) as dl_ht,ALLTRIM(dl_wt) as dl_wt,ALLTRIM(dl_hair) as dl_hair,
		ALLTRIM(dl_eyes) as dl_eyes,customer,store,ttoc(tstamp,1) as tstamp,iif(empty(memo),.F.,.T.) as memo,alltrim(str(recno(),10,0)) as recid from chh where between(recno(),$starting_record_num, $ending_record_num)";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedChh($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT ALLTRIM(dl_state) as dl_state,ALLTRIM(dl_number) as dl_number,ALLTRIM(bankacct) as bankacct,ALLTRIM(acct_name) as acct_name,
		ALLTRIM(acct_addr1) as acct_addr1,ALLTRIM(acct_addr2) as acct_addr2,ALLTRIM(acct_city) as acct_city,ALLTRIM(acct_st) as acct_st,
		ALLTRIM(acct_zip) as acct_zip,ALLTRIM(dl_name) as dl_name,ALLTRIM(dl_addr1) as dl_addr1,ALLTRIM(dl_addr2) as dl_addr2,ALLTRIM(dl_city) as dl_city,
		ALLTRIM(dl_st) as dl_st,ALLTRIM(dl_zip) as dl_zip,ALLTRIM(ssn_taxid) as ssn_taxid,ALLTRIM(phone1) as phone1,ALLTRIM(desc1) as desc1,ALLTRIM(phone2) as phone2,
		ALLTRIM(desc2) as desc2,ALLTRIM(phone3) as phone3,ALLTRIM(desc3) as desc3,ALLTRIM(phone4) as phone4,ALLTRIM(desc4) as desc4,cust_since,lst_chk,
		alltrim(str(ret_amt,9,9)) as ret_amt,alltrim(str(ret_nbr,2,2)) as ret_nbr,upd_dte,ALLTRIM(status) as status,ALLTRIM(desc) as desc,ALLTRIM(dl_exp_dte) as dl_exp_dte,
		dl_bday,ALLTRIM(dl_desc) as dl_desc,ALLTRIM(dl_sex) as dl_sex,ALLTRIM(dl_ht) as dl_ht,ALLTRIM(dl_wt) as dl_wt,ALLTRIM(dl_hair) as dl_hair,
		ALLTRIM(dl_eyes) as dl_eyes,customer,store,ttoc(tstamp,1) as tstamp,iif(empty(memo),.F.,.T.) as memo,deleted() as isdeleted from chh where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readDep()
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT ALLTRIM(depos) as depos,alltrim(str(unit,8,2)) as unit,alltrim(str(case,8,2)) as case,ALLTRIM(scat) as scat,ALLTRIM(rcat) as rcat,
		ttoc(tstamp,1) as tstamp,alltrim(str(recno(),10,0)) as recid from dep";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedDep($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT ALLTRIM(depos) as depos,alltrim(str(unit,8,2)) as unit,alltrim(str(case,8,2)) as case,ALLTRIM(scat) as scat,ALLTRIM(rcat) as rcat,
		ttoc(tstamp,1) as tstamp,deleted() as isdeleted from dep where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readDsc()
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT ALLTRIM(dcode) as dcode,ALLTRIM(chain) as chain,ALLTRIM(descript) as descript,mix,match,alltrim(str(qty,8,2)) as qty,ALLTRIM(qtype) as qtype,
		alltrim(str(level1disc,8,2)) as level1disc,additive,freesku,alltrim(str(freeqty,2,2)) as freeqty,ALLTRIM(promo) as promo,onsale,
		ttoc(tstamp,1) as tstamp,override,alltrim(str(recno(),10,0)) as recid from dsc";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedDsc($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT ALLTRIM(dcode) as dcode,ALLTRIM(chain) as chain,ALLTRIM(descript) as descript,mix,match,alltrim(str(qty,8,2)) as qty,ALLTRIM(qtype) as qtype,
		alltrim(str(level1disc,8,2)) as level1disc,additive,freesku,alltrim(str(freeqty,2,2)) as freeqty,ALLTRIM(promo) as promo,onsale,
		ttoc(tstamp,1) as tstamp,override,deleted() as isdeleted from dsc where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readEmp()
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT id,ALLTRIM(uid) as uid,ALLTRIM(last_name) as last_name,ALLTRIM(first_name) as first_name,store,ALLTRIM(password) as password,
		ALLTRIM(security) as security,alltrim(str(poslevel,2,2)) as poslevel,alltrim(str(invlevel,2,2)) as invlevel,alltrim(str(actlevel,2,2)) as actlevel,
		alltrim(str(admlevel,2,2)) as admlevel,ttoc(tstamp,1) as tstamp,ALLTRIM(email) as email,ALLTRIM(cardnum) as cardnum,ALLTRIM(pws) as pws,
		alltrim(str(recno(),10,0)) as recid from emp";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedEmp($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT id,ALLTRIM(uid) as uid,ALLTRIM(last_name) as last_name,ALLTRIM(first_name) as first_name,store,ALLTRIM(password) as password,
		ALLTRIM(security) as security,alltrim(str(poslevel,2,2)) as poslevel,alltrim(str(invlevel,2,2)) as invlevel,alltrim(str(actlevel,2,2)) as actlevel,
		alltrim(str(admlevel,2,2)) as admlevel,ttoc(tstamp,1) as tstamp,ALLTRIM(email) as email,ALLTRIM(cardnum) as cardnum,ALLTRIM(pws) as pws,
		deleted() as isdeleted from emp where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readKit()
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT sku,ksku,seq,qty,ttoc(tstamp,1) as tstamp,alltrim(str(recno(),10,0)) as recid from kit";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedKit($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT sku,ksku,seq,qty,ttoc(tstamp,1) as tstamp,deleted() as isdeleted from kit where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readKys()
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT ALLTRIM(keyboard) as keyboard,page,key,ALLTRIM(keyname) as keyname,ALLTRIM(cat) as cat,alltrim(str(receipts,1,1)) as receipts,customer,
		ALLTRIM(function) as function,change,credit,balance,active,security,ttoc(tstamp,1) as tstamp,ALLTRIM(catname) as catname,keyorder,
		alltrim(str(recno(),10,0)) as recid from kys";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedKys($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT ALLTRIM(keyboard) as keyboard,page,key,ALLTRIM(keyname) as keyname,ALLTRIM(cat) as cat,alltrim(str(receipts,1,1)) as receipts,
		customer,ALLTRIM(function) as function,change,credit,balance,active,security,ttoc(tstamp,1) as tstamp,ALLTRIM(catname) as catname,keyorder,
		deleted() as isdeleted from kys where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readMsg()
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT ALLTRIM(mcode) as mcode,mnumber,active,iif(empty(mtop),.F.,.T.) as mtop,iif(empty(mbottom),.F.,.T.) as mbottom,ttoc(tstamp,1) as tstamp,
		alltrim(str(recno(),10,0)) as recid from Msg";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedMsg($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT ALLTRIM(mcode) as mcode,mnumber,active,iif(empty(mtop),.F.,.T.) as mtop,iif(empty(mbottom),.F.,.T.) as mbottom,ttoc(tstamp,1) as tstamp,
		deleted() as isdeleted from msg where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedPwd($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT ALLTRIM(class) as class,ALLTRIM(event) as event,alltrim(str(ask_level,2,2)) as ask_level,
		alltrim(str(do_level,2,2)) as do_level,ALLTRIM(scoptosale) as scoptosale,ttoc(tstamp,1) as tstamp,
		deleted() as isdeleted from pwd where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readPwd()
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT ALLTRIM(class) as class,ALLTRIM(event) as event,alltrim(str(ask_level,2,2)) as ask_level,
		alltrim(str(do_level,2,2)) as do_level,ALLTRIM(scoptosale) as scoptosale,ttoc(tstamp,1) as tstamp,
		alltrim(str(recno(),10,0)) as recid from pwd";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedSlh($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT listnum,ALLTRIM(listname) as listname,ALLTRIM(descript) as descript,ALLTRIM(type) as type,ALLTRIM(promo) as promo,onsale,store,
		ALLTRIM(status) as status,start,stop,ttoc(tstamp,1) as tstamp,
		deleted() as isdeleted from slh where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readSlh($starting_record_num, $ending_record_num)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT listnum,ALLTRIM(listname) as listname,ALLTRIM(descript) as descript,ALLTRIM(type) as type,ALLTRIM(promo) as promo,onsale,store,
		ALLTRIM(status) as status,start,stop,ttoc(tstamp,1) as tstamp,
		alltrim(str(recno(),10,0)) as recid from slh where between(recno(),$starting_record_num, $ending_record_num)";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedSll($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT listnum,line,ALLTRIM(listname) as listname,sku,ALLTRIM(type) as type,ALLTRIM(level) as level,qty,
		alltrim(str(price,8,2)) as price,ALLTRIM(status) as status,store,ALLTRIM(stype) as stype,deleted() as isdeleted from sll where listnum in (select listnum from slh where tstamp > ctot('$thisTstamp'))";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readSll($starting_record_num, $ending_record_num)
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT sll.listnum,sll.line,ALLTRIM(sll.listname) as listname,sll.sku,ALLTRIM(sll.type) as type,ALLTRIM(sll.level) as level,sll.qty,
		alltrim(str(sll.price,8,2)) as price,ALLTRIM(sll.status) as status,sll.store,ALLTRIM(sll.stype) as stype from sll where between(recno(),$starting_record_num, $ending_record_num)";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedTxc($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "SELECT ALLTRIM(code) as code,ALLTRIM(level) as level,ALLTRIM(descript) as descript,alltrim(str(rate,6,6)) as rate,ALLTRIM(cat) as cat,
		ALLTRIM(table) as table,ttoc(tstamp,1) as tstamp,deleted() as isdeleted from txc where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readTxc()
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "SELECT ALLTRIM(code) as code,ALLTRIM(level) as level,ALLTRIM(descript) as descript,alltrim(str(rate,6,6)) as rate,ALLTRIM(cat) as cat,
		ALLTRIM(table) as table,ttoc(tstamp,1) as tstamp,deleted() as isdeleted from txc";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function getUpdatedTxt($getTstamp)
	{
		$thisTstamp = date('m-d-Y H:i:s', strtotime($getTstamp));
		$this->conn->Execute('SET DELETED OFF');
		$query = "select ALLTRIM(table) as table,alltrim(str(cutoff,3,3)) as cutoff,alltrim(str(tax,3,3)) as tax,
		ttoc(tstamp,1) as tstamp,deleted() as isdeleted from txt where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	function readTxt()
	{
		$this->conn->Execute('SET DELETED ON');
		$query = "select ALLTRIM(table) as table,alltrim(str(cutoff,3,3)) as cutoff,alltrim(str(tax,3,3)) as tax,
		ttoc(tstamp,1) as tstamp,deleted() as isdeleted from txt";
		$stmt = $this->conn->Execute($query);
		return $stmt;
	}

	public function countrecs()
	{
		$thisTable = $this->table;
		$query = "SELECT alltrim(str(COUNT(*),12,0)) as totalrw FROM $thisTable";
		$stmt = $this->conn->Execute($query);
		$this->total_rows = $stmt->Fields("totalrw")->value;
	}
	public function countrecsNEW()
	{
		$thisTable = $this->table;
		$thisTstamp = date('m-d-Y H:i:s', strtotime($this->tstamp));
		$query = "SELECT alltrim(str(COUNT(*),12,0)) as totalrw FROM $thisTable where tstamp > ctot('$thisTstamp')";
		$stmt = $this->conn->Execute($query);
		$this->total_rows = $stmt->Fields("totalrw")->value;
	}

}
?>