<form id="form_lead" action="<?php echo base_url("appointment/edit_appointment");?>" method="post" enctype='multipart/form-data'>
  <?php if(isset($error)){ ?>
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

    <?php echo $error; ?>
  </div>
  <?php  } ?>

  <div class="form-group">
    <label class="col-md-3 control-label">Booking Date</label>
    <div class="col-md-6">
      <div class="input-group">
        <span class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </span>
        <input type="text" data-plugin-datepicker="" name="booking_date" id="booking_date" value="<?php echo date("d/m/Y",strtotime($result->booking_date))?>" class="form-control">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">Booking Time</label>
    <div class="col-md-6">
      <div class="input-group">
        <span class="input-group-addon">
          <i class="fa fa-clock-o"></i>
        </span>
        <input type="text" data-plugin-timepicker="" name="booking_time" id="booking_time" value="<?php echo $result->booking_time;?>" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }">
      </div>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="purpose">Purpose</label>
    <div class="col-md-6">
      <select class="form-control mb-md" name="purpose">
        <option value="">Select</option>
        <?php 
        foreach($purpose as $row){
          ?>
          <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $result->purpose)  echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>

  <!-- <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Are you from Nepal?</label>
    <div class="col-md-6">
      <input type="radio" name="from_nepal" id="nepal_yes" value="1" <?php if($result->from_nepal == '1') echo 'checked="checked"';?> class="required">Yes
      <input type="radio" name="from_nepal" id="nepal_no" value="0" <?php if($result->from_nepal == '0') echo 'checked="checked"';?>  class="required">No
    </div>

  </div> -->

  <div class="form-group" id="div_nepal" <?php if($result->from_nepal == '0') echo 'style="display:none;"';?>>
    <label class="col-md-3 control-label" for="">Select your interested country</label>
    <div class="col-md-6">
      <select class="form-control mb-md" name="country">
        <option value="">Country</option>
        <?php
        foreach ($countries as $country) {
         ?>
         <option <?php if("Australia" == $country->country_name) echo 'selected="selected"';?> value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
         <?php
       }
       ?>
     </select>
   </div>
 </div>

 <div class="form-group" id="div_located" <?php if($result->from_nepal == '1') echo 'style="display:none;"';?>>
  <label class="col-md-3 control-label" for="inputDefault">Where are you located at the moment?</label>
  <div class="col-md-6">
    <select class="form-control mb-md" name="country">
      <option value="">Country</option>
      <?php
      foreach ($countries as $country) {
       ?>
       <option <?php if($result->country == $country->country_name) echo 'selected="selected"';?> value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
       <?php
     }
     ?>
   </select>
 </div>
</div>


<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">First Name</label>
  <div class="col-md-6">
    <input type="text" name="name" value="<?php echo $result->lead_name;?>"  class="form-control required" id="" >
    <?php echo form_error("name");?>
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Last Name</label>
  <div class="col-md-6">
    <input type="text" name="lname" value="<?php echo $result->lead_lname;?>"  class="form-control required" id="" >

  </div>
</div>



<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Email</label>
  <div class="col-md-6">
    <input type="email" name="email" value="<?php echo $result->email;?>"  class="form-control required" id="email" >
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">Mobile</label>
  <div class="col-md-6 control-label">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-phone"></i>
      </span>
      <input id="phone" name="phone" value="<?php echo $result->phone_number;?>" data-plugin-masked-input=""  class="form-control number">
    </div>
  </div>
</div>


<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="lead_id" value="<?php echo $result->lead_id;?>">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>
</form>

<script src="<?php echo base_url("");?>assets/javascripts/theme.init.js"></script>