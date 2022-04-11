<?php
class Lead_status extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('lead_statusmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'LEAD-STATUS';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('lead_status/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['status'] 	= $this->lead_statusmodel->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //--------------------------------------add--------------------------------------	
    

    function addStatus(){
        $status_name = $this->input->post("status_name");
        $status_color = $this->input->post("status_color");
        $userdata = $this->session->userdata("clms_front_userid");
        $date = date("Y-m-d");
        $data['values']['status_name']  = $status_name;
        $data['values']['status_color']  = $status_color;
        $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
        $data['values']['added_date']       = time();
        $data['values']['added_by']         = $userdata;
        $data['values']['modified_date']    = time();
        $data['values']['modified_by']      = $userdata;
        $data['values']['status']      = 1;
        $this->lead_statusmodel->add($data['values']);

        $id = $this->db->insert_id();
        $array = array("id"=>$id,"name"=>$status_name);
        echo json_encode($array);
    }

    function add() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {
              /* if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }*/
            $userdata = $this->session->userdata("clms_front_userid");
            $date = date("Y-m-d");
            $data['values']['status_name']	= $this->input->post('name');
            $data['values']['status_color']  = $this->input->post('code');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->lead_statusmodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Lead Status",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Lead Status added successfully');
            redirect('lead_status/listall');
        }else{
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
function edit() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('status_id');
            $userdata = $this->session->userdata("clms_front_userid");
            $data['values']['status_name']    = $this->input->post('name');
            $data['values']['status_color']  = $this->input->post('code');
            $data['values']['added_date']       = time();
            $data['values']['added_by']         = $userdata;
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->lead_statusmodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Lead Status",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Lead Status edited Successfully');
            redirect('lead_status/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->lead_statusmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Lead status';
                $this->load->view('main', $data);
            } else {
                redirect('lead_status/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("status_id"=>$delid);
        $content = $this->usermodel->getDeletedData('lead_status',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Status",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->lead_statusmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('lead_status/listall');
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
        $cond = array("status_id"=>$delid);
        $content = $this->usermodel->getDeletedData('lead_status',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Lead Status",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->lead_statusmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
    //echo $this->db->last_query();
    exit();
}

}