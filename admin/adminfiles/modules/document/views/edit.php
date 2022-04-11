<script type="text/javascript">

  window.onload = function(){
  //  CKEDITOR.replace('details');
};
</script>
<!-- start: page -->


  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <div class="panel-actions">
            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
            <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
          </div>

          <h2 class="panel-title">Document : [New]</h2>
        </header>
        <div class="panel-body">
          <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("document/edit");?>" method="post" enctype='multipart/form-data'>
            <?php if(isset($error)){ ?>
            <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </div>
            <?php  } ?>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Name</label>
              <div class="col-md-6">
                <input type="text" name="name" value="<?php echo $result->name;?>"  class="form-control" id="inputDefault" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="details">Details</label>
              <div class="col-md-6">
                <textarea name="details" id="details" class="form-control" required><?php echo $result->content;?></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label" for="list_image">Document</label>
              <div class="col-md-6">
                <?php if($result->image != "" && file_exists("../uploads/document/".$result->image)) echo '<a href="'.SITE_URL."uploads/document/".$result->image.'" target="_blank">'.$result->image.'</a>';?>
              </div>
            </div>


            <div class="form-group">
              <label class="col-md-3 control-label" for="list_image">Replace Image</label>
              <div class="col-md-6">
                <input type="file" name="list_image" id="list_image" class="form-control doccuments" > 
              </div>
            </div>







            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault"></label>
              <div class="col-md-6">
                <input type="hidden" name="content_id" value="<?php echo $result->content_id;?>">
                <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
                <a href="<?php echo base_url("document");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
