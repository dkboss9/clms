


<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Enquiry package : [Edit]</h2>
      </header>
      <div class="panel-body">
      <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("enquiry_subscription/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Credits</label>
            <div class="col-md-6">
              <input type="number" name="credits" value="<?php echo $result->credits;?>"  class="form-control" id="inputDefault" required>
              <?php echo form_error("credits");?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="email">Price</label>
            <div class="col-md-6">
              <input type="number" name="price" value="<?php echo $result->price;?>"  class="form-control" id="email" required>
              <?php echo form_error("price");?>
            </div>
          </div>

       

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="hidden" name="status_id" value="<?php echo $result->id;?>">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("chat_id");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
