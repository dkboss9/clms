<?php
class budget_typemodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'budget_type';		

	}

	function listall($parent_id = 0){		
		$this->db->where("parent_id",$parent_id);
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->order_by('type_name','asc');
		return $this->db->get($this->table);
	}

	function getcategory(){
		$sql = "select *,(select type_name from pnp_budget_type l where lc.parent_id = l.type_id) parent from pnp_budget_type as lc ";
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")
			$sql.=" where company_id = ".$this->session->userdata("clms_company"); 

		return $this->db->query($sql);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($cat_id){
		$this->db->where('type_id',$cat_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($cat_id, $data){
		$this->db->where('type_id', $cat_id);
		$this->db->update($this->table, $data);
	}

	function delete($cat_id) {
		$this->db->where('type_id', $cat_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('type_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('type_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('type_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}