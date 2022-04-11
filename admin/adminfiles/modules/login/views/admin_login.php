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
  <!-- start: page -->
  <?php
  $row = $this->generalsettingsmodel->getConfigData(24)->row();
  ?>
  <section class="body-sign">
    <div class="center-sign">
      <a href="#" class="logo pull-left">
        <img src="<?php echo SITE_URL."uploads/logo/".$row->config_value;?>" />
      </a>

      <div class="panel panel-sign">
        <div class="panel-title-sign mt-xl text-right">
          <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
        </div>
        <div class="panel-body">
          <form action="<?php echo base_url("login/admin_login");?>" method="post">
            <?php if($this->session->flashdata('error')!=""){ ?>
            <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <strong>Ops!</strong>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
            <?php  } ?>
            <?php if($this->session->flashdata('success_message')!=""){ ?>
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <strong>Well done!</strong> <?php echo $this->session->flashdata('success_message');?> <a href="" class="alert-link">Thank you.</a>.
            </div>
            <?php } ?>
            <div class="form-group mb-lg">
              <label>Username</label>
              <div class="input-group input-group-icon">
              <input name="username" type="text" class="form-control input-lg" required />
                <span class="input-group-addon">
                  <span class="icon icon-lg">
                    <i class="fa fa-user"></i>
                  </span>
                </span>
              </div>
            </div>

            <div class="form-group mb-lg">
              <div class="clearfix">
                <label class="pull-left">Password</label>
              <!--  <a href="<?php echo base_url("recover-password");?>" class="pull-right">Forgot Password?</a> -->
              </div>
              <div class="input-group input-group-icon">
                <input name="password" type="password" class="form-control input-lg" required />
                <span class="input-group-addon">
                  <span class="icon icon-lg">
                    <i class="fa fa-lock"></i>
                  </span>
                </span>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <div class="checkbox-custom checkbox-default">
                  <input id="RememberMe" name="rememberme" type="checkbox"/>
                  <label for="RememberMe">Remember Me</label>
                </div>
              </div>
              <div class="col-sm-4 text-right">
                <input type="submit" name="submit" class="btn btn-primary hidden-xs" value="Sign In">
                <input type="submit" name="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg" value="Login">
              </div>
            </div>
            
          </form>
        </div>
      </div>





      <p class="text-center text-muted mt-md mb-md">&copy; Copyright <?php echo date("Y");?>. All Rights Reserved.</p>
    </div>
  </section>
  <!-- end: page -->

  <!-- Vendor -->
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