<?php
class NewsletterModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'newsletter';
		
	}
	
	function listall($limit = null){
		$this->db->select('*');
		$this->db->from($this->table);
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->order_by('newsletter_date','desc');
		$this->db->where_in('status',array('0','1'));
		(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
		return $this->db->get();
	}
	
	function add($data){
		$this->db->insert($this->table, $data);
	}
	
	function getdata($newsletter_id){
		$this->db->where('newsletter_id',$newsletter_id);
		$this->db->where_in('status', array('0','1'));
		$query=$this->db->get($this->table);
		return $query;
		
	}
	
	function update($newsletter_id, $data){
		$this->db->where('newsletter_id', $newsletter_id);
		$this->db->update($this->table, $data);
	}
	
	function delete($newsletter_id) {
		$data = array('status'=>'2');
		$this->db->where('newsletter_id', $newsletter_id);
		$this->db->update($this->table, $data);
	}
	
	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$data["status"]='2';
			} else if($action=="publish"){
				$data["status"]='1';
			} else if($action=="unpublish"){
				$data["status"]='0';
			} else {
				return;
			}
			$this->db->where_in('newsletter_id',$ids);
			$this->db->update($this->table, $data);
		}
		return;
	}
}