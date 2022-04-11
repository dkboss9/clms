<?php
class social_mediaModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'social_media';		

	}

	function listall($limit = null){		
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->order_by('id','desc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($start_id){
		$this->db->where('id',$start_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function get_documents($id){
		$this->db->where("social_id",$id);
		$query = $this->db->get("socail_files");
		return $query->result();
	}


	function update($start_id, $data){
		$this->db->where('id', $start_id);
		$this->db->update($this->table, $data);
	}

	function delete($start_id) {
		$this->db->where('id', $start_id);
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