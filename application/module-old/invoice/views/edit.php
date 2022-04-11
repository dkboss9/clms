<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#trumbowyg').trumbowyg();
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#customer").change(function(){ 
      var customer = $(this).val();
      if(customer == "")
        return false;
      window.location = '<?php echo base_url("invoice/add");?>/'+ customer;
    });
    $(".txt_qty").blur(function(){
      var qty = $(this).val();
      var id = $(this).attr("rel");
      var price = $("#price_"+id).val();
      $("#total_"+id).val(parseFloat(price)*parseInt(qty));
    });
    $("#link_calc").click(function(){
      var total = 0;
      $(".txt_total").each(function(){
       total+= parseFloat($(this).val());

     });
      $("#sub_total").val(total);
      $("#grand").val(total);
      $("#due").val(total);
    });
    $("#shipping").blur(function(){
      var shipping = $(this).val();
      var total = $("#sub_total").val();
      var grand = parseFloat(shipping) + parseFloat(total);
      $("#grand").val(grand);
      $("#due").val(grand);
    });
    $("#sub_total").blur(function(){
      var total = $(this).val();
      var shipping = $("#shipping").val();
      var grand = parseFloat(shipping) + parseFloat(total);
      $("#grand").val(grand);
      $("#due").val(grand);
    });
    $("#paid").blur(function(){

      var paid = $(this).val();
      if(paid == "")
        return false;
      var due = $("#due").val();
      $("#due").val(parseFloat(due) - parseFloat(paid));
    });
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

        <h2 class="panel-title">Invoice : [Edit]</h2>
      </header>
      <div class="panel-body">
       <form action="<?php echo current_url();?>" method="post" id="form">
        <div class="form-group">
         <label class="col-md-3 control-label" for="lname">Customer</label>
         <div class="col-md-6">

           <select class="form-control required" name="student" id="student" required disabled>
            <option value="">Select</option>
            <?php
            foreach ($students->result() as $row) {
             ?>
             <option value="<?php echo $row->userid;?>" <?php if($result->customer_id == $row->userid) echo 'selected="selected"';?>><?php echo $row->first_name.' '.$row->last_name;?></option>
             <?php
           }
           ?>
         </select>
         
       </div>
     </div>
<?php /*
       <div class="form-group">
        <label class="col-md-3 control-label" for="fname">Company</label>
        <div class="col-md-6">
         <select name="company" id="company" class="form-control" required>
           <option value="">Select</option>
           <?php 
           foreach ($companies as $row) {
             ?>
             <option <?php if($result->company_id == $row->userid) echo 'selected="selected"';?> value="<?php echo $row->userid;?>"><?php echo $row->company_name; ?></option>
             <?php
           }
           ?>
         </select>
       </div>
     </div>

*/ ?>
<?php 
    /// echo $result->invoice_id;
$projects = $this->invoicemodel->getinvoiceDetails($result->invoice_id);
    // echo "<pre>";
     //print_r($projects);
if(isset($projects)){ ?>
<div class="table-responsive">
  <table class="table invoice-items">
    <thead>
      <tr class="h4 text-dark">
        <th id="cell-id" class="text-weight-semibold">#</th>
        <th id="cell-item" class="text-weight-semibold">Item</th>
        <th id="cell-desc" class="text-weight-semibold">Description</th>
        <th id="cell-price" class="text-center text-weight-semibold">Price</th>
        <th id="cell-qty" class="text-center text-weight-semibold">Quantity</th>
        <th id="cell-total" class="text-center text-weight-semibold">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php 

      foreach ($projects as $row) {
       ?>
       <tr>
         <td><input type="hidden" name="projects[]" value="<?php echo $row->project_id;?>"><input type="hidden" name="order[]" value="<?php echo $row->project_no;?>"> <?php echo $row->project_no;?></td>
         <td class="text-weight-semibold text-dark"><input type="text" class="form-control" name="title[]"  value="<?php echo $row->title;?>"></td>
         <td><input type="text" class="form-control" name="desc[]"  value="<?php echo $row->description;?>"></td>
         <td class="text-center"><input type="text" class="form-control" name="price[]" id="price_<?php echo $row->project_id;?>" value="<?php echo $row->price;?>"></td>
         <td class="text-center"><input type="text" class="form-control txt_qty" name="qty[]" id="qty_<?php echo $row->project_id;?>" rel="<?php echo $row->project_id;?>" value="<?php echo $row->qty;?>" required></td>
         <td class="text-center"><input type="text" class="form-control txt_total" name="total[]" id="total_<?php echo $row->project_id;?>"  value="<?php echo $row->total;?>" readonly="" ></td>
       </tr>
       <?php
     }

     ?>


     <tr>
       <td colspan="6" style="text-align:right;" id="link_calc"><a href="javascript:void(0);"class="mb-xs mt-xs mr-xs btn btn-success"> Calculate </a></td>
     </tr>
   </tbody>
 </table>
</div>
<?php } ?>
<div class="form-group">
  <label class="col-md-3 control-label">Sub Total</label>
  <div class="col-md-6">
   <input type="text" name="sub_total" id="sub_total" value="<?php echo $result->sub_total;?>" class="form-control"  required/>
 </div>
</div>



<div class="form-group">
  <label class="col-md-3 control-label">Shipping</label>
  <div class="col-md-6">
    <input type="text" name="shipping" id="shipping" value="<?php echo $result->shipping;?>" class="form-control" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">grand</label>
  <div class="col-md-6">
   <input type="text" name="grand" id="grand" value="<?php echo $result->grand;?>" class="form-control" required />
 </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">Payment Info</label>
  <div class="col-md-6">
    <div class="table-responsive">
      <table class="table invoice-items">
        <thead>
          <tr class="h4 text-dark">

            <th id="cell-item" class="text-weight-semibold">Date</th>
            <th id="cell-desc" class="text-weight-semibold">Amount</th>

          </tr>
        </thead>
        <tbody>
          <?php 
          $payments = $this->invoicemodel->getPayments($result->invoice_id);
          foreach ($payments as $row) {
           ?>
           <tr>
             <td><?php echo date("d/m/Y",$row->paid_date);?></td>
             <td class="text-weight-semibold text-dark"><?php echo $row->amount;?></td>
           </tr>
           <?php
         }

         ?>
       </tbody>
     </table>
   </div>
 </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Amount Paid</label>
  <div class="col-md-6">
    <input type="text" name="paid" id="paid" value="" class="form-control"  />
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">Amount Due</label>
  <div class="col-md-6">
    <input type="text" name="due" id="due" value="<?php echo $result->due_amount;?>" class="form-control"  />
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Admin Note</label>
  <div class="col-md-9">
    <textarea name="admin_note"   class="form-control" rows="4" required><?php echo $result->admin_note;?></textarea>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Customer Note</label>
  <div class="col-md-9">
    <textarea name="customer_note" id="trumbowyg"  class="form-control" rows="4" required><?php echo $result->customer_note;?></textarea>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Invoice Date</label>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="invoice_date" class="form-control" value="<?php echo date("d/m/Y",$result->invoice_date);?>" required>
    </div>
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">Due Date</label>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="due_date" class="form-control" value="<?php echo date("d/m/Y",$result->due_date);?>" required>
    </div>
  </div>
</div>

<div class="form-group">
 <label class="col-md-3 control-label" for="status">Invoice Status</label>
 <div class="col-md-6">
   <select name="status" id="status" class="form-control" required>
     <option value="">Select</option>
     <?php 
     foreach ($status as $row) {
       ?>
       <option <?php if($result->invoice_status == $row->status_id) echo 'selected="selected"'; ?>  value="<?php echo $row->status_id;?>"><?php echo $row->status_name; ?></option>
       <?php
     }
     ?>
   </select>
 </div>
</div>


<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="invoice_id" value="<?php echo $result->invoice_id;?>">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("invoice");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
