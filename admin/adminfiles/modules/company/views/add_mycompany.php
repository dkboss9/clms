
<style type="text/css">
  table {
    border-collapse: collapse;
  }

  td {
    padding-top: .5em;
    padding-bottom: .5em;
  }
</style>



<div class="row">
  <div class="col-xs-12">
    <section class="panel form-wizard" id="w4">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
          <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss=""></a>
        </div>

        <h2 class="panel-title"> Company : [Add]</h2>
      </header>
      <div class="panel-body">
        <div class="wizard-progress wizard-progress-lg">
          <div class="steps-progress">
            <div class="progress-indicator"></div>
          </div>
          <ul class="wizard-steps">
            <li class="active">
              <a href="#w4-account" data-toggle="tab" aria-expanded="true"><span>1</span>Account Info</a>
            </li>
            <li class="">
              <a href="#w4-profile" data-toggle="tab" aria-expanded="false"><span>2</span>Profile Info</a>
            </li>
            <li>
              <a href="#w4-billing" data-toggle="tab"><span>3</span>Billing Info</a>
            </li>
          </ul>
        </div>

        <form id="form" method="post" action="<?php echo base_url("company/add");?>" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
          <div class="tab-content">
            <div id="w4-account" class="tab-pane active">
             <div class="form-group">
              <label class="col-md-3 control-label" for="fname">First Name</label>
              <div class="col-md-6">
                <input type="text" name="fname" id="fname" value="<?php echo set_value("fname");?>" class="form-control"  required />
                <input type="hidden" name="role" id="role" value="3">
              </div>
            </div>

            <div class="form-group">
             <label class="col-md-3 control-label" for="lname">Last Name</label>
             <div class="col-md-6">
              <input type="text" name="lname" id="lname" value="<?php echo set_value("lname");?>" class="form-control"  required/>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Email</label>
            <div class="col-md-6">
             <input type="email" name="email" id="email" value="<?php echo set_value("email");?>" class="form-control"  required autocomplete="off"/>
             <?php echo form_error("email");?>
           </div>
         </div>

         <div class="form-group">
        <label class="col-md-3 control-label">Password</label>
        <div class="col-md-6">
         <input type="password" name="password" id="password" class="form-control" autocomplete="off" required />
       </div>
     </div>
 </div>
 <div id="w4-profile" class="tab-pane">

   <div class="form-group">
     <label class="col-md-3 control-label">Due date</label>
     <div class="col-md-6">
      <input type="text" name="duedatenumber" id="duedatenumber" value="<?php echo set_value("duedatenumber");?>" class="form-control number required"   />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Company Name</label>
    <div class="col-md-6">
      <input type="text" name="company" id="company" value="<?php echo set_value("company");?>" class="form-control" required  />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Quote Email</label>
    <div class="col-md-6">
      <input type="text" name="quote_email" id="quote_email" value="<?php echo set_value("quote_email");?>" class="form-control" required  />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Order Email</label>
    <div class="col-md-6">
      <input type="text" name="order_email" id="order_email" value="<?php echo set_value("order_email");?>" class="form-control" required  />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Address 1</label>
    <div class="col-md-6">
      <input type="text" name="address1" id="address1" value="<?php echo set_value("address1");?>" class="form-control" required />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Address 2</label>
    <div class="col-md-6">
      <input type="text" name="address2" id="address2" value="<?php echo set_value("address2");?>" class="form-control"  />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="bill_country">Country</label>
    <div class="col-md-6">
      <select name="bill_country" id="bill_country" required >
        <option value="">Select</option>
        <?php 
        foreach ($countries as $row) {
          ?>
          <option <?php if($row->country_id == 13) echo 'selected="selected"';?> value="<?php echo $row->country_id;?>"><?php echo $row->country_name;?></option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="bill_state">State</label>
    <div class="col-md-6">
      <select name="bill_state" id="bill_state" >
        <option value="">Select</option>
        <?php 
        foreach ($states as $row) {
          ?>
          <option value="<?php echo $row->state_id;?>"><?php echo $row->state_name;?></option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">ABN</label>
    <div class="col-md-6">
      <input type="text" name="abn" id="abn" value="<?php echo set_value("abn");?>" class="form-control"  />
    </div>
    <div class="col-md-3">
      <input type="checkbox" name="display_abn" value="1"> display in invoice and order
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">Post Code</label>
    <div class="col-md-6">
      <input type="text" name="postcode" id="postcode" value="<?php echo set_value("postcode");?>" class="form-control"  />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Phone</label>
    <div class="col-md-6">
     <input type="text" name="phone" id="phone" value="<?php echo set_value("phone");?>" class="form-control"  required/>
   </div>
 </div>

 <div class="form-group">
  <label class="col-md-3 control-label">Logo</label>
  <div class="col-md-6">
   <input type="file" name="logo" id="logo"  class="form-control" />
 </div>
</div>
</div>
<div id="w4-billing" class="tab-pane">
  <div class="form-group">
    <label class="col-sm-3 control-label" for="w4-cc">Credit Card Payment via Phone</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="cc-number" id="w4-cc" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="cc-via-online">Credit card payment via online</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="cc-via-online" id="cc-via-online" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="cc-via-paypal">Credit card payment via Paypal</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="cc-via-paypal" id="cc-via-paypal" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="eway_id">Bank Transfer</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="bank" id="bank" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="eway_id">BSB</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="bsb" id="bsb" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="eway_id">Account Number</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="account_no" id="account_no" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="eway_id">Mail To</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="mail_to" id="mail_to" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="eway_id">Mail to Address</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="mail_to_address" id="mail_to_address" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="eway_id">Eway Customer Id</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="eway_id" id="eway_id" >
    </div>
  </div>



  <div class="form-group">
    <label class="col-sm-3 control-label" for="api_username">Paypal API_username</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="api_username" id="api_username" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="api_signature">Paypal API_signature</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="api_signature" id="api_signature" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="api_password">Paypal API_password</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="api_password" id="api_password" >
    </div>
  </div>

</div>

</form>
</div>
<div class="panel-footer">
  <ul class="pager">
    <li class="previous disabled">
      <a><i class="fa fa-angle-left"></i> Previous</a>
    </li>
    <li class="finish hidden pull-right">
      <a class="link_finish">Finish</a>
    </li>
    <li class="next">
      <a>Next <i class="fa fa-angle-right"></i></a>
    </li>
  </ul>
</div>
</section>
</div>
</div>
<!-- end: page -->
</section>
</div>
</section>

<script type="text/javascript">
  $(document).ready(function(){
    $("#package").change(function(){
      var package_id = $(this).val();
      if(package_id == "")
        return false;

      $.ajax({
        url: '<?php echo base_url() ?>company/getPackagePrice',
        type: "POST",
        data: "package_id=" + package_id,
        success: function(data) { 
          if(data != ""){
            $("#order_term").html(data);
          }
        }        
      });

    });

    $(document).on("change","#order_term",function(){
      var price =  $('option:selected', this).attr('price');
      var discountprice =  $('option:selected', this).attr('discountprice');
      if(price > discountprice)
        var price1 = discountprice;
      else
        var price1 = price;
      $("#span_package_price").html(price1);
      $("#txt_package_price").val(price1);
    });

    $(".link_finish").click(function(){
     $("#form").submit();
   });
    $("#bill_country").change(function(){
      var country = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>company/get_state',
        type: "POST",
        data: "country=" + country,
        success: function(data) { 
          if(data != ""){
            $("#bill_state").html(data);
          }
        }        
      });
    });
  });

</script>

<script type="text/javascript">
  $(document).ready(function(){


    $(document.body).on('change', '.package_qty' ,function(){
      var id = $(this).attr("rel");
      if($("#package"+id).val()=="")
        return false;
      var qty = $(this).val();
      var price = $("#unit_price_"+id).val();
      $("#package_price_"+id).val(parseFloat(qty)*parseFloat(price));
      $(".package_price").trigger("blur");
    });


    $(document.body).on('change', '.unit_price' ,function(){
      var id = $(this).attr("rel");
      if($("#package"+id).val()=="")
        return false;
      var price = $(this).val();
      var qty = $("#package_qty_"+id).val();
      $("#package_price_"+id).val(parseFloat(qty)*parseFloat(price));
      $(".package_price").trigger("blur");
    });

    
    $(document.body).on('blur', '.package_price' ,function(){
      var package_total = 0;
      $(".doccuments").each(function(){
        //if ($(this).prop('checked')) {
          var id = $(this).attr('rel');
          var price = $("#package_price_"+id).val();
          package_total+=parseFloat(price);
     // }
     $("#price").val(package_total);
   });
      $("#price").trigger("blur");
    });
    var num = 1;
    $("#add_more").click(function(){
      var cond = 1;
      $(".doccuments").each(function(){
        if($(this).val() == ""){
         cond = 0;

       }

     });
      if(cond == 0){
        alert("Select Package First.");
        return false;
      }

     // var num = $(".doccuments").length;
     num = num + 1;
     $("#div_document").append('<tr style="margin-top:10px;" id="tr_'+num+'">'+
      '<td>  <select name="package[]" id="package'+num+'" rel="'+num+'" class="form-control doccuments">'+
      '<option value="">Select</option>'+
      <?php 
      foreach ($packages as $package) {
       ?>
       '<option value="<?php echo $package->package_id;?>"><?php echo $package->package_name; ?></option>'+
       <?php }?>
       '</select>'+
       '</td>'+
       '<td> <input type="text" name="qty[]" value="1" rel="'+num+'" id="package_qty_'+num+'" class="package_qty" style="width:50px;margin-left:20px;"></td>'+
       '<td> <input type="text" name="unit_price[]" value="0" rel="'+num+'" id="unit_price_'+num+'" class="unit_price" style="width:50px"></td>'+
       '<td> <input type="text" name="package_price[]" value="0" rel="'+num+'" id="package_price_'+num+'" class="package_price" style="width:50px"></td>'+
       '<td><input type="text" name="package_desc[]" value="" rel="'+num+'" id="package_desc_'+num+'" class="package_desc"></td><td><a href="javascript:void(0);" class="link_remove" rel="'+num+'"> Remove</a></td></tr>');
});
$(document.body).on('click', '.link_remove' ,function(){
  var id = $(this).attr("rel");
  $("#tr_"+id).remove(); 
  $(".package_price").trigger("blur");
});
$(document.body).on('change', '.doccuments' ,function(){
  var packageid = $(this).val();
  var id = $(this).attr("rel");
  $.ajax({
    url: '<?php echo base_url() ?>company/get_packageDetails',
    type: "POST",
    data: "packageid=" + packageid,
    success: function(data) { 
     if(data != ""){
      var data = JSON.parse(data);
      var out = "";
      var i;
      console.log(data);
      for(i = 0; i < data.length; i++) {
       // $("#package_qty_"+id).val(data[i].qty);
       $("#unit_price_"+id).val(data[i].price);
       $("#package_price_"+id).val(data[i].price);
       $("#package_desc_"+id).val(data[i].details);
       $(".package_price").trigger("blur");
     }

   }
 }        
}); 

});


$("#price").blur(function(){
  var price = $(this).val();
  if(price == "")
    return false;
  var gst = $(this).attr("rel");
  var total = parseFloat(price) + ((parseFloat(price)/100)*parseFloat(gst));
  $("#total").val(total);
  var shipping = $("#shipping").val();
  $("#grand").val(parseFloat(shipping)+parseFloat(total));
});

$("#total").blur(function(){
  var gst = $(this).attr("rel");
  var total = $(this).val();
  if(total == "")
    return false;
  var price = (parseFloat(total)*100)/(parseFloat(gst)+100);
  $("#price").val(price);
  var shipping = $("#shipping").val();
  $("#grand").val(parseFloat(shipping)+parseFloat(total));
});
$("#shipping").blur(function(){
  var shipping = $(this).val();
  var total = $("#total").val();
  $("#grand").val(parseFloat(shipping)+parseFloat(total));
});

// $("#duedatenumber").datepicker({
//   format: 'dd-mm-yyyy',
// });

});
</script>
