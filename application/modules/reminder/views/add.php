


<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Reminder : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("reminder/add");?>" method="post" enctype='multipart/form-data'>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Name</label>
            <div class="col-md-6">
              <input type="text" name="name" value=""  class="form-control" id="inputDefault" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Task Detail</label>
            <div class="col-md-6">
              <textarea name="detail" id="detail" class="form-control required"></textarea>
            </div>
          </div>

          <div class="form-group">
              <label class="col-md-3 control-label">Reminder Date</label>
              <div class="col-md-2">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input type="text"  value="" name="reminder_date" id="reminder_date" class="form-control datepicker required" autocomplete="off">
                </div>
              </div>
              <label class="col-md-2 control-label">Reminder Time</label>
              <div class="col-md-2">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </span>
                  <input type="text" data-plugin-timepicker="" name="reminder_time" id="reminder_time" value="" autocomplete="off" class="form-control required" data-plugin-options="{ &quot;showMeridian&quot;: false }">
                </div>
              </div>
           </div>

           <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Status</label>
            <div class="col-md-6">
              <select name="status" class="form-control required">
                  <option value="">Select</option>
                  <option value="To Do">To Do</option>
                  <option value="In Progress">In Progress</option>
                  <option value="Done">Done</option>
                  <option value="Blocked">Blocked</option>
              </select>
            </div>
          </div>



          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("purpose");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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