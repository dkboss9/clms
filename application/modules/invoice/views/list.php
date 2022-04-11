


  <!-- start: page -->
  <section class="panel">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle></a>
        <a href="#" class="" data-panel-dismiss></a>
      </div>

      <h2 class="panel-title">Invoice List</h2>
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
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> More <span class="caret"></span> </button>
              <ul class="dropdown-menu" role="menu">
                <li><a onclick="cascade('delete');">Delete Marked</a></li>
                <li><a onclick="cascade('publish');">Mark as Published
                </a></li>
                <li><a onclick="cascade('unpublish');">Mark as Unpublished
                </a></li>
              </ul>
            </div>
          </h2>
        </div>
      </div>
    </div>
    <table class="table table-bordered table-striped mb-none" id="datatable-default">
      <thead>
        <tr>
          <th style="width:10%"><input type="checkbox" name="all" id="checkall" ></th>
          <th>Invoice Number</th>
          <th>Client</th>
          <th>Company</th>
          <th>Grand Total</th>
          <th>Due Amount</th>
          <th>Invoice Date</th>
          <th>Due Date</th>
          <th>Status</th>
          <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        foreach ($invoice->result() as $row) {
          $counter = $this->invoicemodel->getemailcount($row->invoice_id);
          $publish = ($row->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
          ?>
          <tr class="gradeX">
           <td><input type="checkbox" class="checkone" value="<?php echo $row->invoice_id; ?>" /></td>
           <td><?php echo $row->invoice_no;?></td>
           <td><?php echo $row->first_name.' '.$row->last_name;?></td>
           <td><?php echo $row->company_name;?></td>
           <td><?php echo $row->grand;?></td>
           <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("invoice/payment/".$row->invoice_id);?>"><?php echo $row->due_amount;?></a></td>
           <td><?php echo date('d/m/Y',$row->invoice_date);?></td>
           <td><?php echo date('d/m/Y',$row->due_date);?></td>
           <td><?php echo $row->status_name;?></td>
           <td class="actions">
             <?php
             echo $publish.'&nbsp;';
             echo anchor('invoice/edit/'.$row->invoice_id,'<span class="glyphicon glyphicon-edit"></span>');
             echo ' <a href="'. base_url(""). 'invoice/detail/'. $row->invoice_id .'"  class=""><span class="fa fa-dollar"></span></a>';
             ?>
             <a href="<?php echo base_url("invoice/submit_invoice/".$row->invoice_id);?>" class="link_email"><span class="glyphicon glyphicon-envelope">(<?php echo  $counter;?>)</span></a>
           </td>
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
    $(".link_email").click(function(){
      if(!confirm("Are you sure to send invoice?"))
        return false;
    });
    
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
    $('.fa-dollar').tooltip({'placement': 'bottom','title':'Preview invoice'});
    $('.glyphicon-envelope').tooltip({'placement': 'bottom','title':'Send Invoice'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>invoice/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Announcement?'))
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
          url:"<?php echo base_url(); ?>invoice/cascadeAction",
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