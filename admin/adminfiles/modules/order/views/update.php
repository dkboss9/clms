

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


    <h2 class="panel-title">Update Order</h2>
  </header>
  
  <div class="panel-body">

   <?php if($this->session->flashdata("success_message")){?>
   <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Thank you!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
  </div>
  <?php
}
?>
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
         <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("customer/details/".$row->customer_id);?>"><?php echo @$customer->first_name.'  '.@$customer->last_name;?></a></td>
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
<form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("order/update/".$row->order_id);?>" method="post" enctype='multipart/form-data'>
  <div class="row">
    <div class="col-md-12">
      <div class="tabs tabs-warning">
        <ul class="nav nav-tabs">
        <li >
              <a href="<?php echo base_url("order/customer_note/".$row->order_id.'?project='.$this->input->get("project")??0);?>" >Customer Note</a>
            </li>

            <li class="active" >
              <a href="<?php echo base_url("order/update/".$row->order_id.'?project='.$this->input->get("project")??0);?>" ><i class="fa fa-star"></i> Status</a>
            </li>
            <li >
              <a href="<?php echo base_url("order/admin_note/".$row->order_id.'?project='.$this->input->get("project")??0);?>" >Admin Note</a>
            </li>
          

        </ul>
        <div class="tab-content">
          <div id="leads" class="tab-pane <?php if(!$this->input->get("tab")) echo 'active';?>">
            <div class="form-group">
              <label class="col-md-3 control-label" for="price">Order status</label>
              <div class="col-md-6">
               <select name="order_status" data-plugin-selectTwo id="order_status" class="form-control required" >
                <option value=""></option>
                <?php 
                foreach ($order_status as $row1){
                  ?>
                  <option value="<?php echo $row1->threatre_id;?>" <?php if(@$row->order_status == $row1->threatre_id) echo 'selected="selected"';?>><?php echo $row1->name;?></option>
                  <?php
                }
                ?>

              </select>

            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Contact Emails</label>
            <div class="col-md-6">
              <div class="col-md-4">
                <input type="checkbox" name="useremails[]" value="<?php echo $customer_arr['email']; ?>" checked=""> <?php echo $customer_arr['name']; ?>
              </div>
              <?php
              foreach ($customer_contacts as $key => $customer) {
                ?>
                <div class="col-md-4">
                  <input type="checkbox" name="useremails[]" value="<?php echo $customer->email; ?>"> <?php echo $customer->name; ?>
                </div>
                <?php
              }
              ?>

            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Other Emails</label>
            <div class="col-md-6">
              <textarea name="other_email" id="other_email" class="form-control"></textarea>
              Add the valid email address seperated by comma.
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="price"></label>
            <div class="col-md-6">
              <input type="checkbox" name="send_email"> Copy email to me
            </div>
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
              <?php   } ?>
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
