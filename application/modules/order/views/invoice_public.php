
<!doctype html>
<html class="fixed">
<head>
	<style type="text/css">
		.today{
			background-color: #0088cc;
		}
	</style>
	<!-- Basic -->
	<meta charset="UTF-8">

	<?php
	//$site_name = $this->generalsettingsmodel->getConfigData(20)->row();
	$site_title = $this->generalsettingsmodel->getConfigData(20)->row();
	$site_keyword = $this->generalsettingsmodel->getConfigData(44)->row();
	$site_desc = $this->generalsettingsmodel->getConfigData(45)->row();

	?>
	<title><?php echo $site_title->config_value; ?></title>
	<meta name="keywords" content="<?php echo $site_keyword->config_value; ?>" />
	<meta name="description" content="<?php echo $site_desc->config_value; ?>">
	<meta name="author" content="ausnep.com.au">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap/css/bootstrap.css" />

	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/morris/morris.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/select2/select2.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />
	
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/fullcalendar/fullcalendar.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/fullcalendar/fullcalendar.print.css" media="print" />
	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/theme-custom.css">

	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/colorbox.css">
	<!-- Head Libs -->
	<script src="<?php echo  base_url("");?>assets/vendor/modernizr/modernizr.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jquery/jquery.js"></script>
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
	<!-- Invoice Print Style -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/invoice-print.css" />
	

	<style>
		@media only screen and (min-width: 768px){
			html.fixed .content-body {
				margin-left: 0px;}

				html.fixed .page-header
				{
					left: 0;
					top:0;
					z-index: 1;
				}
				html.fixed .header {
					position: fixed;
					z-index: 1020;
					top: 48px;
				}
				html.fixed .inner-wrapper {
					padding-top: 140px;
				}


			}

			.inner-wrapper .invoice-wrap .fixed .content-body{
				margin-left: 0px !important;
			}

			.invoice {
				padding: 0 15px 15px;
				background: white;
				border: 1px solid #ddd;
			}

			.inner-wrapper .invoice-wrap .content-body
			{

				padding:0;
			}
			.page-header h2
			{
				padding: 0px 20px;
			}

			.payment-strip {
				width: 100%;
				padding: 10px 0;
				background: #fff;
				display: flex;
				align-items: center;
			}
			.payment-strip .pay-container
			{
				float: left;
			}
			.payment-strip .pay-container, .payment-strip .save-buttons {
				display: flex;
				align-items: center;
			}
			.payment-strip .pay-btn {
				min-width: 150px;
				margin-right: 20px;
			}
			.payment-strip .amount {
				font-size: 26px;
				display: flex;
				flex-direction: column;
				white-space: nowrap;
				font-weight: bold;
			}
			.payment-strip .amount .currency {
				font-weight: normal;
				font-size: 20px;
				color: #7e90a2;
			}
			a#button-1010 {
				color: white;
				text-align: center;
				padding-left: 39px;
			}
			span.status.due.in-future {
				font-size: 14px;
				font-weight: normal;
			}
			.download-file
			{
				float:right;

			}
			.download-file ul li {
				list-style: none;
				float: left;
				margin-left:20px;
			}

			.download-file ul li a


			{
				color:#999;
				padding:8px 30px ;
				text-decoration:none;
				border:1px solid #47a447;
				display: inline-block;
				transition:05s;
				-webkit-transition:0.5s;
				-moz-transition:0.5s;

			}

			.download-file ul li a:hover
			{
				background:#47a447;
				color:white;
			}

			@media only screen and (max-device-width: 480px){
				.download-file
				{
					float:none;
					text-align: center;
					margin-top:10px;
				}
				.download-file ul li
				{
					margin-left:5px;
				}
				.download-file ul li a
				{
					padding:5px 20px;
				}
				.payment-strip .amount
				{
					font-size: 14px;
				}


				.page-header{
					position: fixed;
					width: 100%;
				}

				.header{
					position: fixed;
					top: 52px;
				}


				.inner-wrapper .invoice-wrap .content-body{
					margin-left: 0px !important;
					top: 169px !important;
				}


			}
		</style>


	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<?php
			$row = $this->generalsettingsmodel->getConfigData(24)->row();
			?>
			<header class="page-header">
				<h2><?php echo $site_title->config_value; ?> </h2>

			</header>


			<header class="header">
				<div class="payment-strip">
					<div class="container">
						<div class="pay-container">
							<?php if($company->chk_payment_online > 0 && $result->due_amount > 0){ ?>
							<div class="pay-btn btn btn-success" id="ext-gen1026"><a  href="#form_payment" class="popup-with-form x-btn green x-unselectable x-btn-default-small x-noicon x-btn-noicon x-btn-default-small-noicon x-border-box" style="display:flex;width:100px;" role="button" hidefocus="on" unselectable="on" tabindex="0" href="#" target="_blank" id="button-1010"><span id="button-1010-btnWrap" class="x-btn-wrap" unselectable="on"><span id="button-1010-btnEl" class="x-btn-button"><span id="button-1010-btnInnerEl" class="x-btn-inner x-btn-inner-center" unselectable="on">Pay now</span><span role="img" id="button-1010-btnIconEl" class="x-btn-icon-el  " unselectable="on" style=""></span></span></span></a></div>
							<?php } ?>
							<div class="amount">
								<span><?php echo number_format($result->due_amount,2);?> <span class="currency"><?php echo @$account_setting->currency_code;?></span></span>
								<span class="status due in-future"><strong>Due Date:</strong> <?php echo date("d/m/Y",strtotime($result->expiry_date));?></span>

							</div>
						</div>



						<div class="download-file">
							<ul>
								<li><a href="<?php echo base_url("order/preview_order/".$result->order_id);?>">Download</a></li>
								<li><a href="<?php echo base_url("order/print_invoice/".$result->order_id);?>">Print</a></li>
							</ul>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>

				<form id="form_payment" action="<?php echo base_url("order/payment_customer");?>" method="post" class="white-popup-block mfp-hide form-horizontal">

					<div class="form-group">

						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table invoice-items">
									<thead>
										<tr class="h4 text-dark" >
											<th id="cell-item" class="text-weight-semibold" colspan="4">Payment Info</th>
										</tr>
										<tr class="h4 text-dark">
											<th id="cell-item" class="text-weight-semibold">Date</th>
											<th id="cell-desc" class="text-weight-semibold">Amount</th>
											<th id="cell-desc" class="text-weight-semibold">Payment Method</th>
											<th id="cell-desc" class="text-weight-semibold">Note</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$payments = $this->ordermodel->getPayments($result->order_id);
										foreach ($payments as $row) {
											?>
											<tr>
												<td><?php echo date("d/m/Y",$row->paid_date);?></td>
												<td class="text-weight-semibold text-dark"><?php echo $row->amount;?></td>
												<td class="text-weight-semibold text-dark"><?php echo $row->payment_method;?></td>
												<td class="text-weight-semibold text-dark"><?php echo $row->note;?></td>							</tr>
												<?php
											}

											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<hr>

						<div class="form-group">
							<label class="col-md-3 control-label">Due Amount</label>
							<div class="col-sm-6">
								<?php echo $result->due_amount;?>
								<input type="hidden" name="due" value="<?php echo $result->due_amount;?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Amount Paid</label>
							<div class="col-sm-6">
								<input type="text" class="form-control required number" max="<?php echo $result->due_amount;?>" value="" name="paid" id="paid" >
							</div>
						</div>

						<div class="form-group mb-lg">
							<strong>Select Payment Type</strong>
						</div>

						<div class="form-group">
							<?php if($company->chk_eway == 1){ ?>

							<div class="col-md-3">
								<input type="radio" name="paymethod" value="eway" id="ewaypayment" class="payment-radio-class"  required  />
								<img src="<?php echo base_url("assets/images/");?>/payment-icon.jpg" style="width:60%" >
							</div>
							<?php
						}
						?>
						<?php if($company->chk_stripe == 1){ ?>
						<div class="col-md-3">
							<input type="radio" name="paymethod" value="stripe" id="stripepayment" class="payment-radio-class"  required  />
							<img src="<?php echo SITE_URL."assets/images/stripe.png"; ?>" style="width:60%">
						</div>
						<?php
					}
					?>
					<?php if($company->chk_bank == 1){ ?>
					<div class="col-md-3 ">
						<input type="radio" name="paymethod"  class="payment-radio-class" value="bank" id="banktransfer" required />
						<img src="<?php echo base_url("assets/images/");?>/bank-transfer.gif">
					</div>
					<?php } ?>
					<?php if($company->chk_paypal == 1){ ?>
					<div class="col-md-3 ">
						<input type="radio" name="paymethod"  class="payment-radio-class" value="paypal" id="paypal">
						<img src="<?php echo base_url("assets/images/");?>/paypal.png" style="width:60%">
					</div>
					<?php } ?>
				</div>


				<div style="display:none;" id="div_eway">
					<input type="hidden" name="access_token" id="access_token" value="">
					<div class="form-group" >
						<label class="col-md-3 control-label" for="card_name">Card Name *:</label>
						<div class="col-md-6">
							<input type="text"  value="" id="card_name" name="card_name" placeholder="Enter Your Card Name" class="form-control" >
						</div>
					</div>

					<div class="form-group" >
						<label class="col-md-3 control-label" for="card_number">Card Number *:</label>
						<div class="col-md-6">
							<input type="text"  value="" id="card_number" name="card_number" data-stripe="number" placeholder="Enter Your Card Number" class="form-control " >

						</div>
					</div>

					<div class="form-group" >
						<label class="col-md-3 control-label" for="expiry_month">Expiry Date *:</label>
						<div class="col-md-3">
							<select name="expiry_month" id="expiry_month" data-stripe="exp_month" class="form-control" >
								<option value="">Month</option>
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>

						</div>
						<div class="col-md-3">
							<select name="expiry_year" id="expiry_year" data-stripe="exp_year" class="form-control" >
								<option value="">Year</option>
								<option value="17">2017</option>
								<option value="18">2018</option>
								<option value="19">2019</option>
								<option value="20">2020</option>
								<option value="21">2021</option>
								<option value="22">2022</option>
								<option value="23">2023</option>
								<option value="24">2024</option>
								<option value="25">2025</option>
								<option value="26">2026</option>
								<option value="27">2027</option>
								<option value="28">2028</option>
								<option value="29">2029</option>
								<option value="30">2030</option>
							</select>

						</div>
					</div>

					<div class="form-group" >
						<label class="col-md-3 control-label" for="ccv">CCV *</label>
						<div class="col-md-6">
							<input type="text"  value="" id="ccv" name="ccv" data-stripe="cvc" placeholder="Enter CCV" class="form-control" >
						</div>
						<?php //echo form_error("sex");?>
					</div>
					<br>
				</div>
				<?php if($company->chk_bank == 1){ ?>
				<div class="icon-border" id="div_bank" style="display:none;">
					<div class="form-group">
						<div class="col-md-12 ">
							<?php echo $company->company_name; ?><br/>BSB: <?php echo $company->bsb; ?> <br/>A/C No.: <?php echo $company->account_no; ?><br/>  <?php echo $company->bank; ?>
						</div>
					</div>
				</div>
				<?php } ?>
<?php /*
							<div class="form-group">
								<label class="col-md-3 control-label" for="price">Invoice</label>
								<div class="col-md-6">
									<select name="invoice_status" id="invoice_status" class="form-control required" >
										<option value=""></option>
										<?php 
										foreach ($invoices as $row){
											?>
											<option value="<?php echo $row->status_id;?>" <?php if(@$result->invoice_status == $row->status_id) echo 'selected="selected"';?>><?php echo $row->status_name;?></option>
											<?php
										}
										?>

									</select>

								</div>
							</div>
*/ ?>
<div class="form-group" >
	<label class="col-md-3 control-label" for="payment_method">Special Note:</label>
	<div class="col-md-6">
		<textarea name="note" id="note" class="form-control"></textarea>

	</div>
	<?php //echo form_error("sex");?>
</div>
							<?php /*
							<div class="form-group" >
								<label class="col-md-3 control-label" for="payment_method"></label>
								<div class="col-md-6">
									<input type="checkbox" name="sendmail" value="1" checked=""> Send email automatically

								</div>
								<?php //echo form_error("sex");?>
							</div>
							*/
							?>
							<div class="row mb-lg">
								<div class="col-sm-9 col-sm-offset-3">
									<input type="hidden" name="tab" value="<?php echo $this->input->get("tab");?>">
									<input type="hidden" value="<?php echo $result->order_id;?>" name="invoice_id">
									<input type="submit" value="Submit" name="submit" class="btn btn-primary">
									<button type="reset" class="btn btn-default">Reset</button>
								</div>
							</div>


						</form>
						<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
						<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

						<script type="text/javascript">
							$(document).ready(function(){
								 //Stripe.setPublishableKey('pk_test_JIbsTfUxDOQnFUt7LzE9fkzr');
								 Stripe.setPublishableKey('<?php echo $company->stripe_public_key;?>');
								 $("#form_payment").validate();


								 $('.payment-radio-class').click(function() { 
								 	if ($(this).val() == 'bank'){
								 		$('.bank-info').slideDown();
								 		$('#extrachargesinfo2').hide();
								 		$("#div_bank").show();
								 		$("#div_eway").hide();
								 	}

								 	if ($(this).val() == 'eway' || $(this).val() == 'stripe'){
								 		$("#card_name").addClass("required");
								 		$("#card_number").addClass("required");
								 		$("#expiry_month").addClass("required");
								 		$("#expiry_year").addClass("required");
								 		$("#ccv").addClass("required");
								 		$("#div_eway").show();
								 		$('.bank-info').slideUp();
								 		$('#extrachargesinfo2').show();
								 		$("#div_bank").hide();
								 		$("#div_eway").show();
								 	}else{
								 		$("#card_name").removeClass("required");
								 		$("#card_number").removeClass("required");
								 		$("#expiry_month").removeClass("required");
								 		$("#expiry_year").removeClass("required");
								 		$("#ccv").removeClass("required");
								 		$("#div_eway").hide();
								 	}

								 	if ($(this).val() == 'paypal'){
								 		$("#div_bank").hide();  
								 		$("#div_eway").hide();    
								 	}
								 });

var $form = $('#form_payment');
$("#ccv").blur(function(event) { 
	if(  $('input[name=paymethod]:checked').val() == 'stripe'){ 
		Stripe.card.createToken($form, stripeResponseHandler);
	}
	return false;
});
});



function stripeResponseHandler(status, response) {

	if (response.error) {
		alert(response.error.message);
	} else {
		$("#access_token").val(response.id);
		console.log(response.id);
	}
}
</script>
</header>

<div class="container">
	<div class="inner-wrapper">
		<!-- start: sidebar -->
		<div class="invoice-wrap">
			<?php 
			if($this->session->flashdata("success_message"))
			{
				?>
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<strong>Well done!</strong> <?php echo $this->session->flashdata("success_message");?>
				</div>
				<?php
			}
			?>
			<?php 
			if($this->session->flashdata("error"))
			{
				?>
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<strong>Ops!</strong> <?php echo $this->session->flashdata("error");?>
				</div>
				<?php
			}
			?>
			<!-- end: sidebar -->
			<section role="main" class="content-body">

				<div class="invoice">
					<header class="clearfix">
						<div class="row">
							<div class="col-sm-6 mt-md">
								<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">Invoice</h2>
								<h4 class="h4 m-none text-dark text-weight-bold">#<?php echo $result->order_number; ?></h4>
							</div>
							<div class="col-sm-6 text-right mt-md mb-md">
								<address class="ib mr-xlg">
									<?php echo $company->company_name;?>
									<br/>
									<?php echo $company->address;?>
									<br/>
									Phone: <?php echo $company->phone;?>
									<br/>
									<?php echo $company->email;?>
									<?php 
									if($company->chk_field3 == 1 && $company->license_no != ''){
										echo '<br/>';
										echo $company->license_no_label == ''?'License No.':$company->license_no_label.': '.$company->license_no;
									} ?>
								</address>
								<div class="ib">
									<?php if(file_exists("./assets/uploads/users/thumb/".$company->thumbnail) && $company->thumbnail != ""){ ?>
									<img src="<?php echo SITE_URL."assets/uploads/users/thumb/".$company->thumbnail;?>" alt="OKLER Themes" />
									<?php } ?>
								</div>
							</div>
						</div>
					</header>

					<div class="bill-info">
						<div class="row">
							<div class="col-md-6">
								<div class="bill-to">
									<p class="h5 mb-xs text-dark text-weight-semibold">To:</p>
									<address>
										<?php echo $cutomer->customer_name;?>
										<br/>
										<?php echo $cutomer->billing_address1;?>, <?php echo $cutomer->billing_suburb;?>
										<br/>
										Phone: <?php echo $cutomer->contact_number;?>
										<br/>
										<?php echo $cutomer->email;?>
									</address>
								</div>
							</div>
							<div class="col-md-6">
								<div class="bill-data text-right">
									<p class="mb-none">
										<span class="text-dark">Order Date:</span>
										<span class="value"><?php echo date("d/m/Y",$result->added_date);?></span>
									</p>

								</div>
							</div>
						</div>
						<?php
						$package = $this->quotemodel->getpackage($result->package);
						$timeline = $this->quotemodel->gettimeline($result->timeline);
						?>
						<div class="row">
							<div class="col-md-12">
								<div class="bill-to">
									<p ><span class="h5 mb-xs text-dark text-weight-semibold">Nature of Project:</span> <?php echo $result->product;?> </p>

								</div>
							</div>

						</div>

						<!-- <div class="row">
							<div class="col-md-12">
								<div class="bill-to">
									<p ><span class="h5 mb-xs text-dark text-weight-semibold">Package Type:</span> <?php echo $package->name;?> </p>

								</div>
							</div>

						</div> -->
					</div>


					<div class="table-responsive">
						<table class="table invoice-items">
							<thead>

								<tr >

									<td colspan="6"><strong>Project Features: </strong></td>

								</tr>
								<tr >
									<td>&nbsp;</td>
									<td colspan="5"><?php echo $result->description;?></td>

								</tr>

							</thead>

							<tbody>
								<tr>
									<td colspan="2">Description</td>
									<td colspan="2">Quantity</td>
									<td >Price (<?php echo @$account_setting->currency_code;?>)</td>
									<td >Total (<?php echo @$account_setting->currency_code;?>)</td>
								</tr>
								<?php
								foreach ($quote_inverters as $row ) {
									?>
									<tr>
										<td colspan="2"><?php echo $row->descriptions;?>
											<p style="font-size:10px;"><?php if($row->short_desc != "") echo '('.$row->short_desc.')'; ?></p>
										</td>
										<td colspan="2"><?php echo $row->quantity;?></td>
										<td ><?php echo number_format($row->price,2);?></td>
										<td ><?php echo number_format($row->amount,2);?></td>
									</tr>
									<?php } ?>

									<tr>
										<td colspan="6" style="text-align:right;"><strong>Regular Price:</strong> <?php echo number_format($result->qprice,2);?>(<?php echo @$account_setting->currency_code;?>)</td>
									</tr>
									<?php if($result->discount > 0){ ?>
									<tr>
										<td colspan="6" style="text-align:right;"><strong>Discount : </strong><?php echo number_format($result->discount,2);?><?php if($result->is_flat > 0) echo '%'; else echo '('.@$account_setting->currency_code.')'; ?></td>
									</tr>
									<?php } ?>
									<?php
									if($result->is_included == 1){
										$subtotal = $result->price - $result->gst;
									}else{
										$subtotal = $result->price;
									}
									?>
									<tr>
										<td colspan="6" style="text-align:right;"><strong>Sub Total : </strong><?php echo number_format($subtotal,2);?>(<?php echo @$account_setting->currency_code;?>) </td>
									</tr>
									<?php if($result->gst_applicable == 1){ ?>
									<tr>
										<td colspan="6" style="text-align:right;"><strong><?php echo $result->is_included == 1 ? '':'Including'; ?> <?php echo @$account_setting->gst_title;?> : </strong><?php echo number_format($result->gst,2);?>(<?php echo @$account_setting->currency_code;?>) </td>
									</tr>
									<?php }else{
										?>
										<tr>
											<td colspan="6" style="text-align:right;"><strong> <?php echo @$account_setting->gst_title;?> : -</strong> </td>
										</tr>
										<?php
									} ?>
									<tr>
										<td colspan="6" style="text-align:right;"><strong>Total Price: </strong><?php echo number_format($result->price,2);?>(<?php echo @$account_setting->currency_code;?>)</td>
									</tr>

									<tr>
										<td colspan="6" style="text-align:right;"><strong>Paid: </strong><?php echo number_format($result->price-$result->due_amount,2);?>(<?php echo @$account_setting->currency_code;?>)</td>
									</tr>

									<tr>
										<td colspan="6" style="text-align:right;"><strong>Due: </strong><?php echo number_format($result->due_amount,2);?>(<?php echo @$account_setting->currency_code;?>)</td>
									</tr>
									<?php if($result->chk_timeline == 0){?>
									<tr>
										<td colspan="6"><strong>Timeline: </strong><?php echo $timeline->name;?></td>
									</tr>
									<?php }  ?>
									<?php if($result->chk_test == 0 && $company->chk_field1 == 1){?>
									<tr>
										<td colspan="6"><strong><?php echo $company->project_test_label == ''?'Project Testing':$company->project_test_label; ?></strong> <?php echo $result->testing;?></td>
									</tr>
									<?php } ?>
									<?php if($result->chk_payment == 0 && $company->chk_field2 == 1){?>
									<tr>
										<td colspan="6"><strong>Payment Terms: </strong><?php echo $company->payment_term_label == ''?'Payment Terms':$company->payment_term_label; ?></td>
									</tr>
									<?php } ?>
									<tr>
										<td colspan="6" style="color:red;"><strong>Note: </strong><?php echo $result->note;?></td>
									</tr>

								</tbody>
							</table>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
	<?php
	$row = $this->generalsettingsmodel->getConfigData(24)->row();
	?>
	<div class="container">
		<div style="text-align:center;margin:20px 0;">
			<a href="<?php echo base_url("");?>" >
				<img src="<?php echo SITE_URL."uploads/logo/".$row->config_value;?>" />
			</a>
		</div>
	</div>
	<script src="<?php echo base_url("");?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

	<!-- Specific Page Vendor -->
	<script src="<?php echo base_url("");?>assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jquery-appear/jquery.appear.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.pie.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.categories.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.resize.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/raphael/raphael.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/morris/morris.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/gauge/gauge.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/snap-svg/snap.svg.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/liquid-meter/liquid.meter.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jqvmap/jquery.vmap.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jquery-autosize/jquery.autosize.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/bootstrap-markdown/js/markdown.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/bootstrap-markdown/js/to-markdown.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jquery-validation/jquery.validate.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/pnotify/pnotify.custom.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/fullcalendar/lib/moment.min.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/fullcalendar/fullcalendar.js"></script>
	<!-- Theme Base, Components and Settings -->
	<script src="<?php echo base_url("");?>assets/javascripts/theme.js"></script>
	<script src="<?php echo base_url("");?>themes/ckeditor/ckeditor.js"></script>

	<!-- Theme Custom -->
	<script src="<?php echo base_url("");?>assets/javascripts/theme.custom.js"></script>

	<!-- Theme Initialization Files -->
	<script src="<?php echo base_url("");?>assets/javascripts/theme.init.js"></script>


	<!-- Examples -->
	<?php if($this->uri->segment(1) == "dashboard"){?>
	<script src="<?php echo base_url("");?>assets/javascripts/dashboard/examples.dashboard.js"></script>
	<?php } ?>
	<script src="<?php echo base_url("");?>assets/vendor/select2/select2.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

	<!-- Theme Base, Components and Settings -->
	<script src="<?php echo base_url("");?>assets/javascripts/theme.js"></script>

	<!-- Theme Custom -->
	<script src="<?php echo base_url("");?>assets/javascripts/theme.custom.js"></script>

	<!-- Theme Initialization Files -->
	<script src="<?php echo base_url("");?>assets/javascripts/theme.init.js"></script>


	<!-- Examples -->
	<script src="<?php echo base_url("");?>assets/javascripts/tables/examples.datatables.default.js"></script>
	<script src="<?php echo base_url("");?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
	<script src="<?php echo base_url("");?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>
	<script src="<?php echo base_url("");?>assets/javascripts/forms/examples.validation.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>
	<?php if($this->uri->segment(1) != 'upgrade'){?>
	<script src="<?php echo base_url("");?>assets/javascripts/forms/examples.advanced.form.js"></script>
	<?php } ?>
	<script src="<?php echo base_url("");?>assets/javascripts/ui-elements/examples.lightbox.js"></script>
	<script src="<?php echo base_url("");?>assets/javascripts/forms/examples.wizard.js"></script>
	<script src="<?php echo base_url("");?>assets/javascripts/jquery.colorbox.js"></script>
	<script src="<?php echo base_url("");?>themes/js/main.js"></script>

</body>
</html>