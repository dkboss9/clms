<?php
class start_supplier extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('start_suppliermodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'start_supplier';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('start_supplier/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['access'] 	= $this->start_suppliermodel->listall();
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
            $data['values']['company_name']    = $this->input->post('company_name');
            $data['values']['email']    = $this->input->post('email');
            $data['values']['phone']    = $this->input->post('phone');
            $data['values']['address']    = $this->input->post('address');
            $data['values']['product']	= $this->input->post('product');
            $data['values']['status']	= $this->input->post('action');
            $data['values']['created_by']	= $this->input->post('staff');
            $data['values']['company_id']      = $this->session->userdata("clms_company");
            $data['values']['added_date'] 		= date("Y-m-d H:i:s");
            $data['values']['added_by'] 		= $userdata;
            $this->start_suppliermodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Head Agent",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'head agents added successfully');
            redirect('start_supplier/listall');
        }else{
            $this->load->model("project/projectmodel");
            $data['counselers'] = $this->projectmodel->get_empoyee();
            $data['page'] = 'add';
            $data['heading'] = 'Add Access';
            $this->load->vars($data);
            $this->load->view($this->container);
        }
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------------------edit--------------------------------------
function edit($id) {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            // $id = $this->input->post('type_id');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['name']	= $this->input->post('name');
            $data['values']['company_name']    = $this->input->post('company_name');
            $data['values']['email']    = $this->input->post('email');
            $data['values']['phone']    = $this->input->post('phone');
            $data['values']['address']    = $this->input->post('address');
            $data['values']['product']	= $this->input->post('product');
            $data['values']['status']	= $this->input->post('action');
            $data['values']['created_by']	= $this->input->post('staff');
            $data['values']['modified_date']    = date("Y-m-d H:i:s");
            $data['values']['modified_by']      = $userdata;
            $this->start_suppliermodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Head Agent",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'head agents edited Successfully');
            redirect('start_supplier/listall');
        } else {
            $this->load->model("project/projectmodel");
            $data['counselers'] = $this->projectmodel->get_empoyee();
            $query = $this->start_suppliermodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('start_supplier/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('start_supplier',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->start_suppliermodel->delete($delid);
        $this->session->set_flashdata('success_message', 'start_supplier deleted successfully');
        redirect('start_supplier/listall');
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
        $content = $this->usermodel->getDeletedData('start_supplier',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Business Category",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->start_suppliermodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}