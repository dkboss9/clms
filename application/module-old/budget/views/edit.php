

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

        <h2 class="panel-title">Budget : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("budget/edit");?>" method="post" enctype='multipart/form-data'>
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
                <option value="1" <?php if($result->cat1 == 1) echo 'selected="selected"';?>>Income</option>
                <option value="2" <?php if($result->cat1 == 2) echo 'selected="selected"';?>>Expense</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Item</label>
            <div class="col-md-6">
              <select data-plugin-selectTwo class="form-control populate" name="item" id="select_item">
                <?php 
                $types = $this->budgetmodel->get_items($result->cat1);

                foreach ($types as $type) {
                  ?>
                  <optgroup label="<?php echo $type->type_name; ?>">
                    <?php  $items = $this->budgetmodel->get_items($type->type_id);
                    foreach ($items as $item) {
                      ?>
                      <option value="<?php echo $item->type_id;?>" <?php if($result->cat3 == $item->type_id) echo 'selected="selected"'; ?>><?php echo $item->type_name;?></option>
                      <?php
                    }
                    ?>
                  </optgroup>
                  <?php
                }

                ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="purpose">Purpose</label>
            <div class="col-md-6">
              <select class="form-control" name="purpose" id="purpose" required>
                <option value="">Select</option>
                <option value="Personal" <?php if($result->purpose == "Personal") echo 'selected="selected"';?>>Personal</option>
                <option value="Business" <?php if($result->purpose == "Business") echo 'selected="selected"';?>>Business</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="price">Price</label>
            <div class="col-md-6">
              <input type="text" name="price" value="<?php echo $result->price;?>"  class="form-control" id="price" required>
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
                 <option value="<?php echo $row->id;?>" <?php if($result->payment_time == $row->id) echo 'selected="selected"';?> ><?php echo $row->title;?></option>
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
              <option value="Due" <?php if($result->budget_status == "Due") echo 'selected="selected"';?>>Due</option>
              <option value="Paid" <?php if($result->budget_status == "Paid") echo 'selected="selected"';?>>Paid</option>

            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label">Note</label>
          <div class="col-md-9">
            <textarea name="details"  class="form-control" rows="8" required><?php echo $result->note;?></textarea>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label">Start Date</label>
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </span>
              <input type="text" data-plugin-datepicker="" value="<?php echo date("d/m/Y",$result->from_date);?>" name="start_date" class="form-control">
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
              <input type="text" data-plugin-datepicker="" name="end_date" value="<?php echo date("d/m/Y",$result->end_date);?>" class="form-control">
            </div>
          </div>
        </div>


        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault"></label>
          <div class="col-md-6">
            <input type="hidden" name="budget_id" value="<?php echo $result->budget_id;?>">
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
