<?php
class LoginModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'users';
		$this->tbllog ='userlog';

	}

		//check valid username and password
/*	function checkuser($username,$password){
		$this->db->where('user_name',$username);
		$this->db->where('password',$password);
		$this->db->where('status',1);
		return $this->db->get($this->table);
	}

	function checkemailuser($email,$password){
		$this->db->where('email',$email);
		$this->db->where('password',$password);
		$this->db->where('status',1);
		return $this->db->get($this->table);
	}
	*/

	function checkuser($username,$password){
		$this->db->where('user_name',$username);
		$this->db->where('password',$password);
		$this->db->where('status',1);
		return $this->db->get($this->table);
	}

	function checkemailuser($username,$password){
		$this->db->where('email',$username);
		$this->db->where('password',$password);
		$this->db->where('status',1);
		$this->db->where('user_group !=',1);
		return $this->db->get($this->table);
	}

	function check_username($username){
		$groups = $this->db->select("u.*")
		->from("users u")
		->join("user_groups ug","ug.user_id = u.userid")
		->join('group g',"g.groupid=ug.group_id")
        // ->join("user_groups ug","ug.group_id = g.groupid")
        ->join("pnp_user_group_company ugc","ugc.user_group_id = ug.id")
        // ->join("users u","u.userid = ugc.company_id")
		->where('user_name',$username)
		->where('u.status',1)
		->where('u.verified_at is NOT NULL')->get();
        // ->where('groupid',7)

		return $groups;
	}

	function checkemailuser_new($username,$password,$company,$group=null){
		$this->db->select("u.*,groupid,group_name,ugc.company_id company_id,company_name,
		ugc.id user_group_companyid")
		->from("users u")
		->join("user_groups ug","ug.user_id = u.userid")
		->join('group g',"g.groupid=ug.group_id")
        // ->join("user_groups ug","ug.group_id = g.groupid")
        ->join("pnp_user_group_company ugc","ugc.user_group_id = ug.id")
        // ->join("users u","u.userid = ugc.company_id")
		->where('email',$username)
		->where('password',$password)
		->where('ugc.company_id',$company);
		if($group)
		$this->db->where('ug.group_id',$group);
		$this->db->where('ug.group_id !=',14);
		return $this->db->where('u.status',1)
		->where('u.verified_at is NOT NULL')->get();
        // ->where('groupid',7)

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

	function get_groups(){
		return $this->db->where("status",1)->where("company_id",0)->get("pnp_group")->result();
	}

	function getContentDetail($contentid){
		$this->db->where("content_id",$contentid);
		return $this->db->get("content")->row();
	}

		//check username
	function checkusername($username){
		$this->db->where('usr_user_name',$username);
		return $this->db->get($this->table);
	}

		//check email
	function checkemail($email){
		$this->db->where('email',$email);
		return $this->db->get($this->table);
	}

		//function insert user log details

	function insertlog($data){
		$this->db->insert($this->tbllog,$data);
	}
		//update user log
	function updatelog($data,$user,$logid){
		$this->db->where('logid',$logid);
		$this->db->where('userid',$user);
		$this->db->update($this->tbllog,$data);
	}		

	function get_currenttask($userid){
		$this->db->select("*");
		$this->db->from("task t");
		$this->db->join("users u","u.userid=t.user_id");
		$this->db->where("t.is_completed",0);
		$this->db->where("t.task_status !=",2);
		if($userid != 23)
			$this->db->where("t.user_id",$userid);
		$this->db->order_by("t.task_id","desc");
		return $this->db->get("")->result();
	}

	function get_todayLeads($userid){
		$this->db->select("*");
		$this->db->from("leads l");
		$this->db->join("users u","u.userid=l.user_id","left");
		$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d') = CURDATE()");
		if($userid != 23)
			$this->db->where("l.user_id",$userid);
		$this->db->order_by("l.reminder_time","asc");
		return $this->db->get("")->result();
	}
	function getalerts(){
		$sql = "SELECT * FROM pnp_announcement  WHERE DATE_FORMAT(FROM_UNIXTIME(`announcement_date`), '%Y-%m-%d') = CURDATE()";
		return $this->db->query($sql)->result();
	}


	function get_todayEvents($userid){
		$this->db->select("*");
		$this->db->from("events e");
		$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`event_date`), '%Y-%m-%d') = CURDATE()");
		if($userid != 23)
			$this->db->where("e.added_by",$userid);
		$this->db->order_by("e.event_time","asc");
		return $this->db->get("")->result();
	}

	function get_UserDetails(){
		$this->db->where("user_name",$_COOKIE["username"]);
		return $this->db->get("users")->row();
	}

	function checkpasscode($username,$passcode){
		$this->db->where("user_name",$username);
		$this->db->where("passcode",$passcode);
		return $this->db->get("users");
	}

	function send_email_verification($userid){
		$user = $this->db->where("userid",$userid)->get("users")->row();
		if(empty($user))
			return;
		$link = '<a href="'.base_url()."activate-account/".$user->uuid.'">Verify Email</a>';
		$from 	  = $this->mylibrary->getSiteEmail(22);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(59);
		$phone    = $this->mylibrary->getSiteEmail(61);
		$fax      = $this->mylibrary->getSiteEmail(94);
		$sitemail = $this->mylibrary->getSiteEmail(23);
		$logo     = $this->mylibrary->getlogo();

		$sitemail = $this->mylibrary->getSiteEmail(23);
		$noreplyemail = $this->mylibrary->getSiteEmail(22);
		/******  send welcome email to company user******/
		$row = $this->mylibrary->getEmailTemplate(86);
		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($noreplyemail, $fromname);
		$this->email->reply_to($sitemail, $fromname);
		$this->email->to($user->email);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
		$this->email->subject($subject);
		$message = str_replace('[FULL_NAME]',$user->first_name.' '.$user->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[ACTIVATION_LINK]',$link,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		$message = str_replace('[USER_EMAIL]',$this->input->post('email'),$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		//$data['mail'] = $message; 
		$this->email->message($message);
		$this->email->send();
		$this->email->clear();
	}

}
?>