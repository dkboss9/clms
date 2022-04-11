<?php
class lead_category extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('lead_categorymodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'LEAD-CATEGORY';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('lead_category/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['categories'] 	= $this->lead_categorymodel->getcategory();
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
            $data['values']['parent_id'] = $this->input->post('parent');
            $data['values']['cat_name']	= $this->input->post('name');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->lead_categorymodel->add($data['values']);
            $this->session->set_flashdata('success_message', 'Lead Category added successfully');
            redirect('lead_category/listall');
        }else{
            $data['categories']     = $this->lead_categorymodel->listall(0);
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
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('cat_id');
            $userdata = $this->session->userdata("clms_front_userid");
            $data['values']['parent_id'] = $this->input->post('parent');
            $data['values']['cat_name']    = $this->input->post('name');
            $data['values']['added_date']       = time();
            $data['values']['added_by']         = $userdata;
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->lead_categorymodel->update($id, $data['values']);
            $this->session->set_flashdata('success_message', 'When Start edited Successfully');
            redirect('lead_category/listall');
        } else {
            $data['categories']     = $this->lead_categorymodel->listall(0);
            $id = $this->uri->segment(3);
            $query = $this->lead_categorymodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Lead category';
                $this->load->view('main', $data);
            } else {
                redirect('lead_category/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $this->lead_categorymodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('lead_category/listall');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------detail---------------------------------
function detail() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
        $id = $this->uri->segment(3);
        $query = $this->lead_category->getdata($id);
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
    $query = $this->lead_categorymodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}



}