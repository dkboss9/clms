


<?php 
if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
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

        <h2 class="panel-title">Budget Type : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("budget_type/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Category</label>
            <div class="col-md-6">
              <select name="parent" id="parent" data-plugin-selectTwo class="form-control">
               <option value="">Select</option>
               <option value="1">Income</option>
               <?php 
               
               $cats1 = $this->budget_typemodel->listall(1);
               foreach ($cats1->result() as $cat1) {
                ?>
                <option value="<?php echo $cat1->type_id;?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cat1->type_name;?></option>
                <?php
              }
              ?>
              <option value="2">Expense</option>
              <?php 

              $cats1 = $this->budget_typemodel->listall(2);
              foreach ($cats1->result() as $cat1) {
                ?>
                <option value="<?php echo $cat1->type_id;?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cat1->type_name;?></option>
                <?php
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
