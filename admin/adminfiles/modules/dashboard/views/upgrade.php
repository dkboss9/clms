 <style type="text/css">
  #span_package_price{
    font-weight: bold;
    background: #0088cc;
    padding: 5px;
    color: #ffffff;
    border-radius: 25px;
  }
</style>

<section class="body-sign">
  <div class="center-sign">

    <div class="panel panel-sign">
      <div class="panel-title-sign mt-xl text-right">
        <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Upgrade your Package</h2>
      </div>
      <div class="panel-body">
        <?php if(validation_errors()!=""){?>
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?php echo validation_errors(); ?>
        </div>
        <?php } ?>
        <?php if($this->session->flashdata("error")){ ?>
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?php echo $this->session->flashdata("error");?>
        </div>
        <?php
      }
      ?>
<form id="form" method="post" action="<?php echo current_url();?>"  class="form-horizontal form-bordered" novalidate="novalidate">




 <div class="form-group mb-lg">
  <label>Package</label>
  <select name="package" id="package" data-plugin-selectTwo class="form-control " required>
    <option value="">Select</option>
    <?php
    foreach ($packages as $row) {
      ?>
      <option value="<?php echo $row->package_id;?>"><?php echo $row->name;?></option>
      <?php
    }
    ?>
  </select>
</div>

<div class="form-group mb-lg">
  <label>Order Term</label>
  <select name="order_term" id="order_term" data-plugin-selectTwo class="form-control " required>
    <option value="">Select</option>
  </select>
</div>

<div class="form-group mb-lg div_price" style="display:none;">
  <label>Package Price: &nbsp;</label>
  <input type="hidden" name="txt_package_price" id="txt_package_price" value="">
  <span id="span_package_price" >-</span>
</div>


<div class="form-group mb-lg">
  <strong>Select Payment Type</strong>
</div>

<div class="form-group">

  <div class="col-md-3">
    <input type="radio" name="paymethod" value="stripe" id="stripepayment" class="payment-radio-class"  required  />
    <img src="<?php echo base_url("assets/images/");?>/payment-icon.jpg" style="width:60%" >
  </div>
 
<?php 
if($this->mylibrary->getSiteEmail(75) == 1){
  ?>
  <div class="col-md-3 ">
   <input type="radio" name="paymethod"  class="payment-radio-class" value="bank" id="banktransfer" required />
   <img src="<?php echo base_url("assets/images/");?>/bank-transfer.gif">
 </div>
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
      <input type="text"  value="" id="card_name" name="card_name" placeholder="Enter Your Card Name" class="form-control " required>
    </div>

  </div>

  <div class="form-group">
   <label class="col-md-4 control-label">Card Number *</label>
   <div class="col-md-8 ">
     <input type="text"  value="" id="card_number" name="card_number" data-stripe="number" placeholder="Enter Your Card Number" class="form-control " required>
   </div>

 </div>

 <div class="form-group">
   <label class="col-md-4 control-label">Expiry Date *</label>
   <div class="col-md-4 ">
     <select name="expiry_month" class="form-control " data-plugin-selectTwo data-stripe="exp_month" required>
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
   <select name="expiry_year" class="form-control " data-plugin-selectTwo data-stripe="exp_year" required>
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
  <input type="text"  value="" id="ccv" name="ccv" placeholder="Enter CCV" data-stripe="cvc" class="form-control" required>
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

<script type="text/javascript">
  $(document).ready(function(){
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
      if(price > discountprice && discountprice > 0)
        var price1 = discountprice;
      else
        var price1 = price;
      $("#span_package_price").html('AUD '+price1);
      $("#txt_package_price").val(price1);
      $(".div_price").show();
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
