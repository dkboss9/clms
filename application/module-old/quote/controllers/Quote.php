<?php
class Quote extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->container = 'main';
    $this->load->model('quotemodel');
    $this->load->model('customer/customermodel');
    $this->load->model('users/usermodel');
    $this->load->model('lms/lmsmodel');
    $this->load->model('salerep/salerepmodel');
    $this->load->model('company/companymodel');
    $this->load->model("appointment/appointmentmodel");
    $this->load->library('html2pdf');
    $this->module_code = 'Quote';
  }

  function index() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      redirect('dashboard/quote', 'location');
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

    //----------------------------------------listall--------------------------------------------------	
  function listall() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
    
				if($this->input->get("status"))
					$qstatus = $this->input->get("status");
				else
					$qstatus = '';

				if($this->input->get("expired"))
					$expired = $this->input->get("expired");
				else
					$expired = '';

			
				$data['quote'] 	= $this->quotemodel->listall($qstatus,$expired);
		
				$data['company'] = $this->quotemodel->getCompanyDetails($this->session->userdata("clms_front_companyid"));
				$data['page'] 			= 'list';
				$data['nav'] = 'quote';
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
      $this->form_validation->set_message('username_check', '<p style="color:red;">Customer with this email already in use.Please, Try with another email.</p>');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }

  function getCustomerDetails(){
    $customer = $this->input->post("customer_id");
    $cust = $this->quotemodel->getCustomer($customer);
 
    echo '<p>Name: '.$cust->first_name.''.$cust->last_name.'</p>';
    echo '<p>Passport no: '.$cust->passport_no.'</p>';
    echo '<p>Contact No:'.$cust->mobile.'</p>';
    echo '<p>Email: '.$cust->email.'</p>';
  }

    //--------------------------------------add--------------------------------------	
  function add() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
     
      $this->form_validation->set_rules('txt_name', 'Nature', 'required');
      $company = $this->session->userdata("clms_front_companyid");
      $data['company'] = $this->companymodel->getdata($company)->row();
      if ($this->form_validation->run() == FALSE){
        $this->load->model("referals/referal_model");
        $this->load->model("student/studentmodel");
        $userdata = $this->session->userdata("clms_front_userid");
        $data['has_referal'] = $this->companymodel->has_referal_permission($userdata,164);
        // $data['referrals'] = $this->referal_model->get_referrals();
        $data['countries'] = $this->customermodel->getcoutries();
        $data['states'] = $this->customermodel->getstates(13);
        $data['customers'] = $this->studentmodel->listall(null,1);
        $data['products'] = $this->quotemodel->listProducts();
        $data['panels'] = $this->quotemodel->listPanels();
        $data['inverters'] = $this->quotemodel->listInverter();
        $data['heights'] = $this->quotemodel->listRoofHeight();
        $data['types'] = $this->quotemodel->listRoofType();
        $data['phases'] = $this->quotemodel->listPhase();
        $data['status'] = $this->quotemodel->listQuoteStatus();
        $data['from'] = $this->quotemodel->listQuoteFrom();
        $data['abouts'] = $this->quotemodel->ListAboutus();
        $data['docs'] = $this->quotemodel->ListDocs();
        $data['account_managers'] = $this->quotemodel->getaccountmanager();
        $data['sales_rep'] = $this->salerepmodel->listall();
        $data['users']      = $this->lmsmodel->get_users();
        
        if($this->input->get("lead_id")){
          $lead_id = $this->input->get("lead_id");
          $query = $this->lmsmodel->getdata($lead_id);
          $data['result']   = $query->row();
        }
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
      if($this->input->post("customer_type") == '2'){
        // if($this->input->post("lead_id") == '0'){
        //   $leads = array(
        //     "lead_name"=>$this->input->post('customer_name'),
        //     "company_name" => $this->input->post("company_name"),
        //     "email" => $this->input->post("email"),
        //     "phone_number" => $this->input->post("contact_number"),
        //     "requirements" => $this->input->post("description"),
        //     "sales_rep" => $this->input->post("sales_rep"),
        //     "reminder_date"=> time(),
        
        //     "added_by" => $userdata,
        //     "added_date" => time(),
        //     "status_id" => 18,
        //     "company_id" => $this->session->userdata("clms_front_companyid")
        //   );

        //   $this->db->insert("leads",$leads);
        //   $lead_id = $this->db->insert_id();
        // }

       
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
        $this->db->insert("company_students",$value['details']);
               $customer_id = $student = $this->db->insert_id();
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
       
        );
    
        $this->db->insert("company_student_details",$insert_array);
   // die();
  }else{
    $customer_id = $this->input->post("customer");
    if($this->input->post("lead_id") == '0'){
      $customer = $this->quotemodel->getCustomer($customer_id);

      $leads = array(
        "lead_name"=>$customer->first_name,
        "lead_lname" => $customer->last_name,
        "email" => $customer->email,
        "phone_number" => $customer->mobile,
        "requirements" => $this->input->post("description"),
        "reminder_date"=> time(),
         // "status_id" => '1',
        "added_by" => $userdata,
        "added_date" => time(),
        "status_id" => 18
      );

      $this->db->insert("leads",$leads);
      $lead_id = $this->db->insert_id();
    }
  }

  if($this->input->post("lead_id") > '0')
    $lead_id = $this->input->post("lead_id");

  $dates = $this->input->post('date');
  $dates = explode("/", $dates);
  $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
  $quote = array(
    "lead_id"=>$lead_id,
    "company_id"=>$this->session->userdata("clms_front_companyid"),
    "product"=>$this->input->post("txt_name"),
    "customer_id"=>$customer_id,
    "package"=>$this->input->post("package_type"),
    "description"=>$this->input->post("description"),
    "note"=>$this->input->post("note"),
    "discount"=>$this->input->post("discount"),
    "is_flat"=>$this->input->post("is_flat"),
    "gst_applicable"=>$this->input->post("gst_applicable"),
    "is_included"=>$this->input->post("radio_gst"),
    "gst"=>$this->input->post("gst"),
    "total_price"=>$this->input->post("total_price"),
    "price"=>$this->input->post("price"),
    "finance_option"=>$this->input->post("finance"),
    "payment_term"=>$this->input->post("payment_terms"),
    "timeline"=>$this->input->post("timeline"),
    "chk_timeline"=>$this->input->post("chk_timeline"),
    "testing"=>$this->input->post("testing"),
    "payment_terms"=>$this->input->post("payment"),
    "chk_test"=>$this->input->post("chk_test"),
    "chk_payment"=>$this->input->post("chk_payment"),
      //"document"=>$this->input->post("docs"),
    "quote_satus"=>18,
    "quote_from"=>$this->input->post("quote_from"),
    "about_us"=>$this->input->post("about_us"),
    "contact_by"=>$this->input->post("contact_by"),
    "expiry_date"=>strtotime($date),
    "status"=>1,
    "added_by"=>$userdata,
    "added_date"=>time()
  );

  $this->db->insert("quote",$quote);

  $quote_id = $this->db->insert_id();
  $this->db->where("quote_id",$quote_id);
  $this->db->set("quote_number",1000+$quote_id);
  $this->db->update("quote");

  $package_desc = $this->input->post("package_desc");
  $short_desc = $this->input->post("short_desc");
  $package_qty = $this->input->post("package_qty");
  $package_price = $this->input->post("package_price");
  $package_amount = $this->input->post("package_amount");

  foreach ($package_desc as $key => $value) {
   if($value != ""){
    $package = array(
      "quote_id"=> $quote_id,
      "descriptions" => $value,
      "short_desc" => $short_desc[$key],
      "quantity" => $package_qty[$key],
      "price" => $package_price[$key],
      "amount" => $package_amount[$key]
    );
    $this->db->insert("quote_inverters",$package);
  }
}

if($this->input->post("docs")){
 $docs = $this->input->post("docs");
 foreach ($docs as $key => $value) {
  $document = array(
    "quote_id" => $quote_id,
    "document_id" => $value,
  );
  $this->db->insert("quote_documents",$document);
}
}



$this->db->where("lead_id",$lead_id);
$this->db->set("status_id",18);
$this->db->update("leads");

$quote = $this->quotemodel->getdata($quote_id)->row();
$customer = $this->quotemodel->getCustomer($customer_id);
if($customer->student_id > 0){
  $notification = array(
    "content" => $this->session->userdata("username").' has added the quote. - #'.$quote->quote_number,
    "link" => 'quote/details/'.$quote_id,
    "from_id" => $this->session->userdata("clms_front_userid"),
    "to_id" => $customer->student_id,
    "added_date" => date("Y-m-d")
  );
  $this->db->insert("student_notifications",$notification);
}
$this->session->set_flashdata('success_message', 'Quote added successfully');
redirect('quote/listall');
}

} else {
  $this->session->set_flashdata('error', 'Please login with your username and password');
  redirect('login', 'location');
}
}

function duplicate()
{
  $this->load->model("student/studentmodel");
 $id = $this->uri->segment(3);
 $data['countries'] = $this->customermodel->getcoutries();
 $data['states'] = $this->customermodel->getstates();
 $data['customers'] = $this->studentmodel->listall(null,1);
 $data['products'] = $this->quotemodel->listProducts();
 $data['panels'] = $this->quotemodel->listPanels();
 $data['inverters'] = $this->quotemodel->listInverter();
 $data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
 $data['heights'] = $this->quotemodel->listRoofHeight();
 $data['types'] = $this->quotemodel->listRoofType();
 $data['phases'] = $this->quotemodel->listPhase();
 $data['status'] = $this->quotemodel->listQuoteStatus();
 $data['from'] = $this->quotemodel->listQuoteFrom();
 $data['abouts'] = $this->quotemodel->ListAboutus();
 $data['docs'] = $this->quotemodel->ListDocs();
 $company = $this->session->userdata("clms_front_companyid");
 $data['company'] = $this->companymodel->getdata($company)->row();

 $quote_docs = $this->quotemodel->quotedocs($id);
 $quote_docs_ids = array();
 foreach ($quote_docs as $key => $value) {
   array_push($quote_docs_ids, $value['document_id']);
 }
 $data['quote_docs'] = $quote_docs_ids;

 $query = $this->quotemodel->getdata($id);
    // echo $this->db->last_query(); die();
 if ($query->num_rows() > 0) {
  $data['result']   = $query->row();
  $data['cust'] = $this->quotemodel->getCustomer($data['result']->customer_id);
  $data['page']     = 'duplicate';
  $data['heading']  = 'duplicate Quote';
  $this->load->view('main', $data);
} else {
  redirect('quote/listall');
}
}



    //---------------------------------edit--------------------------------------
function edit() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
    if ($this->input->post('submit')) {
      $quote_id = $this->input->post('quote_id');
      $userdata = $this->session->userdata("clms_front_userid");

      $dates = $this->input->post('date');
      $dates = explode("/", $dates);
      $date = $dates[2].'/'.$dates[0].'/'.$dates[1]; 

      $quote = array(
        "company_id"=>$this->session->userdata("clms_front_companyid"),
        "product"=>$this->input->post("txt_name"),
        "customer_id"=>$this->input->post("customer"),
        "package"=>$this->input->post("package_type"),
        "description"=>$this->input->post("description"),
        "note"=>$this->input->post("note"),
        "discount"=>$this->input->post("discount"),
        "is_flat"=>$this->input->post("is_flat"),
        "gst_applicable"=>$this->input->post("gst_applicable"),
        "is_included"=>$this->input->post("radio_gst"),
        "gst"=>$this->input->post("gst"),
        "total_price"=>$this->input->post("total_price"),
        "price"=>$this->input->post("price"),
        "finance_option"=>$this->input->post("finance"),
        "payment_term"=>$this->input->post("payment_terms"),
        "timeline"=>$this->input->post("timeline"),
        "testing"=>$this->input->post("testing"),
        "payment_terms"=>$this->input->post("payment"),
        "chk_timeline"=>$this->input->post("chk_timeline"),
        "chk_test"=>$this->input->post("chk_test"),
        "chk_payment"=>$this->input->post("chk_payment"),
        //"document"=>$this->input->post("docs"),
        "quote_satus"=>$this->input->post("quote_status"),
        "quote_from"=>$this->input->post("quote_from"),
        "about_us"=>$this->input->post("about_us"),
        "contact_by"=>$this->input->post("contact_by"),
        "expiry_date"=>strtotime($date),
        "added_by"=>$userdata,
        "added_date"=>time()
      );

      $this->db->where("quote_id",$quote_id);
      $this->db->update("quote",$quote);

      $this->db->where("lead_id",$this->input->post("lead_id"));
      $this->db->set("status_id",$this->input->post("quote_status"));
      $this->db->update("leads");

      $this->db->where("quote_id",$quote_id);
      $this->db->delete("quote_inverters");

      $package_desc = $this->input->post("package_desc");
      $short_desc = $this->input->post("short_desc");
      $package_qty = $this->input->post("package_qty");
      $package_price = $this->input->post("package_price");
      $package_amount = $this->input->post("package_amount");

      foreach ($package_desc as $key => $value) {
       if($value != ""){
        $package = array(
          "quote_id"=> $quote_id,
          "descriptions" => $value,
          "short_desc" => $short_desc[$key],
          "quantity" => $package_qty[$key],
          "price" => $package_price[$key],
          "amount" => $package_amount[$key]
        );
        $this->db->insert("quote_inverters",$package);
      }
    }

    $this->db->where("quote_id",$quote_id);
    $this->db->delete('quote_documents');
    
    if($this->input->post("docs")){
     $docs = $this->input->post("docs");
     foreach ($docs as $key => $value) {
      $document = array(
        "quote_id" => $quote_id,
        "document_id" => $value,
      );
      $this->db->insert("quote_documents",$document);
    }
  }

  $quote = $this->quotemodel->getdata($quote_id)->row();
  $customer = $this->quotemodel->getCustomer($this->input->post("customer"));
  if($customer->student_id > 0){
  $notification = array(
    "content" => $this->session->userdata("username").' has Updated the quote. - #'.$quote->quote_number,
    "link" => 'quote/details/'.$quote_id,
    "from_id" => $this->session->userdata("clms_front_userid"),
    "to_id" => $customer->student_id,
    "added_date" => date("Y-m-d")
  );

  $this->db->insert("student_notifications",$notification);
}

  $this->session->set_flashdata('success_message', 'Quote edited Successfully');
  redirect('quote/listall');
} else {
  $this->load->model("student/studentmodel");
  $id = $this->uri->segment(3);
  $data['countries'] = $this->customermodel->getcoutries();
  $data['states'] = $this->customermodel->getstates();
  $data['customers'] = $this->studentmodel->listall(null,1);
  $data['products'] = $this->quotemodel->listProducts();
  $data['panels'] = $this->quotemodel->listPanels();
  $data['inverters'] = $this->quotemodel->listInverter();
  $data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
  $data['heights'] = $this->quotemodel->listRoofHeight();
  $data['types'] = $this->quotemodel->listRoofType();
  $data['phases'] = $this->quotemodel->listPhase();
  $data['status'] = $this->quotemodel->listQuoteStatus();
  $data['from'] = $this->quotemodel->listQuoteFrom();
  $data['abouts'] = $this->quotemodel->ListAboutus();
  $data['docs'] = $this->quotemodel->ListDocs();
  $company = $this->session->userdata("clms_front_companyid");
  $data['company'] = $this->companymodel->getdata($company)->row();

  $quote_docs = $this->quotemodel->quotedocs($id);
  $quote_docs_ids = array();
  foreach ($quote_docs as $key => $value) {
   array_push($quote_docs_ids, $value['document_id']);
 }
 $data['quote_docs'] = $quote_docs_ids;

 $query = $this->quotemodel->getdata($id);
    // echo $this->db->last_query(); die();
 if ($query->num_rows() > 0) {
  $data['result'] 	= $query->row();
  $data['cust'] = $this->quotemodel->getCustomer($data['result']->customer_id);
  $data['page'] 		= 'edit';
  $data['heading'] 	= 'Edit Task status';
  $this->load->view('main', $data);
} else {
  redirect('quote/listall');
}
}
}
}

function details($id){

  if($this->input->post("submit")){
   $query = $this->quotemodel->getdata($id);
   $data['result']   = $query->row();
   $to = 'CUST';
   $from_id = $data['result']->company_id;
   $to_id = $data['result']->customer_id;
   $comments = array(
    "quote_id"=>$id,
    "comment"=>$this->input->post("comment"),
    "from_id"=>$from_id,
    "to_id"=>$to_id,
    "added_date"=>date("Y-m-d h:i:s")
  );
   $this->db->insert("quote_comments",$comments);
   $this->quotemodel->sendCommentEmail($id,$this->input->post("comment"),$to);
   $this->session->set_flashdata('success_message', 'Comment added successfully.');
   redirect($_SERVER["HTTP_REFERER"]);
 }else{
  $query = $this->quotemodel->getdata($id);
  if ($query->num_rows() > 0) {
    $data['result']   = $query->row();
    $data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
    $data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
    $data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
    $data['comments'] = $this->quotemodel->getQuoteComments($id);
    // $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
    $data['page']     = 'details';
    $data['heading']  = 'Edit Task status';
    $this->load->view('main', $data);
  } else {
    redirect('quote/listall');
  }
}
}

function print_report($id){
  $query = $this->quotemodel->getdata($id);
  if ($query->num_rows() > 0) {
    $data['result']   = $query->row();
    $data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
    $data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
    $data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
    // $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
    
    $this->load->view('print', $data);
  } else {
    redirect('quote/listall');
  }
}


function public_view($invoice_id){
  $invoice = explode('-',$invoice_id);
  $id = $invoice[1];

  $this->load->model("order/ordermodel");
  $slug = $this->ordermodel->getlatestpreview_slug($id,'quote-link');
  $expired = false;
  if($invoice_id != $slug)
    $expired = true;

  $query = $this->quotemodel->getdata($id);
  if ($query->num_rows() > 0) {
   $data['result']   = $query->row();
   if($invoice[3] == "CUST"){
    $to = 'COMP';
    $from_id = $data['result']->customer_id;
    $to_id =  $data['result']->company_id;
  }else{
    $to = 'CUST';
    $from_id = $data['result']->company_id;
    $to_id = $data['result']->customer_id;
  }
  if($this->input->post("submit")){
    $comments = array(
      "quote_id"=>$id,
      "comment"=>$this->input->post("comment"),
      "from_id"=>$from_id,
      "to_id"=>$to_id,
      "added_date"=>date("Y-m-d h:i:s")
    );
    $this->db->insert("quote_comments",$comments);
    $this->quotemodel->sendCommentEmail($id,$this->input->post("comment"),$to);
    $this->session->set_flashdata('success_message', 'Comment added successfully.');
    redirect($_SERVER["HTTP_REFERER"]);
  }else{
    $data['comments'] = $this->quotemodel->getQuoteComments($id);
    $data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
    $data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
    $data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
    $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
    $data['heading']  = 'Public Quote';
    if($expired){
      $this->load->view('quote_public_expired', $data);
    }else{
      $this->load->view('quote_public', $data);
    }
  }
} else {
  redirect('order/listall');
}
}

function submit_quote($id){
  $query = $this->quotemodel->getdata($id);
  if ($query->num_rows() > 0) {
    $quote = $query->row();
    $this->quotemodel->sendmail($id);
    $this->db->set("quote_satus",'19');
    $this->db->where("quote_id",$id);
    $this->db->update("quote");

    $this->db->where("lead_id",$quote->lead_id);
    $this->db->set("status_id",'19');
    $this->db->update("leads");
    $this->session->set_flashdata('success_message', 'Quote Submited successfully.');
    redirect('dashboard/quote');
  } else {
    redirect('dashboard/quote');
  }
}

function download_quote($id){
 $query = $this->quotemodel->getdata($id);
 if ($query->num_rows() > 0) {
  $quote = $query->row();
  $this->quotemodel->download_order($id);
  $filename = "./uploads/pdf/Quote".$quote->quote_number.".pdf";

  header("Content-Length: " . filesize($filename));
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename=Quote'.$quote->quote_number.'.pdf');

  readfile($filename);

} else {
  redirect('dashboard/quote');
}
}

    //------------------------delete---------------------------------------------------------	
function delete() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
    $delid = $this->uri->segment('3');
    $cond = array("quote_id"=>$delid);
    $content = $this->usermodel->getDeletedData('quote',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => "Delete",
      "module" => "Manage Customer",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs);
    $this->quotemodel->delete($delid);
    $this->session->set_flashdata('success_message', 'Record deleted successfully');
    redirect('quote/listall');
    
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
    $cond = array("quote_id"=>$delid);
    $content = $this->usermodel->getDeletedData('quote',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => $action,
      "module" => "Manage Quote",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs); 
  }

  $query = $this->quotemodel->cascadeAction($ids, $action);
  $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
 // echo $this->db->last_query();
  exit();
}

function mail_preview($quoteid){
  if($this->input->post("submit")){

    $subject = $this->input->post("subject");
    $message = $this->input->post("details123");

    if($this->input->post("email_slug") && $this->input->post("email_slug") !=""){
      $slug = $this->input->post("email_slug");

      $preview_link = array(
        "preview_id" => $quoteid,
        "type" => 'quote-link',
        "preview_slug" => $slug,
        "send_date" => date("Y-m-d h:i:s")
      );

      $this->db->insert("preview_link",$preview_link);
    }

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
  $this->quotemodel->sendmailwithcontent($quoteid,$subject,$message,$useremails);
  $this->session->set_flashdata('success_message', 'Quote Sent successfully');
  redirect('quote/listall');

}else{

  list($subject,$message,$customer_arr,$customer_contacts,$slug) = $this->quotemodel->getmailconent($quoteid);
  $data['orderid'] = $quoteid;
  $data['subject'] = $subject;
  $data['message'] = $message;
  $data['email_slug'] = $slug;
  $data['customer_arr'] = $customer_arr;
  $data['customer_contacts'] = $customer_contacts;
  $this->load->view('mail_preview', $data);

}

}

public function count_mail_seen($quoteid)
{
 $quote_array = array(
  "quote_id" => $quoteid,
//"user_id" => $userid,
  "seen_date" => date("Y-m-d h:i:s")
);
 $this->db->insert("quote_seen",$quote_array);
}

}