<?php
class Sms extends MX_Controller {
    private $currency = 'AUD';
    private $ec_action = 'Sale';
    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model('smsmodel');
        $this->load->model('users/usermodel');
        $this->load->model('company/companymodel');
        $this->module_code = 'sms';


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
            redirect('sms/listall', 'location');
        } else {
            $this->session->set_flashdata('error', 'Please login with your username and password');
            redirect('login', 'location');
        }
    }

    function dashboard() {
        if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
         $this->load->model("student/studentmodel");
         $data['customers'] =  $this->studentmodel->listall();
         $query = $this->smsmodel->getdata($this->session->userdata("clms_front_userid"));
         $data['result']     = $query->row();
         $userdata = $this->session->userdata("clms_front_userid");
         $this->form_validation->set_rules("customer","","");
         if($this->input->post('customer') == '' && $this->input->post("subscribers") == '' && $this->input->post("contractor") == '')
            $this->form_validation->set_rules("other_numbers","Number","required");
        else
            $this->form_validation->set_rules("other_numbers","","");
        $this->form_validation->set_rules("content","","required");
        if ($this->form_validation->run()) {

            $other_numbers = $this->input->post('other_numbers');
            
            $form_numbers = explode(',',$other_numbers);

            $sms = $this->input->post("content");

            $sms_len = strlen($sms);

            $sms_time = ceil($sms_len / 160); 

            $numbers = [];
            if($this->input->post("customer")){
                $numbers = $this->input->post("customer");
            }

            $subsribers = [];
            if($this->input->post("subscribers"))
                $subsribers = $this->input->post("subscribers");

            $contractors = [];
            if($this->input->post("contractor"))
                $contractors = $this->input->post("contractor");



            foreach($subsribers as $val){
                if($val != '' && $val != ' '){
                    $numbers[] = $val;
                }
            }

            foreach($contractors as $val){
                if($val != '' && $val != ' '){
                    $numbers[] = $val;
                }
            }

            foreach($form_numbers as $val){
                if($val != '' && $val != ' '){
                    $numbers[] = $val;
                }
            }



            $numbers = array_filter($numbers, 'strlen');
            if (($key = array_search('multiselect-all', $numbers)) !== false) {
                unset($numbers[$key]);
            }
            if (($key = array_search('multiselect-all', $numbers)) !== false) {
                unset($numbers[$key]);
            }

            if (($key = array_search('multiselect-all', $numbers)) !== false) {
                unset($numbers[$key]);
            }
           // print_r($numbers); die();

            if($data['result']->balance_sms < count($numbers) * $sms_time){
             $this->session->set_flashdata('error',"You don't have sufficent sms balance to send this sms");
             redirect("sms/dashboard");
                 //$this->dashboard();
             die();
         }


         $used = count($numbers) * $sms_time;

         $sms_used = $used + $data['result']->used_sms;

         $balance_sms =$data['result']->balance_sms - $used;

         $this->db->where("company_id",$this->session->userdata("clms_front_userid"));
         $this->db->set("used_sms",$sms_used);
         $this->db->set("balance_sms",$balance_sms);
         $this->db->update("sms");


         $sms = $this->input->post("content");

         $this->load->model("commonmodel");
         $number_string = '';
         foreach($numbers as $key => $mobile_number){
            $this->commonmodel->printsms($sms,$mobile_number,$data['result']->sms_from);
            $number_string .=  $mobile_number.', ';
        }

        $sms = array(
            "company_id" => $this->session->userdata("clms_front_companyid"),
            "customer_id" => isset($customer_id) ? $customer_id : 0,
            "mobile" => $number_string,
            "sms_content" => $sms,
            "sent_time" => date("h:i:s"),
            "sent_date" => date("Y-m-d")
        );

        $this->db->insert("custom_sms_sent",$sms);

        $this->session->set_flashdata('success_message', 'Sms has been sent successfully.');
        redirect('sms/dashboard');
    } else {
        $this->load->model("sms_subscribers/sms_subscribermodel");

        $data['sms_subscribers'] = $this->sms_subscribermodel->sms_subscribers();
        $data['sms_subscribers_contractor'] = $this->sms_subscribermodel->sms_subscribers('Contractor');
        $data['sent'] = $this->smsmodel->getsentsms();
        $data['page']       = 'dashboard';
        $data['heading']    = 'Edit Chat';
        $this->load->view('main', $data);

    }

} else {
    $this->session->set_flashdata('error', 'Please login with your username and password');
    redirect('login', 'location');
}
}

    //----------------------------------------listall--------------------------------------------------	
function listall() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
        $this->form_validation->set_rules("sms_from",'sms from','required|alpha_numeric|max_length[11]');

        if ($this->form_validation->run()) {
            $id = $this->input->post('start_id');
            $userdata = $this->session->userdata("clms_front_userid");
            $data['values']['sms_from']    = $this->input->post('sms_from');
            $data['values']['is_active']       = $this->input->post('is_active');
            $data['values']['company_id']       = $this->session->userdata("clms_front_companyid");
            $data['values']['added_by']         = $userdata;
            $data['values']['added_date']    = date("Y-m-d");
            $query = $this->smsmodel->getdata($this->session->userdata("clms_front_companyid"));
            if($query->num_rows() > 0){
                $this->db->where("company_id",$this->session->userdata("clms_front_companyid"));
                $this->db->update("sms",$data['values']);
            }else{
                $this->db->insert("sms", $data['values']);
            }

            $this->session->set_flashdata('success_message', 'Sms setting save successfully.');
            redirect('sms/listall');
        } else {
            $userdata = $this->session->userdata("clms_front_userid");
            $query = $this->smsmodel->getdata($this->session->userdata("clms_front_companyid"));
            $data['result']     = $query->row();
            $data['page']       = 'edit';
            $data['heading']    = 'Edit Chat';
            $this->load->view('main', $data);

        }

    } else {
        $this->session->set_flashdata('error', 'Please login with your username and password');
        redirect('login', 'location');
    }
}


function get_sms_credits($company_id){
    $this->form_validation->set_rules('credits','Credits','required');
    $this->form_validation->set_rules('txt_package_price','Price','required');
    if($this->form_validation->run()!=FALSE){


        $package = array(
            "user_id" => $company_id,
            "credit"   => $this->input->post('credits'),
            "price"   => $this->input->post('txt_package_price'),
            "added_date" => date("Y-m-d"),
        );
        $this->db->insert("company_sms_credits",$package);



        if($this->input->post('paymethod')=='bank'){ 
            $setting = $this->smsmodel->getdata($company_id)->row();
            $sms_update = array(
                "sms_credit"   => $setting->sms_credit + $this->input->post('credits'),
                "balance_sms"   => $setting->balance_sms + $this->input->post('credits'),
            );
            $this->smsmodel->smsSetting($sms_update,$company_id);

            $company_package = array("payment_method"=>'bank',"invoice_status"=>"due");
            $this->smsmodel->updateSmsPackage($company_package,$company_id);
            $this->smsmodel->sendEmailSmsPackage("bank",$company_id);
            $this->session->set_flashdata("success_message","You have Successfully bought the sms credits.");
            redirect('sms/listall','location');
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
                'desc' => 'Acrm Package - '.$package->name, 
                'currency' => $this->currency, 
                'type' => $this->ec_action, 
                'return_URL' => site_url('sms/success'), 
                'cancel_URL' =>  site_url('sms/cancel'), 
                'shipping_amount' => $shipping, 
                'get_shipping' => true);

            $temp_product = array(
                'name' => 'Acrm Package - '.$package->name, 
                'desc' => $this->input->post('order_term'), 
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

        $this->session->set_flashdata('success_message', 'You have Successfully Updated the package on Acrm.');
        redirect('payment/'.$company);
    }else{
       $data['credits'] = $this->smsmodel->getPackages(); 
       $data['page']       = 'credits';
       $data['heading']    = 'Edit Chat';
       $this->load->view('main', $data);
   }
}

        /* -------------------------------------------------------------------------------------------------
        * The location for your IPN_URL that you set for $this->paypal_ec->do_ec(). obviously more needs to
        * be done here. this is just a simple logging example. The /ipnlog folder should the same level as
        * your CodeIgniter's index.php
        * --------------------------------------------------------------------------------------------------
        */
        function ipn() {
            $logfile = APPPATH.'logs/ipnlog/' . uniqid() . '.html';
            $logdata = "<pre>\r\n" . print_r($_POST, true) . '</pre>';
            file_put_contents($logfile, $logdata);
        }
        
        /* -------------------------------------------------------------------------------------------------
        * a simple message to display errors. this should only be used during development
        * --------------------------------------------------------------------------------------------------
        */
        function _error($ecd) {
            //$data['page'] = 'success';
            //$data['heading'] = 'Payment Success';
            //$this->load->vars($data);
            //$this->load->view($this->container);
            echo "<pre>" . print_r($ecd, true) . "</pre>";
            echo 'Message:' . $this->session->userdata('curl_error_msg') . '<br>';
            echo 'Number:' . $this->session->userdata('curl_error_no') . '<br>';
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
                    
                    $package = $this->smsmodel->getSmsPackage($company_id);

                    $setting = $this->smsmodel->getdata($company_id)->row();
                    $sms_update = array(
                        "sms_credit"   => $setting->sms_credit + $package->credit,
                        "balance_sms"   => $setting->balance_sms + $package->credit,
                    );
                    $this->smsmodel->smsSetting($sms_update,$company_id);

                    $company_package = array("payment_method"=>'Paypal',"invoice_status"=>"Paid","txn_number" => $transaction_id);
                    $this->smsmodel->updateSmsPackage($company_package,$company_id);
                    $this->smsmodel->sendEmailSmsPackage("Paypal",$company_id);
                    $this->session->set_flashdata("success_message","You have Successfully bought the sms credits.");
                    redirect('sms/listall','location');
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

                $package = $this->smsmodel->getSmsPackage($company_id);

                $setting = $this->smsmodel->getdata($company_id)->row();
                $sms_update = array(
                    "sms_credit"   => $setting->sms_credit + $package->credit,
                    "balance_sms"   => $setting->balance_sms + $package->credit,
                );
                $this->smsmodel->smsSetting($sms_update,$company_id);

                $company_package = array("payment_method"=>'Eway',"invoice_status"=>"Paid","txn_number" => $transaction_id);
                $this->smsmodel->updateSmsPackage($company_package,$company_id);
                $this->smsmodel->sendEmailSmsPackage("Eway",$company_id);
                $this->session->set_flashdata("success_message","You have Successfully bought the sms credits.");
                redirect('sms/listall','location');
                
            } else {
                $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessfull.");
                redirect('upgrade/'.$company_id,'location');
            }
        }





    }