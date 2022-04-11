<script type="text/javascript">
  $(document).ready(function(){
   // $('.alert-danger').hide();
   <?php if($this->session->flashdata('error')){?>
    $(".alert-danger").show();
    $(".alert-danger").html('<?php echo $this->session->flashdata('error');?>');
    $(".alert-danger").delay(4000).slideUp('slow',function(){
      $(".alert-danger").html('');
    });
    <?php } ?>

    $("#submit").click(function(){
     if($("#validemail").val()=='0'){
       $("#email").addClass('errorfield');
     }

   });
    $('#email_address').attr('autocomplete', 'off');
    
  });
  function checkEmail(sEmail){
   var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
   if (filter.test(sEmail)) {
    return true;
  }
  else {
    return false;
  }
}  
</script>

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

        <h2 class="panel-title"> Subscriber : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("sms_subscribers/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Mobile Number</label>
            <div class="col-md-6">
             <input type="text" name="mobile_number" id="mobile_number" value="<?php echo set_value("mobile_number");?>" class="form-control input-sm" required />
             <span class="emailError" id="emailError" style="color:red;"><?php echo form_error("mobile_number");?></span>
           </div>
         </div>

         <input type="hidden" name="validemail" id="validemail" value="" />
         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Email Address</label>
          <div class="col-md-6">
           <input type="email" name="email_address" id="email_address" value="<?php echo set_value("email_address");?>" class="form-control input-sm"  />
           <span class="emailError" id="emailError" style="color:red;"></span>
         </div>
       </div>



       <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Name</label>
        <div class="col-md-6">
         <input type="text" name="name" id="name" value="<?php echo set_value("name");?>" class="form-control input-sm" required />
       </div>
     </div>

   <!--   <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Subscription Date</label>
      <div class="col-md-6">
       <input type="text" name="subscription_date" id="subscription_date" value="" class="form-control input-sm" required />
     </div>
   </div> -->

   <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Status</label>
    <div class="col-md-6">
      <select name="status" class="form-control input-sm"  required>

        <option value="1" <?php if(set_value("status") == 1) echo 'selected="selected"'; ?>>Subscribe</option>
        <option value="0" <?php //if(set_value("status") == 0) echo 'selected="selected"'; ?>>Unsubscribe</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault"></label>
    <div class="col-md-6">
     <input type="checkbox" name="newsletter_subscribe" id="newsletter_subscribe" value="1" <?php if(set_value("newsletter_subscribe") == 1) echo 'checked="checked"';?>> Add to Newsletter Subscriber
   </div>
 </div>

 <div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="submit" name="submit" id="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("sms_subscribers");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
    $("#newsletter_subscribe").click(function(){
      if($(this).prop("checked")){
        $("#email_address").addClass("required");
      }
      else{
        $("#email_address").removeClass("required");
       // $("#email_address").removeClass("has-error");
     }
   });
  });
</script>
