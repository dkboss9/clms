<?php
class PositionModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'position';		

	}

	function listall($limit = null){			
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){
			$company_id = $this->session->userdata("clms_company");
			$this->db->where("(company_id = $company_id or company_id = 0)");
		}	
		$this->db->where("status",1);
		$this->db->order_by('position_title','asc');
		return $this->db->get($this->table);
	}

	function all_position($limit = null){			
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){
			$company_id = $this->session->userdata("clms_company");
			$this->db->where("(company_id = $company_id or company_id = 0)");
		}	
		$this->db->order_by('position_title','asc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($id){
		$this->db->where('id',$id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($id, $data){
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}

	function delete($id) {
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}