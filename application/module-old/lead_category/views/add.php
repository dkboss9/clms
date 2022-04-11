


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
<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Lead Category : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("lead_category/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Category</label>
            <div class="col-md-6">
              <select name="parent" id="parent" class="form-control">
               <option value="">Select</option>
               <?php 
               foreach ($categories->result() as $cat) {
                ?>
                <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
                <?php
                $cats1 = $this->lead_categorymodel->listall($cat->cat_id);
                foreach ($cats1->result() as $cat1) {
                  ?>
                  <option value="<?php echo $cat1->cat_id;?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cat1->cat_name;?></option>
                  <?php
                  $cats2 = $this->lead_categorymodel->listall($cat1->cat_id);
                  foreach ($cats2->result() as $cat2) {
                    ?>
                    <option value="<?php echo $cat2->cat_id;?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cat2->cat_name;?></option>
                    <?php
                    $cats3 = $this->lead_categorymodel->listall($cat2->cat_id);
                    foreach ($cats3->result() as $cat3) {
                      ?>
                      <option value="<?php echo $cat3->cat_id;?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cat3->cat_name;?></option>
                      <?php
                    }
                    
                  }
                }

              }
              ?>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Name</label>
          <div class="col-md-6">
            <input type="text" name="name" value=""  class="form-control" id="inputDefault" required>
            <?php echo form_error("name");?>
          </div>
        </div>




        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault"></label>
          <div class="col-md-6">
            <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
            <a href="<?php echo base_url("lead_category");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
