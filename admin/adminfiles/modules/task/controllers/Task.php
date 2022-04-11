<?php
class Task extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('taskmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'TASK';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('task/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function data_migrate(){
        $query = $this->db->get("task")->result();
        foreach ($query as $row ) {
           if($row->user_id > 0){
            $tasks = array("task_id"=>$row->task_id,"user_id"=>$row->user_id);
            $this->db->insert("task_assigned_user",$tasks);
        }
    }
}

    //----------------------------------------listall--------------------------------------------------	
function listall() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
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
            $start = strtotime($start_date);
        }else{
            $start_date = '';
            $start = '';
        }
        if($this->input->get("end_date")){
            $end_date = $this->input->get('end_date');
            $end = strtotime($end_date);
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
        $data['tasks'] 	= $this->taskmodel->listall($reps,$status,$priority,$start,$end);
        //  echo $this->db->last_query(); die();
        $data["users"] = $this->taskmodel->get_users();
        $data["status"] = $this->taskmodel->get_task_status();
        $data["projects"] = $this->taskmodel->getProjects();
        $data["priorities"] = $this->taskmodel->getPriority();
        $data['page'] 			= 'list';
        $this->load->vars($data);
        $this->load->view($this->container);
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

function callendar(){
    $data['tasks']     = $this->taskmodel->listall();
    $data["users"] = $this->taskmodel->get_users();
    $data["task_status"] = $this->taskmodel->get_task_status();
    $data['page']          = 'callendar';
    $this->load->vars($data);
    $this->load->view($this->container);
}

function get_taskUser(){
    $task_id = $this->input->post("task_id");
    $this->db->where("task_id",$task_id);
    $query = $this->db->get("task_assigned_user")->result();
    echo json_encode($query);
}

    //--------------------------------------add--------------------------------------	
function add() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
        if ($this->input->post('submit')) {
         if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
            redirect($_SERVER["HTTP_REFERER"],"refresh");
        }
        $userdata = $this->session->userdata("clms_userid");
        $date = date("Y-m-d");
        $data['values']['company_id']      = $this->session->userdata("clms_company");
        // $data['values']['project_id']   = 0;
        $data['values']['task_name']	= $this->input->post('name');
        $data['values']['task_detail']   = $this->input->post('details');
        $data['values']['assign_to']   = $this->input->post('assign_to');
        $data['values']['assign_by']   = $this->input->post('assign_by');
        $data['values']['task_status']   = $this->input->post('status');
        $data['values']['priority']   = $this->input->post('priority');
       
        $data['values']['start_date']   = strtotime($this->input->post('start_date'));
        $data['values']['end_date']   = strtotime($this->input->post('end_date'));
        $data['values']['added_date'] 		= time();
        $data['values']['added_by'] 		= $userdata;
        $data['values']['modified_date'] 	= time();
        $data['values']['modified_by'] 		= $userdata;
        $data['values']['status']      = 1;
        $this->taskmodel->add($data['values']);
        $taskid = $this->db->insert_id();
        $notifications = array(
            "content" => $this->session->userdata("username").' has assigned Task '.$this->input->post('name').' to you.',
            "link" => 'task/task_detail/'.$taskid,
            // "project_id" => $this->input->post('project_id'),
            "notification_type" => 1,
            "task_id" => $taskid
            );
        $this->db->insert("notifications",$notifications);

        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Add",
            "module" => "Manage Task",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);

        $val = $this->input->post('assign_to');
    
            $customer_id = $val;
            $rcust    = $this->taskmodel->get_userdetails($customer_id);
            if(!empty($rcust) > 0){
                $customer = $rcust->first_name.' '.$rcust->last_name;   
                $from     = $this->mylibrary->getSiteEmail(32);
                $site_url = $this->mylibrary->getSiteEmail(21);
                $fromname = $this->mylibrary->getSiteEmail(20);
                $address  = $this->mylibrary->getSiteEmail(25);
                $phone    = $this->mylibrary->getSiteEmail(27);
                $fax      = $this->mylibrary->getSiteEmail(28);
                $logo     = $this->mylibrary->getlogo();
                $sitemail = $this->mylibrary->getSiteEmail(23);
                $noreplyemail = $this->mylibrary->getSiteEmail(22);
                $company = $this->usermodel->getuser($this->session->userdata("clms_company"))->row();
                $this->email->set_mailtype('html');
                $this->email->from($noreplyemail, $fromname);
                $this->email->reply_to($company->email);
                $this->email->to($rcust->email);
                $row = $this->mylibrary->getCompanyEmailTemplate(4,$this->session->userdata("clms_company"));
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

               
                $message = str_replace('[COMPANY_NAME]',$company->company_name,$message);
                $message = str_replace('[COMPANY_ADDRESS]',$company->address,$message);

                $this->email->message($message);
                $this->email->send();
                $this->email->clear();
            }
    
        $this->session->set_flashdata('success_message', 'Task added successfully');
        if(strpos($_SERVER["HTTP_REFERER"], 'callendar') === false)
            redirect('task/listall');
        else
            redirect($_SERVER["HTTP_REFERER"]);

    }else{
        $data["users"] = $this->taskmodel->get_users();
        $data["status"] = $this->taskmodel->get_task_status();
        $data["priorities"] = $this->taskmodel->getPriority();
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

    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('task_id');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['task_name']    = $this->input->post('name');
            $data['values']['task_detail']   = $this->input->post('details');
            $data['values']['assign_to']   = $this->input->post('assign_to');
            $data['values']['assign_by']   = $this->input->post('assign_by');
            //$data['values']['user_id']   = $this->input->post('assign_to');
            $data['values']['task_status']   = $this->input->post('status');
            $data['values']['priority']   = $this->input->post('priority');
            $data['values']['start_date']   = strtotime($this->input->post('start_date'));
            $data['values']['end_date']   = strtotime($this->input->post('end_date'));
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->taskmodel->update($id, $data['values']);

            $this->db->where("task_id",$id);
            $this->db->delete("task_assigned_user");
            // $assign_users = $this->input->post('assign_to');
            // foreach ($assign_users as $key=>$val) {
            //     $taskusers = array(
            //         "task_id" => $id,
            //         "user_id" => $val
            //         );
            //     $this->db->insert("task_assigned_user",$taskusers);
            // }

            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Task",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Task edited Successfully');
            
            redirect('task/listall');
        } else {
            $data["users"] = $this->taskmodel->get_users();
            $data["status"] = $this->taskmodel->get_task_status();
            $data["projects"] = $this->taskmodel->getProjects();
            $data["priorities"] = $this->taskmodel->getPriority();
            $id = $this->uri->segment(3);
            $query = $this->taskmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('task/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("task_id"=>$delid);
        $content = $this->usermodel->getDeletedData('task',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Task",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->taskmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect($_SERVER["HTTP_REFERER"]);
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------detail---------------------------------
function task_detail() {
    if ($this->session->userdata("clms_userid") != "" ) {
        $id = $this->uri->segment(3);
        $query = $this->taskmodel->getdata($id);
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
            "module" => "Manage Task",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->taskmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

function complete(){
    $tasks = $this->input->post("taskid");
        //$lists = $this->input->post("tasklist");
    if($this->input->post("complete")){
        foreach ($tasks as $key=>$val) {
            if($this->input->post("tasklist".$val)){
                $task_detail = $this->taskmodel->getdata($val)->row();
                if($task_detail->task_status != 4){
                    $notifications = array(
                        "content" => $this->session->userdata("username").' has Completed Task '.$task_detail->task_name,
                        "link" => 'task/task_detail/'.$val,
                        "project_id" => $task_detail->project_id,
                        "notification_type" => 1,
                        "task_id" => $val
                        );
                    $this->db->insert("notifications",$notifications);
                }
                $this->db->set("task_status",4);
            }else{
                $this->db->set("task_status",3);
            }
            $this->db->where("task_id",$val);
            $this->db->update("task");

        }
        //die('halt');
    }else{ 
        foreach ($tasks as $key=>$val) {
            if($this->input->post("tasklist".$val)){
                $this->db->set("is_completed",1);
            }else{
                $this->db->set("is_completed",0);
            }
            $this->db->where("task_id",$val);
            $this->db->update("task");
        }

    }
    redirect("dashboard","");
}

function add_update(){
    if($this->input->post("submit")){
        $task = array(
            "task_id" => $this->input->post("task_id"),
            "content" => $this->input->post("details123"),
            "added_date" => time(),
            "added_by" => $this->session->userdata("clms_userid")
            );

        $config['upload_path'] = '../uploads/lms_project';
        $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xml|rar|zip';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['max_size'] = 0;
        $config['encrypt_name'] = FALSE;
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
       // echo $_FILES['task_file']['type']; die();
        
        if ( ! $this->upload->do_upload('task_file'))
        {
            $error = array('error' => $this->upload->display_errors());
           // print_r($error); die();


        }
        else
        {
            $arr_image = $this->upload->data();
            $task['file_name']      = $arr_image['file_name'];


        }
        //print_r($task); die();
        $this->db->insert("task_update",$task);
        $notifications = array(
            "content" => $this->session->userdata("username").' has added task update on  '.$this->input->post('project_name'),
            "link" => 'task/task_detail/'.$this->input->post("task_id"),
            "project_id" => $this->input->post("project_id"),
            "task_id" => $this->input->post("task_id"),
            "notification_type" => 1
            );
        $this->db->insert("notifications",$notifications);
        $logs = array(
            "content" => serialize($task),
            "action" => "Add Update",
            "module" => "Manage Task",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
        $users = array();
        $task_user = $this->taskmodel->getdata($this->input->post("task_id"))->row();
            //print_r($task_user); die();
        array_push($users, $task_user->user_id);
        array_push($users, $task_user->added_by);
        $users_update = $this->taskmodel->gettaskusers($this->input->post("task_id"));
        foreach ($users_update as $row) {
            array_push($users, $row->added_by);
        }
        $users = array_unique($users);
            //print_r($users); die();
        $emailcus    = $this->taskmodel->get_userdetails($this->session->userdata("clms_userid"));
        foreach ($users as $key => $value) {
         $customer_id = $this->input->post('assign_to');
         /************* send activation email to customer ************/
         $rcust    = $this->taskmodel->get_userdetails($value);
         $customer = @$rcust->first_name.' '.@$rcust->last_name;   
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
         $this->email->to(@$rcust->email);
        // $this->email->to('bikash.suwal01@gmail.com');
         $row = $this->mylibrary->getCompanyEmailTemplate(1,$this->session->userdata("clms_company"));
         $subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
         $this->email->subject($subject);
         $message = str_replace('[NAME]',$customer,html_entity_decode($row->email_message,ENT_COMPAT));
         $message = str_replace('[USER_NAME]',$emailcus->first_name.' '.$emailcus->last_name,$message);
         $message = str_replace('[SITE_NAME]',$fromname,$message);
         $message = str_replace('[LOGO]',$logo,$message);
         $message = str_replace('[SITE_ADDRESS]',$address,$message);
         $message = str_replace('[SITE_PHONE]',$phone,$message);
         $message = str_replace('[SITE_FAX]',$fax,$message);
         $message = str_replace('[SITE_EMAIL]',$sitemail,$message);
         $message = str_replace('[SITE_URL]',$site_url,$message);
         $message = str_replace('[COMMENT]',$this->input->post("details123"),$message);
               //$message = str_replace('[TASK_DETAIL]',$this->input->post('details'),$message);
         $message = str_replace('[YEAR]',date('Y'),$message);
         $company = $this->usermodel->getuser($this->session->userdata("clms_company"))->row();
         $message = str_replace('[COMPANY_NAME]',$company->company_name,$message);
         $message = str_replace('[COMPANY_ADDRESS]',$company->address,$message);
         //echo $message;die();
         $this->email->message($message);
         $this->email->send();
         $this->email->clear();
     }

     $this->session->set_flashdata('success_message', 'Update has been successfully Added.');
     redirect($_SERVER["HTTP_REFERER"]);
 }
}

}