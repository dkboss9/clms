<?php
class Lms extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('lmsmodel');
        $this->load->model('users/usermodel');
        $this->load->model('project/projectmodel');
        $this->load->model('customer/customermodel');
        $this->load->model('database/databasemodel');
        $this->load->model('appointment/appointmentmodel');
        $this->load->model('inquiry/inquirymodel');
        $this->load->model('salerep/salerepmodel');
        $this->module_code = 'LEAD-MANAGEMENT';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('dashboard', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function assign_appointment($lead_id){
        if($this->input->post("submit")){
            $lead_id = $this->input->post("lead_id");

            if($this->input->post('booking_date') && $this->input->post('booking_date') != ''){
                $data['values']['booking_date']              = date("Y-m-d",strtotime($this->input->post('booking_date')));
            }
            $data['values']['booking_time']              = $this->input->post("booking_time");
            $data['values']['status_id']              = $this->input->post('status');
            $data['values']['consultant']              = $this->input->post('consultant');
            $data['values']['is_booked'] = 1;
            $data['values']['modified_by']              = $this->session->userdata("clms_userid");
            $this->lmsmodel->update($lead_id, $data['values']);
            $task = array(
                "lead_id" => $lead_id,
                "content" => $this->input->post("details123"),
                "added_date" => time(),
                "added_by" => $this->session->userdata("clms_userid")
                );
            $this->db->insert("lead_update",$task);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add Update",
                "module" => "Manage Lead",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Consultant has been successfully Added.');
            redirect('dashboard/appointment');
        }else{
           $data['employees'] = $this->projectmodel->get_empoyee();
           $data['leadstatus']      = $this->lmsmodel->get_leadstatus();
           $query = $this->lmsmodel->getdata($lead_id);
           $data['result'] = $query->row();
           $data['booking_time_options'] = $this->lmsmodel->get_appointmenttimes($data['result'],$lead_id);
           $this->load->view('assign_appointment', $data);
       }

   }

    //----------------------------------------listall--------------------------------------------------	
   function listall() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {

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
        $query = $this->lmsmodel->listall($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date);
        $data["leads"] = $query;

        $data['languages']      = $this->lmsmodel->get_languages();
        $data['countries']      = $this->lmsmodel->get_country();
        $data['chats']      = $this->lmsmodel->get_chatType();
        $data['category']      = $this->lmsmodel->get_category();
        $data['access']      = $this->lmsmodel->get_access();
        $data['users']      = $this->lmsmodel->get_users();
        $data['weightage']      = $this->lmsmodel->get_leadweightage();
        $data['status']      = $this->lmsmodel->get_leadstatus();


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

    //--------------------------------------add--------------------------------------	
function add() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
        if ($this->input->post('txt_submit')) {
           if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
            redirect($_SERVER["HTTP_REFERER"],"refresh");
        }
        $userdata = $this->session->userdata("clms_userid");
        $date = date("Y-m-d");
        $data_post = $_POST;
        $data['values']['form_post']   = serialize($data_post);
        $data['values']['company_id']      = $this->session->userdata("clms_company");
        $data['values']['user_id']       = $this->input->post('user');
        $data['values']['student_id']       = $this->input->post('contact');
        $data['values']['lead_name'] 		= $this->input->post('name');
        $data['values']['lead_lname']        = $this->input->post('lname');
        $data['values']['email'] 			= $this->input->post('email');
        $data['values']['phone_number']              = $this->input->post('phone');
        $data['values']['purpose'] 				= $this->input->post('purpose');
        $data['values']['about_us']              = $this->input->post('about_us');
        $data['values']['is_booked']              = $this->input->post('conselling');
        if($this->input->post('booking_date') && $this->input->post('booking_date') != ''){
            $data['values']['booking_date']              = date("Y-m-d",strtotime($this->input->post('booking_date')));
        }
        
        $data['values']['booking_time']              =  $this->input->post('booking_time');
        $data['values']['country']              = $this->input->post('country');
        $data['values']['requirements']              = $this->input->post('requirement');
        $data['values']['lead_source']              = $this->input->post('lead_source');
     
        $data['values']['reminder_date']              = strtotime($this->input->post('date'));
        $data['values']['reminder_time']              = $this->input->post("time");
        $data['values']['consultant']           = $this->input->post("consultant");
        $data['values']['referral']              = $this->input->post('referral');
        $data['values']['status_id']              = $this->input->post('status');
        $data['values']['lead_email_id']              = $this->input->post("email_template");

           // $data['values']['user_id']              = $userdata;
        $data['values']['added_by'] 				= $userdata;
        $data['values']['added_date'] 			= time();
        $data['values']['modified_by'] 				= $userdata;
        $data['values']['status'] 					= 1;
        $this->lmsmodel->add($data['values']);
        $leadid = $this->db->insert_id();

        $txt_files = $this->input->post("txt_files");

        if($txt_files && !empty($txt_files)){

            foreach($txt_files as $file){
                $this->db->insert("lead_attachments",[
                    "lead_id" => $leadid,
                    "doc_name" => $file
                ]);
            }
        }

        $docs = $this->input->post("docs");
        if(!empty($docs)){
            foreach($docs as $doc){
                $lead_docs = array(
                    "lead_id" => $leadid,
                    "doc_id" => $doc,
                    "added_at" => date("Y-m-d h:i:s")
                );

                $this->db->insert("pnp_leaddocs",$lead_docs);
            }
        }

        if($this->input->post('status_update') !=""){
            $data['update']['content']              = $this->input->post('status_update');
            $data['update']['lead_id']                 = $leadid;
            $data['update']['added_by']                 = $userdata;
            $data['update']['added_date']           = time();
            $data['update']['modified_by']              = $userdata;
            $data['update']['modified_date']              = time();
            $this->lmsmodel->addstatus($data['update']);
        }

        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Add",
            "module" => "Manage Lead",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);

        $customer_id = $this->input->post('user');
        /************* send activation email to customer ************/
        if($customer_id > 0 && $this->input->post("send_email")){
            $rcust    = $this->lmsmodel->get_userdetails($customer_id);
            $customer = $rcust->first_name.' '.$rcust->last_name;   
            $from     = $this->mylibrary->getSiteEmail(32);
            $site_url = $this->mylibrary->getSiteEmail(21);
            $fromname = $this->mylibrary->getSiteEmail(20);
            $address  = $this->mylibrary->getSiteEmail(25);
            $phone    = $this->mylibrary->getSiteEmail(27);
            $fax      = $this->mylibrary->getSiteEmail(28);
            $sitemail = $this->mylibrary->getSiteEmail(23);
            $noreplyemail = $this->mylibrary->getSiteEmail(22);
            $company = $this->usermodel->getuser($this->session->userdata("clms_company"))->row();
            if($company->thumbnail != '' && file_exists('../assets/uploads/users/thumb/'.$company->thumbnail)){
                $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
            }else{
                $logo = '';
            }
            $this->email->set_mailtype('html');
            $this->email->from($noreplyemail, $fromname);
            $this->email->reply_to($company->email);
            $this->email->to($rcust->email);
            $row = $this->mylibrary->getCompanyEmailTemplate(2,$this->session->userdata("clms_company"));
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
            $this->email->send();
            $this->email->clear();

         
        }

          /************* send activation email to customer ************/
          if($this->input->post("send_email")){
            $rcust    = $this->lmsmodel->get_userdetails($customer_id);
            $customer = $rcust->first_name.' '.$rcust->last_name;   
            $from     = $this->mylibrary->getSiteEmail(32);
            $site_url = $this->mylibrary->getSiteEmail(21);
            $fromname = $this->mylibrary->getSiteEmail(20);
            $address  = $this->mylibrary->getSiteEmail(25);
            $phone    = $this->mylibrary->getSiteEmail(27);
            $fax      = $this->mylibrary->getSiteEmail(28);
            $sitemail = $this->mylibrary->getSiteEmail(23);
            $noreplyemail = $this->mylibrary->getSiteEmail(22);
            $company = $this->usermodel->getuser($this->session->userdata("clms_company"))->row();
            if($company->thumbnail != '' && file_exists('../assets/uploads/users/thumb/'.$company->thumbnail)){
                $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
            }else{
                $logo = '';
            }
            $this->email->set_mailtype('html');
            $this->email->from($noreplyemail, $fromname);
            $this->email->reply_to($company->email);
            $this->email->to($this->input->post("email"));
            $row = $this->mylibrary->getCompanyEmailTemplate(91,$this->session->userdata("clms_company"));
            $subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
            $subject = str_replace('[TYPE]','Lead',$subject);
            $this->email->subject($subject);
            $message = str_replace('[NAME]',$this->input->post("name").' '.$this->input->post("lname"),html_entity_decode($row->email_message,ENT_COMPAT));
            $message = str_replace('[SITE_NAME]',$fromname,$message);
            $message = str_replace('[TYPE]','Lead',$message);
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
            $this->email->send();
            $this->email->clear();
        }
        $this->session->set_flashdata('success_message', 'Leads added successfully');
        redirect('dashboard/leads');
    } else {
        if($this->uri->segment(3)){
            $dbid = $this->uri->segment(3);
            $data["db"] = $this->databasemodel->getdata($dbid)->row();
        }

        if($this->input->get("inquiry_id"))
           $data["db"] = $this->inquirymodel->getdata($this->input->get("inquiry_id"))->row();


        $this->load->model("contacts/contacts_model");    
        $this->load->model("student/studentmodel");    
    
       $data['countries']      = $this->lmsmodel->get_country();
       $data['about_us']      = $this->lmsmodel->about_us();
       $data['purpose']      = $this->lmsmodel->get_purpose();
       $data['source']      = $this->lmsmodel->get_source();
       $data['status']      = $this->lmsmodel->get_leadstatus();
       $data['users']      = $this->lmsmodel->get_users();
       $data['employees'] = $this->projectmodel->get_empoyee();
       $data['lead_types'] = $this->salerepmodel->get_leadType();
       $data['emails'] = $this->lmsmodel->listEmails();
       $data['docs'] = $this->lmsmodel->ListDocs();
      // $data['contacts'] = $this->contacts_model->listall(null,1);
      $data['contacts'] = $this->studentmodel->listall();
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

function project(){
    if($this->input->post("project_type") && $this->input->post("project_type") == "new_project")
      $this->form_validation->set_rules('email', 'Email', 'required|is_unique[customers.email]');
  else
    $this->form_validation->set_rules('customer', 'Customer', 'required');

if ($this->form_validation->run() == FALSE){
    $lead_id = $this->uri->segment(3);
    $data['result'] = $this->lmsmodel->getdata($lead_id)->row();
    $data['countries'] = $this->customermodel->getcoutries();
    $data['states'] = $this->customermodel->getstates();
    $data['category']      = $this->lmsmodel->get_category(0);
    $data['customer']      = $this->projectmodel->get_customer();
    $data['project_status'] = $this->projectmodel->getStatus();
    $data['gst'] = $this->generalsettingsmodel->getConfigData(53)->row();
    $data['lead_types']      = $this->lmsmodel->get_leadTypes();
    $data['users']      = $this->lmsmodel->get_users();
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
    $userdata = $this->session->userdata("clms_userid");
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
    $userdata = $this->session->userdata("clms_userid");
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
    $cats = $this->lmsmodel->get_category($catid);
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




    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('txt_submit')) {
            $id = $this->input->post('lead_id');
            $userdata = $this->session->userdata("clms_userid");
            $date = date("Y-m-d");
            $data_post = $_POST;
            $data['values']['form_post']   = serialize($data_post);
            $data['values']['company_id']      = $this->session->userdata("clms_company");
            $data['values']['user_id']       = $this->input->post('user');
            $data['values']['student_id']       = $this->input->post('contact');
            $data['values']['lead_name']        = $this->input->post('name');
            $data['values']['lead_lname']        = $this->input->post('lname');
            $data['values']['email']            = $this->input->post('email');
            $data['values']['phone_number']              = $this->input->post('phone');
            $data['values']['purpose']              = $this->input->post('purpose');
            $data['values']['about_us']              = $this->input->post('about_us');
            $data['values']['is_booked']              = $this->input->post('conselling');
            $data['values']['more_info_added']              = 1;
            $data['values']['consultant']           = $this->input->post("consultant");
            $data['values']['weightage_id']              = $this->input->post('weightage');
            if($this->input->post('booking_date')){
                $data['values']['booking_date']              = date("Y-m-d",strtotime($this->input->post('booking_date')));
            }
            $data['values']['booking_time']              =  $this->input->post('booking_time');
            $data['values']['country']              = $this->input->post('country');
            $data['values']['requirements']              = $this->input->post('requirement');
            $data['values']['lead_source']              = $this->input->post('lead_source');
            $data['values']['reminder_date']              = strtotime($this->input->post('date'));
            $data['values']['reminder_time']              = $this->input->post("time");
            $data['values']['referral']              = $this->input->post('referral');
            $data['values']['status_id']              = $this->input->post('status');
            $data['values']['lead_email_id']              = $this->input->post("email_template");

           // $data['values']['user_id']              = $userdata;
            $data['values']['added_by']                 = $userdata;
            $data['values']['added_date']           = time();
            $data['values']['modified_by']              = $userdata;
           // $data['values']['status']                   = 1;

            $this->lmsmodel->update($id, $data['values']);

            $txt_files = $this->input->post("txt_files");
            $this->db->where("lead_id",$id);
            $this->db->delete("lead_attachments");

            if($txt_files && !empty($txt_files)){
                foreach($txt_files as $file){
                    $this->db->insert("lead_attachments",[
                        "lead_id" => $id,
                        "doc_name" => $file
                    ]);
                }
            }


            $docs = $this->input->post("docs");

            $this->db->where("lead_id",$id);
            $this->db->delete("leaddocs");
            if(!empty($docs)){
                foreach($docs as $doc){
                    $leaddocs = array(
                        "lead_id" => $id,
                        "doc_id" => $doc,
                        "added_at" => date("Y-m-d H:i:s")
                    );
                    $this->db->insert("leaddocs",$leaddocs);
                }
            }

            $leadid = $id;
            if($this->input->post('status_update') !=""){
                $data['update']['content']              = $this->input->post('status_update');
                $data['update']['lead_id']                 = $leadid;
                $data['update']['added_by']                 = $userdata;
                $data['update']['added_date']           = time();
                $data['update']['modified_by']              = $userdata;
                $data['update']['modified_date']              = time();
                $this->lmsmodel->addstatus($data['update']);
            }
            
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Lead",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $customer_id = $this->input->post('user');
            /************* send activation email to customer ************/
            if($this->input->post("send_email")){
                $rcust    = $this->lmsmodel->get_userdetails($customer_id);
                if(!empty($rcust)){
                $customer = $rcust->first_name.' '.$rcust->last_name;   
                $from     = $this->mylibrary->getSiteEmail(32);
                $site_url = $this->mylibrary->getSiteEmail(21);
                $fromname = $this->mylibrary->getSiteEmail(20);
                $address  = $this->mylibrary->getSiteEmail(25);
                $phone    = $this->mylibrary->getSiteEmail(27);
                $fax      = $this->mylibrary->getSiteEmail(28);
                $sitemail = $this->mylibrary->getSiteEmail(23);
                $noreplyemail = $this->mylibrary->getSiteEmail(22);
                $this->load->model("quote/quotemodel");
                $company = $this->quotemodel->getCompanyDetails($this->session->userdata("clms_company"));
                if($company->thumbnail != '' && file_exists('../assets/uploads/users/thumb/'.$company->thumbnail)){
                    $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
                }else{
                    $logo = '';
                }
                $this->email->set_mailtype('html');
                $this->email->from($noreplyemail, $fromname);
                $this->email->reply_to($company->email);
                $this->email->to($this->input->post("email"));
                $this->email->cc($rcust->email);
                $row = $this->mylibrary->getCompanyEmailTemplate(2,$this->session->userdata("clms_company"));
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
                $this->email->send();
                $this->email->clear();

            }
            }

            if($this->input->post("send_email")){
              
                $from     = $this->mylibrary->getSiteEmail(32);
                $site_url = $this->mylibrary->getSiteEmail(21);
                $fromname = $this->mylibrary->getSiteEmail(20);
                $address  = $this->mylibrary->getSiteEmail(25);
                $phone    = $this->mylibrary->getSiteEmail(27);
                $fax      = $this->mylibrary->getSiteEmail(28);
                $sitemail = $this->mylibrary->getSiteEmail(23);
                $noreplyemail = $this->mylibrary->getSiteEmail(22);
                $company = $this->usermodel->getuser($this->session->userdata("clms_company"))->row();
                if($company->thumbnail != '' && file_exists('../assets/uploads/users/thumb/'.$company->thumbnail)){
                    $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
                }else{
                    $logo = '';
                }
                $this->email->set_mailtype('html');
                $this->email->from($noreplyemail, $fromname);
                $this->email->reply_to($company->email);
                $this->email->to($this->input->post("email"));
                $row = $this->mylibrary->getCompanyEmailTemplate(91,$this->session->userdata("clms_company"));
                $subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
                $subject = str_replace('[TYPE]','Lead',$subject);
                $this->email->subject($subject);
                $message = str_replace('[NAME]',$this->input->post("name").' '.$this->input->post("lname"),html_entity_decode($row->email_message,ENT_COMPAT));
                $message = str_replace('[SITE_NAME]',$fromname,$message);
                $message = str_replace('[TYPE]','Lead',$message);
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
                $this->email->send();
                $this->email->clear();
            }
            $this->session->set_flashdata('success_message', 'Leads Edited Successfully');
            redirect('dashboard/leads');
        } else {
            $this->load->model("student/studentmodel");
            $data['contacts'] = $this->studentmodel->listall();
            $data['countries']      = $this->lmsmodel->get_country();
            $data['about_us']      = $this->lmsmodel->about_us();
            $data['purpose']      = $this->lmsmodel->get_purpose();
            $data['source']      = $this->lmsmodel->get_source();
            $data['status']      = $this->lmsmodel->get_leadstatus();
            $data['users']      = $this->lmsmodel->get_users();
            $data['employees'] = $this->projectmodel->get_empoyee();
            $data['lead_types'] = $this->salerepmodel->get_leadType();
            $data['weightage']      = $this->lmsmodel->get_leadweightage();
            $data['emails'] = $this->lmsmodel->listEmails();
            $data['docs'] = $this->lmsmodel->ListDocs();
            $id = $this->uri->segment(3);
            $data['files'] = $this->db->where("lead_id",$id)->get("lead_attachments")->result();
            $lead_docs = $this->lmsmodel->lead_docs($id);
            $data['lead_docs'] = array_column( $lead_docs,"doc_id");
            
          
            $query = $this->lmsmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['booking_time_options'] = $this->lmsmodel->get_appointmenttimes($data['result'],$id);
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Leads';
                $this->load->view('main', $data);
            } else {
                redirect('dashboard');
            }
        }
    }
}

function getemailContent(){
    $this->load->model("quote/quotemodel");
    $this->load->model("lms/lmsmodel");
    $emailid = $this->input->post("email") ? $this->input->post("email") : null;
    $id = $this->input->post("leadid");
    $this->db->where("id",$emailid);
    $row = $this->db->get("pnp_lead_email_template")->row();
    $header = $this->lmsmodel->getHeader();
    $footer = $this->lmsmodel->getFooter();

   $query = $this->lmsmodel->getdata($id);


      $data['result']   = $query->row();
      $data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);

      $from = $data['company']->order_email;
      $fromname = $data['company']->company_name;
      $fax      = $this->mylibrary->getSiteEmail(62);
      if($data['company']->thumbnail != '' && file_exists('../assets/uploads/users/thumb/'.$data['company']->thumbnail)){
          $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
      }else{
          $logo = '';
      }
    if(empty($row)){
        $row = $this->mylibrary->getCompanyEmailTemplate(77,$data['company']->company_id);
        $msg = @$row->email_message; 
    }else{
        $msg = $header.@$row->email_message.$footer; 
    }

      $data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
      
      $from = $data['company']->order_email;
      $fromname = $data['company']->company_name;
      $fax      = $this->mylibrary->getSiteEmail(62);
      if($data['company']->thumbnail != '' && file_exists('../assets/uploads/users/thumb/'.$data['company']->thumbnail)){
          $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
      }else{
          $logo = '';
      }
      
      $subject = $row->email_subject ? $row->email_subject : '';

      $subject = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($subject, ENT_COMPAT));
      $subject = str_replace('[SITE_NAME]', $fromname, $subject);
      $subject = str_replace('[FULL_NAME]', $data['result']->lead_name, $subject);
      $subject = str_replace('[YEAR]', date('Y'), $subject);
      $subject = str_replace('[LOGO]', $logo, $subject);
      $subject = str_replace('[SITE_URL]', SITE_URL, $subject);
      $subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
      $subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
      $subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
      if($fax == "")
          $subject = str_replace('- Fax -', "", $subject);
      $subject = str_replace('[SITE_FAX]', $fax, $subject);
      $subject = str_replace('[EMAIL]', $data['company']->email, $subject);
      

    
    
      
    $message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($msg, ENT_COMPAT));
      $message = str_replace('[SITE_NAME]', $fromname, $message);
      $message = str_replace('[FULL_NAME]', $data['result']->lead_name, $message);
      $message = str_replace('[YEAR]', date('Y'), $message);
      $message = str_replace('[LOGO]', $logo, $message);
      $message = str_replace('[SITE_URL]', SITE_URL, $message);
      $message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
      $message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
      $message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
      if($fax == "")
          $message = str_replace('- Fax -', "", $message);
      $message = str_replace('[SITE_FAX]', $fax, $message);
      $message = str_replace('[EMAIL]', $data['company']->email, $message);
      $message = str_replace('[YEAR]', date('Y'), $message);

    $message = str_replace('[NAME]', $data['result']->lead_name, $message);
    $message = str_replace('[CUSTOMER_COMPANY]', $data['result']->company_name, $message);
    $message = str_replace('[EMAIL]', $data['result']->email, $message);
    $message = str_replace('[PHONE]', $data['result']->phone_number, $message);
    $message = str_replace('[REQUIREMENTS]', $data['result']->requirements, $message);
    $message = str_replace('[WHEN_START]', '', $message);
    $message = str_replace('[LEAD_FROM]', @$data['result']->name, $message);
    $message = str_replace('[REMINDER_DATE]', date("d-m-Y",$data['result']->reminder_date), $message);
    $message = str_replace('[REMINDER_TIME]', $data['result']->reminder_time, $message);
    $message = str_replace('[STATUS_UPDATE]', $data['result']->status_update, $message);
    $message = str_replace('[YEAR]', date('Y'), $message);
    $message = str_replace('[LOGO]', $logo, $message);
    $message = str_replace('[SITE_URL]', SITE_URL, $message);
    $message = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $message);
    $message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
    $message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
    $message = str_replace('[SITE_FAX]', $fax, $message);
    $message = str_replace('[EMAIL]', $data['company']->email, $message);
    $message = str_replace('[YEAR]', date('Y'), $message);
    if($data['company']->powered_by == 1){
        $thokyoo_logo     = $this->mylibrary->getlogo1();
        $message .= '<p>Power By </p>'.$thokyoo_logo;
    } 
      
      echo json_encode([
          "subject" => $subject,
          "msg" => $message
      ]);
  

}

function set_employee_avaibility(){
    $this->load->model("employee/employeemodel");
    $employee_id = $this->input->post("consultant");
    $data['days'] = $this->employeemodel->get_service_day();
    $data['employee_id'] = $employee_id;
   echo $this->load->view("booking_time",$data,true);
}

function addempavaibility(){
    $day = $this->input->post("day");
    $start = $this->input->post("start_time");
    $end = $this->input->post("end_time");
    $id = $this->input->post("consaltant");

    $this->db->where("employee_id",$id);
    $this->db->delete("service_time_available");
    foreach($start as $key=>$val){
        $service = array(
            "employee_id" => $id,
            //"service_time_available"=>$val,
            "service_day"=> $day[$key],
            "service_start_time" => $start[$key],
            "service_end_time" => $end[$key],
            );
        $this->db->insert("service_time_available",$service);
        
    }
}

function mail_preview(){
    $leadid = $this->input->post("leadid");
    $this->load->model("quote/quotemodel");
    if($this->input->post("txt_submit")){
      $lead = $this->lmsmodel->getdata($leadid)->row();
      $subject = $this->input->post("subject");
      $message = $this->input->post("details123");
      $docs = $this->input->post("docs");

      $file_names = $this->input->post("txt_file") ? $this->input->post("txt_file") : [];
  
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
    $this->sendmailwithcontent($leadid,$subject,$message,$useremails,$docs,$file_names);
  

    $this->session->set_flashdata('success_message', 'Lead Sent successfully');
    redirect('dashboard/leads');
  
  }else{

    $this->load->model("lead_email_template/lead_emailmodel");
  
    list($subject,$message,$customer_arr,$customer_contacts) = $this->lmsmodel->getmailconent($leadid);
    $data['emails'] = $this->lead_emailmodel->listall();
    $data['leadid'] = $leadid;
    $data['subject'] = $subject;
    $data['message'] = $message;
    $data['new_message'] = $this->lmsmodel->getnewMessagecontent($leadid);
    $data['defualt_email'] = $this->lmsmodel->get_lead_template($leadid)->row();
    $data['customer_arr'] = $customer_arr;
    $data['customer_contacts'] = $customer_contacts;
    $data['docs'] = $this->lmsmodel->ListDocs();
    $lead_docs = $this->lmsmodel->lead_docs($leadid);
    $data['lead_docs'] = array_column( $lead_docs,"doc_id");
   // $data['lead_docs'] = [];
    echo $this->load->view('mail_preview', $data,true);
  
  }
  
  }

  function sendmailwithcontent($id,$subject,$message,$useremails,$docs=[],$file_names){

    $query = $this->lmsmodel->getdata($id);
    
    $data['result']   = $query->row();
    $data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
    
    $from = $data['company']->order_email;
    $fromname = $data['company']->company_name;
    $fax      = $this->mylibrary->getSiteEmail(62);
    if($data['company']->thumbnail != '' && file_exists('../assets/uploads/users/thumb/'.$data['company']->thumbnail)){
        $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
    }else{
        $logo = '';
    }
    //$message .= '<img src="'.base_url("quote/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';
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
            $doc_name = '';
            if(!empty($docs)){
                foreach($docs as $key => $docid){
                    $doc = $this->lmsmodel->getdocDetails($docid);
                    if(file_exists("../uploads/document/".$doc->image)){
                        $this->email->attach("../uploads/document/".$doc->image);
                    }

                    $doc_name .= $doc->name.', ';
                }
            }

            if(!empty($file_names)){
                foreach($file_names as $file_name){
                    if(file_exists("../uploads/document/".$file_name))
                        $this->email->attach("../uploads/document/".$file_name);
                }
            }

            $this->email->send();
            $this->email->clear(TRUE);
        }
    }
    $this->db->insert("pnp_lead_update",[
        "lead_id"=> $id,
        "content" => 'Sent email : ' . $subject . '<br> Attached files : '. $doc_name,
        "added_by" => $this->session->userdata("clms_userid"),
        "added_date" => time(),
        "file_name" => implode(",",$file_names)
    ]);
    $this->db->set("lead_id",$id);
    $this->db->set("sent_date",time());
    $this->db->insert("lead_email");

}

function mail(){
    $to = "bikash.suwal01@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: webmaster@example.com" . "\r\n" .
"CC: somebodyelse@example.com";

mail($to,$subject,$txt,$headers);
        
}

function edit_update(){
    if($this->session->userdata("clms_userid") != ""){
        $id = $this->input->post("id");
        $content = $this->input->post("content");

        $this->db->where("update_id",$id);
        $this->db->set("content",$content);
        $this->db->update("pnp_lead_update");
    }
}



    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("lead_id"=>$delid);
        $content = $this->usermodel->getDeletedData('leads',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->lmsmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('dashboard');
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
       // if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
    if ($this->session->userdata("clms_userid") != "") {

        $data['users']      = $this->lmsmodel->get_users();
        $data['weightage']      = $this->lmsmodel->get_leadweightage();
        $data['leadstatus']      = $this->lmsmodel->get_leadstatus();
        $id = $this->uri->segment(3);
        $query = $this->lmsmodel->getdata($id);
        $data['result'] = $query->row();
        $this->load->view('detail', $data);
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}



function add_update(){
    if($this->input->post("txt_submit")){
        $lead_id = $this->input->post("lead_id");
        $data['values']['reminder_date']              = strtotime($this->input->post('date'));
        $data['values']['reminder_time']              = $this->input->post("time");
        if($this->input->post('user'))
            $data['values']['user_id']              = $this->input->post('user');
        $data['values']['weightage_id']              = $this->input->post('weightage');
        $data['values']['status_id']              = $this->input->post('status');
        $data['values']['remark']              = $this->input->post('remark');
        $data['values']['next_action']              = $this->input->post('action');
        $data['values']['modified_by']              = $this->session->userdata("clms_userid");
            //$data['values']['modified_date']              = time();
        $this->lmsmodel->update($lead_id, $data['values']);
        $task = array(
            "lead_id" => $lead_id,
            "content" => $this->input->post("details123"),
            "added_date" => time(),
            "added_by" => $this->session->userdata("clms_userid")
            );
        $this->db->insert("lead_update",$task);
        $logs = array(
            "content" => serialize($data['values']),
            "action" => "Add Update",
            "module" => "Manage Lead",
            "added_by" => $this->session->userdata("clms_userid"),
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

        $emailcus    = $this->lmsmodel->get_userdetails($this->session->userdata("clms_userid"));
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
               $company = $this->quotemodel->getCompanyDetails($this->session->userdata("clms_company"));

               if($company->thumbnail != '' && file_exists('../assets/uploads/users/thumb/'.$company->thumbnail)){
                $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
                }else{
                    $logo = '';
                }
               $this->email->set_mailtype('html');
               $this->email->from($sitemail, "Lead Management System");
               $this->email->to($rcust->email);
              
               $row = $this->mylibrary->getCompanyEmailTemplate(3,$this->session->userdata("clms_company"));
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

               $query = $this->smsmodel->getdata($this->session->userdata("clms_userid"));
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
                       $this->commonmodel->calculate_smsBalance($this->session->userdata("clms_userid"));
                   }
       
                  
               }
               /***** Sms code ******/
           }
        }
       }
       $this->session->set_flashdata('success_message', 'Update has been successfully Added.');
       redirect('dashboard/leads');
   }
}


function status_update(){
    $id = $this->input->post("leadid");
    $updates = $this->lmsmodel->get_updates($id);
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
   $docs = $this->lmsmodel->get_documents($id);
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
        "added_by" => $this->session->userdata("clms_userid"),
        "added_date" => time()
        );
       $this->usermodel->insertUserlog($logs); 
   }

   $query = $this->lmsmodel->cascadeAction($ids, $action);
   $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
//echo $this->db->last_query();
   exit();
}

	//---------------------------------send--------------------------------------
function send() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('id');
            $userdata = $this->session->userdata("clms_userid");
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

function get_appointment_time_list(){
    $company_id = $this->session->userdata("clms_company");
    $company_detail = $this->db->where("company_id",$company_id)->get("company_details")->row();
    $interval = $company_detail->time_interval;
    $empid = $this->input->post("consultant");
    $appointment_date = $this->input->post("appointment_date");
    $day = date('N', strtotime($appointment_date));

    $this->db->where("booking_date",date("Y-m-d",strtotime($appointment_date)));
    $this->db->where("consultant",$empid);
    $leads = $this->db->get("leads")->result_array();

   
    $lead_times = array_column($leads,"booking_time");

    foreach($lead_times as $key => $time){
        $lead_times[$key] = date('H:i',strtotime($time));
    }

    $service_time = $this->db->where("employee_id",$empid)->where("service_day",$day)->get("pnp_service_time_available")->row();
    if(!empty($service_time)){
        if($service_time->service_start_time != '00:00:00' || $service_time->service_end_time != '00:00:00'){
           
            $start_time = $service_time->service_start_time;
            while(strtotime($start_time) < strtotime($service_time->service_end_time) )
                {
                    $time_interval = date("H:i",strtotime($start_time));
                    if(strtotime('-'.$interval.' minutes', strtotime($service_time->service_end_time)) >= strtotime($time_interval) && !in_array($time_interval, $lead_times))
                        echo '<option value="'.$time_interval.'">'.$time_interval.'</option>';
                    $start_time = date("H:i",strtotime('+'.$interval.' minutes', strtotime($time_interval)));
             
                }
              }
        }
    }

    function delete_all_leads(){
        $leadids = $this->input->post("leadids");

        $this->lmsmodel->delete_leads($leadids);
    }

    function lead_detail(){
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $id = $this->input->post("leadid");
            $this->load->model("student/studentmodel");
            $data['contacts'] = $this->studentmodel->listall();
            $data['countries']      = $this->lmsmodel->get_country();
            $data['about_us']      = $this->lmsmodel->about_us();
            $data['purpose']      = $this->lmsmodel->get_purpose();
            $data['source']      = $this->lmsmodel->get_source();
            $data['status']      = $this->lmsmodel->get_leadstatus();
            $data['users']      = $this->lmsmodel->get_users();
            $data['employees'] = $this->projectmodel->get_empoyee();
            $data['lead_types'] = $this->salerepmodel->get_leadType();
            $data['weightage']      = $this->lmsmodel->get_leadweightage();
            $data['emails'] = $this->lmsmodel->listEmails();
            $data['docs'] = $this->lmsmodel->ListDocs();
            $data['files'] = $this->db->where("lead_id",$id)->get("lead_attachments")->result();
            $lead_docs = $this->lmsmodel->lead_docs($id);
            $data['lead_docs'] = array_column( $lead_docs,"doc_id");
        
            $query = $this->lmsmodel->getdata($id);
            // echo $this->db->last_query();
            $data['result'] 	= $query->row();
            // print_r($data['result']); die();
            $data['booking_time_options'] = $this->lmsmodel->get_appointmenttimes($data['result'],$id);

            echo $this->load->view("edit_lead",$data,true);

        }else{
            redirect("login");
        }
      
    }

    function lead_update_form(){
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $id = $this->input->post("leadid");
            $data['type'] = $this->input->post("type") ?? "lead";
            $this->load->model("student/studentmodel");
            $data['users']      = $this->lmsmodel->get_users();
            $data['weightage']      = $this->lmsmodel->get_leadweightage();
            $data['leadstatus']      = $this->lmsmodel->get_leadstatus();
        
            $query = $this->lmsmodel->getdata($id);
            // echo $this->db->last_query();
            $data['result'] 	= $query->row();
            // print_r($data['result']); die();

            echo $this->load->view("add_lead_update",$data,true);

        }else{
            redirect("login");
        }
    }

    function assign_appointment_form(){
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $id = $this->input->post("leadid");
            $this->load->model("student/studentmodel");
            $data['users']      = $this->lmsmodel->get_users();
            $data['weightage']      = $this->lmsmodel->get_leadweightage();
            $data['leadstatus']      = $this->lmsmodel->get_leadstatus();
        
            $query = $this->lmsmodel->getdata($id);
            // echo $this->db->last_query();
            $data['result'] 	= $query->row();
            // print_r($data['result']); die();

            $data['employees'] = $this->projectmodel->get_empoyee();
            $data['result'] = $query->row();
            $data['booking_time_options'] = $this->lmsmodel->get_appointmenttimes($data['result'],$id);

            echo $this->load->view("assign_appointment",$data,true);

        }else{
            redirect("login");
        }
    }

    function ajax_lead_detail(){
        $leadid = $this->input->post("leadid");

        $result = $this->lmsmodel->getdata($leadid)->row();

        echo json_encode($result);
    }

    function delete_lead(){
        $leadid = $this->input->post("leadid");
        $this->db->where("lead_id",$leadid);
        $this->db->delete("leads");
    }

}