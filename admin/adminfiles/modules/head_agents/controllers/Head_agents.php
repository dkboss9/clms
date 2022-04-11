<?php
class Head_agents extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('head_agentsmodel');
        $this->load->model('users/usermodel');
        $this->load->model("employee/employeemodel");
        $this->module_code = 'head_agents';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('head_agents/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['access'] 	= $this->head_agentsmodel->listall();
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

    function addhead_agents(){
        $name = $this->input->post("head_agents_name");
        $head_agents_desc = $this->input->post("head_agents_desc");
        $head_agents_start_date = $this->input->post("head_agents_start_date");
        $head_agents_end_date = $this->input->post("head_agents_end_date");
        $userdata = $this->session->userdata("clms_userid");

        $date = date("Y-m-d");
        $data['values']['type_name']    = $name;
        $data['values']['head_agents_desc']    = $head_agents_desc;
        $data['values']['head_agents_start_date']    = $this->head_agentsmodel->save_date($head_agents_start_date);
        $data['values']['head_agents_end_date']    = $this->head_agentsmodel->save_date($head_agents_end_date);
        $data['values']['company_id']      = $this->session->userdata("clms_company");
        $data['values']['added_date']       = time();
        $data['values']['added_by']         = $userdata;
        $data['values']['modified_date']    = time();
        $data['values']['modified_by']      = $userdata;
        $data['values']['status']      = 1;
        $this->head_agentsmodel->add($data['values']);

        $id = $this->db->insert_id();
        $array = array("id"=>$id,"name"=>$name);
        echo json_encode($array);
    }

    //--------------------------------------add--------------------------------------	
    function add() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            $this->form_validation->set_rules('name','Name','required');
            $this->form_validation->set_rules('email','Email','required|valid_email|callback_email_check');
            if($this->form_validation->run()!=FALSE){
                if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
                    redirect($_SERVER["HTTP_REFERER"],"refresh");
                }
                $userdata = $this->session->userdata("clms_userid");

                $date = date("Y-m-d");
                $this->load->library("uuid");
                $data['values']['uuid'] = $this->uuid->v4();
                $data['values']['name']	= $this->input->post('name');
                $data['values']['email']    = $this->input->post('email');
                $data['values']['phone_no']    = $this->input->post('phone');
                $data['values']['mobile_no']    = $this->input->post('mobile');
                $data['values']['commission_share']    = $this->input->post('share');
                $data['values']['is_percentage']	= $this->input->post('is_percentage') ? 1 : 0;
                $data['values']['status']	= $this->input->post('action');
                $data['values']['created_by']	= $this->input->post('staff');
                $data['values']['company_id']      = $this->session->userdata("clms_company");
                $data['values']['added_date'] 		= date("Y-m-d H:i:s");
                $data['values']['added_by'] 		= $userdata;
                $this->head_agentsmodel->add($data['values']);
                $head_agent_id = $this->db->insert_id();
                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Add",
                    "module" => "Manage Head Agent",
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);
                $this->head_agentsmodel->send_approval_email($head_agent_id);
                $request = [
                    "company_user_id" => $head_agent_id,
                    "type" => 'Head Agent',
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_at" => date("Y-m-d H:i:s")
                ];
                $this->load->model("employee/employeemodel");
                $this->employeemodel->adduserRequest($request);
                $this->session->set_flashdata('success_message', 'head agents added successfully');
                redirect('head_agents/listall');
        }else{
            $this->load->model("project/projectmodel");
            $data['counselers'] = $this->projectmodel->get_empoyee();
            $data['page'] = 'add';
            $data['heading'] = 'Add Access';
            $this->load->vars($data);
            $this->load->view($this->container);
        }
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

function resend_activation($id){
    $this->head_agentsmodel->send_approval_email($id);
    $request = [
        "company_user_id" => $id,
        "type" => 'Head Agent',
        "added_by" => $this->session->userdata("clms_userid"),
        "added_at" => date("Y-m-d H:i:s")
    ];
    $this->load->model("employee/employeemodel");
    $this->employeemodel->adduserRequest($request);
    $this->session->set_flashdata('success_message', 'Mail sent Successfully.');
    redirect('head_agents/listall');
}

    //---------------------------------edit--------------------------------------
function edit($id) {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            // $id = $this->input->post('type_id');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['name']	= $this->input->post('name');
            $data['values']['email']    = $this->input->post('email');
            $data['values']['phone_no']    = $this->input->post('phone');
            $data['values']['mobile_no']    = $this->input->post('mobile');
            $data['values']['commission_share']    = $this->input->post('share');
            $data['values']['is_percentage']	= $this->input->post('is_percentage') ? 1 : 0;
            $data['values']['status']	= $this->input->post('action');
            $data['values']['created_by']	= $this->input->post('staff');
            $data['values']['modified_date']    = date("Y-m-d H:i:s");
            $data['values']['modified_by']      = $userdata;
            $this->head_agentsmodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Head Agent",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'head agents edited Successfully');
            redirect('head_agents/listall');
        } else {
            $this->load->model("project/projectmodel");
            $data['counselers'] = $this->projectmodel->get_empoyee();
            $query = $this->head_agentsmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('head_agents/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('head_agents',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->head_agentsmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'head_agents deleted successfully');
        redirect('head_agents/listall');
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
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('head_agents',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Business Category",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->head_agentsmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}