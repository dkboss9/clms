<?php
class AccessModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'access';		

	}

	function listall($limit = null){			
		//if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			//$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->order_by('access_name','asc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($access_id){
		$this->db->where('access_id',$access_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($access_id, $data){
		$this->db->where('access_id', $access_id);
		$this->db->update($this->table, $data);
	}

	function delete($access_id) {
		$this->db->where('access_id', $access_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('access_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('access_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('access_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}