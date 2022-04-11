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

        <h2 class="panel-title">Leads : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form_lead" action="<?php echo base_url("lms/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-2 control-label" for="customer">Select contact</label>
            <div class="col-md-3">
              <select name="contact" id="customer" data-plugin-selectTwo class="form-control">
                  <option value="">Select</option>
                  <?php 
                      foreach($contacts->result() as $result){
                    
                        ?>
                         <option value="<?php echo $result->id;?>" firstname="<?php echo trim($result->first_name);?>" lastname="<?php echo trim($result->last_name);?>" email="<?php echo $result->email;?>" phone="<?php echo $result->phone;?>" address="<?php echo $result->address?>"><?php echo $result->first_name;?> <?php echo $result->last_name;?></option>
                        <?php
                      }
                  ?>
              </select>
            </div>
            <div class="col-md-1">
              <a href="javascript:void(0);" id="link_customer" class=""><i class="glyphicon glyphicon-plus"></i></a>
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-2 control-label" for="inputDefault">First Name</label>
            <div class="col-md-3">
              <input type="text" name="name" value="<?php echo @$db->database_name;?>"  class="form-control required" id="firstname" >
              <?php echo form_error("name");?>
            </div>

            <label class="col-md-3 control-label" for="inputDefault">Last Name</label>
            <div class="col-md-3">
              <input type="text" name="lname" value=""  class="form-control required" id="lastname" >

            </div>
          </div>


          <div class="form-group">
            <label class="col-md-2 control-label" for="inputDefault">Email</label>
            <div class="col-md-3">
              <input type="email" name="email" value="<?php echo @$db->email;?>"  class="form-control required" id="lemail" >
            </div>
            <label class="col-md-3 control-label">Mobile</label>
            <div class="col-md-3 control-label">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-phone"></i>
                </span>
                <input id="phone" name="phone" value="<?php echo @$db->phone;?>" data-plugin-masked-input=""  class="form-control number">
              </div>
            </div>
          </div>
          <!-- data-plugin-selectTwo -->

          <div class="form-group">
            <label class="col-md-2 control-label" for="purpose">Purpose</label>
            <div class="col-md-3">
              <select  class="form-control mb-md" data-plugin-selectTwo  name="purpose" id="sel_purpose">
                <option value="">Select</option>
                <?php 
                foreach($purpose as $row){
                  ?>
                  <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <div class="col-md-1">
              <a href="javascript:void(0);" id="link_purpose"><i class="glyphicon glyphicon-plus"></i></a>
            </div>
            <label class="col-md-2 control-label" for="about_us">How did you know about us?</label>
            <div class="col-md-3">
              <select  name="about_us"  id="about_us" data-plugin-selectTwo  class="form-control mb-md" >
                <option value="">Select</option>
                <?php 
                foreach($about_us as $row){
                  ?>
                  <option value="<?php echo $row->threatre_id;?>"><?php echo $row->name;?></option>
                  <?php
                }
                ?>

              </select>
            </div>
            <div class="col-md-1">
              <a href="javascript:void(0);" id="link_about"><i class="glyphicon glyphicon-plus"></i></a>
            </div>
          </div>
          <?php
  if($this->input->get("source") == 38)
             $display = 'style="display:none"';
    else
          $display = "";
?>

          <div class="form-group" <?php echo $display;?>>
            <label class="col-md-2 control-label" for="">Want to book for counselling ?</label>
            <div class="col-md-3">
              <input type="radio" name="conselling" id="consell_yes" value="1" class="required"> Yes &nbsp;&nbsp;&nbsp;
              <input type="radio" name="conselling" id="consell_no" value="0" class="required" checked> No
            </div>
          </div>
          <div id="div_booking" style="display:none">
          <div class="form-group">
              <label class="col-md-2 control-label">Consultant</label>
              <div class="col-md-3">
                <select name="consultant" id="consultant" data-plugin-selectTwo  class="form-control mb-md">
                  <option value="">Select</option>
                  <?php 
                  foreach ($employees as $row) {
                   ?>
                   <option value="<?php echo $row->id;?>"><?php echo $row->first_name.' '.$row->last_name;?></option>
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
                  <input type="text"  name="booking_date" id="booking_date" class="form-control datepicker" autocomplete="off">
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
                  </select>
                </div>
              </div>
            </div>
          
         </div>
         <div class="form-group">
         </div>

      
         <div class="form-group">
          <label class="col-md-2 control-label" for="inputDefault">Country</label>
          <div class="col-md-3">
            <select class="form-control mb-md" data-plugin-selectTwo  name="country">
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
         <label class="col-md-3 control-label" for="inputDefault" <?php echo $display;?>>Description</label>
         <div class="col-md-3">
           <textarea name="requirement" <?php echo $display;?> class="form-control required"><?php echo @$db->message;?></textarea>

         </div>
       </div>


       <div class="form-group" <?php echo $display;?>>
        <label class="col-md-2 control-label" for="inputDefault">Lead Source</label>
        <div class="col-md-3">
          <select name="lead_source" id="lead_source" data-plugin-selectTwo  class="form-control mb-md">
           <option value="">Select</option>
           <?php 
           foreach($source as $row){
            ?>
            <option value="<?php echo $row->type_id;?>" <?php echo @$this->input->get("source")  == $row->type_id  ? 'selected':''; ?>><?php echo $row->type_name;?></option>
            <?php
          }
          ?>
        </select>
      </div>
      <div class="col-md-1">
        <a href="javascript:void(0);" id="link_source"><i class="glyphicon glyphicon-plus"></i></a>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-2 control-label" for="inputDefault">Referral</label>
      <div class="col-md-3">
        <input type="radio" name="referral" id="referral_yes" value="1" class="required"> Yes &nbsp;&nbsp;&nbsp;
        <input type="radio" name="referral" id="referral_no" value="0" class="required"> No
      </div>
      <label class="col-md-3 control-label div_refferal" for="inputDefault"  <?php  echo 'style="display:none;"';?>>Referral</label>
      <div class="col-md-3 div_refferal"  <?php echo 'style="display:none;"';?>>
        <select name="user" id="user" class="form-control mb-md" data-plugin-selectTwo >
          <option value="">Select</option>
          <?php 
          foreach($users as $user){
            ?>
            <option value="<?php echo $user->id;?>" <?php //if($result->user_id == $user->userid) echo 'selected="selected"';?>><?php echo $user->first_name.' '.$user->last_name;?></option>
            <?php
          }
          ?>
        </select>
      </div>
      <div class="col-md-1 div_refferal" <?php echo 'style="display:none;"';?>>
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
          <input type="text" name="date" value="<?php echo date("d-m-Y",strtotime("+1 day"))?>" class="form-control datepicker" autocomplete="off" required>
        </div>
      </div>
      <label class="col-md-3 control-label">Reminder Time</label>
      <div class="col-md-3">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-clock-o"></i>
          </span>
          <input type="text" data-plugin-timepicker="" name="time" value="0:00" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }">
        </div>
      </div>
    </div>


    <header class="panel-heading" style="margin-bottom: 10px;">
      <h2 class="panel-title">Status Update</h2>
    </header>
    <div class="form-group">
      <label class="col-md-2 control-label" for="inputDefault">Today</label>
      <div class="col-md-9">
        <textarea name="status_update" class="form-control"></textarea>
      </div>
     
  </div>


  <div class="form-group">

  <label class="col-md-2 control-label" for="inputDefault">Status</label>
      <div class="col-md-3">
      <select name="status" id="sel_status" data-plugin-selectTwo  class="form-control mb-md">
        <?php 
        foreach($status as $stat){
          ?>
          <option value="<?php echo $stat->status_id;?>"><?php echo $stat->status_name;?></option>
          <?php
        }

        ?>
      </select>
    </div>
    <div class="col-md-1">
      <a href="javascript:void(0);" id="link_status"><i class="glyphicon glyphicon-plus"></i></a>
    </div>
    <label class="col-md-2 control-label" for="inputDefault"></label>
    <div class="col-md-3">
      <input type="checkbox" name="send_email" value="1" > Send Email
    </div>
  </div>


  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault"></label>
    <div class="col-md-6">
      <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
      <a href="<?php echo base_url("lms");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
$this->load->view("add_purpose");
$this->load->view("order/add_customer");
?>
<script type="text/javascript">
 function addCustomer() {
   
   var student_doc_types = [];
   var student_docs = [];
   var student_doc_desc = [];
   $('select[name="doc_type[]"]').each(function(){
     var doc_type = $(this).val();
     student_doc_types.push(doc_type);
   });
   $(".file_name").each(function(){
     var doc = $(this).val();
     student_docs.push(doc);
   });

   $(".student_doc_desc").each(function(){
     var desc = $(this).val();
     student_doc_desc.push(desc);
   });

   var qualifaction = [];
   var institution = [];
   var country = [];
   var commence_date = [];
   var complete_date = [];
   var percentage = [];
   var is_attached = [];

   $(".qualifaction").each(function(){
     var val = $(this).val();
     qualifaction.push(val);
   });

   $(".institution").each(function(){
     var val = $(this).val();
     institution.push(val);
   });

   $('select[name="country[]"]').each(function(){
     var val = $(this).val();
     country.push(val);
   });

   $('select[name="commence_date[]"]').each(function(){
     var val = $(this).val();
     commence_date.push(val);
   });

   $('select[name="complete_date[]"]').each(function(){
     var val = $(this).val();
     complete_date.push(val);
   });

   $(".percentage").each(function(){
     var val = $(this).val();
     percentage.push(val);
   });
 
   $(".is_attached").each(function(){
     var val = $(this).prop("checked") ? 1 : 0;
     is_attached.push(val);
   });
   

   var experience = [];
   var e_institution = [];
   var e_position = [];
   var e_country  = [];
   var e_commence_date = [];
   var e_complete_date = [];
   var e_is_attached = [];

   $(".experience").each(function(){
     var val = $(this).val();
     experience.push(val);
   });

   $(".e_institution").each(function(){
     var val = $(this).val();
     e_institution.push(val);
   });

   $(".e_position").each(function(){
     var val = $(this).val();
     e_position.push(val);
   });

   $('select[name="e_country[]"]').each(function(){
     var val = $(this).val();
     e_country.push(val);
   });

   $('select[name="e_commence_date[]"]').each(function(){
     var val = $(this).val();
     e_commence_date.push(val);
   });

   $('select[name="e_complete_date[]"]').each(function(){
     var val = $(this).val();
     e_complete_date.push(val);
   });

   $(".e_is_attached").each(function(){
     var val = $(this).prop("checked") ? 1 : 0;
     e_is_attached.push(val);
   });
 
   var data = {
     "fname": $("#fname").val(),
     "lname": $("#lname").val(),
     "email": $("#email").val(),
     "mobile": $("#mobile").val(),
     "username": $("#username").val(),
     "password": $("#password1").val(),
     "cpassword": $("#cpassword").val(),
     "dob": $("#dob").val(),
     "passport_no": $("#passport_no").val(),
     "phone": $("#phone").val(),
     "referral": $("#user").val(),
     "sex": $("#sex").val(),
     "is_married": $("#is_married").val(),
     "about_us": $("#about_us").val(),
     "send_email": $("#send_email").prop("checked")? 1 : 0,
     "have_ielts": $("input:radio[name=have_ielts]:checked").val(),
     "listening": $("#listening").val(),
     "writing": $("#writing").val(),
     "reading": $("#reading").val(),
     "speaking": $("#speaking").val(),
     "have_toefl": $("input:radio[name=have_toefl]:checked").val(),
     "txt_toefl": $("#txt_toefl").val(),
     "have_pte":  $("input:radio[name=have_pte]:checked").val(),
     "txt_pte": $("#txt_pte").val(),
     "have_sat": $("input:radio[name=have_pte]:checked").val(),
     "txt_sat": $("#txt_sat").val(),
     "have_gre":  $("input:radio[name=have_gre]:checked").val(),
     "txt_gre": $("#txt_gre").val(),
     "have_gmat":  $("input:radio[name=have_gmat]:checked").val(),
     "txt_gmat": $("#txt_gmat").val(),
     "student_doc_types": student_doc_types,
     "student_docs": student_docs,
     "student_doc_desc": student_doc_desc,
     "qualifaction": qualifaction,
     "institution": institution,
     "country": country,
     "commence_date": commence_date,
     "complete_date": complete_date,
     "percentage": percentage,
     "is_attached": is_attached,
     "experience": experience,
     "e_institution": e_institution,
     "e_position": e_position,
     "e_country": e_country,
     "e_commence_date": e_commence_date,
     "e_complete_date": e_complete_date,
     "e_is_attached": e_is_attached,
   }

   $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>student/addstudent",
     data: data,
     success: function (msg) {
       var msg = JSON.parse(msg);
       if(msg.result == 'success'){
       $("#customer").append('<option value="' + msg.student_id + '">' + $("#fname").val() + ' '+$("#lname").val()+ '</option>');
       $("#customer").val(msg);
       $(".btn-close").trigger("click");
       }else{
         $("#p_degree").html(msg.err);
       }
       
     }
   });

 }
  $(document).ready(function(){
    $('#link_customer').click(function() {
      $('#form_customer_model').modal();
    });

    $("#form_customer").validate();

    $("#contact").change(function(){
      var firstname = $('option:selected', this).attr('firstname');
      var lastname = $('option:selected', this).attr('lastname');
      var email = $('option:selected', this).attr('email');
      var phone = $('option:selected', this).attr('phone');
      $("#firstname").val(firstname);
      $("#lastname").val(lastname);
      $("#email").val(email);
      $("#phone").val(phone);
    });
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