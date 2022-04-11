<?php
class CommonModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getLogo($client){
		$this->db->where('client_id',$client);
		return $this->db->get('company');
		
	}
	
	function getModules($group_id){
		$this->db->where('groupid',$group_id);
	}

	function sendSMS($content) {
		$ch = curl_init('https://api.smsbroadcast.com.au/api-adv.php');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec ($ch);
		curl_close ($ch);
		return $output;    
	}

	function printsms($sms_text,$number){
		$fromname = $this->mylibrary->getSiteEmail(20);
		$username = 'bivek';
		$password = 'print@123';
   // $destination = '0405343545'; //Multiple numbers can be entered, separated by a comma
		$destination = $number;
		$source    = 'SCPrint';
		$text = $sms_text;
		$ref = 'abc123';

		$content =  'username='.rawurlencode($username).
		'&password='.rawurlencode($password).
		'&to='.rawurlencode($destination).
		'&from='.rawurlencode($source).
		'&message='.rawurlencode($text).
		'&ref='.rawurlencode($ref);

		$smsbroadcast_response = $this->sendSMS($content);

	/* 
	print_r($smsbroadcast_response);
	$response_lines = explode("\n", $smsbroadcast_response);

	foreach( $response_lines as $data_line){
		$message_data = "";
		$message_data = explode(':',$data_line);
		if($message_data[0] == "OK"){
			echo "The message to ".$message_data[1]." was successful, with reference ".$message_data[2]."\n";
		}elseif( $message_data[0] == "BAD" ){
			echo "The message to ".$message_data[1]." was NOT successful. Reason: ".$message_data[2]."\n";
		}elseif( $message_data[0] == "ERROR" ){
			echo "There was an error with this request. Reason: ".$message_data[1]."\n";
		}
	} 
	*/
}

function get_alldata_group_permissions(){
	$group_id = $this->session->userdata("usergroup");
	$group = $this->db->where("groupid",$group_id)->get("pnp_group")->row();
	return $group->all_data;
}

function calculate_smsBalance($company_id){
	$query = $this->smsmodel->getdata($company_id);
	$sms_setting  = $query->row();

	$balance_sms = $sms_setting->balance_sms - 1;

	$this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
	$this->db->set("used_sms",$sms_setting->used_sms + 1);
	$this->db->set("balance_sms",$balance_sms);
	$this->db->update("sms");

}

function is_admin($userid){
	$is_admin =	$this->db->where("group_id",1)->where("user_id",$userid)->where("status",1)->get("user_groups")->num_rows();

	return $is_admin > 0 ? true : false;
}

function get_adminmenu($parentid=0){
	return $this->db->where("parent_id",$parentid)->order_by("position","asc")->get("pnp_admin_menu")->result();
}

function get_adminmenu_users($parentid=0,$user_group_company_id=null,$user_action_id){
	$this->db->select("am.*");
	$this->db->from("pnp_admin_menu am");
	$this->db->join("pnp_permissions_per_user_group_company uc","uc.module_id=am.menuid");
	$this->db->where("user_group_company_id",$user_group_company_id);
	$this->db->where("user_action_id",$user_action_id);
	return $this->db->where("parent_id",$parentid)->order_by("position","asc")->get()->result();
}

function getcompany_userid($table,$front_user_id){
	$this->db->where("student_id",$front_user_id);
	return $this->db->get($table)->row()->id;
}

function getcompany_userid_new(){
	$front_user_id = $this->session->userdata("clms_front_userid");
	$front_group_id = $this->session->userdata("clms_front_user_group");

	switch($front_group_id){
		case 3:
			$table = 'pnp_company_users';
			$field = 'clms_front_userid';
			break;
		case 9:
			$table = 'pnp_company_users';
			$field = 'clms_front_userid';
			break;
		case 10:
			$table = 'pnp_company_users';
			$field = 'clms_front_userid';
			break;
		case 14:
			$table = 'pnp_company_students';
			 $field = 'student_id';
			break;
		case 19:
			$table = 'pnp_head_agents';
			$field = 'clms_front_userid';
			break;
		case 20:
			$table = 'pnp_sub_agents';
			$field = 'clms_front_userid';
			break;
		default:
		$table = 'pnp_company_users';
		$field = 'clms_front_userid';
	}
	$this->db->where($field,$front_user_id);
	return @$this->db->get($table)->row()->id;
}

}
?>