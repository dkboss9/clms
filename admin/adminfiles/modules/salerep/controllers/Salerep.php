<?php
class salerep extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('salerepmodel');
        $this->load->model('users/usermodel');
        $this->load->model("employee/employeemodel");
        $this->module_code = 'SALE-REPS';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('salerep/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['salerep'] 	= $this->salerepmodel->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    public function email_check($email)
    {
        $this->db->where("email",$email);
        $this->db->where("company_id",$this->session->userdata("clms_company"));
        $query = $this->db->get("company_users");
       
        if ($query->num_rows() > 0)
        {
                $this->form_validation->set_message('email_check', 'Data with this email already exists.');
                return FALSE;
        }

        $this->db->where("email",$email);
        $this->db->where("company_id",$this->session->userdata("clms_company"));
        $query = $this->db->get("head_agents");
       
        if ($query->num_rows() > 0)
        {
                $this->form_validation->set_message('email_check', 'Data with this email already exists.');
                return FALSE;
        }

        $this->db->where("email",$email);
        $this->db->where("company_id",$this->session->userdata("clms_company"));
        $query = $this->db->get("sub_agents");
       
        if ($query->num_rows() > 0)
        {
                $this->form_validation->set_message('email_check', 'Data with this email already exists.');
                return FALSE;
        }
        
        return TRUE;
    }

    function addUser(){

        $this->form_validation->set_rules('fname','First Name','required');
        $this->form_validation->set_rules('lname','Last Name','required');
        $this->form_validation->set_rules('email','Email','required|valid_email|callback_email_check');
        if($this->form_validation->run()==FALSE){
         
            $array = array("response"=>"error","err_msg"=>validation_errors());
            echo json_encode($array);
         }else{
            $value['details']['first_name']     = $this->input->post('fname');
            $value['details']['last_name']      = $this->input->post('lname');
            $value['details']['email']          = $this->input->post('email');
            $value['details']['phone']          = $this->input->post('phone');
            $value['details']['company_id']      = $this->session->userdata("clms_company");
            $value['details']['user_group']     = 3;
            $value['details']['added_date']     = date('Y-m-d H:i:s');
            $value['details']['added_by']       = $this->session->userdata("clms_userid");
            $value['details']['status']         = 1;
            $this->db->insert("pnp_company_users",$value['details']);
            $id = $this->db->insert_id();
            $this->salerepmodel->send_approval_email($id);
            $request = [
                "company_user_id" => $id,
                "type" => 'Salerep',
                "added_by" => $this->session->userdata("clms_userid"),
                "added_at" => date("Y-m-d H:i:s")
            ];
            $this->load->model("employee/employeemodel");
            $this->employeemodel->adduserRequest($request);
            $array = array("response"=>"success","id"=>$id,"name"=>$this->input->post('fname').' '.$this->input->post('lname'));
            echo json_encode($array);
         }
    }
    
    function add(){
        if($this->session->userdata("clms_userid")!="" && $this->usermodel->checkperm($this->module_code,"ADD")){
            if($this->input->post('action') && $this->input->post('action')=='submit'){
               if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
                  echo '<strong>We must tell you! </strong> Please select company to add this data.';
                  exit;
              }
              $this->form_validation->set_rules('fname','First Name','required');
              $this->form_validation->set_rules('lname','Last Name','required');
              $this->form_validation->set_rules('role','User Group','required');
            //   $this->form_validation->set_rules('username','Username','required');
            $this->form_validation->set_rules('email','Email','required|valid_email|callback_email_check');
              $this->form_validation->set_rules('phone','Phone','required');
            //   $this->form_validation->set_rules('password','Password','required');
              if($this->form_validation->run()==FALSE){
                echo validation_errors();
                exit();
            }else{
                $value['details']['first_name']     = $this->input->post('fname');
                $value['details']['last_name']      = $this->input->post('lname');
                $value['details']['email']          = $this->input->post('email');
                $value['details']['phone']          = $this->input->post('phone');
                $value['details']['company_id']      = $this->session->userdata("clms_company");
                   // $value['details']['rate1']          = $this->input->post('rate1');
                   // $value['details']['rate2']          = $this->input->post('rate2');
                $value['details']['user_group']     = $this->input->post('role');
                $value['details']['user_name']      = $this->input->post('username');
                $value['details']['password']       = md5(trim($this->input->post('password')));
                $value['details']['added_date']     = date('Y-m-d H:i:s');
                $value['details']['added_by']       = $this->session->userdata("clms_userid");
                $value['details']['status']         = 1;
                $this->db->insert("pnp_company_users",$value['details']);
                $id = $this->db->insert_id();
                $this->salerepmodel->send_approval_email($id);
                $request = [
                    "company_user_id" => $id,
                    "type" => 'Salerep',
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_at" => date("Y-m-d H:i:s")
                ];
                $this->load->model("employee/employeemodel");
                $this->employeemodel->adduserRequest($request);

            $rate = $this->input->post("rate");
            $rate = rtrim($rate, ",");
            $rate = explode(',', $rate);
            foreach ($rate as $key=>$val) {
               $rate1 = explode(':', $val);
               $insert_arr = array(
                "user_id" => $id,
                "type_id" => $rate1[0],
                "rate" => $rate1[1]
                );
               $this->db->insert("salesrep_rate",$insert_arr);
           }

           $logs = array(
            "content" => serialize($value['details']),
            "action" => "Add",
            "module" => "Manage Sales Rep",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
           $this->usermodel->insertUserlog($logs);
           echo "yes";
       }
   }else{
    $data['lead_types'] = $this->salerepmodel->get_leadType();
    $data['page'] = 'add';
    $data['heading'] = 'Add ';
    $this->load->vars($data);
    $this->load->view($this->container);
}
}else{
    $this->session->set_flashdata('error','Please login with your username and password');
    redirect('login','location');
}
}

function resend_activation($id){
    $this->salerepmodel->send_approval_email($id);
    $request = [
        "company_user_id" => $id,
        "type" => 'Salerep',
        "added_by" => $this->session->userdata("clms_userid"),
        "added_at" => date("Y-m-d H:i:s")
    ];
    $this->load->model("employee/employeemodel");
    $this->employeemodel->adduserRequest($request);
    $this->session->set_flashdata('success_message', 'Mail sent Successfully.');
    redirect('salerep/listall');
}


    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('userid');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['first_name']    = $this->input->post('fname');
            $data['values']['last_name']    = $this->input->post('lname');
            $data['values']['email']    = $this->input->post('email');
            $data['values']['phone']    = $this->input->post('phone');
            $data['values']['user_name']    = $this->input->post('username');
            $value['values']['status']         = 1;
           // $data['values']['rate1']          = $this->input->post('rate1');
            //$data['values']['rate2']          = $this->input->post('rate2');
            if($this->input->post("password") != "")
                $data['values']['password']    = md5(trim($this->input->post('password')));


            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;

            $this->db->where("user_id",$id);
            $this->db->delete("salesrep_rate");
            $rates = $this->input->post("rate");
            if($this->input->post("type_id")){
                $types = $this->input->post("type_id");
                foreach ($types as $key => $value) {
                   $insert_arr = array(
                    "user_id" => $id,
                    "type_id" => $value,
                    "rate" => $rates[$key]
                    );
                   $this->db->insert("salesrep_rate",$insert_arr);
               }
           }
           $this->salerepmodel->update($id, $data['values']);
           $logs = array(
            "content" => serialize($data['values']),
            "action" => "Edit",
            "module" => "Manage Sales Rep",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
           $this->usermodel->insertUserlog($logs);
           $this->session->set_flashdata('success_message', 'Sale reps edited Successfully');
         //echo md5(trim($this->input->post('password')));
           redirect('salerep/listall');
       } else {
        $data['lead_types'] = $this->salerepmodel->get_leadType();
        $id = $this->uri->segment(3);
        $query = $this->salerepmodel->getdata($id);
        if ($query->num_rows() > 0) {
            $data['result'] 	= $query->row();
            $data['page'] 		= 'edit';
            $data['heading'] 	= 'Edit Chat';
            $this->load->view('main', $data);
        } else {
            redirect('start/listall');
        }
    }
}
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("userid"=>$delid);
        $content = $this->usermodel->getDeletedData('users',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Sale Reps",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->salerepmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('salerep/listall');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------detail---------------------------------
function detail() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
        $id = $this->uri->segment(3);
        $query = $this->industrymodel->getdata($id);
        if ($query->num_rows() > 0) {
            $data['result'] = $query->row();
            $row = $query->row();
            $query->free_result();
            $data['title'] = $row->option_name.' - Option';
            $data['page'] = 'detail';
            $this->load->view('main', $data);
        } else {
            redirect('industry/listall');
        }
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
        $cond = array("userid"=>$delid);
        $content = $this->usermodel->getDeletedData('users',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Sales Rep",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->salerepmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}