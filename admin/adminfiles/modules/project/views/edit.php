
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

        <h2 class="panel-title">Enroll : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("project/edit");?>" method="post" enctype='multipart/form-data'>

          <div class="form-group">
           <label class="col-md-2 control-label">Start Date</label>
           <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </span>
              <input type="text"  name="start_date" class="form-control start_date" value="<?php echo date("d-m-Y",$result->start_date);?>" required autocomplete="off">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label" for="lead_type">Lead Type</label>
          <div class="col-md-3">
            <select name="lead_type" class="form-control data-plugin-selectTwo" id="lead_type" required>
              <option value="">Select</option>
              <?php 
              foreach ($lead_types as $row) {
               ?>
               <option <?php if($row->type_id == $result->lead_type) echo 'selected="selected"';?> value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
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
        <?php //echo $result->sales_rep;?>
          <select name="user" id="user" class="form-control mb-md data-plugin-selectTwo" required>
            <option value="">Select</option>
            <?php 
            foreach($users as $user){
              ?>
              <option <?php if($user->id == $result->sales_rep) echo 'selected="selected"';?> value="<?php echo $user->id;?>"><?php echo $user->first_name.' '.$user->last_name;?></option>
              <?php
            }
            ?>
          </select>
        </div>
        <div class="col-md-1">
          <a href="javascript:void(0);" id="link_user"><i class="glyphicon glyphicon-plus"></i></a>
        </div>
      </div>


      <div class="form-group" id="div_old_student">
        <label class="col-md-2 control-label" for="inputDefault">Client</label>
        <div class="col-md-3">

         <select class="form-control required" data-plugin-selectTwo name="student" id="student">
          <option value="">Select</option>
          <?php
          foreach ($students->result() as $row) {
           ?>
           <option value="<?php echo $row->id;?>" <?php if($row->id == $enroll->student_id) echo 'selected="selected"';?>><?php echo $row->first_name.' '.$row->last_name;?></option>
           <?php
         }
         ?>
       </select>
     </div>
     <?php 
     $studentdetail = $this->projectmodel->getUserDetail($enroll->student_id);
     ?>
     <div class="col-md-3" id="div_studentdetail">
      <?php
      echo '<p>Name: '.$studentdetail->first_name.' '.$studentdetail->last_name.'</p>';
      echo '<p>Email: '.$studentdetail->email.'</p>';
      echo '<p>Contact no: '.$studentdetail->phone.'</p>';
      ?>
    </div>
  </div>

  <div class="form-group" id="div_old_student">

   <label class="col-md-2 control-label" for="lname">Commence Date</label>
   <div class="col-md-3">
     <input type="text"  name="commence_date" id="commence_date" value="<?php echo ($result->commence_date != '0000-00-00') ? date("d-m-Y",strtotime($result->commence_date)) : '';?>" class="form-control required"  autocomplete="off"/>
   </div>
 </div>

 <div class="form-group">
 </div>

 <div class="form-group">
  <label class="col-md-2 control-label" for="inputDefault">Visa Type</label>
  <div class="col-md-3">
    <input type="radio" name="visa_type" value="14" <?php echo $enroll->visa == 14 ? 'checked':'';?>> Education &nbsp;&nbsp;
    <input type="radio" name="visa_type" value="28" <?php echo $enroll->visa == 28 ? 'checked':'';?>> Migration
  </div>

  <label class="col-md-2 control-label" for="inputDefault">Visa Sub category</label>
  <div class="col-md-3">
    <select class="form-control required" name="sub_visa_type" id="sub_visa_type" data-plugin-selectTwo>
      <option value="">Select</option>
    </select>
  </div>
  <div class="col-md-1">
    <a href="javascript:void(0);" id="link_visa_type"><i class="glyphicon glyphicon-plus"></i></a>
  </div>

</div>



<div class="div_student" <?php if($enroll->visa != '14') echo 'style="display:none;"';?>>
    <div class="form-group">
    <label class="col-md-2 control-label" for="inputDefault">Intake</label>
    <div class="col-md-3">
    <select class="form-control required" data-plugin-selectTwo name="intake" id="intake">
      <option value="">Select</option>
      <?php
      foreach ($intakes as $row) {
      ?>
      <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $enroll->intake) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
      <?php
    }
    ?>

    </select>
    </div>
    <div class="col-md-1">
      <a href="javascript:void(0);" id="link_intake"><i class="glyphicon glyphicon-plus"></i></a>
    </div>
</div>
 <div class="form-group">
  <label class="col-md-2 control-label" for="inputDefault">College</label>
  <div class="col-md-3">
   <select class="form-control " data-plugin-selectTwo name="college" id="college">
    <option value="">Select</option>
    <?php
    foreach ($colleges as $row) {
     ?>
     <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $enroll->college) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
     <?php
   }
   ?>
 </select>
</div>
<div class="col-md-1">
  <a href="javascript:void(0);" id="link_college"><i class="glyphicon glyphicon-plus"></i></a>
</div>
<?php
$degree = $this->enrollmodel->getDegree($enroll->college);
?>
<label class="col-md-2 control-label" for="inputDefault" >Degree</label>
<div class="col-md-3">
  <select class="form-control " data-plugin-selectTwo name="degree" id="degree">
    <option value="">Select</option>
    <?php
    foreach ($degree as $row) {
     ?>
     <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $enroll->degree) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
     <?php
   }
   ?>
 </select>
</div>
<div class="col-md-1">
  <a href="javascript:void(0);" id="link_degree"><i class="glyphicon glyphicon-plus"></i></a>
</div>
<label class="col-md-2 control-label" for="inputDefault"></label>
<div class="col-md-3">
  <input type="hidden" name="txt_fee" id="txt_fee" class="form-control "> 
  <span id="tution_fee"></span>
  <span id="div_period"></span>
  <input type="hidden" name="fee_period" id="fee_period" class="form-control">
</div>
</div>

<?php
$courses = $this->enrollmodel->getCourse($enroll->degree);
?>
<div class="form-group">
  <label class="col-md-2 control-label" for="inputDefault">Course</label>
  <div class="col-md-3">
   <select class="form-control " data-plugin-selectTwo name="course" id="course">
    <option value="">Select</option>
    <?php
    foreach($courses as $row){
      ?>
      <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $enroll->course) echo 'selected="seleted"';?>><?php echo $row->type_name;?></option>
      <?php
    }
    ?>
  </select>
</div>

<div class="col-md-1">
  <a href="javascript:void(0);" id="link_course"><i class="glyphicon glyphicon-plus"></i></a>
</div>

</div>

<div class="form-group"  >
  <label class="col-md-2 control-label" for="inputDefault">Student want to pay for</label>
  <div class="col-md-3">
    <input type="radio" name="duration" class="" value="One Semester" <?php if($enroll->pay_period == 'One Semester') echo 'checked="checked"';?>> One Semester &nbsp;&nbsp;
    <input type="radio" name="duration" id="tri-semester" class="" value="Tri-semester" <?php if($enroll->pay_period == 'Tri-semester') echo 'checked="checked"';?>> Tri-semester &nbsp;&nbsp;&nbsp;
    <input type="radio" name="duration" class="" value="One Year" <?php if($enroll->pay_period == 'One Year') echo 'checked="checked"';?>> One Year &nbsp;&nbsp;
    <input type="radio" name="duration" class="" value="Whole Course" <?php if($enroll->pay_period == 'Whole Course') echo 'checked="checked"';?>> Whole Course &nbsp;&nbsp;
  </div>
  <label class="col-md-3 control-label" for="inputDefault">Fee</label>
  <div class="col-md-3">
    <input type="text" name="fee" id="fee" class="form-control required" value="<?php echo $enroll->fee;?>" > 
  </div>
</div>

<div class="form-group" >
  <label class="col-md-2 control-label" for="inputDefault">Discount</label>
  <div class="col-md-3">
    <input type="text" name="txt_discount" id="txt_discount" class="form-control required" value="<?php echo $enroll->discount;?>" > 
  </div>
  <div class="col-md-2">
    <input type="checkbox" name="is_percentage" id="is_percentage" value="1" <?php if($enroll->is_percent == '1') echo 'checked="checked"';?>> Is Percentage
  </div>
  <label class="col-md-1 control-label" for="inputDefault">Total</label>
  <div class="col-md-2">
    <input type="text" name="total_fee" id="total_fee" class="form-control required" value="<?php echo $enroll->total_fee;?>" > 
  </div>
</div>


<div class="form-group">
  <label class="col-md-2 control-label" for="inputDefault">Current Status in Nepal</label>
  <div class="col-md-3">
    <input type="radio" name="current_status" class="" id="current_status_yes" value="1" <?php if($enroll->current_status == '1') echo 'checked="checked"';?>> Offshore &nbsp;&nbsp;
    <input type="radio" name="current_status" class="" id="current_status_no" value="2" <?php if($enroll->current_status == '0') echo 'checked="checked"';?>> Onshore
  </div>
</div>

</div>
<div class="form-group">
</div>
<div class="form-group" id="div_current_status" <?php if($enroll->current_status == '1') echo 'style="display:none;"';?> >
  <label class="col-md-2 control-label" for="inputDefault">Visa title</label>
  <div class="col-md-2">
    <input type="text" name="visa_title" class="form-control " value="<?php echo $enroll->visa_title;?>">
  </div>
  <label class="col-md-1 control-label" for="inputDefault">Visa Subclass</label>
  <div class="col-md-2">
   <select class="form-control " data-plugin-selectTwo name="visa_class" id="visa_class">
    <option value="">Select</option>
    <?php
    foreach ($visa_class as $row) {
     ?>
     <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $enroll->visa_subclass) echo 'selected="seleted"';?>><?php echo $row->type_name;?></option>
     <?php
   }
   ?>
 </select>
 
</div>
<label class="col-md-1 control-label" for="inputDefault"><a href="javascript:void(0);" id="link_visa_class"><i class="glyphicon glyphicon-plus"></i></a></label>
<label class="col-md-1 control-label" for="inputDefault">Visa Expiry Date</label>
<div class="col-md-2">
  <input type="text" data-plugin-datepicker="" name="expiry_date" class="form-control " value="<?php echo date("d/m/Y",strtotime($enroll->expiry_date));?>">
</div>
</div>

<div class="form-group">

  <label class="col-md-2 control-label" for="description"></label>
  <div class="col-md-3">
    <input type="checkbox" name="show_package" id="show_package" value="1" <?php if($result->is_packaged == '1') echo 'checked="checked"';?>> Add Package
  </div>
</div>

<div id="div_package"  <?php if($result->is_packaged == '0') echo 'style="display:none;"';?>>

  <div class="form-group">
    <label class="col-md-2 control-label">Package</label>
    <div class="col-md-8">

      <table style="width: 100%;" id="div_document">
        <tr>
          <td></td>
          <td><strong>Package</strong></td>
          <td><strong>Quantity</strong></td>
          <td><strong>Unit Price</strong></td>
          <td><strong>Total Price</strong></td>
          <td></td>
        </tr>
        <?php 
        $num = 1;
        foreach ($project_packages as $project_pack) {
        # code...
         ?>
         <tr id="tr_<?php echo $num;?>">
           <td>   <a href="javascript:void(0);" class="link_package btn btn-primary list-btn" rel='1'><i class="glyphicon glyphicon-plus"></i></a></td>
           <td> 
              <select name="package[]" rel="<?php echo $num;?>" id="package_desc_<?php echo $num;?>" class="form-control package_name  doccuments" data-plugin-selectTwo>
              <option value="">Select</option>

            <?php 
              foreach ($inverters as $row){
                ?>
                <option value="<?php echo $row->name;?>" rel="<?php echo $row->price;?>" <?php if($project_pack->package_id == $row->name) echo 'selected="selected"';?> ><?php echo $row->name;?></option>
                <?php
              }
              ?>
          
           </select>
         </td>
         <td> <input type="text" name="qty[]" value="<?php echo $project_pack->qty; ?>" rel="<?php echo $num;?>" id="package_qty_<?php echo $num;?>" class="package_qty form-control" style="width:50px;margin-left:20px;"></td>
         <td> <input type="text" name="unit_price[]" value="<?php echo $project_pack->unit_price; ?>" rel="<?php echo $num;?>" id="unit_price_<?php echo $num;?>" class="unit_price form-control" style="width:50px"></td>
         <td> <input type="text" name="package_price[]" value="<?php echo $project_pack->total_price; ?>" rel="<?php echo $num;?>" id="package_price_<?php echo $num;?>" class="package_price form-control" style="width:50px"></td>
         <td><a href="javascript:void(0);" class="link_remove" rel="<?php echo $num;?>"> Remove</a></td>
       </tr>
       <?php 
       $num++;
     } ?>
   </table>
   <a href="javascript:void(0);" id="add_more">Add</a>
 </div>

</div>


<div class="form-group">
  <label class="col-md-2 control-label" for="price">Price</label>
  <div class="col-md-3">
    <input type="text" name="price" value="<?php echo $result->price;?>" rel="<?php //echo $gst->config_value;?>"  class="form-control" id="price" required>

  </div>
  <div class="col-md-2">
    <input type="checkbox" name="no_tax" id="no_tax" value="1"  <?php if($result->gst == 0) echo 'checked=""';?>> Tax not applicable.

  </div>
  <label class="col-md-1 div_tax control-label div_tax" for="price">Tax Type</label>
    <div class="col-md-3">
     <select name="gst" id="gst" class="form-control" data-plugin-selectTwo>
      <option value="0">Select</option>
      <?php
      foreach ($gsts as $row) {
        ?>
        <option value="<?php echo $row->gst;?>" <?php if($row->gst == $result->gst) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
        <?php
      }
      ?>
    </select>
  </div>
  <div class="col-md-1 div_tax">
    <a href="javascript:void(0);" id="link_gst"><i class="glyphicon glyphicon-plus"></i></a>
  </div>
</div>



<div class="form-group">
  <label class="col-md-2 control-label" for="total">Total</label>
  <div class="col-md-3">
    <input type="text" name="total" value="<?php echo $result->total;?>" rel="<?php //echo $gst->config_value;?>" class="form-control" id="total" >
  </div>
  
</div>
</div>
<div class="form-group">
</div>
<div class="form-group">
  <label class="col-md-2 control-label" for="grand">Grand Total</label>
  <div class="col-md-3">
    <input type="text" name="grand" value="<?php echo $result->grand_total;?>"  class="form-control" id="grand" readonly="">
  </div>
  <label class="col-md-3 control-label" for="inputDefault">Currency</label>
  <div class="col-md-3">
   <select class="form-control required" name="currency" id="currency" data-plugin-selectTwo>
    <option value="">Select</option>
    <?php 
    foreach ($currencies as $row) {
     ?>
     <option value="<?php echo $row->currency_code;?>" <?php if($enroll->currency == $row->currency_code) echo 'selected="selected"'; ?> ><?php echo $row->currency_code;?></option>
     <?php
   }
   ?>
 </select>
</div>
</div>

<div class="form-group">

 <label class="col-md-2 control-label" for="description">Description</label>
 <div class="col-md-9">
  <textarea name="description"  class="form-control" id="description"  ><?php echo $result->description;?></textarea>
</div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label" for="note">Admin Note</label>
  <div class="col-md-9">
    <textarea name="note" class="form-control" id="note" ><?php echo $result->note;?></textarea>
  </div>
</div>


<div class="form-group">

  <label class="col-md-2 control-label">Deadline </label>
  <div class="col-md-3">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text"  name="end_date" class="form-control end_date" required value="<?php echo date("d-m-Y",$result->end_date);?>">
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
      $emp = $this->projectmodel->getEmployeeDetails($row->id,$result->project_id);
      ?>
      <div class="checkbox-custom checkbox-primary" style="width: 100%;">
       <input type="checkbox" value="<?php echo $row->id;?>" name="employee[]" <?php if($emp > 0) echo 'checked="checked"'; ?> id="checkboxExample2">
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
      $emp = $this->projectmodel->getSupplierDetails($row->id,$result->project_id);
      ?>
      <div class="checkbox-custom checkbox-primary" style="width: 100%;">
       <input type="checkbox" value="<?php echo $row->id;?>" name="supplier[]" <?php if($emp > 0) echo 'checked="checked"'; ?> id="checkboxExample2">
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
    <select name="project_status" id="project_status" class="form-control" data-plugin-selectTwo>
     <option value="">Select</option>
     <?php 
     foreach ($project_status as $row) {
      ?>
      <option <?php if($result->project_status == $row->status_id) echo 'selected="selected"';?>  value="<?php echo $row->status_id;?>"><?php echo $row->status_name;?></option>
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
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
   <input type="hidden" name="fee_id" id="fee_id" value="<?php echo $enroll->fee_id; ?>">
   <input type="hidden" name="project_id" value="<?php echo $result->project_id;?>">
   <input type="hidden" name="project" value="<?php echo $this->input->get("project")??0;?>">
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

<?php
$this->load->view("lms/add_purpose");
$this->load->view("quote/popup");
?>

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
        //if ($(this).prop('checked')) {
          var id = $(this).attr('rel');
          if(id){
            var price = $("#package_price_"+id).val();
            package_total+=parseFloat(price);
     // }
     $("#price").val(package_total);
   }
 });
      $("#price").trigger("blur");
    });
    var num = 1;
    $("#add_more").click(function(){
      var cond = 1;
      $(".doccuments").each(function(){
        if($(this).val() == ""){
         cond = 0;

       }

     });
    // if(cond == 0){
    //   alert("Select Package First.");
    //   return false;
    // }

    var num = $(".doccuments").length;
    num = num + 1;
    $("#div_document").append('<tr style="margin-top:10px;" id="tr_'+num+'">'+
      '<td><a href="javascript:void(0);" class="link_package btn btn-primary list-btn" rel="'+num+'"><i class="glyphicon glyphicon-plus"></i></a></td>'+
      '<td>  <select name="package[]" id="package_desc_'+num+'" rel="'+num+'" class="form-control package_name doccuments" data-plugin-selectTwo>'+
      '<option value="">Select</option>'+
      <?php 
          foreach ($inverters as $row){
            ?>
            '<option value="<?php echo $row->name;?>" rel="<?php echo $row->price;?>" ><?php echo $row->name;?></option>'+
            <?php
          }
          ?>
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
    $(document).on('change','.package_name',function(){
      if($(this).val() == '')
        return false;
      var id = $(this).attr("rel");
      var price = $('option:selected', this).attr('rel');
      var qty = $("#package_qty_"+id).val();
      var package_total = price * qty;
      $("#unit_price_"+id).val(price);
      $("#package_price_"+id).val(package_total);
      $(".package_price").trigger("blur");
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

    $("#college").change(function(){
      $("#course").trigger("change");
    });

    var visa_type = '<?php echo $enroll->visa;?>';
    var visa_sub_category = '<?php echo $enroll->visa_sub_category;?>';
    $.ajax({
        url: '<?php echo base_url() ?>visa/getsubcategory',
        type: "POST",
        data: {visa_type:visa_type,visa_sub_category:visa_sub_category},
        success: function(data) { 
          if(data != ""){
            $("#sub_visa_type").html(data);
            $("#sub_visa_type").select2();
          }
        }        
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
     // $("#referral").addClass("required");
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
     // $("#referral").removeClass("required");
     $("#address").removeClass("required");
     $("#sex").removeClass("required");
     $("#is_married").removeClass("required");
     $("#username").removeClass("required");
     $("#password").removeClass("required");
     $("#cpassword").removeClass("required");
     $("#about_us").removeClass("required");
     $("#student").addClass("required");
   });

   $( ".start_date" ).datepicker({ format: 'dd-mm-yyyy',
      startDate: '-0d',
      autoclose: true });

      $( "#commence_date" ).datepicker({ format: 'dd-mm-yyyy',
      startDate: '-0d',
      autoclose: true });

      
  $( ".end_date" ).datepicker({ format: 'dd-mm-yyyy',
      startDate: '-0d',
      autoclose: true });
  });
</script>