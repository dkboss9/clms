<?php
class quote_status extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('quote_statusmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'quote_status';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('quote_status/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['status'] 	= $this->quote_statusmodel->listall(null,1);
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
                $data['values']['name']	= $this->input->post('name');
                $data['values']['color_code'] = $this->input->post('code');
                $data['values']['company_id'] = $this->session->userdata("clms_company");
                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= time();
                $data['values']['modified_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->quote_statusmodel->add($data['values']);

                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Add",
                    "module" => "Manage quote_status",
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);

                $this->session->set_flashdata('success_message', 'Quote status added successfully');
                redirect('quote_status/listall');
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
                $data['values']['color_code']    = $this->input->post('code');
                $data['values']['added_date']       = time();
                $data['values']['added_by']         = $userdata;
                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $this->quote_statusmodel->update($id, $data['values']);
                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Edit",
                    "module" => "Manage quote_status",
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);


                $this->session->set_flashdata('success_message', 'Quote status edited Successfully');
                redirect('quote_status/listall');
            } else {
                $id = $this->uri->segment(3);
                $query = $this->quote_statusmodel->getdata($id);
                if ($query->num_rows() > 0) {
                    $data['result'] 	= $query->row();
                    $data['page'] 		= 'edit';
                    $data['heading'] 	= 'Edit Lead status';
                    $this->load->view('main', $data);
                } else {
                    redirect('quote_status/listall');
                }
            }
        }
    }

    //------------------------delete---------------------------------------------------------	
    function delete() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
            $delid = $this->uri->segment('3');
            $cond = array("threatre_id"=>$delid);
            $content = $this->usermodel->getDeletedData('quote_status',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => "Delete",
                "module" => "Manage quote_status",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->quote_statusmodel->delete($delid);
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('quote_status/listall');
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
            $content = $this->usermodel->getDeletedData('quote_status',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => $action,
                "module" => "Manage quote_status",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs); 
        }
        $query = $this->quote_statusmodel->cascadeAction($ids, $action);
        $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
        exit();
    }

}