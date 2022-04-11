<?php
	class GeneralSettingsModel extends CI_Model{
		function __construct(){
			parent::__construct();
			$this->table = 'site_config';
		}
		
		function listall($limit = null){
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->order_by('config_id','asc');
			(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
			return $this->db->get();
		}
		
		
		function getdata(){
			return $this->db->get($this->table);
		}
                
		function getConfigData($config_id){
			$this->db->where('config_id',$config_id);
			return $this->db->get($this->table);
		}
		
		function updatesettings($config_id,$data){
         	$this->db->where('config_id',$config_id);
			$this->db->update($this->table,$data);
		}
	
		
}