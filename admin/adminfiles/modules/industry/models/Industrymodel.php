<?php
	class IndustryModel extends CI_Model{
		function __construct(){
			parent::__construct();
			$this->table = 'industry';		
			
		}
		
		function listall($limit = null){			
			$this->db->order_by('industry_name','asc');
			$this->db->where_in('status',array('0','1'));
			(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
			return $this->db->get($this->table);
		}
		
		function add($data){
			  $this->db->insert($this->table, $data);
		}
		
		function getdata($industry_id){
			$this->db->where('industry_id',$industry_id);
			$this->db->where_in('status', array('0','1'));
			$query=$this->db->get($this->table);
			return $query;
			
		}
		
		function update($industry_id, $data){
			$this->db->where('industry_id', $industry_id);
        	$this->db->update($this->table, $data);
		}
		
		function delete($industry_id) {
			$data = array('status'=>'2');
			$this->db->where('industry_id', $industry_id);
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
				$this->db->where_in('industry_id',$ids);
				$this->db->update($this->table, $data);
			}
			return;
		}
	}