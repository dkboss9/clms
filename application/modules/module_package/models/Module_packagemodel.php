<?php
class module_packagemodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'module_package';		

	}

	function listall($limit = null){		
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));		
		$this->db->order_by('package_id','asc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($status_id){
		$this->db->where('package_id',$status_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function getAssignedDashboard($userid,$section_id){
		$this->db->where("section_id",$section_id);
		$this->db->where("package_id",$userid);
		return $this->db->get("dashboard_package")->num_rows();
	}

	function update($status_id, $data){
		$this->db->where('package_id', $status_id);
		$this->db->update($this->table, $data);
	}

	function delete($status_id) {
		$this->db->where('package_id', $status_id);
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

	function getdesclist($package_id){
		$this->db->where("package_id",$package_id);
		return $this->db->get("package_desc")->result();
	}


	function updatepackage_perm($permissions, $user_id, $login_id){
		$this->db->trans_start();
		$permission_set = '';
		if(count($permissions)>0){
			$permission_set = implode(",", $permissions);				
		}
		$parameters = array($permission_set, $user_id, $login_id);
		$qry_res = $this->db->query('CALL sp_InsertPackagePermission(?,?,?)', $parameters);
		$this->db->trans_complete();			
	}

	function checkpackage_permision($module_id, $user_action_id, $group_id){
		$query = "SELECT 
		fn_CheckPackagePermission(". $module_id .",". $user_action_id .",". $group_id .")
		AS permission
		";
		$result = $this->db->query($query);
		$permission = $result->row();
		return $permission->permission;
	}


}