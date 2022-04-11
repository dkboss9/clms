<?php
class Company_EmailModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = "company_email_template";
	}

		//list all news
	function listall($limit = null){
		$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->order_by('email_id','desc');
		(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):'';
		return $this->db->get('company_email_template');
	}

		//insert new record
	function insert($data){
		$this->db->insert($this->table,$data);
	}

		//update news details
	function update($email_id,$data){
		$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where('email_id',$email_id);
		$this->db->update($this->table,$data);
	}

		//load news details
	function loaddata($email_id){
		$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where('email_id',$email_id);
		return $this->db->get($this->table);
	}	
		//delete news details
	function delete($newsid){
		$this->db->where('email_id',$email_id);
		$this->db->delete($this->table);
	}
	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$data["news_status"]='2';
			} else if($action=="publish"){
				$data["news_status"]='1';
			} else if($action=="unpublish"){
				$data["news_status"]='0';
			} else {
				return;
			}
			$this->db->where_in('employee_id',$ids);
			$this->db->update($this->table, $data);
		}
		return;
	} 		
}
?>
