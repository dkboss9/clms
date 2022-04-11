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
  <style type="text/css">
    input.error {
      border-color: #a94442;
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    }

    .error_email,.error_username{
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
        <img src="<?php echo SITE_URL."uploads/logo/".$this->mylibrary->getSiteEmail(24);?>" height="50"/>
      </a>

      <div class="panel panel-sign">
        <div class="panel-title-sign mt-xl text-right">
          <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Sign Up</h2>
          <?php //echo validation_errors(); ?>
        </div>
      
        <div class="panel-body">

          <form id="form" method="post" action="<?php echo current_url();?>" enctype="multipart/form-data" class="form-horizontal form-bordered" novalidate="novalidate">
         <div class="form-group">
          <div class="row">
            <div class="col-sm-6">
              <label>First Name</label>
              <input type="text" name="fname" id="fname" value="<?php echo set_value("fname",$user->first_name??"");?>" class="form-control"  required />
              <input type="hidden" name="role" id="role" value="3">
            </div>
            <div class="col-sm-6">
              <label>Last Name</label>
              <input type="text" name="lname" id="lname" value="<?php echo set_value("lname",$user->last_name??"");?>" class="form-control"  required/>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-sm-6">
              <label>Email</label>
              <input type="email" name="email" id="email" value="<?php echo set_value("email",$user->email??"");?>" class="form-control"  required/>
              <?php if(form_error("email")){ ?>
                <label for="email" class="error_email" ><?php echo form_error("email");?></label>
              <?php } ?>

            </div>
            <div class="col-sm-6">
              <label>Phone Number</label>
              <input type="text" name="phone" id="phone" value="<?php echo set_value("phone",$user->phone??"");?>" class="form-control" required/>

            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-sm-6">
              <label>Password</label>
              <input type="password" name="password" id="password" minlength="6" class="form-control" required />
            </div>
            <div class="col-sm-6">
              <label>Confirm Password</label>
              <input type="password" name="cpassword" id="cpassword" equalTo="#password" class="form-control"  required/>
              <?php echo form_error("username");?>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-sm-12">
              <label>Country</label>
              <select name="bill_country" id="bill_country" class="form-control" required >
                <option value="">Select</option>
                <?php 
                foreach ($countries as $row) {
                  ?>
                  <option <?php if($row->country_id == 13) echo 'selected="selected"';?> value="<?php echo $row->country_id;?>"><?php echo $row->country_name;?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <div class="col-sm-6">
            <label>&nbsp;</label>
             
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-8">
            <div class="checkbox-custom checkbox-default">
            <input type="checkbox" id="AgreeTerms" name="agreeterms"  class="required">
              <label for="AgreeTerms">I agree with <a href="javascript:void(0);" id="term-of-use">terms of use</a></label>
            </div>
          </div>
          <div class="col-sm-4 text-right">
            <input type="hidden" name="company_id" id="company_id" value="<?php echo set_value("company_id",$companyid);?>">
            <input type="hidden" name="company_user_id" id="company_user_id" value="<?php echo set_value("company_user_id",$company_user_id);?>">
            <input type="hidden" name="type" value="<?php echo set_value("type",$type);?>">
            <button type="submit" class="btn btn-primary hidden-xs">Sign up</button>
            <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign up</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <p class="text-center text-muted mt-md mb-md">&copy; Copyright <?php echo date("Y");?>. All Rights Reserved.</p>
</div>
</section>
<div style="hidden">

  <div id="form_payment_modal" class="modal fade" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content" style="width:900px;" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo $content->name;?></h4>
          </div>

          <div id="div_payroll_form">

            <?php
            echo $content->content;
            ?>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>

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

<script type="text/javascript">
  $(document).ready(function(){
    $("#form").validate();
    $("#term-of-use").click(function(){
      $("#form_payment_modal").modal();
    });

    $("#package").change(function(){
      var package_id = $(this).val();
      if(package_id == "")
        return false;

      $.ajax({
        url: '<?php echo base_url() ?>company/getPackagePrice',
        type: "POST",
        data: "package_id=" + package_id,
        success: function(data) { 
          if(data != ""){
            $("#order_term").html(data);
          }
        }        
      });

    });

    $(document).on("change","#order_term",function(){
      var price =  $('option:selected', this).attr('price');
      var discountprice =  $('option:selected', this).attr('discountprice');
      if(price > discountprice)
        var price1 = discountprice;
      else
        var price1 = price;
      $("#span_package_price").html('AUD '+price1);
      $("#txt_package_price").val(price1);
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


</body>
</html>