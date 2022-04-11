

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

        <h2 class="panel-title">Budget : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("budget/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="type">Type</label>
            <div class="col-md-6">
              <select class="form-control" name="type" id="type" required>
                <option value="">Select</option>
                <option value="1">Income</option>
                <option value="2">Expense</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Item</label>
            <div class="col-md-6">
              <select data-plugin-selectTwo class="form-control populate" name="item" id="select_item">

              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="purpose">Purpose</label>
            <div class="col-md-6">
              <select class="form-control" name="purpose" id="purpose" required>
                <option value="">Select</option>
                <option value="Personal">Personal</option>
                <option value="Business">Business</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="price">Price</label>
            <div class="col-md-6">
              <input type="text" name="price" value=""  class="form-control" id="price" required>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-md-3 control-label" for="payment_time">Payment Time</label>
            <div class="col-md-6">
              <select class="form-control" name="payment_time" id="payment_time" required>
                <option value="">Select</option>
                <?php 
                foreach ($payment_times as $row) {
                 ?>
                 <option value="<?php echo $row->id;?>"><?php echo $row->title;?></option>
                 <?php
               }
               ?>
             </select>
           </div>
         </div>

         <div class="form-group">
          <label class="col-md-3 control-label" for="status">Status</label>
          <div class="col-md-6">
            <select class="form-control" name="status" id="status" required>
              <option value="">Select</option>
              <option value="Due">Due</option>
              <option value="Paid">Paid</option>

            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label">Note</label>
          <div class="col-md-9">
           <textarea name="details"  class="form-control" rows="8" required></textarea>
         </div>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label">Start Date</label>
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </span>
            <input type="text" data-plugin-datepicker="" name="start_date" id="start_date" class="form-control">
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">End Date</label>
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </span>
            <input type="text" data-plugin-datepicker="" name="end_date" id="end_date" class="form-control">
          </div>
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault"></label>
        <div class="col-md-6">
          <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
          <a href="<?php echo base_url("budget");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
<script type="text/javascript">
  $(document).ready(function(){
    $("#type").change(function(){
      var id = $(this).val();
      if(id == "")
        return false;
      $.ajax({
        url: '<?php echo base_url() ?>budget/get_items',
        type: "POST",
        data: "catid=" + id,
        success: function(data) { 
          if(data != ""){
            $("#select_item").html(data);
          }
        }        
      });
      /*$("#select_item").html('<optgroup label="Alaskan/Hawaiian Time Zone">'+
        '<option value="AK">Alaska</option><option value="HI">Hawaii</option></optgroup>'+
        '<optgroup label="Pacific Time Zone">'+
        '<option value="CA">California</option><option value="NV">Nevada</option><option value="OR">Oregon</option><option value="WA">Washington</option>'+
        '</optgroup>'); */
  });
  });

</script>
