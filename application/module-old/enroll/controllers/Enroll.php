<?php
class Enroll extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('enrollmodel');
        $this->load->model('student/studentmodel');
        $this->load->model('project/projectmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'enroll_Manager';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('dashboard/enroll', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['access'] 	= $this->enrollmodel->listall();
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
            $date1 = explode('/', $this->input->post('expiry_date'));
            $date = date("Y-m-d");
            if($this->input->post("student_type") == 1){
                $data['values']['student_id']   = $this->enrollmodel->addStudent();
            }else{
                $data['values']['student_id']   = $this->input->post('student');
            }
            
            $data['values']['degree']  = $this->input->post('degree');
            $data['values']['course']  = $this->input->post('course');
            $data['values']['college']  = $this->input->post('college');
            $data['values']['country']  = $this->input->post('duration');
            $data['values']['visa']  = $this->input->post('visa_type');
            $data['values']['intake']  = $this->input->post('intake');
            $data['values']['current_status']  = $this->input->post('current_status');
            $data['values']['fee']  = $this->input->post('fee');
            $data['values']['period']  = $this->input->post('fee_period');
            $data['values']['pay_period']  = $this->input->post('duration');
            $data['values']['visa_title']  = $this->input->post('visa_title');
            $data['values']['visa_subclass']  = $this->input->post('visa_class');
            $data['values']['expiry_date']  = $date1[2].'-'.$date1[1].'-'.$date1[0];
            $data['values']['enroll_status']  = $this->input->post('visa_status');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['added_date'] 		= date("Y-m-d");
            $data['values']['added_by'] 		= $userdata;
           // $data['values']['modified_date'] 	= time();
          //  $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->enrollmodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Lead Type",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Enroll added successfully');
            redirect('dashboard/enroll');
        }else{
            $data['visa'] = $this->enrollmodel->getVisaType();
            $data['visa_class'] = $this->enrollmodel->getVisaClass();
            $data['colleges'] = $this->enrollmodel->getcolleges();
            $data['degree'] = $this->enrollmodel->getDegree();
            $data['intakes'] = $this->enrollmodel->getIntakes();
            $data['students'] = $this->studentmodel->listall();
            $data['project_status'] = $this->projectmodel->getStatus();
            //echo $this->db->last_query();die();
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

function getEnrollAmount(){
    $college = $this->input->post("college");
    $degree = $this->input->post("degree");
    $course = $this->input->post("course");
    $query = $this->enrollmodel->getEnrollAmount($college,$degree,$course);
    
    if($query->num_rows() > 0){
        $fee = $query->row();
        if($fee->period == 'Semester')
            $tution_fee = $fee->price;
        elseif($fee->period == 'Yearly')
         $tution_fee = $fee->y_price;
     else
        $tution_fee = $fee->t_price;
    $array = array("fee"=>$tution_fee,"period"=>$fee->period,"currency"=>$fee->currency,"fee_id"=>$fee->fee_id);
}else{
    $array = array("fee"=>'',"period"=>'',"period"=>'AUD',"fee_id"=>"");
}
echo json_encode($array);
}

function get_enrollAmount(){
    $college = $this->input->post("college");
    $degree = $this->input->post("degree");
    $course = $this->input->post("course");
    $period = $this->input->post("period");
    $query = $this->enrollmodel->getEnrollAmount($college,$degree,$course,$period);
    $fee = $query->row();

    if($period == 'One Semester')
        $tution_fee = $fee->price;
    elseif($period == 'One Year')
        $tution_fee = $fee->y_price;
    else
        $tution_fee = $fee->t_price;
    echo $tution_fee;
}

    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('enroll_id');
            $userdata = $this->session->userdata("clms_front_userid");
            $date1 = explode('/', $this->input->post('expiry_date'));
            $date = date("Y-m-d");
            $data['values']['student_id']   = $this->input->post('student');
            $data['values']['degree']  = $this->input->post('degree');
            $data['values']['course']  = $this->input->post('course');
            $data['values']['college']  = $this->input->post('college');
            $data['values']['country']  = $this->input->post('duration');
            $data['values']['visa']  = $this->input->post('visa_type');
            $data['values']['intake']  = $this->input->post('intake');
            $data['values']['current_status']  = $this->input->post('current_status');
            $data['values']['fee']  = $this->input->post('fee');
            $data['values']['period']  = $this->input->post('fee_period');
            $data['values']['pay_period']  = $this->input->post('duration');
            $data['values']['visa_title']  = $this->input->post('visa_title');
            $data['values']['visa_subclass']  = $this->input->post('visa_class');
            $data['values']['expiry_date']  = $date1[2].'-'.$date1[1].'-'.$date1[0];
            $data['values']['enroll_status']  = $this->input->post('visa_status');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");

            $data['values']['status']      = 1;
            $this->enrollmodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Lead Type",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Enroll edited Successfully');
            redirect('dashboard/enroll');
        } else {
           $data['visa'] = $this->enrollmodel->getVisaType();
           $data['visa_class'] = $this->enrollmodel->getVisaClass();
           $data['colleges'] = $this->enrollmodel->getcolleges();
           $data['degree'] = $this->enrollmodel->getDegree();
           $data['intakes'] = $this->enrollmodel->getIntakes();
           $data['students'] = $this->studentmodel->listall();
           $data['project_status'] = $this->projectmodel->getStatus();
           $id = $this->uri->segment(3);
           $query = $this->enrollmodel->getdata($id);
           if ($query->num_rows() > 0) {
            $data['result'] 	= $query->row();
            $data['page'] 		= 'edit';
            $data['heading'] 	= 'Edit Chat';
            $this->load->view('main', $data);
        } else {
            redirect('dashboard/enroll');
        }
    }
}
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("type_id"=>$delid);
        $content = $this->usermodel->getDeletedData('enroll',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->enrollmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Enroll deleted successfully');
        redirect('dashboard/enroll');
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
        $cond = array("enroll_id"=>$delid);
        $content = $this->usermodel->getDeletedData('enroll',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Business Category",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->enrollmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

function getCourse(){
    $degree = $this->input->post("degree");
    $course = $this->enrollmodel->getCourse($degree);
    ?>
    <option value="">Select</option>
    <?php
    foreach($course as $row){
        ?>
        <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
        <?php
    }

}

}