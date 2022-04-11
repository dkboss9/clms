<?php
class collegemodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'college';		

	}

	function listall($limit = null){	
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		$company_user_id = $this->commonmodel->getcompany_userid_new();
		$front_user_id = $this->session->userdata("clms_front_userid");
		$front_company_id = $this->session->userdata("clms_front_companyid");

		$this->db->select("*,c.status")->from("college c");
		$this->db->join("countries co","co.country_id=c.country_id");	
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("c.company_id",$this->session->userdata("clms_front_companyid"));

		if($all_data == 0)
			$this->db->where("c.added_by",$front_user_id);
		
		$this->db->order_by('c.type_id','desc');
		return $this->db->get("");
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($type_id){
		$this->db->where('type_id',$type_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	

	function update($type_id, $data){
		$this->db->where('type_id', $type_id);
		$this->db->update($this->table, $data);
	}

	function delete($type_id) {
		$this->db->where('type_id', $type_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('type_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('type_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('type_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function getcity($country=null){
		$this->db->where("country_id",$country);
		return $this->db->get("states")->result();
	}

	function getcollegelevel(){
		$this->db->where("company_id",0);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
		   $this->db->or_where("company_id",$this->session->userdata("clms_front_companyid"));
		return $this->db->get("pnp_college_level")->result();
	}


}