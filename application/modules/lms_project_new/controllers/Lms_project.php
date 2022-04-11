<?php
class Lms_project extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('lms_projectmodel');
        $this->load->model('task/taskmodel');
        $this->load->model('project/projectmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'LMS_PROJECT';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('lms_project/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            if($this->input->get("reps"))
                $reps = $this->input->get("reps");
            else
                $reps = '';
            if($this->input->get("status"))
                $status = $this->input->get("status");
            else
                $status = '';
            if($this->input->get("priority"))
                $priority = $this->input->get("priority");
            else
                $priority = '';

            
            if($this->input->get("start_date")){
                $start_date = $this->input->get('start_date');

                $dates = explode("/", $start_date);
                $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
                $start = strtotime($date);
            }else{
                $start_date = '';
                $start = '';
            }
            if($this->input->get("end_date")){
                $end_date = $this->input->get('end_date');
                $dates1 = explode("/", $end_date);
                $date1 = $dates1[1].'/'.$dates1[0].'/'.$dates1[2]; 
                $end = strtotime($date1);
            }
            else{
                $end_date = '';
                $end = '';
            }
            $data['search_reps'] = $reps;
            $data['search_status'] = $status;
            $data['search_priority'] = $priority;
            $data['search_start_date'] = $start_date;
            $data['search_end_date'] = $end_date;
            $data['tasks'] 	= $this->lms_projectmodel->listall($reps,$status,$start,$end);
            //echo $this->db->last_query(); die();
            $data["users"] = $this->lms_projectmodel->get_users();
            $data["status"] = $this->lms_projectmodel->get_task_status();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function callendar(){
        $id = $this->uri->segment(3);
        $data['tasks']     = $this->taskmodel->listalltask($id);
        $data["users"] = $this->taskmodel->get_users();
        $data["task_status"] = $this->taskmodel->get_task_status();
        $query = $this->lms_projectmodel->getdata($id);
        if ($query->num_rows() > 0) {
            $data['result']     = $query->row();
            $data['page']          = 'callendar';
            $data['heading']    = 'Edit Chat';
            $this->load->view('main', $data);
        } else {
            redirect('lms_project/listall');
        }
    }

    function lms_callendar(){
        $data['projects']     = $this->lms_projectmodel->listall();
        $data["users"] = $this->lms_projectmodel->get_users();

        $data["status"] = $this->lms_projectmodel->get_task_status();
            //echo $this->db->last_query();die();
        $data["orders"] = $this->lms_projectmodel->get_orders();
        $data['form'] = $this->lms_projectmodel->get_form();
        $data['page']          = 'lms_callendar';
        $data['heading']    = 'Edit Chat';
        $this->load->view('main', $data);

    }

    //--------------------------------------add--------------------------------------	
    function add() {

        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {
               if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }
            $data_post = $_POST;
            $user_assigned = $this->input->post("assign_to");
            $userdata = $this->session->userdata("clms_front_userid");
            $date = date("Y-m-d");
            $data['values']['is_existing']      = $this->session->userdata("is_existing");
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['task_name']	= $this->input->post('name');
            $data['values']['task_detail']   = $this->input->post('details');
            $data['values']['form_post']   = serialize($data_post);

            $data['values']['task_status']   = $this->input->post('status');
            $data['values']['order_id']   = $this->input->post('project_order');
            $dates = $this->input->post('start_date');
            $dates = explode("/", $dates);
            $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
            $data['values']['start_date']   = strtotime($date);
            $dates1 = $this->input->post('end_date');
            $dates1 = explode("/", $dates1);
            $date1 = $dates1[1].'/'.$dates1[0].'/'.$dates1[2]; 
            $data['values']['end_date']   = strtotime($date1);
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->lms_projectmodel->add($data['values']);
            $projectid = $this->db->insert_id();
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Lms Project",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            foreach ($user_assigned as $key => $value) {
                $insert_array = array("project_id"=> $projectid, "user_id" => $value);
                $this->db->insert("lms_project_assigned_user",$insert_array);
                $rcust    = $this->taskmodel->get_userdetails($value);
                if(count($rcust) > 0 && ($this->input->post('status') != 2)){
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
                    //$this->email->to('bikash.suwal01@gmail.com');
                    $row = $this->mylibrary->getCompanyEmailTemplate(4,$this->session->userdata("clms_front_companyid"));
                    $subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
                    $this->email->subject($subject);
                    $message = str_replace('[NAME]',$customer,html_entity_decode($row->email_message,ENT_COMPAT));
                    $message = str_replace('[SITE_NAME]',$fromname,$message);
                    $message = str_replace('[LOGO]',$logo,$message);
                    $message = str_replace('[SITE_ADDRESS]',$address,$message);
                    $message = str_replace('[SITE_PHONE]',$phone,$message);
                    $message = str_replace('[SITE_FAX]',$fax,$message);
                    $message = str_replace('[SITE_EMAIL]',$sitemail,$message);
                    $message = str_replace('[SITE_URL]',$site_url,$message);
                    $message = str_replace('[PROJECT_NAME]',$this->input->post('name'),$message);
                    $message = str_replace('[PROJECT_DETAIL]',$this->input->post('details'),$message);
                    $message = str_replace('[YEAR]',date('Y'),$message);

                    $company = $this->usermodel->getuser($this->session->userdata("clms_front_companyid"))->row();
                    $message = str_replace('[COMPANY_NAME]',@$company->company_name,$message);
                    $message = str_replace('[COMPANY_ADDRESS]',@$company->address,$message);

                    $this->email->message($message);
                    $this->email->send();
                    $this->email->clear();
                }
            }

            $notifications = array(
                "content" => $this->session->userdata("username").' has assigned Project '.$this->input->post('name').' to you.',
                "link" => 'lms_project/task/'.$projectid,
                "project_id" => $projectid
                );
            $this->db->insert("notifications",$notifications);



            $this->session->set_flashdata('success_message', 'Project added successfully');
            if(strpos($_SERVER["HTTP_REFERER"], 'callendar') === false)
                redirect('lms_project/task/'.$projectid);
            else
                redirect($_SERVER["HTTP_REFERER"]);

        }else{
            $data["users"] = $this->lms_projectmodel->get_users();
            
            $data["status"] = $this->lms_projectmodel->get_task_status();
            //echo $this->db->last_query();die();
            $data["orders"] = $this->lms_projectmodel->get_orders();
            $data['form'] = $this->lms_projectmodel->get_form();
            $data['page'] = 'add';
            $data['heading'] = 'Add Chat Name';
            $this->load->vars($data);
            $this->load->view($this->container);
        }
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}


function get_projectUser(){
    $project_id = $this->input->post("project_id");
    $this->db->where("project_id",$project_id);
    $query = $this->db->get("lms_project_assigned_user")->result();
    echo json_encode($query);
}

function getOrderdetail(){
    $orderid = $this->input->post("orderid");
    $order = $this->lms_projectmodel->get_order_customer($orderid);
    echo 'Name: '.$order->customer_name.'<br>Email: '.$order->email.'<br>Contact No: '.$order->contact_number;
}

function edit(){
 if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
    if ($this->input->post('submit')) {
        $id = $this->input->post('task_id');
        $user_assigned = $this->input->post("assign_to");
        $userdata = $this->session->userdata("clms_front_userid");
        $data['values']['is_existing']      = $this->input->post("is_existing");
        $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
        $data['values']['task_name']    = $this->input->post('name');
        $data['values']['task_detail']   = $this->input->post('details');

        $data['values']['task_status']   = $this->input->post('status');
        $data['values']['order_id']   = $this->input->post('project_order');
        $dates = $this->input->post('start_date');
        $dates = explode("/", $dates);
        $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
        $data['values']['start_date']   = strtotime($date);
        $dates1 = $this->input->post('end_date');
        $dates1 = explode("/", $dates1);
        $date1 = $dates1[1].'/'.$dates1[0].'/'.$dates1[2]; 
        $data['values']['end_date']   = strtotime($date1);
        $data['values']['modified_date']    = time();
        $data['values']['modified_by']      = $userdata;
        $this->lms_projectmodel->update($id, $data['values']);
        $this->db->where("project_id",$id);
        $this->db->delete("lms_project_assigned_user");
        foreach ($user_assigned as $key => $value) {
            $insert_array = array("project_id"=> $id, "user_id" => $value);
            $this->db->insert("lms_project_assigned_user",$insert_array);
        }
           // echo $this->db->last_query();
        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Edit",
            "module" => "Manage Lms Project",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);

        $this->session->set_flashdata('success_message', 'Project edited Successfully');
        if(strpos($_SERVER["HTTP_REFERER"], 'callendar') === false)
            redirect('lms_project/listall');
        else
            redirect($_SERVER["HTTP_REFERER"]);
    } else {
        $data["users"] = $this->lms_projectmodel->get_users();
        $data["status"] = $this->lms_projectmodel->get_task_status();
        $data["orders"] = $this->lms_projectmodel->get_orders();
        $data['form'] = $this->lms_projectmodel->get_form();
        $id = $this->uri->segment(3);
        $query = $this->lms_projectmodel->getdata($id);
        if ($query->num_rows() > 0) {
            $data['result']     = $query->row();
            $data['page']       = 'edit';
            $data['heading']    = 'Edit Chat';
            $this->load->view('main', $data);
        } else {
            redirect('lms_project/listall');
        }
    }
}
}

function task(){
    $id = $this->uri->segment(3);
    if ($this->session->userdata("clms_front_userid")) {
        if ($this->input->post('submit')) {
           if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
            redirect($_SERVER["HTTP_REFERER"],"refresh");
        }
        $userdata = $this->session->userdata("clms_front_userid");
        $date = date("Y-m-d");
        $data['values']['project_id']      =  $id;
        $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
        $data['values']['task_name']    = $this->input->post('name');
        $data['values']['task_detail']   = $this->input->post('details');
        //if($this->input->post('assign_to'))
          //  $data['values']['user_id']   = $this->input->post('assign_to');
      // else
         //   $data['values']['user_id']   = $userdata;
        $data['values']['task_status']   = $this->input->post('status');
        $data['values']['priority']   = $this->input->post('priority');
        $dates = $this->input->post('start_date');
        $dates = explode("/", $dates);
        $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
        $data['values']['start_date']   = strtotime($date);
        $dates1 = $this->input->post('end_date');
        $dates1 = explode("/", $dates1);
        $date1 = $dates1[1].'/'.$dates1[0].'/'.$dates1[2]; 
        $data['values']['end_date']   = strtotime($date1);
        $data['values']['added_date']       = time();
        $data['values']['added_by']         = $userdata;
        $data['values']['modified_date']    = time();
        $data['values']['modified_by']      = $userdata;
        $data['values']['status']      = 1;
        $this->taskmodel->add($data['values']);
        $taskid = $this->db->insert_id();

        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Add",
            "module" => "Manage Task",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $assign_users = $this->input->post('assign_to');
        foreach ($assign_users as $key=>$val) {
            $taskusers = array(
                "task_id" => $taskid,
                "user_id" => $val
                );
            $this->db->insert("task_assigned_user",$taskusers);
            $customer_id = $val;
            $rcust    = $this->taskmodel->get_userdetails($customer_id);
            if(count($rcust) > 0 && ($this->input->post('status') != 2)){
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
                $row = $this->mylibrary->getCompanyEmailTemplate(4,$this->session->userdata("clms_front_companyid"));
                $subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
                $this->email->subject($subject);
                $message = str_replace('[NAME]',$customer,html_entity_decode($row->email_message,ENT_COMPAT));
                $message = str_replace('[SITE_NAME]',$fromname,$message);
                $message = str_replace('[LOGO]',$logo,$message);
                $message = str_replace('[SITE_ADDRESS]',$address,$message);
                $message = str_replace('[SITE_PHONE]',$phone,$message);
                $message = str_replace('[SITE_FAX]',$fax,$message);
                $message = str_replace('[SITE_EMAIL]',$sitemail,$message);
                $message = str_replace('[SITE_URL]',$site_url,$message);
                $message = str_replace('[TASK_NAME]',$this->input->post('name'),$message);
                $message = str_replace('[TASK_DETAIL]',$this->input->post('details'),$message);
                $message = str_replace('[YEAR]',date('Y'),$message);

                $company = $this->usermodel->getuser($this->session->userdata("clms_front_companyid"))->row();
                $message = str_replace('[COMPANY_NAME]',@$company->company_name,$message);
                $message = str_replace('[COMPANY_ADDRESS]',@$company->address,$message);

                $this->email->message($message);
                $this->email->send();
                $this->email->clear();
            }
        }
        $this->session->set_flashdata('success_message', 'Task added successfully');
      //  if(strpos($_SERVER["HTTP_REFERER"], 'callendar') === false)
         //   redirect('task/listall');
       // else

        $notifications = array(
            "content" => $this->session->userdata("username").' has assigned Task '.$this->input->post('name').' to you.',
            "link" => 'task/task_detail/'.$taskid,
            "project_id" => $id,
            "notification_type" => 1,
            "task_id" => $taskid
            );
        $this->db->insert("notifications",$notifications);
        redirect($_SERVER["HTTP_REFERER"]);

    }else{
        $data["users"] = $this->taskmodel->get_users();
        $data["status"] = $this->taskmodel->get_task_status();
        $data['tasks']  = $this->taskmodel->listallwithproject($id);
        $query = $this->lms_projectmodel->getdata($id);
        if ($query->num_rows() > 0) {
            $data['result']     = $query->row();
            $data['page']       = 'task';
            $data['heading']    = 'Edit Chat';
            $this->load->view('main', $data);
        } else {
            redirect('lms_project/listall');
        }
    }
} else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
}
}

function edit_task(){
    if ($this->session->userdata("clms_front_userid") != "" ) {
        $data["users"] = $this->taskmodel->get_users();
        $data["status"] = $this->taskmodel->get_task_status();
        $id = $this->uri->segment(3);
        $query = $this->taskmodel->getdata($id);
        if ($query->num_rows() > 0) {
            $data['result']     = $query->row();
            $data['heading']    = 'Edit Chat';
            $this->load->view('edit_task', $data);
        } else {
            redirect('task/listall');
        }

    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }

}

function discussion(){
    $id = $this->uri->segment(3);
    if($this->input->post("submit")){
        $userdata = $this->session->userdata("clms_front_userid");
        $discussion = array(
            "discussion_title" => $this->input->post("discussion_title"),
            "discussion_description" => $this->input->post("discussion_description"),
            "discussion_satus" => $this->input->post("discussion_status"),
            "project_id" => $id,
            "added_by" => $userdata,
            "added_date" => time()
            );
        $this->db->insert("lms_project_discussion",$discussion);
        $discussion_id = $this->db->insert_id();
        $notifications = array(
            "content" => $this->session->userdata("username").' has added Discussion '.$this->input->post('discussion_title'),
            "link" => 'lms_project/discussion_detail/'.$discussion_id,
            "project_id" => $id,
            "notification_type" => 2
            );
        $this->db->insert("notifications",$notifications);
        $this->session->set_flashdata('success_message', 'Discussion added successfully');
        redirect($_SERVER["HTTP_REFERER"]);
    }else{
        $query = $this->lms_projectmodel->getdata($id);
        $data["status"] = $this->lms_projectmodel->get_task_status();
        if ($query->num_rows() > 0) {
            $data['result']     = $query->row();
            $data['page']       = 'discussion';
            $data['heading']    = 'Edit Chat';
            $this->load->view('main', $data);
        } else {
            redirect('lms_project/listall');
        }
    }
}

function delete_discussion(){
    $id = $this->uri->segment(3);
    $this->db->where("discussion_id",$id);
    $this->db->delete("lms_project_discussion");
    $this->session->set_flashdata('success_message', 'Record deleted successfully');
    redirect($_SERVER["HTTP_REFERER"]);
}

function discussion_detail(){
    $id = $this->uri->segment(3);
    $data['discussion'] = $this->lms_projectmodel->getDiscussionDetail($id);
    $this->load->view("discussion_detail",$data);
}

function add_discussionupdate(){
    $userdata = $this->session->userdata("clms_front_userid");
    $id = $this->input->post("discussion_id");
    $discussion = array(
        "discussion_description" => $this->input->post("details123"),
        "added_by" => $userdata,
        "added_date" => time(),
        "parent_id" => $id
        );
    $notifications = array(
        "content" => $this->session->userdata("username").' has added update on  '.$this->input->post('discussion_name'),
        "link" => 'lms_project/discussion_detail/'.$id,
        "project_id" => $this->input->post("project_id"),
        "notification_type" => 2
        );
    $this->db->insert("notifications",$notifications);
    $config['upload_path'] = './uploads/lms_project';
    $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xml|rar|zip';
    $config['max_width'] = 0;
    $config['max_height'] = 0;
    $config['max_size'] = 0;
    $config['encrypt_name'] = FALSE;
    $this->upload->initialize($config);
    $this->load->library('upload', $config);


    if ( ! $this->upload->do_upload('task_file'))
    {
        $error = array('error' => $this->upload->display_errors());
        //print_r($error); 


    }
    else
    {
        $arr_image = $this->upload->data();
        $discussion['file_name']      = $arr_image['file_name'];


    }
    $this->db->insert("lms_project_discussion",$discussion);
    $this->session->set_flashdata('success_message', 'Discussion update added successfully');
    redirect($_SERVER["HTTP_REFERER"]);
}

function testing(){ 
    $id = $this->uri->segment(3);
    if($this->input->post("submit")){
        $userdata = $this->session->userdata("clms_front_userid");
        $config['upload_path'] = './uploads/lms_project';
        $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xml|rar|zip';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['max_size'] = 0;
        $config['encrypt_name'] = FALSE;
        $this->upload->initialize($config);
        $this->load->library('upload', $config);

        if($this->input->post("testing_description")!="")
            $data['testing']['test_description']      = $this->input->post("testing_description");
        if ( ! $this->upload->do_upload('testing_file'))
        {
            $error = array('error' => $this->upload->display_errors());
               // print_r($error); die();


        }
        else
        {
            $arr_image = $this->upload->data();
            $data['testing']['testing_file']      = $arr_image['file_name'];


        }
        if(isset($data['testing'])){
         $data['testing']['project_id']      = $id;
         $data['testing']['added_by']      = $userdata;
         $data['testing']['added_date']      = time();

         $this->db->insert("lms_project_testing",$data['testing']);
     }
     $testid = $this->db->insert_id();
     $notifications = array(
        "content" => $this->session->userdata("username").' has added Testing '.$this->input->post('testing_description'),
        "link" => 'lms_project/testing_detail/'.$testid,
        "project_id" => $id,
        "notification_type" => 3
        );
     $this->db->insert("notifications",$notifications);
     $this->session->set_flashdata('success_message', 'Testing Description added successfully');
     redirect($_SERVER["HTTP_REFERER"]);
 }else{
    $query = $this->lms_projectmodel->getdata($id);
    if ($query->num_rows() > 0) { 
        $data['result']     = $query->row();
        $data['page']       = 'testing';
        $data['heading']    = 'Edit Chat';
        $this->load->view('main', $data);
    } else {
        redirect('lms_project/listall');
    }
}
}

function delete_testing(){
    $id = $this->uri->segment(3);
    $this->db->where("test_id",$id);
    $this->db->delete("lms_project_testing");
    $this->session->set_flashdata('success_message', 'Record deleted successfully');
    redirect($_SERVER["HTTP_REFERER"]);
}

function testing_detail(){
    $id = $this->uri->segment(3);
    $data['discussion'] = $this->lms_projectmodel->getTestingDetail($id);
    $this->load->view("testing_detail",$data);
}

function add_testingupdate(){
    $userdata = $this->session->userdata("clms_front_userid");
    $id = $this->input->post("discussion_id");
    $discussion = array(
        "test_description" => $this->input->post("details123"),
        "added_by" => $userdata,
        "added_date" => time(),
        "parent_id" => $id
        );
    $config['upload_path'] = './uploads/lms_project';
    $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xml|rar|zip';
    $config['max_width'] = 0;
    $config['max_height'] = 0;
    $config['max_size'] = 0;
    $config['encrypt_name'] = FALSE;
    $this->upload->initialize($config);
    $this->load->library('upload', $config);


    if ( ! $this->upload->do_upload('task_file'))
    {
        $error = array('error' => $this->upload->display_errors());
        //print_r($error); 


    }
    else
    {
        $arr_image = $this->upload->data();
        $discussion['testing_file']      = $arr_image['file_name'];


    }
    $this->db->insert("lms_project_testing",$discussion);
    $notifications = array(
        "content" => $this->session->userdata("username").' has added testing update.',
        "link" => 'lms_project/testing_detail/'.$id,
        "project_id" => $this->input->post("project_id"),
        "notification_type" => 3
        );
    $this->db->insert("notifications",$notifications);
    $this->session->set_flashdata('success_message', 'Testing update added successfully');
    redirect($_SERVER["HTTP_REFERER"]);
}

function add_fileupdate(){
    $userdata = $this->session->userdata("clms_front_userid");
    $id = $this->input->post("discussion_id");
    $discussion = array(
        "file_title" => $this->input->post("details123"),
        "added_by" => $userdata,
        "added_date" => time(),
        "parent_id" => $id
        );
    $config['upload_path'] = './uploads/lms_project';
    $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xml|rar|zip';
    $config['max_width'] = 0;
    $config['max_height'] = 0;
    $config['max_size'] = 0;
    $config['encrypt_name'] = FALSE;
    $this->upload->initialize($config);
    $this->load->library('upload', $config);


    if ( ! $this->upload->do_upload('task_file'))
    {
        $error = array('error' => $this->upload->display_errors());
        //print_r($error); 


    }
    else
    {
        $arr_image = $this->upload->data();
        $discussion['file_name']      = $arr_image['file_name'];


    }
    $this->db->insert("lms_project_files",$discussion);

    $notifications = array(
        "content" => $this->session->userdata("username").' has uploaded file on '.$this->input->post("file_name"),
        "link" => 'lms_project/file_detail/'.$id,
        "project_id" => $this->input->post("project_id"),
        "notification_type" => 4
        );
    $this->db->insert("notifications",$notifications);

    $this->session->set_flashdata('success_message', 'File update added successfully');
    redirect($_SERVER["HTTP_REFERER"]);
}

function delete_file(){
    $id = $this->uri->segment(3);
    $this->db->where("file_id",$id);
    $this->db->delete("lms_project_files");
    $this->session->set_flashdata('success_message', 'Record deleted successfully');
    redirect($_SERVER["HTTP_REFERER"]);
}

function file_detail(){
    $id = $this->uri->segment(3);
    $data['discussion'] = $this->lms_projectmodel->getFileDetail($id);
    $this->load->view("file_detail",$data);
}

function file(){
    $id = $this->uri->segment(3);
    if($this->input->post("submit")){
        $userdata = $this->session->userdata("clms_front_userid");
        $config['upload_path'] = './uploads/lms_project';
        $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xml|rar|zip';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['max_size'] = 0;
        $config['encrypt_name'] = FALSE;
        $this->upload->initialize($config);
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('project_file'))
        {
            $error = array('error' => $this->upload->display_errors());

        }
        else
        {
            $arr_image = $this->upload->data();
            $project_file = array(
                "file_title" => $this->input->post("file_title"),
                "file_name" => $arr_image['file_name'],
                "project_id" => $id,
                "added_by" => $userdata,
                "added_date" => time()
                );
            $this->db->insert("lms_project_files",$project_file);
            $fileid = $this->db->insert_id();
            $notifications = array(
                "content" => $this->session->userdata("username").' has uploaded file '.$this->input->post('file_title'),
                "link" => 'lms_project/file_detail/'.$fileid,
                "project_id" => $id,
                "notification_type" => 4
                );
            $this->db->insert("notifications",$notifications);
        }
        $this->session->set_flashdata('success_message', 'File added successfully');
        redirect($_SERVER["HTTP_REFERER"]);
    }else{
        $query = $this->lms_projectmodel->getdata($id);
        if ($query->num_rows() > 0) { 
            $data['result']     = $query->row();
            $data['page']       = 'upload';
            $data['heading']    = 'Edit Chat';
            $this->load->view('main', $data);
        } else {
            redirect('lms_project/listall');
        }
    }
}

    //---------------------------------edit--------------------------------------

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("task_id"=>$delid);
        $content = $this->usermodel->getDeletedData('task',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Project",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->lms_projectmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('lms_project/listall');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------detail---------------------------------
function task_detail() {
    if ($this->session->userdata("clms_front_userid") != "" ) {
        $id = $this->uri->segment(3);
        $query = $this->lms_projectmodel->getdata($id);
        $data['result'] = $query->row();
        $this->load->view('detail_task', $data);

    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }

}

function cascadeAction() {
    $data = $_POST['object'];
    $ids = $data['ids'];
    $action = $data['action'];

    foreach ($ids as $key => $delid) {
        $cond = array("task_id"=>$delid);
        $content = $this->usermodel->getDeletedData('task',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Project",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->lms_projectmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}



}