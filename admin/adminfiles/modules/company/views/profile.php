

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
						<?php if(file_exists('../assets/uploads/users/thumb/'.$company->thumbnail) && $company->thumbnail !=""){ ?>
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
							if($this->session->userdata("clms_userid") == $company->userid){
								?>
								<li class="">Status : <span class="label" style="background-color:<?php echo $color;?>;color:white;"><?php echo $status;?></span></li>
								<li class="">Package : <?php echo @$this->companymodel->get_packageDetails($company->package_id)->name;?></li>
								<li class="">Join Date: <?php echo date("d/m/Y",$company->join_date);?></li>
								<li class="">Expiry Date : <?php echo date("d/m/Y",$company->expiry_date);?></li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<?php 
					$date_after_month = $next_month = date('Y-m-d', strtotime("+1 months", strtotime("NOW"))); 
					if($this->session->userdata("usergroup") == 7 && $this->session->userdata("clms_userid") == $company_id){
						?>
						<hr class="dotted short">
						<a href="<?php echo base_url("upgrade/".$this->session->userdata("clms_userid")."?type=upgrade");?>" class="mb-xs mt-xs mr-xs btn btn-success">Upgrade Your Package</a>
						<?php if($date_after_month > date("Y-m-d",$company->expiry_date) ){ ?>
							<hr class="dotted short">
							<a href="<?php echo base_url("upgrade/".$this->session->userdata("clms_userid")."?type=renew");?>" class="mb-xs mt-xs mr-xs btn btn-success">Renew Your Package</a>
						<?php }} ?>
						<hr class="dotted short">

						<h6 class="text-muted">About</h6>
						<p><?php echo $company->description;?></p>

						<hr class="dotted short">

						<a href="<?php echo base_url("company/qr_code/".$company->uuid);?>">Download QR Code</a>

					</div>
				</section>




			</div>
			<div class="col-md-8 col-lg-9">

				<div class="tabs tabs-warning">
					<ul class="nav nav-tabs">
						<li class="active">
							<a   href="<?php echo base_url("company/profile/".$company->userid);?>" >Edit Company Info</a>
						</li>
						<li >
							<a href="<?php echo base_url("company/setting/".$company->userid);?>" >Settings</a>
						</li>
						<li >
							<a href="<?php echo base_url("company/opening_hours/".$company->userid);?>" >Opening Hours</a>
						</li>
						<li class="">
							<a href="<?php echo base_url("company/invoice_setting/".$company->userid);?>" >Invoice Setting</a>
						</li>
					
						<?php if($has_referal > 0) { ?>
						<li class="">
							<a href="<?php echo base_url("company/referral_setting/".$company->userid);?>" >Referral Setting</a>
						</li>
						<?php } ?>


					</ul>
					<div class="tab-content">

						<div id="edit" class="tab-pane active">

							<form id="form" method="post" action="<?php echo current_url();?>" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
								<h4 class="mb-xlg">Account Info</h4>
								<fieldset>
									<div class="form-group">
										<label class="col-md-2 control-label" for="fname">First Name</label>
										<div class="col-md-3">
											<input type="text" name="fname" id="fname" value="<?php echo $company->first_name;?>" class="form-control" required  />
											<input type="hidden" name="role" id="role" value="3">
											<input type="hidden" name="userid" value="<?php echo $company->userid;?>">
										</div>
										<label class="col-md-3 control-label" for="lname">Last Name</label>
										<div class="col-md-3">
											<input type="text" name="lname" id="lname" value="<?php echo $company->last_name;?>" class="form-control" required />
										</div>
									</div>

									<?php 
									//print_r($this->session->userdata("clms_userid"));
									// if($this->session->userdata("clms_userid") != $company_id){
										?>

									<div class="form-group">
										<label class="col-md-2 control-label">Email</label>
										<div class="col-md-3">
											<input type="email" name="email" id="email" value="<?php echo $company->email;?>" class="form-control" required readonly=""/>
											<?php if(form_error("email")) echo form_error("email");?>
										</div>
										<label class="col-md-3 control-label">Password</label>
											<div class="col-md-3">
												<input type="password" name="password" id="password" class="form-control"  />
											</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Username</label>
										<div class="col-md-3">
											<input type="text" name="username" id="username" value="<?php echo $company->user_name;?>" class="form-control" required/>
											<p class="div_error"></p>
										</div>
									</div>

									<?php //} ?>

									<!-- <div class="form-group">
									
										<label class="col-md-2 control-label" for="description">Description</label>
										<div class="col-md-9">
											<textarea name="description"  class="form-control" id="description"  ><?php echo $company->description;?></textarea>
										</div>
									</div> -->
										
									</fieldset>
									<hr class="dotted tall">
									<h4 class="mb-xlg">Profile Info</h4>
									<fieldset>
										<div class="form-group">
											<label class="col-md-2 control-label">Company Name</label>
											<div class="col-md-3">
												<input type="text" name="company" id="company" value="<?php if($company->company_name != "0") echo $company->company_name;?>" class="form-control" required />
											</div>
											<label class="col-md-3 control-label">Quote Email</label>
											<div class="col-md-3">
												<input type="text" name="quote_email" id="quote_email" value="<?php if($company->quote_email != '') echo $company->quote_email; else echo $company->email;?>" class="form-control" required  />
											</div>
										</div>

								

										<div class="form-group">
											<label class="col-md-2 control-label">Order Email</label>
											<div class="col-md-3">
												<input type="text" name="order_email" id="order_email" value="<?php if($company->order_email != '') echo $company->order_email; else echo $company->email;?>" class="form-control" required  />
											</div>
											<label class="col-md-3 control-label">Account Email</label>
											<div class="col-md-3">
												<input type="text" name="account_email" id="account_email" value="<?php if($company->account_email != '') echo $company->account_email; else echo $company->email;?>" class="form-control" required  />
											</div>
										</div>

									

										<div class="form-group">
											<label class="col-md-2 control-label">Address 1</label>
											<div class="col-md-3">
												<input type="text" name="address1" id="address1" value="<?php echo $company->address;?>" class="form-control"  required/>
											</div>
											<label class="col-md-3 control-label">Address 2</label>
											<div class="col-md-3">
												<input type="text" name="address2" id="address2" value="<?php echo $company->address2;?>" class="form-control"  />
											</div>
										</div>

									

										
										<div class="form-group">
											<label class="col-md-2 control-label">Phone</label>
											<div class="col-md-3">
												<input type="text" name="phone" id="phone" value="<?php echo $company->phone;?>" class="form-control" required />
											</div>
											<label class="col-md-3 control-label">ABN</label>
											<div class="col-md-3">
												<input type="text" name="abn" id="abn" value="<?php echo $company->abn;?>" class="form-control"  />
											</div>
										
										</div>

									

										<div class="form-group" <?php if($company->chk_field3 == 0) echo 'style="display:none"';?> >
											<label class="col-md-2 control-label"><?php echo $company->license_no_label == ''?'License No':$company->license_no_label; ?></label>
											<div class="col-md-3">
												<input type="text" name="license_no" id="license_no" value="<?php echo $company->license_no;?>" class="form-control"  />
											</div>
											
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label">Post Code</label>
											<div class="col-md-3">
												<input type="text" name="postcode" id="postcode" value="<?php echo $company->postcode;?>" class="form-control"  />
											</div>
											<label class="col-md-3 control-label"></label>
											<div class="col-md-3">
												<input type="checkbox" name="display_abn" value="1" <?php if($company->display_abn == '1') echo 'checked=""';?>> display in invoice and order
											</div>
										</div>
										<?php
										$states = $this->companymodel->getstates($company->country);
										?>
										<div class="form-group">
											<label class="col-md-2 control-label " for="bill_country">Country</label>
											<div class="col-md-3">
												<select name="bill_country" id="bill_country" data-plugin-selectTwo class="form-control" required>
													<option value="">Select</option>
													<?php 
													foreach ($countries as $row) {
														?>
														<option <?php if($row->country_id == $company->country) echo 'selected="selected"';?> value="<?php echo $row->country_id;?>"><?php echo $row->country_name;?></option>
														<?php
													}
													?>
												</select>
											</div>
											<label class="col-md-3 control-label" for="bill_state">State</label>
											<div class="col-md-3">
												<div class="state_aus" <?php echo $company->country != 13 ? 'style="display:none;"':'';?>>
													<select name="bill_state" id="bill_state" data-plugin-selectTwo class="form-control" >
														<option value="">Select</option>
														<?php 
														foreach ($states as $row) {
															?>
															<option <?php if($row->state_name == $company->state) echo 'selected="selected"';?> value="<?php echo $row->state_name;?>"><?php echo $row->state_name;?></option>
															<?php
														}
														?>
													</select>
												</div>

												<div class="state_nep" <?php echo $company->country == 13 ? 'style="display:none;"':'';?>>
													<input type="text" name="txt_bill_state" id="txt_bill_state" class="form-control" value="<?php echo $company->state;?>">
												</div>
											</div>
										
										</div>

									

										<div class="form-group">
											<label class="col-md-2 control-label" for="cart_image">Logo</label>
											<div class="col-md-3">
												<?php if($company->thumbnail != "" && file_exists("../assets/uploads/users/thumb/".$company->thumbnail)) echo '<img src="'.SITE_URL."assets/uploads/users/thumb/".$company->thumbnail.'" width="50" height="50">';?>
											</div>
											<label class="col-md-3 control-label">Replace Logo</label>
											<div class="col-md-3">
												<input type="file" name="logo" id="logo"  class="form-control" />
											</div>
										</div>
									
									</fieldset>

									<hr class="dotted tall">
									<h4 class="mb-xlg" >Check-In Email  <a href="javascript:void(0);" style="float: right;" id="link_more_contact" class="btn btn-primary list-btn"> Add more contacts</a></h4>

									<fieldset>
									

									<?php foreach($checked_inemails as $email){?>
										<div class="form-group">
										<label class="col-md-2 control-label" for="mobile_number">Name</label>
										<div class="col-md-2">
											<input type="text" name="email_name[]" value="<?php echo $email->name;?>"  class="form-control" id="email_name" required>
										</div>
										<label class="col-md-1 control-label" for="email">Email</label>
										<div class="col-md-2">
											<input type="email" name="standup_email[]" value="<?php echo $email->email;?>"  class="form-control" id="standup_email" required>
										</div>
										<label class="col-md-1 control-label" for="Mobile">Mobile</label>
										<div class="col-md-2">
											<input type="mobile" name="standup_mobile[]" value="<?php echo $email->mobile;?>"  class="form-control" id="standup_mobile" required>
										</div>
										<div class="col-md-1">
										<a href="javascript:void(0);" class="link_contact_remove btn btn-danger list-btn"  ><span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a>
										</div>
										</div>
									<?php } ?>

									<div id="div_more_contact">

									</div>
									</fieldset>

									<div class="panel-footer">
										<div class="row">
											<div class="col-md-9 col-md-offset-3">
												<input type="submit" class="btn btn-primary" name="submit" id="btn-submit" value="Submit">
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
		var row_len = 0
    $("#link_more_contact").click(function(){
      var content = '<div id="row_'+row_len+'">'+
      '<div class="form-group" >'+
      '<label class="col-md-2 control-label" for="mobile_number">Name</label>'+
      '<div class="col-md-2">'+
      '<input type="text" name="email_name[]" id="email_name'+row_len+'" value=""  class="form-control" required>'+
      '</div>'+
      '<label class="col-md-1 control-label" for="email">Email</label>'+
      '<div class="col-md-2">'+
      '<input type="email" name="standup_email[]" id="standup_email'+row_len+'" value=""  class="form-control"  required>'+
      '</div>'+
	  '<label class="col-md-1 control-label" for="Mobile">Mobile</label>'+
	  '<div class="col-md-2">'+
			'<input type="mobile" name="standup_mobile[]" value=""  class="form-control" id="standup_mobile'+row_len+'" required>'+
	   '</div>'+
      '<div class="col-md-1"><a href="javascript:void(0);" class="link_contact_remove btn btn-danger list-btn" rel="'+row_len+'" ><span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a></div>'+
      '</div>'+
      '<div>';
      row_len = row_len +1;
      $("#div_more_contact").append(content);
    });

    $(document).on("click",".link_contact_remove",function(){
    //   var id = $(this).prop("rel"); 
    //   $("#row_"+id).remove();
	$(this).parent().parent().remove();
    });
		$(".link_finish").click(function(){
			$("#form").submit();
		});
		$("#bill_country").change(function(){
			var country = $(this).val();
			if(country == 13){
				$(".state_aus").show();
				$(".state_nep").hide();
				$.ajax({
					url: '<?php echo base_url() ?>company/get_state_new',
					type: "POST",
					data: "country=" + country,
					success: function(data) { 
					if(data != ""){
						$("#bill_state").html(data);
					}
					}        
				});
			}else{
				$(".state_aus").hide();
				$(".state_nep").show();
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
				url: '<?php echo base_url("");?>company/upload_file/<?php echo $company->userid;?>', 
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
				url: "<?php echo base_url();?>/company/remove_image/<?php echo $company->userid;?>",
				data: "fname=1",
				success: function (msg) {
					
				}
			});
		});

		$("#username").change(function(){
			var username = $(this).val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>/company/check_username/<?php echo $company->userid;?>",
				data: "username="+username,
				success: function (msg) {
					if(msg > 0){
						$(".div_error").html("This username is already exist.");
						$("#btn-submit").attr("disabled",true);
					}else{
						$(".div_error").html("");
						$("#btn-submit").attr("disabled",false);
					}
				}
			});
		});
	});


</script>