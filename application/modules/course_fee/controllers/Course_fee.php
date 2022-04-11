<?php
class Course_fee extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('course_feemodel');
        $this->load->model('appointment/appointmentmodel');
        $this->load->model('download/downloadmodel');
        $this->load->model('doc_type/doc_typemodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'course_fee_Manager';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('course_fee/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['access'] 	= $this->course_feemodel->listall();
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
            $data['values']['country_id']  = $this->input->post('country');
            $data['values']['intake_id']  = $this->input->post('intake');
            $data['values']['college']	= $this->input->post('college');
            $data['values']['degree']  = $this->input->post('degree');
            $data['values']['course']  = $this->input->post('course');
            $data['values']['currency'] = $this->input->post('currency');
            $data['values']['price']  = $this->input->post('fee');
            $data['values']['tri_fee']  = $this->input->post('tri_fee');
            $data['values']['y_price']  = $this->input->post('y_fee');
            $data['values']['t_price']  = $this->input->post('t_fee');
            $data['values']['period']  = $this->input->post('duration');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->course_feemodel->add($data['values']);

            $course_id = $this->db->insert_id();
            if($this->input->post("chk_list")){
                $chk_lists = $this->input->post("chk_list");
                foreach ($chk_lists as $key => $value) {
                 $chklist = array("fee_id" => $course_id, "checklist_id"=>$value);
                 $this->db->insert("course_fee_checklist",$chklist);
             }
         }

         if($this->input->post("chk_coe_list")){
            $chk_lists = $this->input->post("chk_coe_list");
            foreach ($chk_lists as $key => $value) {
             $chklist = array("fee_id" => $course_id, "checklist_id"=>$value,"checklist_type"=>'ceo-processing');
             $this->db->insert("course_fee_checklist",$chklist);
         }
     }

         if($this->input->post("chk_form")){
            $chk_forms = $this->input->post("chk_form");
            foreach ($chk_forms as $key => $value) {
                $forms = array("fee_id" => $course_id, "form_id"=>$value);
                $this->db->insert("course_fee_form",$forms);
            }
        }

        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Add",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->session->set_flashdata('success_message', 'course fee added successfully');
        redirect('course_fee/listall');
    }else{
     $data['countries']      = $this->appointmentmodel->get_country();
     $data['intakes']      = $this->appointmentmodel->get_Intakes();
          // $data['colleges'] = $this->course_feemodel->getcolleges();
    
     $data['currencies'] = $this->course_feemodel->get_currency();
     $data['downloads']     = $this->downloadmodel->listall(14);
    //  echo $this->db->last_query();die();
     $data['checklist']      = $this->doc_typemodel->listall(14);
    
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
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('type_id');
            $userdata = $this->session->userdata("clms_front_userid");
            $data['values']['country_id']  = $this->input->post('country');
            $data['values']['intake_id']  = $this->input->post('intake');
            $data['values']['college']  = $this->input->post('college');
            $data['values']['degree']  = $this->input->post('degree');
            $data['values']['course']  = $this->input->post('course');
            $data['values']['currency'] = $this->input->post('currency');
            $data['values']['price']  = $this->input->post('fee');
            $data['values']['tri_fee']  = $this->input->post('tri_fee');
            $data['values']['y_price']  = $this->input->post('y_fee');
            $data['values']['t_price']  = $this->input->post('t_fee');
            $data['values']['period']  = $this->input->post('duration');
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->course_feemodel->update($id, $data['values']);

            $this->db->where("fee_id",$id);
            $this->db->delete("course_fee_checklist");

            $this->db->where("fee_id",$id);
            $this->db->delete("course_fee_form");
            
            $course_id = $id;
            if($this->input->post("chk_list")){
                $chk_lists = $this->input->post("chk_list");
                foreach ($chk_lists as $key => $value) {
                 $chklist = array("fee_id" => $course_id, "checklist_id"=>$value);
                 $this->db->insert("course_fee_checklist",$chklist);
             }
         }

         if($this->input->post("chk_coe_list")){
            $chk_lists = $this->input->post("chk_coe_list");
            foreach ($chk_lists as $key => $value) {
             $chklist = array("fee_id" => $course_id, "checklist_id"=>$value,"checklist_type"=>'ceo-processing');
             $this->db->insert("course_fee_checklist",$chklist);
         }
     }

         if($this->input->post("chk_form")){
            $chk_forms = $this->input->post("chk_form");
            foreach ($chk_forms as $key => $value) {
                $forms = array("fee_id" => $course_id, "form_id"=>$value);
                $this->db->insert("course_fee_form",$forms);
            }
        }

        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Edit",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->session->set_flashdata('success_message', 'course fee edited Successfully');
        redirect('course_fee/listall');
    } else {
     $data['countries']      = $this->appointmentmodel->get_country();
     $data['intakes']      = $this->appointmentmodel->get_Intakes();
        // $data['colleges'] = $this->course_feemodel->getcolleges();
     $data['degree'] = $this->course_feemodel->getDegree();
     $data['currencies'] = $this->course_feemodel->get_currency();
     $data['downloads']     = $this->downloadmodel->listall(14);
     $data['checklist']      = $this->doc_typemodel->listall(14);
     
     $id = $this->uri->segment(3);
     $query = $this->course_feemodel->getdata($id);
     if ($query->num_rows() > 0) {
        $data['result'] 	= $query->row();
        $data['page'] 		= 'edit';
        $data['heading'] 	= 'Edit Chat';
        $this->load->view('main', $data);
    } else {
        redirect('course_fee/listall');
    }
}
}
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("fee_id"=>$delid);
        $content = $this->usermodel->getDeletedData('course_fee',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->course_feemodel->delete($delid);
        $this->session->set_flashdata('success_message', 'course fee deleted successfully');
        redirect('course_fee/listall');
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
        $content = $this->usermodel->getDeletedData('course_fee',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Business Category",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->course_feemodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

function getCourse(){
    $degree = $this->input->post("degree");
    $course = $this->course_feemodel->getCourse($degree);
    ?>
    <option value="">Select</option>
    <?php
    foreach($course as $row){
        ?>
        <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
        <?php
    }

}

function getColleges(){
    $country = $this->input->post("country");
    $colleges = $this->course_feemodel->getColleges($country);
    ?>
    <option value="">Select</option>
    <?php
    foreach($colleges as $row){
        ?>
        <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
        <?php
    }

}

function getDegree(){
    $college = $this->input->post("college");
    $colleges = $this->course_feemodel->getDegree($college);
    ?>
    <option value="">Select</option>
    <?php
    foreach($colleges as $row){
        ?>
        <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
        <?php
    }

}

}