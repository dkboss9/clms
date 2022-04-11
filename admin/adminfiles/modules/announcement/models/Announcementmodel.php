<?php
class AnnouncementModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'announcement';		

	}

	function listall($limit = null){		
		if($this->session->userdata["usergroup"] != 1 && $this->session->userdata["usergroup"] != 7  && $this->session->userdata["company_id"] != 0){
			$this->db->where("added_by",$this->session->userdata("clms_userid"));
		}	
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->order_by('announcement_id','desc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($start_id){
		$this->db->where('announcement_id',$start_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($start_id, $data){
		$this->db->where('announcement_id', $start_id);
		$this->db->update($this->table, $data);
	}

	function delete($start_id) {
		$this->db->where('announcement_id', $start_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('announcement_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('announcement_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('announcement_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}