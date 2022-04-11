


<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Customer : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("customer/edit");?>" method="post" enctype='multipart/form-data'>
         <div class="form-group">
          <label class="col-md-3 control-label" for="customer_name">Customer Name</label>
          <div class="col-md-6">
            <input type="text" name="customer_name" value="<?php echo $result->customer_name;?>"  class="form-control" id="customer_name" required>
            
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
            <input type="text" name="contact_number" value="<?php echo $result->contact_number;?>"  class="form-control" id="contact_number" >
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="email">Email</label>
          <div class="col-md-6">
            <input type="email" name="email" value="<?php echo $result->email;?>"  class="form-control" id="email" required>
            <?php echo form_error("email");?>
          </div>
        </div>

        <header class="panel-heading" style="margin-bottom: 10px;">
          <h2 class="panel-title">Billing Address</h2>
        </header>

        <div class="form-group">
          <label class="col-md-3 control-label" for="bill_address_1">Address 1</label>
          <div class="col-md-6">
            <input type="text" name="bill_address_1" value="<?php echo $result->billing_address1;?>"  class="form-control" id="bill_address_1" >
            
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="bill_address_2">Address 2</label>
          <div class="col-md-6">
            <input type="text" name="bill_address_2" value="<?php echo $result->billing_address2;?>"  class="form-control" id="bill_address_2" >
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="bill_suburb">Suburb</label>
          <div class="col-md-6">
            <input type="text" name="bill_suburb" value="<?php echo $result->billing_suburb;?>"  class="form-control" id="bill_suburb" >
            
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="bill_postcode">Post Code</label>
          <div class="col-md-6">
            <input type="text" name="bill_postcode" value="<?php echo $result->billing_postcode;?>"  class="form-control" id="bill_postcode" >

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
                <option <?php if($row->country_id == $result->billing_country) echo 'selected="selected"';?> value="<?php echo $row->country_id;?>"><?php echo $row->country_name;?></option>
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
                <option  <?php if($row->state_id == $result->billing_state) echo 'selected="selected"';?> value="<?php echo $row->state_id;?>"><?php echo $row->state_name;?></option>
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
            <input type="text" name="delivery_address_1" value="<?php echo $result->delivery_address1;?>"  class="form-control" id="delivery_address_1" >
            
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="delivery_address_2">Address 2</label>
          <div class="col-md-6">
            <input type="text" name="delivery_address_2" value="<?php echo $result->delivery_address2;?>"  class="form-control" id="delivery_address_2" >
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="delivery_suburb">Suburb</label>
          <div class="col-md-6">
            <input type="text" name="delivery_suburb" value="<?php echo $result->delivery_suburb;?>"  class="form-control" id="delivery_suburb" >
            
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="delivery_postcode">Post Code</label>
          <div class="col-md-6">
            <input type="text" name="delivery_postcode" value="<?php echo $result->delivery_postcode;?>"  class="form-control" id="delivery_postcode" >

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
                <option <?php if($row->country_id == $result->delivery_country) echo 'selected="selected"';?> value="<?php echo $row->country_id;?>"><?php echo $row->country_name;?></option>
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
                <option <?php if($row->state_id == $result->delivery_state) echo 'selected="selected"';?>  value="<?php echo $row->state_id;?>"><?php echo $row->state_name;?></option>
                <?php
              }
              ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault"></label>
          <div class="col-md-6">
            <input type="hidden" name="customer_id" value="<?php echo $result->customer_id;?>">
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

  });
</script>
