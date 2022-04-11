<?php
class company_package extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('company_packagemodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'company_package';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('company_package/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['company_packages'] 	= $this->company_packagemodel->listall();
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
                $data['values']['package_name']	= $this->input->post('name');
                $data['values']['details'] = $this->input->post('details');
                $data['values']['price'] = $this->input->post('price');
                $data['values']['color'] = $this->input->post('code');
                $data['values']['payment_time'] = $this->input->post('payment_time');
                //$data['values']['company_id']      = $this->session->userdata("clms_company");
                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= time();
                $data['values']['modified_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->company_packagemodel->add($data['values']);
                $packid = $this->db->insert_id();
                if($this->input->post("type")){
                    $types = $this->input->post("type");
                    foreach ($types as $key => $value) {
                       $type_arr = array(
                        "package_id" => $packid,
                        "type_id" => $value
                        );
                       $this->db->insert("company_package_type_data",$type_arr);
                   }
               }
               $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage company_package",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
               $this->usermodel->insertUserlog($logs);
               $this->session->set_flashdata('success_message', 'Company package added successfully');
               redirect('company_package/listall');
           }else{
            $data['types'] = $this->company_packagemodel->get_packageType();
            $data['payment_times'] = $this->company_packagemodel->get_paymentTime();
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
            $id = $this->input->post('company_package_id');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['package_name'] = $this->input->post('name');
            $data['values']['details'] = $this->input->post('details');
            $data['values']['price'] = $this->input->post('price');
            $data['values']['color'] = $this->input->post('code');
            $data['values']['payment_time'] = $this->input->post('payment_time');
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->company_packagemodel->update($id, $data['values']);

            $this->db->where("package_id",$id);
            $this->db->delete("company_package_type_data");
            if($this->input->post("type")){
                $types = $this->input->post("type");
                foreach ($types as $key => $value) {
                   $type_arr = array(
                    "package_id" => $id,
                    "type_id" => $value
                    );
                   $this->db->insert("company_package_type_data",$type_arr);
               }
           }
           $logs = array(
            "content" => serialize($data['values']),
            "action" => "Edit",
            "module" => "Manage company_package",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
           $this->usermodel->insertUserlog($logs);
           $this->session->set_flashdata('success_message', 'Company package edited Successfully');
           redirect('company_package/listall');
       } else {
           $data['payment_times'] = $this->company_packagemodel->get_paymentTime();
           $data['types'] = $this->company_packagemodel->get_packageType();
           $id = $this->uri->segment(3);
           $query = $this->company_packagemodel->getdata($id);
           if ($query->num_rows() > 0) {
            $data['result'] 	= $query->row();
            $data['page'] 		= 'edit';
            $data['heading'] 	= 'Edit Chat';
            $this->load->view('main', $data);
        } else {
            redirect('company_package/listall');
        }
    }
}
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("package_id"=>$delid);
        $content = $this->usermodel->getDeletedData('company_package',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage company_package",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->company_packagemodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('company_package/listall');
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
        $cond = array("package_id"=>$delid);
        $content = $this->usermodel->getDeletedData('company_package',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage company package",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->company_packagemodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}