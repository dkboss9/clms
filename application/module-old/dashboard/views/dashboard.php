
<div style="text-align: center;">
<img src="<?php echo SITE_URL; ?>/uploads/logo/logo 1 draft_rectangle-04.png" style="width: 50%;">

<div>
	<h3 style="font-size: 24px;"> Welcome to Khrouch </h3>
</div>
</div>
<?php /*
<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>

<script src="<?php echo base_url("");?>assets/vendor/chartist/chartist.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.categories.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.resize.js"></script>

<style type="text/css">

.btn-action{
  padding: 5px;
  color: #fff !important;
}
.link_archive_all1{float: left;}
.link_archive_all{float: right;}
</style>
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

	ul.widget-todo-list-new li {
    border-bottom: 1px dotted #ddd;
    padding: 15px 15px 15px 0;
    position: relative;
}

.checkbox-custom {
    position: relative;
    padding: 0 0 0 25px;
    margin-bottom: 7px;
    margin-top: 0;
}

	@media(max-width: 767px) {
		.top-icon li {
			padding: 0% 2.5%;
		}
	}
</style>


	<?php if($this->session->flashdata("success_message")){?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<strong>Well done!</strong> <?php echo $this->session->flashdata("success_message") ?>
	</div>
	<?php
}
?>

	<!-- start: page -->

	<div class="row">
		<div class="col-md-9 module_link_wrapper">
			<a href="<?php echo base_url("dashboard/leads")?>">
				<div class="module_link selected">
					<div><i class="fa fa-bar-chart" aria-hidden="true"></i></div>
					<div>Leads</div>
				</div>
			</a>

			<a href="<?php echo base_url("dashboard/appointment");?>">
				<div class="module_link ">
					<div><i class="fa fa-clock-o" aria-hidden="true"></i></div>
					<div>Appointment</div>
				</div>
			</a>

			<a href="<?php echo base_url("dashboard/counselling")?>">
				<div class="module_link ">
					<div><i class="fa fa-globe" aria-hidden="true"></i></div>
					<div>Councelling</div>
				</div>
			</a>

			<a href="<?php echo base_url("dashboard/enroll")?>">
				<div class="module_link ">
					<div><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div>Enrollment</div>
				</div>
			</a>

			<a href="<?php echo base_url("appointment/callendar")?>">
				<div class="module_link ">
					<div><i class="fa fa-calendar" aria-hidden="true"></i></div>
					<div>Calendar</div>
				</div>
			</a>

			<a href="">
				<div class="module_link ">
					<div><i class="fa fa-book" aria-hidden="true"></i></div>
					<div>Visa</div>
				</div>
			</a>

			<a href="<?php echo base_url("dashboard/student")?>">
				<div class="module_link ">
					<div><i class="fa fa-user" aria-hidden="true"></i></div>
					<div>Students</div>
				</div>
			</a>

		</div>
		<div class="col-md-3 ">
			<div class="notice-board-wrapper"  data-toggle="modal" data-target="#noticeModal">
			<div class="notice-board-title">
				Notice Board
			</div>
			<div class="notice-board-body" >
				<?php echo substr($notice,0,180);?>
			</div>
			</div>
		</div>
	</div>

	<?php 
$this->load->view("dashboard_count");
?>

	<div class="row">
		<div class="col-lg-6 mb-3">
			<section class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-lg-8 col-xl-8">
							<div class="chart-data-selector" id="salesSelectorWrapper">
								<h2>
									Sales:
									<strong>
										<select class="form-control" id="salesSelector">
											<option value="Porto Admin" selected>Porto Admin</option>
											<option value="Porto Drupal">Porto Drupal</option>
											<option value="Porto Wordpress">Porto Wordpress</option>
										</select>
									</strong>
								</h2>

								<div id="salesSelectorItems" class="chart-data-selector-items mt-3">
									<!-- Flot: Sales Porto Admin -->
									<div class="chart chart-sm" data-sales-rel="Porto Admin" id="flotDashSales1"
										class="chart-active" style="height: 203px;"></div>
									<script>
										var flotDashSales1Data = [{
											data: [
												["Jan", 140],
												["Feb", 240],
												["Mar", 190],
												["Apr", 140],
												["May", 180],
												["Jun", 320],
												["Jul", 270],
												["Aug", 180]
											],
											color: "#0088cc"
										}];

										// See: js/examples/examples.dashboard.js for more settings.
									</script>

									<!-- Flot: Sales Porto Drupal -->
									<div class="chart chart-sm" data-sales-rel="Porto Drupal" id="flotDashSales2"
										class="chart-hidden"></div>
									<script>
										var flotDashSales2Data = [{
											data: [
												["Jan", 240],
												["Feb", 240],
												["Mar", 290],
												["Apr", 540],
												["May", 480],
												["Jun", 220],
												["Jul", 170],
												["Aug", 190]
											],
											color: "#2baab1"
										}];

										// See: js/examples/examples.dashboard.js for more settings.
									</script>

									<!-- Flot: Sales Porto Wordpress -->
									<div class="chart chart-sm" data-sales-rel="Porto Wordpress" id="flotDashSales3"
										class="chart-hidden"></div>
									<script>
										var flotDashSales3Data = [{
											data: [
												["Jan", 840],
												["Feb", 740],
												["Mar", 690],
												["Apr", 940],
												["May", 1180],
												["Jun", 820],
												["Jul", 570],
												["Aug", 780]
											],
											color: "#734ba9"
										}];

										// See: js/examples/examples.dashboard.js for more settings.
									</script>
								</div>

							</div>
						</div>
						<div class="col-lg-4 col-xl-4 text-center">
							<h2 class="card-title mt-3">Sales Goal</h2>
							<div class="liquid-meter-wrapper liquid-meter-sm mt-3">
								<div class="liquid-meter">
									<meter min="0" max="100" value="35" id="meterSales"></meter>
								</div>
								<div class="liquid-meter-selector mt-4 pt-1" id="meterSalesSel">
									<a href="#" data-val="35" class="active">Monthly Goal</a>
									<a href="#" data-val="28">Annual Goal</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="col-lg-6">
			<div class="row mb-3">
				<div class="col-lg-6 col-xl-6">
					<section class="card card-featured-left card-featured-primary mb-3">
						<div class="card-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-primary">
										<i class="fas fa-life-ring"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Support Questions</h4>
										<div class="info">
											<strong class="amount">1281</strong>
											<span class="text-primary">(14 unread)</span>
										</div>
									</div>
									<div class="summary-footer">
										<a class="text-muted text-uppercase" href="#">(view all)</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="col-lg-6 col-xl-6">
					<section class="card card-featured-left card-featured-secondary">
						<div class="card-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-secondary">
										<i class="fas fa-dollar-sign"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Total Profit</h4>
										<div class="info">
											<strong class="amount">$ 14,890.30</strong>
										</div>
									</div>
									<div class="summary-footer">
										<a class="text-muted text-uppercase" href="#">(withdraw)</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-xl-6">
					<section class="card card-featured-left card-featured-tertiary mb-3">
						<div class="card-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-tertiary">
										<i class="fas fa-shopping-cart"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Today's Orders</h4>
										<div class="info">
											<strong class="amount">38</strong>
										</div>
									</div>
									<div class="summary-footer">
										<a class="text-muted text-uppercase" href="#">(statement)</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="col-lg-6 col-xl-6">
					<section class="card card-featured-left card-featured-quaternary">
						<div class="card-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-tertiary">
										<i class="fa fa-user"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Today's Visitors</h4>
										<div class="info">
											<strong class="amount">3765</strong>
										</div>
									</div>
									<div class="summary-footer">
										<a class="text-muted text-uppercase" href="#">(report)</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-lg-6">
			<section class="card">
				<header class="card-header">
					<div class="card-actions">
						<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
						<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
					</div>

					<h2 class="card-title">Student flow in Bar Graph</h2>
				</header>
				<div class="card-body">
					<div id="ChartistOverlappingBarsOnMobile" class="ct-chart ct-perfect-fourth ct-golden-section">
					</div>

					<!-- See: js/examples/examples.charts.js for the example code. -->
				</div>
			</section>
		</div>
		<div class="col-lg-6">
			<section class="card">
				<header class="card-header">
					<div class="card-actions">
						<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
						<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
					</div>

					<h2 class="card-title">Real-Time Chart</h2>
				</header>
				<div class="card-body">

					<!-- Flot: Curves -->
					<div class="chart chart-md" id="flotRealTime"></div>

				</div>
			</section>
		</div>
	</div>


	<div class="row pt-4 mt-2">
	
		<div class="col-lg-6 col-xl-6">

			<section class="card mb-3">
				<header class="card-header">
					<div class="card-actions">
						<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
						<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
					</div>

					<h2 class="card-title">
						<span class="badge badge-primary font-weight-normal va-middle p-2 mr-2">298</span>
						<span class="va-middle">Friends</span>
					</h2>
				</header>
				<div class="card-body">
					<div class="content">
						<ul class="simple-user-list">
							<li>
								<figure class="image rounded">
									<img src="<?php echo base_url("assets")?>/images/!sample-user.jpg"
										alt="Joseph Doe Junior" class="rounded-circle">
								</figure>
								<span class="title">Joseph Doe Junior</span>
								<span class="message truncate">Lorem ipsum dolor sit.</span>
							</li>
							<li>
								<figure class="image rounded">
									<img src="<?php echo base_url("assets")?>/images/!sample-user.jpg"
										alt="Joseph Junior" class="rounded-circle">
								</figure>
								<span class="title">Joseph Junior</span>
								<span class="message truncate">Lorem ipsum dolor sit.</span>
							</li>
							<li>
								<figure class="image rounded">
									<img src="<?php echo base_url("assets")?>/images/!sample-user.jpg" alt="Joe Junior"
										class="rounded-circle">
								</figure>
								<span class="title">Joe Junior</span>
								<span class="message truncate">Lorem ipsum dolor sit.</span>
							</li>
						</ul>
						<hr class="dotted short">
						<div class="text-right">
							<a class="text-uppercase text-muted" href="#">(View All)</a>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="input-group">
						<input type="text" class="form-control" name="s" id="s" placeholder="Search...">
						<span class="input-group-append">
							<button class="btn btn-default" type="submit"><i class="fas fa-search"></i>
							</button>
						</span>
					</div>
				</div>
			</section>
		</div>
		<div class="col-lg-12 col-xl-6">
			<section class="card">
				<header class="card-header card-header-transparent">
					<div class="card-actions">
						<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
						<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
					</div>

					<h2 class="card-title">Company Activity</h2>
				</header>
				<div class="card-body">
					<div class="timeline timeline-simple mt-3 mb-3">
						<div class="tm-body">
							<div class="tm-title">
								<h5 class="m-0 pt-2 pb-2 text-uppercase">November 2017</h5>
							</div>
							<ol class="tm-items">
								<li>
									<div class="tm-box">
										<p class="text-muted mb-0">7 months ago.</p>
										<p>
											Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas hendrerit
											augue at leo viverra, aliquam egestas lectus laoreet. Donec vehicula
											vestibulum ipsum, tincidunt ultrices elit suscipit ac. Sed eget risus
											laoreet, varius nibh id, luctus ligula. Nulla facilisi. <span
												class="text-primary">#awesome</span>
										</p>
									</div>
								</li>
								<li>
									<div class="tm-box">
										<p class="text-muted mb-0">7 months ago.</p>
										<p>
											Checkout! How cool is that! Etiam efficitur, sapien eget vehicula gravida,
											magna neque volutpat risus, vitae tempus odio arcu ac elit. Aenean porta
											orci eu mi fermentum varius. Curabitur ac sem at nibh egestas. Curabitur ac
											sem at nibh egestas.
										</p>
										<div class="thumbnail-gallery">
											<a class="img-thumbnail lightbox" href="img/projects/project-4.jpg"
												data-plugin-options='{ "type":"image" }'>
												<img class="img-fluid" width="215"
													src="<?php echo base_url("assets")?>/images/!logged-user.jpg">
												<span class="zoom">
													<i class="fas fa-search"></i>
												</span>
											</a>
										</div>
									</div>
								</li>
							</ol>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>


	<div class="row">

<div class="col-xl-6 col-lg-6">
  <section class="panel panel-transparent">
	<header class="panel-heading">
	  <div class="panel-actions">
		<!-- <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
		<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a> -->
	  </div>

	  <h2 class="panel-title">To Do list <a href="<?php echo base_url("cron/send_todo_email");?>" style="float: right;">Export</a></h2>
	</header>
	<div class="panel-body">
	  <section class="panel panel-group">

		<div id="accordion">
		  <div class="panel panel-accordion panel-accordion-first" >
			<div class="panel-heading">
			  <h4 class="panel-title">
				<a  href="<?php echo base_url("download/tasks")?>">
				  <i class="fa fa-download"></i> Tasks
				</a>
			  </h4>
			</div>
			<div id="collapse1One" class=" collapse in">
			  <div class="panel-body">
				<ul class="widget-todo-list-new" id="widget-todo-list" style="height: 220px;overflow-y:scroll;">
				  <?php 
				  $i = 1;
				  foreach ($todos as $row) {
					?>
					<li class="li_todo">
					  <div class="checkbox-custom checkbox-default">
						<input type="checkbox" <?php if($row->status == 1) echo 'checked=""';?> value="<?php echo $row->id;?>" id="todoListItem<?php echo $i;?>" class="todo-check my-todo">
						<label class="todo-label  <?php if($row->status == 1){?>line-through <?php } ?>" for="todoListItem<?php echo $i;?>"><span><?php echo $row->task_name;?></span></label>
					  </div>
					  <div class="todo-actions">
						<a  href="<?php echo base_url("dashboard/todotask_detail/".$row->id);?>" class="simple-ajax-popup btn btn-primary btn-action" style="font-size: 10px;"><span class="fa fa-info-circle"></span></a>
						<?php if($row->status == 1){?>
						<a class="btn btn-primary link_archive" style="font-size: 10px;" rel="<?php echo $row->id;?>" href="javascript:void(0);">
						 Archive
					   </a>
					   <?php }else{ ?>
					   <a class="todo-remove btn link_remove btn-action btn-danger" rel="<?php echo $row->id;?>" href="javascript:void(0);" style="font-size: 10px;">
						 <span class="glyphicon glyphicon-trash" data-original-title="" title=""></span>
					   </a>
					   <?php
					 }
					 ?>
				   </div>
				 </li>
				 <?php
			   }?>


			 </ul>
			 <hr class="solid mt-sm mb-lg">
			 <form method="get" class="form-horizontal form-bordered">
			  <div class="form-group">
				<div class="col-sm-12">
				  <div class="input-group input-task mb-md">
					<input type="text" class="form-control" id="txt_todo">
					<div class="input-group-btn">
					  <button type="button" id="btn-todo" class="btn btn-primary" tabindex="-1">Add</button>
					</div>

				  </div>
				  <div id="div_todo" style="color:red;"></div>
				</div>
			  </div>
			</form>
		  </div>
		</div>
	  </div>

	</div>
  </section>

</div>
</section>
</div>

<div class="col-xl-6 col-lg-6">
<section class="panel panel-transparent">
<header class="panel-heading">
  <div class="panel-actions">
	<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
	<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
  </div>

  <h2 class="panel-title">Archived To Do list</h2>
</header>
<div class="panel-body">
  <section class="panel panel-group">

	<div id="accordion">
	  <div class="panel panel-accordion panel-accordion-first" >
		<div class="panel-heading">
		  <h4 class="panel-title">

			<a  href="<?php echo base_url("download/tasks/archive")?>">
			  <i class="fa fa-download"></i> Archived Tasks
			</a>
		  </h4>
		</div>
		<div id="collapse1One" class=" collapse in">
		  <div class="panel-body">
			<ul class="widget-todo-list-new" id="widget-todo-list" style="height: 220px;overflow-y:scroll;">
			  <?php 
			  $i = 1;
			  foreach ($archiv_todos as $row) {
				?>
				<li class="li_todo">
				  <div >
					<label class="todo-label" for="todoListItem<?php echo $i;?>"><span><?php echo $row->task_name;?></span></label>
				  </div>
				  <div class="todo-actions">
					<a  href="<?php echo base_url("dashboard/todotask_detail/".$row->id);?>" class="simple-ajax-popup btn btn-primary btn-action" style="font-size: 10px;"><span class="fa fa-info-circle"></span></a>
				  </div>
				</li>
				<?php
			  }?>


			</ul>
			<hr class="solid mt-sm mb-lg">
			
		  </div>
		</div>
	  </div>

	</div>
  </section>

</div>
</section>
</div>

</div>

	

	
</section>
</div>
</section>

<div class="modal fade" id="noticeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<i class="fa fa-times" aria-hidden="true"></i>
		</button>
	<form name="form_notice" method="post" action="<?php echo base_url("dashboard/index")?>">
      <div class="modal-body">
		<textarea rows="10" name="notice" style="width:100%"><?php echo $notice;?></textarea>
	
      </div>
      <div class="modal-footer notice-buttons">
		  <input type="hidden" name="notice_form" value="1">
	  	<button type="submit" class="btn btn-success">Save </button>
        <button type="button" class="btn btn-danger btn-delete" data-dismiss="modal">Delete</button>
	  </div>
	</form>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function () {

		$(".my-todo").click(function(){
    if(!confirm("Are you Sure to change Status of todo task?"))
      return false;

    var taskid = $(this).val();
    if ($(this).prop('checked')==true){ 
      var status = 1;
    }else{
      var status = 0;
    }
    $.ajax({
      url: '<?php echo base_url() ?>dashboard/status_todotask',
      type: "POST",
      data: "taskid=" + taskid + "&status=" + status,
      success: function(data) { 
        window.location.reload();
      }        
    });
    
  })

  $(".link_archive").click(function(){
    if(!confirm("Are you Sure to Archive todo task?"))
      return false;
    var taskid = $(this).attr("rel");
    $.ajax({
      url: '<?php echo base_url() ?>dashboard/archive_todotask',
      type: "POST",
      data: "taskid=" + taskid,
      success: function(data) { 
        window.location.reload();
      }        
    });
  });


		$("#btn-todo").click(function(){
    var task = $("#txt_todo").val();
    if(task == ""){
      $("#div_todo").html("Enter the to do task");
      return false;
    }else{
      $("#div_todo").html("");
    }
    var num = $(".li_todo").length + 1;
    $.ajax({
     url: '<?php echo base_url() ?>dashboard/add_todotask',
     type: "POST",
     data: "task=" + task,
     success: function(data) { 
   
       location.reload();
     }        
   });
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
			'title': 'Add Student'
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

*/
?>
