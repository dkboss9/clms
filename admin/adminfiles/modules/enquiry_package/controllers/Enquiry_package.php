<?php
class enquiry_package extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('enquiry_package_model');
        $this->load->model('users/usermodel');
        $this->module_code = 'Enquiry_package';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('enquiry_package/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() { 
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['status'] 	= $this->enquiry_package_model->listall();
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
              
                $userdata = $this->session->userdata("clms_userid");
                $date = date("Y-m-d");
                $data['values']['credits']    = $this->input->post('credits');
                $data['values']['price'] = $this->input->post('price');
                $data['values']['company_id']      = $this->session->userdata("clms_company");
                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= time();
                $data['values']['modified_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->enquiry_package_model->add($data['values']);
                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Add",
                    "module" => "Manage Lead Status",
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_date" => time()
                );
                $this->usermodel->insertUserlog($logs);
                $this->session->set_flashdata('success_message', 'Enquiry package added successfully');
                redirect('enquiry_package/listall');
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
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
            if ($this->input->post('submit')) {
                $id = $this->input->post('status_id');
                $userdata = $this->session->userdata("clms_userid");
                $data['values']['credits']    = $this->input->post('credits');
                $data['values']['price'] = $this->input->post('price');
                $data['values']['added_date']       = time();
                $data['values']['added_by']         = $userdata;
                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $this->enquiry_package_model->update($id, $data['values']);
                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Edit",
                    "module" => "Manage Lead Status",
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_date" => time()
                );
                $this->usermodel->insertUserlog($logs);
                $this->session->set_flashdata('success_message', 'Enquiry package edited Successfully');
                redirect('enquiry_package/listall');
            } else {
                $id = $this->uri->segment(3);
                $query = $this->enquiry_package_model->getdata($id);
                if ($query->num_rows() > 0) {
                    $data['result'] 	= $query->row();
                    $data['page'] 		= 'edit';
                    $data['heading'] 	= 'Edit Lead status';
                    $this->load->view('main', $data);
                } else {
                    redirect('enquiry_package/listall');
                }
            }
        }
    }

    //------------------------delete---------------------------------------------------------	
    function delete() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
            $delid = $this->uri->segment('3');
            $cond = array("id"=>$delid);
            $content = $this->usermodel->getDeletedData('enquiry_package',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => "Delete",
                "module" => "Manage Lead Status",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
            );
            $this->usermodel->insertUserlog($logs);
            $this->enquiry_package_model->delete($delid);
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('enquiry_package/listall');
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
            $content = $this->usermodel->getDeletedData('enquiry_package',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => $action,
                "module" => "Manage Lead Status",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
            );
            $this->usermodel->insertUserlog($logs); 
        }
        $query = $this->enquiry_package_model->cascadeAction($ids, $action);
        $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
        exit();
    }

}