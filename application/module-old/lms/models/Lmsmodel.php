<?php
class LmsModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'leads';

	}

	function listall($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date){
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		$company_user_id = $this->commonmodel->getcompany_userid_new();
	
		$front_user_id = $this->session->userdata("clms_front_userid");
		$front_company_id = $this->session->userdata("clms_front_companyid");

		$this->db->select('*,l.added_by handle,l.email email, l.status,s.type_name as source_name,l.added_date');
		$this->db->from($this->table." l");
	
		$this->db->join("lead_status ls","ls.status_id=l.status_id");
		$this->db->join("source s","s.type_id=l.lead_source","left");
		$this->db->join("company_users u","u.id=l.user_id","left");
		if($handle != "")
			$this->db->where("l.user_id",$handle);
		if($country != "")
			$this->db->where("l.country",$country);
		if($weightage != "")
			$this->db->where("l.weightage_id",$weightage);
		if($status != "")
			$this->db->where("l.status_id",$status);
		if($access != "")
			$this->db->where("l.access",$access);
		if($category != "")
			$this->db->where("l.category",$category);
		if($language != "")
			$this->db->where("l.language",$language);
		if($all_data == 0){
			$this->db->where("(l.added_by = $front_user_id OR l.user_id = $company_user_id OR l.consultant=$company_user_id OR l.student_id=$company_user_id)");
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_front_companyid"));
		if($lead_date !=""){
			if($lead_date == "today")
				$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`+64800), '%Y-%m-%d') = CURDATE()");
			elseif($lead_date == "tomorrow")
				$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`+64800), '%Y-%m-%d') = DATE_FORMAT(CURDATE()+1, '%Y-%m-%d')");
			elseif($lead_date == 'exceeded')
				$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`+64800), '%Y-%m-%d') < CURDATE()");
		}

		if($added_date !=""){
			if($added_date == "today")
				$this->db->where("DATE_FORMAT(FROM_UNIXTIME(l.`added_date`), '%Y-%m-%d') = CURDATE()");
			elseif($added_date == "yesterday")
				$this->db->where("l.added_date >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY)) AND l.added_date < UNIX_TIMESTAMP(CURDATE())");
			elseif($added_date == "week")
				$this->db->where("WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(l.`added_date`), '%Y-%m-%d'))=WEEKOFYEAR(NOW())");
			elseif($added_date == "month")
				$this->db->where("MONTH(DATE_FORMAT(FROM_UNIXTIME(l.`added_date`), '%Y-%m-%d'))=MONTH(NOW())");
		}
		//$this->db->where("is_booked",'0');
		//$this->db->where("l.status_id !=",'5');
		//$this->db->where("l.status_id !=",'6');
		$this->db->order_by('l.lead_id','desc');
		return $this->db->get();
	}

	function get_appointmenttimes($result,$leadid){
		$empid = $result->consultant;
		$appointment_date = $result->booking_date;
		$day = date('N', strtotime($appointment_date));

		$this->db->where("booking_date",date("Y-m-d",strtotime($appointment_date)));
		$this->db->where("consultant",$empid);
		$this->db->where("lead_id !=",$leadid);
		$leads = $this->db->get("leads")->result_array();
		$lead_times = array_column($leads,"booking_time");
	
		foreach($lead_times as $key => $time){
			$lead_times[$key] = date('H:i',strtotime($time));
		}

		$options = '';
	
		$service_time = $this->db->where("employee_id",$empid)->where("service_day",$day)->get("pnp_service_time_available")->row();
		
		if(!empty($service_time)){
			if($service_time->service_start_time != '00:00:00' || $service_time->service_end_time != '00:00:00'){
			   
				$start_time = $service_time->service_start_time;
				while(strtotime($start_time) < strtotime($service_time->service_end_time) )
					{
						$time_interval = date("H:i",strtotime($start_time));
						if(strtotime('-30 minutes', strtotime($service_time->service_end_time)) >= strtotime($time_interval) && !in_array($time_interval, $lead_times)){
							$selected = $time_interval == date('H:i',strtotime($result->booking_time)) ? 'selected' : '';
							$options .='<option value="'.$time_interval.'" '.$selected.'>'.$time_interval.'</option>';
						}
						$start_time = date("H:i",strtotime('+30 minutes', strtotime($time_interval)));
				 
					}
				  }
			}
		
		return $options;
	}

	function fullowup($date){
		$this->db->select('*,l.added_by handle,l.email email, l.status');
		$this->db->from($this->table." l");
		//$this->db->join("weightage w","w.weightage_id=l.weightage_id");
		//$this->db->join("lead_status ls","ls.status_id=l.status_id");
		//$this->db->join("users u","u.userid=l.user_id","left");
		
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7  && $this->session->userdata("clms_front_companyid") != 0){
			$this->db->where("l.added_by",$this->session->userdata("clms_front_userid"));
			$this->db->or_where("l.user_id",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_front_companyid"));

		//$this->db->where("is_booked",'0');
		
	/*	if($date == 'today'){
			$this->db->where("booking_date",date("Y-m-d"));
		}elseif($date == 'tomorrow'){
			$this->db->where("booking_date",date("Y-m-d", strtotime("+1 day")));
		}elseif($date == 'exceeded'){
			$this->db->where("booking_date < ",date("Y-m-d"));
		}
		*/

		if($date == "today")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`+64800), '%Y-%m-%d') = CURDATE()");
		elseif($date == "tomorrow")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`+64800), '%Y-%m-%d') = DATE_FORMAT(CURDATE()+1, '%Y-%m-%d')");
		elseif($date == 'exceeded')
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`+64800), '%Y-%m-%d') < CURDATE()");
		
		$this->db->where("l.status_id !=",'5');
		$this->db->where("l.status_id !=",'6');
		$this->db->order_by('l.lead_id','desc');
		return $this->db->get();
		
	}

	function appointment($date,$student_id=null){
		$this->db->select('*,l.added_by handle,l.email email, l.status');
		$this->db->from($this->table." l");
		//$this->db->join("weightage w","w.weightage_id=l.weightage_id");
		//$this->db->join("lead_status ls","ls.status_id=l.status_id");
		//$this->db->join("users u","u.userid=l.user_id","left");
		
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7  && $this->session->userdata("clms_front_companyid") != 0){
			$this->db->where("l.added_by",$this->session->userdata("clms_front_userid"));
			$this->db->or_where("l.user_id",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_front_companyid"));

		$this->db->where("l.status_id",'5');
		
		if($date == 'today'){
			$this->db->where("booking_date",date("Y-m-d"));
		}elseif($date == 'tomorrow'){
			$this->db->where("booking_date",date("Y-m-d", strtotime("+1 day")));
		}elseif($date == 'exceeded'){
			$this->db->where("booking_date < ",date("Y-m-d"));
		}

		if($student_id)
			$this->db->where("student_id",$student_id);
		

		$this->db->order_by('l.lead_id','desc');
		return $this->db->get();
		
	}

	function countLeads($lead_date){
		if($lead_date == "today")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d') = CURDATE()");
		elseif($lead_date == "tomorrow")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d') = DATE_SUB(CURDATE(), INTERVAL -1 DAY)");
		elseif($lead_date == "reminder_exceeded")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d') < CURDATE()");
		$this->db->where("status_id not in (20,21,23)");
		return $this->db->get("leads")->num_rows();
	}

	function about_us(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
			$this->db->or_where("company_id",0);
		}
		$this->db->order_by("name","asc");
		return $this->db->get("about_us")->result();
	}

	function get_purpose(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
			$this->db->or_where("company_id",0);
		}
		$this->db->order_by("type_name","asc");
		return $this->db->get("purpose")->result();
	}

	function get_source(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
			$this->db->or_where("company_id",0);
		}
		$this->db->order_by("type_name","asc");
		return $this->db->get("source")->result();
	}

	function get_form(){
		$this->db->where("module_name","Lead");
		$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		return $this->db->get("form");
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function addstatus($data){
		$this->db->insert("lead_update",$data);
	}

	function get_updates($leadid){
		$this->db->select("l.update_id,l.content,l.added_date,u.first_name,u.last_name");
		$this->db->from("lead_update l");
		$this->db->join("users u","u.userid=l.added_by");
		$this->db->where("l.lead_id",$leadid);
		$this->db->order_by("l.update_id","desc");
		return $this->db->get("")->result();
	}

	function getdata($lead_id){
		$this->db->where('lead_id',$lead_id);
		//$this->db->where_in('status', array('0','1'));
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($lead_id, $data){
		$this->db->where('lead_id', $lead_id);
		$this->db->update($this->table, $data);
	}

	function delete($lead_id) {

		$this->db->where('lead_id', $lead_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('lead_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('lead_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('lead_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}

		}
		return;
	}

	function get_languages(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->order_by("language_name","asc");
		return $this->db->get("language")->result();
	}

	function get_chatType(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->order_by("chat_name","asc");
		return $this->db->get("chat")->result();
	}

	function get_WhenStart(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->order_by("start_name","asc");
		return $this->db->get("start")->result();
	}

	function get_category($parent = 0){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("parent_id",$parent);
		$this->db->where("status",1);
		$this->db->order_by("cat_name","asc");
		return $this->db->get("lead_category")->result();
	}

	function get_access(){
		//if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
		//	$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->order_by("access_name","asc");
		return $this->db->get("access")->result();
	}

	function get_users(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->where("user_group",3);
		$this->db->order_by("first_name","asc");
		return $this->db->get("company_users")->result();
	}

	function get_leadweightage(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	{
			$userid = $this->session->userdata("clms_front_companyid");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		$this->db->order_by("name","asc");
		return $this->db->get("weightage")->result();
	}

	function get_leadstatus(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
			$this->db->or_where("company_id",0);
		}
		$this->db->where("status",1);
		$this->db->order_by('status_name','asc');
		return $this->db->get("lead_status")->result();
	}

	function addLmsfiles($data){
		$this->db->insert("lead_documents",$data);
	}

	function get_documents($lead_id){
		$this->db->where("lead_id",$lead_id);
		$query = $this->db->get("lead_documents");
		return $query->result();
	}

	function getusers($userid){
		$this->db->where("userid",$userid);
		return $this->db->get("users")->row();
	}

	function get_country(){
		$this->db->order_by("country_name","asc");
		$query = $this->db->get("countries");
		return $query->result();
	}

	function getleadusers($lead_id){
		$this->db->where("lead_id",$lead_id);
		$this->db->where("added_by !=",$this->session->userdata("clms_front_userid"));
		return $this->db->get("lead_update")->result();
	}

	function get_userdetails($userid){
		$this->db->where("id",$userid);
		return $this->db->get("company_users")->row();
	}

	function get_leadTypes(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
			$this->db->or_where("company_id",0);
		}	
		
		$this->db->where("status",1);
		return $this->db->get("lead_type")->result();
	}
}