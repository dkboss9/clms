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
      $("#email_address").keyup(function() {
       var email_address = $("#email_address").val();
       if(checkEmail(email_address)){        
         $.post("<?php echo base_url();?>index.php/subscribers/validateemail", {email_address:email_address},
           function(result) {
             if(result == 1) {
              $("#emailError").html("This email is already registered");
              $("#validemail").val('0');
            }
            else {

              $("#emailError").html('');
              $("#validemail").val('1');
            }
          });
       }
     });

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

        <h2 class="panel-title">Subscriber : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("subscribers/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>
          <input type="hidden" name="validemail" id="validemail" value="" required/>
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Email Address</label>
            <div class="col-md-6">
             <input type="text" name="email_address" id="email_address" value="" class="form-control input-sm" required />
             <span class="emailError" id="emailError" style="color:red;"></span>
           </div>
         </div>



         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Name</label>
          <div class="col-md-6">
           <input type="text" name="name" id="name" value="" class="form-control input-sm" required />
         </div>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Subscription Date</label>
        <div class="col-md-6">
         <input type="text" name="subscription_date" id="subscription_date" value="" class="form-control input-sm" required />
       </div>
     </div>

     <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Status</label>
      <div class="col-md-6">
        <select name="status" class="form-control input-sm"  required>
          <option value="">[Select Status]</option>
          <option value="1">Subscribe</option>
          <option value="0">Unsubscribe</option>
        </select>
      </div>
    </div>


    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault"></label>
      <div class="col-md-6">
        <input type="submit" name="submit" id="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
        <a href="<?php echo base_url("subscribers");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
