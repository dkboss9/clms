<?php
class budget_type extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('budget_typemodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'BUDGET_TYPE';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('budget_type/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['categories'] 	= $this->budget_typemodel->getcategory();
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
            $data['values']['parent_id'] = $this->input->post('parent');
            $data['values']['type_name']	= $this->input->post('name');
            $data['values']['company_id']      = $this->session->userdata("clms_company");
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->budget_typemodel->add($data['values']);
            $this->session->set_flashdata('success_message', 'Budget Type added successfully');
            redirect('budget_type/listall');
        }else{
            $data['categories']     = $this->budget_typemodel->listall(0);
            $data['page'] = 'add';
            $data['heading'] = 'Add Lead Category';
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
            $id = $this->input->post('cat_id');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['parent_id'] = $this->input->post('parent');
            $data['values']['type_name']    = $this->input->post('name');
            $data['values']['added_date']       = time();
            $data['values']['added_by']         = $userdata;
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->budget_typemodel->update($id, $data['values']);
            $this->session->set_flashdata('success_message', 'Budget Type edited Successfully');
            redirect('budget_type/listall');
        } else {
            $data['categories']     = $this->budget_typemodel->listall(0);
            $id = $this->uri->segment(3);
            $query = $this->budget_typemodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Lead category';
                $this->load->view('main', $data);
            } else {
                redirect('budget_type/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $this->budget_typemodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('budget_type/listall');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------detail---------------------------------
function detail() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
        $id = $this->uri->segment(3);
        $query = $this->budget_type->getdata($id);
        if ($query->num_rows() > 0) {
            $data['result'] = $query->row();
            $row = $query->row();
            $query->free_result();
            $data['title'] = $row->option_name.' - Option';
            $data['page'] = 'detail';
            $this->load->view('main', $data);
        } else {
            redirect('industry/listall');
        }
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

function cascadeAction() {
    $data = $_POST['object'];
    $ids = $data['ids'];
    $action = $data['action'];
    $query = $this->budget_typemodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}



}