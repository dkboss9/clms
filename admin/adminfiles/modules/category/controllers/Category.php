<?php
class Category extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('categorymodel');
        $this->load->model('users/usermodel');
        $this->module_code = 'PRODUCT-CATEGORY';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('category/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $config['base_url'] = base_url() . 'category/listall/';
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
            $query = $this->categorymodel->listall();
            $config['total_rows'] = $query->num_rows();
            $this->pagination->initialize($config);
            $query->free_result();
            $page = $this->uri->segment(3, 0);
            $limit = array("start" => $config['per_page'], "end" => $page);
            $query = $this->categorymodel->listall($limit);
            if ($query->num_rows() > 0) {
                $category = '';
                foreach ($query->result() as $row):
                   $publish = ($row->cat_status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
               $category .= '<tr>
               <td><input type="checkbox" class="checkone" value="' . $row->category_id . '" /></td>
               <td>'.$row->category_name. '</td>
               <td>' . $row->category_details . '</td>
               <td>'.anchor('category/edit/'.$row->category_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;'.anchor('category/delete/'.$row->category_id,'<span class="glyphicon glyphicon-trash"></span>',array('onclick'=>"if(confirmationBox()){return true;} return false;")).'</td>';
               $category .= '</tr>';
               endforeach;
               $query->free_result();
           }else {
            $category = '';
            $category .= '<tr><td colspan="4" style="text-align:center;">No records exist.</td></tr>';
        }

        $initial = ($page + 1) > $config['total_rows'] ? $config['total_rows'] : ($page + 1);
        $final = ($page + $config['per_page']);
        $string = $initial . " - " . (($config['total_rows'] > $final) ? $final : $config['total_rows']) . " of " . $config['total_rows'];
        $data['heading'] 		= 'Product Category';
        $data['pagenumbers'] 	= $string;
        $data['category'] 		= $category;
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
            $data['values']['parent_id'] 		= $this->input->post('parent_category');
            $data['values']['category_name'] 	= $this->input->post('category_name');
            $data['values']['category_details'] = $this->input->post('description');
            $data['values']['added_date'] 		= $date;
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= $date;
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['cat_status'] = "1";
            $this->categorymodel->add($data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage Lead Category",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success', 'Product category added successfully');
            redirect('category/listall');
        } else {
            $data['page'] = 'add';
            $data['heading'] = 'Add Product Category';
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
            $data['values']['parent_id'] 		= $this->input->post('parent_category');
            $data['values']['category_name'] 	= $this->input->post('category_name');
            $data['values']['category_details'] = $this->input->post('description');
            $data['values']['modified_date'] 	= $date;
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['cat_status'] 		= $this->input->post('status');
            $this->categorymodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage Lead Category",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success', 'Product Category Edited Successfully');
            redirect('category/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->categorymodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Product Category';
                $this->load->view('main', $data);
            } else {
                redirect('category/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $this->categorymodel->delete($delid);
        $cond = array("cat_id"=>$delid);
        $content = $this->usermodel->getDeletedData('lead_category',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Lead Category",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('category/listall');
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
        $cond = array("cat_id"=>$delid);
        $content = $this->usermodel->getDeletedData('lead_category',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Lead Category",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->categorymodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
    echo '';
    exit();
}

}