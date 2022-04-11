<?php
class installer extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('installermodel');
        $this->load->model('users/usermodel');
        $this->load->model('customer/customermodel');
        $this->module_code = 'installer';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('installer/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['status'] 	= $this->installermodel->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function checkemail(){
        $userid = $this->session->userdata("clms_front_userid");
        $email = $this->input->post("email");
        //$action = $this->input->post("action");
        $this->db->where("email",$email);
        if($this->input->post("userid")){
            $this->db->where("userid !=",$this->input->post("userid"));
        }
        if($this->db->get("pnp_users")->num_rows() > 0)
            echo 'User with this email is already existed. Please use another.';
        else
            echo '';
    }

    //--------------------------------------add--------------------------------------	
    function add() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {
                if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
                    redirect($_SERVER["HTTP_REFERER"],"refresh");
                }

                $userdata = $this->session->userdata("clms_front_userid");

                $user = [
                    "company_id" => $this->session->userdata("clms_front_companyid"),
                    "company_name" => $this->input->post('company_name'),
                    "first_name" => $this->input->post('first_name'),
                    "last_name" => $this->input->post('last_name'),
                    "email" => $this->input->post('email'),
                    "phone" => $this->input->post('phone'),
                    "address" => $this->input->post('address'),
                    "password" => md5($this->input->post('password')),
                    "day_gitlab" => $this->input->post('day_gitlab'),
                    "status" => 1,
                    "user_group"=>11,
                    "added_by" => $userdata
                ];
                $this->db->insert("users",$user);
                $userid = $this->db->insert_id();
                $this->usermodel->addmodulepermission(11,$userid);
                $date = date("Y-m-d");
                $data['values']['user_id']	= $userid;
                $data['values']['first_name']	= $this->input->post('first_name');
                $data['values']['last_name']    = $this->input->post('last_name');
                $data['values']['position_type']    = $this->input->post('position');
                $data['values']['email']    = $this->input->post('email');
                $data['values']['phone']    = $this->input->post('phone');
                $data['values']['mobile']    = $this->input->post('mobile');
                $data['values']['hourly_rate']    = $this->input->post('hourly_rate');
                $data['values']['description']    = $this->input->post('description');
                $data['values']['company']    = $this->input->post('company_name');
                $data['values']['abn']    = $this->input->post('abn');
                $data['values']['address']    = $this->input->post('address');
                $data['values']['suburb']    = $this->input->post('suburb');
                $data['values']['postcode']    = $this->input->post('postcode');
                $data['values']['country']    = $this->input->post('account_country');
                $data['values']['state']    = $this->input->post('state');
                $data['values']['company_id'] = $this->session->userdata("clms_front_companyid");
                $data['values']['employee_type'] = $this->input->post("employee_type");
                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= time();
                $data['values']['modified_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->installermodel->add($data['values']);
                $id = $this->db->insert_id();

                $start = $this->input->post("start_time");
                $end = $this->input->post("end_time");
                $day = $this->input->post("day_id");

                foreach($start as $key=>$val){
                    $service = array(
                        "installer_id" => $id,
                        "service_day"=> $day[$key],
                        "service_start_time" => $start[$key],
                        "service_end_time" => $end[$key],
                    );
                    $this->db->insert("service_time_available",$service);

                }

                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Add",
                    "module" => "Manage installer",
                    "added_by" => $this->session->userdata("clms_front_userid"),
                    "added_date" => time()
                );
                $this->usermodel->insertUserlog($logs);

                if($this->input->post("add_sms")){
                    $sms = array(
                        "company_id" => $this->session->userdata("clms_front_companyid"),
                        "email_address" => $this->input->post("email"),
                        "mobile_number" => $this->input->post("mobile"),
                        "name" => $this->input->post("first_name").' '.$this->input->post("last_name"),
                        "group" => "Contractor",
                        "subscription_date" => date("Y-m-d"),
                        "status" => 1
                    );

                    $this->db->insert("sms_subscription",$sms);
                }

                if($this->input->post("add_email")){
                    $email = array(
                        "company_id" => $this->session->userdata("clms_front_companyid"),
                        "email_address" => $this->input->post("email"),
                        "mobile_number" => $this->input->post("mobile"),
                        "name" => $this->input->post("first_name").' '.$this->input->post("last_name"),
                        "group" => "Contractor",
                        "subscription_date" => date("d/m/Y"),
                        "status" => 1
                    );

                    $this->db->insert("newsletter_subscription",$email);
                }

                $this->session->set_flashdata('success_message', 'Contractor added successfully');
                redirect('installer/listall');
            }else{
                $this->load->model("company/companymodel");
                $data['company_id'] = $this->session->userdata("clms_front_companyid");
                $data['countries'] = $this->customermodel->getcoutries();
                $data['states'] = $this->customermodel->getstates(13);
                $data['days'] = $this->installermodel->get_service_day();
             

                $this->load->model("position/positionmodel");

                $data['positions'] = $this->positionmodel->listall();
                $data['page'] = 'add';
                $data['heading'] = 'Add Lead Status';
                $this->load->vars($data);
                $this->load->view($this->container);
            }
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //---------------------------------edit--------------------------------------
    function edit($id = '') {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
            if ($this->input->post('submit')) {
                $id = $this->input->post('status_id');
                $userdata = $this->session->userdata("clms_front_userid");
                $data['values']['first_name']   = $this->input->post('first_name');
                $data['values']['last_name']    = $this->input->post('last_name');
                $data['values']['position_type']    = $this->input->post('position');
                $data['values']['email']    = $this->input->post('email');
                $data['values']['phone']    = $this->input->post('phone');
                $data['values']['mobile']    = $this->input->post('mobile');
                $data['values']['hourly_rate']    = $this->input->post('hourly_rate');
                $data['values']['description']    = $this->input->post('description');
                $data['values']['company']    = $this->input->post('company_name');
                $data['values']['abn']    = $this->input->post('abn');
                $data['values']['address']    = $this->input->post('address');
                $data['values']['suburb']    = $this->input->post('suburb');
                $data['values']['postcode']    = $this->input->post('postcode');
                $data['values']['country']    = $this->input->post('account_country');
                $data['values']['state']    = $this->input->post('state');
                $data['values']['company_id'] = $this->session->userdata("clms_front_companyid");
                $data['values']['employee_type'] = $this->input->post("employee_type");
                $data['values']['added_date']       = time();
                $data['values']['added_by']         = $userdata;
                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $this->installermodel->update($id, $data['values']);

                $query_user = $this->installermodel->getdata($id)->row();
                $user = [
                    "company_name" => $this->input->post('company_name'),
                    "first_name" => $this->input->post('first_name'),
                    "last_name" => $this->input->post('last_name'),
                    "email" => $this->input->post('email'),
                    "phone" => $this->input->post('phone'),
                    "address" => $this->input->post('address'),
                    "day_gitlab" => $this->input->post('day_gitlab'),
                ];
                if($this->input->post("password") != ""){
                   $user["password"] = md5($this->input->post('password'));
                }

                $this->db->where("userid",$query_user->user_id);
                $this->db->update("users",$user);

                $this->db->where("installer_id",$id);
                $this->db->delete("service_time_available");
                $start = $this->input->post("start_time");
                $end = $this->input->post("end_time");
                $day = $this->input->post("day_id");

                foreach($start as $key=>$val){
                    $service = array(
                        "installer_id" => $id,
                        "service_day"=> $day[$key],
                        "service_start_time" => $start[$key],
                        "service_end_time" => $end[$key],
                    );
                    $this->db->insert("service_time_available",$service);

                }


                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Edit",
                    "module" => "Manage installer",
                    "added_by" => $this->session->userdata("clms_front_userid"),
                    "added_date" => time()
                );
                $this->usermodel->insertUserlog($logs);


                if($this->input->post("add_sms")){
                    $sms = array(
                        "company_id" => $this->session->userdata("clms_front_companyid"),
                        "email_address" => $this->input->post("email"),
                        "mobile_number" => $this->input->post("mobile"),
                        "name" => $this->input->post("first_name").' '.$this->input->post("last_name"),
                        "group" => "Contractor",
                        "subscription_date" => date("Y-m-d"),
                        "status" => 1
                    );

                    $this->db->insert("sms_subscription",$sms);
                }

                if($this->input->post("add_email")){
                    $email = array(
                        "company_id" => $this->session->userdata("clms_front_companyid"),
                        "email_address" => $this->input->post("email"),
                        "mobile_number" => $this->input->post("mobile"),
                        "name" => $this->input->post("first_name").' '.$this->input->post("last_name"),
                        "group" => "Contractor",
                        "subscription_date" => date("d/m/Y"),
                        "status" => 1
                    );

                    $this->db->insert("newsletter_subscription",$email);
                }



                $this->session->set_flashdata('success_message', 'Contractor edited Successfully');
                redirect('installer/listall');
            } else {
                $query = $this->installermodel->getdata($id);
                if ($query->num_rows() > 0) {
                    $data['result'] 	= $query->row();
                    $userid = $data['result']->user_id;
                    $data['user'] = $this->installermodel->get_user($userid);
                    $data['countries'] = $this->customermodel->getcoutries();
                    $data['states'] = $this->customermodel->getstates($data['result']->country);
                    $this->load->model('position/positionmodel');
                    $data['positions'] = $this->positionmodel->listall();
                    $data['days'] = $this->installermodel->get_service_day();
                    $data['page'] 		= 'edit';
                    $data['heading'] 	= 'Edit Lead status';
                    $this->load->view('main', $data);
                } else {
                    redirect('installer/listall');
                }
            }
        }
    }

    //------------------------delete---------------------------------------------------------	
    function delete() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
            $delid = $this->uri->segment('3');
            $this->db->where("threatre_id",$delid);
            $installer = $this->db->get("installer")->row();
            $this->db->where("userid",$installer->user_id);
            $this->db->delete("users");
            $cond = array("threatre_id"=>$delid);
            $content = $this->usermodel->getDeletedData('installer',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => "Delete",
                "module" => "Manage installer",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
            );
            $this->usermodel->insertUserlog($logs);
            $this->installermodel->delete($delid);
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('installer/listall');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    public function details() {
       $id = $this->uri->segment(3);
       $data['installer']= $this->installermodel->getdata($id)->row();
       $this->load->view("detail",$data);
   }



   function cascadeAction() {
    $data = $_POST['object'];
    $ids = $data['ids'];
    $action = $data['action'];
    foreach ($ids as $key => $delid) {
        $cond = array("threatre_id"=>$delid);
        $content = $this->usermodel->getDeletedData('installer',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage installer",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
        );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->installermodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}