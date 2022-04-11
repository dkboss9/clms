<?php
class Industry extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('industrymodel');
		$this->load->model('users/usermodel');
		$this->module_code = 'INDUSTRY';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('industry/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $config['base_url'] = base_url() . 'industry/listall/';
            $config['uri_segment'] = 3;
            $config['per_page'] = 20;
            $config['cur_tag_open'] = '<span class="active">';
            $config['cur_tag_close'] = '</span>';
            $config['first_link'] = FALSE;
            $config['last_link'] = FALSE;
            $config['display_pages'] = FALSE;
            $config['next_link'] = '<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>';
            $config['prev_link'] = '<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>';
            $config['next_link_disabled'] = '<button type="button" disabled class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></button>';
            $config['prev_link_disabled'] = '<button type="button" disabled class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></button>';
            $config['next_tag_open'] = '';
            $config['next_tag_close'] = '';
            $config['prev_tag_open'] = '';
            $config['prev_tag_close'] = '';
            $config['num_tag_open'] = '';
            $config['num_tag_close'] = '';
            $query = $this->industrymodel->listall();
            $config['total_rows'] = $query->num_rows();
            $this->pagination->initialize($config);
            $query->free_result();
            $page = $this->uri->segment(3, 0);
            $limit = array("start" => $config['per_page'], "end" => $page);
            $query = $this->industrymodel->listall($limit);
            if ($query->num_rows() > 0) {
                $industries = '';
                foreach ($query->result() as $row):
					$publish = ($row->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
                    $industries .= '<tr>
									<td><input type="checkbox" class="checkone" value="' . $row->industry_id . '" /></td>
									<td>' . $row->industry_name . '</td>
									<td>'.anchor('industry/edit/'.$row->industry_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;'.anchor('industry/delete/'.$row->industry_id,'<span class="glyphicon glyphicon-trash"></span>',array('onclick'=>"if(confirmationBox()){return true;} return false;")).'</td>';
                    $industries .= '</tr>';
                endforeach;
                $query->free_result();
            }else {
                $industries = '';
                $industries .= '<tr><td colspan="4" style="text-align:center;">No records exist.</td></tr>';
            }

            $initial = ($page + 1) > $config['total_rows'] ? $config['total_rows'] : ($page + 1);
            $final = ($page + $config['per_page']);
            $string = $initial . " - " . (($config['total_rows'] > $final) ? $final : $config['total_rows']) . " of " . $config['total_rows'];
            $data['heading'] 		= 'Industries';
            $data['pagenumbers'] 	= $string;
            $data['industries'] 	= $industries;
            $data['pagination'] 	= $this->pagination->create_links();
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
                $userdata = $this->session->userdata("clms_userid");
                $date = date("Y-m-d");
                $data['values']['industry_name']	= $this->input->post('industry_name');
                $data['values']['added_date'] 		= $date;
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= $date;
                $data['values']['modified_by'] 		= $userdata;
                $this->industrymodel->add($data['values']);
                $this->session->set_flashdata('success', 'Industry added successfully');
                redirect('industry/listall');
            }else{
                $data['page'] = 'add';
                $data['heading'] = 'Add Industry';
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
                $id = $this->input->post('id');
                $userdata = $this->session->userdata("clms_userid");
                $date = date("Y-m-d");
                $data['values']['industry_name']	= $this->input->post('industry_name');
                $data['values']['modified_date']= $date;
                $data['values']['modified_by'] 	= $userdata;
                $data['values']['status'] = $this->input->post('status');
                $this->industrymodel->update($id, $data['values']);
                $this->session->set_flashdata('success', 'Industry edited Successfully');
                redirect('industry/listall');
            } else {
                $id = $this->uri->segment(3);
                $query = $this->industrymodel->getdata($id);
                if ($query->num_rows() > 0) {
                    $data['result'] 	= $query->row();
                    $data['page'] 		= 'edit';
                    $data['heading'] 	= 'Edit Option';
                    $this->load->view('main', $data);
                } else {
                    redirect('industry/listall');
                }
            }
        }
    }

    //------------------------delete---------------------------------------------------------	
    function delete() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
            $delid = $this->uri->segment('3');
            $this->industrymodel->delete($delid);
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('industry/listall');
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
        $query = $this->industrymodel->cascadeAction($ids, $action);
        $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
        echo '';
        exit();
    }

}