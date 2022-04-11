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

        <h2 class="panel-title">Quote : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("quote/edit");?>" method="post" enctype='multipart/form-data'>

          <div class="form-group" >
           <label class="col-md-2 control-label" for="customer_name">Customer</label>
           <div class="col-md-3">
             <select name="customer" data-plugin-selectTwo id="customer" class="form-control">
               <option value=""></option>
               <?php 
               foreach ($customers->result() as $row) {
                 ?>
                 <option value="<?php echo $row->id;?>" <?php if($result->customer_id == $row->id) echo 'selected="selected"';?>><?php echo $row->first_name;?> <?php echo $row->last_name;?></option>
                 <?php
               }
               ?>
             </select>
           </div>
           <div class="col-md-3" id="div_customer_detail">
             <?php
            echo '<p>Name: '.$cust->first_name.''.$cust->last_name.'</p>';
            echo '<p>Passport no: '.$cust->passport_no.'</p>';
            echo '<p>Contact No:'.$cust->mobile.'</p>';
            echo '<p>Email: '.$cust->email.'</p>';
             ?>
           </div>
         </div>


         <div class="form-group">
         </div>

         <div class="form-group">
          <label class="col-md-2 control-label" for="delivery_sate">Nature of Project</label>
          <div class="col-md-10">
            <input type="text" name="txt_name" id="txt_name" value="<?php echo $result->product;?>" class="form-control" required="">
          </div>
        </div>


        <div class="form-group">
          <label class="col-md-2 control-label">Price</label>
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
              foreach ($quote_inverters as $intverter) {
                ?>
                <tr id="tr_<?php echo $i;?>">
                  <td>
                    <a href="javascript:void(0);" class="link_package " rel='<?php echo $i;?>'><i class="glyphicon glyphicon-plus" ></i></a>
                  </td>
                  <td>  
                   <select name="package_desc[]" data-plugin-selectTwo id="package_desc_<?php echo $i;?>" rel="<?php echo $i;?>" class="form-control package_name"  required>
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
                <td >  
                 <input type="text" name="short_desc[]" value="<?php echo $intverter->short_desc;?>" rel="<?php echo $i;?>" id="short_desc_<?php echo $i;?>" class="short_desc form-control" >
                 
               </td>
               <td> <input type="text" name="package_qty[]" value="<?php echo $intverter->quantity;?>" rel="<?php echo $i;?>" id="package_qty_<?php echo $i;?>" class="package_qty form-control" ></td>
               <td><input type="text" name="package_price[]" value="<?php echo $intverter->price;?>" rel="<?php echo $i;?>" id="package_price_<?php echo $i;?>" class="package_price form-control number"></td>
               <td>
                <input type="text" name="package_amount[]" value="<?php echo $intverter->amount;?>" rel="<?php echo $i;?>" id="package_amount_<?php echo $i;?>" class="package_amount form-control number">
              </td>
              <td><a href="javascript:void(0);" class="link_remove " rel="<?php echo $i;?>"> <span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a></td>
            </tr>
            <?php
            $i++;
          }

          ?>
        </table>
        <a href="javascript:void(0);" id="add_more" class="list-btn btn btn-primary">Add more package</a>
      </div>

    </div>

    <div class="form-group">
     <label class="col-md-2 control-label" for="price">Regular Price</label>
     <div class="col-md-3">
       <input type="text" name="price" id="price" value="<?php echo $result->price;?>" class="form-control required number" readonly="" >
     </div>
     <label class="col-md-2 control-label" for="price">Discount</label>
     <div class="col-md-3">
       <input type="text" name="discount" id="discount" value="<?php echo $result->discount;?>" class="form-control required number" >
     </div>
     <div class="col-md-2">
       <input type="checkbox" name="is_flat" id="is_flat" value="1" <?php if($result->is_flat > 0) echo 'checked="checked"';?>> Is Percentage?
     </div>
   </div>

   <div class="form-group">
     <label class="col-md-2 control-label" for="price">Sub Total</label>
     <div class="col-md-3">
       <?php
       if($result->is_included == 1){
        $subtotal = $result->total_price - $result->gst;
      }else{
        $subtotal = $result->total_price;
      }
      ?>
      <input type="text" name="subtotal" id="subtotal" value="<?php echo $subtotal;?>" class="form-control required number" readonly="" >

    </div>
    <label class="col-md-2 control-label" for="price"><span class="span_gst"></span> Applicable</label>
    <div class="col-md-3">
     <input type="radio" name="gst_applicable" id="gst_yes" value="1" <?php if($result->gst_applicable == 1) echo 'checked=""'; ?>  > Yes &nbsp;&nbsp;
     <input type="radio" name="gst_applicable" id="gst_no" value="0" <?php if($result->gst_applicable == 0) echo 'checked=""'; ?>  > No
   </div>
 </div>

 <div id="div_gst" <?php if($result->gst_applicable == 0) echo 'style="display:none;"'; ?> >
   <div class="form-group">
     <label class="col-md-2 control-label" for="price"></label>
     <div class="col-md-4">
       <input type="radio" name="radio_gst" id="gst_exclude" value="1" <?php if($result->is_included == 1) echo 'checked=""'; ?> > Price excluding <span class="span_gst"></span> &nbsp;&nbsp;
       <input type="radio" name="radio_gst" id="gst_include" value="0"  <?php if($result->is_included == 0) echo 'checked=""'; ?> > Price including <span class="span_gst"></span>
     </div>
     <label class="col-md-1 control-label" for="price"><span class="span_gst"></span></label>
     <div class="col-md-3">
       <input type="text" name="gst" id="gst" value="<?php echo $result->gst;?>" class="form-control required number" readonly="" >

     </div>
   </div>

   <br>
 </div>

 <div class="form-group">
   <label class="col-md-2 control-label" for="price">Total Price</label>
   <div class="col-md-3">
     <input type="text" name="total_price" id="total_price" value="<?php echo $result->total_price;?>" class="form-control required number" readonly="" >
   </div>
   
 </div>
 <div class="form-group" id=""  >
 <label class="col-md-2 control-label" for="price"></label>
   <div class="col-md-3">
     <input type="checkbox" name="finance" id="finance" value="1" <?php if($result->finance_option == '1') echo 'checked="checked"'; ?>> Finance Options
   </div> 
 <label class="col-md-2 control-label div_payment_term" for="price" <?php if($result->finance_option != '1') echo 'style="display:none;"'; ?>>Payment Terms</label>
   <div class="col-md-3 div_payment_term" <?php if($result->finance_option != '1') echo 'style="display:none;"'; ?>>
     <select name="payment_terms" data-plugin-selectTwo id="payment_terms" class="form-control">
       <option value="">Select</option>
       <?php 
       for($i = 1; $i<=12; $i++){
        ?>
        <option value="<?php echo $i;?>" <?php if($result->payment_term == $i) echo 'selected="selected"';?>><?php echo $i; if($i == '1') echo ' month'; else echo ' months';?></option>
        <?php
      }
      ?>
    </select>
  </div>
</div>



<div class="form-group">
 <label class="col-md-2 control-label" for="description">Project Features</label>
 <div class="col-md-8">
   <textarea name="description" id="description" class="form-control" rows="4"><?php echo @$result->description;?></textarea>
 </div>
</div>

<div class="form-group">
 <label class="col-md-2 control-label" for="description">Special Note</label>
 <div class="col-md-8">
   <textarea name="note" id="note" class="form-control" rows="4"><?php echo $result->note;?></textarea>
 </div>
</div>



<div class="form-group">
 <label class="col-md-2 control-label" for="quote_status">Timeline</label>
 <div class="col-md-3">
   <select name="timeline" id="timeline" data-plugin-selectTwo class="form-control required" >
    <option value=""></option>
    <?php 
    foreach ($panels as $row){
      ?>
      <option value="<?php echo $row->threatre_id;?>" <?php if($result->timeline == $row->threatre_id) echo 'selected="selected"';?> ><?php echo $row->name;?></option>
      <?php
    }
    ?>
  </select>
</div>
<div class="col-md-1">
  <a href="javascript:void(0);" id="link_timeline" class=""><i class="glyphicon glyphicon-plus"></i></a>
</div>
<div class="col-md-4 control-label">
  <input type="checkbox" name="chk_timeline" value="1" <?php if($result->chk_timeline==1) echo 'checked="checked"';?>> Don't display in quote confirmation
</div>
</div>


<div class="form-group" <?php if($company->chk_field1 == 0) echo 'style="display:none;"';?>> 
 <label class="col-md-2 control-label" for="description"> <?php echo $company->project_test_label == ''?'Project Testing':$company->project_test_label; ?> </label>
 <div class="col-md-8">
   <textarea name="testing" id="testing" class="form-control" rows="4"><?php echo $result->testing;?></textarea>
 </div>
 <div class="col-md-2">
  <input type="checkbox" name="chk_test" value="1" <?php if($result->chk_test==1 || $company->chk_field1 == 0) echo 'checked="checked"';?>> Don't display in quote confirmation
</div>
</div>

<div class="form-group" <?php if($company->chk_field2 == 0) echo 'style="display:none;"';?>>
 <label class="col-md-2 control-label" for="description"><?php echo $company->payment_term_label == ''?'Payment Terms':$company->payment_term_label; ?></label>
 <div class="col-md-8">
   <textarea name="payment" id="payment" class="form-control" rows="4"><?php echo $result->payment_terms;?></textarea>
 </div>
 <div class="col-md-2">
  <input type="checkbox" name="chk_payment" value="1" <?php if($result->chk_payment==1 || $company->chk_field2 == 0) echo 'checked="checked"';?>> Don't display in quote confirmation
</div>
</div>

<div class="form-group">
 <label class="col-md-2 control-label" for="quote_status">Quote Status</label>
 <div class="col-md-3">
   <select name="quote_status" data-plugin-selectTwo id="quote_status" class="form-control"  >
    <option value=""></option>
    <?php 
    foreach ($status as $row){
      ?>
      <option value="<?php echo $row->threatre_id;?>" <?php if($result->quote_satus == $row->threatre_id) echo 'selected="selected"';?>><?php echo $row->name;?></option>
      <?php
    }
    ?>

  </select>
</div>
<label class="col-md-2 control-label" for="quote_from">Quote From</label>
<div class="col-md-3">
 <select name="quote_from" id="quote_from" data-plugin-selectTwo class="form-control" >
  <option value=""></option>
  <?php 
  foreach ($from as $row){
    ?>
    <option value="<?php echo $row->threatre_id;?>" <?php if($result->quote_from == $row->threatre_id) echo 'selected="selected"';?>><?php echo $row->name;?></option>
    <?php
  }
  ?>
</select>
</div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="quote_from">How you know about us?</label>
  <div class="col-md-3">
   <select name="about_us" id="about_us" data-plugin-selectTwo class="form-control" >
    <option value="">Select</option>
    <?php 
    foreach ($abouts as $row){
      ?>
      <option value="<?php echo $row->threatre_id;?>" <?php if($result->about_us == $row->threatre_id) echo 'selected="selected"';?>><?php echo $row->name;?></option>
      <?php
    }
    ?>
  </select>
</div>
<label class="col-md-2 control-label">Quote expiry date </label>
<div class="col-md-3">
  <div class="input-group">
    <span class="input-group-addon">
      <i class="fa fa-calendar"></i>
    </span>
    <input type="text" data-plugin-datepicker="" value="<?php echo date("m/d/Y",$result->expiry_date);?>" name="date" class="form-control datepicker" required>
  </div>
</div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="customer_name">How may we contact you ?</label>
  <div class="col-md-3">
   <input type="radio" name="contact_by" id="old_customer" value="1" checked="checked"> Email
   <input type="radio" name="contact_by" id="new_customer" value="2" <?php if($result->contact_by == '2') echo  'checked="checked"';?> > Phone
 </div>
 <label class="col-md-2 control-label" for="quote_from">Attach Document</label>
 <div class="col-md-3">

   <select multiple data-plugin-selectTwo name="docs[]" id="docs" class="form-control" >
    <option value="">Select</option>
    <?php 
    foreach ($docs as $row){
      ?>
      <option value="<?php echo $row->content_id;?>"  <?php if(in_array($row->content_id, $quote_docs)) echo 'selected="selected"';?>><?php echo $row->name;?></option>
      <?php
    }
    ?>

  </select>
</div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="tab" value="<?php if($this->input->get("tab")) echo '1'; else echo '0'; ?>">
    <input type="hidden" name="lead_id" value="<?php echo $result->lead_id;?>">
    <input type="hidden" name="quote_id" value="<?php echo $result->quote_id;?>">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("quote/listall");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
$this->load->view("popup");
?>
<script type="text/javascript">
   $( function() {
  $( ".datepicker" ).datepicker({ format: 'dd-mm-yyyy',
    startDate: '-0d',
    autoclose: true 
    });
});
  $(document).ready(function(){
    var gst_val = 0;
    $(document).on('click','.link_package',function() {
     var id = $(this).attr("rel");
     $("#txt_row_number").val(id);
     $('#form_package_model').modal();
   });

    $("#link_timeline").click(function(){
     $('#form_timeline_model').modal();
   })

    $("#form").validate();
    $("#form_package").validate();
    $("#form_timeline").validate();

    $("#finance").click(function(){
     if ($(this).prop('checked')==true){ 
      $(".div_payment_term").show();
      $("#payment_terms").addClass("required");
    }else{
      $(".div_payment_term").hide();
      $("#payment_terms").removeClass("required");
    }
  });
    $("#customer").change(function(){
      var customer = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>quote/getCustomerDetails',
        type: "POST",
        data: "customer_id=" + customer,
        success: function(data) { 
          $("#div_customer_detail").html(data);
        }        
      });
    });

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

    function calculate_price(){ 
     var discount = get_discount();
     var price = $("#price").val();
     var sub_total = parseFloat(price) - parseFloat(discount);
     $("#subtotal").val(sub_total);
     if($('input[name=gst_applicable]:checked').val() == 1){
      if($('input[name=radio_gst]:checked').val() == 1){
       var gst = (sub_total/100)*10;
       $("#gst").val(gst.toFixed(2));
     }else{
      var total = (sub_total*100)/(100+gst_val);
      var gst = gst_val > 0 ? (total/gst_val)*100 : 0;
      $("#gst").val(gst.toFixed(2));
      gst = 0;
    }

  }else{
    var gst = 0;
  }

  var total_price = parseFloat(gst) + parseFloat(sub_total);
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

  var num = $(".package_name ").length;
  num = num + 1;
  var package_sel = '<select name="package_desc[]" data-plugin-selectTwo  id="package_desc_'+num+'" class="form-control package_name" rel="'+num+'"  required>  <option value="">Select</option>';
  $.each( JSON.parse(package), function( key, value ) {
    package_sel = package_sel + '<option value="'+value.name+'" rel="'+value.price+'">'+value.name+'</option>';
  });

  package_sel = package_sel + '</select>';
  $("#div_document").append('<tr id="tr_'+num+'">'+
   '<td><a href="javascript:void(0);" class="link_package  " rel="'+num+'"><i class="glyphicon glyphicon-plus"></i></a></td>'+
   '<td>'+package_sel+'</td>'+
   '<td> <input type="text" name="short_desc[]" value="" rel="'+num+'" id="short_desc_'+num+'" class="short_desc form-control" > </td>'+
   '<td> <input type="text" name="package_qty[]" value="1" rel="'+num+'" id="package_qty_'+num+'" class="package_qty form-control number" ></td>'+
   '<td><input type="text" name="package_price[]" value="0" rel="'+num+'" id="package_price_'+num+'" class="package_price form-control number" ></td>'+
   ' <td><input type="text" name="package_amount[]" value="0" rel="'+num+'" id="package_amount_'+num+'" class="package_amount form-control number">'+
   '</td>'+
   '<td><a href="javascript:void(0);" class="link_remove  " rel="'+num+'"> <span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a></td></tr>');

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

var country = '<?php echo $company->country;?>';
$.ajax({
  url: '<?php echo base_url() ?>customer/get_account_detail',
  type: "POST",
  data: "country=" + country,
  success: function(data) { 
    var setting = JSON.parse(data);
    gst_val = setting.gst_value;
    $(".span_gst").html(setting.gst_title);
  }        
});
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
