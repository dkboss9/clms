<?php
class threatre extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('threatremodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'threatre';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('threatre/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['status'] 	= $this->threatremodel->all_timeline();
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
               
                $data['values']['company_id'] = $this->session->userdata("clms_front_companyid");
                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= time();
                $data['values']['modified_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->threatremodel->add($data['values']);

                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Add",
                    "module" => "Manage threatre",
                    "added_by" => $this->session->userdata("clms_front_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);

                $this->session->set_flashdata('success_message', 'Timeline added successfully');
                redirect('threatre/listall');
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

    function addTimeline(){
     if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {

        $userdata = $this->session->userdata("clms_front_userid");
        $date = date("Y-m-d");
        $data['values']['name'] = $this->input->post('new_timeline');
        $data['values']['company_id'] = $this->session->userdata("clms_front_companyid");
        $data['values']['added_date']       = time();
        $data['values']['added_by']         = $userdata;
        $data['values']['modified_date']    = time();
        $data['values']['modified_by']      = $userdata;
        $data['values']['status']      = 1;
        $this->threatremodel->add($data['values']);
        echo $this->db->insert_id();

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
            $data['values']['name']    = $this->input->post('name');
         
            $data['values']['added_date']       = time();
            $data['values']['added_by']         = $userdata;
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->threatremodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage threatre",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);


            $this->session->set_flashdata('success_message', 'Timeline edited Successfully');
            redirect('threatre/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->threatremodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Lead status';
                $this->load->view('main', $data);
            } else {
                redirect('threatre/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("threatre_id"=>$delid);
        $content = $this->usermodel->getDeletedData('threatre',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage threatre",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->threatremodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('threatre/listall');
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
        $cond = array("threatre_id"=>$delid);
        $content = $this->usermodel->getDeletedData('threatre',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage threatre",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->threatremodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}