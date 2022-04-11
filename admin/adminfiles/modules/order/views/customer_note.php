<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/trumbowyg.min.css">
<script src="<?php echo base_url("");?>assets/javascripts/trumbowyg.js"></script>
<script type="text/javascript">


  $(document).ready(function(){
    $('#customer_note').trumbowyg();
  });
</script>
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
         <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("customer/details/".$row->customer_id);?>"><?php echo @$customer->first_name.' '.$customer->last_name;?></a></td>
         <td><?php echo @$row->product;?></td>
         <td><?php echo $row->price;?></td>
         <td><?php echo $row->due_amount;?></td>
         <td><span class="label" style="color:#fff;background:<?php echo @$status->color_code;?>"><?php echo @$status->name;?></span></br><?php echo @$install->first_name.' '.@$install->last_name;?></td>
         <td><span class="label" style="color:#fff;background:<?php echo @$invoice->status_color;?>"><?php echo @$invoice->status_name;?></span></td>

         <td><?php echo @$install->installed_date;?><?php 
         if(!empty($notes)){
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
         <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("customer/details/".$row->customer_id);?>"><?php echo @$customer->first_name.' '.@$customer->last_name;?></a></td>
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
  <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("order/customer_note/".$row->order_id);?>" method="post" enctype='multipart/form-data'>
    <div class="row">
      <div class="col-md-12">
        <div class="tabs tabs-warning">
          <ul class="nav nav-tabs">
            <li class="active">
              <a href="<?php echo base_url("order/customer_note/".$row->order_id.'?project='.$this->input->get("project")??0);?>" >Customer Note</a>
            </li>

            <li >
              <a href="<?php echo base_url("order/update/".$row->order_id.'?project='.$this->input->get("project")??0);?>" ><i class="fa fa-star"></i> Status</a>
            </li>
            <li >
              <a href="<?php echo base_url("order/admin_note/".$row->order_id.'?project='.$this->input->get("project")??0);?>" >Admin Note</a>
            </li>

          </ul>
          <div class="tab-content">
            <div id="leads" class="tab-pane active">

             <?php
             if($customer_notes->num_rows() >0){
               echo ' <header class="panel-heading">
               <h2 class="panel-title">Notes</h2>
               </header>';
               $i = 1;
               foreach($customer_notes->result() as $note){
                 $added_by = $this->usermodel->getuser($note->added_by)->row();
                 ?>
                 <div class="form-group" <?php if(!empty($added_by)) echo 'style="background:#d8f1f9; margin-left: 0px;
                 margin-right: 0px;"'; else echo 'style="background:#dfd; margin-left: 0px;
                 margin-right: 0px;"';?> >
                 <label class="col-md-3 control-label" for="payment_method">
                  <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown" style="background: #FFF;
                  border-radius: 50%;
                  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.3);
                  display: inline-block;
                  height: 30px;
                  position: relative;
                  width: 30px;
                  color:#ffffff;

                  padding-top: 3px;
                  text-align: center;font-weight:bold; <?php if(!empty($added_by)) echo 'background:#0088cc'; else echo 'background:green';?>">
                  <?php if(!empty($added_by)) echo 'A'; else echo 'C'?>
                  <span class="badge"></span>
                </a>
              </label>
              <label class="col-md-9 " for="payment_method"><?php echo $note->customer_note;?> 
               <?php
               $attached_files = $this->ordermodel->getNotefiles($note->note_id); 
               if(!empty($attached_files)){
                foreach ($attached_files as $filename) {
                  if($filename->file_name != "" && file_exists("../uploads/document/".$filename->file_name)) 
                    echo '<br><a href="'.SITE_URL."uploads/document/".$filename->file_name.'" target="_blank">'.$filename->file_name.'</a>';
                }
              }
              if($note->attached_file != "" && file_exists("../uploads/document/".$note->attached_file)) echo '<br><a href="'.SITE_URL."uploads/document/".$note->attached_file.'" target="_blank">'.$note->attached_file.'</a>';
              ?>
              <br> Added at <?php echo date("d F, Y",$note->added_date);?>  
              - By <?php echo !empty($added_by) ? @$customer->first_name.' '. @$customer->last_name : @$added_by->first_name.' '.@$added_by->last_name;?></label>
            </div>
            <?php
            $i++;
          }
        }
        ?>

        <div class="form-group" >
          <label class="col-md-3 control-label" for="payment_method">Customer Note:</label>
          <div class="col-md-6">
            <textarea name="customer_note" id="customer_note" class="form-control required"></textarea>

          </div>
          <?php //echo form_error("sex");?>
        </div>

        <div class="form-group" >
          <label class="col-md-3 control-label" for="payment_method">Attach file:</label>
          <div class="col-md-6">
           <table style="width: 100%;" id="div_document">

            <tr>
              <td>  <input type="file" name="document1" class="form-control doccuments"> </td>

            </tr>
          </table>

        </div>
        <div class="col-md-3" for="payment_method"> 
          <a href="javascript:void(0);" id="add_more">Add</a>
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
          <input type="checkbox" name="copy_email" value="1" checked=""> Copy email to me 
          <input type="hidden" name="project" value="<?php echo $this->input->get("project")??0;?>">
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
<script type="text/javascript">
  $(document).ready(function(){

    var num = 1;
    $("#add_more").click(function(){
      var cond = 1;
     // var num = $(".doccuments").length;
     num = num + 1;
     $("#div_document").append('<tr style="margin-top:10px;" id="tr_'+num+'">'+
      '<td> <input type="file" name="document'+num+'" class="form-control doccuments"></td>'+
      '<td><a href="javascript:void(0);" class="link_remove" rel="'+num+'"> Remove</a></td></tr>');
   });
    $(document.body).on('click', '.link_remove' ,function(){
      var id = $(this).attr("rel");
      $("#tr_"+id).remove(); 
    });

  });
</script>