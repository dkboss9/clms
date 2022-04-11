


<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Announcement : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("announcement/edit");?>" method="post" enctype='multipart/form-data'>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Title</label>
            <div class="col-md-6">
              <input type="text" name="name" value="<?php echo $result->title; ?>"  class="form-control" id="inputDefault" required>
              <?php echo form_error("name");?>
            </div>
          </div>

          <div class="form-group">
           <label class="col-md-3 control-label">Content</label>
           <div class="col-md-9">
            <textarea name="details"   class="form-control" rows="8" required><?php echo $result->content; ?></textarea>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label">Announcement Date</label>
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </span>
              <input type="text" data-plugin-datepicker="" value="<?php echo date("d/m/Y",$result->announcement_date); ?>" name="date" required class="form-control">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault"></label>
          <div class="col-md-6">
            <input type="hidden" name="announcement_id" value="<?php echo $result->announcement_id;?>">
            <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
            <a href="<?php echo base_url("announcement");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
