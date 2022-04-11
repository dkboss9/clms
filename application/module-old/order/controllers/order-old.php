<?php
require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php');
class order extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->container = 'main';
    $this->load->model('ordermodel');
    $this->load->model('users/usermodel');
    $this->load->model('customer/customermodel');
    $this->load->model('quote/quotemodel');
    $this->load->library('html2pdf');
    $this->module_code = 'order';
  }



  function index() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      redirect('dashboard/order', 'location');
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

  function export(){
    if($this->input->get("status"))
      $ostatus = $this->input->get("status");
    else
      $ostatus = '';

    if($this->input->get("invoice"))
      $invoice = $this->input->get("invoice");
    else
      $invoice = '';

    if($this->input->get("archived"))
      $archived = $this->input->get("archived");
    else
      $archived = '0';

    if($this->input->get("order_date"))
      $order_date = $this->input->get("order_date");
    else
      $order_date = '';

    if($this->input->get("referral_id"))
      $referral = $this->input->get("referral_id");
    else
      $referral = '';

    if($this->input->get("from_date"))
      $from_date = $this->input->get("from_date");
    else
      $from_date= '';

    if($this->input->get("to_date"))
      $to_date = $this->input->get("to_date");
    else
      $to_date= '';

    if($from_date != ''){
      $date = explode("/", $from_date);
      $from_date = $date[2].'-'.$date[1].'-'.$date[0];
    }

    if($to_date != ''){
      $date = explode("/", $to_date);
      $to_date = $date[2].'-'.$date[1].'-'.$date[0];
    }

    $period = $this->input->get('period') ? $this->input->get('period') : '';
    $month = $this->input->get('month') ? $this->input->get('month') : '';


    $order   = $this->ordermodel->listall($ostatus,$invoice,$archived,$order_date,$referral,$from_date,$to_date,$period,$month);



    header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=\"Sales-report ".date("d-m-Y").".csv\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    $handle = fopen('php://output', 'w');
    fputcsv($handle, array(
      'Order Number',
      'Customer Name',
      'Referral',
      'Nature of Order',
      'Price',
      'Commision',
      'Ordered Date',
      'Order Status',
    ));
    foreach ($order->result() as $row) {

      $customer = $this->quotemodel->getCustomer($row->customer_id);

      $status = $this->ordermodel->getstatus($row->order_status);
      $invoice = $this->ordermodel->getinvoicestatus($row->invoice_status);
      $install = $this->ordermodel->getOrderInstallers($row->order_id);
      $notes = $this->ordermodel->getOrderInstallersNotes($row->order_id);
      $counter = $this->ordermodel->getemailcount($row->order_id);
      $orderseen = $this->ordermodel->countseen($row->order_id);
      $referrals = $this->usermodel->getuser($row->referral_id)->row();

      fputcsv($handle, array(
        $row->order_number,
        @$customer->customer_name,
        @$referrals->first_name. ' '.@$referrals->last_name,
        @$row->product,
        number_format($row->price,2),
        number_format($row->commision,2),
        date("d/m/Y",$row->added_date),
        @$status->name
      ));
    }

    fclose($handle);
    exit;
  }

  function order_details($id){
    $query = $this->ordermodel->getdata($id);
    if ($query->num_rows() > 0) {
      $data['result']   = $query->row();
      $data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
      $data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
      $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
      $data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);
      $data["quote_inverters"] = $this->ordermodel->getInverterOrder($id);
      $data['page']     = 'order_details';
      $data['heading']  = 'Edit Task status';
      $this->load->view('main', $data);
    } else {
      redirect('quote/listall');
    }
  }

    //----------------------------------------listall--------------------------------------------------	
  function listall() {
    if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
      $data['status'] 	= $this->ordermodel->listall();
      $data['page'] 			= 'list';
      $this->load->vars($data);
      $this->load->view($this->container);
    } else {
      $this->session->set_flashdata('error', 'Please login with your username and password');
      redirect('login', 'location');
    }
  }

  function make_archive($id){
    $this->db->where("order_id",$id);
    $this->db->set("is_archived",'1');
    $this->db->set("archived_date",date("Y-m-d"));
    $this->db->update("order");
    $this->session->set_flashdata('success_message', 'Order archived successfully');
    redirect("dashboard/order","location");
  }

  function approve_quote($quote_id = ''){
   if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
    redirect('',"refresh");
  }
  if($this->input->post("submit")){

      //$userdata = $this->session->userdata("clms_front_userid");
    $quote_id = $this->input->post("quote_id");
    $quote = $this->quotemodel->getdata($quote_id)->row();
    if($this->input->post("advance_payment") && $this->input->post("advance_payment")>0)
      $status = 7;
    else
      $status = 6;
    $company = $this->companymodel->getdata($quote->company_id)->row();
    $due_date =  date("Y-m-d",strtotime("+".$company->duedatenumber." days")); 
    $order = array(
      "company_id"=>$quote->company_id,
      "product"=>$quote->product,
      "customer_id"=>$quote->customer_id,
      "package"=>$quote->package,
      "timeline"=>$quote->timeline,
      "testing"=>$quote->testing,
      "payment_terms"=>$quote->payment_terms,
      "document"=>$quote->document,
      "description"=>$quote->description,
      "qprice"=>$quote->price,
      "discount"=>$quote->discount,
      "is_flat"=>$quote->is_flat,
      "gst_applicable"=>$quote->gst_applicable,
      "is_included"=>$quote->is_included,
      "gst"=>$quote->gst,
      "price"=>$quote->total_price,
      "due_amount"=>$quote->total_price,
      "finance_option"=>$quote->finance_option,
      "payment_term"=>$quote->payment_term,
      "order_status"=>16,
      "invoice_status"=>$status,
      "note" => $this->input->post("note"),
      "minimum_deposit"=>$this->input->post("minimum_deposit"),
      "status"=>1,
      "added_by"=>$quote->added_by,
      "expiry_date" => $due_date,
      "added_date"=>time()
    );

    $this->db->insert("order",$order);

    $order_id = $this->db->insert_id();
    $this->db->where("order_id",$order_id);
    $this->db->set("order_number",1000+$order_id);
    $this->db->update("order");

    $this->ordermodel->AddOrderReminder($order_id);
     // echo '<pre>';
    $quote_inverters = $this->quotemodel->listQuoteInverter($quote_id);
    foreach ($quote_inverters as $row) {
     $inverters = array(
      "order_id" => $order_id,
      "descriptions" => $row->descriptions,
      "short_desc" => $row->short_desc,
      "quantity" => $row->quantity,
      "price" => $row->price,
      "amount" => $row->amount
    );
     $this->db->insert("order_inverters",$inverters);
       //print_r($inverters);
   }

   $this->db->set("quote_satus",20);
   $this->db->where("quote_id",$quote_id);
   $this->db->update("quote");

   $this->db->where("lead_id",$quote->lead_id);
   $this->db->set("status_id",'20');
   $this->db->update("leads");

   if($this->input->post("advance_payment") && $this->input->post("advance_payment") > 0){

     $dif = $quote->total_price - $this->input->post("advance_payment");
     $this->db->where("order_id",$order_id);
     $this->db->set("due_amount",$dif);
     $this->db->update("order");

        // if( $this->input->post("paid") != ""){
     $insert_paid = array(
      "amount" => $this->input->post("advance_payment"),
      "invoice_id" => $order_id,
      "paid_date" => time(),
      "payment_method" => $this->input->post("payment_method"),
      "note" => $this->input->post("note")
    );
     $this->db->insert("invoice_payment",$insert_paid);

       // }
   }

   if($this->input->post("send_email")){
    $this->ordermodel->sendmail($order_id);
    $arr = array("order_id"=>$order_id,"sent_date"=>time());
    $this->db->insert("order_email",$arr);
  }

  $query = $this->ordermodel->getdata($order_id)->row();

  $notification = array(
    "content" => $this->session->userdata("username").' has Added the Order. #'.$query->order_number,
    "link" => 'order/details/'.$order_id,
    "from_id" => $this->session->userdata("clms_front_userid"),
    "to_id" => $query->customer_id,
    "added_date" => date("Y-m-d")
  );

  $this->db->insert("customer_notification",$notification);
  $this->session->set_flashdata('success_message', 'Order added successfully');
  if($this->session->userdata("clms_front_userid"))
    redirect("dashboard/order","location");
  else
    redirect($_SERVER["HTTP_REFERER"]);
}else{
  $data["quote"] = $this->quotemodel->getdata($quote_id)->row();
  $data['page']          = 'quotes';
  $this->load->vars($data);
  if($this->session->userdata("clms_front_userid"))
    $this->load->view($this->container);
  else
    $this->load->view("public_quote");
}
}

function invoice($invoice_id){
  $invoice = explode('-',$invoice_id);
  $id = $invoice[1];
  $slug = $this->ordermodel->getlatestpreview_slug($id,'order-invoice');
  $expired = false;
  if($invoice_id != $slug)
    $expired = true;
  $query = $this->ordermodel->getdata($id);
  if ($query->num_rows() > 0) {
    $data['result']   = $query->row();
    $data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
    $data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
    $data["quote_inverters"] = $this->ordermodel->getInverterOrder($id);
    $data["payments"] = $this->ordermodel->getPayments($id);
    $data['result'] = $this->ordermodel->getdata($id)->row();
    $data['invoices'] = $this->ordermodel->listInvoices();
    $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
    $data['customer_account_setting'] = $this->customermodel->get_account_detail($data['cutomer']->account_setting_country);
     // $data['page']     = 'details';
    $data['heading']  = 'Edit Task status';
    if($expired){
     $this->load->view('invoice_public_expired', $data);
   }else{
     $this->load->view('invoice_public', $data);
   }
   
 } else {
  redirect('order/listall');
}
}


function payment_customer(){
  if($this->input->post("submit")){

    $orderid = $this->input->post("invoice_id");
    $corder = $this->ordermodel->getdata($orderid)->row();
    $ccompany = $this->quotemodel->getCompanyDetails($corder->company_id);
    $this->session->set_userdata("paypal_company",$corder->company_id);
    $paypal_details = array(
      'API_username' => $ccompany->api_username, 
      'API_signature' => $ccompany->api_signature, 
      'API_password' => $ccompany->api_password,
      'sandbox_status' => true
    );

    $this->load->library('paypal_ec', $paypal_details);
    $amount = $this->input->post("due");
    $note = $this->input->post("note");
    $method = $this->input->post("paymethod");
    if($this->input->post("sendmail") == 1)
      $sendmail = 1;
    else
      $sendmail = 0;


    if($this->input->post('paymethod')=='bank'){ 
      //$payment_id = $this->ordermodel->getpaymentid($orderid);
      $dif = $this->input->post("due")-$this->input->post("paid");
      $this->db->where("order_id",$orderid);
      $this->db->set("due_amount",$dif);
      $this->db->set("invoice_status",8);
      $this->db->update("order");

      $insert_paid = array(
        "amount" => $this->input->post("due"),
        "invoice_id" => $orderid,
        "paid_date" => time(),
        "payment_method" => "Bank transfer",
        "note" => $note,
        "invoice_status" => 'Due',
      );
      $this->db->insert("invoice_payment",$insert_paid);
     // if($sendmail > 0 )
      $this->ordermodel->sendCustomerPaymentEmail($orderid,'Bank transfer',$note,$amount);


      $query = $this->ordermodel->getdata($orderid)->row();
      $notification = array(
        "content" => $this->session->userdata("customer_username").' has Paid for Order. #'.$query->order_number,
        "link" => 'order/details/'.$orderid,
        "from_id" => $query->customer_id,
        "to_id" => $query->company_id,
        "added_date" => date("Y-m-d")
      );
      $this->db->insert("company_notification",$notification);
    }elseif($this->input->post('paymethod')=='eway'){
      $amount = $this->input->post('due');
      $name = $this->input->post("card_name");
      $cardnum = $this->input->post("card_number");
      $expiry= $this->input->post("expiry_year").'-'.$this->input->post("expiry_month");
      $cvv = $this->input->post("ccv");
      $respose = $this->eway_direct_payment_customer($name, $cardnum, $expiry, $cvv='007', $email='bikash@ausnep.com' ,$amount ,$sendmail,$note,$orderid);
    }elseif($this->input->post('paymethod')=='stripe'){
      $amount = $this->input->post('paid');
      $name = $this->input->post("card_name");
      $cardnum = $this->input->post("card_number");
      $expiry= $this->input->post("expiry_year").'-'.$this->input->post("expiry_month");
      $cvv = $this->input->post("ccv");
      $respose = $this->stripe_payment_customer($amount,$orderid);
    }else{

      $order = $this->ordermodel->getdata($orderid)->row();
     // print_r($order);
      $shipping = 0;
      $to_buy = array(
        'desc' => 'Order - #'.$order->order_number, 
        'currency' => $this->currency, 
        'type' => $this->ec_action, 
        'return_URL' => site_url('order/success'), 
        'cancel_URL' =>  site_url('order/order'), 
        'shipping_amount' => $shipping, 
        'get_shipping' => true);

      $temp_product = array(
        'name' => 'Order - #'.$order->order_number, 
        'desc' => $note, 
        'number' => $orderid .'-' .$sendmail, 
        'quantity' => 1, 
        'amount' => $amount,
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



    $this->session->set_flashdata('success_message', 'Payment done successfully');
    redirect($_SERVER["HTTP_REFERER"],'location');
  }else{
    $id = $this->uri->segment(3);
    $data["payments"] = $this->ordermodel->getPayments($id);
    $data['result'] = $this->ordermodel->getdata($id)->row();
    $data['invoices'] = $this->ordermodel->listInvoices();
    $data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
    $this->load->view('payment', $data);
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
      $paypal_company = $this->session->userdata("paypal_company");
      $ccompany = $this->quotemodel->getCompanyDetails($paypal_company);
      $paypal_details = array(
        'API_username' => $ccompany->api_username, 
        'API_signature' => $ccompany->api_signature, 
        'API_password' => $ccompany->api_password,
        'sandbox_status' => true
      );
      $this->session->unset_userdata("paypal_company");
      $this->load->library('paypal_ec', $paypal_details);
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
          'IPN_URL' => base_url().'order/ipn', 
          'type' => $this->ec_action);
        // DoExpressCheckoutPayment
        $do_ec_return = $this->paypal_ec->do_ec($ec_details);
        if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {

          $company_id = '';
          $transaction_id = '';
          $paypal =  $get_ec_return;
          $transaction = $do_ec_return;
          $number = explode('-', $paypal['L_PAYMENTREQUEST_0_NUMBER0']);
          $orderid = $number[0];
          $sendmail = $number[1];
          $note = $paypal['L_PAYMENTREQUEST_0_DESC0'];
          $transaction_id = $transaction['PAYMENTINFO_0_TRANSACTIONID'];
          $amount = $transaction['PAYMENTINFO_0_AMT'];

          $this->db->where("order_id",$orderid);
          $order = $this->db->get("order")->row();

          $dif = $order->due_amount - $this->input->post("paid");
          $this->db->where("order_id",$orderid);
          $this->db->set("due_amount",$dif);
          $this->db->set("invoice_status",8);
          $this->db->update("order");

          $insert_paid = array(
            "amount" => $amount,
            "invoice_id" => $orderid,
            "paid_date" => time(),
            "payment_method" => 'Paypal',
            "invoice_status" => 'Paid',
            "txn_number" => $transaction_id
          );
          if(isset($note))
            $insert_paid["note"] = $note;
          $this->db->insert("invoice_payment",$insert_paid);

          //if($sendmail > 0 )
          $this->ordermodel->sendCustomerPaymentEmail($orderid,'Paypal',$note,$amount);

          $query = $this->ordermodel->getdata($orderid)->row();
          $notification = array(
            "content" => $this->session->userdata("customer_username").' has Paid for Order. #'.$query->order_number,
            "link" => 'order/details/'.$orderid,
            "from_id" => $query->customer_id,
            "to_id" => $query->company_id,
            "added_date" => date("Y-m-d")
          );
          $this->db->insert("company_notification",$notification);
          $this->session->set_flashdata("success_message","Payment done successfully.");
          redirect('dashboard/order','location');
        } else {
          $this->_error($do_ec_return);
        }
      } else {
        $this->_error($get_ec_return);
      }
    }


    function eway_direct_payment_customer($name, $cc_number, $validity, $sc_code, $email, $payment ,$sendmail,$note,$orderid) {
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

      $this->db->where("order_id",$orderid);
      $order = $this->db->get("order")->row();
      $this->load->library('ewaypayment');
      $company = $this->quotemodel->getCompanyDetails($order->company_id);
      $this->ewaypayment->setCustomerID($company->eway_id);
      $this->ewaypayment->setGatewayURL('https://www.eway.com.au/gateway_cvn/xmltest/testpage.asp');
 // $this->ewaypayment->setCustomerID('11668185');
 // $this->ewaypayment->setGatewayURL('https://www.eway.com.au/gateway_cvn/xmlpayment.asp');
      $this->ewaypayment->setCustomerFirstname($first_name);
      $this->ewaypayment->setCustomerLastname($last_name);
      $this->ewaypayment->setCustomerEmail($email);
      $this->ewaypayment->setCustomerAddress('adfsda');
      $this->ewaypayment->setCustomerPostcode('1111');
      $this->ewaypayment->setCustomerInvoiceDescription('Payment detail');
      $this->ewaypayment->setCustomerInvoiceRef('INV120394');
      $this->ewaypayment->setCardHoldersName($name);
      $this->ewaypayment->setCardNumber($cc_number);
      $this->ewaypayment->setCardExpiryMonth($expmonth);
      $this->ewaypayment->setCardExpiryYear($expyear);
      $this->ewaypayment->setTrxnNumber($orderid);
      $this->ewaypayment->setTotalAmount($amount);
      $this->ewaypayment->setCVN($sc_code);

      $check = $this->ewaypayment->doPayment();

      if ($check == EWAY_TRANSACTION_OK) {
        $transaction_id = $this->ewaypayment->getAuthCode();
        $order_update['transaction_id'] = $transaction_id;


        $dif = $order->due_amount - $this->input->post("paid");
        $this->db->where("order_id",$orderid);
        $this->db->set("due_amount",$dif);
        $this->db->set("invoice_status",8);
        $this->db->update("order");

        $insert_paid = array(
          "amount" => $payment,
          "invoice_id" => $orderid,
          "paid_date" => time(),
          "payment_method" => 'Eway',
          "note" => $note,
          "invoice_status" => 'Paid',
          "txn_number" => $transaction_id
        );
        $this->db->insert("invoice_payment",$insert_paid);

      //  if($sendmail > 0 )
        $this->ordermodel->sendCustomerPaymentEmail($orderid,'Eway',$note,$payment);

        $query = $this->ordermodel->getdata($orderid)->row();
        $notification = array(
          "content" => $this->session->userdata("customer_username").' has Paid for Order. #'.$query->order_number,
          "link" => 'order/details/'.$orderid,
          "from_id" => $query->customer_id,
          "to_id" => $query->company_id,
          "added_date" => date("Y-m-d")
        );
        $this->db->insert("company_notification",$notification);
        $this->session->set_flashdata('success_message', 'Payment done successfully');
        redirect($_SERVER["HTTP_REFERER"],'location');
      } else {
        $this->session->set_flashdata('error', 'Your Payment is not successfull.');
        redirect($_SERVER["HTTP_REFERER"],'location');
      }
    }

    function stripe_payment_customer($amount,$orderid){
       //  echo $this->input->post('access_token');
        // echo $this->mylibrary->getSiteEmail(84);
      //$order = $this->homemodel->getOrderdata($orderid)->row();
      try {

        $this->db->where("order_id",$orderid);
        $order = $this->db->get("order")->row();
        $company = $this->quotemodel->getCompanyDetails($order->company_id);
        Stripe::setApiKey($company->stripe_private_key);
        $charge = Stripe_Charge::create(array(
          "amount" => $amount * 100,
          "currency" => "AUD",
          "card" => $this->input->post('access_token'),
          "description" => "Stripe Payment"
        ));
            // this line will be reached if no error was thrown above
      //$transaction_id = $this->ewaypayment->getAuthCode();

        $transaction_id = $this->input->post('access_token');

       // $order_update['transaction_id'] = $transaction_id;


        $dif = $order->due_amount - $this->input->post("paid");
        $this->db->where("order_id",$orderid);
        $this->db->set("due_amount",$dif);
        $this->db->set("invoice_status",8);
        $this->db->update("order");
        $payment = $amount;
        $note = $this->input->post("note");
        $insert_paid = array(
          "amount" => $payment,
          "invoice_id" => $orderid,
          "paid_date" => time(),
          "payment_method" => 'Stripe',
          "note" => $note,
          "invoice_status" => 'Paid',
          "txn_number" => $transaction_id
        );
        $this->db->insert("invoice_payment",$insert_paid);

      //  if($sendmail > 0 )
        $this->ordermodel->sendCustomerPaymentEmail($orderid,'Stripe',$note,$payment);

        $query = $this->ordermodel->getdata($orderid)->row();
        $notification = array(
          "content" => $this->session->userdata("customer_username").' has Paid for Order. #'.$query->order_number,
          "link" => 'order/details/'.$orderid,
          "from_id" => $query->customer_id,
          "to_id" => $query->company_id,
          "added_date" => date("Y-m-d")
        );
        $this->db->insert("company_notification",$notification);
        $this->session->set_flashdata('success_message', 'Payment done successfully');
        redirect($_SERVER["HTTP_REFERER"],'location');
      } catch (Stripe_CardError $e) {
        $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
      } catch (Stripe_InvalidRequestError $e) {
        $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
      } catch (Stripe_AuthenticationError $e) {
        $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
      } catch (Stripe_ApiConnectionError $e) {
        $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
      } catch (Stripe_Error $e) {
        $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
      } catch (Exception $e) {
        $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
      }
      redirect($_SERVER["HTTP_REFERER"],'location');
    }



    function payment(){
      if($this->input->post("submit")){
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
            "paid_date" => time(),
            "payment_method" => $this->input->post("payment_method"),
            "note" => $this->input->post("note")
          );
          $this->db->insert("invoice_payment",$insert_paid);
          if($this->input->post("payment_method") == 'Eway'){
            $amount = $this->input->post('paid');
            $name = $this->input->post("card_name");
            $cardnum = $this->input->post("card_number");
            $expiry= $this->input->post("expiry_year").'-'.$this->input->post("expiry_month");
            $orderid = $this->input->post("invoice_id");
            $order = $this->ordermodel->getdata($orderid)->row();
            $ordernum = $order->order_number;
            $cvv = $this->input->post("ccv");
            $respose = $this->eway_direct_payment($name, $cardnum, $expiry, $cvv='007', $email='bikash@ausnep.com' ,$amount ,$user_id=5,$credits='10',8,$orderid,$ordernum);
          }elseif($this->input->post("payment_method") == "Credit Card"){
           $amount = $this->input->post('paid');
           $name = $this->input->post("card_name");
           $cardnum = $this->input->post("card_number");
           $expiry= $this->input->post("expiry_year").'-'.$this->input->post("expiry_month");
           $orderid = $this->input->post("invoice_id");
           $order = $this->ordermodel->getdata($orderid)->row();
           $ordernum = $order->order_number;
           $cvv = $this->input->post("ccv");
           $respose = $this->stripe_payment($amount,$orderid);
         }
         $this->ordermodel->sendPaymentEmail($this->input->post("sendmail"),$this->input->post("copy_me"));
       }
       if($this->input->post("tab") == 'invoice'){
         $this->session->set_flashdata('success_message', 'Payment done successfully');
         redirect($_SERVER["HTTP_REFERER"],'location');
       }else{
         $this->session->set_flashdata('success_message', 'Payment done successfully');
         redirect($_SERVER["HTTP_REFERER"],'location');
       }

     }else{
      $id = $this->uri->segment(3);
      $data["payments"] = $this->ordermodel->getPayments($id);
      $data['result'] = $this->ordermodel->getdata($id)->row();
      $data['invoices'] = $this->ordermodel->listInvoices();
      $this->load->view('payment', $data);
    }

  }

  function stripe_payment($amount,$orderid){
       //  echo $this->input->post('access_token');
        // echo $this->mylibrary->getSiteEmail(84);
      //$order = $this->homemodel->getOrderdata($orderid)->row();
    try {

      $this->db->where("order_id",$orderid);
      $order = $this->db->get("order")->row();
      $company = $this->quotemodel->getCompanyDetails($order->company_id);
      Stripe::setApiKey($company->stripe_private_key);
      $charge = Stripe_Charge::create(array(
        "amount" => $amount * 100,
        "currency" => "AUD",
        "card" => $this->input->post('access_token'),
        "description" => "Stripe Payment"
      ));
            // this line will be reached if no error was thrown above
      //$transaction_id = $this->ewaypayment->getAuthCode();

      $transaction_id = $this->input->post('access_token');

      $order_update['transaction_id'] = $transaction_id;
      $order_update['payment_type'] ='Stripe';
      $order_update['paid'] = 'Yes';
   // $this->homemodel->updateorder($order_update,$orderid);
   // $this->homemodel->sendEmail('Stripe',$orderid);
      $this->session->set_flashdata('success_message', 'Payment done successfully');
        //die('one');
    } catch (Stripe_CardError $e) {
      $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
    } catch (Stripe_InvalidRequestError $e) {
      $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
    } catch (Stripe_AuthenticationError $e) {
      $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
    } catch (Stripe_ApiConnectionError $e) {
      $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
    } catch (Stripe_Error $e) {
      $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
    } catch (Exception $e) {
      $this->session->set_flashdata("error","Something goes wrong. Payment UnSuccessful.");
    }
    redirect($_SERVER["HTTP_REFERER"],'location');
  }


  function eway_direct_payment($name, $cc_number, $validity, $sc_code, $email, $payment, $user_id, $credits,$package_id,$orderid,$ordernum) {
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

    $this->db->where("order_id",$orderid);
    $order = $this->db->get("order")->row();
    $this->load->library('ewaypayment');
    $this->db->where("order_id",$orderid);
    $order = $this->db->get("order")->row();
    $company = $this->quotemodel->getCompanyDetails($order->company_id);
 // $this->ewaypayment->setCustomerID('91533096');
    $this->ewaypayment->setCustomerID($company->eway_id);
    $this->ewaypayment->setGatewayURL('https://www.eway.com.au/gateway_cvn/xmltest/testpage.asp');
 // $this->ewaypayment->setCustomerID('11668185');
 // $this->ewaypayment->setGatewayURL('https://www.eway.com.au/gateway_cvn/xmlpayment.asp');
    $this->ewaypayment->setCustomerFirstname($first_name);
    $this->ewaypayment->setCustomerLastname($last_name);
    $this->ewaypayment->setCustomerEmail($email);
    $this->ewaypayment->setCustomerAddress('adfsda');
    $this->ewaypayment->setCustomerPostcode('1111');
    $this->ewaypayment->setCustomerInvoiceDescription('Payment detail');
    $this->ewaypayment->setCustomerInvoiceRef('INV120394');
    $this->ewaypayment->setCardHoldersName($name);
    $this->ewaypayment->setCardNumber($cc_number);
    $this->ewaypayment->setCardExpiryMonth($expmonth);
    $this->ewaypayment->setCardExpiryYear($expyear);
    $this->ewaypayment->setTrxnNumber($orderid);
    $this->ewaypayment->setTotalAmount($amount);
    $this->ewaypayment->setCVN($sc_code);

    $check = $this->ewaypayment->doPayment();

    if ($check == EWAY_TRANSACTION_OK) {
      $transaction_id = $this->ewaypayment->getAuthCode();
      $order_update['transaction_id'] = $transaction_id;
      $order_update['payment_type'] ='eway';
      $order_update['paid'] = 'Yes';
   // $this->homemodel->updateorder($order_update,$orderid);
   // $this->homemodel->sendEmail('Eway',$orderid);
      $this->session->set_flashdata('success_message', 'Payment done successfully');
      redirect($_SERVER["HTTP_REFERER"],'location');
    } else {
      $this->session->set_flashdata('success_message', 'Your Payment is not successfull.');
      redirect($_SERVER["HTTP_REFERER"],'location');
    }
  }

  function notes(){
    if($this->input->post("submit")){
      if($this->input->post("note") != ''){
        $note = array(
          "notes" => $this->input->post("note"),
          "order_id" => $this->input->post("order_id"),
          "added_by" => $this->session->userdata("clms_front_userid"),
          "added_date" => time()
        );
        $this->db->insert("order_installer_notes",$note);
      }
      $this->session->set_flashdata('success_message', 'Installer Note added successfully');
      redirect("dashboard/installer","");
    }else{
     $id = $this->uri->segment(3);
     $data["order_notes"] = $this->ordermodel->getOrderInstallersNotes($id);
     $data["order"] =$this->ordermodel->listallInstall_detail($id);
     $data['order_id'] = $id;
     $this->load->view('notes', $data);
   }

 }

 function calender_notes(){

   $id = $this->input->post("eventid");
   $order_notes = $this->ordermodel->getOrderInstallersNotes($id);
   foreach ($order_notes as $row) {
    ?>
    <tr>

      <td class=" text-dark">
        <?php echo $row->notes;?>
        <br>
        Added By: <?php echo $row->first_name.' '.$row->last_name;?> &nbsp;&nbsp; Added Date: <?php echo date("d/m/Y",$row->added_date);?>
      </td>
    </tr>
    <?php
  }
}

function install(){
  if($this->input->post("submit")){
    $this->load->model("installer/installermodel");
    $this->load->model("install_type/install_typemodel");
    $order_id = $this->input->post("order_id");
    $dates = explode('/',$this->input->post("reminder_date"));
    $order_installer = $this->ordermodel->getOrderInstallers($order_id);

    $installer = array(
      "order_id"=>$order_id,
      "installer"=> $this->input->post("installer"),
      "install_type"=> $this->input->post("install_type"),
      "installed_date" => $dates[2].'-'.$dates[1].'-'.$dates[0],
      "installed_time" => $this->input->post("time"),
      "time_allocate_by" => $this->input->post("allocate_by"),
      "hourly_rate" => $this->input->post("hourly_rate"),
      "total_hour" => $this->input->post("install_time"),
      "flat_amount" => $this->input->post("flat_amount"),
      "fuel_amount" => $this->input->post("fuel_amount"),
      "transport_amount" => $this->input->post("transport_amount"),
      "others_amount" => $this->input->post("others_amount"),
      "total_amount" => $this->input->post("total_amount"),
      "payment_method" => $this->input->post("payment_method"),
      "allocated_time" => $this->input->post("flat_install_time"),
      "assign_by" => $this->input->post("assign_by")
    );
    //print_r($installer);die();
    if(count($order_installer) >0){
      $this->db->where("order_id",$order_id);
      $this->db->update("order_installer",$installer);
      $install_id = $order_installer->id;
    }else{
      $installer['added_date'] = date("Y-m-d H:i:s");
      $installer['install_status'] = 22;
      $this->db->insert("order_installer",$installer);
      $install_id = $this->db->insert_id();
    }
    if($this->input->post("note") != ''){
      $note = array(
        "notes" => $this->input->post("note"),
        "order_id" => $order_id,
        "added_by" => $this->session->userdata("clms_front_userid"),
        "added_date" => time()
      );
      $this->db->insert("order_installer_notes",$note);
    }

    $this->db->set("order_status",'19');
    $this->db->where("order_id",$order_id);
    $this->db->update("order");

    $installer['note'] = $this->input->post("note");
    $installer['install_id'] = $install_id;
    $arr = array("install_id"=>$install_id,"sent_date"=>time());
    $this->db->insert("install_email",$arr);
    
    if($this->input->post("send_mail"))
      $this->ordermodel->send_mail_to_installer($installer);
    if($this->input->post("copy_me"))
      $this->ordermodel->send_mail_to_installer_me($installer);
    $this->session->set_flashdata('success_message', 'Installer added successfully');
    
    if($this->input->post("tab") == 'invoice'){
      redirect("dashboard/invoice","");
    }else{
      if($this->input->post('calendar'))
        redirect("dashboard/callendar","");
      else
        redirect("dashboard/order","");
    }

  }else{
    $id = $this->uri->segment(3);
    $data["order_installer"] = $this->ordermodel->getOrderInstallers($id);
    $data["order_notes"] = $this->ordermodel->getOrderInstallersNotes($id);
    $data["installers"] = $this->ordermodel->getInstallers();
    $data["installer_type"] = $this->ordermodel->getInstallerType();
    $data['result'] = $this->ordermodel->getdata($id)->row();
    $data["customer"] = $this->customermodel->getdata($data['result']->customer_id)->row();
    $this->load->view('install', $data);
  }

}

function get_order_detail(){
  $order_id = $this->input->post("orderid");
  $order =  $this->ordermodel->getdata($order_id)->row_array();
  $customer = $this->customermodel->getdata($order['customer_id'])->row();
  echo $customer->delivery_address1.', '.$customer->delivery_suburb.','.$this->ordermodel->getState($customer->delivery_state);
}

    //--------------------------------------add--------------------------------------	
function add() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"ADD")) {
    if ($this->input->post('submit')) {

    }else{
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

function add_order(){
  $userdata = $this->session->userdata("clms_front_userid");
  $data['has_referal'] = $this->companymodel->has_referal_permission($userdata,164);
  $company = $this->session->userdata("clms_front_companyid");
  $data['company'] = $this->companymodel->getdata($company)->row();
  if($this->input->post("submit")){

    $lead_type = $this->session->userdata('usergroup') == 9 ? 4 : $this->input->post("lead_type");
    $due_date =  date("Y-m-d",strtotime("+".$data['company']->duedatenumber." days")); 
    $order = array(
      "company_id"=>$this->session->userdata("clms_front_companyid"),
      "product"=>$this->input->post("txt_name"),
      "customer_id"=>$this->input->post("customer"),
      "package"=>$this->input->post("package_type"),
      "timeline"=>$this->input->post("timeline"),
      "testing"=>$this->input->post("testing"),
      "payment_terms"=>$this->input->post("payment"),
      "chk_timeline"=>$this->input->post("chk_timeline"),
      "chk_test"=>$this->input->post("chk_test"),
      "chk_payment"=>$this->input->post("chk_payment"),
        //"document"=>$this->input->post("product"),
      "description"=>$this->input->post("description"),
      "qprice"=>$this->input->post("price"),
      "discount"=>$this->input->post("discount"),
      "is_flat"=>$this->input->post("is_flat"),
      "lead_type"=> $lead_type,
      "is_referral_percentage"=>$this->input->post("is_referral_percentage"),
      "referral_discount"=>$this->input->post("referral_discount"),
      "referral_discount_amount" => $this->input->post("referal_discount_amount"),
      "total_after_referral_discount"=>$this->input->post("referal_subtotal"),
      "gst_applicable"=>$this->input->post("gst_applicable"),
      "is_included"=>$this->input->post("radio_gst"),
      "gst"=>$this->input->post("gst"),
      "price"=>$this->input->post("total_price"),
      "due_amount"=>$this->input->post("total_price"),
      "minimum_deposit"=>$this->input->post("minimum_deposit"),
      "finance_option"=>$this->input->post("finance"),
      "payment_term"=>$this->input->post("payment_terms"),
      "order_status"=>$this->input->post("order_status"),
      "invoice_status"=>$this->input->post("invoice_status"),
      "note" => $this->input->post("note"),
      "status"=>1,
      "added_by"=>$userdata,
      "added_date"=>time(),
      "expiry_date"=>$due_date
    );

    

    if($data['has_referal'] > 0 && $data['company']->enable_referral == 1 ) { 
      $referral = $this->ordermodel->get_referrals($this->input->post("customer"));

      if( $referral > 0){
        $commision = $this->ordermodel->get_commision($referral,$lead_type);
        $commision_rate = $commision->rate;
        $is_commision_percentage = $commision->is_percentage;
        if($is_commision_percentage == 0)
          $total_commision = $commision_rate;
        else
          $total_commision = ($commision_rate * $this->input->post("total_price"))/100;

        $order['commision'] = $total_commision;
      }
    }else{
     $order['commision'] = 0;
   }


   $this->db->insert("order",$order);

   $quote_id = $this->db->insert_id();
   $this->db->where("order_id",$quote_id);
   $this->db->set("order_number",1000+$quote_id);
   $this->db->update("order");

   $this->ordermodel->AddOrderReminder($quote_id);

   $package_desc = $this->input->post("package_desc");
   $package_qty = $this->input->post("package_qty");
   $package_price = $this->input->post("package_price");
   $short_desc = $this->input->post("short_desc");
   $package_amount = $this->input->post("package_amount");

   foreach ($package_desc as $key => $value) {
     if($value != ""){
      $package = array(
        "order_id"=> $quote_id,
        "descriptions" => $value,
        "short_desc" => $short_desc[$key],
        "quantity" => $package_qty[$key],
        "price" => $package_price[$key],
        "amount" => $package_amount[$key]
      );
      $this->db->insert("order_inverters",$package);
    }
  }

  if($this->input->post("docs")){
   $docs = $this->input->post("docs");
   foreach ($docs as $key => $value) {
    $document = array(
      "order_id" => $quote_id,
      "document_id" => $value,
    );
    $this->db->insert("order_documents",$document);
  }
}

if($this->input->post("advance_payment") && $this->input->post("advance_payment") > 0){

 $dif = $this->input->post("total_price") - $this->input->post("advance_payment");
 $this->db->where("order_id",$quote_id);
 $this->db->set("due_amount",$dif);
 $this->db->update("order");
        // if( $this->input->post("paid") != ""){
 $insert_paid = array(
  "amount" => $this->input->post("advance_payment"),
  "invoice_id" => $quote_id,
  "paid_date" => time(),
  "payment_method" => $this->input->post("payment_method"),
  "note" => $this->input->post("note")
);
 $this->db->insert("invoice_payment",$insert_paid);

       // }
}
if($this->input->post("send_email")){
  $this->ordermodel->sendmail($quote_id);
  $arr = array("order_id"=>$quote_id,"sent_date"=>time());
  $this->db->insert("order_email",$arr);
}

$query = $this->ordermodel->getdata($quote_id)->row();
$notification = array(
  "content" => $this->session->userdata("username").' has Added the Order. #'.$query->order_number,
  "link" => 'order/details/'.$quote_id,
  "from_id" => $this->session->userdata("clms_front_userid"),
  "to_id" => $query->customer_id,
  "added_date" => date("Y-m-d")
);

$this->db->insert("customer_notification",$notification);
$this->session->set_flashdata('success_message', 'Order added successfully');
if($this->input->post("tab") > 0)
  redirect('dashboard/order');
else
  redirect('order/listall');
}else{
  //$this->ordermodel->AddOrderReminder(325); die();
 $this->load->model("referals/referal_model");
 $userdata = $this->session->userdata("clms_front_userid");
 $data['has_referal'] = $this->companymodel->has_referal_permission($userdata,164);
 $data['referrals'] = $this->referal_model->get_referrals();
 
 $data['customers'] = $this->customermodel->listall(array("status"=>1));
 $data['products'] = $this->quotemodel->listProducts();
 $data['panels'] = $this->quotemodel->listPanels();
 $data['inverters'] = $this->quotemodel->listInverter();
    //$data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
 $data['heights'] = $this->quotemodel->listRoofHeight();
 $data['types'] = $this->quotemodel->listRoofType();
 $data['phases'] = $this->quotemodel->listPhase();
    //$data['status'] = $this->quotemodel->listQuoteStatus();
 $data['status'] = $this->ordermodel->listOrderStatus();
 $data['from'] = $this->quotemodel->listQuoteFrom();
 $data['invoices'] = $this->ordermodel->listInvoices();

 $data['countries'] = $this->customermodel->getcoutries();
 $data['states'] = $this->customermodel->getstates(13);
 $data['account_managers'] = $this->customermodel->getaccountmanager();
 $data['docs'] = $this->quotemodel->ListDocs();

 $data['lead_types'] = $this->ordermodel->get_leadtypes();

 $company = $this->session->userdata("clms_front_companyid");
 $data['company'] = $this->companymodel->getdata($company)->row();
 if($this->input->get("quote_number")){
  $quoteno = $this->input->get("quote_number");
  $data["quote"] = $this->ordermodel->getquote($quoteno);
  $data['cust'] = $this->quotemodel->getCustomer(@$data['quote']->customer_id);
  $data["quote_inverters"] = $this->ordermodel->getInverter(@$data["quote"]->quote_id);
        //print_r($data["inverters"]); die();
}
if($data['has_referal'] > 0 && $data['company']->enable_referral == 1 && $data['company']->enable_discount_referred_customer == 1) { 
  $data['page'] = 'add_order_referral';
}else{
  $data['page'] = 'add_order';
}
$data['heading'] = 'Add Lead Status';
$this->load->vars($data);
$this->load->view($this->container);
}
}

function pdf($id){
  $this->ordermodel->sendmail($id);
}

function remove_reminder_date(){
  $id = $this->input->post("reminder_id");
  $this->db->where("id",$id);
  $this->db->delete("pnp_order_reminder_date");
}


function details($id){ 
  if($this->input->post("reminder_date")){
    $date = explode('/',$this->input->post("reminder_date"));
    
    $insert_array = array(
      "company_id" => $this->session->userdata("clms_front_companyid"),
      "order_id" => $id,
      "reminder_date" => date("Y-m-d",strtotime(@$date[2].'-'.@$date[1].'-'.@$date[0]))
    );
    
    $this->db->insert("pnp_order_reminder_date",$insert_array);
    $this->session->set_flashdata('success_message', 'Invoice Reminder date added successfully');
    redirect("order/details/".$id);
  }else{
    $query = $this->ordermodel->getdata($id);
    if ($query->num_rows() > 0) {
      $data['result']   = $query->row();
      $data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
      $data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
      $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
      $data["quote_inverters"] = $this->ordermodel->getInverterOrder($id);
      $data["reminder_dates"] = $this->ordermodel->getorderReminder($id);
      $data['order_id'] = $id;
      $data['page']     = 'details';
      $data['heading']  = 'Edit Task status';
      $this->load->view('main', $data);
    } else {
      redirect('quote/listall');
    }
  }
  
}

function change_expiry_date(){
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"VIEW")) {
    if($this->input->post("order_id")){
      $date = explode("/",$this->input->post("expiry_date"));
      $expiry_date = $date[2].'-'.$date[1].'-'.$date[0];
      $orderid = $this->input->post("order_id");
      $this->db->set("expiry_date",$expiry_date);
      $this->db->where("order_id",$orderid);
      $this->db->update("order");
    //  echo $this->db->last_query(); die();
      $this->session->set_flashdata('success_message', 'Invoice Expiry date added successfully');
      redirect("order/details/".$orderid);
    }
  }

}


function print_report($id){
  $query = $this->ordermodel->getdata($id);
  if ($query->num_rows() > 0) {
    $data['result']   = $query->row();
    $data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
    $data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
    $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
    $data["quote_inverters"] = $this->ordermodel->getInverterOrder($id);
    $this->load->view('print', $data);
  } else {
    redirect('quote/listall');
  }
}

function print_invoice($id){
  $query = $this->ordermodel->getdata($id);
  if ($query->num_rows() > 0) {
    $data['result']   = $query->row();
    $data['cutomer'] = $this->quotemodel->getCustomer($data['result']->customer_id);
    $data['company'] = $this->quotemodel->getCompanyDetails($data['result']->company_id);
    $data['account_setting'] = $this->customermodel->get_account_detail($data['company']->country);
    $data["quote_inverters"] = $this->ordermodel->getInverterOrder($id);
    $this->load->view('print_invoice', $data);
  } else {
    redirect('quote/listall');
  }
}

function submit_order($id){
  $query = $this->ordermodel->getdata($id);
  if ($query->num_rows() > 0) {
    $quote = $query->row();
    $this->ordermodel->sendmail($id);
    $arr = array("order_id"=>$id,"sent_date"=>time());
    $this->db->insert("order_email",$arr);

    $query = $this->ordermodel->getdata($id)->row();
    $notification = array(
      "content" => $this->session->userdata("username").' has Send the Order Invoice. #'.$query->order_number,
      "link" => 'order/details/'.$id,
      "from_id" => $this->session->userdata("clms_front_userid"),
      "to_id" => $query->customer_id,
      "added_date" => date("Y-m-d")
    );

    $this->db->insert("customer_notification",$notification);
    $this->session->set_flashdata('success_message', 'Order Submited successfully.');
    redirect('dashboard/order');
  } else {
    redirect('dashboard/order');
  }
}

function submit_invoice($id){
  $query = $this->ordermodel->getdata($id);
  if ($query->num_rows() > 0) {
    $quote = $query->row();
    $this->ordermodel->sendmail_invoice($id);
    $arr = array("order_id"=>$id,"sent_date"=>time());
    $this->db->insert("order_email",$arr);
    $query = $this->ordermodel->getdata($id)->row();
    $notification = array(
      "content" => $this->session->userdata("username").' has Send the Order Invoice. #'.$query->order_number,
      "link" => 'order/details/'.$id,
      "from_id" => $this->session->userdata("clms_front_userid"),
      "to_id" => $query->customer_id,
      "added_date" => date("Y-m-d")
    );

    $this->db->insert("customer_notification",$notification);
    if($this->input->get("tab") == "invoice"){
      $this->session->set_flashdata('success_message', 'Invoice Submited successfully.');
      redirect('dashboard/invoice');
    }else{
      $this->session->set_flashdata('success_message', 'Order Submited successfully.');
      redirect('dashboard/order');
    }
    
  } else {
    redirect('dashboard/order');
  }
}

function preview_order($id){
  $query = $this->ordermodel->getdata($id);
  if ($query->num_rows() > 0) {
    $quote = $query->row();
    $this->ordermodel->preview_order($id);
    $filename = "./uploads/pdf/Invoice".$quote->order_number.".pdf";

    header("Content-Length: " . filesize($filename));
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=Invoice'.$quote->order_number.'.pdf');

    readfile($filename);

  } else {
    redirect('dashboard/order');
  }
}

function download_order($id){
  $query = $this->ordermodel->getdata($id);
  if ($query->num_rows() > 0) {
    $quote = $query->row();
    $this->ordermodel->download_order($id);
    $filename = "./uploads/pdf/Order".$quote->order_number.".pdf";

    header("Content-Length: " . filesize($filename));
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=Order'.$quote->order_number.'.pdf');

    readfile($filename);

  } else {
    redirect('dashboard/order');
  }
}

    //---------------------------------edit--------------------------------------

function update_price(){
  if($this->input->post("btn-submit")){
    $order_id = $this->input->post("order_id");
    $userdata = $this->session->userdata("clms_front_userid");

    $order = array(
      "company_id"=>$this->session->userdata("clms_front_companyid"),
      "due_amount"=>$this->input->post("due"),
      "description"=>$this->input->post("description"),
      "qprice"=>$this->input->post("price"),
      "discount"=>$this->input->post("discount"),
      "is_flat"=>$this->input->post("is_flat"),
      "gst_applicable"=>$this->input->post("gst_applicable"),
      "is_included"=>$this->input->post("radio_gst"),
      "gst"=>$this->input->post("gst"),
      "price"=>$this->input->post("total_price"),
      "minimum_deposit"=>$this->input->post("minimum_deposit"),
      "finance_option"=>$this->input->post("finance"),
      "payment_term"=>$this->input->post("payment_terms"),
      "added_by"=>$userdata,
      "added_date"=>time()
    );


    $this->db->where("order_id",$order_id);           
    $this->db->update("order",$order);

    $this->db->where("order_id",$order_id);
    $this->db->delete("order_inverters");

    $package_desc = $this->input->post("package_desc");
    $package_qty = $this->input->post("package_qty");
    $package_price = $this->input->post("package_price");
    $short_desc = $this->input->post("short_desc");

    foreach ($package_desc as $key => $value) {
     if($value != ""){
      $package = array(
        "order_id"=> $order_id,
        "descriptions" => $value,
        "short_desc" => $short_desc[$key],
        "quantity" => $package_qty[$key],
        "price" => $package_price[$key]
      );
      $this->db->insert("order_inverters",$package);
    }
  }


  if($this->input->post("advance_payment") && $this->input->post("advance_payment") != ''){

   $dif = $this->input->post("due") - $this->input->post("advance_payment");
   $this->db->where("order_id",$order_id);
   $this->db->set("due_amount",$dif);
   $this->db->update("order");

        // if( $this->input->post("paid") != ""){
   $insert_paid = array(
    "amount" => $this->input->post("advance_payment"),
    "invoice_id" => $order_id,
    "paid_date" => time(),
    "payment_method" => $this->input->post("payment_method"),
    "note" => $this->input->post("note")
  );
   $this->db->insert("invoice_payment",$insert_paid);

       // }
 }

 $query = $this->ordermodel->getdata($order_id)->row();
 $notification = array(
  "content" => $this->session->userdata("username").' has updated the Order. #'.$query->order_number,
  "link" => 'order/details/'.$order_id,
  "from_id" => $this->session->userdata("clms_front_userid"),
  "to_id" => $query->customer_id,
  "added_date" => date("Y-m-d")
);

 $this->db->insert("customer_notification",$notification);
 $this->session->set_flashdata('success_message', 'order edited Successfully');
 redirect('dashboard/order');
}else{
 $id = $this->input->post("order_id");
 $query = $this->ordermodel->getdata($id);
 $data['quote']  = $query->row();
  //print_r($data['quote']);
 $data['cust'] = $this->quotemodel->getCustomer($data['quote']->customer_id);
 $data["quote_inverters"] = $this->ordermodel->getInverterOrder($id);
 $this->load->view("update_price",$data);
}

}

function update($order_id){
  if($this->input->post("submit")){
    $status = $this->input->post("order_status");
    $customer = $this->input->post("customer_note");
    $admin = $this->input->post("admin_note");

    $this->db->where("order_id",$order_id);
    $this->db->set("order_status",$status);
    $this->db->update("order");

    if($this->input->post('useremails'))
      $useremails = $this->input->post('useremails');
    else
      $useremails = array();
    $other_email = $this->input->post('other_email');

    $other_emails = explode(',',$other_email);
    foreach ($other_emails as $key => $value) {
     array_push($useremails,$value);
   }

   $company = $this->quotemodel->getCompanyDetails($this->session->userdata('clms_company'));

   if($this->input->post("send_email"))
    array_push($useremails,$company->email);
  
  $this->ordermodel->sendmail_status($order_id,$useremails);

  $query = $this->ordermodel->getdata($order_id)->row();
  $notification = array(
    "content" => $this->session->userdata("username").' has added note on Order. #'.$query->order_number,
    "link" => 'order/update/'.$order_id,
    "from_id" => $this->session->userdata("clms_front_userid"),
    "to_id" => $query->customer_id,
    "added_date" => date("Y-m-d")
  );

  $this->db->insert("customer_notification",$notification);
  $this->session->set_flashdata('success_message', 'your status has been changed');
  redirect($_SERVER["HTTP_REFERER"]);
}else{
  $query = $this->ordermodel->getdata($order_id);
  $data['order_status'] = $this->ordermodel->listOrderStatus();
  $data['admin_notes'] = $this->ordermodel->listAdminNotes($order_id);
  $data['customer_notes'] = $this->ordermodel->listCustomerNotes($order_id);
  list($customer_arr,$customer_contacts) = $this->ordermodel->get_customers_lists($order_id);
  $data['customer_arr'] = $customer_arr;
  $data['customer_contacts'] = $customer_contacts;
  $data['row']  = $query->row();
  $data['page']     = 'update';
  $data['heading']  = 'Update job';
  $this->load->view('main', $data);
}
}

function admin_note($order_id){
 if($this->input->post("submit")){
  $status = $this->input->post("order_status");
  $customer = $this->input->post("customer_note");
  $admin = $this->input->post("admin_note");


  if($admin != ""){
    $admin_array = array("order_id"=>$order_id,"admin_note"=>$admin,"added_date"=>time(),"added_by"=>$this->session->userdata("clms_front_userid"));
    $this->db->insert("order_admin_note",$admin_array);
  }

  $this->session->set_flashdata('success_message', 'Order updated successfully');
  redirect($_SERVER["HTTP_REFERER"]);
}else{
  $query = $this->ordermodel->getdata($order_id);
  $data['order_status'] = $this->ordermodel->listOrderStatus();
  $data['admin_notes'] = $this->ordermodel->listAdminNotes($order_id);
  $data['customer_notes'] = $this->ordermodel->listCustomerNotes($order_id);
  $data['row']  = $query->row();
  $data['page']     = 'admin_note';
  $data['heading']  = 'Update job';
  $this->load->view('main', $data);
}
}

function public_customer_note($order_code){
 $invoice = explode('-',$order_code);
 $id = $invoice[1];

 $this->load->model("order/ordermodel");
 $slug = $this->ordermodel->getlatestpreview_slug($id,'order-customer-note');
 $expired = false;
 if($order_code != $slug)
  $expired = true;

$query = $this->ordermodel->getdata($id);
if ($query->num_rows() > 0) {
 $data['result']   = $query->row();
 if($invoice[3] == "cust"){
  $to = 'comp';
  $from_id = $data['result']->customer_id;
  $to_id =  $data['result']->company_id;
}else{
  $to = 'cust';
  $from_id = $data['result']->company_id;
  $to_id = $data['result']->customer_id;
}
if($this->input->post("submit")){
  $customer = $this->input->post("customer_note");

  if($customer != ""){

    $customer_array = array("order_id"=>$id,"customer_note"=>$customer,"added_date"=>time(),"added_by"=>$from_id);

    $config['upload_path'] = './uploads/document';
    $config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
    $config['max_width'] = 0;
    $config['max_height'] = 0;
    $config['max_size'] = 0;
    $config['encrypt_name'] = TRUE;
    $this->upload->initialize($config);
    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('attach_file'))
    {
      $error = array('error' => $this->upload->display_errors());
                   // print_r($error);
      $filename = '';
    }
    else
    {
      $arr_image = $this->upload->data();
      $customer_array['attached_file'] = $arr_image['file_name']; 
      $filename = $arr_image['file_name'];
    }

    $this->db->insert("order_customer_note",$customer_array);
  }

  $slug = $this->ordermodel->sendmailnote_public($id,$filename,$to);
    // if($this->input->post("send_email")){
    //   $arr = array("order_id"=>$id,"sent_date"=>time());
    //   $this->db->insert("order_email",$arr);
    // }

  $query = $this->ordermodel->getdata($id)->row();
  $notification = array(
    "content" => $this->session->userdata("username").' has added note on Order. #'.$query->order_number,
    "link" => 'order/update/'.$id,
    "from_id" => $this->session->userdata("clms_front_userid"),
    "to_id" => $query->customer_id,
    "added_date" => date("Y-m-d")
  );

  $this->db->insert("customer_notification",$notification);
  $this->session->set_flashdata('success_message', 'Order updated successfully');
  redirect($_SERVER["HTTP_REFERER"]);
   // redirect('order/public_customer_note/'.$slug);
}else{
  $query = $this->ordermodel->getdata($id);
  $data['order_status'] = $this->ordermodel->listOrderStatus();
  $data['admin_notes'] = $this->ordermodel->listAdminNotes($id);
  $data['customer_notes'] = $this->ordermodel->listCustomerNotes($id,'desc');
  $data['row']  = $query->row();
  $data['heading']  = 'Public customer note';
  // if($expired){
  //   $this->load->view('customer_public_note_expired', $data);
  // }else{
  $this->load->view('customer_public_note', $data);
  //}
}
} else {
  redirect('order/listall');
}
}


function customer_note($order_id){
  if($this->input->post("submit")){
    $status = $this->input->post("order_status");
    $customer = $this->input->post("customer_note");
    $admin = $this->input->post("admin_note");


    if($customer != ""){

      $customer_array = array("order_id"=>$order_id,"customer_note"=>$customer,"added_date"=>time(),"added_by"=>$this->session->userdata("clms_front_userid"));

      // $config['upload_path'] = './uploads/document';
      // $config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
      // $config['max_width'] = 0;
      // $config['max_height'] = 0;
      // $config['max_size'] = 0;
      // $config['encrypt_name'] = TRUE;
      // $this->upload->initialize($config);
      // $this->load->library('upload', $config);
      // if ( ! $this->upload->do_upload('attach_file'))
      // {
      //   $error = array('error' => $this->upload->display_errors());
      //              // print_r($error);
      //   $filename = '';
      // }
      // else
      // {
      //   $arr_image = $this->upload->data();
      //   $customer_array['attached_file'] = $arr_image['file_name']; 
      //   $filename = $arr_image['file_name'];
      // }

      $this->db->insert("order_customer_note",$customer_array);

      $note_id = $this->db->insert_id();

      $config['upload_path'] = './uploads/document';
      $config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
      $config['max_width'] = 0;
      $config['max_height'] = 0;
      $config['max_size'] = 0;
      $config['encrypt_name'] = TRUE;
      $this->upload->initialize($config);
      $this->load->library('upload', $config);
      foreach($_FILES as $key => $value) {
        if(!empty($_FILES[$key]['name'])){ 
          $this->upload->initialize($config);
          if (!$this->upload->do_upload($key)) { 
            $errors[] = $this->upload->display_errors();
           // print_r($errors);die();
          }else{ 
            $uploads = array($this->upload->data()); 
                        //print_r($uploads);
            foreach($uploads as $key => $value){ 
              $files = array(
                "note_id" => $note_id,
                "file_name" => $value['file_name']
              );
              $this->db->insert("order_customer_note_files",$files);

            }
          }
        }
      }
    }

    if($this->input->post('useremails'))
      $useremails = $this->input->post('useremails');
    else
      $useremails = array();
    $other_email = $this->input->post('other_email');

    $other_emails = explode(',',$other_email);
    foreach ($other_emails as $key => $value) {
     array_push($useremails,$value);
   }

   $company = $this->quotemodel->getCompanyDetails($this->session->userdata('clms_company'));

   if($this->input->post("copy_email"))
    array_push($useremails,$company->email);

  $this->ordermodel->sendmailnote($order_id,$note_id,$useremails);
  if($this->input->post("send_email")){
    $arr = array("order_id"=>$order_id,"sent_date"=>time());
    $this->db->insert("order_email",$arr);
  }

  $query = $this->ordermodel->getdata($order_id)->row();
  $notification = array(
    "content" => $this->session->userdata("username").' has added note on Order. #'.$query->order_number,
    "link" => 'order/update/'.$order_id,
    "from_id" => $this->session->userdata("clms_front_userid"),
    "to_id" => $query->customer_id,
    "added_date" => date("Y-m-d")
  );

  $this->db->insert("customer_notification",$notification);
  $this->session->set_flashdata('success_message', 'Order updated successfully');
  redirect($_SERVER["HTTP_REFERER"]);
}else{
  $query = $this->ordermodel->getdata($order_id);
  $data['order_status'] = $this->ordermodel->listOrderStatus();
  $data['admin_notes'] = $this->ordermodel->listAdminNotes($order_id);
  $data['customer_notes'] = $this->ordermodel->listCustomerNotes($order_id);
  $data['row']  = $query->row();
  list($customer_arr,$customer_contacts) = $this->ordermodel->get_customers_lists($order_id);
  $data['customer_arr'] = $customer_arr;
  $data['customer_contacts'] = $customer_contacts;
  $data['page']     = 'customer_note';
  $data['heading']  = 'Update job';
  $this->load->view('main', $data);
}
}

function edit() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"EDIT")) {
    $userdata = $this->session->userdata("clms_front_userid");
    $data['has_referal'] = $this->companymodel->has_referal_permission($userdata,164);
    $company = $this->session->userdata("clms_front_companyid");
    $data['company'] = $this->companymodel->getdata($company)->row();
    if ($this->input->post('submit')) {
      $order_id = $this->input->post("order_id");
      $userdata = $this->session->userdata("clms_front_userid");
      $lead_type = $this->session->userdata('usergroup') == 9 ? 4 : $this->input->post("lead_type");
      $order = array(
        "company_id"=>$this->session->userdata("clms_front_companyid"),
        "product"=>$this->input->post("txt_name"),
        "customer_id"=>$this->input->post("customer"),
        "package"=>$this->input->post("package_type"),
        "timeline"=>$this->input->post("timeline"),
        "testing"=>$this->input->post("testing"),
        "payment_terms"=>$this->input->post("payment"),
        "chk_timeline"=>$this->input->post("chk_timeline"),
        "chk_test"=>$this->input->post("chk_test"),
        "chk_payment"=>$this->input->post("chk_payment"),
        //"document"=>$this->input->post("product"),
        "due_amount"=>$this->input->post("due"),
        "description"=>$this->input->post("description"),
        "qprice"=>$this->input->post("price"),
        "discount"=>$this->input->post("discount"),
        "is_flat"=>$this->input->post("is_flat"),
        "lead_type"=>$lead_type,
        "is_referral_percentage"=>$this->input->post("is_referral_percentage"),
        "referral_discount"=>$this->input->post("referral_discount"),
        "referral_discount_amount" => $this->input->post("referal_discount_amount"),
        "total_after_referral_discount"=>$this->input->post("referal_subtotal"),
        "gst_applicable"=>$this->input->post("gst_applicable"),
        "is_included"=>$this->input->post("radio_gst"),
        "gst"=>$this->input->post("gst"),
        "price"=>$this->input->post("total_price"),
        "minimum_deposit"=>$this->input->post("minimum_deposit"),
        "finance_option"=>$this->input->post("finance"),
        "payment_term"=>$this->input->post("payment_terms"),
        "order_status"=>$this->input->post("order_status"),
        "invoice_status"=>$this->input->post("invoice_status"),
        "note" => $this->input->post("note"),
        "status"=>1,
        "added_by"=>$userdata,
        "added_date"=>time()
      );

      if($data['has_referal'] > 0 && $data['company']->enable_referral == 1) { 
        $referral = $this->ordermodel->get_referrals($this->input->post("customer"));

        if( $referral > 0){
          $commision = $this->ordermodel->get_commision($referral,$lead_type);
          $commision_rate = $commision->rate;
          $is_commision_percentage = $commision->is_percentage;
          if($is_commision_percentage == 0)
            $total_commision = $commision_rate;
          else
            $total_commision = ($commision_rate * $this->input->post("total_price"))/100;

          $order['commision'] = $total_commision;
        }
      }else{
       $order['commision'] = 0;
     }



     $this->db->where("order_id",$order_id);           
     $this->db->update("order",$order);

     $this->db->where("order_id",$order_id);
     $this->db->delete("order_inverters");

     $package_desc = $this->input->post("package_desc");
     $package_qty = $this->input->post("package_qty");
     $package_price = $this->input->post("package_price");
     $short_desc = $this->input->post("short_desc");
     $package_amount = $this->input->post("package_amount");

     foreach ($package_desc as $key => $value) {
       if($value != ""){
        $package = array(
          "order_id"=> $order_id,
          "descriptions" => $value,
          "short_desc" => $short_desc[$key],
          "quantity" => $package_qty[$key],
          "price" => $package_price[$key],
          "amount" => $package_amount[$key]
        );
        $this->db->insert("order_inverters",$package);
      }
    }

    $this->db->where("order_id",$order_id);
    $this->db->delete('order_documents');
    
    if($this->input->post("docs")){
     $docs = $this->input->post("docs");
     foreach ($docs as $key => $value) {
      $document = array(
        "order_id" => $order_id,
        "document_id" => $value,
      );
      $this->db->insert("order_documents",$document);
    }
  }

  if($this->input->post("advance_payment") && $this->input->post("advance_payment") != ''){

   $dif = $this->input->post("due") - $this->input->post("advance_payment");
   $this->db->where("order_id",$order_id);
   $this->db->set("due_amount",$dif);
   $this->db->update("order");

        // if( $this->input->post("paid") != ""){
   $insert_paid = array(
    "amount" => $this->input->post("advance_payment"),
    "invoice_id" => $order_id,
    "paid_date" => time(),
    "payment_method" => $this->input->post("payment_method"),
    "note" => $this->input->post("note")
  );
   $this->db->insert("invoice_payment",$insert_paid);

       // }
 }

 $query = $this->ordermodel->getdata($order_id)->row();
 $notification = array(
  "content" => $this->session->userdata("username").' has updated the Order. #'.$query->order_number,
  "link" => 'order/details/'.$order_id,
  "from_id" => $this->session->userdata("clms_front_userid"),
  "to_id" => $query->customer_id,
  "added_date" => date("Y-m-d")
);

 $this->db->insert("customer_notification",$notification);

 if($this->input->post("tab") == 'invoice'){
  $this->session->set_flashdata('success_message', 'Invoice edited Successfully');
  redirect('dashboard/invoice');
}
else{
  $this->session->set_flashdata('success_message', 'Order edited Successfully');
  redirect('dashboard/order');
}
} else {
  $userdata = $this->session->userdata("clms_front_userid");
  $data['customers'] = $this->customermodel->listall(array("status"=>1));
  $data['products'] = $this->quotemodel->listProducts();
  $data['panels'] = $this->quotemodel->listPanels();
  $data['inverters'] = $this->quotemodel->listInverter();
    //$data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
  $data['heights'] = $this->quotemodel->listRoofHeight();
  $data['types'] = $this->quotemodel->listRoofType();
  $data['phases'] = $this->quotemodel->listPhase();
    //$data['status'] = $this->quotemodel->listQuoteStatus();
  $data['status'] = $this->ordermodel->listOrderStatus();
  $data['invoices'] = $this->ordermodel->listInvoices();
  $data['from'] = $this->quotemodel->listQuoteFrom();
  $data['docs'] = $this->quotemodel->ListDocs();
  
  $id = $this->uri->segment(3);
  $query = $this->ordermodel->getdata($id);

  $order_docs = $this->ordermodel->orderdocs($id);
  $order_docs_ids = array();
  foreach ($order_docs as $key => $value) {
   array_push($order_docs_ids, $value['document_id']);
 }
 $this->load->model("referals/referal_model");
 $data['order_docs'] = $order_docs_ids;
 
 $data['referrals'] = $this->referal_model->get_referrals();
 $data['lead_types'] = $this->ordermodel->get_leadtypes();

 if ($query->num_rows() > 0) {
  $data['quote'] 	= $query->row();
  $data['cust'] = $this->quotemodel->getCustomer($data['quote']->customer_id);
  $data["quote_inverters"] = $this->ordermodel->getInverterOrder($id);
  if($data['has_referal'] > 0 && $data['company']->enable_referral == 1 && $data['company']->enable_discount_referred_customer == 1 && $data['quote']->referral_discount_amount > 0) { 
    $data['page'] = 'edit_order_referral';
  }else{
    $data['page'] = 'edit';
  }
  $data['heading'] 	= 'Edit Lead status';
  $this->load->view('main', $data);
} else {
  redirect('order/listall');
}
}
}
}

function duplicate()
{
  $this->load->model("referals/referal_model");
  $userdata = $this->session->userdata("clms_front_userid");
  $data['has_referal'] = $this->companymodel->has_referal_permission($userdata,164);
  $company = $this->session->userdata("clms_front_companyid");
  $data['company'] = $this->companymodel->getdata($company)->row();
  if($this->input->post("submit")){
   $userdata = $this->session->userdata("clms_front_userid");
   $lead_type = $this->session->userdata('usergroup') == 9 ? 4 : $this->input->post("lead_type");
   $order = array(
    "company_id"=>$this->session->userdata("clms_front_companyid"),
    "product"=>$this->input->post("txt_name"),
    "customer_id"=>$this->input->post("customer"),
    "package"=>$this->input->post("package_type"),
    "timeline"=>$this->input->post("timeline"),
    "testing"=>$this->input->post("testing"),
    "payment_terms"=>$this->input->post("payment"),
    "chk_timeline"=>$this->input->post("chk_timeline"),
    "chk_test"=>$this->input->post("chk_test"),
    "chk_payment"=>$this->input->post("chk_payment"),
          //"document"=>$this->input->post("product"),
    "description"=>$this->input->post("description"),
    "qprice"=>$this->input->post("price"),
    "discount"=>$this->input->post("discount"),
    "is_flat"=>$this->input->post("is_flat"),
    "lead_type"=> $lead_type,
    "is_referral_percentage"=>$this->input->post("is_referral_percentage"),
    "referral_discount"=>$this->input->post("referral_discount"),
    "referral_discount_amount" => $this->input->post("referal_discount_amount"),
    "total_after_referral_discount"=>$this->input->post("referal_subtotal"),
    "gst_applicable"=>$this->input->post("gst_applicable"),
    "is_included"=>$this->input->post("radio_gst"),
    "gst"=>$this->input->post("gst"),
    "price"=>$this->input->post("total_price"),
    "due_amount"=>$this->input->post("total_price"),
    "minimum_deposit"=>$this->input->post("minimum_deposit"),
    "finance_option"=>$this->input->post("finance"),
    "payment_term"=>$this->input->post("payment_terms"),
    "order_status"=>$this->input->post("order_status"),
    "invoice_status"=>$this->input->post("invoice_status"),
    "note" => $this->input->post("note"),
    "status"=>1,
    "added_by"=>$userdata,
    "added_date"=>time()
  );

   if($data['has_referal'] > 0 && $data['company']->enable_referral == 1 ) { 
    $referral = $this->ordermodel->get_referrals($this->input->post("customer"));
    
    if( $referral > 0){
      $commision = $this->ordermodel->get_commision($referral,$lead_type);
      $commision_rate = $commision->rate;
      $is_commision_percentage = $commision->is_percentage;
      if($is_commision_percentage == 0)
        $total_commision = $commision_rate;
      else
        $total_commision = ($commision_rate * $this->input->post("total_price"))/100;

      $order['commision'] = $total_commision;
    }
  }else{
   $order['commision'] = 0;
 }

 $this->db->insert("order",$order);

 $quote_id = $this->db->insert_id();
 $this->db->where("order_id",$quote_id);
 $this->db->set("order_number",1000+$quote_id);
 $this->db->update("order");

 $package_desc = $this->input->post("package_desc");
 $package_qty = $this->input->post("package_qty");
 $package_price = $this->input->post("package_price");
 $short_desc = $this->input->post("short_desc");
 $package_amount = $this->input->post("package_amount");

 foreach ($package_desc as $key => $value) {
   if($value != ""){
    $package = array(
      "order_id"=> $quote_id,
      "descriptions" => $value,
      "short_desc" => $short_desc[$key],
      "quantity" => $package_qty[$key],
      "price" => $package_price[$key],
      "amount" => $package_amount[$key]
    );
    $this->db->insert("order_inverters",$package);
  }
}

if($this->input->post("docs")){
 $docs = $this->input->post("docs");
 foreach ($docs as $key => $value) {
  $document = array(
    "order_id" => $quote_id,
    "document_id" => $value,
  );
  $this->db->insert("order_documents",$document);
}
}

if($this->input->post("advance_payment") && $this->input->post("advance_payment") > 0){

 $dif = $this->input->post("total_price") - $this->input->post("advance_payment");
 $this->db->where("order_id",$quote_id);
 $this->db->set("due_amount",$dif);
 $this->db->update("order");
            // if( $this->input->post("paid") != ""){
 $insert_paid = array(
  "amount" => $this->input->post("advance_payment"),
  "invoice_id" => $quote_id,
  "paid_date" => time(),
  "payment_method" => $this->input->post("payment_method"),
  "note" => $this->input->post("note")
);
 $this->db->insert("invoice_payment",$insert_paid);

         // }
}

if($this->input->post("send_email")){
  $this->ordermodel->sendmail($quote_id);
  $arr = array("order_id"=>$quote_id,"sent_date"=>time());
  $this->db->insert("order_email",$arr);
}

$query = $this->ordermodel->getdata($quote_id)->row();
$notification = array(
  "content" => $this->session->userdata("username").' has Added the Order. #'.$query->order_number,
  "link" => 'order/details/'.$quote_id,
  "from_id" => $this->session->userdata("clms_front_userid"),
  "to_id" => $query->customer_id,
  "added_date" => date("Y-m-d")
);

$this->db->insert("customer_notification",$notification);
$this->session->set_flashdata('success_message', 'Order added successfully');

if($this->input->post("tab") > 0)
  redirect('dashboard/order');
else
  redirect('order/listall');
}else{
 $data['customers'] = $this->customermodel->listall(array("status"=>1));
 $data['products'] = $this->quotemodel->listProducts();
 $data['panels'] = $this->quotemodel->listPanels();
 $data['inverters'] = $this->quotemodel->listInverter();
        //$data['quote_inverters'] = $this->quotemodel->listQuoteInverter($id);
 $data['heights'] = $this->quotemodel->listRoofHeight();
 $data['types'] = $this->quotemodel->listRoofType();
 $data['phases'] = $this->quotemodel->listPhase();
        //$data['status'] = $this->quotemodel->listQuoteStatus();
 $data['status'] = $this->ordermodel->listOrderStatus();
 $data['invoices'] = $this->ordermodel->listInvoices();
 $data['from'] = $this->quotemodel->listQuoteFrom();
 $data['docs'] = $this->quotemodel->ListDocs();
 $company = $this->session->userdata("clms_front_companyid");
 $data['company'] = $this->companymodel->getdata($company)->row();
 $id = $this->uri->segment(3);
 $query = $this->ordermodel->getdata($id);

 $order_docs = $this->ordermodel->orderdocs($id);
 $order_docs_ids = array();
 foreach ($order_docs as $key => $value) {
   array_push($order_docs_ids, $value['document_id']);
 }

 $data['order_docs'] = $order_docs_ids;
 $data['referrals'] = $this->referal_model->get_referrals();
 $data['lead_types'] = $this->ordermodel->get_leadtypes();

 if ($query->num_rows() > 0) {
  $data['quote']  = $query->row();
  $data['cust'] = $this->quotemodel->getCustomer($data['quote']->customer_id);
  $data["quote_inverters"] = $this->ordermodel->getInverterOrder($id);
  if($data['has_referal'] > 0 && $data['company']->enable_referral == 1 && $data['company']->enable_discount_referred_customer == 1 && $data['quote']->referral_discount_amount > 0) { 
    $data['page'] = 'duplicate_order_referral';
  }else{
    $data['page']     = 'duplicate';
  }
  
  $data['heading']  = 'Duplicate Quote';
  $this->load->view('main', $data);
} else {
  redirect('order/listall');
}
}
}

    //------------------------delete---------------------------------------------------------	
function delete() {
  if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm($this->module_code,"DELETE")) {
    $delid = $this->uri->segment('3');
    $cond = array("order_id"=>$delid);
    $this->ordermodel->delete($delid);
    $this->session->set_flashdata('success_message', 'Record deleted successfully');
    redirect('dashboard/order');
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
    $cond = array("order_id"=>$delid);
    $content = $this->usermodel->getDeletedData('order',$cond);
    $logs = array(
      "content" => serialize($content),
      "action" => $action,
      "module" => "Manage Order",
      "added_by" => $this->session->userdata("clms_front_userid"),
      "added_date" => time()
    );
    $this->usermodel->insertUserlog($logs); 
  }
  $query = $this->ordermodel->cascadeAction($ids, $action);
  $this->session->set_flashdata('success_message', ($action == 'delete' ? 'Deleted' : ($action == 'publish' ? 'Published' : 'Unpublished')) . ' successfully');
       // echo $this->db->last_query();
  exit();
}

function cascadeInstallerAction(){
 $data = $_POST['object'];
 $ids = $data['ids'];
 $status = $data['action'];
 $query = $this->ordermodel->cascadeInstallerAction($ids, $status);
 $this->session->set_flashdata('success_message', 'Status changed successfully');
 echo $this->db->last_query();
 exit();
}

function mail_preview($orderid){
  if($this->input->post("submit")){

    $subject = $this->input->post("subject");
    $message = $this->input->post("details123");
    $slug = $this->input->post("email_slug");

    $preview_link = array(
      "preview_id" => $orderid,
      "type" => 'order-invoice',
      "preview_slug" => $slug,
      "send_date" => date("Y-m-d h:i:s")
    );

    $this->db->insert("preview_link",$preview_link);

    $company = $this->quotemodel->getCompanyDetails($this->session->userdata('clms_company'));

    //count number of email sent times
    $arr = array("order_id"=>$orderid,"sent_date"=>time());
    $this->db->insert("order_email",$arr);

    if($this->input->post('useremails'))
      $useremails = $this->input->post('useremails');
    else
      $useremails = array();
    $other_email = $this->input->post('other_email');

    $other_emails = explode(',',$other_email);
    foreach ($other_emails as $key => $value) {
     array_push($useremails,$value);
   }

   if($this->input->post("copy_me"))
    array_push($useremails,$company->email);

  $this->ordermodel->sendmailwithcontent($orderid,$subject,$message,$useremails);
  $this->ordermodel->sendSms($orderid,2);
  $this->session->set_flashdata('success_message', 'Invoice sent successfully');
  if($this->input->post("tab") == 'invoice')
    redirect('dashboard/invoice');
  else
    redirect('dashboard/order');

}else{

  list($subject,$message,$customer_arr,$customer_contacts,$slug) = $this->ordermodel->getmailconent($orderid);
  $data['orderid'] = $orderid;
  $data['subject'] = $subject;
  $data['message'] = $message;
  $data['email_slug'] = $slug;
  $data['customer_arr'] = $customer_arr;
  $data['customer_contacts'] = $customer_contacts;
  $this->load->view('mail_preview', $data);

}

}

function mail_preview_invoice($orderid){
  if($this->input->post("submit")){

    $subject = $this->input->post("subject");
    $message = $this->input->post("details123");

    if($this->input->post("email_slug") && $this->input->post("email_slug") !=""){
      $slug = $this->input->post("email_slug");

      $preview_link = array(
        "preview_id" => $orderid,
        "type" => 'order-invoice',
        "preview_slug" => $slug,
        "send_date" => date("Y-m-d h:i:s")
      );

      $this->db->insert("preview_link",$preview_link);
    }

    $company = $this->quotemodel->getCompanyDetails($this->session->userdata('clms_company'));

    //count number of email sent times
    $arr = array("order_id"=>$orderid,"sent_date"=>time());
    $this->db->insert("order_email",$arr);

    if($this->input->post('useremails'))
      $useremails = $this->input->post('useremails');
    else
      $useremails = array();
    $other_email = $this->input->post('other_email');

    $other_emails = explode(',',$other_email);
    foreach ($other_emails as $key => $value) {
     array_push($useremails,$value);
   }

   if($this->input->post("copy_me"))
    array_push($useremails,$company->email);

  $this->ordermodel->sendmailwithcontent_invoice($orderid,$subject,$message,$useremails);
  $this->ordermodel->sendSms($orderid,49);
  $this->session->set_flashdata('success_message', 'Invoice sent successfully');
   //die();
  if($this->input->post("tab") == 'invoice')
    redirect('dashboard/invoice');
  else
    redirect('dashboard/order');

}else{

  list($subject,$message,$customer_arr,$customer_contacts,$slug) = $this->ordermodel->getmailconent_invoice($orderid);
  $data['orderid'] = $orderid;
  $data['subject'] = $subject;
  $data['email_slug'] = $slug;
  $data['message'] = $message;
  $data['customer_arr'] = $customer_arr;
  $data['customer_contacts'] = $customer_contacts;
  $this->load->view('mail_preview', $data);

}

}

function invoice_reminder($orderid){
  if($this->input->post("submit")){

    $subject = $this->input->post("subject");
    $message = $this->input->post("details123");

    if($this->input->post("email_slug") && $this->input->post("email_slug") !=""){
      $slug = $this->input->post("email_slug");

      $preview_link = array(
        "preview_id" => $orderid,
        "type" => 'order-invoice',
        "preview_slug" => $slug,
        "send_date" => date("Y-m-d h:i:s")
      );

      $this->db->insert("preview_link",$preview_link);
    }

    $company = $this->quotemodel->getCompanyDetails($this->session->userdata('clms_company'));

    //count number of email sent times
    $arr = array("order_id"=>$orderid,"sent_date"=>time());
    $this->db->insert("order_email",$arr);

    if($this->input->post('useremails'))
      $useremails = $this->input->post('useremails');
    else
      $useremails = array();
    $other_email = $this->input->post('other_email');

    $other_emails = explode(',',$other_email);
    foreach ($other_emails as $key => $value) {
     array_push($useremails,$value);
   }

   if($this->input->post("copy_me"))
    array_push($useremails,$company->email);

  $this->ordermodel->sendmailwithcontent_invoice($orderid,$subject,$message,$useremails);
  $this->session->set_flashdata('success_message', 'Invoice Reminder sent successfully');
   //die();
  if($this->input->post("tab") == 'invoice')
    redirect('dashboard/invoice');
  else
    redirect('dashboard/order');

}else{

  list($subject,$message,$customer_arr,$customer_contacts,$slug) = $this->ordermodel->getmailconent_invoice_remider($orderid);
  $data['orderid'] = $orderid;
  $data['subject'] = $subject;
  $data['message'] = $message;
  $data['email_slug'] = $slug;
  $data['customer_arr'] = $customer_arr;
  $data['customer_contacts'] = $customer_contacts;
  $this->load->view('mail_preview', $data);

}

}


public function count_install_mail_seen($install_id)
{
 $install_array = array(
  "install_id" => $install_id,
//"user_id" => $userid,
  "seen_date" => date("Y-m-d h:i:s")
);
 $this->db->insert("install_seen",$install_array);
}

public function count_mail_seen($orderid)
{
 $order_array = array(
  "order_id" => $orderid,
//"user_id" => $userid,
  "seen_date" => date("Y-m-d h:i:s")
);
 $this->db->insert("order_seen",$order_array);
}

function mail_preview_installer($install_id){
  $this->load->model("installer/installermodel");
  $this->load->model("install_type/install_typemodel");
  $install = $this->ordermodel->get_install_detail($install_id);
  if($this->input->post("submit")){

    $subject = $this->input->post("subject");
    $message = $this->input->post("details123");

    $company = $this->quotemodel->getCompanyDetails($this->session->userdata('clms_company'));

    //count number of email sent times
    $arr = array("install_id"=>$install_id,"sent_date"=>time());
    $this->db->insert("install_email",$arr);

    $useremails = array();
    $other_email = $this->input->post('other_email');
    $other_emails = explode(',',$other_email);
    foreach ($other_emails as $key => $value) {
     array_push($useremails,$value);
   }

   if($this->input->post("copy_me"))
    array_push($useremails,$company->email);

  $this->ordermodel->sendmailwithcontent_installer($install,$subject,$message,$useremails);
  $this->session->set_flashdata('success_message', 'Mail sent successfully');

  redirect('dashboard/installer');

}else{

  list($subject,$message) = $this->ordermodel->get_mail_to_installer_content($install);
  $data['install'] = $install;
  $data['subject'] = $subject;
  $data['message'] = $message;
  $this->load->view('mail_preview_install', $data);

}
}

}