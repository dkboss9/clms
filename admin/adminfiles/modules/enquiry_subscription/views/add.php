



<?php 
if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
  ?>
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>We must tell you! </strong> Please select company to add this data.
  </div>
  <?php
}
?>

<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Enquriy Package Subscription : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("enquiry_subscription/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>
          
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Credits</label>
            <div class="col-md-6">
             <select name="credits" id="credits" class="form-control " required>
              <option value="">Select</option>
              <?php
              foreach ($credits->result() as $row) {
                ?>
                <option value="<?php echo $row->credits;?>" price="<?php echo $row->price;?>"><?php echo $row->credits;?> Credits</option>
                <?php
              }
              ?>
            </select>
            <?php echo form_error("credits");?>
          </div>
        </div>

        <div class="form-group div_price" style="display:none;">
          <label class="col-md-3 control-label" for="email">Package Price</label>
          <div class="col-md-6">
            <input type="hidden" name="txt_package_price" id="txt_package_price" value="">
            <span id="span_package_price" >-</span>
          </div>
        </div>

        <div class="form-group div_price" >
          <label class="col-md-3 control-label" for="email">Select Payment Type</label>
          <div class="col-md-6">
           <?php 
           if($this->mylibrary->getSiteEmail(81) == 1){
            ?>

            <div class="col-md-5">
             <input type="radio" name="paymethod" value="eway" id="ewaypayment" class="payment-radio-class" checked="checked" required  />
             <img src="<?php echo base_url("assets/images/");?>/payment-icon.jpg" style="width:80%" >
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
          <div class="col-md-4 ">
           <input type="radio" name="paymethod"  class="payment-radio-class" value="paypal" id="paypal">
           <img src="<?php echo base_url("assets/images/");?>/paypal.png" width="80">
         </div>
         <?php } ?>
       </div>
     </div>

     <?php 
     if($this->mylibrary->getSiteEmail(81) == 1){
      ?>
      <div id="div_eway"  >
       <div class="form-group">
         <label class="col-md-3 control-label">Card Name *</label>
         <div class="col-md-6 ">
          <input type="text"  value="" id="card_name" name="card_name" placeholder="Enter Your Card Name" class="form-control required" >
        </div>

      </div>

      <div class="form-group">
       <label class="col-md-3 control-label">Card Number *</label>
       <div class="col-md-6 ">
         <input type="text"  value="" id="card_number" name="card_number" placeholder="Enter Your Card Number" class="form-control required" >
       </div>

     </div>

     <div class="form-group">
       <label class="col-md-3 control-label">Expiry Date *</label>
       <div class="col-md-3 ">
         <select name="expiry_month" class="form-control required" >
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
      <div class="col-md-3 ">
       <select name="expiry_year" class="form-control required" >
        <option value="">Year</option>
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
   <label class="col-md-3 control-label">CVV*</label>
   <div class="col-md-4 ">
    <input type="text"  value="" id="ccv" name="ccv" placeholder="Enter CCV" class="form-control required" >
  </div>

</div>


</div>
<?php } ?>

<?php 
if($this->mylibrary->getSiteEmail(75) == 1){
  ?>
  <div class="icon-border" id="div_bank" style="display:none;">
    <div class="form-group">
       <div class="col-md-3 "></div>
      <div class="col-md-9 ">
       AusNep Group Pty Ltd.<br/>BSB: 062 475 <br/>A/C No.: 1009 5913<br/>  Common Wealth Bank
     </div>
   </div>
 </div>
 <?php } ?>




 <div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("enquiry_subscription");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
  </div>
</div>
</form>
</div>
</section>
</div>
</div>
<!-- end: page -->
</section>
</div>
</section>

<script type="text/javascript">
  $(document).ready(function(){
    $("#credits").change(function(){
      var package_id = $(this).val();
      if(package_id == "")
        return false;
      var price1 = $('option:selected', this).attr('price'); 
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

      if ($(this).val() == 'eway'){
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
