<?php
class Customer_Role extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('customerrolemodel');
		$this->load->model('users/usermodel');
		$this->module_code = 'ROLE';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('customer_role/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $config['base_url'] = base_url() . 'customer_role/listall/';
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
            $query = $this->customerrolemodel->listall();
            $config['total_rows'] = $query->num_rows();
            $this->pagination->initialize($config);
            $query->free_result();
            $page = $this->uri->segment(3, 0);
            $limit = array("start" => $config['per_page'], "end" => $page);
            $query = $this->customerrolemodel->listall($limit);
            if ($query->num_rows() > 0) {
                $roles = '';
                foreach ($query->result() as $row):
					$publish = ($row->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
                    $roles .= '<tr>
									<td><input type="checkbox" class="checkone" value="' . $row->role_id . '" /></td>
									<td>' . $row->role_name . '</td>
									<td>'.anchor('customer_role/edit/'.$row->role_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;'.anchor('customer_role/delete/'.$row->role_id,'<span class="glyphicon glyphicon-trash"></span>',array('onclick'=>"if(confirmationBox()){return true;} return false;")).'</td>';
                    $roles .= '</tr>';
                endforeach;
                $query->free_result();
            }else {
                $roles = '';
                $roles .= '<tr><td colspan="4" style="text-align:center;">No records exist.</td></tr>';
            }

            $initial = ($page + 1) > $config['total_rows'] ? $config['total_rows'] : ($page + 1);
            $final = ($page + $config['per_page']);
            $string = $initial . " - " . (($config['total_rows'] > $final) ? $final : $config['total_rows']) . " of " . $config['total_rows'];
            $data['heading'] 		= 'Roles';
            $data['pagenumbers'] 	= $string;
            $data['roles'] 			= $roles;
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
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
            if ($this->input->post('submit')) {
                $userdata = $this->session->userdata("clms_front_userid");
                $date = date("Y-m-d");
                $data['values']['role_name']	= $this->input->post('role_name');
                $data['values']['added_date'] 		= $date;
                $data['values']['added_by'] 		= $userdata;
                $data['values']['modified_date'] 	= $date;
                $data['values']['modified_by'] 		= $userdata;
                $this->customerrolemodel->add($data['values']);
                $this->session->set_flashdata('success', 'Hear From added successfully');
                redirect('customer_role/listall');
            }else{
                $data['page'] = 'add';
                $data['heading'] = 'Add Role';
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
                $id = $this->input->post('id');
                $userdata = $this->session->userdata("clms_front_userid");
                $date = date("Y-m-d");
                $data['values']['role_name']	= $this->input->post('role_name');
                $data['values']['modified_date']= $date;
                $data['values']['modified_by'] 	= $userdata;
                $data['values']['status'] = $this->input->post('status');
                $this->customerrolemodel->update($id, $data['values']);
                $this->session->set_flashdata('success', 'Hear From edited Successfully');
                redirect('customer_role/listall');
            } else {
                $id = $this->uri->segment(3);
                $query = $this->customerrolemodel->getdata($id);
                if ($query->num_rows() > 0) {
                    $data['result'] 	= $query->row();
                    $data['page'] 		= 'edit';
                    $data['heading'] 	= 'Edit Role';
                    $this->load->view('main', $data);
                } else {
                    redirect('customer_role/listall');
                }
            }
        }
    }

    //------------------------delete---------------------------------------------------------	
    function delete() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
            $delid = $this->uri->segment('3');
            $this->customerrolemodel->delete($delid);
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('customer_role/listall');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //---------------------detail---------------------------------
    function detail() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $id = $this->uri->segment(3);
            $query = $this->customerrolemodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] = $query->row();
				$row = $query->row();
				$query->free_result();
                $data['title'] = $row->option_name.' - Option';
                $data['page'] = 'detail';
                $this->load->view('main', $data);
            } else {
                redirect('customer_role/listall');
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
        $query = $this->customerrolemodel->cascadeAction($ids, $action);
        $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
        echo '';
        exit();
    }

}