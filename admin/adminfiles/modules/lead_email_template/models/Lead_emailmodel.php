<?php
class Lead_EmailModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = "lead_email_template";
	}

		//list all news
	function listall($limit = null){
		$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->order_by('id','desc');
		(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):'';
		return $this->db->get('lead_email_template');
	}

		//insert new record
	function insert($data){
		$this->db->insert($this->table,$data);
	}

		//update news details
	function update($email_id,$data){
		$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where('id',$email_id);
		$this->db->update($this->table,$data);
	}

		//load news details
	function loaddata($email_id){
		$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where('id',$email_id);
		return $this->db->get($this->table);
	}	
		//delete news details
	function delete($email_id){
		$this->db->where('id',$email_id);
		$this->db->delete($this->table);
	}
	
}
?>
