
<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Company : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Name</label>
            <div class="col-md-6">
              <input type="text" name="name" value="<?php echo $result->name;?>"  class="form-control" id="name" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Email</label>
            <div class="col-md-6">
              <input type="email" name="email" value="<?php echo $result->email;?>" class="form-control" id="email" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Phone</label>
            <div class="col-md-6">
              <input type="text" name="phone" value="<?php echo $result->phone;?>" class="form-control" id="phone" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Address</label>
            <div class="col-md-6">
              <input type="text" name="address" value="<?php echo $result->address;?>"  class="form-control" id="address" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Staff </label>
            <div class="col-md-6">
              <select name="source" id="source" data-plugin-selectTwo  class="form-control"  required>
                  <option value="">Select</option>
                  <?php 
                    foreach($users as $user){
                      ?>
                        <option value="<?php echo $user->id;?>" <?php echo $user->id == $result->staff_id ? 'selected':'';?>><?php echo $user->first_name;?> <?php echo $user->last_name;?></option>
                      <?php
                    }
                  ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Company Name</label>
            <div class="col-md-6">
              <input type="text" name="company_name" value="<?php echo $result->company_name;?>"  class="form-control" id="company_name" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">ABN </label>
            <div class="col-md-6">
            <input type="text" name="abn" value="<?php echo $result->abn;?>"  class="form-control" id="abn" >
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("companies");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
<script>
   $(document).ready(function(){
    $(".datepicker").datepicker({  format: 'dd-mm-yyyy'});
  });
  </script>