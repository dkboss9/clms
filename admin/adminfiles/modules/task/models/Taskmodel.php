<?php
class TaskModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'task';		

	}

	function listallwithproject($project_id){
		$this->db->select("*,t.status as status,t.added_by as added_by,t.task_name,t.task_id,t.start_date,t.end_date");
		$this->db->from("task t");	
		// $this->db->join("task_assigned_user au","au.task_id=t.task_id");
		$this->db->join("users u","u.userid=au.user_id");
		// $this->db->join("lms_project p","p.task_id=t.project_id");
		$this->db->join("task_status ts","ts.status_id=t.task_status");

		if($this->session->userdata["usergroup"] != 1 && $this->session->userdata["usergroup"] != 7 && $this->session->userdata["company_id"] != 0){
			$this->db->where("au.user_id",$this->session->userdata("clms_userid"));
		}
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("t.company_id",$this->session->userdata("clms_company"));
		$this->db->where("t.project_id",$project_id);
		$this->db->order_by('t.task_id','desc');
		$this->db->group_by("t.task_id");
		return $this->db->get("");
	}

	function getProjects(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		return $this->db->get("lms_project")->result();
	}

	function get_Assignedusers($task_id){
		$this->db->select("*")->from("users u");
		$this->db->join("task_assigned_user au","au.user_id=u.userid");
		$this->db->where("au.task_id",$task_id);
		return $this->db->get("")->result();
	}

	function listall($reps="",$status="",$priority="",$start="",$end=""){		
		$this->db->select("t.*,u.*,ts.*,t.task_name as tasktitle,t.status as status,t.added_by as added_by,p.name priority");
		$this->db->from("task t");	
		// $this->db->join("task_assigned_user au","au.task_id=t.task_id");
		$this->db->join("company_users u","u.id=t.assign_to");
		$this->db->join("priority p","p.id=t.priority","left");
		$this->db->join("task_status ts","ts.status_id=t.task_status");

		if($this->session->userdata["usergroup"] != 1 && $this->session->userdata["usergroup"] != 7 && $this->session->userdata["company_id"] != 0){
	
			$this->db->where("au.user_id",$this->session->userdata("clms_userid"));
		}
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("t.company_id",$this->session->userdata("clms_company"));
		if($reps != "")
			$this->db->where("t.assign_to",$reps);
	
		if($status != "")
			$this->db->where("t.task_status",$status);
		if($priority != "")
			$this->db->where("t.priority",$priority);
		if($start != "")
			$this->db->where("start_date >",$start);
		if($end != "")
			$this->db->where("end_date <",$end);
		$this->db->order_by('t.task_id','desc');
		$this->db->group_by("t.task_id");
		return $this->db->get("");
	}

	function get_taskusers($userid,$task_id){
		$this->db->where("user_id",$userid);
		$this->db->where("task_id",$task_id);
		return $this->db->get("task_assigned_user")->num_rows();
	}

	function listalltask($project_id){		
		$this->db->select("*,t.status as status,t.added_by as added_by");
		$this->db->from("task t");	
		$this->db->join("users u","u.userid=t.user_id");
		$this->db->join("task_status ts","ts.status_id=t.task_status");
		$this->db->where("t.project_id",$project_id);
		$this->db->order_by('t.task_id','desc');
		return $this->db->get("");
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($task_id){
		$this->db->select("*");
		$this->db->from($this->table.' t');
		$this->db->join("task_status ts","t.task_status=ts.status_id");
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
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		$this->db->where("user_group",9);
		$this->db->order_by("first_name","asc");
		return $this->db->get("company_users")->result();
	}

	function get_userdetails($userid){
		$this->db->where("id",$userid);
		return $this->db->get("company_users")->row();
	}

	function get_task_status(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		return $this->db->get("task_status")->result();
	}

	function get_updates($taskid){
		$this->db->select("l.update_id,l.content,l.file_name,l.added_date,u.first_name,u.last_name");
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

	function getPriority(){
		$company_id = $this->session->userdata("clms_company");
		$this->db->where("status",1);
		$this->db->where("(company_id = 0 OR company_id=$company_id)");
		return $this->db->get("priority")->result();
	}
}