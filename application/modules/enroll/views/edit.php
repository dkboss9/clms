
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
      <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("enroll/edit");?>" method="post" enctype='multipart/form-data'>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Client</label>
            <div class="col-md-6">

              <select class="form-control required" name="student" id="student">
                <option value="">Select</option>
                <?php
                foreach ($students->result() as $row) {
                 ?>
                 <option value="<?php echo $row->userid;?>" <?php if($row->userid == $result->student_id) echo 'selected="selected"';?>><?php echo $row->first_name.' '.$row->last_name;?></option>
                 <?php
               }
               ?>
             </select>
           </div>
         </div>
         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Visa Type</label>
          <div class="col-md-6">
           <select class="form-control required" name="visa_type" id="visa_type">
            <option value="">Select</option>
            <?php
            foreach ($visa as $row) {
             ?>
             <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $result->visa) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
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
           <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $result->intake) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
           <?php
         }
         ?>

       </select>
     </div>
   </div>
   <div id="div_student" <?php if($result->visa != 14) echo 'style="display:none;"';?>>
     <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">College</label>
      <div class="col-md-6">
       <select class="form-control <?php if($result->visa == 14) echo 'required';?>" name="college" id="college">
        <option value="">Select</option>
        <?php
        foreach ($colleges as $row) {
         ?>
         <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $result->college) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
         <?php
       }
       ?>
     </select>
   </div>
 </div>

 <div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault" >Degree</label>
  <div class="col-md-6">
    <select class="form-control <?php if($result->visa == 14) echo 'required';?>" name="degree" id="degree">
      <option value="">Select</option>
      <?php
      foreach ($degree as $row) {
       ?>
       <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $result->degree) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
       <?php
     }
     ?>
   </select>
 </div>
</div>
<?php
$courses = $this->enrollmodel->getCourse($result->degree);
?>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Course</label>
  <div class="col-md-6">
   <select class="form-control <?php if($result->visa == 14) echo 'required';?>" name="course" id="course">
    <option value="">Select</option>
    <?php
    foreach($courses as $row){
      ?>
      <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $result->course) echo 'selected="seleted"';?>><?php echo $row->type_name;?></option>
      <?php
    }
    ?>
  </select>
</div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Fee</label>
  <div class="col-md-6">
    <input type="number" name="fee" id="fee" class="form-control <?php if($result->visa == 14) echo 'required';?>" value="<?php echo $result->fee;?>">
    <input type="hidden" name="fee_period" id="fee_period" class="form-control" value="<?php echo $result->period;?>">
  </div>
  <label class="col-md-1 control-label" for="inputDefault" id="div_period"></label>
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Current Status in Nepal</label>
  <div class="col-md-6">
    <input type="radio" name="current_status" class="" id="current_status_yes" value="1" <?php if($result->current_status == '1') echo 'checked="checked"';?>>Yes
    <input type="radio" name="current_status" class="" id="current_status_no" value="2" <?php if($result->current_status == '0') echo 'checked="checked"';?>> No
  </div>
</div>
<div class="form-group" style="display:none;" id="div_current_status">
  <label class="col-md-3 control-label" for="inputDefault">Client want to pay for</label>
  <div class="col-md-6">
    <input type="radio" name="duration" class="" value="One Semester" <?php if($result->pay_period == 'One Semester') echo 'checked="checked"';?>>One Semester
    <input type="radio" name="duration" class="" value="One Year" <?php if($result->pay_period == 'One Year') echo 'checked="checked"';?>> One Year
    <input type="radio" name="duration" class="" value="Whole Course" <?php if($result->pay_period == 'Whole Course') echo 'checked="checked"';?>>Whole Course
  </div>
</div>
</div>
<div class="form-group">
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Visa title</label>
  <div class="col-md-6">
    <input type="text" name="visa_title" class="form-control required" value="<?php echo $result->visa_title;?>">
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
     <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $result->visa_subclass) echo 'selected="seleted"';?>><?php echo $row->type_name;?></option>
     <?php
   }
   ?>
 </select>
</div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Visa Expiry Date</label>
  <div class="col-md-6">
    <input type="text" data-plugin-datepicker="" name="expiry_date" class="form-control required" value="<?php echo date("d/m/Y",strtotime($result->expiry_date));?>">
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
     <option value="<?php echo $row->status_id;?>" <?php if($row->status_id == $result->enroll_status) echo 'selected="seleted"';?>><?php echo $row->status_name;?></option>
     <?php
   }
   ?>
 </select>
</div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="enroll_id" value="<?php echo $result->enroll_id;?>">
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
  });
</script>