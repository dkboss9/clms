<?php
class Campaign extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('campaignmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'campaign';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('campaign/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
           
       
           
        $query = $this->campaignmodel->listall();
          
        $data['campaigns'] = $query->result();

    
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
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
        if ($this->input->post('submit')) {
            $userdata = $this->session->userdata("clms_userid");
            $date = date("Y-m-d");
            $data['values']['name'] 		= $this->input->post('name');
            $data['values']['detail'] 	= $this->input->post('detail');
            $data['values']['company_id'] 		=$this->session->userdata("clms_company");
            $data['values']['added_date'] 		= $date;
            $data['values']['added_by'] 		= $userdata;
            // $data['values']['modified_date'] 	= $date;
            // $data['values']['modified_by'] 		= $userdata;
            $data['values']['status'] = "1";
            $this->campaignmodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Lead campaign",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success', 'Campaign added successfully');
            redirect('campaign/listall');
        } else {
            $data['page'] = 'add';
            $data['heading'] = 'Add campaign';
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
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $userdata = $this->session->userdata("clms_userid");
            $date = date("Y-m-d");
            $data['values']['name'] 	= $this->input->post('name');
            $data['values']['detail'] = $this->input->post('detail');
            $data['values']['modified_date'] 	= $date;
            // $data['values']['modified_by'] 		= $userdata;
            // $data['values']['status'] 		= $this->input->post('status');
            $this->campaignmodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage  campaign",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success', 'Campaign Edited Successfully');
            redirect('campaign/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->campaignmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Product campaign';
                $this->load->view('main', $data);
            } else {
                redirect('campaign/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $this->campaignmodel->delete($delid);
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('campaign',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage campaign",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('campaign/listall');
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
        $content = $this->usermodel->getDeletedData('campaign',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage campaign",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->campaignmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
    echo '';
    exit();
}

}