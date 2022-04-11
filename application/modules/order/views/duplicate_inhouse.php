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
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("order/duplicate");?>" method="post" enctype='multipart/form-data'>
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
               <select name="customer" data-plugin-selectTwo id="customer" class="form-control required">
                 <option value=""></option>
                 <?php 
                 foreach ($customers->result() as $row) {
                   ?>
                   <option value="<?php echo $row->customer_id;?>" <?php if(@$quote->customer_id == $row->customer_id) echo 'selected="selected"';?>><?php echo $row->customer_name;?></option>
                   <?php
                 }
                 ?>
               </select>

             </div>
             <div class="col-md-1">
              <a href="javascript:void(0);" id="link_customer" class=""><i class="glyphicon glyphicon-plus"></i></a>
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
    <input type="text" name="txt_name" id="txt_name" value="<?php echo $quote->product;?>" class="form-control" required="">
  </div>
</div>



<div class="form-group">
 <label class="col-md-2 control-label" for="description">Project Features</label>
 <div class="col-md-8">
   <textarea name="description" id="description" class="form-control"><?php echo @$quote->description;?></textarea>
 </div>
</div>

<div class="form-group">
<label class="col-md-2 control-label" for="description">Date</label>
 <div class="col-md-3">
   <input type="text" id="date" name="date" class="form-control datepicker_job" value="<?php echo date("d/m/Y",strtotime($quote->inhouse_date));?>" readonly>
 </div>
 <label class="col-md-2 control-label" for="no_of_people">No of peoples</label>
 <div class="col-md-3">
   <input type="number" min="1" id="no_of_people" name="no_of_people" class="form-control required" value="<?php echo @$quote->no_of_people;?>">
 </div>
</div>








<div class="form-group">
 <label class="col-md-2 control-label" for="price">Order status</label>
 <div class="col-md-3">
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
</div>
<label class="col-md-2 control-label" for="price">Deadline</label>
<div class="col-md-3">
 <input type="text" class="datepicker_job form-control required" value="<?php echo date("d/m/Y",strtotime($quote->expiry_date));?>" name="deadline" id="#deadline" readonly>
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
  <input type="hidden" name="is_inhouse" value="1">
  <input type="hidden" name="order_id" value="<?php echo $quote->order_id;?>">
    <input type="hidden" name="tab" value="<?php echo $this->input->get("tab");?>">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("dashboard/inhouse_order/");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
   $(".datepicker_job").datepicker({
    format: 'dd/mm/yyyy',
    startDate: '-0d'
});
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
    var gst = (total/gst_val)*100;
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
