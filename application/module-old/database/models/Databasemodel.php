<?php
class DatabaseModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'database';		

	}

	function listall($category="",$sub_category="",$sub_category2="",$sub_category3="",$businesscategory="",$sub_businesscategory="",$sub_businesscategory2="",$sub_businesscategory3=""){	
		$this->db->select("d.*,u.first_name,u.last_name,u.status");
		$this->db->from($this->table." d");
		$this->db->join("users u","d.added_by = u.userid");
		if($category !="")	
			$this->db->where("d.category",$category);	
		if($sub_category !="")	
			$this->db->where("d.subcategory",$sub_category);	
		if($sub_category2 !="")	
			$this->db->where("d.subcategory2",$sub_category2);	
		if($sub_category3 !="")	
			$this->db->where("d.subcategory3",$sub_category3);	

		if($businesscategory !="")	
			$this->db->where("d.businesscategory",$businesscategory);	
		if($sub_businesscategory !="")	
			$this->db->where("d.businesssubcategory",$sub_businesscategory);	
		if($sub_businesscategory2 !="")	
			$this->db->where("d.businesssubcategory2",$sub_businesscategory2);	
		if($sub_businesscategory3 !="")	
			$this->db->where("d.businesssubcategory3",$sub_businesscategory3);	
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("d.company_id",$this->session->userdata("clms_front_companyid"));

		$this->db->order_by('d.db_id','desc');
		return $this->db->get();
	}

	function cheackAccess($userid,$dbid){
		$this->db->where("user_id",$userid);
		$this->db->where("db_id",$dbid);
		return $this->db->get("database_access")->num_rows();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($db_id){
		$this->db->where('db_id',$db_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function get_category($parent = 0){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("parent_id",$parent);
		$this->db->where("status",1);
		$this->db->order_by("cat_name","asc");
		return $this->db->get("lead_category")->result();
	}

	function get_businesscategory($parent = 0){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("parent_id",$parent);
		$this->db->where("status",1);
		$this->db->order_by("cat_name","asc");
		return $this->db->get("business_category")->result();
	}


	function getuser($userid){
		$this->db->where('userid',$userid);
		return $this->db->get('users');
	}
	function listuser(){
		$this->db->select('u.status, user_name, group_name,user_group, first_name,last_name,email,phone,userid');
		$this->db->from('users u');
		$this->db->join('group g','g.groupid=u.user_group');
		$this->db->where('groupid !=',7);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("u.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->order_by('first_name','asc');
		return $this->db->get();
	}
	function get_note($db_id){
		$this->db->where("db_id",$db_id);
		return $this->db->get("database_note")->result();
	}

	function update($db_id, $data){
		$this->db->where('db_id', $db_id);
		$this->db->update($this->table, $data);
	}

	function delete($db_id) {
		$this->db->where('db_id', $db_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('db_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('db_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('db_id',$ids);
				$this->db->update($this->table, $data);
			}else if($action=="call"){
				$data["is_called"]='1';
				$this->db->where_in('db_id',$ids);
				$this->db->update($this->table, $data);
			}else if($action=="notcall"){
				$data["is_called"]='0';
				$this->db->where_in('db_id',$ids);
				$this->db->update($this->table, $data);
			}else {
				return;
			}
			
		}
		return;
	}
}