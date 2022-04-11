<?php
class salerepmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'company_users';		

	}

	function listall($limit = null){		
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		$company_user_id = $this->commonmodel->getcompany_userid_new();
		$front_user_id = $this->session->userdata("clms_front_userid");
		$front_company_id = $this->session->userdata("clms_front_companyid");

		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$this->db->where("(company_id = $front_company_id OR company_id = 0)");
		}	

		if($all_data == 0)
			$this->db->where("added_by",$front_user_id);
		$this->db->where("user_group",3);	
		$this->db->order_by('id','desc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($salerepid){
		$this->db->where('id',$salerepid);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($salerepid, $data){
		$this->db->where('id', $salerepid);
		$this->db->update($this->table, $data);
	}

	function delete($salerepid) {
		$this->db->where('id', $salerepid);
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

	function get_leadType(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$userid = $this->session->userdata("clms_front_companyid");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}	
		
		$this->db->where("status",1);
		return $this->db->get("lead_type")->result();
	}

	function getRate($userid,$type_id){
		$this->db->where("type_id",$type_id);
		$this->db->where("user_id",$userid);
		return $this->db->get("salesrep_rate")->row();
	}

	function send_approval_email($salerepid){
		$salerep = $this->getdata($salerepid)->row();
		$company = $this->usermodel->getuser($this->session->userdata("clms_front_companyid"))->row();
		$from = $company->email;
		$fromname = $company->company_name;

		$fax      = $company->fax;
		if($company->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$company->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
		}else{
			$logo = '';
		}

		//$from     = $this->mylibrary->getSiteEmail(32);
		$site_url = $this->mylibrary->getSiteEmail(21);
	//	$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $company->address;
		$phone    = $company->phone;
		$sitemail = $company->email;
		$this->email->set_mailtype('html');
		$this->email->from($sitemail, $fromname);
		$this->email->to($salerep->email);
		$row = $this->mylibrary->getCompanyEmailTemplate(54,$this->session->userdata("clms_front_companyid"));

		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
		$subject = str_replace('[FULL_NAME]',$salerep->first_name.' '.$salerep->last_name,$subject);
		$subject = str_replace('[GROUP_NAME]','Employee',$subject);
		$subject = str_replace('[COMPANY_NAME]',@$company->company_name,$subject);
		$this->email->subject($subject);
		$message = str_replace('[FULL_NAME]',$salerep->first_name.' '.$salerep->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[GROUP_NAME]','Employee',$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		$message = str_replace('[SITE_URL]',$site_url,$message);
	
		$message = str_replace('[YEAR]',date('Y'),$message);
		$message = str_replace('[LINK]','<a href="'.SITE_URL.'invite-user/'.$company->uuid.'/'.$salerep->uuid.'?type=3">Accept Invitation</a>',$message);

		$message = str_replace('[COMPANY_NAME]',@$company->company_name,$message);
		$message = str_replace('[COMPANY_ADDRESS]',@$company->address,$message); 
		$this->email->message($message);
		$this->email->send();
		$this->email->clear();
	}
}