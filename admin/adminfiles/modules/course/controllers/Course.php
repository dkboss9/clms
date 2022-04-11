<?php
class Course extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('coursemodel');
        $this->load->model('appointment/appointmentmodel');
        $this->load->model('course_fee/course_feemodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'Course_Manager';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('course/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['access'] 	= $this->coursemodel->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function addCourse(){
        $name = $this->input->post("course_name");
        $userdata = $this->session->userdata("clms_userid");
        $date = date("Y-m-d");
        $data['values']['type_name']    = $name;
        $data['values']['course_desc']    = $this->input->post('course_desc');
        $data['values']['degree_id']   = $this->input->post('course_degree');
        $data['values']['period']   = $this->input->post('course_period');
        $data['values']['company_id']      = $this->session->userdata("clms_company");
        $data['values']['added_date']       = time();
        $data['values']['added_by']         = $userdata;
        $data['values']['modified_date']    = time();
        $data['values']['modified_by']      = $userdata;
        $data['values']['status']      = 1;
        $this->coursemodel->add($data['values']);

        $id = $this->db->insert_id();
        $array = array("id"=>$id,"name"=>$name);
        echo json_encode($array);
    }

    //--------------------------------------add--------------------------------------	
    function add() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {
             /*if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }*/
            $userdata = $this->session->userdata("clms_userid");
            $date = date("Y-m-d");
            $data['values']['country_id']    = $this->input->post('country');
            $data['values']['college_id']    = $this->input->post('college');
            $data['values']['type_name']	= $this->input->post('name');
            $data['values']['course_desc']    = $this->input->post('txt_desc');
            $data['values']['degree_id']   = $this->input->post('degree');
            $data['values']['period']   = $this->input->post('period');
            $data['values']['company_id']      = $this->session->userdata("clms_company");
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->coursemodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Lead Type",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
            );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'course added successfully');
            redirect('course/listall');
        }else{
            $data['degree'] = $this->coursemodel->getDegree();
            $data['countries']      = $this->appointmentmodel->get_country();
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
function edit() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('type_id');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['country_id']    = $this->input->post('country');
            $data['values']['college_id']    = $this->input->post('college');
            $data['values']['type_name']    = $this->input->post('name');
            $data['values']['course_desc']    = $this->input->post('txt_desc');
            $data['values']['degree_id']   = $this->input->post('degree');
            $data['values']['period']   = $this->input->post('period');
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
          //  print_r( $data['values']);die();
            $this->coursemodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Lead Type",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
            );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'course edited Successfully');
            redirect('course/listall');
        } else {
            $data['countries']      = $this->appointmentmodel->get_country();
            $data['degree'] = $this->coursemodel->getDegree();
            $id = $this->uri->segment(3);
            $query = $this->coursemodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('course/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("type_id"=>$delid);
        $content = $this->usermodel->getDeletedData('course',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
        );
        $this->usermodel->insertUserlog($logs);
        $this->coursemodel->delete($delid);
        $this->session->set_flashdata('success_message', 'course deleted successfully');
        redirect('course/listall');
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
        $cond = array("type_id"=>$delid);
        $content = $this->usermodel->getDeletedData('course',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Business Category",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
        );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->coursemodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}