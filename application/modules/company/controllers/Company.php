<?php
class Company extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->container = 'main';
    $this->load->model('companymodel');
    $this->load->model('users/usermodel');
    $this->module_code = 'Company';
    $this->load->library("uuid");
    $this->load->library('html2pdf');
  }

  function index() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      redirect('company/listall', 'location');
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

    //----------------------------------------listall--------------------------------------------------	
  function listall() {
     if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      $data['company'] 	= $this->companymodel->listall();
            //print_r($this->session->userdata); die();
      if($this->session->userdata("clms_front_user_group")=='1' || $this->session->userdata("clms_front_user_group")=='2'){ 
        $data['page'] 			= 'list';
      }
      else{
       $data['page']          = 'list_company';
     }
     $this->load->vars($data);
     $this->load->view($this->container);
   } else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
  }
}

function save_tabname(){
  if ($this->session->userdata("clms_front_userid") != "") {
    $company_id = $this->session->userdata("clms_front_userid");
    $tab_name = $this->input->post("tab_name");
    $tab_value = $this->input->post("tab_value");
    $this->db->set($tab_name,$tab_value);
    $this->db->where("company_id",$company_id);
    $this->db->update("company_details");
  } else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
  }
}

function set_company(){
  $company = $this->input->post("company_id"); 
  $this->session->set_userdata("clms_company",$company);
  redirect($_SERVER["HTTP_REFERER"],"locations");
}

function set_my_company(){
  $company = $this->input->post("company_id"); 
  $this->companymodel->updateCompanyEmail($company);
  $this->session->set_userdata("clms_company",$company);
  $this->session->set_userdata("company_id",$company);
  redirect($_SERVER["HTTP_REFERER"],"locations");
}

function get_company(){
  $name = $this->uri->segment("3");
  $this->db->where("status",1);
  $this->db->where("user_group",7);
  $this->db->like('company_name', $name);
  $query = $this->db->get("users")->result();
  $users = array();
  $elms = array();
  foreach ($query as $row) {
   $user = new stdClass;
   $user->userid = $row->userid;
   $user->name = $row->company_name;
   $users[] = $user;

 }
 $item['item'] = $users;
 echo json_encode($item);
}
function add(){
  if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"ADD")){
    if(!$this->input->post("is_admin")){
      if(!$this->companymodel->checkCompanyNo()){
        $this->session->set_flashdata('error', 'Your company quota is exceeded.');
        redirect('company/listall');
      }

    }
    $this->form_validation->set_rules('fname','First Name','required');
    $this->form_validation->set_rules('lname','Last Name','required');
    $this->form_validation->set_rules('company','Company Name','required');
    $this->form_validation->set_rules('address1','Address','required');

    $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]');
    $this->form_validation->set_rules('phone','Phone','required');


    if($this->input->post("is_admin")){
     $this->form_validation->set_rules('username','Username','required|is_unique[users.user_name]');
     $this->form_validation->set_rules('password','Password','required');
   }

   if($this->form_validation->run()!=FALSE){

    $config['upload_path'] = './assets/uploads/users';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_width'] = 0;
    $config['max_height'] = 0;
    $config['max_size'] = 0;
    $config['encrypt_name'] = FALSE;
    $this->upload->initialize($config);
    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('logo'))
    {
      $error = array('error' => $this->upload->display_errors());

            //print_r($error);
    }
    else
    {
      $arr_image = $this->upload->data();
      $thumb = $this->_createThumbnail('./assets/uploads/users/' . $arr_image['file_name'], './assets/uploads/users/thumb',174,69);
      $value['details']['picture']              = $arr_image['file_name']; 
      $value['details']['thumbnail']              = $thumb["dst_file"];
    }


    $value['details']['uuid']     = $this->uuid->v4();
    $value['details']['first_name']     = $this->input->post('fname');
    $value['details']['last_name']      = $this->input->post('lname');
    $value['details']['email']          = $this->input->post('email');
    $value['details']['phone']          = $this->input->post('phone');
    $value['details']['company_name']          = $this->input->post('company');
    $value['details']['address']          = $this->input->post('address1');
    $value['details']['user_group']     = 7;
    $value['details']['added_date']     = date('Y-m-d H:i:s');
    $value['details']['added_by']       = $this->session->userdata("clms_front_userid");
    $value['details']['status']         = 1;

    if($this->input->post("is_admin")){
      $value['details']['password']       = md5($this->input->post('password'));
      $value['details']['user_name']      = $this->input->post('username');
    }

    $this->usermodel->insertuser($value['details']);
    $company = $this->db->insert_id();
    $this->db->where("userid",$company);
    
    if($this->input->post("is_admin")){
      $this->db->set("company_id",$company);
    }else{
     $this->db->set("company_id",$this->session->userdata("clms_front_userid"));
   }
   $this->db->update("users");

   if($this->input->post("is_admin")){
    $dates = $this->input->post('join_date');
    $dates = explode("/", $dates);
    $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
    $dates1 = $this->input->post('expiry_date');
    $dates1 = explode("/", $dates1);
    $date1 = $dates1[1].'/'.$dates1[0].'/'.$dates1[2]; 
  }

  $insert_array = array(
    "company_id" => $company,
    "duedatenumber" => $this->input->post("duedatenumber"),
    "quote_email" => $this->input->post("quote_email"),
    "order_email" => $this->input->post("order_email"),
    "address2" => $this->input->post("address2"),
    "country" => $this->input->post("bill_country"),
    "state" => $this->input->post("bill_state"),
    "abn" => $this->input->post("abn"),
    "display_abn" => $this->input->post("display_abn"),
    "postcode" => $this->input->post("postcode"),
    "pay_via_phone" => $this->input->post("cc-number"),
    "pay_via_online" => $this->input->post("cc-via-online"),
    "cc_via_paypal" => $this->input->post("cc-via-paypal"),
    "bank" => $this->input->post("bank"),
    "bsb" => $this->input->post("bsb"),
    "account_no" => $this->input->post("account_no"),
    "mail_to" => $this->input->post("mail_to"),
    "mail_to_address" => $this->input->post("mail_to_address"),
    "eway_id" => $this->input->post("eway_id"),
    "api_username" => $this->input->post("api_username"),
    "api_signature" => $this->input->post("api_signature"),
    "api_password" => $this->input->post("api_password"),
  );

  if($this->input->post("is_admin")){
   $insert_array["description"] = $this->input->post('description');
   $insert_array["package_id"] = $this->input->post('package');
   $insert_array["payment_term"] = $this->input->post('order_term');
   $insert_array["price"] = $this->input->post('txt_package_price');
   $insert_array["invoice_status"] = $this->input->post('invoice_status');
   $insert_array["join_date"] = strtotime($date);
   $insert_array["expiry_date"] = strtotime($date1);
 }

 $this->db->insert("company_details",$insert_array);
 if($this->session->userdata("clms_front_user_group")=='1' || $this->session->userdata("clms_front_user_group")=='2')
   $this->companymodel->setModulePermission($this->input->post('package'),$company);

 $this->session->set_flashdata('success_message', 'Company added Successfully.');
 redirect('company/listall');
}else{
  $data['packages'] = $this->companymodel->listPackages();
  $data['countries'] = $this->companymodel->getcoutries();
  $data['states'] = $this->companymodel->getstates(13);
  if($this->session->userdata("clms_front_user_group")=='1' || $this->session->userdata("clms_front_user_group")=='2')
    $data['page'] = 'add';
  else
    $data['page'] = 'add_mycompany';

  $data['heading'] = 'Add ';
  $this->load->vars($data);
  $this->load->view($this->container);
}
}else{
  $this->session->set_flashdata('error','Please login with your username and password');
  redirect('login','location');
}
}

function get_packageDetails(){
  $packageid = $this->input->post("packageid");
  $this->db->select("*")->from("pnp_company_package");
  $this->db->where("package_id",$packageid);
  $query = $this->db->get("")->result();
  echo json_encode($query);
}

function opening_hours($id){
  if($this->session->userdata("clms_front_userid")!=""){
    if($this->input->post("submit")){

      $summary_report = $this->input->post("summary_report") ? implode(",",$this->input->post("summary_report")) : NULL;

      $this->db->where("company_id",$id);
      $this->db->set("time_zone",$this->input->post("time_zone"));
      $this->db->set("summary_report",$summary_report);
      $this->db->update("company_details");

      $this->db->where("company_id",$id);
      $this->db->delete("company_service_time_available");

     
    
      $start = $this->input->post("start_time");
      $end = $this->input->post("end_time");
      $day = $this->input->post("day_id");

      foreach($start as $key=>$val){
          $service = array(
              "company_id" => $id,
              "service_day"=> $day[$key],
              "service_start_time" => $start[$key],
              "service_end_time" => $end[$key],
          );
          $this->db->insert("company_service_time_available",$service);
      }


      $this->session->set_flashdata('success_message', 'Company Opening hour updated Successfully');
      redirect('company/opening_hours/'.$id);
    }else{
      $this->load->model("installer/installermodel");
     $userdata = $this->session->userdata("acrm_userid");
     $data['has_referal'] = $this->companymodel->has_referal_permission($userdata,164);
     $company = $this->session->userdata("clms_front_companyid");
     $data['countries'] = $this->companymodel->getcoutries();
     $data['company'] = $this->companymodel->getdata($company)->row();
     $data['company_id'] = $id;
     $data['days'] = $this->installermodel->get_service_day();
     $data['page']       = 'opening_hours';
     $data['heading']    = 'Edit Chat';
     $this->load->view('main', $data);
   }
 }else{
  redirect("","");
}
}


function profile($company_id){
  if($this->session->userdata("clms_front_userid")!=""){ 
  if($this->input->post("submit")){
    $id = $this->input->post('userid');
    $userdata = $this->session->userdata("clms_front_userid");
    $config['upload_path'] = './assets/uploads/users';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_width'] = 0;
    $config['max_height'] = 0;
    $config['max_size'] = 0;
    $config['encrypt_name'] = FALSE;
    $this->upload->initialize($config);
    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('logo'))
    {
      $error = array('error' => $this->upload->display_errors());

               // print_r($error);
    }
    else
    {
      $arr_image = $this->upload->data();
      $thumb = $this->_createThumbnail('./assets/uploads/users/' . $arr_image['file_name'], './assets/uploads/users/thumb',174,69);
      $data['values']['picture']              = $arr_image['file_name']; 
      $data['values']['thumbnail']              = $thumb["dst_file"];
    }

    $data['values']['first_name']    = $this->input->post('fname');
    $data['values']['last_name']    = $this->input->post('lname');
    $data['values']['email']    = $this->input->post('email');
    $data['values']['phone']    = $this->input->post('phone');
    $data['values']['company_name']          = $this->input->post('company');
    $data['values']['address']          = $this->input->post('address1');
    if($this->input->post("password") != "")
      $data['values']['password']    = md5($this->input->post('password'));
    $data['values']['modified_date']    = time();
    $data['values']['modified_by']      = $userdata;

    $this->companymodel->update($id, $data['values']);

    $insert_array = array(
      "company_id" => $id,
      "quote_email" => $this->input->post("quote_email"),
      "order_email" => $this->input->post("order_email"),
      "account_email" => $this->input->post("account_email"),
      "address2" => $this->input->post("address2"),
      "country" => $this->input->post("bill_country"),
      "state" => $this->input->post("bill_country") == 13 ? $this->input->post("bill_state") : $this->input->post("txt_bill_state"),
      "abn" => $this->input->post("abn"),
      "mail_to_address" => $this->input->post('address1'),
      "license_no" => $this->input->post("license_no"),
      "display_abn" => $this->input->post("display_abn"),
      "postcode" => $this->input->post("postcode"),
      "description"   => $this->input->post('description'),
    );
    $this->db->where("company_id",$id);
    $this->db->update("company_details",$insert_array);

    $email_name = $this->input->post("email_name");
    $standup_emails = $this->input->post("standup_email");
    $standup_mobiles = $this->input->post("standup_mobile");

    $this->db->where("company_id",$company_id);
    $this->db->delete("company_standup_emails");
    if($this->input->post("standup_email")){
    foreach($standup_emails as $key => $email){
      $data = [
        "company_id" => $id,
        "name" => $email_name[$key],
        "email" => $email,
        "mobile" => $standup_mobiles[$key]
      ];
      $this->db->insert("company_standup_emails",$data);
    }
  }

    $this->session->set_flashdata('success_message', 'Profile updated Successfully');
    redirect($_SERVER['HTTP_REFERER']);
  }else{

    $company = $company_id;
    $userdata = $this->session->userdata("clms_front_userid");
    $data['has_referal'] = $this->companymodel->has_referal_permission($userdata,164);
    $data['countries'] = $this->companymodel->getcoutries();
    $data['company'] = $this->companymodel->getdata($company)->row();
    $data['checked_inemails'] = $this->companymodel->checked_inemails($company);
    $data['company_id'] = $company_id;
    $data['page']       = 'profile';
    $data['heading']    = 'Edit Chat';
    $this->load->view('main', $data);
  }}
}

function invoice_setting($company_id){
  if(!$this->session->userdata("clms_front_userid") ||  $this->session->userdata("clms_front_userid") == '')
    redirect('login', 'location');
  if($this->input->post("submit")){
      $this->db->where('company_id',$company_id);
				$this->db->delete("package_reminder");
				if($this->input->post("reminder")){
					$reminder = $this->input->post("reminder");
					foreach ($reminder as $key => $value) {
						$array_remind = array("company_id"=>$company_id,"reminder"=>$value);
						$this->db->insert("package_reminder",$array_remind);
					}
				}
				$this->session->set_flashdata('success_message', 'Reminder Renew Email Updated successfully');
				redirect("company/invoice_setting/".$company_id,'');
  }else{
      $company = $company_id;
      $data['company_id'] = $company;
      $userdata = $this->session->userdata("clms_front_userid");
      $data['has_referal'] = $this->companymodel->has_referal_permission($userdata,164);
      $data['countries'] = $this->companymodel->getcoutries();
      $data['company'] = $this->companymodel->getdata($company)->row();
      $data['page']       = 'invoice_setting';
      $data['heading']    = 'Edit Chat';
      $this->load->view('main', $data);
  }
    
}

function setting($company_id){
  if($this->input->post("submit")){
   $id = $this->input->post('userid');
   $userdata = $this->session->userdata("clms_front_userid");


   $dates = $this->input->post('join_date');

   $insert_array = array(
    "company_id" => $id,
    "duedatenumber" => $this->input->post("duedatenumber"),
    "quote_days" => $this->input->post("quote_days"),
    "lead_days" => $this->input->post("lead_days"),
    "pay_via_phone" => $this->input->post("cc-number"),
    "pay_via_online" => $this->input->post("cc-via-online"),
    "cc_via_paypal" => $this->input->post("cc-via-paypal"),
    "bank" => $this->input->post("bank"),
    "bsb" => $this->input->post("bsb"),
    "account_no" => $this->input->post("account_no"),
    "mail_to" => $this->input->post("mail_to"),
    "mail_to_address" => $this->input->post("mail_to_address"),
    "eway_id" => $this->input->post("eway_id"),
    "stripe_public_key" => $this->input->post("stripe_public_key"),
    "stripe_private_key" => $this->input->post("stripe_private_key"),
    "api_username" => $this->input->post("api_username"),
    "api_signature" => $this->input->post("api_signature"),
    "api_password" => $this->input->post("api_password"),
    "chk_card" => $this->input->post("chk_card"),
    "chk_bank" => $this->input->post("chk_bank"),
    "chk_post" => $this->input->post("chk_post"),
    "chk_eway" => $this->input->post("chk_eway"),
    "chk_stripe" => $this->input->post("chk_stripe"),
    "chk_payment_online" => $this->input->post("chk_payment_online"),
    "gst" => $this->input->post("gst_setting"),
    "project_test_label" => $this->input->post("project_test"),
    "chk_field1" => $this->input->post("chk_field1"),
    "chk_field2" => $this->input->post("chk_field2"),
    "chk_field3" => $this->input->post("chk_field3"),
    "txt_field1" => $this->input->post("txt_field1"),
    "txt_field2" => $this->input->post("txt_field2"),
    "license_no_label" => $this->input->post("license_no_label"),
    "payment_term_label" => $this->input->post("payment_term"),
    "chk_paypal" => $this->input->post("chk_paypal"),
    "chk_credit_phone" => $this->input->post("chk_cc_number"),
    "chk_credit_paypal" => $this->input->post("chk_via-paypal"),
    "chk_credit_online" => $this->input->post("chk_via-online"),
    "credit_card_charge" => $this->input->post("cc_charge")
  );

//print_r($insert_array); die();

   $this->db->where("company_id",$id);
   $this->db->update("company_details",$insert_array);

   $this->session->set_flashdata('success_message', 'Setting Updated Successfully');
   redirect($_SERVER['HTTP_REFERER']);
 }else{
  $company = $company_id;
  $userdata = $this->session->userdata("clms_front_userid");
  $data['has_referal'] = $this->companymodel->has_referal_permission($userdata,164);
  $data['countries'] = $this->companymodel->getcoutries();
  $data['company'] = $this->companymodel->getdata($company)->row();
  $data['page']       = 'setting';
  $data['heading']    = 'Edit Chat';
  $this->load->view('main', $data);
}

}

function tab_setting(){
  if($this->session->userdata("clms_front_companyid")!=""){
    if($this->input->post("submit")){
      $id = $this->input->post('userid');
      
      $tab_array = array(
        "tab_lead_name" => $this->input->post("tab_lead_name"),
        "tab_customer_name" => $this->input->post("tab_customer_name"),
        "tab_quote_name" => $this->input->post("tab_quote_name"),
        "tab_job_name" => $this->input->post("tab_job_name"),
        "tab_installer_name" => $this->input->post("tab_installer_name"),
        "tab_support_name" => $this->input->post("tab_support_name"),
        "tab_invoice_name" => $this->input->post("tab_invoice_name"),
      );

      $this->db->where("company_id",$id);
      $this->db->update("company_details",$tab_array);

      $this->session->set_flashdata('success_message', 'Tab name updated Successfully');
      redirect('company/tab_setting');
    }else{
     $userdata = $this->session->userdata("clms_front_userid");
     $data['has_referal'] = $this->companymodel->has_referal_permission($userdata,164);
     $company = $this->session->userdata("clms_front_companyid");
     $data['countries'] = $this->companymodel->getcoutries();
     $data['company'] = $this->companymodel->getdata($company)->row();
     $data['page']       = 'tab_setting';
     $data['heading']    = 'Edit Chat';
     $this->load->view('main', $data);
   }
 }else{
  redirect("","");
}
}

function referral_setting($company_id){
  if($this->session->userdata("clms_front_companyid")!=""){

    if($this->input->post("submit")){
      $enable_referral = $this->input->post("enable_referral");
      $enable_discount_referred_customer = $this->input->post("enable_discount_referred_customer");
      $referred_discount = $this->input->post("referred_discount");
      $is_referred_percentage = $this->input->post("is_referred_percentage");
      $referral_array = array(
        "to_do_email" => $this->input->post("to_do_email"),
        "to_do_email_referral" => $this->input->post("to_do_email_referral"),
        "enable_referral" => $enable_referral,
        "enable_discount_referred_customer" => $enable_discount_referred_customer,
        "referred_discount" => $referred_discount,
        "is_referred_percentage" => $is_referred_percentage,
        "referral_company_asign_rate" => $this->input->post("referral_company_asign_rate"),
        "referral_self_asign_rate" =>$this->input->post("referral_self_asign_rate"),
        "is_referral_company_asign_rate_percentage" => $this->input->post("is_referral_company_asign_rate_percentage"),
        "is_referral_self_asign_rate_percentage" => $this->input->post("is_referral_self_asign_rate_percentage"),
      );
      $this->db->where("company_id",$company_id);
      $this->db->update("company_details",$referral_array);
      $this->session->set_flashdata('success_message', 'Referral Setting updated Successfully');
      redirect('company/referral_setting/'.$company_id);
    }else{
     $userdata = $this->session->userdata("clms_front_userid");
     $data['has_referal'] = $this->companymodel->has_referal_permission($userdata,164);
     $company = $this->session->userdata("clms_front_companyid");

     $data['company'] = $this->companymodel->getdata($company)->row();
     $data['page']       = 'referral_setting';
     $data['heading']    = 'Edit Chat';
     $this->load->view('main', $data);
   }
 }else{
  redirect("","");
}
}

function upgrade(){
 $type = $this->input->get("type");
 $company = $this->session->userdata("clms_front_companyid");
 $data['countries'] = $this->companymodel->getcoutries();
 $data['company'] = $this->companymodel->getdata($company)->row();
 $data['package'] = $this->companymodel->getPackageDetail($data['company']->package_id);
 if($type=='renew')
 $data['packages'] = $this->companymodel->listPackages();
 else
 $data['packages'] = $this->companymodel->listPackages($data['company']->package_id);
 $data['page']       = 'upgrade';
 $data['heading']    = 'Edit Chat';
 $this->load->view('main', $data);
}

function get_state(){
  $country = $this->input->post('country');
  $states = $this->companymodel->getstates($country);
  foreach ($states as $row) {
   ?>
   <option value="<?php echo $row->state_id;?>"><?php echo $row->state_name;?></option>
   <?php
 }
}

function get_state_new(){
  $country = $this->input->post('country');
  $states = $this->companymodel->getstates($country);
  foreach ($states as $row) {
   ?>
   <option value="<?php echo $row->state_name;?>"><?php echo $row->state_name;?></option>
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

function upload_file() {

  $config['upload_path'] = './assets/uploads/users/';
  $config['allowed_types'] = 'gif|jpg|png';
  $config['max_width'] = 0;
  $config['max_height'] = 0;
  $config['max_size'] = 0;
  $config['encrypt_name'] = FALSE;
  $this->upload->initialize($config);
  $this->load->library('upload', $config);

  $this->load->library('upload', $config);
  if (!$this->upload->do_upload('file')) {
    echo $this->upload->display_errors();
} else {
    $arr_image = $this->upload->data();
    $thumb = $this->_createThumbnail('./assets/uploads/users/'.$arr_image["file_name"], './assets/uploads/users/thumb/',776,223);
    $arr = array("image_name"=>$arr_image["file_name"],"thumb_name"=>$thumb["dst_file"]);
    $this->db->where("userid",$this->session->userdata("clms_front_userid"));
    $this->db->set("picture",$arr_image["file_name"]);
    $this->db->set("thumbnail",$thumb["dst_file"]);
    $this->db->update("users");
    echo json_encode($arr);
}

}

function upload_file_project() {

  $config['upload_path'] = './uploads/document/';
  $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
  $config['max_width'] = 0;
  $config['max_height'] = 0;
  $config['max_size'] = 0;
  $config['encrypt_name'] = FALSE;
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

function remove_image(){
  $this->db->where("userid",$this->session->userdata("clms_front_userid"));
  $this->db->set("picture",'');
  $this->db->set("thumbnail",'');
  $this->db->update("users");
}

    //---------------------------------edit--------------------------------------
function edit() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
    if ($this->input->post('userid')) {
      $id = $this->input->post('userid');
      $userdata = $this->session->userdata("clms_front_userid");

      $config['upload_path'] = './assets/uploads/users';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_width'] = 0;
      $config['max_height'] = 0;
      $config['max_size'] = 0;
      $config['encrypt_name'] = FALSE;
      $this->upload->initialize($config);
      $this->load->library('upload', $config);
      if ( ! $this->upload->do_upload('logo'))
      {
        $error = array('error' => $this->upload->display_errors());

               // print_r($error);
      }
      else
      {
        $arr_image = $this->upload->data();
        $thumb = $this->_createThumbnail('./assets/uploads/users/' . $arr_image['file_name'], './assets/uploads/users/thumb',174,69);
        $data['values']['picture']              = $arr_image['file_name']; 
        $data['values']['thumbnail']              = $thumb["dst_file"];
      }

      $data['values']['first_name']    = $this->input->post('fname');
      $data['values']['last_name']    = $this->input->post('lname');
      $data['values']['email']    = $this->input->post('email');
      $data['values']['phone']    = $this->input->post('phone');
      $data['values']['user_name']    = $this->input->post('username');
      $data['values']['company_name']          = $this->input->post('company');
      $data['values']['address']          = $this->input->post('address1');
      if($this->input->post("password") != "")
        $data['values']['password']    = md5($this->input->post('password'));


      $data['values']['modified_date']    = time();
      $data['values']['modified_by']      = $userdata;


      $this->companymodel->update($id, $data['values']);
           // echo $this->db->last_query();
      $dates = $this->input->post('join_date');
      $dates = explode("/", $dates);
      $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
      $dates1 = $this->input->post('expiry_date');
      $dates1 = explode("/", $dates1);
      $date1 = $dates1[1].'/'.$dates1[0].'/'.$dates1[2]; 

      $insert_array = array(
        "company_id" => $id,
        "powered_by"    => $this->input->post('powered_by'),
        "duedatenumber" => $this->input->post("duedatenumber"),
        "quote_email" => $this->input->post("quote_email"),
        "order_email" => $this->input->post("order_email"),
        "address2" => $this->input->post("address2"),
        "country" => $this->input->post("bill_country"),
        "state" => $this->input->post("bill_state"),
        "abn" => $this->input->post("abn"),
        "display_abn" => $this->input->post("display_abn"),
        "postcode" => $this->input->post("postcode"),
        "pay_via_phone" => $this->input->post("cc-number"),
        "pay_via_online" => $this->input->post("cc-via-online"),
        "cc_via_paypal" => $this->input->post("cc-via-paypal"),
        "bank" => $this->input->post("bank"),
        "bsb" => $this->input->post("bsb"),
        "account_no" => $this->input->post("account_no"),
        "mail_to" => $this->input->post("mail_to"),
        "mail_to_address" => $this->input->post("mail_to_address"),
        "eway_id" => $this->input->post("eway_id"),
        "api_username" => $this->input->post("api_username"),
        "api_signature" => $this->input->post("api_signature"),
        "api_password" => $this->input->post("api_password"),
        "description"   => $this->input->post('description'),
        "invoice_status"    => $this->input->post('invoice_status'),
        "join_date" => strtotime($date),
        "expiry_date" => strtotime($date1),
      );
      $this->db->where("company_id",$id);
      $this->db->update("company_details",$insert_array);






      $this->session->set_flashdata('success_message', 'Company edited Successfully');
      redirect('company/listall');
    } else {
      $data['packages'] = $this->companymodel->listPackages();
      $data['countries'] = $this->companymodel->getcoutries();
      $id = $this->uri->segment(3);
      $query = $this->companymodel->getdata($id);
      if ($query->num_rows() > 0) {
        $data['result'] 	= $query->row();
        $data['page'] 		= 'edit';
        $data['heading'] 	= 'Edit Chat';
        $this->load->view('main', $data);
      } else {
        redirect('company/listall');
      }
    }
  }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
    $delid = $this->uri->segment('3');
    $this->companymodel->delete($delid);
    $cond = array("userid"=>$delid);
    $content = $this->usermodel->getDeletedData('users',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => "Delete",
      "module" => "Manage Company",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs);
    $this->session->set_flashdata('success_message', 'Record deleted successfully');
    redirect('company/listall');
  } else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
  }
}

    //---------------------detail---------------------------------
function detail() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {

    $id = $this->uri->segment(3);
    $data['result'] = $this->companymodel->getdata($id)->row();

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
 $data['result'] = $this->companymodel->getdata($id)->row();
 $this->load->view('print_report', $data);
}


function send_email(){
  $id = $this->uri->segment(3);
  $data['result'] = $this->companymodel->getdata($id)->row();
  $data['mail'] = 1;
  $message = $this->load->view('print_report', $data,"true");

  $sitename = $this->companymodel->getConfigData(20)->config_value;
  $email = $this->companymodel->getConfigData(22)->config_value;


  $name =  $data['result']->company_name;
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
  redirect('company/detail/'.$id);
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
      "module" => "Manage Company",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs); 
  }
  $query = $this->companymodel->cascadeAction($ids, $action);
  $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
  exit();
}

function getPackagePrice(){
  $package_id = $this->input->post("package_id");
  $detail = $this->companymodel->get_packageDetails($package_id);

  $string = '<option value="">Select</option>';
  $string .= '<option value="1 Month" price="'.$detail->txt_month.'" discountprice="'.$detail->txt_month_discount.'">1 Month</option>';
  $string .= '<option value="3 Months" price="'.$detail->txt_3month.'" discountprice="'.$detail->txt_3month_discount.'">3 Months</option>';
  $string .= '<option value="6 Months" price="'.$detail->txt_6month.'" discountprice="'.$detail->txt_6month_discount.'">6 Months</option>';
  $string .= '<option value="12 Months" price="'.$detail->txt_12month.'" discountprice="'.$detail->txt_12month_discount.'">12 Months</option>';
  echo $string;
}

function qr_code($uuid){
  $this->load->model("quote/quotemodel");
  $this->load->library('ciqrcode');
  $qr_image=$uuid.'.png';
  $params['data'] = SITE_URL."guest-checkin/".$uuid;
  $params['level'] = 'H';
  $params['size'] = 8;
  $qr_image = $params['savename'] ="./uploads/qr_image/".$qr_image;
  $this->ciqrcode->generate($params);

  $company = $this->db->where("uuid",$uuid)->get("users")->row();

  // print_r($company); die();

  $this->load->helper('download');
  $this->html2pdf->folder('./uploads/pdf/');


  $data['company'] = $this->quotemodel->getCompanyDetails($company->userid);
  $content = $this->load->view('qr_code', $data, true); 
  
  $file = $company->company_name.'.pdf';
  $this->html2pdf->filename($file);
  $this->html2pdf->paper('a4', 'potrait');
  $this->html2pdf->html($content);
  $this->html2pdf->create('save');
  $file = "./uploads/pdf/".$file;

  $filename = "./uploads/pdf/".$company->company_name.'.pdf';

  header("Content-Length: " . filesize($filename));
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename='.$company->company_name.'.pdf');

  readfile($filename);
}

}