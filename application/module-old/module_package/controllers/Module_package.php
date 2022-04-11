<?php
class module_package extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('module_packagemodel');
        $this->load->model('company/companymodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'module_package';
    }

    function index() {
        // print_r($this->session->userdata); die();
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('module_package/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall-------------------------------------------------- 
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['status']     = $this->module_packagemodel->listall();
            $data['page']           = 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function assign_dashboard(){
        if ($this->session->userdata("clms_front_userid") != "") {
            if($this->input->post("submit")){
                $userid = $this->input->post("user_id");
                $this->db->where("package_id",$userid);
                $this->db->delete("dashboard_package");
                if($this->input->post("section")){
                    $sections = $this->input->post("section");
                    foreach ($sections as $key => $value) {
                        $insert_arr = array("section_id"=>$value,"package_id"=>$userid);
                        $this->db->insert("dashboard_package",$insert_arr);
                    }
                }
                redirect('module_package/listall', 'location');
            }else{
                $id = $this->uri->segment(3);
                $data['result'] = $this->usermodel->listDashboardSections();
                $data['userid'] = $id;
                $this->load->view('dashboard_assign', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //--------------------------------------add--------------------------------------   
    function add() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {

                $userdata = $this->session->userdata("clms_front_userid");
                $date = date("Y-m-d");
                $data['values']['name'] = $this->input->post('name');
                $data['values']['txt_month'] = $this->input->post('txt_month');
                $data['values']['txt_month_discount'] = $this->input->post('txt_month_discount');
                $data['values']['txt_3month'] = $this->input->post('txt_3month');
                $data['values']['txt_3month_discount'] = $this->input->post('txt_3month_discount');
                $data['values']['txt_6month'] = $this->input->post('txt_6month');
                $data['values']['txt_6month_discount'] = $this->input->post('txt_6month_discount');
                $data['values']['txt_12month'] = $this->input->post('txt_12month');
                $data['values']['txt_12month_discount'] = $this->input->post('txt_12month_discount');
                $data['values']['company_id'] = $this->session->userdata("clms_front_companyid");
                $data['values']['added_date']       = time();
                $data['values']['added_by']         = $userdata;
                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $data['values']['status']      = 1;
                $this->module_packagemodel->add($data['values']);

                $id = $this->db->insert_id();

                if($this->input->post("desc")){

                    $desc = $this->input->post("desc");

                    foreach($desc as $key=>$val){
                        if($val != ""){
                            $arr_desc = array("package_id"=>$id,"package_desc"=>$val);
                            $this->db->insert("package_desc",$arr_desc);
                        }
                    }
                }

                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Add",
                    "module" => "Manage package",
                    "added_by" => $this->session->userdata("clms_front_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);

                $this->session->set_flashdata('success_message', 'Package added successfully');
                redirect('module_package/listall');
            }else{
                $data['page'] = 'add';
                $data['heading'] = 'Add Lead Status';
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
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
            if ($this->input->post('submit')) {
                $id = $this->input->post('status_id');
                $userdata = $this->session->userdata("clms_front_userid");
                $data['values']['name']    = $this->input->post('name');
                $data['values']['txt_month'] = $this->input->post('txt_month');
                $data['values']['txt_month_discount'] = $this->input->post('txt_month_discount');
                $data['values']['txt_3month'] = $this->input->post('txt_3month');
                $data['values']['txt_3month_discount'] = $this->input->post('txt_3month_discount');
                $data['values']['txt_6month'] = $this->input->post('txt_6month');
                $data['values']['txt_6month_discount'] = $this->input->post('txt_6month_discount');
                $data['values']['txt_12month'] = $this->input->post('txt_12month');
                $data['values']['txt_12month_discount'] = $this->input->post('txt_12month_discount');
                $data['values']['added_date']       = time();
                $data['values']['added_by']         = $userdata;
                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $this->module_packagemodel->update($id, $data['values']);

                $this->db->where("package_id",$id);
                $this->db->delete("package_desc");

                if($this->input->post("desc")){
                   $desc = $this->input->post("desc");
                   foreach($desc as $key=>$val){
                    if($val != ""){
                        $arr_desc = array("package_id"=>$id,"package_desc"=>$val);
                        $this->db->insert("package_desc",$arr_desc);
                    }
                }
            }
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage package",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);


            $this->session->set_flashdata('success_message', 'package edited Successfully');
            redirect('module_package/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->module_packagemodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result']     = $query->row();
                $data['page']       = 'edit';
                $data['heading']    = 'Edit Lead status';
                $this->load->view('main', $data);
            } else {
                redirect('module_package/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------   
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("package_id"=>$delid);
        $content = $this->usermodel->getDeletedData('module_package',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage package",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->module_packagemodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('module_package/listall');
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
        $cond = array("package_id"=>$delid);
        $content = $this->usermodel->getDeletedData('module_package',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage package",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->module_packagemodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

function permission($package_id){
 if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
    if ($this->input->post('submit')) {
        $chk_permission = $_POST['chk_permission'];
        $login_id = $this->session->userdata("clms_front_userid");
            //$package_id = $this->uri->segment(3);
        $this->module_packagemodel->updatepackage_perm($chk_permission, $package_id, $login_id);
        $this->companymodel->updateModule_perm($package_id);                     
        $this->session->set_flashdata('success_message', 'Package Permission Saved Successfully.');
        redirect('module_package', 'location');

    } else {

     $group_id = $this->uri->segment(3);
     $parentmodules = $this->usermodel->listmodule();
     $grouppermissions = '';
     if (count($parentmodules) > 0) {                        
        foreach ($parentmodules as $parent_module_row):
                            //---------------------For Parent Menu Access---------------------------------                      
            $grouppermissions .= '<tr>';
        $grouppermissions .= '<td><strong>'. $parent_module_row['menu_name'] . '</strong></td>';    
        $permission = $this->module_packagemodel->checkpackage_permision($parent_module_row['menuid'],1, $package_id);
        $checkbox_id = $parent_module_row['menuid'] ."_1";
        if($permission)
            $checked = "checked = 'checked'";
        else
            $checked = "";
        $checkbox = "<input value='". $checkbox_id . "' name='chk_permission[]' class='chk_module' type='checkbox' ". $checked . "/>";
        $grouppermissions .= '<td colspan="4">Access&nbsp;&nbsp;' . $checkbox . '</td>';
        $grouppermissions .= '</tr>';   
                            //---------------------End Parent Menu Access---------------------------------

        $qrymodules = $this->usermodel->listmodule($parent_module_row['menuid']);
        if (count($qrymodules) > 0) {
            foreach ($qrymodules as $module_row):
                $grouppermissions .= '<tr>';
            $grouppermissions .= '<td>'. $module_row['menu_name'] . '</td>';
            $qryuseraction = $this->usermodel->listuseraction();
            if(count($qryuseraction) > 0 ){                 
                foreach ($qryuseraction as $action_row):
                    $permission = $this->module_packagemodel->checkpackage_permision($module_row['menuid'], $action_row['user_action_id'], $group_id);
                $checkbox_id = $module_row['menuid'] ."_". $action_row['user_action_id'];
                if($permission)
                    $checked = "checked = 'checked'";
                else
                    $checked = "";
                $checkbox = "<input value='". $checkbox_id . "' class='chk_module' name='chk_permission[]' type='checkbox' ". $checked . "/>";
                $grouppermissions .= '<td>'.  $action_row['user_action_name']. '&nbsp;&nbsp;' . $checkbox . '</td>';
                endforeach;
            }
            $grouppermissions .= '</tr>';   
            endforeach; 
        }
        endforeach  ;


        $data['heading'] = "Group Permissions";
        $data['page'] = 'permission';
        $data['grouppermissions'] = $grouppermissions;
        $this->load->view('main', $data);                                  
    }else {
        redirect('users/', 'location');
    }
}
}else{
    $this->session->set_flashdata('error','Please login with your username and password');
    redirect('login','location');
}
}

}