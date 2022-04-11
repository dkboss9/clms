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
  <!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/theme-custom.css"> -->

  <link rel="apple-touch-icon" href="<?php echo base_url("");?>assets/images/alms.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url("");?>assets/images/alms.png" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url("");?>assets/images/alms.png" />
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url("");?>assets/images/alms.png" />
  <link rel="apple-touch-icon" sizes="58x58" href="<?php echo base_url("");?>assets/images/alms.png" />

  <!-- Head Libs -->
  <script src="<?php echo base_url();?>assets/vendor/modernizr/modernizr.js"></script>
</head>
<body>
  <!-- start: page -->
  <?php
  $row = $this->generalsettingsmodel->getConfigData(24)->row();
  ?>
  <section class="body-sign">
    <div class="center-sign">
      <a href="#" class="logo pull-left" style="width: 65%;">
        <img src="<?php echo SITE_URL."uploads/logo/".$row->config_value;?>" style="width: 90%;" />
      </a>

      <div class="panel panel-sign">
        <div class="panel-title-sign mt-xl text-right">
          <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Change Password</h2>
        </div>
        <div class="panel-body">
		<?php if(!isset($user)){?>
					<div class="alert alert-danger">
						This link is not valid or expired.
					</div>
					<?php }else{ ?>
					<div class="alert alert-info">
						<p class="m-none text-weight-semibold h6">
							<?php if($this->session->flashdata("sucess_message")){ 
							echo $this->session->flashdata("sucess_message");
						}else{?>
						Enter your new password below .
						<?php } ?>
					</p>
				</div>
		<form name="form_forgot" id="form" method="post" action="<?php echo current_url();?>" novalidate="novalidate">
					<div class="form-group mb-lg">
						<label>Password</label>
						<div class="input-group input-group-icon">
							<input name="password" type="password" value="" class="form-control input-lg" required />
							<span class="input-group-addon">
								<span class="icon icon-lg">
									<i class="fa fa-lock"></i>
								</span>
							</span>
						</div>
						<span class="error"><?php echo form_error("password");?></span>
					</div>

					<div class="form-group mb-lg">
						<div class="clearfix">
							<label class="pull-left">Confirm Password</label>

						</div>
						<div class="input-group input-group-icon">
							<input name="cpassword" type="password" value="" class="form-control input-lg" required />
							<span class="input-group-addon">
								<span class="icon icon-lg">
									<i class="fa fa-lock"></i>
								</span>
							</span>
						</div>
						<span class="error"><?php echo form_error("cpassword");?></span>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="checkbox-custom checkbox-default">
							</div>
						</div>
						<div class="col-sm-6 text-right">
							<input type="submit" name="submit" class="btn btn-primary hidden-xs" value="Change Password">
							<input type="submit" name="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg" value="Change Password">
						</div>
					</div>
					<br>
				</form>
						<?php } ?>
        </div>
      </div>

      <p class="text-center text-muted mt-md mb-md">&copy; Copyright <?php echo date("Y");?>. All Rights Reserved.</p>
    </div>
  </section>
  <!-- end: page -->

  <!-- Vendor -->
  <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
  <script src="<?php echo base_url();?>/vendor/bootstrap/js/bootstrap.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/nanoscroller/nanoscroller.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/magnific-popup/magnific-popup.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
  <script src="<?php echo base_url("");?>assets/vendor/jquery-validation/jquery.validate.js"></script>
  <script src="<?php echo base_url("");?>assets/javascripts/forms/examples.validation.js"></script>

  <!-- Theme Base, Components and Settings -->
  <script src="<?php echo base_url();?>assets/javascripts/theme.js"></script>

  <!-- Theme Custom -->
  <script src="<?php echo base_url();?>assets/javascripts/theme.custom.js"></script>

  <!-- Theme Initialization Files -->
  <script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>

</body>
</html>