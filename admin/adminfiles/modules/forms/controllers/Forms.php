<?php

class Forms extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('formsmodel');
        $this->module_code = 'Forms';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['forms'] = $this->formsmodel->listall();
            $data['page'] = 'index';
            $data['heading'] = 'Forms List';
            $this->load->vars($data);
            $this->load->view($this->container);
            //$this->addform();
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }

    }

    function add() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post("submit")) {
                if (sizeof($_POST) > 0) {
                    $catid = $this->input->post("category");
                    $importData = array(
                        "forms_template" => serialize($_POST['form']),
                        "forms_status" => 1,
                        "forms_added" => date("Y-m-d h:i:s"),
                        "company_id" =>  $this->session->userdata("clms_company"),
                        "module_name" => $this->input->post("maincat")
                        );
                    $this->formsmodel->insert_form($importData);
                    $this->session->set_flashdata('success_message', 'Form added successfully');
                    redirect("forms/", "refresh");
                } else {
                    redirect("forms/addform", "refresh");
                }
            } else {

                $data['page'] = 'addform';
                $data['heading'] = 'Add Forms';
                $this->load->vars($data);
                $this->load->view($this->container);
            }
        }else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }



    function edit($formid) {
     if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post("submit")) {
            $catid = $this->input->post("category");
            $importData = array(
                "forms_template" => serialize($_POST['form']),
                "forms_status" => 1,
                "forms_modified" => date("Y-m-d h:i:s"),
                "company_id" =>  $this->session->userdata("clms_company"),
                "module_name" => $this->input->post("maincat")
                );

            $this->formsmodel->update_form($importData, $formid);
            $this->session->set_flashdata('success_message', 'Form Updated successfully');
            redirect("forms/", "refresh");
        } else {
            $data["form"] = $this->formsmodel->getformdetail($formid);
            $data['page'] = 'editform';
            $data['heading'] = 'Add Forms';
            $this->load->vars($data);
            $this->load->view($this->container);
        }
    }else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

function delete() {
    if ($this->session->userdata("clms_userid") != "") {
        $formid = $this->uri->segment(3);
        $this->db->where("forms_id", $formid);
        $this->db->delete("form");
        $this->session->set_flashdata('success_message', 'Form deleted successfully');
        redirect('forms','location');
    }
}

}

?>