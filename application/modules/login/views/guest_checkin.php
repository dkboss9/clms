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
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet"
    type="text/css">

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
  <style type="text/css">
    input.error {
      border-color: #a94442;
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    }

    .error_email,
    .error_username {
      color: #B94A48;
    }
  </style>
  <!-- Head Libs -->
  <script src="<?php echo base_url();?>assets/vendor/modernizr/modernizr.js"></script>
</head>

<body>
  <!-- start: page -->

  <section class="body-sign">
    <div class="center-sign">
      <a href="/" class="logo pull-left">
        <img src="<?php echo SITE_URL."uploads/logo/".$this->mylibrary->getSiteEmail(24);?>" height="50" />
      </a>

      <div class="panel panel-sign">
        <div class="panel-title-sign mt-xl text-right">
          <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Guest Checkin</h2>
          <?php //echo validation_errors(); ?>
        </div>

        <div class="panel-body">

          <?php 
            if(empty($company)){
                echo '<h1>No company found.</h1>';
            }else{
        ?>
          <?php if($this->session->flashdata("success_message")){ ?>
          <div class="alert alert-success" role="alert">
            <?php echo $this->session->flashdata("success_message");?>
          </div>
          <?php }else{ ?>
          <form id="form" method="post" action="<?php echo current_url();?>" enctype="multipart/form-data"
            class="form-horizontal form-bordered" novalidate="novalidate">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6">
                  <label>Name</label>
                  <input type="text" name="name" id="name" value="<?php echo set_value("name");?>" class="form-control"
                    required />
                  <input type="hidden" name="role" id="role" value="3">
                </div>

                <div class="col-sm-6">
                  <label>Email</label>
                  <input type="email" name="email" id="email" value="<?php echo set_value("email");?>"
                    class="form-control" required />
                  <?php if(form_error("email")){ ?>
                  <label for="email" class="error_email"><?php echo form_error("email");?></label>
                  <?php } ?>

                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">

                <div class="col-sm-6">
                  <label>Mobile</label>
                  <input type="text" name="phone" id="phone" value="<?php echo set_value("phone");?>"
                    class="form-control" required />
                </div>

                <div class="col-sm-6">
                  <label>Purpose</label>
                  <select class="form-control mb-md" name="purpose" id="sel_purpose" required>
                    <option value="">Select</option>
                    <?php 
                    foreach($purpose as $row){
                    ?>
                    <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  <label>Country</label>
                  <select class="form-control mb-md" data-plugin-selectTwo  name="country">
                  <option value="">Country</option>
                  <?php
                  foreach ($countries as $country) {
                  ?>
                  <option <?php if("Australia" == $country->country_name) echo 'selected="selected"';?> value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
                  <?php
                }
                ?>
              </select>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-sm-8">
                <div class="checkbox-custom checkbox-default">
                  <!-- <input type="checkbox" id="AgreeTerms" name="agreeterms"  class="required">
                <label for="AgreeTerms">I agree with <a href="javascript:void(0);" id="term-of-use">terms of use</a></label> -->
                </div>
              </div>
              <div class="col-sm-4 text-right">
                <input type="hidden" name="company_id" id="company_id" value="<?php echo $company->userid;?>">
                <button type="submit" class="btn btn-primary hidden-xs">Check In</button>
                <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Check In</button>
              </div>
            </div>
          </form>
          <?php }} ?>
        </div>
      </div>

      <p class="text-center text-muted mt-md mb-md">&copy; Copyright <?php echo date("Y");?>. All Rights Reserved.</p>
    </div>
  </section>

  <!-- Vendor -->
  <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/nanoscroller/nanoscroller.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/magnific-popup/magnific-popup.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

  <!-- Theme Base, Components and Settings -->
  <script src="<?php echo base_url();?>assets/javascripts/theme.js"></script>

  <!-- Theme Custom -->
  <script src="<?php echo base_url();?>assets/javascripts/theme.custom.js"></script>

  <!-- Theme Initialization Files -->
  <script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>
  <script src="<?php echo base_url("");?>assets/vendor/jquery-validation/jquery.validate.js"></script>

  <script>
    $(document).ready(function () {
      $("#form").validate();
    });
  </script>
</body>

</html>