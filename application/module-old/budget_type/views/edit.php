



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Budget Type : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("budget_type/edit");?>" method="post" enctype='multipart/form-data'>
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Parent</label>
            <div class="col-md-6">

              <select name="parent" id="parent" data-plugin-selectTwo class="form-control">
               <option value="">Select</option>
               <option value="1" <?php if($result->parent_id == 1) echo 'selected="selected"'; ?>>Income</option>
               <?php 
               
               $cats1 = $this->budget_typemodel->listall(1);
               foreach ($cats1->result() as $cat1) {
                ?>
                <option <?php if($result->parent_id == $cat1->type_id) echo 'selected="selected"'; ?> value="<?php echo $cat1->type_id;?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cat1->type_name;?></option>
                <?php
              }
              ?>
              <option <?php if($result->parent_id == 2) echo 'selected="selected"'; ?> value="2">Expense</option>
              <?php 

              $cats1 = $this->budget_typemodel->listall(2);
              foreach ($cats1->result() as $cat1) {
                ?>
                <option <?php if($result->parent_id == $cat1->type_id) echo 'selected="selected"'; ?> value="<?php echo $cat1->type_id;?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cat1->type_name;?></option>
                <?php
              }
              ?>

            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Name</label>
          <div class="col-md-6">
            <input type="text" name="name" value="<?php echo $result->type_name;?>"  class="form-control" id="inputDefault" required>
            <?php echo form_error("name");?>
          </div>
        </div>


        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault"></label>
          <div class="col-md-6">
            <input type="hidden" name="cat_id" value="<?php echo $result->type_id;?>">
            <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
            <a href="<?php echo base_url("budget_type");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
