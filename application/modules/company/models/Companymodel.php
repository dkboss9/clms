<?php
class companymodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'users';		

	}

	function listall($limit = null){		
		
		$this->db->where("user_group",7);	
		$this->db->order_by('userid','desc');
		$this->db->select("*")->from("users c");
		$this->db->join("company_details cd",'c.userid=cd.company_id');
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("c.company_id",$this->session->userdata("clms_company"));	
		$query=$this->db->get();
		return $query;

	}

	function has_referal_permission($user_id,$module_id){
		$this->db->where("module_id",$module_id);
		$this->db->where("user_id",$user_id);
		return $this->db->get("permissions_per_user")->num_rows();
	}

	function checkCompanyNo(){
		$userid = $this->session->userdata("clms_userid");


		$this->db->where("company_id",$userid);
		$row = $this->db->get("company_details")->row();

		$package_id = $row->package_id; 

		$this->db->where("package_id",$package_id);
		$package = $this->db->get("pnp_module_package")->row();

		$max_company = $package->max_no_company;

		$this->db->where("company_id",$userid);
		$this->db->where("user_group",7);
		$query = $this->db->get("users");

		$no_of_comp = $query->num_rows();

		if($no_of_comp >= $max_company )
			return false;
		else
			return true;
	}

	function checkreminder($remind_date,$company_id='0'){
		//$company_id = $this->session->userdata("company_id");
		$this->db->where("company_id",$company_id);
		$reminder = $this->db->get("package_reminder")->result();
		$chk = 0;
		foreach($reminder as $row){
			if($remind_date == $row->reminder)
				$chk = 1;
		}
		return $chk;
	}

	function getReminderDate(){
		//$this->db->where("company_id",$company_id);
		return $this->db->get("package_reminder")->result();
	}

	function getConfigData($config_id){
		$this->db->where('config_id',$config_id);
		return $this->db->get('site_config')->row();
	}

	function get_packagename($id){
		$this->db->where("status_id",$id);
		return $this->db->get("invoice_status")->row()->status_name;
	}

	function getinvoiceDetails($company_id){
		$this->db->select("*");
		$this->db->from("company_package_value cpv");
		$this->db->join("company_package cp","cp.package_id=cpv.package_id");
		$this->db->where("cpv.company_id",$company_id);
		return $this->db->get("")->result();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($start_id){
		$this->db->select("*");
		$this->db->from($this->table.' c');
		$this->db->join('company_details cd','c.userid=cd.company_id');
		$this->db->where('c.userid',$start_id);
		$query=$this->db->get();
		return $query;

	}

	function getdatawithuuid($uuid){
		$this->db->select("*");
		$this->db->from($this->table.' c');
		$this->db->join('company_details cd','c.userid=cd.company_id');
		$this->db->where('c.uuid',$uuid);
		$query=$this->db->get();
		return $query;

	}

	function get_packages(){
		$this->db->where("status",1);
		return $this->db->get("company_package")->result();
	}

	function getStatus(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$this->db->where("company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("company_id",0);
		}
		$this->db->where("status",1);
		return $this->db->get("invoice_status")->result();
	}

	function get_companyPackage($project_id){
		$this->db->where("company_id",$project_id);
		return $this->db->get("company_package_value")->result();
	}



	function update($start_id, $data){
		$this->db->where('userid', $start_id);
		$this->db->update($this->table, $data);
	}

	function delete($start_id) {
		$this->db->where('userid', $start_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('userid',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('userid',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('userid',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}

		}
		return;
	}

	function get_leadType(){
		$this->db->where("status",1);
		return $this->db->get("lead_type")->result();
	}

	function getRate($userid,$type_id){
		$this->db->where("type_id",$type_id);
		$this->db->where("user_id",$userid);
		return $this->db->get("salesrep_rate")->row();
	}

	function getcoutries(){
		return $this->db->get("countries")->result();
	}

	function getstates($country){
		$this->db->where("country_id",$country);
		return $this->db->get("states")->result();
	}

	function get_service_time($companyid,$dayid){
		$this->db->where("company_id",$companyid);
		$this->db->where("service_day",$dayid);
		$query = $this->db->get("company_service_time_available");
		return $query->row();
	}

	function setModulePermission_for_group($companyid){
		$this->db->where("status",1);
		$this->db->where("company_id",0);
		$groups = $this->db->get("pnp_group")->result();

		foreach($groups as $group){
			$this->db->where("group_id",$group->groupid);
			$this->db->where("company_id",NULL);
			$permissions = $this->db->get("pnp_permissions_per_group")->result_array();
			foreach($permissions as $perm){
				unset($perm['permission_per_group_id']);
				$perm['added_by'] = $companyid;
				$perm['added_date'] = date("Y-m-d H:i:s");
				$perm['modified_by'] = $companyid;
				$perm['modified_date'] = date("Y-m-d H:i:s");
				$perm['company_id'] = $companyid;
			}
		}
	}

	function listPackages($packageid=null){
		$this->db->where("status",1);
		$this->db->where("package_id !=",19);
		if($packageid)
			$this->db->where("package_id !=",$packageid);
		return $this->db->get("pnp_module_package")->result();
	}

	function get_packageDetails($package_id){
		$this->db->where("package_id",$package_id);
		return $this->db->get("pnp_module_package")->row();
	}

	function setModulePermission_by_package($package_id,$user_group_company_id,$company_id){
		$this->db->where("user_group_company_id",$user_group_company_id);
		$this->db->delete("pnp_permissions_per_user_group_company");
		$this->db->where("package_id",$package_id);
		$permissions = $this->db->get("permissions_per_package")->result();

		$this->db->where("user_group_company_id",$user_group_company_id)->delete("pnp_permissions_per_user_group_company");

		foreach($permissions as $row){
			$arr = array(
				"module_id" => $row->module_id,
				"user_action_id" => $row->user_action_id,
				"user_group_company_id" => $user_group_company_id,
				"added_by" => $company_id,
				"added_date" => date("Y-m-d"),
				"modified_by" => $company_id,
				"modified_date" => date("Y-m-d")
			);
			$this->db->insert('pnp_permissions_per_user_group_company',$arr);
		}
	}

	function setModulePermission($package_id,$group_user_company_id){
		$this->db->where("user_group_company_id ",$group_user_company_id);
		$this->db->delete("permissions_per_user_group_company");
		$this->db->where("package_id",$package_id);
		$permissions = $this->db->get("permissions_per_package")->result();

	//	print_r($permissions );

		foreach($permissions as $row){
			$arr = array(
				"module_id" => $row->module_id,
				"user_action_id" => $row->user_action_id,
				"user_group_company_id" => $group_user_company_id,
				"added_by" => 2,
				"added_date" => date("Y-m-d"),
				"modified_by" => 2,
				"modified_date" => date("Y-m-d")
			);
			$this->db->insert('permissions_per_user_group_company',$arr);
		}

	}
	


	function updateModule_perm($package_id){
		$companies = $this->getCompanyWithPackage($package_id);
		foreach ($companies as $row) {
			$this->setModulePermission($package_id,$row->id);
		}
	}


	function getCompanyWithPackage($package_id){
		$this->db->select("gc.*");
		$this->db->from($this->table.' c');
		$this->db->join('company_details cd','c.userid=cd.company_id');
		$this->db->join('user_groups ug','c.userid=ug.user_id');
		$this->db->join('pnp_user_group_company gc','gc.user_group_id=ug.id');
		$this->db->where("ug.group_id",7);
		$this->db->where('cd.package_id',$package_id);
		$query=$this->db->get();
		return $query->result();

	}

	function getPackageDetail($package_id){
		$this->db->where("package_id",$package_id);
		return $this->db->get("pnp_module_package")->row();
	}

	function updateorder($data,$company_id){
		$this->db->where("company_id",$company_id);
		$this->db->update("company_details",$data);
	}

	function getCompanyPackage($company_id){
		$this->db->where("user_id",$company_id);
		$this->db->order_by("id","desc");
		return $this->db->get("company_package_order")->row();
	}

	function updatecompanyPackage($data,$company_id){
		$package = $this->getCompanyPackage($company_id);

		$id = $package->id;
		$this->db->where("id",$id);
		$this->db->update('company_package_order',$data);
	}

	function sendEmail($type,$company_id){
		$from 	  = $this->mylibrary->getSiteEmail(22);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(59);
		$phone    = $this->mylibrary->getSiteEmail(61);
		$fax      = $this->mylibrary->getSiteEmail(94);
		$sitemail = $this->mylibrary->getSiteEmail(23);
		$sendemail = $this->mylibrary->getSiteEmail(19);

		$company = $this->getdata($company_id)->row();

		$package = $this->get_packageDetails($company->package_id);

		$logo     = $this->mylibrary->getlogo(); 
		
		$row = $this->mylibrary->getEmailTemplate(2);
		$this->email->set_mailtype('html');
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($company->email);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
	//	$subject = str_replace('[ORDER_NUMBER]',$order->order_num ,$subject);
		$this->email->subject($subject);
		$message = str_replace('[FULL_NAME]',$company->first_name.' '.$company->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[PAYMENT_METHOD]',$company->payment_method,$message);
		$message = str_replace('[PACKAGE_NAME]',$package->name,$message);
		$message = str_replace('[ORDER_TERM]',$company->payment_term,$message);
		$message = str_replace('[AMOUNT]',$company->price,$message);
		$message = str_replace('[INVOICE_STATUS]',$company->invoice_status,$message);
		$message = str_replace('[EXPIRY_DATE]',date("d-m-Y",$company->expiry_date),$message);
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		//$data['mail'] = $message;
		//echo $message; die();
		$this->email->message($message);
		$this->email->send();
		$this->email->clear();						
		//$query->free_result();	
	}

	function sendEmailUpgrade($type,$company_id){
		$from 	  = $this->mylibrary->getSiteEmail(22);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(59);
		$phone    = $this->mylibrary->getSiteEmail(61);
		$fax      = $this->mylibrary->getSiteEmail(94);
		$sitemail = $this->mylibrary->getSiteEmail(23);
		$sendemail = $this->mylibrary->getSiteEmail(19);

		$company = $this->getdata($company_id)->row();

		$package = $this->get_packageDetails($company->package_id);

		$logo     = $this->mylibrary->getlogo(); 
	
		$row = $this->mylibrary->getEmailTemplate(84);
		$this->email->set_mailtype('html');
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($company->email);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
	//	$subject = str_replace('[ORDER_NUMBER]',$order->order_num ,$subject);
		$this->email->subject($subject);
		$message = str_replace('[FULL_NAME]',$company->first_name.' '.$company->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[PAYMENT_METHOD]',$company->payment_method,$message);
		$message = str_replace('[PACKAGE_NAME]',$package->name,$message);
		$message = str_replace('[ORDER_TERM]',$company->payment_term,$message);
		$message = str_replace('[AMOUNT]',$company->price,$message);
		$message = str_replace('[INVOICE_STATUS]',$company->invoice_status,$message);
		$message = str_replace('[EXPIRY_DATE]',date("d-m-Y",$company->expiry_date),$message);
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		//$data['mail'] = $message;
		//echo $message; die();
		$this->email->message($message);
		$this->email->send();
		$this->email->clear();						
		//$query->free_result();	
	}


	function sendEmailActivation($company_id){
		$from 	  = $this->mylibrary->getSiteEmail(22);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(59);
		$phone    = $this->mylibrary->getSiteEmail(61);
		$fax      = $this->mylibrary->getSiteEmail(94);
		$sitemail = $this->mylibrary->getSiteEmail(23);
		$sendemail = $this->mylibrary->getSiteEmail(19);

		$code = mt_rand(1111,9999);

		$company = $this->db->where("userid",$company_id)->get("users")->row();

		$this->db->where("userid",$company_id);
		$this->db->set("code",$code);
		$this->db->update("users");

	//	$package = $this->get_packageDetails($company->package_id);

		$link = '<a href="'.base_url()."activate-account/".$company->uuid.'">Verify Email</a>';

		$logo     = $this->mylibrary->getlogo(); 
	
		$row = $this->mylibrary->getEmailTemplate(86);
	
		$this->email->set_mailtype('html');
		$this->email->from($from, $fromname);
		$this->email->reply_to($sitemail, $fromname);
		$this->email->to($company->email);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
	//	$subject = str_replace('[ORDER_NUMBER]',$order->order_num ,$subject);
		$this->email->subject($subject);
		$message = str_replace('[FULL_NAME]',$company->first_name.' '.$company->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[ACTIVATION_LINK]',$link,$message);
		$message = str_replace('[CODE]',$code,$message);
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		//$data['mail'] = $message;
		$this->email->message($message);
		$this->email->send();
		$this->email->clear();						
		//$query->free_result();	
	}

	function checked_inemails($company){
		$this->db->where("company_id",$company);	
		return $this->db->get("company_standup_emails")->result();
	}


	function sendReminderEmail($company){
		$from 	  = $this->mylibrary->getSiteEmail(22);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(59);
		$phone    = $this->mylibrary->getSiteEmail(61);
		$fax      = $this->mylibrary->getSiteEmail(94);
		$sitemail = $this->mylibrary->getSiteEmail(23);
		$sendemail = $this->mylibrary->getSiteEmail(19);

		//$company = $this->getdata($company_id)->row();

		$package = $this->get_packageDetails($company->package_id);

		$logo     = $this->mylibrary->getlogo(); 
		$row = $this->mylibrary->getCompanyEmailTemplate(56,$company->company_id);
		$this->email->set_mailtype('html');
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($company->email);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
	//	$subject = str_replace('[ORDER_NUMBER]',$order->order_num ,$subject);
		$this->email->subject($subject);
		$message = str_replace('[FULL_NAME]',$company->first_name.' '.$company->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[UPDATE_URL]',base_url("upgrade/".$company->company_id),$message);
		$message = str_replace('[EXPIRY_DATE]',date("d-m-Y",$company->expiry_date),$message);
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		$this->email->message($message);
		$this->email->send();
		$this->email->clear();				
	}

	function checkEmail($userid,$email_id){
		$this->db->where("company_id",$userid);
		$this->db->where("email_id",$email_id);
		return $this->db->get("company_email_template")->num_rows();
	}

	function updateCompanyEmail($userid){
		$this->db->where("email_id not in (57,63,64,65)");
		$emails = $this->db->get("email_template")->result();

		foreach($emails as $row){
			if($this->checkEmail($userid,$row->email_id) == 0){
				$email_array = array(
					"email_id" => $row->email_id,
					"company_id" => $userid, 
					"email_subject" => $row->email_subject,
					"email_message" => $row->email_message,
					"email_desc" => $row->email_desc,
					"sms" => 0,
					"sms_text" => $row->sms_text,
					"updated_date" => time(),
					"updated_by" => time()
				);
				$this->db->insert("company_email_template",$email_array);
			}
		}
	}
}