
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
					<?php
					if($this->session->userdata("clms_front_user_group") == 7){
						?>
						<hr class="dotted short">
						<a href="<?php echo base_url("upgrade/".$this->session->userdata("clms_front_userid"));?>" class="mb-xs mt-xs mr-xs btn btn-success">Upgrade Your Package</a>
						<?php } ?>
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
						<li class="">
							<a   href="<?php echo base_url("company/profile/".$company->userid);?>" >Edit Company Info</a>
						</li>
						<li >
							<a href="<?php echo base_url("company/setting/".$company->userid);?>" >Settings</a>
						</li>
						<li class="active">
							<a href="<?php echo base_url("company/tab_setting/".$company->userid);?>" >Tab Setting</a>
						</li>

						<?php if($has_referal > 0) { ?>
						<li class="">
							<a href="<?php echo base_url("company/referral_setting/".$company->userid);?>" >Referral Setting</a>
						</li>
						<?php } ?>


					</ul>
					<div class="tab-content">

						<div id="edit" class="tab-pane active">
							<table class="table table-bordered table-striped mb-none" id="datatable-editable">
								<thead>
									<tr>
										<th>Sn.</th>
										<th>Tab Names</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr class="gradeX tab_lead_name">
										<td class="sno">1</td>
										<td><?php echo $company->tab_lead_name != '' ? $company->tab_lead_name : 'Lead';?></td>
										<td class="actions">
											<a href="#" class="hidden on-editing save-row " rel="tab_lead_name"><i class="fa fa-save"></i></a>
											<a href="#" class="hidden on-editing cancel-row "><i class="fa fa-times"></i></a>
											<a href="#" class="on-default edit-row "><i class="fa fa-pencil"></i></a>
										</td>
									</tr>

									<tr class="gradeX tab_customer_name">
										<td class="sno">2</td>
										<td><?php echo $company->tab_customer_name != '' ? $company->tab_customer_name : 'Customer';?></td>
										<td class="actions">
											<a href="#" class="hidden on-editing save-row " rel="tab_customer_name"><i class="fa fa-save"></i></a>
											<a href="#" class="hidden on-editing cancel-row "><i class="fa fa-times"></i></a>
											<a href="#" class="on-default edit-row "><i class="fa fa-pencil"></i></a>
										</td>
									</tr>

									<tr class="gradeX tab_quote_name">
										<td class="sno">3</td>
										<td><?php echo $company->tab_quote_name != '' ? $company->tab_quote_name : 'Quote';?></td>
										<td class="actions">
											<a href="#" class="hidden on-editing save-row " rel="tab_quote_name"><i class="fa fa-save"></i></a>
											<a href="#" class="hidden on-editing cancel-row "><i class="fa fa-times"></i></a>
											<a href="#" class="on-default edit-row "><i class="fa fa-pencil"></i></a>
										</td>
									</tr>

									<tr class="gradeX tab_job_name">
										<td class="sno">4</td>
										<td><?php echo $company->tab_job_name != '' ? $company->tab_job_name : 'Job';?></td>
										<td class="actions">
											<a href="#" class="hidden on-editing save-row " rel="tab_job_name"><i class="fa fa-save"></i></a>
											<a href="#" class="hidden on-editing cancel-row "><i class="fa fa-times"></i></a>
											<a href="#" class="on-default edit-row "><i class="fa fa-pencil"></i></a>
										</td>
									</tr>

									<tr class="gradeX tab_installer_name">
										<td class="sno">5</td>
										<td><?php echo $company->tab_installer_name != '' ? $company->tab_installer_name : 'Installer';?></td>
										<td class="actions">
											<a href="#" class="hidden on-editing save-row " rel="tab_installer_name"><i class="fa fa-save"></i></a>
											<a href="#" class="hidden on-editing cancel-row "><i class="fa fa-times"></i></a>
											<a href="#" class="on-default edit-row "><i class="fa fa-pencil"></i></a>
										</td>
									</tr>

									<tr class="gradeX tab_support_name">
										<td class="sno">6</td>
										<td><?php echo $company->tab_support_name != '' ? $company->tab_support_name : 'Support';?></td>
										<td class="actions">
											<a href="#" class="hidden on-editing save-row " rel="tab_support_name"><i class="fa fa-save"></i></a>
											<a href="#" class="hidden on-editing cancel-row "><i class="fa fa-times"></i></a>
											<a href="#" class="on-default edit-row "><i class="fa fa-pencil"></i></a>
										</td>
									</tr>

									<tr class="gradeX tab_invoice_name">
										<td class="sno">7</td>
										<td><?php echo $company->tab_invoice_name != '' ? $company->tab_invoice_name : 'Invoice';?></td>
										<td class="actions">
											<a href="#" class="hidden on-editing save-row " rel="tab_invoice_name"><i class="fa fa-save"></i></a>
											<a href="#" class="hidden on-editing cancel-row "><i class="fa fa-times"></i></a>
											<a href="#" class="on-default edit-row "><i class="fa fa-pencil"></i></a>
										</td>
									</tr>

								</tbody>
							</table>
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
		$(".save-row").click(function(){
			var tab = $(this).attr("rel");
			var value = $("."+tab).find("input").val();
			$.ajax({
				url: '<?php echo base_url() ?>company/save_tabname',
				type: "POST",
				data: "tab_name=" + tab + "&tab_value="+value,
				success: function(data) { 
					
				}        
			});
		});
		$(".link_finish").click(function(){
			$("#form").submit();
		});
		$("#bill_country").change(function(){
			var country = $(this).val();
			$.ajax({
				url: '<?php echo base_url() ?>company/get_state',
				type: "POST",
				data: "country=" + country,
				success: function(data) { 
					if(data != ""){
						$("#bill_state").html(data);
					}
				}        
			});
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