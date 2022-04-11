

<?php if($this->session->flashdata("success_message")){?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
</div>
<?php
}
?>
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
					<li >
						<a href="<?php echo base_url("company/setting/".$company->userid);?>" >Settings</a>
					</li>
					<li class="">
						<a href="<?php echo base_url("company/tab_setting/".$company->userid);?>" >Tab Setting</a>
					</li>

					<?php if($has_referal > 0) { ?>
					<li class="active">
						<a href="<?php echo base_url("company/referral_setting/".$company->userid);?>" >Referral Setting</a>
					</li>
					<?php } ?>


				</ul>
				<div class="tab-content">

					<div id="edit" class="tab-pane active">

						<form id="form" method="post" action="<?php echo current_url();?>" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
							<fieldset class="mb-xl">

								<div class="form-group">
									<label class="col-md-3 control-label">Enable Todo Email:</label>
									<div class="col-md-2">
										<input type="radio" name="to_do_email"  value="1" <?php if($company->to_do_email == '1') echo 'checked="checked"';?>>Yes &nbsp;&nbsp;
										<input type="radio" name="to_do_email"  value="0" <?php if($company->to_do_email == '0') echo 'checked="checked"';?>> No &nbsp;&nbsp;
									</div>

								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Copy of Todo list of employer to Company :</label>
									<div class="col-md-2">
										<input type="radio" name="to_do_email_referral"  value="1" <?php if($company->to_do_email_referral == '1') echo 'checked="checked"';?>>Yes &nbsp;&nbsp;
										<input type="radio" name="to_do_email_referral" value="0" <?php if($company->to_do_email_referral == '0') echo 'checked="checked"';?>> No &nbsp;&nbsp;
									</div>

								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Enable Referral</label>
									<div class="col-md-2">
										<input type="radio" name="enable_referral" id="referral_yes" value="1" <?php if($company->enable_referral == '1') echo 'checked="checked"';?>>Yes &nbsp;&nbsp;
										<input type="radio" name="enable_referral" id="referral_no" value="0" <?php if($company->enable_referral == '0') echo 'checked="checked"';?>> No &nbsp;&nbsp;
									</div>

								</div>
								<div id="div_referred_customer" <?php if($company->enable_referral == '0') echo 'style="display: none;"';?>>
									<div class="form-group "  >
										<label class="col-md-3 control-label">Company Assigned Rate: </label>
										<div class="col-md-2">
											<input type="text" class="form-control number" name="referral_company_asign_rate" id="referral_company_asign_rate" value="<?php echo $company->referral_company_asign_rate;?>" >
										</div>
										<div class="col-sm-2">
										<input type="checkbox" name="is_referral_company_asign_rate_percentage" value="1" <?php if($company->is_referral_company_asign_rate_percentage == 1) echo 'checked="checked"';?> > Is percentage
									</div>
									</div>
									<div class="form-group "  >
										<label class="col-md-3 control-label">Self Assigned Rate: </label>
										<div class="col-md-2">
											<input type="text" class="form-control number" name="referral_self_asign_rate" id="referral_self_asign_rate" value="<?php echo $company->referral_self_asign_rate;?>" >
										</div>
										<div class="col-sm-2">
										<input type="checkbox" name="is_referral_self_asign_rate_percentage" value="1" <?php if($company->is_referral_self_asign_rate_percentage == 1) echo 'checked="checked"';?> > Is percentage
									</div>
									</div>
									<div class="form-group "  >
										<label class="col-md-3 control-label">Apply Discount to Referred Customer</label>
										<div class="col-md-6">
											<input type="radio" name="enable_discount_referred_customer" id="referred_customer_yes" value="1" <?php if($company->enable_discount_referred_customer == '1') echo 'checked="checked"';?>>Yes &nbsp;&nbsp;
											<input type="radio" name="enable_discount_referred_customer" id="referred_customer_no" value="0" <?php if($company->enable_discount_referred_customer == '0') echo 'checked="checked"';?>> No &nbsp;&nbsp;
										</div>
									</div>
								</div>

								<div class="form-group " id="div_discount" <?php if($company->enable_discount_referred_customer == '0' || $company->enable_referral == '0') echo 'style="display: none;"';?>>
									<label class="col-sm-3 control-label" for="w4-cc">
										Discount
									</label>
									<div class="col-sm-2">
										<input type="text" class="form-control number" name="referred_discount" id="referred_discount" value="<?php echo $company->referred_discount;?>" >
									</div>
									<div class="col-sm-2">
										<input type="checkbox" name="is_referred_percentage" value="1" <?php if($company->is_referred_percentage == 1) echo 'checked="checked"';?> > Is percentage
									</div>
								</div>
								<br>
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
	$("#referral_yes").click(function(){ 
		$("#div_referred_customer").show();
		if($("#referred_customer_yes").prop("checked"))
			$("#div_discount").show();
	});
	$("#referral_no").click(function(){
		$("#div_referred_customer").hide();
		$("#div_discount").hide();
	});
	$("#referred_customer_yes").click(function(){
		$("#div_discount").show();
	});

	$("#referred_customer_no").click(function(){
		$("#div_discount").hide();
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