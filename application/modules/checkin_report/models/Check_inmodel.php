<?php
class check_inmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'employee_daily_activity';		

	}

	function listall($limit = null){	
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));			
		$this->db->order_by('id','asc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function get_users(){
		$alldata = $this->commonmodel->get_alldata_group_permissions(); 
		$this->db->select("*")->from("users u");
		$this->db->join("group g","g.groupid=u.user_group");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("u.company_id",$this->session->userdata("clms_front_companyid"));

		if($alldata == 0){
			$userid = $this->session->userdata("clms_front_userid");
			$this->db->where("userid",$userid);
		}
		$this->db->where("u.status",1);
		//$this->db->where("user_group",3);
		$this->db->order_by("u.first_name","asc");
		return $this->db->get("")->result();
	}

	function update($status_id, $data){
		$this->db->where('id', $status_id);
		$this->db->update($this->table, $data);
	}

	function delete($status_id) {
		$this->db->where('visit_id', $status_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('visit_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('visit_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('visit_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}