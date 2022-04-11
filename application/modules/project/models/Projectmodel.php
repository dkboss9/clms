<?php
class Projectmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'projects';		

	}

	function msgsender($added_by,$comment_from){
		if($comment_from == 'company'){
			return $this->db->where("userid",$added_by)->get("users u")->row();
		}else{
			return $this->db->select("u.*")->from("pnp_company_students cs")
			->join("users u","u.userid=cs.student_id")->get()->row();
		}
	}

	function get_rootCompanies(){
		$companies = $this->db->select("userid company_id,company_name")->from('group g')
        ->join("user_groups ug","ug.group_id = g.groupid")
        ->join("pnp_user_group_company ugc","ugc.user_group_id = ug.id")
        ->join("users u","u.userid = ugc.company_id")
		->where("u.userid=u.company_id")
		->where('u.status',1)
		->where('u.verified_at is NOT NULL')
        ->where('groupid',7)->get();
		return $companies;
	}

	function listall($added_date="",$type="",$status="",$deadline="",$start_date="",$end_date="",$handle="",$filter="", $is_assigned="",$commence_date="",$student_id=null,$is_completed=null){			
		
		$email = $this->session->userdata("clms_front_email");
		$this->db->select("*,p.status status,p.added_date,s.first_name fname, s.last_name lname,s.id student_id,com.company_name")->from("projects p");
		$this->db->join("enroll e","e.order_id=p.project_id");
		$this->db->join("users com","com.userid=e.company_id");
		$this->db->join("company_students s","s.id=e.student_id");
		$this->db->join("project_status ps","p.project_status=ps.status_id");
		$this->db->join("lead_type lt","lt.type_id=p.lead_type");
		$this->db->join("company_users u","u.id=p.sales_rep");
		$this->db->join("project_employee pe","pe.project_id=p.project_id","left");
		$this->db->join("project_supplier psup","psup.project_id=p.project_id","left");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		if($added_date !=""){
			if($added_date == "today")
				$this->db->where("DATE_FORMAT(FROM_UNIXTIME(p.`added_date`), '%Y-%m-%d') = CURDATE()");
			elseif($added_date == "yesterday")
				$this->db->where("p.added_date >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY)) AND p.added_date < UNIX_TIMESTAMP(CURDATE())");
			elseif($added_date == "week")
				$this->db->where("WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(p.`added_date`), '%Y-%m-%d'))=WEEKOFYEAR(NOW())");
			elseif($added_date == "month")
				$this->db->where("MONTH(DATE_FORMAT(FROM_UNIXTIME(p.`added_date`), '%Y-%m-%d'))=MONTH(NOW())");
		}
		if($type != "")
			$this->db->where("lead_type",$type);

		if($status != "")
			$this->db->where("project_status",$status);

		if($deadline != "")
			$this->db->where("WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(p.`end_date`), '%Y-%m-%d'))=WEEKOFYEAR(NOW())");
		if($handle != "")
			$this->db->where("sales_rep",$handle);
		
		if($start_date != ""){
			$dates = explode("/", $start_date);
			$date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
			if($filter == 1)
				$this->db->where("start_date >=",strtotime($date));
			else
				$this->db->where("end_date >=",strtotime($date));
		}
		if($end_date != ""){
			$dates = explode("/", $end_date);
			$date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
			
			if($filter == 1)
				$this->db->where("start_date <=",strtotime($date));
			else
				$this->db->where("end_date <=",strtotime($date));
		}
		if($commence_date == 'next_month'){
			$start_date = date("Y-m-01", strtotime('next month'));
			$end_date = date("Y-m-t", strtotime('next month'));
			$this->db->where("commence_date >=",$start_date);
			$this->db->where("commence_date <=",$end_date);
		}elseif($commence_date == 'month'){
			$start_date = date("Y-m-01", strtotime('this month'));
			$end_date = date("Y-m-t", strtotime('this month'));
			$this->db->where("commence_date >=",$start_date);
			$this->db->where("commence_date <=",$end_date);
		}elseif($commence_date == 'today'){
			$this->db->where("commence_date",date("Y-m-d"));
		}
		if($is_assigned !=""){
			if( $is_assigned == 1){
				$this->db->where("(p.project_id in (select project_id from pnp_project_employee) OR p.project_id in (select project_id from pnp_project_supplier))");
			}else{
				$this->db->where("p.project_id not in (select project_id from pnp_project_employee)");
				$this->db->where("p.project_id not in (select project_id from pnp_project_supplier)");
			}
		}

		$this->db->where("s.email",$email);

		if($is_completed)
			$this->db->where("e.collected_points !=",NULL);

	

		$this->db->order_by("p.project_id","desc");
		$this->db->group_by("p.project_id");
		return $this->db->get("");
		
	}

	function project_listdetail($projectid){			
		$this->db->select("*,p.status status,p.added_date,s.first_name fname, s.last_name lname")->from("projects p");
		$this->db->join("enroll e","e.order_id=p.project_id");
		$this->db->join("company_students s","s.id=e.student_id");
		$this->db->join("project_status ps","p.project_status=ps.status_id");
		$this->db->join("lead_type lt","lt.type_id=p.lead_type");
		$this->db->join("company_users u","u.id=p.sales_rep");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("p.project_id",$projectid);
		return $this->db->get("")->row();
	}


	function getGsts(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
			$this->db->or_where("company_id",0);
		}	
		$this->db->where("status",'1');
		return $this->db->get("gst")->result();
	}

	function projectDetail($id){
		$this->db->select("*,p.status status,p.added_date,s.first_name fname, s.last_name lname,s.id  student_id")->from("projects p");
		$this->db->join("enroll e","e.order_id=p.project_id");
		$this->db->join("company_students s","s.id=e.student_id");
		$this->db->join("project_status ps","p.project_status=ps.status_id");
		$this->db->join("lead_type lt","lt.type_id=p.lead_type");
		$this->db->join("company_users u","u.id=p.sales_rep");
		$this->db->where("project_id",$id);
		return $this->db->get("");
	}

	function get_chatId($userids,$type=null){
		$chats = [];
		foreach($userids as $userid){
			$this->db->select("*")->from("pnp_user_chat_users u");
			$this->db->join("pnp_user_chat c","c.id=u.chat_user_id");
			$this->db->where("u.user_id",$userid);
			if($type)
				$this->db->where("c.type",$type);
			$chat = $this->db->get()->result_array();
			$chat_ids = array_column($chat,"chat_user_id");
			array_push($chats,$chat_ids);
  
		}

		$result = call_user_func_array('array_intersect', $chats);
		return $result;
	}

	function chatmsglist(){
		$this->db->select("m.*,u.company_name,m.added_by")->from("pnp_company_student_note_new m");
		$this->db->join("company_students cu","cu.id=m.company_student_id",'left');
		$this->db->join("users u","u.userid=cu.company_id",'left');
		$this->db->where("cu.email",$this->session->userdata("clms_front_email"));
		$this->db->group_by("cu.company_id");
		$this->db->order_by("id","desc");
		return $this->db->get()->result();
	}

	function getChatMessages($userid=null){
		$this->db->select("m.*,u.*,m.added_by")->from("pnp_company_student_note_new m");
		$this->db->join("pnp_users u","u.userid=m.added_by",'left');
		$this->db->where("m.company_student_id",$userid);
		$this->db->order_by("id","desc");
		return $this->db->get()->result();
	}

	function checkChecklist($chklistid,$enrollid){
		$this->db->where("checklist_id",$chklistid);
		$this->db->where("enroll_id",$enrollid);
		return $this->db->get("enroll_checklist");
	}

	function getCollectedPoints($student_id){
		$this->db->select("SUM(collected_points) as points");
		$this->db->from("pnp_enroll e");
		$this->db->join("company_students u","u.id = e.student_id");
		$this->db->where("u.email",$this->session->userdata("clms_front_email"));
		return $this->db->get()->row();
	}


	function getTotalInvoice($student_id){
		$this->db->select("SUM(price) as total");
		$this->db->from("pnp_order o");
		$this->db->join("company_students u","u.id = o.customer_id");
		$this->db->where("u.email",$this->session->userdata("clms_front_email"));
		return $this->db->get()->row();
	}


	function getnotes($id){
		$this->db->select("*,s.added_date")->from("project_note s");
		$this->db->join("users u","u.userid=s.added_by");
		$this->db->where("s.project_id",$id);
		return $this->db->get("")->result();
	}

	function getchecklistnote($id){
		$this->db->select("*,s.added_date")->from("enroll_checklist_note s");
		$this->db->join("users u","u.userid=s.added_by");
		$this->db->where("s.checklist_id",$id);
		return $this->db->get("")->result();
	}

	function get_form(){
		$this->db->where("module_name","Order");
		$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		return $this->db->get("form");
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($project_id){
		$this->db->where('project_id',$project_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($project_id, $data){
		$this->db->where('project_id', $project_id);
		$this->db->update($this->table, $data);
	}

	function delete($project_id) {
		$this->db->where('project_id', $project_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('project_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('project_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('project_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function check_duplicateEmail($email){
		$this->db->where("email",$email);
		return $this->db->get($this->table)->num_rows();
	}

	function getcoutries(){
		return $this->db->get("countries")->result();
	}

	function getstates(){
		return $this->db->get("states")->result();
	}

	function getStatus(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	{
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
			$this->db->or_where("company_id",0);
		}
		$this->db->where("status",1);
		return $this->db->get("project_status")->result();
	}

	function get_customer(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		return $this->db->get("company_students")->result();
	}

	function getRate($type,$userid){
		$this->db->where("type_id",$type);
		$this->db->where("user_id",$userid);
		$query = $this->db->get("salesrep_rate");
		if($query->num_rows() > 0){
			return $query->row()->rate;
		}else{
			return 0;
		}
		
	}

	function get_empoyee(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->where("user_group",9);
		$this->db->order_by("first_name","asc");
		return $this->db->get("company_users")->result();
	}

	function get_supplier(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->where("user_group",10);
		return $this->db->get("company_users")->result();
	}

	function get_packages(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	{
			$userid = $this->session->userdata("clms_front_companyid");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		return $this->db->get("package")->result();
	}

	function getEmployeeDetails($empid,$projectid){
		$this->db->where("project_id",$projectid);
		$this->db->where("employee_id",$empid);
		return $this->db->get("project_employee")->num_rows();
	}

	function getSupplierDetails($empid,$projectid){
		$this->db->where("project_id",$projectid);
		$this->db->where("supplier_id",$empid);
		return $this->db->get("project_supplier")->num_rows();
	}

	function get_leadTypes(){
		
		$this->db->select("count(*) num,lt.type_id,lt.type_name")->from("projects p");
		$this->db->join("lead_type lt","lt.type_id = p.lead_type");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->group_by("lt.type_id");
		return $this->db->get('')->result();
	}

	function get_leadTypesSales(){
		$this->db->select("sum(total) num,lt.type_id,lt.type_name")->from("projects p");
		$this->db->join("lead_type lt","lt.type_id = p.lead_type");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->group_by("lt.type_id");
		return $this->db->get('')->result();
	}

	function get_leadTypesCommission(){
		$this->db->select("sum(commission) num,lt.type_id,lt.type_name")->from("projects p");
		$this->db->join("lead_type lt","lt.type_id = p.lead_type");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->group_by("lt.type_id");
		return $this->db->get('')->result();
	}

	function get_Salereps(){
		
		$this->db->select("count(*) num,u.first_name,u.last_name,p.sales_rep")->from("projects p");
		$this->db->join("users u","u.userid = p.sales_rep");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->group_by("p.sales_rep");
		return $this->db->get('')->result();
	}

	function get_SalerepsSales(){
		
		$this->db->select("sum(total) num,u.first_name,u.last_name,p.sales_rep")->from("projects p");
		$this->db->join("users u","u.userid = p.sales_rep");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->group_by("p.sales_rep");
		return $this->db->get('')->result();
	}

	function get_SalerepsCommissions(){
		
		$this->db->select("sum(commission) num,u.first_name,u.last_name,p.sales_rep")->from("projects p");
		$this->db->join("users u","u.userid = p.sales_rep");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->group_by("p.sales_rep");
		return $this->db->get('')->result();
	}


	function get_Status(){
		$this->db->select("count(*) num,ps.status_name,ps.status_id")->from("projects p");
		$this->db->join("project_status ps","ps.status_id = p.project_status");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->group_by("p.project_status");
		return $this->db->get('')->result();
	}

	function get_LeadStatus(){
		$this->db->select("count(*) num,ls.status_name,ls.status_id")->from("leads l");
		$this->db->join("lead_status ls","ls.status_id = l.status_id");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	{
			$this->db->where("ls.company_id",$this->session->userdata("clms_front_companyid"));
			$this->db->or_where("ls.company_id",0);
		}
		$this->db->group_by("ls.status_id");
		return $this->db->get('')->result();
	}

	function get_projectStatus(){
		$this->db->select("count(*) num,ls.status_name,ls.status_id")->from("lms_project l");
		$this->db->join("lms_project_status ls","ls.status_id = l.task_status");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("ls.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->group_by("ls.status_id");
		return $this->db->get('')->result();
	}

	function get_LeadCategory(){
		$this->db->select("count(*) num,lc.cat_name,lc.cat_id")->from("leads l");
		$this->db->join("lead_category lc","lc.cat_id = l.category");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->group_by("lc.cat_id");
		return $this->db->get('')->result();
	}

	function get_StatusSales(){
		$this->db->select("sum(total) num,ps.status_name,ps.status_id")->from("projects p");
		$this->db->join("project_status ps","ps.status_id = p.project_status");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->group_by("p.project_status");
		return $this->db->get('')->result();
	}

	function get_StatusCommission(){
		$this->db->select("sum(commission) num,ps.status_name,ps.status_id")->from("projects p");
		$this->db->join("project_status ps","ps.status_id = p.project_status");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->group_by("p.project_status");
		return $this->db->get('')->result();
	}

	function get_leadTypes_num(){
		
		$this->db->select("count(*) num")->from("projects p");
		$this->db->join("lead_type lt","lt.type_id = p.lead_type");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		return $this->db->get('')->row()->num;
	}

	function get_leadStatus_num(){
		
		$this->db->select("count(*) num")->from("leads l");
		$this->db->join("lead_status ls","ls.status_id = l.status_id");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_front_companyid"));
		return $this->db->get('')->row()->num;
	}

	function get_projectStatus_num(){
		
		$this->db->select("count(*) num")->from("lms_project l");
		$this->db->join("lms_project_status ls","ls.status_id = l.task_status");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_front_companyid"));
		return $this->db->get('')->row()->num;
	}

	function get_LeadCategory_num(){
		$this->db->select("count(*) num")->from("leads l");
		$this->db->join("lead_category lc","lc.cat_id = l.category");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_front_companyid"));
		return $this->db->get('')->row()->num;
	}

	function get_leadTypes_numSales(){
		
		$this->db->select("count(total) num")->from("projects p");
		$this->db->join("lead_type lt","lt.type_id = p.lead_type");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		return $this->db->get('')->row()->num;
	}

	function get_leadTypes_numCommission(){
		
		$this->db->select("count(commission) num")->from("projects p");
		$this->db->join("lead_type lt","lt.type_id = p.lead_type");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		return $this->db->get('')->row()->num;
	}

	function count_project($userid,$type_id){
		$this->db->where("lead_type",$type_id);
		$this->db->where("sales_rep",$userid);
		return $this->db->get("projects")->num_rows();
	}

	function count_dashboardProject($month,$type_id){
		$sql = "SELECT sum(total) AS times FROM pnp_projects p WHERE  MONTH(DATE_FORMAT(FROM_UNIXTIME(`added_date`), '%Y-%m-%d'))=$month";
		//$sql = "SELECT sum(total) AS times FROM pnp_projects p WHERE  MONTH(DATE_FORMAT(FROM_UNIXTIME(`added_date`), '%Y-%m-%d'))=$month and YEAR(DATE_FORMAT(FROM_UNIXTIME(`added_date`), '%Y-%m-%d'))=YEAR(NOW())";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (p.sales_rep='".$this->session->userdata("clms_front_userid")."') OR (p.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and p.company_id =".$this->session->userdata("clms_front_companyid");

		$sql.=" and p.lead_type =".$type_id;
		//$this->db->where("lead_type",$type_id);
		//$this->db->where("sales_rep",$userid);
		//$this->db->group_by("mymonth");
		$row = $this->db->query($sql)->row();
		return intval($row->times);
	}


	function count_projectSales($userid,$type_id){
		$this->db->select("sum(total) num")->from("projects");
		$this->db->where("lead_type",$type_id);
		$this->db->where("sales_rep",$userid);
		return $this->db->get("")->row()->num;
	}

	function count_MonthSales($userid,$month){
		$year = date('Y');
		$sql = "SELECT SUM(total) AS num FROM pnp_projects l WHERE  MONTH(DATE_FORMAT(FROM_UNIXTIME(`added_date`), '%Y-%m-%d'))=$month and YEAR(DATE_FORMAT(FROM_UNIXTIME(`added_date`), '%Y-%m-%d')) = $year";
		$sql.=" and (l.sales_rep ='".$userid."')";
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
			//echo $sql;
		$row = $this->db->query($sql)->row();
		return $row->num;
	}

	function count_projectCommission($userid,$type_id){
		$this->db->select("sum(commission) num")->from("projects");
		$this->db->where("lead_type",$type_id);
		$this->db->where("sales_rep",$userid);
		return $this->db->get("")->row()->num;
	}

	function count_projectstatus($userid,$status_id){
		$this->db->where("project_status",$status_id);
		$this->db->where("sales_rep",$userid);
		return $this->db->get("projects")->num_rows();
	}

	function count_projectstatusSales($userid,$status_id){
		$this->db->select("sum(total) num")->from("projects");
		$this->db->where("project_status",$status_id);
		$this->db->where("sales_rep",$userid);
		return $this->db->get("")->row()->num;
	}

	function count_projectstatusCommission($userid,$status_id){
		$this->db->select("sum(commission) num")->from("projects");
		$this->db->where("project_status",$status_id);
		$this->db->where("sales_rep",$userid);
		return $this->db->get("")->row()->num;
	}

	function get_projectEmployee($project_id){
		$this->db->select("*")->from("pnp_project_employee pe");
		$this->db->join("company_users u","u.id = pe.employee_id");
		$this->db->where("pe.project_id",$project_id);
		return $this->db->get("")->result();
		
	}

	function get_projectSupplier($project_id){
		$this->db->select("*")->from("pnp_project_supplier ps");
		$this->db->join("company_users u","u.id = ps.supplier_id");
		$this->db->where("ps.project_id",$project_id);
		return $this->db->get("")->result();
	}

	function get_projectPackage($project_id){
		$this->db->where("project_id",$project_id);
		return $this->db->get("project_package")->result();
	}

	function getUserDetail($userid){
		$this->db->where("id",$userid);
		return $this->db->get("company_students")->row();
	}

	function getUserDetailNew($userid){
		$this->db->where("userid",$userid);
		return $this->db->get("users")->row();
	}

	function getchecklistfiles($enroll_checklistid){
		$this->db->where("enroll_checklist_id",$enroll_checklistid);
		return $this->db->get("pnp_enroll_checklist_files")->result();
	}

	function sendemail($project_id){
		$enroll = $this->projectDetail($project_id)->row();
		$student = $this->studentmodel->getdata($enroll->student_id)->row();
		$from     = $this->mylibrary->getSiteEmail(32);
		$site_url = $this->mylibrary->getSiteEmail(21);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(25);
		$phone    = $this->mylibrary->getSiteEmail(27);
		$fax      = $this->mylibrary->getSiteEmail(28);
		$sitemail = $this->mylibrary->getSiteEmail(23);
		$logo     = $this->mylibrary->getlogo();
		$this->email->set_mailtype('html');
		$this->email->from($sitemail, $fromname);
		$this->email->to($student->email);
		$row = $this->mylibrary->getCompanyEmailTemplate(55,$enroll->company_id);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
		$subject = str_replace('[STUDENT_NAME]',$student->first_name.' '.$student->last_name,$subject);
		$subject = str_replace('[ENROLL_NUMBER]',$enroll->order_no,$subject);
		$this->email->subject($subject);
		$message = str_replace('[STUDENT_NAME]',$student->first_name.' '.$student->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[ENROLL_NUMBER]',$enroll->order_no,$message);
		$message = str_replace('[ADDED_DATE]',date("d/m/Y",$enroll->added_date),$message);
		$message = str_replace('[START_DATE]',date("d/m/Y",$enroll->start_date),$message);
		$message = str_replace('[END_DATE]',date("d/m/Y",$enroll->end_date),$message);
		$message = str_replace('[STATUS]',$enroll->status_name,$message);
		$intake = $this->intakemodel->getdata($enroll->intake)->row();
		$college = $this->collegemodel->getdata($enroll->college)->row();
		$degree = $this->degreemodel->getdata($enroll->degree)->row();
		$course = $this->coursemodel->getdata($enroll->course)->row();
		$message = str_replace('[INTAKE]',$intake->type_name,$message);
		$message = str_replace('[COLLEGE]',@$college->type_name,$message);
		$message = str_replace('[DEGREE]',@$degree->type_name,$message);
		$message = str_replace('[COURSE]',@$course->type_name,$message);
		$message = str_replace('[GRAND_TOTAL]',$enroll->grand_total,$message);
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		$message = str_replace('[SITE_URL]',$site_url,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		$company = $this->usermodel->getuser($this->session->userdata("clms_front_companyid"))->row();
		$message = str_replace('[COMPANY_NAME]',@$company->company_name,$message);
		$message = str_replace('[COMPANY_ADDRESS]',@$company->address,$message);

		$this->email->message($message);
		$this->email->send();
		$this->email->clear();

		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[STUDENT_NAME]',$student->first_name.' '.$student->last_name,html_entity_decode($sms,ENT_COMPAT));
			$sms = str_replace('[ENROLL_NUMBER]',$enroll->order_no,$sms);
			$sms = str_replace('[ADDED_DATE]',date("d/m/Y",$enroll->added_date),$sms);
			$sms = str_replace('[START_DATE]',date("d/m/Y",$enroll->start_date),$sms);
			$sms = str_replace('[END_DATE]',date("d/m/Y",$enroll->end_date),$sms);
			$sms = str_replace('[STATUS]',$enroll->status_name,$sms);

			$sms = str_replace('[INTAKE]',$intake->type_name,$sms);
			$sms = str_replace('[COLLEGE]',@$college->type_name,$sms);
			$sms = str_replace('[DEGREE]',@$degree->type_name,$sms);
			$sms = str_replace('[COURSE]',@$course->type_name,$sms);
			$sms = str_replace('[GRAND_TOTAL]',$enroll->grand_total,$sms);
			$sms = str_replace('[SITE_NAME]',$fromname,$sms);
			$sms = str_replace('[LOGO]',$logo,$sms);
			$sms = str_replace('[SITE_ADDRESS]',$address,$sms);
			$sms = str_replace('[SITE_PHONE]',$phone,$sms);
			$sms = str_replace('[SITE_FAX]',$fax,$sms);
			$sms = str_replace('[SITE_EMAIL]',$sitemail,$sms);
			$sms = str_replace('[SITE_URL]',$site_url,$sms);
			$sms = str_replace('[YEAR]',date('Y'),$sms);
			$sms = str_replace('[COMPANY_NAME]',@$company->company_name,$sms);
		    $sms = str_replace('[COMPANY_ADDRESS]',@$company->address,$sms);
			$mobile = $student->mobile;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/
	}

	function sendnoteEmail($enrollid,$note=''){
		$enroll = $this->enrollmodel->getdata($enrollid)->row();
		$project = $this->getdata($enrollid)->row();
		$student = $this->studentmodel->getdata($enroll->student_id)->row();

		$company = $this->usermodel->getuser($this->session->userdata("clms_front_companyid"))->row();

		$from     = $this->mylibrary->getSiteEmail(32);
		$site_url = $this->mylibrary->getSiteEmail(21);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(25);
		$phone    = $this->mylibrary->getSiteEmail(27);
		$fax      = $this->mylibrary->getSiteEmail(28);
		$sitemail = $this->mylibrary->getSiteEmail(23);
		$logo     = $this->mylibrary->getlogo();
		$this->email->set_mailtype('html');
		$this->email->from($sitemail, $fromname);
		$this->email->to(@$student->email);
		$row = $this->mylibrary->getCompanyEmailTemplate(60,$project->company_id);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
		$subject = str_replace('[USER_NAME]',@$company->first_name.' '.@$company->last_name,$subject);
		$subject = str_replace('[ENROL_NUMBER]',$project->order_no,$subject);
		$this->email->subject($subject);
		$message = str_replace('[USER_NAME]',@$company->first_name.' '.@$company->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[CONTENT]',$note,$message);
		$message = str_replace('[ENROL_NUMBER]',$project->order_no,$message);
		$message = str_replace('[NAME]',$student->first_name.' '.$student->last_name,$message);
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		$message = str_replace('[SITE_URL]',$site_url,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		
		$message = str_replace('[COMPANY_NAME]',@$company->company_name,$message);
		 $message = str_replace('[COMPANY_ADDRESS]',@$company->address,$message);

		$this->email->message($message);
		$this->email->send();
		$this->email->clear();

		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1){
			$sms = $row->sms_text;

			$sms = str_replace('[USER_NAME]',@$company->first_name.' '.@$company->last_name,html_entity_decode($sms,ENT_COMPAT));
			$sms = str_replace('[CONTENT]',$note,$sms);
			$sms = str_replace('[ENROL_NUMBER]',$project->order_no,$sms);
			$sms = str_replace('[NAME]',$student->first_name.' '.$student->last_name,$sms);
			$sms = str_replace('[SITE_NAME]',$fromname,$sms);
			$sms = str_replace('[LOGO]',$logo,$sms);
			$sms = str_replace('[SITE_ADDRESS]',$address,$sms);
			$sms = str_replace('[SITE_PHONE]',$phone,$sms);
			$sms = str_replace('[SITE_FAX]',$fax,$sms);
			$sms = str_replace('[SITE_EMAIL]',$sitemail,$sms);
			$sms = str_replace('[SITE_URL]',$site_url,$sms);
			$sms = str_replace('[YEAR]',date('Y'),$sms);

			$sms = str_replace('[COMPANY_NAME]',@$company->company_name,$sms);
			$sms = str_replace('[COMPANY_ADDRESS]',@$company->address,$sms);
			$mobile = $student->mobile;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/
	}

	function sendchecklistemail($chklistid,$enrollid,$content=''){
		$enroll = $this->enrollmodel->getdata($enrollid)->row();
		$project = $this->getdata($enrollid)->row();
		$checklist = $this->checkChecklist($chklistid,$enrollid)->row();
		$student = $this->studentmodel->getdata_new($this->session->userdata("clms_front_userid"))->row();
		$doctype = $this->studentmodel->getDocType($chklistid);

		$company = $this->usermodel->getuser($enroll->company_id)->row();

		$from     = $this->mylibrary->getSiteEmail(32);
		$site_url = $this->mylibrary->getSiteEmail(21);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(25);
		$phone    = $this->mylibrary->getSiteEmail(27);
		$fax      = $this->mylibrary->getSiteEmail(28);
		$sitemail = $this->mylibrary->getSiteEmail(22);
		$logo     = $this->mylibrary->getlogo();
		$this->email->set_mailtype('html');
		$this->email->from($sitemail, $fromname);
		$this->email->reply_to($student->email);
	//	$company->email = 'bikash.suwal01@gmail.com';
		$this->email->to($company->email);
		$row = $this->mylibrary->getCompanyEmailTemplate(89,$project->company_id);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
		$subject = str_replace('[NAME]',@$student->first_name.' '.@$student->last_name,$subject);
		$subject = str_replace('[ENROL_NUMBER]',$project->order_no,$subject);
		$subject = str_replace('[CHECKLIST]',$doctype->type_name,$subject);
		$subject = str_replace('[STATUS]',$checklist->checklist_status,$subject);
		$this->email->subject($subject);
		$message = str_replace('[STUDENT_NAME]',$company->first_name.' '.$company->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[CHECKLIST]',$doctype->type_name,$message);
		$message = str_replace('[ENROL_NUMBER]',$project->order_no,$message);
		$message = str_replace('[STATUS]',$checklist->checklist_status,$message);
		$message = str_replace('[CONTENT]',$content,$message);
		$message = str_replace('[NAME]',@$student->first_name.' '.@$student->last_name,$message);
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		$message = str_replace('[SITE_URL]',$site_url,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		
		$message = str_replace('[COMPANY_NAME]',@$company->company_name,$message);
		$message = str_replace('[COMPANY_ADDRESS]',@$company->address,$message);

		$this->email->message($message);
		$this->email->send();
		$this->email->clear();

		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[STUDENT_NAME]',$company->first_name.' '.$company->last_name,html_entity_decode($sms,ENT_COMPAT));
			$sms = str_replace('[CHECKLIST]',$doctype->type_name,$sms);
			$sms = str_replace('[ENROL_NUMBER]',$project->order_no,$sms);
			$sms = str_replace('[STATUS]',$checklist->checklist_status,$sms);
			$sms = str_replace('[CONTENT]',$content,$sms);
			$sms = str_replace('[NAME]',@$student->first_name.' '.@$student->last_name,$sms);
			$sms = str_replace('[SITE_NAME]',$fromname,$sms);
			$sms = str_replace('[LOGO]',$logo,$sms);
			$sms = str_replace('[SITE_ADDRESS]',$address,$sms);
			$sms = str_replace('[SITE_PHONE]',$phone,$sms);
			$sms = str_replace('[SITE_FAX]',$fax,$sms);
			$sms = str_replace('[SITE_EMAIL]',$sitemail,$sms);
			$sms = str_replace('[SITE_URL]',$site_url,$sms);
			$sms = str_replace('[YEAR]',date('Y'),$sms);

			$sms = str_replace('[COMPANY_NAME]',@$company->company_name,$sms);
			$sms = str_replace('[COMPANY_ADDRESS]',@$company->address,$sms);
			$mobile = $student->mobile;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/
	}

	function checkphase($enroll_id,$phase_id=null,$all=null){
		$this->db->select("*,cn.added_at date")->from("pnp_enroll_caseflow c");
		$this->db->join("pnp_enroll_caseflow_notes cn","cn.enroll_case_flow_id=c.id");
		$this->db->join("pnp_users u","u.userid=cn.added_by");
		$this->db->where("c.enroll_id",$enroll_id);
		if($phase_id)
			$this->db->where("c.case_phase",$phase_id);
		$this->db->order_by("cn.id","desc");
		if($all)
			return $this->db->get()->result();
		else
			return $this->db->get()->row();
	}

	function lastestphase($enroll_id){
		$this->db->where("enroll_id",$enroll_id);
		$this->db->order_by("id","desc");
		$row =  $this->db->get("pnp_enroll_caseflow")->row();
		return $row->case_phase ?? 0;
	}



	function getmailconent($id,$student){

		$customer_arr = array();
		$this->db->where("email_id",$id);
		$email = $this->db->get("custom_email_template");
		
		
		$customer_arr['name'] = $student->first_name.' '.$student->last_name;
		$customer_arr['email'] = $student->email;
	
		$data['company'] = $this->quotemodel->getCompanyDetails($this->session->userdata("clms_front_companyid"));
		
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}
		
		
		$header = $this->getHeader();
		$row = $email->row();
		$footer = $this->getFooter();
		$row->email_message = $header.$row->email_message.$footer; 

		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to( $student->email);

		
		$subject = str_replace('[COMPANY_NAME]', $data['company']->company_name, $row->email_subject);

		$this->email->subject($subject);

		$message = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[FULL_NAME]', $student->first_name.' '.$student->last_name, $message);
		
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[NAME]', $student->first_name.' '.$student->last_name, $message);
		// $message = str_replace('[CUSTOMER_COMPANY]', $lead->company_name, $message);
		$message = str_replace('[EMAIL]', $student->email, $message);
		$message = str_replace('[PHONE]', $student->phone, $message);
	
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		
		return array($subject,$message,$customer_arr,array($student->email));

	}

	function countemail($emailid,$student_id){
		return $this->db->where("custom_email_id",$emailid)->where("student_id",$student_id)->get("custom_email_sent")->num_rows();
	}

	function getHeader(){
		return '<table border="0" cellpadding="5" cellspacing="0" width="100%">
		<tbody>
			<tr>
				<td>
					[LOGO]</td>
			</tr>
			<tr>
				<td>
					Dear [FULL_NAME],</td>
			</tr>
			<tr>
				<td>';
	}


	function getFooter(){
		return '</td>
		</tr>
		<tr>
			<td>
				<span attached="" background-color:="" blockquote="" find="" font-family:="" font-size:="" for="" invoice="" number:="" open="" order="" please="" type="cite">&nbsp;</span></td>
		</tr>
		<tr>
			<td>
				<span attached="" background-color:="" blockquote="" find="" font-family:="" font-size:="" for="" invoice="" number:="" open="" order="" please="" type="cite">Thank you,</span></td>
		</tr>
		<tr>
			<td>
				<span attached="" background-color:="" blockquote="" find="" font-family:="" font-size:="" for="" invoice="" number:="" open="" order="" please="" type="cite">[COMPANY_NAME]&nbsp;</span></td>
		</tr>
		<tr>
			<td>
				<hr />
			</td>
		</tr>
		<tr>
			<td align="center">
				<span attached="" background-color:="" blockquote="" find="" font-family:="" font-size:="" for="" invoice="" number:="" open="" order="" please="" type="cite">[SITE_NAME] - [SITE_ADDRESS]<br />
				Phone: [SITE_PHONE] - Mob: 0425 327 800 - Email: [SITE_EMAIL]<br />
				Copyright &copy; [YEAR] [SITE_NAME]. All Rights Reserved.</span></td>
				</tr>
			</tbody>
		</table>';
	}

	function getStudentChecklists($sudent_id){

	}


}