<?php
class sms_packagemodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'sms_package';		

	}

	function listall($limit = null){		
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));		
		$this->db->order_by('id','asc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($status_id){
		$this->db->where('id',$status_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($status_id, $data){
		$this->db->where('id', $status_id);
		$this->db->update($this->table, $data);
	}

	function delete($status_id) {
		$this->db->where('id', $status_id);
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

	function getdesclist($id){
		$this->db->where("id",$id);
		return $this->db->get("sms_package_desc")->result();
	}


	function updatesms_package_perm($permissions, $user_id, $login_id){
		$this->db->trans_start();
		$permission_set = '';
		if(count($permissions)>0){
			$permission_set = implode(",", $permissions);				
		}
		$parameters = array($permission_set, $user_id, $login_id);
		$qry_res = $this->db->query('CALL sp_Insertsms_packagePermission(?,?,?)', $parameters);
		$this->db->trans_complete();			
	}

	function checksms_package_permision($module_id, $user_action_id, $group_id){
		$query = "SELECT 
		fn_Checksms_packagePermission(". $module_id .",". $user_action_id .",". $group_id .")
		AS permission
		";
		$result = $this->db->query($query);
		$permission = $result->row();
		return $permission->permission;
	}


}