

<!-- start: page -->

<div class="row">
	<div class="col-md-4 col-lg-3">

		<section class="panel">
			<div class="panel-body">
				<div class="thumb-info mb-md">
					<?php if(file_exists('../assets/uploads/users/'.$company->picture) && $company->picture !=""){ ?>
					<img src="<?php echo SITE_URL.'assets/uploads/users/'.$company->picture;?>" class="rounded img-responsive" >
					<?php }else{?>
					<img src="<?php echo base_url("");?>assets/images/!logged-user.jpg" alt="Joseph Doe" class="rounded img-responsive" data-lock-picture="<?php base_url("");?>assets/images/!logged-user.jpg" />
					<?php }?>
					
				</div>

				<?php
				if($company->status == 1){
					$status = "Active";
					$color = "green";
				}
				else{
					$status = "Not Active";
					$color = "Red";
				}
				?>
				<div class="widget-toggle-expand mb-md">
					
					<div class="widget-content-expanded">
						<ul class="simple-todo-list">
							<?php if($company->company_name != '0' && $company->company_name != '') { ?>
							<li class="">Company Name : <?php echo $company->company_name;?></li>
							<?php } ?>
							<li class="">Name : <?php echo $company->first_name.' '.$company->last_name;?></li>
							<li class="">Status : <span class="label" style="background-color:<?php echo $color;?>;color:white;"><?php echo $status;?></span></li>
							<li class="">Join Date: <?php echo date("d/m/Y",$company->join_date);?></li>
							<li class="">Expiry Date : <?php echo date("d/m/Y",$company->expiry_date);?></li>
						</ul>
					</div>
				</div>


				<hr class="dotted short">

				<h6 class="text-muted">About</h6>
				<p><?php echo $company->description;?></p>
				
				<hr class="dotted short">

			</div>
		</section>


		

	</div>
	<div class="col-md-8 col-lg-9">

		<div class="tabs tabs-warning">
			<ul class="nav nav-tabs">
				<li >
					<a   href="<?php echo base_url("company/profile");?>" >Edit Company Info</a>
				</li>
				<li >
					<a href="<?php echo base_url("company/setting");?>" >Settings</a>
				</li>
				<li class="active">
					<a href="<?php echo base_url("company/upgrade");?>" >Upgrade Your Company</a>
				</li>
			</ul>
			<div class="tab-content">
				
				<div id="edit" class="tab-pane active">

					<form id="form" method="post" action="<?php echo base_url("company/setting");?>" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
						<fieldset class="mb-xl">
							<h3>Current Package</h3>
							<div class="current_package" style="    border: 3px solid #cccccc;
							border-radius: 15px;
							margin-bottom: 20px;">
							<div class="form-group">
								<label class="col-md-3 control-label" for="fname">Package:</label>
								<div class="col-md-6 control-label" style="text-align:left;">
									<strong><?php echo $package->name;?></strong>

									<input type="hidden" name="txt_name" value="<?php echo $package->name;?>">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label"  for="lname">Order Term:</label>
								<div class="col-md-8 control-label" style="text-align:left;">
									<strong><?php echo $company->payment_term;?></strong> 
									<input type="hidden" name="txt_order_term" value="<?php echo $company->payment_term;?>">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Amount:</label>
								<div class="col-md-8 control-label" style="text-align:left;">
									<strong>AUD <?php echo $company->price;?></strong>
									<input type="hidden" name="txt_price" value="<?php echo $company->price;?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="api_password">Package</label>
							<div class="col-sm-6">
								<select name="package" id="package" class="form-control " required>
									<option value="">Select</option>
									<?php
									foreach ($packages as $row) {
										?>
										<option value="<?php echo $row->package_id;?>"><?php echo $row->name;?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label" for="api_password">Order Term</label>
							<div class="col-sm-6">
								<select name="order_term" id="order_term" class="form-control " required>
									<option value="">Select</option>
								</select>
							</div>
						</div>


						<div class="form-group">
							<label class="col-sm-3 control-label" for="api_password">Package Price</label>
							<div class="col-sm-6">
								<input type="hidden" name="txt_package_price" id="txt_package_price" value="">
								<span id="span_package_price" >-</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="api_password"><strong>Select Payment Type</strong></label>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label" for="api_password"></label>
							<?php 
							if($this->mylibrary->getSiteEmail(81) == 1){
								?>

								<div class="col-md-3">
									<input type="radio" name="paymethod" value="eway" id="ewaypayment" class="payment-radio-class" checked="checked" required  />
									<img src="<?php echo base_url("assets/images/");?>/payment-icon.jpg" style="width:80%" >
								</div>
								<?php
							}
							?>
							<?php 
							if($this->mylibrary->getSiteEmail(75) == 1){
								?>
								<div class="col-md-2 ">
									<input type="radio" name="paymethod"  class="payment-radio-class" value="bank" id="banktransfer" required />
									<img src="<?php echo base_url("assets/images/");?>/bank-transfer.gif">
								</div>
								<?php } ?>
								<?php 
								if($this->mylibrary->getSiteEmail(77) == 1){
									?>
									<div class="col-md-3 ">
										<input type="radio" name="paymethod"  class="payment-radio-class" value="paypal" id="paypal">
										<img src="<?php echo base_url("assets/images/");?>/paypal.png" width="80">
									</div>
									<?php } ?>
								</div>

								<?php 
								if($this->mylibrary->getSiteEmail(81) == 1){
									?>
									<div id="div_eway"  >
										<div class="form-group">
											<label class="col-md-3 control-label">Card Name *</label>
											<div class="col-md-6 ">
												<input type="text"  value="" id="card_name" name="card_name" placeholder="Enter Your Card Name" class="form-control required" >
											</div>

										</div>

										<div class="form-group">
											<label class="col-md-3 control-label">Card Number *</label>
											<div class="col-md-6 ">
												<input type="text"  value="" id="card_number" name="card_number" placeholder="Enter Your Card Number" class="form-control required" >
											</div>

										</div>

										<div class="form-group">
											<label class="col-md-3 control-label">Expiry Date *</label>
											<div class="col-md-3 ">
												<select name="expiry_month" class="form-control required" >
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
											<div class="col-md-3 ">
												<select name="expiry_year" class="form-control required" >
													<option value="">Year</option>
													<option value="16">2016</option>
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

										<div class="form-group">
											<label class="col-md-3 control-label">CVV*</label>
											<div class="col-md-6 ">
												<input type="text"  value="" id="ccv" name="ccv" placeholder="Enter CCV" class="form-control required" >
											</div>

										</div>


									</div>
									<?php } ?>

									<?php 
									if($this->mylibrary->getSiteEmail(75) == 1){
										?>
										<div class="icon-border" id="div_bank" style="display:none;">
											<div class="form-group">
												<label class="col-md-3 control-label"></label>
												<div class="col-md-9 ">
													AusNep Group Pty Ltd.<br/>BSB: 062 475 <br/>A/C No.: 1009 5913<br/>  Common Wealth Bank
												</div>

											</div>

										</div>
										<?php } ?>

										<div class="form-group">
										</div>

									</fieldset>
									<div class="panel-footer">
										<div class="row">
											<div class="col-md-9 col-md-offset-3">
												<input type="submit" class="btn btn-primary" value="Submit" name="submit">
												<button type="reset" class="btn btn-default">Reset</button>
											</div>
										</div>
									</div>

								</form>

							</div>

							<div id="overview" class="tab-pane ">
								<h4 class="mb-md">Update Status</h4>



								<h4 class="mb-xlg">Timeline</h4>


							</div>
						</div>
					</div>
				</div>


			</div>
			<!-- end: page -->
		</section>
	</div>


</section>

<script type="text/javascript">
	$(document).ready(function(){

		$('.payment-radio-class').click(function() { 
			if ($(this).val() == 'bank'){
				$('.bank-info').slideDown();
				$('#extrachargesinfo2').hide();
				$("#div_bank").show();
				$("#div_eway").hide();
			}

			if ($(this).val() == 'eway'){
				$('.bank-info').slideUp();
				$('#extrachargesinfo2').show();
				$("#div_bank").hide();
				$("#div_eway").show();
			}

			if ($(this).val() == 'paypal'){
				$("#div_bank").hide();  
				$("#div_eway").hide();    
			}
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){

		$("#package").change(function(){
			var package_id = $(this).val();
			if(package_id == "")
				return false;

			$.ajax({
				url: '<?php echo base_url() ?>company/getPackagePrice',
				type: "POST",
				data: "package_id=" + package_id,
				success: function(data) { 
					if(data != ""){
						$("#order_term").html(data);
					}
				}        
			});

		});

		$(document).on("change","#order_term",function(){
			var price =  $('option:selected', this).attr('price');
			var discountprice =  $('option:selected', this).attr('discountprice');
			if(price > discountprice)
				var price1 = discountprice;
			else
				var price1 = price;
			$("#span_package_price").html('AUD '+price1);
			$("#txt_package_price").val(price1);
		});


	});

</script>
