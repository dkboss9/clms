
<style type="text/css">
table {
  border-collapse: collapse;
}

td {
  padding-top: .5em;
  padding-bottom: .5em;
}
</style>

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

        <h2 class="panel-title">Enroll : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("project/add");?>" method="post" enctype='multipart/form-data'>
          <div class="form-group">
            <label class="col-md-2 control-label">Start Date</label>
            <div class="col-md-3">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </span>
                <input type="text"  name="start_date" class="form-control start_date" value="<?php echo date("d-m-Y");?>" required autocomplete="off">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2 control-label" for="lead_type">Lead Type</label>
            <div class="col-md-3">
              <select name="lead_type" class="form-control" id="lead_type" required data-plugin-selectTwo>
                <option value="">Select</option>
                <?php 
                foreach ($lead_types as $row) {
                 ?>
                 <option value="<?php echo $row->type_id;?>" <?php //if(@$lead->lead_type->$row->type_id) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
                 <?php
               }
               ?>
             </select>
           </div>
           <div class="col-md-1">
             <a href="javascript:void(0);" id="link_lead_type"><i class="glyphicon glyphicon-plus"></i></a>
           </div>
           <label class="col-md-2 control-label" for="inputDefault">Sale Reps / Referrals</label>
           <div class="col-md-3">
             <select name="user" id="user" class="form-control mb-md" required data-plugin-selectTwo>
              <option value="">Select</option>
              <?php 
              foreach($users as $user){
                ?>
                <option value="<?php echo $user->id;?>" <?php //if(@$lead->user_id->$user->userid) echo 'selected="selected"';?>><?php echo $user->first_name.' '.$user->last_name;?></option>
                <?php
              }
              ?>
            </select>
          </div>
          <div class="col-md-1">
            <a href="javascript:void(0);" id="link_user"><i class="glyphicon glyphicon-plus"></i></a>
          </div>
        </div>

        
        <div class="form-group">
          <label class="col-md-2 control-label" for="inputDefault">Client</label>
          <div class="col-md-3">
            <input type="radio" name="student_type" id="existing_student" value="0" checked=""> Existing Client &nbsp;&nbsp;
            <input type="radio" name="student_type" id="new_student" value="1" > New Client
          </div>
          <label class="col-md-3 control-label" for="lname">Commence Date</label>
          <div class="col-md-3">
            <input type="text" data-plugin-datepicker="" name="commence_date" id="commence_date" value="" class="form-control required"  autocomplete="off"/>
          </div>
        </div>

        <div id="div_new_student" style="display:none;">
          <div class="form-group">
            <label class="col-md-2 control-label" for="fname">First Name</label>
            <div class="col-md-3">
              <input type="text" name="fname" id="fname" value="<?php echo set_value("fname",@$lead->lead_name);?>" class="form-control "   />
              <input type="hidden" name="role" id="role" value="3">
            </div>

            <label class="col-md-3 control-label" for="lname">Last Name</label>
            <div class="col-md-3">
              <input type="text" name="lname" id="lname" value="<?php echo set_value("lname",@$lead->lead_lname);?>" class="form-control"  />
            </div>
          </div>



          <div class="form-group">
           <label class="col-md-2 control-label" for="dob">DOB</label>
           <div class="col-md-3">
             <input type="text" data-plugin-datepicker=""  name="dob" id="dob" value="<?php echo set_value("dob");?>" class="form-control"  />
           </div>

           <label class="col-md-3 control-label" for="passport_no">Passport No</label>
           <div class="col-md-3">
            <input type="text" name="passport_no" id="passport_no" value="<?php echo set_value("passport_no");?>" class="form-control"  />
          </div>

        </div>


        <div class="form-group">
         <label class="col-md-2 control-label" for="lname">Phone</label>
         <div class="col-md-3">
          <input type="text" name="phone" id="phone" value="<?php echo set_value("phone",@$lead->phone_number);?>" class="form-control"  />
        </div>
        <label class="col-md-3 control-label" for="mobile">Mobile</label>
        <div class="col-md-3">
          <input type="text" name="mobile" id="mobile" value="<?php echo set_value("mobile");?>" class="form-control"  />
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-2 control-label">Email</label>
        <div class="col-md-3">
         <input type="email" name="email" id="email" value="<?php echo set_value("email",@$lead->email);?>" class="form-control"  />
         <?php echo form_error("email");?>
       </div>
       <?php /*
       <label class="col-md-2 control-label" for="referral">Referral</label>
       <div class="col-md-3">
         <select name="referral" id="referral" class="form-control mb-md " >
          <option value="">Select</option>
          <?php 
          foreach($users as $user){
            ?>
            <option value="<?php echo $user->userid;?>" <?php if($user->userid == set_value("referral",@$lead->user_id)) echo 'selected="selected"'; ?>><?php echo $user->first_name.' '.$user->last_name;?></option>
            <?php
          }
          ?>
        </select>
      </div>
    */  ?>
  </div>


  <div class="form-group">
   <label class="col-md-2 control-label" for="address">Address</label>
   <div class="col-md-3">
    <input type="text" name="address" id="address" value="<?php echo set_value("address");?>" class="form-control"  />
  </div>
  <label class="col-md-3 control-label" for="sex">Sex</label>
  <div class="col-md-3">
   <select name="sex" class="form-control " data-plugin-selectTwo id="sex" >
     <option value="">Select</option>
     <option value="Male" <?php if(set_value("sex") == "Male") echo 'selected="selected"';?>>Male</option>
     <option value="Female" <?php if(set_value("sex") == "Female") echo 'selected="selected"';?>>Female</option>
   </select>
 </div>
</div>



<div class="form-group">
 <label class="col-md-2 control-label" for="is_married">Marital Status</label>
 <div class="col-md-3">
  <select name="is_married" id="is_married" class="form-control " data-plugin-selectTwo>
   <option value="">Select</option>
   <option value="Single" <?php if(set_value("is_married") == "Single") echo 'selected="selected"';?>>Single</option>
   <option value="Married" <?php if(set_value("is_married") == "Married") echo 'selected="selected"';?>>Married</option>
 </select>
</div>

<label class="col-md-3 control-label">How do you know about us?</label>
  <div class="col-md-3">
    <select name="about_us" id="about_us" class="form-control mb-md" data-plugin-selectTwo>
      <option value="">Select</option>
      <?php 
      foreach($about_us as $row){
        ?>
        <option value="<?php echo $row->threatre_id;?>" <?php if(@$lead->about_us == $row->threatre_id) echo 'selected="selected"';?>><?php echo $row->name;?></option>
        <?php
      }
      ?>

    </select>

  </div>
  <div class="col-md-1">
    <a href="javascript:void(0);" id="link_about"><i class="glyphicon glyphicon-plus"></i></a>
  </div>
</div>

</div>


<div class="form-group" id="div_old_student">
  <label class="col-md-2 control-label" for="inputDefault">Client</label>
  <div class="col-md-3">

    <select class="form-control required" name="student" id="student" data-plugin-selectTwo>
      <option value="">Select</option>
      <?php
      foreach ($students->result() as $row) {
       ?>
       <option value="<?php echo $row->id;?>" <?php echo $this->input->get("customer") == $row->id ? 'selected':'';?>><?php echo $row->first_name.' '.$row->last_name;?></option>
       <?php
     }
     ?>
   </select>
 </div>
 <div class="col-md-3" id="div_studentdetail"></div>
</div>

<div class="form-group">
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="inputDefault">Visa Type</label>
  <div class="col-md-3">
    <input type="radio" name="visa_type" value="14"> Education &nbsp;&nbsp;
    <input type="radio" name="visa_type" value="28"> Migration
  </div>
 
  <label class="col-md-3 control-label " for="intake" >Visa Sub category</label>
  <div class="col-md-3">
    <select class="form-control required" name="sub_visa_type" id="sub_visa_type" data-plugin-selectTwo>
      <option value="">Select</option>
    </select>
  </div>
  <div class="col-md-1">
    <a href="javascript:void(0);" id="link_visa_type"><i class="glyphicon glyphicon-plus"></i></a>
  </div>
</div>

<div class="form-group div_student" style="display:none;">
<label class="col-md-2 control-label " for="intake" >Intake</label>
<div class="col-md-3">
 <select class="form-control required " name="intake" id="intake" data-plugin-selectTwo >
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
<div class="col-md-1 div_student" style="display:none;">
  <a href="javascript:void(0);" id="link_intake"><i class="glyphicon glyphicon-plus"></i></a>
</div>
</div>



<div class="div_student" style="display:none;">
 <div class="form-group">
  <label class="col-md-2 control-label" for="inputDefault">College</label>
  <div class="col-md-3">
   <select class="form-control " name="college" id="college" data-plugin-selectTwo>
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
<div class="col-md-1">
  <a href="javascript:void(0);" id="link_college"><i class="glyphicon glyphicon-plus"></i></a>
</div>
<label class="col-md-2 control-label" for="inputDefault" >Degree</label>
<div class="col-md-3">
  <select class="form-control " name="degree" id="degree" data-plugin-selectTwo>
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
<div class="col-md-1">
  <a href="javascript:void(0);" id="link_degree"><i class="glyphicon glyphicon-plus"></i></a>
</div>
</div>


<div class="form-group">
  <label class="col-md-2 control-label" for="inputDefault">Course</label>
  <div class="col-md-3">
   <select class="form-control " name="course" id="course" data-plugin-selectTwo>
    <option value="">Select</option>
  </select>
</div>
<div class="col-md-1">
  <a href="javascript:void(0);" id="link_course"><i class="glyphicon glyphicon-plus"></i></a>
</div>
<label class="col-md-2 control-label" for="inputDefault">Tuition Fee</label>
<div class="col-md-3">
  <input type="hidden" name="txt_fee" id="txt_fee" class="form-control "> 
  <span id="tution_fee"></span> &nbsp;&nbsp; / &nbsp;&nbsp;
  <span id="div_period"></span>
  <input type="hidden" name="fee_period" id="fee_period" class="form-control">
</div>
</div>

<div class="form-group" >
  <label class="col-md-2 control-label" for="inputDefault">Student want to pay for</label>
  <div class="col-md-3">
    <input type="radio" name="duration" id="semester" class="" value="One Semester" checked=""> One Semester &nbsp;&nbsp;&nbsp;
    <input type="radio" name="duration" id="tri-semester" class="" value="Tri-semester" > Tri-semester &nbsp;&nbsp;&nbsp;
    <input type="radio" name="duration" id="yearly" class="" value="One Year"> One Year &nbsp;&nbsp;&nbsp;
    <input type="radio" name="duration" id="whole" class="" value="Whole Course"> Whole Course
  </div>
  <label class="col-md-3 control-label" for="inputDefault">Fee</label>
  <div class="col-md-3">
    <input type="text" name="fee" id="fee" class="form-control required" value="" > 
  </div>

</div>

<div class="form-group" >
  <label class="col-md-2 control-label" for="inputDefault">Discount</label>
  <div class="col-md-3">
    <input type="text" name="txt_discount" id="txt_discount" class="form-control required" value="0" > 
  </div>
  <div class="col-md-1">
    <input type="checkbox" name="is_percentage" id="is_percentage" value="1" > Is Percentage
  </div>
  <label class="col-md-2 control-label" for="inputDefault">Total</label>
  <div class="col-md-3">
    <input type="text" name="total_fee" id="total_fee" class="form-control required" value="0" > 
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="inputDefault">Current Status in Nepal</label>
  <div class="col-md-2">
    <input type="radio" name="current_status" class="" id="current_status_yes" value="1" checked=""> Offshore &nbsp;&nbsp;
    <input type="radio" name="current_status" class="" id="current_status_no" value="2"> Onshore
  </div>
</div>

</div>

<div class="form-group" id="div_current_status" style="display:none;">
  <label class="col-md-2 control-label" for="inputDefault">Visa title</label>
  <div class="col-md-2">
    <input type="text" name="visa_title" class="form-control " value="">
  </div>
  <label class="col-md-1 control-label" for="inputDefault">Visa Subclass</label>
  <div class="col-md-2">
   <select class="form-control " name="visa_class" id="visa_class" data-plugin-selectTwo>
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
<label class="col-md-1 " for="inputDefault"><a href="javascript:void(0);" id="link_visa_class"><i class="glyphicon glyphicon-plus"></i></a></label>
<label class="col-md-1 control-label" for="inputDefault">Visa Expiry Date</label>
<div class="col-md-2">
  <input type="text" data-plugin-datepicker="" name="expiry_date" class="form-control " value="">
</div>
</div>

<div class="form-group">
</div>



<div class="form-group">

  <label class="col-md-2 control-label" for="description"></label>
  <div class="col-md-3">
    <input type="checkbox" name="show_package" id="show_package" value="1"> Add Package
  </div>
</div>
<div id="div_package" style="display:none;">
  <div class="form-group">
    <label class="col-md-2 control-label">Package</label>
    <div class="col-md-8">

      <table style="width: 100%;" id="div_document">
        <tr>
         <td>   </td>
         <td><strong>Package</strong></td>
         <td><strong>Quantity</strong></td>
         <td><strong>Unit Price</strong></td>
         <td><strong>Total Price</strong></td>
         <td></td>
       </tr>
       <tr>
        <td>   <a href="javascript:void(0);" class="link_package btn btn-primary list-btn" rel='1'><i class="glyphicon glyphicon-plus"></i></a></td>
        <td>  <select name="package[]" rel="1" id="package1" class="form-control doccuments" data-plugin-selectTwo>
          <option value="">Select</option>
          <?php 
          foreach ($packages as $package) {
           ?>
           <option value="<?php echo $package->package_id;?>"><?php echo $package->package_name; ?></option>
           <?php }?>
         </select>
       </td>
       <td> <input type="text" name="qty[]" value="1" rel="1" id="package_qty_1" class="package_qty form-control" style="width:50px;margin-left:20px;"></td>
       <td> <input type="text" name="unit_price[]" value="0" rel="1" id="unit_price_1" class="unit_price form-control" style="width:50px"></td>
       <td> <input type="text" name="package_price[]" value="0" rel="1" id="package_price_1" class="package_price form-control" style="width:50px"></td>
       <td></td>
     </tr>
   </table>
   <a href="javascript:void(0);" id="add_more">Add</a>
 </div>

</div>


<div class="form-group">
  <label class="col-md-2 control-label" for="price">Price</label>
  <div class="col-md-3">
    <input type="text" name="price" value="0" rel="<?php //echo $gst->config_value;?>"  class="form-control" id="price" required>

  </div>
  <div class="col-md-2">
    <input type="checkbox" name="no_tax" id="no_tax" value="1"  checked=""> Tax not applicable.

  </div>
  
    <label class="col-md-1 control-label div_tax" style="display:none;" for="gst">Tax Type</label>
    <div class="col-md-3 div_tax" style="display:none;">

      <select name="gst" id="gst" class="form-control " data-plugin-selectTwo>
        <option value="0">Select</option>
        <?php
        foreach ($gsts as $row) {
          ?>
          <option value="<?php echo $row->gst;?>"><?php echo $row->type_name;?></option>
          <?php
        }
        ?>
      </select>
    </div>
    <div class="col-md-1 div_tax" style="display:none;"> 
      <a href="javascript:void(0);" id="link_gst"><i class="glyphicon glyphicon-plus"></i></a>
    </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="total">Total</label>
  <div class="col-md-3">
    <input type="text" name="total" value="0" rel="<?php //echo $gst->config_value;?>" class="form-control" id="total" >
  </div>
</div>
</div>

<div class="form-group">
</div>

<div class="form-group">

  <label class="col-md-2 control-label" for="total">Grand Total</label>
  <div class="col-md-3">
    <input type="hidden" name="hidden_total" value="0" rel="" class="form-control" id="hidden_total" >
    <input type="text" name="grand" value="0"  class="form-control" id="grand" readonly="">
  </div>
  <label class="col-md-3 control-label" for="inputDefault">Currency</label>
  <div class="col-md-3">
   <select class="form-control required" name="currency" id="currency" data-plugin-selectTwo>
    <option value="">Select</option>
    <?php 
    foreach ($currencies as $row) {
     ?>
     <option value="<?php echo $row->currency_code;?>" ><?php echo $row->currency_code;?></option>
     <?php
   }
   ?>
 </select>
</div>
</div>

<div class="form-group">

  <label class="col-md-2 control-label" for="description">Description</label>
  <div class="col-md-9">
    <textarea name="description"  class="form-control" id="description"  ></textarea>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="note">Admin Note</label>
  <div class="col-md-9">
    <textarea name="note" class="form-control" id="note" ></textarea>
  </div>
</div>


<div class="form-group">

  <label class="col-md-2 control-label">Deadline </label>
  <div class="col-md-3">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text"  name="end_date" class="form-control end_date" required autocomplete="off">
    </div>
  </div>
</div>

<header class="panel-heading" style="margin-bottom: 10px;">
  <h2 class="panel-title">Assign Consultant / Consultancy</h2>
</header>

<div class="form-group">
  <label class="col-md-2 control-label">Add Consultant </label>
  <div class="col-md-2">
    <div class="input-group" id="div_consultant">

      <?php 
      foreach ($employees as $row) {
       ?>
       <div class="checkbox-custom checkbox-primary" style="width: 100%;"> 
         <input type="checkbox" value="<?php echo $row->id;?>" name="employee[]" <?php if(@$lead->consultant == $row->id) echo 'checked="checked"'; ?>>
         <label for="checkboxExample2"><?php echo $row->first_name.' '.$row->last_name; ?></label>
       </div>
       <?php
     }
     ?>
   </div>
 </div>
 <div class="col-md-1">
   <a href="javascript:void(0);" id="link_consultant"><i class="glyphicon glyphicon-plus"></i></a>
 </div>
 <label class="col-md-2 control-label">Assign Super Agent </label>
 <div class="col-md-2">
   <div class="input-group" id="div_consultancy">

    <?php 
    foreach ($suppliers as $row) {
     ?>
     <div class="checkbox-custom checkbox-primary">
       <input type="checkbox" value="<?php echo $row->id;?>" name="supplier[]"  >
       <label for="checkboxExample2"><?php echo $row->first_name.' '.$row->last_name; ?></label>
     </div>
     <?php
   }
   ?>
 </div>
</div>
<div class="col-md-1">
  <a href="javascript:void(0);" id="link_consultantancy"><i class="glyphicon glyphicon-plus"></i></a>
</div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="project_status">Status</label>
  <div class="col-md-3">
    <select name="project_status" id="project_status" class="form-control required" data-plugin-selectTwo>
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
<div class="col-md-1">
  <a href="javascript:void(0);" id="link_project_status"><i class="glyphicon glyphicon-plus"></i></a>
</div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="fee_id" id="fee_id" value="">
    <input type="hidden" name="project" value="<?php echo $this->input->get("project")??0?>">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <?php
    if($this->input->get("project") && $this->input->get("customer")){
      ?>
      <a href="<?php echo base_url("project/cases/".$this->input->get("customer"));?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
      <?php
    }else{
      ?>
       <a href="<?php echo base_url("dashboard/enroll");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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

<?php
$this->load->view("lms/add_purpose");
?>
<script>
  $(document).ready(function(){
    $( ".datepicker" ).datepicker({ format: 'dd-mm-yyyy',
      startDate: '-0d',
      autoclose: true });

      $( "#commence_date" ).datepicker({ format: 'dd-mm-yyyy',
      startDate: '-0d',
      autoclose: true });
    $("#college_country").change(function(){
      var country = $(this).val();
      $.ajax({
        method: "POST",
        url: "<?php echo base_url("college/getcity")?>",
        data: { country: country}
      })
        .done(function( msg ) {
          $("#college_city").html(msg);
          $("#college_city").select2();
        });
    });
  });
</script>
<script type="text/javascript">
  function get_discount(){
    var discount_val = $("#txt_discount").val();
    var fee = $("#fee").val();
    if($("#is_percentage").prop("checked")){
      var discount = (fee * discount_val)/100;
    }else{
      var discount = discount_val;
    }

    var total_fee = fee - discount;
    $("#total_fee").val(total_fee);
  }

  function get_grand(){
    var total_fee = $("#total_fee").val();
    var pakage_fee = $("#total").val();
    $("#grand").val(parseFloat(total_fee) + parseFloat(pakage_fee));
  }

  $(document).ready(function(){
   $(document).on('click','.link_package',function() {
    var id = $(this).attr("rel");
    $("#txt_row_number").val(id);
    $('#form_package_model').modal();
  });
   $("#link_gst").click(function(){ 
    $("#form_gst_model").modal();
  });
   $("#link_consultantancy").click(function(){ 
    $("#form_consultancy_model").modal();
  });

   $("#link_consultant").click(function(){ 
    $("#form_consultant_model").modal();
  });

   $("#link_visa_class").click(function(){
    $("#form_visa_class_model").modal();
  });

   $("#link_project_status").click(function(){
    $("#form_project_status_model").modal();
  });
   $("#link_course").click(function(){
    var degree = $("#degree").val();
    if(degree != ""){
      var text = $("#degree option:selected").text();
      if($("#course_degree option[value='"+degree+"']").length == 0){
        $("#course_degree").append('<option value="'+degree+'">'+text+'</option>');
        $("#course_degree").val(degree);
      }else{
        $("#course_degree").val(degree);
      }

    }
    $("#form_course_model").modal();
  });

   $("#link_degree").click(function(){
    $("#form_degree_model").modal();
  });
   $("#link_college").click(function(){
    $("#form_college_model").modal();
  });

   $("#link_intake").click(function(){
    $("#form_intake_model").modal();
  });
   $("#link_visa_type").click(function(){
    $("#form_visa_type_model").modal();
  });
   $("#link_about").click(function(){ 
    $("#form_about_model").modal();
  });

   $("#link_lead_type").click(function(){ 
    $("#form_lead_type_model").modal();
  });

   $("#link_user").click(function(){ 
    $("#form_user_model").modal();
  });
   $("#form_gst").validate();
   $("#form_consultancy").validate();
   $("#form_consultant").validate();
   $("#form_visa_class").validate();
   $("#form_course").validate();
   $("#form_degree").validate();
   $("#form_college").validate();
   $("#form_intake").validate();
   $("#form_visa_type").validate();
   $("#form_about").validate();
   $("#form_user").validate();
   $("#form_lead_type").validate();

   $("#txt_discount").blur(function(){
    get_discount();
    get_grand();
  });

   $("#is_percentage").click(function(){
     get_discount();
     get_grand();
   });
   $("#show_package").click(function(){
    if($(this).prop("checked"))
      $("#div_package").show();
    else
      $("#div_package").hide();
  });

  $( ".start_date" ).datepicker({ format: 'dd-mm-yyyy',
      startDate: '-0d',
      autoclose: true });

      
  $( ".end_date" ).datepicker({ format: 'dd-mm-yyyy',
      startDate: '-0d',
      autoclose: true });

   $(document.body).on('change', '.package_qty' ,function(){
    var id = $(this).attr("rel");
    if($("#package"+id).val()=="")
      return false;
    var qty = $(this).val();
    var price = $("#unit_price_"+id).val();
    $("#package_price_"+id).val(parseFloat(qty)*parseFloat(price));
    $(".package_price").trigger("blur");
  });


   $(document.body).on('change', '.unit_price' ,function(){
    var id = $(this).attr("rel");
    if($("#package"+id).val()=="")
      return false;
    var price = $(this).val();
    var qty = $("#package_qty_"+id).val();
    $("#package_price_"+id).val(parseFloat(qty)*parseFloat(price));
    $(".package_price").trigger("blur");
  });


   $(document.body).on('blur', '.package_price' ,function(){
    var package_total = 0;
    $(".doccuments").each(function(){
      var id = $(this).attr('rel'); 

      if(id){
        var price = $("#package_price_"+id).val();
        package_total+=parseFloat(price);
      }
      $("#price").val(package_total);
    });

    $("#price").trigger("blur");
  });
   var num = 1;
   $("#add_more").click(function(){
   //  var cond = 1;
   //  $(".doccuments").each(function(){
   //    if($(this).val() == ""){
   //     cond = 0;

   //   }

   // });
   //  if(cond == 0){
   //    alert("Select Package First.");
   //    return false;
   //  }

     // var num = $(".doccuments").length;
     num = num + 1;
     $("#div_document").append('<tr style="margin-top:10px;" id="tr_'+num+'">'+
      '<td><a href="javascript:void(0);" class="link_package btn btn-primary list-btn" rel="'+num+'"><i class="glyphicon glyphicon-plus"></i></a></td>'+
      '<td>  <select name="package[]" id="package'+num+'" rel="'+num+'" class="form-control doccuments" data-plugin-selectTwo>'+
      '<option value="">Select</option>'+
      <?php 
      foreach ($packages as $package) {
       ?>
       '<option value="<?php echo $package->package_id;?>"><?php echo $package->package_name; ?></option>'+
       <?php }?>
       '</select>'+
       '</td>'+
       '<td> <input type="text" name="qty[]" value="1" rel="'+num+'" id="package_qty_'+num+'" class="package_qty form-control" style="width:50px;margin-left:20px;"></td>'+
       '<td> <input type="text" name="unit_price[]" value="0" rel="'+num+'" id="unit_price_'+num+'" class="unit_price form-control" style="width:50px"></td>'+
       '<td> <input type="text" name="package_price[]" value="0" rel="'+num+'" id="package_price_'+num+'" class="package_price form-control" style="width:50px"></td>'+
       '<td><a href="javascript:void(0);" class="link_remove" rel="'+num+'"> Remove</a></td></tr>');

     (function( $ ) {

      'use strict';

      if ( $.isFunction($.fn[ 'select2' ]) ) {

        $(function() {
          $('[data-plugin-selectTwo]').each(function() {
            var $this = $( this ),
            opts = {};

            var pluginOptions = $this.data('plugin-options');
            if (pluginOptions)
              opts = pluginOptions;

            $this.themePluginSelect2(opts);
          });
        });

      }

    }).apply(this, [ jQuery ]);
   });
   $(document.body).on('click', '.link_remove' ,function(){
    var id = $(this).attr("rel");
    $("#tr_"+id).remove(); 
    $(".package_price").trigger("blur");
  });
   $(document.body).on('change', '.doccuments' ,function(){
    var packageid = $(this).val();
    var id = $(this).attr("rel");
    $.ajax({
      url: '<?php echo base_url() ?>project/get_packageDetails',
      type: "POST",
      data: "packageid=" + packageid,
      success: function(data) { 
       if(data != ""){
        var data = JSON.parse(data);
        var out = "";
        var i;
        console.log(data);
        for(i = 0; i < data.length; i++) {
       // $("#package_qty_"+id).val(data[i].qty);
       $("#unit_price_"+id).val(data[i].price);
       $("#package_price_"+id).val(data[i].price);
       $(".package_price").trigger("blur");
     }

   }
 }        
}); 

  });



   $("#price").blur(function(){ 
    var price = $(this).val();
    if(price == "")
      return false;
    var gst = $("#gst").val();
    var total = parseFloat(price) + ((parseFloat(price)/100)*parseFloat(gst));
    $("#total").val(total);
    $("#hidden_total").val(total);
 // $("#grand").val(parseFloat(total) + parseFloat($("#fee").val()));
 get_grand();
});
   $("#gst").change(function(){
    $("#price").trigger("blur");
  });
   $("#total").blur(function(){
    var gst = $("#gst").val();
    var total = $(this).val();
    $("#hidden_total").val(total);
    if(total == "")
      return false;
    var price = (parseFloat(total)*100)/(parseFloat(gst)+100);
    $("#price").val(price);
  //$("#grand").val(parseFloat(total) + parseFloat($("#fee").val()));
  get_grand();
});

 });
</script>

<script type="text/javascript">
  $(document).ready(function(){ 


    $("#no_tax").click(function(){
      if($(this).prop("checked")){
        $(".div_tax").hide();
        $("#gst").val(0);
        $("#price").trigger("blur");
      }else{
        $(".div_tax").show();
      }
    });
    $("#student").change(function(){
      var studentid = $(this).val();
      if(studentid == '')
        return false;

      $.ajax({
        url: '<?php echo base_url() ?>project/get_userDetail',
        type: "POST",
        data: "studentid=" + studentid,
        success: function(data) { 
          if(data != ""){
            $("#div_studentdetail").html(data);
          }
        }        
      });
    });
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
          $("#tution_fee").html(data.fee);
          $("#txt_fee").val(data.fee);
          $("#fee").val(data.fee);
          $("#fee_id").val(data.fee_id);
          $("#fee_period").val(data.period);
          $("#div_period").html(data.period);
          $("#currency").val(data.currency);
          if(data.period == 'Semester')
            $("#semester").prop("checked",true);
          else if(data.period == 'Tri-semester')
            $("#tri-semester").prop("checked",true);
          else if(data.period == 'Yearly')
            $("#yearly").prop("checked",true);
          else
            $("#whole").prop("checked",true);
          get_discount();
          get_grand();
        }        
      });

    });
    $('input[name=duration]').click(function(){
      var period = $(this).val();
      var course = $("#course").val();
      var degree = $("#degree").val();
      var college = $("#college").val();
      $.ajax({
        url: '<?php echo base_url() ?>enroll/get_enrollAmount',
        type: "POST",
        data: "degree="+degree+"&course="+course+"&college="+college+"&period="+period,
        success: function(data) { 
          $("#fee").val(data);
          get_discount();
          get_grand();
        }        
      });
    });

/*$("#college").change(function(){
  $("#course").trigger("change");
});
*/

$("#college").change(function(){
  var college = $(this).val();

  $.ajax({
    url: '<?php echo base_url() ?>course_fee/getDegree',
    type: "POST",
    data: "college=" + college,
    success: function(data) { 
      if(data != ""){
        $("#degree").html(data);
      }
    }        
  });
});

$('input[name="visa_type"]').click(function(){
  visa_type = $(this).val();
  if(visa_type == '14'){
    $(".div_student").show();
    $("#college").addClass("required");
    $("#student").addClass("required");
    $("#degree").addClass("required");
    $("#course").addClass("required");
  }else{
    $(".div_student").hide();
    $("#college").removeClass("required");
    $("#student").removeClass("required");
    $("#degree").removeClass("required");
    $("#course").removeClass("required");
  }
  $.ajax({
    url: '<?php echo base_url() ?>visa/getsubcategory',
    type: "POST",
    data: "visa_type=" + visa_type,
    success: function(data) { 
      if(data != ""){
        $("#sub_visa_type").html(data);
        $("#sub_visa_type").select2();
      }
    }        
  });
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
  //$("#referral").addClass("required");
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
  //$("#referral").removeClass("required");
  $("#address").removeClass("required");
  $("#sex").removeClass("required");
  $("#is_married").removeClass("required");
  $("#username").removeClass("required");
  $("#password").removeClass("required");
  $("#cpassword").removeClass("required");
  $("#about_us").removeClass("required");
  $("#student").addClass("required");
});
<?php 
if(isset($lead->lead_id)) {?>
  $("#new_student").trigger("click");
  <?php
}
?>
});
</script>