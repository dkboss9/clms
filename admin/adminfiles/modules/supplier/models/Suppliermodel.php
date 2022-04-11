<?php
class Suppliermodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'company_users';		

	}

	function listall($limit = null){	
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_company"),$this->session->userdata("usergroup"))->num_rows();
		$company_user_id = $this->session->userdata("company_user_id");
		$userid = $this->commonmodel->get_login_id();
		$company_id = $this->session->userdata("clms_company");
		$group_id = $this->session->userdata("usergroup");

		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));

		if($all_data == 0){
			$this->db->where("(added_by = $userid OR id = $company_user_id)");
		}

		$this->db->where("user_group",10);	
		$this->db->order_by('id','desc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($start_id){
		$this->db->select("*,u.id userid")->from("company_users u");
		$this->db->join("company_supplier_details s","u.id=s.company_user_id");
		$this->db->where('u.id',$start_id);
		$query=$this->db->get("");
		return $query;

	}

	function update($start_id, $data){
		$this->db->where('id', $start_id);
		$this->db->update($this->table, $data);
	}

	function delete($start_id) {
		$this->db->where('id', $start_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function employeeLevel(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		return $this->db->get("employee_level")->result();
	}

	function employeePosition(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		return $this->db->get("employee_position")->result();
	}

	function employeetransport(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		return $this->db->get("employee_transport")->result();
	}

	function employeeType(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		return $this->db->get("employee_type")->result();
	}

	function get_service_day(){
		return $this->db->get("service_day")->result();
	}
	function get_service_time($userid,$dayid){
		$this->db->where("employee_id",$userid);
		$this->db->where("service_day",$dayid);
		$query = $this->db->get("service_time_available");
		return $query->row();
	}

	function send_approval_email($sub_agent_id){
		$supplier = $this->getdata($sub_agent_id)->row();
		$company = $this->usermodel->getuser($this->session->userdata("clms_company"))->row();
		$from = $company->email;
		$fromname = $company->company_name;

		$fax      = $company->fax;
		if($company->thumbnail != '' && file_exists('../assets/uploads/users/thumb/'.$company->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
		}else{
			$logo = '';
		}

		$sitemail = $this->mylibrary->getSiteEmail(23);
		$noreplyemail = $this->mylibrary->getSiteEmail(22);
		$site_url = $this->mylibrary->getSiteEmail(21);
	//	$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $company->address;
		$phone    = $company->phone;
		$sitemail = $company->email;
		$this->email->set_mailtype('html');
		$this->email->from($noreplyemail, $fromname);
		$this->email->reply_to($company->email);
		$this->email->to($supplier->email);
		$row = $this->mylibrary->getCompanyEmailTemplate(54,$this->session->userdata("clms_company"));

		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
		$subject = str_replace('[FULL_NAME]',$supplier->first_name.' '.$supplier->last_name,$subject);
		$subject = str_replace('[GROUP_NAME]','Consultancy',$subject);
		$subject = str_replace('[COMPANY_NAME]',@$company->company_name,$subject);
		$this->email->subject($subject);
		$message = str_replace('[FULL_NAME]',$supplier->first_name.' '.$supplier->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[GROUP_NAME]','Consultancy',$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		$message = str_replace('[SITE_URL]',$site_url,$message);
	
		$message = str_replace('[YEAR]',date('Y'),$message);
		$message = str_replace('[LINK]','<a href="'.SITE_URL.'invite-user/'.$company->uuid.'/'.$supplier->uuid.'?type=10">Accept Invitation</a>',$message);

		$message = str_replace('[COMPANY_NAME]',@$company->company_name,$message);
		$message = str_replace('[COMPANY_ADDRESS]',@$company->address,$message); 
		$this->email->message($message);
		$this->email->send();
		$this->email->clear();
	}
	
}