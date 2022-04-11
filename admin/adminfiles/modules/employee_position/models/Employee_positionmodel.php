<?php
class employee_positionmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'employee_position';		

	}

	function listall($limit = null){		
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$this->db->where("company_id",$this->session->userdata("clms_company"));	
			$this->db->or_where("company_id",0);
		}
		$this->db->order_by('position_id','desc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($position_id){
		$this->db->where('position_id',$position_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($position_id, $data){
		$this->db->where('position_id', $position_id);
		$this->db->update($this->table, $data);
	}

	function delete($position_id) {
		$this->db->where('position_id', $position_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('position_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('position_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('position_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}