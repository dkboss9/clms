<?php
class checkin_report extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('check_in/check_inmodel');
        $this->load->model('users/usermodel');
        $this->load->model('lms_project/lms_projectmodel');
        $this->module_code = 'checkin_report';
        $this->load->library('html2pdf');
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('checkin_report/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function listall(){
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['period'] = $this->input->get("period") ? '1' : ''; 

            $data['staff'] = $this->input->get("staff");
            $data['date'] = $this->input->get("date");
            $data['activity_from_date'] = $this->input->get("activity_from_date");
            $data['activity_to_date'] = $this->input->get("activity_to_date");
           
            $data["users"] = $this->check_inmodel->get_users();
            if($this->input->get("fm"))
            $data["attendences"] = $this->check_inmodel->get_allAttendences($data);
            else
            $data["attendences"] = [];
            $data['page'] 			= 'list_all';
            $data['get_url'] = $this->input->get() ?  http_build_query($this->input->get()) : '';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
  

    function export(){
     
        $data['period'] = $this->input->get("period") ? '1' : ''; 
        $data['staff'] = $this->input->get("staff");
        $data['date'] = $this->input->get("date");
        $data['activity_from_date'] = $this->input->get("activity_from_date");
        $data['activity_to_date'] = $this->input->get("activity_to_date");
        
        $data["users"] = $this->check_inmodel->get_users();
        $attendences = $this->check_inmodel->get_allAttendences($data);

        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"Check-in list ".date("d-m-Y").".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array(
            'Staff Name',
            'Date',
            'Check In Time',
            'Daily Standup',
            'Clock Out Time',
            'Updates',
        ));
        foreach ($attendences as $row) {
           

            fputcsv($handle, array(
                $row->first_name.' '.$row->last_name,
                date("d-m-Y",strtotime($row->register_date)),
                $row->checkin_at ? date("h:i a",strtotime($row->checkin_at)) : '',
                nl2br($row->checkin_note),
                $row->checkout_at ? date("h:i a",strtotime($row->checkout_at)):'',
                nl2br($row->checkout_note)
           ));
        }

        fclose($handle);
        exit;
    }

    function pdf(){
        $data['period'] = $this->input->get("period") ? '1' : ''; 
        $data['staff'] = $this->input->get("staff");
        $data['date'] = $this->input->get("date");
        $data['activity_from_date'] = $this->input->get("activity_from_date");
        $data['activity_to_date'] = $this->input->get("activity_to_date");
        
        $data["users"] = $this->check_inmodel->get_users();
        $data['attendences'] = $this->check_inmodel->get_allAttendences($data);

        if(file_exists('./uploads/pdf/checkin.pdf'))
            unlink( './uploads/pdf/checkin.pdf');

        $this->load->helper('download');
        $this->html2pdf->folder('./uploads/pdf/');
        $this->load->model("quote/quotemodel");

		
		$data['company'] = $this->quotemodel->getCompanyDetails($this->session->userdata("clms_front_companyid"));
		$content = $this->load->view('pdf', $data, true);
		
		$file = 'checkin.pdf';
		$this->html2pdf->filename($file);
		$this->html2pdf->paper('a4', 'potrait');
		$this->html2pdf->html($content);
        $this->html2pdf->create('save');
        
        $path = './uploads/pdf/checkin.pdf';
        $pth    =   file_get_contents('./uploads/pdf/checkin.pdf');
        $nme    =   "attendence-".date("d-m-Y").".pdf";
        force_download($nme, $pth);  
    }

    

}