



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Head agents : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("head_agents/add");?>" method="post" enctype='multipart/form-data'>




          <div class="form-group">
            <label class="col-md-2 control-label" for="name">Name</label>
            <div class="col-md-3">
              <input type="text" name="name"  value=""  class="form-control" id="name" required>
            </div>

            <label class="col-md-3 control-label" for="email">Email</label>
            <div class="col-md-3">
              <input type="email" name="email" value=""  class="form-control" id="email" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2 control-label" for="phone">Phone No.</label>
            <div class="col-md-3">
              <input type="number" name="phone"  value=""  class="form-control" id="phone" >
            </div>

            <label class="col-md-3 control-label" for="email">Mobile No.</label>
            <div class="col-md-3">
              <input type="number" name="mobile" value=""  class="form-control" id="mobile" >
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-2 control-label" for="share">Commission share</label>
            <div class="col-md-3">
              <input type="number" name="share"  value=""  class="form-control" id="share" required>
            </div>
            <label class="col-md-3 control-label" for="is_percentage"> </label>
            <label class="col-md-3 " for="is_percentage">  <input type="checkbox" name="is_percentage" value="1"   id="is_percentage" > Is percentage</label>
            
          </div>

          <div class="form-group">
            <label class="col-md-2 control-label" for="share">Created by</label>
            <div class="col-md-3">
              <select name="staff" class="form-control" id="staff" required>
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

            <label class="col-md-3 control-label" for="action">  Action</label>
            <div class="col-md-3">
              <select name="action" class="form-control" id="action">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
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
