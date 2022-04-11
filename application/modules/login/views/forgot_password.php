<!doctype html>
<html class="fixed">
<head>
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
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap/css/bootstrap.css" />

	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<script src="<?php echo base_url("");?>assets/vendor/modernizr/modernizr.js"></script>
	<style>
		.input-group > .form-control {
    position: relative;
    -ms-flex: 1 1 0%;
    flex: 0.8 1 0%;
    min-width: 0;
    margin-bottom: 0;
}
	</style>
</head>
<body>
	<!-- start: page -->
	<?php
	$row = $this->generalsettingsmodel->getConfigData(24)->row();
	?>
	<section class="body-sign">
		<div class="center-sign">
			<a href="/" class="logo pull-left">
				<img src="<?php echo SITE_URL."uploads/logo/".$row->config_value;?>" />
			</a>

			<div class="panel panel-sign">
				<div class="panel-title-sign mt-xl text-right">
					<h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Recover Password</h2>
				</div>
				<div class="panel-body">
					<div class="alert alert-info">
						<p class="m-none text-weight-semibold h6">
							<?php 
							if($userexit != '')
								echo 'No user found with this email.';
							elseif($this->input->get("success") == 1)
								echo 'We have email your new password. Please check your email.';
							else
								echo 'Enter your e-mail below!';

							?>

						</p>
					</div>

					<form action="<?php echo current_url();?>" id="form" method="post">
						<div class="form-group mb-none">
							<div class="input-group">
								<input name="email" type="email" value="<?php echo $userexit;?>" placeholder="E-mail" class="form-control input-lg" required/>
								<span class="input-group-btn">
									<input type="submit" class="btn btn-primary btn-lg" name="btn-submit" value="submit">
								</span>
							</div>
						</div>

						<p class="text-center mt-lg">Remembered? <a href="<?php echo base_url("login");?>">Sign In!</a>
						</form>
					</div>
				</div>

				<p class="text-center text-muted mt-md mb-md">&copy; Copyright <?php echo base_url("Y");?>. All Rights Reserved.</p>
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="<?php echo base_url("");?>assets/vendor/jquery/jquery.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-validation/jquery.validate.js"></script>
		<script src="<?php echo base_url("");?>assets/javascripts/forms/examples.validation.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo base_url("");?>assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="<?php echo base_url("");?>assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?php echo base_url("");?>assets/javascripts/theme.init.js"></script>

	</body>
	</html>