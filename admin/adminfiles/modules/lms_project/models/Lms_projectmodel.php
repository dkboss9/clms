<?php
class Lms_projectModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'lms_project';		

	}

	function listall($reps="",$status="",$start="",$end=""){		
		$this->db->select("*,t.status as status,t.added_by as added_by");
		$this->db->from("lms_project t");	
		//$this->db->join("users u","u.userid=t.user_id");
		$this->db->join("lms_project_status ts","ts.status_id=t.task_status");

		if($this->session->userdata["usergroup"] != 1 && $this->session->userdata["usergroup"] != 7){
			//$this->db->or_where("t.user_id",$this->session->userdata("clms_userid"));
			$this->db->join("lms_project_assigned_user u","u.project_id=t.task_id");
			$this->db->where("u.user_id",$this->session->userdata("clms_userid"));
		}
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("t.company_id",$this->session->userdata("clms_company"));
		if($reps != "")
			$this->db->where("t.user_id",$reps);
		
		if($status != "")
			$this->db->where("t.task_status",$status);
		
		if($start != "")
			$this->db->where("start_date",$start);
		if($end != "")
			$this->db->where("end_date",$end);
		$this->db->order_by('t.task_id','desc');
		return $this->db->get("");
	}

	function get_form(){
		$this->db->where("module_name","Project");
		$this->db->where("company_id",$this->session->userdata("clms_company"));
		return $this->db->get("form");
	}

	function counttask($project_id){
		$this->db->where("project_id",$project_id);
		return $this->db->get("task")->num_rows();
	}

	function countdiscussion($project_id){
		$this->db->where("project_id",$project_id);
		return $this->db->get("lms_project_discussion")->num_rows();
	}

	function countfiles($project_id){
		$this->db->where("project_id",$project_id);
		return $this->db->get("lms_project_files")->num_rows();
	}

	function counttesting($project_id){
		$this->db->where("project_id",$project_id);
		return $this->db->get("lms_project_testing")->num_rows();
	}

	function getProjectAssignUsers($project_id){
		$this->db->select("*")->from("lms_project_assigned_user lu");
		$this->db->join("users u","u.userid=lu.user_id");
		$this->db->where("lu.project_id",$project_id);
		return $this->db->get("")->result();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($task_id){
		$this->db->select("*");
		$this->db->from($this->table.' t');
		$this->db->join("lms_project_status ts","t.task_status=ts.status_id");
		$this->db->where('t.task_id',$task_id);
		$query=$this->db->get();
		return $query;

	}

	function getusers($userid){
		//if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			//$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("userid",$userid);
		return $this->db->get("users")->row();
	}

	function update($task_id, $data){
		$this->db->where('task_id', $task_id);
		$this->db->update($this->table, $data);
	}

	function delete($task_id) {
		$this->db->where('task_id', $task_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('task_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('task_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('task_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function get_users(){
		$this->db->select("*")->from("users u");
		$this->db->join("group g","g.groupid=u.user_group");
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("u.company_id",$this->session->userdata("clms_company"));
		$this->db->where("u.status",1);
		//$this->db->where("user_group",3);
		$this->db->order_by("u.first_name","asc");
		return $this->db->get("")->result();
	}

	function get_userdetails($userid){
		$this->db->where("userid",$userid);
		return $this->db->get("users")->row();
	}

	function get_task_status(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		return $this->db->get("lms_project_status")->result();
	}

	function checkAssignedUser($userid,$projectid){
		$this->db->where("user_id",$userid);
		$this->db->where("project_id",$projectid);
		return $this->db->get("lms_project_assigned_user")->num_rows();
	}

	function get_order_customer($order_id){
		$this->db->select("*")->from("projects p");
		$this->db->join("customers c","p.customer_id=c.customer_id");
		$this->db->where("project_id",$order_id);
		return $this->db->get("")->row();
	}

	function get_orders(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		return $this->db->get("projects")->result();
	}

	function get_updates($taskid){
		$this->db->select("l.update_id,l.content,l.added_date,u.first_name,u.last_name");
		$this->db->from("task_update l");
		$this->db->join("users u","u.userid=l.added_by");
		$this->db->where("l.task_id",$taskid);
		$this->db->order_by("l.update_id","desc");
		return $this->db->get("")->result();
	}

	function gettaskusers($task_id){
		$this->db->where("task_id",$task_id);
		$this->db->where("added_by !=",$this->session->userdata("clms_userid"));
		return $this->db->get("task_update")->result();
	}

	function getdiscussion($project_id){
		$this->db->select("p.*,u.first_name,u.last_name")->from("lms_project_discussion p");
		$this->db->join("users u","u.userid=p.added_by");
		$this->db->where("p.project_id",$project_id);
		return $this->db->get("")->result();
	}

	function getDiscussionDetail($discussionid){
		$this->db->where("discussion_id",$discussionid);
		return $this->db->get("lms_project_discussion")->row();
	}


	function get_discussionupdates($discussionid){
		$this->db->select("d.*,u.first_name,u.last_name");
		$this->db->from("lms_project_discussion d");
		$this->db->join("users u","u.userid=d.added_by");
		$this->db->where("d.parent_id",$discussionid);
		$this->db->order_by("d.discussion_id","desc");
		return $this->db->get("")->result();
		
	}

	function getTestingDiscussion($project_id){
		$this->db->select("p.*,u.first_name,u.last_name")->from("lms_project_testing p");
		$this->db->join("users u","u.userid=p.added_by");
		$this->db->where("p.project_id",$project_id);
		return $this->db->get("")->result();
	}

	function getTestingDetail($testid){
		$this->db->where("test_id",$testid);
		return $this->db->get("lms_project_testing")->row();
	}

	function get_testingupdates($testid){
		$this->db->select("d.*,u.first_name,u.last_name");
		$this->db->from("lms_project_testing d");
		$this->db->join("users u","u.userid=d.added_by");
		$this->db->where("d.parent_id",$testid);
		$this->db->order_by("d.test_id","desc");
		return $this->db->get("")->result();
		
	}

	function getFileDetail($fileid){
		$this->db->where("file_id",$fileid);
		return $this->db->get("lms_project_files")->row();
	}

	function get_fileupdates($fileid){
		$this->db->select("d.*,u.first_name,u.last_name");
		$this->db->from("lms_project_files d");
		$this->db->join("users u","u.userid=d.added_by");
		$this->db->where("d.parent_id",$fileid);
		$this->db->order_by("d.file_id","desc");
		return $this->db->get("")->result();
		
	}

	function getProjectFiles($project_id){
		$this->db->select("p.*,u.first_name,u.last_name")->from("lms_project_files p");
		$this->db->join("users u","u.userid=p.added_by");
		$this->db->where("p.project_id",$project_id);
		return $this->db->get("")->result();
		
	}
}