<html>
<head>
	<?php
	//$site_name = $this->generalsettingsmodel->getConfigData(20)->row();
	$site_title = $this->generalsettingsmodel->getConfigData(20)->row();
	$site_keyword = $this->generalsettingsmodel->getConfigData(44)->row();
	$site_desc = $this->generalsettingsmodel->getConfigData(45)->row();

	?>
	<title><?php echo $site_title->config_value; ?></title>
	<meta name="keywords" content="<?php echo $site_keyword->config_value; ?>" />
	<meta name="description" content="<?php echo $site_desc->config_value; ?>">
	<!-- Web Fonts  -->
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap/css/bootstrap.css" />

	<!-- Invoice Print Style -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/invoice-print.css" />
</head>
<body>
	<div class="invoice">
		<header class="clearfix">
			<div class="row">
				<div class="col-sm-6 mt-md">
					<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">Order</h2>
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
						<?php if(file_exists("../assets/uploads/users/thumb/".$company->thumbnail) && $company->thumbnail != ""){ ?>
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
						<?php echo $cutomer->first_name;?> <?php echo $cutomer->first_name;?>
							<br/>
							<?php echo $cutomer->address;?>
							<br/>
							Phone: <?php echo $cutomer->mobile;?>
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

		<!-- 	<div class="row">
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
						<td >Amount (<?php echo @$account_setting->currency_code;?>)</td>
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
						<?php
				if($result->discount > 0){
					?>
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
							<td colspan="6" style="text-align:right;"><strong><?php echo $result->is_included == 1 ? '':'Including'; ?> <?php echo @$account_setting->gst_title; ?> : </strong><?php echo number_format($result->gst,2);?>(<?php echo @$account_setting->currency_code;?>) </td>
						</tr>
						<?php }else{
							?>
							<tr>
								<td colspan="6" style="text-align:right;"><strong> <?php echo @$account_setting->gst_title; ?> : -</strong>(<?php echo @$account_setting->currency_code;?>) </td>
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


		<script>
			window.print();
		</script>
	</body>
	</html>