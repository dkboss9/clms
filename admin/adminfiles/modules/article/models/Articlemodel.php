<?php
	class ArticleModel extends CI_Model{
		function __construct(){
			parent::__construct();
			$this->table = "articles";
		}
		
		//list all images order by imageid desc
		function listall(){
			$this->db->order_by('articleid','desc');
			return $this->db->get($this->table);
		}
		function getparent($parent_id =''){
			$parent = '';
			$this->db->where('parent_id',0);
			$query = $this->db->get($this->table);
			if($query->num_rows()>0){
				foreach($query->result() as $row):
					$select = ($parent_id!='' && $parent_id==$row->articleid)?' selected="selected"':'';
					$parent .= '<option value="'.$row->articleid.'"'.$select.'>'.$row->article_title.'</option>';
				endforeach;
			}
			$query->free_result();
			return $parent;
		}
		//insert new image in database
		function insert($data){
			$this->db->insert($this->table,$data);
		}
		
		//update image details
		function update($id,$data){
			$this->db->where('articleid',$id);
			$this->db->update($this->table,$data);
		}
		
		//load image details
		
		function loadpage($articleid){
			$this->db->where('articleid',$articleid);
			return $this->db->get($this->table);
		}	
		//delete image details
		function delete($articleid){
			$this->db->where('articleid',$articleid);
			$this->db->delete($this->table);
		}
	}
?>
