<?php
class Announcement extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('announcementmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'ANNOUNCEMENT';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('announcement/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['announcement'] 	= $this->announcementmodel->listall();
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
                $data['values']['title']	= $this->input->post('name');
                $data['values']['company_id']      = $this->session->userdata("clms_company");
                $data['values']['content']    = $this->input->post('details');
                $dates = $this->input->post('date');
                $dates = explode("/", $dates);
                $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
                $data['values']['announcement_date']   = strtotime($date);
                //$data['values']['announcement_date']    = $this->input->post('name');
                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= time();
                $data['values']['modified_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->announcementmodel->add($data['values']);
                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Add",
                    "module" => "Manage Announcement",
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);
                $this->session->set_flashdata('success_message', 'Announcement added successfully');
                redirect('announcement/listall');
            }else{
                $data['page'] = 'add';
                $data['heading'] = 'Add ';
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
                $id = $this->input->post('announcement_id');
                $userdata = $this->session->userdata("clms_userid");
                $data['values']['title']    = $this->input->post('name');
                $data['values']['content']    = $this->input->post('details');
                $dates = $this->input->post('date');
                $dates = explode("/", $dates);
                $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
                $data['values']['announcement_date']   = strtotime($date);
                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $this->announcementmodel->update($id, $data['values']);
                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Edit",
                    "module" => "Manage Announcement",
                    "added_by" => $this->session->userdata("clms_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);
                $this->session->set_flashdata('success_message', 'Announcement edited Successfully');
                redirect('announcement/listall');
            } else {
                $id = $this->uri->segment(3);
                $query = $this->announcementmodel->getdata($id);
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
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
            $delid = $this->uri->segment('3');
            $cond = array("announcement_id"=>$delid);
            $content = $this->usermodel->getDeletedData('announcement',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => "Delete",
                "module" => "Manage Announcement",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->announcementmodel->delete($delid);
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('announcement/listall');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //---------------------detail---------------------------------
    function detail() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
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
            $cond = array("announcement_id"=>$delid);
            $content = $this->usermodel->getDeletedData('announcement',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => $action,
                "module" => "Manage Announcement",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs); 
        }
        $query = $this->announcementmodel->cascadeAction($ids, $action);
        $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
        exit();
    }

}