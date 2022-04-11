<?php
class ordermodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'order';		

	}

	function AddOrderReminder($order_id){
		$companyid = $this->session->userdata("clms_front_companyid");
 		$company = $this->companymodel->getdata($companyid)->row();
		$due_date =  date("Y-m-d",strtotime("+".$company->duedatenumber." days")); 

		$this->db->where("company_id",$companyid);
		$reminders = $this->db->get("package_reminder");

		foreach($reminders->result() as $row){
			$days = explode('-',$row->reminder);
			if($days[1] == "after"){
				$reminder_date = date("Y-m-d",strtotime("+".$days[0]." days", strtotime($due_date)));
			}else{
				$reminder_date = date("Y-m-d",strtotime("-".$days[0]." days", strtotime($due_date)));
			}
			
			$insert_array = array(
				"company_id" => $companyid,
				"order_id" => $order_id,
				"reminder" => $row->reminder,
				"reminder_date" => $reminder_date,
				"is_sent"=>0
			);
			$this->db->insert("pnp_order_reminder_date",$insert_array);
		}
	}

	function getorderReminder($order_id){
		$this->db->where("order_id",$order_id);
		$this->db->order_by("reminder_date");
		return $this->db->get("pnp_order_reminder_date")->result();
	}

	

	function get_referrals($customer_id){
		$this->db->where("customer_id",$customer_id);
		$customer = $this->db->get("customers")->row();

		$referral_id = $customer->referral_id;

		if($referral_id > 0){
			$this->db->where("userid",$referral_id);
			$referral = $this->db->get("users")->row();
			return $referral->userid;
		}else{
			return 0;
		}
	}


	function get_commision($referral,$lead_type){
		$this->db->where("user_id",$referral);
		$this->db->where("type_id",$lead_type);
		return $this->db->get("salesrep_rate")->row();
	}

	function getPayments($id){
		$this->db->where('invoice_id',$id);
		return $this->db->get("invoice_payment")->result();
	}

	function get_leadtypes($limit = null){		
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company_id = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company_id or company_id = 0)");
		}	
		$this->db->where("status",1);
		$this->db->order_by('type_id','desc');
		return $this->db->get('lead_type');
	}

	function count_todayOrder(){
		$alldata = $this->commonmodel->get_alldata_group_permissions(); 
		$sql = "SELECT SUM(o.price) AS times FROM pnp_order o 
		JOIN pnp_customers c on c.customer_id = o.customer_id
		WHERE DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d') = CURDATE() and is_archived='0'";
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")
			$sql.=" and o.company_id=".$this->session->userdata("clms_front_companyid");

		if($alldata == 0){
			$userid = $this->session->userdata("clms_front_userid");
			$sql.= " and (o.added_by = $userid Or c.sales_rep = $userid)";
			
		}
			
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	

	function count_weekOrder(){
		$alldata = $this->commonmodel->get_alldata_group_permissions(); 
		$sql = "SELECT SUM(o.price) AS times FROM pnp_order o 
		JOIN pnp_customers c on c.customer_id = o.customer_id
		WHERE WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d'))=WEEKOFYEAR(NOW()) and YEAR(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d'))=YEAR(NOW()) and is_archived='0'";
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	$sql.=" and o.company_id=".$this->session->userdata("clms_front_companyid");
		if($alldata == 0){
			$userid = $this->session->userdata("clms_front_userid");
			$sql.= " and (o.added_by = $userid Or c.sales_rep = $userid)";
			
		}
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_monthOrder(){
		$alldata = $this->commonmodel->get_alldata_group_permissions(); 
		$sql = "SELECT SUM(o.price) AS times FROM pnp_order o 
		JOIN pnp_customers c on c.customer_id = o.customer_id
		WHERE  MONTH(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d'))=MONTH(NOW()) and YEAR(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d'))=YEAR(NOW()) and is_archived='0'";
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	$sql.=" and o.company_id=".$this->session->userdata("clms_front_companyid");
		if($alldata == 0){
			$userid = $this->session->userdata("clms_front_userid");
			$sql.= " and (o.added_by = $userid Or c.sales_rep = $userid)";
			
		}
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function total_earning($referral_id)
	{
		$this->db->select("sum(commision) earning")->from("order o");	
		$this->db->join("customers c","c.customer_id = o.customer_id");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("o.company_id",$this->session->userdata("clms_front_companyid"));	
		if($this->session->userdata("clms_front_user_group")  == 9)
			$this->db->where("c.referral_id",$this->session->userdata("clms_front_userid"));
		
		if($referral_id != "")
			$this->db->where("c.referral_id",$referral_id);

		return $this->db->get()->row();
		
	}

	function total_company_earning_monthly($order_date)
	{
		$this->db->select("sum(commision) earning")->from("order o");	
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("o.company_id",$this->session->userdata("clms_front_companyid"));	
		
		if($order_date == "month")
			$this->db->where("MONTH(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d')) = MONTH(NOW()) and YEAR(DATE_FORMAT(FROM_UNIXTIME(`o.added_date`), '%Y-%m-%d'))=YEAR(NOW())");

		return $this->db->get()->row();
		
	}

	function listall($ostatus='',$invoice='',$archive='0',$order_date='',$referral='',$from_date='',$to_date='',$period = '',$month ='',$type='',$student=null){	
	

		$this->db->select("o.*,s.referral referral_id,c.company_name")->from("order o");	
		$this->db->join("users c","c.userid = o.company_id");
		$this->db->join("company_students u","u.id = o.customer_id");
		$this->db->join("company_student_details s","u.id = s.company_student_id");

		if($ostatus != '')
			$this->db->where("o.order_status",$ostatus);
		if($invoice != '')
			$this->db->where("o.invoice_status",$invoice);
		if($archive != "")
			$this->db->where("o.is_archived",$archive);

		if($referral != "")
			$this->db->where("s.referral_id",$referral);

		if($from_date != "")
			$this->db->where("o.added_date >=",strtotime($from_date));

		if($to_date != "")
			$this->db->where("o.added_date <=",strtotime($to_date));
					
		if($type == '')
			$this->db->where("inhouse_date is NULL");
		else
			$this->db->where("inhouse_date is NOT NULL");


		if($order_date == "month")
			$this->db->where("MONTH(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d')) = MONTH(NOW()) and YEAR(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d'))=YEAR(NOW())");
		elseif($order_date == "week")
			$this->db->where("WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d'))=WEEKOFYEAR(NOW()) and YEAR(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d'))=YEAR(NOW())");
		elseif($order_date == "today")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d') = CURDATE()");

		if($period == 'Monthly' && $month != ''){

			$this->db->where("MONTH(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d')) = $month and YEAR(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d'))=YEAR(NOW())");
		}

	 	$this->db->where("u.email",$this->session->userdata("clms_front_email"));

		$this->db->order_by('o.order_id','asc');
		return $this->db->get();
		
	}

	function total_company_earning($ostatus='',$invoice='',$archive='0',$order_date='',$referral='',$from_date='',$to_date='',$period = '',$month =''){	
		$this->db->select("sum(o.commision) as earning")->from("order o");	
		$this->db->join("customers c","c.customer_id = o.customer_id");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("o.company_id",$this->session->userdata("clms_front_companyid"));	
		if($this->session->userdata("clms_front_user_group")  == 9)
			$this->db->where("c.referral_id",$this->session->userdata("clms_front_userid"));
		if($ostatus != '')
			$this->db->where("o.order_status",$ostatus);
		if($invoice != '')
			$this->db->where("o.invoice_status",$invoice);
		if($archive != "")
			$this->db->where("o.is_archived",$archive);

		if($referral != "")
			$this->db->where("c.referral_id",$referral);

		if($from_date != "")
			$this->db->where("o.added_date >=",strtotime($from_date));

		if($to_date != "")
			$this->db->where("o.added_date <=",strtotime($to_date));


		if($order_date == "month")
			$this->db->where("MONTH(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d')) = MONTH(NOW()) and YEAR(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d'))=YEAR(NOW())");
		elseif($order_date == "week")
			$this->db->where("WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d'))=WEEKOFYEAR(NOW()) and YEAR(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d'))=YEAR(NOW())");
		elseif($order_date == "today")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d') = CURDATE()");

		if($period == 'Monthly' && $month != ''){

			$this->db->where("MONTH(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d')) = $month and YEAR(DATE_FORMAT(FROM_UNIXTIME(o.added_date), '%Y-%m-%d'))=YEAR(NOW())");
		}

		return $this->db->get()->row();
		
	}


	function countArchiveOrder($type=null){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		$this->db->where("is_archived",'1');
		if($type)
			$this->db->where("inhouse_date is NOT NULL");
		else
			$this->db->where("inhouse_date is NULL");
		return $this->db->get("order")->num_rows();
	}

	function countOrderwithStatus($status,$type=null){
		$alldata = $this->commonmodel->get_alldata_group_permissions(); 
		$this->db->select("*")->from("order o");
		$this->db->join("customers c","c.customer_id=o.customer_id");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
		$this->db->where("o.company_id",$this->session->userdata("clms_front_companyid"));	
	
		if($alldata == 0){
			// $this->db->where("o.added_by",$this->session->userdata("clms_front_userid"));
			$userid = $this->session->userdata("clms_front_userid");
			$this->db->where("(o.added_by = $userid  OR c.sales_rep = $userid )");
		}
		$this->db->where("order_status",$status);
		$this->db->where("is_archived",0);
		if($type)
			$this->db->where("inhouse_date is NOT NULL");
		else
			$this->db->where("inhouse_date is NULL");
		$this->db->order_by('order_id','asc');
		return $this->db->get("")->num_rows();


		// if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
		// 	$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		// $this->db->where("order_status",$status);
		// $this->db->where("is_archived",0);
		// if($type)
		// 	$this->db->where("inhouse_date is NOT NULL");
		// else
		// 	$this->db->where("inhouse_date is NULL");
		// $this->db->order_by('order_id','asc');
		// return $this->db->get("order")->num_rows();
	}

	function countOrderwithInvoiceStatus($status){
		$this->db->select("o.*")->from("order o");
		$this->db->join("customers c","c.customer_id=o.customer_id");

		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
		$this->db->where("o.company_id",$this->session->userdata("clms_front_companyid"));	

		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7  && $this->session->userdata("clms_front_companyid") != 0){
			// $this->db->where("o.added_by",$this->session->userdata("clms_front_userid"));
			$userid = $this->session->userdata("clms_front_userid");
			$this->db->where("(o.added_by = $userid  OR c.sales_rep = $userid )");
					}
		$this->db->where("invoice_status",$status);
		$this->db->where("is_archived",0);
		$this->db->order_by('order_id','asc');
		return $this->db->get()->num_rows();
	}

	function totalDueOrderwithInvoiceStatus(){

		$alldata = $this->commonmodel->get_alldata_group_permissions(); 
	
		$this->db->select("sum(due_amount) as due")->from("order o");
		$this->db->join("customers c","c.customer_id=o.customer_id");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
		$this->db->where("o.company_id",$this->session->userdata("clms_front_companyid"));	
		//$this->db->where("invoice_status",$status);
		$this->db->where("o.is_archived",0);
		//$this->db->group_by('order_id','asc');
			// $this->db->where("o.added_by",$this->session->userdata("clms_front_userid"));
		if($alldata == 0){
			$userid = $this->session->userdata("clms_front_userid");
			$this->db->where("(o.added_by = $userid  OR c.sales_rep = $userid )");
					}
		return $this->db->get("")->row();
	}

	function totalPaiddOrderwithInvoiceStatus(){
		// if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
		// 	$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		// $this->db->select("sum(price) as totalprice")->from("order");
		// //$this->db->where("invoice_status",$status);
		// $this->db->where("is_archived",0);
		// //$this->db->group_by('order_id','asc');
		// return $this->db->get("")->row();

		$alldata = $this->commonmodel->get_alldata_group_permissions(); 

		$this->db->select("sum(price) as totalprice")->from("order o");
		$this->db->join("customers c","c.customer_id=o.customer_id");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
		$this->db->where("o.company_id",$this->session->userdata("clms_front_companyid"));	
		//$this->db->where("invoice_status",$status);
		$this->db->where("o.is_archived",0);
		//$this->db->group_by('order_id','asc');
		if($alldata == 0){
			// $this->db->where("o.added_by",$this->session->userdata("clms_front_userid"));
			$userid = $this->session->userdata("clms_front_userid");
			$this->db->where("(o.added_by = $userid  OR c.sales_rep = $userid )");
					}
		return $this->db->get("")->row();
	}

	function listallInstall($pending=null){
		$alldata = $this->commonmodel->get_alldata_group_permissions(); 
	//	$this->db->select("*,it.name type,it.color_code as type_code,oi.payment_method,oi.total_amount,oi.flat_amount,oi.hourly_rate,oi.added_date")
		$this->db->select("*,oi.id,ist.threatre_id")
		->from("order_installer oi");
		$this->db->join("order o","o.order_id=oi.order_id");
		//$this->db->join("installer i","i.threatre_id=oi.installer");
		$this->db->join("install_type it","it.threatre_id=oi.install_type");
		$this->db->join("users c","c.userid=o.customer_id");
		$this->db->join("installer_status ist","ist.threatre_id=oi.install_status");

		if($pending)
			$this->db->where("oi.install_status !=",22);
		if($this->session->userdata("clms_front_user_group") == 11){
			$this->db->join("pnp_order_assignees oa","oa.order_id=o.order_id");
			$this->db->join("pnp_installer i","i.threatre_id=oa.installer_id");
			$this->db->join("pnp_users u","u.userid=i.user_id");
			$this->db->where("u.userid",$this->session->userdata("clms_front_userid"));
		}elseif($alldata == 0){
			$this->db->where("o.added_by",$this->session->userdata("clms_front_userid"));
		}

		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("o.company_id",$this->session->userdata("clms_front_companyid"));	
	
		$this->db->where("order_status",'19');
		$this->db->order_by('o.order_id','asc');
		return $this->db->get("");
	}

	function get_activitydetail($id){
		$this->db->where("id",$id);
		return $this->db->get("pnp_order_installer_activities")->row();
	}

	function listActivities($custom,$date,$from_date,$to_date,$orderid,$contractor){
		$this->db->select("*,oia.description,oia.id")->from("pnp_order_installer_activities oia");
		$this->db->join("order_installer oi","oi.order_id=oia.order_id");
			$this->db->join("order o","o.order_id=oi.order_id");
			$this->db->join("install_type it","it.threatre_id=oi.install_type");
			$this->db->join("users c","c.userid=o.customer_id");
			$this->db->join("installer_status ist","ist.threatre_id=oi.install_status");
	
			
			$this->db->join("pnp_order_assignees oa","oa.order_id=o.order_id");
			$this->db->join("pnp_installer i","i.threatre_id=oa.installer_id");
			$this->db->join("pnp_users u","u.userid=i.user_id");
			$this->db->where("oia.user_id = i.user_id");
			if($this->session->userdata("clms_front_user_group") == 11){
				$this->db->where("u.userid",$this->session->userdata("clms_front_userid"));
			}
	
			if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
				$this->db->where("o.company_id",$this->session->userdata("clms_front_companyid"));	
	
			if($custom == ""){

				if($date == 'today'){
					$this->db->where("DATE(activity_date) = CURDATE()");
				}elseif($date == 'week'){
					$this->db->where("WEEKOFYEAR(activity_date)=WEEKOFYEAR(NOW()) AND YEAR(activity_date)=YEAR(NOW())");
				}elseif($date == 'month'){
					$this->db->where("MONTH(activity_date)=MONTH(NOW()) AND YEAR(activity_date)=YEAR(NOW())");
				}
	
			}else{
				if($from_date != ''){
					$fdate = explode('/', $from_date);
					$fdate = $fdate[2].'-'.$fdate[1].'-'.$fdate[0];
					$this->db->where("DATE(activity_date) >=",$fdate);
				}
				if($to_date != ''){
					$tdate = explode('/', $to_date);
					$tdate = $tdate[2].'-'.$tdate[1].'-'.$tdate[0];
					$this->db->where("DATE(activity_date) <=",$tdate);
				}
			}

			if($orderid != ''){
				$this->db->where("o.order_id",$orderid);
			}

			if($contractor != ''){
				$this->db->where("oia.user_id",$contractor);
			}
		
			$this->db->where("order_status",'19');
			$this->db->order_by('o.order_id','asc');
			return $this->db->get("");
	}

	

	function getorder_installer($orderid){
		$this->db->select("*")->from("pnp_order_assignees oa");
		$this->db->join("pnp_installer i","oa.installer_id=i.threatre_id");
		$this->db->where("oa.order_id",$orderid);
		return $this->db->get()->result();
	}

	function listallInstall_detail($id){
		$this->db->select("*,o.added_by")->from("order_installer oi");
		$this->db->join("order o","o.order_id=oi.order_id");
		//$this->db->join("installer i","i.threatre_id=oi.installer");
		//$this->db->join("install_type it","it.threatre_id=oi.install_type");
		$this->db->join("customers c","c.customer_id=o.customer_id");
		$this->db->join("installer_status ist","ist.threatre_id=oi.install_status");
		$this->db->where("o.order_id",$id);
		return $this->db->get("")->row();
	}

	function listInvoices(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company_id = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company_id or company_id = 0)");
		}	
		//$this->db->where("threatre_id",$id);
		$this->db->where("status",1);
		return $this->db->get("lead_status")->result();
	}

	function getState($stateid){
		$this->db->where("state_id",$stateid);
		return @$this->db->get("states")->row()->state_name;
	}

	function getInstallers(){
		//$this->db->where("threatre_id",$id);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		return $this->db->get("installer")->result();
	}

	function getInstallerType(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		return $this->db->get("install_type")->result();
	}

	function getOrderInstallers($orderid){
		$this->db->select("*,oi.hourly_rate hrate")->from("order_installer oi");
		//$this->db->join("installer i","oi.installer = i.threatre_id");
		$this->db->where("order_id",$orderid);
		return $this->db->get("")->row();
	}

	function get_install_user($id){
		$this->db->where("threatre_id",$id);
		return $this->db->get("pnp_installer")->row();
	}

	function getAssignedOrderInstallers($installerid,$orderid){
		$this->db->select("*")->from("pnp_order_assignees oa");
		$this->db->where("order_id",$orderid);
		$this->db->where("installer_id",$installerid);
		return $this->db->get();
	}

	function getOrderInstallersNotes($orderid){
		$this->db->select("*,o.added_date,o.added_by")->from("order_installer_notes o");
		$this->db->join("users u","u.userid=o.added_by");
		$this->db->where("o.order_id",$orderid);
		return $this->db->get("")->result();
	}

	function getstatus($id){
		$this->db->where("threatre_id",$id);
		return $this->db->get("order_status")->row();
	}

	function getinvoicestatus($id){
		$this->db->where("status_id",$id);
		return $this->db->get("invoice_status")->row();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($status_id){
		$this->db->where('order_id',$status_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function listOrderStatus(){

		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company_id = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company_id or company_id = 0)");
		}	
		$this->db->where('status','1');
		return $this->db->get("order_status")->result();
	}

	function getquote($id){
		$this->db->where('quote_number',$id);
		$query=$this->db->get("quote");
		return $query->row();
	}

	function getInverter($id){
		$this->db->where("quote_id",$id);
		return $this->db->get("quote_inverters")->result();
	}

	function getInverterOrder($id){
		$this->db->where("order_id",$id);
		return $this->db->get("order_inverters")->result();
	}

	function getOrder($order_id){
		$this->db->select("*, p.name as patient, pr.name as procedure_name, t.name as threatre")->from("order o");	
		$this->db->join("patient p","p.patient_id=o.patient_id");
		$this->db->join("procedure pr","pr.procedure_id=o.procedure_id");
		$this->db->join("threatre t","t.threatre_id=o.threatre_id");
		$this->db->where("order_id",$order_id);
		$this->db->order_by('o.order_id','asc');
		return $this->db->get("");
	}

	function getProjectFiles($project_id){
		$this->db->select("p.*,u.first_name,u.last_name")->from("order_files p");
		$this->db->join("users u","u.userid=p.added_by");
		$this->db->where("p.order_id",$project_id);
		return $this->db->get("")->result();
		
	}
	function getDiscussionDetail($discussionid){
		$this->db->where("comment_id",$discussionid);
		return $this->db->get("comment")->row();
	}

	function get_discussionupdates($discussionid){
		$this->db->select("d.*,u.first_name,u.last_name");
		$this->db->from("comment d");
		$this->db->join("users u","u.userid=d.added_by");
		$this->db->where("d.parent_id",$discussionid);
		$this->db->order_by("d.comment_id","desc");
		return $this->db->get("")->result();
		
	}


	function getFileDetail($fileid){
		$this->db->where("file_id",$fileid);
		return $this->db->get("order_files")->row();
	}

	function get_fileupdates($fileid){
		$this->db->select("d.*,u.first_name,u.last_name");
		$this->db->from("order_files d");
		$this->db->join("users u","u.userid=d.added_by");
		$this->db->where("d.parent_id",$fileid);
		$this->db->order_by("d.file_id","desc");
		return $this->db->get("")->result();
		
	}

	function update($status_id, $data){
		$this->db->where('order_id', $status_id);
		$this->db->update($this->table, $data);
	}

	function delete($status_id) {
		$this->db->where('order_id', $status_id);
		$this->db->delete($this->table);
	}

	function getPatients(){
		$this->db->where("status",1);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		return $this->db->get("patient")->result();
	}

	function getProcedures(){
		$this->db->where("status",1);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		return $this->db->get("procedure")->result();
	}

	function getThreatre(){
		$this->db->where("status",1);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		return $this->db->get("threatre")->result();
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('order_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('order_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('order_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function cascadeInstallerAction($ids,$status){
		
		$this->db->where_in('id',$ids);
		$this->db->set("install_status",$status);
		$this->db->update('order_installer');
		return;
	}

	function getcomments($orderid){
		$this->db->select("*,c.added_date")->from("comment c");
		$this->db->join("users u","u.userid = c.added_by");
		$this->db->where("c.order_id",$orderid);
		$this->db->order_by("c.comment_id","desc");
		return $this->db->get("")->result(); 
	}

	function getcommentDetails($commentid){
		$this->db->where("comment_id",$commentid);
		return $this->db->get("comment")->row();
	}

	function listAdminNotes($order_id){
		$this->db->where("order_id",$order_id);
		return $this->db->get("order_admin_note");
	}

	function listCustomerNotes($order_id,$order = 'asc'){
		$this->db->where("order_id",$order_id);
		$this->db->order_by("note_id",$order);
		return $this->db->get("order_customer_note");
	}

	function sendSms($orderid,$email_id){

		$query = $this->ordermodel->getdata($orderid);

		$this->load->model("sms/smsmodel");
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);

		$query = $this->smsmodel->getdata($this->session->userdata("clms_front_userid"));
		$sms_setting  = $query->row();

		
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}


		$row = $this->mylibrary->getCompanyEmailTemplate($email_id,$data['company']->company_id);
		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(73) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($sms, ENT_COMPAT));
			$sms = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $sms);
			$sms = str_replace('[SITE_NAME]', $fromname, $sms);
			$sms = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$sms = str_replace('[LOGO]', $logo, $sms);
			$sms = str_replace('[SITE_URL]', SITE_URL, $sms);
			$sms = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $sms);
			$sms = str_replace('[SITE_EMAIL]', $data['company']->email , $sms);
			$sms = str_replace('[SITE_PHONE]', $data['company']->phone, $sms);
			$sms = str_replace('[SITE_FAX]', $fax, $sms);
			$sms = str_replace('[EMAIL]', $data['company']->email, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);

			$mobile = $data['cutomer']->mobile_number;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile,$sms_setting->sms_from);

			$balance_sms = $sms_setting->balance_sms - 1;

			$this->db->where("company_id",$this->session->userdata("clms_front_userid"));
			$this->db->set("used_sms",$sms_setting->used_sms + 1);
			$this->db->set("balance_sms",$balance_sms);
			$this->db->update("sms");
		}
		/***** Sms code ******/
	}

	function sendmail_invoice($id){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		// $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);

		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);
		$content = $this->load->view('invoice', $data, true); 
		
		$file = 'Invoice'.$data['result']->order_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		/********** Get order details email template and send email to customer***********/
		//$from 	  = $this->mylibrary->getSiteEmail(31);
		//$fromname = $this->mylibrary->getSiteEmail(20);
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(68,$data['company']->company_id);
		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(73) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($sms, ENT_COMPAT));
			$sms = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $sms);
			$sms = str_replace('[SITE_NAME]', $fromname, $sms);
			$sms = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$sms = str_replace('[LOGO]', $logo, $sms);
			$sms = str_replace('[SITE_URL]', SITE_URL, $sms);
			$sms = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $sms);
			$sms = str_replace('[SITE_EMAIL]', $data['company']->email , $sms);
			$sms = str_replace('[SITE_PHONE]', $data['company']->phone, $sms);
			$sms = str_replace('[SITE_FAX]', $fax, $sms);
			$sms = str_replace('[EMAIL]', $data['company']->email, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);

			$mobile = $data['cutomer']->mobile_number;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/

		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($data['cutomer']->email);
		
		$subject = str_replace('[COMPANY_NAME]', $data['company']->company_name, $row->email_subject);
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$this->email->subject($subject);

		$message = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);
		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		$message = str_replace('[INVOICE_LINK]','<a href="'. base_url("order/invoice/".$string1."-$id-".$string2).'">'. base_url("order/invoice/".$string1."-$id-".$string2).'</a>', $message);
		
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		if($fax == "")
			$message = str_replace('- Fax -', "", $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message .= '<img src="'.base_url("order/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';
		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 

		//echo $message; die();
		$this->email->message($message);
		$docs = $this->ordermodel->getDocuments($id);
		foreach($docs as $key => $doc){
			if(file_exists("./uploads/document/".$doc->image))
				$this->email->attach("./uploads/document/".$doc->image);
		}
		$this->email->attach($file);
		$this->email->send();
		$this->email->clear();

	}

	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function sendCustomerPaymentEmail($orderid,$payment_method,$note,$amount){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');



		$query = $this->ordermodel->getdata($orderid);
		
		$data['result']   = $query->row();
		$invoice_status = $this->ordermodel->getinvoicestatus($data['result']->invoice_status);
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);

		//print_r($data['company']);die();
		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($orderid);
		$content = $this->load->view('invoice', $data, true);
		//echo $content; die();

		
		$file = 'Invoice'.$data['result']->order_number.'.pdf'; 
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		
		$this->email->set_mailtype('html');
		$from = $data['cutomer']->email;
		$fromname = $data['cutomer']->first_name;
		$fax      = '';
		$logo     = '';

		$row = $this->mylibrary->getCompanyEmailTemplate(69,$data['company']->company_id);
		//print_r($row);

		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($data['company']->order_email);
		//$this->email->to('bikash.suwal01@gmail.com');
		
		$subject = str_replace('[CUSTOMER_NAME]', $data['cutomer']->first_name, $row->email_subject);
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		$subject = str_replace('[STATUS]', $invoice_status->status_name, $subject);
		
		$this->email->subject($subject);

		$message = str_replace('[FULL_NAME]', $data['company']->first_name.' '.$data['company']->last_name, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[CUSTOMER_NAME]', $data['cutomer']->first_name, $message);
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);
		$message = str_replace('[STATUS]', $invoice_status->status_name, $message);
		$message = str_replace('[AMOUNT]', $amount, $message);
		$message = str_replace('[PAYMENT_METHOD]', $payment_method, $message);
		$message = str_replace('[NOTE]', $note, $message);
		$message = str_replace('[SITE_NAME]', $this->mylibrary->getSiteEmail(20), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[COMPANY_NAME]', $data['cutomer']->first_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		//echo $message; die();
		$this->email->message($message);
		$this->email->attach($file);
		$docs = $this->ordermodel->getDocuments($orderid);
		foreach($docs as $key => $doc){
			if(file_exists("./uploads/document/".$doc->image))
				$this->email->attach("./uploads/document/".$doc->image);
		}
		$this->email->send();
		$this->email->clear();
//end mail sent to company//
		//mail sent to customer//
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}


		$row = $this->mylibrary->getCompanyEmailTemplate(70,$data['company']->company_id);
		//print_r($row);

		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($data['cutomer']->email);
		//$this->email->to('bikash.suwal01@gmail.com');
		
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $row->email_subject);
		//$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		//$subject = str_replace('[STATUS]', $invoice_status->status_name, $subject);
		
		$this->email->subject($subject);

		$message = str_replace('[FULL_NAME]', $data['cutomer']->first_name, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[COMPANY_NAME]', $data['company']->company_name, $message);
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);
		$message = str_replace('[STATUS]', $invoice_status->status_name, $message);
		$message = str_replace('[AMOUNT]', $amount, $message);
		$message = str_replace('[PAYMENT_METHOD]', $payment_method, $message);
		$message = str_replace('[NOTE]', $note, $message);
		$message = str_replace('[SITE_NAME]', $this->mylibrary->getSiteEmail(20), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message .= '<img src="'.base_url("order/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';
		$this->email->message($message);
		//$this->email->attach($file);
		$this->email->send();
		$this->email->clear();
	}


	function sendPaymentEmail($sendemail = '',$copy_me = ''){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');

		$orderid = $this->input->post("invoice_id");
		$status = $this->input->post("invoice_status");
		$amount = $this->input->post("paid");
		$method = $this->input->post("payment_method");
		$note = $this->input->post("note");

		$invoice_status = $this->ordermodel->getinvoicestatus($status);
		//print_r($invoice_status); die();

		$query = $this->ordermodel->getdata($orderid);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);

		//print_r($data['company']);die();
		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($orderid);
		$content = $this->load->view('order/invoice', $data, true);
		//echo $content; die();

		
		$file = 'Invoice'.$data['result']->order_number.'.pdf'; 
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		/********** Get order details email template and send email to customer***********/
		//$from 	  = $this->mylibrary->getSiteEmail(31);
		//$fromname = $this->mylibrary->getSiteEmail(20);
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(71,$data['company']->company_id);
		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(73) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($sms, ENT_COMPAT));
			$sms = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $sms);
			$sms = str_replace('[STATUS]', $invoice_status->status_name, $sms);
			$sms = str_replace('[AMOUNT]', $amount, $sms);
			$sms = str_replace('[PAYMENT_METHOD]', $method, $sms);
			$sms = str_replace('[NOTE]', $note, $sms);
			$sms = str_replace('[SITE_NAME]', $fromname, $sms);
			$sms = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$sms = str_replace('[LOGO]', $logo, $sms);
			$sms = str_replace('[SITE_URL]', SITE_URL, $sms);
			$sms = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $sms);
			$sms = str_replace('[SITE_EMAIL]', $data['company']->email , $sms);
			$sms = str_replace('[SITE_PHONE]', $data['company']->phone, $sms);
			$sms = str_replace('[SITE_FAX]', $fax, $sms);
			$sms = str_replace('[EMAIL]', $data['company']->email, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$mobile = $data['cutomer']->mobile_number;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/

		$subject = str_replace('[COMPANY_NAME]', $fromname, $row->email_subject);
		$subject = str_replace('[STATUS]', $invoice_status->status_name, $subject);
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);
		$message = str_replace('[STATUS]', $invoice_status->status_name, $message);
		$message = str_replace('[AMOUNT]', $amount, $message);
		$message = str_replace('[PAYMENT_METHOD]', $method, $message);
		$message = str_replace('[NOTE]', $note, $message);
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		if($fax == "")
			$message = str_replace('- Fax -', "", $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message .= '<img src="'.base_url("order/count_mail_seen/".$orderid).'" style="width:1px;height:1px;"">';
		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 
		if($sendemail == 1){
			$this->email->set_mailtype('html');
			$sendemail   = $this->mylibrary->getSiteEmail(19);
			$this->email->from($sendemail, $fromname);
			$this->email->reply_to($from, $fromname);
			$this->email->to($data['cutomer']->email);
			$this->email->subject($subject);
			//echo $message; die();
			$this->email->message($message);
			$docs = $this->ordermodel->getDocuments($orderid);
			foreach($docs as $key => $doc){
				if(file_exists("./uploads/document/".$doc->image))
					$this->email->attach("./uploads/document/".$doc->image);
			}
			$this->email->attach($file);
			$this->email->send();
			$this->email->clear();
		}
		if($copy_me == 1){
			$this->email->set_mailtype('html');
			$sendemail   = $this->mylibrary->getSiteEmail(19);
			$this->email->from($sendemail, $fromname);
			$this->email->reply_to($from, $fromname);
			$this->email->to($data['company']->order_email);
			$this->email->subject($subject);
			$this->email->message($message);
			$docs = $this->ordermodel->getDocuments($orderid);
			foreach($docs as $key => $doc){
				if(file_exists("./uploads/document/".$doc->image))
					$this->email->attach("./uploads/document/".$doc->image);
			}
			if($sendemail == '')
				$this->email->attach($file);
			$this->email->send();
			$this->email->clear();
		}
	}

	function getemailcount($order_id){
		$this->db->where("order_id",$order_id);
		return $this->db->get("order_email")->num_rows();
	}

	function getinstallemailcount($install_id){
		$this->db->where("install_id",$install_id);
		return $this->db->get("install_email")->num_rows();
	}


	function preview_order($id){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);
		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);
		$content = $this->load->view('invoice', $data, true); 
		
		$file = 'Invoice'.$data['result']->order_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
	}

	function download_order($id){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);

		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);
		$content = $this->load->view('pdf', $data, true);
		//echo $content; die();

		
		$file = 'Order'.$data['result']->order_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
	}

	function sendmailnote($id,$note_id,$useremails,$to='cust'){ 
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);

		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);
		$content = $this->load->view('pdf', $data, true);
		//  echo $content; die();

		
		$file = 'Order'.$data['result']->order_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		/********** Get order details email template and send email to customer***********/
		//$from 	  = $this->mylibrary->getSiteEmail(31);
		//$fromname = $this->mylibrary->getSiteEmail(20);
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(72,$data['company']->company_id);

		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(73) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($sms, ENT_COMPAT));
			$sms = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $sms);
			$sms = str_replace('[NOTE_CONTENT]', $this->input->post("customer_note"), $sms);
			$sms = str_replace('[SITE_NAME]', $fromname, $sms);
			$sms = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$sms = str_replace('[LOGO]', $logo, $sms);
			$sms = str_replace('[SITE_URL]', SITE_URL, $sms);
			$sms = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $sms);
			$sms = str_replace('[SITE_EMAIL]', $data['company']->email , $sms);
			$sms = str_replace('[SITE_PHONE]', $data['company']->phone, $sms);
			$sms = str_replace('[SITE_FAX]', $fax, $sms);
			$sms = str_replace('[EMAIL]', $data['company']->email, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$mobile = $data['cutomer']->mobile_number;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/

		
		
		$subject = str_replace('[COMPANY_NAME]', $fromname, $row->email_subject);
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		

		$message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);

		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		$link = '<a href="'. base_url("order/public_customer_note/".$string1."-$id-".$string2).'-'.$to.'">'. base_url("order/public_customer_note/".$string1."-$id-".$string2).'-'.$to.'</a>';

		$slug = $string1."-$id-".$string2."-$to";

		$message = str_replace('[NOTE_CONTENT]', $this->input->post("customer_note").'<br>'.$link, $message);
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		if($fax == "")
			$message = str_replace('- Fax -', "", $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message .= '<img src="'.base_url("order/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';
		//echo $message;
		$preview_link = array(
			"preview_id" => $id,
			"type" => 'order-customer-note',
			"preview_slug" => $slug,
			"send_date" => date("Y-m-d h:i:s")
		);

		$this->db->insert("preview_link",$preview_link);

		$docs = $this->ordermodel->getDocuments($id);
		foreach($docs as $key => $doc){
			if(file_exists("./uploads/document/".$doc->image))
				$this->email->attach("./uploads/document/".$doc->image);
		}

		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 
		
		$attached_files = $this->getNotefiles($note_id); 
		if(!empty($attached_files)){
			foreach ($attached_files as $filename) {
				if($filename->file_name != "" && file_exists("./uploads/document/".$filename->file_name)) 
					$this->email->attach("./uploads/document/".$filename->file_name);
			}
		}
		
		$useremails = array_filter($useremails);
		//echo $message; die();
		//if($this->input->post("send_email")){
		if(count($useremails) >0){
			$this->email->set_mailtype('html');
			$sendemail   = $this->mylibrary->getSiteEmail(19);
			$this->email->from($sendemail, $fromname);
			$this->email->reply_to($from, $fromname);
			$this->email->to($useremails);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();
			$this->email->clear();
		}
		//}

		// if($this->input->post("copy_email")){
		// 	$from = $data['company']->order_email;
		// 	$fromname = $data['company']->company_name;
		// 	$this->email->set_mailtype('html');
		// 	$this->email->from($from, $fromname);
		// 	$this->email->to($data['company']->email);
		// 	//$this->email->to('bikash.suwal01@gmail.com');
		// 	$this->email->subject($subject);
		// 	$this->email->message($message);
		// 	$this->email->send();
		// 	$this->email->clear();
		// }

		

	}

	function getNotefiles($note_id){
		$this->db->where("note_id",$note_id);
		return $this->db->get("order_customer_note_files")->result();
	}

	function sendmailnote_public($id,$filename,$to='cust'){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);

		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);
		$content = $this->load->view('pdf', $data, true);
		//echo $content; die();

		
		$file = 'Order'.$data['result']->order_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		/********** Get order details email template and send email to customer***********/
		//$from 	  = $this->mylibrary->getSiteEmail(31);
		//$fromname = $this->mylibrary->getSiteEmail(20);
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(72,$data['company']->company_id);

		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(73) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($sms, ENT_COMPAT));
			$sms = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $sms);
			$sms = str_replace('[NOTE_CONTENT]', $this->input->post("customer_note"), $sms);
			$sms = str_replace('[SITE_NAME]', $fromname, $sms);
			$sms = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$sms = str_replace('[LOGO]', $logo, $sms);
			$sms = str_replace('[SITE_URL]', SITE_URL, $sms);
			$sms = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $sms);
			$sms = str_replace('[SITE_EMAIL]', $data['company']->email , $sms);
			$sms = str_replace('[SITE_PHONE]', $data['company']->phone, $sms);
			$sms = str_replace('[SITE_FAX]', $fax, $sms);
			$sms = str_replace('[EMAIL]', $data['company']->email, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$mobile = $data['cutomer']->mobile_number;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/

		
		
		$subject = str_replace('[COMPANY_NAME]', $fromname, $row->email_subject);
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		

		$message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);

		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		$link = '<a href="'. base_url("order/public_customer_note/".$string1."-$id-".$string2).'-'.$to.'">'. base_url("order/public_customer_note/".$string1."-$id-".$string2).'-'.$to.'</a>';

		$slug = $string1."-$id-".$string2."-$to";

		$message = str_replace('[NOTE_CONTENT]', $this->input->post("customer_note").'<br>'.$link, $message);
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		if($fax == "")
			$message = str_replace('- Fax -', "", $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message .= '<img src="'.base_url("order/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';
		//echo $message;
		$preview_link = array(
			"preview_id" => $id,
			"type" => 'order-customer-note',
			"preview_slug" => $slug,
			"send_date" => date("Y-m-d h:i:s")
		);

		$this->db->insert("preview_link",$preview_link);

		$docs = $this->ordermodel->getDocuments($id);
		foreach($docs as $key => $doc){
			if(file_exists("./uploads/document/".$doc->image))
				$this->email->attach("./uploads/document/".$doc->image);
		}

		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 
		//$this->email->attach($file);

		if($filename != "" && file_exists("./uploads/document/".$filename)) 
			$this->email->attach("./uploads/document/".$filename);

		//echo $message; die();
		if($to == 'cust'){
			$this->email->set_mailtype('html');
			$sendemail   = $this->mylibrary->getSiteEmail(19);
			$this->email->from($sendemail, $fromname);
			$this->email->reply_to($from, $fromname);
			$this->email->to($data['cutomer']->email);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();
			$this->email->clear();
		}else{
			$from = $data['company']->order_email;
			$fromname = $data['company']->company_name;
			$this->email->set_mailtype('html');
			$sendemail   = $this->mylibrary->getSiteEmail(19);
			$this->email->from($sendemail, $fromname);
			$this->email->reply_to($from, $fromname);
			$this->email->to($data['company']->email);
			//$this->email->to('bikash.suwal01@gmail.com');
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();
			$this->email->clear();
		}
		
		return $slug;
	}


	function sendmail($id){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');
		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		// $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		// $data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);

		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);
		$content = $this->load->view('pdf', $data, true);
		
		$file = 'Order'.$data['result']->order_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		/********** Get order details email template and send email to customer***********/
		//$from 	  = $this->mylibrary->getSiteEmail(31);
		//$fromname = $this->mylibrary->getSiteEmail(20);
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(73,$data['company']->company_id);

		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(73) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($sms, ENT_COMPAT));
			$sms = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $sms);
			//$sms = str_replace('[NOTE_CONTENT]', $this->input->post("customer_note"), $sms);
			$sms = str_replace('[SITE_NAME]', $fromname, $sms);
			$sms = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$sms = str_replace('[LOGO]', $logo, $sms);
			$sms = str_replace('[SITE_URL]', SITE_URL, $sms);
			$sms = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $sms);
			$sms = str_replace('[SITE_EMAIL]', $data['company']->email , $sms);
			$sms = str_replace('[SITE_PHONE]', $data['company']->phone, $sms);
			$sms = str_replace('[SITE_FAX]', $fax, $sms);
			$sms = str_replace('[EMAIL]', $data['company']->email, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$mobile = $data['cutomer']->mobile_number;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/

		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($data['cutomer']->email);
		
		$subject = str_replace('[COMPANY_NAME]', $fromname, $row->email_subject);
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$this->email->subject($subject);

		$message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);
		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		$message = str_replace('[INVOICE_LINK]','<a href="'. base_url("order/invoice/".$string1."-$id-".$string2).'">'. base_url("order/invoice/".$string1."-$id-".$string2).'</a>', $message);
	//	$message = str_replace('[NOTE_CONTENT]', $this->input->post("customer_note"), $message);
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		if($fax == "")
			$message = str_replace('- Fax -', "", $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message .= '<img src="'.base_url("order/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';

		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 

		//echo $message; die();
		$this->email->message($message);
		$docs = $this->ordermodel->getDocuments($id);
		foreach($docs as $key => $doc){
			if(file_exists("./uploads/document/".$doc->image))
				$this->email->attach("./uploads/document/".$doc->image);
		}
		$this->email->attach($file);
		$this->email->send();
		$this->email->clear();

	}

	function sendmail_status($id,$useremails){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);

		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);
		$content = $this->load->view('pdf', $data, true);
		
		$file = 'Order'.$data['result']->order_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		/********** Get order details email template and send email to customer***********/
		//$from 	  = $this->mylibrary->getSiteEmail(31);
		//$fromname = $this->mylibrary->getSiteEmail(20);
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(74,$data['company']->company_id);

		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(73) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($sms, ENT_COMPAT));
			$sms = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $sms);
			//$sms = str_replace('[NOTE_CONTENT]', $this->input->post("customer_note"), $sms);
			$sms = str_replace('[SITE_NAME]', $fromname, $sms);
			$sms = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$sms = str_replace('[LOGO]', $logo, $sms);
			$sms = str_replace('[SITE_URL]', SITE_URL, $sms);
			$sms = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $sms);
			$sms = str_replace('[SITE_EMAIL]', $data['company']->email , $sms);
			$sms = str_replace('[SITE_PHONE]', $data['company']->phone, $sms);
			$sms = str_replace('[SITE_FAX]', $fax, $sms);
			$sms = str_replace('[EMAIL]', $data['company']->email, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$mobile = $data['cutomer']->mobile_number;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/

		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		
		
		$subject = str_replace('[COMPANY_NAME]', $fromname, $row->email_subject);
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$this->email->subject($subject);

		

		$status = $this->ordermodel->getstatus($data['result']->order_status);

		$message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);
		$message = str_replace('[ORDER_STATUS]', $status->name, $message);
		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		$message = str_replace('[INVOICE_LINK]','<a href="'. base_url("order/invoice/".$string1."-$id-".$string2).'">'. base_url("order/invoice/".$string1."-$id-".$string2).'</a>', $message);
	//	$message = str_replace('[NOTE_CONTENT]', $this->input->post("customer_note"), $message);
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		if($fax == "")
			$message = str_replace('- Fax -', "", $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message .= '<img src="'.base_url("order/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';

		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 

		//echo $message; die();
		$this->email->message($message);
		$docs = $this->ordermodel->getDocuments($id);
		foreach($docs as $key => $doc){
			if(file_exists("./uploads/document/".$doc->image))
				$this->email->attach("./uploads/document/".$doc->image);
		}

		$this->email->to($useremails);
		$this->email->attach($file);
		if(count($useremails) >0)
			$this->email->send();
		$this->email->clear();

	}

	function sendmailwithcontent_invoice($id,$subject,$message,$useremails,$cron=0){
		
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');

		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);

		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);
		$content = $this->load->view('order/invoice', $data, true); 
		
		$file = 'Invoice'.$data['result']->order_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		/********** Get order details email template and send email to customer***********/
		//$from 	  = $this->mylibrary->getSiteEmail(31);
		//$fromname = $this->mylibrary->getSiteEmail(20);
		$from = $data['company']->account_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(73,$data['company']->company_id);

		
		$message .= '<img src="'.base_url("order/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';
		foreach ($useremails as $key => $customer_email) {
			if($customer_email != ""){
				$this->email->set_mailtype('html');
				$sendemail   = $this->mylibrary->getSiteEmail(19);
				$this->email->from($sendemail, $fromname);
				$this->email->reply_to($from, $fromname);
				$this->email->to($customer_email);
				$this->email->subject($subject);

				$this->email->message($message);
				if($key == 0){
					$docs = $this->ordermodel->getDocuments($id);
					foreach($docs as $key => $doc){
						if(file_exists("./uploads/document/".$doc->image))
							$this->email->attach("./uploads/document/".$doc->image);
					};

					if($this->input->post("chk_pdf") || $cron == 1)
						$this->email->attach($file);
				}
				
				$this->email->send();
				$this->email->clear();
			}
		}

	}

	function sendmailwithcontent($id,$subject,$message,$useremails){
		
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');

		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);

		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);
		$content = $this->load->view('pdf', $data, true); 
		
		$file = 'Order'.$data['result']->order_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		/********** Get order details email template and send email to customer***********/
		//$from 	  = $this->mylibrary->getSiteEmail(31);
		//$fromname = $this->mylibrary->getSiteEmail(20);
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(73,$data['company']->company_id);

		$message .= '<img src="'.base_url("order/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';
		foreach ($useremails as $key => $customer_email) {
			if($customer_email != ""){
				$this->email->set_mailtype('html');
				$sendemail   = $this->mylibrary->getSiteEmail(19);
				$this->email->from($sendemail, $fromname);
				$this->email->reply_to($from, $fromname);
				$this->email->to($customer_email);
				$this->email->subject($subject);

				$this->email->message($message);
				if($key == 0){
					$docs = $this->ordermodel->getDocuments($id);
					foreach($docs as $key => $doc){
						if(file_exists("./uploads/document/".$doc->image))
							$this->email->attach("./uploads/document/".$doc->image);
					}

					if($this->input->post("chk_pdf")){
						$this->email->attach($file);
					}
				}
				
				$this->email->send();
				$this->email->clear();
			}
		}

	}

	function sendmailwithcontent_installer($install,$subject,$message,$useremails){
		$data['installation'] = $install;
		$id = $install['order_id'];
		$installer_id = $install['installer'];

		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');

		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$installer = $this->installermodel->getdata($installer_id)->row();
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($installer->country);

		$data['installer'] = $installer;
		$installer_type = $this->install_typemodel->getdata($install['install_type'])->row();

		$data['INSTALL_TYPE'] = $installer_type->name;
		$data['INSTALL_DATE'] = $install['installed_date'];
		$data['INSTALL_TIME'] = $install['installed_time'];
		$data['ALLOCATE_BY'] = $install['time_allocate_by'];
		$data['ALLOCATED_TIME'] = $install['allocated_time'];

		$this->db->select("notes")->from("order_installer_notes");
		$this->db->where("order_id",$id);
		$this->db->order_by("id","desc");
		$res = $this->db->get()->row_array();

		$note = @$res['notes'];
		$data['NOTE'] = $note;
		$data['FULL_NAME'] = $installer->first_name.' '.$installer->last_name;

		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);
		$content = $this->load->view('pdf_install', $data, true);
		$file = 'JA'.$data['result']->order_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		/********** Get order details email template and send email to customer***********/
		//$from 	  = $this->mylibrary->getSiteEmail(31);
		//$fromname = $this->mylibrary->getSiteEmail(20);
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(73,$data['company']->company_id);

		
		$message .= '<img src="'.base_url("order/count_install_mail_seen/".$installer_id).'" style="width:1px;height:1px;"">';
		foreach ($useremails as $key => $customer_email) {
			if($customer_email != ""){
				$this->email->set_mailtype('html');
				$sendemail   = $this->mylibrary->getSiteEmail(19);
				$this->email->from($sendemail, $fromname);
				$this->email->reply_to($from, $fromname);
				$this->email->to($customer_email);
				$this->email->subject($subject);

				$this->email->message($message);
				if($key == 0){
					$docs = $this->ordermodel->getDocuments($id);
					foreach($docs as $key => $doc){
						if(file_exists("./uploads/document/".$doc->image))
							$this->email->attach("./uploads/document/".$doc->image);
					}
				}
				if($key == 0 && $this->input->post("chk_pdf"))
					$this->email->attach($file);
				$this->email->send();
				$this->email->clear();
			}
		}



	}


	function countseen($orderid){
		$this->db->where("order_id",$orderid);
		return $this->db->get("order_seen")->num_rows();
	}

	function countinstallseen($install_id){
		$this->db->where("install_id",$install_id);
		return $this->db->get("install_seen")->num_rows();
	}

	function get_customers_lists($id){
		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$customer_arr['name'] = $data['cutomer']->first_name.' '.$data['cutomer']->first_name;
		$customer_arr['email'] = $data['cutomer']->email;
		// $customer_contacts = $this->customermodel->getMoreContact($data['result']->customer_id);

		return array($customer_arr,$customer_contacts??[]);
	}

	function getmailconent($id){

		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$customer_arr['name'] = $data['cutomer']->first_name . ' ' .$data['cutomer']->last_name;
		$customer_arr['email'] = $data['cutomer']->email;
		// $customer_contacts = $this->customermodel->getMoreContact($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);

		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(73,$data['company']->company_id);

		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($data['cutomer']->email);
		
		$subject = str_replace('[COMPANY_NAME]', $fromname, $row->email_subject);
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]', $data['cutomer']->first_name . ' ' .$data['cutomer']->last_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);

		$message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);
		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		$message = str_replace('[INVOICE_LINK]','<a href="'. base_url("order/invoice/".$string1."-$id-".$string2).'">'. base_url("order/invoice/".$string1."-$id-".$string2).'</a>', $message);

		$slug = $string1."-$id-".$string2;
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[FULL_NAME]', $data['cutomer']->first_name . ' ' .$data['cutomer']->last_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		if($fax == "")
			$message = str_replace('- Fax -', "", $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);

		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 

		return array($subject,$message,$customer_arr,$customer_contacts??[],$slug);

	}

	function getlatestpreview_slug($order_id,$type){
		$this->db->select("preview_slug")->from("preview_link");
		$this->db->where("preview_id",$order_id);
		$this->db->where("type",$type);
		$this->db->order_by("id","desc");
		$query = $this->db->get()->row();
		return @$query->preview_slug;
	}

	function getmailconent_invoice($id){

		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$customer_arr['name'] = $data['cutomer']->first_name .' '.$data['cutomer']->last_name;
		$customer_arr['email'] = $data['cutomer']->email;
		// $customer_contacts = $this->customermodel->getMoreContact($data['result']->customer_id);
		$customer_contacts = [];
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);

		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(68,$data['company']->company_id);

		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($data['cutomer']->email);
		
		$subject = str_replace('[COMPANY_NAME]', $fromname, $row->email_subject);
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]', $data['cutomer']->first_name .' '.$data['cutomer']->last_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);

		$message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);
		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		$message = str_replace('[INVOICE_LINK]','<a href="'. base_url("order/invoice/".$string1."-$id-".$string2).'">'. base_url("order/invoice/".$string1."-$id-".$string2).'</a>', $message);

		$slug = $string1."-$id-".$string2;
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[FULL_NAME]', $data['cutomer']->first_name .' '.$data['cutomer']->last_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		if($fax == "")
			$message = str_replace('- Fax -', "", $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);

		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 

		return array($subject,$message,$customer_arr,$customer_contacts,$slug);

	}

	function getmailconent_invoice_remider($id){

		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$customer_arr['name'] = $data['cutomer']->first_name. ' '.$data['cutomer']->last_name ;
		$customer_arr['email'] = $data['cutomer']->email;
		// $customer_contacts = $this->customermodel->getMoreContact($data['result']->customer_id);
		$customer_contacts= [];
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);

		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(75,$data['company']->company_id);

		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($data['cutomer']->email);
		
		$subject = str_replace('[COMPANY_NAME]', $fromname, $row->email_subject);
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]', $data['cutomer']->first_name.' '.$data['cutomer']->last_name , $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);

		$message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);
		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		$message = str_replace('[INVOICE_LINK]','<a href="'. base_url("order/invoice/".$string1."-$id-".$string2).'">'. base_url("order/invoice/".$string1."-$id-".$string2).'</a>', $message);
		$slug = $string1."-$id-".$string2;
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[FULL_NAME]',  $data['cutomer']->first_name.' '.$data['cutomer']->last_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		if($fax == "")
			$message = str_replace('- Fax -', "", $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);

		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 

		return array($subject,$message,$customer_arr,$customer_contacts,$slug);

	}

	function send_mail_to_installer($installer)
	{
		//print_r($installer); die();
		$data['installation'] = $installer;
		$id = $installer['order_id'];
		$install_id = $installer['install_id'];
		$installer_ids = $installer['installer'];
		$install_type_id = $installer['install_type'];
		$install_date = $installer['installed_date'];
		$install_time = $installer['installed_time'];
		$time_allocate_by = $installer['time_allocate_by'];
		$allocated_time = $installer['allocated_time'];
		$note = $installer['note'];
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		if(!empty($installer_ids)){
			foreach($installer_ids as $installer_id){
				$installer = $this->installermodel->getdata($installer_id)->row();
				$data['customer_account_setting'] = $this->customermodel->get_account_detail($installer->country);
				$installer_type = $this->install_typemodel->getdata($install_type_id)->row();
				$data['installer'] = $installer;
				$data['INSTALL_TYPE'] = $installer_type->name;
				$data['INSTALL_DATE'] = $install_date;
				$data['INSTALL_TIME'] = $install_time;
				$data['ALLOCATE_BY'] = $time_allocate_by;
				$data['ALLOCATED_TIME'] = $allocated_time;
				$data['NOTE'] = $note;
				$data['FULL_NAME'] = $installer->first_name.' '.$installer->last_name;
		
				$data['quote_inverters'] = $this->ordermodel->getInverterOrder($id);
		
				$content = $this->load->view('pdf_install', $data, true); 
				
				$file = 'JA'.$data['result']->order_number.'.pdf';
				$this->html2pdf->filename($file);
				$this->html2pdf->paper('a4', 'potrait');
				$this->html2pdf->html($content);
				$this->html2pdf->create('save');
				$file = "./uploads/pdf/".$file;
				
				$from = $data['company']->order_email;
				$fromname = $data['company']->company_name;
				$fax      = $this->mylibrary->getSiteEmail(62);
				if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
					$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
				}else{
					$logo = '';
				}
		
				$row = $this->mylibrary->getCompanyEmailTemplate(76,$data['company']->company_id);
				
				$this->email->set_mailtype('html');
				$sendemail   = $this->mylibrary->getSiteEmail(19);
				$this->email->from($sendemail, $fromname);
				$this->email->reply_to($from, $fromname);
				$this->email->to($installer->email);
				
				$subject = str_replace('[COMPANY_NAME]', $data['company']->company_name, $row->email_subject);
				$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
				$subject = str_replace('[SITE_NAME]', $fromname, $subject);
				$subject = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $subject);
				$subject = str_replace('[YEAR]', date('Y'), $subject);
				$subject = str_replace('[LOGO]', $logo, $subject);
				$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
				$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
				$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
				$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
				$subject = str_replace('[SITE_FAX]', $fax, $subject);
				$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
				$subject = str_replace('[YEAR]', date('Y'), $subject);
				$this->email->subject($subject);
		
				$message = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($row->email_message, ENT_COMPAT));
				$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);
				$string1 = $this->generateRandomString();
				$string2 = $this->generateRandomString();
				$message = str_replace('[INVOICE_LINK]','<a href="'. base_url("order/invoice/".$string1."-$id-".$string2).'">'. base_url("order/invoice/".$string1."-$id-".$string2).'</a>', $message);
				$message = str_replace('[SITE_NAME]', $fromname, $message);
				$message = str_replace('[INSTALL_TYPE]', $installer_type->name, $message);
				$message = str_replace('[INSTALL_DATE]', date("D, d/m/Y",strtotime($install_date)), $message);
				$message = str_replace('[INSTALL_TIME]', $install_time, $message);
				$message = str_replace('[ALLOCATE_BY]', $time_allocate_by, $message);
				$message = str_replace('[ALLOCATED_TIME]', $allocated_time, $message);
				$message = str_replace('[NOTE]', $note, $message);
				$message = str_replace('[FULL_NAME]', $installer->first_name.' '.$installer->last_name, $message);
				$message = str_replace('[YEAR]', date('Y'), $message);
				$message = str_replace('[LOGO]', $logo, $message);
				$message = str_replace('[SITE_URL]', SITE_URL, $message);
				$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
				$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
				$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
				if($fax == "")
					$message = str_replace('- Fax -', "", $message);
				$message = str_replace('[SITE_FAX]', $fax, $message);
				$message = str_replace('[EMAIL]', $data['company']->email, $message);
				$message = str_replace('[YEAR]', date('Y'), $message);
				$message .= '<img src="'.base_url("order/count_install_mail_seen/".$install_id).'" style="width:1px;height:1px;"">';
				if($data['company']->powered_by == 1){
					$thokyoo_logo     = $this->mylibrary->getlogo1();
					$message .= '<p>Power By </p>'.$thokyoo_logo;
				} 
		
				//echo $message; 
				$this->email->message($message);
				
				if($this->input->post("pdf_attachment"))
					$this->email->attach($file);
			
				$docs = $this->ordermodel->getDocuments($id); 
				foreach($docs as $key => $doc){
					if(file_exists("./uploads/document/".$doc->image))
						$this->email->attach("./uploads/document/".$doc->image);
				}
				
				$this->email->send();
				$this->email->clear();
			}
		  }
		

	}

	function get_mail_to_installer_content($installer){
		$id = $installer['order_id'];
		$installer_id = $installer['installer'];
		$install_type_id = $installer['install_type'];
		$install_date = $installer['installed_date'];
		$install_time = $installer['installed_time'];
		$time_allocate_by = $installer['time_allocate_by'];
		$allocated_time = $installer['allocated_time'];

		$this->db->select("notes")->from("order_installer_notes");
		$this->db->where("order_id",$id);
		$this->db->order_by("id","desc");
		$res = $this->db->get()->row_array();
		$note = @$res['notes'];

		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();

		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);

		$this->load->model("installer/installermodel");
		$this->load->model("install_type/install_typemodel");
		
		$installer = $this->installermodel->getdata($installer_id)->row();
		$installer_type = $this->install_typemodel->getdata($install_type_id)->row();

		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);

		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(76,$data['company']->company_id);
		
		$subject = str_replace('[COMPANY_NAME]', $data['company']->company_name, $row->email_subject);
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$this->email->subject($subject);

		$message = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);
		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[INSTALL_TYPE]', $installer_type->name, $message);
		$message = str_replace('[INSTALL_DATE]', date("D, d/m/Y",strtotime($install_date)), $message);
		$message = str_replace('[INSTALL_TIME]', $install_time, $message);
		$message = str_replace('[ALLOCATE_BY]', $time_allocate_by, $message);
		$message = str_replace('[ALLOCATED_TIME]', $allocated_time, $message);
		$message = str_replace('[NOTE]', $note, $message);
		$message = str_replace('[FULL_NAME]', $installer->first_name.' '.$installer->last_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		if($fax == "")
			$message = str_replace('- Fax -', "", $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message .= '<img src="'.base_url("order/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';
		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 

		return array($subject,$message);

	}

	function get_install_detail($install_id)
	{
		$this->db->select("*")->from("order_installer oi");
		$this->db->join("installer i","i.threatre_id = oi.installer");
		$this->db->where("id",$install_id);
		return $this->db->get("")->row_array();
	}

	function send_mail_to_installer_me($installer)
	{ 
		$data['installation'] = $installer;
		$id = $installer['order_id'];
		$installer_ids = $installer['installer'];
		$install_type_id = $installer['install_type'];
		$install_date = $installer['installed_date'];
		$install_time = $installer['installed_time'];
		$time_allocate_by = $installer['time_allocate_by'];
		$allocated_time = $installer['allocated_time'];
		$note = $installer['note'];
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->ordermodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		foreach($installer_ids as $installer_id){
		$installer = $this->installermodel->getdata($installer_id)->row();
		$data['customer_account_setting'] = $this->customermodel->get_account_detail($installer->country);
		$installer_type = $this->install_typemodel->getdata($install_type_id)->row();

		$quote_inverters = $this->ordermodel->getInverterOrder($id);
		$content = $this->load->view('pdf_install', $data, true); 
		
		$file = 'JA'.$data['result']->order_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		/********** Get order details email template and send email to customer***********/
		//$from 	  = $this->mylibrary->getSiteEmail(31);
		//$fromname = $this->mylibrary->getSiteEmail(20);
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(76,$data['company']->company_id);
		

		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($data['company']->email);
		
		$subject = str_replace('[COMPANY_NAME]', $data['company']->company_name, $row->email_subject);
		$subject = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]', $data['cutomer']->first_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$this->email->subject($subject);

		$message = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[ORDER_NUMBER]', $data['result']->order_number, $message);
		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		$message = str_replace('[INVOICE_LINK]','<a href="'. base_url("order/invoice/".$string1."-$id-".$string2).'">'. base_url("order/invoice/".$string1."-$id-".$string2).'</a>', $message);
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[INSTALL_TYPE]', $installer_type->name, $message);
		$message = str_replace('[INSTALL_DATE]', date("D, d/m/Y",strtotime($install_date)), $message);
		$message = str_replace('[INSTALL_TIME]', $install_time, $message);
		$message = str_replace('[ALLOCATE_BY]', $time_allocate_by, $message);
		$message = str_replace('[ALLOCATED_TIME]', $allocated_time, $message);
		$message = str_replace('[NOTE]', $note, $message);
		$message = str_replace('[FULL_NAME]', $installer->first_name.' '.$installer->last_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		if($fax == "")
			$message = str_replace('- Fax -', "", $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message .= '<img src="'.base_url("order/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';
		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 

		//echo $message; 
		$this->email->message($message);
		$docs = $this->ordermodel->getDocuments($id);
		foreach($docs as $key => $doc){
			if(file_exists("./uploads/document/".$doc->image))
				$this->email->attach("./uploads/document/".$doc->image);
		}

		if($this->input->post("pdf_attachment") && !$this->input->post("send_mail"))
			$this->email->attach($file);
	//	$this->email->send();
		$this->email->clear();
	}

	}

	function orderdocs($id){
		$this->db->select("document_id");
		$this->db->where("order_id",$id);
		return $this->db->get("order_documents")->result_array();
	}

	function getDocuments($id){
		$this->db->select("*")->from('order_documents od');
		$this->db->join("document d",'d.content_id = od.document_id');
		$this->db->where("od.order_id",$id);
		return $this->db->get()->result();
	}

}