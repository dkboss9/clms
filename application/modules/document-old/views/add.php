<script type="text/javascript">

  window.onload = function(){
    //CKEDITOR.replace('details');
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

          <h2 class="panel-title">Document : [New]</h2>
        </header>
        <div class="panel-body">
          <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("document/add");?>" method="post" enctype='multipart/form-data'>
            <?php if(isset($error)){ ?>
            <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </div>
            <?php  } ?>


            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Name</label>
              <div class="col-md-6">
                <input type="text" name="name" value=""  class="form-control" id="inputDefault" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="details">Details</label>
              <div class="col-md-9">
                <textarea name="details" id="details" class="form-control" required></textarea>
              </div>
            </div>



            <div class="form-group">
            <label class="col-md-3 control-label" for="list_image">Document</label>
              <div class="col-md-6">
                <input type="file" name="list_image" id="list_image" class="form-control doccuments"  > 
              </div>
            </div>







            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault"></label>
              <div class="col-md-6">
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
