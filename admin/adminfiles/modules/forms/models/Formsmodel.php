<?php

class Formsmodel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'form';
    }

    function insert_form($data) {
        $this->db->insert($this->table, $data);
    }

    function getformdetail($id) {
        $this->db->where("forms_id", $id);
        $query = $this->db->get($this->table);
        //echo $this->db->last_query();
        return $query->row();
    }

    function update_form($data, $id) {
        $this->db->where("forms_id", $id);
        $this->db->update($this->table, $data);
    }

    function listall($limit = null) {
        $this->db->order_by('forms_id', 'desc');
        $this->db->where("company_id",$this->session->userdata("clms_company"));
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    function listpost($limit=null){
        $this->db->select('*');
        $this->db->from('post p');
        $this->db->join('adcategory c','c.form_id=p.form_id');
        $this->db->order_by('post_id', 'desc');
        ($limit!=null)?$this->db->limit($limit['start'],$limit['end']):'';
        $query = $this->db->get();
        return $query->result();    
        
    }
    
    function update_post($postid,$data){
        $this->db->where('post_id',$postid);
        $this->db->update('post',$data);
    }
    
    function getImagesByPost($post_id){
        $this->db->where('post_id',$post_id);
        $query = $this->db->get('post_images');
        return $query->result();
        $query->free_result();
    }
    
    function getPost($post_id){
        $this->db->where('post_id',$post_id);
        $query  = $this->db->get('post');
        $row    = $query->row();
        return $row->title;
        $query->free_result();
    }
    
    function getImage($image_id){
        $this->db->where("image_id",$image_id);
        $query = $this->db->get('post_images');
        return $query->row();
        $query->free_result();
        
        
    }

}