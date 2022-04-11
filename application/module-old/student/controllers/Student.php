<?php
class Student extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->container = 'main';
    $this->load->model('studentmodel');
    $this->load->model('users/usermodel');
    $this->load->model('lms/lmsmodel');
    $this->load->model('mailchimp/mailchimpmodel');
    $this->load->model('appointment/appointmentmodel');
    $this->module_code = 'student';
  }

  function index() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      redirect('dashboard/student', 'location');
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

    //----------------------------------------listall--------------------------------------------------	
  function listall() {
 
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      $data['student'] 	= $this->studentmodel->listall(null,null,1);
      $data['page'] 			= 'list';
      $this->load->vars($data);
      $this->load->view($this->container);
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

  function set_student(){
    $student = $this->input->post("student_id"); 
    $this->session->set_userdata("student",$student);
    redirect($_SERVER["HTTP_REFERER"],"locations");
  }
  function get_student(){
    $name = $this->uri->segment("3");
    $this->db->where("status",1);
    $this->db->where("user_group",7);
    $this->db->like('student_name', $name);
    $query = $this->db->get("users")->result();
    $users = array();
    $elms = array();
    foreach ($query as $row) {
     $user = new stdClass;
     $user->userid = $row->userid;
     $user->name = $row->student_name;
     $users[] = $user;

   }
   $item['item'] = $users;
   echo json_encode($item);
 }

 function mailchimp($id){
  $companyid = $this->session->userdata("clms_front_companyid");
  $query = $this->studentmodel->getdata($id)->row();
  $mailchimps = $this->mailchimpmodel->getdata($companyid);
  if($mailchimps->num_rows > 0){
    $mailchimp = $mailchimps->row();
    $arr  = array('apiKey'=>$mailchimp->api_key,'secure'=>false);
    $this->load->library('Mcapi',$arr);
    $list_id = $mailchimp->list_id;
    $email = $query->email;
    $name = $query->first_name.' '.$query->last_name;
    $getresult = $this->mcapi->listSubscribe($list_id, $email, $name);
    if($getresult === true){
      $this->db->where("student_id",$id);
      $this->db->set("mailchimp",1);
      $this->db->update("student_details");
      $this->session->set_flashdata('success_message', 'Subscribed to mailchimp successfully.');
    }else{
     $this->session->set_flashdata('success_message', 'Not Subscribed successfully.');
   }
 }else{
  $this->session->set_flashdata('success_message', 'Please Enter your Mail Chimp information first.');

}
redirect('dashboard/student');

}

function checkEmail() {
  $email = $this->input->post("email");
  $this->db->where("email",$email);
  if($this->db->get("users")->num_rows() > 0){
    echo 'This Email address is already in Exists';
  }
}

function checkUsername() {
  $username = $this->input->post("username");
  $this->db->where("user_name",$username);
  $user = $this->db->get("users");
  if($user->num_rows()){
   echo 'This Username is already in Exists';
 }
}

public function email_check($email)
{
  $companyid = $this->session->userdata("clms_front_companyid");
  $check_student = $this->studentmodel->checkStudent($companyid,$email);
  if ($check_student->num_rows() > 0)
  {
          $this->form_validation->set_message('email_check', 'The {field} is already in used.');
          return FALSE;
  }
  else
  {
          return TRUE;
  }
}


function add(){
   if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"ADD")){
   $this->load->library("uuid");
   $this->form_validation->set_rules('fname','First Name','required');
   $this->form_validation->set_rules('lname','Last Name','required');
   $this->form_validation->set_rules('mobile','Mobile','required');
   $this->form_validation->set_rules('email','Email','required|valid_email|callback_email_check');
   if($this->form_validation->run()!=FALSE){
    $value['details']['uuid']     = $this->uuid->v4();
    $value['details']['first_name']     = $this->input->post('fname');
    $value['details']['last_name']      = $this->input->post('lname');
    $value['details']['email']          = $this->input->post('email');
    $value['details']['phone']          = $this->input->post('phone');
    $value['details']['address']          = $this->input->post('address');
    $value['details']['picture']     = $this->input->post('txt_profile_pic');
    $value['details']['user_group']     = 14;
    $value['details']['user_name']      = $this->input->post('username');
    $value['details']['password']       = md5($this->input->post('password'));
    $value['details']['added_date']     = date('Y-m-d H:i:s');
    $value['details']['added_by']       = $this->session->userdata("clms_front_userid");
    $value['details']['status']         = 1;
    // $this->usermodel->insertuser($value['details']);
    $this->db->insert("company_students",$value['details']);
    $student = $this->db->insert_id();
    $this->db->where("id",$student);
    $this->db->set("company_id",$this->session->userdata("clms_front_companyid"));
    $this->db->update("company_students");

    if($this->input->post("lead_id") > 0){
      $lead_id = $this->input->post("lead_id");
      $this->db->where("lead_id",$lead_id);
      $this->db->set("student_id",$student);
      $this->db->update("leads");
    }

    $insert_array = array(
      "company_student_id" => $student,
      "dob" => $this->input->post("dob"),
      "passport_no" => $this->input->post("passport_no"),
      "mobile" => $this->input->post("mobile"),
      "referral" => $this->input->post("referral"),
      "sex" => $this->input->post("sex"),
      "is_married" => $this->input->post("is_married"),
      "about_us" => $this->input->post("about_us"),
      "ielts" => $this->input->post("have_ielts"),
      "listening" => $this->input->post("listening"),
      "writing" => $this->input->post("writing"),
      "reading" => $this->input->post("reading"),
      "speaking" => $this->input->post("speaking"),
      "toefl" => $this->input->post("have_toefl"),
      "toefl_score" => $this->input->post("txt_toefl"),
      "pte" => $this->input->post("have_pte"),
      "pte_score" => $this->input->post("txt_pte"),
      "sat" => $this->input->post("have_sat"),
      "sat_score" => $this->input->post("txt_sat"),
      "gre" => $this->input->post("have_gre"),
      "gre_score" => $this->input->post("txt_gre"),
      "gmat" => $this->input->post("have_gmat"),
      "gmat_score" => $this->input->post("txt_gmat"),
    );

    $this->db->insert("pnp_company_student_details",$insert_array);

    $type = $this->input->post("doc_type");
    $desc = $this->input->post("description");
    $config['upload_path'] = './uploads/student_documents';
    $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xml|rar|zip';
    $config['max_width'] = 0;
    $config['max_height'] = 0;
    $config['max_size'] = 0;
    $config['encrypt_name'] = TRUE;
    $this->upload->initialize($config);
    $this->load->library('upload', $config);
    $i = 0;
    // echo '<pre>';
    // print_r($type);
    // print_r($desc);
    // die();
    foreach($_FILES as $key => $value) {
      if(!empty($_FILES[$key]['name']) && !in_array($key, ["product_image","profile_pic"])){ 
        if(isset($type[$i])){
          $type1 = $type[$i];
          $desc1 = $desc[$i];
          $this->upload->initialize($config);
          if (!$this->upload->do_upload($key)) { 
            $errors[] = $this->upload->display_errors();
          }else{ 
            $uploads = array($this->upload->data()); 
                          //print_r($uploads);
            foreach($uploads as $key => $value){ 
              $image = $value['file_name'];
              $student_documents = array("company_student_id"=>$student,"doc_type"=>$type1,"doc_name"=>$image,'doc_desc'=>$desc1);
              $this->db->insert("company_student_documents",$student_documents);
            }
          }
          $i++;
      }
    }
     
    }

    $qualifaction = $this->input->post("qualifaction");
    $institution = $this->input->post("institution");
    $country = $this->input->post("country");
    $commence_date = $this->input->post("commence_date");
    $complete_date = $this->input->post("complete_date");
    $percentage = $this->input->post("percentage");
    $is_attached = $this->input->post("is_attached");

    $i = 1;
    foreach ($qualifaction as $key => $value) {
      if($value != ""){
        if($this->input->post("is_attached".$i)) $is_attached = 1; else $is_attached = 0;
        $qualification_array = array(
          "company_student_id" => $student,
          "qualification_name"=> $value,
          "institution_name" => $institution[$key],
          "country" => $country[$key],
          "commence_date" => $commence_date[$key],
          "complete_year" => $complete_date[$key],
          "percent" => $percentage[$key],
          "doc_attached" => $is_attached,
        );
        $this->db->insert("company_student_qualification",$qualification_array);

      }
      $i++;
    }

    $experience = $this->input->post("experience");
    $e_institution = $this->input->post("e_institution");
    $e_position = $this->input->post("e_position");
    $e_country = $this->input->post("e_country");
    $e_commence_date = $this->input->post("e_commence_date");
    $e_complete_date = $this->input->post("e_complete_date");
        //$e_is_attached = $this->input->post("e_is_attached");

    $i = 1;
    foreach ($experience as $key => $value) {
      if($value != ""){
        if($this->input->post("e_is_attached".$i)) $is_attached = 1; else $is_attached = 0;
        $experience_array = array(
          "company_student_id" => $student,
          "experience_name"=> $value,
          "institution_name" => $e_institution[$key],
          "position" => $e_position[$key],
          "country" => $e_country[$key],
          "commence_date" => $e_commence_date[$key],
          "complete_year" => $e_complete_date[$key],
          "doc_attached" => $is_attached,
        );
        $this->db->insert("company_student_experience",$experience_array);
      }
      $i++;
    }
    if($this->input->post("send_email")){
      $this->studentmodel->sendemail($student,$this->input->post('password'));
      $request = [
        "company_user_id" => $student,
        "type" => 'Student',
        "added_by" => $this->session->userdata("clms_front_userid"),
        "added_at" => date("Y-m-d H:i:s")
      ];
      $this->load->model("employee/employeemodel");
      $this->employeemodel->adduserRequest($request);
    }

    $this->session->set_flashdata('success_message', 'student added Successfully.');
    redirect('dashboard/student');
  }else{
    $data['doc_type'] = $this->studentmodel->get_docType();
    $data['about_us']      = $this->lmsmodel->about_us();
    $data['users']      = $this->lmsmodel->get_users();
    $data['countries']      = $this->appointmentmodel->get_country();
    if($this->uri->segment(3) && $this->uri->segment(3) > 0){
      $id = $this->uri->segment(3);
      $data['lead'] =  $this->lmsmodel->getdata($id)->row();
    }
    $data['page'] = 'add';
    $data['heading'] = 'Add ';
    $this->load->vars($data);
    $this->load->view($this->container);
  }
}else{
  $this->session->set_flashdata('error','Please login with your username and password');
  redirect('login','location');
}
}

function resend_email($student_id){
  $this->studentmodel->sendemail($student_id);
  $request = [
    "company_user_id" => $student_id,
    "type" => 'Student',
    "added_by" => $this->session->userdata("clms_front_userid"),
    "added_at" => date("Y-m-d H:i:s")
];
$this->load->model("employee/employeemodel");
$this->employeemodel->adduserRequest($request);
  $this->session->set_flashdata('success_message', 'student added Successfully.');
  redirect('dashboard/student');
}

function addstudent(){
  $this->load->library("uuid");
  $this->form_validation->set_rules('fname','First Name','required');
  $this->form_validation->set_rules('lname','Last Name','required');
  $this->form_validation->set_rules('mobile','Mobile','required');
  $this->form_validation->set_rules('email','Email','required|valid_email|callback_email_check');
  if($this->form_validation->run()!=FALSE){

   $value['details']['uuid']     = $this->uuid->v4();
   $value['details']['first_name']     = $this->input->post('fname');
   $value['details']['last_name']      = $this->input->post('lname');
   $value['details']['email']          = $this->input->post('email');
   $value['details']['phone']          = $this->input->post('phone');
   $value['details']['address']          = $this->input->post('address');
   $value['details']['user_group']     = 14;
   $value['details']['user_name']      = $this->input->post('username');
   $value['details']['password']       = md5($this->input->post('password'));
   $value['details']['added_date']     = date('Y-m-d H:i:s');
   $value['details']['added_by']       = $this->session->userdata("clms_front_userid");
   $value['details']['status']         = 1;
   $this->db->insert('company_students',$value['details']);
   $student = $this->db->insert_id();
   $this->db->where("id",$student);
   $this->db->set("company_id",$this->session->userdata("clms_front_companyid"));
   $this->db->update("company_students");



   $insert_array = array(
     "company_student_id" => $student,
     "dob" => $this->input->post("dob"),
     "passport_no" => $this->input->post("passport_no"),
     "mobile" => $this->input->post("mobile"),
     "referral" => $this->input->post("referral"),
     "sex" => $this->input->post("sex"),
     "is_married" => $this->input->post("is_married"),
     "about_us" => $this->input->post("about_us"),
     "ielts" => $this->input->post("have_ielts"),
     "listening" => $this->input->post("listening"),
     "writing" => $this->input->post("writing"),
     "reading" => $this->input->post("reading"),
     "speaking" => $this->input->post("speaking"),
     "toefl" => $this->input->post("have_toefl"),
     "toefl_score" => $this->input->post("txt_toefl"),
     "pte" => $this->input->post("have_pte"),
     "pte_score" => $this->input->post("txt_pte"),
     "sat" => $this->input->post("have_sat"),
     "sat_score" => $this->input->post("txt_sat"),
     "gre" => $this->input->post("have_gre"),
     "gre_score" => $this->input->post("txt_gre"),
     "gmat" => $this->input->post("have_gmat"),
     "gmat_score" => $this->input->post("txt_gmat"),
   );

   $this->db->insert("company_student_details",$insert_array);

   $types = $this->input->post("student_doc_types");
   $student_docs = $this->input->post("student_docs");
   $desc = $this->input->post("student_doc_desc");
   
   if(!empty($types)){
   foreach($types as $key => $value){ 
      $student_documents = array(
        "student_id"=>$student,
        "doc_type"=>$value,
        "doc_name"=>$student_docs[$key],
        'doc_desc'=>$desc[$key]
      );
      $this->db->insert("student_documents",$student_documents);
  }
}
 
  

   $qualifaction = $this->input->post("qualifaction");
   $institution = $this->input->post("institution");
   $country = $this->input->post("country");
   $commence_date = $this->input->post("commence_date");
   $complete_date = $this->input->post("complete_date");
   $percentage = $this->input->post("percentage");
   $is_attached = $this->input->post("is_attached");

   $i = 1;
   foreach ($qualifaction as $key => $value) {
     if($value != ""){
      
       $qualification_array = array(
         "student_id" => $student,
         "qualification_name"=> $value,
         "institution_name" => $institution[$key],
         "country" => $country[$key],
         "commence_date" => $commence_date[$key],
         "complete_year" => $complete_date[$key],
         "percent" => $percentage[$key],
         "doc_attached" => $is_attached,
       );
       $this->db->insert("student_qualification",$qualification_array);

     }
     $i++;
   }

   $experience = $this->input->post("experience");
   $e_institution = $this->input->post("e_institution");
   $e_position = $this->input->post("e_position");
   $e_country = $this->input->post("e_country");
   $e_commence_date = $this->input->post("e_commence_date");
   $e_complete_date = $this->input->post("e_complete_date");
  $e_is_attached = $this->input->post("e_is_attached");

   $i = 1;
   foreach ($experience as $key => $value) {
     if($value != ""){
      
       $experience_array = array(
         "student_id" => $student,
         "experience_name"=> $value,
         "institution_name" => $e_institution[$key],
         "position" => $e_position[$key],
         "country" => $e_country[$key],
         "commence_date" => $e_commence_date[$key],
         "complete_year" => $e_complete_date[$key],
         "doc_attached" => $e_is_attached,
       );
       $this->db->insert("student_experience",$experience_array);
     }
     $i++;
   }
   if($this->input->post("send_email"))
     $this->studentmodel->sendemail($student,$this->input->post('password'));

     echo json_encode(array("result"=>'success',"student_id"=>$student));
  }else{
    echo json_encode(array("result"=>"error","err"=>validation_errors()));
  }
  
}


function upload_file() {

  $config['upload_path'] = './uploads/student_documents/';
  $config['allowed_types'] = '*';
  $config['max_width'] = 0;
  $config['max_height'] = 0;
  $config['max_size'] = 0;
  $config['encrypt_name'] = TRUE;
  $this->upload->initialize($config);
  $this->load->library('upload', $config);

  $this->load->library('upload', $config);
  if (!$this->upload->do_upload('file')) {
      echo $this->upload->display_errors();
  } else {
      $arr_image = $this->upload->data();
      $arr = array("image_name"=>$arr_image["file_name"]);
      echo json_encode($arr);
  }
}


function edit() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
    if ($this->input->post('student_id')) {
      $student = $this->input->post("student_id");
      $value['details']['first_name']     = $this->input->post('fname');
      $value['details']['last_name']      = $this->input->post('lname');
      $value['details']['email']          = $this->input->post('email');
      $value['details']['phone']          = $this->input->post('phone');
      $value['details']['address']          = $this->input->post('address');
      $value['details']['picture']     = $this->input->post('txt_profile_pic');
      $value['details']['user_group']     = 14;
      $value['details']['user_name']      = $this->input->post('username');
      if($this->input->post('password') != "")
       $value['details']['password']       = md5($this->input->post('password'));
     $value['details']['added_date']     = date('Y-m-d H:i:s');
     $value['details']['added_by']       = $this->session->userdata("clms_front_userid");
     $value['details']['status']         = 1;
     $this->db->where("id",$student);
     $this->db->update("company_students",$value['details']);




     $insert_array = array(
      "company_student_id" => $student,
      "dob" => $this->input->post("dob"),
      "passport_no" => $this->input->post("passport_no"),
      "mobile" => $this->input->post("mobile"),
      "referral" => $this->input->post("referral"),
      "sex" => $this->input->post("sex"),
      "is_married" => $this->input->post("is_married"),
      "about_us" => $this->input->post("about_us"),
      "ielts" => $this->input->post("have_ielts"),
      "listening" => $this->input->post("listening"),
      "writing" => $this->input->post("writing"),
      "reading" => $this->input->post("reading"),
      "speaking" => $this->input->post("speaking"),
      "toefl" => $this->input->post("have_toefl"),
      "toefl_score" => $this->input->post("txt_toefl"),
      "pte" => $this->input->post("have_pte"),
      "pte_score" => $this->input->post("txt_pte"),
      "sat" => $this->input->post("have_sat"),
      "sat_score" => $this->input->post("txt_sat"),
      "gre" => $this->input->post("have_gre"),
      "gre_score" => $this->input->post("txt_gre"),
      "gmat" => $this->input->post("have_gmat"),
      "gmat_score" => $this->input->post("txt_gmat"),
    );
     $this->db->where("company_student_id",$student);
     $this->db->update("company_student_details",$insert_array);


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
     foreach($_FILES??[] as $key => $value) {
      if(!empty($_FILES[$key]['name']) && !in_array($key, ["product_image","profile_pic"])){ 

      if(isset($type[$i])){
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
            $student_documents = array("company_student_id"=>$student,"doc_type"=>$type1,"doc_name"=>$image,'doc_desc'=>$desc1);
                       // print_r($student_documents);
            $this->db->insert("company_student_documents",$student_documents);
          }
        }
      }
      }
      $i++;
    }
//die();
    $this->db->where("company_student_id",$student);
    $this->db->delete("company_student_qualification");

    $qualifaction = $this->input->post("qualifaction");
    $institution = $this->input->post("institution");
    $country = $this->input->post("country");
    $commence_date = $this->input->post("commence_date");
    $complete_date = $this->input->post("complete_date");
    $percentage = $this->input->post("percentage");
    $i = 1;
    foreach ($qualifaction as $key => $value) {
      if($value != ""){
        if($this->input->post("is_attached".$i)) $is_attached = 1; else $is_attached = 0;
        $qualification_array = array(
          "company_student_id" => $student,
          "qualification_name"=> $value,
          "institution_name" => $institution[$key],
          "country" => $country[$key],
          "commence_date" => $commence_date[$key],
          "complete_year" => $complete_date[$key],
          "percent" => $percentage[$key],
          "doc_attached" => $is_attached,
        );
        $this->db->insert("company_student_qualification",$qualification_array);

      }
      $i++;
    }

    $experience = $this->input->post("experience");
    $e_institution = $this->input->post("e_institution");
    $e_position = $this->input->post("e_position");
    $e_country = $this->input->post("e_country");
    $e_commence_date = $this->input->post("e_commence_date");
    $e_complete_date = $this->input->post("e_complete_date");
    $e_is_attached = $this->input->post("e_is_attached");


    $this->db->where("company_student_id",$student);
    $this->db->delete("company_student_experience");
    $i = 1;
    foreach ($experience as $key => $value) {
      if($value != ""){
        if($this->input->post("e_is_attached".$i)) $is_attached = 1; else $is_attached = 0;
        $experience_array = array(
          "company_student_id" => $student,
          "experience_name"=> $value,
          "institution_name" => $e_institution[$key],
          "position" => $e_position[$key],
          "country" => $e_country[$key],
          "commence_date" => $e_commence_date[$key],
          "complete_year" => $e_complete_date[$key],
          "doc_attached" => $is_attached,
        );
        $this->db->insert("company_student_experience",$experience_array);
      }
      $i++;
    }

 
    $notifications = array(
      "content" => $this->session->userdata("clms_front_username").' has  updated the profile informations',
      "link" => 'project/profile/'.$student,
      "from_id" => $this->session->userdata("clms_front_userid"),
      "to_id" => $this->session->userdata("clms_front_companyid") ,
      "added_date" => date("Y-m-d")
      );
    $this->db->insert("student_notifications",$notifications);


    if($this->input->post("is_case")){
      $this->session->set_flashdata('success_message', 'Profile updated successfully.');
      redirect($_SERVER["HTTP_REFERER"]);
    }else{
      $this->session->set_flashdata('success_message', 'Student edited Successfully.');
      redirect('dashboard/student');
    }
  } else {
    $id = $this->uri->segment(3);
    $data['doc_type'] = $this->studentmodel->get_docType();
    $data['about_us']      = $this->lmsmodel->about_us();
    $data['users']      = $this->lmsmodel->get_users();
    $data['countries']      = $this->appointmentmodel->get_country();
    $query = $this->studentmodel->getdata($id);
    if ($query->num_rows() > 0) {
      $data['result']   = $query->row();
      $data['page']     = 'edit';
      $data['heading']  = 'Edit Chat';
      $this->load->view('main', $data);
    } else {
      redirect('dashboard/student');
    }
  }
}
}
function get_docRow(){
  $data['num'] = $this->input->post("num");
  $data['doc_type'] = $this->studentmodel->get_docType();
  echo $this->load->view("row_document",$data,true);
}

function get_packageDetails(){
  $packageid = $this->input->post("packageid");
  $this->db->select("*")->from("pnp_student_package");
  $this->db->where("package_id",$packageid);
  $query = $this->db->get("")->result();
  echo json_encode($query);
}


function get_state(){
  $country = $this->input->post('country');
  $states = $this->studentmodel->getstates($country);
  foreach ($states as $row) {
   ?>
   <option value="<?php echo $row->state_id;?>"><?php echo $row->state_name;?></option>
   <?php
 }
}

function _createThumbnail($fileName, $thumb, $width=100, $height=100) {
  $config = array();
  $config['image_library'] = 'gd2';
  $config['source_image'] = $fileName;
  $config['new_image'] = FCPATH . $thumb;
  $config['create_thumb'] = TRUE;
  $config['maintain_ratio'] = TRUE;
  $config['width'] =  $width;
  $config['height'] = $height;

  $this->load->library('image_lib');
  $this->image_lib->initialize($config);
  if (!$this->image_lib->resize()) {
    echo $this->image_lib->display_errors();
    return false;
  }
  return $this->image_lib->data();
}

function notes($student_id){
  if($this->input->post("submit")){
    $array = array(
      "student_note" => $this->input->post("note"),
      "admin_note" => $this->input->post("admin_note"),
      "company_student_id" => $student_id,
      "added_date" => date("Y-m-d")
    );
    $this->db->insert("company_student_note",$array);
    $this->session->set_flashdata('success_message', 'Note added Successfully');
    redirect($_SERVER["HTTP_REFERER"],'');
  }else{
    $query = $this->studentmodel->getdata($student_id);
    if ($query->num_rows() > 0) {
      $data['result']     = $query->row();
      $data['page']       = 'note';
      $data['heading']    = 'Edit Chat';
      $this->load->view('main', $data);
    } else {
      redirect('dashboard/student');
    }
  }
}

function experiences($student_id){
  if($this->input->post("submit")){
   $experience = $this->input->post("experience");
   $institution = $this->input->post("e_institution");
   $country = $this->input->post("e_country");
   $commence_date = $this->input->post("e_commence_date");
   $complete_date = $this->input->post("e_complete_date");
   $is_attached = $this->input->post("e_is_attached");

   $qualification_array = array(
    "company_student_id" => $student_id,
    "experience_name"=> $experience,
    "institution_name" => $institution,
    "position"=> $this->input->post("e_position"),
    "country" => $country,
    "commence_date" => $commence_date,
    "complete_year" => $complete_date,
    "doc_attached" => $is_attached??0,
  );
   $this->db->insert("company_student_experience",$qualification_array);

   $this->session->set_flashdata('success_message', 'experience added Successfully');
   redirect($_SERVER["HTTP_REFERER"],'');
 }else{
  $query = $this->studentmodel->getdata($student_id);
  if ($query->num_rows() > 0) {
    $data['result']     = $query->row();
    $data['page']       = 'experience';
    $data['heading']    = 'Edit Chat';
    $this->load->view('main', $data);
  } else {
    redirect('dashboard/student');
  }
}
}

function qualifications($student_id){
  if($this->input->post("submit")){
   $qualifaction = $this->input->post("qualifaction");
   $institution = $this->input->post("institution");
   $country = $this->input->post("country");
   $commence_date = $this->input->post("commence_date");
   $complete_date = $this->input->post("complete_date");
   $percent = $this->input->post("percent");
   $is_attached = $this->input->post("is_attached");

   $qualification_array = array(
    "company_student_id" => $student_id,
    "qualification_name"=> $qualifaction,
    "institution_name" => $institution,
    "country" => $country,
    "commence_date" => $commence_date,
    "complete_year" => $complete_date,
    "percent" => $percent,
    "doc_attached" => $is_attached,
  );
   $this->db->insert("company_student_qualification",$qualification_array);

   $this->session->set_flashdata('success_message', 'Qualifaction added Successfully');
   redirect($_SERVER["HTTP_REFERER"],'');
 }else{
  $query = $this->studentmodel->getdata($student_id);
  if ($query->num_rows() > 0) {
    $data['result']     = $query->row();
    $data['page']       = 'qualifaction';
    $data['heading']    = 'Edit Chat';
    $this->load->view('main', $data);
  } else {
    redirect('dashboard/student');
  }
}
}

function ielts($student_id){
  if($this->input->post("submit")){
    $insert_array = array(
      "ielts" => $this->input->post("have_ielts"),
      "listening" => $this->input->post("listening"),
      "writing" => $this->input->post("writing"),
      "reading" => $this->input->post("reading"),
      "speaking" => $this->input->post("speaking"),
      "toefl" => $this->input->post("have_toefl"),
      "toefl_score" => $this->input->post("txt_toefl"),
      "pte" => $this->input->post("have_pte"),
      "pte_score" => $this->input->post("txt_pte"),
      "sat" => $this->input->post("have_sat"),
      "sat_score" => $this->input->post("txt_sat"),
      "gre" => $this->input->post("have_gre"),
      "gre_score" => $this->input->post("txt_gre"),
      "gmat" => $this->input->post("have_gmat"),
      "gmat_score" => $this->input->post("txt_gmat")
    );
    $this->db->where("company_student_id",$student_id);
    $this->db->update("company_student_details",$insert_array);
    $this->session->set_flashdata('success_message', 'Ielts info added Successfully');
    redirect($_SERVER["HTTP_REFERER"],'');
  }else{
    $query = $this->studentmodel->getdata($student_id);
    if ($query->num_rows() > 0) {
      $data['result']     = $query->row();
      $data['page']       = 'ielts';
      $data['heading']    = 'Edit Chat';
      $this->load->view('main', $data);
    } else {
      redirect('dashboard/student');
    }
  }
}


function documents($student_id){
 if($this->input->post("submit")){
   $type = $this->input->post("doc_type");
   $desc = $this->input->post("description");
   $config['upload_path'] = './uploads/student_documents';
   $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xml|rar|zip';
   $config['max_width'] = 0;
   $config['max_height'] = 0;
   $config['max_size'] = 0;
   $config['encrypt_name'] = TRUE;
   $this->upload->initialize($config);
   $this->load->library('upload', $config);
   if ( ! $this->upload->do_upload('document'))
   {
    $error = array('error' => $this->upload->display_errors());
                   //print_r($error); die();
  }
  else
  {
    $arr_image = $this->upload->data();
    $image = $arr_image['file_name']; 
    $student_documents = array("company_student_id"=>$student_id,"doc_type"=>$type,"doc_name"=>$image,'doc_desc'=>$desc);
    $this->db->insert("company_student_documents",$student_documents);
  }
  $this->session->set_flashdata('success_message', 'Document added Successfully');
  redirect($_SERVER["HTTP_REFERER"],'');
}else{
  $query = $this->studentmodel->getdata($student_id);
  if ($query->num_rows() > 0) {
    $data['result']     = $query->row();
    $data['doc_type'] = $this->studentmodel->get_docType();
    $data['page']       = 'documents';
    $data['heading']    = 'Edit Chat';
    $this->load->view('main', $data);
  } else {
    redirect('dashboard/student');
  }
}
}

function edit_experience($qid,$student_id){
  if($this->input->post("submit")){
    $experience = $this->input->post("experience");
    $institution = $this->input->post("e_institution");
    $country = $this->input->post("e_country");
    $commence_date = $this->input->post("e_commence_date");
    $complete_date = $this->input->post("e_complete_date");
    $is_attached = $this->input->post("e_is_attached");

    $qualification_array = array(
      "company_student_id" => $student_id,
      "experience_name"=> $experience,
      "institution_name" => $institution,
      "position"=> $this->input->post("e_position"),
      "country" => $country,
      "commence_date" => $commence_date,
      "complete_year" => $complete_date,
      "doc_attached" => $is_attached,
    );

    $this->db->where("id",$qid);
    $this->db->update("company_student_experience",$qualification_array);

    $this->session->set_flashdata('success_message', 'Experience updated Successfully');
    redirect("student/experiences/".$student_id);
  }else{
    $query = $this->studentmodel->getdata($student_id);
    if ($query->num_rows() > 0) {
      $data['result']     = $query->row();
      $data['edetail'] = $this->studentmodel->getExperienceDetail($qid);
      $data['page']       = 'edit_experience';
      $data['heading']    = 'Edit Chat';
      $this->load->view('main', $data);
    } else {
      redirect('dashboard/student');
    }
  }
}

function edit_qualification($qid,$student_id){
  if($this->input->post("submit")){
    $qualifaction = $this->input->post("qualifaction");
    $institution = $this->input->post("institution");
    $country = $this->input->post("country");
    $commence_date = $this->input->post("commence_date");
    $complete_date = $this->input->post("complete_date");
    $percent = $this->input->post("percent");
    $is_attached = $this->input->post("is_attached");

    $qualification_array = array(
      "company_student_id" => $student_id,
      "qualification_name"=> $qualifaction,
      "institution_name" => $institution,
      "country" => $country,
      "commence_date" => $commence_date,
      "complete_year" => $complete_date,
      "percent" => $percent,
      "doc_attached" => $is_attached,
    );
    $this->db->where("id",$qid);
    $this->db->update("company_student_qualification",$qualification_array);

    $this->session->set_flashdata('success_message', 'Qualifaction updated Successfully');
    redirect("student/qualifications/".$student_id);
  }else{
    $query = $this->studentmodel->getdata($student_id);
    if ($query->num_rows() > 0) {
      $data['result']     = $query->row();
      $data['qdetail'] = $this->studentmodel->getQualificationDetail($qid);
      $data['page']       = 'edit_qualification';
      $data['heading']    = 'Edit Chat';
      $this->load->view('main', $data);
    } else {
      redirect('dashboard/student');
    }
  }
}


function edit_documents($docid,$student_id){
  if($this->input->post("submit")){
   $type = $this->input->post("doc_type");
   $desc = $this->input->post("description");
   $student_documents = array("doc_type"=>$type,'doc_desc'=>$desc);
   $config['upload_path'] = './uploads/student_documents';
   $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xml|rar|zip';
   $config['max_width'] = 0;
   $config['max_height'] = 0;
   $config['max_size'] = 0;
   $config['encrypt_name'] = TRUE;
   $this->upload->initialize($config);
   $this->load->library('upload', $config);
   if ( ! $this->upload->do_upload('document'))
   {
    $error = array('error' => $this->upload->display_errors());
                  // print_r($error);
  }
  else
  {
    $arr_image = $this->upload->data();
    $image = $arr_image['file_name']; 
    $student_documents["doc_name"] = $image;

  }
  $this->db->where("id",$docid);
  $this->db->update("company_student_documents",$student_documents);
  $this->session->set_flashdata('success_message', 'Document updated Successfully');
  redirect("student/documents/".$student_id);
}else{
  $query = $this->studentmodel->getdata($student_id);
  if ($query->num_rows() > 0) {
    $data['result']     = $query->row();
    $data['doc_type'] = $this->studentmodel->get_docType();
    $data['docs_detail'] = $this->studentmodel->get_docDetail($docid);
    $data['page']       = 'edit_documents';
    $data['heading']    = 'Edit Chat';
    $this->load->view('main', $data);
  } else {
    redirect('dashboard/student');
  }
}
}

function delete_experiences(){
  $id = $this->uri->segment(3);
  $userid = $this->uri->segment(4);
  $this->db->where("id",$id);
  $this->db->delete("company_student_experience");
  $this->session->set_flashdata('success_message', 'Experience deleted Successfully');
  redirect($_SERVER["HTTP_REFERER"],'');
}

function delete_Qualification(){
  $id = $this->uri->segment(3);
  $userid = $this->uri->segment(4);
  $this->db->where("id",$id);
  $this->db->delete("company_student_qualification");
  $this->session->set_flashdata('success_message', 'qualification deleted Successfully');
  redirect($_SERVER["HTTP_REFERER"],'');
}

function delete_documents(){
  $id = $this->uri->segment(3);
  $userid = $this->uri->segment(4);
  $this->db->where("id",$id);
  $this->db->delete("company_student_documents");
  $this->session->set_flashdata('success_message', 'Document deleted Successfully');
  redirect($_SERVER["HTTP_REFERER"],'');
}

function delete_notes(){
  $id = $this->uri->segment(3);
  $userid = $this->uri->segment(4);
  $this->db->where("id",$id);
  $this->db->delete("company_student_note");
  $this->session->set_flashdata('success_message', 'Note deleted Successfully');
  redirect($_SERVER["HTTP_REFERER"],'');
}

    //---------------------------------edit--------------------------------------



function delete_docRow(){
  $docid = $this->input->post("docid");
  $this->db->where("id",$docid);
  $this->db->delete("student_documents");
}

    //------------------------delete---------------------------------------------------------	
function delete() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
    $delid = $this->uri->segment('3');
    $this->studentmodel->delete($delid);
    $cond = array("userid"=>$delid);
    $content = $this->usermodel->getDeletedData('users',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => "Delete",
      "module" => "Manage student",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs);
    $this->session->set_flashdata('success_message', 'Record deleted successfully');
    redirect('dashboard/student');
  } else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
  }
}

    //---------------------detail---------------------------------
function detail() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {

    $id = $this->uri->segment(3);
    $data['result'] = $this->studentmodel->getdata($id)->row();

    $data['page']       = 'detail';
    $data['heading']    = 'Edit Chat';
    $this->load->view('main', $data);
  } else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
  }
}

function print_report(){
 $id = $this->uri->segment(3);
 $data['result'] = $this->studentmodel->getdata($id)->row();
 $this->load->view('print_report', $data);
}


function send_email(){
  $id = $this->uri->segment(3);
  $data['result'] = $this->studentmodel->getdata($id)->row();
  $data['mail'] = 1;
  $message = $this->load->view('print_report', $data,"true");

  $sitename = $this->studentmodel->getConfigData(20)->config_value;
  $email = $this->studentmodel->getConfigData(22)->config_value;


  $name =  $data['result']->student_name;
  $subject =  "Invoice from Alms";
  $to = $data['result']->email;


  $this->email->set_mailtype('html');
  $this->email->from($email, $sitename);
  $this->email->to($to);
  $this->email->subject($subject);
  $this->email->message($message);
  $this->email->send();
  $this->email->clear();
  $this->session->set_flashdata('success_message', 'Mail has been sent successfully.');
  redirect('student/detail/'.$id);
}

function cascadeAction() {
  $data = $_POST['object'];
  $ids = $data['ids'];
  $action = $data['action'];
  foreach ($ids as $key => $delid) {
    $cond = array("userid"=>$delid);
    $content = $this->usermodel->getDeletedData('users',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => $action,
      "module" => "Manage student",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs); 
  }
  $query = $this->studentmodel->cascadeAction($ids, $action);
  $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
  exit();
}

function verify_document($docid,$student_id,$status){

  if($status == 0){
    $verify = 1;
    $Verified = "verified";
  }else{
    $verify = 0;
    $Verified = "unverified";
  }

  $this->db->where("id",$docid);
  $this->db->set("is_verified",$verify);
  $this->db->update("company_student_documents");

  $notifications = array(
    "content" => $this->session->userdata("username").' has '.$Verified.' your documents.',
    "link" => 'student/documents/'.$student_id,
    "from_id" => $this->session->userdata("clms_front_userid"),
    "to_id" => $student_id,
    "added_date" => date("Y-m-d")
  );
  $this->db->insert("student_notifications",$notifications);

  $this->studentmodel->addDocEmail($student_id,$docid);

  redirect("student/documents/".$student_id);

}

}