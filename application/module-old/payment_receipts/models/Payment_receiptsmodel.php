<?php
class payment_receiptsModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'invoice_payment';		

	}

	function listall($limit = null){			
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company_id = $this->session->userdata("clms_front_companyid");
			$this->db->where("(company_id = $company_id or company_id = 0)");
		}	
		$this->db->where("status",1);
		$this->db->order_by('payment_id','asc');
		return $this->db->get($this->table);
	}

	function all_payment_receipts($limit = null){		
		$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
		$company_user_id = $this->commonmodel->getcompany_userid_new();
		$front_user_id = $this->session->userdata("clms_front_userid");
		$front_company_id = $this->session->userdata("clms_front_companyid");

		$this->db->select("p.*,c.first_name  cfname,c.last_name  clname,r.first_name,r.last_name,o.order_number")->from($this->table.' p');
		if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
			$company_id = $this->session->userdata("clms_front_companyid");
			$this->db->where("p.company_id", $company_id);
		}	
		if($all_data == 0){
			$this->db->where("(p.receipted_by = $company_user_id OR o.customer_id = $company_user_id)");
		}
		$this->db->join("order o","o.order_id=p.invoice_id");
		$this->db->join("company_students c","c.id=o.customer_id");
		$this->db->join("company_users r","r.id=p.receipted_by");
		$this->db->order_by('payment_id','asc');
		return $this->db->get();
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($id){
		$this->db->where('id',$id);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($id, $data){
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}

	function delete($id) {
		$this->db->where('id', $id);
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
}