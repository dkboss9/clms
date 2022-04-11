<?php
	class CampaignModel extends CI_Model{
		function __construct(){
			parent::__construct();
			$this->table = 'campaign';		
			
		}
		
		function listall($limit = null,$status=null,$all=null){
			$all_data = $this->usermodel->getGroup_allData($this->session->userdata("clms_front_user_group"),$this->session->userdata("clms_front_companyid"))->num_rows();
			$all_data = $all ? $all_data : 1;
			$company_user_id = $this->commonmodel->getcompany_userid_new();
			$front_user_id = $this->session->userdata("clms_front_userid");
			$front_company_id = $this->session->userdata("clms_front_companyid");

			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->order_by('id','desc');
			(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
			if($this->session->userdata("clms_front_companyid") && $this->session->userdata("clms_front_companyid") != ""){
				$this->db->where("(company_id = $front_company_id OR company_id = 0)");
			}	
	
			if($all_data == 0)
				$this->db->where("added_by",$front_user_id);
			if($status)
			 	$this->db->where("status",$status);
			return $this->db->get();
		}

	
		
	
		function add($data){
			  $this->db->insert($this->table, $data);
		}
		
		function getdata($campaign_id){
			$this->db->where('id',$campaign_id);
			$query=$this->db->get($this->table);
			return $query;
		}
		
		function update($campaign_id, $data){
			$this->db->where('id', $campaign_id);
        	$this->db->update($this->table, $data);
		}
		
		function delete($campaign_id) {
			$this->db->where('id', $campaign_id);
			$this->db->delete($this->table);
		}
                
		function cascadeAction($ids,$action){
			$data = array();
			if(isset($ids)){
				if($action=="delete"){
					$this->db->where_in('id',$ids);
					$this->db->delete("campaign");
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
		function listcampaign($campaign_id=''){
			$campaign = '';
			$this->db->where('cat_status',1);
			$query = $this->db->get($this->table);
			if($query->num_rows()>0){				
				foreach($query->result() as $row):
					$select = ($campaign_id!='' && $campaign_id==$row->campaign_id)?' selected="selected"':'';
					$campaign .= '<option value="'.$row->campaign_id.'"'.$select.'">'.$row->campaign_name.'</option>';
				endforeach;
			}
			$query->free_result();
			return $campaign;
		}
	}