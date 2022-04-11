<?php
class Download extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('downloadmodel');
        $this->load->model('student/studentmodel');
        $this->load->model('appointment/appointmentmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'download';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('dashboard/download', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['access'] 	= $this->downloadmodel->listall();
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
            /* if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }
            */
            $userdata = $this->session->userdata("clms_userid");
            $date = date("Y-m-d");
            $data['values']['type_name']	= $this->input->post('name');
            $data['values']['company_id']      = $this->session->userdata("clms_company");
            $data['values']['doc_type']   = $this->input->post('doc_type');
            $data['values']['doc_desc']  = $this->input->post('doc_desc');
            $config['upload_path'] = '../uploads/student_documents';
            $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xml|rar|zip';
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['max_size'] = 0;
            $config['encrypt_name'] = FALSE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('doc_name'))
            {
                $error = array('error' => $this->upload->display_errors());
               // print_r($error);
            }
            else
            {
                $arr_image = $this->upload->data();
                $data['values']['doc_name']      = $arr_image['file_name'];
            }
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->downloadmodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Lead Type",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Form to download added successfully');
            redirect('dashboard/download');
        }else{
            $data['doc_type'] = $this->studentmodel->get_docType();
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
        if ($this->input->post('submit')) {
            $id = $this->input->post('type_id');
            $userdata = $this->session->userdata("clms_userid");
            $data['values']['type_name']    = $this->input->post('name');
            $data['values']['doc_type']   = $this->input->post('doc_type');
            $data['values']['doc_desc']  = $this->input->post('doc_desc');
            $config['upload_path'] = '../uploads/student_documents';
            $config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xml|rar|zip';
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['max_size'] = 0;
            $config['encrypt_name'] = FALSE;
            $this->upload->initialize($config);
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('doc_name'))
            {
                $error = array('error' => $this->upload->display_errors());
               // print_r($error);
            }
            else
            {
                $arr_image = $this->upload->data();
                $data['values']['doc_name']      = $arr_image['file_name'];
            }
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->downloadmodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Lead Type",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'From to download edited Successfully');
            redirect('dashboard/download');
        } else {
            $id = $this->uri->segment(3);
            $data['doc_type'] = $this->studentmodel->get_docType();
            $query = $this->downloadmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('dashboard/download');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("type_id"=>$delid);
        $content = $this->usermodel->getDeletedData('download',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Type",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->downloadmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Form to download deleted successfully');
        redirect('dashboard/download');
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
        $content = $this->usermodel->getDeletedData('download',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Business Category",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->downloadmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}