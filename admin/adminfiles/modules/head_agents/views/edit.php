



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Head agents : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>




          <div class="form-group">
            <label class="col-md-2 control-label" for="name">Name</label>
            <div class="col-md-3">
              <input type="text" name="name"  value="<?php echo $result->name;?>"  class="form-control" id="name" required>
            </div>

            <label class="col-md-3 control-label" for="email">Email</label>
            <div class="col-md-3">
              <input type="email" name="email" value="<?php echo $result->email;?>"  class="form-control" id="email" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2 control-label" for="phone">Phone No.</label>
            <div class="col-md-3">
              <input type="number" name="phone"  value="<?php echo $result->phone_no;?>"  class="form-control" id="phone" >
            </div>

            <label class="col-md-3 control-label" for="email">Mobile No.</label>
            <div class="col-md-3">
              <input type="number" name="mobile" value="<?php echo $result->mobile_no;?>"  class="form-control" id="mobile" >
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-2 control-label" for="share">Commission share</label>
            <div class="col-md-3">
              <input type="number" name="share"  value="<?php echo $result->commission_share;?>"  class="form-control" id="share" required>
            </div>
            <label class="col-md-3 control-label" for="is_percentage"> </label>
            <label class="col-md-3 " for="is_percentage">  <input type="checkbox" name="is_percentage" value="1"   id="is_percentage" <?php echo $result->is_percentage == 1 ? 'checked':'';?> > Is percentage</label>
            
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
              <a href="<?php echo base_url("head_agents");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
