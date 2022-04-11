<script type="text/javascript">

  window.onload = function(){
    CKEDITOR.replace('description');
  };
</script>
<style type="text/css">
th, td {
  padding: 5px;
}
</style>
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
          <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
          <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Edit Daily Activity</h2>
      </header>
      <div class="panel-body">
      <form name="form_activity" id="form_activity" action="<?php echo current_url();?>" method="POST">
      <div class="modal-body" id="form_dailyact">
      <span style="float: right;">Activity Date: <?php echo date("M, d-m-Y",strtotime($activity->activity_date));?></span>
     
           
              <table class="table table-bordered table-striped mb-none" id="datatable-default1" style="margin-bottom: 20px !important;">
                <thead>
                  <tr>
                    <th>Order Number</th>
                    <th>Customer</th>
                    <th>Address</th>
                    <th>Date</th>
                    <th>Time</th>
                  </tr>
                </thead>
                <tbody>
                <?php
               $counter = $this->ordermodel->getinstallemailcount($order_installer->id);
               $orderseen = $this->ordermodel->countinstallseen($order_installer->id);
               $installers = $this->ordermodel->getorder_installer($order_installer->order_id);
               //echo $this->db->last_query();
               ?>
               <tr class="gradeX">
                <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("order/notes/".$order_installer->order_id);?>"><?php echo $order->order_number;?></a></td>
                <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("customer/details/".$order->customer_id);?>"><?php echo @$customer->customer_name;?></a></td>
                <td><?php echo $customer->delivery_address1.', '.$customer->delivery_suburb.','.$this->ordermodel->getState($customer->delivery_state);?></td>
                
                <td><?php echo date("D",strtotime($order_installer->installed_date));?>,<?php echo date("d/m/Y",strtotime($order_installer->installed_date));?></td>
                <td><?php echo $order_installer->installed_time;?></td>
              </tr>
                </tbody>
            </table>
            <div class="form-group">
              <label class="col-md-2 control-label">Start Time</label>
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input type="text"  data-plugin-timepicker="" value="<?php echo $activity->start_time;?>" name="start_time" id="start_time" class="form-control required" data-plugin-options="{ &quot;showMeridian&quot;: false }"  >
                </div>
              </div>
              <label class="col-md-2 control-label">End Time</label>
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </span>
                  <input type="text" data-plugin-timepicker="" name="end_time" value="<?php echo $activity->end_time;?>" class="form-control required" data-plugin-options="{ &quot;showMeridian&quot;: false }"  >
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-2 control-label">Description</label>
              <div class="col-sm-10">
                <textarea name="note" id="note" class="form-control required"><?php echo $activity->description;?></textarea>
              </div>
            </div>
                <input type="hidden" name="order_id[]" value="<?php echo $order_installer->order_id;?>">
             
      </div>
      <div class="modal-footer" style="clear: both;margin-top: 0px;">
        <input type="hidden" name="txt_day" id="txt_day" value="1">
        <input type="submit" name="submit" class="btn btn-success" value="Edit Activity">
        <a href="<?php echo base_url("dashboard/activity_report")?>" class="btn btn-danger" data-dismiss="modal">Cancel</a>
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
$("#form_activity").validate();
});
</script>
