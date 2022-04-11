

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
<section class="panel">
  <header class="panel-heading">


    <h2 class="panel-title">Update Order</h2>
  </header>
  
  <div class="panel-body ">
<div class="table-responsive">
  <?php if($row->inhouse_date == NULL){  ?>
    <table class="table table-bordered table-striped mb-none" id="datatable-default1">
      <thead>
        <tr>

          <th>Order Number</th>
          <th>Customer Name</th>
          <th>Nature of Order</th>
          <th>Price</th>
          <th>Due Amount</th>
          <th>Order Status</th>
          <th>Invoice Status</th>
          <th>Installation Date</th>

        </tr>
      </thead>
      <tbody>
        <?php 
        $publish = ($row->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
        $customer = $this->quotemodel->getCustomer($row->customer_id);

        $status = $this->ordermodel->getstatus($row->order_status);
        $invoice = $this->ordermodel->getinvoicestatus($row->invoice_status);
        $install = $this->ordermodel->getOrderInstallers($row->order_id);
        $notes = $this->ordermodel->getOrderInstallersNotes($row->order_id);
        $counter = $this->ordermodel->getemailcount($row->order_id);
        $note_string = '';
        foreach ($notes as $note) {
          $note_string.=$note->notes.'\n';
          $note_string.= $note->first_name.' '.$note->last_name.' \t \t Added Date:'.date("d/m/Y",$note->added_date).'\n';
        }
        ?>
        <tr class="gradeX">

         <td><?php echo $row->order_number;?></td>
         <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("customer/details/".$row->customer_id);?>"><?php echo @$customer->first_name;?> <?php echo @$customer->last_name;?></a></td>
         <td><?php echo @$row->product;?></td>
         <td><?php echo $row->price;?></td>
         <td><?php echo $row->due_amount;?></td>
         <td><span class="label" style="color:#fff;background:<?php echo @$status->color_code;?>"><?php echo @$status->name;?></span></br><?php echo @$install->first_name.' '.@$install->last_name;?></td>
         <td><span class="label" style="color:#fff;background:<?php echo @$invoice->status_color;?>"><?php echo @$invoice->status_name;?></span></td>

         <td><?php echo @$install->installed_date;?><?php 
         if(count($notes)){
          ?><span class="glyphicon glyphicon-comment spectail_note<?php echo $row->order_id;?>"></span>
          <?php } ?>
        </td>
      </tr>




    </tbody>
  </table>
         <?php }else{ ?>
          <table class="table table-bordered table-striped mb-none" id="datatable-default1">
      <thead>
        <tr>
        <th style="width:2%;"><input type="checkbox" name="all" id="checkall" ></th>
        <th>Ordered Date</th>
        <th>Order Number</th>
        <th>Order Name</th>
        <th>Customer Name</th>
        <th>Expiry Date</th>
        <th> No. of people</th>
        <th>Order Status</th>

        </tr>
      </thead>
      <tbody>
        <?php 
         $publish = ($row->status == 1 ? '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span></a>' : '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span></a>');
         $customer = $this->quotemodel->getCustomer($row->customer_id);

         $status = $this->ordermodel->getstatus($row->order_status);
         $invoice = $this->ordermodel->getinvoicestatus($row->invoice_status);
         $install = $this->ordermodel->getOrderInstallers($row->order_id);
      
        ?>
        <tr class="gradeX">
         <td><input type="checkbox" class="checkone" value="<?php echo $row->order_id; ?>" /></td>
         <td><?php echo date("d/m/Y",strtotime($row->inhouse_date));?></td>
         <td><a  href="<?php echo base_url("order/order_details/".$row->order_id);?>"><?php echo $row->order_number;?></a></td>
         <td><?php echo $row->product;?></td>
         <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("customer/details/".$row->customer_id);?>"><?php echo @$customer->customer_name;?></a></td>
         <td><?php echo date("d/m/Y",strtotime($row->expiry_date));?></td>
         <td><?php echo $row->no_of_people;?></td>
        <td>
          <span class="label" style="color:#fff;background:<?php echo @$status->color_code;?>"><?php echo @$status->name;?></span></br><?php echo @$install->first_name.' '.@$install->last_name;?> <br> <?php echo @$install->position_type;?> 
        </td>
      </tr>
    </tbody>
  </table>
         <?php } ?>
</div>
    <br>
    <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("order/admin_note/".$row->order_id);?>" method="post" enctype='multipart/form-data'>
      <div class="row">
        <div class="col-md-12">
          <div class="tabs tabs-warning">
            <ul class="nav nav-tabs">
            <li >
              <a href="<?php echo base_url("order/customer_note/".$row->order_id.'?project='.$this->input->get("project")??0);?>" >Customer Note</a>
            </li>

            <li  >
              <a href="<?php echo base_url("order/update/".$row->order_id.'?project='.$this->input->get("project")??0);?>" ><i class="fa fa-star"></i> Status</a>
            </li>
            <li class="active">
              <a href="<?php echo base_url("order/admin_note/".$row->order_id.'?project='.$this->input->get("project")??0);?>" >Admin Note</a>
            </li>
            

          </ul>
          <div class="tab-content">
            <div id="leads" class="tab-pane active">

             <?php
             if($admin_notes->num_rows() >0){
               echo ' <header class="panel-heading">
               <h2 class="panel-title">Admin Notes</h2>
             </header>';
             $i = 1;
             foreach($admin_notes->result() as $note){
               $added_by = $this->usermodel->getuser($note->added_by)->row();
               ?>
               <div class="form-group" >
                <label class="col-md-3 control-label" for="payment_method"><?php //echo $i;?></label>
                <label class="col-md-9 " for="payment_method"><?php echo $note->admin_note?> <br> Added at <?php echo date("d F, Y",$note->added_date);?> - By <?php echo  @$added_by->first_name.' '.@$added_by->last_name;?></label></label>
              </div>
              <?php
              $i++;
            }
          }
          ?>

          <div class="form-group" >
            <label class="col-md-3 control-label" for="payment_method">Admin Note:</label>
            <div class="col-md-6">
              <textarea name="admin_note" id="admin_note" class="form-control"></textarea>

            </div>
            <?php //echo form_error("sex");?>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="hidden" name="order_id" value="<?php echo $row->order_id;?>">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <?php if(@$this->input->get("project") == 1){?>
                <a href="<?php echo base_url("project/invoice/".$row->customer_id);?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
                <?php }else{ ?>
                  <a href="<?php echo base_url("order/listall");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
              <?php  } ?>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

</div>

</form>
</div>
</section>




</section>
</div>


</section>
