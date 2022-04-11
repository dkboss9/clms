<?php
class mailchimpmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'mailchimp';		

	}

	

	function getdata($start_id){
		$this->db->where('company_id',$start_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	
	
}