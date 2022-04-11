<?php
class Companies extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('companies_model');
        $this->load->model('users/usermodel');
        $this->module_code = 'companies';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('companies/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['companies'] 	= $this->companies_model->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
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
            $data['values']['name']	= $this->input->post('name');
            $data['values']['email']      = $this->input->post("email");
            $data['values']['phone'] 		= $this->input->post("phone");
            $data['values']['staff_id'] 		= $this->input->post("source");
            $data['values']['company_name'] 	= $this->input->post("company_name");
            $data['values']['abn']	= $this->input->post('abn');
            $data['values']['address']	= $this->input->post('address');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['added_by']      = $this->session->userdata("clms_front_userid");
            $data['values']['added_date']      = date("Y-m-d");
            $data['values']['status']      = 1;
            $this->companies_model->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Contact",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Company added successfully');
            redirect('companies/listall');
        }else{
            $this->load->model("task/taskmodel");
            $this->load->model("campaign/campaignmodel");
            $data["users"] = $this->taskmodel->get_users();
            $data["campaigns"] = $this->campaignmodel->listall(null,1);
            $data['page'] = 'add';
            $data['heading'] = 'Add companies';
            $this->load->vars($data);
            $this->load->view($this->container);
        }
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}



    //---------------------------------edit--------------------------------------
function edit($id) {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $data['values']['name']	= $this->input->post('name');
            $data['values']['email']      = $this->input->post("email");
            $data['values']['phone'] 		= $this->input->post("phone");
            $data['values']['staff_id'] 		= $this->input->post("source");
            $data['values']['company_name'] 	= $this->input->post("company_name");
            $data['values']['abn']	= $this->input->post('abn');
            $data['values']['address']	= $this->input->post('address');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['modified_by']      = $this->session->userdata("clms_front_userid");
            $data['values']['modified_date']      = date("Y-m-d");
            $this->companies_model->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Contact",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Company edited Successfully');
            redirect('companies/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->companies_model->getdata($id);
            if ($query->num_rows() > 0) {
                $this->load->model("task/taskmodel");
                $this->load->model("campaign/campaignmodel");
                $data['result'] 	= $query->row();
                $data["users"] = $this->taskmodel->get_users();
                $data["campaigns"] = $this->campaignmodel->listall(null,1);
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('purpose/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('companies',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->companies_model->delete($delid);
        $this->session->set_flashdata('success_message', 'Contact deleted successfully');
        redirect('companies/listall');
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
        $content = $this->usermodel->getDeletedData('companies',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage companies",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->companies_model->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}