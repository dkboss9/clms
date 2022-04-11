<?php
class PackageModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'package';		
	}

	function listall($limit = null){			
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->order_by('package_name','asc');
		return $this->db->get($this->table);
	}

	function get_packageType(){
		return $this->db->get("package_type")->result();
	}

	function get_paymentTime(){
		return $this->db->get("package_payment_time")->result();
	}

	function get_packageid($packageid, $typeid){
		$this->db->where("package_id",$packageid);
		$this->db->where("type_id",$typeid);
		return $this->db->get("package_type_data")->num_rows();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($package_id){
		$this->db->where('package_id',$package_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($package_id, $data){
		$this->db->where('package_id', $package_id);
		$this->db->update($this->table, $data);
	}

	function delete($package_id) {
		$this->db->where('package_id', $package_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('package_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('package_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('package_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}