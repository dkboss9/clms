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
					$date_after_month = $next_month = date('Y-m-d', strtotime("+1 months", strtotime("NOW"))); 
					if($this->session->userdata("clms_front_user_group") == 7 && $company->userid == $company->company_id){
						?>
						<hr class="dotted short">
						<a href="<?php echo base_url("upgrade/".$this->session->userdata("clms_front_userid")."?type=upgrade");?>" class="mb-xs mt-xs mr-xs btn btn-success">Upgrade Your Package</a>
						<?php if($date_after_month > date("Y-m-d",$company->expiry_date) ){ ?>
							<hr class="dotted short">
							<a href="<?php echo base_url("upgrade/".$this->session->userdata("clms_front_userid")."?type=renew");?>" class="mb-xs mt-xs mr-xs btn btn-success">Renew Your Package</a>
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
						<li >
							<a   href="<?php echo base_url("company/profile/".$company->userid);?>" >Edit Company Info</a>
						</li>
						<li >
							<a href="<?php echo base_url("company/setting/".$company->userid);?>" >Settings</a>
						</li>
						<li class="active">
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
                <form class="form-horizontal form-bordered" id="form" action="<?php echo current_url();?>" method="post"
                    enctype='multipart/form-data'>
                    <h4 class="mb-xlg">Time Zone</h4>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="fname">Time Zone</label>
                        <div class="col-md-6">
                           <select name="time_zone" id="time_zone" class="form-control">
                           <option value="Asia/Kathmandu" <?php echo $company->time_zone == 'Asia/Kathmandu'? 'selected':'';?>>Asia/Kathmandu</option>
                           <option value="Australia/Sydney" <?php echo $company->time_zone == 'Australia/Sydney'? 'selected':'';?>>Australia/Sydney/Melbourne/Tasmania</option>
                           <option value="Australia/Perth" <?php echo $company->time_zone == 'Australia/Perth'? 'selected':'';?>>Australia/Perth</option>
                           <option value="Australia/Adelaide" <?php echo $company->time_zone == 'Australia/Adelaide'? 'selected':'';?>>Australia/Adelaide</option>
                           <option value="Australia/Darwin" <?php echo $company->time_zone == 'Australia/Darwin'? 'selected':'';?>>Australia/Darwin</option>
                           <option value="Australia/Brisbane" <?php echo $company->time_zone == 'Australia/Brisbane'? 'selected':'';?>>Australia/Brisbane</option>
                           </select>
                        </div>
                    </div>
                    <?php

                    $summary = explode(",",$company->summary_report);
                    ?>

                    <h4 class="mb-xlg"></h4>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="fname">Summery Report Setting</label>
                        <div class="col-md-2">
                          <input type="checkbox" name="summary_report[]" id="daily" value="daily" <?php echo in_array("daily", $summary) ? 'checked':'';?>> Daily
                        </div>
                        <div class="col-md-2">
                          <input type="checkbox" name="summary_report[]" id="weekly" value="weekly" <?php echo in_array("weekly", $summary) ? 'checked':'';?>> Weekly
                        </div>
                        <div class="col-md-2">
                          <input type="checkbox" name="summary_report[]" id="monthly" value="monthly" <?php echo in_array("monthly", $summary) ? 'checked':'';?>> Monthly
                        </div>
                    </div>

                    <h4 class="mb-xlg">Opening Hour</h4>

                    <div id="edit" class="tab-pane active">

                        <?php
      foreach($days as $day){
        $times = $this->companymodel->get_service_time($company_id,$day->day_id);
        if($times){
          $start = date('H:i',strtotime(@$times->service_start_time));
          $end =  date('H:i',strtotime(@$times->service_end_time));
        }
        ?>
                        <input type="hidden" name="day_id[]" value="<?php echo $day->day_id;?>">
                        <div class="form-group">
                            <label class="col-md-3 control-label"
                                for="productivity"><?php echo $day->day_name; ?></label>
                            <div class="col-md-3">
                                <select name="start_time[]" id="start_time<?php echo $day->day_id;?>"
                                    class="form-control">

                                    <?php  for ($i=0;$i<=23;$i++){
              for ($j=0;$j<=45;$j=$j+15)
              {
                $time_interval = $i.':'.str_pad($j, 2, '0', STR_PAD_LEFT);
                $time_interval = date('H:i',strtotime($time_interval));
                ?>
                                    <option value="<?php echo $time_interval;?>"
                                        <?php if(@$start == $time_interval) echo 'selected="selected"'; ?>>
                                        <?php echo $time_interval;?></option>
                                    <?php
              }
            }?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="end_time[]" id="end_time<?php echo $day->day_id;?>" class="form-control">

                                    <?php  for ($i=0;$i<=23;$i++){
              for ($j=0;$j<=45;$j=$j+15)
              {
                $time_interval = $i.':'.str_pad($j, 2, '0', STR_PAD_LEFT);
                $time_interval = date('H:i',strtotime($time_interval));
                ?>
                                    <option value="<?php echo $time_interval;?>"
                                        <?php if(@$end == $time_interval) echo 'selected="selected"'; ?>>
                                        <?php echo $time_interval;?></option>
                                    <?php
              }
            }?>
                                </select>
                            </div>
                            <label class="col-md-3 control-label" id="err_serivce<?php echo $day->day_id;?>"></label>
                        </div>
                        <?php } ?>

                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-9 col-md-offset-3">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                    <button type="reset" class="btn btn-default">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
    $(document).ready(function () {
        $(".save-row").click(function () {
            var tab = $(this).attr("rel");
            var value = $("." + tab).find("input").val();
            $.ajax({
                url: '<?php echo base_url() ?>company/save_tabname',
                type: "POST",
                data: "tab_name=" + tab + "&tab_value=" + value,
                success: function (data) {

                }
            });
        });
        $(".link_finish").click(function () {
            $("#form").submit();
        });
        $("#bill_country").change(function () {
            var country = $(this).val();
            $.ajax({
                url: '<?php echo base_url() ?>company/get_state',
                type: "POST",
                data: "country=" + country,
                success: function (data) {
                    if (data != "") {
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
	});


</script>