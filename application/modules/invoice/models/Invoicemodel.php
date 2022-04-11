<?php
class invoicemodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'invoice';		

	}

	function listall($status = ''){	
		$this->db->select("*,i.status status,u.company_name")->from("invoice i");	
		$this->db->join("users u","u.userid=i.company_id");
		$this->db->join("users s","s.userid=i.customer_id");
		$this->db->join("invoice_status ins","ins.status_id=i.invoice_status");
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("i.company_id",$this->session->userdata("clms_front_companyid"));
		if($status != '')
			$this->db->where("invoice_status",$status);
		$this->db->order_by('i.invoice_id','desc');
		return $this->db->get("");
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($start_id){
		$this->db->where('invoice_id',$start_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($start_id, $data){
		$this->db->where('userid', $start_id);
		$this->db->update($this->table, $data);
	}

	function delete($start_id) {
		$this->db->where('userid', $start_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('invoice_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('invoice_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('invoice_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function getCompany(){
		$this->db->where('status',1);
		$this->db->where('user_group',7);
		return $this->db->get("users")->result();
	}

	function getCustomer(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where('status',1);
		return $this->db->get("customers")->result();
	}

	function getProject($cutomerid){
		
		$this->db->select("*")->from("projects p");
		$this->db->join("enroll e","e.order_id=p.project_id");
		$this->db->where('p.status',1);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("p.company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->where('e.student_id',$cutomerid);
		return $this->db->get("")->result();
	}

	function getinvoiceDetails($invoiceid){
		$this->db->where("invoice_id",$invoiceid);
		return $this->db->get("invoice_details")->result();
	}

	function getCompanyDetails($id){
		$this->db->where('userid',$id);
		return $this->db->get("users")->row();
	}

	function getCustomerDetails($id){
		$this->db->where('customer_id',$id);
		return $this->db->get("customers")->row();
	}

	function getStudentDetails($id){
		$this->db->where("userid",$id);
		return $this->db->get("users")->row();
	}

	function getPayments($id){
		$this->db->where('invoice_id',$id);
		return $this->db->get("invoice_payment")->result();
	}

	function getStatus(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	{
			$userid = $this->session->userdata("clms_front_companyid");
			$this->db->where("((company_id = $userid) OR (company_id = 0))");
		}
		$this->db->where("status",1);
		return $this->db->get("invoice_status")->result();
	}

	
	function getemailcount($order_id){
		$this->db->where("order_id",$order_id);
		return $this->db->get("order_email")->num_rows();
	}

	function preview_order($id){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->invoicemodel->getdata($id);
		
		$data['result']   = $query->row();
		
		$content = $this->load->view('invoice', $data, true);
		//echo $content; die();

		
		$file = 'Invoice'.$data['result']->invoice_no.'.pdf'; 
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
	}

	function sendmail_invoice($id){
		$this->load->helper('download');
		$this->html2pdf->folder('./uploads/pdf/');


		$query = $this->invoicemodel->getdata($id);
		
		$data['result']   = $query->row();
		$data['cutomer'] = $this->studentmodel->getdata($data['result']->customer_id)->row();
		$data['company'] = $this->invoicemodel->getCompanyDetails($data['result']->company_id);
		$content = $this->load->view('invoice', $data, true);
		//echo $content; die();

		
		$file = 'Invoice'.$data['result']->invoice_no.'.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
		$this->html2pdf->create('save');
		$file = "./uploads/pdf/".$file;
		/********** Get order details email template and send email to customer***********/
		//$from 	  = $this->mylibrary->getSiteEmail(31);
		//$fromname = $this->mylibrary->getSiteEmail(20);
		$from = $data['company']->email;
		$fromname = $data['company']->company_name;
		$fax      = $this->mylibrary->getSiteEmail(62);
		$logo     = '<img src="'.SITE_URL.'assets/uploads/users/thumb/'.$data['company']->thumbnail.'">';

		$row = $this->mylibrary->getCompanyEmailTemplate(52,$data['result']->company_id);
		/***** Sms code ******/
		if($this->mylibrary->getSiteEmail(54) == 1 && $row->sms == 1){
			$sms = $row->sms_text;
			$sms = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($sms, ENT_COMPAT));
			$sms = str_replace('[SITE_NAME]', $fromname, $sms);
			$sms = str_replace('[FULL_NAME]', $data['cutomer']->first_name.' '.$data['cutomer']->last_name, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$sms = str_replace('[LOGO]', $logo, $sms);
			$sms = str_replace('[SITE_URL]', SITE_URL, $sms);
			$sms = str_replace('[SITE_ADDRESS]', $data['company']->address, $sms);
			$sms = str_replace('[SITE_EMAIL]', $data['company']->email , $sms);
			$sms = str_replace('[SITE_PHONE]', $data['company']->phone, $sms);
			$sms = str_replace('[SITE_FAX]', $fax, $sms);
			$sms = str_replace('[EMAIL]', $data['company']->email, $sms);
			$sms = str_replace('[YEAR]', date('Y'), $sms);
			$mobile = $data['cutomer']->mobile;
			if($mobile != "")
				$this->commonmodel->printsms($sms,$mobile);
		}
		/***** Sms code ******/
		$this->email->set_mailtype('html');
		$this->email->from($from, $fromname);
		$this->email->to($data['cutomer']->email);
		
		$subject = str_replace('[COMPANY_NAME]', $fromname, $row->email_subject);
		$this->email->subject($subject);

		$message = str_replace('[COMPANY_NAME]', $fromname, html_entity_decode($row->email_message, ENT_COMPAT));
		$message = str_replace('[SITE_NAME]', $fromname, $message);
		$message = str_replace('[FULL_NAME]', $data['cutomer']->first_name.' '.$data['cutomer']->last_name, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$message = str_replace('[LOGO]', $logo, $message);
		$message = str_replace('[SITE_URL]', SITE_URL, $message);
		$message = str_replace('[SITE_ADDRESS]', $data['company']->address, $message);
		$message = str_replace('[SITE_EMAIL]', $data['company']->email , $message);
		$message = str_replace('[SITE_PHONE]', $data['company']->phone, $message);
		$message = str_replace('[SITE_FAX]', $fax, $message);
		$message = str_replace('[EMAIL]', $data['company']->email, $message);
		$message = str_replace('[YEAR]', date('Y'), $message);
		$this->email->message($message);
		
		$this->email->attach($file);
		$this->email->send();
		$this->email->clear();

	}

}