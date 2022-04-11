<?php
class Log extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('logmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'log';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('log/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['logs'] 	= $this->logmodel->listall();
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
                $data['values']['log_name']	= $this->input->post('name');
                $data['values']['company_id']      = $this->session->userdata("clms_company");
                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= time();
                $data['values']['modified_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->logmodel->add($data['values']);
                $this->session->set_flashdata('success_message', 'When log added successfully');
                redirect('log/listall');
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
                $id = $this->input->post('log_id');
                $userdata = $this->session->userdata("clms_userid");
                $data['values']['log_name']    = $this->input->post('name');
                $data['values']['added_date']       = time();
                $data['values']['added_by']         = $userdata;
                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $this->logmodel->update($id, $data['values']);
                $this->session->set_flashdata('success_message', 'When log edited Successfully');
                redirect('log/listall');
            } else {
                $id = $this->uri->segment(3);
                $query = $this->logmodel->getdata($id);
                if ($query->num_rows() > 0) {
                    $data['result'] 	= $query->row();
                    $data['page'] 		= 'edit';
                    $data['heading'] 	= 'Edit Chat';
                    $this->load->view('main', $data);
                } else {
                    redirect('log/listall');
                }
            }
        }
    }

    //------------------------delete---------------------------------------------------------	
    function delete() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
            $delid = $this->uri->segment('3');
            $this->logmodel->delete($delid);
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('log/listall');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //---------------------detail---------------------------------
    function detail() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $id = $this->uri->segment(3);
            $query = $this->industrymodel->getdata($id);
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
        $query = $this->logmodel->cascadeAction($ids, $action);
        $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
        exit();
    }

}