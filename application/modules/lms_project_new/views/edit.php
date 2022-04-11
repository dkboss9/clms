
<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#trumbowyg').trumbowyg();
  });
</script>


<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Project : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("lms_project/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Is Existing Order?</label>
            <div class="col-md-6">
              <input type="radio" name="is_existing" id="radio_yes" <?php if($result->is_existing ==  '1') echo 'checked="checked"';?> value="1"> Yes
              <input type="radio" name="is_existing" id="radio_no" <?php if($result->is_existing ==  '0') echo 'checked="checked"';?> value="0"> No
            </div>
          </div>

          <div class="form-group" id="div_order" <?php if($result->is_existing ==  '0') echo 'style="display:none;"';?>>
            <label class="col-md-3 control-label" for="inputDefault">Order</label>
            <div class="col-md-6">
              <select class="form-control" name="project_order" id="project_order" required>
                <option value="">Select</option>
                <?php 
                foreach ($orders as $row) {
                 ?>
                 <option value="<?php echo $row->project_id;?>" <?php if($row->project_id == $result->order_id) echo 'selected="selected"';?>><?php echo $row->project_title;?></option>
                 <?php
               }
               ?>
             </select>
           </div>
           <?php
           $order = $this->lms_projectmodel->get_order_customer($result->order_id);
           ?>
           <div class="col-md-3" id="div_customer">
             <?php
             if(count($order) > 0)
              echo 'Name: '.$order->customer_name.'<br>Email: '.$order->email.'<br>Contact No: '.$order->contact_number;
            ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Project Title</label>
          <div class="col-md-6">
            <input type="text" name="name" value="<?php echo $result->task_name;?>"  class="form-control" id="inputDefault" required>
          </div>
        </div>


        <div class="form-group">
         <label class="col-md-3 control-label">Project Details</label>
         <div class="col-md-9">
          <textarea name="details" id="trumbowyg"  class="form-control" rows="8" required><?php echo $result->task_detail;?></textarea>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Assign To</label>
        <div class="col-md-9">
          <?php 
          foreach ($users as $user ) {
           $assign_user = $this->lms_projectmodel->checkAssignedUser($user->userid,$result->task_id);
            //echo $this->db->last_query();
           ?>
           <div style="float:left;margin-right:20px;width:200px;">
            <input type="checkbox" name="assign_to[]" <?php if($assign_user > 0 ) echo 'checked="checked"';?> value="<?php echo $user->userid;?>"><?php echo $user->first_name." ".$user->last_name.' ( '.$user->group_name.' )';?>
          </div>
          <?php
        }
        ?>
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
           <option value="<?php echo $row->status_id;?>" <?php if($row->status_id == $result->task_status) echo 'selected="selected"';?>><?php echo $row->status_name;?></option>
           <?php
         }
         ?>
       </select>
     </div>

   </div>

   <div class="form-group">
    <label class="col-md-3 control-label">Start Date</label>
    <div class="col-md-6">
      <div class="input-group">
        <span class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </span>
        <input type="text" data-plugin-datepicker=""  name="start_date" value="<?php echo date("d/m/Y",$result->start_date);?>" class="form-control">
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

  <?php
  if($form->num_rows()>0){
    $row = $form->row();
    pds_form_render($row->forms_id,$result->task_id);
  }
  ?>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault"></label>
    <div class="col-md-6">
      <input type="hidden" name="task_id" value="<?php echo $result->task_id;?>">
      <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
      <a href="<?php echo base_url("lms_project");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
  // $("#div_order").hide();
  $("#radio_yes").click(function(){
    $("#div_order").show();
  });
  $("#radio_no").click(function(){
    $("#div_order").hide();
  });
  $("#project_order").change(function(){
    var orderid = $(this).val();
    if(orderid == "")
      return false;
    $.ajax({
      url: '<?php echo base_url() ?>lms_project/getOrderdetail',
      type: "POST",
      data: "orderid=" + orderid,
      success: function(data) { 
        $("#div_customer").html(data);
      }        
    }); 
  });
});
  
</script>
