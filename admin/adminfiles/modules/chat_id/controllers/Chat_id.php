<?php
class Chat_id extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('chat_idmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'CHAT-ID';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('chat_id/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['chats'] 	= $this->chat_idmodel->listall();
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
            $data['values']['chat_name']	= $this->input->post('name');
            $data['values']['company_id']      = $this->session->userdata("clms_company");
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->chat_idmodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Chat Id",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Chat added successfully');
            redirect('chat_id/listall');
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
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('chat_id');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['chat_name']    = $this->input->post('name');
            $data['values']['added_date']       = time();
            $data['values']['added_by']         = $userdata;
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->chat_idmodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Chat Id",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Chat edited Successfully');
            redirect('chat_id/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->chat_idmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('chat_id/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("chat_id"=>$delid);
        $content = $this->usermodel->getDeletedData('chat',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Chat Id",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->chat_idmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('chat_id/listall');
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
        $cond = array("chat_id"=>$delid);
        $content = $this->usermodel->getDeletedData('chat',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Chat Id",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->chat_idmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
    echo '';
    exit();
}

}