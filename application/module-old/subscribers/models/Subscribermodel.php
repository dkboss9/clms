<?php
class SubscriberModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'newsletter_subscription';

	}

	function listall($limit = null,$status = ''){
		$this->db->select('*');
		$this->db->from($this->table);
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->order_by('name','desc');
		($status == '')?$this->db->where_in('status',array('0','1')): $this->db->where('status',$status);
		$this->db->where_in('status',array('0','1'));
		(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
		return $this->db->get();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($subscription_id){
		$this->db->where('subscription_id',$subscription_id);
		$this->db->where_in('status', array('0','1'));
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($subscription_id, $data){
		$this->db->where('subscription_id', $subscription_id);
		$this->db->update($this->table, $data);
	}

	function delete($subscription_id) {
		$data = array('status'=>'2');
		$this->db->where('subscription_id', $subscription_id);
		$this->db->update($this->table, $data);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$data["status"]='2';
			} else if($action=="publish"){
				$data["status"]='1';
			} else if($action=="unpublish"){
				$data["status"]='0';
			} else {
				return;
			}
			$this->db->where_in('subscription_id',$ids);
			$this->db->update($this->table, $data);
		}
		return;
	}

	function checkifexists($email_address){
		$this->db->select('count(email_address) as email_count');
		$this->db->where('email_address',$email_address);
		$result = $this->db->get($this->table);
		$subscriber = $result->row();
		if($subscriber->email_count)
			return true;
		else
			return false;
	}	

	function listSubscriberCheckBox(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->select('email_address, name');
		$this->db->where("status",1);
		$query = $this->db->get('newsletter_subscription');
		$subscribers = '';
		if($query->num_rows()>0){				
			foreach($query->result() as $row):
				$subscribers .= '<div style="width: 20%; float: left;">
			<input type="checkbox" name="chkemaillist[]" value="'.$row->email_address.'">'.
			$row->name .
			'</div>';
			endforeach;
		}
		$query->free_result();
		return $subscribers;

	}

	function listUsers($group){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->select('email, first_name, last_name');
		$this->db->where("status",1);
		$this->db->where("user_group",$group);
		$query = $this->db->get('users');
		$subscribers = '';
		if($query->num_rows()>0){				
			foreach($query->result() as $row):
				$subscribers .= '<div style="width: 20%; float: left;">
			<input type="checkbox" name="chkemaillist[]" value="'.$row->email.'" class="check_'.$group.'">'.
			$row->first_name .' '.$row->last_name .
			'</div>';
			endforeach;
		}
		$query->free_result();
		return $subscribers;

	}

	function listCustomers(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->select('email, customer_name');
		$this->db->where("status",1);
		$query = $this->db->get('customers');
		$subscribers = '';
		if($query->num_rows()>0){				
			foreach($query->result() as $row):
				$subscribers .= '<div style="width: 20%; float: left;">
			<input type="checkbox" name="chkemaillist[]" value="'.$row->email.'" class="customers">'.
			$row->customer_name .
			'</div>';
			endforeach;
		}
		$query->free_result();
		return $subscribers;

	}

	function listSubscriberDropDown(){
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
		$this->db->select('email_address, name');
		$this->db->where("status",1);
		$query = $this->db->get('newsletter_subscription');
		$subscribers = '';
		if($query->num_rows()>0){				
			foreach($query->result() as $row):
				$subscribers .= '<option value="'.$row->email_address.'">'.$row->name.'</option>';
			endforeach;
		}
		$query->free_result();
		return $subscribers;
	}
}