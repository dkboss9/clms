<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#trumbowyg').trumbowyg();
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#student").change(function(){
      var studentid = $(this).val();
      if(studentid == '')
        return false;
      window.location = '<?php echo base_url("invoice/add");?>/'+ studentid;
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
      var due = $("#due").val();
      $("#due").val(parseFloat(due) - parseFloat(paid));
    });
  });
</script>


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

        <h2 class="panel-title">Invoice : [New]</h2>
      </header>
      <div class="panel-body">
       <form action="<?php echo current_url();?>" method="post" id="form">
        <div class="form-group">
          <label class="col-md-3 control-label" for="lname">Client</label>
          <div class="col-md-6">
           <select class="form-control required" name="student" id="student">
            <option value="">Select</option>
            <?php
            foreach ($students->result() as $row) {
             ?>
             <option value="<?php echo $row->userid;?>" <?php if($this->uri->segment(3) == $row->userid) echo 'selected="selected"';?>><?php echo $row->first_name.' '.$row->last_name;?></option>
             <?php
           }
           ?>
         </select>
       </div>
       <div class="col-md-3" id="div_studentdetail"></div>
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
             <option value="<?php echo $row->userid;?>"><?php echo $row->company_name; ?></option>
             <?php
           }
           ?>
         </select>
       </div>
     </div>
*/ ?>

<?php if(isset($projects)){ ?>
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
         <td><input type="hidden" name="projects[]" value="<?php echo $row->project_id;?>"><input type="hidden" name="order[]" value="<?php echo $row->order_no;?>"> <?php echo $row->order_no;?></td>
         <td class="text-weight-semibold text-dark"><input type="text" class="form-control" name="title[]"  value="<?php echo $row->project_title;?>"></td>
         <td><input type="text" class="form-control" name="desc[]"  value="<?php echo $row->description;?>"></td>
         <td class="text-center"><input type="text" class="form-control" name="price[]" id="price_<?php echo $row->project_id;?>" value="<?php echo $row->total;?>"></td>
         <td class="text-center"><input type="text" class="form-control txt_qty" name="qty[]" id="qty_<?php echo $row->project_id;?>" rel="<?php echo $row->project_id;?>" value="" required></td>
         <td class="text-center"><input type="text" class="form-control txt_total" name="total[]" id="total_<?php echo $row->project_id;?>"  value="" readonly="" ></td>
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
   <input type="text" name="sub_total" id="sub_total" value="0" class="form-control"  required/>
 </div>
</div>



<div class="form-group">
  <label class="col-md-3 control-label">Shipping</label>
  <div class="col-md-6">
    <input type="text" name="shipping" id="shipping" value="0" class="form-control" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">Grand</label>
  <div class="col-md-6">
   <input type="text" name="grand" id="grand" value="0" class="form-control" required />
 </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">Amount Paid</label>
  <div class="col-md-6">
   <input type="text" name="paid" id="paid" value="" class="form-control" required />
 </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">Amount Due</label>
  <div class="col-md-6">
    <input type="text" name="due" id="due" value="" class="form-control" required />
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">Invoice Date</label>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="invoice_date" class="form-control" required>
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
      <input type="text" data-plugin-datepicker="" name="due_date" class="form-control" required>
    </div>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Admin Note</label>
  <div class="col-md-9">
    <textarea name="admin_note"   class="form-control" rows="4" required></textarea>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Customer Note</label>
  <div class="col-md-9">
    <textarea name="customer_note" id="trumbowyg"  class="form-control" rows="4" required></textarea>
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
       <option  value="<?php echo $row->status_id;?>"><?php echo $row->status_name; ?></option>
       <?php
     }
     ?>
   </select>
 </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
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
