
<script type="text/javascript">
  window.onload = function(){
    CKEDITOR.replace('newsletter_description');
  };
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

        <h2 class="panel-title">Newsletter : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("newsletter/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Title</label>
            <div class="col-md-6">
              <input type="text" name="newsletter_title" value="<?php echo $result->newsletter_title; ?>"  class="form-control" id="newsletter_title" required>
              <?php echo form_error("name");?>
            </div>
          </div>



          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Message</label>
            <div class="col-md-9">
             <textarea name="newsletter_description" id="newsletter_description" class="form-control input-sm"><?php echo $result->newsletter_description; ?></textarea>
           </div>
         </div>

         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Status</label>
          <div class="col-md-6">
            <select name="status" class="form-control input-sm" >
              <option value="1" <?php if($result->status == '1'){ echo 'selected';} ?>>Active</option>
              <option value="0" <?php if($result->status == '0'){ echo 'selected';} ?>>Inactive</option>
            </select>
          </div>
        </div>


        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault"></label>
          <div class="col-md-6">
            <input type="hidden" name="id" id="id" value="<?php echo $result->newsletter_id; ?>" />
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
