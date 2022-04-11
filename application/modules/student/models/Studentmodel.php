<?php
class studentmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'company_students';		

	}

	function listall($limit = null,$status = null,$all=null){		
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		$all_data = $all ? $all_data : 1;
		$company_user_id = $this->commonmodel->getcompany_userid_new();
		$front_user_id = $this->session->userdata("clms_front_userid");
		$front_company_id = $this->session->userdata("clms_front_companyid");

	    if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("user_group",14);	
		if($status)
		$this->db->where("c.status",$status);
		$this->db->order_by('c.id','desc');
		$this->db->select("*,c.id")->from("company_students c");
		$this->db->join("company_student_details cd",'c.id=cd.company_student_id');

		if($all_data == 0){
			$this->db->where("(c.added_by = $front_user_id OR c.id = $company_user_id OR cd.referral=$company_user_id OR c.student_id=$front_user_id)");
		}

		$query=$this->db->get();
		return $query;

	}

	function get_docType(){
		$this->db->where("company_id",$this->session->userdata("clms_front_userid"));
		$query=$this->db->get("doc_type");
		return $query->result();
	}

	function getDocType($doc_type){
		$this->db->where("type_id",$doc_type);
		return $this->db->get("doc_type")->row();
	}

	function getConfigData($config_id){
		$this->db->where('config_id',$config_id);
		return $this->db->get('site_config')->row();
	}

	function get_packagename($id){
		$this->db->where("status_id",$id);
		return $this->db->get("invoice_status")->row()->status_name;
	}

	function getinvoiceDetails($student_id){
		$this->db->select("*");
		$this->db->from("student_package_value cpv");
		$this->db->join("student_package cp","cp.package_id=cpv.package_id");
		$this->db->where("cpv.student_id",$student_id);
		return $this->db->get("")->result();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($student_id){
		$this->db->select("*,c.id");
		$this->db->from($this->table.' c');
		$this->db->join('company_student_details cd','c.id=cd.company_student_id');
		$this->db->where('c.id',$student_id);
		$query=$this->db->get();
		return $query;

	}

	function getdata_new($userid){
		$this->db->select("*")->from("users u");
		$this->db->join('student_details ud','u.userid=ud.student_id');
		return $this->db->where("u.userid",$userid)->get();
	}

	function get_packages(){
		$this->db->where("status",1);
		return $this->db->get("student_package")->result();
	}

	function getStatus(){
		if($this->session->userdata("student") && $this->session->userdata("student") != "")	{
			$this->db->where("student_id",$this->session->userdata("student"));
			$this->db->or_where("student_id",0);
		}
		$this->db->where("status",1);
		return $this->db->get("invoice_status")->result();
	}

	function get_studentPackage($project_id){
		$this->db->where("student_id",$project_id);
		return $this->db->get("student_package_value")->result();
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
				$this->db->where_in('student_id',$ids);
				$this->db->delete("student_details");
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

	function getDoccuments($userid){
		$this->db->select("*")->from("student_documents d");
		$this->db->join("users u","u.userid = d.student_id");
		$this->db->where("u.userid",$userid);
		return $this->db->get()->result();
	}

	function getQualifications($userid){
		$this->db->where("student_id",$userid);
		return $this->db->get("student_qualification")->result();
	}

	function getExperinces($userid){
		$this->db->where("student_id",$userid);
		return $this->db->get("student_experience")->result();
	}

	function getnotes($student_id){
		$this->db->where("company_student_id",$student_id);
		return $this->db->get("company_student_note")->result();
	}

	function get_docDetail($docid){
		$this->db->where("id",$docid);
		return $this->db->get("company_student_documents")->row();
	}

	function getQualificationDetail($qid){
		$this->db->where("id",$qid);
		return $this->db->get("company_student_qualification")->row();
	}

	function getExperienceDetail($qid){
		$this->db->where("id",$qid);
		return $this->db->get("student_experience")->row();
	}

	function sendemail($student_id,$password=null){ 
		$student = $this->getdata($student_id)->row();

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
		$this->email->to($student->email);
		$row = $this->mylibrary->getCompanyEmailTemplate(54,$this->session->userdata("clms_front_companyid"));

		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
		$subject = str_replace('[FULL_NAME]',$student->first_name.' '.$student->last_name,$subject);
		$subject = str_replace('[GROUP_NAME]','Student',$subject);
		$subject = str_replace('[COMPANY_NAME]',@$company->company_name,$subject);
		$this->email->subject($subject);
		$message = str_replace('[FULL_NAME]',$student->first_name.' '.$student->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[GROUP_NAME]','Student',$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		$message = str_replace('[SITE_URL]',$site_url,$message);
		$message = str_replace('[USERNAME]',$student->user_name,$message);
		$message = str_replace('[PASSWORD]',$password,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		$message = str_replace('[LINK]','<a href="'.SITE_URL.'invite-user/'.$company->uuid.'/'.$student->uuid.'?type=14">Accept Invitation</a>',$message);

		$message = str_replace('[COMPANY_NAME]',@$company->company_name,$message);
		$message = str_replace('[COMPANY_ADDRESS]',@$company->address,$message); 
		$this->email->message($message);
		$this->email->send();
		$this->email->clear();

		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[STUDENT_NAME]',$student->first_name.' '.$student->last_name,html_entity_decode($sms,ENT_COMPAT));
			$sms = str_replace('[SITE_NAME]',$fromname,$sms);
			$sms = str_replace('[LOGO]',$logo,$sms);
			$sms = str_replace('[SITE_ADDRESS]',$address,$sms);
			$sms = str_replace('[SITE_PHONE]',$phone,$sms);
			$sms = str_replace('[SITE_FAX]',$fax,$sms);
			$sms = str_replace('[SITE_EMAIL]',$sitemail,$sms);
			$sms = str_replace('[SITE_URL]',$site_url,$sms);
			$sms = str_replace('[USERNAME]',$student->user_name,$sms);
			$sms = str_replace('[PASSWORD]',$password,$sms);
			$sms = str_replace('[YEAR]',date('Y'),$sms);
			$sms = str_replace('[COMPANY_NAME]',@$company->company_name,$sms);
			$sms = str_replace('[COMPANY_ADDRESS]',@$company->address,$sms);
			$sms = str_replace('[LINK]','<a href="'.SITE_URL.'invite-student/'.$company->uuid.'/'.$student->uuid.'">Accept Invitation</a>',$sms);
			$mobile = $student->mobile;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/
	}

	function addDocEmail($student_id,$docid){
		$student = $this->getdata($student_id)->row();
		$docs = $this->get_docDetail($docid);
		// print_r($docs);die();
		$doctype = $this->getDocType($docs->doc_type);
		$company = $this->usermodel->getuser($this->session->userdata("clms_front_companyid"))->row();
		if($docs->is_verified == '1')
			$status =  'Verified';
		else
			$status =  'Not Verified';

		$from = $company->email;
		$fromname = $company->company_name;

		$fax      = $this->mylibrary->getSiteEmail(62);
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
		$this->email->to($student->email);
		
		$row = $this->mylibrary->getCompanyEmailTemplate(62,$this->session->userdata("clms_front_companyid"));

		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[STUDENT_NAME]',$student->first_name.' '.$student->last_name,html_entity_decode($sms,ENT_COMPAT));
			$sms = str_replace('[DOC_TYPE]',$doctype->type_name,$sms);
			$sms = str_replace('[CONTENT]',$docs->doc_desc,$sms);
			$sms = str_replace('[STATUS]',$status,$sms);
			$sms = str_replace('[NAME]',@$company->first_name.' '.@$company->last_name,$sms);
			$sms = str_replace('[SITE_NAME]',$fromname,$sms);
			$sms = str_replace('[LOGO]',$logo,$sms);
			$sms = str_replace('[SITE_ADDRESS]',$address,$sms);
			$sms = str_replace('[SITE_PHONE]',$phone,$sms);
			$sms = str_replace('[SITE_FAX]',$fax,$sms);
			$sms = str_replace('[SITE_EMAIL]',$sitemail,$sms);
			$sms = str_replace('[SITE_URL]',$site_url,$sms);
			$sms = str_replace('[YEAR]',date('Y'),$sms);

			$sms = str_replace('[COMPANY_NAME]',@$company->company_name,$sms);
			$sms = str_replace('[COMPANY_ADDRESS]',@$company->address,$sms);
			$mobile = $student->mobile;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/

		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
		$subject = str_replace('[STATUS]',$status,$subject);
		$subject = str_replace('[DOC_TYPE]',$doctype->type_name,$subject);
		$this->email->subject($subject);
		$message = str_replace('[STUDENT_NAME]',$student->first_name.' '.$student->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[DOC_TYPE]',$doctype->type_name,$message);
		$message = str_replace('[CONTENT]',$docs->doc_desc,$message);
		$message = str_replace('[STATUS]',$status,$message);
		$message = str_replace('[NAME]',@$company->first_name.' '.@$company->last_name,$message);
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		$message = str_replace('[SITE_URL]',$site_url,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		
		$message = str_replace('[COMPANY_NAME]',@$company->company_name,$message);
		$message = str_replace('[COMPANY_ADDRESS]',@$company->address,$message);

		$this->email->message($message);
		$this->email->send();
		$this->email->clear();
	}

	function checkStudent($companyid,$email){
		$this->db->where("company_id",$companyid);
		$this->db->where("email",$email);
		return $this->db->get("company_students");
	}

}