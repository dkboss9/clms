

<?php if($this->session->flashdata("success_message")){?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?>
</div>
<?php
}
?>
<!-- start: page -->

<header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle=""></a>
        <a href="#" class="" data-panel-dismiss=""></a>
      </div>

      <h2 class="panel-title">Company Profile</h2>
    </header>
	<br>

<div class="row">
	<div class="col-md-4 col-lg-3">

		<section class="panel">
			<div class="panel-body">
				<div class="thumb-info mb-md">
					<div class="photo-upload-sec" id="post_img_profile">
						<?php if(file_exists('./assets/uploads/users/thumb/'.$company->thumbnail) && $company->thumbnail !=""){ ?>
						<img src="<?php echo SITE_URL.'assets/uploads/users/'.$company->picture;?>" style="width:100%">
						<a href="javascript:void(0);" id="link_remove_image">x Remove</a>
						<?php }else{?>
						<img src="<?php echo base_url("");?>assets/images/!logged-user.jpg" alt="Joseph Doe"
							class="rounded img-responsive" data-lock-picture="<?php base_url("");?>assets/images/!logged-user.jpg" />
						<?php }?>
					</div>

					<input type="file" name="profile_image" id="profile_image" style="display: none;">
				</div>
				<a href="javascript:void(0);" id="link_upload_profile"><span class="fa fa fa-camera">
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
							<li class="">Status : <span class="label"
									style="background-color:<?php echo $color;?>;color:white;"><?php echo $status;?></span></li>
							<li class="">Package : <?php echo @$this->companymodel->get_packageDetails($company->package_id)->name;?>
							</li>
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
					<a href="<?php echo base_url("company/profile/".$company->userid);?>">Edit Company Info</a>
				</li>
				<li>
					<a href="<?php echo base_url("company/setting/".$company->userid);?>">Settings</a>
				</li>
				<li class="active">
					<a href="<?php echo base_url("company/invoice_setting/".$company->userid);?>">Invoice Setting</a>
				</li>
			
				<?php if($has_referal > 0) { ?>
				<li class="">
					<a href="<?php echo base_url("company/referral_setting/".$company->userid);?>">Referral Setting</a>
				</li>
				<?php } ?>


			</ul>
			<div class="tab-content">

				<div id="edit" class="tab-pane active">
					<h3>Get paid on time by scheduling payment reminders for your customer:</h3>
					<form action="<?php echo current_url();?>" method="post">
						<div class="current_package" style="    border: 3px solid #cccccc;
    border-radius: 15px;
    margin-bottom: 20px; padding:20px;">
							<div class="form-group">


								<!-- <div class="col-md-3 ">
									<input type="checkbox" name="reminder[]" value="90-before"
										<?php if($this->companymodel->checkreminder("90-before",$company_id) == 1) echo 'checked="checked"';?>> 90 Days
									Before expiry
								</div>

								<div class="col-md-3 ">
									<input type="checkbox" name="reminder[]" value="30-before"
										<?php if($this->companymodel->checkreminder("30-before",$company_id) == 1) echo 'checked="checked"';?>> 30 Days
									Before expiry
								</div> -->


								<div class="col-md-3 ">
									<input type="checkbox" name="reminder[]" value="14-before"
										<?php if($this->companymodel->checkreminder("14-before",$company_id) == 1) echo 'checked="checked"';?>> 14 Days
									Before expiry
								</div>
								<div class="col-md-3 ">
									<input type="checkbox" name="reminder[]" value="7-before"
										<?php if($this->companymodel->checkreminder("7-before",$company_id) == 1) echo 'checked="checked"';?>> 7 Days
									Before expiry
								</div>
								<div class="col-md-3 ">
									<input type="checkbox" name="reminder[]" value="3-before"
										<?php if($this->companymodel->checkreminder("3-before",$company_id) == 1) echo 'checked="checked"';?>> 3 Days
									Before expiry
								</div>

								<div class="col-md-3 ">
									<input type="checkbox" name="reminder[]" value="2-before"
										<?php if($this->companymodel->checkreminder("2-before",$company_id) == 1) echo 'checked="checked"';?>> 2 Days
									Before expiry
								</div>

								<div class="col-md-3 ">
									<input type="checkbox" name="reminder[]" value="1-before"
										<?php if($this->companymodel->checkreminder("1-before",$company_id) == 1) echo 'checked="checked"';?>> 1 Days
									Before expiry
								</div>
								<div class="col-md-3 ">
									<input type="checkbox" name="reminder[]" value="0-before"
										<?php if($this->companymodel->checkreminder("0-before",$company_id) == 1) echo 'checked="checked"';?>> On due date
								</div>
								<div class="col-md-3 ">
									<input type="checkbox" name="reminder[]" value="1-after"
										<?php if($this->companymodel->checkreminder("1-after",$company_id) == 1) echo 'checked="checked"';?>> 1 Days
									After expiry
								</div>
								<div class="col-md-3 ">
									<input type="checkbox" name="reminder[]" value="2-after"
										<?php if($this->companymodel->checkreminder("2-after",$company_id) == 1) echo 'checked="checked"';?>> 2 Days
									After expiry
								</div>
								<div class="col-md-3 ">
									<input type="checkbox" name="reminder[]" value="7-after"
										<?php if($this->companymodel->checkreminder("7-after",$company_id) == 1) echo 'checked="checked"';?>> 7 Days
									After expiry
								</div>
								<div class="col-md-3 ">
									<input type="checkbox" name="reminder[]" value="14-after"
										<?php if($this->companymodel->checkreminder("14-after",$company_id) == 1) echo 'checked="checked"';?>> 14 Days
									After expiry
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12" style="text-align:right;">
									<input class="btn btn-primary" value="Submit" name="submit" type="submit">
								</div>
							</div>
						</div>
				</form>

				</div>

			
			</div>
		</div>
	</div>


</div>
<!-- end: page -->
</section>
</div>


</section>