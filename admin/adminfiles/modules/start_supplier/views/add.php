



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Supplier : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("start_supplier/add");?>" method="post" enctype='multipart/form-data'>




          <div class="form-group">
            <label class="col-md-2 control-label" for="name">Name</label>
            <div class="col-md-3">
              <input type="text" name="name"  value=""  class="form-control" id="name" required>
            </div>

            <label class="col-md-3 control-label" for="name">Company Name</label>
            <div class="col-md-3">
              <input type="text" name="company_name"  value=""  class="form-control" id="company_name" required>
            </div>
          </div>

          <div class="form-group">
          <label class="col-md-2 control-label" for="email">Email</label>
            <div class="col-md-3">
              <input type="email" name="email" value=""  class="form-control" id="email" required>
            </div>
            <label class="col-md-3 control-label" for="phone">Landline no </label>
            <div class="col-md-3">
              <input type="number" name="phone"  value=""  class="form-control" id="phone" required>
            </div>

          </div>


          <div class="form-group">
            <label class="col-md-2 control-label" for="address">Location</label>
            <div class="col-md-3">
              <input type="text" name="address"  value=""  class="form-control" id="address" required>
            </div>

            <label class="col-md-3 control-label" for="product">Product / Service</label>
            <div class="col-md-3">
              <input type="text" name="product"  value=""  class="form-control" id="product" required>
            </div>
          
            
          </div>

          <div class="form-group">
            <label class="col-md-2 control-label" for="share">Created by</label>
            <div class="col-md-3">
              <select name="staff" class="form-control" id="consultant" data-plugin-selectTwo required>
                <option value="">Select</option>
                <?php 
                    foreach($counselers as $user){
                      ?>
                        <option value="<?php echo $user->id;?>"><?php echo $user->first_name;?> <?php echo $user->last_name;?></option>
                      <?php
                    }
                ?>
              </select>
            </div>

            <div class="col-md-1">
              <a href="javascript:void(0);" id="link_consultant"><i class="glyphicon glyphicon-plus"></i></a>
            </div>
          

            <label class="col-md-2 control-label" for="action">  Action</label>
            <div class="col-md-3">
              <select name="action" class="form-control" data-plugin-selectTwo id="action">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
          </div>
          </div>
        

       


          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("start_supplier");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
<?php 
$this->load->view("lms/add_purpose");
?>
<script type="text/javascript">
    $(document).ready(function(){
      $("#link_consultant").click(function(){ 
      $("#form_consultant_model").modal();
    });
    });
  </script>