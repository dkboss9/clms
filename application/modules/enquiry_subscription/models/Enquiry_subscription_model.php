<?php
class enquiry_subscription_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'company_enquiry_package';		

	}

	function listall($limit = null){	
		$this->db->select("cep.*,u.company_name")->from("company_enquiry_package cep");
		$this->db->join("users u","u.userid = cep.company_id");		
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("cep.company_id",$this->session->userdata("clms_front_companyid"));
		//$this->db->order_by('status_id','asc');
		return $this->db->get();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($status_id){
		$this->db->where('id',$status_id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($status_id, $data){
		$this->db->where('id', $status_id);
		$this->db->update($this->table, $data);
	}

	function delete($status_id) {
		$this->db->where('id', $status_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}

	function getEnquiryPackage($company_id){
		$this->db->where("company_id",$company_id);
		$this->db->order_by("id","desc");
		return $this->db->get("company_enquiry_package")->row();
	}

	function updateEnquriyPackage($company_package,$company_id){
		$package = $this->getEnquiryPackage($company_id);
		$this->db->where("id",$package->id);
		$this->db->update("company_enquiry_package",$company_package);
	}

	function enquirySetting($enquiry_update,$company_id){
		$this->db->where("company_id",$company_id);
		$this->db->update("company_details",$enquiry_update);
	}

	function sendEmailEnquiryPackage($type,$company_id){
		$from 	  = $this->mylibrary->getSiteEmail(22);
		$fromname = $this->mylibrary->getSiteEmail(20);
		$address  = $this->mylibrary->getSiteEmail(59);
		$phone    = $this->mylibrary->getSiteEmail(61);
		$fax      = $this->mylibrary->getSiteEmail(94);
		$sitemail = $this->mylibrary->getSiteEmail(23);

		$company = $this->companymodel->getdata($company_id)->row();


		$logo     = $this->mylibrary->getlogo(); 
		$row = $this->mylibrary->getCompanyEmailTemplate(65,$company_id);
		
		
		//print_r($row);die();
		$this->email->set_mailtype('html');
		$this->email->from($from, $fromname);
		$this->email->reply_to($from, $fromname);
		$this->email->to($company->email);
		$subject = str_replace('[SITE_NAME]',$fromname,$row->email_subject);
	//	$subject = str_replace('[ORDER_NUMBER]',$order->order_num ,$subject);
		$package = $this->enquiry_subscription_model->getEnquiryPackage($company_id);
		$this->email->subject($subject);
		$message = str_replace('[FULL_NAME]',$company->first_name.' '.$company->last_name,html_entity_decode($row->email_message,ENT_COMPAT));
		$message = str_replace('[PAYMENT_METHOD]',$package->payment_method,$message);
		$message = str_replace('[CREDITS]',$package->credits,$message);
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