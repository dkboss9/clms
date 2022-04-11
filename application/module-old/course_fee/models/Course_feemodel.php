<?php
class course_feemodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'course_fee';		

	}

	function listall($limit = null){	
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		$company_user_id = $this->commonmodel->getcompany_userid_new();
		$front_user_id = $this->session->userdata("clms_front_userid");
		$front_company_id = $this->session->userdata("clms_front_companyid");

		$this->db->select("cf.fee_id,cf.currency,c.type_name as college,d.type_name as degree,cu.type_name as course,cf.price,cf.period,cf.status")->from("course_fee cf");
		$this->db->join("college c",'c.type_id=cf.college');	
		$this->db->join("degree d",'d.type_id=cf.degree');
		$this->db->join("course cu",'cu.type_id=cf.course');
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("cf.company_id",$this->session->userdata("clms_front_companyid"));

		if($all_data == 0)
			$this->db->where("cf.added_by",$front_user_id);

		$this->db->order_by('cf.fee_id','desc');
		return $this->db->get("");
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($type_id){
		$this->db->where('fee_id',$type_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	

	function update($type_id, $data){
		$this->db->where('fee_id', $type_id);
		$this->db->update($this->table, $data);
	}

	function delete($type_id) {
		$this->db->where('fee_id', $type_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('fee_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('fee_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('fee_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function getcolleges($country){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->where("country_id",$country);
		return $this->db->get("college")->result();
	}

	function getDegree($college=''){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	{
			$userid = $this->session->userdata("clms_front_companyid");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		if($college != "")
			$this->db->where("college_id",$college);
		$this->db->where("status",1);
		return $this->db->get("degree")->result();
	}

	function getCourse($degree){
		$this->db->where("degree_id",$degree);
		$this->db->where("status",1);
		return $this->db->get("course")->result();
	}

	function checkChecklist($checkid,$fee_id,$type='offer-letter'){
		$this->db->where("fee_id",$fee_id);
		$this->db->where("checklist_id",$checkid);
		$this->db->where("checklist_type",$type);
		return $this->db->get("course_fee_checklist")->num_rows();
	}

	function checkFormlist($checkid,$fee_id){
		$this->db->where("fee_id",$fee_id);
		$this->db->where("form_id",$checkid);
		return $this->db->get("course_fee_form")->num_rows();
	}

	function get_currency(){
		return $this->db->get("currency")->result();
	}

}