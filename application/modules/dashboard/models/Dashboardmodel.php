<?php
class Dashboardmodel extends CI_Model{
	function __construct(){
		parent::__construct();

	}	
	function getuser($user_id){
		$this->db->where('userid',$user_id);
		return $this->db->get('users');	
	}

	function getTodo(){
		$this->db->where("user_id",$this->session->userdata("clms_front_userid"));
		return $this->db->get("todotask")->result();
	}

	function gettodotasks($archived = 0){
		$this->db->where("user_id",$this->session->userdata("clms_front_userid"));
		$this->db->where("is_archived",$archived);
		return $this->db->get("pnp_todotask")->result();
	}

	function getCompanyDetails($company_id){
		$this->db->select("*")->from("users u");
		$this->db->join("company_details cd","u.userid=cd.company_id");
		$this->db->where("u.userid",$company_id);
		return $this->db->get("")->row();
	}

	function getActiveTodo(){
		$this->db->where("user_id",$this->session->userdata("clms_front_userid"));
		$this->db->where("status",0);
		return $this->db->get("todotask")->result();
	}

	function get_tasklogs($id){
		$this->db->select("th.*,u.first_name,u.last_name");
		$this->db->from("task_history th");
		$this->db->join("todotask t","t.id = th.todo_id");
		$this->db->join("users u","u.userid = th.user_id");
		$this->db->where("th.todo_id",$id);
		return $this->db->get();
	}

	function addtaskhistory($taskid,$action){
		$log = array(
			"todo_id" => $taskid,
			"action" => $action,
			"user_id" => $this->session->userdata("clms_front_userid"),
			"actioned_date" => date("Y-m-d")
		);
		$this->db->insert("task_history",$log);
	}



	function gettodotasks_cron($archived = 0,$company_id){
		$this->db->where("user_id",$company_id);
		$this->db->where("is_archived",$archived);
		return $this->db->get("pnp_todotask")->result();
	}

	function getProjects(){
		$this->db->select("*,t.status as status,t.added_by as added_by");
		$this->db->from("lms_project t");	
		//$this->db->join("users u","u.userid=t.user_id");
		$this->db->join("lms_project_status ts","ts.status_id=t.task_status");

		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			//$this->db->or_where("t.user_id",$this->session->userdata("clms_front_userid"));
			$this->db->join("lms_project_assigned_user u","u.project_id=t.task_id");
			$this->db->where("u.user_id",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("t.company_id",$this->session->userdata("clms_front_companyid"));
		
		$this->db->order_by('t.task_id','desc');
		return $this->db->get("")->result();
	}

	function updateuser($user_id,$data){
		$this->db->where('userid',$user_id);
		$this->db->update('users',$data);
	}	

	function count_leads($catid = null)   {
		if(isset($catid))
			$this->db->where("category",$catid);
		if($this->session->userdata("clms_front_user_group") != 1)
			$this->db->where("user_id",$this->session->userdata("clms_front_userid"));
		return $this->db->get("leads")->num_rows();
	}	

	function get_chatNote(){
		$this->db->select("*,c.added_date added_date");
		$this->db->from("chat_note c");
		$this->db->join("users u","u.userid=c.added_by");
		if($this->session->userdata("clms_front_companyid"))
			$this->db->where("c.company_id",$this->session->userdata("clms_front_companyid"));

		$this->db->order_by("c.note_id","desc");
		return $this->db->get("")->result();

	}

	function get_notifications(){
		$userid = $this->session->userdata("clms_front_userid");
		$this->db->select("*,n.id as noteid");
		$this->db->from("notifications n");
		$this->db->join("lms_project p","p.task_id = n.project_id");
		$this->db->join("lms_project_assigned_user u","u.project_id=p.task_id");
		$this->db->where("u.user_id",$this->session->userdata("clms_front_userid"));
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("n.id not in (select notification_id from pnp_notifications_project where user_id = $userid)");
		$this->db->order_by("n.id","desc");
		return $this->db->get("")->result();
	}

	function get_projectNotifications(){
		$userid = $this->session->userdata("clms_front_userid");
		$this->db->select("*,n.id as noteid");
		$this->db->from("notifications n");
		$this->db->join("lms_project p","p.task_id = n.project_id");
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$this->db->join("lms_project_assigned_user u","u.project_id=p.task_id");
			$this->db->where("u.user_id",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		//$this->db->where("n.id not in (select notification_id from pnp_notifications_project where user_id = $userid)");
		$this->db->order_by("n.id","desc");
		return $this->db->get("")->result();
	}

	function get_taskNotifications($limit=""){
		$userid = $this->session->userdata("clms_front_userid");
		$this->db->select("t.*,u.*,t.status as status,t.added_by as added_by");
		$this->db->from("task t");	
		$this->db->join("company_users cu","cu.id=t.assign_to");
		$this->db->join("users u","u.userid=cu.clms_front_userid");
		$this->db->where("t.task_status !=",2);
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			//$this->db->where("t.user_id",$this->session->userdata("clms_front_userid"));
			$this->db->where("u.userid",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("t.company_id",$this->session->userdata("clms_front_companyid"));
		//$this->db->where("t.task_id not in (select task_id from pnp_notifications_task where user_id = $userid)");
		if($limit != "")
			$this->db->limit($limit);

		$this->db->order_by("t.task_id","desc");
		$this->db->group_by("t.task_id");
		return $this->db->get("")->result();
	}

	function get_currenttask($limit=""){
		$userid = $this->session->userdata("clms_front_userid");
		$this->db->select("t.*,u.*,t.status as status,t.added_by as added_by");
		$this->db->from("task t");	
		$this->db->join("company_users cu","cu.id=t.assign_to");
		$this->db->join("users u","u.userid=cu.clms_front_userid");
		$this->db->where("t.task_status !=",2);
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			//$this->db->where("t.user_id",$this->session->userdata("clms_front_userid"));
			$this->db->where("u.userid",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("t.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("t.task_id not in (select task_id from pnp_notifications_task where user_id = $userid)");
		if($limit != "")
			$this->db->limit($limit);

		$this->db->order_by("t.task_id","desc");
		$this->db->group_by("t.task_id");
		return $this->db->get("")->result();
	}

	function not_assigntask($limit=""){
		$this->db->select("t.*,u.*,p.task_name as projectname,p.task_id as projectid,t.status as status,t.added_by as added_by");
		$this->db->from("task t");	
		$this->db->join("task_assigned_user au","au.task_id=t.task_id");
		$this->db->join("users u","u.userid=au.user_id");
		$this->db->join("lms_project p","p.task_id=t.project_id");
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			//$this->db->where("t.user_id",$this->session->userdata("clms_front_userid"));
			$this->db->where("au.user_id",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("t.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("t.is_completed",0);
		$this->db->where("t.task_status",2);
		$this->db->order_by("t.task_id","desc");
		$this->db->group_by("t.task_id");
		if($limit != "")
			$this->db->limit($limit);
		return $this->db->get("")->result();
	}

	function get_Archivedtask($limit=""){
		$this->db->select("t.*,u.*,p.task_name as projectname,p.task_id as projectid,t.status as status,t.added_by as added_by");
		$this->db->from("task t");	
		$this->db->join("users u","u.userid=t.user_id");
		$this->db->join("lms_project p","p.task_id=t.project_id");
		$this->db->where("t.is_completed",1);
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$this->db->where("t.user_id",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("t.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->order_by("t.task_id","desc");
		if($limit != "")
			$this->db->limit($limit);
		return $this->db->get("")->result();
	}

	function get_todayLeads($date = ''){
		$this->db->select("*");
		$this->db->from("leads l");
		$this->db->join("company_users cu","cu.id=l.user_id",'left');
		$this->db->join("users u","u.userid=cu.clms_front_userid",'left');
		if($date != '')
			$this->db->where("l.reminder_date",$date);
		else
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d') = CURDATE()");
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7)
			$this->db->where("u.userid",$this->session->userdata("clms_front_userid"));
		// else
		// 	$this->db->where("l.user_id > ",0);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->order_by("l.reminder_time","asc");
		return $this->db->get("")->result();
	}

	function get_activeLeads($date = ''){
		$this->db->select("*");
		$this->db->from("leads l");
		$this->db->join("users u","u.userid=l.user_id","left");
		if($date != '')
			$this->db->where("l.reminder_date",$date);
		else
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d') >= CURDATE()");
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7)
			$this->db->where("l.user_id",$this->session->userdata("clms_front_userid"));
		else
			$this->db->where("l.user_id > ",0);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status_id",2);
		$this->db->order_by("l.reminder_time","asc");
		return $this->db->get("")->result();
	}

	function get_yesterdayLeads($yesterday=null){

		$this->db->select("*");
		$this->db->from("leads l");
		$this->db->join("company_users cu","cu.id=l.user_id",'left');
		$this->db->join("users u","u.userid=cu.clms_front_userid",'left');

		if($yesterday){
			$date = date("Y-m-d",strtotime("-1 days"));
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d') = '".$date."'");
		}else
			$this->db->where("l.reminder_date < UNIX_TIMESTAMP(CURDATE())");
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7)
			$this->db->where("u.userid",$this->session->userdata("clms_front_userid"));
		else
			$this->db->where("l.user_id > ",0);
		$this->db->where("l.status_id not in (3,4)");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->order_by("l.reminder_time","asc");
		return $this->db->get("")->result();
	}

	function get_todayEvents($date,$reminded = ""){
		$this->db->select("*");
		$this->db->from("events e");
		$this->db->where("e.event_status",5);
		$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`event_date`), '%Y-%m-%d') = CURDATE()");
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$this->db->where("e.added_by",$this->session->userdata("clms_front_userid"));
		}

		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("e.company_id",$this->session->userdata("clms_front_companyid"));
		if($reminded != "")
			$this->db->where("is_reminded",$reminded);
		$this->db->order_by("e.event_time","asc");
		return $this->db->get("")->result();
	}

	function get_leadstatus($id){
		$this->db->where("status_id",$id);
		$this->db->where("status",1);
		return $this->db->get("lead_status")->row();
	}

	function get_notAssignLeads(){
		$this->db->select("*");
		$this->db->from("leads l");
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$this->db->or_where("l.added_by",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("l.user_id",0);
		$this->db->order_by("l.lead_id","desc");
		return $this->db->get("")->result();
	}

	function getalerts(){
		$sql = "SELECT * FROM pnp_announcement  WHERE DATE_FORMAT(FROM_UNIXTIME(`announcement_date`), '%Y-%m-%d') = CURDATE()";
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and company_id =".$this->session->userdata("clms_front_companyid");
		return $this->db->query($sql)->result();
	}

	function count_todayLead(){
		$sql = "SELECT l.lead_id, COUNT(*) AS times FROM pnp_leads l WHERE DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d') = CURDATE()";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (l.user_id='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_yesterdayLead(){
		$sql = "SELECT l.lead_id, COUNT(*) AS times FROM pnp_leads l WHERE l.reminder_date >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY)) AND l.reminder_date < UNIX_TIMESTAMP(CURDATE())";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (l.user_id='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_weekLead(){
		$sql = "SELECT l.lead_id, COUNT(*) AS times FROM pnp_leads l WHERE WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d'))=WEEKOFYEAR(NOW())";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (l.user_id='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_monthLead(){
		$sql = "SELECT l.lead_id, COUNT(*) AS times FROM pnp_leads l WHERE  MONTH(DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d'))=MONTH(NOW())";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (l.user_id='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_todayAddedLead(){
		$sql = "SELECT l.lead_id, COUNT(*) AS times FROM pnp_leads l WHERE DATE_FORMAT(FROM_UNIXTIME(`added_date`), '%Y-%m-%d') = CURDATE()";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (l.user_id='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_yesterdayAddedLead(){
		$sql = "SELECT l.lead_id, COUNT(*) AS times FROM pnp_leads l WHERE l.added_date >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY)) AND l.added_date < UNIX_TIMESTAMP(CURDATE())";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (l.user_id='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_weekAddedLead(){
		$sql = "SELECT l.lead_id, COUNT(*) AS times FROM pnp_leads l WHERE WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(`added_date`), '%Y-%m-%d'))=WEEKOFYEAR(NOW())";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (l.user_id='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_monthAddedLead(){
		$sql = "SELECT l.lead_id, COUNT(*) AS times FROM pnp_leads l WHERE  MONTH(DATE_FORMAT(FROM_UNIXTIME(`added_date`), '%Y-%m-%d'))=MONTH(NOW())";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (l.user_id='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_todaySale(){
		$sql = "SELECT SUM(total) AS times FROM pnp_projects l WHERE DATE_FORMAT(FROM_UNIXTIME(`added_date`), '%Y-%m-%d') = CURDATE()";

		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			//$sql.=" and (l.sales_rep ='".$this->session->userdata("clms_front_userid")."' OR (l.added_by='".$this->session->userdata("clms_front_userid")."'";
			$sql.=" and (l.sales_rep='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");

		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_yesterdaySale(){
		$sql = "SELECT SUM(total) AS times FROM pnp_projects l WHERE l.added_date >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY)) AND l.added_date < UNIX_TIMESTAMP(CURDATE())";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (l.sales_rep='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_weekSale(){
		$sql = "SELECT SUM(total) AS times FROM pnp_projects l WHERE WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(`added_date`), '%Y-%m-%d'))=WEEKOFYEAR(NOW())";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (l.sales_rep='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
		$row = $this->db->query($sql)->row();
		return $row->times;
	} 

	function count_monthSale($lead_type=""){
		$sql = "SELECT SUM(total) AS times FROM pnp_projects l WHERE  MONTH(DATE_FORMAT(FROM_UNIXTIME(`added_date`), '%Y-%m-%d'))=MONTH(NOW())";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (l.sales_rep='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
		if($lead_type != "")
			$sql.=" and l.lead_type=".$lead_type;
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_monthCommission($lead_type=""){
		$sql = "SELECT SUM(commission) AS times FROM pnp_projects l WHERE  MONTH(DATE_FORMAT(FROM_UNIXTIME(`added_date`), '%Y-%m-%d'))=MONTH(NOW())";
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$sql.=" and (l.sales_rep='".$this->session->userdata("clms_front_userid")."') OR (l.added_by='".$this->session->userdata("clms_front_userid")."')";
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id =".$this->session->userdata("clms_front_companyid");
		if($lead_type != "")
			$sql.=" and l.lead_type=".$lead_type;
		$row = $this->db->query($sql)->row();
		return $row->times;
	}

	function count_Projects($id){
		$this->db->where("project_status",$id);
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$this->db->where("sales_rep",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));

		return $this->db->get("projects")->num_rows();
	}

	function count_ProjectType($type){
		$this->db->where("lead_type",$type);
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$this->db->where("sales_rep",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		return $this->db->get("projects")->num_rows();
	}



	function count_weekProject(){
		$sql = "SELECT l.project_id, COUNT(*) AS times FROM pnp_projects l WHERE WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(`end_date`), '%Y-%m-%d'))=WEEKOFYEAR(NOW())";
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$sql.=" and l.company_id=".$this->session->userdata("clms_front_companyid");
		$row = $this->db->query($sql)->row();
		return $row->times;
	}



	function count_leadsStatus($status){
		$this->db->where("status_id",$status);
		if($this->session->userdata("clms_front_user_group") != 1)
			$this->db->where("user_id",$this->session->userdata("clms_front_userid"));
		$query = $this->db->get("leads");
		return $query->num_rows();
	}

	function get_alltask(){
		$this->db->where("status",1);
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$this->db->where("added_by",$this->session->userdata("clms_front_userid"));
			$this->db->or_where("user_id",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		return $this->db->get("task")->result();
	}

	function get_alllead(){
		$this->db->where("status",1);
		if($this->session->userdata("clms_front_user_group") != 1 && $this->session->userdata("clms_front_user_group") != 7){
			$this->db->where("added_by",$this->session->userdata("clms_front_userid"));
			$this->db->or_where("user_id",$this->session->userdata("clms_front_userid"));
		}
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		return $this->db->get("leads")->result();
	}

	function listallLeadType(){		
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->where("parent_id",0);
		$this->db->order_by('cat_id','desc');
		return $this->db->get("lead_category");
	}

	function listallLeadStatus(){		
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->order_by('status_id','desc');
		return $this->db->get("lead_status");
	}

	function listallProjectStatus(){		
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->order_by('status_id','desc');
		return $this->db->get("project_status");
	}

	function listporjectType(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->order_by('type_id','desc');
		return $this->db->get("lead_type");
	}

	function getUsers(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		$this->db->where("userid !=",$this->session->userdata("clms_front_userid"));
		$this->db->order_by("first_name","asc");
		return $this->db->get("users")->result();

	}

	function getOnlineUsers($userid){
		$this->db->select("log_off")->from("userlog");
		$this->db->where("userid",$userid);
		$this->db->order_by("logid","desc");
		return $this->db->get();
	}

	function countInvoice($status = '',$student_id=null){
		$this->db->select("*,i.status status,u.company_name")->from("order i");	
		$this->db->join("users c","c.userid = i.company_id");
		$this->db->join("company_students u","u.id = i.customer_id");
		$this->db->join("company_student_details s","u.id = s.company_student_id");
		$this->db->join("invoice_status ins","ins.status_id=i.invoice_status");
		$this->db->where("u.email",$this->session->userdata("clms_front_email"));
		if($status != '')
			$this->db->where("invoice_status",$status);
		
		$this->db->order_by('i.order_id','desc');
		return $this->db->get("")->num_rows();

	}

	function getEnroll($time,$student_id=null){
		$this->db->select("*")->from("projects p");
		$this->db->join("enroll e","p.project_id=e.order_id");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		if($time == 'next_month'){
			$start_date = date("Y-m-01", strtotime('next month'));
			$end_date = date("Y-m-t", strtotime('next month'));
			$this->db->where("p.commence_date >=",$start_date);
			$this->db->where("p.commence_date <=",$end_date);
		}elseif($time == 'month'){
			$start_date = date("Y-m-01", strtotime('this month'));
			$end_date = date("Y-m-t", strtotime('this month'));
			$this->db->where("p.commence_date >=",$start_date);
			$this->db->where("p.commence_date <=",$end_date);
		}else{
			$this->db->where("p.commence_date",date("Y-m-d"));
		}

		if($student_id){
			$this->db->where("e.student_id",$student_id);
		}

		return $this->db->get();
	}

	function getTopReferre(){
		$this->db->select("count(project_id) as num,sales_rep,first_name,last_name");
		$this->db->from("projects p");
		$this->db->join("users u","u.userid=p.sales_rep");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$start_date = date("Y-m-01", strtotime('this month'));
		$end_date = date("Y-m-t", strtotime('this month'));
		$this->db->where("commence_date >=",$start_date);
		$this->db->where("commence_date <=",$end_date);
		$this->db->group_by("sales_rep");
		$this->db->order_by("num","desc");
		return $this->db->get("")->row();
	}

	function getTopcollege(){
		$this->db->select("count(project_id) as num,college,type_name");
		$this->db->from("projects p");
		$this->db->join("enroll e","e.order_id = p.project_id");
		$this->db->join("college c","c.type_id = e.college");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$start_date = date("Y-m-01", strtotime('this month'));
		$end_date = date("Y-m-t", strtotime('this month'));
		$this->db->where("commence_date >=",$start_date);
		$this->db->where("commence_date <=",$end_date);
		$this->db->group_by("e.college");
		$this->db->order_by("num","desc");
		return $this->db->get("")->row();
	}

	function getTopConsultant(){
		$this->db->select("count(p.project_id) as num,employee_id,first_name,last_name");
		$this->db->from("projects p");
		$this->db->join("project_employee pe","pe.project_id=p.project_id");
		$this->db->join("users u","u.userid=pe.employee_id");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$start_date = date("Y-m-01", strtotime('this month'));
		$end_date = date("Y-m-t", strtotime('this month'));
		$this->db->where("commence_date >=",$start_date);
		$this->db->where("commence_date <=",$end_date);
		$this->db->group_by("employee_id");
		$this->db->order_by("num","desc");
		return $this->db->get("")->row();
	}

	function getStudentNotifications($status=''){
		if($status != '')
			$this->db->where("status",$status);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("to_id",$this->session->userdata("clms_front_companyid"));
		$this->db->order_by("id","desc");
		$this->db->limit(5);
		return $this->db->get("student_notifications");
	}
}
?>