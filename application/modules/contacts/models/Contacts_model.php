<?php
class Contacts_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'contacts';		

	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('id',$ids);
				$this->db->delete("contacts");
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

	function listall($limit = null,$status=null){	
		 $all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		 $company_user_id = $this->commonmodel->getcompany_userid_new();
		 $front_user_id = $this->session->userdata("clms_front_userid");
		 $front_company_id = $this->session->userdata("clms_front_companyid");

		$this->db->select("c.*,u.first_name,u.last_name,camp.name as campaign")->from($this->table. ' c');
		$this->db->join("campaign camp","camp.id=c.campaign_id");
		$this->db->join("company_users u","u.id=c.staff_id");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$this->db->where("(c.company_id = $front_company_id OR c.company_id = 0)");
		}	

		if($all_data == 0){
			$this->db->where("(c.added_by = $front_user_id OR c.staff_id = $company_user_id)");
		}

		if($status)
		$this->db->where('c.status',$status);
		$this->db->order_by('id','desc');
		return $this->db->get();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($type_id){
		$this->db->where('id',$type_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($type_id, $data){
		$this->db->where('id', $type_id);
		$this->db->update($this->table, $data);
	}

	function delete($type_id) {
		$this->db->where('id', $type_id);
		$this->db->delete($this->table);
	}

	
}