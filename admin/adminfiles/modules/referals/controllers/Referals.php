<?php
class referals extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->container = 'main';
    $this->load->model('referal_model');
    $this->load->model('users/usermodel');
    $this->module_code = 'Referral';
  }

  function index() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      redirect('referals/listall', 'location');
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

    //----------------------------------------listall--------------------------------------------------	
  function listall() {
    $this->load->model("customer/customermodel");
    $this->load->model("referral_request/referral_request_model");
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
     
      
      $data['referals'] 	= $this->referal_model->listall();
      $data['page'] 			= 'list';
      $this->load->vars($data);
      $this->load->view($this->container);
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

  function dashboard($referral_id)
  {
   $this->load->model("customer/customermodel");
   $this->load->model("order/ordermodel");
   $this->load->model("referral_request/referral_request_model");
   if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
    $id = $this->uri->segment(3);
    $query = $this->referal_model->getdata($id);
    $data['result']   = $query->row();
    $data['lead_types'] = $this->referal_model->get_leadType();
    $data['referral_id']   = $referral_id;
    $data['page']       = 'dashboard';
    $this->load->vars($data);
    $this->load->view($this->container);
  } else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
  }
}
function add(){
  if($this->session->userdata("clms_userid")!="" && $this->usermodel->checkperm($this->module_code,"ADD")){

    $this->form_validation->set_rules('fname','First Name','required');
    $this->form_validation->set_rules('lname','Last Name','required');
    $this->form_validation->set_rules('role','User Group','required');
    $this->form_validation->set_rules('email','Email','required|valid_email');
    $this->form_validation->set_rules('phone','Phone','required');
    $this->form_validation->set_rules('password','Password','required');
    if($this->form_validation->run()){
     $value['details']['first_name']     = $this->input->post('fname');
     $value['details']['last_name']      = $this->input->post('lname');
     $value['details']['email']          = $this->input->post('email');
     $value['details']['phone']          = $this->input->post('phone');
     $value['details']['company_id']      = $this->session->userdata("clms_company");
                   // $value['details']['rate1']          = $this->input->post('rate1');
                   // $value['details']['rate2']          = $this->input->post('rate2');
     $value['details']['user_group']     = $this->input->post('role');
     $value['details']['password']       = md5(trim($this->input->post('password')));
     $value['details']['added_date']     = date('Y-m-d H:i:s');
     $value['details']['added_by']       = $this->session->userdata("clms_userid");
     $value['details']['status']         = 1;
     $this->usermodel->insertuser($value['details']);
     $id = $this->db->insert_id();

     $this->referal_model->referral_permission($id);

     $rate = $this->input->post("rate");
     $is_percents = $this->input->post("is_percent");
     $types = $this->input->post("type");
     
     foreach ($rate as $key=>$val) {
       
       $insert_arr = array(
        "user_id" => $id,
        "type_id" => $types[$key],
        "rate" => $val,
        "is_percentage" => isset($is_percents[$key] ) ? $is_percents[$key] : 0
      );
       $this->db->insert("salesrep_rate",$insert_arr);
     }

     $logs = array(
      "content" => serialize($value['details']),
      "action" => "Add",
      "module" => "Manage Referals",
      "added_by" => $this->session->userdata("clms_userid"),
      "added_date" => time()
    );
     $this->usermodel->insertUserlog($logs);
     $this->session->set_flashdata('success_message', 'Sale reps edited Successfully');
     redirect('referals/listall');
   }else{
    $data['lead_types'] = $this->referal_model->get_leadType();
    $company = $this->session->userdata("clms_company");

    $data['company'] = $this->companymodel->getdata($company)->row();
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


    //---------------------------------edit--------------------------------------
function edit() {
  if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
    if ($this->input->post('submit')) {
      $id = $this->input->post('userid');
      $userdata = $this->session->userdata("clms_userid");
      $data['values']['first_name']    = $this->input->post('fname');
      $data['values']['last_name']    = $this->input->post('lname');
      $data['values']['email']    = $this->input->post('email');
      $data['values']['phone']    = $this->input->post('phone');

      $value['values']['status']         = 1;

      if($this->input->post("password") != "")
        $data['values']['password']    = md5(trim($this->input->post('password')));


      $data['values']['modified_date']    = time();
      $data['values']['modified_by']      = $userdata;
      $this->referal_model->update($id, $data['values']);

      $this->db->where("user_id",$id);
      $this->db->delete("salesrep_rate");
      
      $rate = $this->input->post("rate");
      $is_percents = $this->input->post("is_percent");
      $types = $this->input->post("type");
      
      foreach ($rate as $key=>$val) {
       
       $insert_arr = array(
        "user_id" => $id,
        "type_id" => $types[$key],
        "rate" => $val,
        "is_percentage" => isset($is_percents[$key] ) ? $is_percents[$key] : 0
      );
       $this->db->insert("salesrep_rate",$insert_arr);
     }

     $logs = array(
      "content" => serialize($data['values']),
      "action" => "Edit",
      "module" => "Manage Sales Rep",
      "added_by" => $this->session->userdata("clms_userid"),
      "added_date" => time()
    );
     $this->usermodel->insertUserlog($logs);
     $this->session->set_flashdata('success_message', 'Sale reps edited Successfully');
         //echo md5(trim($this->input->post('password')));
     redirect('referals/listall');
   } else {
    $data['lead_types'] = $this->referal_model->get_leadType();
    $id = $this->uri->segment(3);
    $query = $this->referal_model->getdata($id);
    if ($query->num_rows() > 0) {
      $data['result'] 	= $query->row();
      $data['page'] 		= 'edit';
      $data['heading'] 	= 'Edit Chat';
      $this->load->view('main', $data);
    } else {
      redirect('start/listall');
    }
  }
}
}

    //------------------------delete---------------------------------------------------------	
function delete() {
  if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
    $delid = $this->uri->segment('3');
    $cond = array("userid"=>$delid);
    $content = $this->usermodel->getDeletedData('users',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => "Delete",
      "module" => "Manage Sale Reps",
      "added_by" => $this->session->userdata("clms_userid"),
      "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs);
    $this->referal_model->delete($delid);
    $this->session->set_flashdata('success_message', 'Record deleted successfully');
    redirect('referals/listall');
  } else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
  }
}

    //---------------------detail---------------------------------
function detail() {
  if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
    $id = $this->uri->segment(3);
    $query = $this->industrymodel->getdata($id);
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
    $cond = array("userid"=>$delid);
    $content = $this->usermodel->getDeletedData('users',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => $action,
      "module" => "Manage Sales Rep",
      "added_by" => $this->session->userdata("clms_userid"),
      "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs); 
  }
  $query = $this->referal_model->cascadeAction($ids, $action);
  $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
  exit();
}

}