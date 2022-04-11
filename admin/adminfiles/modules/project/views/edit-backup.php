
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
            <label class="col-md-3 control-label" for="lead_type">Lead Type</label>
            <div class="col-md-3">
              <select name="lead_type" class="form-control" id="lead_type" required>
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
           <label class="col-md-2 control-label" for="inputDefault">Sale Reps</label>
           <div class="col-md-3">
            <select name="user" class="form-control mb-md" required>
              <option value="">Select</option>
              <?php 
              foreach($users as $user){
                ?>
                <option <?php if($user->userid == $result->sales_rep) echo 'selected="selected"';?> value="<?php echo $user->userid;?>"><?php echo $user->first_name.' '.$user->last_name;?></option>
                <?php
              }
              ?>
            </select>
          </div>
        </div>


        <div class="form-group" id="div_old_student">
          <label class="col-md-3 control-label" for="inputDefault">Student</label>
          <div class="col-md-3">

           <select class="form-control required" name="student" id="student">
            <option value="">Select</option>
            <?php
            foreach ($students->result() as $row) {
             ?>
             <option value="<?php echo $row->userid;?>" <?php if($row->userid == $enroll->student_id) echo 'selected="selected"';?>><?php echo $row->first_name.' '.$row->last_name;?></option>
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

     <label class="col-md-3 control-label" for="lname">Commence Date</label>
     <div class="col-md-3">
       <input type="text" data-plugin-datepicker="" name="commence_date" id="commence_date" value="<?php echo ($result->commence_date != '0000-00-00') ? date("d/m/Y",strtotime($result->commence_date)) : '';?>" class="form-control required"  />
     </div>
   </div>

   <div class="form-group">
   </div>

   <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Visa Type</label>
    <div class="col-md-3">
     <select class="form-control required" name="visa_type" id="visa_type">
      <option value="">Select</option>
      <?php
      foreach ($visa as $row) {
       ?>
       <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $enroll->visa) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
       <?php
     }
     ?>

   </select>
 </div>
 <label class="col-md-2 control-label" for="inputDefault">Intake</label>
 <div class="col-md-3">
   <select class="form-control required" name="intake" id="intake">
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
</div>



<div id="div_student" style="display:none;">
 <div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">College</label>
  <div class="col-md-3">
   <select class="form-control " name="college" id="college">
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
<label class="col-md-2 control-label" for="inputDefault" >Degree</label>
<div class="col-md-3">
  <select class="form-control " name="degree" id="degree">
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
</div>

<?php
$courses = $this->enrollmodel->getCourse($enroll->degree);
?>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Course</label>
  <div class="col-md-3">
   <select class="form-control " name="course" id="course">
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
<label class="col-md-2 control-label" for="inputDefault">Fee</label>
<div class="col-md-3">
  <input type="number" name="fee" id="fee" class="form-control <?php if($enroll->visa == 14) echo 'required';?>" value="<?php echo $enroll->fee;?>">
  <input type="hidden" name="fee_period" id="fee_period" class="form-control" value="<?php echo $enroll->period;?>">
</div>
<label class="col-md-1 control-label" for="inputDefault" id="div_period"></label>
</div>


<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Current Status in Nepal</label>
  <div class="col-md-6">
    <input type="radio" name="current_status" class="" id="current_status_yes" value="1" <?php if($enroll->current_status == '1') echo 'checked="checked"';?>>Yes &nbsp;&nbsp;
    <input type="radio" name="current_status" class="" id="current_status_no" value="2" <?php if($enroll->current_status == '0') echo 'checked="checked"';?>> No
  </div>
</div>
<div class="form-group" style="display:none;" id="div_current_status">
  <label class="col-md-3 control-label" for="inputDefault">Student want to pay for</label>
  <div class="col-md-6">
    <input type="radio" name="duration" class="" value="One Semester" <?php if($enroll->pay_period == 'One Semester') echo 'checked="checked"';?>>One Semester &nbsp;&nbsp;
    <input type="radio" name="duration" class="" value="One Year" <?php if($enroll->pay_period == 'One Year') echo 'checked="checked"';?>> One Year &nbsp;&nbsp;
    <input type="radio" name="duration" class="" value="Whole Course" <?php if($enroll->pay_period == 'Whole Course') echo 'checked="checked"';?>>Whole Course &nbsp;&nbsp;
  </div>
</div>
</div>
<div class="form-group">
</div>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Visa title</label>
  <div class="col-md-3">
    <input type="text" name="visa_title" class="form-control required" value="<?php echo $enroll->visa_title;?>">
  </div>
  <label class="col-md-2 control-label" for="inputDefault">Visa Subclass</label>
  <div class="col-md-3">
   <select class="form-control required" name="visa_class" id="visa_class">
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
</div>



<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Visa Expiry Date</label>
  <div class="col-md-3">
   <input type="text" data-plugin-datepicker="" name="expiry_date" class="form-control required" value="<?php echo date("d/m/Y",strtotime($enroll->expiry_date));?>">
 </div>
 <label class="col-md-2 control-label" for="description">Description</label>
 <div class="col-md-3">
  <textarea name="description"  class="form-control" id="description"  ><?php echo $result->description;?></textarea>
</div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">Package</label>
  <div class="col-md-6">

    <table style="width: 100%;" id="div_document">
      <tr>
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
         <td>  <select name="package[]" rel="<?php echo $num;?>" id="package<?php echo $num;?>" class="form-control doccuments">
          <option value="">Select</option>
          <?php 
          foreach ($packages as $package) {
           ?>
           <option value="<?php echo $package->package_id;?>" <?php if($project_pack->package_id == $package->package_id) echo 'selected="selected"';?>><?php echo $package->package_name; ?></option>
           <?php }?>
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
  <label class="col-md-3 control-label" for="price">Product Price</label>
  <div class="col-md-3">
    <input type="text" name="price" value="<?php echo $result->price;?>" rel="<?php //echo $gst->config_value;?>"  class="form-control" id="price" required>

  </div>
  <label class="col-md-2 control-label" for="price">GST</label>
  <div class="col-md-3">
  <?php /*
    <input type="hidden" name="gst" value="<?php echo $gst->config_value;?>"  class="form-control" id="gst" required>

    <label class="col-md-3 control-label" for="price"><?php echo $gst->config_value;?> %</label>
 */ ?>

 <select name="gst" id="gst" class="form-control">
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
</div>



<div class="form-group">
  <label class="col-md-3 control-label" for="total">Total</label>
  <div class="col-md-3">
    <input type="text" name="total" value="<?php echo $result->total;?>" rel="<?php //echo $gst->config_value;?>" class="form-control" id="total" >
  </div>
  <label class="col-md-2 control-label" for="grand">Grand Total</label>
  <div class="col-md-3">
    <input type="text" name="grand" value="<?php echo $result->grand_total;?>"  class="form-control" id="grand" readonly="">
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="project_status">Status</label>
  <div class="col-md-3">
    <select name="project_status" id="project_status" class="form-control">
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
<label class="col-md-2 control-label" for="note">Admin Note</label>
<div class="col-md-3">
  <textarea name="note" class="form-control" id="note" ><?php echo $result->note;?></textarea>
</div>
</div>


<div class="form-group">
  <label class="col-md-3 control-label">Start Date</label>
  <div class="col-md-3">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="start_date" class="form-control" value="<?php echo date("d/m/Y",$result->start_date);?>" required>
    </div>
  </div>
  <label class="col-md-2 control-label">End Date</label>
  <div class="col-md-3">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="end_date" class="form-control" required value="<?php echo date("d/m/Y",$result->end_date);?>">
    </div>
  </div>
</div>



<div class="form-group">
  <label class="col-md-3 control-label">Add Consultant </label>
  <div class="col-md-3">
    <div class="input-group">

     <?php 
     foreach ($employees as $row) {
      $emp = $this->projectmodel->getEmployeeDetails($row->userid,$result->project_id);
      ?>
      <div class="checkbox-custom checkbox-primary">
       <input type="checkbox" value="<?php echo $row->userid;?>" name="employee[]" <?php if($emp > 0) echo 'checked="checked"'; ?> id="checkboxExample2">
       <label for="checkboxExample2"><?php echo $row->first_name.' '.$row->last_name; ?></label>
     </div>
     <?php
   }
   ?>
 </div>
</div>
<label class="col-md-2 control-label">Add Consultancy </label>
<div class="col-md-3">
  <div class="input-group">

    <?php 
    foreach ($suppliers as $row) {
      $emp = $this->projectmodel->getSupplierDetails($row->userid,$result->project_id);
      ?>
      <div class="checkbox-custom checkbox-primary">
       <input type="checkbox" value="<?php echo $row->userid;?>" name="supplier[]" <?php if($emp > 0) echo 'checked="checked"'; ?> id="checkboxExample2">
       <label for="checkboxExample2"><?php echo $row->first_name.' '.$row->last_name; ?></label>
     </div>
     <?php
   }
   ?>
 </div>
</div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
   <input type="hidden" name="project_id" value="<?php echo $result->project_id;?>">
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
          var price = $("#package_price_"+id).val();
          package_total+=parseFloat(price);
     // }
     $("#price").val(package_total);
   });
      $("#price").trigger("blur");
    });
    var num = <?php echo $num;?>;
    $("#add_more").click(function(){
      var cond = 1;
      $(".doccuments").each(function(){
        if($(this).val() == ""){
         cond = 0;

       }

     });
      if(cond == 0){
        alert("Select Package First.");
        return false;
      }

     // var num = $(".doccuments").length;
     num = num + 1;
     $("#div_document").append('<tr style="margin-top:10px;" id="tr_'+num+'">'+
      '<td>  <select name="package[]" id="package'+num+'" rel="'+num+'" class="form-control doccuments">'+
      '<option value="">Select</option>'+
      <?php 
      foreach ($packages as $package) {
       ?>
       '<option value="<?php echo $package->package_id;?>"><?php echo $package->package_name; ?></option>'+
       <?php }?>
       '</select>'+
       '</td>'+
       '<td> <input type="text" name="qty[]" value="1" rel="'+num+'" id="package_qty_'+num+'" class="package_qty" style="width:50px;margin-left:20px;"></td>'+
       '<td> <input type="text" name="unit_price[]" value="0" rel="'+num+'" id="unit_price_'+num+'" class="unit_price" style="width:50px"></td>'+
       '<td> <input type="text" name="package_price[]" value="0" rel="'+num+'" id="package_price_'+num+'" class="package_price" style="width:50px"></td>'+
       '<td><a href="javascript:void(0);" class="link_remove" rel="'+num+'"> Remove</a></td></tr>');
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
  $("#grand").val(parseFloat(total));
});

$("#gst").change(function(){
  $("#price").trigger("blur");
});

$("#total").blur(function(){
  var gst = $("#gst").val();
  var total = $(this).val();
  if(total == "")
    return false;
  var price = (parseFloat(total)*100)/(parseFloat(gst)+100);
  $("#price").val(price);
  $("#grand").val(parseFloat(total));
});


});
</script>

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