<?php
class Customer extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->container = 'main';
    $this->load->model('customermodel');
    $this->load->model('users/usermodel');
    $this->module_code = 'CUSTOMER';
  }

  function index() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      redirect('customer/listall', 'location');
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

    //----------------------------------------listall--------------------------------------------------	
  function listall() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      $data['status'] 	= $this->customermodel->listall();
      $data['page'] 			= 'list';
      $this->load->vars($data);
      $this->load->view($this->container);
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

  public function username_check($str)
  {
    $num = $this->customermodel->check_duplicateEmail($str,$this->session->userdata("clms_front_companyid"));
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

  function details($id){
   $this->load->model('student/studentmodel');
   $data["customer"] = $this->studentmodel->getdata($id)->row();
   $this->load->view("details",$data);
 }

    //--------------------------------------add--------------------------------------	
 function add() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
    $this->form_validation->set_rules('email', 'Email', 'required|callback_username_check');

    if ($this->form_validation->run() == FALSE){
     $data['countries'] = $this->customermodel->getcoutries();
     $data['states'] = $this->customermodel->getstates();
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
    $userdata = $this->session->userdata("clms_front_userid");
    $date = date("Y-m-d");
    $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
    $data['values']['customer_name']    = $this->input->post('customer_name');
    $data['values']['company_name']    = $this->input->post('company_name');
    $data['values']['contact_number']    = $this->input->post('contact_number');
    $data['values']['email']    = $this->input->post('email');
    $data['values']['billing_address1']    = $this->input->post('bill_address_1');
    $data['values']['billing_address2']    = $this->input->post('bill_address_2');
    $data['values']['billing_suburb']    = $this->input->post('bill_suburb');
    $data['values']['billing_state']    = $this->input->post('bill_state');
    $data['values']['billing_postcode']    = $this->input->post('bill_postcode');
    $data['values']['billing_country']    = $this->input->post('bill_country');
    $data['values']['delivery_address1']    = $this->input->post('delivery_address_1');
    $data['values']['delivery_address2']    = $this->input->post('delivery_address_2');
    $data['values']['delivery_suburb']    = $this->input->post('delivery_suburb');
    $data['values']['delivery_state']    = $this->input->post('delivery_state');
    $data['values']['delivery_postcode']    = $this->input->post('delivery_postcode');
    $data['values']['delivery_country']    = $this->input->post('delivery_country');
    $data['values']['added_date']       = time();
    $data['values']['added_by']         = $userdata;
    $data['values']['status']      = 1;
    $this->customermodel->add($data['values']);

    $id = $this->db->insert_id();
    $this->db->where("customer_id",$id);
    $this->db->set("customer_no",1000+$id);
    $this->db->update("customers");

    $logs = array(
      "content" => serialize($data['values']),
      "action" => "Add",
      "module" => "Manage Customer",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
      );
    $this->usermodel->insertUserlog($logs);
    $this->session->set_flashdata('success_message', 'Customer added successfully');
    redirect('customer/listall');
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
      $id = $this->input->post('customer_id');
      $userdata = $this->session->userdata("clms_front_userid");
      $data['values']['customer_name']    = $this->input->post('customer_name');
      $data['values']['company_name']    = $this->input->post('company_name');
      $data['values']['contact_number']    = $this->input->post('contact_number');
      $data['values']['email']    = $this->input->post('email');
      $data['values']['billing_address1']    = $this->input->post('bill_address_1');
      $data['values']['billing_address2']    = $this->input->post('bill_address_2');
      $data['values']['billing_suburb']    = $this->input->post('bill_suburb');
      $data['values']['billing_state']    = $this->input->post('bill_state');
      $data['values']['billing_postcode']    = $this->input->post('bill_postcode');
      $data['values']['billing_country']    = $this->input->post('bill_country');
      $data['values']['delivery_address1']    = $this->input->post('delivery_address_1');
      $data['values']['delivery_address2']    = $this->input->post('delivery_address_2');
      $data['values']['delivery_suburb']    = $this->input->post('delivery_suburb');
      $data['values']['delivery_state']    = $this->input->post('delivery_state');
      $data['values']['delivery_postcode']    = $this->input->post('delivery_postcode');
      $data['values']['delivery_country']    = $this->input->post('delivery_country');
      $data['values']['modified_date']    = time();
      $data['values']['modified_by']      = $userdata;
      $this->customermodel->update($id, $data['values']);
      $logs = array(
        "content" => serialize($data['values']),
        "action" => "Edit",
        "module" => "Manage Customer",
        "added_by" => $this->session->userdata("clms_front_userid"),
        "added_date" => time()
        );
      $this->usermodel->insertUserlog($logs);
      $this->session->set_flashdata('success_message', 'Customer edited Successfully');
      redirect('customer/listall');
    } else {
     $data['countries'] = $this->customermodel->getcoutries();
     $data['states'] = $this->customermodel->getstates();
     $id = $this->uri->segment(3);
     $query = $this->customermodel->getdata($id);
     if ($query->num_rows() > 0) {
      $data['result'] 	= $query->row();
      $data['page'] 		= 'edit';
      $data['heading'] 	= 'Edit Task status';
      $this->load->view('main', $data);
    } else {
      redirect('customer/listall');
    }
  }
}
}

    //------------------------delete---------------------------------------------------------	
function delete() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
    $delid = $this->uri->segment('3');
    $cond = array("customer_id"=>$delid);
    $content = $this->usermodel->getDeletedData('customers',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => "Delete",
      "module" => "Manage Customer",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
      );
    $this->usermodel->insertUserlog($logs);
    $this->customermodel->delete($delid);
    $this->session->set_flashdata('success_message', 'Record deleted successfully');
    redirect('customer/listall');
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
    $cond = array("customer_id"=>$delid);
    $content = $this->usermodel->getDeletedData('customers',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => $action,
      "module" => "Manage Customer",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
      );
    $this->usermodel->insertUserlog($logs); 
  }

  $query = $this->customermodel->cascadeAction($ids, $action);
  $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
 // echo $this->db->last_query();
  exit();
}

}