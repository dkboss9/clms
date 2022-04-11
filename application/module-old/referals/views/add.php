
<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
          <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Referal : [New]</h2>
      </header>
      <div class="panel-body">
       <form action="<?php echo base_url("referals/add");?>" method="post">
        <div class="alert alert-danger" id="error-message" style="display:none;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?php 
          if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
            ?>
            <strong>We must tell you! </strong> Please select clms_company to add this data.
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
           <input type="hidden" name="role" id="role" value="9">
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
      if($row->type_id == 3){
        $rate = $company->referral_company_asign_rate;
        $is_percent = $company->is_referral_company_asign_rate_percentage;
      }else{
        $rate = $company->referral_self_asign_rate;
        $is_percent = $company->is_referral_self_asign_rate_percentage;
      }
      ?>
      <div class="form-group">
        <label class="col-md-3 control-label"><?php echo $row->type_name;?> Rate</label>
        <div class="col-md-6">
          <input type="number" name="rate[]"  value="<?php echo @$rate;?>" class="form-control txt_rate " />
          <input type="hidden" name="type[]" value="<?php echo $row->type_id;?>">
        </div>
        <div class="col-md-3">
          <input type="checkbox" name="is_percent[]" value="1" <?php echo  @$is_percent == 1 ? 'checked="checked"':'';?> class="is_percent" /> Is percentage
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
    <label class="col-md-3 control-label">Password</label>
    <div class="col-md-6">
     <input type="password" name="password" id="password" class="form-control" required />
   </div>
 </div>

 <div class="form-group">
  <label class="col-md-3 control-label">Confirm Password</label>
  <div class="col-md-6">
   <input type="password" name="cpassword" id="cpassword" class="form-control" required />
 </div>
</div>



<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("referals");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
