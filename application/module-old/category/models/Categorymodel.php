<?php
	class CategoryModel extends CI_Model{
		function __construct(){
			parent::__construct();
			$this->table = 'product_category';		
			
		}
		
		function listall($limit = null){
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->order_by('category_name','asc');
			$this->db->where_in('cat_status',array('0','1'));
			(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
			return $this->db->get();
		}
		
		function listParentCategory($category_id=''){
			$category = '';
			$this->db->where('parent_id',0);
			$query = $this->db->get('product_category');
			if($query->num_rows()>0){
				foreach($query->result() as $row):
					$select    = ($category_id!='' && $category_id==$row->category_id)?' selected="selected"':'';
					$category .= '<option value="'.$row->category_id.'"'.$select.'>'.$row->category_name.'</option>';
				endforeach;
			}
			$query->free_result();
			return $category;
		}
		function add($data){
			  $this->db->insert($this->table, $data);
		}
		
		function getdata($category_id){
			$this->db->where('category_id',$category_id);
			$this->db->where_in('cat_status', array('0','1'));
			$query=$this->db->get($this->table);
			return $query;
			
		}
		
		function update($category_id, $data){
			$this->db->where('category_id', $category_id);
        	$this->db->update($this->table, $data);
		}
		
		function delete($category_id) {
			$data = array('cat_status'=>'2');
			$this->db->where('category_id', $category_id);
			$this->db->update($this->table, $data);
		}
                
		function cascadeAction($ids,$action){
			$data = array();
			if(isset($ids)){
				if($action=="delete"){
					$data["cat_status"]='2';
				} else if($action=="publish"){
					$data["cat_status"]='1';
				} else if($action=="unpublish"){
					$data["cat_status"]='0';
				} else {
					return;
				}
				$this->db->where_in('category_id',$ids);
				$this->db->update($this->table, $data);
			}
			return;
		}
		function listCategory($category_id=''){
			$category = '';
			$this->db->where('cat_status',1);
			$query = $this->db->get($this->table);
			if($query->num_rows()>0){				
				foreach($query->result() as $row):
					$select = ($category_id!='' && $category_id==$row->category_id)?' selected="selected"':'';
					$category .= '<option value="'.$row->category_id.'"'.$select.'">'.$row->category_name.'</option>';
				endforeach;
			}
			$query->free_result();
			return $category;
		}
	}