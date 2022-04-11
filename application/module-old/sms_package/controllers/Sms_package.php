<?php
class sms_package extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('sms_packagemodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'sms_package';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('sms_package/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['status'] 	= $this->sms_packagemodel->listall();
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
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {

                $userdata = $this->session->userdata("clms_front_userid");
                $date = date("Y-m-d");
                $data['values']['credits']	= $this->input->post('credits');
                $data['values']['price'] = $this->input->post('price');
                $data['values']['company_id'] = $this->session->userdata("clms_front_companyid");
                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= time();
                $data['values']['modified_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->sms_packagemodel->add($data['values']);

                $id = $this->db->insert_id();


                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Add",
                    "module" => "Manage sms package",
                    "added_by" => $this->session->userdata("clms_front_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);

                $this->session->set_flashdata('success_message', 'Package added successfully');
                redirect('sms_package/listall');
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
                $data['values']['credits']   = $this->input->post('credits');
                $data['values']['price'] = $this->input->post('price');
                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $this->sms_packagemodel->update($id, $data['values']);

                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Edit",
                    "module" => "Manage sms_package",
                    "added_by" => $this->session->userdata("clms_front_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);


                $this->session->set_flashdata('success_message', 'Sms package edited Successfully');
                redirect('sms_package/listall');
            } else {
                $id = $this->uri->segment(3);
                $query = $this->sms_packagemodel->getdata($id);
                if ($query->num_rows() > 0) {
                    $data['result'] 	= $query->row();
                    $data['page'] 		= 'edit';
                    $data['heading'] 	= 'Edit Lead status';
                    $this->load->view('main', $data);
                } else {
                    redirect('sms_package/listall');
                }
            }
        }
    }

    //------------------------delete---------------------------------------------------------	
    function delete() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
            $delid = $this->uri->segment('3');
            $cond = array("sms_package_id"=>$delid);
            $content = $this->usermodel->getDeletedData('sms_package',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => "Delete",
                "module" => "Manage sms_package",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->sms_packagemodel->delete($delid);
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('sms_package/listall');
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
            $cond = array("sms_package_id"=>$delid);
            $content = $this->usermodel->getDeletedData('sms_package',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => $action,
                "module" => "Manage sms_package",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs); 
        }
        $query = $this->sms_packagemodel->cascadeAction($ids, $action);
        $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
        exit();
    }

    function permission($sms_package_id){
     if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $chk_permission = $_POST['chk_permission'];
            $login_id = $this->session->userdata("clms_front_userid");
            //$sms_package_id = $this->uri->segment(3);
            $this->sms_packagemodel->updatesms_package_perm($chk_permission, $sms_package_id, $login_id);
            $this->companymodel->updateModule_perm($sms_package_id);                     
            $this->session->set_flashdata('success_message', 'sms_package Permission Saved Successfully.');
            redirect('sms_package', 'location');

        } else {

         $group_id = $this->uri->segment(3);
         $parentmodules = $this->usermodel->listmodule();
         $grouppermissions = '';
         if (count($parentmodules) > 0) {                        
            foreach ($parentmodules as $parent_module_row):
                            //---------------------For Parent Menu Access---------------------------------                      
                $grouppermissions .= '<tr>';
            $grouppermissions .= '<td><strong>'. $parent_module_row['menu_name'] . '</strong></td>';    
            $permission = $this->sms_packagemodel->checksms_package_permision($parent_module_row['menuid'],1, $sms_package_id);
            $checkbox_id = $parent_module_row['menuid'] ."_1";
            if($permission)
                $checked = "checked = 'checked'";
            else
                $checked = "";
            $checkbox = "<input value='". $checkbox_id . "' name='chk_permission[]' type='checkbox' ". $checked . "/>";
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
                        $permission = $this->sms_packagemodel->checksms_package_permision($module_row['menuid'], $action_row['user_action_id'], $group_id);
                    $checkbox_id = $module_row['menuid'] ."_". $action_row['user_action_id'];
                    if($permission)
                        $checked = "checked = 'checked'";
                    else
                        $checked = "";
                    $checkbox = "<input value='". $checkbox_id . "' name='chk_permission[]' type='checkbox' ". $checked . "/>";
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