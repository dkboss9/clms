
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

        <h2 class="panel-title">Acrm : Company : [Edit]</h2>
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
            <li>
              <a href="#w4-confirm" data-toggle="tab"><span>4</span>Confirmation</a>
            </li>
          </ul>
        </div>

        <form id="form" method="post" action="<?php echo base_url("company/edit");?>" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
          <div class="tab-content">
            <div id="w4-account" class="tab-pane active">
             <div class="form-group">
              <label class="col-md-3 control-label" for="fname">First Name</label>
              <div class="col-md-6">
                <input type="text" name="fname" id="fname" value="<?php echo $result->first_name;?>" class="form-control" required  />
                <input type="hidden" name="role" id="role" value="3">
                <input type="hidden" name="userid" value="<?php echo $result->userid;?>">
              </div>
            </div>

            <div class="form-group">
             <label class="col-md-3 control-label" for="lname">Last Name</label>
             <div class="col-md-6">
              <input type="text" name="lname" id="lname" value="<?php echo $result->last_name;?>" class="form-control" required />
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">Email</label>
            <div class="col-md-6">
             <input type="email" name="email" id="email" value="<?php echo $result->email;?>" class="form-control" required />
             <?php echo form_error("email");?>
           </div>
         </div>
         <div class="form-group">
          <label class="col-md-3 control-label">Username</label>
          <div class="col-md-6">
           <input type="text" name="username" id="username" class="form-control" value="<?php echo $result->user_name;?>" required />
           <?php echo form_error("username");?>
         </div>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label">Password</label>
        <div class="col-md-6">
         <input type="password" name="password" id="password" class="form-control"  />
       </div>
     </div>

     <div class="form-group">
      <label class="col-md-3 control-label">Powered By</label>
      <div class="col-md-6">
      <input type="checkbox" name="powered_by" id="powered_by"  <?php if($result->powered_by==1) echo 'checked="checked"';?>  value="1" />
     </div>
   </div>
 </div>

 <div id="w4-profile" class="tab-pane">

   <div class="form-group">
     <label class="col-md-3 control-label">Due date</label>
     <div class="col-md-6">
      <input type="text" name="duedatenumber" id="duedatenumber" value="<?php echo $result->duedatenumber;?>" class="form-control number required"   />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Company Name</label>
    <div class="col-md-6">
      <input type="text" name="company" id="company" value="<?php echo $result->company_name;?>" class="form-control" required />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Quote Email</label>
    <div class="col-md-6">
      <input type="text" name="quote_email" id="quote_email" value="<?php echo $result->quote_email;?>" class="form-control" required  />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Order Email</label>
    <div class="col-md-6">
      <input type="text" name="order_email" id="order_email" value="<?php echo $result->order_email;?>" class="form-control" required  />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Address 1</label>
    <div class="col-md-6">
      <input type="text" name="address1" id="address1" value="<?php echo $result->address;?>" class="form-control"  required/>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Address 2</label>
    <div class="col-md-6">
      <input type="text" name="address2" id="address2" value="<?php echo $result->address2;?>" class="form-control"  />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="bill_country">Country</label>
    <div class="col-md-6">
      <select name="bill_country" id="bill_country" required>
        <option value="">Select</option>
        <?php 
        foreach ($countries as $row) {
          ?>
          <option <?php if($row->country_id == $result->country) echo 'selected="selected"';?> value="<?php echo $row->country_id;?>"><?php echo $row->country_name;?></option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>
  <?php
  $states = $this->companymodel->getstates($result->country);
  ?>
  <div class="form-group">
    <label class="col-md-3 control-label" for="bill_state">State</label>
    <div class="col-md-6">
      <select name="bill_state" id="bill_state" >
        <option value="">Select</option>
        <?php 
        foreach ($states as $row) {
          ?>
          <option <?php if($row->state_id == $result->state) echo 'selected="selected"';?> value="<?php echo $row->state_id;?>"><?php echo $row->state_name;?></option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">ABN</label>
    <div class="col-md-6">
      <input type="text" name="abn" id="abn" value="<?php echo $result->abn;?>" class="form-control"  />
    </div>
    <div class="col-md-3">
      <input type="checkbox" name="display_abn" value="1" <?php if($result->display_abn == '1') echo 'checked=""';?>> display in invoice and order
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">Post Code</label>
    <div class="col-md-6">
      <input type="text" name="postcode" id="postcode" value="<?php echo $result->postcode;?>" class="form-control"  />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Phone</label>
    <div class="col-md-6">
     <input type="text" name="phone" id="phone" value="<?php echo $result->phone;?>" class="form-control" required />
   </div>
 </div>

 <div class="form-group">
   <label class="col-md-3 control-label" for="cart_image">Logo</label>
   <div class="col-md-6">
    <?php if($result->thumbnail != "" && file_exists("./assets/uploads/users/thumb/".$result->thumbnail)) echo '<img src="'.SITE_URL."assets/uploads/users/thumb/".$result->thumbnail.'" width="50" height="50">';?>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Replace Logo</label>
  <div class="col-md-6">
   <input type="file" name="logo" id="logo"  class="form-control" />
 </div>
</div>
</div>
<div id="w4-billing" class="tab-pane">
  <div class="form-group">
    <label class="col-sm-3 control-label" for="w4-cc">Credit Card Payment via Phone</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="cc-number" id="w4-cc" value="<?php echo $result->pay_via_phone;?>" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="cc-via-online">Credit card payment via online</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="cc-via-online" id="cc-via-online" value="<?php echo $result->pay_via_online;?>" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="cc-via-paypal">Credit card payment via Paypal</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="cc-via-paypal" id="cc-via-paypal" value="<?php echo $result->cc_via_paypal;?>" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="eway_id">Bank Transfer</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="bank" id="bank" value="<?php echo $result->bank;?>" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="eway_id">BSB</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="bsb" id="bsb" value="<?php echo $result->bsb;?>">
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="eway_id">Account Number</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="account_no" id="account_no" value="<?php echo $result->account_no;?>" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="eway_id">Mail To</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="mail_to" id="mail_to" value="<?php echo $result->mail_to;?>">
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="eway_id">Mail to Address</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="mail_to_address" id="mail_to_address" value="<?php echo $result->mail_to_address;?>" >
    </div>
  </div>


  <div class="form-group">
    <label class="col-sm-3 control-label" for="eway_id">Eway Customer Id</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="eway_id" id="eway_id" value="<?php echo $result->eway_id;?>" >
    </div>
  </div>



  <div class="form-group">
    <label class="col-sm-3 control-label" for="api_username">Paypal API_username</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="api_username" id="api_username" value="<?php echo $result->api_username;?>" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="api_signature">Paypal API_signature</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="api_signature" id="api_signature" value="<?php echo $result->api_signature;?>">
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="api_password">Paypal API_password</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="api_password" id="api_password" value="<?php echo $result->api_password;?>" >
    </div>
  </div>

</div>
<div id="w4-confirm" class="tab-pane">
<?php /*
  <div class="form-group">
    <label class="col-md-3 control-label" for="description">Package</label>
    <div class="col-md-6">
      <select name="package" id="package" class="form-control required">
        <option>Select</option>
        <?php
        foreach ($packages as $row) {
          ?>
          <option value="<?php echo $row->package_id;?>"><?php echo $row->name;?></option>
          <?php
        }
        ?>
      </select>

    </div>
  </div>

  

  <div class="form-group">
    <label class="col-md-3 control-label" for="description">Order Term</label>
    <div class="col-md-6">
      <select name="order_term" id="order_term" class="form-control required">
        <option>Select</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="description">Package Price</label>
    <div class="col-md-6">
     <input type="hidden" name="txt_package_price" id="txt_package_price" value="">
     <span id="span_package_price"></span>
   </div>
 </div>
*/ ?>
<div class="form-group">
  <label class="col-md-3 control-label" for="description">Description</label>
  <div class="col-md-6">
    <textarea name="description"  class="form-control" id="description"  ><?php echo $result->description;?></textarea>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="invoice_status">Status</label>
  <div class="col-md-6">
    <select name="invoice_status" id="invoice_status" class="form-control" required>
     <option value="">Select</option>
     <option value="Due" <?php if($result->invoice_status == "Due") echo 'selected="selected"';?>>Due</option>
     <option value="Paid" <?php if($result->invoice_status == "Paid") echo 'selected="selected"';?>>Paid</option>
   </select>
 </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label" for="join_date">Join Date</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" data-plugin-datepicker="" name="join_date" id="join_date" required="" value="<?php echo date("d/m/Y",$result->join_date);?>">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label" for="expiry_date">Expiry Date</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" data-plugin-datepicker="" name="expiry_date" id="expiry_date" required="" value="<?php echo date("d/m/Y",$result->expiry_date);?>">
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
    <li class="pull-right">
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
    var num = <?php echo $num;?>;
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

});
</script>
