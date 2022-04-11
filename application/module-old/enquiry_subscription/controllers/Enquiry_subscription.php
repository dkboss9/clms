<?php
class enquiry_subscription extends MX_Controller {

    private $currency = 'AUD';
    private $ec_action = 'Sale';

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('enquiry_subscription_model');
        $this->load->model('users/usermodel');
        $this->module_code = 'Enquiry_subscription';

        $paypal_details = array(
            'API_username' => $this->mylibrary->getSiteEmail(78), 
            'API_signature' => $this->mylibrary->getSiteEmail(79), 
            'API_password' => $this->mylibrary->getSiteEmail(80),
            'sandbox_status' => true
        );
        $this->load->library('paypal_ec', $paypal_details);
    }

    function index() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            redirect('enquiry_subscription/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    //----------------------------------------listall--------------------------------------------------	
    function listall() { 
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
            $data['status'] 	= $this->enquiry_subscription_model->listall();
            $this->load->model('company/companymodel');
            $company_id = $this->session->userdata("clms_front_companyid");
            $setting = $this->companymodel->getdata($company_id)->row();
            $data['company'] = $setting;
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

            $this->form_validation->set_rules('credits','Credits','required');
            $this->form_validation->set_rules('txt_package_price','Price','required');
            if($this->form_validation->run()!=FALSE){

                if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
                    redirect($_SERVER["HTTP_REFERER"],"refresh");
                }

                $package = array(
                    "company_id" => $this->session->userdata("clms_front_companyid"),
                    "credits"   => $this->input->post('credits'),
                    "price"   => $this->input->post('txt_package_price'),
                    "added_date" => date("Y-m-d"),
                );
                $this->db->insert("company_enquiry_package",$package);

                $this->load->model("company/companymodel");
                $company_id = $this->session->userdata("clms_front_companyid");
                if($this->input->post('paymethod')=='bank'){ 
                    $setting = $this->companymodel->getdata($company_id)->row();
                    $enquiry_update = array(
                        "enquiry_credit"   => $setting->enquiry_credit + $this->input->post('credits'),
                        "balance_enquiry"   => $setting->enquiry_credit + $this->input->post('credits'),
                    );
                    $this->enquiry_subscription_model->enquirySetting($enquiry_update,$company_id);

                    $company_package = array("payment_method"=>'bank',"invoice_status"=>"due");
                    $this->enquiry_subscription_model->updateEnquriyPackage($company_package,$company_id);
                    $this->enquiry_subscription_model->sendEmailEnquiryPackage("bank",$company_id);
                    $this->session->set_flashdata("success_message","You have Successfully bought the Enquiry credits.");
                    redirect('enquiry_subscription/listall','location');
                }elseif($this->input->post('paymethod')=='eway'){ 
                    $amount = $this->input->post('txt_package_price');
                    $name = $this->input->post('credits')." Sms Credits";
                    $cardnum = $this->input->post("card_number");
                    $expiry= $this->input->post("expiry_year").'-'.$this->input->post("expiry_month");
                    $cvv = $this->input->post("ccv");
                    $respose = $this->eway_direct_payment($name, $cardnum, $expiry, $cvv='007', $email='bikash@ausnep.com' ,$amount ,$user_id=5,$credits='10',8,$company_id);
                }else{
                    $package = $this->companymodel->get_packageDetails($this->input->post("package"));
                    $shipping = 0;
                    $to_buy = array(
                        'desc' => 'Clms Enquiry Package - '.$this->input->post('credits'), 
                        'currency' => $this->currency, 
                        'type' => $this->ec_action, 
                        'return_URL' => site_url('enquiry_subscription/success'), 
                        'cancel_URL' =>  site_url('enquiry_subscription/cancel'), 
                        'shipping_amount' => $shipping, 
                        'get_shipping' => true);

                    $temp_product = array(
                        'name' => 'Clms Enquiry Package - '.$this->input->post('credits'), 
                        'desc' => '', 
                        'number' => $company_id, 
                        'quantity' => 1, 
                        'amount' => $this->input->post('txt_package_price')
                    );
                    $to_buy['products'][] = $temp_product;
                        // enquire Paypal API for token
                    $set_ec_return = $this->paypal_ec->set_ec($to_buy);

                    if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
                            // redirect to Paypal
                        $this->paypal_ec->redirect_to_paypal($set_ec_return['TOKEN']);
                            // $this->paypal_ec->redirect_to_paypal( $set_ec_return['TOKEN'], true); this is for mobile payment
                    } else {
                        $this->_error($set_ec_return);
                    }
                }

                $this->session->set_flashdata("success_message","You have Successfully bought the Enquiry credits.");
                redirect('enquiry_subscription/listall','location');
            }else{
                $this->load->model('enquiry_package/enquiry_package_model');
                $data['credits'] = $this->enquiry_package_model->listall(1);
                $data['page'] = 'add';
                $data['heading'] = 'Add Lead Status';
                $this->load->vars($data);
                $this->load->view($this->container);
            }

        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function success() {
        $token = $this->input->get('token');
        $payer_id = $this->input->get('PayerID');
            // GetExpressCheckoutDetails
        $get_ec_return = $this->paypal_ec->get_ec($token);
        if (isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {
            $ec_details = array(
                'token' => $token, 
                'payer_id' => $payer_id, 
                'currency' => $this->currency, 
                'amount' => $get_ec_return['PAYMENTREQUEST_0_AMT'], 
                'IPN_URL' => base_url().'dashboard/ipn', 
                'type' => $this->ec_action);
                // DoExpressCheckoutPayment
            $do_ec_return = $this->paypal_ec->do_ec($ec_details);
            if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {
                $company_id = '';
                $transaction_id = '';
                $paypal =  $get_ec_return;
                $transaction = $do_ec_return;
                $company_id = $paypal['L_PAYMENTREQUEST_0_NUMBER0'];
                $transaction_id = $transaction['PAYMENTINFO_0_TRANSACTIONID'];
                $amount = $transaction['PAYMENTINFO_0_AMT'];

                $package = $this->enquiry_subscription_model->getEnquiryPackage($company_id);

                $this->load->model("company/companymodel");

                $setting = $this->companymodel->getdata($company_id)->row();
                $enquiry_update = array(
                    "enquiry_credit"   => $setting->enquiry_credit + $package->credits,
                    "balance_enquiry"   => $setting->balance_enquiry + $package->credits,
                );

                $this->enquiry_subscription_model->enquirySetting($enquiry_update,$company_id);

                $company_package = array("payment_method"=>'Paypal',"invoice_status"=>"Paid","txn_number" => $transaction_id);
                $this->enquiry_subscription_model->updateEnquriyPackage($company_package,$company_id);
                $this->enquiry_subscription_model->sendEmailEnquiryPackage("Paypal",$company_id);
                $this->session->set_flashdata("success_message","You have Successfully bought the Enquiry credits.");
                redirect('enquiry_subscription/listall','location');
            } else {
                $this->_error($do_ec_return);
            }
        } else {
            $this->_error($get_ec_return);
        }
    }


    function payment_successfull(){
        $data['page']       = 'thanks';
        $this->load->vars($data);
        $this->load->view($this->container);
    }

    function cancel(){
        $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessfull.");
        redirect('dashboard','location');
    }


    function eway_direct_payment($name, $cc_number, $validity, $sc_code, $email, $payment, $user_id, $credits,$package_id,$company_id) {
        $amount = $payment * 100;
        $validityArr = explode("-", $validity);
        $expmonth = $validityArr[1];
        $expyear = $validityArr[0];
        $nameArr = explode(" ", $name);
        if (count($nameArr) > 1) {
            $first_name = $nameArr[0];
            $last_name = $nameArr[1];
        } else {
            $first_name = $nameArr[0];
            $last_name = "NotProvide";
        }


        $company = $this->companymodel->getdata($company_id)->row();
        $this->load->library('ewaypayment');
            //$this->ewaypayment->setCustomerID('91533096');
        $this->ewaypayment->setCustomerID($this->mylibrary->getSiteEmail(76));
        $this->ewaypayment->setGatewayURL('https://www.eway.com.au/gateway_cvn/xmltest/testpage.asp');
    //$this->ewaypayment->setGatewayURL('https://www.eway.com.au/gateway_cvn/xmlpayment.asp');
        $this->ewaypayment->setCustomerFirstname($company->first_name);
        $this->ewaypayment->setCustomerLastname($company->last_name);
        $this->ewaypayment->setCustomerEmail($company->email);
        $this->ewaypayment->setCustomerAddress($company->address);
        $this->ewaypayment->setCustomerPostcode($company->postcode);
        $this->ewaypayment->setCustomerInvoiceDescription('Payment detail');
        $this->ewaypayment->setCustomerInvoiceRef('INV120394');
        $this->ewaypayment->setCardHoldersName($name);
        $this->ewaypayment->setCardNumber($cc_number);
        $this->ewaypayment->setCardExpiryMonth($expmonth);
        $this->ewaypayment->setCardExpiryYear($expyear);
        $this->ewaypayment->setTrxnNumber($company_id);
        $this->ewaypayment->setTotalAmount($amount);
        $this->ewaypayment->setCVN($sc_code);

        $check = $this->ewaypayment->doPayment();


        if ($check == EWAY_TRANSACTION_OK) {
            $transaction_id = $this->ewaypayment->getAuthCode();

            $package = $this->enquiry_subscription_model->getEnquiryPackage($company_id);
          //  echo $this->db->last_query();

            $setting = $this->companymodel->getdata($company_id)->row();
            $enquiry_update = array(
                "enquiry_credit"   => $setting->enquiry_credit + $package->credits,
                "balance_enquiry"   => $setting->balance_enquiry + $package->credits,
            );
            
            $this->enquiry_subscription_model->enquirySetting($enquiry_update,$company_id);

            $company_package = array("payment_method"=>'Eway',"invoice_status"=>"Paid","txn_number" => $transaction_id);
            $this->enquiry_subscription_model->updateEnquriyPackage($company_package,$company_id);
            $this->enquiry_subscription_model->sendEmailEnquiryPackage("Eway",$company_id);

            $this->session->set_flashdata("success_message","You have Successfully bought the Enquiry credits.");
            redirect('enquiry_subscription/listall','location');

        } else {
            $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessfull.");
            redirect('enquiry_subscription/add','location');
        }
    }

    //---------------------------------edit--------------------------------------
    function edit() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
            if ($this->input->post('submit')) {
                $id = $this->input->post('status_id');
                $userdata = $this->session->userdata("clms_front_userid");
                $data['values']['credits']    = $this->input->post('credits');
                $data['values']['price'] = $this->input->post('price');
                $data['values']['added_date']       = time();
                $data['values']['added_by']         = $userdata;
                $data['values']['modified_date']    = time();
                $data['values']['modified_by']      = $userdata;
                $this->enquiry_subscription_model->update($id, $data['values']);
                $logs = array(
                    "content" => serialize($data['values']),
                    "action" => "Edit",
                    "module" => "Manage Lead Status",
                    "added_by" => $this->session->userdata("clms_front_userid"),
                    "added_date" => time()
                );
                $this->usermodel->insertUserlog($logs);
                $this->session->set_flashdata('success_message', 'Enquiry Subscription edited Successfully');
                redirect('enquiry_subscription/listall');
            } else {
                $id = $this->uri->segment(3);
                $query = $this->enquiry_subscription_model->getdata($id);
                if ($query->num_rows() > 0) {
                    $data['result'] 	= $query->row();
                    $data['page'] 		= 'edit';
                    $data['heading'] 	= 'Edit Lead status';
                    $this->load->view('main', $data);
                } else {
                    redirect('enquiry_subscription/listall');
                }
            }
        }
    }

    //------------------------delete---------------------------------------------------------	
    function delete() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
            $delid = $this->uri->segment('3');
            $cond = array("id"=>$delid);
            $content = $this->usermodel->getDeletedData('enquiry_subscription',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => "Delete",
                "module" => "Manage Lead Status",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
            );
            $this->usermodel->insertUserlog($logs);
            $this->enquiry_subscription_model->delete($delid);
            $this->session->set_flashdata('success_message', 'Record deleted successfully');
            redirect('enquiry_subscription/listall');
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
            $content = $this->usermodel->getDeletedData('enquiry_subscription',$cond);
            $logs = array(
                "content" => serialize($content),
                "action" => $action,
                "module" => "Manage Lead Status",
                "added_by" => $this->session->userdata("clms_front_userid"),
                "added_date" => time()
            );
            $this->usermodel->insertUserlog($logs); 
        }
        $query = $this->enquiry_subscription_model->cascadeAction($ids, $action);
        $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
        exit();
    }

}