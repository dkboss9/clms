<?php
class Appointment extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('appointmentmodel');
        $this->load->model('users/usermodel');
        $this->load->model('project/projectmodel');
        $this->load->model('customer/customermodel');
        $this->load->model('database/databasemodel');
        $this->load->model('inquiry/inquirymodel');
        $this->load->model('doc_type/doc_typemodel');
        $this->load->model('download/downloadmodel');
        $this->load->model('salerep/salerepmodel');
        $this->module_code = 'appointment';
        $this->load->library('html2pdf');

    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('dashboard/appointment', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {

            if($this->input->get("handle"))
                $handle = $this->input->get("handle");
            else
                $handle = "";
            $data["search_handle"] = $handle;
            if($this->input->get("country"))
                $country = $this->input->get("country");
            else
                $country = "";
            $data["search_country"] = $country;
            if($this->input->get("weightage"))
                $weightage = $this->input->get("weightage");
            else
                $weightage = "";
            $data["search_weightage"] = $weightage;
            if($this->input->get("status"))
                $status = $this->input->get("status");
            else
                $status = "";
            $data["search_status"] = $status;
            if($this->input->get("category"))
                $category = $this->input->get("category");
            else
                $category = "";
            $data["search_category"] = $category;
            if($this->input->get("access"))
                $access = $this->input->get("access");
            else
                $access = "";
            $data["search_access"] = $access;
            if($this->input->get("language"))
                $language = $this->input->get("language");
            else
                $language = "";
            if($this->input->get("lead_date"))
                $lead_date = $this->input->get("lead_date");
            else
                $lead_date = "";

            if($this->input->get("added_date"))
                $added_date = $this->input->get("added_date");
            else
                $added_date = "";


            $data["search_language"] = $language;
            $query = $this->appointmentmodel->listall($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
            $data["leads"] = $query;

            $data['languages']      = $this->appointmentmodel->get_languages();
            $data['countries']      = $this->appointmentmodel->get_country();
            $data['chats']      = $this->appointmentmodel->get_chatType();
            $data['category']      = $this->appointmentmodel->get_category();
            $data['access']      = $this->appointmentmodel->get_access();
            $data['users']      = $this->appointmentmodel->get_users();
            $data['weightage']      = $this->appointmentmodel->get_leadweightage();
            $data['status']      = $this->appointmentmodel->get_leadstatus();

            
            $data['heading']        = 'Newsletters';
        //$data['pagenumbers'] 	= $string;
        //$data['newsletter'] 	= $newsletter;
            //$data['pagination'] 	= $this->pagination->create_links();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function callendar(){
        if($this->input->post("submit")){
           if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
            redirect($_SERVER["HTTP_REFERER"],"refresh");
        }
        $userdata = $this->session->userdata("clms_front_userid");
        $date = date("Y-m-d");
        $data_post = $_POST;
        $data['values']['form_post']   = serialize($data_post);
        $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
        $data['values']['user_id']       = $this->input->post('user');
        $data['values']['lead_name']        = $this->input->post('name');
        $data['values']['lead_lname']        = $this->input->post('lname');
        $data['values']['email']            = $this->input->post('email');
        $data['values']['phone_number']              = $this->input->post('phone');
        $data['values']['purpose']              = $this->input->post('purpose');
        $data['values']['about_us']              = $this->input->post('about_us');
        $data['values']['is_booked']              = 1;
        $data['values']['from_nepal']              = $this->input->post("from_nepal");
        $dates = $this->input->post('booking_date');
        $dates = explode("/", $dates);
        $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
        $data['values']['booking_date']              = date("Y-m-d",strtotime($date));
        $data['values']['booking_time']              =  $this->input->post('booking_time');
        $data['values']['country']              = $this->input->post('country');
        $data['values']['requirements']              = $this->input->post('requirement');
        $data['values']['lead_source']              = $this->input->post('lead_source');

        $data['values']['referral']              = $this->input->post('referral');
        $data['values']['status_id']              = 5;

           // $data['values']['user_id']              = $userdata;
        $data['values']['added_by']                 = $userdata;
        $data['values']['added_date']           = time();
        $data['values']['modified_by']              = $userdata;
        $data['values']['status']                   = 1;
        $this->appointmentmodel->add($data['values']);
        $leadid = $this->db->insert_id();

        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Add",
            "module" => "Manage Lead",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->session->set_flashdata('success_message', 'Appointment added successfully');
        redirect("appointment/callendar");
    }else{
        if($this->input->get("handle"))
            $handle = $this->input->get("handle");
        else
            $handle = "";
        $data["search_handle"] = $handle;
        if($this->input->get("country"))
            $country = $this->input->get("country");
        else
            $country = "";
        $data["search_country"] = $country;
        if($this->input->get("weightage"))
            $weightage = $this->input->get("weightage");
        else
            $weightage = "";
        $data["search_weightage"] = $weightage;
        if($this->input->get("status"))
            $status = $this->input->get("status");
        else
            $status = "";
        $data["search_status"] = $status;
        if($this->input->get("category"))
            $category = $this->input->get("category");
        else
            $category = "";
        $data["search_category"] = $category;
        if($this->input->get("access"))
            $access = $this->input->get("access");
        else
            $access = "";
        $data["search_access"] = $access;
        if($this->input->get("language"))
            $language = $this->input->get("language");
        else
            $language = "";
        if($this->input->get("lead_date"))
            $lead_date = $this->input->get("lead_date");
        else
            $lead_date = "";

        if($this->input->get("added_date"))
            $added_date = $this->input->get("added_date");
        else
            $added_date = "";


        $data["search_language"] = $language;
        $query = $this->appointmentmodel->listall($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
        $data["leads"] = $query;

        $data['countries']      = $this->appointmentmodel->get_country();
        $data['about_us']      = $this->appointmentmodel->about_us();
        $data['purpose']      = $this->appointmentmodel->get_purpose();
        $data['source']      = $this->appointmentmodel->get_source();
        $data['status']      = $this->appointmentmodel->get_leadstatus();
        $data['users']      = $this->appointmentmodel->get_users();


        $data['heading']        = 'Newsletters';
        $data['page']           = 'callendar';
        $this->load->vars($data);
        $this->load->view($this->container);
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
        $data_post = $_POST;
        $data['values']['form_post']   = serialize($data_post);
        $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
        $data['values']['user_id']       = $this->input->post('user');
        $data['values']['student_id']       = $this->input->post('student_id');
        $data['values']['lead_name'] 		= $this->input->post('name');
        $data['values']['lead_lname']        = $this->input->post('lname');
        $data['values']['email'] 			= $this->input->post('email');
        $data['values']['phone_number']              = $this->input->post('phone');
        $data['values']['purpose'] 				= $this->input->post('purpose');
        $data['values']['about_us']              = $this->input->post('about_us');
        $data['values']['is_booked']              = 1;
        $data['values']['from_nepal']              = $this->input->post("from_nepal");
        $dates = $this->input->post('booking_date');
       
        $data['values']['booking_date']              = date("Y-m-d",strtotime($dates));
        $data['values']['booking_time']              =  $this->input->post('booking_time');
        $data['values']['country']              = $this->input->post('country')??$this->input->post('country1');
        $data['values']['state']              = $this->input->post('state');
        $data['values']['requirements']              = $this->input->post('requirement');
        $data['values']['lead_source']              = $this->input->post('lead_by');
        $data['values']['note']              = $this->input->post('note');
        $date = $this->input->post('redminder_date');
        
        $data['values']['reminder_date']              = strtotime($date);
        $data['values']['reminder_time']              = $this->input->post("reminder_time");
        $data['values']['consultant']              = $this->input->post('counseller');
        $data['values']['referral']              = $this->input->post('referral');
        if($this->input->post("counceling") == 1)
        $data['values']['status_id']              = 6;
        else
        $data['values']['status_id']              = 5;

        // $data['values']['user_id']              = $userdata;
        $data['values']['added_by'] 				= $userdata;
        $data['values']['added_date'] 			= time();
        $data['values']['modified_by'] 				= $userdata;
        $data['values']['status'] 					= 1;
        $this->appointmentmodel->add($data['values']);
        $leadid = $this->db->insert_id();

        if($this->input->post('status_update') !=""){
            $data['update']['content']              = $this->input->post('status_update');
            $data['update']['lead_id']                 = $leadid;
            $data['update']['added_by']                 = $userdata;
            $data['update']['added_date']           = time();
            $data['update']['modified_by']              = $userdata;
            $data['update']['modified_date']              = time();
            $this->appointmentmodel->addstatus($data['update']);
        }

            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Lead",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);

            $customer_id = $this->input->post('counseller');
            /************* send activation email to customer ************/
            if($customer_id > 0 && $this->input->post("send_email")){
                $rcust    = $this->appointmentmodel->get_userdetails($customer_id);
                $customer = $rcust->first_name.' '.$rcust->last_name;   
                $from     = $this->mylibrary->getSiteEmail(32);
                $site_url = $this->mylibrary->getSiteEmail(21);
                $fromname = $this->mylibrary->getSiteEmail(20);
                $address  = $this->mylibrary->getSiteEmail(25);
                $phone    = $this->mylibrary->getSiteEmail(27);
                $fax      = $this->mylibrary->getSiteEmail(28);
                $sitemail = $this->mylibrary->getSiteEmail(23);

                $this->load->model("quote/quotemodel");
                $company = $this->quotemodel->getCompanyDetails($this->session->userdata("clms_front_companyid"));

                if($company->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$company->thumbnail)){
                    $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
                }else{
                    $logo = '';
                }
                $this->email->set_mailtype('html');
                $this->email->from($sitemail, "Lead Management System");
                $this->email->to($this->input->post("email"));
                $row = $this->mylibrary->getCompanyEmailTemplate(2,$this->session->userdata("clms_front_companyid"));
              
                $subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
                $this->email->subject($subject);
                $message = str_replace('[NAME]',$customer,html_entity_decode($row->email_message,ENT_COMPAT));
                $message = str_replace('[SITE_NAME]',$fromname,$message);
                $message = str_replace('[LOGO]',$logo,$message);
                $message = str_replace('[SITE_ADDRESS]',$address,$message);
                $message = str_replace('[SITE_PHONE]',$phone,$message);
                $message = str_replace('[SITE_FAX]',$fax,$message);
                $message = str_replace('[SITE_EMAIL]',$sitemail,$message);
                $message = str_replace('[SITE_URL]',$site_url,$message);
                $message = str_replace('[LEAD_NAME]',$this->input->post('name'),$message);
                $message = str_replace('[LEAD_DETAILS]',$this->input->post('requirement'),$message);
                $message = str_replace('[YEAR]',date('Y'),$message);

              
                $message = str_replace('[COMPANY_NAME]',@$company->company_name,$message);
                $message = str_replace('[COMPANY_ADDRESS]',@$company->address,$message);

                $this->email->message($message);
              //  $this->email->send();
                $this->email->clear();

                $this->load->model("sms/smsmodel");

                $query = $this->smsmodel->getdata($this->session->userdata("clms_front_userid"));
                $sms_setting  = $query->row();
                
              

                if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1 && $sms_setting->balance_sms??0 > 0){
                    $sms = $row->sms_text;
                    $sms = str_replace('[COMPANY_NAME]', $company->company_name, html_entity_decode($sms, ENT_COMPAT));
                    $sms = str_replace('[NAME]', $customer, $sms);
                    $sms = str_replace('[SITE_NAME]', $fromname, $sms);
                    $sms = str_replace('[LEAD_NAME]', $this->input->post('name'), $sms);
                    $sms = str_replace('[LEAD_DETAILS]', $this->input->post('requirement'), $sms);
                    $sms = str_replace('[YEAR]', date('Y'), $sms);
                    $sms = str_replace('[LOGO]', $logo, $sms);
                    $sms = str_replace('[SITE_URL]', SITE_URL, $sms);
                    $sms = str_replace('[SITE_ADDRESS]', $company->mail_to_address, $sms);
                    $sms = str_replace('[SITE_EMAIL]', $company->email , $sms);
                    $sms = str_replace('[SITE_PHONE]', $company->phone, $sms);
                    $sms = str_replace('[SITE_FAX]', $fax, $sms);
                    $sms = str_replace('[EMAIL]', $company->email, $sms);
                    $sms = str_replace('[YEAR]', date('Y'), $sms);
        
                    $mobile = $rcust->mobile;
                    if($mobile != ""){
                        $this->commonmodel->printsms($sms,$mobile,$sms_setting->sms_from);
                        $this->commonmodel->calculate_smsBalance($this->session->userdata("clms_front_userid"));
                    }
        
                   
                }
                /***** Sms code ******/
        
            }

            $this->session->set_flashdata('success_message', 'Appointment added successfully');
            if($this->input->post("student_id") > 0)
            redirect('project/appointments/'.$this->input->post("student_id"));
            else{
                if($this->input->post("counceling") == 1)
                redirect('dashboard/counselling');
                else
                redirect('dashboard/appointment');
            }
           
        } else {
            if($this->uri->segment(3)){
                $dbid = $this->uri->segment(3);
                $data["db"] = $this->databasemodel->getdata($dbid)->row();
            }

            if($this->input->get("inquiry_id"))
               $data["db"] = $this->inquirymodel->getdata($this->input->get("inquiry_id"))->row();


           $data['countries']      = $this->appointmentmodel->get_country();
           $data['about_us']      = $this->appointmentmodel->about_us();
           $data['purpose']      = $this->appointmentmodel->get_purpose();
           $data['source']      = $this->appointmentmodel->get_source();
           $data['status']      = $this->appointmentmodel->get_leadstatus();
           $data['users']      = $this->appointmentmodel->get_users();
           $data['lead_types'] = $this->salerepmodel->get_leadType();
           $data['counselers'] = $this->projectmodel->get_empoyee();
           if($this->input->get("tab") == 'counselling')
                $data['page'] = 'add_counselling';
           else
                $data['page'] = 'add';
           $data['heading'] = 'Add Leads';
           $this->load->vars($data);
           $this->load->view($this->container);

       }
   } else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
}
}

function getstates(){
    $country = $this->input->post("country_id");
    $state = $this->input->post("state");
    $this->db->where("country_id",$country);
    $states = $this->db->get("pnp_states")->result();
    foreach($states as $row){
        $selected = $state == $row->state_name ? 'selected' : '';
        echo '<option value="'.$row->state_name.'" '.$selected.'>'.$row->state_name.'</option>';
    }
}

function project(){
    if($this->input->post("project_type") && $this->input->post("project_type") == "new_project")
      $this->form_validation->set_rules('email', 'Email', 'required|is_unique[customers.email]');
  else
    $this->form_validation->set_rules('customer', 'Customer', 'required');

if ($this->form_validation->run() == FALSE){
    $lead_id = $this->uri->segment(3);
    $data['result'] = $this->appointmentmodel->getdata($lead_id)->row();
    $data['countries'] = $this->customermodel->getcoutries();
    $data['states'] = $this->customermodel->getstates();
    $data['category']      = $this->appointmentmodel->get_category(0);
    $data['customer']      = $this->projectmodel->get_customer();
    $data['project_status'] = $this->projectmodel->getStatus();
    $data['gst'] = $this->generalsettingsmodel->getConfigData(53)->row();
    $data['lead_types']      = $this->appointmentmodel->get_leadTypes();
    $data['users']      = $this->appointmentmodel->get_users();
    $data['page'] = 'project';
    $data['heading'] = 'Add Project';
    $this->load->vars($data);
    $this->load->view($this->container);
}else{
 if($this->input->post("project_type") && $this->input->post("project_type") == "new_project"){
    $type = $this->input->post('lead_type');
    $sales_rep = $this->input->post('user');
    $rate = $this->projectmodel->getRate($type,$sales_rep);
    $price = $this->input->post('price');
    $commission = ($rate*$price)/100;
    $userdata = $this->session->userdata("clms_front_userid");
    $date = date("Y-m-d");
    $data['customer']['customer_name']    = $this->input->post('customer_name');
    $data['customer']['company_name']    = $this->input->post('company_name');
    $data['customer']['contact_number']    = $this->input->post('contact_number');
    $data['customer']['email']    = $this->input->post('email');
    $data['customer']['billing_address1']    = $this->input->post('bill_address_1');
    $data['customer']['billing_address2']    = $this->input->post('bill_address_2');
    $data['customer']['billing_suburb']    = $this->input->post('bill_suburb');
    $data['customer']['billing_state']    = $this->input->post('bill_state');
    $data['customer']['billing_postcode']    = $this->input->post('bill_postcode');
    $data['customer']['billing_country']    = $this->input->post('bill_country');
    $data['customer']['delivery_address1']    = $this->input->post('delivery_address_1');
    $data['customer']['delivery_address2']    = $this->input->post('delivery_address_2');
    $data['customer']['delivery_suburb']    = $this->input->post('delivery_suburb');
    $data['customer']['delivery_state']    = $this->input->post('delivery_state');
    $data['customer']['delivery_postcode']    = $this->input->post('delivery_postcode');
    $data['customer']['delivery_country']    = $this->input->post('delivery_country');
    $data['customer']['added_date']       = time();
    $data['customer']['added_by']         = $userdata;
    $data['customer']['status']      = 1;
    $this->customermodel->add($data['customer']);
    $customer_id = $this->db->insert_id();

    $data['values']['project_title']              = $this->input->post('title');
    $data['values']['lead_type']              = $this->input->post('lead_type');
    $data['values']['sales_rep']              = $this->input->post('user');
    $data['values']['category']              = $this->input->post('category');
    $data['values']['subcategory']              = $this->input->post('sub_category');
    $data['values']['subcategory2']              = $this->input->post('sub_category2');
    $data['values']['subcategory3']              = $this->input->post('sub_category3');
    $data['values']['subcategory4']              = $this->input->post('sub_category4');

    $data['values']['customer_id']    = $customer_id;
    $data['values']['description']    = $this->input->post('description');
    $data['values']['note']    = $this->input->post('note');
    $data['values']['price']    = $this->input->post('price');
    $data['values']['gst']    = $this->input->post('gst');
    $data['values']['total']    = $this->input->post('total');
    $data['values']['shipping']    = $this->input->post('shipping');
    $data['values']['grand_total']    = $this->input->post('grand');
    $data['values']['project_status']    = $this->input->post('project_status');
    $data['values']['commission_rate']    = $rate;
    $data['values']['commission']    = $commission;


    $dates = $this->input->post('start_date');
    $dates = explode("/", $dates);
    $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
    $data['values']['start_date']   = strtotime($date);
    $dates1 = $this->input->post('end_date');
    $dates1 = explode("/", $dates1);
    $date1 = $dates1[1].'/'.$dates1[0].'/'.$dates1[2]; 
    $data['values']['end_date']   = strtotime($date1);

    $data['values']['added_date']       = time();
    $data['values']['added_by']         = $userdata;
    $data['values']['status']      = 1;
    $this->projectmodel->add($data['values']);
    $id = $this->db->insert_id();
    $this->db->where("project_id",$id);
    $this->db->set("order_no",1000+$id);
    $this->db->update("projects");
}else{

    $type = $this->input->post('lead_type');
    $sales_rep = $this->input->post('user');
    $rate = $this->projectmodel->getRate($type,$sales_rep);
    $price = $this->input->post('price');
    $commission = ($rate*$price)/100;
    $userdata = $this->session->userdata("clms_front_userid");
    $data['values']['project_title']              = $this->input->post('title');
    $data['values']['lead_type']              = $this->input->post('lead_type');
    $data['values']['sales_rep']              = $this->input->post('user');
    $data['values']['category']              = $this->input->post('category');
    $data['values']['subcategory']              = $this->input->post('sub_category');
    $data['values']['subcategory2']              = $this->input->post('sub_category2');
    $data['values']['subcategory3']              = $this->input->post('sub_category3');
    $data['values']['subcategory4']              = $this->input->post('sub_category4');

    $data['values']['customer_id']    = $this->input->post('customer');
    $data['values']['description']    = $this->input->post('description');
    $data['values']['note']    = $this->input->post('note');
    $data['values']['price']    = $this->input->post('price');
    $data['values']['gst']    = $this->input->post('gst');
    $data['values']['total']    = $this->input->post('total');
    $data['values']['shipping']    = $this->input->post('shipping');
    $data['values']['grand_total']    = $this->input->post('grand');
    $data['values']['project_status']    = $this->input->post('project_status');
    $data['values']['commission_rate']    = $rate;
    $data['values']['commission']    = $commission;


    $dates = $this->input->post('start_date');
    $dates = explode("/", $dates);
    $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
    $data['values']['start_date']   = strtotime($date);
    $dates1 = $this->input->post('end_date');
    $dates1 = explode("/", $dates1);
    $date1 = $dates1[1].'/'.$dates1[0].'/'.$dates1[2]; 
    $data['values']['end_date']   = strtotime($date1);

    $data['values']['added_date']       = time();
    $data['values']['added_by']         = $userdata;
    $data['values']['status']      = 1;
    $this->projectmodel->add($data['values']);
    $id = $this->db->insert_id();
    $this->db->where("project_id",$id);
    $this->db->set("order_no",1000+$id);
    $this->db->update("projects");
}
$this->session->set_flashdata('success_message', 'Project added successfully');
redirect('project/listall');
}
}

function get_customerDetails(){
    $customer_id = $this->input->post("customerid");
    $this->db->where("customer_id",$customer_id);
    $query =  $this->db->get("customers");
    if($query->num_rows() > 0){
        $row = $query->row();
        echo 'Email: '.$row->email.' Contact Number:'.$row->contact_number;
    }

}

function get_subcategory(){
    $catid = $this->input->post("catid");
    $cats = $this->appointmentmodel->get_category($catid);
    if(count($cats) > 0){
        ?>
        <option value="">Select</option>
        <?php
        foreach ($cats as $cat) {
            ?>
            <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
            <?php 
        }
    }
}

function counselling(){
    if($this->input->post("submit")){ 
        $leadid = $this->input->post("lead_id");
        if($this->input->post("chk_option")){
            $fees = $this->input->post("chk_option");
            foreach ($fees as $key => $value) {
               if($this->appointmentmodel->checkfee($leadid,$value) == 0){
                $this->db->set("lead_id",$leadid);
                $this->db->set("fee_id",$value);
                $this->db->insert("fav_course_fee");
            }
        }
    }

  /*  $this->db->where("lead_id",$leadid);
    $this->db->set("status_id",6);
    $this->db->update("leads");*/

    redirect($_SERVER["HTTP_REFERER"]);

}else{
    if($this->input->get("country"))
        $country = $this->input->get("country");
    else
        $country = '';
    $data['search_country'] = $country;

    if($this->input->get("intake"))
        $intake = $this->input->get("intake");
    else
        $intake = '';
    $data['search_intake'] = $intake;

    if($this->input->get("college"))
        $college = $this->input->get("college");
    else
        $college = '';
    $data['search_college'] = $college;

    if($this->input->get("degree"))
        $degree = $this->input->get("degree");
    else
        $degree = '';
    $data['search_degree'] = $degree;

    if($this->input->get("course"))
        $course = $this->input->get("course");
    else
        $course = '';
    $data['search_course'] = $course;


    $data['countries']      = $this->appointmentmodel->get_country();
    $data['courses']      = $this->appointmentmodel->get_Courses();
    $data['intakes']      = $this->appointmentmodel->get_Intakes();
    $data['colleges']      = $this->appointmentmodel->get_Colleges();
    $data['degrees']      = $this->appointmentmodel->get_Degrees();
    if($this->input->get("submit"))
        $data['counsells']      = $this->appointmentmodel->get_Counselling($country, $intake, $college, $degree, $course);
    else
        $data['counsells']= array();

    $id = $this->uri->segment(3);
    $query = $this->appointmentmodel->getdata($id);
    if ($query->num_rows() > 0) {
        $data['favourites']      = $this->appointmentmodel->get_favCounselling($id);
        $data['result']     = $query->row();
        $data['page']       = 'counselling';
        $data['heading']    = 'Edit Leads';
        $this->load->view('main', $data);
    } else {
        redirect('dashboard/appointment');
    }
}
}


function add_update(){
    if($this->input->post("submit")){
        $this->load->model("lms/lmsmodel");
        $lead_id = $this->input->post("lead_id");
        
        $data['values']['reminder_date']              = strtotime($this->input->post('date'));
        $data['values']['reminder_time']              = $this->input->post("time");
        if($this->input->post('user'))
            $data['values']['user_id']              = $this->input->post('user');
        $data['values']['weightage_id']              = $this->input->post('weightage');
        $data['values']['status_id']              = $this->input->post('status');
        $data['values']['remark']              = $this->input->post('remark');
        $data['values']['next_action']              = $this->input->post('action');
        $data['values']['modified_by']              = $this->session->userdata("clms_front_userid");
            //$data['values']['modified_date']              = time();
        $this->lmsmodel->update($lead_id, $data['values']);
        $task = array(
            "lead_id" => $lead_id,
            "content" => $this->input->post("details123"),
            "added_date" => time(),
            "added_by" => $this->session->userdata("clms_front_userid")
            );
        $this->db->insert("lead_update",$task);
        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Add Update",
            "module" => "Manage Lead",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $users = array();
        $task_user = $this->lmsmodel->getdata($this->input->post("lead_id"))->row();

        array_push($users, $task_user->user_id);
        array_push($users, $task_user->added_by);

        $users_update = $this->lmsmodel->getleadusers($this->input->post("lead_id"));
        foreach ($users_update as $row) {
            array_push($users, $row->added_by);
        }
        $users = array_unique($users);

        $emailcus    = $this->lmsmodel->get_userdetails($this->session->userdata("clms_front_userid"));
        if($this->input->post('user')){
            foreach ($users as $key => $value) {
               //$customer_id = $this->input->post('assign_to');
               /************* send activation email to customer ************/
               $rcust    = $this->lmsmodel->get_userdetails($value);
               if( !empty($rcust)){
               $customer = $rcust->first_name.' '.$rcust->last_name;   
               $from     = $this->mylibrary->getSiteEmail(32);
               $site_url = $this->mylibrary->getSiteEmail(21);
               $fromname = $this->mylibrary->getSiteEmail(20);
               $address  = $this->mylibrary->getSiteEmail(25);
               $phone    = $this->mylibrary->getSiteEmail(27);
               $fax      = $this->mylibrary->getSiteEmail(28);
               $sitemail = $this->mylibrary->getSiteEmail(23);
               $this->load->model("quote/quotemodel");
               $company = $this->quotemodel->getCompanyDetails($this->session->userdata("clms_front_companyid"));

               if($company->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$company->thumbnail)){
                $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
                }else{
                    $logo = '';
                }
               $this->email->set_mailtype('html');
               $this->email->from($sitemail, "Lead Management System");
               $this->email->to($rcust->email);
              
               $row = $this->mylibrary->getCompanyEmailTemplate(3,$this->session->userdata("clms_front_companyid"));
               $subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
               $this->email->subject($subject);
               $message = str_replace('[NAME]',$customer,html_entity_decode($row->email_message,ENT_COMPAT));
               $message = str_replace('[USER_NAME]',$emailcus->first_name.' '.$emailcus->last_name,$message);
               $message = str_replace('[SITE_NAME]',$fromname,$message);
               $message = str_replace('[LOGO]',$logo,$message);
               $message = str_replace('[SITE_ADDRESS]',$address,$message);
               $message = str_replace('[SITE_PHONE]',$phone,$message);
               $message = str_replace('[SITE_FAX]',$fax,$message);
               $message = str_replace('[SITE_EMAIL]',$sitemail,$message);
               $message = str_replace('[SITE_URL]',$site_url,$message);
               $message = str_replace('[TODAY_STATUS]',$this->input->post("details123"),$message);
               //$message = str_replace('[TASK_DETAIL]',$this->input->post('details'),$message);
               $message = str_replace('[YEAR]',date('Y'),$message);

               $message = str_replace('[COMPANY_NAME]',@$company->company_name,$message);
               $message = str_replace('[COMPANY_ADDRESS]',@$company->address,$message);

               $this->email->message($message);
               $this->email->send();
               $this->email->clear();

               $this->load->model("sms/smsmodel");

               $query = $this->smsmodel->getdata($this->session->userdata("clms_front_userid"));
               $sms_setting  = $query->row();
               
             

               if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1 && $sms_setting->balance_sms??0 > 0){
                   $sms = $row->sms_text;
                   $sms = str_replace('[NAME]',$customer,html_entity_decode($sms,ENT_COMPAT));
                   $sms = str_replace('[USER_NAME]',$emailcus->first_name.' '.$emailcus->last_name,$sms);
                   $sms = str_replace('[SITE_NAME]',$fromname,$sms);
                   $sms = str_replace('[LOGO]',$logo,$sms);
                   $sms = str_replace('[SITE_ADDRESS]',$address,$sms);
                   $sms = str_replace('[SITE_PHONE]',$phone,$sms);
                   $sms = str_replace('[SITE_FAX]',$fax,$sms);
                   $sms = str_replace('[SITE_EMAIL]',$sitemail,$sms);
                   $sms = str_replace('[SITE_URL]',$site_url,$sms);
                   $sms = str_replace('[TODAY_STATUS]',$this->input->post("details123"),$sms);
                   //$message = str_replace('[TASK_DETAIL]',$this->input->post('details'),$message);
                   $sms = str_replace('[YEAR]',date('Y'),$sms);
    
                   $sms = str_replace('[COMPANY_NAME]',@$company->company_name,$sms);
                   $sms = str_replace('[COMPANY_ADDRESS]',@$company->address,$sms);
       
                   $mobile = $rcust->mobile;
                   if($mobile != ""){
                       $this->commonmodel->printsms($sms,$mobile,$sms_setting->sms_from);
                       $this->commonmodel->calculate_smsBalance($this->session->userdata("clms_front_userid"));
                   }
       
                  
               }
               /***** Sms code ******/
           }
        }
       }
       $this->session->set_flashdata('success_message', 'Update has been successfully Added.');
       if($this->input->post('tab') == 'counselling')
         redirect('dashboard/counselling');
       else
        redirect($_SERVER['HTTP_REFERER']);
   }
}

function make_selected($leadid,$fee_id){
    $this->db->where("lead_id",$leadid);
    $this->db->set("destinated_option",'0');
    $this->db->update("fav_course_fee");

    $this->db->where("lead_id",$leadid);
    $this->db->where("fee_id",$fee_id);
    $this->db->set("destinated_option",'1');
    $this->db->update("fav_course_fee");
    redirect($_SERVER["HTTP_REFERER"]);
}

function remove_selected($leadid,$fee_id){
    $this->db->where("lead_id",$leadid);
    $this->db->where("fee_id",$fee_id);
    $this->db->set("destinated_option",'0');
    $this->db->update("fav_course_fee");
    redirect($_SERVER["HTTP_REFERER"]);
}

function make_favourite(){
    $leadid = $this->input->post("lead_id");
    $fee_id = $this->input->post("fee_id");

    /*$this->db->where("lead_id",$leadid);
    $this->db->set("status_id",6);
    $this->db->update("leads");*/

    if($this->appointmentmodel->checkfee($leadid,$fee_id) == 0){
        $this->db->set("lead_id",$leadid);
        $this->db->set("fee_id",$fee_id);
        $this->db->insert("fav_course_fee");
    }
    $data['favourites']      = $this->appointmentmodel->get_favCounselling($leadid);
    echo $this->load->view("favourite",$data,true);

}

function remove_favourite(){
    $leadid = $this->input->post("lead_id");
    $fee_id = $this->input->post("fee_id");
    $this->db->where("fee_id",$fee_id);
    $this->db->where("lead_id",$leadid);
    $this->db->delete("fav_course_fee");
}


    //---------------------------------edit--------------------------------------

function edit_appointment(){
    if ($this->input->post('submit')) {
        $id = $this->input->post('lead_id');
        $userdata = $this->session->userdata("clms_front_userid");
        $date = date("Y-m-d");
        $data_post = $_POST;
        $data['values']['form_post']   = serialize($data_post);
        $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
           // $data['values']['user_id']       = $this->input->post('user');
        $data['values']['lead_name']        = $this->input->post('name');
        $data['values']['lead_lname']        = $this->input->post('lname');
        $data['values']['email']            = $this->input->post('email');
        $data['values']['phone_number']              = $this->input->post('phone');
        $data['values']['purpose']              = $this->input->post('purpose');
           // $data['values']['about_us']              = $this->input->post('about_us');
            //$data['values']['is_booked']              = $this->input->post('conselling');
        $data['values']['from_nepal']              = $this->input->post("from_nepal");
        $date = $this->input->post('booking_date');
    
        $data['values']['booking_date']              = date("Y-m-d",strtotime($date));
        $data['values']['booking_time']              =  $this->input->post('booking_time');
        if($this->input->post("from_nepal") == 1)
            $data['values']['country']              = $this->input->post('country');
        else
            $data['values']['country']              = $this->input->post('country1');

            $data['values']['state']              = $this->input->post('state');

        $data['values']['consultant']              =  $this->input->post('counseller');

        $data['values']['added_by']                 = $userdata;
        $data['values']['added_date']           = time();
        $data['values']['modified_by']              = $userdata;
           // $data['values']['status']                   = 1;
        $this->appointmentmodel->update($id, $data['values']);

        $leadid = $id;
        if($this->input->post('status_update') !=""){
            $data['update']['content']              = $this->input->post('status_update');
            $data['update']['lead_id']                 = $leadid;
            $data['update']['added_by']                 = $userdata;
            $data['update']['added_date']           = time();
            $data['update']['modified_by']              = $userdata;
            $data['update']['modified_date']              = time();
            $this->appointmentmodel->addstatus($data['update']);
        }

        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Edit",
            "module" => "Manage Lead",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->session->set_flashdata('success_message', 'Appointment Edited Successfully');
        redirect('appointment/callendar');
    }else{
        $id = $this->input->post("appid");
        $data['countries']      = $this->appointmentmodel->get_country();
        $data['about_us']      = $this->appointmentmodel->about_us();
        $data['purpose']      = $this->appointmentmodel->get_purpose();
        $data['source']      = $this->appointmentmodel->get_source();
        $data['status']      = $this->appointmentmodel->get_leadstatus();
        $data['users']      = $this->appointmentmodel->get_users();


        $query = $this->appointmentmodel->getdata($id);
        $data['result']     = $query->row();
        echo $this->load->view('edit_callendar', $data,true);
    }

}
function edit() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            
            $id = $this->input->post('lead_id');
            $userdata = $this->session->userdata("clms_front_userid");
            $date = date("Y-m-d");
            $data_post = $_POST;
            $data['values']['form_post']   = serialize($data_post);
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['lead_name']        = $this->input->post('name');
            $data['values']['lead_lname']        = $this->input->post('lname');
            if($this->input->post("tab")){
            $data['values']['email']            = $this->input->post('email');
            $data['values']['phone_number']              = $this->input->post('phone');
            $data['values']['purpose']              = $this->input->post('purpose');
            $data['values']['from_nepal']              = $this->input->post("from_nepal");
            $date = $this->input->post('booking_date');
            $data['values']['booking_date']              = date("Y-m-d",strtotime($date));
            $data['values']['booking_time']              =  $this->input->post('booking_time');
            if($this->input->post("from_nepal") == 1)
                $data['values']['country']              = $this->input->post('country');
            else
                $data['values']['country']              = $this->input->post('country1');
    
                $data['values']['state']              = $this->input->post('state');
            }else{

                $data['values']['email']            = $this->input->post('email');
                $data['values']['phone_number']              = $this->input->post('phone');
                $date = $this->input->post('booking_date');
                   
                $data['values']['booking_date']              = date("Y-m-d",strtotime($date));
                $data['values']['booking_time']              =  $this->input->post('booking_time');
                 
                $data['values']['country']              = $this->input->post('country');
                 
                $data['values']['lead_source']              = $this->input->post('lead_by');
                $data['values']['note']              = $this->input->post('note');
                $date = $this->input->post('redminder_date');
                
                $data['values']['reminder_date']              = strtotime($date);
                $data['values']['reminder_time']              = $this->input->post("reminder_time");
            }
            $data['values']['consultant']              =  $this->input->post('counseller');
                
            $data['values']['added_by']                 = $userdata;
            $data['values']['added_date']           = time();
            $data['values']['modified_by']              = $userdata;
               // $data['values']['status']                   = 1;
            $this->appointmentmodel->update($id, $data['values']);
    
            $leadid = $id;
            if($this->input->post('status_update') !=""){
                $data['update']['content']              = $this->input->post('status_update');
                $data['update']['lead_id']                 = $leadid;
                $data['update']['added_by']                 = $userdata;
                $data['update']['added_date']           = time();
                $data['update']['modified_by']              = $userdata;
                $data['update']['modified_date']              = time();
                $this->appointmentmodel->addstatus($data['update']);
            }
    
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Lead",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
      
            $this->session->set_flashdata('success_message', 'Appointment Edited Successfully');
            if($this->input->post("project") == 1 && $this->input->post("student_id"))
            redirect('project/appointments/'.$this->input->post("student_id"));
            else{
                if($this->input->post("tab")=='counselling'){
                    redirect('dashboard/counselling');
                }else{
                    redirect('dashboard/appointment');
                }
            }
            
        } else {
            $this->load->model("lms/lmsmodel");
            $data['countries']      = $this->appointmentmodel->get_country();
            $data['about_us']      = $this->appointmentmodel->about_us();
            $data['purpose']      = $this->appointmentmodel->get_purpose();
            $data['source']      = $this->appointmentmodel->get_source();
            $data['status']      = $this->appointmentmodel->get_leadstatus();
            $data['users']      = $this->appointmentmodel->get_users();
            $data['lead_types'] = $this->salerepmodel->get_leadType();
            $data['counselers'] = $this->projectmodel->get_empoyee();
         
            $id = $this->uri->segment(3);
            $query = $this->appointmentmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                if($this->input->get("tab") == 'counselling')
                $data['page'] 		= 'edit_counselling';
                else
                $data['page'] 		= 'edit';
                $data['booking_time_options'] = $this->lmsmodel->get_appointmenttimes($data['result'],$id);
                $data['heading'] 	= 'Edit Leads';
                $this->load->view('main', $data);
            } else {
                redirect('dashboard/appointment');
            }
        }
    }
}


    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("lead_id"=>$delid);
        $content = $this->usermodel->getDeletedData('leads',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->appointmentmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('dashboard/appointment');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

function delete_documents(){
    $imageid = $this->input->post("id");
    $this->db->where("doc_id",$imageid);
    $this->db->delete("lead_documents");
}

    //---------------------detail---------------------------------
function detail() {
       // if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
    if ($this->session->userdata("clms_front_userid") != "") {
        $data['tab'] = $this->input->get("tab")??"";
        $this->load->model("project/projectmodel");
        $data['users']      = $this->appointmentmodel->get_users();
        $data['weightage']      = $this->appointmentmodel->get_leadweightage();
        $data['leadstatus']      = $this->appointmentmodel->get_leadstatus();
        $data['employees'] = $this->projectmodel->get_empoyee();
        $id = $this->uri->segment(3);
        $query = $this->appointmentmodel->getdata($id);
        $data['result'] = $query->row();
        $this->load->model("lms/lmsmodel");
        $data['booking_time_options'] = $this->lmsmodel->get_appointmenttimes($data['result'],$id);
        $this->load->view('detail', $data);
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

function add_consultant($lead_id){
    if($this->input->post("submit")){
        $lead_id = $this->input->post("lead_id");


        $data['values']['status_id']              = $this->input->post('status');
        $data['values']['consultant']              = $this->input->post('consultant');
        $data['values']['modified_by']              = $this->session->userdata("clms_front_userid");
        if($this->input->post('booking_date')){
            $data['values']['booking_date']              = date("Y-m-d",strtotime($this->input->post('date')));
        }
        $data['values']['booking_time']              =  $this->input->post('time');
        $data['values']['is_booked'] = 1;
        $this->appointmentmodel->update($lead_id, $data['values']);
        $task = array(
            "lead_id" => $lead_id,
            "content" => $this->input->post("details123"),
            "added_date" => time(),
            "added_by" => $this->session->userdata("clms_front_userid")
            );
        $this->db->insert("lead_update",$task);
        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Add Update",
            "module" => "Manage Lead",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->session->set_flashdata('success_message', 'Appointment has been assigned successfully.');
        $lead = $this->appointmentmodel->getdata($lead_id)->row();
        if($this->input->post("project") > 0){
            redirect('project/appointments/'.$lead->student_id);
        }else{
            redirect('dashboard/appointment');
        }
    }else{
       $data['employees'] = $this->projectmodel->get_empoyee();
       $data['leadstatus']      = $this->appointmentmodel->get_leadstatus();
       $query = $this->appointmentmodel->getdata($lead_id);
       $data['result'] = $query->row();
       $this->load->view('add_consultant', $data);
   }

}

function download_form($fee_id){
   if ($this->session->userdata("clms_front_userid") != "") {
    $data['downloads']     = $this->appointmentmodel->listDownloadForm($fee_id);
    $this->load->view('download_form', $data);
} else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
}
}

function checklist($fee_id){
    if ($this->session->userdata("clms_front_userid") != "") {
        $data['checklist']      = $this->appointmentmodel->listChecklist($fee_id);
        $data['fee_id']      = $fee_id;
        $this->load->view('checklist', $data);
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

function download_checklist($fee_id){

   $this->load->helper('download');
   $this->html2pdf->folder('./uploads/pdf/');

   $data['checklist']      = $this->appointmentmodel->listChecklist($fee_id);
   $content = $this->load->view('pdf_chklist', $data, true);

   $file = "checklist.pdf";
   $this->html2pdf->filename($file);
   $this->html2pdf->paper('a4', 'potrait');
   $this->html2pdf->html($content);
   $this->html2pdf->create('save');


   $filename = "./uploads/pdf/".$file;

   header("Content-Length: " . filesize($filename));
   header('Content-Type: application/octet-stream');
   header('Content-Disposition: attachment; filename='.$file);

   readfile($filename);
}




function status_update(){
    $id = $this->input->post("leadid");
    $updates = $this->appointmentmodel->get_updates($id);
    if(count($updates) >0){
        foreach ($updates as $update) {
          echo '<p>'.$update->content.'</p>';
          echo '<p>Added by: '.$update->first_name.' '.$update->last_name.' at '.date("d/m/Y",$update->added_date).'</p>';
          echo '<hr>';
      }}else{
          echo "No Update added yet.";
      }
  }

  function lead_doc(){
   $id = $this->input->post("leadid");
   $docs = $this->appointmentmodel->get_documents($id);
   if(count($docs) >0){
    foreach ($docs as $doc) {
        echo '<p id="file_'.$doc->doc_id.'"><a href="'.SITE_URL.'uploads/leads/'.$doc->file_name.'" target="_blank">'.$doc->file_name.'</a></p>';
    }}else{
      echo "No Document added yet.";
  }
}

function cascadeAction() {
    $data = $_POST['object'];
    $ids = $data['ids'];
    $action = $data['action'];
    foreach ($ids as $key => $delid) {
       $cond = array("lead_id"=>$delid);
       $content = $this->usermodel->getDeletedData('leads',$cond);
       $logs = array(
        "content" => serialize($content),
        "action" => $action,
        "module" => "Manage Lead",
        "added_by" => $this->session->userdata("clms_front_userid"),
        "added_date" => time()
        );
       $this->usermodel->insertUserlog($logs); 
   }

   $query = $this->appointmentmodel->cascadeAction($ids, $action);
   $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
//echo $this->db->last_query();
   exit();
}

	//---------------------------------send--------------------------------------
function send() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('id');
            $userdata = $this->session->userdata("clms_front_userid");
            $date = date("Y-m-d");
            $send_to = $this->input->post('rdorec');
            $subscribers = '';
            $emaillist = '';
            switch($send_to){
             case "0":
             $query = $this->subscribermodel->listall(null,1);
             if ($query->num_rows() > 0) {
               foreach ($query->result() as $row):
                $subscribers .= $row->email_address .";";
            endforeach;
            $query->free_result();
        }
        break;
        case "1":
        $subscribers = $this->input->post('selected_subscriber');
        break;
        case "2":
        $emaillist = $this->input->post('chkemaillist');
        $len = count($emaillist);
        if($len>0)
           $subscribers = implode($emaillist, ";");
       default:
       break;

   }
   $custom_emails = $this->input->post('custom_emails');
   if($custom_emails)
     ($subscribers == '')? $subscribers .= $custom_emails. ";":$subscribers .= ";". $custom_emails;

 $subribers_email = explode(";", $subscribers);

 $query = $this->newslettermodel->getdata($id);	
 $row = $query->row();
 $site = $this->mylibrary->getSiteEmail(21);
 $this->load->library('email');				
 foreach($subribers_email as $email):
     $message = $row->newsletter_description;
 $message .= '<p>'.$this->mylibrary->getSiteEmail(21).' '.$this->mylibrary->getSiteEmail(25).'</p>
 <p>'.anchor($site.'unsubscribe?email='.$email.'&id='.$this->session->userdata('session_id'),'Unsubscribe').' from announcement emails?</p>';
 $this->email->from($this->mylibrary->getSiteEmail(22), $this->mylibrary->getSiteEmail(20));			
 $this->email->subject($row->newsletter_title);
 $this->email->message($message);
 $this->email->set_mailtype('html');	
 $this->email->to($email); 
 $this->email->send();
 $this->email->clear();
 endforeach;
 $this->session->set_flashdata('success', 'Newsletter Sent Successfully');
 redirect('newsletter/listall');
} else {
   redirect('newsletter/listall');
}
}
}

}