<?php
class installermodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'installer';		

	}

	function listall($limit = null){	
		$this->db->select("u.userid,i.*")->from("users u");
		$this->db->join("installer i","i.user_id=u.userid");
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("i.company_id",$this->session->userdata("clms_company"));		
		$this->db->order_by('threatre_id','asc');
		return $this->db->get();
	}

	function get_user($userid){
		$this->db->where("userid",$userid);
		return $this->db->get("users")->row();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($status_id){
		$this->db->where('threatre_id',$status_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function get_service_day(){
		return $this->db->get("service_day")->result();
	}

	function get_service_time($userid,$dayid){
		$this->db->where("installer_id",$userid);
		$this->db->where("service_day",$dayid);
		$query = $this->db->get("service_time_available");
		return $query->row();
	}

	function update($status_id, $data){
		$this->db->where('threatre_id', $status_id);
		$this->db->update($this->table, $data);
	}

	function delete($status_id) {
		$this->db->where('threatre_id', $status_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('threatre_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('threatre_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('threatre_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}