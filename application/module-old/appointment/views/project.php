
<script type="text/javascript">
  $("#document").ready(function(){
    $("#existing_project").click(function(){
      $("#customer_details").hide();
      $("#payment").hide();
      $("#div_customer").show();
    });

    $("#new_project").click(function(){
      $("#customer_details").show();
      $("#payment").show();
      $("#div_customer").hide();

    });
    $("#customer").change(function(){
      var id = $(this).val();

      $.ajax({
        url: '<?php echo base_url() ?>appointment/get_customerDetails',
        type: "POST",
        data: "customerid=" + id,
        success: function(data) { 
          $("#customer_info").html(data);
        }        
      });
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

        <h2 class="panel-title">Customer : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>
         <div class="form-group">
           <label class="col-md-3 control-label" for="customer_name"></label>
           <div class="col-md-6">
             <input type="radio" name="project_type" value="new_project" id="new_project" checked=""> New Project &nbsp;&nbsp;&nbsp;&nbsp;
             <input type="radio" name="project_type" value="existing_project" id="existing_project"> Existing Project

           </div>
         </div>
         <div id="customer_details">
          <div class="form-group">
            <label class="col-md-3 control-label" for="customer_name">Customer Name</label>
            <div class="col-md-6">
              <input type="text" name="customer_name" value="<?php echo $result->lead_name;?>"  class="form-control" id="customer_name" required>

            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="company_name">Company Name</label>
            <div class="col-md-6">
              <input type="text" name="company_name" value="<?php echo $result->company_name;?>"  class="form-control" id="company_name" >

            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="contact_number">Contact Number</label>
            <div class="col-md-6">
              <input type="text" name="contact_number" value="<?php echo $result->phone_number;?>"  class="form-control" id="contact_number" >
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="email">Email</label>
            <div class="col-md-6">
              <input type="email" name="email" value="<?php echo set_value("email",$result->email);?>"  class="form-control" id="email" required>
              <?php echo form_error("email");?>
            </div>
          </div>
        </div>
        <header class="panel-heading" style="margin-bottom: 10px;">
          <h2 class="panel-title">Project details</h2> 

        </header>
        <div class="form-group">
          <label class="col-md-3 control-label" for="title">Project Title</label>
          <div class="col-md-6">
            <input type="text" name="title" value="" class="form-control" id="title" required>

          </div>
        </div>
        
        <div class="form-group">
          <label class="col-md-3 control-label" for="lead_type">Lead Type</label>
          <div class="col-md-6">
            <select name="lead_type" class="form-control" id="lead_type" required>
              <option value="">Select</option>
              <?php 
              foreach ($lead_types as $row) {
               ?>
               <option <?php if($result->lead_type == $row->type_id) echo 'selected="selected"';?> value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
               <?php
             }
             ?>
           </select>
         </div>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Sale Reps</label>
        <div class="col-md-6">
          <select name="user" class="form-control mb-md" required>
            <option value="">Select</option>
            <?php 
            foreach($users as $user){
              ?>
              <option <?php if($result->user_id == $user->userid) echo 'selected="selected"';?> value="<?php echo $user->userid;?>"><?php echo $user->first_name.' '.$user->last_name;?></option>
              <?php
            }
            ?>
          </select>
        </div>
      </div>

      <div class="form-group" style="display:none;" id="div_customer">
        <label class="col-md-3 control-label" for="customer">Customer</label>
        <div class="col-md-6">
          <select name="customer" id="customer">
           <option value="">Select</option>
           <?php 
           foreach ($customer as $row) {
            ?>
            <option value="<?php echo $row->customer_id;?>"><?php echo $row->customer_name;?></option>
            <?php
          }
          ?>
        </select>

      </div>
      <label class="col-md-3 control-label" id="customer_info"></label>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Category</label>
      <div class="col-md-6">
        <select name="category" id="category" class="form-control mb-md" required>
          <option value="">Select</option>
          <?php 
          foreach ($category as $cat) {
            ?>
            <option <?php if($result->category == $cat->cat_id) echo 'selected="selected"';?> value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
            <?php 
          }
          ?>
        </select>
      </div>
    </div>
    <?php
    $subs = $this->appointmentmodel->get_category($result->category);
    if(count($subs) > 0 && $result->category > 0)
      $display = '';
    else
      $display = 'style="display:none;"';
    ?>
    <div class="form-group" id="div_sub_category" <?php echo $display;?>>
      <label class="col-md-3 control-label" for="inputDefault">Sub Category</label>
      <div class="col-md-6">
       <select name="sub_category" id="sub_category" class="form-control mb-md" >
        <option value="">Select</option>
        <?php 

        foreach ($subs as $sub) {
         ?>
         <option <?php if($result->subcategory == $sub->cat_id) echo 'selected="selected"';?> value="<?php echo $sub->cat_id;?>"><?php echo $sub->cat_name;?></option>
         <?php 
       }
       ?>
     </select>
   </div>
 </div>
 <?php
 $subs2 = $this->appointmentmodel->get_category($result->subcategory);
 if(count($subs2) > 0 && $result->subcategory > 0)
  $display = '';
else
  $display = 'style="display:none;"';
?>
<div class="form-group" id="div_sub_category2" <?php echo $display;?>>
  <label class="col-md-3 control-label" for="inputDefault">Sub Category 2nd</label>
  <div class="col-md-6">
    <select name="sub_category2" id="sub_category2" class="form-control mb-md" >
      <option value="">Select</option>
      <?php 

      foreach ($subs2 as $sub2) {
       ?>
       <option <?php if($result->subcategory2 == $sub2->cat_id) echo 'selected="selected"';?> value="<?php echo $sub2->cat_id;?>"><?php echo $sub2->cat_name;?></option>
       <?php 
     }
     ?>
   </select>
 </div>
</div>

<?php
$subs3 = $this->appointmentmodel->get_category($result->subcategory2);
if(count($subs3) > 0 && $result->subcategory2 > 0)
  $display = '';
else
  $display = 'style="display:none;"';
?>
<div class="form-group" id="div_sub_category3" <?php echo $display;?>>
  <label class="col-md-3 control-label" for="inputDefault">Sub Category 3rd</label>
  <div class="col-md-6">
    <select name="sub_category3" id="sub_category3" class="form-control mb-md" >
      <option value="">Select</option>
      <?php 

      foreach ($subs3 as $sub3) {
       ?>
       <option <?php if($result->subcategory3 == $sub3->cat_id) echo 'selected="selected"';?> value="<?php echo $sub3->cat_id;?>"><?php echo $sub3->cat_name;?></option>
       <?php 
     }
     ?>
   </select>
 </div>
</div>

<?php
$subs4 = $this->appointmentmodel->get_category($result->subcategory3);
if(count($subs4) > 0 && $result->subcategory3 > 0)
  $display = '';
else
  $display = 'style="display:none;"';
?>
<div class="form-group" id="div_sub_category4" <?php echo $display;?>>
  <label class="col-md-3 control-label" for="inputDefault">Sub Category 4th</label>
  <div class="col-md-6">
    <select name="sub_category4" id="sub_category4" class="form-control mb-md" >
      <option value="">Select</option>
      <?php 

      foreach ($subs4 as $sub4) {
       ?>
       <option <?php if($result->subcategory4 == $sub4->cat_id) echo 'selected="selected"';?> value="<?php echo $sub4->cat_id;?>"><?php echo $sub4->cat_name;?></option>
       <?php 
     }
     ?>
   </select>
 </div>
</div>


<div class="form-group">
  <label class="col-md-3 control-label" for="description">Description</label>
  <div class="col-md-6">
    <textarea name="description"  class="form-control" id="description"  ></textarea>
  </div>
</div>



<div class="form-group">
  <label class="col-md-3 control-label" for="price">Product Price</label>
  <div class="col-md-6">
    <input type="text" name="price" value="" rel="<?php echo $gst->config_value;?>"  class="form-control" id="price" required>

  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="price">GST</label>
  <div class="col-md-6">
    <input type="hidden" name="gst" value="<?php echo $gst->config_value;?>"  class="form-control" id="gst" required>

    <label class="col-md-3 control-label" for="price"><?php echo $gst->config_value;?> %</label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="total">Total</label>
  <div class="col-md-6">
    <input type="text" name="total" value="" rel="<?php echo $gst->config_value;?>" class="form-control" id="total" >
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="shipping">Shipping</label>
  <div class="col-md-6">
    <input type="text" name="shipping" value="0"  class="form-control" id="shipping" >

  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="grand">Grand Total</label>
  <div class="col-md-6">
    <input type="text" name="grand" value="0"  class="form-control" id="grand" readonly="">
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="project_status">Status</label>
  <div class="col-md-6">
    <select name="project_status" id="project_status">
     <option value="">Select</option>
     <?php 
     foreach ($project_status as $row) {
      ?>
      <option value="<?php echo $row->status_id;?>"><?php echo $row->status_name;?></option>
      <?php
    }
    ?>
  </select>

</div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="note">Admin Note</label>
  <div class="col-md-6">

    <textarea name="note" class="form-control" id="note" ></textarea>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Start Date</label>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="start_date" class="form-control" required>
    </div>
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">End Date</label>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="end_date" class="form-control" required>
    </div>
  </div>
</div>

<div id="payment">
  <header class="panel-heading" style="margin-bottom: 10px;">
    <h2 class="panel-title">Billing Address</h2>
  </header>

  <div class="form-group">
    <label class="col-md-3 control-label" for="bill_address_1">Address 1</label>
    <div class="col-md-6">
      <input type="text" name="bill_address_1" value=""  class="form-control" id="bill_address_1" >

    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="bill_address_2">Address 2</label>
    <div class="col-md-6">
      <input type="text" name="bill_address_2" value=""  class="form-control" id="bill_address_2" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="bill_suburb">Suburb</label>
    <div class="col-md-6">
      <input type="text" name="bill_suburb" value=""  class="form-control" id="bill_suburb" >

    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="bill_postcode">Post Code</label>
    <div class="col-md-6">
      <input type="text" name="bill_postcode" value=""  class="form-control" id="bill_postcode" >

    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="bill_country">Country</label>
    <div class="col-md-6">
      <select name="bill_country" id="bill_country" >
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
  <header class="panel-heading" style="margin-bottom: 10px;">
    <h2 class="panel-title">Delivery Address</h2> 
    <input type="checkbox" name="billing" id="billing" > Same as Billing address
  </header>

  <div class="form-group">
    <label class="col-md-3 control-label" for="delivery_address_1">Address 1</label>
    <div class="col-md-6">
      <input type="text" name="delivery_address_1" value=""  class="form-control" id="delivery_address_1" >

    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="delivery_address_2">Address 2</label>
    <div class="col-md-6">
      <input type="text" name="delivery_address_2" value=""  class="form-control" id="delivery_address_2" >
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="delivery_suburb">Suburb</label>
    <div class="col-md-6">
      <input type="text" name="delivery_suburb" value=""  class="form-control" id="delivery_suburb" >

    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="delivery_postcode">Post Code</label>
    <div class="col-md-6">
      <input type="text" name="delivery_postcode" value=""  class="form-control" id="delivery_postcode" >

    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="delivery_country">Country</label>
    <div class="col-md-6">
      <select name="delivery_country" id="delivery_country" >
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
    <label class="col-md-3 control-label" for="delivery_sate">State</label>
    <div class="col-md-6">
      <select name="delivery_state" id="delivery_state" >
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

</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("customer");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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

<script type="text/javascript">
  $(document).ready(function(){
    $("#billing").click(function(){
      if($(this).is(":checked")){
        $("#delivery_address_1").val($("#bill_address_1").val());
        $("#delivery_address_2").val($("#bill_address_2").val());
        $("#delivery_suburb").val($("#bill_suburb").val());
        $("#delivery_postcode").val($("#bill_postcode").val());
        jQuery("#delivery_country option[value='"+$("#bill_country").val() +"']").attr('selected', 'selected');
        jQuery("#delivery_state option[value='"+$("#bill_state").val() +"']").attr('selected', 'selected');
      }
    });

    $(document).ready(function(){
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
      $("#category").change(function(){
       $("#div_sub_category").hide();
       $("#div_sub_category2").hide();
       $("#div_sub_category3").hide();
       $("#div_sub_category4").hide();
       jQuery("#sub_category option[value='']").attr('selected', 'selected');
       jQuery("#sub_category2 option[value='']").attr('selected', 'selected');
       jQuery("#sub_category3 option[value='']").attr('selected', 'selected');
       jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
       var catid = $(this).val();
       $.ajax({
        url: '<?php echo base_url() ?>lms/get_subcategory',
        type: "POST",
        data: "catid=" + catid,
        success: function(data) { 
          if(data != ""){
            $("#sub_category").html(data);
            $("#div_sub_category").show();
          }
        }        
      });
     });

      $("#sub_category").on("change",function(){
        $("#div_sub_category2").hide();
        $("#div_sub_category3").hide();
        $("#div_sub_category4").hide();
        jQuery("#sub_category2 option[value='']").attr('selected', 'selected');
        jQuery("#sub_category3 option[value='']").attr('selected', 'selected');
        jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
        var catid = $(this).val();
        $.ajax({
          url: '<?php echo base_url() ?>lms/get_subcategory',
          type: "POST",
          data: "catid=" + catid,
          success: function(data) { 
            if(data != ""){
              $("#sub_category2").html(data);
              $("#div_sub_category2").show();
            }
          }        
        });
      });

      $("#sub_category2").on("change",function(){
        $("#div_sub_category3").hide();
        $("#div_sub_category4").hide();

        jQuery("#sub_category3 option[value='']").attr('selected', 'selected');
        jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
        var catid = $(this).val();
        $.ajax({
          url: '<?php echo base_url() ?>lms/get_subcategory',
          type: "POST",
          data: "catid=" + catid,
          success: function(data) { 
            if(data != ""){
              $("#sub_category3").html(data);
              $("#div_sub_category3").show();
            }
          }        
        });
      });

      $("#sub_category3").on("change",function(){
        $("#div_sub_category4").hide();
        jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
        var catid = $(this).val();
        $.ajax({
          url: '<?php echo base_url() ?>lms/get_subcategory',
          type: "POST",
          data: "catid=" + catid,
          success: function(data) { 
            if(data != ""){
              $("#sub_category4").html(data);
              $("#div_sub_category4").show();
            }
          }        
        });
      });



    });

});
</script>
