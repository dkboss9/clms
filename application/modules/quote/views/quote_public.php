
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
						<div class="pay-btn btn btn-success" id="ext-gen1026">
							<a  href="<?php echo base_url("order/approve_quote/".$result->quote_id);?>"  style="display:flex;width:100px;" role="button" hidefocus="on" unselectable="on" tabindex="0" target="_blank" id="button-1010"><span ><span  class="x-btn-button"><span >Approve</span><span role="img" id="button-1010-btnIconEl" class="x-btn-icon-el  " unselectable="on" style=""></span></span></span>
							</a></div>
							<div class="amount">
								<span><?php //echo number_format($result->due_amount,2);?> <span class="currency"><?php echo @$account_setting->currency_code;?></span></span>
								<span class="status due in-future"><strong>Due Date:</strong> <?php echo date("d/m/Y",strtotime("+".$company->duedatenumber." days", $result->added_date));?></span>

							</div>
						</div>



						<div class="download-file">
							<ul>
								<li><a href="<?php echo base_url("quote/download_quote/".$result->quote_id);?>">Download</a></li>
								<li><a href="<?php echo base_url("quote/print_report/".$result->quote_id);?>">Print</a></li>
							</ul>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>


				<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
				<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

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
						<section class="panel">
							<div class="row">
								<div class="col-sm-9 mt-md">
									<div class="panel-body">
										<div class="invoice">
											<header class="clearfix">
												<div class="row">
													<div class="col-sm-6 mt-md">
														<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">QUOTE</h2>
														<h4 class="h4 m-none text-dark text-weight-bold">#<?php echo $result->quote_number; ?></h4>
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
															<p class="h5 mb-xs text-dark text-weight-semibold">Attn:</p>
															<address>
																<?php echo $cutomer->customer_name;?>
																<br/>
																<?php 
																if($cutomer->company_name != "")
																	echo $cutomer->company_name.'<br/>';
																?>
																<?php 
																if($cutomer->billing_address1 != '' || $cutomer->billing_suburb !='')
																	echo $cutomer->billing_address1.', '.$cutomer->billing_suburb.'<br/>';
																?>
																Phone: <?php echo $cutomer->contact_number;?>
																<br/>
																<?php echo $cutomer->email;?>
															</address>
														</div>
													</div>
													<div class="col-md-6">
														<div class="bill-data text-right">
															<p class="mb-none">
																<span class="text-dark">Quote Date:</span>
																<span class="value"><?php echo date("d/m/Y",$result->added_date);?></span>
															</p>
															<p class="mb-none">
																<span class="text-dark">Quote expiry date :</span>
																<span class="value"><?php echo date("d/m/Y",$result->expiry_date);?></span>
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
															<tr >

																<td colspan="2"><strong>Descriptions: </strong></td>
																<td colspan="2"><strong>Quantity: </strong></td>
																<td ><strong>Price: (<?php echo @$account_setting->currency_code;?>)</strong></td>
																<td ><strong>Total: (<?php echo @$account_setting->currency_code;?>)</strong></td>

															</tr>
															<?php
															foreach ($quote_inverters as $row ) {
																?>
																<tr>
																	<td colspan="2">
																		<?php echo $row->descriptions;?></br>
																		<span style="font-size:10px;"><?php if($row->short_desc != "") echo '('.$row->short_desc.')'; ?></span>
																	</td>
																	<td colspan="2"><?php echo $row->quantity;?></td>
																	<td ><?php echo number_format($row->price, 2);?></td>
																	<td ><?php echo number_format($row->amount, 2);?></td>
																</tr>
																<?php } ?>

																<tr>
																	<td colspan="6" style="text-align:right;"><strong>Regular Price:</strong> <?php echo number_format($result->price, 2);?>(<?php echo @$account_setting->currency_code;?>)</td>
																</tr>
																<?php if($result->discount > 0){?>
																<tr>
																	<td colspan="6" style="text-align:right;"><strong>Discount : </strong><?php echo $result->is_flat > 0 ? $result->discount : number_format($result->discount,2); ?>(<?php echo @$account_setting->currency_code;?>)';?> <?php if($result->is_flat > 0) echo '%'; ?></td>
																</tr>
																<?php } ?>

																<?php
																if($result->is_included == 1){
																	$subtotal = $result->total_price - $result->gst;
																}else{
																	$subtotal = $result->total_price;
																}

																?>
																<tr>
																	<td colspan="6" style="text-align:right;"><strong>Sub Total : </strong><?php echo number_format($subtotal,2);?>(<?php echo @$account_setting->currency_code;?>)</td>
																</tr>
																<?php if($result->gst_applicable == 1){ ?>
																<tr>
																	<td colspan="6" style="text-align:right;"><strong><?php echo $result->is_included == 1 ? '':'Including'; ?> <?php echo @$account_setting->gst_title;?>: </strong><?php echo number_format($result->gst,2);?> (<?php echo @$account_setting->currency_code;?>)</td>
																</tr>
																<?php }else{
																	?>
																	<tr>
																		<td colspan="6" style="text-align:right;"><strong> <?php echo @$account_setting->gst_title;?>: </strong> - </td>
																	</tr>
																	<?php

																} ?>
																<tr>
																	<td colspan="6" style="text-align:right;"><strong>Total Price: </strong><?php echo number_format($result->total_price,2);?> (<?php echo @$account_setting->currency_code;?>)</td>
																</tr>

																<?php if($result->finance_option == '1'){ ?>
																<tr  >

																	<td colspan="6" style="text-align:right;" >
																		<strong>Payment Terms: </strong><?php echo $result->payment_term; if($result->payment_term == '1') echo ' month'; else echo ' months';?> 
																	</td>
																</tr>

																<tr  >
																	<td colspan="6" style="text-align:right;" >
																		<strong>Repayment/Month: </strong><?php echo $result->total_price/$result->payment_term;?> (<?php echo @$account_setting->currency_code;?>)
																	</td>
																</tr>

																<?php 
															}
															?>

															<?php if($result->chk_timeline == 0){?>
															<tr>
																<td colspan="6" ><strong>Timeline: </strong><?php echo @$timeline->name;?></td>
															</tr>
															<?php }  ?>
															<?php if($result->chk_test == 0){?>
															<tr>
																<td colspan="6"><?php echo $company->project_test_label == ''?'Project Testing':$company->project_test_label; ?> : <?php echo $result->testing;?></td>
															</tr>
															<?php } ?>
															<?php if($result->chk_payment == 0){?>
															<tr>
																<td colspan="6"><strong><?php echo $company->payment_term_label == ''?'Payment Terms':$company->payment_term_label; ?>: </strong><?php echo $result->payment_terms;?></td>
															</tr>
															<?php } ?>
															<?php if($result->note != ""){?>
															<tr>
																<td colspan="6" style="color:red;"><strong>Note: </strong><?php echo $result->note;?></td>
															</tr>
															<?php } ?>
															<tr>
																<td colspan="6" >
																	<strong>
																		Thank you for the opportunity to quote on the above project 
																	</strong>
																</td>
															</tr>
														</tbody>
													</table>
												</div>

											</div>
										</div>
									</div>
									<div class="col-sm-3 mt-md">
										<form name="form_comment" id="form_comment" method="post" action="<?php echo current_url();?>">
											<div class="table-responsive">
												<table class="table invoice-items">
													<thead>
														<tr>
															<td><strong>Add Comment: </strong></td>
														</tr>
													</thead>
													<tbody>
														<tr >

															<td>
																<textarea name="comment" class="form-control required"></textarea>
															</td>

														</tr>
														<tr >

															<td>
																<input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
															</td>

														</tr>
													</tbody>
												</table>

												<table class="table invoice-items">
													<thead>
														<tr>
															<td><strong>Comments(<?php echo count($comments);?>): </strong></td>
														</tr>
													</thead>
													<tbody>
														<?php 
														foreach ($comments as $row) {
															?>
															<tr >
																<td>
																	<?php if($row->from_id == $result->company_id){?>
																	<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown" style="background: #FFF;
																	border-radius: 50%;
																	box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.3);
																	display: inline-block;
																	height: 30px;
																	position: relative;
																	width: 30px;
																	color:#ffffff;

																	padding-top: 3px;
																	text-align: center;font-weight:bold; background:#0088cc">
																	A                    <span class="badge"></span>
																</a>
																<?php 
															}else{
																?>
																<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown" style="background: #FFF;
																border-radius: 50%;
																box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.3);
																display: inline-block;
																height: 30px;
																position: relative;
																width: 30px;
																color:#ffffff;

																padding-top: 3px;
																text-align: center;font-weight:bold; background:#47a447">
																C                   <span class="badge"></span>
															</a>
															<?php
														} 
														?>

														<?php echo $row->comment; ?>
													</td>

												</tr>
												<?php
											}?>


										</tbody>
									</table>
								</div>
							</form>
						</div>
					</div>

				</section>

			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#form_comment").validate();
		});
	</script>
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