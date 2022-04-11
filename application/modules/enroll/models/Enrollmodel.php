<?php
class enrollmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'enroll';		

	}

	function listall($limit = null){	
		$this->db->select("s.first_name,s.last_name,e.college, e.course, e.degree, e.enroll_id,e.fee,e.period,e.status,i.type_name as intake, v.type_name as visa")->from("enroll e");
		$this->db->join("intake i",'i.type_id=e.intake');	
		$this->db->join("visa v",'v.type_id=e.visa');
		$this->db->join("users s",'s.userid=e.student_id');
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("e.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->order_by('e.enroll_id','desc');
		return $this->db->get("");
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($type_id){
		$this->db->where('order_id',$type_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function getdataByEnrollId($enrollid){
		$this->db->where('enroll_id',$enrollid);
		$query=$this->db->get($this->table)->row();
		return $query;

	}

	

	function update($type_id, $data){
		$this->db->where('enroll_id', $type_id);
		$this->db->update($this->table, $data);
	}

	function delete($type_id) {
		$this->db->where('enroll_id', $type_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('enroll_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('enroll_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('enroll_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function getcolleges(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company or company_id = 0)");
		}	
		$this->db->where("status",1);
		return $this->db->get("college")->result();
	}

	function getDegree($collegeid=''){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company or company_id = 0)");
		}	
		if($collegeid != '')
			$this->db->where("college_id",$collegeid);
		$this->db->where("status",1);
		return $this->db->get("degree")->result();
	}

	function getCourse($degree){
		$this->db->where("degree_id",$degree);
		$this->db->where("status",1);
		return $this->db->get("course")->result();
	}

	function getStudents(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		return $this->db->get("student")->result();
	}

	function getEnrollAmount($college,$degree,$course){
		$this->db->where("college",$college);
		$this->db->where("degree",$degree);
		$this->db->where("course",$course);
		return $this->db->get("course_fee");
	}

	

	function getVisaType(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company or company_id = 0)");
		}	

		$this->db->where("status",1);
		return $this->db->get("visa")->result();
	}

	function getVisaClass(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company or company_id = 0)");
		}	
		$this->db->where("status",1);
		return $this->db->get("visa_class")->result();
	}

	function getIntakes(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company or company_id = 0)");
		}	
		$this->db->where("status",1);
		return $this->db->get("intake")->result();
	}

	function getcollegeDetail($id){
		$this->db->where("type_id",$id);
		return $this->db->get("college")->row();
	}

	function getcourseDetail($id){
		$this->db->where("type_id",$id);
		return $this->db->get("course")->row();
	}

	function getdegreeDetail($id){
		$this->db->where("type_id",$id);
		return $this->db->get("degree")->row();
	}

	function addStudent(){
		$value['details']['first_name']     = $this->input->post('fname');
		$value['details']['last_name']      = $this->input->post('lname');
		$value['details']['email']          = $this->input->post('email');
		$value['details']['phone']          = $this->input->post('phone');
		$value['details']['address']          = $this->input->post('address');
		$value['details']['user_group']     = 14;
		$value['details']['user_name']      = $this->input->post('username');
		$value['details']['password']       = md5($this->input->post('password'));
		$value['details']['added_date']     = date('Y-m-d H:i:s');
		$value['details']['added_by']       = $this->session->userdata("clms_front_userid");
		$value['details']['status']         = 1;
		$this->db->insert("company_students",$value['details']);
		$student = $this->db->insert_id();
		$this->db->where("id",$student);
		$this->db->set("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->update("company_students");



		$insert_array = array(
			"company_student_id" => $student,
			"dob" => $this->input->post("dob"),
			"passport_no" => $this->input->post("passport_no"),
			"mobile" => $this->input->post("mobile"),
			"referral" => $this->input->post("referral"),
			"sex" => $this->input->post("sex"),
			"is_married" => $this->input->post("is_married"),
			"about_us" => $this->input->post("about_us"),
			);

		$this->db->insert("company_student_details",$insert_array);

		return $student;
	}

}