



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">intake : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("intake/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>



          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Name</label>
            <div class="col-md-6">
              <input type="text" name="name" value="<?php echo $result->type_name;?>"  class="form-control" id="inputDefault" required>
              <?php echo form_error("name");?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Description</label>
            <div class="col-md-6">
              <textarea name="txt_desc" class="form-control" ><?php echo $result->intake_desc;?></textarea>
            </div>
          </div>

          <?php
          if($result->intake_start_date == '0000-00-00')
            $start_date = '';
          else
            $start_date = date("d/m/Y",strtotime($result->intake_start_date));
          ?>
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Form Submit Start Date</label>
            <div class="col-md-6">
              <input type="text" data-plugin-datepicker="" name="start_date" value="<?php echo $start_date;?>"  class="form-control" id="inputDefault" required>
            </div>
          </div>
          <?php
          if($result->intake_end_date == '0000-00-00')
            $end_date = '';
          else
            $end_date = date("d/m/Y",strtotime($result->intake_end_date));
          ?>
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Form Submit End Date</label>
            <div class="col-md-6">
              <input type="text" data-plugin-datepicker="" name="end_date" value="<?php echo $end_date;?>"  class="form-control" id="inputDefault" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="hidden" name="type_id" value="<?php echo $result->type_id;?>">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("intake");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
