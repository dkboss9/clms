<?php
class UserModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'users';
		$this->tbllog ='userlog';
	}

		//check valid username and password
	function checkuser($username,$password){
		$this->db->where('user_name',$username);
		$this->db->where('password',$password);
		$this->db->where('status',1);
		return $this->db->get($this->table);
	}

		//check username
	function checkusername($username){
		$this->db->where('user_name',$username);
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

	function listDashboardSections(){
		return $this->db->get('dashboard')->result();
	}

	function listCompany(){
		$this->db->where("user_group",7);
		$this->db->where("status",1);
		return $this->db->get('users')->result();
	}

	function getAssignedCompany($userid,$company_id){
		$this->db->where("company_id",$company_id);
		$this->db->where("user_id",$userid);
		return $this->db->get("company_assign")->num_rows();
	}

	function getAssignedDashboard($userid,$section_id){
		$this->db->where("section_id",$section_id);
		$this->db->where("user_id",$userid);
		return $this->db->get("dashboard_users")->num_rows();
	}

	function checkpackage_permision($module_id, $user_action_id, $package_id){
		$query = "SELECT 
		fn_CheckPackagePermission(". $module_id .",". $user_action_id .",". $package_id .")
		AS permission
		";
		$result = $this->db->query($query);
		$permission = $result->row();
		return $permission->permission;
	}

	function checkmenu_package($module_id,$package_id){
		$this->db->where("module_id",$module_id);
		$this->db->where("package_id",$package_id);
		return $this->db->get("permissions_per_package")->num_rows();
	}

	function checkperm1($module_code, $user_action_code){
		$login_id = $this->session->userdata("clms_userid");			
		$this->db->select("*")->from("pnp_permissions_per_user p");
		$this->db->join("pnp_user_actions a","a.user_action_id=p.user_action_id");
		$this->db->join("pnp_admin_menu m","m.menuid=p.module_id");
		$this->db->where("m.module_code",$module_code);
		$this->db->where("a.user_action_code",$user_action_code);
		$this->db->where("p.user_id",$login_id);
		$query = $this->db->get();
//	echo $this->db->last_query();
	//$result = $query->row();
		if($query->num_rows() >0){
			return true;
		} else {
			return false;	
		}

	}


		//list user group
	function listgroup($limit = null){
		$this->db->select("g.*,(select group_name from pnp_group where pnp_group.groupid = g.parent_id) parent");
		$this->db->from("group g");
		$this->db->where('g.status',1);
		
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("(g.company_id = $userid OR g.company_id=0)");
		}
	//	(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
		return $this->db->get();
	}

		//insert user detail
	function insertuser($data){
		$this->db->insert($this->table,$data);
	}
		//get user details
	function getuser($userid){
		$this->db->where('userid',$userid);
		return $this->db->get($this->table);
	}
		//updat user details
	function updateuser($userid,$data){
		$this->db->where('userid',$userid);
		$this->db->update($this->table,$data);
	}
		//delete user
	function deleteuser($userid){
		$this->db->where('userid',$userid);
		$this->db->delete($this->table);
	}
		//list all users
	function listuser($limit = null){
		$this->db->select('u.status, user_name, group_name,user_group, first_name,last_name,email,phone,userid');
		$this->db->from('users u');
		$this->db->join('group g','g.groupid=u.user_group');
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("u.company_id",$this->session->userdata("clms_company"));
		else
			$this->db->where("u.company_id",0);
		//$this->db->where('groupid !=',1);
		//$this->db->where('groupid !=',3);
		//$this->db->where('groupid !=',7);
		$this->db->where('u.status !=','2');
		$this->db->order_by('first_name','asc');
		(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
		return $this->db->get();
	}

	function listuser_new($limit = null){
		$this->db->select('u.status, user_name, group_name,user_group, first_name,last_name,email,phone,userid,ugc.id user_group_company_id');
		$this->db->from('users u');
		$this->db->join('user_groups ug',"u.userid=ug.user_id");
		$this->db->join('group g','g.groupid=ug.group_id');
		$this->db->join('user_group_company ugc','ugc.user_group_id=ug.id');
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("ugc.company_id",$this->session->userdata("clms_company"));
	
	//	$this->db->where('u.status !=','2');
		$this->db->order_by('first_name','asc');
		(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
		return $this->db->get();
	}

	function getusergroup($id){
		$this->db->select("*")->from("user_group_company ugc");
		$this->db->join("user_groups ug","ug.id=ugc.user_group_id");
		$this->db->where("ugc.id",$id);
		return $this->db->get()->row();
	}

	function search($group,$limit = null){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->order_by('userid','desc');
		(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
		return $this->db->get();		
	}

	/********** Group ***************/

	function addGroup($data){
		$this->db->insert('group',$data);	
	}

	function updateGroup($data,$groupid){
		$this->db->where('groupid',$groupid);
		$this->db->update('group',$data);	
	}

	function setGroup_allData($company_id,$group_id,$alldata){
		$this->db->where("company_id",$company_id);
		$this->db->where("group_id",$group_id);
		$this->db->delete("pnp_group_all_data");
		if($alldata == 1){
			$this->db->insert("pnp_group_all_data",[
				"company_id" => $company_id,
				"group_id" => $group_id
			]);
		}
	}

	function getGroup_allData($company_id,$group_id){
		$this->db->where("company_id",$company_id);
		$this->db->where("group_id",$group_id);
		return $this->db->get("pnp_group_all_data");
	}

	function getGroup($groupid){
		$this->db->where('groupid',$groupid);
		return $this->db->get('group');	
	}

	function deleteGroup($groupid){
		$this->db->where('groupid',$groupid);
		$this->db->delete('group');	
	}

	function listModulesforEdit($parent_id = '', $permission = array()) {
		$modules = '';
		$i = 1;
		$j = 1;
		$flag = 0;
		($parent_id != '') ? $this->db->where('parent_id', $parent_id) : $this->db->where('parent_id', '0');
		$query = $this->db->get('admin_menu');
		if ($query->num_rows() > 0) {
			$modules .= '<tr><td colspan="2"><b>Permissions to Modules Available</b><td></tr>';
			foreach ($query->result() as $row):
				$flag = 0;
				if (in_array($row->menuid, $permission)) {
					$flag = 1;
					$modules .= '<tr><td colspan="2"><input type="checkbox" checked="checked" class="checkall edit-modules required" id="edit-chk' . $i . '" name="module[]" value="' . $row->menuid . '" onchange="checkparent(\'edit-chk' . $i . '\');" /><span class="padding-left5">' . $row->menu_name.  '</span></td></tr>';
				} else {
					$modules .= '<tr><td colspan="2"><input type="checkbox" class="checkall edit-modules required" id="edit-chk' . $i . '" name="module[]" value="' . $row->menuid . '" onchange="checkparent(\'edit-chk' . $i . '\');" /><span class="padding-left5">' . $row->menu_name . '</span></td></tr>';
				}

				$this->db->where('parent_id', $row->menuid);
				$qsub = $this->db->get('admin_menu');
				if ($qsub->num_rows() > 0) {
					$j = $i;
					$i++;

					foreach ($qsub->result() as $rsub):
						if (in_array($rsub->menuid, $permission)) {
							$modules .= '<tr class="edit-chk edit-chk-checked">
							<td class="padding-left45"><input type="checkbox" checked="checked" class="edit-modules required edit-chk' . $j . '" id="edit-chk' . $i . '" name="module[]" value="' . $rsub->menuid . '" onchange="checkchild(\'edit-chk' . $j . '\')" /><span class="padding-left5">' . $rsub->menu_name . '</span></td>
							</tr>';
						} else {
							$modules .= '<tr class="edit-chk '. ($flag==1?"edit-chk-checked":"") .'">
							<td class="padding-left45"><input type="checkbox" class="edit-modules required edit-chk' . $j . '" id="edit-chk' . $i . '" name="module[]" value="' . $rsub->menuid . '" onchange="checkchild(\'edit-chk' . $j . '\')" /><span class="padding-left5">' . $rsub->menu_name . '</span></td>
							</tr>';
						}

						$i++;
					endforeach;
				} else {
					$i++;
				}

			endforeach;
		}
		return $modules;
	}

	function listModules($parent_id = '') {
		$modules = '';
		$i = 1;
		$j = 1;
		($parent_id != '') ? $this->db->where('parent_id', $parent_id) : $this->db->where('parent_id', '0');
		$query = $this->db->get('admin_menu');
		if ($query->num_rows() > 0) {
			$modules .= '<tr><td colspan="2"><b>Permissions to Modules Available</b><td></tr>';
			foreach ($query->result() as $row):
				$modules .= '<tr><td colspan="2"><input type="checkbox" class="checkall modules required" id="chk' . $i . '" name="module[]" value="' . $row->menuid . '" onchange="checkparent(\'chk' . $i . '\');" /><span class="padding-left5">' . $row->menu_name . '</span></td></tr>';
				$this->db->where('parent_id', $row->menuid);
				$qsub = $this->db->get('admin_menu');
				if ($qsub->num_rows() > 0) {
					$j = $i;
					$i++;
					foreach ($qsub->result() as $rsub):
						$modules .= '<tr class="chk">
						<td class="padding-left45"><input type="checkbox" class="modules required chk' . $j . '" id="chk' . $i . '" name="module[]" value="' . $rsub->menuid . '" onchange="checkchild(\'chk' . $j . '\')" /><span class="padding-left5">' . $rsub->menu_name . '</span></td>
						</tr>';
						$i++;
					endforeach;
				} else {
					$i++;
				}

			endforeach;
		}
		return $modules;
	}


	function setpermission($data){
		$this->db->insert('permission',$data);
	}

	function getpermission($group){
		$this->db->where('groupid',$group);
		return $this->db->get('permission');
	}
	function deletepermission($group){
		$this->db->where('groupid',$group);
		$this->db->delete('permission');
	}	

	function cascadeAction($ids,$action,$field,$status,$table){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
			//$data["$status"]='2';
				$this->db->where_in("userid",$ids);
				$this->db->delete($table, $data);
			} else if($action=="publish"){
				$data["$status"]='1';
				$this->db->where_in("userid",$ids);
				$this->db->update($table, $data);
				$this->usermodel->sendWelcomeMsg($ids);
			} else if($action=="unpublish"){
				$data["$status"]='0';
				$this->db->where_in("userid",$ids);
				$this->db->update($table, $data);
			} else {
				return;
			}

		}
		return;
	}	

	function sendWelcomeMsg($userids){
		foreach($userids as $userid){
			$user = $this->db->where("userid",$userid)->get("users")->row();
			if(empty($user))
				continue;
			$link = '<a href="'.base_url().'">Click Here</a>';
			$from 	  = $this->mylibrary->getSiteEmail(22);
			$fromname = $this->mylibrary->getSiteEmail(20);
			$address  = $this->mylibrary->getSiteEmail(59);
			$phone    = $this->mylibrary->getSiteEmail(61);
			$fax      = $this->mylibrary->getSiteEmail(94);
			$sitemail = $this->mylibrary->getSiteEmail(23);
			$logo     = $this->mylibrary->getlogo();
			/******  send welcome email to company user******/
			$row = $this->mylibrary->getEmailTemplate(87);
			$this->email->set_mailtype('html');
			$sendemail   = $this->mylibrary->getSiteEmail(23);
			$this->email->from($from, $fromname);
			$this->email->reply_to($sendemail, $fromname);
			$this->email->to($user->email);
			$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
			$this->email->subject($subject);
			$message = str_replace('[FULL_NAME]',$user->first_name.' '.$user->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
			$message = str_replace('[SITE_NAME]',$fromname,$message);
			$message = str_replace('[LINK]',$link,$message);
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

	function listuseraction($limit=null){
		$this->db->select('*');
		$this->db->from('pnp_user_actions');
		(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
		$qry_res = $this->db->get();
		$res = $qry_res->result_array();	
		$qry_res->free_result();	
		return $res;
	}
	function listmodule($parent_id = 0,$limit=null){
		$this->db->select('*');
		$this->db->from('admin_menu');
		$this->db->where('parent_id',$parent_id);
		if($this->session->userdata('usergroup')!=1){
			$this->db->where('status','1');
		}
		(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
		$qry_res = $this->db->get();
		$res = $qry_res->result_array();	
		$qry_res->free_result();	
		return $res;	
	}
	function checkgroup_permision($module_id, $user_action_id, $group_id){
		$query = "SELECT 
		fn_CheckGroupPermission(". $module_id .",". $user_action_id .",". $group_id .")
		AS permission
		";
		$result = $this->db->query($query);
		$permission = $result->row();
		return $permission->permission;
	}

	function checkmenu($module_id,$user_id){
		$this->db->where("module_id",$module_id);
		$this->db->where("user_id",$user_id);
		return $this->db->get("permissions_per_user")->num_rows();
	}

	function getgroupname($group_id){
		$this->db->select('group_name');
		$this->db->where('groupid',$group_id);
		$query = $this->db->from('group');
		$result = $this->db->get();
		$group = $result->row();
		return $group->group_name;
	}
	function updategroup_permision($permissions, $group_id, $login_id,$company_id){
		// $this->db->trans_start();
		// $permission_set = '';
		// if(count($permissions)>0){
		// 	$permission_set = implode(",", $permissions);				
		// }
		// $parameters = array($permission_set, $group_id, $login_id);
		// $qry_res = $this->db->query('CALL sp_InsertGroupPermission(?,?,?)', $parameters);
		// $this->db->trans_complete();		

		$this->db->where("group_id",$group_id);
		$this->db->where("company_id",$company_id);
		$this->db->delete("pnp_permissions_per_group");
	
		if(empty($permissions))
		return;

//	print_r($permissions);
		foreach($permissions as $perm){
			$perms = explode("_", $perm);
			$perm_array = [
				"module_id" => $perms[0],
				"user_action_id" => $perms[1],
				"group_id" => $group_id,
				"added_by" => $login_id,
				"added_date" => date("Y-m-d H:i:s"),
				"modified_by" => $login_id,
				"modified_date" => date("Y-m-d H:i:s"),
				"company_id" => $company_id
			];
			$this->db->insert("pnp_permissions_per_group",$perm_array);
		}
	}	

	function updategroup_permision_company_group_users($permissions, $group_id, $login_id,$company_id){
		$user_group_company_ids = $this->db->select("ugc.id user_group_company_id")->from("user_group_company ugc")
		->join("user_groups ug","ug.id=ugc.user_group_id")
		->where("ug.group_id",$group_id)
		->where("ugc.company_id",$company_id)
		->get()->result_array();

		//print_r($user_group_company_ids); die();

		$user_group_company_ids = array_column($user_group_company_ids,"user_group_company_id");
		if(empty($user_group_company_ids))
			return;

		$this->db->where_in("user_group_company_id",$user_group_company_ids);
		$this->db->delete("pnp_permissions_per_user_group_company");

		if(empty($permissions))
			return;

	//	print_r($permissions);
		
		foreach($permissions as $perm){
			$perms = explode("_", $perm);

			foreach($user_group_company_ids as $id){
	
				$perm_array = [
					"module_id" => $perms[0],
					"user_action_id" => $perms[1],
					"user_group_company_id" => $id,
					"added_by" => $login_id,
					"added_date" => date("Y-m-d H:i:s"),
					"modified_by" => $login_id,
					"modified_date" => date("Y-m-d H:i:s")
				];
				$this->db->insert("pnp_permissions_per_user_group_company",$perm_array);
			}
		}
	}
	function checkuser_perm($module_id, $user_action_id, $user_id){
		$query = "SELECT 
		fn_CheckUserPermission(". $module_id .",". $user_action_id .",". $user_id .")
		AS permission
		";
		$result = $this->db->query($query);
		$permission = $result->row();
		return $permission->permission;
	}

	function getusername($user_id){

		$result = $this->db->query("SELECT IFNULL(CONCAT(first_name,' ',last_name), '') AS full_name FROM pnp_users WHERE userid = '". $user_id ."'");
		$user = $result->row();
		return $user->full_name;
	}

	function updateuser_perm($permissions, $user_group_company_id, $login_id){
		$this->db->where("user_group_company_id",$user_group_company_id);
		$this->db->delete("pnp_permissions_per_user_group_company");

		if(empty($permissions))
			return;
		
		foreach($permissions as $perm){
			$perms = explode("_", $perm);
	
			$perm_array = [
				"module_id" => $perms[0],
				"user_action_id" => $perms[1],
				"user_group_company_id" => $user_group_company_id,
				"added_by" => $login_id,
				"added_date" => date("Y-m-d H:i:s"),
				"modified_by" => $login_id,
				"modified_date" => date("Y-m-d H:i:s")
			];
			$this->db->insert("pnp_permissions_per_user_group_company",$perm_array);
		}
	}
	function checkperm_old($module_code, $user_action_code){
	 $login_id = $this->session->userdata("clms_userid");			
		$sql = "SELECT fn_CheckPermissionByLoginId('". $module_code . "','". $user_action_code . "','". $login_id ."') AS permission";
		$query = $this->db->query($sql);
		$result = $query->row();
		if(!$result->permission){
			$this->session->set_flashdata("error", "Unauthorized Access!");
			redirect('dashboard','location');
		} else {
			return true;	
		}

	}

	function checkperm($module_code, $user_action_code){
		$login_user_group_company_id = $this->session->userdata("user_group_companyid");			
		$this->db->select("*")->from("pnp_permissions_per_user_group_company p");
		$this->db->join("pnp_user_actions a","a.user_action_id=p.user_action_id");
		$this->db->join("pnp_admin_menu m","m.menuid=p.module_id");
		$this->db->where("m.module_code",$module_code);
		$this->db->where("a.user_action_code",$user_action_code);
		$this->db->where("p.user_group_company_id",$login_user_group_company_id);
		$query = $this->db->get();

		// echo $this->db->last_query(); die();
		if($query->num_rows() >0 || $this->session->userdata("usergroup") == 1){
			return true;
		} else {
			$this->session->set_flashdata("error", "Unauthorized Access!");
			redirect('dashboard','location');
		}

	}

	

	function checkpermDashboard($module_code, $user_action_code){
		$login_id = $this->session->userdata("clms_userid");			
		$sql = "SELECT fn_CheckPermissionByLoginId('". $module_code . "','". $user_action_code . "','". $login_id ."') AS permission";
		$query = $this->db->query($sql);
		$result = $query->row();
		if(!$result->permission){
			return false;
		} else {
			return true;	
		}

	}

	function verifyclient($user_id){
		$sql = "SELECT fn_VerifyClient('". $user_id ."') AS verification";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result->verification;
	}

	function getgroupid($user_id){
		$this->db->select('user_group');
		$this->db->where('userid',$user_id);
		$query = $this->db->from('pnp_users');
		$result = $this->db->get();
		$group = $result->row();
		return $group->user_group;
	}		

	function getuser_new($user_id){
		$this->db->select('*');
		$this->db->where('userid',$user_id);
		$query = $this->db->from('pnp_users');
		$result = $this->db->get();
		return $result->row();
	}		

	function isGroupName($groupname, $groupid = '0') {
		$this->db->where('group_name', $groupname);
		if($groupid!='0'){
			$this->db->where('groupid <>', $groupid);
		}
		$this->db->where("company_id",$this->session->userdata("clms_company"));
		return $this->db->get('group');
	}		

	function insertUserlog($content){
		$this->db->insert("logs",$content);
	}	

	function getDeletedData($table,$cond){
		$this->db->where($cond);
		return $this->db->get($table)->row();
	}

	function get_assigned_permissions($user_group_company_id=null,$parent_id=0){
		$this->db->select("a.*,p.user_action_id")->from("permissions_per_user_group_company p");
		$this->db->join("admin_menu a","a.menuid=p.module_id");
		$this->db->where("a.parent_id",$parent_id);
		if($user_group_company_id)
		$this->db->where("p.user_group_company_id",$user_group_company_id);
		$this->db->group_by("a.menuid");
		return $this->db->get()->result_array();
	}

	function get_assigned_permissions_actions($user_group_company_id=null,$menu_id){
		$this->db->select("ua.*,p.user_action_id")->from("permissions_per_user_group_company p");
		$this->db->join("pnp_user_actions ua","ua.user_action_id=p.user_action_id");
		$this->db->where("p.module_id",$menu_id);
		if($user_group_company_id)
		$this->db->where("p.user_group_company_id",$user_group_company_id);
		$this->db->group_by("ua.user_action_id");
		return $this->db->get()->result_array();
	}

	
	function has_group_permission($menuid,$user_action_id,$group_id,$company_id){
		$this->db->where("module_id",$menuid);
		$this->db->where("user_action_id",$user_action_id);
		$this->db->where("group_id",$group_id);
		$this->db->where("company_id",$company_id);
		$query =  $this->db->get("pnp_permissions_per_group");
		if($query->num_rows() >0)
			return true;
		else	
			return false;
	}

	function has_user_permission($menuid,$user_action_id,$user_group_company_id){
		$this->db->where("module_id",$menuid);
		$this->db->where("user_action_id",$user_action_id);
		$this->db->where("user_group_company_id",$user_group_company_id);
		$query =  $this->db->get("pnp_permissions_per_user_group_company");
		if($query->num_rows() >0)
			return true;
		else	
			return false;
	}

}
?>