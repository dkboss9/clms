<?php
class payment_receipts extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('payment_receiptsmodel');
        $this->load->model('users/usermodel');
        $this->load->model('order/ordermodel');
        $this->load->model('quote/quotemodel');
        $this->module_code = 'payment_receipts';
        $this->load->model('customer/customermodel');
        $this->load->model('student/studentmodel');
        $this->load->library('html2pdf');
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('payment_receipts/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['payment_receipts'] 	= $this->payment_receiptsmodel->all_payment_receipts();
            // echo $this->db->last_query();die();
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
             if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
                redirect($_SERVER["HTTP_REFERER"],"refresh");
            }
            $dif = $this->input->post("due")-$this->input->post("paid");
        $this->db->where("order_id",$this->input->post("invoice_id"));
        $this->db->set("due_amount",$dif);
        if($this->input->post("invoice_status"))
          $this->db->set("invoice_status",$this->input->post("invoice_status"));
        $this->db->update("order");

        if( $this->input->post("paid") != ""){
          $insert_paid = array(
            "amount" => $this->input->post("paid"),
            "invoice_id" => $this->input->post("invoice_id"),
            "company_id" => $this->session->userdata("clms_front_companyid"),
            "paid_date" => time(),
            "received_on"=> date("Y-m-d",strtotime($this->input->post("received_date"))),
            "payment_method" => $this->input->post("payment_method"),
            "note" => $this->input->post("note")??'',
            "receipted_by" => $this->input->post("staff_id"),
            "account_number" => $this->input->post("account_no")
          );
        
          $this->db->insert("invoice_payment",$insert_paid);
        
         $this->ordermodel->sendPaymentEmail($this->input->post("sendmail"),$this->input->post("copy_me"));
       }
     

            $this->session->set_flashdata('success_message', 'Payment done successfully');
            redirect('payment_receipts/listall');
        }else{
            $data['orders'] 	= $this->ordermodel->listall($ostatus='',$invoice='',$archived='',$order_date='',$referral='',$from_date='',$to_date='','','',$type='');
            $id = $this->input->get('invoice');
            $data["payments"] = $this->ordermodel->getPayments($id);
            $data['result'] = $this->ordermodel->getdata($id)->row();
            $this->load->model('project/projectmodel');
            $data['employees'] = $this->projectmodel->get_empoyee();
            if(empty($data['result'])){
                $data['page'] = 'add';
            }else{
                $data['page'] = 'add_payment';
            }
            
            $data['heading'] = 'Add Chat Name';
            $this->load->vars($data);
            $this->load->view($this->container);
        }
    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}

function addpayment_receipts(){
    if($this->session->userdata("clms_front_userid")!="" && $this->usermodel->checkperm($this->module_code,"ADD")){
       if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
          echo '<strong>We must tell you! </strong> Please select company to add this data.';
          exit;
      }
      $this->form_validation->set_rules('payment_receipts_type','payment_receipts','required');

      if($this->form_validation->run()==FALSE){
        echo "Required field(s) missing";
        exit();
    }else{
     $this->db->select("count(id) num");
     $this->db->from("payment_receipts p");
     $this->db->where("payment_receipts_title",$this->input->post('payment_receipts_type'));
     $query = $this->db->get()->row();
     if($query->num > 0){
        echo "payment_receipts type already exists";
        exit();
    }

    $userdata = $this->session->userdata("clms_front_userid");
    $date = date("Y-m-d");
    $data['values']['payment_receipts_title']   = $this->input->post('payment_receipts_type');
    $data['values']['company_id']      = $this->session->userdata("clms_front_companyid");
    $data['values']['added_date']       = time();
    $data['values']['added_by']         = $userdata;
    $data['values']['modified_date']    = time();
    $data['values']['modified_by']      = $userdata;
    $data['values']['status']      = 1;
    $this->payment_receiptsmodel->add($data['values']);
    $id = $this->db->insert_id();

    $logs = array(
        "content" => serialize($data['values']),
        "action" => "Add",
        "module" => "payment_receipts Type",
        "added_by" => $this->session->userdata("clms_front_userid"),
        "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs);
    echo $id;
}

}else{
    $this->session->set_flashdata('error','Please login with your username and password');
    redirect('login','location');
}
}

    //---------------------------------edit--------------------------------------
function edit() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
        if ($this->input->post('submit')) {
            $id = $this->input->post('payment_receipts_id');
            $userdata = $this->session->userdata("clms_front_userid");
            $data['values']['payment_receipts_title']    = $this->input->post('name');
            $data['values']['added_date']       = time();
            $data['values']['added_by']         = $userdata;
            $data['values']['modified_date']    = time();
            $data['values']['modified_by']      = $userdata;
            $this->payment_receiptsmodel->update($id, $data['values']);
            $logs = array(
                "content" => serialize($data['values']),
                "action" => "Edit",
                "module" => "Manage payment_receipts",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
            );
            $this->usermodel->insertUserlog($logs);
            $this->session->set_flashdata('success_message', 'payment_receipts type edited Successfully');
            redirect('payment_receipts/listall');
        } else {
            $id = $this->uri->segment(3);
            $query = $this->payment_receiptsmodel->getdata($id);
            if ($query->num_rows() > 0) {
                $data['result'] 	= $query->row();
                $data['page'] 		= 'edit';
                $data['heading'] 	= 'Edit Chat';
                $this->load->view('main', $data);
            } else {
                redirect('payment_receipts/listall');
            }
        }
    }
}

    //------------------------delete---------------------------------------------------------	
function delete() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
        $delid = $this->uri->segment('3');
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('payment_receipts',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => "Delete",
            "module" => "Manage payment_receipts",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
        );
        $this->usermodel->insertUserlog($logs);
        $this->payment_receiptsmodel->delete($delid);
        $this->session->set_flashdata('success_message', 'Record deleted successfully');
        redirect('payment_receipts/listall');
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
        $cond = array("id"=>$delid);
        $content = $this->usermodel->getDeletedData('payment_receipts',$cond);
        $logs = array(
            "content" => serialize($content),
            "action" => $action,
            "module" => "Manage payment_receipts",
            "added_by" => $this->session->userdata("clms_front_userid"),
            "added_date" => time()
        );
        $this->usermodel->insertUserlog($logs); 
    }
    $query = $this->payment_receiptsmodel->cascadeAction($ids, $action);
    $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
    exit();
}

}