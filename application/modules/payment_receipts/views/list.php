


<!-- start: page -->
<section class="panel">
  <header class="panel-heading">
    <div class="panel-actions">
      <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
      <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
    </div>

    <h2 class="panel-title">Payment receipts </h2>
  </header>
  
  <div class="panel-body">
    <?php if($this->session->flashdata("success_message")){?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
    </div>
    <?php
  }
  ?>
  <div class="row">
    <div class="col-sm-6">
      <div class="mb-md">
        <h2>
          <button 
          id="addButton"
          data-toggle="tooltip" 
          title="Add New Record"
          type="button" 
          class="btn btn-primary"> Add <i class="fa fa-plus"></i> </button>

          <!-- Single button -->
          <!-- <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> More <span class="caret"></span> </button>
            <ul class="dropdown-menu" role="menu">
              <li><a onclick="cascade('delete');">Delete Marked</a></li>
              <li><a onclick="cascade('publish');">Mark as Publish</a></li>
              <li><a onclick="cascade('unpublish');">Mark as Unpublish</a></li>
            </ul>
          </div> -->
        </h2>
      </div>
    </div>
  </div>
  <table class="table table-bordered table-striped mb-none" id="datatable-default">
    <thead>
      <tr>
      <th id="cell-item" class="text-weight-semibold">payment No</th>
      <th id="cell-item" class="text-weight-semibold">Received Date</th>
      <th id="cell-desc" class="text-weight-semibold">Amount</th>
      <th id="cell-desc" class="text-weight-semibold">Payment Method</th>
      <th id="cell-desc" class="text-weight-semibold">Note</th>
      <th>Invoice Number</th>
      <th>Receipted  By</th>
      <th>Customer  </th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach ($payment_receipts->result() as $payment_receipt) {
      //  $publish = ($payment_receipts->status == 1 ? '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span></a>' : '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span></a>');
       ?>
       <tr class="gradeX">
       <td><?php echo $payment_receipt->payment_id;?></td>
       <td><?php echo date("d/m/Y",strtotime($payment_receipt->received_on));?></td>
        <td ><?php echo $payment_receipt->amount;?></td>
        <td ><?php echo $payment_receipt->payment_method;?></td>
        <td ><?php echo $payment_receipt->note;?></td>	
        <td ><?php echo $payment_receipt->order_number;?></td>	
        <td><?php echo $payment_receipt->first_name;?> <?php echo $payment_receipt->last_name;?></td>
        <td><?php echo $payment_receipt->cfname;?> <?php echo $payment_receipt->clname;?></td>

        
        </tr>
        <?php
      } ?>


    </tbody>
  </table>
</div>
</section>




</section>
</div>


</section>
<script type="text/javascript">
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>payment_receipts/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
        return false;
    });
  });


  function cascade(action){

    confirmation("Confirmation","Are you sure you want to proceed this Action? ","Cancel","Confirm","",action,"<?php echo base_url(); ?>payment_receipts/cascadeAction");

  }

</script> 