<?php
class budget_typemodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'budget_type';		

	}

	function listall($parent_id = 0){		
		$this->db->where("parent_id",$parent_id);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->order_by('type_name','asc');
		return $this->db->get($this->table);
	}

	function getcategory(){
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		$company_user_id = $this->commonmodel->getcompany_userid_new();
		$front_user_id = $this->session->userdata("clms_front_userid");
		$front_company_id = $this->session->userdata("clms_front_companyid");

		$sql = "select *,(select type_name from pnp_budget_type l where lc.parent_id = l.type_id) parent from pnp_budget_type as lc ";
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")
			$sql.=" where company_id = ".$this->session->userdata("clms_front_companyid"); 

		if($all_data == 0){
			$sql .=" and lc.added_by = $front_user_id";
		}

		return $this->db->query($sql);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($cat_id){
		$this->db->where('type_id',$cat_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($cat_id, $data){
		$this->db->where('type_id', $cat_id);
		$this->db->update($this->table, $data);
	}

	function delete($cat_id) {
		$this->db->where('type_id', $cat_id);
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
}