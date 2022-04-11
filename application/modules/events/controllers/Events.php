<?php
class Events extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('eventsmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'EVENTS';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('start/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['myevents'] 	= $this->eventsmodel->listall();
            $data['event_status']   = $this->eventsmodel->liststatus();
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
            if ($this->input->post('submit') && $this->input->post("event_id") == 0) {
                $userdata = $this->session->userdata("clms_front_userid");
                if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
                    redirect($_SERVER["HTTP_REFERER"],"refresh");
                }
                $data['values']['event_name']        = $this->input->post('name');
                $data['values']['event_details']     = $this->input->post('details');
                $data['values']['action']     = $this->input->post('event_action');
                $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
                $dates = $this->input->post('date');
                $dates = explode("/", $dates);
                $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
                $data['values']['event_date']              = strtotime($date);
                $data['values']['event_time']              = $this->input->post("event_time");
                $data['values']['reminder_time']              = $this->input->post("reminder");
                $data['values']['event_status']              = $this->input->post("event_status");
                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->eventsmodel->add($data['values']);
                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Add",
                    "module" => "Manage Event",
                    "added_by" => $this->session->userdata("clms_front_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);
                $this->session->set_flashdata('success_message', 'Event added successfully');
                redirect('events/listall');
            }elseif($this->input->post('submit') && $this->input->post("event_id") > 0){
                $userdata = $this->session->userdata("clms_front_userid");
                $data['values']['event_name']        = $this->input->post('name');
                $data['values']['event_details']     = $this->input->post('details');
                $data['values']['action']     = $this->input->post('event_action');
                $dates = $this->input->post('date');
                $dates = explode("/", $dates);
                $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
                $data['values']['event_date']              = strtotime($date);
                $data['values']['event_time']              = $this->input->post("event_time");
                $data['values']['reminder_time']              = $this->input->post("reminder");
                $data['values']['event_status']              = $this->input->post("event_status");
                $data['values']['modified_date']       = time();
                $data['values']['modified_by']         = $userdata;
                $data['values']['is_reminded']      = 0;
                $data['values']['status']      = 1;
                $this->eventsmodel->update($this->input->post("event_id"),$data['values']);
                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Edit",
                    "module" => "Manage Event",
                    "added_by" => $this->session->userdata("clms_front_userid"),
                    "added_date" => time()
                    );
                $this->usermodel->insertUserlog($logs);
                $this->session->set_flashdata('success_message', 'Event Edited successfully');
                redirect('events/listall');
            }else{
                $data['page'] = 'add';
                $data['heading'] = 'Add Event';
                $this->load->vars($data);
                $this->load->view($this->container);
            }
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function drag_event(){
        $dates = $this->input->post('date');
        $dates = explode("/", $dates);
        $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
        $data['values']['event_date']              = strtotime($date);
        $this->eventsmodel->update($this->input->post("eventid"),$data['values']);
        $this->session->set_flashdata('success_message', 'Event Edited successfully');
    }

    

    
}