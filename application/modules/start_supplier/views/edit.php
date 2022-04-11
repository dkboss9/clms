



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Supplier : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>




          <div class="form-group">
            <label class="col-md-2 control-label" for="name">Name</label>
            <div class="col-md-3">
              <input type="text" name="name"  value="<?php echo $result->name;?>"  class="form-control" id="name" required>
            </div>

            <label class="col-md-3 control-label" for="name">Company Name</label>
            <div class="col-md-3">
              <input type="text" name="company_name"  value="<?php echo $result->company_name;?>"  class="form-control" id="company_name" required>
            </div>
          </div>

          <div class="form-group">
          <label class="col-md-2 control-label" for="email">Email</label>
            <div class="col-md-3">
              <input type="email" name="email" value="<?php echo $result->email;?>"  class="form-control" id="email" required>
            </div>
            <label class="col-md-3 control-label" for="phone">Landline no </label>
            <div class="col-md-3">
              <input type="number" name="phone"  value="<?php echo $result->phone;?>"  class="form-control" id="phone" required>
            </div>

          </div>


          <div class="form-group">
            <label class="col-md-2 control-label" for="address">Location</label>
            <div class="col-md-3">
              <input type="text" name="address"  value="<?php echo $result->address;?>"  class="form-control" id="address" required>
            </div>

            <label class="col-md-3 control-label" for="product">Product / Service</label>
            <div class="col-md-3">
              <input type="text" name="product"  value="<?php echo $result->product;?>"  class="form-control" id="product" required>
            </div>
          
            
          </div>

          

          <div class="form-group">
            <label class="col-md-2 control-label" for="share">Created by</label>
            <div class="col-md-3">
              <select name="staff" class="form-control" id="staff" required>
                <option value="">Select</option>
                <?php 
                    foreach($counselers as $user){
                      ?>
                        <option value="<?php echo $user->id;?>" <?php echo $result->created_by == $user->id ? 'selected':'';?>><?php echo $user->first_name;?> <?php echo $user->last_name;?></option>
                      <?php
                    }
                ?>
              </select>
            </div>

            <label class="col-md-3 control-label" for="action">  Action</label>
            <div class="col-md-3">
              <select name="action" class="form-control" id="action">
                <option value="1" <?php echo $result->status == 1 ? 'selected':'';?>>Active</option>
                <option value="0" <?php echo $result->status == 0 ? 'selected':'';?>>Inactive</option>
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
