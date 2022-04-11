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
						<p class="h5 mb-xs text-dark text-weight-semibold">Attn:</p>
						<address>
							<?php echo $cutomer->first_name;?> <?php echo $cutomer->last_name;?>
							<br/>
							<?php 
							// if($cutomer->company_name != "")
							// 	echo $cutomer->company_name.'<br/>';
							?>
							<?php 
							// if($cutomer->billing_address1 != '' || $cutomer->billing_suburb !='')
								echo $cutomer->address;
							?>
							Phone: <?php echo $cutomer->mobile;?>
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
						<td colspan="5">
							<?php echo $result->description;?>

						</td>
						
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
							<td ><?php echo number_format($row->price,2);?></td>
							<td ><?php echo number_format($row->amount,2);?></td>

						</tr>
						<?php } ?>

						<tr>
							<td colspan="6" style="text-align:right;"><strong>Regular Price:</strong> $<?php echo number_format($result->price,2);?> (<?php echo @$account_setting->currency_code;?>)</td>
						</tr>
						<?php if($result->discount > 0){?>
						<tr>
							<td colspan="6" style="text-align:right;"><strong>Discount : </strong><?php echo number_format($result->discount,2);?>  <?php if($result->is_flat > 0) echo '%'; else echo '('.@$account_setting->currency_code.')'; ?></td>
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
							<td colspan="6" style="text-align:right;"><strong><?php echo $result->is_included == 1 ? '':'Including'; ?> <?php echo @$account_setting->gst_title;?>: </strong>: </strong><?php echo number_format($result->gst,2);?>(<?php echo @$account_setting->currency_code;?>)</td>
						</tr>
						<?php }else{
							?>
							<tr>
								<td colspan="6" style="text-align:right;"><strong> <?php echo @$account_setting->gst_title;?>: </strong>:- </strong></td>
							</tr>
							<?php
						} ?>
						<tr>
							<td colspan="6" style="text-align:right;"><strong>Total Price: </strong><?php echo number_format($result->total_price,2);?>(<?php echo @$account_setting->currency_code;?>)</td>
						</tr>

						<?php if($result->finance_option == '1'){ ?>
						<tr  >
							
							<td colspan="6" style="text-align:right;" >
								<strong>Payment Terms: </strong><?php echo $result->payment_term; if($result->payment_term == '1') echo ' month'; else echo ' months';?> 
							</td>
						</tr>

						<tr  >
							<td colspan="6" style="text-align:right;" >
								<strong>Repayment/Month: </strong><?php echo number_format($result->total_price/$result->payment_term,2);?> (<?php echo @$account_setting->currency_code;?>)
							</td>
						</tr>
						
						<?php 
					}
					?>
					<?php if($result->chk_timeline == 0){?>
					<tr>
						<td colspan="6" ><strong>Timeline: </strong><?php echo $timeline->name;?></td>
					</tr>
					<?php } ?>
					<?php if($result->chk_test == 0){?>
					<tr>
						<td colspan="6">Project Testing: <?php echo $result->testing;?></td>
					</tr>
					<?php } ?>
					<?php if($result->chk_payment == 0){?>
					<tr>
						<td colspan="6"><strong>Payment Terms: </strong><?php echo $result->payment_terms;?></td>
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


	<script>
		window.print();
	</script>
</body>
</html>