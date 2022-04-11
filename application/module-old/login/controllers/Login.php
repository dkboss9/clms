<?php
class Login extends MX_Controller{
	function __construct(){
		parent::__construct();
		//date_default_timezone_set('australia/sydney');
		$this->container = 'container';
		$this->load->model('loginmodel');
		$this->load->model('student/studentmodel');
	}	

	function page_not_found(){
		$this->load->view('page_not_found');
	}


	function index(){
		if($this->session->userdata("clms_front_userid")!="" && $this->session->userdata('username')!=""){
			redirect('welcome','location');
		}else{
			if($this->input->get("user") && $this->input->get("user")=="no"){
				$this->load->view('login');
			}else{
				if(isset($_COOKIE["username"])){
					$data["users"] = $this->loginmodel->get_UserDetails();
					$this->load->view('unlock',$data);
				}else
				$this->load->view('login');
			}
		}
	}

	

	function autoemail(){
		$users = $this->db->get("users")->result();
		foreach ($users as $rcust) {
			$header_tasks = $this->loginmodel->get_currenttask($rcust->userid);
			$header_todays = $this->loginmodel->get_todayLeads($rcust->userid);
			$alerts = $this->loginmodel->getalerts();
			$header_events = $this->loginmodel->get_todayEvents($rcust->userid);
			$content = '';
			if(count($header_tasks)>0){
				$content.='Today Tasks:';
				foreach ($header_tasks as $task) {

					$content.='<p><span>Task Title: '.$task->task_name.'</span> | <span>Sales Rep: '.$task->user_name.'</span></p>';

				}
			}

			if(count($header_todays)>0){
				$content.='Today Leads:';
				foreach ($header_todays as $lead) {
					$status = $this->welcomemodel->get_leadstatus($lead->status_id);
					$content.='<p><span>Lead Title: '.$lead->lead_name.'</span> | <span>Sales Rep: '.$lead->user_name.'</span></p>';
				}
			}

			if(count($alerts)>0){
				$content.='Today Alerts:';
				foreach ($alerts as $alert) {
					$content.='<p><span class="title">'.$alert->title.'</span></br>
					<span class="message">'.$alert->content.'</span></p>';
				}
			}

			if(count($header_events)>0){
				$content.='Today Events:';
				foreach ($header_events as $event) {
					$content.='<p><span class="title">'.$event->event_name.'</span></br>
					<span class="message">'.$event->event_details.'</span></p>';

				}
			}

			//echo $content;
			if($content != ''){
				//$content.= date("d/m/Y h:i a");
				//echo $content;
				$customer = $rcust->first_name.' '.$rcust->last_name;   
				$from     = $this->mylibrary->getSiteEmail(32);
				$site_url = $this->mylibrary->getSiteEmail(21);
				$fromname = $this->mylibrary->getSiteEmail(20);
				$address  = $this->mylibrary->getSiteEmail(25);
				$phone    = $this->mylibrary->getSiteEmail(27);
				$fax      = $this->mylibrary->getSiteEmail(28);
				$sitemail = $this->mylibrary->getSiteEmail(23);
				$logo     = $this->mylibrary->getlogo();
				$this->email->set_mailtype('html');
				$this->email->from($sitemail, "Lead Management System");
				$this->email->to($rcust->email);
				//$this->email->to("bikash.suwal01@gmail.com");
				$row = $this->mylibrary->getEmailTemplate(50);
				$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
				$this->email->subject($subject);
				$message = str_replace('[USER_NAME]',$customer,html_entity_decode($row->email_message,ENT_COMPAT));
				$message = str_replace('[SITE_NAME]',$fromname,$message);
				$message = str_replace('[LOGO]',$logo,$message);
				$message = str_replace('[SITE_ADDRESS]',$address,$message);
				$message = str_replace('[SITE_PHONE]',$phone,$message);
				$message = str_replace('[SITE_FAX]',$fax,$message);
				$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
				$message = str_replace('[SITE_URL]',$site_url,$message);
				$message = str_replace('[CONTENT]',$content,$message);
				$message = str_replace('[YEAR]',date('Y'),$message);

				$this->email->message($message);
				$this->email->send();
				$this->email->clear();
			}
			
		}
		

	}

	function checkuser(){
		if($this->session->userdata("clms_front_userid")!="" && $this->session->userdata('username')!=""){
			if($this->session->userdata('usergroup')=='8'){
				redirect('welcome','location');
			}else{
				redirect('welcome','location');
			}
		}else{ 
			if($this->input->post('submit')){ 
				$username = $this->input->post('username');
				$password = md5($this->input->post('password'));
				$this->form_validation->set_rules('username', 'Username', 'required');
				$this->form_validation->set_rules('password', 'Password', 'required');
				if($this->form_validation->run()==FALSE){
					$this->session->set_flashdata('error','Required fields missing');
					$this->load->view('login');
				}else{
					$query = $this->loginmodel->checkuser($username,$password);
				//echo $this->db->last_query();die();
					if($query->num_rows()>0){
						if($this->input->post("rememberme")){ 
							$cusername = $this->input->post('username');
							$cpassword =$this->input->post('password');
						//setcookie("username", $username, time() + 3600, '/');
						//setcookie("password", $this->input->post('password'), time() + 3600, '/');
						}else{ //die('one');
						//setcookie("username", "", time() - 3600, '/');
						//setcookie("password", "", time() - 3600, '/');
					}
					$row = $query->row();
					$value['logdetails']['userid'] 		= $row->userid;
					$value['logdetails']['log_time'] 	= date('Y-m-d H:i:s');
					$value['logdetails']['ip_address'] 	= $this->input->ip_address();
					$this->loginmodel->insertlog($value['logdetails']);
					$lastid = $this->db->insert_id();
					$userdata = array('clms_front_userid'=>$row->userid,'clms_front_chatname'=>$row->user_name,'clms_front_username'=>$row->first_name.' '.$row->last_name,'front_logid'=>$lastid);
					$query->free_result();
					//print_r($userdata); die();
					$this->session->set_userdata($userdata);
					redirect('welcome/','location');
				}else{
					$this->session->set_flashdata('error','Invalid username or password');
					redirect('login','location');
				}
			}
		}
	}
}

function checkpasscode(){
	$passcode = $this->input->post("pwd");
	$username = $_COOKIE["username"];
	$query = $this->loginmodel->checkpasscode($username,$passcode);
	if($query->num_rows()>0){
		$row = $query->row();
		$value['logdetails']['userid'] 		= $row->userid;
		$value['logdetails']['log_time'] 	= date('Y-m-d H:i:s');
		$value['logdetails']['ip_address'] 	= $this->input->ip_address();
		$this->loginmodel->insertlog($value['logdetails']);
		$lastid = $this->db->insert_id();
		$userdata = array('clms_front_userid'=>$row->userid,'username'=>$row->first_name.' '.$row->last_name,'logid'=>$lastid,'usergroup'=>$row->user_group,'clms_front_company'=>$row->company_id);
		$query->free_result();
		if($this->session->set_userdata($userdata)){
			redirect('welcome','location');
		}else{
			redirect('login','location');
		}
	}else{
		$data['error'] = "Invalid Pass Code";
		$data["users"] = $this->loginmodel->get_UserDetails();
		$this->load->view('unlock',$data);
	}
}

		//function logout
function logout(){
	$value['details']['log_off'] = date('Y-m-d H:i:s');
	$userid = $this->session->userdata("clms_front_userid");
	$logid	= $this->session->userdata('logid');
	$this->loginmodel->updatelog($value['details'],$userid,$logid);
	$this->session->unset_userdata('clms_front_userid');
	$this->session->sess_destroy();
	redirect('login','location');
}	



function unlock(){
	$data["users"] = $this->loginmodel->get_UserDetails();
	$this->load->view('unlock',$data);
}


function forgot_password(){
	if($this->input->post("btn-submit")){

		$email = $this->input->post("email");
		$query = $this->loginmodel->checkemail($email);
		if($query->num_rows() >0){
			$user = $query->row();
			$url = base_url("change-password/".$user->uuid);
			$link = '<a href="'.$url.'">Click Here</a>';
			$customer = $user->first_name.' '.$user->last_name;   
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
			$this->email->to($email);
			//$this->email->to("bikash.suwal01@gmail.com");
			$row = $this->mylibrary->getEmailTemplate(57);
			/***** Sms code ******/
			if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1){
				$sms = $row->sms_text;
				$sms = str_replace('[FULL_NAME]',$customer,html_entity_decode($sms,ENT_COMPAT));
				$sms = str_replace('[CHANGE_PASSWORD]',$link,$sms);
				$sms = str_replace('[CODE]','',$sms);
				$sms = str_replace('[SITE_NAME]',$fromname,$sms);
				$sms = str_replace('[LOGO]',$logo,$sms);
				$sms = str_replace('[SITE_ADDRESS]',$address,$sms);
				$sms = str_replace('[SITE_PHONE]',$phone,$sms);
				$sms = str_replace('[SITE_FAX]',$fax,$sms);
				$sms = str_replace('[SITE_EMAIL]',$sitemail,$sms);
				$sms = str_replace('[SITE_URL]',$site_url,$sms);
				$sms = str_replace('[YEAR]',date('Y'),$sms);
				$mobile = $user->mobile;
				if($mobile != "")
					$this->commonmodel->printsms($sms,$mobile);
			}
			/***** Sms code ******/
			$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
			$this->email->subject($subject);
			$message = str_replace('[FULL_NAME]',$customer,html_entity_decode($row->email_message,ENT_COMPAT));
			$message = str_replace('[CHANGE_PASSWORD]',$link,$message);
			$message = str_replace('[CODE]','',$message);
			$message = str_replace('[SITE_NAME]',$fromname,$message);
			$message = str_replace('[LOGO]',$logo,$message);
			$message = str_replace('[SITE_ADDRESS]',$address,$message);
			$message = str_replace('[SITE_PHONE]',$phone,$message);
			$message = str_replace('[SITE_FAX]',$fax,$message);
			$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
			$message = str_replace('[SITE_URL]',$site_url,$message);
			$message = str_replace('[YEAR]',date('Y'),$message);

			$this->email->message($message);
			$this->email->send();
			$this->email->clear();
			redirect("forgot-password?success=1");
		}else{
			$data['userexit'] = $email;
			$this->load->view('forgot_password',$data);
		}

	}else{
		$data['userexit'] = '';
		$this->load->view('forgot_password',$data);
	}
	
}

function change_password($uuid){
	$this->form_validation->set_rules('password', 'Password', 'required');
	$this->form_validation->set_rules('cpassword', 'Password Confirmation', 'required|matches[password]');
	
	if($this->form_validation->run() == false){
		$query = $this->db->where("uuid",$uuid)->get('users');
		$data = array();
		if($query->num_rows() > 0){
			$data['user'] = $query->row();
		}
		$this->load->view("change_password",$data);
	}else{
		$password = $this->input->post("password");
		$this->db->where("uuid",$uuid);
		$this->db->set("password",md5($password));
	//	$this->db->set("updated_at",date("Y-m-d h:i:s"));
		$this->db->update("users");
		$this->session->set_flashdata("success_message","Your password has been changed successfully.");
		redirect("login","location");
	}
}


function change_password_old($uuid){

	$user = $this->db->where("uuid",$uuid)->get("users")->row();
	if(empty($user)){
		$this->session->set_flashdata('error', 'Invalid link');
		redirect("login");
	}

	$this->form_validation->set_rules('password', 'Password', 'required');
	$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

	if($this->form_validation->run()){

		$password = $this->input->post("password");

		$this->db->where("uuid",$uuid)->set("password",md5($password))->update("users");

		$this->session->set_flashdata('success_message', 'New password has been changed successfully.');
	
		redirect("login");
	}else{

		$data['user'] = $user;
		$this->load->view('change_password',$data);
	}

}

function signup($companyid=null,$company_studentid=null){

		if($company_studentid){
			$is_signuped_already = $this->loginmodel->checkIsSignuped($company_studentid);
			if($is_signuped_already){
				redirect("login");
			}
			$this->db->where("uuid",$company_studentid);
			$data['student']=$this->db->get("company_students")->row();
		}

		$this->load->library("uuid");
		$this->load->model("company/companymodel");
		
		$this->form_validation->set_rules('fname','First Name','required');
		$this->form_validation->set_rules('lname','Last Name','required');
		$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('phone','Phone','required');
		$this->form_validation->set_rules('password','Password','required');
		if($this->form_validation->run()!=FALSE){
			$this->db->trans_start();
			$value['details']['uuid']     = $this->uuid->v4();
			$value['details']['first_name']     = $this->input->post('fname');
			$value['details']['last_name']      = $this->input->post('lname');
			$value['details']['email']          = $this->input->post('email');
			$value['details']['phone']          = $this->input->post('phone');
    		//$value['details']['company_name']          = $this->input->post('company');
			$value['details']['user_group']     = 14;
			$value['details']['password']       = md5($this->input->post('password'));
			$value['details']['added_date']     = date('Y-m-d H:i:s');
			//$value['details']['status']         = 1;
			$this->usermodel->insertuser($value['details']);
			$student_id = $this->db->insert_id();

			$this->db->insert("student_details",[
				"student_id" => $student_id
			]);

			$company_student_id = $this->input->post("company_student_id");

			if($company_student_id > 0){
				$this->db->where("uuid",$company_student_id);
				$this->db->set("student_id",$student_id);
				$this->db->update("pnp_company_students");
			}

			$this->db->trans_complete();

			$row = $this->generalsettingsmodel->getConfigData(82)->row();

		
			$this->companymodel->sendEmailActivation($student_id);

			$from 	  = $this->mylibrary->getSiteEmail(22);
			$fromname = $this->mylibrary->getSiteEmail(20);
			$address  = $this->mylibrary->getSiteEmail(59);
			$phone    = $this->mylibrary->getSiteEmail(61);
			$fax      = $this->mylibrary->getSiteEmail(94);
			$sitemail = $this->mylibrary->getSiteEmail(23);
			$logo     = $this->mylibrary->getlogo();
			/****** get new registration template and send email to admin******/
			$row = $this->mylibrary->getEmailTemplate(63);
			$this->email->set_mailtype('html');
			$this->email->from($from, $fromname);
			$this->email->to($sitemail);
			$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
			$this->email->subject($subject);
			$message = str_replace('[USER_FULL_NAME]',$this->input->post("fname").' '.$this->input->post("lname"),html_entity_decode($row->email_message,ENT_COMPAT));
			$message = str_replace('[SITE_NAME]',$fromname,$message);
			$message = str_replace('[ADMIN_NAME]','Admin',$message);
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
			$this->session->set_flashdata('success_message', 'Your account has been successfully created. But the account is awaiting activation. Please Check your email to activate your account.');
			redirect('login/');
		}else{
		
			$data['countries'] = $this->companymodel->getcoutries();
			$data['content'] = $this->loginmodel->getContentDetail(3);
			$data['companyid'] = $companyid;
			$data['company_studentid'] = $company_studentid;
			$this->load->view('signup',$data);
		}
	
}

function activate_user($userid){
	$this->load->model("company/companymodel");
	$this->db->where("uuid",$userid);
	$this->db->set("status",1);
	$this->db->update("users");
	$query = $this->companymodel->getStudentData($userid);

	if($query->num_rows() > 0){ 
		$row = $query->row();
		$value['logdetails']['userid'] 		= $row->userid;
		$value['logdetails']['log_time'] 	= date('Y-m-d H:i:s');
		$value['logdetails']['ip_address'] 	= $this->input->ip_address();
		$this->loginmodel->insertlog($value['logdetails']);
		$lastid = $this->db->insert_id();
		$userdata = array('clms_front_userid'=>$row->userid,'username'=>$row->first_name.' '.$row->last_name,'logid'=>$lastid,'usergroup'=>$row->user_group,'clms_front_company'=>$row->company_id);
		$query->free_result();
		if($this->session->set_userdata($userdata)){
			$this->session->set_flashdata('success_message', 'Your account has been successfully activated.');
			redirect('welcome','location');
		}else{
			redirect('login','location');
		}
	}else{
		redirect('login/');
	}
}

function user_signup($companyid=null,$company_userid=null){
	$type = $this->input->get("type") ?? 14;
	if($company_userid && $type){
		switch($type){
			case 3:
				$table = 'pnp_company_users';
				break;
			case 9:
				$table = 'pnp_company_users';
				break;
			case 10:
				$table = 'pnp_company_users';
				break;
			case 14:
				$table = 'pnp_company_students';
				break;
			case 19:
				$table = 'pnp_head_agents';
				break;
			case 20:
				$table = 'pnp_sub_agents';
				break;
			default:
			$table = 'pnp_company_users';
			
		}

		$is_signuped_already = $this->loginmodel->checkIsUserSignuped($company_userid,$table,$type);
		if($is_signuped_already){
			redirect("login");
		}
		$this->db->where("uuid",$company_userid);
		$data['user']=$this->db->get($table)->row();
	}

	$this->load->library("uuid");
	$this->load->model("company/companymodel");
	
	$this->form_validation->set_rules('fname','First Name','required');
	$this->form_validation->set_rules('lname','Last Name','required');
	$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]');
	$this->form_validation->set_rules('phone','Phone','required');
	$this->form_validation->set_rules('password','Password','required');
	if($this->form_validation->run()!=FALSE){
		$companyuuid = $this->input->post("company_id");
		$type = $this->input->post("type");
		$company_user_id = $this->input->post("company_user_id");
		$company = $this->db->where("uuid",$companyuuid)->get("users")->row();
		//print_r($company);die();
		$value['details']['uuid']     = $this->uuid->v4();
		$value['details']['first_name']     = $this->input->post('fname');
		$value['details']['last_name']      = $this->input->post('lname');
		$value['details']['email']          = $this->input->post('email');
		$value['details']['phone']          = $this->input->post('phone');
		//$value['details']['company_name']          = $this->input->post('company');
		// $value['details']['user_group']     = $type;
		$value['details']['password']       = md5($this->input->post('password'));
		$value['details']['added_date']     = date('Y-m-d H:i:s');
		//$value['details']['status']         = 1;
		$this->usermodel->insertuser($value['details']);
		$userid = $this->db->insert_id();

		if($company_user_id != ""){
			$this->db->where("uuid",$company_user_id);
			if($type==14)
			$this->db->set("student_id",$userid);
			else
			$this->db->set("clms_front_userid",$userid);
			$this->db->update($table);
		}
	
		if($type != ""){
			$this->db->insert("pnp_user_groups",[
				"group_id" => $type,
				"user_id" => $userid,
				"status" => 1,
				"added_date" => date("Y-m-d H:i:s")
				]);

			$user_groupid = $this->db->insert_id();
			if(!empty($company)){
				$this->db->insert("pnp_user_group_company",[
					"user_group_id" => $user_groupid,
					"company_id" => $company->userid
				]);
				$user_group_companyid = $this->db->insert_id();
				$this->loginmodel->insert_group_permissions($user_group_companyid,$type);
			}
		}
	
		$row = $this->generalsettingsmodel->getConfigData(82)->row();

	
		$this->companymodel->sendEmailActivation($userid);

		$from 	  = $this->mylibrary->getSiteEmail(22);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(59);
		$phone    = $this->mylibrary->getSiteEmail(61);
		$fax      = $this->mylibrary->getSiteEmail(94);
		$sitemail = $this->mylibrary->getSiteEmail(23);
		$logo     = $this->mylibrary->getlogo();
		/****** get new registration template and send email to admin******/
		$row = $this->mylibrary->getEmailTemplate(63);
		$this->email->set_mailtype('html');
		$this->email->from($from, $fromname);
		$this->email->to($sitemail);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
		$this->email->subject($subject);
		$message = str_replace('[USER_FULL_NAME]',$this->input->post("fname").' '.$this->input->post("lname"),html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[ADMIN_NAME]','Admin',$message);
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
		$this->session->set_flashdata('success_message', 'Your account has been successfully created. But the account is awaiting activation. Please Check your email to activate your account.');
		redirect('login/');
	}else{
	
		$data['countries'] = $this->companymodel->getcoutries();
		$data['content'] = $this->loginmodel->getContentDetail(3);
		$data['companyid'] = $companyid;
		$data['company_user_id'] = $company_userid;
		$data['type'] = $type;
		$this->load->view('signup',$data);
	}

}

function guest_checkin($uuid){
	$this->load->library("uuid");
	$this->load->model("company/companymodel");

	$this->db->where("uuid",$uuid);
	$company = $this->db->get("users")->row();

	
	$this->form_validation->set_rules('name','Name','required');
	//$this->form_validation->set_rules('lname','Last Name','required');
	$this->form_validation->set_rules('email','Email','required|valid_email');
	$this->form_validation->set_rules('phone','Phone','required');

	if($this->form_validation->run()!=FALSE){
		$userdata = $this->session->userdata("clms_front_userid");
        $date = date("Y-m-d");
		$name = explode(" ",$this->input->post("name"));
        $data_post = $_POST;
        $data['values']['form_post']   = serialize($data_post);
        $data['values']['company_id']      = $this->input->post("company_id");
        $data['values']['lead_name'] 		= $name[0];
        $data['values']['lead_lname']        = $name[1];
        $data['values']['email'] 			= $this->input->post('email');
        $data['values']['phone_number']              = $this->input->post('phone');
        $data['values']['purpose'] 				= $this->input->post('purpose');
        $data['values']['lead_source']              = 38;
		$data['values']['status_id'] 					= 1;
		$data['values']['more_info_added'] 					= 0;
        $data['values']['added_date'] 			= time();
		$data['values']['status'] 					= 1;
		$data['values']['booking_date']              = date("Y-m-d");
		$data['values']['reminder_date']              = time();
		$data['values']['country']              = $this->input->post('country');
		$this->db->insert("leads",$data['values']);
        $leadid = $this->db->insert_id();

        if($this->input->post('status_update') !=""){
            $data['update']['content']              = $this->input->post('status_update');
            $data['update']['lead_id']                 = $leadid;
            $data['update']['added_by']                 = $userdata;
            $data['update']['added_date']           = time();
            $data['update']['modified_by']              = $userdata;
			$data['update']['modified_date']              = time();
			$this->db->insert("lead_update",$data['update']);
        }

       

		/************* send  email to visitor ************/
		
		$customer = $this->input->post("fname").' '. $this->input->post("lname");   
		$from     = $this->mylibrary->getSiteEmail(32);
		$site_url = $this->mylibrary->getSiteEmail(21);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(25);
		$phone    = $this->mylibrary->getSiteEmail(27);
		$fax      = $this->mylibrary->getSiteEmail(28);
		$sitemail = $this->mylibrary->getSiteEmail(23);
		$logo     = $this->mylibrary->getlogo();
		$this->email->set_mailtype('html');
		$this->email->from($sitemail, "Lead Management System");
		$this->email->to($this->input->post("email"));
		$row = $this->mylibrary->getCompanyEmailTemplate(80,$company->company_id);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
		$this->email->subject($subject);
		$message = str_replace('[FULL_NAME]',$customer,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		$message = str_replace('[SITE_URL]',$site_url,$message);
		$message = str_replace('[LEAD_NAME]',$this->input->post('name'),$message);
		$message = str_replace('[LEAD_DETAILS]',$this->input->post('requirement'),$message);
		$message = str_replace('[YEAR]',date('Y'),$message);

		$message = str_replace('[COMPANY_NAME]',$company->company_name,$message);
		$message = str_replace('[COMPANY_ADDRESS]',$company->address,$message); 
		$this->email->message($message);
		$this->email->send();
		$this->email->clear();

		/************* send  email to Consultancy ************/
		
		$customer = $this->input->post("fname").' '. $this->input->post("lname");   
		$from     = $this->mylibrary->getSiteEmail(32);
		$site_url = $this->mylibrary->getSiteEmail(21);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(25);
		$phone    = $this->mylibrary->getSiteEmail(27);
		$fax      = $this->mylibrary->getSiteEmail(28);
		$sitemail = $this->mylibrary->getSiteEmail(23);
		$logo     = $this->mylibrary->getlogo();
		$this->email->set_mailtype('html');
		$this->email->from($sitemail, "Lead Management System");
		$this->email->to($this->input->post("email"));
		$row = $this->mylibrary->getCompanyEmailTemplate(79,$company->company_id);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
		$subject = str_replace('[CUSTOMER_NAME]',$this->input->post("fname").' '.$this->input->post("lname"),$subject);
		$subject = str_replace('[TIME]',date("h:i a"),$subject);
		$this->email->subject($subject);
		$message = str_replace('[FULL_NAME]',$company->first_name.' '.$company->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[CUSTOMER_NAME]',$this->input->post("fname").' '.$this->input->post("lname"),$message);
		$message = str_replace('[TIME]',date("h:i a"),$message);
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		$message = str_replace('[SITE_URL]',$site_url,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);

		$message = str_replace('[COMPANY_NAME]',$company->company_name,$message);
	 	$message = str_replace('[COMPANY_ADDRESS]',$company->address,$message);

		$this->email->message($message);
		$this->email->send();
		$this->email->clear();
        
        $this->session->set_flashdata('success_message', 'Checked in successfully');
        redirect($_SERVER["HTTP_REFERER"]);
		
	}else{
		$this->load->model("lms/lmsmodel");
		$data['countries']      = $this->lmsmodel->get_country();
		$data['purpose'] = $this->loginmodel->get_purpose($company->userid??null);
		$data['company'] = $company;
		$this->load->view('guest_checkin',$data);
	}
}

}
?>
