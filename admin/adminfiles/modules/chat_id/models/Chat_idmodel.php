<?php
class Chat_idModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->table = 'chat';		

	}

	function listall($limit = null){			
		if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") != "")	
			$this->db->where("company_id",$this->session->userdata("clms_company"));
		$this->db->order_by('chat_name','asc');
		return $this->db->get($this->table);
	}

	function add($data){
		$this->db->insert($this->table, $data);
	}

	function getdata($chat_id){
		$this->db->where('chat_id',$chat_id);
		$this->db->where_in('status', 1);
		$query=$this->db->get($this->table);
		return $query;

	}

	function update($chat_id, $data){
		$this->db->where('chat_id', $chat_id);
		$this->db->update($this->table, $data);
	}

	function delete($chat_id) {
		$this->db->where('chat_id', $chat_id);
		$this->db->delete($this->table);
	}

	function cascadeAction($ids,$action){
		$data = array();
		if(isset($ids)){
			if($action=="delete"){
				$this->db->where_in('chat_id',$ids);
				$this->db->delete($this->table);
			} else if($action=="publish"){
				$data["status"]='1';
				$this->db->where_in('chat_id',$ids);
				$this->db->update($this->table, $data);
			} else if($action=="unpublish"){
				$data["status"]='0';
				$this->db->where_in('chat_id',$ids);
				$this->db->update($this->table, $data);
			} else {
				return;
			}
			
		}
		return;
	}
}