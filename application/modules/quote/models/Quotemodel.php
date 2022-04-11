<?php
class Quotemodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'quote';		

	}

	function listall($status='',$expired_date=''){	
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		$company_user_id = $this->commonmodel->getcompany_userid_new();
		$front_user_id = $this->session->userdata("clms_front_userid");
		$front_company_id = $this->session->userdata("clms_front_companyid");

		$this->db->select("q.*")->from($this->table.' as q');	
		$this->db->join("company_students as c","c.id = q.customer_id");
	
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("q.company_id",$this->session->userdata("clms_front_companyid"));	

		if($all_data == 0){
			$this->db->where("(q.added_by = $front_user_id OR q.customer_id = $company_user_id)");
		}

		if($status != '')
			$this->db->where("quote_satus",$status);
		if($expired_date == "today")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`expiry_date`), '%Y-%m-%d') = CURDATE()");
		elseif($expired_date == "tomorrow")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`expiry_date`), '%Y-%m-%d') = DATE_SUB(CURDATE(), INTERVAL -1 DAY)");
		elseif($expired_date == "all")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`expiry_date`), '%Y-%m-%d') < CURDATE()");
		$this->db->order_by('customer_id','desc');
		return $this->db->get();
	}

	function countQuotes($expired_date){
		if($expired_date == "today")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`expiry_date`), '%Y-%m-%d') = CURDATE()");
		elseif($expired_date == "tomorrow")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`expiry_date`), '%Y-%m-%d') = DATE_SUB(CURDATE(), INTERVAL -1 DAY)");
		elseif($expired_date == "all")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`expiry_date`), '%Y-%m-%d') < CURDATE()");
		elseif($expired_date == "active")
			$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`expiry_date`), '%Y-%m-%d') >= CURDATE()");
		return $this->db->get($this->table)->num_rows();
	}

	function getCustomer($customer_id){
		$this->db->select("*")->from("company_students c");
		$this->db->join("company_student_details cd",'c.id=cd.company_student_id');
		$this->db->where("c.id",$customer_id);
		$query=$this->db->get();
		return $query->row();
	}


	function getCompanyDetails($company_id){
		$this->db->select("*")->from("users u");
		$this->db->join("company_details cd","u.userid=cd.company_id");
		$this->db->where("u.userid",$company_id);
		return $this->db->get("")->row();
	}

	function getpanel($id){
		$this->db->where("threatre_id",$id);
		return $this->db->get("threatre")->row();
	}

	function getpackage($id){
		$this->db->where("threatre_id",$id);
		return $this->db->get("inverter")->row();
	}

	function gettimeline($id){
		$this->db->where("threatre_id",$id);
		return $this->db->get("threatre")->row();
	}
	function gettype($id){
		$this->db->where("threatre_id",$id);
		return $this->db->get("roof_type")->row();
	}
	function getheight($id){
		$this->db->where("threatre_id",$id);
		return $this->db->get("roof_height")->row();
	}

	function getPhase($id){
		$this->db->where("threatre_id",$id);
		return $this->db->get("phase")->row();
	}
	function getstatus($id){
		$this->db->where("threatre_id",$id);
		return $this->db->get("quote_status")->row();
	}

	function getproduct($id){
		$this->db->where("procedure_id",$id);
		return $this->db->get("procedure")->row();
	}

	function getaccountmanager(){
		$this->db->where("user_group",3);
		$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where("status",1);
		return $this->db->get("company_users")->result();
	}


	function listProducts(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		$this->db->where("status",'1');
		return $this->db->get("procedure")->result();
	}

	function listPanels(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company_id = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company_id or company_id = 0)");
		}	
		$this->db->where("status",'1');
		return $this->db->get("threatre")->result();
	}

	function listInverter(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		$this->db->where("status",'1');
		return $this->db->get("inverter")->result();
	}

	function ListAboutus(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company_id = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company_id or company_id = 0)");
		}	
		$this->db->where("status",'1');
		return $this->db->get("about_us")->result();
	}

	function ListDocs(){
		$this->db->select("d.*")->from("document d");
		$this->db->join("document_category dc","dc.id=d.cat_id");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$this->db->where("d.company_id",$this->session->userdata("clms_front_companyid"));	
		}	
		$this->db->where("dc.type","Public");
		$this->db->where("d.status",'1');
		return $this->db->get()->result();
	}

	function listRoofHeight(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		$this->db->where("status",'1');
		return $this->db->get("roof_height")->result();
	}

	function listRoofType(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		$this->db->where("status",'1');
		return $this->db->get("roof_type")->result();
	}

	function listPhase(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));	
		$this->db->where("status",'1');
		return $this->db->get("phase")->result();
	}

	function listQuoteStatus(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company_id = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company_id or company_id = 0)");
		}	
		$this->db->where("status",'1');
		return $this->db->get("quote_status")->result();
	}

	function listQuoteFrom(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company_id = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company_id or company_id = 0)");
		}		
		$this->db->where("status",'1');
		return $this->db->get("quote_from")->result();
	}

	function listQuoteInverter($quoteid){
		$this->db->where("quote_id",$quoteid);
		return $this->db->get("quote_inverters")->result();
	}

	function getInverter($id){
		$this->db->where("threatre_id",$id);
		return $this->db->get("inverter")->row();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($customer_id){
		$this->db->where('quote_id',$customer_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function getQuoteWithLead($leadid){
		$this->db->where('lead_id',$leadid);
		$query=$this->db->get($this->table);
		return $query;
	}

	function update($customer_id, $data){
		$this->db->where('customer_id', $customer_id);
		$this->db->update($this->table, $data);
	}

	function delete($quoteid) {
		$this->db->where('quote_id', $quoteid);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('quote_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('quote_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('quote_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function check_duplicateEmail($email,$company_id){
		$this->db->where("email",$email);
		$this->db->where("company_id",$company_id);
		return $this->db->get($this->table)->num_rows();
	}

	function getcoutries(){
		return $this->db->get("countries")->result();
	}

	function getstates(){
		return $this->db->get("states")->result();
	}

	function getemailcount($quote_id){
		$this->db->where("quote_id",$quote_id);
		return $this->db->get("quote_email")->num_rows();
	}

	function download_order($id){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->quotemodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		// $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);

		$data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
		$content = $this->load->view('pdf', $data, true);
		//echo $content; die();

		
		$file = 'Quote'.$data['result']->quote_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
	}


	function sendmail($id){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->quotemodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
		$content = $this->load->view('pdf', $data, true);
		
		$file = 'Quote'.$data['result']->quote_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		
		$from = $data['company']->quote_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}
		
		$row = $this->mylibrary->getCompanyEmailTemplate(66,$data['company']->company_id);
		//echo $this->db->last_query();
		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(73) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[COMPANY_NAME]', $data['company']->company_name, $sms);
			$sms = str_replace('[QUOTE_NUMBER]', $data['result']->quote_number, $sms);
			$sms = str_replace('[SITE_NAME]', $fromname, $sms);
			$sms = str_replace('[FULL_NAME]',$data['cutomer']->customer_name, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$sms = str_replace('[LOGO]', $logo, $sms);
			$sms = str_replace('[SITE_URL]', SITE_URL, $sms);
			$sms = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $sms);
			$sms = str_replace('[SITE_EMAIL]', $data['company']->email , $sms);
			$sms = str_replace('[SITE_PHONE]', $data['company']->phone, $sms);
			$sms = str_replace('[SITE_FAX]', $fax, $sms);
			$sms = str_replace('[EMAIL]', $data['company']->email, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$mobile = $data['cutomer']->mobile_number;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/
		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($data['cutomer']->email);
		
		$subject = str_replace('[COMPANY_NAME]', $data['company']->company_name, $row->email_subject);
		$subject = str_replace('[QUOTE_NUMBER]', $data['result']->quote_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]',$data['cutomer']->customer_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$this->email->subject($subject);
		//echo $subject;
		$message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[QUOTE_NUMBER]', $data['result']->quote_number, $message);
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		$message = str_replace('[QUOTE_LINK]','<a href="'. base_url("quote/public_view/".$string1."-$id-".$string2.'-CUST').'">'. base_url("order/invoice/".$string1."-$id-".$string2.'-'.'CUST').'</a>', $message);
		$message = str_replace('[FULL_NAME]',$data['cutomer']->customer_name, $message);
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
		$message .= '<img src="'.base_url("quote/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';

		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 

		//echo $message; die();
		$this->email->message($message);
		$docs = $this->quotemodel->getDocuments($id);
		foreach($docs as $key => $doc){
			if(file_exists("./uploads/document/".$doc->image))
				$this->email->attach("./uploads/document/".$doc->image);
		}
		
		$this->email->attach($file);
		$this->email->send();
		$this->email->clear();

		$this->db->set("quote_id",$id);
		$this->db->set("sent_date",time());
		$this->db->insert("quote_email");

	}

	function countseen($quoteid){
		$this->db->where("quote_id",$quoteid);
		return $this->db->get("quote_seen")->num_rows();
	}

	function sendmailwithcontent($id,$subject,$message,$useremails){

		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');

		$query = $this->quotemodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		// $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
		$content = $this->load->view('pdf', $data, true);
		
		$file = 'Quote'.$data['result']->quote_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		
		$from = $data['company']->quote_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}
		
		$row = $this->mylibrary->getCompanyEmailTemplate(66,$data['company']->company_id);
		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(73) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[COMPANY_NAME]', $data['company']->company_name, $sms);
			$sms = str_replace('[QUOTE_NUMBER]', $data['result']->quote_number, $sms);
			$sms = str_replace('[SITE_NAME]', $fromname, $sms);
			$sms = str_replace('[FULL_NAME]',$data['cutomer']->customer_name, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$sms = str_replace('[LOGO]', $logo, $sms);
			$sms = str_replace('[SITE_URL]', SITE_URL, $sms);
			$sms = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $sms);
			$sms = str_replace('[SITE_EMAIL]', $data['company']->email , $sms);
			$sms = str_replace('[SITE_PHONE]', $data['company']->phone, $sms);
			$sms = str_replace('[SITE_FAX]', $fax, $sms);
			$sms = str_replace('[EMAIL]', $data['company']->email, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$mobile = $data['cutomer']->mobile_number;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/
		$message .= '<img src="'.base_url("quote/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';
		foreach ($useremails as $key => $customer_email) {
			if($customer_email != ''){
				$this->email->set_mailtype('html');
				$sendemail   = $this->mylibrary->getSiteEmail(19);
				$this->email->from($sendemail, $fromname);
				$this->email->reply_to($from, $fromname);
				$this->email->to($customer_email);
				$this->email->subject($subject);
				$this->email->message($message);
				if($key == 0){
					$docs = $this->quotemodel->getDocuments($id);
					foreach($docs as $key => $doc){
						if(file_exists("./uploads/document/".$doc->image))
							$this->email->attach("./uploads/document/".$doc->image);
					}
					
				}
				if($key == 0 && $this->input->post("chk_pdf"))
					$this->email->attach($file);
				$this->email->send();
				$this->email->clear();
			}
		}
		

		$this->db->set("quote_id",$id);
		$this->db->set("sent_date",time());
		$this->db->insert("quote_email");

	}

	function sendCommentEmail($id,$comment,$to){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->quotemodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		// $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
		$data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
		$content = $this->load->view('pdf', $data, true);
		

		
		$file = 'Quote'.$data['result']->quote_number.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		
		$from = $data['company']->quote_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}
		
		$row = $this->mylibrary->getCompanyEmailTemplate(67,$data['company']->company_id);
		
		//echo $this->db->last_query();die();
		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(73) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[COMPANY_NAME]', $data['company']->company_name, $sms);
			$sms = str_replace('[QUOTE_NUMBER]', $data['result']->quote_number, $sms);
			$sms = str_replace('[SITE_NAME]', $fromname, $sms);
			$sms = str_replace('[QUOTE_COMMENT]', $comment, $sms);
			$sms = str_replace('[FULL_NAME]',$data['cutomer']->customer_name, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$sms = str_replace('[LOGO]', $logo, $sms);
			$sms = str_replace('[SITE_URL]', SITE_URL, $sms);
			$sms = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $sms);
			$sms = str_replace('[SITE_EMAIL]', $data['company']->email , $sms);
			$sms = str_replace('[SITE_PHONE]', $data['company']->phone, $sms);
			$sms = str_replace('[SITE_FAX]', $fax, $sms);
			$sms = str_replace('[EMAIL]', $data['company']->email, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$mobile = $data['cutomer']->mobile_number;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/
		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		if($to=="CUST"){
			$this->email->to($data['cutomer']->email);
			$fullname = $data['cutomer']->first_name . ' ' .$data['cutomer']->last_name;
		}else{
			$this->email->to($data['company']->email);
			$fullname = $data['company']->first_name.' '.$data['company']->last_name;
		}
		
		$subject = str_replace('[COMPANY_NAME]', $data['company']->company_name, $row->email_subject);
		$subject = str_replace('[QUOTE_NUMBER]', $data['result']->quote_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]',$fullname, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$this->email->subject($subject);
		//echo $subject;
		$message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[QUOTE_NUMBER]', $data['result']->quote_number, $message);
		$message = str_replace('[QUOTE_COMMENT]', $comment, $message);
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		$message = str_replace('[QUOTE_LINK]','<a href="'. base_url("quote/public_view/".$string1."-$id-".$string2.'-'.$to).'">'. base_url("order/invoice/".$string1."-$id-".$string2.'-'.$to).'</a>', $message);
		$message = str_replace('[FULL_NAME]',$fullname, $message);
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
		$message .= '<img src="'.base_url("quote/count_mail_seen/".$id).'" style="width:1px;height:1px;"">';

		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 

		
		$this->email->message($message);
		if($data['result']->document>0){
			$doc = $this->quotemodel->getDocument($data['result']->document);
			if(file_exists("./uploads/document/".$doc->image))
				$this->email->attach("./uploads/document/".$doc->image);
		}
		$this->email->attach($file);
		$this->email->send();
		$this->email->clear();

		$this->db->set("quote_id",$id);
		$this->db->set("sent_date",time());
		$this->db->insert("quote_email");
	}

	function getmailconent($id){

		$customer_arr = array();
		$query = $this->quotemodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
		$customer_arr['name'] = $data['cutomer']->first_name.' '.$data['cutomer']->last_name;
		$customer_arr['email'] = $data['cutomer']->email;
		// $customer_contacts = $this->customermodel->getMoreContact($data['result']->customer_id);
		$data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
		$data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
		
		$from = $data['company']->quote_email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		if($data['company']->thumbnail != '' && file_exists('./assets/uploads/users/thumb/'.$data['company']->thumbnail)){
			$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';
		}else{
			$logo = '';
		}
		
		$row = $this->mylibrary->getCompanyEmailTemplate(66,$data['company']->company_id);
		
		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($data['cutomer']->email);
		
		$subject = str_replace('[COMPANY_NAME]', $data['company']->company_name, $row->email_subject);
		$subject = str_replace('[QUOTE_NUMBER]', $data['result']->quote_number, $subject);
		$subject = str_replace('[SITE_NAME]', $fromname, $subject);
		$subject = str_replace('[FULL_NAME]',$data['cutomer']->first_name.' '.$data['cutomer']->last_name, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);
		$subject = str_replace('[LOGO]', $logo, $subject);
		$subject = str_replace('[SITE_URL]', SITE_URL, $subject);
		$subject = str_replace('[SITE_ADDRESS]', $data['company']->mail_to_address, $subject);
		$subject = str_replace('[SITE_EMAIL]', $data['company']->email , $subject);
		$subject = str_replace('[SITE_PHONE]', $data['company']->phone, $subject);
		$subject = str_replace('[SITE_FAX]', $fax, $subject);
		$subject = str_replace('[EMAIL]', $data['company']->email, $subject);
		$subject = str_replace('[YEAR]', date('Y'), $subject);

		$message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[QUOTE_NUMBER]', $data['result']->quote_number, $message);
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$string1 = $this->generateRandomString();
		$string2 = $this->generateRandomString();
		$message = str_replace('[QUOTE_LINK]','<a href="'. base_url("quote/public_view/".$string1."-$id-".$string2.'-CUST').'">'. base_url("quote/public_view/".$string1."-$id-".$string2.'-'.'CUST').'</a>', $message);
		$slug = $string1."-$id-".$string2.'-CUST';
		$message = str_replace('[FULL_NAME]',$data['cutomer']->first_name.' '.$data['cutomer']->last_name, $message);
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

		if($data['company']->powered_by == 1){
			$thokyoo_logo     = $this->mylibrary->getlogo1();
			$message .= '<p>Power By </p>'.$thokyoo_logo;
		} 

		return array($subject,$message,$customer_arr,[],$slug);

	}


	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function getDocument($id){
		$this->db->where("content_id",$id);
		return $this->db->get("document")->row();
	}

	function getDocuments($id){
		$this->db->select("*")->from('quote_documents qd');
		$this->db->join("document d",'d.content_id = qd.document_id');
		$this->db->where("qd.quote_id",$id);
		return $this->db->get()->result();
	}

	function getQuoteComments($id){
		$this->db->where("quote_id",$id);
		return $this->db->get("quote_comments")->result();
	}

	function quotedocs($id){
		$this->db->select("document_id");
		$this->db->where("quote_id",$id);
		return $this->db->get("quote_documents")->result_array();
	}


}