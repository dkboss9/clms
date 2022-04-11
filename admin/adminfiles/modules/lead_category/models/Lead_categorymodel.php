<?php
class lead_categorymodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'lead_category';		

	}

	function listall($parent_id = 0){		
		$this->db->where("parent_id",$parent_id);
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->order_by('cat_name','asc');
		return $this->db->get($this->table);
	}

	function getcategory(){
		$sql = "select *,(select cat_name from pnp_lead_category l where lc.parent_id = l.cat_id) parent from pnp_lead_category as lc ";
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")
			$sql.=" where company_id = ".$this->session->userdata("clms_company"); 

		return $this->db->query($sql);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($cat_id){
		$this->db->where('cat_id',$cat_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($cat_id, $data){
		$this->db->where('cat_id', $cat_id);
		$this->db->update($this->table, $data);
	}

	function delete($cat_id) {
		$this->db->where('cat_id', $cat_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('cat_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('cat_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('cat_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}