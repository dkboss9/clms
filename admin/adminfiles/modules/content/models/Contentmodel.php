<?php
class contentmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table ='login_content';
	}

		//list all records
	function listall($limit = null){

		(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):'';
		return $this->db->get($this->table);
	}

			//function to insert  details
	function insertdata($data){
		$this->db->insert($this->table,$data);
	}

		//get record details
	function getdata($cat_id){
		$this->db->where('id',$cat_id);
		return $this->db->get($this->table);
	}

		//function to update details
	function updatedata($data,$cat_id){
		$this->db->where('id',$cat_id);
		$this->db->update($this->table,$data);
	}

		//function to delete record
	function deletedata($cat_id){
		$this->db->where('id',$cat_id);
		$this->db->delete($this->table);

	}

	
}
?>