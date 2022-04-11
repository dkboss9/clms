<?php
class Sub_agents extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('sub_agentsmodel');
        $this->load->model('users/usermodel');
        $this->load->model("employee/employeemodel");
        $this->module_code = 'sub_agents';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('sub_agents/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['access'] 	= $this->sub_agentsmodel->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function addsub_agents(){
        $name = $this->input->post("sub_agents_name");
        $sub_agents_desc = $this->input->post("sub_agents_desc");
        $sub_agents_start_date = $this->input->post("sub_agents_start_date");
        $sub_agents_end_date = $this->input->post("sub_agents_end_date");
        $userdata = $this->session->userdata("clms_front_userid");

        $date = date("Y-m-d");
        $data['values']['type_name']    = $name;
        $data['values']['sub_agents_desc']    = $sub_agents_desc;
        $data['values']['sub_agents_start_date']    = $this->sub_agentsmodel->save_date($sub_agents_start_date);
        $data['values']['sub_agents_end_date']    = $this->sub_agentsmodel->save_date($sub_agents_end_date);
        $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
        $data['values']['added_date']       = time();
        $data['values']['added_by']         = $userdata;
        $data['values']['modified_date']    = time();
        $data['values']['modified_by']      = $userdata;
        $data['values']['status']      = 1;
        $this->sub_agentsmodel->add($data['values']);

        $id = $this->db->insert_id();
        $array = array("id"=>$id,"name"=>$name);
        echo json_encode($array);
    }

    //--------------------------------------add--------------------------------------	
    function add() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {
            if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }
            $userdata = $this->session->userdata("clms_front_userid");

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
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['added_date'] 		= date("Y-m-d H:i:s");
            $data['values']['added_by'] 		= $userdata;
            $this->sub_agentsmodel->add($data['values']);
            $sub_agent_id = $this->db->insert_id();
            $this->sub_agentsmodel->send_approval_email($sub_agent_id);
            $request = [
                "company_user_id" => $sub_agent_id,
                "type" => 'Sub Agent',
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_at" => date("Y-m-d H:i:s")
            ];
            $this->load->model("employee/employeemodel");
            $this->employeemodel->adduserRequest($request);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Head Agent",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'head agents added successfully');
            redirect('sub_agents/listall');
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
    $this->sub_agentsmodel->send_approval_email($id);
    $request = [
        "company_user_id" => $id,
        "type" => 'Sub Agent',
        "added_by" => $this->session->userdata("clms_front_userid"),
        "added_at" => date("Y-m-d H:i:s")
    ];
    $this->load->model("employee/employeemodel");
    $this->employeemodel->adduserRequest($request);
    $this->session->set_flashdata('success_message', 'Mail sent Successfully.');
    redirect('sub_agents/listall');
}

    //---------------------------------edit--------------------------------------
function edit($id) {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            // $id = $this->input->post('type_id');
            $userdata = $this->session->userdata("clms_front_userid");
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
            $this->sub_agentsmodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Head Agent",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'head agents edited Successfully');
            redirect('sub_agents/listall');
        } else {
            $this->load->model("project/projectmodel");
            $data['counselers'] = $this->projectmodel->get_empoyee();
            $query = $this->sub_agentsmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('sub_agents/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('sub_agents',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->sub_agentsmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'sub_agents deleted successfully');
        redirect('sub_agents/listall');
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
        $content = $this->usermodel->getDeletedData('sub_agents',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Business Category",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->sub_agentsmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}