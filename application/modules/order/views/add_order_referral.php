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
          <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
          <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">order : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("order/add_order");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>



          <div id="div_new">
            <div class="form-group" >
             <label class="col-md-2 control-label" for="customer_name">Customer</label>
             <div class="col-md-6">
               <select name="customer"  data-plugin-selectTwo id="customer" class="form-control">
                 <option value=""></option>
                 <?php 
                 foreach ($customers->result() as $row) {
                   ?>
                   <option referral_id = "<?php echo $row->referral_id;?>" value="<?php echo $row->customer_id;?>" <?php if(@$quote->customer_id == $row->customer_id) echo 'selected="selected"';?>><?php echo $row->customer_name;?></option>
                   <?php
                 }
                 ?>
               </select>

             </div>
             <div class="col-md-1">
               <?php 
               if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm1('CUSTOMER',"ADD")) {
                ?>
                <a href="javascript:void(0);" id="link_customer" class=""><i class="glyphicon glyphicon-plus"></i></a>
                <?php } ?>
              </div>
              <div class="col-md-3" id="div_customer_detail">
               <?php
               if(isset($cust->customer_no)){
                 echo '<p>Customer No.: '.$cust->customer_no.'</p>';
                 echo '<p>Name: '.$cust->customer_name.'</p>';
                 echo '<p>Company: '.$cust->company_name.'</p>';
                 echo '<p>Contact No:'.$cust->contact_number.'</p>';
                 echo '<p>Email: '.$cust->email.'</p>';
               }
               ?>
             </div>
           </div>

           <div class="form-group">
            <label class="col-md-2 control-label" for="delivery_sate">Nature of Project</label>
            <div class="col-md-6">
              <input type="text" name="txt_name" id="txt_name" value="<?php echo @$quote->product;?>" class="form-control" required="">
            </div>
            <?php if($has_referal > 0 && $company->enable_referral == 1) { 
              if($this->session->userdata("clms_front_user_group")  != 9 ){
                ?>
                <label class="col-md-1 control-label" for="delivery_sate">Lead Type</label>
                <div class="col-md-3">
                 <select name="lead_type" class="form-control required">
                   <option value="">Lead Type</option>
                   <?php 
                   foreach ($lead_types->result() as $row) {
                    ?>
                    <option value="<?php echo $row->type_id; ?>"><?php echo $row->type_name;?></option>
                    <?php
                  }
                }
                ?>
              </select>
            </div>
            <?php } ?>
          </div>



          <div class="form-group">
            <label class="col-md-2 control-label"></label>
            <div class="col-md-10">

              <table style="width: 100%;" id="div_document">
                <tr>
                  <td></td>
                  <td width="30%"><strong>Package</strong></td>
                  <td width="30%"><strong>Short Description</strong></td>
                  <td><strong>Quantity</strong></td>
                  <td><strong>Price</strong></td>
                  <td><strong>Total</strong></td>
                </tr>
                <?php 
                $i = 1;
                if(isset($quote_inverters)){
                  foreach (@$quote_inverters as $intverter) {
                    ?>
                    <tr id="tr_<?php echo $i;?>">
                     <td>
                       <?php 
                       if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm1('inverter',"ADD")) {
                        ?>
                        <a href="javascript:void(0);" class="link_package " rel='<?php echo $i;?>'><i class="glyphicon glyphicon-plus"></i></a>
                        <?php } ?>
                      </td>
                      <td>  
                       <select name="package_desc[]" data-plugin-selectTwo  id="package_desc_<?php echo $i;?>" rel="<?php echo $i;?>" class="form-control package_name"  required>
                        <option value="">Select</option>
                        <?php 
                        foreach ($inverters as $row){
                          ?>
                          <option value="<?php echo $row->name;?>" rel="<?php echo $row->price;?>" <?php echo $row->name == $intverter->descriptions ? 'selected="selected"' : '';?>><?php echo $row->name;?></option>
                          <?php
                        }
                        ?>
                      </select>
                    </td>
                    <td>  
                     <input type="text" name="short_desc[]" value="<?php echo $intverter->short_desc;?>" rel="<?php echo $i;?>" id="package_short_desc_<?php echo $i;?>" class="short_desc form-control" >

                   </td>
                   <td> <input type="text" name="package_qty[]" value="<?php echo $intverter->quantity;?>" rel="<?php echo $i;?>" id="package_qty_<?php echo $i;?>" class="package_qty form-control" ></td>
                   <td><input type="text" name="package_price[]" value="<?php echo $intverter->price;?>" rel="<?php echo $i;?>" id="package_price_<?php echo $i;?>" class="package_price form-control number" ></td>
                   <td>
                    <input type="text" name="package_amount[]" value="<?php echo $intverter->quantity * $intverter->price;?>" rel="<?php echo $i;?>" id="package_amount_<?php echo $i;?>" class="package_amount form-control number" >
                  </td>
                  <td><a href="javascript:void(0);" class="link_remove " rel="<?php echo $i;?>">  <span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a></td>
                </tr>
                <?php
                $i++;
              }}

              ?>
              <tr id="tr_<?php echo $i;?>">
                <td>
                 <?php 
                 if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm1('inverter',"ADD")) {
                  ?>
                  <a href="javascript:void(0);" class="link_package " rel='<?php echo $i;?>'><i class="glyphicon glyphicon-plus"></i></a>
                  <?php } ?>
                </td>
                <td>  
                 <select name="package_desc[]" data-plugin-selectTwo  id="package_desc_<?php echo $i;?>" rel="<?php echo $i;?>" class="form-control package_name"  required>
                  <option value="">Select</option>
                  <?php 
                  foreach ($inverters as $row){
                    ?>
                    <option value="<?php echo $row->name;?>" rel="<?php echo $row->price;?>" ><?php echo $row->name;?></option>
                    <?php
                  }
                  ?>
                </select>

              </td>
              <td >  
               <input type="text" name="short_desc[]" value="" rel="<?php echo $i;?>" id="package_short_desc_<?php echo $i;?>" class="short_desc form-control" >

             </td>
             <td> <input type="text" name="package_qty[]" value="1" rel="<?php echo $i;?>" id="package_qty_<?php echo $i;?>" class="package_qty form-control" ></td>
             <td><input type="text" name="package_price[]" value="0" rel="<?php echo $i;?>" id="package_price_<?php echo $i;?>" class="package_price form-control number" ></td>
             <td>
              <input type="text" name="package_amount[]" value="0" rel="<?php echo $i;?>" id="package_amount_<?php echo $i;?>" class="package_amount form-control number">
            </td>
            <td><a href="javascript:void(0);" class="link_remove " rel="<?php echo $i;?>">  <span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a></td>
          </tr>

        </table>
        <a href="javascript:void(0);" id="add_more" class="">Add more package</a>
      </div>

    </div>

    <div class="form-group">
     <label class="col-md-2 control-label" for="price">Regular Price</label>
     <div class="col-md-3">
       <input type="text" name="price" id="price" value="<?php if(isset($quote->price)) echo $quote->price; else echo '0';?>" class="form-control required number" readonly="" >

     </div>
     <label class="col-md-2 control-label" for="price">Discount</label>
     <div class="col-md-3">
       <input type="text" name="discount" id="discount" value="<?php if(isset($quote->discount)) echo $quote->discount; else echo '0';?>" class="form-control required number" >

     </div>
     <div class="col-md-2">
       <input type="checkbox" name="is_flat" id="is_flat" value="1" <?php if(@$quote->is_flat > 0) echo 'checked="checked"';?>> Is Percentage?

     </div>
   </div>


   <?php
   if(isset($quote->price)){
     if($quote->is_included == 1){
      $subtotal = $quote->total_price - $quote->gst;
    }else{
      $subtotal = $quote->total_price;
    }
  }else{
    $subtotal = 0;
  }

  ?>
  <div class="form-group">

   <label class="col-md-2 control-label" for="price">Sub Total</label>
   <div class="col-md-3">
     <input type="text" name="subtotal" id="subtotal" value="<?php echo $subtotal;?>" class="form-control required number" readonly="" >
   </div>
 </div>

 <?php if($has_referal > 0 && $company->enable_referral == 1 && $company->enable_discount_referred_customer == 1) { ?>
 <div class="form-group" id="div_referral_discount" <?php if(@$cust->referral_id == 0) echo 'style="display:none;"';?>>
   <label class="col-md-2 control-label" for="price">Discount to Referred Customer <?php echo ($company->is_referred_percentage == 1) ? '%' : '';?> </label>
   <div class="col-md-3">
    <input type="hidden" name="is_referral_percentage" id="is_referral_percentage" value="<?php echo $company->is_referred_percentage;?>">
    <input type="text" name="referral_discount" id="referral_discount" value="<?php if(@$cust->referral_id > 0) echo $company->referred_discount; else echo 0;?>" class="form-control required number" readonly="" >
  </div>
  <label class="col-md-2 control-label" for="price"> Total After referral discount</label>
  <div class="col-md-3">
   <input type="text" name="referal_subtotal" id="referal_subtotal" value="<?php echo @$total_ater_referral;?>" class="form-control required number" readonly="" >
   <input type="hidden" name="referal_discount_amount" id="referal_discount_amount" value="<?php echo @$discount;?>" class="form-control required number" readonly="" >
 </div>
</div>
<?php } ?>

<div class="form-group">
 <label class="col-md-2 control-label" for="price"><span class="span_gst"></span> Applicable</label>
 <div class="col-md-3">
   <input type="radio" name="gst_applicable" id="gst_yes" value="1" <?php if($company->gst != 0) echo 'checked="checked"';?>  > Yes &nbsp;&nbsp;
   <input type="radio" name="gst_applicable" id="gst_no" value="0" <?php if($company->gst == 0) echo 'checked="checked"';?>  > No
 </div>
</div>

<div id="div_gst" <?php if($company->gst == 0) echo 'style="display:none;"';?>>
 <div class="form-group">
   <label class="col-md-2 control-label" for="price"></label>
   <div class="col-md-4">
     <input type="radio" name="radio_gst" id="gst_exclude" value="1" <?php if($company->gst == 2) echo 'checked="checked"';?>> Price excluding <span class="span_gst"></span> &nbsp;&nbsp;
     <input type="radio" name="radio_gst" id="gst_include" value="0" <?php if($company->gst == 1) echo 'checked="checked"';?>> Price including <span class="span_gst"></span>
   </div>
   <label class="col-md-1 control-label" for="price"><span class="span_gst"></span></label>
   <div class="col-md-3">
    <input type="text" name="gst" id="gst" value="<?php if(isset($quote->gst)) echo $quote->gst; else echo '0';?>" class="form-control required number" readonly="" >
  </div>
</div>
<br>
</div>

<div class="form-group">
 <label class="col-md-2 control-label" for="price">Total Price</label>
 <div class="col-md-3">
   <input type="text" name="total_price" id="total_price" value="<?php if(isset($quote->total_price)) echo $quote->total_price; else echo '0';?>" class="form-control required number" readonly="" >
 </div>
 <label class="col-md-2 control-label" for="price">Minimum Deposit (%)</label>
 <div class="col-md-3">
   <input type="text" name="minimum_deposit" value="" class="form-control number" >
 </div>
</div>
<div class="form-group" >
  <label class="col-md-2 control-label" for="payment_method">Advance payment:</label>
  <div class="col-md-3">
    <input type="text" name="advance_payment" id="advance_payment" value="" class="form-control ">
  </div>
  <label class="col-md-2 control-label" for="payment_method">Payment Method:</label>
  <div class="col-md-3">
    <select name="payment_method" data-plugin-selectTwo  id="payment_method" class="form-control">
      <option value="">Select</option>
      <option value="Bank Transfer">Bank Transfer</option>
      <option value="COD">COD</option>
      <option value="">Credit Card</option>
      <option value="">Paypal</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="price">Finance Options</label>
  <div class="col-md-3">
   <input type="checkbox" name="finance" id="finance" value="1" <?php if(@$quote->finance_option == '1') echo 'checked="checked"'; ?>>
 </div>
 <div class="col-md-7" id="div_payment_term" <?php if(@$quote->finance_option == '0') echo 'style="display:none;"'; ?> >
  <label class="col-md-3 control-label" for="price">Payment Terms</label>
  <div class="col-md-6" style="padding-right: 30px;">
   <select name="payment_terms" data-plugin-selectTwo  id="payment_terms" class="form-control">
     <option value="">Select</option>
     <?php 
     for($i = 1; $i<=12; $i++){
      ?>
      <option value="<?php echo $i;?>" <?php if(@$quote->payment_term == $i) echo 'selected="selected"';?>><?php echo $i; if($i == '1') echo ' month'; else echo ' months';?></option>
      <?php
    }
    ?>
  </select>
</div>
</div>
</div>



<div class="form-group">
 <label class="col-md-2 control-label" for="description">Project Features</label>
 <div class="col-md-8">
   <textarea name="description" id="description" class="form-control"><?php echo @$quote->description;?></textarea>
 </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="quote_from">Attach Document</label>
  <div class="col-md-3">
    <select multiple data-plugin-selectTwo name="docs[]" id="docs" class="form-control" >
      <option value="">Select</option>
      <?php 
      foreach ($docs as $row){
        ?>
        <option value="<?php echo $row->content_id;?>" ><?php echo $row->name;?></option>
        <?php
      }
      ?>

    </select>
  </div>
</div>

<div class="form-group">
 <label class="col-md-2 control-label" for="description">Special Note</label>
 <div class="col-md-8">
   <textarea name="note" id="note" class="form-control" rows="4"><?php echo @$quote->note;?></textarea>
 </div>
</div>



<div class="form-group">
 <label class="col-md-2 control-label" for="quote_status">Timeline</label>
 <div class="col-md-3">
   <select name="timeline" id="timeline" data-plugin-selectTwo  class="form-control required" >
    <option value="">Select</option>
    <?php 
    foreach ($panels as $row){
      ?>
      <option value="<?php echo $row->threatre_id;?>" <?php if(@$quote->timeline == $row->threatre_id) echo 'selected="selected"';?> ><?php echo $row->name;?></option>
      <?php
    }
    ?>

  </select>
</div>
<div class="col-md-1">
 <?php 
 if ($this->session->userdata("clms_front_userid") != "" && $this->usermodel->checkperm1('threatre',"ADD")) {
  ?>
  <a href="javascript:void(0);" id="link_timeline" class="link_package "><i class="glyphicon glyphicon-plus"></i></a>
  <?php } ?>
</div>
<div class="col-md-3">
  <input type="checkbox" name="chk_timeline" value="1"> Don't display in quote confirmation
</div>
</div>


<div class="form-group" <?php if($company->chk_field1 == 0) echo 'style="display:none;"';?>>
 <label class="col-md-2 control-label" for="description"> <?php echo $company->project_test_label == ''?'Project Testing':$company->project_test_label; ?> </label>
 <div class="col-md-8">
   <textarea name="testing" id="testing" class="form-control" rows="4"><?php echo $company->txt_field1 == ''?'All development and testing will be done under AusNep testing server and Customer can see and do user level testing from there. ':$company->txt_field1;?></textarea>
 </div>
 <div class="col-md-2">
  <input type="checkbox" name="chk_test" value="1" <?php if($company->chk_field1 == 0) echo 'checked="checked"';?>> Don't display in quote confirmation
</div>
</div>

<div class="form-group" <?php if($company->chk_field2 == 0) echo 'style="display:none;"';?>>
 <label class="col-md-2 control-label" for="description"><?php echo $company->payment_term_label == ''?'Payment Terms':$company->payment_term_label; ?></label>
 <div class="col-md-8">
   <textarea name="payment" id="payment" class="form-control" rows="4"><?php echo $company->txt_field2 == ''?'All development and testing will be done under AusNep testing server and Customer can see and do user level testing from there. ':$company->txt_field2;?></textarea>
 </div>
 <div class="col-md-2">
  <input type="checkbox" name="chk_payment" value="1" <?php if($company->chk_field2 == 0) echo 'checked="checked"';?>> Don't display in quote confirmation
</div>
</div>




<div class="form-group">
 <label class="col-md-2 control-label" for="price">Order_status</label>
 <div class="col-md-3">
   <?php if($this->session->userdata("clms_front_user_group") == 9){ ?>
   <select name="order_status" id="order_status" data-plugin-selectTwo  class="form-control required" >
    <option value="">Select</option>
    <option value="15" selected="selected">Pending</option>
  </select>
  <?php }else{ ?>
  <select name="order_status" id="order_status" data-plugin-selectTwo  class="form-control required" >
    <option value="">Select</option>
    <?php 
    foreach ($status as $row){
      ?>
      <option value="<?php echo $row->threatre_id;?>" <?php if(@$row->threatre_id == '16') echo 'selected="selected"';?> ><?php echo $row->name;?></option>
      <?php
    }
    ?>
  </select>
  <?php } ?>

</div>
<label class="col-md-2 control-label" for="price">Invoice</label>
<div class="col-md-3">
  <?php  if($this->session->userdata("clms_front_user_group") == 9){ ?>
  <select name="invoice_status" id="invoice_status" data-plugin-selectTwo  class="form-control required" >
    <option value="">Select</option>
    <option value="6" selected="selected">Due</option>
  </select>
  <?php }else{ ?>
  <select name="invoice_status" id="invoice_status" data-plugin-selectTwo  class="form-control required" >
    <option value="">Select</option>
    <?php 
    foreach ($invoices as $row){
      ?>
      <option value="<?php echo $row->status_id;?>" <?php if(@$row->status_id == '6') echo 'selected="selected"';?>><?php echo $row->status_name;?></option>
      <?php
    }
    ?>
  </select>
  <?php } ?>
</div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="price"></label>
  <div class="col-md-8">
   <input type="checkbox" name="send_email" value="1" checked=""> Send email automatically
 </div>
</div>


</div>
<div class="form-group">
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="tab" value="<?php echo $this->input->get("tab");?>">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("dashboard/order/");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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



<?php 
$this->load->view("add_customer");
$this->load->view("quote/popup");
$this->load->view("customer/popup");
?>


<script type="text/javascript">
  $(document).ready(function(){
    
    $(document).on('click','.link_package',function() {
      var id = $(this).attr("rel");
      $("#txt_row_number").val(id);
      $('#form_package_model').modal();
    });

    $("#link_timeline").click(function(){
     $('#form_timeline_model').modal();
   })

    $("#form_account").validate();
    $('#link_account').click(function() {
      $('#form_account_model').modal();
    });

    $("#form").validate();
    $("#form_package").validate();
    $("#form_timeline").validate();

    $('#link_customer').click(function() {
      $('#form_customer_model').modal();
    });

    $("#form_customer").validate();



    $(document).on("click","#billing123",function(){ 
      if($(this).is(":checked")){
        $("#delivery_address_1").val($("#bill_address_1").val());
        $("#delivery_address_2").val($("#bill_address_2").val());
        $("#delivery_suburb").val($("#bill_suburb").val());
        $("#delivery_postcode").val($("#bill_postcode").val());
        jQuery("#delivery_country").data("select2").val($("#bill_country").val());
        jQuery("#delivery_state").data("select2").val($("#bill_state").val());
      }
    });

    $("#finance").click(function(){
     if ($(this).prop('checked')==true){ 
      $("#div_payment_term").show();
      $("#payment_terms").addClass("required");
    }else{
      $("#div_payment_term").hide();
      $("#payment_terms").removeClass("required");
    }
  });

    $("#radio_yes").click(function(){
      $("#div_old").show();
      $("#div_new").hide();
    });

    $("#radio_no").click(function(){
      $("#div_old").hide();
      $("#div_new").show();
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
   var gst_val = 0;

   $('input[name=gst_applicable]').click(function(){
    if($(this).val() == 1){
      $("#div_gst").show();
    }else{
      $("#div_gst").hide();
    }
    calculate_price();
  });

   $('input[name=radio_gst]').click(function(){

    calculate_price();
  });



   function get_discount(){
    var amount = 0;
    var discount = $("#discount").val();
    var price = $("#price").val();
    if ($("#is_flat").prop('checked')==true){ 
      if(discount > 0)
        amount = parseFloat(price) * (parseFloat(discount)/100);
    }else{
      amount = discount;
    }

    return amount;
  }

  function get_referral_discount(){
    var referral_discount_amount = 0;
    var referral_discount = $("#referral_discount").val();
    var price_before_referal_discount = $("#subtotal").val();
    if($("#is_referral_percentage").val() == 1){
     if(referral_discount > 0)
      referral_discount_amount = parseFloat(price_before_referal_discount) * (parseFloat(referral_discount)/100);
  }else{
    referral_discount_amount = discount;
  }

  $("#referal_discount_amount").val(referral_discount_amount);

  return referral_discount_amount;
}

function calculate_price(){ 
 var discount = get_discount();
 var price = $("#price").val();
 var sub_total = parseFloat(price) - parseFloat(discount);
 $("#subtotal").val(sub_total);

 var referral_discount = get_referral_discount();
// alert(referral_discount);
var referal_subtotal = parseFloat(sub_total) - parseFloat(referral_discount);
$("#referal_subtotal").val(referal_subtotal);
if($('input[name=gst_applicable]:checked').val() == 1){
  if($('input[name=radio_gst]:checked').val() == 1){
   var gst = (referal_subtotal/100)*10;
   $("#gst").val(gst.toFixed(2));
 }else{
  var total = (referal_subtotal*100)/(100+gst_val);
  var gst = (total/gst_val)*100;
  $("#gst").val(gst.toFixed(2));
  gst = 0;
}

}else{
  var gst = 0;
}

var total_price = parseFloat(gst) + parseFloat(referal_subtotal);
$("#total_price").val(total_price);
}

$("#discount").blur(function(){
  calculate_price();
});

$("#is_flat").click(function(){
  calculate_price();
});

$("#new_customer").click(function(){
  $("#div_customer").show();
  $("#div_old_customer").hide();
});
$("#old_customer").click(function(){
  $("#div_customer").hide();
  $("#div_old_customer").show();
});
var num = <?php echo $i;?>;
var package = '<?php echo json_encode($inverters)?>';
$("#add_more").click(function(){ 
  var cond = 1;
  $(".package_name").each(function(){
    var id = $(this).attr("rel");
    if($("#package_desc_"+id).val() == ""){
     cond = 0;
   }

   if($("#package_qty_"+id).val() == ""){
     cond = 0;
   }

   if($("#package_price_"+id).val() == ""){
     cond = 0;
   }

 });
  if(cond == 0){
   alert_box('',"Enter all package value First.",'Ok');
   return false;
 }

  //var num = $(".package_name").length;
  num = num + 1;
  var package_sel = '<select name="package_desc[]" data-plugin-selectTwo  id="package_desc_'+num+'" class="form-control package_name" rel="'+num+'"  required>  <option value="">Select</option>';
  $.each( JSON.parse(package), function( key, value ) {
    package_sel = package_sel + '<option value="'+value.name+'" rel="'+value.price+'">'+value.name+'</option>';
  });

  package_sel = package_sel + '</select>';
  $("#div_document").append('<tr style="margin-top:10px;" id="tr_'+num+'">'+
    '<td> <a href="javascript:void(0);" class="link_package " rel='+num+'><i class="glyphicon glyphicon-plus"></i></a></td>'+
    '<td>'+package_sel+'</td>'+
    '<td > <input type="text" name="short_desc[]" value="" rel="'+num+'" id="package_short_desc_'+num+'" class="short_desc form-control" > </td>'+
    '<td> <input type="text" name="package_qty[]" value="1" rel="'+num+'" id="package_qty_'+num+'" class="package_qty form-control number" ></td>'+
    '<td><input type="text" name="package_price[]" value="0" rel="'+num+'" id="package_price_'+num+'" class="package_price form-control number" ></td>'+
    '<td><input type="text" name="package_amount[]" value="0" rel="'+num+'" id="package_amount_'+num+'" class="package_amount form-control number" >'+
    '</td>'+
    '<td><a href="javascript:void(0);" class="link_remove " rel="'+num+'"> <span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a></td></tr>');

  (function( $ ) {

    'use strict';

    if ( $.isFunction($.fn[ 'select2' ]) ) {

      $(function() {
        $('[data-plugin-selectTwo]').each(function() {
          var $this = $( this ),
          opts = {};

          var pluginOptions = $this.data('plugin-options');
          if (pluginOptions)
            opts = pluginOptions;

          $this.themePluginSelect2(opts);
        });
      });

    }

  }).apply(this, [ jQuery ]);
});

$(document).on('change','.package_name',function(){
  if($(this).val() == '')
    return false;
  var id = $(this).attr("rel");
  var price = $('option:selected', this).attr('rel');
  var qty = $("#package_qty_"+id).val();
  var package_total = price * qty;
  $("#package_price_"+id).val(price);
  $("#package_amount_"+id).val(package_total);
  $('.package_amount').trigger('blur');
});

$(document.body).on('blur','.package_qty',function(){
 var qty = $(this).val();
 var id = $(this).attr("rel");
 var price = $("#package_price_"+id).val();
 var package_total = price * qty;
 $("#package_amount_"+id).val(package_total);
 $('.package_amount').trigger('blur');
});

$(document.body).on('blur','.package_price',function(){
  var price = $(this).val();
  var id = $(this).attr("rel");
  var qty = $("#package_qty_"+id).val();
  var package_total = price * qty;
  $("#package_amount_"+id).val(package_total);
  $('.package_amount').trigger('blur');
});
$(document.body).on('blur','.package_amount',function(){
  var total_price = 0;
  $(".package_amount").each(function(){
    var price = $(this).val();
    total_price += parseFloat(price);
  });
  $("#price").val(total_price);
  calculate_price();
});
$(document.body).on('click', '.link_remove' ,function(){
  var id = $(this).attr("rel");
  $("#tr_"+id).remove(); 
  $(".package_price").trigger("blur");
});

$("#customer").change(function(){ 
  var customer = $(this).val();
  var referral_id = $('option:selected', this).attr('referral_id');
  if(referral_id == 0){
    $("#referral_discount").val(0);
    $("#div_referral_discount").hide();
  }else{
    
    $("#referral_discount").val('<?php echo $company->referred_discount;?>');
    $("#div_referral_discount").show();
  }
  calculate_price();
  $.ajax({
    url: '<?php echo base_url() ?>quote/getCustomerDetails',
    type: "POST",
    data: "customer_id=" + customer,
    success: function(data) { 
      $("#div_customer_detail").html(data);
    }        
  });
});

$(document).on('change','#account_country',function(){
  var country = $(this).val();
  if(country == '')
    return false;

  $.ajax({
    url: '<?php echo base_url() ?>customer/get_account_detail',
    type: "POST",
    data: "country=" + country,
    success: function(data) { 
      var setting = JSON.parse(data);
      console.log(setting);
      $(".span_abn").html(setting.abn_title)
    }        
  });
});

var country = '<?php echo $company->country;?>';
$.ajax({
  url: '<?php echo base_url() ?>customer/get_account_detail',
  type: "POST",
  data: "country=" + country,
  success: function(data) { 
    var setting = JSON.parse(data);
    gst_val = setting.gst_value;
    $(".span_gst").html(setting.gst_title)
  }        
});
calculate_price();
});

function alert_box(heading='', question, okButtonTxt) {

  var confirmModal = 
  $('<div class="modal" >' +        
    '<div class="modal-dialog" >' +
    '<div class="modal-content ch_mcont" >' +
    '<div class="modal-header ch_mheader">' +
    '<a class="close" data-dismiss="modal" >&times;</a>' +
    '</div>' +

    '<div class="modal-body ch_mbody" style="height:200px;">' +
    '<p>' + question + '</p>' +
    '</div>' +

    '<div class="modal-footer ch_mfooter">' +
    '<a href="#!" id="okButton" class="btn btn-primary" data-dismiss="modal">' + 
    okButtonTxt + 
    '</a>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>');

  confirmModal.modal('show');    
};

</script>
