



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Doc Type : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("doc_type/add");?>" method="post" enctype='multipart/form-data'>

        <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Visa</label>
            <div class="col-md-6">
              <select name="category" id="category" class="form-control" required >
                <option value="">Select</option>
                <?php
                foreach($categories as $cat){
                  ?>
                   <option value="<?php echo $cat->type_id;?>"><?php echo $cat->type_name;?></option>
                  <?php 
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Doc Type</label>
            <div class="col-md-6">
              <input type="text" name="name" value=""  class="form-control" id="inputDefault" required>
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("doc_type");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
