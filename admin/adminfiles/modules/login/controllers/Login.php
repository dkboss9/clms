<?php
require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php');
class Login extends MX_Controller{
	function __construct(){
		parent::__construct();
		//date_default_timezone_set('australia/sydney');
		$this->container = 'container';
		$this->load->model('loginmodel');
		$this->load->model('company/companymodel');
	}	

	function page_not_found(){
		$this->load->view('page_not_found');
	}


	function index(){
		if($this->session->userdata("clms_userid")!="" && $this->session->userdata('username')!=""){ 
			redirect('dashboard','location');
		}else{
			$data = [];
			if($this->input->get("user") && $this->input->get("user")=="no"){
				$this->load->view('login_1',$data);
			}else{
				if(isset($_COOKIE["username"])){
					$data["users"] = $this->loginmodel->get_UserDetails();
					$this->load->view('unlock',$data);
				}else
				$this->load->view('login_1',$data);
			}
		}
	}

	function checkusername(){
		$this->form_validation->set_rules('username', 'Username', 'required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('error','Required fields missing');
			$this->load->view('login_1');
		}else{
			$username = $this->input->post('username');
			$query = $this->loginmodel->check_username($username);
			if($query->num_rows()>0){
			
				$row = $query->row();
			
				redirect("checkuser/$row->uuid");

			}else{
				$this->session->set_flashdata('error','Invalid Username!');
				$this->load->view('login_1');
			}
		}
	}

	function isemail_exist(){
		$email = $this->input->post("email");
		$query = $this->loginmodel->checkemail($email);

		if($query->num_rows() > 0)
		$isAvailable = true; // or false
		else
		$isAvailable = false; // or false

		// Finally, return a JSON
		echo json_encode(array('valid' => $isAvailable));
	}

	function isunique_username(){
		$username = $this->input->post('username');
		$query = $this->db->where("user_name",$username)->get("users");
	
		if($query->num_rows() == 0)
		$isAvailable = true; // or false
		else
		$isAvailable = false; // or false

// Finally, return a JSON
echo json_encode(array(
    'valid' => $isAvailable));
	}

	function isunique_email(){
		$email = $this->input->post('email');
		$query = $this->db->where("email",$email)->get("users");
		if($query->num_rows() == 0)
		$isAvailable = true; // or false
		else
		$isAvailable = false; // or false

// Finally, return a JSON
echo json_encode(array(
    'valid' => $isAvailable));
	}

	function checkslug($username='123'){
		$query = $this->loginmodel->check_username($username);
		if($query->num_rows()>0){
		
			$row = $query->row();
		
			redirect("checkuser/$row->uuid");

		}else{
			$this->session->set_flashdata('error','Invalid Username!');
			$this->load->view('login_1');
		}
}


	function checkuser($uuid='123'){
				$user = $this->db->where("uuid",$uuid)->get("users");
				if($user->num_rows() == 0){
					redirect("admin/login");
				}
				$data['user'] = $user->row();
			
				$this->form_validation->set_rules('username', 'Username', 'required');
				$this->form_validation->set_rules('password', 'Password', 'required');
			
				if($this->form_validation->run()==FALSE){
					$this->session->set_flashdata('error','Required fields missing');
					$this->load->view('login',$data);
				}else{
					$username = $this->input->post('username');
					$password = md5($this->input->post('password'));
					$rootcompany = $this->input->post("company_id");
					$query = $this->loginmodel->checkemailuser_new($username,$password,$rootcompany);
					//echo $this->db->last_query(); die();
					if($query->num_rows()>0){
					
						$row = $query->row();
						$value['logdetails']['userid'] 		= $row->userid;
						$value['logdetails']['log_time'] 	= date('Y-m-d H:i:s');
						$value['logdetails']['ip_address'] 	= $this->input->ip_address();
						$this->loginmodel->insertlog($value['logdetails']);
						$lastid = $this->db->insert_id();
						$this->usermodel->setGroup_allData($row->company_id,7,1); 
				
						$company_user_id = $this->commonmodel->getcompany_userid_new($row->userid,$row->groupid);
					//	echo $this->db->last_query(); die();
						if($row->userid != $row->company_id && $row->user_group == 7){
							$userdata = array(
								'login_clms_userid'=>$row->userid,
								'clms_userid'=>$row->company_id,
								'chatname'=>$row->first_name.' '.$row->last_name,
								'username'=>$row->first_name.' '.$row->last_name,
								'logid'=>$lastid,'usergroup'=>$row->groupid,
								'groupname'=>$row->group_name,'company_id'=>$row->company_id,
								'clms_company'=>$row->company_id,
								'user_group_companyid'=>$row->user_group_companyid,
								'company_user_id' => $company_user_id
							);
						}else{
							$userdata = array(
								'login_clms_userid'=>$row->userid,
								'clms_userid'=>$row->userid,
								'chatname'=>$row->first_name.' '.$row->last_name,
								'username'=>$row->first_name.' '.$row->last_name,
								'logid'=>$lastid,'usergroup'=>$row->groupid,
								'groupname'=>$row->group_name,'company_id'=>$row->company_id,
								'clms_company'=>$row->company_id,
								'user_group_companyid'=>$row->user_group_companyid,
								'company_user_id' => $company_user_id
							);
						}
	
						
						$query->free_result();
						$this->companymodel->updateCompanyEmail($row->company_id);
						if($this->session->set_userdata($userdata)){
							redirect('dashboard','location');
						}else{
							redirect('login','location');
						}
	
					}else{
						$this->session->set_flashdata('error_msg','Invalid Email or password');
						$this->load->view('login',$data);
					}
				}
	}


	function demo(){
		$this->load->library("uuid");
		$this->form_validation->set_rules('fname','First Name','required');
		$this->form_validation->set_rules('lname','Last Name','required');
		$this->form_validation->set_rules('company','Company Name','required');
		$this->form_validation->set_rules('abn','ABN','required');
	//$this->form_validation->set_rules('address1','Address','required');
		$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('username','Username','required|is_unique[users.user_name]');
		$this->form_validation->set_rules('phone','Phone','required');
		$this->form_validation->set_rules('password','Password','required');
		if($this->form_validation->run()!=FALSE){
			$value['details']['uuid']     = $this->uuid->v4();
			$value['details']['first_name']     = $this->input->post('fname');
			$value['details']['last_name']      = $this->input->post('lname');
			$value['details']['user_name']      = $this->input->post('username');
			$value['details']['email']          = $this->input->post('email');
			$value['details']['phone']          = $this->input->post('phone');
			$value['details']['company_name']          = $this->input->post('company');
    		//$value['details']['company_name']          = $this->input->post('company');
			$value['details']['user_group']     = 7;
			$value['details']['password']       = md5($this->input->post('password'));
			$value['details']['added_date']     = date('Y-m-d H:i:s');
			$value['details']['added_by']       = $this->session->userdata("clms_userid");
			$value['details']['status']         = 1;
			$this->usermodel->insertuser($value['details']);
			$company = $this->db->insert_id();
			$this->db->where("userid",$company);
			$this->db->set("company_id",$company);
			$this->db->update("users");

			$row = $this->generalsettingsmodel->getConfigData(82)->row();

			$expiry = strtotime(" +".$row->config_value." days");

			$insert_array = array(
				"company_id" => $company,
				"country" => $this->input->post("bill_country"),
				"package_id"   => 19,
				"payment_term"   => $row->config_value.' days',
				"price"   => 0,
				"abn" => $this->input->post("abn"),
				//"invoice_status"    => $this->input->post('invoice_status'),
				"join_date" => time(),
				"expiry_date" => $expiry,
				);

			$this->db->insert("company_details",$insert_array);

			$this->db->insert("pnp_user_groups",[
                "group_id" => 7,
                "user_id" => $company,
                "status" => 1,
                "added_date" => date("Y-m-d H:i:s")
            ]);

            $user_group_id = $this->db->insert_id();

            $this->db->insert("pnp_user_group_company",[
                "user_group_id" => $user_group_id,
                "company_id" => $company,
            ]);

            $user_group_company_id = $this->db->insert_id();

			$package = array(
				"user_id" => $company,
				"package_id"   => 19,
				"order_term"   => '1 Month',
				"package_price"   => 0,
				//"invoice_status"    => $this->input->post('invoice_status'),
				"added_date" => date("Y-m-d"),
				"expiry_date" => date("Y-m-d",$expiry)
				);

			$this->db->insert("company_package_order",$package);

			$this->companymodel->sendEmailActivation($company);

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
		//	$this->companymodel->setModulePermission(19,$company);
		    $this->companymodel->setModulePermission_by_package(19,$user_group_company_id,$company);
			$this->companymodel->setModulePermission_for_group($company);
			$this->loginmodel->send_email_verification($company);
			$this->session->set_flashdata('success_message', 'Your account has been successfully created. But the account is awaiting activation. Please Check your email to activate your account.');
			redirect('login/');
		}else{
			$data['countries'] = $this->companymodel->getcoutries();
			$data['content'] = $this->loginmodel->getContentDetail(3);
			$data['heading'] = 'Add ';
			$this->load->vars($data);
			$this->load->view('demo');
		}
	}

	function activate_user($uuid){
		$this->db->where("uuid",$uuid);
		$this->db->set("verified_at",date("Y-m-d"));
		$this->db->update("users");
		$user = $this->companymodel->getdatawithuuid($uuid)->row();

		$ids = array($user->userid);

		if($user->status == 0){
			$this->session->set_flashdata('success_message', 'Your account has been successfully verified but need admin approval to login.');
		}else{
			$this->usermodel->sendWelcomeMsg($ids);
			$this->session->set_flashdata('success_message', 'Your account has been successfully verified and activated.');
		}

		redirect('login/');
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
					$status = $this->dashboardmodel->get_leadstatus($lead->status_id);
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

function tweet(){


	date_default_timezone_set("Asia/Kathmandu"); 
//		date_default_timezone_set("Australia/Sydney"); 
		//$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`shedule_date`), '%Y-%m-%d') = CURDATE()");
		//$this->db->where("is_shared",0);
	$socials = $this->db->get("social_media")->result();
	foreach ($socials as $row) {
	//	if($row->schedule_time < date("H:i")){
		$this->db->where("social_id",$row->id);
		$files = $this->db->get("socail_files")->result();
		$media_files = array();
		foreach ($files as $file) {
			array_push($media_files, "../uploads/media/".$file->filename);
		}

		require_once ('../src/codebird.php');
		$users = $this->db->where("userid",$row->added_by)->get("users")->row();
\Codebird\Codebird::setConsumerKey($users->consumer_key, $users->consumer_secret); // static, see 'Using multiple Codebird instances'

$cb = \Codebird\Codebird::getInstance();

$cb->setToken($users->access_token, $users->access_secret);

$media_ids = array();

foreach ($media_files as $file) {
    // upload all media files
	$reply = $cb->media_upload(array(
		'media' => $file
		));
    // and collect their IDs
	//$media_ids[] = $reply->media_id_string;
	array_push($media_ids, $reply->media_id_string);
}


$media_ids = implode(',', $media_ids);
//echo strlen($media_ids);
// send tweet with these medias
if(strlen($media_ids)>0)
	$reply = $cb->statuses_update(array(
		'status' => $row->content,
		'media_ids' => $media_ids
		));
else
	$cb->statuses_update('status='.$row->content);

$this->db->where("id",$row->id);
$this->db->set("is_shared",1);
$this->db->update("social_media");
//}
}
}

function admin_login(){ 
	$username = $this->input->post('username');
	$password = md5($this->input->post('password'));
	$this->form_validation->set_rules('username', 'Username', 'required');
	$this->form_validation->set_rules('password', 'Password', 'required');
	if($this->form_validation->run()==FALSE){
		$this->session->set_flashdata('error','Required fields missing');
		$this->load->view('admin_login');
	}else{
		$query = $this->loginmodel->checkuser($username,$password);
					//echo $this->db->last_query(); die();
		if($query->num_rows()>0){
			$row = $query->row();
			$value['logdetails']['userid'] 		= $row->userid;
			$value['logdetails']['log_time'] 	= date('Y-m-d H:i:s');
			$value['logdetails']['ip_address'] 	= $this->input->ip_address();
			//$this->loginmodel->insertlog($value['logdetails']);
			$lastid = $this->db->insert_id();
			$userdata = array('clms_userid'=>$row->userid,'chatname'=>$row->user_name,'username'=>$row->first_name.' '.$row->last_name,'logid'=>$lastid,'usergroup'=>$row->user_group,'company_id'=>$row->company_id,'clms_company'=>$row->company_id);
			$this->usermodel->setGroup_allData(0,1,1); 
			$query->free_result();
			if($this->session->set_userdata($userdata)){
				redirect('dashboard','location');
			}else{
				redirect('login','location');
			}

		}else{
			$this->session->set_flashdata('error','Invalid username or password');
			redirect('myadmin','location');
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
		$userdata = array('clms_userid'=>$row->userid,'username'=>$row->first_name.' '.$row->last_name,'logid'=>$lastid,'usergroup'=>$row->user_group,'clms_company'=>$row->company_id);
		$query->free_result();
		if($this->session->set_userdata($userdata)){
			redirect('dashboard','location');
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
	$userid = $this->session->userdata('clms_userid');
	$logid	= $this->session->userdata('logid');
	$this->loginmodel->updatelog($value['details'],$userid,$logid);
	$this->session->unset_userdata('clms_userid');
	$this->session->sess_destroy();
	redirect('login','location');
}	



function unlock(){
	$data["users"] = $this->loginmodel->get_UserDetails();
	$this->load->view('unlock',$data);
}

function forgot_username(){
	
		$this->form_validation->set_rules('email', 'Email', 'required');
		if($this->form_validation->run() != false){
		$email = $this->input->post("email");
		$query = $this->db->where("email",$email)->where("userid=company_id")->get("users");
		// $query = $this->loginmodel->checkemail($email);
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
			$row = $this->mylibrary->getEmailTemplate(92);
			/***** Sms code ******/
			if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1){
				$sms = $row->sms_text;
				$sms = str_replace('[FULL_NAME]',$customer,html_entity_decode($sms,ENT_COMPAT));
				$sms = str_replace('[USERNAME]',$user->user_name,$sms);
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
			$message = str_replace('[USERNAME]',$user->user_name,$message);
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
			redirect("forgot-username?success=1");
		}else{
			$data['userexit'] = $email;
			$this->load->view('forgot_username',$data);
		}

	}else{
		$data['userexit'] = '';
		$this->load->view('forgot_username',$data);
	}
	
}

function forgot_password(){
		$this->form_validation->set_rules('email', 'Email', 'required');
		if($this->form_validation->run() == false){

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

function register(){
	$this->load->library("uuid");
	$this->form_validation->set_rules('fname','First Name','required');
	$this->form_validation->set_rules('lname','Last Name','required');
	$this->form_validation->set_rules('company','Company Name','required');
	$this->form_validation->set_rules('address1','Address','required');
	$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]');
	$this->form_validation->set_rules('username','Username','required|is_unique[users.user_name]');
	//$this->form_validation->set_rules('phone','Phone','required');
	$this->form_validation->set_rules('password','Password','required');
	if($this->form_validation->run()!=FALSE){
		//echo $this->input->post('payment_method'); die();
		$config['upload_path'] = '../assets/uploads/users';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_width'] = 0;
		$config['max_height'] = 0;
		$config['max_size'] = 0;
		$config['encrypt_name'] = FALSE;
		$this->upload->initialize($config);
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('logo'))
		{
			$error = array('error' => $this->upload->display_errors());

		//print_r($error);
		}
		else
		{
			$arr_image = $this->upload->data();
			$thumb = $this->_createThumbnail('../assets/uploads/users/' . $arr_image['file_name'], '../assets/uploads/users/thumb',174,69);
			$value['details']['picture']              = $arr_image['file_name']; 
			$value['details']['thumbnail']              = $thumb["dst_file"];
		}

		$this->db->trans_start();

		$value['details']['uuid']     = $this->uuid->v4();
		$value['details']['first_name']     = $this->input->post('fname');
		$value['details']['last_name']      = $this->input->post('lname');
		$value['details']['email']          = $this->input->post('email');
		$value['details']['phone']          = $this->input->post('phone');
		$value['details']['company_name']          = $this->input->post('company');
		$value['details']['address']          = $this->input->post('address1');
		$value['details']['user_group']     = 7;
		$value['details']['user_name']      = $this->input->post('username');
		$value['details']['password']       = md5($this->input->post('password'));
		$value['details']['added_date']     = date('Y-m-d H:i:s');
		$value['details']['added_by']       = $this->session->userdata("acrm_userid");
		//$value['details']['status']         = 1;
		$this->usermodel->insertuser($value['details']);
		$company = $this->db->insert_id();
		$this->db->where("userid",$company);
		$this->db->set("company_id",$company);
		$this->db->update("users");


		if($this->input->post('order_term') == '1 Month'){
			$expiry = strtotime(" +1 month");
		}elseif($this->input->post('order_term') == '3 Months'){
			$expiry = strtotime(" +3 months");
		}elseif($this->input->post('order_term') == '6 Months'){
			$expiry = strtotime(" +6 months");
		}elseif($this->input->post('order_term') == '12 Months'){
			$expiry = strtotime(" +12 months");
		}

		$order_package = $this->companymodel->getpackageDetail($this->input->post('package'));

		$insert_array = array(
			"company_id" => $company,
			"powered_by" => $order_package->powered_by??NULL,
			"duedatenumber" => $this->input->post("duedatenumber"),
			"quote_email" => $this->input->post("quote_email"),
			"order_email" => $this->input->post("order_email"),
			"account_email" => $this->input->post("account_email"),
			"address2" => $this->input->post("address2"),
			"country" => $this->input->post("bill_country"),
			"state" => $this->input->post("bill_country") == 13 ? $this->input->post("bill_state") : $this->input->post("txt_bill_state"),
			"abn" => $this->input->post("abn"),
			"display_abn" => $this->input->post("display_abn"),
			"postcode" => $this->input->post("postcode"),
			"pay_via_phone" => $this->input->post("cc-number"),
			"pay_via_online" => $this->input->post("cc-via-online"),
			"cc_via_paypal" => $this->input->post("cc-via-paypal"),
			"bank" => $this->input->post("bank"),
			"bsb" => $this->input->post("bsb"),
			"account_no" => $this->input->post("account_no"),
			"mail_to" => $this->input->post("mail_to"),
			"mail_to_address" => $this->input->post("mail_to_address"),
			"eway_id" => $this->input->post("eway_id"),
			"api_username" => $this->input->post("api_username"),
			"api_signature" => $this->input->post("api_signature"),
			"api_password" => $this->input->post("api_password"),
			"description"   => $this->input->post('description'),
			"package_id"   => $this->input->post('package'),
			"payment_term"   => $this->input->post('order_term'),
			"price"   => $this->input->post('txt_package_price'),
			//"invoice_status"    => $this->input->post('invoice_status'),
			"join_date" => time(),
			"expiry_date" => $expiry,
		);

		$this->db->insert("company_details",$insert_array);

		$this->db->insert("pnp_user_groups",[
			"group_id" => 7,
			"user_id" => $company,
			"status" => 1,
			"added_date" => date("Y-m-d H:i:s")
		]);

		$user_group_id = $this->db->insert_id();

		$this->db->insert("pnp_user_group_company",[
			"user_group_id" => $user_group_id,
			"company_id" => $company,
		]);

		$user_group_company_id = $this->db->insert_id();

		$this->companymodel->setModulePermission_by_package($this->input->post('package'),$user_group_company_id,$company);

		$this->companymodel->setModulePermission_for_group($company);
		$this->db->trans_complete();
		$from 	  = $this->mylibrary->getSiteEmail(22);
		$fromname = $this->mylibrary->getSiteEmail(20); 
		$address  = $this->mylibrary->getSiteEmail(59);
		$phone    = $this->mylibrary->getSiteEmail(61);
		$fax      = $this->mylibrary->getSiteEmail(94);
		$sitemail = $this->mylibrary->getSiteEmail(23);
		$logo     = $this->mylibrary->getlogo();
		/****** get new registration template and send email to admin******/
		$row = $this->mylibrary->getEmailTemplate(53);
		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
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

		$this->loginmodel->send_email_verification($company);

		if($this->input->post('payment_method')=='bank'){ 
			$order_update['payment_method'] ='bank';
			$order_update['invoice_status'] = 'Due';
			$this->companymodel->updateorder($order_update,$company);
		//	$this->companymodel->sendEmail("bank",$company_id);
		$this->companymodel->sendEmailPackage("Bank",$company);
			$this->session->set_flashdata("success_message","You have been Successfully registered on Acrm. Check your email to veriy your email. You will be able to login after approval of Admin.");
			redirect('','location');
		}elseif($this->input->post('payment_method')=='stripe'){
			$amount = $this->input->post('txt_package_price');
			$respose = $this->stripe_payment($amount,$company);
		}

		$this->session->set_flashdata('success_message', 'Company added Successfully.');
	//	redirect('payment/'.$company);
	}else{
		$this->load->model("customer/customermodel");
		$data['packages'] = $this->companymodel->listPackages();
		$data['countries'] = $this->companymodel->getcoutries();
		
		$data['content'] = $this->loginmodel->getContentDetail(3);
		$ip = $_SERVER['REMOTE_ADDR']; // the IP address to query
		$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
		if($query && $query['status'] == 'success') {
			if(@$query['country'] == 'Nepal')
				$countryid = 146;
			else
				$countryid = 13;
		}else{
			$countryid = 13;
		}
		$data['account_setting'] = $this->customermodel->get_account_detail($countryid);
		$data['states'] = $this->companymodel->getstates($countryid);
		$data['countryid'] = $countryid;
		$data['heading'] = 'Add ';
		$this->load->vars($data);
		$this->load->view('signup');
	}

}

function test(){
	$this->loginmodel->send_email_verification(106);
}

function payment($company_id){
	$this->form_validation->set_rules('txt_name', 'Package Name', 'trim|required');
	$this->form_validation->set_rules('txt_order_term', 'Order Term', 'trim|required');
	$this->form_validation->set_rules('txt_price', 'Price', 'trim|required');
	$data['errors'] = array();
	if ($this->form_validation->run()) {		

		if($this->input->post('paymethod')=='bank'){ 
			$order_update['payment_method'] ='bank';
			$order_update['invoice_status'] = 'Due';
			$this->companymodel->updateorder($order_update,$company_id);
		//	$this->companymodel->sendEmail("bank",$company_id);
		$this->companymodel->sendEmailPackage("Bank",$company_id);
			$this->session->set_flashdata("success_message","You have been Successfully registered on Acrm. Check your email to veriy your email. You will be able to login after approval of Admin.");
			redirect('','location');
		}elseif($this->input->post('paymethod')=='stripe'){
			$amount = $this->input->post('txt_price');
			$respose = $this->stripe_payment($amount,$company_id);
		}
	}else{
		$data['company'] = $this->companymodel->getdata($company_id)->row();
		$data['package'] = $this->companymodel->getPackageDetail($data['company']->package_id);
		$data['heading'] = 'Add ';
		$this->load->vars($data);
		$this->load->view('payment');
	}
}

function stripe_payment($amount,$company_id){
	//  echo $this->input->post('access_token');
	 // echo $this->mylibrary->getSiteEmail(84);
	   //$order = $this->homemodel->getOrderdata($orderid)->row();
   try {
	   Stripe::setApiKey($this->mylibrary->getSiteEmail(84));
	   $charge = Stripe_Charge::create(array(
		   "amount" => $amount * 100,
		   "currency" => "AUD",
		   "card" => $this->input->post('access_token'),
		   "description" => "Stripe Payment"
	   ));
	   // this line will be reached if no error was thrown above
	   //$transaction_id = $this->ewaypayment->getAuthCode();

	   $transaction_id = $this->input->post('access_token');
	   $order_update['transaction_id'] = $transaction_id;
	   $order_update['payment_method'] ='stripe';
	   $order_update['invoice_status'] = 'Paid';
	   $this->companymodel->updateorder($order_update,$company_id);
	   $this->db->where("userid",$company_id);
	   $this->db->set("status",1);
	   $this->db->update("users");
	 //  $this->companymodel->sendEmail('Stripe',$company_id);
	 $this->companymodel->sendEmailPackage("Stripe",$company_id);
	   $this->session->set_flashdata("success_message","You have been Successfully registered on Acrm.Check your email to veriy your email.");
		   //die('one');
   } catch (Stripe_CardError $e) {
	   $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
   } catch (Stripe_InvalidRequestError $e) {
	   $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
   } catch (Stripe_AuthenticationError $e) {
	   $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
   } catch (Stripe_ApiConnectionError $e) {
	   $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
   } catch (Stripe_Error $e) {
	   $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
   } catch (Exception $e) {
	   $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
   }
   redirect('','location');
}



}
?>
