<?php
class appointmentmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'leads';

	}

	function listall($handle,$country,$weightage,$status,$category,$access,$language,$date,$added_date,$both=null,$student_id=null){
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_company"),$this->session->userdata("usergroup"))->num_rows();
		$company_user_id = $this->session->userdata("company_user_id");
		$userid = $this->commonmodel->get_login_id();
		$company_id = $this->session->userdata("clms_company");
		$group_id = $this->session->userdata("usergroup");

		$this->db->select('*,l.added_by handle,l.email email, l.status');
		$this->db->from($this->table." l");
		//$this->db->join("weightage w","w.weightage_id=l.weightage_id");
		//$this->db->join("lead_status ls","ls.status_id=l.status_id");
		//$this->db->join("users u","u.userid=l.user_id","left");
		if($handle != "")
			$this->db->where("l.added_by",$handle);
		if($country != "")
			$this->db->where("l.country",$country);
		if($weightage != "")
			$this->db->where("l.weightage_id",$weightage);
		if($status != "")
			$this->db->where("l.status_id",$status);
		if($access != "")
			$this->db->where("l.access",$access);
		if($category != "")
			$this->db->where("l.category",$category);
		if($language != "")
			$this->db->where("l.language",$language);
		
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_company"));

		if($all_data == 0){
			$this->db->where("(l.added_by = $userid OR l.user_id = $company_user_id OR l.consultant=$company_user_id OR l.student_id=$company_user_id)");
		}
	

		$this->db->where("is_booked",'1');
		if($both){
			$this->db->where("(status_id = 5 OR status_id = 6)");
		}else{
			$this->db->where("status_id",'5');
		}

		if($student_id){
			$this->db->where("student_id",$student_id);
		}
	
		if($added_date !=""){
			if($added_date == "today")
				$this->db->where("DATE_FORMAT(FROM_UNIXTIME(l.`added_date`), '%Y-%m-%d') = CURDATE()");
			elseif($added_date == "yesterday")
				$this->db->where("l.added_date >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY)) AND l.added_date < UNIX_TIMESTAMP(CURDATE())");
			elseif($added_date == "week")
				$this->db->where("WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(l.`added_date`), '%Y-%m-%d'))=WEEKOFYEAR(NOW())");
			elseif($added_date == "month")
				$this->db->where("MONTH(DATE_FORMAT(FROM_UNIXTIME(l.`added_date`), '%Y-%m-%d'))=MONTH(NOW())");
		}

		if($date == 'today'){
			$this->db->where("booking_date",date("Y-m-d"));
		}elseif($date == 'tomorrow'){
			$this->db->where("booking_date",date("Y-m-d", strtotime("+1 day")));
		}elseif($date == 'exceeded'){
			$this->db->where("booking_date < ",date("Y-m-d"));
		}elseif($date == 'active'){
			$this->db->where("booking_date > ",date("Y-m-d"));
		}

		$this->db->order_by('l.lead_id','desc');
		return $this->db->get();
	}

	function listcouncelling($handle,$country,$weightage,$status,$category,$access,$language,$date,$added_date){
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_company"),$this->session->userdata("usergroup"))->num_rows();
		$company_user_id = $this->session->userdata("company_user_id");
		$userid = $this->commonmodel->get_login_id();
		$company_id = $this->session->userdata("clms_company");
		$group_id = $this->session->userdata("usergroup");
		$this->db->select('*,l.added_by handle,l.email email, l.status');
		$this->db->from($this->table." l");
		//$this->db->join("weightage w","w.weightage_id=l.weightage_id");
		//$this->db->join("lead_status ls","ls.status_id=l.status_id");
		//$this->db->join("users u","u.userid=l.user_id","left");
		if($handle != "")
			$this->db->where("l.added_by",$handle);
		if($country != "")
			$this->db->where("l.country",$country);
		if($weightage != "")
			$this->db->where("l.weightage_id",$weightage);
		if($status != "")
			$this->db->where("l.status_id",$status);
		if($access != "")
			$this->db->where("l.access",$access);
		if($category != "")
			$this->db->where("l.category",$category);
		if($language != "")
			$this->db->where("l.language",$language);
	
		if($all_data == 0){
			$this->db->where("(l.added_by = $userid OR l.user_id = $company_user_id OR l.consultant=$company_user_id OR l.student_id=$company_user_id)");
		}

		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_company"));

		$this->db->where("is_booked",'1');
		$this->db->where("status_id",'6');
		
		if($added_date !=""){
			if($added_date == "today")
				$this->db->where("DATE_FORMAT(FROM_UNIXTIME(l.`added_date`), '%Y-%m-%d') = CURDATE()");
			elseif($added_date == "yesterday")
				$this->db->where("l.added_date >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY)) AND l.added_date < UNIX_TIMESTAMP(CURDATE())");
			elseif($added_date == "week")
				$this->db->where("WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(l.`added_date`), '%Y-%m-%d'))=WEEKOFYEAR(NOW())");
			elseif($added_date == "month")
				$this->db->where("MONTH(DATE_FORMAT(FROM_UNIXTIME(l.`added_date`), '%Y-%m-%d'))=MONTH(NOW())");
		}

		if($date == 'today'){
			$this->db->where("booking_date",date("Y-m-d"));
		}elseif($date == 'tomorrow'){
			$this->db->where("booking_date",date("Y-m-d", strtotime("+1 day")));
		}elseif($date == 'exceeded'){
			$this->db->where("booking_date < ",date("Y-m-d"));
		}

		$this->db->order_by('l.lead_id','desc');
		return $this->db->get();
	}

	function listChecklist($fee_id,$type="offer-letter"){
		$this->db->select("*")->from("course_fee_checklist cfc");
		$this->db->join("doc_type dt","dt.type_id=cfc.checklist_id");
		$this->db->where("fee_id",$fee_id);
		$this->db->where("checklist_type",$type);
		return $this->db->get("");
	}

	function listDownloadForm($fee_id){
		$this->db->select("*,d.status,d.type_name typename,d.type_id")->from("course_fee_form cff");
		$this->db->join("download d","d.type_id=cff.form_id");
		$this->db->join("doc_type dt","dt.type_id=d.doc_type");
		//$this->db->select("*,d.type_name typename")->from("course_fee_form cff");
		
		$this->db->where("fee_id",$fee_id);
		return $this->db->get("");
	}

	function get_Counselling($country, $intake, $college, $degree, $course){
		$this->db->select("fee_id,price,y_price,t_price,co.period,cf.status,c.country_name, i.type_name intake, cl.type_name college, d.type_name degree,co.type_name course")->from("course_fee cf");
		$this->db->join("countries c","c.country_id=cf.country_id");
		$this->db->join("intake i","i.type_id=cf.intake_id");
		$this->db->join("college cl","cl.type_id=cf.college");
		$this->db->join("degree d","d.type_id=cf.degree");
		$this->db->join("course co","co.type_id=cf.course");
		if($country != "")
			$this->db->where("cf.country_id",$country);

		if($intake != "")
			$this->db->where("cf.intake_id",$intake);

		if($college != "")
			$this->db->where("cf.college",$college);

		if($degree != "")
			$this->db->where("cf.degree",$degree);

		if($course != "")
			$this->db->where("cf.course",$course);
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){	
			$this->db->where("cf.company_id",$this->session->userdata("clms_company"));
		}
		$this->db->where("cf.status",1);
		return $this->db->get("")->result();
	}

	function get_favCounselling($lead_id){
		$this->db->select("cf.fee_id,fcf.lead_id,fcf.destinated_option,price,y_price,t_price,co.period,cf.status,c.country_name, i.type_name intake, cl.type_name college, d.type_name degree,co.type_name course")->from("course_fee cf");
		$this->db->join("countries c","c.country_id=cf.country_id");
		$this->db->join("intake i","i.type_id=cf.intake_id");
		$this->db->join("college cl","cl.type_id=cf.college");
		$this->db->join("degree d","d.type_id=cf.degree");
		$this->db->join("course co","co.type_id=cf.course");
		$this->db->join("fav_course_fee fcf","fcf.fee_id=cf.fee_id");
		$this->db->where("fcf.lead_id",$lead_id);
		return $this->db->get("")->result();
	}

	function checkfee($leadid,$fee_id){
		$this->db->where("lead_id",$leadid);
		$this->db->where("fee_id",$fee_id);
		return $this->db->get("fav_course_fee")->num_rows();
	}

	function about_us(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("company_id",0);
		}
		return $this->db->get("about_us")->result();
	}

	function get_purpose(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("company_id",0);
		}
		return $this->db->get("purpose")->result();
	}

	function get_source(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("company_id",0);
		}
		return $this->db->get("source")->result();
	}

	function get_form(){
		$this->db->where("module_name","Lead");
		$this->db->where("company_id",$this->session->userdata("clms_company"));
		return $this->db->get("form");
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function addstatus($data){
		$this->db->insert("lead_update",$data);
	}

	function get_updates($leadid){
		$this->db->select("l.update_id,l.content,l.added_date,u.first_name,u.last_name");
		$this->db->from("lead_update l");
		$this->db->join("users u","u.userid=l.added_by");
		$this->db->where("l.lead_id",$leadid);
		$this->db->order_by("l.update_id","desc");
		return $this->db->get("")->result();
	}

	function getdata($lead_id){
		$this->db->where('lead_id',$lead_id);
		//$this->db->where_in('status', array('0','1'));
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($lead_id, $data){
		$this->db->where('lead_id', $lead_id);
		$this->db->update($this->table, $data);
	}

	function delete($lead_id) {

		$this->db->where('lead_id', $lead_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('lead_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('lead_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('lead_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}

		}
		return;
	}

	function get_languages(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->order_by("language_name","asc");
		return $this->db->get("language")->result();
	}

	function get_chatType(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		$this->db->order_by("chat_name","asc");
		return $this->db->get("chat")->result();
	}

	function get_WhenStart(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		$this->db->order_by("start_name","asc");
		return $this->db->get("start")->result();
	}

	function get_category($parent = 0){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("parent_id",$parent);
		$this->db->where("status",1);
		$this->db->order_by("cat_name","asc");
		return $this->db->get("lead_category")->result();
	}

	function get_access(){
		//if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
		//	$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		$this->db->order_by("access_name","asc");
		return $this->db->get("access")->result();
	}

	function get_users(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		$this->db->where("user_group",3);
		$this->db->order_by("first_name","asc");
		return $this->db->get("users")->result();
	}

	function get_leadweightage(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		$this->db->order_by("name","asc");
		return $this->db->get("weightage")->result();
	}

	function get_leadstatus(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("company_id",0);
		}
		$this->db->where("status",1);
		$this->db->order_by('status_id','asc');
		return $this->db->get("lead_status")->result();
	}

	function addLmsfiles($data){
		$this->db->insert("lead_documents",$data);
	}

	function get_documents($lead_id){
		$this->db->where("lead_id",$lead_id);
		$query = $this->db->get("lead_documents");
		return $query->result();
	}

	function getusers($userid){
		$this->db->where("userid",$userid);
		return $this->db->get("users")->row();
	}
	

	
	function getcompany_users($userid){
		$this->db->where("id",$userid);
		return $this->db->get("company_users")->row();
	}
	

	function getlead_status($id){
		$this->db->where("status_id",$id);
		return $this->db->get("lead_status")->row();
	}

	function getlead_purpose($id){
		$this->db->where("type_id",$id);
		return $this->db->get("purpose")->row();
	}

	function get_Courses(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		return $this->db->get("course")->result();
	}

	function get_Colleges(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		return $this->db->get("college")->result();
	}

	function get_Degrees(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		return $this->db->get("degree")->result();
	}

	function get_Intakes(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		return $this->db->get("intake")->result();
	}

	function get_country(){
		$query = $this->db->get("countries");
		return $query->result();
	}

	function getleadusers($lead_id){
		$this->db->where("lead_id",$lead_id);
		$this->db->where("added_by !=",$this->session->userdata("clms_userid"));
		return $this->db->get("lead_update")->result();
	}

	function get_userdetails($userid){
		$this->db->where("id",$userid);
		return $this->db->get("company_users")->row();
	}

	function get_leadTypes(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		return $this->db->get("lead_type")->result();
	}
}