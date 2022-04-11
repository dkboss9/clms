<?php
class sms_subscribers extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->container = 'main';
    $this->load->model('sms_subscribermodel');
    $this->load->model('users/usermodel');
    $this->module_code = 'SMS_SUBSCRIBER';
  }

  function index() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      redirect('sms_subscribers/listall', 'location');
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

    //----------------------------------------listall--------------------------------------------------	
  function listall() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      $config['base_url'] = base_url() . 'sms_subscribers/listall/';
      $config['uri_segment'] = 3;
      $config['per_page'] = 20;
      $config['cur_tag_open'] = '<span class="active">';
      $config['cur_tag_close'] = '</span>';
      $config['first_link'] = FALSE;
      $config['last_link'] = FALSE;
      $config['display_pages'] = FALSE;
      $config['next_link'] = '<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>';
      $config['prev_link'] = '<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>';
      $config['next_link_disabled'] = '<button type="button" disabled class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>';
      $config['prev_link_disabled'] = '<button type="button" disabled class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>';
      $config['next_tag_open'] = '';
      $config['next_tag_close'] = '';
      $config['prev_tag_open'] = '';
      $config['prev_tag_close'] = '';
      $config['num_tag_open'] = '';
      $config['num_tag_close'] = '';
            //$query = $this->sms_subscribermodel->listall();
      $data['sms_subscribers'] = $this->sms_subscribermodel->listall();
      $data['page'] 			= 'list';
      $this->load->vars($data);
      $this->load->view($this->container);
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

  function mobile_check($str){
    $this->db->where("mobile_number",$str);
    $this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
    $query = $this->db->get("sms_subscription");
    if ($query->num_rows() > 0)
    {
      $this->form_validation->set_message('mobile_check', 'This mobible number had been already entered.');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }

    //--------------------------------------add--------------------------------------	
  function add() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
      if($this->input->post("newsletter_subscribe"))
       $this->form_validation->set_rules("email_address",'email','required|valid_email');
     $this->form_validation->set_rules("mobile_number",'mobile number','required|callback_mobile_check');
     $this->form_validation->set_rules("name",'name','required');
     $this->form_validation->set_rules("status",'status','required');
     $this->form_validation->set_rules("newsletter_subscribe",'','');

     if ($this->form_validation->run()) {
       if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
        redirect($_SERVER["HTTP_REFERER"],"refresh");
      }

      $data['values']['mobile_number']      = $this->input->post('mobile_number');    
      $userdata = $this->session->userdata("clms_front_userid");
      $date = date("Y-m-d");
      $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
      $data['values']['email_address'] 			= $this->input->post('email_address');
      $data['values']['name'] 					= $this->input->post('name');
     // $data['values']['subscription_date'] 		= $this->input->post('subscription_date');
      $data['values']['added_date'] 				= $date;
      $data['values']['added_by'] 				= $userdata;
      $data['values']['modified_date'] 			= $date;
      $data['values']['modified_by'] 				= $userdata;
      $data['values']['status'] 					= $this->input->post('status');
      $this->sms_subscribermodel->add($data['values']);

      $this->load->model("subscribers/subscribermodel");
      if($this->input->post("newsletter_subscribe"))
        $this->subscribermodel->add($data['values']);
      $logs = array(
        "content" => serialize($data['values']),
        "action" => "Add",
        "module" => "Manage sms_subscribers",
        "added_by" => $this->session->userdata("clms_front_userid"),
        "added_date" => time()
      );
      $this->usermodel->insertUserlog($logs);
      $this->session->set_flashdata('success_message', 'Subscriber added successfully');
      redirect('sms_subscribers/listall');
    } else {
      $data['page'] = 'add';
      $data['heading'] = 'Add Subscriber';
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
      $old_email_address = $this->input->post('old_email_address');					
      $data['values']['email_address'] 			= $this->input->post('email_address');			
      $exists = false;
      if($old_email_address != $this->input->post('email_address')) {
       $exists = $this->sms_subscribermodel->checkifexists($data['values']['email_address'] );
     }				
     if(!$exists){
       $id = $this->input->post('id');
       $userdata = $this->session->userdata("clms_front_userid");
       $date = date("Y-m-d");
       $data['values']['name'] 					= $this->input->post('name');
       $data['values']['mobile_number']      = $this->input->post('mobile_number');    
       $data['values']['subscription_date'] 		= $this->input->post('subscription_date');
       $data['values']['added_date'] 				= $date;
       $data['values']['added_by'] 				= $userdata;
       $data['values']['modified_date'] 			= $date;
       $data['values']['modified_by'] 				= $userdata;
       $data['values']['status'] 					= $this->input->post('status');
       $this->sms_subscribermodel->update($id, $data['values']);
       $logs = array(
        "content" => serialize($data['values']),
        "action" => "Edit",
        "module" => "Manage sms_subscribers",
        "added_by" => $this->session->userdata("clms_front_userid"),
        "added_date" => time()
      );
       $this->usermodel->insertUserlog($logs);
       $this->session->set_flashdata('success_message', 'Subscriber Edited Successfully');
       redirect('sms_subscribers/listall');
     } else {
       $this->session->set_flashdata('error', 'Email address: '. $data['values']['email_address'] .' already exists');
       $id = $this->uri->segment(3);
       $query = $this->sms_subscribermodel->getdata($id);
       if ($query->num_rows() > 0) {
        $data['result'] 	= $query->row();
        $data['page'] 		= 'edit';
        $data['heading'] 	= 'Edit Subscriber';
        $this->load->view('main', $data);
      } else {
        redirect('sms_subscribers/listall');
      }
    }
  } else {
    $id = $this->uri->segment(3);
    $query = $this->sms_subscribermodel->getdata($id);
    if ($query->num_rows() > 0) {
      $data['result'] 	= $query->row();
      $data['page'] 		= 'edit';
      $data['heading'] 	= 'Edit Subscriber';
      $this->load->view('main', $data);
    } else {
      redirect('sms_subscribers/listall');
    }
  }
}
}

    //------------------------delete---------------------------------------------------------	
function delete() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
    $delid = $this->uri->segment('3');
    $cond = array("subscription_id"=>$delid);
    $content = $this->usermodel->getDeletedData('newsletter_subscription',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => "Delete",
      "module" => "Manage sms_subscribers",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs);
    $this->sms_subscribermodel->delete($delid);
    $this->session->set_flashdata('success_message', 'Subscriber deleted successfully');
    redirect('sms_subscribers/listall');
  } else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
  }
}

    //---------------------detail---------------------------------
function detail() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
    $id = $this->uri->segment(3);
    $query = $this->sms_subscribermodel->getdata($id);
    if ($query->num_rows() > 0) {
      $data['result'] = $query->row();
      $row = $query->row();
      $query->free_result();
      $data['title'] = $row->newsletter_title.' - Newsletter Details';
      $data['page'] = 'detail';
      $this->load->view('main', $data);
    } else {
      redirect('sms_subscribers/listall');
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
    $cond = array("subscription_id"=>$delid);
    $content = $this->usermodel->getDeletedData('newsletter_subscription',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => $action,
      "module" => "Manage sms_subscribers",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs); 
  }
  $query = $this->sms_subscribermodel->cascadeAction($ids, $action);
  $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
  echo '';
  exit();
}

function validateemail(){		
  $email_address = $this->input->post('email_address');
  if($this->sms_subscribermodel->checkifexists($email_address))
   echo 1;
 else
   echo 0;
}

}