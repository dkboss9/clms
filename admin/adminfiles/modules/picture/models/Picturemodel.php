<?php
class PictureModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'picture';		

	}

	function listall($limit = null){			
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->order_by('picture_id','desc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($picture_id){
		$this->db->where('picture_id',$picture_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($picture_id, $data){
		$this->db->where('picture_id', $picture_id);
		$this->db->update($this->table, $data);
	}

	function delete($picture_id) {
		$this->db->where('picture_id', $picture_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('picture_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('picture_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('picture_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}