
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
<section class="panel">
  <header class="panel-heading">


    <h2 class="panel-title">Approved Quote</h2>
  </header>
  
  <div class="panel-body">
    <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("order/approve_quote");?>" method="post" enctype='multipart/form-data'>
    <div class="table-responsive">  
          <table class="table table-bordered table-striped mb-none" id="datatable-default1">
              <thead>
                <tr>
                  <th>Quote Number</th>
                  <th>Customer Name</th>
                  <th>Nature of Quote</th>
                  <th>Total</th>
                  <th>Quote Status</th>
                  <th>Quote Date</th>
                  <th>Expiry Date</th>
                </tr>
              </thead>
              <tbody>
                <?php 
          // foreach ($status->result() as $quote) {
                $publish = ($quote->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
                $customer = $this->quotemodel->getCustomer($quote->customer_id);
                $status = $this->quotemodel->getstatus($quote->quote_satus);
                ?>
                <tr class="gradeX">
                <td><?php echo $quote->quote_number;?></td>
                <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("customer/details/".$quote->customer_id);?>"><?php echo @$customer->first_name.' '.@$customer->last_name;?></a></td>
                <td><?php echo $quote->product;?></td>
                <td><?php echo $quote->total_price;?></td>

                <td><span class="label" style="color:#fff;background:<?php echo @$status->color_code;?>"><?php echo @$status->name;?></span></td>
                <td><?php echo date("d/m/Y",$quote->added_date);?></td>
                <td><?php echo date("d/m/Y",$quote->expiry_date);?></td>
              </tr>
              <?php
          // } ?>


        </tbody>
      </table>
    </div>
<br>
<div class="form-group" >
  <label class="col-md-3 control-label" for="payment_method">Advance payment:</label>
  <div class="col-md-6">
    <input type="text" name="advance_payment" id="advance_payment" value="" class="form-control number">
  </div>
  <?php //echo form_error("sex");?>
</div>
<div class="form-group" >
  <label class="col-md-3 control-label" for="payment_method">Payment Method:</label>
  <div class="col-md-6">
    <select name="payment_method" data-plugin-selectTwo id="payment_method" class="form-control">
      <option value="">Select</option>
      <option value="Bank Transfer">Bank Transfer</option>
      <option value="COD">COD</option>
      <option value="">Credit Card</option>
      <option value="">Paypal</option>
    </select>
    
  </div>
  <?php //echo form_error("sex");?>
</div>
<div class="form-group" >
  <label class="col-md-3 control-label" for="payment_method">Special Note:</label>
  <div class="col-md-6">
    <textarea name="note" id="note" class="form-control"></textarea>
    
  </div>
  <?php //echo form_error("sex");?>
</div>

<div class="form-group" >
  <label class="col-md-3 control-label" for="minimum_deposit">Minimum deposit:(%)</label>
  <div class="col-md-6">
   <input type="text" name="minimum_deposit" id="minimum_deposit" value="" class="form-control number">

 </div>
 <?php //echo form_error("sex");?>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="price"></label>
  <div class="col-md-6">
   <input type="checkbox" name="send_email" value="1" checked=""> Send email automatically
 </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="quote_id" value="<?php echo $quote->quote_id;?>">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("dashboard/quote");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
  </div>
</div>
</form>
</div>
</section>




</section>
</div>


</section>
<script type="text/javascript">
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>order/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
        return false;
    });
  });
    //This function is used for making a json data for cascade delete, publish and unpublish and call ajax
    function cascade(action){
      if(confirm('Are you sure to proceed this action?')){
        var ids = checkedCheckboxId();
      if(ids.length == 0){
        alert("Select atleast one data to proceed this action");
        return false;
      }
        var jsonData ={"object":{"ids":ids,"action":action}};
        $.ajax({
          url:"<?php echo base_url(); ?>order/cascadeAction",
          type:"post",
          data:jsonData,
          success: function(msg){
            location.reload();
          }
        });
      }else{
        return false; 
      }
    }

  </script> 