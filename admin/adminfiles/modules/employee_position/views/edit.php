


<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Employee Position : [Edit]</h2>
      </header>
      <div class="panel-body">
      <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("employee_position/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Level</label>
            <div class="col-md-6">
              <input type="text" name="name" value="<?php echo $result->position_title;?>"  class="form-control" id="inputDefault" required>
              <?php echo form_error("name");?>
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="hidden" name="position_id" value="<?php echo $result->position_id;?>">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("employee_position");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
