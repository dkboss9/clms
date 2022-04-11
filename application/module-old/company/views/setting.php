

<?php if($this->session->flashdata("success_message")){?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
</div>
<?php
}
?>
<header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle=""></a>
        <a href="#" class="" data-panel-dismiss=""></a>
      </div>

      <h2 class="panel-title">Company Profile</h2>
    </header>
	<br>

<!-- start: page -->

<div class="row">
	<div class="col-md-4 col-lg-3">

		<section class="panel">
			<div class="panel-body">
				<div class="thumb-info mb-md">
					<div class="photo-upload-sec" id="post_img_profile"> 
						<?php if(file_exists('./assets/uploads/users/thumb/'.$company->thumbnail) && $company->thumbnail !=""){ ?>
						<img src="<?php echo SITE_URL.'assets/uploads/users/'.$company->picture;?>" style="width:100%" >
						<a href="javascript:void(0);" id="link_remove_image">x Remove</a>
						<?php }else{?>
						<img src="<?php echo base_url("");?>assets/images/!logged-user.jpg" alt="Joseph Doe" class="rounded img-responsive" data-lock-picture="<?php base_url("");?>assets/images/!logged-user.jpg" />
						<?php }?>
					</div>

					<input type="file" name="profile_image" id="profile_image" style="display: none;">
				</div>
				<a href="javascript:void(0);" id="link_upload_profile"><span class="fa fa fa-camera" >
				</span> Change Photo</a>
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
							<?php 
							if($this->session->userdata("clms_front_userid") == $company->userid){
								?>
								<li class="">Status : <span class="label" style="background-color:<?php echo $color;?>;color:white;"><?php echo $status;?></span></li>
								<li class="">Package : <?php echo @$this->companymodel->get_packageDetails($company->package_id)->name;?></li>
								<li class="">Join Date: <?php echo date("d/m/Y",$company->join_date);?></li>
								<li class="">Expiry Date : <?php echo date("d/m/Y",$company->expiry_date);?></li>
								<?php } ?>
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
					<li>
						<a   href="<?php echo base_url("company/profile/".$company->userid);?>" >Edit Company Info</a>
					</li>
					<li class="active">
						<a href="<?php echo base_url("company/setting/".$company->userid);?>" >Settings</a>
					</li>
				
					<li class="">
							<a href="<?php echo base_url("company/invoice_setting/".$company->userid);?>" >Invoice Setting</a>
						</li>

					<?php if(@$has_referal > 0) { ?>
					<li class="">
						<a href="<?php echo base_url("company/referral_setting/".$company->userid);?>" >Referral Setting</a>
					</li>
					<?php } ?>


				</ul>
				<div class="tab-content">

					<div id="edit" class="tab-pane active">

						<form id="form" method="post" action="<?php echo current_url();?>" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
							<fieldset class="mb-xl">

								<div class="form-group">
									<label class="col-md-3 control-label">Lead Reminder Date</label>
									<div class="col-md-1">
										<input type="text" name="lead_days" id="lead_days" value="<?php echo $company->lead_days;?>" class="form-control number required"   />
									</div>
									<div class="col-md-2">
										Days after
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Quote Expiry Date</label>
									<div class="col-md-1">
										<input type="text" name="quote_days" id="quote_days" value="<?php echo $company->quote_days;?>" class="form-control number required"   />
									</div>
									<div class="col-md-2">
										Days after
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Invoice Expiry Date</label>
									<div class="col-md-1">
										<input type="hidden" name="userid" value="<?php echo $company->userid;?>">
										<input type="text" name="duedatenumber" id="duedatenumber" value="<?php echo $company->duedatenumber;?>" class="form-control number required"   />
									</div>
									<div class="col-md-2">
										Days after
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Gst Setting</label>
									<div class="col-md-6">
										<input type="radio" name="gst_setting" id="not_gst" value="0" <?php if($company->gst == '0') echo 'checked="checked"';?>> Not Applicable &nbsp;&nbsp;
										<input type="radio" name="gst_setting" id="including_gst" value="1" <?php if($company->gst == '1') echo 'checked="checked"';?>> Including Gst &nbsp;&nbsp;
										<input type="radio" name="gst_setting" id="excluding_gst" value="2" <?php if($company->gst == '2') echo 'checked="checked"';?>> Excluding Gst &nbsp;&nbsp;

									</div>

								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Additional Field 1</label>
									<div class="col-md-3">
										<input type="text" name="project_test" value="<?php echo $company->project_test_label == ''?'Project Testing':$company->project_test_label;?>" class="form-control required">
									</div>
									<div class="col-md-3">
										<input type="checkbox" name="chk_field1" id="chk_field1" value="1" <?php if($company->chk_field1 == '1') echo 'checked="checked"';?>> Is Required?
									</div>
								</div>

								<div id="div_field1" <?php if($company->chk_field1 == '0') echo 'style="display:none;"';?>  >
									<div class="form-group">
										<label class="col-md-3 control-label">Field 1 Description</label>
										<div class="col-md-6">
											<textarea name="txt_field1" id="txt_field1" class="form-control"><?php echo $company->txt_field1 == ''?'All development and testing will be done under AusNep testing server and Customer can see and do user level testing from there. ':$company->txt_field1;?></textarea>
										</div>
									</div>
								</div>
								<br>
								<div class="form-group">
									<label class="col-md-3 control-label">Additional Field 2</label>
									<div class="col-md-3">
										<input type="text" name="payment_term" value="<?php echo $company->payment_term_label == ''?'Payment Terms':$company->payment_term_label;?>" class="form-control required">
									</div>
									<div class="col-md-3">
										<input type="checkbox" name="chk_field2" id="chk_field2" value="1" <?php if($company->chk_field2 == '1') echo 'checked="checked"';?>> Is Required?
									</div>
								</div>
								<div id="div_field2" <?php if($company->chk_field2 == '0') echo 'style="display:none;"';?> >
									<div class="form-group">
										<label class="col-md-3 control-label">Field 2 Description</label>
										<div class="col-md-6">
											<textarea name="txt_field2" id="txt_field2" class="form-control"><?php echo $company->txt_field2 == ''?'50% of total amount will require as an Advance and rest of amount after completion of project before uploading into live server. ':$company->txt_field2;?></textarea>
										</div>
									</div>
								</div>
								<br>
								<div class="form-group">
									<label class="col-md-3 control-label">Additional Field 3</label>
									<div class="col-md-3">
										<input type="text" name="license_no_label" value="<?php echo $company->license_no_label == ''?'License No':$company->license_no_label;?>" class="form-control required">
									</div>
									<div class="col-md-3">
										<input type="checkbox" name="chk_field3" id="chk_field2" value="1" <?php if($company->chk_field3 == '1') echo 'checked="checked"';?>> Is Required?
									</div>
								</div>



								<div class="form-group " >
									<label class="col-sm-3 control-label" for="w4-cc">
										Credit Card payment's Charge
									</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="cc_charge" id="cc_charge" value="<?php echo $company->credit_card_charge;?>" >
									</div>
									<div class="col-sm-1">
										%
									</div>
								</div>
								<br>

								<div class="form-group">
									<label class="col-sm-4 control-label" for="w4-cc">
										Payment option display in an invoice
									</label>
									<div class="col-sm-6">
									</div>
								</div>

								<div class="form-group " >
									<label class="col-sm-3 control-label" for="w4-cc">
									</label>
									<div class="col-sm-6">
										<input type="checkbox" id="chk_cc_number" name="chk_cc_number" value="1" <?php if($company->chk_credit_phone == 1) echo 'checked="checked"'; ?>>
										Credit Card Payment via Phone
									</div>
								</div>

								<div class="form-group credit_card_phone" <?php if($company->chk_credit_phone == 0) echo 'style="display:none;"';?>>
									<label class="col-sm-3 control-label" for="w4-cc">Enter Phone No</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="cc-number" id="cc-number" value="<?php echo $company->pay_via_phone;?>" placeholder="Enter Phone No.">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label" for="w4-cc">
									</label>
									<div class="col-sm-6">
										<input type="checkbox" id="chk_via-online" name="chk_via-online" value="1" <?php if($company->chk_credit_online == 1) echo 'checked="checked"'; ?>>
										Credit card payment via online
									</div>
								</div>

								<div class="form-group credit_card_online" <?php if($company->chk_credit_online == 0) echo 'style="display:none;"';?>>
									<label class="col-sm-3 control-label" for="cc-via-online">Credit card payment via online</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="cc-via-online" id="cc-via-online" value="<?php echo $company->pay_via_online;?>" placeholder="Enter your website url">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label" for="w4-cc">
									</label>
									<div class="col-sm-6">
										<input type="checkbox" id="chk_via-paypal" name="chk_via-paypal" value="1" <?php if($company->chk_credit_paypal == 1) echo 'checked="checked"'; ?>>
										Credit card payment via Paypal
									</div>
								</div>

								<div class="form-group credit_card_paypal" <?php if($company->chk_credit_paypal == 0) echo 'style="display:none;"';?>>
									<label class="col-sm-3 control-label" for="cc-via-paypal">Credit card payment via Paypal</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" name="cc-via-paypal" id="cc-via-paypal" value="<?php echo $company->cc_via_paypal;?>" placeholder="Enter your Paypal id">
									</div>
								</div>


								<div class="form-group">
									<label class="col-sm-3 control-label" for="w4-cc"></label>
									<div class="col-sm-6">
										<input type="checkbox" id="bank_transfer" name="chk_bank" value="1" <?php if($company->chk_bank > 0) echo 'checked="checked"';?> >
										Payment Via Bank
									</div>
								</div>

								<div class="form-group bank_transfer" <?php if($company->chk_bank == 0) echo 'style="display:none;"';?>>
									<label class="col-sm-3 control-label" for="eway_id">Bank Transfer</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="bank" id="bank" value="<?php echo $company->bank;?>" >
									</div>
								</div>

								<div class="form-group bank_transfer" <?php if($company->chk_bank == 0) echo 'style="display:none;"';?>>
									<label class="col-sm-3 control-label" for="eway_id">BSB</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="bsb" id="bsb" value="<?php echo $company->bsb;?>">
									</div>
								</div>

								<div class="form-group bank_transfer" <?php if($company->chk_bank == 0) echo 'style="display:none;"';?>>
									<label class="col-sm-3 control-label" for="eway_id">Account Number</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="account_no" id="account_no" value="<?php echo $company->account_no;?>" >
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label" for="w4-cc"></label>
									<div class="col-sm-6">
										<input type="checkbox" id="is_post" name="chk_post" value="1"  <?php if($company->chk_post > 0) echo 'checked="checked"';?>>
										Payment Via Cheque
									</div>
								</div>

								<div class="form-group div_post" <?php if($company->chk_post == 0) echo 'style="display:none;"';?>>
									<label class="col-sm-3 control-label" for="eway_id">Mail To</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="mail_to" id="mail_to" value="<?php echo $company->mail_to;?>" >
									</div>
								</div>

								<div class="form-group div_post" <?php if($company->chk_post == 0) echo 'style="display:none;"';?>>
									<label class="col-sm-3 control-label" for="eway_id">Mail to Address</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="mail_to_address" id="mail_to_address" value="<?php echo $company->mail_to_address;?>" >
									</div>
								</div>


								<div class="form-group">
									<label class="col-md-3 control-label">Display Payment option online</label>
									<div class="col-md-6">
										<input type="checkbox" id="chk_payment_online" name="chk_payment_online" value="1" <?php if($company->chk_payment_online > 0) echo 'checked="checked"';?> >
									</div>
								</div>
								<div id="div_payment_online" <?php if($company->chk_payment_online == 0) echo ' style="display:none"';?>>
									<div class="form-group">
										<label class="col-md-3 control-label">Payment Options</label>
										<div class="col-md-6">

										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label" for="w4-cc"></label>
										<div class="col-sm-6">
											<input type="checkbox" id="chk_eway" name="chk_eway" value="1" <?php if($company->chk_eway > 0) echo 'checked="checked"';?>>
											Payment Via Eway
										</div>
									</div>

									<div class="form-group div_eway"  <?php if($company->chk_eway == 0) echo 'style="display:none;"';?>>
										<label class="col-sm-3 control-label " for="eway_id">Eway Customer Id</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="eway_id" id="eway_id" value="<?php echo $company->eway_id;?>" >
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label" for="w4-cc"></label>
										<div class="col-sm-6">
											<input type="checkbox" id="chk_stripe" name="chk_stripe" value="1" <?php if($company->chk_stripe > 0) echo 'checked="checked"';?>>
											Payment Via Stripe
										</div>
									</div>

									<div class="form-group div_stripe"  <?php if($company->chk_stripe == 0) echo 'style="display:none;"';?>>
										<label class="col-sm-3 control-label " for="eway_id">Stripe public key</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="stripe_public_key" id="stripe_public_key" value="<?php echo $company->stripe_public_key;?>" >
										</div>
									</div>

									<div class="form-group div_stripe"  <?php if($company->chk_stripe == 0) echo 'style="display:none;"';?>>
										<label class="col-sm-3 control-label " for="eway_id">Stripe private key</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="stripe_private_key" id="stripe_private_key" value="<?php echo $company->stripe_private_key;?>" >
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label" for="w4-cc"></label>
										<div class="col-sm-6">
											<input type="checkbox" id="chk_paypal" name="chk_paypal"  value="1" <?php if($company->chk_paypal > 0) echo 'checked="checked"';?>>
											Payment Via Paypal
										</div>
									</div>

									<div class="form-group div_paypal" <?php if($company->chk_paypal == 0) echo 'style="display:none;"';?>>
										<label class="col-sm-3 control-label"  for="api_username">Paypal API_username</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="api_username" id="api_username" value="<?php echo $company->api_username;?>" >
										</div>
									</div>

									<div class="form-group div_paypal" <?php if($company->chk_paypal == 0) echo 'style="display:none;"';?>>
										<label class="col-sm-3 control-label"  for="api_signature">Paypal API_signature</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="api_signature" id="api_signature" value="<?php echo $company->api_signature;?>">
										</div>
									</div>

									<div class="form-group div_paypal" <?php if($company->chk_paypal == 0) echo 'style="display:none;"';?>>
										<label class="col-sm-3 control-label"  for="api_password">Paypal API_password</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="api_password" id="api_password" value="<?php echo $company->api_password;?>" >
										</div>
									</div>
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
		$("#chk_field1").click(function(){
			if($(this).prop("checked")){
				$("#div_field1").show();
			}else{
				$("#div_field1").hide();
			}
		});

		$("#chk_field2").click(function(){
			if($(this).prop("checked")){
				$("#div_field2").show();
			}else{
				$("#div_field2").hide();
			}
		});

		$("#credit_card").click(function(){
			if($(this).prop("checked")){
				$(".credit_card").show();
			}else{
				$(".credit_card").hide();
			}
		});

		$("#chk_cc_number").click(function(){
			if($(this).prop("checked")){
				$(".credit_card_phone").show();
				$("#cc-number").addClass("required");
			}else{
				$("#cc-number").removeClass("required");
				$(".credit_card_phone").hide();
			}
		});


		$("#chk_via-paypal").click(function(){
			if($(this).prop("checked")){
				$(".credit_card_paypal").show();
				$("#cc-via-paypal").addClass("required");
			}else{
				$("#cc-via-paypal").removeClass("required");
				$(".credit_card_paypal").hide();
			}
		});

		$("#chk_via-online").click(function(){ 
			if($(this).prop("checked")){ 
				$(".credit_card_online").show();
				$("#cc-via-online").addClass("required");
			}else{

				$("#cc-via-online").removeClass("required");
				$(".credit_card_online").hide();
			}
		});

		$("#bank_transfer").click(function(){ 
			if($(this).prop("checked")){ 
				$(".bank_transfer").show();
				$("#bsb").addClass("required");
				$("#bank").addClass("required");
				$("#account_no").addClass("required");
			}else{
				$(".bank_transfer").hide();
			}
		});

		$("#is_post").click(function(){
			if($(this).prop("checked")){ 
				$(".div_post").show();
				$("#mail_to").addClass("required");
				$("#mail_to_address").addClass("required");
			}else{
				$(".div_post").hide();
			}
		});

		$("#chk_payment_online").click(function(){
			if($(this).prop("checked")){
				$("#div_payment_online").show();
			}else{
				$("#div_payment_online").hide();
			}
		})

		$("#chk_eway").click(function(){
			if($(this).prop("checked")){ 
				$(".div_eway").show();
				$("#eway_id").addClass("required");
			}else{
				$(".div_eway").hide();
			}
		});

		$("#chk_stripe").click(function(){
			if($(this).prop("checked")){ 
				$(".div_stripe").show();
				$("#stripe_private_key").addClass("required");
				$("#stripe_public_key").addClass("required");
			}else{
				$(".div_stripe").hide();
			}
		});

		$("#chk_paypal").click(function(){
			if($(this).prop("checked")){ 
				$(".div_paypal").show();
				$("#api_username").addClass("required");
				$("#api_signature").addClass("required");
				$("#api_password").addClass("required");
			}else{
				$(".div_paypal").hide();
			}
		});
	});
</script>

<script type="text/javascript">

	$(document).ready(function(){
		$("#link_upload_profile").click(function () { 
			$("#profile_image").trigger('click');
		});

		$(document).on("change","#profile_image",function(){ 
			var file_data = $(this).prop('files')[0];
			var form_data = new FormData();
			form_data.append('file', file_data);

			$.ajax({
				url: '<?php echo base_url("");?>dashboard/upload_file/<?php echo $company->userid;?>', 
				dataType: 'text', 
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function (response) {
					img = JSON.parse(response);
					$('#post_img_profile').html('<img src="<?php echo SITE_URL."assets/uploads/users";?>/'+img.image_name+'" style="width:100%"><a href="javascript:void(0);" id="link_remove_image">x Remove</a>');
					//$('#link_upload').hide();
				},
				error: function (response) {
					$('#post_img_profile').html(response); 
				}
			});
		});
		$(document).on("click","#link_remove_image",function(){
			if(!confirm("Are you sure to remove this image?"))
				return false;
			$("#post_img_profile").html("");
			$('#link_upload_profile').show();

			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>index.php/dashboard/remove_image/<?php echo $company->userid;?>",
				data: "fname=1",
				success: function (msg) {
					
				}
			});
		});
	});


</script>