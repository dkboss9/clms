<?php
class Api_model extends CI_Model{
	function __construct(){
		parent::__construct();
  }

  function check_customer_login($username,$password){
    $this->db->select("u.*")->from("users u");
    $this->db->join("student_details sd","sd.student_id=u.userid");
    $this->db->where('email',$username);
    $this->db->where('password',$password);
    $this->db->where("u.verified_at is not NULL");
    $this->db->where("u.status",1);
		return $this->db->get();
  }

  function check_validate_code($email,$code){
    $this->db->select("u.*")->from("users u");
    $this->db->join("student_details sd","sd.student_id=u.userid");
    $this->db->where("u.code",$code);
    $this->db->where("u.email",$email);
    $this->db->where("u.verified_at is NULL");
    return $this->db->get()->row();
  }

  function check_usersEmail_login($email){
    $this->db->select("u.*")->from("users u");
    $this->db->join("student_details sd","sd.student_id=u.userid");
    $this->db->where("u.email",$email);
    return $this->db->get();
  }

  function check_usersToken($token){
    $this->db->select("u.*")->from("users u");
    $this->db->join("student_details sd","sd.student_id=u.userid");
    $this->db->where("u.token",$token);
    return $this->db->get();
  }

  function get_user($userid){
    $this->db->select("u.*,sd.sex,sd.is_married,sd.ielts,sd.listening,sd.writing,sd.reading,sd.speaking,sd.toefl,sd.toefl_score,sd.pte,sd.pte_score,
    sd.sat,sd.sat_score,sd.gre,sd.gre_score,sd.gmat,sd.gmat_score")->from("users u");
    $this->db->join("student_details sd","sd.student_id=u.userid");
    $this->db->where("u.userid",$userid);
    return $this->db->get();
  }

  function getDoccuments($userid,$limit=null){
		$this->db->select("d.*,dt.type_name")->from("student_documents d");
		$this->db->join("pnp_doc_type dt","dt.type_id=d.doc_type");
		$this->db->join("users u","u.userid = d.student_id");
		$this->db->where("u.userid",$userid);
		(!$limit == null)?$this->db->limit($limit['start'],$limit['end']):"";
    $this->db->order_by("d.id","desc");
		return $this->db->get()->result();
	}

  function listall_documentcategory($userid){
    $this->db->where("company_id",$userid);
    return $this->db->get("pnp_doc_type");
  }

  
}
?>