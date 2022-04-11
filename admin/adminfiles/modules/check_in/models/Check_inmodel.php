<?php
class check_inmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'employee_daily_activity';		

	}

	function listall($limit = null){	
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));			
		$this->db->order_by('id','asc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function get_users(){
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_company"),$this->session->userdata("usergroup"))->num_rows();
		$company_user_id = $this->session->userdata("company_user_id");
		$userid = $this->commonmodel->get_login_id();
		$company_id = $this->session->userdata("clms_company");
		$group_id = $this->session->userdata("usergroup");

		$this->db->select("*")->from("company_users u");
		$this->db->join("group g","g.groupid=u.user_group");
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("u.company_id",$this->session->userdata("clms_company"));

		if($all_data == 0){
			$this->db->where("(u.added_by = $userid OR u.id = $company_user_id)");
		}
		$this->db->where("u.status",1);
		$this->db->where("user_group",9);
		$this->db->order_by("u.first_name","asc");
		return $this->db->get()->result();
	}

	function update($status_id, $data){
		$this->db->where('id', $status_id);
		$this->db->update($this->table, $data);
	}

	function delete($status_id) {
		$this->db->where('visit_id', $status_id);
		$this->db->delete($this->table);
	}

	function get_allAttendences($data){
		$this->db->select("e.*,u.first_name,u.last_name")->from("employee_daily_activity e");
		$this->db->join("company_users u","u.id=e.user_id");
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("e.company_id",$this->session->userdata("clms_company"));

		if(isset($data['company_id']) && $data['company_id'] != '')
			$this->db->where("e.company_id",$data['company_id']);

		if(isset($data['staff']) && $data['staff'] != '')
			$this->db->where("e.user_id", $data['staff']);

			if($data['period'] == 1){
				if($data['activity_from_date'] != ""){
					$date = date("Y-m-d",strtotime($data['activity_from_date']));
					$this->db->where("register_date >= ",$date);
				}

				if($data['activity_to_date'] != ""){
					$date = date("Y-m-d",strtotime($data['activity_to_date']));
					$this->db->where("register_date <= ",$date);
				}
			
			}else{
				if($this->input->get("date") && $this->input->get("date") == "today")
					$this->db->where("register_date",date("Y-m-d"));
				elseif($this->input->get("date") && $this->input->get("date") == 'week'){
					$this->db->where("WEEKOFYEAR(register_date)=WEEKOFYEAR(NOW()) AND YEAR(register_date)=YEAR(NOW())");
				}elseif($this->input->get("date") && $this->input->get("date") == 'month'){
					$start_date = date("Y-n-j", strtotime("first day of previous month"));
				 	$end_date = date("Y-n-j", strtotime("last day of previous month"));
					$this->db->where("DATE(register_date) >= ",$start_date);
					$this->db->where("DATE(register_date) <= ",$end_date);
					// $this->db->where("MONTH(checkin_at)=MONTH(NOW())  AND YEAR(checkin_at)=YEAR(NOW())");
				}
			}

		return $this->db->get()->result();
		// $this->db->where("");
	}

	function has_checkin(){
		$date = date("Y-m-d");
		$userid = $this->session->userdata("clms_userid");

		$this->db->where("DATE(checkin_at)",$date);
		$this->db->where("user_id",$userid);
		return $this->db->get("employee_daily_activity")->num_rows();
	}

	function get_service_time($day,$installerid){
		$this->db->where("employee_id",$installerid);
		$this->db->where("service_day",$day);
		return $this->db->get("service_time_available");
		
	}

}