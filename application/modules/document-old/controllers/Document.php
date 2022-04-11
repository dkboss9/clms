<?php
class document extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('documentmodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'Manage-Document';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('document/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['categories'] 	= $this->documentmodel->getdocument();
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
                $data['values']['name']	= $this->input->post('name');
                $data['values']['company_id'] = $this->session->userdata("clms_front_companyid");
                $data['values']['content'] = $this->input->post('details');


                $config['upload_path'] = './uploads/document';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 0;
                $config['encrypt_name'] = FALSE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('list_image'))
                {
                    $error = array('error' => $this->upload->display_errors());

                   // print_r($error);
                }
                else
                {
                    $arr_image = $this->upload->data();
                   // $thumb = $this->_createThumbnail('./assets/uploads/document/' . $arr_image['file_name'], './assets/uploads/document/thumb',700,450);
                    $data['values']['image']              = $arr_image['file_name']; 
                   // $data['values']['thumb']              = $thumb["dst_file"];
                }


                $data['values']['added_date'] 		= time();
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= time();
                $data['values']['modified_by'] 		= $userdata;
                $data['values']['status']      = 1;
                $this->documentmodel->add($data['values']);
                $this->session->set_flashdata('success_message', 'document added successfully');
                redirect('document/listall');
            }else{

                $data['page'] = 'add';
                $data['heading'] = 'Add Lead document';
                $this->load->vars($data);
                $this->load->view($this->container);
            }
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }


    function _createThumbnail($fileName, $thumb, $width=100, $height=100) {
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $fileName;
        $config['new_image'] = FCPATH . $thumb;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] =  $width;
        $config['height'] = $height;

        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
            return false;
        }
        return $this->image_lib->data();
    }
    //---------------------------------edit--------------------------------------
    function edit() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
            if ($this->input->post('submit')) {
                $id = $this->input->post('content_id');
                $userdata = $this->session->userdata("clms_front_userid");
                $data['values']['name']  = $this->input->post('name');
                $data['values']['content'] = $this->input->post('details');


                $config['upload_path'] = './uploads/document';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['max_size'] = 0;
                $config['encrypt_name'] = FALSE;
                $this->upload->initialize($config);
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('list_image'))
                {
                    $error = array('error' => $this->upload->display_errors());

    //print_r($error);
                }
                else
                {
                    $arr_image = $this->upload->data();
                   // $thumb = $this->_createThumbnail('./assets/uploads/document/' . $arr_image['file_name'], './assets/uploads/document/thumb',700,450);
                    $data['values']['image']              = $arr_image['file_name']; 
                  //  $data['values']['thumb']              = $thumb["dst_file"];
                }

                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $data['values']['status']      = 1;
                $this->documentmodel->update($id, $data['values']);
                $this->session->set_flashdata('success_message', 'document edited Successfully');
                redirect('document/listall');
            } else {

                $id = $this->uri->segment(3);
                $query = $this->documentmodel->getdata($id);
                if ($query->num_rows() > 0) {
                    $data['result'] 	= $query->row();
                    $data['page'] 		= 'edit';
                    $data['heading'] 	= 'Edit Lead document';
                    $this->load->view('main', $data);
                } else {
                    redirect('document/listall');
                }
            }
        }
    }

    //------------------------delete---------------------------------------------------------	
    function delete() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
            $delid = $this->uri->segment('3');
            $this->documentmodel->delete($delid);
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('document/listall');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }



    function cascadeAction() {
        $data = $_POST['object'];
        $ids = $data['ids'];
        $action = $data['action'];
        $query = $this->documentmodel->cascadeAction($ids, $action);
        $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
        exit();
    }

    

}