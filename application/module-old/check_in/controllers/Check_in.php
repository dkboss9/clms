<?php
class check_in extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('check_inmodel');
        $this->load->model('users/usermodel');
        $this->load->model("company/companymodel");
        $this->load->model('lms_project/lms_projectmodel');
        $this->module_code = 'check_in';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('check_in/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function listall(){
    
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
          
            $d = strtotime("today");
            if(date('D') == 'Mon')
            $start_week = strtotime("this monday ",$d);
            else
            $start_week = strtotime("last monday ",$d);
            $end_week = strtotime("next sunday",$d);
            $start = date("Y-m-d",$start_week); 
            $end = date("Y-m-d",$end_week);  

            $start = $this->input->get("sdate") == '' ? $start : $this->input->get("sdate"); 
            $end = $this->input->get("edate") == '' ? $end : $this->input->get("edate"); 

            $data['default_date'] = $this->input->get("date") != '' ? $this->input->get("date") : date("Y-m-d");
    
            $data['periods'] = $this->getDatesFromRange($start,$end);
    
            $data['prev_start_date'] = date("Y-m-d",strtotime("-7 day", strtotime($start)));
            $data['prev_end_date'] = date("Y-m-d",strtotime("-7 day", strtotime($end)));
    
            $data['next_start_date'] = date("Y-m-d",strtotime("+7 day", strtotime($start)));
            $data['next_end_date'] = date("Y-m-d",strtotime("+7 day", strtotime($end)));

            $data["users"] = $this->check_inmodel->get_users();
            $data["alldata"] = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows(); 
           
            $data['page'] 			= 'list_all';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
  

    function getDatesFromRange($start, $end, $format = 'Y-m-d') {
		$array = array();
		$interval = new DateInterval('P1D');
	
		$realEnd = new DateTime($end);
		$realEnd->add($interval);
	
		$period = new DatePeriod(new DateTime($start), $interval, $realEnd);
	
		foreach($period as $date) { 
			$array[] = $date->format($format); 
		}
	
		return $array;
	}

    //--------------------------------------add--------------------------------------	
    function add() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == "")
                redirect($_SERVER["HTTP_REFERER"],"refresh");

            $company_id = $this->session->userdata("clms_front_companyid");
            $company = $this->companymodel->getdata($company_id)->row();
            $time_zone = $company->time_zone;
            date_default_timezone_set($time_zone);

            $note = $this->input->post("checkInNote");
            $data = [
                "checkin_note" => $note,
                "checkin_at" => $this->input->post("time") ? $this->input->post("date").' '.$this->input->post("time") : date("Y-m-d H:i:s"),
                "company_id" => $this->session->userdata("clms_front_companyid"),
                "added_by" => $this->session->userdata("clms_front_userid"),
                "user_id" => $this->input->post("userid"),
                "added_date" =>date("Y-m-d H:i:s"),
                "register_date" => $this->input->post("time") ? $this->input->post("date") : date("Y-m-d")
            ]; 

            $this->db->where("user_id",$this->input->post("userid"));
            $this->db->where("register_date", $this->input->post("date"));
            $attendence = $this->db->get("employee_daily_activity");
           if($attendence->num_rows == 0){
            $this->check_inmodel->add($data);
           }else{
               $row = $attendence->row();
               $this->check_inmodel->update($row->id,$data);
           }

           $checkin_emails = $this->db->where("company_id",$this->session->userdata("clms_front_companyid"))
           ->get("pnp_company_standup_emails")->result();

           $user = $this->db->where("userid",$this->input->post("userid"))->get("users")->row();

           $date = $this->input->post("time") ? $this->input->post("date").' '.$this->input->post("time") : date("Y-m-d H:i:s");

           foreach ($checkin_emails as $value) {
                $staff_name = $user->first_name.' '.$user->last_name;   
                $from     = $this->mylibrary->getSiteEmail(32);
                $site_url = $this->mylibrary->getSiteEmail(21);
                $fromname = $this->mylibrary->getSiteEmail(20);
                $address  = $this->mylibrary->getSiteEmail(25);
                $phone    = $this->mylibrary->getSiteEmail(27);
                $fax      = $this->mylibrary->getSiteEmail(28);
                $sitemail = $this->mylibrary->getSiteEmail(23);
                $company = $this->usermodel->getuser($this->session->userdata("clms_front_companyid"))->row();
                $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
                $fromname = $company->company_name;
                $this->email->set_mailtype('html');
                $this->email->from($company->email, $fromname);
                $this->email->to($value->email);
                $row = $this->mylibrary->getCompanyEmailTemplate(81,$company->company_id);
                $subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
                $subject = str_replace('[STAFF_NAME]',$staff_name,$subject);
                $this->email->subject($subject);
                $message = str_replace('[STAFF_NAME]',$staff_name,html_entity_decode($row->email_message,ENT_COMPAT));
                $message = str_replace('[SITE_NAME]',$fromname,$message);
                $message = str_replace('[LOGO]',$logo,$message);
                $message = str_replace('[SITE_ADDRESS]',$company->address,$message);
                $message = str_replace('[SITE_PHONE]',$company->phone,$message);
                $message = str_replace('[SITE_FAX]','',$message);
                $message = str_replace('[SITE_EMAIL]',$company->email,$message);
                $message = str_replace('[SITE_URL]',$site_url,$message);
                $message = str_replace('[FULL_NAME]',$value->name,$message);
                $message = str_replace('[STAND-UP]',nl2br($note),$message);
                $message = str_replace('[DATE]',date("d-m-Y h:i a",strtotime($date)),$message);
                $message = str_replace('[YEAR]',date('Y'),$message);

                
                $message = str_replace('[COMPANY_NAME]',$company->company_name,$message);
                $message = str_replace('[COMPANY_ADDRESS]',$company->address,$message);
                $this->email->message($message);
                 $this->email->send();
                $this->email->clear();

                $this->load->model("sms/smsmodel");

                $query = $this->smsmodel->getdata($this->session->userdata("clms_front_userid"));
                $sms_setting  = $query->row();
                
              

                if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1 && $sms_setting->balance_sms??0 > 0){
                    $sms = $row->sms_text;
                    $sms = str_replace('[STAFF_NAME]',$staff_name,html_entity_decode($sms,ENT_COMPAT));
                    $sms = str_replace('[SITE_NAME]',$fromname,$sms);
                    $sms = str_replace('[LOGO]',$logo,$sms);
                    $sms = str_replace('[SITE_ADDRESS]',$company->address,$sms);
                    $sms = str_replace('[SITE_PHONE]',$company->phone,$sms);
                    $sms = str_replace('[SITE_FAX]','',$sms);
                    $sms = str_replace('[SITE_EMAIL]',$company->email,$sms);
                    $sms = str_replace('[SITE_URL]',$site_url,$sms);
                    $sms = str_replace('[FULL_NAME]',$value->name,$sms);
                    $sms = str_replace('[STAND-UP]',nl2br($note),$sms);
                    $sms = str_replace('[DATE]',date("d-m-Y h:i a",strtotime($date)),$sms);
                    $sms = str_replace('[YEAR]',date('Y'),$sms);

                
                    $sms = str_replace('[COMPANY_NAME]',$company->company_name,$sms);
                    $sms = str_replace('[COMPANY_ADDRESS]',$company->address,$sms);

        
                    $mobile = $value->mobile;
                    if($mobile != "")
                        $this->commonmodel->printsms($sms,$mobile,$sms_setting->sms_from);
        
                    $balance_sms = $sms_setting->balance_sms - 1;
        
                    $this->db->where("company_id",$this->session->userdata("clms_front_userid"));
                    $this->db->set("used_sms",$sms_setting->used_sms + 1);
                    $this->db->set("balance_sms",$balance_sms);
                    $this->db->update("sms");
                }
                /***** Sms code ******/
        } 
           
            $logs = array(
                "content" => serialize($data),
                "action" => "Add stand UP",
                "module" => "Manage check_ins",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'checked in successfully');
            redirect('check_in/listall');
        
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        $note = $this->input->post("checkOutNote");

        $company_id = $this->session->userdata("clms_front_companyid");
        $company = $this->companymodel->getdata($company_id)->row();
        $time_zone = $company->time_zone;
        date_default_timezone_set($time_zone);
      
        $alldata = $this->commonmodel->get_alldata_group_permissions(); 
        $data = [
            "checkout_note" => $note,
            "checkout_at" => $this->input->post("checkout_time") ? $this->input->post("date").' '.$this->input->post("checkout_time") : date("Y-m-d H:i:s"),
            "company_id" => $this->session->userdata("clms_front_companyid"),
            "added_by" => $this->session->userdata("clms_front_userid"),
            "user_id" => $this->input->post("userid"),
            "updated_date" =>date("Y-m-d H:i:s")
        ]; 

        $this->db->where("user_id",$this->input->post("userid"));
        $this->db->where("DATE(checkin_at)", $this->input->post("date"));
        $attendence = $this->db->get("employee_daily_activity");
        $row = $attendence->row();
        if($alldata == 0 && $row->checkout_at != ''){
            unset($data['checkout_at']);
        }
        $this->check_inmodel->update($row->id,$data);

        if($this->input->post("is_pushed")){
            $this->db->where("userid",$this->input->post("userid"));
            $this->db->set("code_push_at",date("Y-m-d H:i:s"));
            $this->db->update("users");
            // echo $this->db->last_query(); die();
        }


        $checkin_emails = $this->db->where("company_id",$this->session->userdata("clms_front_companyid"))
        ->get("pnp_company_standup_emails")->result();

        $user = $this->db->where("userid",$this->input->post("userid"))->get("users")->row();

        $date = $this->input->post("checkout_time") ? $this->input->post("date").' '.$this->input->post("checkout_time") : date("Y-m-d H:i:s");

        foreach ($checkin_emails as $value) {
             $staff_name = $user->first_name.' '.$user->last_name;   
             $from     = $this->mylibrary->getSiteEmail(32);
             $site_url = $this->mylibrary->getSiteEmail(21);
             $fromname = $this->mylibrary->getSiteEmail(20);
             $address  = $this->mylibrary->getSiteEmail(25);
             $phone    = $this->mylibrary->getSiteEmail(27);
             $fax      = $this->mylibrary->getSiteEmail(28);
             $sitemail = $this->mylibrary->getSiteEmail(23);
          //   $logo     = $this->mylibrary->getlogo();
             $company = $this->usermodel->getuser($this->session->userdata("clms_front_companyid"))->row();
             $logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$company->thumbnail.'">';
             $fromname = $company->company_name;
             $this->email->set_mailtype('html');
             $this->email->from($company->email, $fromname);
             $this->email->to($value->email);
         //$this->email->to('bikash.suwal01@gmail.com');
             $row = $this->mylibrary->getCompanyEmailTemplate(82,$company->company_id);
             $subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
             $subject = str_replace('[STAFF_NAME]',$staff_name,$subject);
             $this->email->subject($subject);
             $message = str_replace('[STAFF_NAME]',$staff_name,html_entity_decode($row->email_message,ENT_COMPAT));
             $message = str_replace('[SITE_NAME]',$fromname,$message);
             $message = str_replace('[LOGO]',$logo,$message);
             $message = str_replace('[SITE_ADDRESS]',$company->address,$message);
             $message = str_replace('[SITE_PHONE]',$company->phone,$message);
             $message = str_replace('[SITE_FAX]','',$message);
             $message = str_replace('[SITE_EMAIL]',$company->email,$message);
             $message = str_replace('[SITE_URL]',$site_url,$message);
             $message = str_replace('[FULL_NAME]',$value->name,$message);
             $message = str_replace('[UPDATE]',nl2br($note),$message);
             $message = str_replace('[DATE]',date("d-m-Y h:i a",strtotime($date)),$message);
             $message = str_replace('[YEAR]',date('Y'),$message);

             
             $message = str_replace('[COMPANY_NAME]',$company->company_name,$message);
             $message = str_replace('[COMPANY_ADDRESS]',$company->address,$message);
             $this->email->message($message);
              $this->email->send();
             $this->email->clear();

             $this->load->model("sms/smsmodel");

             $query = $this->smsmodel->getdata($this->session->userdata("clms_front_userid"));
             $sms_setting  = $query->row();
             
           

             if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1 && $sms_setting->balance_sms??0 > 0){
                $sms = $row->sms_text;
                $sms = str_replace('[STAFF_NAME]',$staff_name,html_entity_decode($sms,ENT_COMPAT));
                $sms = str_replace('[SITE_NAME]',$fromname,$sms);
                $sms = str_replace('[LOGO]',$logo,$sms);
                $sms = str_replace('[SITE_ADDRESS]',$company->address,$sms);
                $sms = str_replace('[SITE_PHONE]',$company->phone,$sms);
                $sms = str_replace('[SITE_FAX]','',$sms);
                $sms = str_replace('[SITE_EMAIL]',$company->email,$sms);
                $sms = str_replace('[SITE_URL]',$site_url,$sms);
                $sms = str_replace('[FULL_NAME]',$value->name,$sms);
                $sms = str_replace('[UPDATE]',nl2br($note),$sms);
                $sms = str_replace('[DATE]',date("d-m-Y h:i a",strtotime($date)),$sms);
                $sms = str_replace('[YEAR]',date('Y'),$sms);
              
                $sms = str_replace('[COMPANY_NAME]',$company->company_name,$sms);
                $sms = str_replace('[COMPANY_ADDRESS]',$company->address,$sms);
     
                $mobile = $this->input->post('phone');
                if($mobile != "")
                    $this->commonmodel->printsms($sms,$mobile,$sms_setting->sms_from);
     
                 $balance_sms = $sms_setting->balance_sms - 1;
     
                 $this->db->where("company_id",$this->session->userdata("clms_front_userid"));
                 $this->db->set("used_sms",$sms_setting->used_sms + 1);
                 $this->db->set("balance_sms",$balance_sms);
                 $this->db->update("sms");
             }
             /***** Sms code ******/
     } 
        
        
        $logs = array(
            "content" => serialize($data),
            "action" => "Add Update",
            "module" => "Manage checkout",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->session->set_flashdata('success_message', 'checked out successfully');
        redirect('check_in/listall');
    }else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("check_in_id"=>$delid);
        $content = $this->usermodel->getDeletedData('check_in',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage check_ins",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->check_inmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('check_in/listall');
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
        $cond = array("check_in_id"=>$delid);
        $content = $this->usermodel->getDeletedData('check_in',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage check_ins",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->check_inmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}