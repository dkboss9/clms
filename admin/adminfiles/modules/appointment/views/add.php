



<!-- start: page -->
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
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Appointment : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form_lead" action="<?php echo base_url("appointment/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <?php
            $first_name = isset($db->database_name) ? $db->database_name : "";
            $email = isset($db->email) ? $db->email : "";
            $phone = isset($db->phone) ? $db->phone : "";
            if($first_name == "")
            $first_name = isset($student->first_name) ? $student->first_name : "";
            $last_name = isset($student->last_name) ? $student->last_name : "";
            if($email == "")
            $email = isset($student->email) ? $student->email : "";
            if($phone == "")
            $phone = isset($student->phone) ? $student->phone : "";
          ?>

      <div class="form-group">
        <label class="col-md-2 control-label" for="inputDefault">First Name</label>
        <div class="col-md-3">
          <input type="text" name="name" value="<?php echo $first_name;?>"  class="form-control required" id="" >
          <?php echo form_error("name");?>
        </div>
        <label class="col-md-3 control-label" for="inputDefault">Last Name</label>
        <div class="col-md-3">
          <input type="text" name="lname" value="<?php echo $last_name;?>"  class="form-control required" id="" >

        </div>
      </div>

    

      <div class="form-group">
      <label class="col-md-2 control-label" for="email">Counsellor</label>
        <div class="col-md-3">
          <select name="counseller" id="consultant" class="form-control">
            <option value="">Select</option>
            <?php 
              foreach($counselers as $user){
                ?>
                  <option value="<?php echo $user->id;?>"><?php echo $user->first_name;?> <?php echo $user->last_name;?></option>
                <?php
              }
            ?>
          </select>
        </div>
        <div class="col-md-1">
          <a href="javascript:void(0);" id="link_consultant"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
      
        <label class="col-md-2 control-label">Appointment Date</label>
            <div class="col-md-3">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </span>
                <input type="text"  name="booking_date" id="booking_date" class="form-control datepicker" autocomplete="off">
              </div>
            </div>
      </div>

    
          <div class="form-group">
            <label class="col-md-2 control-label">Appointment Time</label>
            <div class="col-md-3">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-clock-o"></i>
                </span>
                <select name="booking_time" id="booking_time" class="form-control">
                    <option></option>
                  </select>
                <!-- <input type="text" data-plugin-timepicker="" name="booking_time" id="booking_time" value="0:00" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }"> -->
              </div>
            </div>
            <div class="col-md-1">
                <a href="javascript:void(0);" id="link_booking_time"><i class="glyphicon glyphicon-plus"></i></a>
              </div>
            <label class="col-md-2 control-label" for="email">Email</label>
            <div class="col-md-3">
              <input type="email" name="email" value="<?php echo @$email;?>"  class="form-control required" id="email" >
            </div>
          </div>

   
      <div class="form-group">
        <label class="col-md-2 control-label" for="email">Lead By</label>
        <div class="col-md-3">
          <select name="lead_by" id="lead_source" class="form-control">
            <option value="">Select</option>
            <?php 
                foreach($source as $row){
                  ?>
                   <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
                  <?php
                }
            ?>
          </select>
        </div>
        <div class="col-md-1">
          <a href="javascript:void(0);" id="link_source"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
        <label class="col-md-2 control-label" for="country">Country</label>
        <div class="col-md-3">
          <select class="form-control mb-md" name="country" data-plugin-selectTwo>
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

    

      <div class="form-group">
      <label class="col-md-2 control-label">Mobile</label>
        <div class="col-md-3 control-label">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-phone"></i>
            </span>
            <input id="phone" name="phone" value="<?php echo @$phone;?>" data-plugin-masked-input=""  class="form-control number">
          </div>
        </div>
        <label class="col-md-3 control-label">Reminder Date</label>
            <div class="col-md-3">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </span>
                <input type="text"  name="redminder_date" id="redminder_date" class="form-control datepicker">
              </div>
            </div>
      </div>

          <div class="form-group">
            <label class="col-md-2 control-label">Reminder Time</label>
            <div class="col-md-3">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-clock-o"></i>
                </span>
                <input type="text" data-plugin-timepicker="" name="reminder_time" id="reminder_time" value="0:00" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }">
              </div>
            </div>
            <label class="col-md-3 control-label" for="email">Note</label>
            <div class="col-md-3">
              <textarea name="note" class="form-control"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2 control-label"></label>
            <div class="col-md-3">
              <div class="input-group">
               <input type="checkbox" name="send_email" value="1"> &nbsp; Send Email
              </div>
            </div>
           
          </div>
      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault"></label>
        <div class="col-md-6">
          <input type="hidden" name="student_id" value="<?php echo $this->input->get("student_id")??0?>">
          <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
          <?php 
          if($this->input->get("project") == 1 && $this->input->get("student_id") > 0){
            ?>
              <a href="<?php echo base_url("project/appointments/".$this->input->get("student_id"));?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
            <?php
          }else{
            ?>
              <a href="<?php echo base_url("dashboard/appointment");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
            <?php
          }
        ?>
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
<div class="modal fade" id="form_booking_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Employee Avaibility</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form name="form_emp_avaibility" id="form_emp_avaibility" action="javascript:addempavaibility();">
      <div class="modal-body-bookingtime">
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php 
$this->load->view("lms/add_purpose");
?>
<script type="text/javascript">
    function addempavaibility(){
    var day = [];
    var start_time = [];
    var end_time = [];
    $(".day_id").each(function(){
      var dayid = $(this).val();
      day.push(dayid);
      start_time.push($("#start_time"+dayid).val());
      end_time.push($("#end_time"+dayid).val());
    });

    var consaltant = $("#consultant").val();

    $.ajax({
        method: "POST",
        url: "<?php echo base_url('lms/addempavaibility')?>",
        data: { day: day,start_time : start_time, end_time:end_time,consaltant:consaltant}
      })
      .done(function( msg ) {
       $("#consultant").trigger("change");
       $('#form_booking_model').modal("hide");
      });
    
  }
  $(document).ready(function(){
    $("#link_purpose").click(function(){ 
      $("#form_purpose_model").modal();
    });
    $("#form_purpose").validate();
    $("#form_lead").validate();
    $("#nepal_yes").click(function(){
      $("#div_nepal").show();
      $("#div_located").hide();
    });

    $("#nepal_no").click(function(){
      $("#div_nepal").hide();
      $("#div_located").show();
    });

    $("#link_consultant").click(function(){ 
      $("#form_consultant_model").modal();
    });

    
    $("#link_source").click(function(){ 
      $("#form_source_model").modal();
    });

    $('#link_booking_time').click(function(){
      var consultant = $("#consultant").val();
      if(consultant == ""){
        alert("Please select consultant first to add employee avaibility");
        return false;
      }
      
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('lms/set_employee_avaibility')?>",
        data: { consultant: consultant }
      })
      .done(function( msg ) {
        $(".modal-body-bookingtime").html(msg);
        $('#form_booking_model').modal();
      });
    
    });


  });

  $( function() {
    $( ".datepicker" ).datepicker({ format: 'dd-mm-yyyy',
      startDate: '-0d',
      autoclose: true });

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