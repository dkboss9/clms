<?php

class GeneralSettings extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('generalsettingsmodel');
		$this->load->model('users/usermodel');
		$this->module_code = 'GENERAL_SETTINGS';
		
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $results = $this->generalsettingsmodel->getdata();
            if($results->num_rows()>0){
                $data['result']=$results->result();
            }
		    $data['page'] = 'settings';
            $data['heading'] = 'General Settings';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function edit() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
			if($this->input->post('submit')){
				$config_id = $this->input->post('config_id');
				if($config_id=='24'){
					$path = './uploads/logo/';
					$ctmp = read_file($_FILES['new_logo']['tmp_name']);
					$cname = basename($_FILES['new_logo']['name']);
					$file = strtolower(substr($cname, 0, strrpos($cname, '.')));
					$ext = array("jpg", "jpeg", "gif", "png");
					if ($cname != "") {
						if (in_array(end(explode(".", $cname)), $ext)) {
							write_file($path . $cname, $ctmp);
							$mydata = array('config_value'=>$cname,
											'updated_date'=>date('Y-m-d'),
											'updated_by'=>$this->session->userdata("clms_front_userid")
							);
						}
					}
					
				}elseif($config_id=='37'){
					$path = './uploads/logo_footer/';
					$ctmp = read_file($_FILES['new_logo']['tmp_name']);
					$cname = basename($_FILES['new_logo']['name']);
					$file = strtolower(substr($cname, 0, strrpos($cname, '.')));
					$ext = array("jpg", "jpeg", "gif", "png");
					if ($cname != "") {
						if (in_array(end(explode(".", $cname)), $ext)) {
							write_file($path . $cname, $ctmp);
							$mydata = array('config_value'=>$cname,
											'updated_date'=>date('Y-m-d'),
											'updated_by'=>$this->session->userdata("clms_front_userid")
							);
						}
					}
				}else{
					$mydata = array('config_value'=>$this->input->post('config_value'),
								'updated_date'=>date('Y-m-d'),
								'updated_by'=>$this->session->userdata("clms_front_userid")
								);
				}
				$this->generalsettingsmodel->updatesettings($config_id,$mydata);
				$this->session->set_flashdata('success_message', 'Configuration value updated successfully');
				redirect('generalsettings','location');	
			}else{
				$id = $this->uri->segment(3);
				$query = $this->generalsettingsmodel->getConfigData($id);
				if($query->num_rows()>0){
					$data['row'] = $query->row();
					$row = $query->row();
					$data['heading'] = $row->config_option;
					$query->free_result();
				}else{
					redirect('generalsettings','location');	
				}
				if($id=='24'){
					$data['page'] = 'logo';
				}elseif($id=='37'){
					$data['page'] = 'footer_logo';
				}else{
					$data['page'] = 'edit';
				}
				
				$this->load->vars($data);
				$this->load->view($this->container);
			}
		} else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

}