<?php
class LogModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'logs';		

	}

	function listall($limit = null){			
		$this->db->select("*, l.added_by, l.added_date")->from("logs l");
		$this->db->join("users u","u.userid=l.added_by");
		//if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
		//	$this->db->where("u.company_id",$this->session->userdata("clms_company"));
		$this->db->order_by('l.log_id','desc');
		return $this->db->get("");
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($log_id){
		$this->db->where('log_id',$log_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($log_id, $data){
		$this->db->where('log_id', $log_id);
		$this->db->update($this->table, $data);
	}

	function delete($log_id) {
		$this->db->where('log_id', $log_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('log_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('log_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('log_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}