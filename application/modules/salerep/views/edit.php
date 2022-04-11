


<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Sales Rep : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("salerep/edit");?>" method="post" enctype='multipart/form-data'>
         <input type="hidden" name="userid" id="userid" value="<?php echo $result->id;?>" />

         <div class="form-group">
          <label class="col-md-3 control-label" for="fname">First Name</label>
          <div class="col-md-6">
            <input type="text" name="fname" id="fname" value="<?php echo $result->first_name;?>" class="form-control" required />
            <input type="hidden" name="role" id="role" value="3">
          </div>
        </div>

        <div class="form-group">
         <label class="col-md-3 control-label" for="lname">Last Name</label>
         <div class="col-md-6">
          <input type="text" name="lname" id="lname" class="form-control" value="<?php echo $result->last_name;?>"  required />
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Email</label>
        <div class="col-md-6">
         <input type="email" name="email" id="email" class="form-control" value="<?php echo $result->email;?>"  required/>
       </div>
     </div>

     <?php
     foreach ($lead_types as $row) {
      $rate = $this->salerepmodel->getRate($result->id,$row->type_id);
      ?>
      <div class="form-group">
        <label class="col-md-3 control-label"><?php echo $row->type_name;?> Rate</label>
        <div class="col-md-6">
          <input type="text" name="rate[]" id="<?php echo $row->type_id;?>" value="<?php echo @$rate->rate;?>" class="form-control txt_rate" />
          <input type="hidden" name="type_id[]" value="<?php echo $row->type_id;?>">
        </div>
      </div>

      <?php
    }
    ?>

    <div class="form-group">
      <label class="col-md-3 control-label">Phone</label>
      <div class="col-md-6">
       <input type="text" name="phone" id="phone" value="<?php echo $result->phone;?>"  class="form-control" />
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
