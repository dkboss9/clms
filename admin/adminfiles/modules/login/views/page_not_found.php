<!doctype html>
<html class="fixed">
<head>

	<!-- Basic -->
	<meta charset="UTF-8">
<?php

$site_title = $this->generalsettingsmodel->getConfigData(43)->row();
$site_keyword = $this->generalsettingsmodel->getConfigData(44)->row();
$site_desc = $this->generalsettingsmodel->getConfigData(45)->row();

?>
<title><?php echo $site_title->config_value; ?></title>
<meta name="keywords" content="<?php echo $site_keyword->config_value; ?>" />
<meta name="description" content="<?php echo $site_desc->config_value; ?>">
<meta name="author" content="">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.css" />

	<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<script src="<?php echo base_url();?>assets/vendor/modernizr/modernizr.js"></script>
</head>
<body>
	<section role="main" class="content-body">


		<!-- start: page -->
		<section class="body-error error-inside">
			<div class="center-error">

				<div class="row">
					<div class="col-md-8">
						<div class="main-error mb-xlg">
							<h2 class="error-code text-dark text-center text-weight-semibold m-none">404 <i class="fa fa-file"></i></h2>
							<p class="error-explanation text-center">We're sorry, but the page you were looking for doesn't exist.</p>
						</div>
					</div>
					<div class="col-md-4">
						<h4 class="text">Here are some useful links</h4>
						<ul class="nav nav-list primary">
							<li>
								<a href="<?php echo base_url("login");?>"><i class="fa fa-caret-right text-dark"></i> Login</a>
							</li>
							<li>
								<a href="<?php echo base_url("register");?>"><i class="fa fa-caret-right text-dark"></i> Sign Up</a>
							</li>
							
						</ul>
					</div>
				</div>
			</div>
		</section>
		<!-- end: page -->
	</section>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>  
	<script src="<?php echo base_url();?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="<?php echo base_url();?>/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="<?php echo base_url();?>assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo base_url();?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url();?>assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="<?php echo base_url();?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
 <?php /*
 
  
  
 
  
   */ ?>

   <!-- Theme Base, Components and Settings -->
   <script src="<?php echo base_url();?>assets/javascripts/theme.js"></script>

   <!-- Theme Custom -->
   <script src="<?php echo base_url();?>assets/javascripts/theme.custom.js"></script>

   <!-- Theme Initialization Files -->
   <script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>

</body>
</html>