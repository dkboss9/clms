<?php
class EventsModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'events';		

	}

	function listall($limit = null){			
		$this->db->select("*");
		$this->db->from($this->table." e");
		$this->db->join("users u","u.userid = e.added_by");
		$this->db->join("event_status es","es.status_id = e.event_status");
		if($this->session->userdata["usergroup"] != 1 && $this->session->userdata["usergroup"] != 7  && $this->session->userdata["company_id"] != 0)
			$this->db->where("e.added_by",$this->session->userdata("clms_userid"));
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("e.company_id",$this->session->userdata("clms_company"));
		$this->db->order_by('e.event_id','desc');
		return $this->db->get();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($start_id){
		$this->db->where('start_id',$start_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($event_id, $data){
		$this->db->where('event_id', $event_id);
		$this->db->update($this->table, $data);
	}

	function delete($start_id) {
		$this->db->where('start_id', $start_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('start_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('start_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('start_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function liststatus(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$this->db->where("company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("company_id",0);
		}
		$this->db->where("status",1);
		return $this->db->get("event_status")->result();
	}
}