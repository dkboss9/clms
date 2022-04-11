
  <?php 
if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
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

        <h2 class="panel-title">Contracter : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("installer/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Employee Type: </label>
            <div class="col-md-3">
                <select name="employee_type" id="employee_type" class="form-control required">
                  <option value="">Select</option>
                  <option value="Employee" <?php echo $result->employee_type == 'Employee' ? 'selected':''?>>Employee</option>
                  <option value="Contractor" <?php echo $result->employee_type == 'Contractor' ? 'selected':''?>>Contractor</option>
                </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">First Name</label>
            <div class="col-md-3">
              <input type="text" name="first_name" value="<?php echo $result->first_name;?>"  class="form-control" id="first_name" required>
              <?php echo form_error("name");?>
            </div>
            <label class="col-md-2 control-label" for="inputDefault">Last Name</label>
            <div class="col-md-3">
              <input type="text" name="last_name" value="<?php echo $result->last_name;?>"  class="form-control" id="last_name" required>
              <?php echo form_error("last_name");?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Company Name</label>
            <div class="col-md-3">
              <input type="text" name="company_name" value="<?php echo $result->company;?>"  class="form-control" id="company_name" >
              <?php echo form_error("company_name");?>
            </div>
            <label class="col-md-2 control-label" for="inputDefault"><span class="span_abn">ABN</span></label>
            <div class="col-md-3">
              <input type="text" name="abn" value="<?php echo $result->abn;?>" minlength="11" maxlength="11"  class="form-control" id="abn" >
              <?php echo form_error("abn");?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Email</label>
            <div class="col-md-3">
              <input type="text" name="email" value="<?php echo $result->email;?>"  class="form-control email " id="email" required>
              <label id="email_err" class="error"></label>
            </div>
            <label class="col-md-2 control-label" for="inputDefault">Password</label>
            <div class="col-md-3">
              <input type="password" name="password" value=""  class="form-control " id="password" >
              <?php echo form_error("password");?>
            </div>
           
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Hourly Rate</label>
            <div class="col-md-3">
              <input type="text" name="hourly_rate" value="<?php echo $result->hourly_rate;?>"  class="form-control number" id="hourly_rate" required="">
              <?php echo form_error("hourly_rate");?>
            </div>
            <label class="col-md-2 control-label" for="inputDefault">Position Type</label>
            <div class="col-md-3">

             <select name="position" id="position" class="form-control" required="">
               <option value="">Select </option>
               <?php 
               foreach ($positions->result() as $key => $position) {
                 ?>
                 <option value="<?php echo $position->position_title;?>" <?php echo $position->position_title == $result->position_type ? 'selected="selected"':''; ?>><?php echo $position->position_title;?> </option>
                 <?php
               }
               ?>
             </select>
             <?php echo form_error("hourly_rate");?>
           </div>
         </div>

         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Description</label>
          <div class="col-md-9">
            <textarea name="description" class="form-control" id="inputDefault" ><?php echo $result->description;?></textarea>
            <?php echo form_error("description");?>
          </div>
        </div>

        <div class="form-group " >
          <label class="col-md-3 control-label" for="inputDefault">Mobile</label>
          <div class="col-md-3">
           <input type="text" name="mobile" id="mobile" class="form-control" value="<?php echo $result->mobile;?>">
           <?php echo form_error("description");?>
         </div>
         <label class="col-md-2 control-label" for="inputDefault">Phone</label>
            <div class="col-md-3">
              <input type="text" name="phone" value="<?php echo $result->phone;?>"  class="form-control " id="inputDefault" >
              <?php echo form_error("phone");?>
            </div>
       </div>

       <div class="form-group " >
           
          <div class="col-md-3">
           <input type="checkbox" name="add_sms" id="add_sms"> Add to sms subscriber list.
         </div>
         <div class="col-md-3">
           <input type="checkbox" name="add_email" id="add_email"> Add to Newsletter subscriber list.
         </div>
         </div>

     <header class="panel-heading">
      <h2 class="panel-title">Address</h2>
    </header>

    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Address</label>
      <div class="col-md-3">
        <input type="text" name="address" value="<?php echo $result->address;?>"  class="form-control" id="address" >
        <?php echo form_error("address");?>
      </div>
      <label class="col-md-2 control-label" for="inputDefault">Suburb</label>
      <div class="col-md-3">
        <input type="text" name="suburb" value="<?php echo $result->suburb;?>"  class="form-control " id="suburb" >
        <?php echo form_error("suburb");?>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Postcode</label>
      <div class="col-md-3">
        <input type="text" name="postcode" value="<?php echo $result->postcode;?>"  class="form-control" id="postcode" >
        <?php echo form_error("address");?>
      </div>
      <label class="col-md-2 control-label" for="inputDefault">Country</label>
      <div class="col-md-3">
        <select name="account_country" id="account_country"  class="form-control">
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

    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">State</label>
      <div class="col-md-3">
        <select name="state" id="state" class="form-control"  >
          <option value="">Select</option>
          <?php 
          foreach ($states as $row) {
            ?>
            <option  <?php if($row->state_id == $result->state) echo 'selected="selected"';?>  value="<?php echo $row->state_id;?>"><?php echo $row->state_name;?></option>
            <?php
          }
          ?>
        </select>

      </div>
    </div>

    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
      </div>

      <h2 class="panel-title">Avaibility </h2>
    </header>
    <div id="w4-billing" class="tab-pane">
      <?php
      foreach($days as $day){
        $times = $this->installermodel->get_service_time($result->threatre_id,$day->day_id);
        if($times){
          $start = date('H:i',strtotime(@$times->service_start_time));
          $end =  date('H:i',strtotime(@$times->service_end_time));
        }
        ?>
        <input type="hidden" name="day_id[]" value="<?php echo $day->day_id;?>">
        <div class="form-group">
          <label class="col-md-3 control-label" for="productivity"><?php echo $day->day_name; ?></label>
          <div class="col-md-3">
           <select name="start_time[]" id="start_time<?php echo $day->day_id;?>" class="form-control">

            <?php  for ($i=0;$i<=23;$i++){
              for ($j=0;$j<=45;$j=$j+15)
              {
                $time_interval = $i.':'.str_pad($j, 2, '0', STR_PAD_LEFT);
                $time_interval = date('H:i',strtotime($time_interval));
                ?>
                <option value="<?php echo $time_interval;?>" <?php if(@$start == $time_interval) echo 'selected="selected"'; ?>><?php echo $time_interval;?></option>
                <?php
              }
            }?>
          </select>
        </div>
        <div class="col-md-3">
          <select name="end_time[]" id="end_time<?php echo $day->day_id;?>" class="form-control">

            <?php  for ($i=0;$i<=23;$i++){
              for ($j=0;$j<=45;$j=$j+15)
              {
                $time_interval = $i.':'.str_pad($j, 2, '0', STR_PAD_LEFT);
                $time_interval = date('H:i',strtotime($time_interval));
                ?>
                <option value="<?php echo $time_interval;?>" <?php if(@$end == $time_interval) echo 'selected="selected"'; ?>><?php echo $time_interval;?></option>
                <?php
              }
            }?>
          </select>
        </div>
        <label class="col-md-3 control-label"  id="err_serivce<?php echo $day->day_id;?>"></label>
      </div>
      <?php } ?>
    </div>


    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault"></label>
      <div class="col-md-6">
       <input type="hidden" name="status_id" value="<?php echo $result->threatre_id;?>">
       <input type="submit" id="btn-submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
       <a href="<?php echo base_url("installer");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
    $("#email").blur(function(){
      var email = $(this).val();

  $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>index.php/installer/checkemail",
    data: "email="+email+"&userid=<?php echo $result->user_id;?>",
    success: function (msg) {
      if(msg != ''){
        $("#email_err").html(msg);
        $("#btn-submit").attr("disabled",true);
      }else{
        $("#email_err").html(msg);
        $("#btn-submit").attr("disabled",false);
      }
    }
  });
    });
   $("#add_sms").click(function(){
    if($(this).prop("checked")){
   //   $(".div_mobile").show();
      $("#mobile").addClass("required");
    }else{
    // $(".div_mobile").hide();
     $("#mobile").removeClass("required");
   }
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

    $.ajax({
      url: '<?php echo base_url() ?>customer/get_states',
      type: "POST",
      data: "country=" + $("#account_country").val(),
      success: function(data) { 
       $("#state").html(data);
     }        
   });

  });
 });
</script>
