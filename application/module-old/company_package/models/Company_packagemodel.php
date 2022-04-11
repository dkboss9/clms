<?php
class company_packageModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'company_package';		

	}

	function listall($limit = null){			
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		$company_user_id = $this->commonmodel->getcompany_userid_new();
		$front_user_id = $this->session->userdata("clms_front_userid");
		$front_company_id = $this->session->userdata("clms_front_companyid");

		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$this->db->where("(company_id = $front_company_id OR company_id = 0)");
		}	

		if($all_data == 0)
		$this->db->where("added_by",$front_user_id);

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
		return $this->db->get("company_package_type_data")->num_rows();
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