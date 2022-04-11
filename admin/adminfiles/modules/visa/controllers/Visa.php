<?php
class Visa extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('visamodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'visa';
    }

    function index() { 
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('visa/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['access'] 	= $this->visamodel->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //--------------------------------------add--------------------------------------	

    function addVisaType(){
        $name = $this->input->post("type_name");
        $catid = $this->input->post("cat_id");
        $userdata = $this->session->userdata("clms_userid");
        $date = date("Y-m-d");
        $data['values']['type_name']    = $name;
        $data['values']['cat_id']    = intval($catid) > 0 ? $catid : null ;
        $data['values']['company_id']      = $this->session->userdata("clms_company");
        $data['values']['added_date']       = time();
        $data['values']['added_by']         = $userdata;
        $data['values']['modified_date']    = time();
        $data['values']['modified_by']      = $userdata;
        $data['values']['status']      = 1;
        $this->visamodel->add($data['values']);
        
        $id = $this->db->insert_id();
        $array = array("id"=>$id,"name"=>$name);
        echo json_encode($array);
    }

    function add() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {
           /*  if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            } */
            $userdata = $this->session->userdata("clms_userid");
            $date = date("Y-m-d");
            $data['values']['type_name']	= $this->input->post('name');
            $data['values']['cat_id'] = $this->input->post("category");
            $data['values']['company_id']      = $this->session->userdata("clms_company");
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->visamodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Lead Type",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'visa added successfully');
            redirect('visa/listall');
        }else{
            $data['categories'] = $this->visamodel->getcategory()->result();
            $data['page'] = 'add';
            $data['heading'] = 'Add Access';
            $this->load->vars($data);
            $this->load->view($this->container);
        }
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        $company_id = $this->session->userdata("company_id");
        if ($this->input->post('submit')) {
            $id = $this->input->post('type_id');
            $userdata = $this->session->userdata("clms_userid");
            $disabled = $this->input->post("disabled");
           if($disabled == 0){
                $data['values']['type_name']    = $this->input->post('name');
                $data['values']['cat_id'] = $this->input->post("category");
                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $this->visamodel->update($id, $data['values']);
                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Edit",
                    "module" => "Manage Lead Type",
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);
           }else{
               $points = $this->input->post("collected_points");
             

               $point = $this->visamodel->visaPoints($id,$company_id);
               if($point->num_rows() > 0){
                    $row = $point->row();
                    $this->db->where("id",$row->id);
                    $this->db->set("points",$points);
                    $this->db->update("pnp_visa_points");
               }else{
                    $point_array = [
                        "visa_id" => $id,
                        "company_id" => $company_id,
                        "points" => $points
                    ];
                    $this->db->insert("pnp_visa_points",$point_array);
               }
           }
          
            $this->session->set_flashdata('success_message', 'visa edited Successfully');
            redirect('visa/listall');
        } else {
            $id = $this->uri->segment(3);
            $data['point'] = $this->visamodel->visaPoints($id,$company_id)->row();
            $data['categories'] = $this->visamodel->getcategory()->result();
         
            $query = $this->visamodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('visa/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("type_id"=>$delid);
        $content = $this->usermodel->getDeletedData('visa',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->visamodel->delete($delid);
        $this->session->set_flashdata('success_message', 'visa deleted successfully');
        redirect('visa/listall');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}



function cascadeAction() {
    $data = $_POST['object'];
    $ids = $data['ids'];
    $action = $data['action'];
    foreach ($ids as $key => $delid) {
        $cond = array("type_id"=>$delid);
        $content = $this->usermodel->getDeletedData('visa',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Business Category",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->visamodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

function getsubcategory(){
    $visa_type = $this->input->post("visa_type");
    $visa_types = $this->visamodel->getsubcategory($visa_type);
    $visa_sub_category = $this->input->post("visa_sub_category");
    $option = '<option value=""></option>';
    foreach($visa_types as $type){
        $selected = $type->type_id == $visa_sub_category ? 'selected':'';
        $option .= '<option value="'.$type->type_id.'" '.$selected.'>'.$type->type_name.'</option>';
    }

    echo $option;
}

}