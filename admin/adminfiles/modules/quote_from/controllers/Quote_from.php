<?php
class quote_from extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('quote_frommodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'quote_from';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('quote_from/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['status'] 	= $this->quote_frommodel->all_quoteform();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function new_quotefrom() {
                $userdata = $this->session->userdata("clms_userid");
                $date = date("Y-m-d");
                $data['values']['name']	= $this->input->post('quotefrom');
                $data['values']['company_id'] = $this->session->userdata("clms_company");
                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= time();
                $data['values']['modified_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->quote_frommodel->add($data['values']);
                $id = $this->db->insert_id();
                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Add",
                    "module" => "Manage quote_from",
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);
                echo $id;
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
                $data['values']['company_id'] = $this->session->userdata("clms_company");
                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= time();
                $data['values']['modified_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->quote_frommodel->add($data['values']);

                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Add",
                    "module" => "Manage quote_from",
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);

                $this->session->set_flashdata('success_message', 'Quote From added successfully');
                redirect('quote_from/listall');
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
                $data['values']['name']    = $this->input->post('name');
                $data['values']['added_date']       = time();
                $data['values']['added_by']         = $userdata;
                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $this->quote_frommodel->update($id, $data['values']);
                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Edit",
                    "module" => "Manage quote_from",
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);


                $this->session->set_flashdata('success_message', 'Quote From edited Successfully');
                redirect('quote_from/listall');
            } else {
                $id = $this->uri->segment(3);
                $query = $this->quote_frommodel->getdata($id);
                if ($query->num_rows() > 0) {
                    $data['result'] 	= $query->row();
                    $data['page'] 		= 'edit';
                    $data['heading'] 	= 'Edit Lead status';
                    $this->load->view('main', $data);
                } else {
                    redirect('quote_from/listall');
                }
            }
        }
    }

    //------------------------delete---------------------------------------------------------	
    function delete() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
            $delid = $this->uri->segment('3');
            $cond = array("threatre_id"=>$delid);
            $content = $this->usermodel->getDeletedData('quote_from',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => "Delete",
                "module" => "Manage quote_from",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->quote_frommodel->delete($delid);
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('quote_from/listall');
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
            $content = $this->usermodel->getDeletedData('quote_from',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => $action,
                "module" => "Manage quote_from",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs); 
        }
        $query = $this->quote_frommodel->cascadeAction($ids, $action);
        $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
        exit();
    }

}