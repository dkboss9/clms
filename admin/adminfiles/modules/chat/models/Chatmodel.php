<?php
class chatmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'employee_daily_activity';		

	}

	function getNonchatMembers($chat_member_ids=[]){
		$this->db->select("u.*,g.group_name,
		ugc.id user_group_companyid")
		->from("users u")
		->join("user_groups ug","ug.user_id = u.userid")
		->join('group g',"g.groupid=ug.group_id")
        ->join("pnp_user_group_company ugc","ugc.user_group_id = ug.id");
		$this->db->where("ugc.company_id",$this->session->userdata("clms_company"));
		if(!empty($chat_member_ids))
		 	$this->db->where_not_in("userid",$chat_member_ids);
		return $this->db->where('u.status',1)
		->where('u.verified_at is NOT NULL')->get()->result();
		// $this->db->select("u.*,g.group_name")->from("users u");
		// $this->db->join("group g","g.groupid=u.user_group");
		// if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
		// 	$this->db->where("u.company_id",$this->session->userdata("clms_company"));	
		// if(!empty($chat_member_ids))
		// 	$this->db->where_not_in("userid",$chat_member_ids);
		// return $this->db->get()->result();
	}

	function check_chat_userid($login_userid,$userid){
		$this->db->select("*")->from('chats c');
		$this->db->where("(c.user_ids= '".$login_userid.'#'.$userid."' OR c.user_ids= '".$login_userid.'#'.$userid."')");
		return $this->db->get()->row();
	
	}

	function chat_members($chatid){
		//$this->db->_protect_identifiers=false;
		$this->db->select("concat(u.first_name,' ', u.last_name) as name ,u.userid,g.group_name")->from("pnp_chat_members cm");
		$this->db->join("users u","u.userid=cm.user_id");
	//	$this->db->join("group g","g.groupid=u.user_group");
		$this->db->join("user_groups ug","ug.user_id = u.userid")
		->join('group g',"g.groupid=ug.group_id")
        ->join("pnp_user_group_company ugc","ugc.user_group_id = ug.id");
		$this->db->where("chat_id",$chatid);
		$this->db->group_by("u.userid");
		return $this->db->get()->result_array();
	}

	function chat_members_withuuid($uuid){
		//$this->db->_protect_identifiers=false;
		$this->db->select("concat(u.first_name,' ', u.last_name) as name ,u.userid,g.group_name")->from("pnp_chat_members cm");
		$this->db->join("chats c","c.id=cm.chat_id");
		$this->db->join("users u","u.userid=cm.user_id");
		$this->db->join("user_groups ug","ug.user_id = u.userid");
		$this->db->join('group g',"g.groupid=ug.group_id");
        $this->db->join("pnp_user_group_company ugc","ugc.user_group_id = ug.id");
		$this->db->where("c.uuid",$uuid);
		return $this->db->get()->result_array();
	}

	function chat_messages($chatid,$limit=null){
		//$this->db->_protect_identifiers=false;
		$this->db->select("concat(u.first_name,' ', u.last_name) as name ,u.userid,msg.message,msg.file,msg.created_at")->from("pnp_chat_members cm");
		$this->db->join("users u","u.userid=cm.user_id");
		$this->db->join("chat_messages msg","msg.user_id=cm.user_id");
		$this->db->where("msg.chat_id",$chatid);
		if ($limit != null) {
			$this->db->limit($limit["start"], $limit["end"]);
		}
		$this->db->group_by("msg.id");
		$this->db->order_by("msg.id","desc");
		return $this->db->get();
	}

	function search_group($keyword){
		//$this->db->_protect_identifiers=false;

	
		$this->db->select("concat(u.first_name,' ', u.last_name) as name ,u.userid as id,g.group_name as type")
		->from("users u");
		$this->db->join("user_groups ug","ug.user_id = u.userid");
		$this->db->join('group g',"g.groupid=ug.group_id");
        $this->db->join("pnp_user_group_company ugc","ugc.user_group_id = ug.id");
		$this->db->where("(first_name like '%".$keyword."%' OR last_name like '%".$keyword."%')");
		$this->db->where("ugc.company_id",$this->session->userdata("clms_company"));	
		$this->db->where('u.status',1);
		$this->db->where('u.verified_at is NOT NULL');
		$this->db->get();
		$sql1 = $this->db->last_query();
		$this->db->select("chat_name as name,c.uuid as id,'group' as type")->from("chats c");
		$this->db->join("chat_members cm","cm.chat_id=c.id");
		$this->db->join("users u","u.userid=cm.user_id");
		$this->db->where("(first_name like '%".$keyword."%' OR last_name like '%".$keyword."%' OR chat_name like '%".$keyword."%')");
		$this->db->where("u.company_id",$this->session->userdata("clms_company"));	
		$this->db->group_by("c.id");
		$this->db->get();

		$sql2 = $this->db->last_query();

		$sql = $sql1 . ' UNION ' . $sql2;

		$sql .= ' ORDER BY name ASC'; 
 
		 return $this->db->query($sql)->result();
	}

	function chat_latest_messages($userid,$limit=null){
		$cond = array();

		$sql = "SELECT c.*,pm.message,chat.msg_at,mu.first_name,mu.last_name from pnp_chats c 
		left join pnp_chat_members cm on cm.chat_id = c.id 
		left join pnp_users u on u.userid = cm.user_id 
		left join (
			Select MAX(id) id,chat_id,MAX(created_at) msg_at from pnp_chat_messages group by chat_id order by id desc 
			) chat on chat.chat_id = c.id
		left join pnp_chat_messages pm on pm.id = chat.id
		left join pnp_users mu on mu.userid = pm.user_id
		where cm.user_id = ? ";
		array_push($cond,$userid);

		$sql .= "group by c.id ";

		$sql .= "order by chat.id desc, c.id desc ";
		if ($limit != null) {
			$sql .= "limit ? ";
		
			array_push($cond,$limit["start"]);
		}

		if ($limit != null && $limit["end"]) {
			$sql .= "offset ?";
		
			array_push($cond,intval($limit["end"]));
		}

		
	
		return $this->db->query($sql,$cond);
	}

	function get_unseen_msg($chatid,$userid){
		$sql = "select * from pnp_chat_messages cm 
		 where cm.id not in (select chat_message_id from pnp_chat_message_seen where user_id = $userid and chat_id=$chatid) 
		 and cm.chat_id=$chatid and cm.user_id != $userid";
		 return $this->db->query($sql);
	}

	function makechatseen($chatid,$userid){
		$unseen = $this->get_unseen_msg($chatid,$userid)->result_array();
		$unseen_ids = array_column($unseen,"id");
		foreach($unseen_ids as $id){
			$this->db->insert("chat_message_seen",[
				"chat_message_id" => $id,
				"user_id" => $userid,
				"chat_id" => $chatid,
				"seen_at" => date("Y-m-d H:i:s")
			]);
		}
	}
}