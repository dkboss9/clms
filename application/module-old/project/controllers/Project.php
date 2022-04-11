<?php
class Project extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->container = 'main';
    $this->load->model('projectmodel');
    $this->load->model('users/usermodel');
    $this->load->model('lms/lmsmodel');
    $this->load->model('appointment/appointmentmodel');
    $this->load->model('intake/intakemodel');
    $this->load->model('enroll/enrollmodel');
    $this->load->model('student/studentmodel');
    $this->load->model('college/collegemodel');
    $this->load->model('degree/degreemodel');
    $this->load->model('course/coursemodel');
    $this->load->model('course_fee/course_feemodel');
    $this->module_code = 'project';
    $this->load->library('html2pdf');
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
      if($this->input->get("added_date"))
        $added_date = $this->input->get("added_date");
      else
        $added_date = "";

      if($this->input->get("type"))
        $type = $this->input->get("type");
      else
        $type = "";

      if($this->input->get("project_status"))
        $status = $this->input->get("project_status");
      else
        $status = "";
      $data['search_status'] = $status;
      if($this->input->get("deadline"))
        $deadline = $this->input->get("deadline");
      else
        $deadline = "";

      if($this->input->get("start_date"))
        $start_date = $this->input->get("start_date");
      else
        $start_date = "";

      $data['search_start_date'] = $start_date;


      if($this->input->get("end_date"))
        $end_date = $this->input->get("end_date");
      else
        $end_date = "";

      $data['search_end_date'] = $end_date;

      if($this->input->get("handle"))
        $handle = $this->input->get("handle");
      else
        $handle = "";

      $data['search_handle'] = $handle;

      if($this->input->get("filter_by"))
        $filter = $this->input->get("filter_by");
      else
        $filter = "";

      $data["search_filter"] = $filter;

      if($this->input->get("is_assigned"))
        $is_assigned = $this->input->get("is_assigned");
      else
        $is_assigned = "";

      $data["search_is_assigned"] = $is_assigned;

      if($this->input->get("commenced_date"))
        $commenced_date = $this->input->get("commenced_date");
      else
        $commenced_date = '';



      $data['status'] 	= $this->projectmodel->listall($added_date,$type,$status,$deadline,$start_date,$end_date,$handle,$filter,$is_assigned,$commenced_date);
     // echo $this->db->last_query();die();
      $data['users']      = $this->lmsmodel->get_users();
      $data['project_status'] = $this->projectmodel->getStatus();
      $data['page'] 			= 'list';
      $this->load->vars($data);
      $this->load->view($this->container);
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

  function get_userDetail(){
    $userid = $this->input->post("studentid");
    $this->db->where("id",$userid);
    $result = $this->db->get("company_students")->row();

    echo '<p>Name: '.$result->first_name.' '.$result->last_name.'</p>';
    echo '<p>Email: '.$result->email.'</p>';
    echo '<p>Contact no: '.$result->phone.'</p>';
  }


  function callendar(){
    $data['projects']   = $this->projectmodel->listall();
    $data['category']      = $this->lmsmodel->get_category(0);
    $data['customer']      = $this->projectmodel->get_customer();
    $data['project_status'] = $this->projectmodel->getStatus();
    $data['gst'] = $this->generalsettingsmodel->getConfigData(53)->row();
    $data['lead_types']      = $this->lmsmodel->get_leadTypes();
    $data['users']      = $this->lmsmodel->get_users();
    $data['employees'] = $this->projectmodel->get_empoyee();
    $data['suppliers'] = $this->projectmodel->get_supplier();
    $data['packages'] = $this->projectmodel->get_packages();
    $data['page']       = 'callendar';
    $this->load->vars($data);
    $this->load->view($this->container);
  }

    //--------------------------------------add--------------------------------------	
  function add() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
      $this->form_validation->set_rules('lead_type', 'Lead Type', 'required');

      if ($this->form_validation->run() == FALSE){
        if($this->uri->segment(3) != '' && $this->uri->segment(3) > 0){
          $leadid = $this->uri->segment(3);
          $data['lead'] = $this->lmsmodel->getdata($leadid)->row();
        }
        $data['category']      = $this->lmsmodel->get_category(0);
        $data['customer']      = $this->projectmodel->get_customer();
        $data['project_status'] = $this->projectmodel->getStatus();
        $data['gsts'] = $this->projectmodel->getGsts();
        $data['lead_types']      = $this->lmsmodel->get_leadTypes();
        $data['users']      = $this->lmsmodel->get_users();
        $data['employees'] = $this->projectmodel->get_empoyee();
        $data['suppliers'] = $this->projectmodel->get_supplier();
        $data['packages'] = $this->projectmodel->get_packages();

        $data['visa'] = $this->enrollmodel->getVisaType();
        $data['visa_class'] = $this->enrollmodel->getVisaClass();
        $data['colleges'] = $this->enrollmodel->getcolleges();
        $data['degree'] = $this->enrollmodel->getDegree();
        $data['intakes'] = $this->enrollmodel->getIntakes();
        $data['students'] = $this->studentmodel->listall();
        $data['currencies'] = $this->course_feemodel->get_currency();
        $data['about_us']      = $this->lmsmodel->about_us();

        $data['countries']      = $this->appointmentmodel->get_country();
        $data['levels'] = $this->collegemodel->getcollegelevel();

       //print_r($data['users']);die();
        $data['form'] = $this->projectmodel->get_form();
        $data['page'] = 'add';
        $data['heading'] = 'Add Task Status';
        $this->load->vars($data);
        $this->load->view($this->container);
      }
      else
      {
       if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
        redirect($_SERVER["HTTP_REFERER"],"refresh");
      }
      $type = $this->input->post('lead_type');
      $sales_rep = $this->input->post('user');
      $rate = $this->projectmodel->getRate($type,$sales_rep);
      
      $price = $this->input->post('total_fee');
      $commission = (intVal($rate)*$price)/100; 
      $userdata = $this->session->userdata("clms_front_userid");
      $data_post = $_POST;
      $data['values']['form_post']   = serialize($data_post);
      $date = date("Y-m-d");
      $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
      $data['values']['lead_type']              = $this->input->post('lead_type');
      $data['values']['sales_rep']              = $this->input->post('user');
      $data['values']['description']    = $this->input->post('description');
      $data['values']['note']    = $this->input->post('note');
      $data['values']['is_packaged']    = $this->input->post('show_package');
      $data['values']['price']    = $this->input->post('price');
      $data['values']['gst']    = $this->input->post('gst');
      $data['values']['total']    = $this->input->post('total');
      $data['values']['grand_total']    = $this->input->post('grand');
      $data['values']['project_status']    = $this->input->post('project_status');
      $data['values']['commission_rate']    = intVal($rate);
      $data['values']['commission']    = $commission;

      $data['values']['start_date']   = strtotime($this->input->post('start_date'));
      $data['values']['end_date']   = strtotime($this->input->post('end_date'));
      $data['values']['commence_date']   = date("Y-m-d",strtotime($this->input->post("commence_date")));
      $data['values']['added_date']       = time();
      $data['values']['added_by']         = $userdata;
      $data['values']['status']      = 1;
      $this->projectmodel->add($data['values']);
      $id = $this->db->insert_id();
      $this->db->where("project_id",$id);
      $this->db->set("order_no",1000+$id);
      $this->db->update("projects");

      $packages = $this->input->post("package");
      $qty = $this->input->post("qty");
      $unit_price = $this->input->post("unit_price");
      $total_price = $this->input->post("package_price");
      if($packages){
        foreach ($packages as $key => $value) {
         $pack_arr = array(
          "project_id" => $id,
          "package_id" => $value,
          "qty" => $qty[$key],
          "unit_price" => $unit_price[$key],
          "total_price" => $total_price[$key]
          );
         $this->db->insert("project_package",$pack_arr);
       }
     }

     $employees = $this->input->post("employee");
     if($employees){
      foreach ($employees as $key => $value) {
        $emp_array = array(
          "project_id" => $id,
          "employee_id" => $value
          );
        $this->db->insert("project_employee",$emp_array);
      }
    }

    $suppliers = $this->input->post("supplier");
    if($suppliers){
      foreach ($suppliers as $key => $value) {
        $emp_array = array(
          "project_id" => $id,
          "supplier_id" => $value
          );
        $this->db->insert("project_supplier",$emp_array);
      }
    }

    $this->addEnroll($id);

    $logs = array(
      "content" => serialize($data['values']),
      "action" => "Add",
      "module" => "Manage Prject",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
      );
    $this->usermodel->insertUserlog($logs);
    $enroll = $this->projectmodel->projectDetail($id)->row();
   // echo $this->db->last_query(); die();
    $notifications = array(
      "content" => $this->session->userdata("clms_front_username").' has added your enrolment.',
      "link" => 'student/enrolments/'.$enroll->student_id,
      "from_id" => $this->session->userdata("clms_front_userid"),
      "to_id" => $enroll->student_id,
      "added_date" => date("Y-m-d")
      );
    $this->db->insert("student_notifications",$notifications);

    $this->projectmodel->sendemail($id); 
    $this->session->set_flashdata('success_message', 'Project added successfully');
    if($this->input->post("project") == 1){
      redirect('project/cases/'.$this->input->post("student"));
    }else{
      if(strpos($_SERVER["HTTP_REFERER"], 'callendar') === false)
      redirect('dashboard/enroll');
    else
      redirect($_SERVER["HTTP_REFERER"]);
    }
   
  }

} else {
  $this->session->set_flashdata('error', 'Please login with your username and password');
  redirect('login', 'location');
}
}

function addEnroll($orderid){
  $userdata = $this->session->userdata("clms_front_userid");
 
  if($this->input->post("student_type") == 1){
    $data['values']['student_id']   = $this->enrollmodel->addStudent();
  }else{
    $data['values']['student_id']   = $this->input->post('student');
  }

  $data['values']['order_id']  = $orderid;
  $data['values']['degree']  = $this->input->post('degree');
  $data['values']['course']  = $this->input->post('course');
  $data['values']['college']  = $this->input->post('college');
  $data['values']['country']  = $this->input->post('duration');
  $data['values']['visa']  = $this->input->post('visa_type');
  $data['values']['visa_sub_category']  = $this->input->post('sub_visa_type');
  $data['values']['intake']  = $this->input->post('intake');
  $data['values']['currency']  = $this->input->post('currency');
  $data['values']['current_status']  = $this->input->post('current_status');
  $data['values']['fee']  = $this->input->post('fee');
  $data['values']['fee_id']  = $this->input->post('fee_id');
  $data['values']['period']  = $this->input->post('fee_period');
  $data['values']['pay_period']  = $this->input->post('duration');
  $data['values']['discount']  = $this->input->post('txt_discount');
  $data['values']['is_percent']  = $this->input->post('is_percentage');
  $data['values']['total_fee']  = $this->input->post('total_fee');
  $data['values']['visa_title']  = $this->input->post('visa_title');
  $data['values']['visa_subclass']  = $this->input->post('visa_class');
  $data['values']['expiry_date']  = date("Y-m-d",strtotime($this->input->post('expiry_date')));
  $data['values']['enroll_status']  = $this->input->post('visa_status');
  $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
  $data['values']['added_date']     = date("Y-m-d");
  $data['values']['added_by']     = $userdata;
  $data['values']['status']      = 1;
  $this->enrollmodel->add($data['values']);
}

public function username_check($str)
{
  $num = $this->projectmodel->check_duplicateEmail($str);
  if ($num > 0)
  {
    $this->form_validation->set_message('username_check', 'Email already in use.');
    return FALSE;
  }
  else
  {
    return TRUE;
  }
}

function edit_checklist($chklistid,$enrollid){
  if($this->input->post("submit")){
    $insert_array = array(
      "checklist_id" => $chklistid,
      "enroll_id" => $enrollid,
      "received_date" => $this->input->post("received_date"),
      "note" => $this->input->post("note"),
      "checklist_status" => $this->input->post("status"),
      "added_date" => date("Y-m-d h:i:s"),
      "added_by" => $this->session->userdata("clms_front_userid")
      );
  

      $query = $this->projectmodel->checkChecklist($chklistid,$enrollid);
      if($query->num_rows()>0){
        $enroll_checklist_id = $query->row()->id;
        $this->db->where("checklist_id",$chklistid);
        $this->db->where("enroll_id",$enrollid);
        $this->db->update("enroll_checklist",$insert_array);
      }else{
        $this->db->insert("enroll_checklist",$insert_array);
        $enroll_checklist_id = $this->db->insert_id();
      }
  
      $file_names = $this->input->post("file_name")??[];
      foreach($file_names as $name){
        $this->db->insert("pnp_enroll_checklist_files",[
          "enroll_checklist_id" => $enroll_checklist_id,
          "checklist_file" => $name
          ]);
      }

      $this->load->model("quote/quotemodel");
      $enroll = $this->projectmodel->projectDetail($enrollid)->row();
      $customer = $this->quotemodel->getCustomer($enroll->student_id);
 
    $notifications = array(
      "content" => $this->session->userdata("clms_front_username").' has  '.$this->input->post("status").' your checklist.',
      "link" => 'project/checklist/'.$enrollid,
      "from_id" => $this->session->userdata("clms_front_userid"),
      "to_id" =>$this->session->userdata("clms_front_user_group") != 14 ? $customer->student_id : $this->session->userdata("clms_front_companyid") ,
      "added_date" => date("Y-m-d")
      );
    $this->db->insert("student_notifications",$notifications);

    
    if($this->input->post("note")!=""){
     $enroll_checklist = $this->projectmodel->checkChecklist($chklistid,$enrollid)->row();
     $note = array(
      "checklist_id" =>   $enroll_checklist->id,
      "note" => $this->input->post("note"),
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => date("Y-m-d")
      );
     $this->db->insert("enroll_checklist_note",$note);
   }
   $this->projectmodel->sendchecklistemail($chklistid,$enrollid,$this->input->post("note"));
   $this->session->set_flashdata('success_message', 'Checklist updated Successfully');
  //  redirect("project/checklist/".$enrollid);
  redirect($_SERVER['HTTP_REFERER']);
 }else{
   $query = $this->projectmodel->getdata($enrollid);
   if ($query->num_rows() > 0) {
    $data['result']     = $query->row();
    $data['enroll'] = $this->enrollmodel->getdata($enrollid)->row();
    $data['enroll_checklist'] = $this->projectmodel->checkChecklist($chklistid,$enrollid)->row();
    $data['checklistid'] = $chklistid;
    $data['page']       = 'edit_checklist';
    $data['heading']    = 'Edit Chat';
    $this->load->view('edit_checklist', $data);
  } else {
    redirect('dashboard/student');
  }
}
}

function checklist($enrollid){
  if($this->input->post("submit")){

  }else{
   $query = $this->projectmodel->getdata($enrollid);
   if ($query->num_rows() > 0) {
    $data['result']     = $query->row();
    $data['enroll'] = $this->enrollmodel->getdata($enrollid)->row();
    $data['page']       = 'checklist';
    $data['heading']    = 'Edit Chat';
    $this->load->view('main', $data);
  } else {
    redirect('dashboard/student');
  }
}
}

function form_download($enrollid){
  $query = $this->projectmodel->getdata($enrollid);
  if ($query->num_rows() > 0) {
    $data['result']     = $query->row();
    $data['enroll'] = $this->enrollmodel->getdata($enrollid)->row();
    $data['page']       = 'form_download';
    $data['heading']    = 'Edit Chat';
    $this->load->view('main', $data);
  } else {
    redirect('dashboard/student');
  }
}

    //---------------------------------edit--------------------------------------
function edit() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
    if ($this->input->post('submit')) {
      $id = $this->input->post('project_id');
      $userdata = $this->session->userdata("clms_front_userid"); 

      $type = $this->input->post('lead_type');
      $sales_rep = $this->input->post('user');
      $rate = $this->projectmodel->getRate($type,$sales_rep);
     // echo $this->db->last_query(); die();
      $price = $this->input->post('total_fee');
      $commission = (intVal($rate)*$price)/100;
      $data_post = $_POST;
      $data['values']['lead_type']              = $this->input->post('lead_type');
      $data['values']['sales_rep']              = $this->input->post('user');
      $data['values']['description']    = $this->input->post('description');
      $data['values']['note']    = $this->input->post('note');
      $data['values']['price']    = $this->input->post('price');
      $data['values']['gst']    = $this->input->post('gst');
      $data['values']['total']    = $this->input->post('total');
      $data['values']['is_packaged']    = $this->input->post('show_package');
      $data['values']['shipping']    = $this->input->post('shipping');
      $data['values']['grand_total']    = $this->input->post('grand');
      $data['values']['project_status']    = $this->input->post('project_status');
      $data['values']['commission_rate']    = intVal($rate);
      $data['values']['commission']    = $commission;
      $data['values']['start_date']   = strtotime($this->input->post('start_date'));
      $data['values']['end_date']   = strtotime($this->input->post('end_date'));
      $data['values']['commence_date']   = $this->intakemodel->save_date($this->input->post("commence_date"));
      $data['values']['modified_date']    = time();
      $data['values']['modified_by']      = $userdata;
      $this->projectmodel->update($id, $data['values']);

      $this->db->where("project_id",$id);
      $this->db->delete("project_package");

      $packages = $this->input->post("package");
      $qty = $this->input->post("qty");
      $unit_price = $this->input->post("unit_price");
      $total_price = $this->input->post("package_price");
      if($packages){
        foreach ($packages as $key => $value) {
         $pack_arr = array(
          "project_id" => $id,
          "package_id" => $value,
          "qty" => $qty[$key],
          "unit_price" => $unit_price[$key],
          "total_price" => $total_price[$key]
          );
         $this->db->insert("project_package",$pack_arr);
       }
     }

     $this->db->where("project_id",$id);
     $this->db->delete("project_employee");
     $employees = $this->input->post("employee");

     if($employees){
      foreach ($employees as $key => $value) {
        $emp_array = array(
          "project_id" => $id,
          "employee_id" => $value
          );
        $this->db->insert("project_employee",$emp_array);
      }
    }

    $this->db->where("project_id",$id);
    $this->db->delete("project_supplier");
    $suppliers = $this->input->post("supplier");

    if($suppliers){
      foreach ($suppliers as $key => $value) {
        $emp_array = array(
          "project_id" => $id,
          "supplier_id" => $value
          );
        $this->db->insert("project_supplier",$emp_array);
      }
    }

    $this->edit_enroll($id);
    $logs = array(
      "content" => serialize($data['values']),
      "action" => "Edit",
      "module" => "Manage Project",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
      );
    $this->usermodel->insertUserlog($logs);
    $this->session->set_flashdata('success_message', 'Project edited Successfully');
    if($this->input->post("project") == 1){
      redirect('project/cases/'.$this->input->post("student"));
    }else{
    if(strpos($_SERVER["HTTP_REFERER"], 'callendar') === false)
      redirect('dashboard/enroll');
    else
      redirect($_SERVER["HTTP_REFERER"]);
    }
  } else {
   $data['project_status'] = $this->projectmodel->getStatus();
   $data['gsts'] = $this->projectmodel->getGsts();
   $data['lead_types']      = $this->lmsmodel->get_leadTypes();
   $data['users']      = $this->lmsmodel->get_users();
   $data['employees'] = $this->projectmodel->get_empoyee();
   $data['suppliers'] = $this->projectmodel->get_supplier();
   $data['packages'] = $this->projectmodel->get_packages();

   $data['visa'] = $this->enrollmodel->getVisaType();
   $data['visa_class'] = $this->enrollmodel->getVisaClass();
   $data['colleges'] = $this->enrollmodel->getcolleges();
   //$data['degree'] = $this->enrollmodel->getDegree();
   $data['intakes'] = $this->enrollmodel->getIntakes();
   $data['students'] = $this->studentmodel->listall();
   $data['currencies'] = $this->course_feemodel->get_currency();

   $id = $this->uri->segment(3);
   $data['project_packages'] = $this->projectmodel->get_projectPackage($id);
   $query = $this->projectmodel->getdata($id);
    // echo $this->db->last_query(); die();
   if ($query->num_rows() > 0) {
    $data['result'] 	= $query->row();
    $data['enroll'] = $this->enrollmodel->getdata($id)->row();
    //echo $this->db->last_query();
   // print_r($data['enroll']); die();
    $data['page'] 		= 'edit';
    $data['heading'] 	= 'Edit Task status';
    $this->load->view('main', $data);
  } else {
    redirect('dashboard/enroll');
  }
}
}
}

function edit_enroll($id){
 
  $data['values']['student_id']   = $this->input->post('student');
  $data['values']['degree']  = $this->input->post('degree');
  $data['values']['course']  = $this->input->post('course');
  $data['values']['college']  = $this->input->post('college');
  $data['values']['country']  = $this->input->post('duration');
  $data['values']['visa']  = $this->input->post('visa_type');
  $data['values']['visa_sub_category']  = $this->input->post('sub_visa_type');
  $data['values']['intake']  = $this->input->post('intake');
  $data['values']['current_status']  = $this->input->post('current_status');
  $data['values']['currency']  = $this->input->post('currency');
  $data['values']['fee']  = $this->input->post('fee');
  $data['values']['fee_id']  = $this->input->post('fee_id');
  $data['values']['period']  = $this->input->post('fee_period');
  $data['values']['pay_period']  = $this->input->post('duration');
  $data['values']['discount']  = $this->input->post('txt_discount');
  $data['values']['is_percent']  = $this->input->post('is_percentage');
  $data['values']['total_fee']  = $this->input->post('total_fee');
  $data['values']['visa_title']  = $this->input->post('visa_title');
  $data['values']['visa_subclass']  = $this->input->post('visa_class');
  $data['values']['expiry_date']  = date("Y-m-d",strtotime($this->input->post("expiry_date")));
  $data['values']['enroll_status']  = $this->input->post('visa_status');
  $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
  $this->db->where("order_id",$id);
  $this->db->update("enroll", $data['values']);
//  echo $this->db->last_query(); die();
}
function employee_assign(){
  if($this->input->post("submit")){
    $project_id = $this->input->post("project_id");
    $project =  $this->projectmodel->projectDetail($project_id)->row();
    $this->db->where("project_id",$project_id);
    $this->db->set("note",$this->input->post("note"));
    $this->db->update("projects");

    $this->db->where("project_id",$project_id);
    $this->db->delete("project_employee");
    $employees = $this->input->post("employee");

    if($employees){
      foreach ($employees as $key => $value) {
        $emp_array = array(
          "project_id" => $project_id,
          "employee_id" => $value
          );
        $this->db->insert("project_employee",$emp_array);
      }
    }

    $this->db->where("project_id",$project_id);
    $this->db->delete("project_supplier");
    $suppliers = $this->input->post("supplier");

    if($suppliers){
      foreach ($suppliers as $key => $value) {
        $emp_array = array(
          "project_id" => $project_id,
          "supplier_id" => $value
          );
        $this->db->insert("project_supplier",$emp_array);
      }
    }
    $this->session->set_flashdata('success_message', 'Employee Assigned Successfully');
    if($this->input->post("project") > 0)
      redirect('project/cases/'.$project->student_id);
    else
      redirect('dashboard/enroll');
  }else{
    $data['result'] =  $this->projectmodel->getdata($this->uri->segment(3))->row();
    $data['project_id'] = $this->uri->segment(3);
    $data['employees'] = $this->projectmodel->get_empoyee();
    $data['suppliers'] = $this->projectmodel->get_supplier();
    $this->load->view('employee_assign', $data);
  }
}

function get_projectPackage(){
  $project_id = $this->input->post("project_id");
  $this->db->select("*")->from("pnp_project_package");
  $this->db->where("project_id",$project_id);
  $query = $this->db->get("")->result();
  echo json_encode($query);
}

function get_packageDetails(){
  $packageid = $this->input->post("packageid");
  $this->db->select("*")->from("pnp_package");
  $this->db->where("package_id",$packageid);
  $query = $this->db->get("")->result();
  echo json_encode($query);
}


function get_projectEmployee(){
  $project_id = $this->input->post("project_id");
  $this->db->select("employee_id")->from("pnp_project_employee");
  $this->db->where("project_id",$project_id);
  $query = $this->db->get("")->result();
  echo json_encode($query);
}

function get_projectSupplier(){
  $project_id = $this->input->post("project_id");
  $this->db->select("supplier_id")->from("pnp_project_supplier");
  $this->db->where("project_id",$project_id);
  $query = $this->db->get("")->result();
  echo json_encode($query);
}

    //------------------------delete---------------------------------------------------------	
function delete() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
    $delid = $this->uri->segment('3');
    $project = $this->projectmodel->projectDetail($delid)->row();
    $cond = array("project_id"=>$delid);
    $content = $this->usermodel->getDeletedData('projects',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => "Delete",
      "module" => "Manage Project",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
      );
    $this->usermodel->insertUserlog($logs);
    $this->projectmodel->delete($delid);
    $this->session->set_flashdata('success_message', 'Record deleted successfully');
    if($this->input->get("project"))
    redirect('project/cases/'.$project->student_id);
    else
    redirect('dashboard/enroll');
  } else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
  }
}

    //---------------------detail---------------------------------
function detail() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
    $id = $this->uri->segment(3);
    $query = $this->Task_category->getdata($id);
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
  foreach ($ids as $key => $delid) {
    $cond = array("project_id"=>$delid);
    $content = $this->usermodel->getDeletedData('projects',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => $action,
      "module" => "Manage Project",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
      );
    $this->usermodel->insertUserlog($logs); 
  }
  $query = $this->projectmodel->cascadeAction($ids, $action);
  $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
  exit();
}

function lead_type_report(){
  $data["lead_type"] = $this->projectmodel->get_leadTypes();
  $data["project_num"] = $this->projectmodel->get_leadTypes_num();
  $data['page']     = 'lead_type';
  $data['heading']  = 'Edit Task status';
  $this->load->view('main', $data);
}

function lead_type_sale_report(){
  $data["lead_type"] = $this->projectmodel->get_leadTypesSales();
  $data["project_num"] = $this->projectmodel->get_leadTypes_numSales();
  $data['page']     = 'lead_type_sale';
  $data['heading']  = 'Edit Task status';
  $this->load->view('main', $data);
}

function lead_type_commission(){
 $data["lead_type"] = $this->projectmodel->get_leadTypesCommission();
 $data["project_num"] = $this->projectmodel->get_leadTypes_numCommission();
 $data['page']     = 'lead_type_commission';
 $data['heading']  = 'Edit Task status';
 $this->load->view('main', $data);
}

function sales_reps_report(){
  $data["sales_rep"] = $this->projectmodel->get_Salereps();
  $data["project_num"] = $this->projectmodel->get_leadTypes_num();
  $data['page']     = 'sales_rep';
  $data['heading']  = 'Edit Task status';
  $this->load->view('main', $data);
}

function sales_reps_sale_report(){
  $data["sales_rep"] = $this->projectmodel->get_SalerepsSales();
  $data["project_num"] = $this->projectmodel->get_leadTypes_numSales();
  $data['page']     = 'sales_rep_sales';
  $data['heading']  = 'Edit Task status';
  $this->load->view('main', $data);
}

function sale_reports(){ 
  $data['page']     = 'sale_reports';
  $data['heading']  = 'Edit Task status';
  $this->load->view('main', $data);
}

function sales_rep_commission(){
  $data["sales_rep"] = $this->projectmodel->get_SalerepsCommissions();
  $data["project_num"] = $this->projectmodel->get_leadTypes_numCommission();
  $data['page']     = 'sales_rep_commission';
  $data['heading']  = 'Edit Task status';
  $this->load->view('main', $data);
}

function status_report(){
 $data["status"] = $this->projectmodel->get_Status();
 $data["project_num"] = $this->projectmodel->get_leadTypes_num();
 $data['page']     = 'statuswise';
 $data['heading']  = 'Edit Task status';
 $this->load->view('main', $data);
}

function status_sale_report(){
  $data["status"] = $this->projectmodel->get_StatusSales();
  $data["project_num"] = $this->projectmodel->get_leadTypes_numSales();
  $data['page']     = 'statuswise_sales';
  $data['heading']  = 'Edit Task status';
  $this->load->view('main', $data);
}

function status_commission(){
  $data["status"] = $this->projectmodel->get_StatusCommission();
  $data["project_num"] = $this->projectmodel->get_leadTypes_numCommission();
  $data['page']     = 'statuswise_commission';
  $data['heading']  = 'Edit Task status';
  $this->load->view('main', $data);
}

function lead_status(){
 $data["status"] = $this->projectmodel->get_LeadStatus();
 //echo $this->db->last_query();
 //print_r($data["status"]); die();
 $data["project_num"] = $this->projectmodel->get_leadStatus_num();
 $data['page']     = 'lead_status';
 $data['heading']  = 'Edit Task status';
 $this->load->view('main', $data);
}

function project_status(){
  $data["status"] = $this->projectmodel->get_projectStatus();
 //echo $this->db->last_query();
 //print_r($data["status"]); die();
  $data["project_num"] = $this->projectmodel->get_projectStatus_num();
  $data['page']     = 'project_status';
  $data['heading']  = 'Edit Task status';
  $this->load->view('main', $data);
}

function lead_category(){
  $data["status"] = $this->projectmodel->get_LeadCategory();
 //echo $this->db->last_query();
 //print_r($data["status"]); die();
  $data["project_num"] = $this->projectmodel->get_LeadCategory_num();
  $data['page']     = 'lead_category';
  $data['heading']  = 'Edit Task status';
  $this->load->view('main', $data);
}

function note($id){
  if($this->input->post("submit")){
    $project_id = $this->input->post("project_id");
    $note_array = array("project_id"=>$project_id,"note"=>$this->input->post("note"),"added_by"=>$this->session->userdata("clms_front_userid"),"added_date"=>date("Y-m-d"));
    $this->db->insert("project_note",$note_array);
    $enroll = $this->projectmodel->projectDetail($project_id)->row();
    $notifications = array(
      "content" => $this->session->userdata("clms_front_username").' has  added the note for you.',
      "link" => 'project/note/'.$project_id,
      "from_id" => $this->session->userdata("clms_front_userid"),
      "to_id" => $enroll->student_id,
      "added_date" => date("Y-m-d")
      );
    $this->db->insert("student_notifications",$notifications);
    $this->projectmodel->sendnoteEmail($project_id,$this->input->post("note"));
    $this->session->set_flashdata('success_message', 'Note added successfully');
    redirect($_SERVER["HTTP_REFERER"]);
  }else{
    $data['project'] = $this->projectmodel->projectDetail($id);
    $data['notes'] = $this->projectmodel->getnotes($id);
    $data['project_id'] = $id;
    $data['page']     = 'note';
    $data['heading']  = 'Edit Lead status';
    $this->load->view('main', $data);
  }
  
}

function profile($student_id,$enroll_id=null){
  $this->load->model("student/studentmodel");
  if($this->session->userdata("clms_front_userid")){
    $data['result'] =  $this->studentmodel->getdata($student_id)->row();
    $data['doc_type'] = $this->studentmodel->get_docType();
    $data['about_us']      = $this->lmsmodel->about_us();
    $data['users']      = $this->lmsmodel->get_users();
    $data['countries']      = $this->appointmentmodel->get_country();
    $data['student_id'] = $student_id;
    $data['enroll_id'] = $enroll_id;

    $data['page'] = 'student';
    $this->load->vars($data);
    $this->load->view($this->container);
  }else{
    redirect("login");
  }
}

function invoice($student_id,$enroll_id=null){
  $status = $this->input->get("status")??null;
  $this->load->model("student/studentmodel");
  $this->load->model("order/ordermodel");
  $this->load->model("quote/quotemodel");
  if($this->session->userdata("clms_front_userid")){
    $data['result'] =  $this->studentmodel->getdata($student_id)->row();
    $data['order'] 	= $this->ordermodel->listall(null,$status,null,null,null,null,null,null,null,null,$student_id);
    $data['student_id'] = $student_id;
    $data['enroll_id'] = $enroll_id;

    $data['page'] = 'invoice';
    $this->load->vars($data);
    $this->load->view($this->container);
  }else{
    redirect("login");
  }
}

function dashboard($student_id){
    $this->load->model("student/studentmodel");
    $this->load->model("order/ordermodel");
    $this->load->model("quote/quotemodel");
    $this->load->model("doc_type/doc_typemodel");
    if($this->session->userdata("clms_front_userid")){
      $data['result'] =  $this->studentmodel->getdata($student_id)->row();
      $data['enrolls'] 	= $this->projectmodel->listall($added_date='',$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='',null,$student_id);
      $data['student_id'] = $student_id;
    //  echo $this->db->last_query(); die();
      $userid = $this->session->userdata("clms_front_userid");
  
       $data['messages'] = $this->projectmodel->getChatMessages($userid,$student_id);

       $data['point'] = $this->projectmodel->getCollectedPoints($student_id);

       $data['order'] 	= $this->projectmodel->getTotalInvoice($student_id);

       $data['documents'] = $this->studentmodel->getDoccuments($student_id);

       $data['docs'] = $this->doc_typemodel->listall(28)->result();

       $data['appointments'] = $this->appointmentmodel->listall('','','','','','','','','',1,$student_id);

       $data['active_appointments'] = $this->appointmentmodel->listall('','','','','','','','active','',1,$student_id);
       
       $data['checklists'] = $this->projectmodel->getStudentChecklists($student_id);
  
      $data['page'] = 'dashboard';
      $this->load->vars($data);
      $this->load->view($this->container);
  }else{
    redirect("login");
  }
}

function cases($student_id){
  $added_date = $this->input->get("commenced_date")??null;
  $this->load->model("student/studentmodel");
  $this->load->model("order/ordermodel");
  $this->load->model("quote/quotemodel");
  $this->load->model("user/usermodel");
  if($this->session->userdata("clms_front_userid")){
      $data['result'] =  $this->studentmodel->getdata($student_id)->row();
      $data['student_id'] = $student_id;
      $data['enrolls'] 	= $this->projectmodel->listall($added_date,$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='',null,$student_id);
      $data['page'] = 'case_lists';
      $this->load->vars($data);
      $this->load->view($this->container);
  }else{
    redirect("login");
  }
}

function notes($student_id){
  if($this->session->userdata("clms_front_userid")){
    $userid = $this->session->userdata("clms_front_userid");
     
     $data['messages'] = $this->projectmodel->getChatMessages($userid,$student_id);
     $data['result'] =  $this->studentmodel->getdata($student_id)->row();
      
      $data['student_id'] = $student_id;
      $data['enrolls'] 	= $this->projectmodel->listall($added_date='',$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='',null,$student_id);
     // print_r($this->session->userdata);die();
      $data['page'] = 'student_note';
      $this->load->vars($data);
      $this->load->view($this->container);
    }else{
      redirect("login");
    }
}

function add_customerNote(){
  if($this->session->userdata("clms_front_userid")){
    $userid = $this->session->userdata("clms_front_userid");
    $student_id = $this->input->post("student_id");
    $note = $this->input->post("remark");
    $file_name = $this->input->post("file_name");
    $send_email = $this->input->post("send_email");

    $this->db->insert("pnp_company_student_note_new",[
      "to_id" => $student_id,
      "comment" => $note,
      "file_name" => $file_name,
      "added_at" => date("Y-m-d H:i:s"),
      "added_by" => $userid,
      "company_student_id" => $student_id
    ]);

    $this->load->model("quote/quotemodel");
    $customer = $this->quotemodel->getCustomer($student_id);
    $company = $this->quotemodel->getCompanyDetails($this->session->userdata("clms_front_companyid"));

    if($customer->student_id > 0){
      $notifications = array(
        "content" => $this->session->userdata("clms_front_username").' has added new note. ',
        "link" => 'project/notes/'.$student_id,
        "from_id" => $this->session->userdata("clms_front_userid"),
        "to_id" => $this->session->userdata("clms_front_user_group") != 14 ? $customer->student_id : $this->session->userdata("clms_front_companyid") ,
        "added_date" => date("Y-m-d")
        );
      $this->db->insert("student_notifications",$notifications);
      }

   

    if($send_email == 1){
        
      $from = $company->order_email;
      $fromname = $company->company_name;
      $fax      = $this->mylibrary->getSiteEmail(62);
      if($company->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$company->thumbnail)){
        $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
      }else{
        $logo = '';
      }
  
      $row = $this->mylibrary->getCompanyEmailTemplate(78,$company->company_id);
      
  
      $this->email->set_mailtype('html');
      $sendemail   = $this->mylibrary->getSiteEmail(19);
      $this->email->from($sendemail, $fromname);
      $this->email->reply_to($from, $fromname);
      if($this->session->userdata("clms_front_user_group") != 14)
        $this->email->to($customer->email);
      else
        $this->email->to($company->email);
      $subject = str_replace('[COMPANY_NAME]', $company->company_name, $row->email_subject);
      $subject = str_replace('[FROM_NAME]', $company->company_name, $subject);
      $subject = str_replace('[SITE_NAME]', $fromname, $subject);
      $subject = str_replace('[FULL_NAME]', $customer->first_name.' '.$customer->last_name, $subject);
      $subject = str_replace('[YEAR]', date('Y'), $subject);
      $subject = str_replace('[LOGO]', $logo, $subject);
      $subject = str_replace('[SITE_URL]', SITE_URL, $subject);
      $subject = str_replace('[SITE_ADDRESS]', $company->mail_to_address, $subject);
      $subject = str_replace('[SITE_EMAIL]', $company->email , $subject);
      $subject = str_replace('[SITE_PHONE]', $company->phone, $subject);
      $subject = str_replace('[SITE_FAX]', $fax, $subject);
      $subject = str_replace('[EMAIL]', $company->email, $subject);
      $subject = str_replace('[YEAR]', date('Y'), $subject);
      $this->email->subject($subject);
  
      $message = str_replace('[COMPANY_NAME]', $company->company_name, html_entity_decode($row->email_message, ENT_COMPAT));
      $message = str_replace('[FROM_NAME]', $company->company_name, $message);
      $message = str_replace('[SITE_NAME]', $fromname, $message);
      $message = str_replace('[CONTENT]', $note, $message);
      $message = str_replace('[FULL_NAME]', $customer->first_name.' '.$customer->last_name, $message);
      $message = str_replace('[YEAR]', date('Y'), $message);
      $message = str_replace('[LOGO]', $logo, $message);
      $message = str_replace('[SITE_URL]', SITE_URL, $message);
      $message = str_replace('[SITE_ADDRESS]', $company->mail_to_address, $message);
      $message = str_replace('[SITE_EMAIL]', $company->email , $message);
      $message = str_replace('[SITE_PHONE]', $company->phone, $message);
      $message = str_replace('[COMPANY_ADDRESS]', $company->mail_to_address, $message);
      if($fax == "")
        $message = str_replace('- Fax -', "", $message);
      $message = str_replace('[SITE_FAX]', $fax, $message);
      $message = str_replace('[EMAIL]', $company->email, $message);
      $message = str_replace('[YEAR]', date('Y'), $message);
      $this->email->message($message);
      if($file_name && file_exists("./uploads/document/".$file_name))
        $this->email->attach("./uploads/document/".$file_name);
      $this->email->send();
      $this->email->clear();

      $this->load->model("sms/smsmodel");

      $query = $this->smsmodel->getdata($this->session->userdata("clms_front_userid"));
      $sms_setting  = $query->row();
      
    

      if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1 && $sms_setting->balance_sms??0 > 0){
          $sms = $row->sms_text;
          $sms = str_replace('[COMPANY_NAME]', $company->company_name, html_entity_decode($sms, ENT_COMPAT));
          $sms = str_replace('[FROM_NAME]', $company->company_name, $sms);
          $sms = str_replace('[SITE_NAME]', $fromname, $sms);
          $sms = str_replace('[CONTENT]', $note, $sms);
          $sms = str_replace('[FULL_NAME]', $customer->first_name.' '.$customer->last_name, $sms);
          $sms = str_replace('[YEAR]', date('Y'), $sms);
          $sms = str_replace('[LOGO]', $logo, $sms);
          $sms = str_replace('[SITE_URL]', SITE_URL, $sms);
          $sms = str_replace('[SITE_ADDRESS]', $company->mail_to_address, $sms);
          $sms = str_replace('[SITE_EMAIL]', $company->email , $sms);
          $sms = str_replace('[SITE_PHONE]', $company->phone, $sms);
          $sms = str_replace('[COMPANY_ADDRESS]', $company->mail_to_address, $sms);
          if($fax == "")
            $sms = str_replace('- Fax -', "", $sms);
          $sms = str_replace('[SITE_FAX]', $fax, $sms);
          $sms = str_replace('[EMAIL]', $company->email, $sms);
          $sms = str_replace('[YEAR]', date('Y'), $sms);

          $mobile = $customer->mobile;
          if($mobile != ""){
              $this->commonmodel->printsms($sms,$mobile,$sms_setting->sms_from);
              $this->commonmodel->calculate_smsBalance($this->session->userdata("clms_front_userid"));
          }

         
      }
      /***** Sms code ******/
    }

    $this->session->set_flashdata('success_message', 'Note added successfully');
  }
}

function emails($student_id){
  $this->load->model("student/studentmodel");
  $this->load->model("custom_email_template/custom_emailmodel");
  $this->load->model("quote/quotemodel");
  if($this->session->userdata("clms_front_userid")){
      $data['result'] =  $this->studentmodel->getdata($student_id)->row();
      $data['student_id'] = $student_id;
      $data['emails'] = $this->custom_emailmodel->listall()->result();
      $data['page'] = 'emails';
      $this->load->vars($data);
      $this->load->view($this->container);
  }else{
    redirect("login");
  }
}

function mail_preview($emailid,$student_id){
  $this->load->model("quote/quotemodel");
  if($this->input->post("submit")){

    $subject = $this->input->post("subject");
    $message = $this->input->post("details123");


    $company = $this->quotemodel->getCompanyDetails($this->session->userdata('clms_company'));
    if($this->input->post('useremails'))
      $useremails = $this->input->post('useremails');
    else
      $useremails = array();
    $other_email = $this->input->post('other_email');

    $other_emails = explode(',',$other_email);
    foreach ($other_emails as $key => $value) {
     array_push($useremails,$value);
   }

   if($this->input->post("copy_me"))
    array_push($useremails,$company->email);
    $useremails = array_filter($useremails, 'strlen');
  $this->sendmailwithcontent($subject,$message,$useremails,$company,$emailid,$student_id);
  $this->session->set_flashdata('success_message', 'Email Sent successfully');
  redirect('project/emails/'.$student_id);

}else{
 
  $student =  $this->studentmodel->getdata($student_id)->row();
  list($subject,$message,$customer_arr,$customer_contacts) = $this->projectmodel->getmailconent($emailid,$student);
  $data['emailid'] = $emailid;
  $data['subject'] = $subject;
  $data['message'] = $message;
 // $data['email_slug'] = $slug;
  $data['customer_arr'] = $customer_arr;
  $data['customer_contacts'] = $customer_contacts;
  $this->load->view('mail_preview', $data);

}

}

function sendmailwithcontent($subject,$message,$useremails,$company,$emailid,$student_id){
  $from = $company->order_email;
  $fromname = $company->company_name;
      $i = 1;
      $sendemail   = $this->mylibrary->getSiteEmail(19); 
      foreach ($useremails as $key => $customer_email) {
        if($customer_email != ''){
          $this->email->set_mailtype('html');
          $this->email->from($sendemail, $fromname);
          $this->email->reply_to($from, $fromname);
          $this->email->to($customer_email);
          $this->email->subject($subject);
          $this->email->message($message);
          $this->email->send();
          $this->email->clear();
          }
     }

  $this->db->set("custom_email_id",$emailid);
  $this->db->set("student_id",$student_id);
  $this->db->set("subject",$subject);
  $this->db->set("content",$message);
  $this->db->set("sent_at",date("Y-m-d H:i:s"));
  $this->db->insert("custom_email_sent");

}

function points($student_id){
  if($this->session->userdata("clms_front_companyid")){
    $data['result'] =  $this->studentmodel->getdata($student_id)->row();
    $data['student_id'] = $student_id;
    $data['enrolls'] 	= $this->projectmodel->listall($added_date='',$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='',null,$student_id,"completed");
    $data['enroll_projects'] 	= $this->projectmodel->listall($added_date='',$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='',null,$student_id);
    $data['page'] = 'points';
    $this->load->vars($data);
    $this->load->view($this->container);
  }else{
    redirect("login");
  }
}

function getEnroll(){
  $enroll_id = $this->input->post("enrollment");
  $enroll = $this->enrollmodel->getdataByEnrollId($enroll_id);
  echo $enroll->collected_points;
}

function add_collectedPoints(){
  if($this->session->userdata("clms_front_companyid")){
      $enrollment = $this->input->post("enrollment");
      $collected_points = $this->input->post("collected_points");

      $this->db->set("collected_points",$collected_points);
      $this->db->where("enroll_id",$enrollment);
      $this->db->update("enroll");

  }
}

function documents($student_id){
  $this->load->model("student/studentmodel");
  $this->load->model("order/ordermodel");
  $this->load->model("quote/quotemodel");
  if($this->session->userdata("clms_front_userid")){
    if($this->input->post("save")){
      $type = $this->input->post("doc_type");
      $desc = $this->input->post("description");
      $config['upload_path'] = './uploads/student_documents';
      $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|xml|docx|GIF|JPG|PNG|JPEG|PDF|DOC|XML|DOCX|xls|xlsx|rar|zip';
      $config['max_width'] = 0;
      $config['max_height'] = 0;
      $config['max_size'] = 0;
      $config['encrypt_name'] = TRUE;
      $this->upload->initialize($config);
      $this->load->library('upload', $config);
      $i = 0;
      foreach($_FILES as $key => $value) {
       if(!empty($_FILES[$key]['name']) && $key != "product_image"){ 
 
         $type1 = $type[$i];
         $desc1 = $desc[$i];
         $this->upload->initialize($config);
         if (!$this->upload->do_upload($key)) { 
           $errors[] = $this->upload->display_errors();
       //print_r($errors);
                  // print_r($this->upload->data());
         }else{ 
           $uploads = array($this->upload->data()); 
                         //print_r($uploads);
           foreach($uploads as $key => $value){ 
             $image = $value['file_name'];
             $student_documents = array("company_student_id"=>$student_id,"doc_type"=>$type1,"doc_name"=>$image,'doc_desc'=>$desc1);
                        // print_r($student_documents);
             $this->db->insert("company_student_documents",$student_documents);
           }
         }
       }
       $i++;
     }

     $this->load->model("quote/quotemodel");
     $customer = $this->quotemodel->getCustomer($student_id);
     $company = $this->quotemodel->getCompanyDetails($this->session->userdata("clms_front_companyid"));
 
     if($customer->student_id > 0){
       $notifications = array(
         "content" => $this->session->userdata("clms_front_username").' has uploaded new documents. ',
         "link" => 'project/documents/'.$student_id,
         "from_id" => $this->session->userdata("clms_front_userid"),
         "to_id" => $this->session->userdata("clms_front_user_group") != 14 ? $customer->student_id : $this->session->userdata("clms_front_companyid") ,
         "added_date" => date("Y-m-d")
         );
       $this->db->insert("student_notifications",$notifications);
       }

     $this->session->set_flashdata("success_message","Documents uploaded successfully.");
     redirect("project/documents/$student_id");

    }else{
      $data['result'] =  $this->studentmodel->getdata($student_id)->row();
      $data['student_id'] = $student_id;
      $data['doc_type'] = $this->studentmodel->get_docType();
      $data['page'] = 'documents';
      $this->load->vars($data);
      $this->load->view($this->container);
    }
  }else{
    redirect("login");
  }
}

function appointments($student_id){
  $this->load->model("student/studentmodel");
  $appointment_date = $this->input->get("appointment_date"); 
 
  if($this->session->userdata("clms_front_userid")){
      $data['appointments'] = $this->appointmentmodel->listall('','','','','','','',$appointment_date,'',1,$student_id);
    //  echo $this->db->last_query();die();
      $data['result'] =  $this->studentmodel->getdata($student_id)->row();
      $data['student_id'] = $student_id;

      $data['page'] = 'appointments';
      $this->load->vars($data);
      $this->load->view($this->container);
  }else{
    redirect("login");
  }
}

function upload_file_project() {

  $config['upload_path'] = './uploads/student_documents/';
  $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
  $config['max_width'] = 0;
  $config['max_height'] = 0;
  $config['max_size'] = 0;
  $config['encrypt_name'] = TRUE;
  $this->upload->initialize($config);
  $this->load->library('upload', $config);

  $this->load->library('upload', $config);
if (!$this->upload->do_upload('file')) {
     $this->upload->display_errors();
} else {
    $arr_image = $this->upload->data();
   echo $image_name = $arr_image["file_name"];
}

}

function case($student_id,$enroll_id,$phase_no=1){
  if($this->session->userdata("clms_front_userid")){
    $this->load->model("doc_type/doc_typemodel");
    $phase1 = $this->projectmodel->checkphase($enroll_id,1);
    $phase2 = $this->projectmodel->checkphase($enroll_id,2);
    $phase5 = $this->projectmodel->checkphase($enroll_id,5);
    $latest_phase = $this->projectmodel->lastestphase($enroll_id);
    if($latest_phase+1 < $phase_no){
      redirect("project/case/$student_id/$enroll_id");
    }
    $data['logs'] = $this->projectmodel->checkphase($enroll_id,null,1);
    $data['phase1'] = $phase1;
    $data['phase2'] = $phase2;
    $data['phase5'] = $phase5;
    $data['enroll'] = $this->enrollmodel->getdataByEnrollId($enroll_id);
    $data['result'] = $this->studentmodel->getdata($student_id)->row();
    $data['project'] = $this->projectmodel->project_listdetail($data['enroll']->order_id);

    $data['docs'] = $this->doc_typemodel->listall(28)->result();

    
    $data['student_id'] = $student_id;
    $data['enroll_id'] = $enroll_id;
   
    $data['phase'] = $phase_no;
    $data['latest_phase'] = $latest_phase;
    switch ($phase_no) {
      case 1:
          $case = "case1";
        break;
      case 2:
          $case = "case2";
        break;
      case 3:
       
          $case = $data['enroll']->visa == 14 ? "enroll_case3":"case3";
        
        break;
      case 4:
        $case = $data['enroll']->visa == 14 ? "enroll_case4":"case4";
        break;
      case 5:
        $case = $data['enroll']->visa == 14 ? "enroll_case5":"case5";
        $title = "Application Prepared";
      break;
      case 6:
          $case = $data['enroll']->visa == 14 ? "enroll_case6":"case5";
          $title = "Supervisor Checked";
          break;
      case 7:
        $case = $data['enroll']->visa == 14 ? "enroll_case7":"case5";
        $title = "Application Lodged";
        break;
        case 8:
          if($data['enroll']->visa == 14){
            $this->session->set_flashdata("success_message","Case updated successfully.");
            redirect("project/cases/$student_id");
          }
          $case = "case5";
          $title = "Application Acknowledged";
        break;
        case 9:
          $case = "case5";
          $title = "Document Lodged";
        break;
        case 10:
          $case = "case5";
          $title = "Processing Commenced";
        break;
        case 11:
          $this->session->set_flashdata("success_message","Case updated successfully.");
          redirect("project/cases/$student_id");
        break;
      default:
      $case = "case1";
    }
  
    $company_id = $this->session->userdata("clms_front_companyid");
    $this->load->model("visa/visamodel");
    $data['point'] = $this->visamodel->visaPoints(28,$company_id)->row();
    $data['page'] 			= 'cases';
    $data['case'] = $case;
    $data['title'] = $title??'';
    $this->load->vars($data);
    $this->load->view($this->container);
  }else{
    redirect("login");
  }
}

function add_phase(){
  $enroll_id = $this->input->post("enroll_id");
  $remark = $this->input->post("remark");
  $admin_note = $this->input->post("admin_note");
  $phase = $this->input->post("phase");
  $checked_chklists = $this->input->post("checked_chklist");
  $is_skipped = $this->input->post("is_skipped");
  $file_name =  $this->input->post("file_name");
  $send_email = $this->input->post("send_email")??0;
  $visa_status = $this->input->post("visa_status")??'';
  $collected_points = $this->input->post("collected_points")??0;

  $enroll = $this->enrollmodel->getdataByEnrollId($enroll_id);

  $this->db->where("enroll_id",$enroll_id);
  $this->db->set("visa_status",$visa_status);
  $this->db->set("collected_points",$collected_points);
  $this->db->update("pnp_enroll");
  
  $this->db->where("enroll_id",$enroll_id);
  $this->db->where("case_phase",$phase);
  $result = $this->db->get("pnp_enroll_caseflow");
  $status = get_enroll_phase($phase);
  $data = [
    "enroll_id" => $enroll_id,
    "case_phase" => $phase,
    "added_at" => date("Y-m-d H:i:s"),
    "added_by" => $this->session->userdata("clms_front_userid"),
    "is_skipped" => $is_skipped
  ];
  if($result->num_rows() > 0){
    $row = $result->row();
    $id = $row->id;
    $this->db->where("id",$id);
    $this->db->update("pnp_enroll_caseflow",$data);
  }else{
    $this->db->insert("pnp_enroll_caseflow",$data);
    $id = $this->db->insert_id();
  }

  $data = [
    "enroll_case_flow_id" => $id,
    "customer_note" => $remark,
    "admin_note" => $admin_note??'',
    "file_name" => $file_name,
    "added_at" => date("Y-m-d H:i:s"),
    "added_by" => $this->session->userdata("clms_front_userid")
  ];
  $this->db->insert("pnp_enroll_caseflow_notes",$data);

  if($phase == 4){
    $this->db->where("enroll_id",$enroll->order_id);
    $this->db->set("is_approved",NULL);
    $this->db->update("enroll_checklist");
    foreach($checked_chklists as $chk){
        $this->db->where("checklist_id",$chk);
        $this->db->where("enroll_id",$enroll->order_id);
        $enroll_checklist = $this->db->get("enroll_checklist");
        if($enroll_checklist->num_rows() > 0){
          $row = $enroll_checklist->row();
          $this->db->where("id",$row->id);
          $this->db->set("is_approved",1);
          $this->db->update("enroll_checklist");
        }else{
          $insert_data = [
            "checklist_id" => $chk,
            "enroll_id" => $enroll->order_id,
            "is_approved" => 1,
            "added_date" => date("Y-m-d H:i:s"),
            "added_by" => $this->session->userdata("clms_front_userid")
          ];
          $this->db->insert("enroll_checklist",$insert_data);
        }
    }
  }

  if($send_email == 1){
    $this->load->model("quote/quotemodel");
    $customer = $this->quotemodel->getCustomer($enroll->student_id);
    $company = $this->quotemodel->getCompanyDetails($enroll->company_id);

    $project = $this->projectmodel->getdata($enroll->order_id)->row();
    
    $from = $company->order_email;
		$fromname = $company->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($company->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$company->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
		}else{
			$logo = '';
		}

		$row = $this->mylibrary->getCompanyEmailTemplate(77,$company->company_id);
		

		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($company->email);
    $this->email->cc($customer->email);
		
		$subject = str_replace('[COMPANY_NAME]', $company->company_name, $row->email_subject);
		$subject = str_replace('[ENROLLMENT_NO]', $project->order_no, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]', $customer->first_name.' '.$customer->last_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $company->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $company->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $company->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
    $subject = str_replace('[EMAIL]', $company->email, $subject);
    $subject = str_replace('[STATUS]', $status, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$this->email->subject($subject);

		$message = str_replace('[COMPANY_NAME]', $company->company_name, html_entity_decode($row->email_message, ENT_COMPAT));
    $message = str_replace('[ENROLLMENT_NO]', $project->order_no, $message);
    $message = str_replace('[STATUS]', $status, $message);
    $message = str_replace('[VISA_STATUS]', $visa_status != '' ? "Your visa has been $visa_status" : "", $message);
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[CONTENT]', $remark, $message);
		$message = str_replace('[FULL_NAME]', $customer->first_name.' '.$customer->last_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $company->mail_to_address, $message);
		$message = str_replace('[SITE_EMAIL]', $company->email , $message);
    $message = str_replace('[SITE_PHONE]', $company->phone, $message);
    $message = str_replace('[COMPANY_ADDRESS]', $company->mail_to_address, $message);
		if($fax == "")
			$message = str_replace('- Fax -', "", $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $company->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
    $this->email->message($message);
    if($file_name && file_exists("./uploads/document/".$file_name))
      $this->email->attach("./uploads/document/".$file_name);
		$this->email->send();
		$this->email->clear();
  }
}

function print_pdf($student_id){
  $tab = $this->input->get("tab");

  $this->load->model("student/studentmodel");
  $this->load->model("order/ordermodel");
  $this->load->model("quote/quotemodel");

  $this->load->helper('download');
  $this->html2pdf->folder('./uploads/pdf/');

  $this->html2pdf->paper('a4', 'potrait');

  switch ($tab) {
    case 'invoice':
      $this->html2pdf->paper('a4', 'landscape');
      $status = $this->input->get("status");
      $data['order'] 	= $this->ordermodel->listall(null,$status,null,null,null,null,null,null,null,null,$student_id);
      $content = $this->load->view('pdf_invoice', $data, true);
      $file = 'Invoice.pdf';
    break;
    case 'cases':
      $this->html2pdf->paper('a4', 'landscape');
      $added_date = $this->input->get("commenced_date");
      $data['enrolls'] 	= $this->projectmodel->listall($added_date,$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='',null,$student_id);
      $content = $this->load->view('pdf_cases', $data, true);
      $file = 'cases.pdf';
      break;
    case 'notes':
      $userid = $this->session->userdata("clms_front_userid");
      $data['notes'] = $this->projectmodel->getChatMessages($userid);
       $content = $this->load->view('pdf_notes', $data, true); 
       $file = 'notes.pdf';
     
      break;
  
    case 'appointments':
      $appointment_date = $this->input->get("appointment_date");
      $this->html2pdf->paper('a4', 'landscape');
      $data['appointments'] = $this->appointmentmodel->listall('','','','','','','',$appointment_date,'',1,$student_id);
      $content = $this->load->view('pdf_appointments', $data, true);
      $file = 'notes.pdf';
      break;
      case 'points':
        $data['enrolls'] 	= $this->projectmodel->listall($added_date='',$type='',$status='',$deadline='',$start_date='',$end_date='',$handle='',$filter='',$is_assigned='',null,$student_id,"completed");
        $content = $this->load->view('pdf_points', $data, true);
        $file = 'points.pdf';
      break;
    default:
  }
  $this->html2pdf->filename($file);
  $this->html2pdf->html($content);
  $this->html2pdf->create('save');
 
  $filename = "./uploads/pdf/".$file;

  header("Content-Length: " . filesize($filename));
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename='.$tab.'.pdf');

  readfile($filename);

}


}
