<?php
class degreemodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'degree';		

	}

	function listall($limit = null){		
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		$company_user_id = $this->commonmodel->getcompany_userid_new();
		$front_user_id = $this->session->userdata("clms_front_userid");
		$front_company_id = $this->session->userdata("clms_front_companyid");

		$this->db->select("d.*,con.country_name,c.type_name as college");
		$this->db->from("degree d");
		$this->db->join("countries con","con.country_id=d.country_id");
		$this->db->join("college c","c.type_id = d.college_id");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	{
			$userid = $this->session->userdata("clms_front_companyid");
			$this->db->where("((d.company_id = $userid) OR (d.company_id = 0))");
		}

		if($all_data == 0)
			$this->db->where("d.added_by",$front_user_id);

		$this->db->order_by('type_id','desc');
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
}