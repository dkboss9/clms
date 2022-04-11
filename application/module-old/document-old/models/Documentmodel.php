<?php
class documentmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'document';		

	}

	function listall($parent_id = 0){		
		$this->db->where("parent_id",$parent_id);
		$this->db->order_by('cat_name','asc');
		return $this->db->get($this->table);
	}

	function getdocument(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		}	
		
		$this->db->where("status",'1');
		return $this->db->get("document");
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($content_id){
		$this->db->where('content_id',$content_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($content_id, $data){
		$this->db->where('content_id', $content_id);
		$this->db->update($this->table, $data);
	}

	function delete($content_id) {
		$this->db->where('content_id', $content_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('content_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('content_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('content_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function getCounpons(){
		$this->db->where('status',1);
		return $this->db->get("coupons")->result();
	}

	function getLocations(){
		$this->db->where('status',1);
		return $this->db->get("locations")->result();
	}

	function getAge(){
		$this->db->where('status',1);
		return $this->db->get("age")->result();
	}

	function getHead(){
		$this->db->where('status',1);
		return $this->db->get("head")->result();
	}

	function getBody(){
		$this->db->where('status',1);
		return $this->db->get("body")->result();
	}

	function getFoot(){
		$this->db->where('status',1);
		return $this->db->get("foot")->result();
	}

	function get_category($parent = 0){
		$this->db->where("parent_id",$parent);
		$this->db->where("status",1);
		$this->db->order_by("cat_name","asc");
		return $this->db->get("category")->result();
	}
}