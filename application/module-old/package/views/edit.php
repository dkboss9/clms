


<?php 
if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
  ?>
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>We must tell you! </strong> Please select company to add this data.
  </div>
  <?php
}
?>
<!-- package: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Package : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("package/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label">Package Type</label>
            <div class="col-md-6">
              <div class="input-group">

                <?php 
                foreach ($types as $row) {
                  $num = $this->packagemodel->get_packageid($result->package_id,$row->type_id);
                  ?>
                  <div class="checkbox-custom checkbox-primary">
                    <input type="checkbox" value="<?php echo $row->type_id;?>" name="type[]" <?php if($num > 0) echo 'checked="checked"';?> required>
                    <label for="checkboxExample2"><?php echo $row->title; ?></label>
                  </div>
                  <?php
                }
                ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="name">Name</label>
            <div class="col-md-6">
              <input type="text" name="name" value="<?php echo $result->package_name;?>"  class="form-control" id="name" required>
              <?php echo form_error("name");?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="price">Price</label>
            <div class="col-md-6">
              <input type="text" name="price" value="<?php echo $result->price;?>"  class="form-control" id="price" required>

            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Color Code</label>
            <div class="col-md-6">
              <input type="text" data-plugin-colorpicker="" name="code" class="colorpicker-default form-control colorpicker-element" value="<?php echo $result->color;?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Payment Time</label>
            <div class="col-md-6">
              <select name="payment_time" data-plugin-selectTwo class="form-control" required>
                <option value="">Select</option>
                <?php
                foreach ($payment_times as $time) {
                  ?>
                  <option value="<?php echo $time->id;?>" <?php if($time->id == $result->payment_time) echo 'selected="selected"';?>><?php echo $time->title;?></option>
                  <?php
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="hidden" name="package_id" value="<?php echo $result->package_id;?>">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("package");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
