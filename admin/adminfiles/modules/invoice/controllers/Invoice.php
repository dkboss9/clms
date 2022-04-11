<?php
class invoice extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('invoicemodel');
        $this->load->model('users/usermodel');
        $this->load->model('student/studentmodel');
        $this->load->library('html2pdf');
        $this->module_code = 'INVOICE-MANAGER';
    }

    function index() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('invoice/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            if($this->input->get("status"))
                $status = $this->input->get("status");
            else
                $status = '';
            $data['invoice'] 	= $this->invoicemodel->listall($status);
            $data['page'] 			= 'list';
            $this->load->vars($data);
            $this->load->view($this->container);
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }
    function add(){
        if($this->session->userdata("clms_userid")!="" && $this->usermodel->checkperm($this->module_code,"ADD")){
           $this->form_validation->set_rules('student','Student','required');

           if($this->form_validation->run()!=FALSE){
             if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }
            $value['details']['company_id']     = $this->session->userdata("clms_company");
            $value['details']['customer_id']      = $this->input->post('student');
            $value['details']['sub_total']          = $this->input->post('sub_total');
            $value['details']['shipping']          = $this->input->post('shipping');
            $value['details']['grand']          = $this->input->post('grand');
            $value['details']['due_amount']          = $this->input->post('due');

            $dates = $this->input->post('invoice_date');
            $dates = explode("/", $dates);
            $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
            $value['details']['invoice_date']   = strtotime($date);
            $dates1 = $this->input->post('due_date');
            $dates1 = explode("/", $dates1);
            $date1 = $dates1[1].'/'.$dates1[0].'/'.$dates1[2]; 
            $value['details']['due_date']   = strtotime($date1);
            $value['details']['invoice_status']         = $this->input->post("status");
            $value['details']['admin_note']         = $this->input->post("admin_note");
            $value['details']['customer_note']         = $this->input->post("customer_note");
            $value['details']['added_date']     = time();
            $value['details']['added_by']       = $this->session->userdata("clms_userid");
            $value['details']['status']         = 1;
            $this->db->insert("invoice",$value['details']);
            $id = $this->db->insert_id();
            $this->db->where("invoice_id",$id);
            $this->db->set("invoice_no",1000+$id);
            $this->db->update("invoice");

            $logs = array(
                "content" => serialize($value['details']),
                "action" => "Add",
                "module" => "Manage Invoice",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);

            $projects = $this->input->post("projects");
            $orders = $this->input->post("order");
            $titles = $this->input->post("title");
            $desc = $this->input->post("desc");
            $price = $this->input->post("price");
            $qty = $this->input->post("qty");
            $total = $this->input->post("total");

            $insert_paid = array(
                "amount" => $this->input->post("paid"),
                "invoice_id" => $id,
                "paid_date" => time()
                );
            $this->db->insert("invoice_payment",$insert_paid);
            foreach ($projects as $key => $value) {
                $insert_arr = array(
                    "invoice_id" => $id,
                    "project_id" => $projects[$key],
                    "project_no" => $orders[$key],
                    "title" => $titles[$key],
                    "description" => $desc[$key],
                    "price" => $price[$key],
                    "qty" => $qty[$key],
                    "total" => $total[$key]
                    );
                $this->db->insert("invoice_details",$insert_arr);
            }
            $this->session->set_flashdata('success_message', 'Invoice added Successfully.');
            redirect('invoice/listall');
        }else{
            if($this->uri->segment(3)){
                $projectid = $this->uri->segment(3);
                $data['projects'] = $this->invoicemodel->getProject($projectid);
            }
            $data['companies'] = $this->invoicemodel->getCompany();
            //echo $this->db->last_query(); die();
            $data['students'] = $this->studentmodel->listall();
            $data['status'] = $this->invoicemodel->getStatus();

            $data['page'] = 'add';
            $data['heading'] = 'Add ';
            $this->load->vars($data);
            $this->load->view($this->container);
        }
    }else{
        $this->session->set_flashdata('error','Please login with your username and password');
        redirect('login','location');
    }
}


    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('invoice_id');
            $userdata = $this->session->userdata("clms_userid");
            
            $value['details']['sub_total']          = $this->input->post('sub_total');
            $value['details']['shipping']          = $this->input->post('shipping');
            $value['details']['grand']          = $this->input->post('grand');
            $value['details']['due_amount']          = $this->input->post('due');

            $dates = $this->input->post('invoice_date');
            $dates = explode("/", $dates);
            $date = $dates[1].'/'.$dates[0].'/'.$dates[2]; 
            $value['details']['invoice_date']   = strtotime($date);
            $dates1 = $this->input->post('due_date');
            $dates1 = explode("/", $dates1);
            $date1 = $dates1[1].'/'.$dates1[0].'/'.$dates1[2]; 
            $value['details']['due_date']   = strtotime($date1);
            $value['details']['admin_note']         = $this->input->post("admin_note");
            $value['details']['customer_note']         = $this->input->post("customer_note");
            $value['details']['invoice_status']         = $this->input->post("status");
            $value['details']['modified_date']     = time();
            $value['details']['modified_by']       = $this->session->userdata("clms_userid");
            $this->db->where("invoice_id",$id);
            $this->db->update("invoice",$value['details']);
            
            $logs = array(
                "content" => serialize($value['details']),
                "action" => "Edit",
                "module" => "Manage Invoice",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);

            $this->db->where("invoice_id",$id);
            $this->db->delete("invoice_details");
            $projects = $this->input->post("projects");
            $orders = $this->input->post("order");
            $titles = $this->input->post("title");
            $desc = $this->input->post("desc");
            $price = $this->input->post("price");
            $qty = $this->input->post("qty");
            $total = $this->input->post("total");
            foreach ($projects as $key => $value) {
                $insert_arr = array(
                    "invoice_id" => $id,
                    "project_id" => $projects[$key],
                    "project_no" => $orders[$key],
                    "title" => $titles[$key],
                    "description" => $desc[$key],
                    "price" => $price[$key],
                    "qty" => $qty[$key],
                    "total" => $total[$key]
                    );
                $this->db->insert("invoice_details",$insert_arr);
            }
            if( $this->input->post("paid") != ""){
                $insert_paid = array(
                    "amount" => $this->input->post("paid"),
                    "invoice_id" => $id,
                    "paid_date" => time()
                    );
                $this->db->insert("invoice_payment",$insert_paid);
            }
            $this->session->set_flashdata('success_message', 'Invoice edited Successfully');
            redirect('invoice/listall');
        } else {

            $data['companies'] = $this->invoicemodel->getCompany();
            $data['students'] = $this->studentmodel->listall();
            $id = $this->uri->segment(3);
            $data['result'] = $this->invoicemodel->getdata($id)->row();
            $data['status'] = $this->invoicemodel->getStatus();
            $data['page'] 		= 'edit';
            $data['heading'] 	= 'Edit Chat';
            $this->load->view('main', $data);

        }
    }
}

function payment(){
    if($this->input->post("submit")){
        $dif = $this->input->post("due")-$this->input->post("paid");
        $this->db->where("invoice_id",$this->input->post("invoice_id"));
        $this->db->set("due_amount",$dif);
        $this->db->update("invoice");

        if( $this->input->post("paid") != ""){
            $insert_paid = array(
                "amount" => $this->input->post("paid"),
                "invoice_id" => $this->input->post("invoice_id"),
                "paid_date" => time()
                );
            $this->db->insert("invoice_payment",$insert_paid);
            $logs = array(
                "content" => serialize($insert_paid),
                "action" => "Payment",
                "module" => "Manage Invoice",
                "added_by" => $this->session->userdata("clms_userid"),
                "added_date" => time()
                );
            $this->usermodel->insertUserlog($logs);
        }
        $this->session->set_flashdata('success_message', 'Payment done successfully');
        redirect("invoice","");
    }else{
        $id = $this->uri->segment(3);
        $data["payments"] = $this->invoicemodel->getPayments($id);
        $data['result'] = $this->invoicemodel->getdata($id)->row();
        $this->load->view('payment', $data);
    }

}



    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $this->invoicemodel->delete($delid);
        $cond = array("invoice_id"=>$delid);
        $content = $this->usermodel->getDeletedData('invoice',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage Invoice",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('invoice/listall');
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

    //---------------------detail---------------------------------
function detail() {
    if ($this->session->userdata("clms_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
        //$data['companies'] = $this->invoicemodel->getCompany();
       // $data['customers'] = $this->invoicemodel->getCustomer();
        $id = $this->uri->segment(3);
        $data['result'] = $this->invoicemodel->getdata($id)->row();

        $data['page']       = 'detail';
        $data['heading']    = 'Edit Chat';
        $this->load->view('main', $data);
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}


function preview_order($id){
  $query = $this->invoicemodel->getdata($id);
  if ($query->num_rows() > 0) {
    $invoice = $query->row();
    $this->invoicemodel->preview_order($id);
    $filename = "../uploads/pdf/Invoice".$invoice->invoice_no.".pdf";

    header("Content-Length: " . filesize($filename));
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=Invoice'.$invoice->invoice_no.'.pdf');

    readfile($filename);

} else {
    redirect('dashboard/order');
}
}

function submit_invoice($id){
  $query = $this->invoicemodel->getdata($id);
  if ($query->num_rows() > 0) {
    $quote = $query->row();
    $this->invoicemodel->sendmail_invoice($id);
    $arr = array("order_id"=>$id,"sent_date"=>time());
    $this->db->insert("order_email",$arr);
    $this->session->set_flashdata('success_message', 'Invoice Suubmited Successfully');
    redirect('invoice/listall');
} else {
    redirect('invoice/');
}
}

function print_report(){
 $id = $this->uri->segment(3);
 $data['result'] = $this->invoicemodel->getdata($id)->row();
 $this->load->view('print_report', $data);
}

function cascadeAction() {
    $data = $_POST['object'];
    $ids = $data['ids'];
    $action = $data['action'];
    foreach ($ids as $key => $delid) {
        $cond = array("invoice_id"=>$delid);
        $content = $this->usermodel->getDeletedData('invoice',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage Invoice",
            "added_by" => $this->session->userdata("clms_userid"),
            "added_date" => time()
            );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->invoicemodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}