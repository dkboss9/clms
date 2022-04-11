<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>

<script src="<?php echo base_url("");?>assets/vendor/chartist/chartist.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.categories.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.resize.js"></script>


<style>
	.activeClass {
		background-color: #86D1FD;
	}

	.top-icon li {
		list-style: none;
		display: inline-block;
		padding: 0% 3.3%;
	}

	.top-icon li a i {
		font-size: 36px;
	}

	.project-calender a i {
		font-size: 45px;
		display: block;
	}

	.project-calender a {
		color: green;
		text-align: center;
	}

	.event-calender a i {
		font-size: 45px;
		display: block;
	}

	.event-calender a {
		color: pink;
		text-align: center;
	}

	.task-calender a i {
		font-size: 45px;
		display: block;
	}

	.task-calender a {
		color: orange;
		text-align: center;
	}

	@media(max-width: 767px) {
		.top-icon li {
			padding: 0% 2.5%;
		}
	}
</style>


	<!-- start: page -->
	
	<?php if($this->session->flashdata("success_message")){?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<strong>Well done!</strong> <?php echo $this->session->flashdata("success_message") ?>
	</div>
	<?php
}
?>

<div class="row">
  <section class="panel">
  <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle=""></a>
        <a href="#" class="" data-panel-dismiss=""></a>
      </div>

      <h2 class="panel-title">Leads</h2>
    </header>
    <div class="panel-body">
      <div class="tabs tabs-warning">
       

			<div class="row">

				<div class="col-md-12">

					<div class="mb-md">
						<h2>
							<button id="addButton" data-toggle="tooltip" title="Add New Record" type="button"
								class="btn btn-primary"> Add <i class="fa fa-plus"></i> </button>

							<!-- Single button -->
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									More <span class="caret"></span> </button>
								<ul class="dropdown-menu" role="menu">
									<li><a onclick="cascade('delete');">Delete Marked</a></li>
									<li><a onclick="cascade('publish');">Mark as Published
										</a></li>
									<li><a onclick="cascade('unpublish');">Mark as Unpublished
										</a></li>
								</ul>
							</div>
						</h2>
						<div class="row form-search">
						<form method="get" action="<?php echo current_url();?>">

							<div class="col-md-2">
								<select class="form-control mb-md" data-plugin-selectTwo name="handle">
									<option value="">Lead By</option>
									<?php
                        foreach ($users as $user) {
                          ?>
									<option <?php if($search_handle == $user->id) echo 'selected="selected"';?>
										value="<?php echo $user->id;?>">
										<?php echo $user->first_name. ' '.$user->last_name;?></option>
									<?php
                        }
                        ?>
								</select>

							</div>
							<div  class="col-md-2">
								<select class="form-control mb-md" data-plugin-selectTwo name="country">
									<option value="">Country</option>
									<?php
                        foreach ($countries as $country) {
                         ?>
									<option
										<?php if($search_country == $country->country_name) echo 'selected="selected"';?>
										value="<?php echo $country->country_name;?>">
										<?php echo $country->country_name;?></option>
									<?php
                       }
                       ?>
								</select>

							</div>
							<div  class="col-md-2">
								<select class="form-control mb-md" data-plugin-selectTwo name="weightage">
									<option value="">Weightage</option>
									<?php 
                      foreach ($weightage as $wt) {
                        ?>
									<option
										<?php if($search_weightage == $wt->weightage_id) echo 'selected="selected"';?>
										value="<?php echo $wt->weightage_id;?>"><?php echo $wt->name;?></option>
									<?php
                      }
                      ?>
								</select>

							</div>
							<div  class="col-md-2">
								<select class="form-control mb-md" data-plugin-selectTwo name="status">
									<option value="">Status</option>
									<?php 
                      foreach ($status as $st) {
                        ?>
									<option <?php if($search_status == $st->status_id) echo 'selected="selected"';?>
										value="<?php echo $st->status_id;?>"><?php echo $st->status_name;?></option>
									<?php
                      }
                      ?>
								</select>

							</div>

							<div class="col-md-1">
								<input type="submit" name="search" value="search" class="btn btn-primary">

							</div>

						</form>
						</div>
					</div>
				</div>
			</div>
		
			<table class="table table-bordered table-striped mb-none" id="datatable-default">
				<thead>
					<tr>
						<th><input type="checkbox" name="all" id="checkall"></th>
						<th>Lead Id </th>
						<th>Client Name </th>
						<th>Mobile</th>
						<th>Sales Rep</th>
						<th>Reminder</th>
						<th>Added Date</th>
						<th>Status</th>
						<th>Source</th>
						<th>Email</th>
						<th>Country</th>
						<th>Lead By</th>
						<th>Status History</th>
						<th></th>
						<th class="sorting_disabled" aria-label="Actions">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php 

              foreach ($leads->result() as $lead) {
               $publish = ($lead->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
               ?>
					<tr class="gradeX">
						<td><input type="checkbox" class="checkone" value="<?php echo $lead->lead_id; ?>" /></td>
						<td><?php echo $lead->lead_id;?></td>
						<td><?php echo $lead->lead_name.' '.$lead->lead_lname;?></td>
						<td><?php echo $lead->phone_number;?></td>
						<td><?php echo $lead->first_name!=""? $lead->first_name.' '.$lead->last_name:"N/A";?></td>
						<td><?php echo date("d/m/Y",$lead->reminder_date);?></td>
						<td><?php echo date("d/m/Y",$lead->added_date);?></td>
						<td><span class="label"
								style="color:#fff;background: <?php echo $lead->status_color;?>"><?php echo $lead->status_name;?></span>
						</td>
						<td>
						<?php echo $lead->source_name;?>
						</td>
						<td><?php echo $lead->email;?></td>
						<td><?php echo $lead->country;?></td>
						<?php 
                $handler = $this->lmsmodel->getusers($lead->handle);
                ?>
						<td><?php echo @$handler->user_name;?></td>
						<td>
							<?php 
                  $updates = $this->lmsmodel->get_updates($lead->lead_id);
                  if(count($updates)>0){
                    ?>
							<a class="simple-ajax-popup-reminder btn-default"
								href="<?php echo base_url("lms/detail/".$lead->lead_id);?>"><img
									src="<?php echo base_url()."assets/images/history.png";?>"></a>
							<?php }else{ ?>
							<a class="simple-ajax-popup-reminder btn-default"
								href="<?php echo base_url("lms/detail/".$lead->lead_id);?>">N/A</a>
							<?php   }?>
						</td>
						<td>
							<?php 
								if($lead->consultant == 0){
							?>
							<a class="simple-ajax-popup-reminder btn btn-primary"
								href="<?php echo base_url("lms/assign_appointment/".$lead->lead_id);?>">Assign
								Appointment</a>
							<?php }else{
								?>
								<a class="simple-ajax-popup-reminder btn btn-success"
								href="<?php echo base_url("lms/assign_appointment/".$lead->lead_id);?>">View
								Appointment</a>
								<?php
							} ?>
						</td>
						<td class="actions">
						<?php if($lead->more_info_added == 0 && $lead->source_name == 'Walk-in registration'){ ?>
							<a href="<?php echo base_url('lms/edit/'.$lead->lead_id);?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
						<?php } ?>
							<?php 
                    echo anchor('lms/edit/'.$lead->lead_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;';
                    if($this->session->userdata("clms_front_user_group") == 1)
                      echo anchor('lms/delete/'.$lead->lead_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
							<?php if($this->session->userdata("clms_front_user_group") == 1){ ?>
							<a href="<?php echo base_url("lms/send_email/".$lead->lead_id);?>" class="mail"><i
									class="fa fa-mail-forward"></i></a>
							<?php } ?>
							<a href="<?php echo base_url("student/add/".$lead->lead_id);?>"> <i
									class="fa fa-user-md"></i></a>
						</td>
					</tr>
					<?php
              } ?>


				</tbody>
			</table>
			
	</div>
	</div>
</section>
</div>


</section>
</div>
</section>



<script type="text/javascript">
	$(document).ready(function () {
		$('.fa-info-circle').tooltip({
			'placement': 'bottom',
			'title': 'Add more info'
		});
		$('[data-toggle="tooltip"]').tooltip({
			'placement': 'bottom'
		});
		$('.fa-mail-forward').tooltip({
			'placement': 'bottom',
			'title': 'Email'
		});
		$(".fa-user-md").tooltip({
			'placement': 'bottom',
			'title': 'Add Client'
		});

		$(document).on("click",".link_edit",function(){
			$(this).parent().parent().find(".form_update").show();
			$(this).parent().hide();
		});

		$(document).on("click",".link_lead_update",function(){
			$(this).parent().parent().find(".txt_update").show();
			$(this).parent().hide();

			var id = $(this).parent().parent().attr("leadid");
			var content = $(this).parent().find(".update_history").val();
			//  alert(content);
			var newDiv = $(this).parent().prev().find(".span_content");
			// alert(newDiv);
			var jsonData = {id:id,content:content};
			$.ajax({
				url: "<?php echo base_url(); ?>lms/edit_update",
				type: "post",
				data: jsonData,
				success: function (msg) {
					// location.reload();
					newDiv.html(content);
				}
			});
			
		});

		$(document).on("click",".link_lead_delete",function(){
			$(this).parent().parent().find(".txt_update").show();
			$(this).parent().hide();
		});

		$('#addButton').bind('click', function () {
			window.location.assign("<?php echo base_url() ?>lms/add?tab=1");
		})
		$("#checkall").click(function () {
			$(".checkone").prop('checked', $(this).prop('checked'));
		});

		$(".link_delete").click(function () {
			if (!confirm('Are you sure to delete this Lead?'))
				return false;
		});


		$('#datatable-default').DataTable({
			"order": [
				[1, "desc"]
			]
		});

		$("#task-list").trigger("click");


	});

	function cascade(action) {
		if (confirm('Are you sure to proceed this action?')) {
			var ids = checkedCheckboxId();
			if(ids.length == 0){
				alert("Select atleast one data to proceed this action");
				return false;
			}
			var jsonData = {
				"object": {
					"ids": ids,
					"action": action
				}
			};
			$.ajax({
				url: "<?php echo base_url(); ?>lms/cascadeAction",
				type: "post",
				data: jsonData,
				success: function (msg) {
					location.reload();
				}
			});
		} else {
			return false;
		}
	}
</script>