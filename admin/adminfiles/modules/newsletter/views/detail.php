



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Newsletter : [Detail]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("newsletter/send");?>" method="post" enctype='multipart/form-data'>
          <input type="hidden" name="id" id="id" value="<?php echo $result->newsletter_id; ?>" />
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Title</label>
            <div class="col-md-6">
              <?php echo $result->newsletter_title;?>
            </div>
          </div>



          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Message</label>
            <div class="col-md-9">
             <?php echo $result->newsletter_description; ?> 
           </div>
         </div>

         <div class="form-group">
           <table cellpadding="5" cellspacing="0" border="0" width="100%" class="table-tab">
            <tbody>
              <tr>
                <td width="15%"><label for="newsletter_title">Send To</label></td>
                <td><input type="radio" name="rdorec" id="rdorec_all" class="rdorec" value="0" checked="checked">
                  All Subscribers
                  <input type="radio" name="rdorec" id="rdorec_one" class="rdorec" value="1">
                  Single Subscriber
                  <input type="radio" name="rdorec" id="rdorec_multiple" class="rdorec" value="2">
                  Mulitple Subscribers
                  <input type="radio" name="rdorec" id="rdorec_company" class="rdorec" value="2">
                  Alms Members
                  <div id="multiple_subscriber" style="display:none;"> <?php echo $this->subscribermodel->listSubscriberCheckBox();?> </div>
                  <div id="multiple_company" style="display:none;">
                    <input type="checkbox" name="sales_rep" id="sales_rep" value="">
                    <span style="font-weight:bold;">Sales Reps</span></br>
                    <?php echo $this->subscribermodel->listUsers(3);?> 
                  </br><div style="clear:both;"></div>
                  <input type="checkbox" name="customers" id="customers" value="">
                  <span style="font-weight:bold;">Customers </span></br>
                  <?php echo $this->subscribermodel->listCustomers();?>
                </br><div style="clear:both;"></div>
                <input type="checkbox" name="emp" id="emp" value="">
                <span style="font-weight:bold;"> Employees </span></br>
                <?php echo $this->subscribermodel->listUsers(9);?>
              </br><div style="clear:both;"></div>
              <input type="checkbox" name="supplier" id="supplier" value="">
              <span style="font-weight:bold;"> Suppliers </span></br>
              <?php echo $this->subscribermodel->listUsers(10);?>
              <?php if($this->session->userdata("usergroup") == 1){?>
            </br><div style="clear:both;"></div>
            <input type="checkbox" name="company" id="company" value="">
            <span style="font-weight:bold;"> Companies </span></br>
            <?php echo $this->subscribermodel->listUsers(7);?>
            <?php } ?>
          </div>
          <div id="individual_subscriber" style="display:none;">
            <select name="selected_subscriber" class="form-control input-sm">
              <option value="">[Select Subscriber]</option>
              <?php echo $this->subscribermodel->listSubscriberDropDown();?>
            </select>
          </div></td>
        </tr>
        <tr>
          <td valign="top"><label for="custom_emails">Custom Emails </label></td>
          <td><textarea name="custom_emails" id="custom_emails"class="form-control input-sm"></textarea></td>
        </tr>
      </tbody>
    </table>
  </div>


  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault"></label>
    <div class="col-md-6">
      <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
      <a href="<?php echo base_url("newsletter");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
<script>
  //if ($("#rdorec_one").is(':checked')) 
  $(function () {
    $("#sales_rep").click(function(){
      $('.check_3').not(this).prop('checked', this.checked);
    });
    $("#customers").click(function(){
      $('.customers').not(this).prop('checked', this.checked);
    });
    $("#emp").click(function(){
      $('.check_9').not(this).prop('checked', this.checked);
    });
    $("#supplier").click(function(){
      $('.check_10').not(this).prop('checked', this.checked);
    });
    $("#company").click(function(){
      $('.check_7').not(this).prop('checked', this.checked);
    });
    $("input#rdorec_one").click(function () {
      $("#individual_subscriber").show();
      $("#multiple_subscriber").hide();
      $("#multiple_company").hide();
    });
    $("input#rdorec_multiple").click(function () {
      $("#individual_subscriber").hide();
      $("#multiple_company").hide();
      $("#multiple_subscriber").show();
    });
    $("input#rdorec_company").click(function () {
      $("#individual_subscriber").hide();
      $("#multiple_subscriber").hide();
      $("#multiple_company").show();
    });
    $("input#rdorec_all").click(function () {
      $("#individual_subscriber").hide();
      $("#multiple_subscriber").hide();
      $("#multiple_company").hide();
    });
  });
</script> 
