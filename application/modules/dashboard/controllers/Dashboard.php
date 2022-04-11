<?php
require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php');
class Dashboard extends MX_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('dashboardmodel');
		$this->load->model('appointment/appointmentmodel');
		$this->load->model('lms/lmsmodel');
		$this->load->model('login/loginmodel');
		$this->load->model('enroll/enrollmodel');
		$this->load->model('project/projectmodel');
		$this->load->model('download/downloadmodel');
		$this->load->model("student/studentmodel");
		$this->load->library('html2pdf');
		$this->load->model("company/companymodel");
		$this->load->model("employee/employeemodel");
		$this->container ='main';
	}

	function index(){ 
		if ($this->session->userdata("clms_front_userid") != "" ) {
			$company_id = $this->session->userdata("clms_front_companyid");
			if($this->input->post("notice_form")){
				$notice = $this->input->post("notice");

				$db_notices = $this->db->where("company_id",$company_id)->get("company_notice");
				$notice_array = [
					"company_id" => $company_id,
					"content" => $notice,
					"added_at" => date("Y-m-d H:i:s"),
					"added_by" => $this->session->userdata("clms_front_userid")
				];
				if($db_notices->num_rows() > 0){
					$notice_detail = $db_notices->row();
					$this->db->where("id",$notice_detail->id);
					$this->db->update("company_notice",$notice_array);
				}else{
					$this->db->insert("company_notice",$notice_array);
				}
				$this->session->set_flashdata('success_message', 'Notice has been Updated Successfully.');
				redirect("dashboard");
			}else{
				$db_notices = $this->db->where("company_id",$company_id)->get("company_notice")->row();
				$data['todos'] = $this->dashboardmodel->gettodotasks(0);
				$data['archiv_todos'] = $this->dashboardmodel->gettodotasks(1);
				$data['notice'] = $db_notices->content??'';
				$data['page'] = 'dashboard';
				$this->load->vars($data);
				$this->load->view($this->container);
			}
			
		} else {
			$this->session->set_flashdata('error', 'Please login with your username and password');
			redirect('login', 'location');
		}
		
	}

	function todotask_detail($id){
		$data['logs'] = $this->dashboardmodel->get_tasklogs($id);
		$this->load->view("task_logs",$data);
	}

	function add_todotask(){
		$insert_array = array(
			"task_name" => $this->input->post("task"),
			"user_id" => $this->session->userdata("clms_front_userid"),
			"added_date" => time(),
		);
		$this->db->insert("todotask",$insert_array);
		$id = $this->db->insert_id();

		 $this->dashboardmodel->addtaskhistory($id,'Add');

		$todonum = $this->input->post("todonum");

		$string = '<li class="li_todo" id="li_todo'.$id.'">
		<div class="checkbox-custom checkbox-default">
		<input type="checkbox" value="'.$id.'" id="todoListItem'.$todonum.'" class="todo-check my-todo">
		<label id="label_todo_'.$id.'" class="todo-label" for="todoListItem'.$todonum.'"><span>'.$this->input->post("task").'</span></label>
		</div>
		<div class="todo-actions">
		<a class="todo-remove link_remove" rel="'.$id.'" href="javascript:void(0);">
		<i class="fa fa-times"></i>
		</a>
		</div>
		</li>';
		$all = $this->dashboardmodel->getTodo();
		$num = $this->dashboardmodel->getActiveTodo();
		$array = array("string"=>$string,"num"=>count($num),"alltask"=>count($all));
		echo json_encode($array);
	}

	function status_todotask(){
		$this->db->where("id",$this->input->post("taskid"));
		$this->db->set("status",$this->input->post("status"));
		$this->db->update("todotask");
		$id = $this->input->post("taskid");
		$action = $this->input->post("status") == 1 ? 'Complete' : 'Uncomplete';
		$this->dashboardmodel->addtaskhistory($id,$action);

		$all = $this->dashboardmodel->getTodo();
		$num = $this->dashboardmodel->getActiveTodo();
		$array = array("num"=>count($num),"alltask"=>count($all));
		echo json_encode($array);
	}

	function remove_todotask(){
		$this->db->where("id",$this->input->post("taskid"));
		$this->db->delete("todotask");

		$all = $this->dashboardmodel->getTodo();
		$num = $this->dashboardmodel->getActiveTodo();
		$array = array("num"=>count($num),"alltask"=>count($all));
		echo json_encode($array);
	}

	function archive_todotask(){
		$this->db->where("id",$this->input->post("taskid"));
		$this->db->set("is_archived",1);
		$this->db->update("todotask");

		$id = $this->input->post("taskid");
		$action = 'Archive';
		$this->dashboardmodel->addtaskhistory($id,$action);
	}

	function download_todotasks($type = ''){
		$company = $this->dashboardmodel->getCompanyDetails($this->session->userdata("clsm_company"));

		if($type == '')
			$data['todos'] = $this->dashboardmodel->gettodotasks(0);
		else
			$data['todos'] = $this->dashboardmodel->gettodotasks(1);

		$data['company'] = $company;
	

		$content = $this->load->view('dashboard/todo_pdf', $data, true);
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');
		$file = 'todo-'.$type.' '.$this->clean($company->company_name).'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$filename = "./uploads/pdf/".$file;

		header("Content-Length: " . filesize($filename));
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=todo-'.$type.' '.$this->clean($company->company_name).'.pdf');

		readfile($filename);
	}

	function clean($string) {
		$string = str_replace(' ', '-', $string); 
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
	}

	function remove_notice(){
		if ($this->session->userdata("clms_front_userid") != "" ) {
			$company_id = $this->session->userdata("clms_front_companyid");
			$db_notices = $this->db->where("company_id",$company_id)->delete("company_notice");
			$this->session->set_flashdata('success_message', 'Notice has been Deleted Successfully.');
		}
	}

	function leads(){
		if ($this->session->userdata("clms_front_userid") != "" ) {
			$config['base_url'] = base_url() . 'index.php/dashbaord/leads/';
			$config['uri_segment'] = 3;
			$config['per_page'] = 20;
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
			if($this->input->get("handle"))
				$handle = $this->input->get("handle");
			else
				$handle = "";
			$data["search_handle"] = $handle;
			if($this->input->get("country"))
				$country = $this->input->get("country");
			else
				$country = "";
			$data["search_country"] = $country;
			if($this->input->get("weightage"))
				$weightage = $this->input->get("weightage");
			else
				$weightage = "";
			$data["search_weightage"] = $weightage;
			if($this->input->get("status"))
				$status = $this->input->get("status");
			else
				$status = "";
			$data["search_status"] = $status;
			if($this->input->get("category"))
				$category = $this->input->get("category");
			else
				$category = "";
			$data["search_category"] = $category;
			if($this->input->get("access"))
				$access = $this->input->get("access");
			else
				$access = "";
			$data["search_access"] = $access;
			if($this->input->get("language"))
				$language = $this->input->get("language");
			else
				$language = "";
			if($this->input->get("lead_date"))
				$lead_date = $this->input->get("lead_date");
			else
				$lead_date = "";

			if($this->input->get("added_date"))
				$added_date = $this->input->get("added_date");
			else
				$added_date = "";


			$data["search_language"] = $language;
			$query = $this->lmsmodel->listall($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
			$data["leads"] = $query;
			//echo $this->db->last_query();die();
			$data['appointments'] = $this->appointmentmodel->listall($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
			$data['councelling'] = $this->appointmentmodel->listcouncelling($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
			$data['students'] 	= $this->studentmodel->listall();
			//$data['enrolls'] 	= $this->enrollmodel->listall();
			$data['enrolls'] 	= $this->projectmodel->listall($added_date='',$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='');
			$data['downloads'] = $this->downloadmodel->listall();
			//echo $this->db->last_query();die();
			
			$data['languages']      = $this->lmsmodel->get_languages();
			$data['countries']      = $this->lmsmodel->get_country();
			$data['chats']      = $this->lmsmodel->get_chatType();
			$data['category']      = $this->lmsmodel->get_category();
			$data['access']      = $this->lmsmodel->get_access();
			$data['users']      = $this->lmsmodel->get_users();
			$data['weightage']      = $this->lmsmodel->get_leadweightage();
			$data['status']      = $this->lmsmodel->get_leadstatus();

			
			$data['heading']        = 'Newsletters';
			
        //$data['pagenumbers'] 	= $string;
        //$data['newsletter'] 	= $newsletter;
            //$data['pagination'] 	= $this->pagination->create_links();
			$data['page'] 			= 'leads';
			$this->load->vars($data);
			$this->load->view($this->container);
		} else {
			$this->session->set_flashdata('error', 'Please login with your username and password');
			redirect('login', 'location');
		}
		
	}

	function appointment(){
		if ($this->session->userdata("clms_front_userid") != "" ) {

			if($this->input->get("handle"))
				$handle = $this->input->get("handle");
			else
				$handle = "";
			$data["search_handle"] = $handle;
			if($this->input->get("country"))
				$country = $this->input->get("country");
			else
				$country = "";
			$data["search_country"] = $country;
			if($this->input->get("weightage"))
				$weightage = $this->input->get("weightage");
			else
				$weightage = "";
			$data["search_weightage"] = $weightage;
			if($this->input->get("status"))
				$status = $this->input->get("status");
			else
				$status = "";
			$data["search_status"] = $status;
			if($this->input->get("category"))
				$category = $this->input->get("category");
			else
				$category = "";
			$data["search_category"] = $category;
			if($this->input->get("access"))
				$access = $this->input->get("access");
			else
				$access = "";
			$data["search_access"] = $access;
			if($this->input->get("language"))
				$language = $this->input->get("language");
			else
				$language = "";
			if($this->input->get("appointment_date"))
				$lead_date = $this->input->get("appointment_date");
			else
				$lead_date = "";

			if($this->input->get("added_date"))
				$added_date = $this->input->get("added_date");
			else
				$added_date = "";


			$data["search_language"] = $language;
			$query = $this->lmsmodel->listall($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
			$data["leads"] = $query;
			$data['appointments'] = $this->appointmentmodel->listall($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
		//	echo $this->db->last_query();die();
			$data['councelling'] = $this->appointmentmodel->listcouncelling($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
			$data['students'] 	= $this->studentmodel->listall();
			$data['enrolls'] 	= $this->projectmodel->listall($added_date='',$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='');
			$data['downloads'] = $this->downloadmodel->listall();

			$data['languages']      = $this->appointmentmodel->get_languages();
			$data['countries']      = $this->appointmentmodel->get_country();
			$data['chats']      = $this->appointmentmodel->get_chatType();
			$data['category']      = $this->appointmentmodel->get_category();
			$data['access']      = $this->appointmentmodel->get_access();
			$data['users']      = $this->appointmentmodel->get_users();
			$data['weightage']      = $this->appointmentmodel->get_leadweightage();
			$data['status']      = $this->appointmentmodel->get_leadstatus();


			$data['heading']        = 'Newsletters';
        //$data['pagenumbers'] 	= $string;
        //$data['newsletter'] 	= $newsletter;
            //$data['pagination'] 	= $this->pagination->create_links();
			$data['page'] 			= 'appointment';
			$this->load->vars($data);
			$this->load->view($this->container);
		} else {
			$this->session->set_flashdata('error', 'Please login with your username and password');
			redirect('login', 'location');
		}
	}

	function counselling(){
		if ($this->session->userdata("clms_front_userid") != "" ) {

			if($this->input->get("handle"))
				$handle = $this->input->get("handle");
			else
				$handle = "";
			$data["search_handle"] = $handle;
			if($this->input->get("country"))
				$country = $this->input->get("country");
			else
				$country = "";
			$data["search_country"] = $country;
			if($this->input->get("weightage"))
				$weightage = $this->input->get("weightage");
			else
				$weightage = "";
			$data["search_weightage"] = $weightage;
			if($this->input->get("status"))
				$status = $this->input->get("status");
			else
				$status = "";
			$data["search_status"] = $status;
			if($this->input->get("category"))
				$category = $this->input->get("category");
			else
				$category = "";
			$data["search_category"] = $category;
			if($this->input->get("access"))
				$access = $this->input->get("access");
			else
				$access = "";
			$data["search_access"] = $access;
			if($this->input->get("language"))
				$language = $this->input->get("language");
			else
				$language = "";
			if($this->input->get("appointment_date"))
				$lead_date = $this->input->get("appointment_date");
			else
				$lead_date = "";

			if($this->input->get("added_date"))
				$added_date = $this->input->get("added_date");
			else
				$added_date = "";


			$data["search_language"] = $language;
			$query = $this->lmsmodel->listall($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
			$data["leads"] = $query;
			$data['appointments'] = $this->appointmentmodel->listall($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
			$data['councelling'] = $this->appointmentmodel->listcouncelling($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
			$data['students'] 	= $this->studentmodel->listall();
			$data['enrolls'] 	= $this->projectmodel->listall($added_date='',$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='');
			$data['downloads'] = $this->downloadmodel->listall();

			$data['languages']      = $this->appointmentmodel->get_languages();
			$data['countries']      = $this->appointmentmodel->get_country();
			$data['chats']      = $this->appointmentmodel->get_chatType();
			$data['category']      = $this->appointmentmodel->get_category();
			$data['access']      = $this->appointmentmodel->get_access();
			$data['users']      = $this->appointmentmodel->get_users();
			$data['weightage']      = $this->appointmentmodel->get_leadweightage();
			$data['status']      = $this->appointmentmodel->get_leadstatus();


			$data['heading']        = 'Newsletters';
        //$data['pagenumbers'] 	= $string;
        //$data['newsletter'] 	= $newsletter;
            //$data['pagination'] 	= $this->pagination->create_links();
			$data['page'] 			= 'counselling';
			$this->load->vars($data);
			$this->load->view($this->container);
		} else {
			$this->session->set_flashdata('error', 'Please login with your username and password');
			redirect('login', 'location');
		}
	}

	function enroll(){
		if ($this->session->userdata("clms_front_userid") != "" ) {
			$data["leads"] = $this->lmsmodel->listall($handle='',$country='',$weightage='',$status='',$category='',$access='',$language='',$lead_date='',$added_date='');
			$data['appointments'] = $this->lmsmodel->listall($handle='',$country='',$weightage='',$status='',$category='',$access='',$language='',$lead_date='',$added_date='');
			$data['councelling'] = $this->appointmentmodel->listcouncelling($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
			$data['students'] 	= $this->studentmodel->listall();
			$data['enrolls'] 	= $this->projectmodel->listall($added_date='',$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='');
			$data['downloads'] = $this->downloadmodel->listall();
			$data['page'] 			= 'enroll';
			$this->load->vars($data);
			$this->load->view($this->container);
		} else {
			$this->session->set_flashdata('error', 'Please login with your username and password');
			redirect('login', 'location');
		}
	}

	function download() {
		if ($this->session->userdata("clms_front_userid") != "" ) {
			$data["leads"] = $this->lmsmodel->listall($handle='',$country='',$weightage='',$status='',$category='',$access='',$language='',$lead_date='',$added_date='');
			$data['appointments'] = $this->lmsmodel->listall($handle='',$country='',$weightage='',$status='',$category='',$access='',$language='',$lead_date='',$added_date='');
			$data['councelling'] = $this->appointmentmodel->listcouncelling($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
			$data['students'] 	= $this->studentmodel->listall();
			$data['enrolls'] 	= $this->projectmodel->listall($added_date='',$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='');
			$data['downloads'] = $this->downloadmodel->listall();
			$data['page'] = 'download';
			$this->load->vars($data);
			$this->load->view($this->container);
		} else {
			$this->session->set_flashdata('error', 'Please login with your username and password');
			redirect('login', 'location');
		}
	}

	function student() {
		if ($this->session->userdata("clms_front_userid") != "") {
			$data["leads"] = $this->lmsmodel->listall($handle='',$country='',$weightage='',$status='',$category='',$access='',$language='',$lead_date='',$added_date='');
			$data['appointments'] = $this->lmsmodel->listall($handle='',$country='',$weightage='',$status='',$category='',$access='',$language='',$lead_date='',$added_date='');
			$data['councelling'] = $this->appointmentmodel->listcouncelling($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
			$data['students'] 	= $this->studentmodel->listall();
			$data['enrolls'] 	= $this->projectmodel->listall($added_date='',$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='');
			$data['downloads'] = $this->downloadmodel->listall();
			$data['page'] 			= 'student';
			$this->load->vars($data);
			$this->load->view($this->container);
		} else {
			$this->session->set_flashdata('error', 'Please login with your username and password');
			redirect('login', 'location');
		}
	}


	function remove_projectnotications(){
		$this->db->where("user_id",$this->session->userdata("clms_front_userid"));
		$this->db->delete("notifications_project");
		$header_notifications = $this->dashboardmodel->get_notifications();

		foreach ($header_notifications as $row ) {
			
			$array = array(
				"user_id" => $this->session->userdata("clms_front_userid"),
				"notification_id" => $row->noteid
				);
			$this->db->insert("notifications_project",$array);
		}
	}

	function remove_studentnotications(){
		if($this->session->userdata("clms_front_companyid"))
			$this->db->where("to_id",$this->session->userdata("clms_front_companyid"));
		$this->db->set("status",1);
		$this->db->update("student_notifications");
		
	}

	function remove_tasknotications(){
		$this->db->where("user_id",$this->session->userdata("clms_front_userid"));
		$this->db->delete("notifications_task");
		$header_tasks = $this->dashboardmodel->get_currenttask();

		foreach ($header_tasks as $row ) {
			
			$array = array(
				"user_id" => $this->session->userdata("clms_front_userid"),
				"task_id" => $row->task_id
				);
			$this->db->insert("notifications_task",$array);
		}
	}




	// function remove_todotask(){
	// 	$this->db->where("id",$this->input->post("taskid"));
	// 	$this->db->delete("todotask");
	// }

	function backup(){
		if($this->session->userdata("clms_front_userid")!=""){
		// Load the DB utility class
			$this->load->dbutil();

// Backup your entire database and assign it to a variable
			$backup =& $this->dbutil->backup(); 

// Load the file helper and write the file to your server
			$this->load->helper('file');
			write_file('/path/to/mybackup.sql.zip', $backup); 

// Load the download helper and send the file to your desktop
			$this->load->helper('download');
			force_download('mybackup.sql.zip', $backup);
		}
	}

	function chat(){

		if($this->session->userdata("clms_front_userid")!=""){
			$insert_arr = array(
				"content" => $this->input->post("txt_msg"),
				"company_id" => $this->session->userdata("clms_front_companyid"),
				"status" => 1,
				"added_date" => time(),
				"added_by" => $this->session->userdata("clms_front_userid"),
				);
			$this->db->insert("chat_note",$insert_arr);
			$logs = array(
				"content" => serialize($insert_arr),
				"action" => "Add",
				"module" => "Manage Chat",
				"added_by" => $this->session->userdata("clms_front_userid"),
				"added_date" => time()
				);
			$this->usermodel->insertUserlog($logs);
			redirect("dashboard","location");
		}else{
			$this->session->set_flashdata('error','Please login with your username and password');
			redirect('login','location');
		}
	}



	function delete_chat(){
		$id = $this->uri->segment(3);
		$this->db->where("note_id",$id);
		$this->db->delete("chat_note");
		$this->session->set_flashdata("success_message","Record deleted successfully.");
		redirect("dashboard","location");
	}

	function calendar(){
		if($this->input->post('month')){
			$timeid = $this->input->post('month');
		}elseif($this->input->post('jyear')){
			$timeid = mktime(0,0,0,$this->input->post('month'),1,$this->input->post('jyear'));
		}else{
			$timeid = 0;
		}
		if($timeid==0)
			$time = time();
		else
			$time = $timeid;
		$events = $this->dashboardmodel->getMyEvents($time,$this->session->userdata("clms_front_userid"));				
		$today = date("Y/n/j", time());
		$current_month = date("n", $time);
		$current_year = date("Y", $time);
		$current_month_text = date("F Y", $time);
		$total_days_of_current_month = date("t", $time);
		$first_day_of_month = mktime(0,0,0,$current_month,1,$current_year);
					//geting Numeric representation of the day of the week for first day of the month. 0 (for Sunday) through 6 (for Saturday).
		$first_w_of_month = date("w", $first_day_of_month);
					//how many rows will be in the calendar to show the dates
		$total_rows = ceil(($total_days_of_current_month + $first_w_of_month)/7);
		$day = -$first_w_of_month;
		$next_month = mktime(0,0,0,$current_month+1,1,$current_year);
		$next_month_text = date("F \'y", $next_month);
		$previous_month = mktime(0,0,0,$current_month-1,1,$current_year);
		$previous_month_text = date("F \'y", $previous_month);
		$next_year = mktime(0,0,0,$current_month,1,$current_year+1);
		$next_year_text = date("F \'y", $next_year);
		$previous_year = mktime(0,0,0,$current_month,1,$current_year-1);
		$previous_year_text = date("F \'y", $previous_year);
		$month ='';
		for($i=1;$i<=12;$i++){
			if($i==1)
				$mon = "Jan";
			if($i==2)
				$mon = "Feb";
			if($i==3)
				$mon = "Mar";
			if($i==4)
				$mon = "Apr";
			if($i==5)
				$mon = "May";
			if($i==6)
				$mon = "June";
			if($i==7)
				$mon = "July";
			if($i==8)
				$mon = "Aug";
			if($i==9)
				$mon = "Sep";
			if($i==10)
				$mon = "Oct";
			if($i==11)
				$mon = "Nov";
			if($i==12)
				$mon = "Dec";	
			$select = ($current_month==$i)?'selected="selected"':'';																																																	
			$month .= '<option value="'.$i.'" '.$select.'>'.$mon.'</option>';
		}
		$year = '';
		for($i = date('Y');$i<=date('Y')+10;$i++){
			$select = ($current_year==$i)?'selected="selected"':'';
			$year .= '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
		}
		$calendar = "
		<script src='".base_url()."themes/js/coda.js' type='text/javascript'> </script>
		<script type=\"text/javascript\">$(function(){ 
			$('.next').click(function() {
				var month = ($(this).attr('rel'));
				$.ajax({  
					type: 'POST',  
					url: 'dashboard/calendar',  
					data: { month: month},  
					success: function(theResponse) {
						$('#calendar').html(theResponse);
					}  

				}); 
$.ajax({  
	type: 'POST',  
	url: 'dashboard/listevents',  
	data: { month: month},  
	success: function(theResponse) {
		$('#upcomingevents').html(theResponse);
	}  
}); 

});

$('.prev').click(function() {
	var month = ($(this).attr('rel'));
	$.ajax({  
		type: 'POST',  
		url: 'dashboard/calendar',  
		data: { month: month},  
		success: function(theResponse) {
			$('#calendar').html(theResponse);
		}  

	}); 
$.ajax({  
	type: 'POST',  
	url: 'dashboard/listevents',  
	data: { month: month},  
	success: function(theResponse) {
		$('#upcomingevents').html(theResponse);
	}  
}); 

});
$('#jump').click(function() {
	var jmonth = $('#jmonth').val();
	var jyear = $('#jyear').val();
	$.ajax({  
		type: 'POST',  
		url: 'dashboard/calendar',  
		data: { jmonth: jmonth,jyear:jyear},  
		success: function(theResponse) {
			$('#calendar').html(theResponse);
		}  
	}); 
$.ajax({  
	type: 'POST',  
	url: 'dashboard/listevents',  
	data: { jmonth: jmonth,jyear:jyear},
	success: function(theResponse) {
		$('#upcomingevents').html(theResponse);
	}  
}); 
});
});</script>";

$calendar.='<table width="100%">
<tr>
	<td><a style="cursor:pointer" rel="'.$previous_month.'" title="'.$previous_month_text.'" class= "prev btn btn-primary"><span class="glyphicon glyphicon-circle-arrow-left"></span></a></td>
	<td colspan="5" style="text-align:center"><h3>'.date('F',$time).', '.$current_year.'</h3></td>
	<td style="text-align:right"><a style="cursor:pointer" rel="'.$next_month.'" title="'.$next_month_text.'" class="next btn btn-primary"><span class="glyphicon glyphicon-circle-arrow-right"></span></a></td>
</tr>
<tr>
	<td style="vertical-align:middle"><label>Month:</label></td><td colspan="2"> <select name="jyear" class="form-control" id="jmonth" style="width:100px;">'.$month.'</select></td>
	<td style="vertical-align:middle"><label>Year:</label></td><td colspan="2"> <select name="jyear" class="form-control" id="jyear" style="width:100px;">'.$year.'</select></td>
	<td style="text-align:right"><a style="cursor:pointer;" id="jump" class="btn btn-primary"><span class="glyphicon glyphicon-log-in"></span></td>

</tr>
</table>';
$calendar .= '<table cellspacing="0" class="table table-condensed table-calendar" width="100%">	  	
<tr>
	<td><label>Sun</label></td>
	<td><label>Mon</label></td>
	<td><label>Tue</label></td>
	<td><label>Wed</label></td>
	<td><label>Thu</label></td>
	<td><label>Fri</label></td>
	<td><label>Sat</label></td>
</tr>
<tr>';
	for($i=0; $i< $total_rows; $i++){
		for($j=0; $j<7;$j++){
			$day++;					
			if($day>0 && $day<=$total_days_of_current_month){
				$date_form = "$current_year/$current_month/$day";
				$calendar .= '<td';
									//check if the date is today
				if($date_form == $today){
					$calendar .= ' id="today"';
				}
									//check if any event stored for the date
				if(array_key_exists($day,$events)){
										//adding the date_has_event class to the <td> and close it
					$calendar .= ' class="date_has_event"> '.$day;
										//adding the eventTitle and eventContent wrapped inside <span> & <li> to <ul>
					$calendar .= '<div class="events"><ul>';
					foreach ($events as $key=>$event){
						if ($key == $day){
							foreach ($event as $single){					
								$calendar .= '<li>';
								$calendar .= anchor("dashboard/viewevent/".$single->eventid,'<span class="title">'.$single->event_title.'</span>',array('class'=>'viewevent'));
								$calendar .= '</li>'; 
												} // end of for each $event
											}
										} // end of foreach $events
										$calendar .= '</ul><div class="clear"></div></div>';
									} // end of if(array_key_exists...)
									else{
										//if there is not event on that date then just close the <td> tag
										$calendar .='><a href data-toggle="modal" title="Add New Users" data-target="#ammendment" id="'.$day.'"> '.$day.'</a>';
									}
									$calendar .= "</td>";
								}
								else {
									//showing empty cells in the first and last row
									$calendar .= '<td class="padding">&nbsp;</td>';
								}
							}
							$calendar .="</tr><tr>";
						}
						$calendar .= '</tr>';
						$calendar .= '</table>';
						echo $calendar;
					}

					function addevent(){
						if($this->session->userdata("clms_front_userid")==''){
							redirect('login','location');	

						}else{
							if($this->input->post('action') && $this->input->post('action')=='submit'){
								$mydata = array('event_title'=>$this->input->post('title'),
									'event_date'=>$this->input->post('edate'),
									'event_time'=>$this->input->post('etime'),
									'client_id'=>$this->session->userdata('client_id'),
									'event_details'=>$this->input->post('edetails'),
									'location'=>$this->input->post('elocation'),
									'reminder'=>$this->input->post('eremind'),
									'added_by'=>$this->session->userdata("clms_front_userid"),
									'added_date'=>date('Y-m-d'),
									'modified_by'=>$this->session->userdata("clms_front_userid"),
									'modified_date'=>date('Y-m-d')
									);
								$this->dashboardmodel->addevent($mydata);
								echo 'yes';
							}
						}
					}

					function addnews(){
						if($this->session->userdata("clms_front_userid")==''){
							redirect('login','location');	
						}else{
							if($this->input->post('action') && $this->input->post('action')=='submit'){
								$link = str_replace(' ','-',url_title($this->input->post('title'),'-',TRUE));
								$link = str_replace(array(',','.','&','_'),'',$link);
								if($this->session->userdata('client_id')!='0'){
									$client_id 	= $this->session->userdata('client_id');
								}else{
									$client_id 	= '0';
								}
								$details['news']['news_link'] 		= $link;
								$details['news']['news_title'] 		= $this->input->post('title');
								$mydata = array(
									'client_id'=>$client_id,
									'news_link'=>$link,
									'news_title'=>$this->input->post('ntitle'),
									'news_details'=>$this->input->post('ndetails'),
									'added_by'=>$this->session->userdata("clms_front_userid"),
									'added_date'=>date('Y-m-d'),
									'modified_by'=>$this->session->userdata("clms_front_userid"),
									'modified_date'=>date('Y-m-d'),
									'news_status'=>'1'
									);
								$this->dashboardmodel->addnews($mydata);
								echo 'yes';
							}
						}		
					}

					function getnews(){
						if($this->session->userdata("clms_front_userid")==''){
							redirect('login','location');	
						}else{
							if($this->input->post('action') && $this->input->post('action')=='getnews'){
								$newsid = $this->input->post('newsid');
								$query = $this->dashboardmodel->getnews($newsid);
								if($query->num_rows()>0){
									$row = $query->row();
									$data['title'] 	 = $row->news_title;
									$data['details'] = $row->news_details;
									$this->load->view('news_details',$data);
								}else{
									echo 'Error ! occured while fetching data';
								}
							}
						}				
					}

					function getnote(){
						if($this->session->userdata("clms_front_userid")==''){
							redirect('login','location');	
						}else{
							if($this->input->post('action') && $this->input->post('action')=='getnote'){
								$source = str_replace('#','',$this->input->post('source'));
								if(strstr($source,'/')){
									$source = substr($source,0,strpos($source,'/'));
								}else{
									$source = $source;
								}
								$query = $this->dashboardmodel->getnote($source);
								if($query->num_rows()>0){
									foreach($query->result() as $row):
										echo '<tr id="note_'.$row->note_id.'"><td>'.$row->added_date.' - '.strip_tags($row->notes).'</td><td><a  class="deletenote" onclick="deletenote('.$row->note_id.')"><span class="glyphicon glyphicon-trash"></span></a></td></tr>';
									endforeach;	
								}else{
									echo '';	
								}

							}
						}				
					}

					function addnote(){
						if($this->session->userdata("clms_front_userid")==''){
							redirect('login','location');	
						}else{
							if($this->input->post('action') && $this->input->post('action')=='addnote'){
								$source = str_replace('#','',$this->input->post('source'));
								if(strstr($source,'/')){
									$source = substr($source,0,strpos($source,'/'));
								}else{
									$source = $source;
								}
								$client = ($this->session->userdata('client_id')!='')?$this->session->userdata('client_id'):'0';
								$mydata = array('notes'=>$this->input->post('notes'),
									'client_id'=>$client,
									'added_from'=>$source,
									'added_by'=>$this->session->userdata("clms_front_userid"),
									'added_date'=>date('Y-m-d')
									);
								$this->dashboardmodel->addnote($mydata);
								echo 'yes';
							}
						}				
					}

					function deletenote(){
						if($this->session->userdata("clms_front_userid")==''){
							redirect('login','location');	
						}else{
							if($this->input->post('action') && $this->input->post('action')=='deletenote'){
								$note_id = $this->input->post('note_id');
								$this->dashboardmodel->deletenote($note_id);
								echo 'yes';
							}
						}				
					}

					function _createThumbnail($fileName, $thumb) {
						$config = array();
						$config['image_library'] = 'gd2';
						$config['source_image'] = $fileName;
						$config['new_image'] = FCPATH . $thumb;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 235;
						$config['height'] = 160;

						$this->load->library('image_lib');
						$this->image_lib->initialize($config);
						if (!$this->image_lib->resize()) {
							echo $this->image_lib->display_errors();
							return false;
						}
						return $this->image_lib->data();
					}
		//Get User Details
					function getuser(){
						if($this->session->userdata("clms_front_userid")!=""){
							if($this->input->post('action') && $this->input->post('action')=='update'){
								$userid = $this->session->userdata("clms_front_userid");
								$this->form_validation->set_rules('fname','First Name','required');
								$this->form_validation->set_rules('lname','Last Name','required');
								$this->form_validation->set_rules('email','Email ID','required|valid_email');
								$this->form_validation->set_rules('phone','Phone Number','required');
								if($this->form_validation->run()==FALSE){
									echo "Required field(s) missing";
									exit();
								}else{
									if($this->input->post('picture') && $this->input->post('picture') != "undefined"){
										$thumb = $this->_createThumbnail('./assets/uploads/users/' . $this->input->post('picture'), './assets/uploads/users/thumb');
										$value['details']['picture']		= $this->input->post('picture');
										$value['details']['thumbnail']		= $thumb["dst_file"];
									}
									$value['details']['first_name'] 	= $this->input->post('fname');
									$value['details']['last_name'] 		= $this->input->post('lname');
									$value['details']['email'] 			= $this->input->post('email');
									$value['details']['phone'] 			= $this->input->post('phone');
									if($this->input->post('password')!=""){
										$value['details']['password'] 	= md5($this->input->post('password'));
									}

									if($this->input->post('passcode')){
										$value['details']['passcode'] 	= $this->input->post('passcode');
									}
									$value['details']['consumer_key'] 			= $this->input->post('consumer_key');
									$value['details']['consumer_secret'] 			= $this->input->post('consumer_secret');
									$value['details']['access_token'] 			= $this->input->post('access_token');
									$value['details']['access_secret'] 			= $this->input->post('access_secret');
									$value['details']['modified_date'] 	= date('Y-m-d');
									$value['details']['modified_by']	= $this->session->userdata("clms_front_userid");
									$this->dashboardmodel->updateuser($userid,$value['details']);
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
								$userid = $this->session->userdata("clms_front_userid");
								$query = $this->dashboardmodel->getuser($userid);
								if($query->num_rows()>0){
									$data["row"] = $query->row();
									$this->load->view('editprofile',$data);
								}else{
									echo 'no';	
								}
							}
						}else{
							$this->session->set_flashdata('error','Please login with your username and password');
							redirect('login','location');
						}		
					}	
					
					function upgrade($company_id){
						$this->form_validation->set_rules('package','Pacakge','required');
						$this->form_validation->set_rules('order_term','Order Term','required');
						$this->form_validation->set_rules('txt_package_price','Price','required');
						if($this->form_validation->run()!=FALSE){
				
				
							if($this->input->post('order_term') == '1 Month'){
								$expiry = strtotime(" +1 month");
							}elseif($this->input->post('order_term') == '3 Months'){
								$expiry = strtotime(" +3 months");
							}elseif($this->input->post('order_term') == '6 Months'){
								$expiry = strtotime(" +6 months");
							}elseif($this->input->post('order_term') == '12 Months'){
								$expiry = strtotime(" +12 months");
							}
				
							
							$package = array(
								"user_id" => $company_id,
								"package_id"   => $this->input->post('package'),
								"order_term"   => $this->input->post('order_term'),
								"package_price"   => $this->input->post('txt_package_price'),
								"added_date" => date("Y-m-d"),
								"expiry_date" => date("Y-m-d",$expiry)
							);
							$this->db->insert("company_package_order",$package);
							
							
				
							if($this->input->post('paymethod')=='bank'){ 
								$order_update = array(
									"package_id"   => $this->input->post('package'),
									"payment_term"   => $this->input->post('order_term'),
									"price"   => $this->input->post('txt_package_price'),
									"expiry_date" => $expiry,
									"payment_method" => 'bank',
									"invoice_status" => 'Due'
								);
								$this->companymodel->updateorder($order_update,$company_id);
								 $user_group_company_id = $this->session->userdata("clms_front_user_group_company_id"); 
				
								$company_package = array("payment_method"=>'bank',"invoice_status"=>"due");
								$this->companymodel->updatecompanyPackage($company_package,$company_id);
								//$this->companymodel->setModulePermission($this->input->post('package'),$company_id);
								$this->companymodel->setModulePermission_by_package($this->input->post('package'),$user_group_company_id,$company_id);
								$this->companymodel->sendEmailUpgrade("bank",$company_id);
							
							
								$this->session->set_flashdata("success_message","You have Successfully Updated the package on Acrm.");
								redirect('company/profile/'.$company_id,'location');
							}elseif($this->input->post('paymethod')=='stripe'){
								$amount = $this->input->post('txt_package_price');
								$respose = $this->stripe_payment($amount,$company_id);
							
							
							}
				
							$this->session->set_flashdata('success_message', 'You have Successfully Updated the package on Acrm.');
							redirect('company/profile/'.$company_id,'location');
						}else{
							$type = $this->input->get("type");
							
							$data['company'] = $this->companymodel->getdata($company_id)->row();
							$data['package'] = $this->companymodel->getPackageDetail($data['company']->package_id);
							if($type=='renew')
								$data['packages'] = $this->companymodel->listPackages();
							else
								$data['packages'] = $this->companymodel->listPackages($data['company']->package_id);
							$data['page'] 			= 'upgrade';
							$this->load->vars($data);
							$this->load->view($this->container);
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
							$company_package = $this->companymodel->getCompanyPackage($company_id);
							$order_update = array(
								"package_id"   => $company_package->package_id,
								"payment_term"   => $company_package->order_term,
								"price"   => $company_package->package_price,
								"expiry_date" => strtotime($company_package->expiry_date),
								"payment_method" => 'Stripe',
								"invoice_status" => 'Paid',
								"transaction_id" => $transaction_id
							);
							$this->companymodel->updateorder($order_update,$company_id);
				
						
							$user_group_company_id = $this->session->userdata("clms_front_user_group_company_id");
							$company_package = array("payment_method"=>'Stripe',"invoice_status"=>"Paid","txn_number" => $transaction_id);
							$this->companymodel->updatecompanyPackage($company_package,$company_id);
							$this->companymodel->setModulePermission_by_package($this->input->post('package'),$user_group_company_id,$company_id);
							$this->companymodel->sendEmailUpgrade("Stripe",$company_id);
							$this->session->set_flashdata("success_message","You have Successfully Updated the package on Acrm.");
				
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
						redirect('company/profile/'.$company_id,'location');
					}
				
				}

				?>