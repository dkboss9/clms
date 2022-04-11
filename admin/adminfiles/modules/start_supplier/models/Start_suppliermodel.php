<?php
class start_suppliermodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'start_supplier';		

	}

	function listall($limit = null){		

		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_company"),$this->session->userdata("usergroup"))->num_rows();
		$company_user_id = $this->session->userdata("company_user_id");
		$userid = $this->commonmodel->get_login_id();
		$company_id = $this->session->userdata("clms_company");
		$group_id = $this->session->userdata("usergroup");
		
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$this->db->where("((company_id = $company_id) OR (company_id = 0))");
		}
		if($all_data == 0){
			$this->db->where("(added_by = $company_id OR created_by = $company_user_id)");
		}
		$this->db->order_by('id','desc');
		return $this->db->get("start_supplier");
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($type_id){
		$this->db->where('id',$type_id);
		$query=$this->db->get($this->table);
		return $query;

	}


	function save_date($date){
		$date1 = explode("/", $date);
		$start_date = $date1[2].'-'.$date1[1].'-'.$date1[0];
		return $start_date;
	}
	
	

	function update($type_id, $data){
		$this->db->where('id', $type_id);
		$this->db->update($this->table, $data);
	}

	function delete($type_id) {
		$this->db->where('id', $type_id);
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