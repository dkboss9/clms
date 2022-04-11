<?php
class referal_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'users';		

	}

	function listall($limit = null){		
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("user_group",9);	
		$this->db->order_by('userid','desc');
		return $this->db->get($this->table);
	}

	function get_referrals(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		$this->db->where("user_group",9);	
		$this->db->order_by('userid','desc');
		return $this->db->get($this->table);
	}

	function referral_permission($id){

		$this->db->where("group_id",9);
		$permissions = $this->db->get("permissions_per_group")->result();

		foreach($permissions as $row){
			$arr = array(
				"module_id" => $row->module_id,
				"user_action_id" => $row->user_action_id,
				"user_id" => $id,
				"added_by" => $id,
				"added_date" => date("Y-m-d"),
				"modified_by" => $id,
				"modified_date" => date("Y-m-d")
			);
			$this->db->insert('permissions_per_user',$arr);
		}
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($start_id){
		$this->db->where('userid',$start_id);
		$query=$this->db->get($this->table);
		return $query;

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
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){
			$company_id = $this->session->userdata("clms_company");
			$this->db->where("(company_id = $company_id or company_id = 0)");
		}	
		$this->db->where("status",1);
		return $this->db->get("lead_type")->result();
	}

	function getRate($userid,$type_id){
		$this->db->where("type_id",$type_id);
		$this->db->where("user_id",$userid);
		return $this->db->get("salesrep_rate")->row();
	}

	function get_referal_price($referal_id,$lead_type_id){
		$this->db->where("user_id",$referal_id);
		$this->db->where("type_id",$lead_type_id);
		return $this->db->get("salesrep_rate")->row();
	}
}