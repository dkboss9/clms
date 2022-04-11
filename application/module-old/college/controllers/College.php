<?php
class College extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('collegemodel');
        $this->load->model('users/usermodel');
        $this->load->model('appointment/appointmentmodel');
        $this->load->model("invoice/invoicemodel");
        $this->module_code = 'College';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('college/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['access'] 	= $this->collegemodel->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //--------------------------------------add--------------------------------------	

    function addCollege(){
        $name = $this->input->post("college_name");
        $userdata = $this->session->userdata("clms_front_userid");
        $date = date("Y-m-d");
        $data['values']['type_name']    = $name;
        $data['values']['college_desc']   = $this->input->post('college_desc');
        $data['values']['contact_name']   = $this->input->post('college_contact_name');
        $data['values']['contact_email']   = $this->input->post('college_contact_email');
        $data['values']['contact_number']   = $this->input->post('college_contact_number');
        $data['values']['country_id']    = $this->input->post('college_country');
        $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
        $data['values']['trading_name']   = $this->input->post('college_trading_name');
        $data['values']['city']   = $this->input->post('college_city');
        $data['values']['expiry_date']   = date("Y-m-d",strtotime($this->input->post('college_expiry_date')));
        $data['values']['abn']   = $this->input->post('college_abn');
        $data['values']['level_of_college']   = $this->input->post('college_college_level');
        $data['values']['added_date']       = time();
        $data['values']['added_by']         = $userdata;
        $data['values']['modified_date']    = time();
        $data['values']['modified_by']      = $userdata;
        $data['values']['status']      = 1;
        $this->collegemodel->add($data['values']);

        $id = $this->db->insert_id();
        $array = array("id"=>$id,"name"=>$name);
        echo json_encode($array);
    }

    function add() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {
               if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }
            $userdata = $this->session->userdata("clms_front_userid");
            $date = date("Y-m-d");
            $data['values']['type_name']	= $this->input->post('name');
            $data['values']['college_desc']   = $this->input->post('txt_desc');
            $data['values']['contact_name']   = $this->input->post('contact_name');
            $data['values']['contact_email']   = $this->input->post('contact_email');
            $data['values']['contact_number']   = $this->input->post('contact_number');
            $data['values']['trading_name']   = $this->input->post('trading_name');
            $data['values']['city']   = $this->input->post('city');
            $data['values']['expiry_date']   = date("Y-m-d",strtotime($this->input->post('expiry_date')));
            $data['values']['abn']   = $this->input->post('abn');
            $data['values']['level_of_college']   = $this->input->post('college_level');
            $data['values']['country_id']    = $this->input->post('country');
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->collegemodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Lead Type",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'college added successfully');
            redirect('college/listall');
        }else{
         $data['countries']      = $this->appointmentmodel->get_country();
         $data['levels'] = $this->collegemodel->getcollegelevel();
        //  $data['states'] = $this->collegemodel->getstates();
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
            $data['values']['country_id']    = $this->input->post('country');
            $data['values']['type_name']    = $this->input->post('name');
            $data['values']['contact_name']   = $this->input->post('contact_name');
            $data['values']['contact_email']   = $this->input->post('contact_email');
            $data['values']['contact_number']   = $this->input->post('contact_number');
            $data['values']['college_desc']   = $this->input->post('txt_desc');
            $data['values']['trading_name']   = $this->input->post('trading_name');
            $data['values']['city']   = $this->input->post('city');
            $data['values']['expiry_date']   = date("Y-m-d",strtotime($this->input->post('expiry_date')));
            $data['values']['abn']   = $this->input->post('abn');
            $data['values']['level_of_college']   = $this->input->post('college_level');
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->collegemodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Lead Type",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'college edited Successfully');
            redirect('college/listall');
        } else {
            $data['countries']      = $this->appointmentmodel->get_country();
            $data['levels'] = $this->collegemodel->getcollegelevel();
            $id = $this->uri->segment(3);
            $query = $this->collegemodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('college/listall');
            }
        }
    }
}

function send_mail($id){
    if($this->input->post("submit")){
        $subject = $this->input->post("subject");
        $content = $this->input->post("details123");
       echo $sms = $this->input->post("sms");

        $college = $this->collegemodel->getdata($id)->row();

        $data['company'] = $this->invoicemodel->getCompanyDetails($college->company_id);
        
        $from = $data['company']->email;
        $fromname = $data['company']->company_name;
        $fax      = $this->mylibrary->getSiteEmail(62);

        $this->email->set_mailtype('html');
        $this->email->from($from, $fromname);
        $this->email->to($college->contact_email);
        $this->email->subject($subject);

       
        $this->email->message($content);
        $this->email->send();
        $this->email->clear();
        $this->load->model("sms/smsmodel");
        $query = $this->smsmodel->getdata($this->session->userdata("clms_front_userid"));
        $sms_setting  = $query->row();

        if($this->input->post("chk_sms") && $sms_setting->balance_sms??0 > 0){
            $mobile = $college->contact_number;
          
            if($mobile != ""){
                $this->commonmodel->printsms($sms,$mobile,$sms_setting->sms_from);
                $this->commonmodel->calculate_smsBalance($this->session->userdata("clms_front_userid"));
            }
        }
        $this->session->set_flashdata('success_message', 'Mail sent Successfully');
        redirect('college/listall');
    }else{
        $college = $this->collegemodel->getdata($id)->row();

        $data['company'] = $this->invoicemodel->getCompanyDetails($college->company_id);
        
        $from = $data['company']->email;
        $fromname = $data['company']->company_name;
        $fax      = $this->mylibrary->getSiteEmail(62);
        $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
        $content = $this->mylibrary->getCompanyEmailTemplate(53,$this->session->userdata("clms_front_companyid"));
        $message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($content->email_message));
        $message = str_replace('[SITE_NAME]', $fromname, $message);
        $message = str_replace('[FULL_NAME]', $college->contact_name, $message);
        $message = str_replace('[YEAR]', date('Y'), $message);
        $message = str_replace('[LOGO]', $logo, $message);
        $message = str_replace('[SITE_URL]', SITE_URL, $message);
        $message = str_replace('[SITE_ADDRESS]', $data['company']->address, $message);
        $message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
        $message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
        $message = str_replace('[SITE_FAX]', $fax, $message);
        $message = str_replace('[EMAIL]', $data['company']->email, $message);
        $message = str_replace('[YEAR]', date('Y'), $message);
        $data['email'] = $message;

        $data['subject'] = $content->email_subject;
        $sms = $content->sms_text;
        $sms = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($sms));
        $sms = str_replace('[SITE_NAME]', $fromname, $sms);
        $sms = str_replace('[FULL_NAME]', $college->contact_name, $sms);
        $sms = str_replace('[YEAR]', date('Y'), $sms);
        $sms = str_replace('[LOGO]', $logo, $sms);
        $sms = str_replace('[SITE_URL]', SITE_URL, $sms);
        $sms = str_replace('[SITE_ADDRESS]', $data['company']->address, $sms);
        $sms = str_replace('[SITE_EMAIL]', $data['company']->email , $sms);
        $sms = str_replace('[SITE_PHONE]', $data['company']->phone, $sms);
        $sms = str_replace('[SITE_FAX]', $fax, $sms);
        $sms = str_replace('[EMAIL]', $data['company']->email, $sms);
        $sms = str_replace('[YEAR]', date('Y'), $sms);
        $data['sms'] = $sms;
        $this->load->view("send_email",$data);
    }
    
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("type_id"=>$delid);
        $content = $this->usermodel->getDeletedData('college',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->collegemodel->delete($delid);
        $this->session->set_flashdata('success_message', 'college deleted successfully');
        redirect('college/listall');
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
        $content = $this->usermodel->getDeletedData('college',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Business Category",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->collegemodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

function getcity(){
    $country = $this->input->post("country");
    $selected_city = $this->input->post("city");
    $cities = $this->collegemodel->getcity($country);
    $options = '<option vaule=""></option>';
    foreach($cities as $city){
        $selected = $city->state_id == $selected_city ? 'selected':'';
        $options .= '<option value="'.$city->state_id.'" '.$selected.'>'.$city->state_name.'</option>';
    }

    echo $options;
}

}