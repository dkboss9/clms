<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#trumbowyg').trumbowyg();
  });
</script>


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

        <h2 class="panel-title">Task : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("task/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label">Start Date</label>
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </span>
                <input type="text" name="start_date" class="form-control datepicker" autocomplete="off">
              </div>
            </div>
          </div>
        
         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Task Title</label>
          <div class="col-md-6">
            <input type="text" name="name" value=""  class="form-control" id="inputDefault" required>
          </div>
        </div>


        <div class="form-group">
         <label class="col-md-3 control-label">Task Details</label>
         <div class="col-md-9">
          <textarea name="details" id="trumbowyg"  class="form-control" rows="8" required></textarea>
        </div>
      </div>
    

      <div class="form-group">
        <label class="col-md-3 control-label">Due Date</label>
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </span>
            <input type="text"  name="end_date" class="form-control datepicker" autocomplete="off">
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Assign By</label>
        <div class="col-md-6">
       
          <select class="form-control" name="assign_by" required>
            <option value="">Select</option>
            <?php 
            foreach ($users as $user ) {
              ?>
              <option value="<?php echo $user->userid;?>"><?php echo $user->first_name." ".$user->last_name;?></option>
              <?php
            }
            ?>
          </select>
       
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Assign To</label>
        <div class="col-md-6">
       
          <select class="form-control" name="assign_to" required>
            <option value="">Select</option>
            <?php 
            foreach ($users as $user ) {
              ?>
              <option value="<?php echo $user->id;?>"><?php echo $user->first_name." ".$user->last_name;?></option>
              <?php
            }
            ?>
          </select>
       
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Status</label>
        <div class="col-md-6">
          <select class="form-control" name="status" required>
            <option value="">Select</option>
            <?php 
            foreach ($status as $row) {
             ?>
             <option value="<?php echo $row->status_id;?>"><?php echo $row->status_name;?></option>
             <?php
           }
           ?>
         </select>
       </div>
     </div>

     <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Priority</label>
      <div class="col-md-6">
        <select class="form-control" name="priority" required>
          <option value="">Select</option>
          <option value="Normal">Normal</option>
          <option value="High">High</option>
          <option value="Urgent">Urgent</option>
        </select>
      </div>
    </div>


    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault"></label>
      <div class="col-md-6">
        <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
        <a href="<?php echo base_url("task");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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