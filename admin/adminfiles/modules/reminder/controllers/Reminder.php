<?php
class Reminder extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('reminder_model');
        $this->load->model('users/usermodel');
        $this->module_code = 'reminder';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('reminder/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['reminders'] 	= $this->reminder_model->listall();
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
              if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }
            $userdata = $this->session->userdata("clms_userid");
            $date = date("Y-m-d");
            $data['values']['name']	= $this->input->post('name');
            $data['values']['detail']      = $this->input->post("detail");
            $data['values']['reminder_date'] 		= date("Y-m-d",strtotime($this->input->post("reminder_date")));
            $data['values']['reminder_time'] 		= $this->input->post("reminder_time");
            $data['values']['status'] 	= $this->input->post("status");
            $data['values']['added_date'] 		= date("Y-m-d H:i:s");
            $data['values']['company_id']      = $this->session->userdata("clms_company");
            $data['values']['added_by']      = $this->session->userdata("clms_userid");
            $this->reminder_model->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Lead Type",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Reminder added successfully');
            redirect('reminder/listall');
        }else{
            $data['page'] = 'add';
            $data['heading'] = 'Add Reminder';
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
            $data['values']['name']	= $this->input->post('name');
            $data['values']['detail']      = $this->input->post("detail");
            $data['values']['reminder_date'] 		= date("Y-m-d",strtotime($this->input->post("reminder_date")));
            $data['values']['reminder_time'] 		= $this->input->post("reminder_time");
            $data['values']['status'] 	= $this->input->post("status");
            $data['values']['updated_date'] 		= date("Y-m-d H:i:s");
            $data['values']['company_id']      = $this->session->userdata("clms_company");
            $data['values']['added_by']      = $this->session->userdata("clms_userid");
            $this->reminder_model->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Lead Type",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Reminder edited Successfully');
            redirect('reminder/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->reminder_model->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
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
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("type_id"=>$delid);
        $content = $this->usermodel->getDeletedData('purpose',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->reminder_model->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('purpose/listall');
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
        $cond = array("type_id"=>$delid);
        $content = $this->usermodel->getDeletedData('purpose',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Business Category",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->reminder_model->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}