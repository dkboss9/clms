<?php
class budget extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('budgetmodel');
        $this->load->model('users/usermodel');
        $this->load->model('package/packagemodel');
        $this->module_code = 'BUDGET_MANAGER';
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('budget/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['budgets'] 	= $this->budgetmodel->listall();
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function callendar(){
        $data['budgets']     = $this->budgetmodel->listall();
        $data['payment_times'] = $this->packagemodel->get_paymentTime();
        $data['page']          = 'callendar';
        $this->load->vars($data);
        $this->load->view($this->container);
    }

    //--------------------------------------add--------------------------------------	
    function add() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {

            if ($this->input->post('submit')) {
             if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }
            $userdata = $this->session->userdata("clms_front_userid");
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['cat1']	= $this->input->post('type');
            $parent = $this->budgetmodel->getParentItem($this->input->post('item'));
            $data['values']['cat2']   = $parent->parent_id;
            $data['values']['cat3']   = $this->input->post('item');
            $data['values']['purpose']   = $this->input->post('purpose');
            $data['values']['price']      = $this->input->post("price");
            $data['values']['payment_time'] = $this->input->post('payment_time');
            $data['values']['budget_status']   = $this->input->post('status');
            $data['values']['note']   = $this->input->post('details');
            $dates = $this->input->post('start_date');
            $dates = explode("/", $dates);
            $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
            $data['values']['from_date']   = strtotime($date);
            $dates1 = $this->input->post('end_date');
            $dates1 = explode("/", $dates1);
            $date1 = $dates1[1].'/'.$dates1[0].'/'.$dates1[2]; 
            $data['values']['end_date']   = strtotime($date1);
            $data['values']['added_date'] 		= time();
            $data['values']['added_by'] 		= $userdata;
            $data['values']['modified_date'] 	= time();
            $data['values']['modified_by'] 		= $userdata;
            $data['values']['status']      = 1;
            $this->budgetmodel->add($data['values']);

            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Add",
                "module" => "Manage budget",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Budget added successfully');

            if(strpos($_SERVER["HTTP_REFERER"], 'callendar') === false)
                redirect('budget/listall');
            else
                redirect($_SERVER["HTTP_REFERER"]);
            
        }else{
            $data['payment_times'] = $this->packagemodel->get_paymentTime();
            $data['page'] = 'add';
            $data['heading'] = 'Add Chat Name';
            $this->load->vars($data);
            $this->load->view($this->container);
        }
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

function get_items(){
    $catid = $this->input->post("catid");
    $types = $this->budgetmodel->get_items($catid);
    if($this->input->post("itemid"))
        $itemid = $this->input->post("itemid");
    else
        $itemid = "";
    $string = "";
    foreach ($types as $type) {
        $string.='<optgroup label="'.$type->type_name.'">';
        $items = $this->budgetmodel->get_items($type->type_id);
        foreach ($items as $item) {
            if($itemid == $item->type_id)
                $select = 'selected="selected"';
            else
                $select = "";
            $string.='<option value="'.$item->type_id.'" '.$select.'>'.$item->type_name.'</option>';
        }
        $string.='</optgroup>';
    }
    echo $string;

}

    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('budget_id');
            $userdata = $this->session->userdata("clms_front_userid");
            $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
            $data['values']['cat1'] = $this->input->post('type');
            $parent = $this->budgetmodel->getParentItem($this->input->post('item'));
            $data['values']['cat2']   = $parent->parent_id;
            $data['values']['cat3']   = $this->input->post('item');
            $data['values']['purpose']   = $this->input->post('purpose');
            $data['values']['price']      = $this->input->post("price");
            $data['values']['payment_time'] = $this->input->post('payment_time');
            $data['values']['budget_status']   = $this->input->post('status');
            $data['values']['note']   = $this->input->post('details');
            $dates = $this->input->post('start_date');
            $dates = explode("/", $dates);
            $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
            $data['values']['from_date']   = strtotime($date);
            $dates1 = $this->input->post('end_date');
            $dates1 = explode("/", $dates1);
            $date1 = $dates1[1].'/'.$dates1[0].'/'.$dates1[2]; 
            $data['values']['end_date']   = strtotime($date1);
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->budgetmodel->update($id, $data['values']);
           // echo $this->db->last_query();
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage budget",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'Budget edited Successfully');
            if(strpos($_SERVER["HTTP_REFERER"], 'callendar') === false)
                redirect('budget/listall');
            else
                redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data['payment_times'] = $this->packagemodel->get_paymentTime();
            $id = $this->uri->segment(3);
            $query = $this->budgetmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('budget/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("budget_id"=>$delid);
        $content = $this->usermodel->getDeletedData('budget',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage budget",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->budgetmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('budget/listall');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------detail---------------------------------
function budget_detail() {
    if ($this->session->userdata("clms_front_userid") != "" ) {
        $id = $this->uri->segment(3);
        $query = $this->budgetmodel->getdata($id);
        $data['result'] = $query->row();
        $this->load->view('detail_budget', $data);

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
        $cond = array("budget_id"=>$delid);
        $content = $this->usermodel->getDeletedData('budget',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage budget",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->budgetmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}


}