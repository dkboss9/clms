<?php
class Mailchimp extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('mailchimpmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'mailchimp';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('mailchimp/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
         if ($this->input->post('submit')) {
            $id = $this->input->post('start_id');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['api_key']    = $this->input->post('api');
            $data['values']['list_id']       = $this->input->post('listid');
            $data['values']['company_id']       = $this->session->userdata("clms_company");
            $data['values']['added_by']         = $userdata;
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $query = $this->mailchimpmodel->getdata($this->session->userdata("clms_company"));
            if($query->num_rows() > 0){
                $this->db->where("company_id",$this->session->userdata("clms_company"));
                $this->db->update("mailchimp",$data['values']);
            }else{
                $this->db->insert("mailchimp", $data['values']);
            }

            $this->session->set_flashdata('success_message', 'Mailchimp credential save successfully.');
            redirect('mailchimp/listall');
        } else {
            $userdata = $this->session->userdata("clms_userid");
            $query = $this->mailchimpmodel->getdata($this->session->userdata("clms_company"));
            $data['result']     = $query->row();
            $data['page']       = 'edit';
            $data['heading']    = 'Edit Chat';
            $this->load->view('main', $data);

        }

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
        $data['values']['start_name']	= $this->input->post('name');
        $data['values']['company_id']      = $this->session->userdata("clms_company");
        $data['values']['added_date'] 		= time();
        $data['values']['added_by'] 		= $userdata;
        $data['values']['modified_date'] 	= time();
        $data['values']['modified_by'] 		= $userdata;
        $data['values']['status']      = 1;
        $this->startmodel->add($data['values']);
        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Add",
            "module" => "Manage Start",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->session->set_flashdata('success_message', 'When Start added successfully');
        redirect('start/listall');
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
            $id = $this->input->post('start_id');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['start_name']    = $this->input->post('name');
            $data['values']['added_date']       = time();
            $data['values']['added_by']         = $userdata;
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->startmodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Start",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'When Start edited Successfully');
            redirect('start/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->startmodel->getdata($id);
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
        $cond = array("start_id"=>$delid);
        $content = $this->usermodel->getDeletedData('start',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Start",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->startmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('start/listall');
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
        $cond = array("start_id"=>$delid);
        $content = $this->usermodel->getDeletedData('start',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Start",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->startmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}