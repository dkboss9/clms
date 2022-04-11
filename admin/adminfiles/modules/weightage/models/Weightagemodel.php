<?php
class WeightageModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'weightage';		

	}

	function listall($limit = null){			
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->order_by("weightage_id",'desc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($weightage_id){
		$this->db->where('weightage_id',$weightage_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($weightage_id, $data){
		$this->db->where('weightage_id', $weightage_id);
		$this->db->update($this->table, $data);
	}

	function delete($weightage_id) {
		$this->db->where('weightage_id', $weightage_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('weightage_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('weightage_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('weightage_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}