



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

        <h2 class="panel-title">Counselling : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form_lead" action="<?php echo base_url("appointment/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-2 control-label" for="email">Counsel By</label>
            <div class="col-md-3">
              <select name="counseller" id="consultant" class="form-control">
                <option value="">Select</option>
                <?php 
                  foreach($counselers as $user){
                    ?>
                        <option value="<?php echo $user->id;?>" <?php if($result->consultant == $user->id) echo 'selected';?>><?php echo $user->first_name;?> <?php echo $user->last_name;?></option>
                    <?php
                  }
                ?>
              </select>
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-2 control-label">Booking Date</label>
            <div class="col-md-3">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </span>
                <input type="text"  name="booking_date" id="booking_date" value="<?php echo date("d-m-Y",strtotime($result->booking_date))?>" class="form-control datepicker" autocomplete="off">
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
        

          <div class="form-group">
            <label class="col-md-2 control-label" for="purpose">Purpose</label>
            <div class="col-md-3">
            <select class="form-control mb-md" data-plugin-selectTwo name="purpose" id="sel_purpose">
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
            <label class="col-md-2 control-label" for="inputDefault"></label>
            <div class="col-md-3">
            <input type="radio" name="from_nepal" id="nepal_yes" value="1" <?php if($result->from_nepal == '1') echo 'checked="checked"';?> class="required"> Offshore &nbsp;&nbsp;
              <input type="radio" name="from_nepal" id="nepal_no" value="0" <?php if($result->from_nepal == '0') echo 'checked="checked"';?>  class="required"> Onshore
            </div>
          </div>


          <div class="form-group" id="div_nepal" <?php if($result->from_nepal == '0') echo 'style="display:none;"';?>>
            <label class="col-md-2 control-label" for="country">Select your interested country</label>
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

         <div class="form-group" id="div_located" <?php if($result->from_nepal == '1') echo 'style="display:none;"';?>>
          <label class="col-md-2 control-label" for="country1">Where are you located at the moment?</label>
          <div class="col-md-3">
            <select class="form-control mb-md" name="country1" id="country_id" data-plugin-selectTwo>
              <option value="">Country</option>
              <?php
              foreach ($countries as $country) {
               ?>
                 <option country_id="<?php echo $country->country_id;?>" <?php if($result->country == $country->country_name) echo 'selected="selected"';?> value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
               <?php
             }
             ?>
           </select>
         </div>
         <label class="col-md-3 control-label" for="">State</label>
         <div class="col-md-3">
            <select class="form-control mb-md" name="state" id="sate" data-plugin-selectTwo>
              <option value="">State</option>
             
           </select>
         </div>
       </div>


       <div class="form-group">
        <label class="col-md-2 control-label" for="inputDefault">First Name</label>
        <div class="col-md-3">
          <input type="text" name="name" value="<?php echo $result->lead_name;?>"  class="form-control required" id="name" >
          <?php echo form_error("name");?>
        </div>
        <label class="col-md-3 control-label" for="inputDefault">Last Name</label>
        <div class="col-md-3">
          <input type="text" name="lname" value="<?php echo $result->lead_lname;?>"  class="form-control required" id="lname" >

        </div>
      </div>

      



      <div class="form-group">
        <label class="col-md-2 control-label" for="email">Email</label>
        <div class="col-md-3">
          <input type="email" name="email" value="<?php echo $result->email;?>"  class="form-control required" id="email" >
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
        <label class="col-md-3 control-label" for="inputDefault"></label>
        <div class="col-md-6">
            <input type="hidden" name="tab" value="counselling">
          <input type="hidden" name="lead_id" value="<?php echo $result->lead_id;?>">
          <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
          <a href="<?php echo base_url("dashboard/appointment");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
$this->load->view("lms/add_purpose");
?>
<script type="text/javascript">
  $(document).ready(function(){
      var state = '<?php echo $result->state;?>';
    $("#country_id").change(function(){ 
       var country_id =  $("#country_id option:selected").attr("country_id");
  
			$.ajax({
				url: "<?php echo base_url(); ?>appointment/getstates",
				type: "post",
				data: {"country_id":country_id,"state":state},
				success: function (msg) {
					$("#sate").html(msg);
                    $('#sate').select2();
                   
				}
			});
      });
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

  $("#country_id").trigger("change");
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