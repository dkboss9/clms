<?php
class Users extends MX_Controller{
	function __construct(){
		parent::__construct();
		$this->container = 'main';
		$this->load->model('usermodel');
		$this->load->model('users/usermodel');
		$this->module_code = 'MANAGE-USER';
		$this->group_module_code = 'MANAGE-GROUP';
	}
	function index(){
		if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"VIEW")){
			redirect('users/settings','location');
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}				
	}
	/********* add new user **************/
	function add(){
		if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"ADD")){
			if($this->input->post('action') && $this->input->post('action')=='submit'){
				$this->form_validation->set_rules('fname','First Name','required');
				$this->form_validation->set_rules('lname','Last Name','required');
				$this->form_validation->set_rules('role','User Group','required');
				$this->form_validation->set_rules('username','Username','required');
				$this->form_validation->set_rules('email','Email','required|valid_email');
				$this->form_validation->set_rules('phone','Phone','required');
				$this->form_validation->set_rules('password','Password','required');
				if($this->form_validation->run()==FALSE){
					echo "Required field(s) missing";
					exit();
				}else{
					$query = $this->usermodel->checkusername($this->input->post('username'));
					if($query->num_rows()>0){
						echo "Username already exists";
						$query->free_result();
						exit();
					}
					$query = $this->usermodel->checkemail($this->input->post('email'));
					if($query->num_rows()>0){
						echo "Email is already in use";
						$query->free_result();
						exit();
					}
					
					$value['details']['first_name'] 	= $this->input->post('fname');
					$value['details']['last_name'] 		= $this->input->post('lname');
					$value['details']['company_id']      = $this->session->userdata("clms_front_companyid");
					$value['details']['email'] 			= $this->input->post('email');
					$value['details']['phone'] 			= $this->input->post('phone');
					$value['details']['user_group'] 	= $this->input->post('role');
					$value['details']['user_name'] 		= $this->input->post('username');
					$value['details']['password'] 		= md5($this->input->post('password'));
					$value['details']['added_date'] 	= date('Y-m-d H:i:s');
					$value['details']['added_by']		= $this->session->userdata("clms_front_userid");
					$value['details']['status'] 		= 1;
					$this->usermodel->insertuser($value['details']);
					$logs = array(
						"content" => serialize($value['details']),
						"action" => "Add",
						"module" => "Manage User",
						"added_by" => $this->session->userdata("clms_front_userid"),
						"added_date" => time()
						);
					$this->usermodel->insertUserlog($logs);
					echo "yes";

				}
			}
		}else{
			echo "You don't have permission to add user";
		}
	}

	function assign_dashboard(){
		if ($this->session->userdata("clms_front_userid") != "") {
			if($this->input->post("submit")){
				$userid = $this->input->post("user_id");
				$this->db->where("user_id",$userid);
				$this->db->delete("dashboard_users");
				if($this->input->post("section")){
					$sections = $this->input->post("section");
					foreach ($sections as $key => $value) {
						$insert_arr = array("section_id"=>$value,"user_id"=>$userid);
						$this->db->insert("dashboard_users",$insert_arr);
					}
				}
				redirect('users/settings', 'location');
			}else{
				$id = $this->uri->segment(3);
				$data['result'] = $this->usermodel->listDashboardSections();
				$data['userid'] = $id;
				$this->load->view('dashboard_assign', $data);
			}
		} else {
			$this->session->set_flashdata('error', 'Please login with your username and password');
			redirect('login', 'location');
		}
	}

	function assign_company() {
       // if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
		if ($this->session->userdata("clms_front_userid") != "") {
			if($this->input->post("submit")){
				$userid = $this->input->post("user_id");
				$this->db->where("user_id",$userid);
				$this->db->delete("company_assign");
				if($this->input->post("company")){
					$companies = $this->input->post("company");
					foreach ($companies as $key => $value) {
						$insert_arr = array("company_id"=>$value,"user_id"=>$userid);
						$this->db->insert("company_assign",$insert_arr);
					}
				}
				redirect('users/settings', 'location');
			}else{
				$id = $this->uri->segment(3);
				$data['result'] = $this->usermodel->listCompany();
				$data['userid'] = $id;
				$this->load->view('company_assign', $data);
			}
		} else {
			$this->session->set_flashdata('error', 'Please login with your username and password');
			redirect('login', 'location');
		}
	}

		//edit user details
	function edit(){
		if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"EDIT")){
			if($this->input->post('action') && $this->input->post('action')=='update'){
				$userid = $this->input->post('userid');
				$this->form_validation->set_rules('fname','First Name','required');
				$this->form_validation->set_rules('lname','Last Name','required');
				$this->form_validation->set_rules('role','User Group','required');
				$this->form_validation->set_rules('username','Username','required');
				$this->form_validation->set_rules('email','Email Id','required|valid_email');
				if($this->form_validation->run()==FALSE){
					echo "Required field(s) missing";
					exit();
				}else{
					$value['details']['first_name'] 	= $this->input->post('fname');
					$value['details']['last_name'] 		= $this->input->post('lname');
					$value['details']['email'] 			= $this->input->post('email');
					$value['details']['phone'] 			= trim($this->input->post('phone'));
					$value['details']['user_group'] 	= $this->input->post('role');
					$value['details']['user_name'] 		= $this->input->post('username');
					if($this->input->post('password')!=""){
						$value['details']['password'] 	= md5(trim($this->input->post('password')));
					}
					$value['details']['modified_date'] 	= date('Y-m-d H:i:s');
					$value['details']['modified_by']	= $this->session->userdata("clms_front_userid");
					$this->usermodel->updateuser($userid,$value['details']);
					$logs = array(
						"content" => serialize($value['details']),
						"action" => "Edit",
						"module" => "Manage User",
						"added_by" => $this->session->userdata("clms_front_userid"),
						"added_date" => time()
						);
					$this->usermodel->insertUserlog($logs);
					echo "yes";
				}
			}else{
				$userid = $this->input->post('userid');
				$query = $this->usermodel->getuser($userid);
				if($query->num_rows()>0){
					$row = $query->row();
					$data['users']['fname'] 		= $row->first_name;	
					$data['users']['lname'] 		= $row->last_name;	
					$data['users']['email'] 		= $row->email;	
					$data['users']['phone'] 		= $row->phone;	
					$data['users']['username'] 		= $row->user_name;	
					$data['users']['userid'] 		= $row->userid;	
					$query1 =$this->usermodel->listgroup();
					if($query1->num_rows()>0){
						$group = "";
						foreach($query1->result() as $row1):
							$select = ($row->user_group==$row1->groupid)?'selected="selected"':'';
						$group .= '<option value="'.$row1->groupid.'" '.$select.'>'.$row1->group_name.'</option>';
						endforeach;
						$query1->free_result();
						$data['group'] = $group;
					}
					$query->free_result();
					$this->load->view('edituser',$data);					

				}else{
					echo 'no';	
				}
			}
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}		
	}
	
	function delete(){
		if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"DELETE")){
			if($this->input->post('action') && $this->input->post('action')=='delete'){
				$userid = $this->input->post('userid');
				$cond = array("userid"=>$userid);
				$content = $this->usermodel->getDeletedData('users',$cond);
				$logs = array(
					"content" => serialize($content),
					"action" => "Delete",
					"module" => "Manage Users",
					"added_by" => $this->session->userdata("clms_front_userid"),
					"added_date" => time()
					);
				$this->usermodel->insertUserlog($logs);
				$this->usermodel->deleteuser($userid);
				echo 'yes';
			}else{
				echo 'no';
			}
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}
	}

		//activate and deactivate users
	function changestatus(){
		$status = $this->uri->segment(3);
		$userid = $this->uri->segment(4);
		if($status==1){
			$value['details']['status'] = 0;
		}else{
			$value['details']['status'] = 1;
		}
		$this->usermodel->updateuser($userid,$value['details']);
		$this->session->set_flashdata('message','User status changed successfully');
		redirect('users/manage','location');
	}

	/************ list all users **************/
	function settings(){
		if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"VIEW")){
			$config['base_url'] = base_url().'users/settings/';
			$config['uri_segment'] = 3;
			$config['per_page'] = 10;
			$config['cur_tag_open'] = '<span class="active">';
			$config['cur_tag_close'] = '</span>';
			$config['first_link'] = FALSE;
			$config['last_link'] = FALSE;
			$config['display_pages'] = FALSE;
			$config['next_link'] = '<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>';
			$config['prev_link'] = '<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>';
			$config['next_link_disabled'] = '<button type="button" disabled class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>';
			$config['prev_link_disabled'] = '<button type="button" disabled class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>';
			$config['next_tag_open'] = '';
			$config['next_tag_close'] = '';
			$config['prev_tag_open'] = '';
			$config['prev_tag_close'] = '';
			$config['num_tag_open'] = '';
			$config['num_tag_close'] = '';
		
			$query = $this->usermodel->listuser_new();
			//echo $this->db->last_query(); die();
			$data["users"] = $query->result();

			
			$query =$this->usermodel->listgroup();
			if($query->num_rows()>0){
				$group = "";
				foreach($query->result() as $row):
					$group .= '<option value="'.$row->groupid.'">'.$row->group_name.'</option>';
				endforeach;
				$query->free_result();
				$data['group'] = $group;
			}	
			$data['page'] 		= 'settings';
			$this->load->vars($data);
			$this->load->view($this->container);
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}		
	}
	function addgroup() {
		if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
			$action = $_POST['action'];
			if ($action && $action == 'add') {
				$userid = $this->input->post('userid');
				$parentid = $this->input->post('parentid');
				$this->form_validation->set_rules('group', 'Group Name', 'required');
				if ($this->form_validation->run() == FALSE) {
					echo "Required field(s) missing";
					exit();
				} else {
					$value['details']['group_name'] = $this->input->post('group');
					$value['details']['parent_id'] = $this->input->post('parentid') == "" ? NULL : $this->input->post('parentid');
					$value['details']['company_id'] = $this->session->userdata("clms_front_companyid");
					$value['details']['all_data'] = $this->input->post('all_data');
					$value['details']['status'] 	= '1';
					$value['details']['added_date'] = date('Y-m-d');
					$value['details']['added_by'] 	= $this->session->userdata("clms_front_userid");
					$result = $this->usermodel->isGroupName($this->input->post('group'));
					if ($result->num_rows() > 0) {
						echo 'Group Name Already Exist';
						exit();
					}
					$this->usermodel->addGroup($value['details']);
					$groupid = $this->db->insert_id();
					$this->usermodel->setGroup_allData($this->session->userdata("clms_front_companyid"),$groupid,$this->input->post('all_data'));  
					$logs = array(
						"content" => serialize($value['details']),
						"action" => "add",
						"module" => "Manage Group",
						"added_by" => $this->session->userdata("clms_front_userid"),
						"added_date" => time()
						);
					$this->usermodel->insertUserlog($logs);
					echo "yes";
					$this->session->set_flashdata('success_message', 'Group added successfully.');
				}
			}
		} else {
			$this->session->set_flashdata('error', 'Please login with your username and password');
			redirect('login', 'location');
		}
	}

	function editgroup() {
		if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
			if ($this->input->post('action') && $this->input->post('action') == 'update') {
				$userid = $this->session->userdata("clms_front_userid");
				$parentid = $this->input->post("parentid");
				$this->form_validation->set_rules('group', 'Group Name', 'required');
				if ($this->form_validation->run() == FALSE) {
					echo "Required field(s) missing";
					exit();
				} else {
					$value['details']['group_name'] = $this->input->post('group');
					$value['details']['parent_id'] = $this->input->post('parentid') == "" ? NULL : $this->input->post('parentid');
					$value['details']['all_data'] = $this->input->post('all_data');
					$result = $this->usermodel->isGroupName($this->input->post('group'),$_POST['group_id']);
					if ($result->num_rows() > 0) {
						echo 'Group Name Already Exist';
						exit();
					}
					$this->usermodel->updateGroup($value['details'],$_POST['group_id']);   

					$this->usermodel->setGroup_allData($this->session->userdata("clms_front_companyid"),$_POST['group_id'],$this->input->post('all_data'));  
					
				//	echo $this->db->last_query();
					$logs = array(
						"content" => serialize($value['details']),
						"action" => "Edit",
						"module" => "Manage Group",
						"added_by" => $this->session->userdata("clms_front_userid"),
						"added_date" => time()
						);
					$this->usermodel->insertUserlog($logs);                
					echo "yes";
					$this->session->set_flashdata('success_message', 'Group updated successfully.');
				}
			} else {
				$groupid = $this->input->post('groupid');
				$query = $this->usermodel->getGroup($groupid);
				if ($query->num_rows() > 0) {
					$row = $query->row();
					$data['gname'] = $row->group_name;
					$data['all_data'] = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_companyid"),$groupid)->num_rows();
					$data['groupid'] = $row->groupid;
					$data['parent_id'] = $row->parent_id;
					$data['parents'] = $this->db->where("parent_id",null)->get("pnp_group")->result();
					$this->load->view('edit_group',$data);
				}
			}
		} else {
			$this->session->set_flashdata('error', 'Please login with your username and password');
			redirect('login', 'location');
		}
	}

	function deletegroup(){
		if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"DELETE")){
			if($this->input->post('action') && $this->input->post('action')=='delete'){
				$groupid = $this->input->post('groupid');
				$cond = array("groupid"=>$delid);
				$content = $this->usermodel->getDeletedData('group',$cond);
				$logs = array(
					"content" => serialize($content),
					"action" => "Delete",
					"module" => "Manage Group",
					"added_by" => $this->session->userdata("clms_front_userid"),
					"added_date" => time()
					);
				$this->usermodel->insertUserlog($logs);
				$this->usermodel->deleteGroup($groupid);
				echo 'yes';
			}else{
				echo 'no';
			}
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}

	}
    	//Cascasde delete publish and unpublish action
	function cascadeAction() {
		$data 	= $_POST['object'];
		$ids 	= $data['ids'];
		$action = $data['action'];
		foreach ($ids as $key => $delid) {
			$cond = array("userid"=>$delid);
			$content = $this->usermodel->getDeletedData('users',$cond);
			$logs = array(
				"content" => serialize($content),
				"action" => $action,
				"module" => "Manage Users",
				"added_by" => $this->session->userdata("clms_front_userid"),
				"added_date" => time()
				);
			$this->usermodel->insertUserlog($logs); 
		}

		$field  = $data['field'];
		$table  = $data['table'];
		$status  = $data['status_field'];
		$this->usermodel->cascadeAction($ids, $action,$field,$status,$table);
		//echo $this->db->last_query();
	}		
	/************* groups ******************/
	function listgroup(){
		if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->group_module_code,"VIEW")) {
			$config['base_url'] = base_url() . 'grouppermission/listgroup/';
			$config['uri_segment'] = 3;
			$config['per_page'] = 50;
			$config['cur_tag_open'] = '<span class="active">';
			$config['cur_tag_close'] = '</span>';
			$config['first_link'] = FALSE;
			$config['last_link'] = FALSE;
			$config['display_pages'] = FALSE;
			$config['next_link'] = '<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>';
			$config['prev_link'] = '<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>';
			$config['next_link_disabled'] = '<button type="button" disabled class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>';
			$config['prev_link_disabled'] = '<button type="button" disabled class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>';
			$config['next_tag_open'] = '';
			$config['next_tag_close'] = '';
			$config['prev_tag_open'] = '';
			$config['prev_tag_close'] = '';
			$config['num_tag_open'] = '';
			$config['num_tag_close'] = '';
			$query = $this->usermodel->listgroup();
			$config['total_rows'] = $query->num_rows();
			$this->pagination->initialize($config);
			$query->free_result();
			$page = $this->uri->segment(3, 0);
			$limit = array("start" => $config['per_page'], "end" => $page);
			$query = $this->usermodel->listgroup($limit);
			$data["groups"] = $query;
			if ($query->num_rows() > 0) {
				$grouppermissions = '';
				$i = 1;
				foreach ($query->result() as $row):
					$grouppermissions .= '<tr>
				<td>'.$i.'</td>
				<td>' . $row->group_name . '</td>
				<td><a href="'.base_url().'index.php/users/edit_group_perm/' . $row->groupid . '" title="Set Group Permission"><span class="glyphicon glyphicon-th-large"></span></a>
					<a href="" title="Edit Group Details" class="edit" id="'.$row->groupid.'"><span class="glyphicon glyphicon-edit"></span></a></td>';
					$grouppermissions .= '</tr>';
					$i++;
					endforeach;
					$query->free_result();
				}else {
					$grouppermissions = '';
					$grouppermissions .= '<tr><td colspan="3" style="text-align:center;">No records exist.</td></tr>';
				}

				$initial = ($page + 1) > $config['total_rows'] ? $config['total_rows'] : ($page + 1);
				$final = ($page + $config['per_page']);
				$string = $initial . " - " . (($config['total_rows'] > $final) ? $final : $config['total_rows']) . " of " . $config['total_rows'];
				$data['parents'] = $this->db->where("parent_id",null)->get("pnp_group")->result();
				$data['heading'] 	= 'Groups';
				$data['pagenumbers'] = $string;
				$data['grouppermissions'] = $grouppermissions;
				$data['pagination'] = $this->pagination->create_links();
				$data['page'] = 'list';
				$this->load->vars($data);
				$this->load->view($this->container);
			} else {
				$this->session->set_flashdata('error', 'Please login with your username and password');
				redirect('login', 'location');
			}

		}
//---------------------------------edit--------------------------------------
		function edit_group_perm() {
			if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->group_module_code,"EDIT")) {
				if ($this->input->post('txt_permission')) {						
					$chk_permission = $_POST['chk_permission'];
					$login_id = $this->session->userdata("clms_front_userid"); 
					$group_id = $this->uri->segment(3);
					$company_id = $this->session->userdata("clms_front_companyid") == 0 ? NULL : $this->session->userdata("clms_front_companyid");
					$this->usermodel->updategroup_permision($chk_permission, $group_id, $login_id,$company_id);
					$this->usermodel->updategroup_permision_company_group_users($chk_permission, $group_id, $login_id,$company_id);
					$this->session->set_flashdata('success_message', 'Group Permission Saved Successfully.');
					redirect('users/listgroup', 'location');
					
				} else {
					$user_group_company_id = $this->session->userdata("clms_front_user_group_company_id"); 
					$company_id = $this->session->userdata("clms_front_companyid") == 0 ? NULL : $this->session->userdata("clms_front_companyid");
					$group_id = $this->uri->segment(3);
					$parentmodules = $this->usermodel->get_assigned_permissions($user_group_company_id);
					$grouppermissions = '';
					foreach ($parentmodules as $parent_module_row):
							//---------------------For Parent Menu Access---------------------------------						
							$grouppermissions .= '<tr>';
						$grouppermissions .= '<td><strong>'. $parent_module_row['menu_name'] . '</strong></td>';	
						$checkbox_id = $parent_module_row['menuid'] ."_". $parent_module_row['user_action_id'];
						$permission = $this->usermodel->has_group_permission($parent_module_row['menuid'], $parent_module_row['user_action_id'],$group_id,$company_id);
					//	echo $this->db->last_query();
						if($permission)
							$checked = "checked = 'checked'";
						else
							$checked = "";
						$checkbox = "<input value='". $checkbox_id . "' name='chk_permission[]' class='chk_perm' type='checkbox' ". $checked . "/>";
						$grouppermissions .= '<td colspan="4">Access&nbsp;&nbsp;' . $checkbox . '</td>';
						$grouppermissions .= '</tr>';	
							//---------------------End Parent Menu Access---------------------------------

						$qrymodules = $this->usermodel->get_assigned_permissions($user_group_company_id,$parent_module_row['menuid']);
						
						if (count($qrymodules) > 0) {
							foreach ($qrymodules as $module_row):
								$grouppermissions .= '<tr>';
							$grouppermissions .= '<td>'. $module_row['menu_name'] . '</td>';
							$qryuseraction = $this->usermodel->get_assigned_permissions_actions($user_group_company_id,$module_row['menuid']);
						
							if(count($qryuseraction) > 0 ){					
								foreach ($qryuseraction as $action_row):
									$permission = $this->usermodel->has_group_permission($module_row['menuid'], $action_row['user_action_id'], $group_id,$company_id);
								$checkbox_id = $module_row['menuid'] ."_". $action_row['user_action_id'];
								if($permission)
									$checked = "checked = 'checked'";
								else
									$checked = "";
								$checkbox = "<input value='". $checkbox_id . "' class='chk_perm' name='chk_permission[]' type='checkbox' ". $checked . "/>";
								$grouppermissions .= '<td>'.  $action_row['user_action_name']. '&nbsp;&nbsp;' . $checkbox . '</td>';
								endforeach;
							}
							$grouppermissions .= '</tr>';	
							endforeach;	
						}
						endforeach	;
						

						$data['heading'] = "Group Permissions";
						$data['page'] = 'group_modify';
						$data['grouppermissions'] = $grouppermissions;
						$this->load->view('main', $data);
					
				}
			}
		}
		
		//---------------------detail---------------------------------
		function detail() {
			if ($this->session->userdata("clms_front_userid") != "") {
				$group_id = $this->uri->segment(3);
				$qrymodules = $this->usermodel->listmodule();
				$grouppermissions = '';
				if (count($qrymodules) > 0) {
					$grouppermissions .= '<tr>';
					foreach ($qrymodules as $module_row):
						$grouppermissions .= '
					<td>'. $module_row['module_name'] . '</td>';
					$qryuseraction = $this->usermodel->listuseraction();
					if(count($qryuseraction) > 0 ){					
						foreach ($qryuseraction as $action_row):
							$permission = $this->usermodel->checkgroup_permision($module_row['module_id'], $action_row['user_action_id'], $group_id);
						if($permission)
							$permitted = '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>';
						else
							$permitted = '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>';
								//$checkbox = "<input disabled='disabled' type='checkbox'". $checked . "/>";
						$grouppermissions .= '<td>'.  $action_row['user_action_name']. '&nbsp;&nbsp;' . $permitted . '</td>';
						endforeach;
					}
					$grouppermissions .= '</tr>';	
					endforeach;			

					$data['heading'] = "Permissions Details";
					$data['page'] = 'group_detail';
					$data['grouppermissions'] = $grouppermissions;
					$this->load->view('main', $data);
				} else {
					redirect('users/listgroup');
				}
			} else {
				$this->session->set_flashdata('error', 'Please login with your username and password');
				redirect('login', 'location');
			}
		}
		
		/***************  Modify and view user permission **************/
		//---------------------------------edit--------------------------------------
		function perm_modify() {
		if ($this->session->userdata("clms_front_userid") != "" ) {
			$this->load->model("company/companymodel");
			if ($this->input->post('txt_permission')) { 
				$chk_permission = $_POST['chk_permission'];
				$login_id = $this->session->userdata("clms_front_userid");
				$user_group_company_id = $this->uri->segment(3);
				$this->usermodel->updateuser_perm($chk_permission, $user_group_company_id, $login_id);					
				$this->session->set_flashdata('success_message', 'User Permission Saved Successfully.');
				redirect($_SERVER["HTTP_REFERER"], 'location');
				
			} else {
				$user_group_company_id = $this->uri->segment(3);
				
				$user_group = $this->usermodel->getusergroup($user_group_company_id);
			
				$company_user = $this->companymodel->getdata($user_group->user_id);
				$login_user_group_company_id = $this->session->userdata("clms_front_user_group_company_id");
				$parentmodules = $this->usermodel->get_assigned_permissions($login_user_group_company_id);
				$userpermissions = '<tr><td colspan="5"><input type="checkbox" name="check_all" id="check_all">Check All</td></tr>';
				
			//	if (count($parentmodules) > 0) {
					foreach ($parentmodules as $parent_module_row):
								//---------------------Start Parent Menu Access---------------------------------	
						//if($this->usermodel->checkpackage_permision($parent_module_row['menuid'], 1, $package_id) ){
							$userpermissions .= '<tr>';
							$userpermissions .= '<td><strong>'. $parent_module_row['menu_name'] . '</strong></td>';					
						//	$userpermission = $this->usermodel->checkuser_perm($parent_module_row['menuid'], 1, $user_id);
							$userpermission = $this->usermodel->has_user_permission($parent_module_row['menuid'], $parent_module_row['user_action_id'],$user_group_company_id);
							$checkbox_id = $parent_module_row['menuid'] ."_". $parent_module_row['user_action_id'];
							if($userpermission)
								$checked = "checked = 'checked'";
							else
								$checked = "";
								
							$grouppermission = $this->usermodel->has_user_permission($parent_module_row['menuid'], 1,$user_group_company_id);
							if($grouppermission)
								$permitted = '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>';
							else
								$permitted = '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>';

							$checkbox = "<input value='". $checkbox_id . "' name='chk_permission[]' class='chk_perm' type='checkbox' ". $checked . "/>";
							$userpermissions .= '<td colspan="4">'. $permitted . '&nbsp;&nbsp;Access&nbsp;&nbsp;' .$checkbox .'</td>';
								//---------------------End Parent Menu Access---------------------------------
							
							$qrymodules = $this->usermodel->get_assigned_permissions($login_user_group_company_id,$parent_module_row['menuid']);
							if (count($qrymodules) > 0) {
								
								$userpermissions .= '<tr>';
								foreach ($qrymodules as $module_row):
								//	if($this->usermodel->checkmenu_package($module_row['menuid'],$package_id) > 0 ){
										$userpermissions .= '<td>'. $module_row['menu_name'] . '</td>';
										$qryuseraction = $this->usermodel->get_assigned_permissions_actions($login_user_group_company_id,$module_row['menuid']);
										if(count($qryuseraction) > 0 ){					
											foreach ($qryuseraction as $action_row):
												$userpermission = $this->usermodel->has_user_permission($module_row['menuid'], $action_row['user_action_id'],$user_group_company_id);
												$checkbox_id = $module_row['menuid'] ."_". $action_row['user_action_id'];
												if($userpermission)
													$checked = "checked = 'checked'";
												else
													$checked = "";
													
												$grouppermission = $this->usermodel->has_user_permission($module_row['menuid'], $action_row['user_action_id'],$user_group_company_id);
												if($grouppermission)
													$permitted = '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>';
												else
													$permitted = '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>';

												$checkbox = "<input value='". $checkbox_id . "' name='chk_permission[]' class='chk_perm' type='checkbox' ". $checked . "/>";
											
												$userpermissions .= '<td>'. $permitted . '&nbsp;&nbsp;' .  $action_row['user_action_name']. '&nbsp;&nbsp;' .$checkbox .'</td>';

											endforeach;
										}
										$userpermissions .= '</tr>';	
								//	}
								endforeach;		
								
							}
						//}
					endforeach;
					$data['user_id'] = $user_group->user_id;
					$data['heading'] = "User Permissions";
					$data['page'] = 'user_modify';
					$data['userpermissions'] = $userpermissions;
					$this->load->view('main', $data);									
				// }else {
				// 	redirect('users/', 'location');
				// }
			}
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}
	}

		//---------------------detail---------------------------------
				function perm_detail() {
					if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
						$user_id = $this->uri->segment(3);
						$group_id = $this->usermodel->getgroupid($user_id);

						$qrymodules = $this->usermodel->listmodule();		
						$userpermissions = '';			
						if (count($qrymodules) > 0) {
							$userpermissions .= '<tr>';
							foreach ($qrymodules as $module_row):
								$userpermissions .= '
							<td>'. $module_row['module_name'] . '</td>';
							$qryuseraction = $this->usermodel->listuseraction();
							if(count($qryuseraction) > 0 ){					
								foreach ($qryuseraction as $action_row):
									$permission = $this->usermodel->checkuser_perm($module_row['module_id'], $action_row['user_action_id'], $user_id);
								if($permission)
									$checked = "checked = 'checked'";
								else
									$checked = "";
								$grouppermission = $this->usermodel->checkgroup_perm($module_row['module_id'], $action_row['user_action_id'], $group_id);
								if($grouppermission)
									$permitted = '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>';
								else
									$permitted = '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>';

								$checkbox = "<input disabled='disabled' type='checkbox'". $checked . "/>";
								$userpermissions .= '<td>'. $permitted . '&nbsp;&nbsp;' .  $action_row['user_action_name']. '&nbsp;&nbsp;' .$checkbox .'</td>';
								endforeach;
							}
							$userpermissions .= '</tr>';	
							endforeach;			

							$data['heading'] = "User Permissions";
							$data['page'] = 'user_detail';
							$data['userpermissions'] = $userpermissions;
							$this->load->view('main', $data);
						} else {
							redirect('users/', 'location');
						}

					} else {
						$this->session->set_flashdata('error', 'Please login with your username and password');
						redirect('login', 'location');
					}
				}					
			}
			?>