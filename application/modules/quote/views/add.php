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

        <h2 class="panel-title">Quote : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("quote/add");?>" method="post" enctype='multipart/form-data'>
         <div class="form-group">
           <label class="col-md-2 control-label" for="customer_name"></label>
           <div class="col-md-3">
             <input type="radio" name="customer_type" id="old_customer" value="1" checked="checked"> Existing Customer &nbsp;&nbsp;
             <input type="radio" name="customer_type" id="new_customer" value="2" <?php if(isset($result) || form_error("email")) echo 'checked="checked"';?>> New Customer
           </div>
         </div>
         <div class="form-group" id="div_old_customer" <?php if(isset($result) || form_error("email")) echo 'style="display:none;"';?>>
           <label class="col-md-2 control-label" for="customer_name">Customer</label>
           <div class="col-md-3">
             <select name="customer" id="customer" data-plugin-selectTwo class="form-control required" >
               <option value=""></option>
               <?php 
               foreach ($customers->result() as $row) {
                 ?>
                 <option value="<?php echo $row->id;?>"><?php echo $row->first_name;?> <?php echo $row->last_name;?></option>
                 <?php
               }
               ?>
             </select>

           </div>
           <div class="col-md-3" id="div_customer_detail">
           </div>
         </div>
         <div id="div_customer" <?php if(!isset($result) && !form_error("email")) echo 'style="display:none; padding-bottom:20px;" '; ?>>

          <div class="form-group">
            <label class="col-md-2 control-label" for="company_name">First Name</label>
            <div class="col-md-3">
              <input type="text" name="fname" id="fname" value="<?php echo set_value("fname",@$lead->lead_name);?>" class="form-control "   />
            </div>

            <label class="col-md-2 control-label" for="bill_country">Last Name</label>
            <div class="col-md-3">
              <input type="text" name="lname" id="lname" value="<?php echo set_value("lname",@$lead->lead_lname);?>" class="form-control"  />
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="company_name">Email</label>
            <div class="col-md-3">
            <input type="email" name="email" id="email" value="<?php echo set_value("email",@$lead->email);?>" class="form-control"  />
            </div>

            <label class="col-md-2 control-label" for="company_name">Mobile</label>
            <div class="col-md-3">
            <input type="text" name="mobile" id="mobile" value="<?php echo set_value("mobile");?>" class="form-control number"  />
            </div>
          </div>

     
          <div class="form-group">
            <label class="col-md-2 control-label" for="company_name">DOB</label>
            <div class="col-md-3">
            <input type="text" name="dob" id="dob" data-plugin-datepicker="" value="<?php echo set_value("dob");?>" class="form-control"  />
            </div>

            <label class="col-md-2 control-label" for="company_name">Marital Status</label>
            <div class="col-md-3">
            <select name="is_married" class="form-control " data-plugin-selectTwo>
              <option value="">Select</option>
              <option value="Single" <?php if(set_value("is_married") == "Single") echo 'selected="selected"';?>>Single</option>
              <option value="Married" <?php if(set_value("is_married") == "Married") echo 'selected="selected"';?>>Married</option>
            </select>
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-2 control-label" for="company_name">Passport No</label>
            <div class="col-md-3">
            <input type="text" name="passport_no" id="passport_no" value="<?php echo set_value("passport_no");?>" class="form-control"  />
            </div>

            <label class="col-md-2 control-label" for="bill_country">Phone</label>
            <div class="col-md-3">
            <input type="text" name="phone" id="phone" value="<?php echo set_value("phone",@$lead->phone_number);?>" class="form-control  number"  />
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="company_name">Referral</label>
            <div class="col-md-3">
            <select name="referral" id="user" class="form-control mb-md " data-plugin-selectTwo >
              <option value="">Select</option>
              <?php 
                foreach($users as $user){
                  ?>
                  <option value="<?php echo $user->id;?>" <?php if($user->id == set_value("referral",@$lead->user_id)) echo 'selected="selected"'; ?>><?php echo $user->first_name.' '.$user->last_name;?></option>
                  <?php
                }
                ?>
            </select>
            </div>
            <div class="col-md-1">
              <a href="javascript:void(0);" id="link_user"><i class="glyphicon glyphicon-plus"></i></a>
            </div>
            <label class="col-md-1 control-label" for="company_name">Address</label>
            <div class="col-md-3">
            <input type="text" name="address" id="address" value="<?php echo set_value("address");?>" class="form-control"  />
            </div>
          </div>

          <div class="form-group">
          

            <label class="col-md-2 control-label" for="bill_country">Sex</label>
            <div class="col-md-3">
            <select name="sex" class="form-control " data-plugin-selectTwo>
              <option value="">Select</option>
              <option value="Male" <?php if(set_value("sex") == "Male") echo 'selected="selected"';?>>Male</option>
              <option value="Female" <?php if(set_value("sex") == "Female") echo 'selected="selected"';?>>Female</option>
            </select>
            </div>

            <div class="col-md-2"></div>
          <div class="col-md-3">
            <input type="checkbox" name="send_email" id="send_email" checked="" value="1" > Send Email / Sms
            </div>
          </div>
          </div>

      <div class="form-group">
          <label class="col-md-2 control-label" for="delivery_sate">Nature of Project</label>
          <div class="col-md-10">
           <input type="text" name="txt_name" id="txt_name" value="" class="form-control" required="">
         </div>
       </div>

       

       <div class="form-group">
        <label class="col-md-2 control-label">Price</label>
        <div class="col-md-10 table-responsive">

          <table style="width: 100%;" id="div_document" colspan="10">
            <tr>
              <td></td>
              <td width="30%"><strong>Package</strong></td>
              <td width="30%"><strong>Short Description</strong></td>
              <td><strong>Quantity</strong></td>
              <td><strong>Rate</strong></td>
              <td><strong>Total</strong></td>
            </tr>
            <tr>
              <td>
                <a href="javascript:void(0);" class="link_package " rel='1'><i class="glyphicon glyphicon-plus"></i></a>
              </td>
              <td>   
               <select name="package_desc[]" data-plugin-selectTwo id="package_desc_1" rel="1" class="form-control package_name"  required>
                <option value="">Select</option>
                <?php 
                foreach ($inverters as $row){
                  ?>
                  <option value="<?php echo $row->name;?>" rel="<?php echo $row->price;?>"><?php echo $row->name;?></option>
                  <?php
                }
                ?>
              </select>
            </td>
            <td >  
              <input type="text" name="short_desc[]" value="" rel="1" id="short_desc_1" class="short_desc form-control" >
            </td>
            <td>
              <input type="text" name="package_qty[]" value="1" rel="1" id="package_qty_1" class="package_qty form-control number"  >
            </td>
            <td>
             <input type="text" name="package_price[]" value="0" rel="1" id="package_price_1" class="package_price form-control number" >
           </td>
           <td>
            <input type="text" name="package_amount[]" value="0" rel="1" id="package_amount_1" class="package_amount form-control number" >
          </td>
        </tr>
      </table>
      <a href="javascript:void(0);" id="add_more" class="list-btn btn btn-primary">Add more package</a>
    </div>

  </div>

  <div class="form-group">
   <label class="col-md-2 control-label" for="price">Regular Price</label>
   <div class="col-md-3">
     <input type="text" name="price" id="price" value="0" class="form-control required number" readonly="" >

   </div>
   <label class="col-md-2 control-label" for="price">Discount</label>
   <div class="col-md-3">
     <input type="text" name="discount" id="discount" value="0" class="form-control required number" >
   </div>
   <div class="col-md-2">
     <input type="checkbox" name="is_flat" id="is_flat" value="1"> Is Percentage?
   </div>
 </div>

 <div class="form-group">
   <label class="col-md-2 control-label" for="price">Sub Total</label>
   <div class="col-md-3">
     <input type="text" name="subtotal" id="subtotal" value="0" class="form-control required number" readonly="" >
   </div>
   <label class="col-md-2 control-label" for="price"><span class="span_gst"></span> Applicable</label>
   <div class="col-md-3">
     <input type="radio" name="gst_applicable" id="gst_yes" value="1" <?php if($company->gst != 0) echo 'checked="checked"';?>> Yes &nbsp;&nbsp;
     <input type="radio" name="gst_applicable" id="gst_no" value="0" <?php if($company->gst == 0) echo 'checked="checked"';?> > No
   </div>
 </div>

 <div id="div_gst" <?php if($company->gst == 0) echo 'style="display:none;"';?> >
   <div class="form-group">
     <label class="col-md-2 control-label" for="price"></label>
     <div class="col-md-4">
       <input type="radio" name="radio_gst" id="gst_exclude" value="1" <?php if($company->gst == 2) echo 'checked="checked"';?>> Price excluding <span class="span_gst"></span> &nbsp;&nbsp;
       <input type="radio" name="radio_gst" id="gst_include" value="0" <?php if($company->gst == 1) echo 'checked="checked"';?>> Price including <span class="span_gst"></span>
     </div>
     <label class="col-md-1 control-label" for="price"><span class="span_gst"></span></label>
     <div class="col-md-3">
       <input type="text" name="gst" id="gst" value="0" class="form-control required number" readonly="" >
     </div>
   </div>
   <br>
 </div>

 <div class="form-group">
   <label class="col-md-2 control-label" for="price">Total Price</label>
   <div class="col-md-3">
     <input type="text" name="total_price" id="total_price" value="0" class="form-control required number" readonly="" >
   </div>
  
 </div>

 <div class="form-group" id="" >
  <label class="col-md-2 control-label" for="price"></label>
   <div class="col-md-3">
     <input type="checkbox" name="finance" id="finance" value="1"> Finance Options
   </div>
  <label class="col-md-2 control-label div_payment_term" for="price" style="display:none;">Payment Terms</label>
  <div class="col-md-3 div_payment_term" style="display:none;">
   <select name="payment_terms" data-plugin-selectTwo id="payment_terms" class="form-control">
     <option value=""></option>
     <?php 
     for($i = 1; $i<=12; $i++){
      ?>
      <option value="<?php echo $i;?>"><?php echo $i; if($i == '1') echo ' month'; else echo ' months';?></option>
      <?php
    }
    ?>
  </select>
</div>
</div>



<div class="form-group">
 <label class="col-md-2 control-label" for="description">Project Features</label>
 <div class="col-md-8">
   <textarea name="description" id="description" class="form-control"><?php echo @$result->requirements;?></textarea>
 </div>
</div>

<div class="form-group">
 <label class="col-md-2 control-label" for="description">Special Note</label>
 <div class="col-md-8">
   <textarea name="note" id="note" class="form-control"></textarea>
 </div>
</div>



<div class="form-group">
 <label class="col-md-2 control-label" for="quote_status">Timeline</label>
 <div class="col-md-3">
   <select name="timeline" data-plugin-selectTwo id="timeline" class="form-control required" >
    <option value=""></option>
    <?php 
    foreach ($panels as $row){
      ?>
      <option value="<?php echo $row->threatre_id;?>" ><?php echo $row->name;?></option>
      <?php
    }
    ?>

  </select>
</div>
<div class="col-md-1">
  <a href="javascript:void(0);" id="link_timeline" class=""><i class="glyphicon glyphicon-plus"></i></a>
</div>
<div class="col-md-4 control-label">
  <input type="checkbox" name="chk_timeline" value="1"> Don't display in quote confirmation
</div>
</div>


<div class="form-group"  <?php if($company->chk_field1 == 0) echo 'style="display:none;"';?>>
 <label class="col-md-2 control-label" for="description"> <?php echo $company->project_test_label == ''?'Project Testing':$company->project_test_label; ?> </label>
 <div class="col-md-8">
   <textarea name="testing" id="testing" class="form-control" rows="4">
     <?php echo $company->txt_field1 == ''?'All development and testing will be done under AusNep testing server and Customer can see and do user level testing from there. ':$company->txt_field1;?>
   </textarea>
 </div>
 <div class="col-md-2">
   <input type="checkbox" name="chk_test" value="1" <?php if($company->chk_field1 == 0) echo 'checked="checked"';?>> Don't display in quote confirmation
 </div>
</div>

<div class="form-group" <?php if($company->chk_field2 == 0) echo 'style="display:none;"';?>>
 <label class="col-md-2 control-label" for="description"><?php echo $company->payment_term_label == ''?'Payment Terms':$company->payment_term_label; ?></label>
 <div class="col-md-8">
   <textarea name="payment" id="payment" rows="4" class="form-control">
     <?php echo $company->txt_field2 == ''?'All development and testing will be done under AusNep testing server and Customer can see and do user level testing from there. ':$company->txt_field2;?>
   </textarea>
 </div>
 <div class="col-md-2">
   <input type="checkbox" name="chk_payment" value="1" <?php if($company->chk_field2 == 0) echo 'checked="checked"';?>> Don't display in quote confirmation
 </div>
</div>

<div class="form-group">
 <label class="col-md-2 control-label" for="quote_status">Quote Status</label>
 <div class="col-md-3">
   <select name="quote_status" id="quote_status" data-plugin-selectTwo class="form-control" disabled="true" >
    <option value=""></option>
    <?php 
    foreach ($status as $row){
      ?>
      <option value="<?php echo $row->threatre_id;?>" <?php if($row->threatre_id == '18') echo 'selected="selected"';?>><?php echo $row->name;?></option>
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
    <option value="<?php echo $row->threatre_id;?>" <?php if(@$result->lead_from == $row->threatre_id) echo 'selected="selected"';?>><?php echo $row->name;?></option>
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
      <option value="<?php echo $row->threatre_id;?>" <?php if(@$result->about_us == $row->threatre_id) echo 'selected="selected"';?>><?php echo $row->name;?></option>
      <?php
    }
    ?>

  </select>
</div>
<div class="col-md-1">
      <a href="javascript:void(0);" id="link_about"><i class="glyphicon glyphicon-plus"></i></a>
   </div>

<?php 
$date = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " +15 day");
?>
<label class="col-md-1 control-label">Quote expiry date </label>
<div class="col-md-3">
  <div class="input-group">
    <span class="input-group-addon">
      <i class="fa fa-calendar"></i>
    </span>
    <input type="text" value="<?php echo date('d/m/Y', strtotime("+$company->quote_days days"));?>" name="date" class="form-control datepicker" required>
  </div>
</div>
</div>


<div class="form-group">
  <label class="col-md-2 control-label" for="customer_name">How may we contact you ?</label>
  <div class="col-md-3">
   <input type="radio" name="contact_by" id="by_email" value="1" checked="checked"> Email
   <input type="radio" name="contact_by" id="by_phone" value="2" > Phone
 </div>
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
  <label class="col-md-2 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="lead_id" value="<?php if(set_value("lead_id",$this->input->get("lead_id"))) echo set_value("lead_id",$this->input->get("lead_id")); else echo '0';?>">
    <input type="hidden" name="tab" value="<?php if($this->input->get("tab")) echo '1'; else echo '0'; ?>">
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

<?php $this->load->view("lms/add_purpose");?>

<?php
$this->load->view("popup");
//$this->load->view("customer/popup");
?>

<script type="text/javascript">
 $( function() {
  $( ".datepicker" ).datepicker({ format: 'dd-mm-yyyy',
    startDate: '-0d',
    autoclose: true 
    });
});
 $(document).ready(function(){
   
  $("#link_about").click(function(){ 
      $("#form_about_model").modal();
    });
  $("#link_user").click(function(){ 
      $("#form_user_model").modal();
    });
  $("#chk_referral").click(function(){
    if($(this).prop("checked")){
      $('.txt_password').addClass("required");
      $(".div_password").show();
    }else{
      $('.txt_password').removeClass("required");
      $(".div_password").hide();
    }
  });
  var gst_val = 0;
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


  $(document).on("click",".link_contact_remove",function(){
    var id = $(this).prop("rel"); 
    $("#row_"+id).remove();
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

  $("#fname").addClass("required");
  $("#lname").addClass("required");
  $("#email").addClass("required");
  $("#mobile").addClass("required");
  $("#username").addClass("required");
  $("#password").addClass("required");
  $("#cpassword").addClass("required");
  $("#customer").removeClass("required");
});
$("#old_customer").click(function(){
  $("#div_customer").hide();
  $("#div_old_customer").show();

  $("#fname").removeClass("required");
  $("#lname").removeClass("required");
  $("#email").removeClass("required");
  $("#mobile").removeClass("required");
  $("#username").removeClass("required");
  $("#password").removeClass("required");
  $("#cpassword").removeClass("required");

  $("#customer").addClass("required");
});
var num = 1;
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

     // var num = $(".doccuments").length;

     num = num + 1;
     var package_sel = '<select name="package_desc[]" data-plugin-selectTwo id="package_desc_'+num+'" class="form-control package_name" rel="'+num+'"  required>  <option value="">Select</option>';
     $.each( JSON.parse(package), function( key, value ) {
      package_sel = package_sel + '<option value="'+value.name+'" rel="'+value.price+'">'+value.name+'</option>';
    });

     package_sel = package_sel + '</select>';
     $("#div_document").append('<tr style="margin-top:10px;" id="tr_'+num+'">'+
       '<td><a href="javascript:void(0);" class="link_package " rel="'+num+'"><i class="glyphicon glyphicon-plus"></i></a></td>'+
       '<td>'+package_sel+'</td>'+
       '<td > <input type="text" name="short_desc[]" value="" rel="'+num+'" id="short_desc_'+num+'" class="short_desc form-control" > </td>'+
       '<td> <input type="text" name="package_qty[]" value="1" rel="'+num+'" id="package_qty_'+num+'" class="package_qty form-control number" ></td>'+
       '<td><input type="text" name="package_price[]" value="0" rel="'+num+'" id="package_price_'+num+'" class="package_price form-control number" >'+
       '</td>'+
       ' <td><input type="text" name="package_amount[]" value="0" rel="'+num+'" id="package_amount_'+num+'" class="package_amount form-control number" >'+
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

$("#finance").click(function(){
 if ($(this).prop('checked')==true){ 
  $(".div_payment_term").show();
  $("#payment_terms").addClass("required");
}else{
  $(".div_payment_term").hide();
  $("#payment_terms").removeClass("required");
}
});

$("#billing").click(function(){
  if($(this).is(":checked")){
    $("#delivery_address_1").val($("#bill_address_1").val());
    $("#delivery_address_2").val($("#bill_address_2").val());
    $("#delivery_suburb").val($("#bill_suburb").val());
    $("#delivery_postcode").val($("#bill_postcode").val());
    jQuery("#delivery_country").data("select2").val($("#bill_country").val());

    $.ajax({
      url: '<?php echo base_url() ?>customer/get_states',
      type: "POST",
      data: "country=" + $("#bill_country").val(),
      success: function(data) { 
       $("#delivery_state").html(data);
       jQuery("#delivery_state").data("select2").val($("#bill_state").val());
     }        
   });

  }
});

$(document).on('change','#bill_country',function(){
  var country = $(this).val();
  if(country == '')
    return false;
  $.ajax({
    url: '<?php echo base_url() ?>customer/get_states',
    type: "POST",
    data: "country=" + country,
    success: function(data) { 
     $("#bill_state").html(data);
   }        
 });
});

$(document).on('change','#delivery_country',function(){
  var country = $(this).val();
  if(country == '')
    return false;
  $.ajax({
    url: '<?php echo base_url() ?>customer/get_states',
    type: "POST",
    data: "country=" + country,
    success: function(data) { 
     $("#delivery_state").html(data);
   }        
 });
})

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
