<?php
class departmentModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'department';		

	}

	function listall($limit = null){	
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		$company_user_id = $this->commonmodel->getcompany_userid_new();
		$front_user_id = $this->session->userdata("clms_front_userid");
		$front_company_id = $this->session->userdata("clms_front_companyid");
		
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));

		if($all_data == 0){
			$this->db->where("(added_by = $front_user_id)");
		}
		
		$this->db->order_by('name','asc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($id){
		$this->db->where('id',$id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function checkgroup_permision($module_id, $user_action_id, $department_id){
		$this->db->where("department_id",$department_id);
		$this->db->where("user_action_id",$user_action_id);
		$this->db->where("module_id",$module_id);
		$result = $this->db->get('pnp_permissions_per_department');
		if($result->num_rows() > 0)
			return true;
		else
			return false;
	}

	function updatedepartment_permision($chk_permission, $department_id, $login_id){
		$this->db->where("department_id",$department_id);
		$this->db->delete("pnp_permissions_per_department");

		foreach($chk_permission as $key=>$value){
			$module_data = explode('_',$value);
			$data = [
				"department_id" => $department_id,
				"user_action_id" => $module_data[1],
				"module_id" => $module_data[0],
				"added_by" => $login_id
			];
			$this->db->insert("pnp_permissions_per_department",$data);
		}
	}

	function update($id, $data){
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}

	function delete($id) {
		$this->db->where('id', $id);
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