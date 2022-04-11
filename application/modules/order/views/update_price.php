 <form name="form_doc_type" id="form_doc_type" action="<?php echo base_url("order/update_price");?>" method="post">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Update Price</h4>
    </div>
    <p> &nbsp;</p>


    <div class="form-group">
      <div class="col-md-12">

        <table style="width: 100%;" id="div_document">
          <tr>
            <td><strong>Description</strong></td>
            <td><strong>Short Description</strong></td>
            <td><strong>Quantity</strong></td>
            <td><strong>Price</strong></td>
          </tr>
          <?php 
          $i = 1;
          foreach ($quote_inverters as $intverter) {
            ?>
            <tr id="tr_<?php echo $i;?>">
              <td>  
               <input type="text" name="package_desc[]" value="<?php echo $intverter->descriptions;?>" rel="<?php echo $i;?>" id="package_desc_<?php echo $i;?>" class="package_desc form-control" >
             </td>
             <td style="padding-left:10px;">  
               <input type="text" name="short_desc[]" value="<?php echo $intverter->short_desc;?>" rel="<?php echo $i;?>" id="short_desc_<?php echo $i;?>" class="short_desc form-control" >
             </td>
             <td> <input type="text" name="package_qty[]" value="<?php echo $intverter->quantity;?>" rel="<?php echo $i;?>" id="package_qty_<?php echo $i;?>" class="package_qty form-control" style="width:50px;margin-left:20px;"></td>
             <td><input type="text" name="package_price[]" value="<?php echo $intverter->price;?>" rel="<?php echo $i;?>" id="package_price_<?php echo $i;?>" class="package_price form-control number" style="width:100px;margin-left:20px;"></td>
             <td><a href="javascript:void(0);" class="link_remove" rel="<?php echo $i;?>"> Remove</a></td>
           </tr>
           <?php
           $i++;
         }

         ?>
         <tr id="tr_<?php echo $i;?>">
          <td>  
           <input type="text" name="package_desc[]" value="" rel="<?php echo $i;?>" id="package_desc_<?php echo $i;?>" class="package_desc form-control" >

         </td>
         <td style="padding-left:10px;">  
           <input type="text" name="short_desc[]" value="" rel="<?php echo $i;?>" id="short_desc_<?php echo $i;?>" class="short_desc form-control" >

         </td>
         <td> <input type="text" name="package_qty[]" value="1" rel="<?php echo $i;?>" id="package_qty_<?php echo $i;?>" class="package_qty form-control" style="width:50px;margin-left:20px;"></td>
         <td><input type="text" name="package_price[]" value="0" rel="<?php echo $i;?>" id="package_price_<?php echo $i;?>" class="package_price form-control number" style="width:100px;margin-left:20px;"></td>
         <td><a href="javascript:void(0);" class="link_remove" rel="<?php echo $i;?>"> Remove</a></td>
       </tr>

     </table>
     <a href="javascript:void(0);" id="add_more">Add</a>
   </div>

 </div>

 <div class="form-group">
   <label class="col-md-3 control-label" for="price">Regular Price</label>
   <div class="col-md-3">
     <input type="text" name="price" id="price" value="<?php echo $quote->qprice;?>" class="form-control required number" readonly="" >

   </div>
 </div>

 <div class="form-group">
   <label class="col-md-3 control-label" for="price">Discount</label>
   <div class="col-md-3">
     <input type="text" name="discount" id="discount" value="<?php echo $quote->discount;?>" class="form-control required number" >

   </div>
   <div class="col-md-3">
     <input type="checkbox" name="is_flat" id="is_flat" value="1" <?php if($quote->is_flat > 0) echo 'checked="checked"';?>> Is Percentage?

   </div>
 </div>
 <?php
 if(isset($quote->price)){
   if($quote->is_included == 1){
    $subtotal = $quote->price - $quote->gst;
  }else{
    $subtotal = $quote->price;
  }
}else{
  $subtotal = 0;
}

?>
<div class="form-group">
 <label class="col-md-3 control-label" for="price">Sub Total</label>
 <div class="col-md-3">
   <input type="text" name="subtotal" id="subtotal" value="<?php echo $subtotal;?>" class="form-control required number" readonly="" >

 </div>
</div>
<div class="form-group">
 <label class="col-md-3 control-label" for="price">GST Applicable</label>
 <div class="col-md-3">
   <input type="radio" name="gst_applicable" id="gst_yes" value="1" <?php if(@$quote->gst_applicable == 1) echo 'checked=""'; ?>  > Yes &nbsp;&nbsp;
   <input type="radio" name="gst_applicable" id="gst_no" value="0" <?php if(@$quote->gst_applicable != 1) echo 'checked=""'; ?>  > No
 </div>
</div>

<div id="div_gst" <?php if(@$quote->gst_applicable == 1) echo 'style="display:blocked;"'; else echo 'style="display:none;"'; ?>>
 <div class="form-group">
   <label class="col-md-3 control-label" for="price"></label>
   <div class="col-md-6">
     <input type="radio" name="radio_gst" id="gst_exclude" value="1" <?php if(@$quote->is_included == 1) echo 'checked=""';?>> Price excluding GST &nbsp;&nbsp;
     <input type="radio" name="radio_gst" id="gst_include" value="0" <?php if(@$quote->is_included != 1) echo 'checked=""';?>> Price including GST
   </div>
 </div>


 <div class="form-group">
   <label class="col-md-3 control-label" for="price">GST</label>
   <div class="col-md-3">
     <input type="text" name="gst" id="gst" value="<?php echo $quote->gst;?>" class="form-control required number" readonly="" >
   </div>
 </div>
 <br>
</div>

<div class="form-group">
 <label class="col-md-3 control-label" for="price">Total Price</label>
 <div class="col-md-3">
   <input type="text" name="total_price" id="total_price" value="<?php echo $quote->price;?>" class="form-control required number" readonly="" >

 </div>
</div>

<div class="form-group">
 <label class="col-md-3 control-label" for="price">Due</label>
 <div class="col-md-6">
   <input type="text" name="due" value="<?php echo @$quote->due_amount;?>"  id="due_amount" class="form-control" readonly="">
 </div>
</div>

<div class="form-group">
 <label class="col-md-3 control-label" for="price">Minimum Deposit (%)</label>
 <div class="col-md-6">
   <input type="text" name="minimum_deposit" value="<?php echo @$quote->minimum_deposit;?>" class="form-control number" >
 </div>
</div>

<div class="form-group" >
  <label class="col-md-3 control-label" for="payment_method">Advance payment:</label>
  <div class="col-md-6">
    <input type="text" name="advance_payment" id="advance_payment" value="<?php echo intval(@$quote->advance_payment);?>" class="form-control ">
  </div>
  <?php //echo form_error("sex");?>
</div>
<div class="form-group" >
  <label class="col-md-3 control-label" for="payment_method">Payment Method:</label>
  <div class="col-md-6">
   <select name="payment_method" id="payment_method" class="form-control ">
    <option value="">Select</option>
    <option value="Bank Transfer" <?php if($quote->payment_method == 'Bank Transfer') echo 'selected="selected"';?>>Bank Transfer</option>
    <option value="COD" <?php if($quote->payment_method == 'COD') echo 'selected="selected"';?>>COD</option>
    <option value="Credit Card" <?php if($quote->payment_method == 'Credit Card') echo 'selected="selected"';?>>Credit Card</option>
    <option value="Paypal" <?php if($quote->payment_method == 'Paypal') echo 'selected="selected"';?>>Paypal</option>
  </select>

</div>
<?php //echo form_error("sex");?>
</div>

<p style="text-align:center;" id="p_doc_type"> </p>
<div class="row mb-lg">
  <div class="col-sm-9 col-sm-offset-3">
    <input type="hidden" name="order_id" value="<?php echo @$quote->order_id;?>">
    <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
    <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
  </div>
</div>
</div>
</form>