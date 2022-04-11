<?php
class Customermodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'customers';		

	}

	function listall($limit = null){		
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));	
		$this->db->order_by('customer_id','desc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($customer_id){
		$this->db->where('customer_id',$customer_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function get_account_detail($country){
		$this->db->where("country_id",$country);
		return $this->db->get("account_setting")->row();
	}

	function update($customer_id, $data){
		$this->db->where('customer_id', $customer_id);
		$this->db->update($this->table, $data);
	}

	function delete($customer_id) {
		$this->db->where('customer_id', $customer_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('customer_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('customer_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('customer_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function check_duplicateEmail($email,$company_id){
		$this->db->where("email",$email);
		$this->db->where("company_id",$company_id);
		return $this->db->get($this->table)->num_rows();
	}

	function getcoutries(){
		return $this->db->get("countries")->result();
	}

	function getstates(){
		return $this->db->get("states")->result();
	}
}