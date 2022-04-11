<?php
class budgetModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'budget';		

	}

	function listall($reps="",$status="",$priority="",$start="",$end=""){		
		$this->db->select("*,t.status as status,t.added_by as added_by");
		$this->db->from("budget t");	
		$this->db->join("budget_type bt","bt.type_id=t.cat3");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("t.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->order_by('t.budget_id','desc');
		return $this->db->get("");
	}

	function get_items($catid){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("parent_id",$catid);
		return $this->db->get("budget_type")->result();

	}

	function getParentItem($id){
		$this->db->where("type_id",$id);
		return $this->db->get("budget_type")->row();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($budget_id){
		$this->db->select("*");
		$this->db->from($this->table.' t');
		$this->db->where('t.budget_id',$budget_id);
		$query=$this->db->get();
		return $query;

	}

	function getusers($userid){
		//if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			//$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("userid",$userid);
		return $this->db->get("users")->row();
	}

	function update($budget_id, $data){
		$this->db->where('budget_id', $budget_id);
		$this->db->update($this->table, $data);
	}

	function delete($budget_id) {
		$this->db->where('budget_id', $budget_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('budget_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('budget_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('budget_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function get_users(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->where("user_group",3);
		$this->db->order_by("first_name","asc");
		return $this->db->get("users")->result();
	}

	function get_userdetails($userid){
		$this->db->where("userid",$userid);
		return $this->db->get("users")->row();
	}

	function get_budget_status(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		return $this->db->get("budget_status")->result();
	}

	function get_updates($budgetid){
		$this->db->select("l.update_id,l.content,l.added_date,u.first_name,u.last_name");
		$this->db->from("budget_update l");
		$this->db->join("users u","u.userid=l.added_by");
		$this->db->where("l.budget_id",$budgetid);
		$this->db->order_by("l.update_id","desc");
		return $this->db->get("")->result();
	}

	function getbudgetusers($budget_id){
		$this->db->where("budget_id",$budget_id);
		$this->db->where("added_by !=",$this->session->userdata("clms_front_userid"));
		return $this->db->get("budget_update")->result();
	}
}