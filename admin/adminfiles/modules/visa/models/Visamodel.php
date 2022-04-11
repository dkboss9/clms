<?php
class visamodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'visa';		

	}

	function listall($type_id=null){		
		
		$this->db->select("v.*,vc.type_name  category")->from("visa v");
		$this->db->join("visa vc","v.cat_id=vc.type_id","left");
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){
			$this->db->where("v.company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("v.company_id",0);
		}	
		$this->db->order_by('type_name','asc');
		return $this->db->get();
	}

	function getcategory(){
		$this->db->select("*")->from("visa v");
		$this->db->where("cat_id",NULL);
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){
			$this->db->where("company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("company_id",0);
		}	
		$this->db->order_by('type_name','asc');
		return $this->db->get();
	}

	
	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($type_id){
		$this->db->where('type_id',$type_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function visaPoints($visaid,$company_id){
		$this->db->where("visa_id",$visaid);
		$this->db->where("company_id",$company_id);
		return $this->db->get("pnp_visa_points");
	}

	
	

	function update($type_id, $data){
		$this->db->where('type_id', $type_id);
		$this->db->update($this->table, $data);
	}

	function delete($type_id) {
		$this->db->where('type_id', $type_id);
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

	function getsubcategory($visa_id){
		$this->db->where("cat_id",$visa_id);
		return $this->db->get("visa")->result();
	}
}