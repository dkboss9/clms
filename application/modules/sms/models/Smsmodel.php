<?php
class smsmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'sms';		

	}

	function getdata($start_id){
		$this->db->where('company_id',$start_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function getsentsms(){
		$this->db->where('company_id',$this->session->userdata("clms_front_companyid"));
		$query=$this->db->get('custom_sms_sent');
		return $query;
	}

	function getPackages(){
		$this->db->where("status",1);
		return $this->db->get("sms_package")->result();
	}

	function smsSetting($sms_update,$company_id){
		$this->db->where("company_id",$company_id);
		$this->db->update("sms",$sms_update);
	}

	function getSmsPackage($company_id){
		$this->db->where("user_id",$company_id);
		$this->db->order_by("id","desc");
		return $this->db->get("company_sms_credits")->row();
	}

	function updateSmsPackage($company_package,$company_id){
		$package = $this->getSmsPackage($company_id);
		$this->db->where("id",$package->id);
		$this->db->update("company_sms_credits",$company_package);
	}

	
	function sendEmailSmsPackage($type,$company_id){
		$from 	  = $this->mylibrary->getSiteEmail(22);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(59);
		$phone    = $this->mylibrary->getSiteEmail(61);
		$fax      = $this->mylibrary->getSiteEmail(94);
		$sitemail = $this->mylibrary->getSiteEmail(23);

		$company = $this->companymodel->getdata($company_id)->row();


		$logo     = $this->mylibrary->getlogo(); 
		$row = $this->mylibrary->getEmailTemplate(58);
		//print_r($row);die();
		$this->email->set_mailtype('html');
		$sendemail   = $this->mylibrary->getSiteEmail(19);
		$this->email->from($sendemail, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($company->email);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
	//	$subject = str_replace('[ORDER_NUMBER]',$order->order_num ,$subject);
		$package = $this->smsmodel->getSmsPackage($company_id);
		$this->email->subject($subject);
		$message = str_replace('[FULL_NAME]',$company->first_name.' '.$company->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[PAYMENT_METHOD]',$package->payment_method,$message);
		$message = str_replace('[CREDITS]',$package->credit,$message);
		$message = str_replace('[AMOUNT]',$package->price,$message);
		$message = str_replace('[INVOICE_STATUS]',$package->invoice_status,$message);
		$message = str_replace('[DATE]',date("Y-m-d"),$message);
		$message = str_replace('[SITE_NAME]',$fromname,$message);
		$message = str_replace('[LOGO]',$logo,$message);
		$message = str_replace('[YEAR]',date('Y'),$message);
		$message = str_replace('[SITE_ADDRESS]',$address,$message);
		$message = str_replace('[SITE_PHONE]',$phone,$message);
		$message = str_replace('[SITE_FAX]',$fax,$message);
		$message = str_replace('[SITE_EMAIL]',$sitemail,$message);
		//$data['mail'] = $message;
		//echo $message; die();
		$this->email->message($message);
		$this->email->send();
		$this->email->clear();						
		//$query->free_result();	
	}


	
	
}