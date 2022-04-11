



<!-- start: page -->
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
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Leads : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form_lead" action="<?php echo base_url("lms/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-2 control-label" for="inputDefault">Select contact</label>
            <div class="col-md-3">
              <select name="contact" id="contact" data-plugin-selectTwo class="form-control">
                  <option value="">Select</option>
                  <?php 
                      foreach($contacts->result() as $contact){
                    
                        ?>
                         <option value="<?php echo $contact->id;?>" <?php echo $result->student_id == $contact->id ? 'selected' : '';?> firstname="<?php echo trim($contact->first_name);?>" lastname="<?php echo trim($contact->last_name);?>" email="<?php echo $contact->email;?>" phone="<?php echo $contact->phone;?>" address="<?php echo $contact->address?>"><?php echo $contact->first_name;?> <?php echo $contact->last_name;?></option>
                        <?php
                      }
                  ?>
              </select>
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-2 control-label" for="inputDefault">First Name</label>
            <div class="col-md-3">
              <input type="text" name="name" value="<?php echo $result->lead_name;?>"  class="form-control" id="inputDefault" required>
              <?php echo form_error("name");?>
            </div>
            <label class="col-md-3 control-label" for="inputDefault">Last Name</label>
            <div class="col-md-3">
              <input type="text" name="lname" value="<?php echo $result->lead_lname;?>"  class="form-control" id="inputDefault" required>
              <?php echo form_error("name");?>
            </div>
          </div>





          <div class="form-group">
            <label class="col-md-2 control-label" for="inputDefault">Email</label>
            <div class="col-md-3">
              <input type="email" name="email" value="<?php echo $result->email;?>"  class="form-control" id="email" required>
            </div>
            <label class="col-md-3 control-label">Mobile</label>
            <div class="col-md-3 control-label">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-phone"></i>
                </span>
                <input id="phone" name="phone" value="<?php echo $result->phone_number;?>" data-plugin-masked-input=""  class="form-control number">
              </div>
            </div>
          </div>



          <div class="form-group">
            <label class="col-md-2 control-label" for="purpose">Purpose</label>
            <div class="col-md-3">
              <select class="form-control mb-md" name="purpose" data-plugin-selectTwo  id="sel_purpose">
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
            <div class="col-md-1">
              <a href="javascript:void(0);" id="link_purpose"><i class="glyphicon glyphicon-plus"></i></a>
            </div>
            <label class="col-md-2 control-label" for="about_us">How did you know about us? </label>
            <div class="col-md-3">
              <select name="about_us" id="about_us" data-plugin-selectTwo class="form-control mb-md" >
                <option value="">Select</option>
                <?php 
                foreach($about_us as $row){
                  ?>
                  <option value="<?php echo $row->threatre_id;?>" <?php if($row->threatre_id == $result->about_us) echo 'selected="selected"';?>><?php echo $row->name;?></option>
                  <?php
                }
                ?>

              </select>
            </div>
            <div class="col-md-1">
              <a href="javascript:void(0);" id="link_about"><i class="glyphicon glyphicon-plus"></i></a>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2 control-label" for="">Want to book for counselling ?</label>
            <div class="col-md-6">
              <input type="radio" name="conselling" id="consell_yes" value="1" class="required" <?php if($result->is_booked == '1') echo 'checked="checked"';?>> Yes &nbsp;&nbsp;&nbsp;
              <input type="radio" name="conselling" id="consell_no" value="0" class="required" <?php if($result->is_booked == '0') echo 'checked="checked"';?>> No
            </div>
          </div>

          <div id="div_booking" <?php if($result->is_booked == '0') echo 'style="display:none"'; ?> >
            <div class="form-group">
                <label class="col-md-2 control-label">Consultant</label>
                <div class="col-md-3">
                  <select name="consultant" id="consultant" class="form-control mb-md" data-plugin-selectTwo >
                    <option value="">Select</option>
                    <?php 
                    foreach ($employees as $row) {
                    ?>
                    <option value="<?php echo $row->id;?>" <?php if($row->id == $result->consultant) echo 'selected="selected"';?>><?php echo $row->first_name.' '.$row->last_name;?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-1">
                <a href="javascript:void(0);" id="link_consultant"><i class="glyphicon glyphicon-plus"></i></a>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Booking Date</label>
              <div class="col-md-3">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input type="text"  value="<?php echo date("d-m-Y",strtotime($result->booking_date))?>" name="booking_date" id="booking_date" class="form-control datepicker" autocomplete="off">
                </div>
              </div>
              <label class="col-md-3 control-label">Booking Time</label>
              <div class="col-md-3">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </span>
                  <select name="booking_time" id="booking_time" class="form-control">
                    <option></option>
                    <?php echo $booking_time_options;?>
                  </select>
                  <!-- <input type="text" data-plugin-timepicker="" name="booking_time" id="booking_time" value="<?php echo $result->booking_time;?>" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }"> -->
                </div>
              </div>
            </div>
         
         </div>
         <div class="form-group">
         </div>

         <div class="form-group">
          <label class="col-md-2 control-label" for="inputDefault">Country</label>
          <div class="col-md-3">
            <select class="form-control mb-md" name="country" data-plugin-selectTwo >
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
         <label class="col-md-3 control-label" for="inputDefault">Description</label>
         <div class="col-md-3">
           <textarea name="requirement" class="form-control"><?php echo $result->requirements;?></textarea>

         </div>
       </div>


       <div class="form-group">
        <label class="col-md-2 control-label" for="inputDefault">Lead Source</label>
        <div class="col-md-3">
          <select name="lead_source" id="lead_source" class="form-control mb-md" data-plugin-selectTwo >
           <option value="">Select</option>
           <?php 
           foreach($source as $row){
            ?>
            <option value="<?php echo $row->type_id;?>" <?php if($result->lead_source == $row->type_id) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
            <?php
          }
          ?>
        </select>
      </div>
      <div class="col-md-1">
        <a href="javascript:void(0);" id="link_source"><i class="glyphicon glyphicon-plus"></i></a>
      </div>
        <label class="col-md-2 control-label" for="inputDefault">Weightage</label>
        <div class="col-md-3">
         <select name="weightage" class="form-control mb-md required">
          <option value="">Select</option>
          <?php 
          foreach($weightage as $row){
            ?>
            <option <?php if($result->weightage_id == $row->weightage_id) echo 'selected="selected"';?> value="<?php echo $row->weightage_id;?>"><?php echo $row->name;?></option>
            <?php
          }
          ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-2 control-label" for="inputDefault">Referral</label>
      <div class="col-md-3">
        <input type="radio" name="referral"  id="referral_yes" value="1" <?php if($result->referral == '1') echo 'checked="checked"';?>> Yes &nbsp;&nbsp;&nbsp;
        <input type="radio" name="referral"  id="referral_no" value="0" <?php if($result->referral == '0') echo 'checked="checked"';?>> No
      </div>
      <label class="col-md-3 control-label div_refferal" for="inputDefault"  <?php if($result->referral != '1') echo 'style="display:none;"';?>>Referral</label>
      <div class="col-md-3 div_refferal"  <?php if($result->referral != '1') echo 'style="display:none;"';?>>
        <select name="user" id="user" class="form-control mb-md" data-plugin-selectTwo >
          <option value="">Select</option>
          <?php 
          foreach($users as $user){
            ?>
            <option value="<?php echo $user->id;?>" <?php if($result->user_id == $user->id) echo 'selected="selected"';?>><?php echo $user->first_name.' '.$user->last_name;?></option>
            <?php
          }
          ?>
        </select>
      </div>
      <div class="col-md-1 div_refferal" <?php if($result->referral != '1') echo 'style="display:none;"';?>>
          <a href="javascript:void(0);" id="link_user"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
    
  </div>

  <div class="form-group">
    <label class="col-md-2 control-label">Reminder Date</label>
    <div class="col-md-3">
      <div class="input-group">
        <span class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </span>
        <input type="text"  name="date" value="<?php echo date("d-m-Y",$result->reminder_date);?>" class="form-control datepicker" autocomplete="off" required>
      </div>
    </div>
    <label class="col-md-3 control-label">Reminder Time</label>
    <div class="col-md-3">
      <div class="input-group">
        <span class="input-group-addon">
          <i class="fa fa-clock-o"></i>
        </span>
        <input type="text" data-plugin-timepicker="" value="<?php echo $result->reminder_time;?>" name="time" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }">
      </div>
    </div>
  </div>


  <header class="panel-heading" style="margin-bottom: 10px;">
    <h2 class="panel-title">Status Update</h2>
  </header>
  <div class="form-group">
    <label class="col-md-2 control-label" for="inputDefault">Updates</label>
    <div class="col-md-8">
      <?php 
      $updates = $this->lmsmodel->get_updates($result->lead_id);
      if(count($updates) >0){
        foreach ($updates as $update) {
          echo '<p>'.$update->content.'</p>';
          echo '<p>Added by: '.$update->first_name.' '.$update->last_name.' at '.date("d/m/Y",$update->added_date).'</p>';
          echo '<hr>';
        }}else{
          echo "No Update added yet.";
        }
        ?>

      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label" for="inputDefault">Today</label>
      <div class="col-md-9">
        <textarea name="status_update" class="form-control"></textarea>
      </div>
    </div>

    <div class="form-group">

      <label class="col-md-2 control-label" for="inputDefault">Status</label>
      <div class="col-md-3">
       <select name="status" id="sel_status" class="form-control mb-md" data-plugin-selectTwo >
        <?php
        foreach($status as $stat){
         ?>
         <option <?php if($result->status_id == $stat->status_id) echo 'selected="selected"';?>value="<?php echo $stat->status_id;?>"><?php echo $stat->status_name;?></option>
         <?php
       }
       ?>
     </select>
   </div>
   <div class="col-md-1">
    <a href="javascript:void(0);" id="link_status"><i class="glyphicon glyphicon-plus"></i></a>
  </div>
  <label class="col-md-1 control-label" for="inputDefault"></label>
  <div class="col-md-3">
    <input type="checkbox" name="send_email" value="1" > Send Email
  </div>
</div>



<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="lead_id" value="<?php echo $result->lead_id;?>">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("dashboard");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
<?php $this->load->view("add_purpose");?>
<script type="text/javascript">
  $(document).ready(function(){
   $("#link_purpose").click(function(){ 
    $("#form_purpose_model").modal();
  });

   $("#link_about").click(function(){ 
    $("#form_about_model").modal();
  });

   $("#link_consultant").click(function(){ 
    $("#form_consultant_model").modal();
  });

   $("#link_source").click(function(){ 
    $("#form_source_model").modal();
  });

   $("#link_user").click(function(){ 
    $("#form_user_model").modal();
  });


   $("#link_status").click(function(){ 
    $("#form_status_model").modal();
  });

   $("#form_status").validate();
   $("#form_user").validate();
   $("#form_source").validate();
   $("#form_about").validate();
   $("#form_consultant").validate();
   $("#form_purpose").validate();
   $("#form_lead").validate();
   $("#consell_yes").click(function(){
    $("#div_booking").show();
    $("#booking_date").addClass("required");
    $("#booking_time").addClass("required");
  });

   $("#consell_no").click(function(){
    $("#div_booking").hide();
    $("#booking_date").removeClass("required");
    $("#booking_time").removeClass("required");
  });

   $("#referral_yes").click(function(){
    $(".div_refferal").show()
    $("#user").addClass("required");
  });

   $("#referral_no").click(function(){
    $(".div_refferal").hide()
    $("#user").removeClass("required");
  });
 });

 $( function() {
  $( ".datepicker" ).datepicker({ format: 'dd-mm-yyyy',
    startDate: '-0d',
    autoclose: true 
    });
    $('#booking_date').datepicker().on('changeDate', function(e) {
      var appointment_date = e.format(0,"dd-mm-yyyy");
      var consultant = $("#consultant").val();
      get_appointmentTime(consultant,appointment_date);
    });

    $("#consultant").change(function(){
      var appointment_date = $('#booking_date').val();
      var consultant = $(this).val();
      get_appointmentTime(consultant,appointment_date);
    });
} );

function get_appointmentTime(consultant,appointment_date){
  $.ajax({
    method: "POST",
    url: "<?php echo base_url('lms/get_appointment_time_list')?>",
    data: { consultant: consultant, appointment_date: appointment_date }
  })
  .done(function( msg ) {
    $("#booking_time").html(msg);
  });
}
</script>