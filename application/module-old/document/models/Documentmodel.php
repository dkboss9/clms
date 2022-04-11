<?php
class documentmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'document';		

	}

	function listall($parent_id = 0){		
		$this->db->where("parent_id",$parent_id);
		$this->db->order_by('cat_name','asc');
		return $this->db->get($this->table);
	}

	function getCatgory(){
		$this->db->order_by("title");
		$this->db->where("status",1);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company_id = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company_id or company_id = 0)");
		}	
		return $this->db->get("document_category")->result();
	}

	function getdocument(){

		$this->db->select("d.*")->from("document d");
		$this->db->join("document_category dc","dc.id=d.cat_id","left");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$this->db->where("d.company_id",$this->session->userdata("clms_front_companyid"));	
		}	

		$this->db->where("d.status",'1');
		return $this->db->get();
	}

	function all_document(){

		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		$company_user_id = $this->commonmodel->getcompany_userid_new();
		$front_user_id = $this->session->userdata("clms_front_userid");
		$front_company_id = $this->session->userdata("clms_front_companyid");

		$this->db->select("d.*,dc.title as category,dc.type")->from("document d");
		$this->db->join("document_category dc","dc.id = d.cat_id");

		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$this->db->where("d.company_id",$this->session->userdata("clms_front_companyid"));	
		}	

		
		if($all_data == 0)
			$this->db->where("d.added_by",$front_user_id);
		
		return $this->db->get();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($content_id){
		$this->db->where('content_id',$content_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($content_id, $data){
		$this->db->where('content_id', $content_id);
		$this->db->update($this->table, $data);
	}

	function delete($content_id) {
		$this->db->where('content_id', $content_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('content_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('content_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('content_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function getCounpons(){
		$this->db->where('status',1);
		return $this->db->get("coupons")->result();
	}

	function getLocations(){
		$this->db->where('status',1);
		return $this->db->get("locations")->result();
	}

	function getAge(){
		$this->db->where('status',1);
		return $this->db->get("age")->result();
	}

	function getHead(){
		$this->db->where('status',1);
		return $this->db->get("head")->result();
	}

	function getBody(){
		$this->db->where('status',1);
		return $this->db->get("body")->result();
	}

	function getFoot(){
		$this->db->where('status',1);
		return $this->db->get("foot")->result();
	}

	function get_category($parent = 0){
		$this->db->where("parent_id",$parent);
		$this->db->where("status",1);
		$this->db->order_by("cat_name","asc");
		return $this->db->get("category")->result();
	}
}