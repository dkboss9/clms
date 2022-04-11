<?php
class doc_typemodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'doc_type';		

	}

	function listall($visa_type=null){	
		$this->db->select("d.*,v.type_name visa");
		$this->db->from("doc_type d");	
		$this->db->join('visa v',"d.visa_id=v.type_id","left");
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("(d.company_id = $userid or d.company_id =0)");
		}
		if($visa_type)
			$this->db->where("d.visa_id",$visa_type);
		$this->db->order_by('d.type_id','desc');
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
}