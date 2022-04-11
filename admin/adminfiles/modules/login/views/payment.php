<!doctype html>
<html class="fixed">
<head>

  <!-- Basic -->
  <meta charset="UTF-8">
  <title>Account - Signup</title>
  <meta name="keywords" content="Acrm" />
  <meta name="description" content="Ausnep Customer Relation Management">
  <meta name="author" content="ausnep.com.au">


  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

  <!-- Web Fonts  -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.css" />

  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/magnific-popup/magnific-popup.css" />
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/select2/select2.css" />

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
          <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Registration  <<  Payment</h2>
        </div>
        <div class="panel-body">
          <?php if(validation_errors()!=""){?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo validation_errors(); ?>
          </div>
          <?php } ?>
          <?php if($this->session->flashdata("register-success")){ ?>
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata("register-success");?>
          </div>
          <?php
        }
        ?>

        <form id="form" method="post" action="<?php echo current_url();?>" enctype="multipart/form-data" class="form-horizontal form-bordered" novalidate="novalidate">


          <div class="form-group">
            <label class="col-md-4 control-label" for="fname">Package:</label>
            <div class="col-md-8 control-label" style="text-align:left;">
              <strong><?php echo $package->name;?></strong>
              
              <input type="hidden" name="txt_name" value="<?php echo $package->name;?>">
            </div>
          </div>

          <div class="form-group">
           <label class="col-md-4 control-label"  for="lname">Order Term:</label>
           <div class="col-md-8 control-label" style="text-align:left;">
            <strong><?php echo $company->payment_term;?></strong> 
            <input type="hidden" name="txt_order_term" value="<?php echo $company->payment_term;?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-4 control-label">Amount:</label>
          <div class="col-md-8 control-label" style="text-align:left;">
            <strong>$ <?php echo $company->price;?></strong>
            <input type="hidden" name="txt_price" value="<?php echo $company->price;?>">
          </div>
        </div>

        <div class="form-group mb-lg">
          <strong>Select Payment Type</strong>
        </div>

        <div class="form-group">
          <?php 
          if($this->mylibrary->getSiteEmail(83) == 1){
            ?>

            <div class="col-md-3">
             <input type="radio" name="paymethod" value="eway" id="ewaypayment" class="payment-radio-class" checked="checked" required  />
             <img src="<?php echo base_url("assets/images/");?>/payment-icon.jpg" style="width:60%" >
           </div>
           <?php
         }
         ?>
         <?php 
         if($this->mylibrary->getSiteEmail(81) == 1){
          ?>

          <div class="col-md-3">
            <input type="radio" name="paymethod" value="stripe" id="stripepayment" class="payment-radio-class" checked required  />
            <img src="<?php echo base_url("assets/images/");?>/payment-icon.jpg" style="width:60%" >
          </div>
          <?php
        }
        ?>
        <?php 
        if($this->mylibrary->getSiteEmail(75) == 1){
          ?>
          <div class="col-md-3 ">
           <input type="radio" name="paymethod"  class="payment-radio-class" value="bank" id="banktransfer" required />
           <img src="<?php echo base_url("assets/images/");?>/bank-transfer.gif">
         </div>
         <?php } ?>
         <?php 
         if($this->mylibrary->getSiteEmail(77) == 1){
          ?>
          <!-- <div class="col-md-3 ">
           <input type="radio" name="paymethod"  class="payment-radio-class" value="paypal" id="paypal">
           <img src="<?php echo base_url("assets/images/");?>/paypal.png" style="width:60%">
         </div> -->
         <?php } ?>
       </div>
       <?php 
       if($this->mylibrary->getSiteEmail(81) == 1){
        ?>
        <div id="div_eway"  >
         <input type="hidden" name="access_token" id="access_token" value="">
         <div class="form-group">
           <label class="col-md-4 control-label">Card Name *</label>
           <div class="col-md-8 ">
            <input type="text"  value="" id="card_name" name="card_name" placeholder="Enter Your Card Name" class="form-control required" >
          </div>

        </div>

        <div class="form-group">
         <label class="col-md-4 control-label">Card Number *</label>
         <div class="col-md-8 ">
           <input type="text"  value="" id="card_number" name="card_number" data-stripe="number" placeholder="Enter Your Card Number" class="form-control " required >
         </div>

       </div>

       <div class="form-group">
         <label class="col-md-4 control-label">Expiry Date *</label>
         <div class="col-md-4 ">
           <select name="expiry_month" data-plugin-selectTwo data-stripe="exp_month" class="form-control" required>
            <option value="">Month</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>
        </div>
        <div class="col-md-4 ">
         <select name="expiry_year"  data-stripe="exp_year" data-plugin-selectTwo class="form-control" required>
          <option value="">Year</option>
          <option value="17">2017</option>
          <option value="18">2018</option>
          <option value="19">2019</option>
          <option value="20">2020</option>
          <option value="21">2021</option>
          <option value="22">2022</option>
          <option value="23">2023</option>
          <option value="24">2024</option>
          <option value="25">2025</option>
          <option value="26">2026</option>
          <option value="27">2027</option>
          <option value="28">2028</option>
          <option value="29">2029</option>
          <option value="30">2030</option>
        </select>
      </div>

    </div>

    <div class="form-group">
     <label class="col-md-4 control-label">CVV*</label>
     <div class="col-md-4 ">
      <input type="text"  value="" id="ccv" name="ccv" data-stripe="cvc" placeholder="Enter CCV" class="form-control " required>
    </div>

  </div>


</div>
<?php } ?>

<?php 
if($this->mylibrary->getSiteEmail(75) == 1){
  ?>
  <div class="icon-border" id="div_bank" style="display:none;">
    <div class="form-group">
      <div class="col-md-12 ">
       AusNep Group Pty Ltd.<br/>BSB: 062 475 <br/>A/C No.: 1009 5913<br/>  Common Wealth Bank
     </div>
   </div>
 </div>
 <?php } ?>

 <div class="form-group">
 </div>

 <div class="row">
  <div class="col-sm-8">
    <div class="checkbox-custom checkbox-default">
    </div>
  </div>
  <div class="col-sm-4 text-right">
    <button type="submit" class="btn btn-primary hidden-xs submit">Submit</button>
    <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg submit">Submit</button>
  </div>
</div>
</form>
</div>
</div>

<p class="text-center text-muted mt-md mb-md">&copy; Copyright <?php echo date("Y");?>. All Rights Reserved.</p>
</div>
</section>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
 //Stripe.setPublishableKey('pk_test_JIbsTfUxDOQnFUt7LzE9fkzr');
 Stripe.setPublishableKey('<?php echo $this->mylibrary->getSiteEmail(85);?>');
  $(function() {
    var $form = $('#form');
    $("#ccv").blur(function(event) { 
    // Disable the submit button to prevent repeated clicks:
    

    // Request a token from Stripe:
    if( $('input[name=paymethod]:checked').val() == 'stripe'){
      Stripe.card.createToken($form, stripeResponseHandler);
    }
    // Prevent the form from being submitted:
    return false;
  });
  });
  function stripeResponseHandler(status, response) {

   if (response.error) {
    alert(response.error.message);
  } else {
    $("#access_token").val(response.id);
    console.log(response.id);
  }
}
</script>

<!-- end: page -->

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
<script src="<?php echo base_url();?>assets/vendor/select2/select2.js"></script>

<!-- Theme Initialization Files -->
<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/jquery-validation/jquery.validate.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#form").validate();
    $("#btn-submit").click(function(){
      $("#form").submit();
    });
    $('.payment-radio-class').click(function() { 
      if ($(this).val() == 'bank'){
        $('.bank-info').slideDown();
        $('#extrachargesinfo2').hide();
        $("#div_bank").show();
        $("#div_eway").hide();
      }

      if ($(this).val() == 'eway' || $(this).val() == 'stripe'){
       $('.bank-info').slideUp();
       $('#extrachargesinfo2').show();
       $("#div_bank").hide();
       $("#div_eway").show();
     }

     if ($(this).val() == 'paypal'){
       $("#div_bank").hide();  
       $("#div_eway").hide();    
     }
   });
  });
</script>

</body>
</html>