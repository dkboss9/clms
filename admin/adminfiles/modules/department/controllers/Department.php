<?php
class Department extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('departmentmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'department';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('department/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['departments'] 	= $this->departmentmodel->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //--------------------------------------add--------------------------------------	
    function add() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {
               if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }
            $userdata = $this->session->userdata("clms_userid");
            $date = date("Y-m-d");
            $data['values']['name']	= $this->input->post('name');
            $data['values']['company_id']      = $this->session->userdata("clms_company");
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->departmentmodel->add($data['values']);
            $id = $this->db->insert_id();
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage department",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            if($this->input->post("action") == 'add'){
                echo $id; die();
            }

            $this->session->set_flashdata('success_message', 'Department added successfully');
            redirect('department/listall');
        }else{
            $data['page'] = 'add';
            $data['heading'] = 'Add Chat Name';
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
        if ($this->input->post('submit')) {
            $id = $this->input->post('department_id');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['name']    = $this->input->post('name');
            $data['values']['added_date']       = time();
            $data['values']['added_by']         = $userdata;
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->departmentmodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage department",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'When department edited Successfully');
            redirect('department/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->departmentmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('department/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('department',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage department",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->departmentmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('department/listall');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

function edit_department_perm() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('txt_permission')) {						
            $chk_permission = $_POST['chk_permission'];
            $login_id = $this->session->userdata("clms_userid"); 
            $department_id = $this->uri->segment(3);
            $this->departmentmodel->updatedepartment_permision($chk_permission, $department_id, $login_id);
            $this->session->set_flashdata('success_message', 'Group Permission Saved Successfully.');
            redirect('department/listall', 'location');
            
        } else {
            $departmentid = $this->uri->segment(3);
            $parentmodules = $this->usermodel->listmodule();
            $grouppermissions = '';
            if (count($parentmodules) > 0) {						
                foreach ($parentmodules as $parent_module_row):
                    //---------------------For Parent Menu Access---------------------------------						
                    $grouppermissions .= '<tr>';
                $grouppermissions .= '<td><strong>'. $parent_module_row['menu_name'] . '</strong></td>';	
                $permission = $this->departmentmodel->checkgroup_permision($parent_module_row['menuid'],1, $departmentid);
                $checkbox_id = $parent_module_row['menuid'] ."_1";
                if($permission)
                    $checked = "checked = 'checked'";
                else
                    $checked = "";
                $checkbox = "<input value='". $checkbox_id . "' name='chk_permission[]' class='chk_perm' type='checkbox' ". $checked . "/>";
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
                            $permission = $this->departmentmodel->checkgroup_permision($module_row['menuid'], $action_row['user_action_id'], $departmentid);
                        $checkbox_id = $module_row['menuid'] ."_". $action_row['user_action_id'];
                        if($permission)
                            $checked = "checked = 'checked'";
                        else
                            $checked = "";
                        $checkbox = "<input value='". $checkbox_id . "' class='chk_perm' name='chk_permission[]' type='checkbox' ". $checked . "/>";
                        $grouppermissions .= '<td>'.  $action_row['user_action_name']. '&nbsp;&nbsp;' . $checkbox . '</td>';
                        endforeach;
                    }
                    $grouppermissions .= '</tr>';	
                    endforeach;	
                }
                endforeach	;
                
                $data['department'] = $this->departmentmodel->getdata($departmentid)->row();
                $data['heading'] = "Group Permissions";
                $data['page'] = 'department_modify';
                $data['grouppermissions'] = $grouppermissions;
                $this->load->view('main', $data);
            } else {
                redirect('user/listgroup', 'location');
            }
        }
    }
}



function cascadeAction() {
    $data = $_POST['object'];
    $ids = $data['ids'];
    $action = $data['action'];
    foreach ($ids as $key => $delid) {
        $cond = array("department_id"=>$delid);
        $content = $this->usermodel->getDeletedData('department',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage department",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->departmentmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}