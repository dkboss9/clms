<?php
class Supplier extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('suppliermodel');
        $this->load->model('users/usermodel');
        $this->load->model("employee/employeemodel");
        $this->module_code = 'SUPPLIER-MANAGER';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('supplier/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['supplier'] 	= $this->suppliermodel->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function addConsultancy(){
        $first_name = $this->input->post("first_name");
        $last_name = $this->input->post("last_name");
        $email = $this->input->post("email");

        $value['details']['company_id']     = $this->session->userdata("clms_front_companyid");
        $value['details']['first_name']     = $this->input->post('first_name');
        $value['details']['last_name']      = $this->input->post('last_name');
        $value['details']['email']          = $this->input->post('email');
        $value['details']['user_group']     = 10;
        $value['details']['added_date']     = date('Y-m-d H:i:s');
        $value['details']['added_by']       = $this->session->userdata("clms_front_userid");
        $value['details']['status']         = 1;
        $this->usermodel->insertuser($value['details']);
        $id = $this->db->insert_id();

        $insert_array = array(
            "user_id"=>$id,
            "level" => '',
            );
        $this->db->insert("supplier_details",$insert_array);

        $array = array("id"=>$id,"name"=>$first_name.' '.$last_name);
        echo json_encode($array);
    }

    public function email_check($email)
    { 
        $this->db->where("email",$email);
        $this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
        $this->db->where("user_group",10);
        $query = $this->db->get("company_users");
       
            if ($query->num_rows() > 0)
            {
                    $this->form_validation->set_message('email_check', 'Contractor with this email already exists.');
                    return FALSE;
            }
            else
            {
                    return TRUE;
            }
    }

    function add(){
        if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"ADD")){
           $this->form_validation->set_rules('fname','First Name','required');
           $this->form_validation->set_rules('lname','Last Name','required');
           $this->form_validation->set_rules('suburb','Suburb','required');
           $this->form_validation->set_rules('email','Email','required|valid_email|callback_email_check');
           $this->form_validation->set_rules('phone','Phone','required');
         //  $this->form_validation->set_rules('password','Password','required');
           if($this->form_validation->run()!=FALSE){
               if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }
            $config['upload_path'] = './assets/uploads/users';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['max_size'] = 0;
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('logo'))
            {
                $error = array('error' => $this->upload->display_errors());

              //  print_r($error);
            }
            else
            {
                $arr_image = $this->upload->data();
                $thumb = $this->_createThumbnail('./assets/uploads/users/' . $arr_image['file_name'], './assets/uploads/users/thumb',174,69);
                $value['details']['picture']              = $arr_image['file_name']; 
                $value['details']['thumbnail']              = $thumb["dst_file"];
            }

            $this->load->library("uuid");
            $data['values']['uuid'] = $this->uuid->v4();
            $value['details']['company_id']     = $this->session->userdata("clms_front_companyid");
            $value['details']['first_name']      = $this->input->post('fname');
            $value['details']['last_name']      = $this->input->post('lname');
            $value['details']['email']          = $this->input->post('email');
            $value['details']['phone']          = $this->input->post('phone');
            $value['details']['user_group']     = 10;
            $value['details']['user_name']      = $this->input->post('username');
            $value['details']['password']       = md5($this->input->post('password'));
            $value['details']['added_date']     = date('Y-m-d H:i:s');
            $value['details']['added_by']       = $this->session->userdata("clms_front_userid");
            $value['details']['status']         = 1;
            $this->db->insert("company_users",$value['details']);
            $id = $this->db->insert_id();

            $insert_array = array(
                "company_user_id"=>$id,
                "level" => $this->input->post("level"),
                "suburb" => $this->input->post("suburb"),
                "transport" => $this->input->post("transport"),
                "type" => $this->input->post("type"),
                "company" => $this->input->post("company"),
                "abn" => $this->input->post("abn"),
                "comment" => $this->input->post("comment"),
                "positions" => $this->input->post("position"),
                "wage" => $this->input->post("wage"),
                "fual_allowance" => $this->input->post("fual"),
                "productivity_allowance" => $this->input->post("productivity"),
                "total" => $this->input->post("total"),
                );

           
            $this->db->insert("company_supplier_details",$insert_array);


            $start = $this->input->post("start_time");
            $end = $this->input->post("end_time");
            $day = $this->input->post("day_id");
           // $this->db->where("clinic_id",$userid);
           // $this->db->delete("service_time_available");
            foreach($start as $key=>$val){
                $service = array(
                    "employee_id" => $id,
                    //"service_time_available"=>$val,
                    "service_day"=> $day[$key],
                    "service_start_time" => $start[$key],
                    "service_end_time" => $end[$key],
                    );
                $this->db->insert("service_time_available",$service);
                
            }
            $log_array = array_merge($value['details'],$insert_array);

            $logs = array(
                "content" => serialize($log_array),
                "action" => "Add",
                "module" => "Manage Supplier",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);

            $this->suppliermodel->send_approval_email($id);

            $request = [
                "company_user_id" => $id,
                "type" => 'Supplier',
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_at" => date("Y-m-d H:i:s")
            ];
            $this->load->model("employee/employeemodel");
            $this->employeemodel->adduserRequest($request);
            $this->session->set_flashdata('success_message', 'Contractor added Successfully.');
            redirect('supplier/listall');
        }else{
            $this->load->model("company/companymodel");
            $data['levels'] = $this->suppliermodel->employeeLevel();
            $data['positions'] = $this->suppliermodel->employeePosition();
            $data['transports'] = $this->suppliermodel->employeetransport();
            $data['types'] = $this->suppliermodel->employeeType();
            $data['days'] = $this->suppliermodel->get_service_day();
            $data['company_id'] = $this->session->userdata("clms_front_companyid");
            $data['page'] = 'add';
            $data['heading'] = 'Add ';
            $this->load->vars($data);
            $this->load->view($this->container);
        }
    }else{
        $this->session->set_flashdata('error','Please login with your username and password');
        redirect('login','location');
    }
}

function resend_activation($id){
    $this->suppliermodel->send_approval_email($id);
    $request = [
        "company_user_id" => $id,
        "type" => 'Supplier',
        "added_by" => $this->session->userdata("clms_front_userid"),
        "added_at" => date("Y-m-d H:i:s")
    ];
    $this->load->model("employee/employeemodel");
    $this->employeemodel->adduserRequest($request);
    $this->session->set_flashdata('success_message', 'Mail sent Successfully.');
    redirect('supplier/listall');
}

function _createThumbnail($fileName, $thumb, $width=100, $height=100) {
    $config = array();
    $config['image_library'] = 'gd2';
    $config['source_image'] = $fileName;
    $config['new_image'] = FCPATH . $thumb;
    $config['create_thumb'] = TRUE;
    $config['maintain_ratio'] = TRUE;
    $config['width'] =  $width;
    $config['height'] = $height;

    $this->load->library('image_lib');
    $this->image_lib->initialize($config);
    if (!$this->image_lib->resize()) {
        echo $this->image_lib->display_errors();
        return false;
    }
    return $this->image_lib->data();
}


    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('supplier_id')) {
            $id = $this->input->post('supplier_id');
            $userdata = $this->session->userdata("clms_front_userid");

            $config['upload_path'] = './assets/uploads/users';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['max_size'] = 0;
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('logo'))
            {
                $error = array('error' => $this->upload->display_errors());

               // print_r($error);
            }
            else
            {
                $arr_image = $this->upload->data();
                $thumb = $this->_createThumbnail('./assets/uploads/users/' . $arr_image['file_name'], './assets/uploads/users/thumb',174,69);
                $data['values']['picture']              = $arr_image['file_name']; 
                $data['values']['thumbnail']              = $thumb["dst_file"];
            }

            $data['values']['first_name']    = $this->input->post('fname');
            $data['values']['last_name']    = $this->input->post('lname');
            $data['values']['email']    = $this->input->post('email');
            $data['values']['phone']    = $this->input->post('phone');
            $data['values']['user_name']    = $this->input->post('username');
            if($this->input->post("password") != "")
                $data['values']['password']    = md5($this->input->post('password'));


            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->db->where("id",$id);
            $this->db->update("company_users",$data['values']);

            $insert_array = array(
                "company_user_id"=>$id,
                "level" => $this->input->post("level"),
                "suburb" => $this->input->post("suburb"),
                "transport" => $this->input->post("transport"),
                "type" => $this->input->post("type"),
               // "company" => $this->input->post("company"),
                "comment" => $this->input->post("comment"),
                "positions" => $this->input->post("position"),
                "wage" => $this->input->post("wage"),
                "fual_allowance" => $this->input->post("fual"),
                "productivity_allowance" => $this->input->post("productivity"),
                "total" => $this->input->post("total"),
                );
            $this->db->where("company_user_id",$id);
            $this->db->update("company_supplier_details",$insert_array);

            $start = $this->input->post("start_time");
            $end = $this->input->post("end_time");
            $day = $this->input->post("day_id");
            $this->db->where("employee_id",$id);
            $this->db->delete("service_time_available");
            foreach($start as $key=>$val){
                $service = array(
                    "employee_id" => $id,
                    //"service_time_available"=>$val,
                    "service_day"=> $day[$key],
                    "service_start_time" => $start[$key],
                    "service_end_time" => $end[$key],
                    );
                $this->db->insert("service_time_available",$service);
                
            }

            $log_array = array_merge($data['values'],$insert_array);

            $logs = array(
                "content" => serialize($log_array),
                "action" => "Edit",
                "module" => "Manage Supplier",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);

            $this->session->set_flashdata('success_message', 'Contractor edited Successfully');
            redirect('supplier/listall');
        } else {
         $data['levels'] = $this->suppliermodel->employeeLevel();
         $data['positions'] = $this->suppliermodel->employeePosition();
         $data['transports'] = $this->suppliermodel->employeetransport();
         $data['types'] = $this->suppliermodel->employeeType();
         $data['days'] = $this->suppliermodel->get_service_day();
         $id = $this->uri->segment(3);
         $query = $this->suppliermodel->getdata($id);
         if ($query->num_rows() > 0) {
            $data['result'] 	= $query->row();
            $data['page'] 		= 'edit';
            $data['heading'] 	= 'Edit Chat';
            $this->load->view('main', $data);
        } else {
            redirect('supplier/listall');
        }
    }
}
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("userid"=>$delid);
        $content = $this->usermodel->getDeletedData('users',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Supplier",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->suppliermodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('supplier/listall');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------detail---------------------------------
function detail() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
        $id = $this->uri->segment(3);
        $query = $this->industrymodel->getdata($id);
        if ($query->num_rows() > 0) {
            $data['result'] = $query->row();
            $row = $query->row();
            $query->free_result();
            $data['title'] = $row->option_name.' - Option';
            $data['page'] = 'detail';
            $this->load->view('main', $data);
        } else {
            redirect('industry/listall');
        }
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
        $cond = array("userid"=>$delid);
        $content = $this->usermodel->getDeletedData('users',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Supplier",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->suppliermodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}