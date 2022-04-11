<?php
class LoginModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'users';
		$this->tbllog ='userlog';

	}

	function checkuser_new($username,$password){
		$this->db->select("*")
		->from("users u")
		->join("student_details sd","sd.student_id = u.userid")
		->where('email',$username)
		->where('password',$password);
		// $this->db->where('ug.group_id',14);
		return $this->db->where('u.status',1)
		->where('u.verified_at is NOT NULL')->get();
	}

	

		//check valid username and password
	function checkuser($username,$password){
		$this->db->where('email',$username);
		$this->db->where('password',$password);
		$this->db->where('status',1);
		// $this->db->where('user_group',14);
		return $this->db->get($this->table);
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

	function getContentDetail($contentid){
		$this->db->where("content_id",$contentid);
		return $this->db->get("content")->row();
	}

	function checkIsSignuped($studentid){
		$this->db->where("uuid",$studentid);
		$row = $this->db->get("company_students")->row();
		// echo $this->db->last_query(); die();

		$email = $row->email;

		$this->db->where("email",$email);
		$student = $this->db->get("users");

		if($student->num_rows() > 0){
			$student = $student->row();
			$this->db->where("uuid",$studentid);
			$this->db->set("student_id",$student->userid);
				$this->db->update("pnp_company_students");
			return true;
		}else{
			return false;
		}
	}

	function check_alreadyIncompany($userid,$companyid){
			$this->db->select("*")->from("users u");
			$this->db->join("user_groups ug","ug.user_id=u.userid");
			$this->db->join("user_group_company ugc","ugc.user_group_id=ug.id");
			$this->db->where("ugc.company_id",$companyid);
			$this->db->where("u.userid",$userid);
			$result = $this->db->get();

			if($result->num_rows() > 0){
				return true;
			}else{
				return false;
			}
	}

	function checkIsUserSignuped($companyuserid,$table,$type){
		$this->db->where("uuid",$companyuserid);
		$row = $this->db->get($table)->row();
		$email = $row->email;
		$companyid = $row->company_id;

		$this->db->where("email",$email);
		$user = $this->db->get("users");

		if($user->num_rows() > 0){
			$user = $user->row();
			if($this->check_alreadyIncompany($user->userid,$companyid)){ 
				return true;
			} 
			$this->db->where("uuid",$companyuserid);
			if($type==14)
			$this->db->set("student_id",$user->userid);
			else
			$this->db->set("clms_front_userid",$user->userid);
			$this->db->update($table);

			$user_group = $this->db->where("user_id",$user->userid)->where("group_id",$type)->get("pnp_user_groups");
			if($user_group->num_rows() == 0){
				$this->db->insert("pnp_user_groups",[
					"group_id" => $type,
					"user_id" => $user->userid,
					"status" => 1,
					"added_date" => date("Y-m-d H:i:s")
					]);

				$user_groupid = $this->db->insert_id();
				$this->db->insert("pnp_user_group_company",[
					"user_group_id" => $user_groupid,
					"company_id" => $companyid
				]);
				$user_group_companyid = $this->db->insert_id();
				}else{
					$user_group = $user_group->row();
					$user_group_company = $this->db->where([
						"user_group_id" => $user_group->id,
						"company_id" => $companyid
					])->get("pnp_user_group_company");
					if($user_group_company->num_rows() == 0 ){
						$this->db->insert("pnp_user_group_company",[
							"user_group_id" => $user_group->id,
							"company_id" => $companyid
						]);
						$user_group_companyid = $this->db->insert_id();
					}else{
						$user_group_companyid = $user_group_company->row()->id;
					}
				}
				$this->insert_group_permissions($user_group_companyid,$type);
			return true;
		}else{
			return false;
		}
	}

	function get_purpose($companyid){
		$this->db->where("company_id",$companyid);
		$this->db->or_where("company_id",0);
	
		$this->db->order_by("type_name","asc");
		return $this->db->get("purpose")->result();
	}

	function insert_group_permissions($user_group_companyid,$type){
		$this->db->where("user_group_company_id",$user_group_companyid);
		$this->db->delete("pnp_permissions_per_user_group_company");

		$user_group_company = $this->db->where("id",$user_group_companyid)->get("user_group_company")->row();

		$companyid = $user_group_company->company_id;

		$this->db->where("group_id",$type);
		$this->db->where("company_id",$companyid);
		$perms = $this->db->get("pnp_permissions_per_group")->result();
	//	echo $this->db->last_query(); die();

		foreach($perms as $perm){
			$arr = array(
				"module_id" => $perm->module_id,
				"user_action_id" => $perm->user_action_id,
				"user_group_company_id" => $user_group_companyid,
				"added_date" => date("Y-m-d H:i:s"),
				"modified_date" =>  date("Y-m-d H:i:s"),
				"added_by" => $companyid,
				"modified_by" => $companyid
			);
			$this->db->insert("pnp_permissions_per_user_group_company",$arr);
		}

	}

}
?>