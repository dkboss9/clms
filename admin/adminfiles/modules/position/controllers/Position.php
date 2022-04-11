<?php
class Position extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('positionmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'POSITION';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('position/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['positions'] 	= $this->positionmodel->all_position();
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
            $data['values']['position_title']	= $this->input->post('name');
            $data['values']['company_id']      = $this->session->userdata("clms_company");
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->positionmodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage position",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
            );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Position type added successfully');
            redirect('position/listall');
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

function addPosition(){
    if($this->session->userdata("clms_userid")!="" && $this->usermodel->checkperm($this->module_code,"ADD")){
       if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
          echo '<strong>We must tell you! </strong> Please select company to add this data.';
          exit;
      }
      $this->form_validation->set_rules('position_type','Position','required');

      if($this->form_validation->run()==FALSE){
        echo "Required field(s) missing";
        exit();
    }else{
     $this->db->select("count(id) num");
     $this->db->from("position p");
     $this->db->where("position_title",$this->input->post('position_type'));
     $query = $this->db->get()->row();
     if($query->num > 0){
        echo "Position type already exists";
        exit();
    }

    $userdata = $this->session->userdata("clms_userid");
    $date = date("Y-m-d");
    $data['values']['position_title']   = $this->input->post('position_type');
    $data['values']['company_id']      = $this->session->userdata("clms_company");
    $data['values']['added_date']       = time();
    $data['values']['added_by']         = $userdata;
    $data['values']['modified_date']    = time();
    $data['values']['modified_by']      = $userdata;
    $data['values']['status']      = 1;
    $this->positionmodel->add($data['values']);
    $id = $this->db->insert_id();

    $logs = array(
        "content" => serialize($data['values']),
        "action" => "Add",
        "module" => "Position Type",
        "added_by" => $this->session->userdata("clms_userid"),
        "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs);
    echo $id;
}

}else{
    $this->session->set_flashdata('error','Please login with your username and password');
    redirect('login','location');
}
}

    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('position_id');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['position_title']    = $this->input->post('name');
            $data['values']['added_date']       = time();
            $data['values']['added_by']         = $userdata;
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->positionmodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage position",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
            );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Position type edited Successfully');
            redirect('position/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->positionmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('position/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('position',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage position",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
        );
        $this->usermodel->insertUserlog($logs);
        $this->positionmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('position/listall');
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
        $content = $this->usermodel->getDeletedData('position',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage position",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
        );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->positionmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}