<?php
class Picture extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('picturemodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'PICTURE';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('picture/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['pictures'] 	= $this->picturemodel->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function upload(){
        $filename = date('YmdHis') . '.jpg';
        $result = file_put_contents( './webcam/images/'.$filename, file_get_contents('php://input') );
        if (!$result) {
            print "ERROR: Failed to write data to $filename, check permissions\n";
            exit();
        }

        $url = base_url("webcam/"). '/images/' . $filename;
        print "$url\n";
        if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
            redirect($_SERVER["HTTP_REFERER"],"refresh");
        }
        $img_array = array(
            "picture_name"=>$filename,
            "company_id" => $this->session->userdata("clms_front_companyid"),
            "added_date" => time(),
            "added_by" => $this->session->userdata("clms_front_userid"),
            "modified_date" => time(),
            "modified_by" => $this->session->userdata("clms_front_userid"),
            "status" => 1
            );
        $this->picturemodel->add($img_array);
        $logs = array(
            "content" => serialize($img_array),
            "action" => "Add",
            "module" => "Manage Picture",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);

    }

    //--------------------------------------add--------------------------------------	
    function add() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {

                $userdata = $this->session->userdata("clms_front_userid");
                $date = date("Y-m-d");
                $data['values']['start_name']	= $this->input->post('name');
                $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= time();
                $data['values']['modified_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->picturemodel->add($data['values']);
                $this->session->set_flashdata('success_message', 'When Start added successfully');
                redirect('picture/listall');
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
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
            if ($this->input->post('submit')) {
                $id = $this->input->post('start_id');
                $userdata = $this->session->userdata("clms_front_userid");
                $data['values']['start_name']    = $this->input->post('name');
                $data['values']['added_date']       = time();
                $data['values']['added_by']         = $userdata;
                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $this->picturemodel->update($id, $data['values']);
                $this->session->set_flashdata('success_message', 'When Start edited Successfully');
                redirect('start/listall');
            } else {
                $id = $this->uri->segment(3);
                $query = $this->picturemodel->getdata($id);
                if ($query->num_rows() > 0) {
                    $data['result'] 	= $query->row();
                    $data['page'] 		= 'edit';
                    $data['heading'] 	= 'Edit Chat';
                    $this->load->view('main', $data);
                } else {
                    redirect('start/listall');
                }
            }
        }
    }

//------------------------delete---------------------------------------------------------	
    function delete() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
            $delid = $this->uri->segment('3');
            $cond = array("picture_id"=>$delid);
            $content = $this->usermodel->getDeletedData('picture',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => "Delete",
                "module" => "Manage Picture",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->picturemodel->delete($delid);
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('picture/listall');
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
            $cond = array("picture_id"=>$delid);
            $content = $this->usermodel->getDeletedData('picture',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => $action,
                "module" => "Manage Picture",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs); 
        }
        $query = $this->picturemodel->cascadeAction($ids, $action);
        $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
// echo $this->db->last_query();
        exit();
    }

}