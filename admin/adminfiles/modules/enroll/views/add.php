
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
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">course fee : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("enroll/add");?>" method="post" enctype='multipart/form-data'>
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Client</label>
            <div class="col-md-6">
              <input type="radio" name="student_type" id="existing_student" value="0" checked=""> Existing Client
              <input type="radio" name="student_type" id="new_student" value="1"> New Client
            </div>
          </div>
          <div id="div_new_student" style="display:none;">
            <div class="form-group">
              <label class="col-md-3 control-label" for="fname">First Name</label>
              <div class="col-md-6">
                <input type="text" name="fname" id="fname" value="<?php echo set_value("fname");?>" class="form-control "   />
                <input type="hidden" name="role" id="role" value="3">
              </div>
            </div>

            <div class="form-group">
             <label class="col-md-3 control-label" for="lname">Last Name</label>
             <div class="col-md-6">
              <input type="text" name="lname" id="lname" value="<?php echo set_value("lname");?>" class="form-control"  />
            </div>
          </div>

          <div class="form-group">
           <label class="col-md-3 control-label" for="dob">DOB</label>
           <div class="col-md-6">
            <input type="text" name="dob" id="dob" value="<?php echo set_value("dob");?>" class="form-control"  />
          </div>
        </div>
        <div class="form-group">
         <label class="col-md-3 control-label" for="passport_no">Passport No</label>
         <div class="col-md-6">
          <input type="text" name="passport_no" id="passport_no" value="<?php echo set_value("passport_no");?>" class="form-control"  />
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="lname">Phone</label>
       <div class="col-md-6">
        <input type="text" name="phone" id="phone" value="<?php echo set_value("phone");?>" class="form-control"  />
      </div>
    </div>

    <div class="form-group">
     <label class="col-md-3 control-label" for="mobile">Mobile</label>
     <div class="col-md-6">
      <input type="text" name="mobile" id="mobile" value="<?php echo set_value("mobile");?>" class="form-control"  />
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Email</label>
    <div class="col-md-6">
     <input type="email" name="email" id="email" value="<?php echo set_value("email");?>" class="form-control"  />
     <?php echo form_error("email");?>
   </div>
 </div>
 <div class="form-group">
   <label class="col-md-3 control-label" for="referral">Referral</label>
   <div class="col-md-6">
    <input type="text" name="referral" id="referral" value="<?php echo set_value("referral");?>" class="form-control"  />
  </div>
</div>

<div class="form-group">
 <label class="col-md-3 control-label" for="address">Address</label>
 <div class="col-md-6">
  <input type="text" name="address" id="address" value="<?php echo set_value("address");?>" class="form-control"  />
</div>
</div>

<div class="form-group">
 <label class="col-md-3 control-label" for="sex">Sex</label>
 <div class="col-md-6">
   <select name="sex" class="form-control " id="sex" >
     <option value="">Select</option>
     <option value="Male" <?php if(set_value("sex") == "Male") echo 'selected="selected"';?>>Male</option>
     <option value="Female" <?php if(set_value("sex") == "Female") echo 'selected="selected"';?>>Female</option>
   </select>
 </div>
</div>

<div class="form-group">
 <label class="col-md-3 control-label" for="is_married">Marital Status</label>
 <div class="col-md-6">
  <select name="is_married" id="is_married" class="form-control ">
   <option value="">Select</option>
   <option value="Single" <?php if(set_value("is_married") == "Single") echo 'selected="selected"';?>>Single</option>
   <option value="Married" <?php if(set_value("is_married") == "Married") echo 'selected="selected"';?>>Married</option>
 </select>
</div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Username</label>
  <div class="col-md-6">
   <input type="text" name="username" id="username" class="form-control" value="<?php echo set_value("username");?>"  />
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
  <label class="col-md-3 control-label">Verify Password</label>
  <div class="col-md-6">
   <input type="password" name="cpassword" id="cpassword" class="form-control"  />
 </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">How do you know about us?</label>
  <div class="col-md-6">
   <input type="text" name="about_us" id="about_us" class="form-control" value="<?php echo set_value("about_us");?>"  />
   
 </div>
</div>
</div>

<div class="form-group" id="div_old_student">
  <label class="col-md-3 control-label" for="inputDefault">Client</label>
  <div class="col-md-6">

    <select class="form-control required" name="student" id="student">
      <option value="">Select</option>
      <?php
      foreach ($students->result() as $row) {
       ?>
       <option value="<?php echo $row->userid;?>"><?php echo $row->first_name.' '.$row->last_name;?></option>
       <?php
     }
     ?>
   </select>
 </div>
</div>
<div class="form-group">
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Visa Type</label>
  <div class="col-md-6">
   <select class="form-control required" name="visa_type" id="visa_type">
    <option value="">Select</option>
    <?php
    foreach ($visa as $row) {
     ?>
     <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
     <?php
   }
   ?>

 </select>
</div>
</div>
<div class="form-group">
 <label class="col-md-3 control-label" for="inputDefault">Intake</label>
 <div class="col-md-6">
   <select class="form-control required" name="intake" id="intake">
    <option value="">Select</option>
    <?php
    foreach ($intakes as $row) {
     ?>
     <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
     <?php
   }
   ?>

 </select>
</div>
</div>
<div id="div_student" style="display:none;">
 <div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">College</label>
  <div class="col-md-6">
   <select class="form-control " name="college" id="college">
    <option value="">Select</option>
    <?php
    foreach ($colleges as $row) {
     ?>
     <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
     <?php
   }
   ?>
 </select>
</div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault" >Degree</label>
  <div class="col-md-6">
    <select class="form-control " name="degree" id="degree">
      <option value="">Select</option>
      <?php
      foreach ($degree as $row) {
       ?>
       <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
       <?php
     }
     ?>
   </select>
 </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Course</label>
  <div class="col-md-6">
   <select class="form-control " name="course" id="course">
    <option value="">Select</option>
  </select>
</div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Fee</label>
  <div class="col-md-6">
    <input type="number" name="fee" id="fee" class="form-control ">
    <input type="hidden" name="fee_period" id="fee_period" class="form-control">
  </div>
  <label class="col-md-1 control-label" for="inputDefault" id="div_period"></label>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Current Status in Nepal</label>
  <div class="col-md-6">
    <input type="radio" name="current_status" class="" id="current_status_yes" value="1" checked="">Yes
    <input type="radio" name="current_status" class="" id="current_status_no" value="2"> No
  </div>
</div>
<div class="form-group" style="display:none;" id="div_current_status">
  <label class="col-md-3 control-label" for="inputDefault">Client want to pay for</label>
  <div class="col-md-6">
    <input type="radio" name="duration" class="" value="One Semester" checked="">One Semester
    <input type="radio" name="duration" class="" value="One Year"> One Year
    <input type="radio" name="duration" class="" value="Whole Course">Whole Course
  </div>
</div>
</div>
<div class="form-group">
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Visa title</label>
  <div class="col-md-6">
    <input type="text" name="visa_title" class="form-control required" value="">
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Visa Subclass</label>
  <div class="col-md-6">
   <select class="form-control required" name="visa_class" id="visa_class">
    <option value="">Select</option>
    <?php
    foreach ($visa_class as $row) {
     ?>
     <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
     <?php
   }
   ?>
 </select>
</div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Visa Expiry Date</label>
  <div class="col-md-6">
    <input type="text" data-plugin-datepicker="" name="expiry_date" class="form-control required" value="">
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Status</label>
  <div class="col-md-6">
   <select class="form-control required" name="visa_status" id="visa_status">
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
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("dashboard/enroll");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
    $("#degree").change(function(){
      var degree = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>enroll/getCourse',
        type: "POST",
        data: "degree=" + degree,
        success: function(data) { 
          if(data != ""){
            $("#course").html(data);
          }
        }        
      });
    });
    $(document).on("change","#course",function(){
      var course = $(this).val();
      var degree = $("#degree").val();
      var college = $("#college").val();
      if(course == '')
        return false;

      $.ajax({
        url: '<?php echo base_url() ?>enroll/getEnrollAmount',
        type: "POST",
        data: "degree="+degree+"&course="+course+"&college="+college,
        success: function(data) { 
          data = JSON.parse(data);
          $("#fee").val(data.fee);
          $("#fee_period").val(data.period);
          $("#div_period").html(data.period);
        }        
      });

    });
    $("#college").change(function(){
      $("#course").trigger("change");
    });

    $("#visa_type").change(function(){
      var visa_type = $(this).val();
      if(visa_type == '14'){
        $("#div_student").show();
        $("#college").addClass("required");
        $("#student").addClass("required");
        $("#degree").addClass("required");
        $("#course").addClass("required");
        $("#fee").addClass("required");
      }else{
        $("#college").removeClass("required");
        $("#student").removeClass("required");
        $("#degree").removeClass("required");
        $("#course").removeClass("required");
        $("#fee").removeClass("required");
      }
    });
    $("#current_status_no").click(function(){
      $("#div_current_status").show();
    });
    $("#current_status_yes").click(function(){
      $("#div_current_status").hide();
    });
    $("#new_student").click(function(){
      $("#div_old_student").hide();
      $("#div_new_student").show();
      $("#fname").addClass("required");
      $("#lname").addClass("required");
      $("#dob").addClass("required");
      $("#passport_no").addClass("required");
      $("#phone").addClass("required");
      $("#mobile").addClass("required");
      $("#email").addClass("required");
      $("#referral").addClass("required");
      $("#address").addClass("required");
      $("#sex").addClass("required");
      $("#is_married").addClass("required");
      $("#username").addClass("required");
      $("#password").addClass("required");
      $("#cpassword").addClass("required");
      $("#about_us").addClass("required");
      $("#student").removeClass("required");
    });
    $("#existing_student").click(function(){
      $("#div_old_student").show();
      $("#div_new_student").hide();
      $("#fname").removeClass("required");
      $("#lname").removeClass("required");
      $("#dob").removeClass("required");
      $("#passport_no").removeClass("required");
      $("#phone").removeClass("required");
      $("#mobile").removeClass("required");
      $("#email").removeClass("required");
      $("#referral").removeClass("required");
      $("#address").removeClass("required");
      $("#sex").removeClass("required");
      $("#is_married").removeClass("required");
      $("#username").removeClass("required");
      $("#password").removeClass("required");
      $("#cpassword").removeClass("required");
      $("#about_us").removeClass("required");
      $("#student").addClass("required");
    });
  });
</script>