<?php
class Document_category extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('document_categorymodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'Document_category';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('document_category/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['categories'] 	= $this->document_categorymodel->listall();
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
            $data['values']['title']	= $this->input->post('name');
            $data['values']['type']	= $this->input->post('type');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['added_date'] 		= date("Y-m-d H:i:s");
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= date("Y-m-d H:i:s");
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->document_categorymodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage document category",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
            );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Document category added successfully');
            redirect('document_category/listall');
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
            $id = $this->input->post('cat_id');
            $userdata = $this->session->userdata("clms_front_userid");
            $data['values']['title']	= $this->input->post('name');
            $data['values']['type']	= $this->input->post('type');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['added_date'] 		= date("Y-m-d H:i:s");
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= date("Y-m-d H:i:s");
            $data['values']['modified_by'] 		= $userdata;
            $this->document_categorymodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage document category",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
            );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Document category edited Successfully');
            redirect('document_category/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->document_categorymodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('document_category/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('document_category',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage document",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
        );
        $this->usermodel->insertUserlog($logs);
        $this->document_categorymodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('document_category/listall');
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
        $content = $this->usermodel->getDeletedData('document_category',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage document category",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
        );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->document_categorymodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}