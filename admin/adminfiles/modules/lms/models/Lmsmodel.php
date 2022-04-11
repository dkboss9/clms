<?php
class LmsModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'leads';

	}

	function listall($handle,$country,$weightage,$status,$category,$access,$language,$lead_date,$added_date){
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_company"),$this->session->userdata("usergroup"))->num_rows();
		$company_user_id = $this->session->userdata("company_user_id");
		$userid = $this->commonmodel->get_login_id();
		$company_id = $this->session->userdata("clms_company");
		$group_id = $this->session->userdata("usergroup");

		$this->db->select('*,l.added_by handle,l.email email, l.status,s.type_name as source_name,l.added_date');
		$this->db->from($this->table." l");
	
		$this->db->join("lead_status ls","ls.status_id=l.status_id");
		$this->db->join("source s","s.type_id=l.lead_source","left");
		$this->db->join("company_users u","u.id=l.user_id","left");
		if($handle != "")
			$this->db->where("l.user_id",$handle);
		if($country != "")
			$this->db->where("l.country",$country);
		if($weightage != "")
			$this->db->where("l.weightage_id",$weightage);
		if($status != "")
			$this->db->where("l.status_id",$status);
		if($access != "")
			$this->db->where("l.access",$access);
		if($category != "")
			$this->db->where("l.category",$category);
		if($language != "")
			$this->db->where("l.language",$language);
		
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_company"));

		if($all_data == 0){
			$this->db->where("(l.added_by = $userid OR l.user_id = $company_user_id OR l.consultant=$company_user_id OR l.student_id=$company_user_id)");
		}

		if($lead_date !=""){
			if($lead_date == "today")
				$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`+64800), '%Y-%m-%d') = CURDATE()");
			elseif($lead_date == "tomorrow")
				$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`+64800), '%Y-%m-%d') = DATE_FORMAT(CURDATE()+1, '%Y-%m-%d')");
			elseif($lead_date == 'exceeded')
				$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`+64800), '%Y-%m-%d') < CURDATE()");
		}

		if($added_date !=""){
			if($added_date == "today")
				$this->db->where("DATE_FORMAT(FROM_UNIXTIME(l.`added_date`), '%Y-%m-%d') = CURDATE()");
			elseif($added_date == "yesterday")
				$this->db->where("l.added_date >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY)) AND l.added_date < UNIX_TIMESTAMP(CURDATE())");
			elseif($added_date == "week")
				$this->db->where("WEEKOFYEAR(DATE_FORMAT(FROM_UNIXTIME(l.`added_date`), '%Y-%m-%d'))=WEEKOFYEAR(NOW())");
			elseif($added_date == "month")
				$this->db->where("MONTH(DATE_FORMAT(FROM_UNIXTIME(l.`added_date`), '%Y-%m-%d'))=MONTH(NOW())");
		}
		//$this->db->where("is_booked",'0');
		//$this->db->where("l.status_id !=",'5');
		//$this->db->where("l.status_id !=",'6');
		$this->db->order_by('l.lead_id','desc');
		return $this->db->get();
	}

	function getLeadStart($id){
		$this->db->where("start_id",$id);
		return $this->db->get("start")->row();
	}

	function getLeadFrom($id){
		$this->db->where("threatre_id",$id);
		return $this->db->get("quote_from")->row();
	}

	function delete_leads($leadids=[]){
		if(!empty($leadids)){
			$this->db->where_in("lead_id",$leadids);
			$this->db->delete("leads");
		}
	}

	function getmailconent($id){

		$customer_arr = array();
		$query = $this->getdata($id);
		
		$data['result']   = $query->row();

		$lead = $data['result']; 
		//print_r($lead);

		$customer_arr['name'] = $lead->lead_name;
		$customer_arr['email'] = $lead->email;
	
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('../assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}
		
		$lead_template = $this->get_lead_template($id);
		if($lead_template->num_rows() > 0){
			$header = $this->getHeader();
			$row = $lead_template->row();
			$footer = $this->getFooter();
			$row->email_message = $header.$row->email_message.$footer; 
		}else{
			$row = $this->mylibrary->getCompanyEmailTemplate(91,$data['company']->company_id);
		}
		
		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to( $lead->email);

		// $start = $this->lmsmodel->getLeadStart($lead->when_start);
 		// $lead_from = $this->lmsmodel->getLeadFrom($lead->lead_from);
		
		$subject = str_replace('[SITE_NAME]', $data['company']->company_name, $row->email_subject);
		$subject = str_replace('[TYPE]', 'Lead', $subject);

		$this->email->subject($subject);

		$message = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[NAME]', $lead->lead_name, $message);
		$message = str_replace('[TYPE]', 'Lead', $message);
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[LEAD_NAME]', $lead->lead_name, $message);
		$message = str_replace('[CUSTOMER_COMPANY]', $lead->company_name, $message);
		$message = str_replace('[EMAIL]', $lead->email, $message);
		$message = str_replace('[PHONE]', $lead->phone_number, $message);
		$message = str_replace('[LEAD_DETAILS]', $lead->requirements, $message);
		// $message = str_replace('[WHEN_START]', @$start->start_name, $message);
		// $message = str_replace('[LEAD_FROM]', @$lead_from->name, $message);
		$message = str_replace('[REMINDER_DATE]', date("d-m-Y",$lead->reminder_date), $message);
		$message = str_replace('[REMINDER_TIME]', $lead->reminder_time, $message);
		$message = str_replace('[STATUS_UPDATE]', $lead->status_update, $message);
		$message = str_replace('[COMPANY_ADDRESS]', $data['company']->address, $message);
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
		return array($subject,$message,$customer_arr,array($lead->email));

	}

	function getHeader(){
		return '<table border="0" cellpadding="5" cellspacing="0" width="100%">
		<tbody>
			<tr>
				<td>
					[LOGO]</td>
			</tr>
			<tr>
				<td>
					Dear [FULL_NAME],</td>
			</tr>
			<tr>
				<td>';
	}


	function getFooter(){
		return '</td>
		</tr>
		<tr>
			<td>
				<span attached="" background-color:="" blockquote="" find="" font-family:="" font-size:="" for="" invoice="" number:="" open="" order="" please="" type="cite">&nbsp;</span></td>
		</tr>
		<tr>
			<td>
				<span attached="" background-color:="" blockquote="" find="" font-family:="" font-size:="" for="" invoice="" number:="" open="" order="" please="" type="cite">Thank you,</span></td>
		</tr>
		<tr>
			<td>
				<span attached="" background-color:="" blockquote="" find="" font-family:="" font-size:="" for="" invoice="" number:="" open="" order="" please="" type="cite">[COMPANY_NAME]&nbsp;</span></td>
		</tr>
		<tr>
			<td>
				<hr />
			</td>
		</tr>
		<tr>
			<td align="center">
				<span attached="" background-color:="" blockquote="" find="" font-family:="" font-size:="" for="" invoice="" number:="" open="" order="" please="" type="cite">[SITE_NAME] - [SITE_ADDRESS]<br />
				Phone: [SITE_PHONE] - Mob: 0425 327 800 - Email: [SITE_EMAIL]<br />
				Copyright &copy; [YEAR] [SITE_NAME]. All Rights Reserved.</span></td>
				</tr>
			</tbody>
		</table>';
	}

	function getnewMessagecontent($id){

		$customer_arr = array();
		$query = $this->getdata($id);
		
		$data['result']   = $query->row();

		$lead = $data['result']; 
		//print_r($lead);

		$customer_arr['name'] = $lead->lead_name;
		$customer_arr['email'] = $lead->email;
	
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		
		$from = $data['company']->order_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('../assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}
		
	
		$header = $this->getHeader();
		$footer = $this->getFooter();
		$email_message = $header.'<p></p>'.$footer; 
	
		
		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to( $lead->email);

		// $start = $this->lmsmodel->getLeadStart($lead->when_start);
 		// $lead_from = $this->lmsmodel->getLeadFrom($lead->lead_from);
		
		$subject = '';

		$message = str_replace('[COMPANY_NAME]', $data['company']->company_name, html_entity_decode($email_message, ENT_COMPAT));
		$message = str_replace('[FULL_NAME]', $lead->lead_name, $message);
		
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[NAME]', $lead->lead_name, $message);
		$message = str_replace('[CUSTOMER_COMPANY]', $lead->company_name, $message);
		$message = str_replace('[EMAIL]', $lead->email, $message);
		$message = str_replace('[PHONE]', $lead->phone_number, $message);
		$message = str_replace('[REQUIREMENTS]', $lead->requirements, $message);
		$message = str_replace('[WHEN_START]', @$start->start_name, $message);
		$message = str_replace('[LEAD_FROM]', @$lead_from->name, $message);
		$message = str_replace('[REMINDER_DATE]', date("d-m-Y",$lead->reminder_date), $message);
		$message = str_replace('[REMINDER_TIME]', $lead->reminder_time, $message);
		$message = str_replace('[STATUS_UPDATE]', $lead->status_update, $message);
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
		
		return $message;

	}

	function getdocDetails($id){
		return $this->db->where("content_id",$id)->get("document")->row();
	}


	function get_email_sendcount($lead_id){
		$this->db->where("lead_id",$lead_id);
		return $this->db->get("pnp_lead_email")->num_rows();
	}

	function listEmails(){
		$this->db->where("status",1);
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
		$this->db->where("company_id",$this->session->userdata("clms_company"));
		return $this->db->get("pnp_lead_email_template")->result();
	}

	function lead_docs($leadid){
		$this->db->where("lead_id",$leadid);
		return $this->db->get("leaddocs")->result_array();
	}
	

	function ListDocs(){
		$this->db->where("status",1);
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
		$this->db->where("company_id",$this->session->userdata("clms_company"));
		return $this->db->get("document")->result();
	}


	function get_lead_template($leadid){
		$this->db->select("let.*")->from("pnp_lead_email_template let");
		$this->db->join("leads l","l.lead_email_id = let.id");
		$this->db->where("l.lead_id",$leadid);
		$this->db->where("let.status",1);
		return $this->db->get();
	}


	function get_appointmenttimes($result,$leadid){
		$empid = $result->consultant;
		$appointment_date = $result->booking_date;
		$day = date('N', strtotime($appointment_date));

		$this->db->where("booking_date",date("Y-m-d",strtotime($appointment_date)));
		$this->db->where("consultant",$empid);
		$this->db->where("lead_id !=",$leadid);
		$leads = $this->db->get("leads")->result_array();
		$lead_times = array_column($leads,"booking_time");
	
		foreach($lead_times as $key => $time){
			$lead_times[$key] = date('H:i',strtotime($time));
		}

		$options = '';
	
		$service_time = $this->db->where("employee_id",$empid)->where("service_day",$day)->get("pnp_service_time_available")->row();
		
		if(!empty($service_time)){
			if($service_time->service_start_time != '00:00:00' || $service_time->service_end_time != '00:00:00'){
			   
				$start_time = $service_time->service_start_time;
				while(strtotime($start_time) < strtotime($service_time->service_end_time) )
					{
						$time_interval = date("H:i",strtotime($start_time));
						if(strtotime('-30 minutes', strtotime($service_time->service_end_time)) >= strtotime($time_interval) && !in_array($time_interval, $lead_times)){
							$selected = $time_interval == date('H:i',strtotime($result->booking_time)) ? 'selected' : '';
							$options .='<option value="'.$time_interval.'" '.$selected.'>'.$time_interval.'</option>';
						}
						$start_time = date("H:i",strtotime('+30 minutes', strtotime($time_interval)));
				 
					}
				  }
			}
		
		return $options;
	}

	function fullowup($date){
		$this->db->select('*,l.added_by handle,l.email email, l.status');
		$this->db->from($this->table." l");
		//$this->db->join("weightage w","w.weightage_id=l.weightage_id");
		//$this->db->join("lead_status ls","ls.status_id=l.status_id");
		//$this->db->join("users u","u.userid=l.user_id","left");
		
		if($this->session->userdata["usergroup"] != 1 && $this->session->userdata["usergroup"] != 7  && $this->session->userdata["company_id"] != 0){
			$this->db->where("l.added_by",$this->session->userdata("clms_userid"));
			$this->db->or_where("l.user_id",$this->session->userdata("clms_userid"));
		}
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_company"));

		//$this->db->where("is_booked",'0');
		
	/*	if($date == 'today'){
			$this->db->where("booking_date",date("Y-m-d"));
		}elseif($date == 'tomorrow'){
			$this->db->where("booking_date",date("Y-m-d", strtotime("+1 day")));
		}elseif($date == 'exceeded'){
			$this->db->where("booking_date < ",date("Y-m-d"));
		}
		*/

		if($date == "today")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`+64800), '%Y-%m-%d') = CURDATE()");
		elseif($date == "tomorrow")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`+64800), '%Y-%m-%d') = DATE_FORMAT(CURDATE()+1, '%Y-%m-%d')");
		elseif($date == 'exceeded')
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`+64800), '%Y-%m-%d') < CURDATE()");
		
		$this->db->where("l.status_id !=",'5');
		$this->db->where("l.status_id !=",'6');
		$this->db->order_by('l.lead_id','desc');
		return $this->db->get();
		
	}

	function appointment($date,$student_id=null){
		$this->db->select('*,l.added_by handle,l.email email, l.status');
		$this->db->from($this->table." l");
		//$this->db->join("weightage w","w.weightage_id=l.weightage_id");
		//$this->db->join("lead_status ls","ls.status_id=l.status_id");
		//$this->db->join("users u","u.userid=l.user_id","left");
		
		if($this->session->userdata["usergroup"] != 1 && $this->session->userdata["usergroup"] != 7  && $this->session->userdata["company_id"] != 0){
			$this->db->where("l.added_by",$this->session->userdata("clms_userid"));
			$this->db->or_where("l.user_id",$this->session->userdata("clms_userid"));
		}
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("l.company_id",$this->session->userdata("clms_company"));

		$this->db->where("l.status_id",'5');
		
		if($date == 'today'){
			$this->db->where("booking_date",date("Y-m-d"));
		}elseif($date == 'tomorrow'){
			$this->db->where("booking_date",date("Y-m-d", strtotime("+1 day")));
		}elseif($date == 'exceeded'){
			$this->db->where("booking_date < ",date("Y-m-d"));
		}

		if($student_id)
			$this->db->where("student_id",$student_id);
		

		$this->db->order_by('l.lead_id','desc');
		return $this->db->get();
		
	}

	function countLeads($lead_date){
		if($lead_date == "today")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d') = CURDATE()");
		elseif($lead_date == "tomorrow")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d') = DATE_SUB(CURDATE(), INTERVAL -1 DAY)");
		elseif($lead_date == "reminder_exceeded")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`reminder_date`), '%Y-%m-%d') < CURDATE()");
		$this->db->where("status_id not in (20,21,23)");
		return $this->db->get("leads")->num_rows();
	}

	function about_us(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("company_id",0);
		}
		$this->db->order_by("name","asc");
		return $this->db->get("about_us")->result();
	}

	function get_purpose(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("company_id",0);
		}
		$this->db->order_by("type_name","asc");
		return $this->db->get("purpose")->result();
	}

	function get_source(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("company_id",0);
		}
		$this->db->order_by("type_name","asc");
		return $this->db->get("source")->result();
	}

	function get_form(){
		$this->db->where("module_name","Lead");
		$this->db->where("company_id",$this->session->userdata("clms_company"));
		return $this->db->get("form");
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function addstatus($data){
		$this->db->insert("lead_update",$data);
	}

	function get_updates($leadid){
		$this->db->select("l.update_id,l.content,l.added_date,u.first_name,u.last_name");
		$this->db->from("lead_update l");
		$this->db->join("users u","u.userid=l.added_by");
		$this->db->where("l.lead_id",$leadid);
		$this->db->order_by("l.update_id","desc");
		return $this->db->get("")->result();
	}

	function getdata($lead_id){
		$this->db->where('lead_id',$lead_id);
		//$this->db->where_in('status', array('0','1'));
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($lead_id, $data){
		$this->db->where('lead_id', $lead_id);
		$this->db->update($this->table, $data);
	}

	function delete($lead_id) {

		$this->db->where('lead_id', $lead_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('lead_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('lead_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('lead_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}

		}
		return;
	}

	function get_languages(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->order_by("language_name","asc");
		return $this->db->get("language")->result();
	}

	function get_chatType(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		$this->db->order_by("chat_name","asc");
		return $this->db->get("chat")->result();
	}

	function get_WhenStart(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		$this->db->order_by("start_name","asc");
		return $this->db->get("start")->result();
	}

	function get_category($parent = 0){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("parent_id",$parent);
		$this->db->where("status",1);
		$this->db->order_by("cat_name","asc");
		return $this->db->get("lead_category")->result();
	}

	function get_access(){
		//if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
		//	$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		$this->db->order_by("access_name","asc");
		return $this->db->get("access")->result();
	}

	function get_users(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->where("status",1);
		$this->db->where("user_group",3);
		$this->db->order_by("first_name","asc");
		return $this->db->get("company_users")->result();
	}

	function get_leadweightage(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	{
			$userid = $this->session->userdata("clms_company");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		$this->db->order_by("name","asc");
		return $this->db->get("weightage")->result();
	}

	function get_leadstatus(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("company_id",0);
		}
		$this->db->where("status",1);
		$this->db->order_by('status_name','asc');
		return $this->db->get("lead_status")->result();
	}

	function addLmsfiles($data){
		$this->db->insert("lead_documents",$data);
	}

	function get_documents($lead_id){
		$this->db->where("lead_id",$lead_id);
		$query = $this->db->get("lead_documents");
		return $query->result();
	}

	function getusers($userid){
		$this->db->where("userid",$userid);
		return $this->db->get("users")->row();
	}

	function get_country(){
		$this->db->order_by("country_name","asc");
		$query = $this->db->get("countries");
		return $query->result();
	}

	function getleadusers($lead_id){
		$this->db->where("lead_id",$lead_id);
		$this->db->where("added_by !=",$this->session->userdata("clms_userid"));
		return $this->db->get("lead_update")->result();
	}

	function get_userdetails($userid){
		$this->db->where("id",$userid);
		return $this->db->get("company_users")->row();
	}

	function get_leadTypes(){
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != ""){
			$this->db->where("company_id",$this->session->userdata("clms_company"));
			$this->db->or_where("company_id",0);
		}	
		
		$this->db->where("status",1);
		return $this->db->get("lead_type")->result();
	}
}