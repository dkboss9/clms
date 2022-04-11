
<script src="<?php echo base_url("");?>assets/vendor/chartist/chartist.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.categories.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.resize.js"></script>
<?php
$pending = $this->dashboardmodel->countCompanies("pending")->num_rows();
$approved = $this->dashboardmodel->countCompanies("approved")->num_rows();
$total = $this->dashboardmodel->countCompanies()->num_rows();
//echo $this->db->last_query();
?>
<section class="panel">
    <div class="panel-body case-body">

        <div class="migrate-menu">
            <div class="row">
                <div class="col-sm-12">
                    <div class="migrate-menu-list">
                        <div class="mig-top-sec">
                            <!-- <h4 class="mitgrate-tt">Dashboard</h4> -->
                            <div class="adding">
                                <!-- <a href="javascript:void();"><i class="fa fa-plus"></i>Add</a>
                                <a href="javascript:void();"><i class="fa fa-edit"></i>Edit</a> -->
                            </div>
                        </div>

                    </div>
                    <div>
                        <input type="hidden" name="student_id" id="student_id" value="11">
                    </div>
                    <div class="row">

                        <div class="col-md-12 col-lg-4 col-xl-4 lead_count_wrapper">
                            <div class="lead_count_header">
                                <div class=" appointment_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                                <div class="lead_title">Companies</div>
                                <div class=" appointment_icon"> <a
                                        href="<?php echo base_url("user/settings");?>">View All</a></div>
                            </div>
                            <div class="lead_count_body">
                                <div class="counter_wrapper">
                                    <div class="counter_title">Pending </div>
                                    <div class="counter">
                                        <a
                                            href="<?php echo base_url("user/settings");?>"><?php echo $pending;?></a>
                                    </div>
                                </div>
                                <div class="counter_wrapper">
                                    <div class="counter_title">Approved </div>
                                    <div class="counter">
                                        <a
                                            href="<?php echo base_url("user/settings");?>"><?php echo $approved;?></a>
                                    </div>
                                </div>
                                <div class="counter_wrapper">
                                    <div class="counter_title"> Total </div>
                                    <div class="counter">
                                        <a href="<?php echo base_url("user/settings");?>"><?php echo $total;?></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
$today = $this->dashboardmodel->countDateCompanies("today")->num_rows();
$last_week = $this->dashboardmodel->countDateCompanies("last_week")->num_rows();
$this_week = $this->dashboardmodel->countDateCompanies("this_week")->num_rows();
//echo $this->db->last_query();
?>

                        <div class="col-md-12 col-lg-4 col-xl-4 lead_count_wrapper">
                            <div class="lead_count_header">
                                <div class="enroll_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                                <div class="lead_title"> Company Register</div>
                                <div class="enroll_icon"> <a href="<?php echo base_url("user/settings");?>">View
                                        All</a></div>
                            </div>
                            <div class="lead_count_body">
                                <div class="counter_wrapper">
                                    <div class="counter_title">Today</div>
                                    <div class="counter">
                                        <a
                                            href="<a href="<?php echo base_url("user/settings");?>"><?php echo $today;?></a>
                                    </div>
                                </div>
                                <div class="counter_wrapper">
                                    <div class="counter_title">Last Week</div>
                                    <div class="counter">
                                        <a
                                            href="<a href="<?php echo base_url("user/settings");?>"><?php echo $last_week;?></a>
                                    </div>
                                </div>
                                <div class="counter_wrapper">
                                    <div class="counter_title"> This Week </div>
                                    <div class="counter">
                                        <a
                                            href="<a href="<?php echo base_url("user/settings");?>"><?php echo $this_week;?></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
$today = $this->dashboardmodel->countDateStudents("today")->num_rows();
$last_week = $this->dashboardmodel->countDateStudents("last_week")->num_rows();
$this_week = $this->dashboardmodel->countDateStudents("this_week")->num_rows();
$total = $this->dashboardmodel->countDateStudents()->num_rows();
?>

                        <div class="col-md-12 col-lg-4 col-xl-4 lead_count_wrapper">
                            <div class="lead_count_header">
                                <div class="invoice_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                                <div class="lead_title">Student</div>
                                <div class="invoice_icon"> <a href="<?php echo base_url("user/settings");?>">View
                                        All</a></div>
                            </div>
                            <div class="lead_count_body">
                                <div class="counter_wrapper">
                                    <div class="counter_title">Today</div>
                                    <div class="counter">
                                        <a href="<?php echo base_url("user/settings");?>"><?php echo $today;?></a>
                                    </div>
                                </div>
                                <div class="counter_wrapper">
                                    <div class="counter_title">Last Week</div>
                                    <div class="counter">
                                        <a href="<?php echo base_url("user/settings");?>"><?php echo $last_week;?></a>
                                    </div>
                                </div>
                                <div class="counter_wrapper">
                                    <div class="counter_title"> This Week</div>
                                    <div class="counter">
                                        <a href="<?php echo base_url("user/settings");?>"><?php echo $this_week;?></a>
                                    </div>
                                </div>

                                <div class="counter_wrapper">
                                    <div class="counter_title"> Total</div>
                                    <div class="counter">
                                        <a href="<?php echo base_url("user/settings");?>"><?php echo $total?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-3 col-xl-3 lead_count_wrapper" >
                        </div>
                        <?php 
                            $packages = $this->db->where("status",1)->get("pnp_module_package")->result();
                        ?>
                        <div class="col-md-12 col-lg-6 col-xl-6 lead_count_wrapper" >
                        <section class="card">
									<header class="card-header">
										<div class="card-actions">
											<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
											<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
										</div>
						
										<h2 class="card-title">Package wise Companies</h2>
									</header>
                        <div class="card-body">
                        <div class="chart chart-md" id="flotBars"></div>
                        <script type="text/javascript">
						
                        var flotBarsData = [
                            <?php 
                                foreach($packages as $package){ 
                                   $counter = $this->dashboardmodel->countpackageCompany($package->package_id)->num_rows();
                                    ?>
                            ["<?php echo $package->name;?>", <?php echo  $counter;?>],
                            <?php } ?>
                          
                        ];
    
                        // See: js/examples/examples.charts.js for more settings.
    
                    </script>
						
										<!-- See: js/examples/examples.charts.js for the example code. -->
									</div>
                        </section>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</section>

<script>
  (function() {
		if( $('#flotBars').get(0) ) {
			var plot = $.plot('#flotBars', [flotBarsData], {
				colors: ['#8CC9E8'],
				series: {
					bars: {
						show: true,
						barWidth: 0.8,
						align: 'center'
					}
				},
				xaxis: {
					mode: 'categories',
					tickLength: 0
				},
				grid: {
					hoverable: true,
					clickable: true,
					borderColor: 'rgba(0,0,0,0.1)',
					borderWidth: 1,
					labelMargin: 15,
					backgroundColor: 'transparent'
				},
				tooltip: true,
				tooltipOpts: {
					content: '%y',
					shifts: {
						x: -10,
						y: 20
					},
					defaultTheme: false
				}
			});
		}
	})();
</script>