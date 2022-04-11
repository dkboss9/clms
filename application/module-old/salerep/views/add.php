<script type="text/javascript">
  $(document).ready(function(){
    $("#error-message").hide();
    $("#success-message").hide();
  });
  function addUser(){
    var rate = "";
    $(".txt_rate").each(function(){
      rate+=$(this).attr("id")+':'+$(this).val()+',';
    });
    //console.log(rate);
   // return false;
   var role   = $("#role").val();
   var fname    = $("#fname").val();
   var lname    = $("#lname").val(); 
   var email    = $("#email").val();
   var rate1    = $("#rate1").val();
   var rate2    = $("#rate2").val();
   var phone    = $("#phone").val();
 
   $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>index.php/salerep/add",
    data: "fname="+fname+"&lname="+lname+"&email="+email+"&phone="+phone+"&rate="+rate+"&role="+role+"&action=submit",
    success: function (msg) {
      if(msg=='yes'){
        $("#success-message").show();
        $("#success-message").html('User added successfully');
        $(".txt_rate").each(function(){
          $(this).val("");
        });
        $("#success-message").delay(4000).slideUp('slow',function(){
          $("#success-message").html('');

        });
        $("#fname").val('');  
        $("#lname").val('');  
        $("#cpassword").val('');  
        $("#email").val('');
        $("#password").val(''); 
        $("#username").val('');
        $("#rate1").val('');     
        $("#rate2").val('');  
        $("#phone").val('');     

      }else{
        $("#error-message").show();
        $("#error-message").html(msg);
        $("#error-message").delay(5000).slideUp('slow',function(){
          $("#error-message").html('');
        });

      }
    }
  });
}
</script>



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Sales Rep : [New]</h2>
      </header>
      <div class="panel-body">
       <form action="javascript:addUser()">
        <div class="alert alert-danger" id="error-message" style="display:none;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?php 
          if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
            ?>
            <strong>We must tell you! </strong> Please select company to add this data.
            <?php
          }
          ?>
        </div>

        <div class="alert alert-success" id="success-message" style="display:none;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>


        <div class="form-group">
          <label class="col-md-3 control-label" for="fname">First Name</label>
          <div class="col-md-6">
           <input type="text" name="fname" id="fname" class="form-control" required />
           <input type="hidden" name="role" id="role" value="3">
         </div>
       </div>

       <div class="form-group">
         <label class="col-md-3 control-label" for="lname">Last Name</label>
         <div class="col-md-6">
          <input type="text" name="lname" id="lname" class="form-control" required />
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Email</label>
        <div class="col-md-6">
         <input type="email" name="email" id="email" class="form-control"  required/>
       </div>
     </div>

     <?php
     foreach ($lead_types as $row) {
      ?>
      <div class="form-group">
        <label class="col-md-3 control-label"><?php echo $row->type_name;?> Rate</label>
        <div class="col-md-6">
          <input type="text" name="rate[]" id="<?php echo $row->type_id;?>" class="form-control txt_rate" />
        </div>
      </div>

      <?php
    }
    ?>

    <div class="form-group">
      <label class="col-md-3 control-label">Phone</label>
      <div class="col-md-6">
       <input type="text" name="phone" id="phone" class="form-control" />
     </div>
   </div>

  



<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("salerep");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
