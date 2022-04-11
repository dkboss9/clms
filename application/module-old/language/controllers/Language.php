<?php
class Language extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('languagemodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'LANGUAGE';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('language/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['language'] 	= $this->languagemodel->listall();
            // echo $this->db->last_query(); die();
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
            $data['values']['language_name']	= $this->input->post('name');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['status']      = 1;
            $this->languagemodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Language",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Language added successfully');
            redirect('language/listall');
        }else{
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
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('lang_id');
            $userdata = $this->session->userdata("clms_front_userid");
            $data['values']['language_name']    = $this->input->post('name');
            $this->languagemodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Language",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Language edited Successfully');
            redirect('language/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->languagemodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit language';
                $this->load->view('main', $data);
            } else {
                redirect('language/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("language_id"=>$delid);
        $content = $this->usermodel->getDeletedData('language',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Language",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->languagemodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('language/listall');
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
        $cond = array("language_id"=>$delid);
        $content = $this->usermodel->getDeletedData('language',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Language",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->languagemodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}