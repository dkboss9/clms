


<!-- start: page -->
<?php 
if($result->type_id == 14 || $result->type_id == 28){
  $disabled = true;
}else{
  $disabled = false;
}
?>
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">visa : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("visa/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Categories</label>
            <div class="col-md-6">
              <select name="category" id="category" class="form-control" required <?php echo $disabled ? 'disabled':'';?>>
                <option value="">Select</option>
                <?php
                foreach($categories as $cat){
                  ?>
                   <option value="<?php echo $cat->type_id;?>" <?php echo $result->cat_id == $cat->type_id ? 'selected':"";?>><?php echo $cat->type_name;?></option>
                  <?php 
                }
                ?>
              </select>
            </div>
          </div>
         

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Name</label>
            <div class="col-md-6">
              <input type="text" name="name" value="<?php echo $result->type_name;?>"  class="form-control" id="inputDefault" required <?php echo $disabled ? 'disabled':'';?>>
              <?php echo form_error("name");?>
            </div>
          </div>

          <?php
          if($disabled){
          ?>
            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Collected Points</label>
              <div class="col-md-6">
              <input type="number" min="0" class="form-control" name="collected_points" id="collected_points" value="<?php echo $point->points??0;?>">
              </div>
            </div>
            <?php 
            }
            ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="hidden" name="type_id" value="<?php echo $result->type_id;?>">
              <input type="hidden" name="disabled" value="<?php echo $disabled ? '1':'0';?>">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("visa");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
