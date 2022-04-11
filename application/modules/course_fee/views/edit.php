



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">course fee : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("course_fee/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
           <label class="col-md-3 control-label" for="country">Country</label>
           <div class="col-md-6">
             <select class="form-control required" data-plugin-selectTwo  name="country" id="country">
              <option value="">Select</option>
              <?php
              foreach ($countries as $row) {
               ?>
               <option value="<?php echo $row->country_id;?>" <?php if($row->country_id == $result->country_id) echo 'selected="selected"';?>><?php echo $row->country_name;?></option>
               <?php
             }
             ?>
           </select>
         </div>
       </div>

       <div class="form-group">
         <label class="col-md-3 control-label" for="intake">Intake</label>
         <div class="col-md-6">
          <select class="form-control required" data-plugin-selectTwo  name="intake" id="intake">
            <option value="">Select</option>
            <?php
            foreach ($intakes as $row) {
             ?>
             <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $result->intake_id) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
             <?php
           }
           ?>
         </select>
       </div>
       <div class="col-md-3">
        <a href="javascript:void(0);" id="link_intake"><i class="glyphicon glyphicon-plus"></i></a>
      </div>
    </div>

    <?php
    $colleges = $this->course_feemodel->getColleges($result->country_id);
    ?>
    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">College</label>
      <div class="col-md-6">
        <select class="form-control required" data-plugin-selectTwo  name="college" id="college">
          <option value="">Select</option>
          <?php
          foreach ($colleges as $row) {
           ?>
           <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $result->college) echo 'selected="seleted"';?>><?php echo $row->type_name;?></option>
           <?php
         }
         ?>
       </select>
     </div>
     <div class="col-md-3">
      <a href="javascript:void(0);" id="link_college"><i class="glyphicon glyphicon-plus"></i></a>
    </div>
  </div>
  <?php
  $degree = $this->course_feemodel->getDegree($result->college);
  ?>
  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault" >Degree</label>
    <div class="col-md-6">
      <select class="form-control required" data-plugin-selectTwo  name="degree" id="degree">
        <option value="">Select</option>
        <?php
        foreach ($degree as $row) {
         ?>
         <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $result->degree) echo 'selected="seleted"';?>><?php echo $row->type_name;?></option>
         <?php
       }
       ?>
     </select>
   </div>
   <div class="col-md-3">
    <a href="javascript:void(0);" id="link_degree"><i class="glyphicon glyphicon-plus"></i></a>
  </div>
</div>
<?php
$courses = $this->course_feemodel->getCourse($result->degree);
?>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Course</label>
  <div class="col-md-6">
   <select class="form-control required" data-plugin-selectTwo  name="course" id="course">
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
<div class="col-md-3">
  <a href="javascript:void(0);" id="link_course"><i class="glyphicon glyphicon-plus"></i></a>
</div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Currency</label>
  <div class="col-md-6">
   <select class="form-control required" data-plugin-selectTwo  name="currency" id="currency">
    <option value="">Select</option>
    <?php 
    foreach ($currencies as $row) {
     ?>
     <option value="<?php echo $row->currency_code;?>" <?php if($row->currency_code == $result->currency) echo 'selected="selected"';?>><?php echo $row->currency_code;?></option>
     <?php
   }
   ?>
 </select>
</div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Semester Fee</label>
  <div class="col-md-6">
    <input type="number" name="fee" class="form-control required" value="<?php echo $result->price;?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Tri-semester Fee</label>
  <div class="col-md-6">
    <input type="number" name="tri_fee" class="form-control required"  value="<?php echo $result->tri_fee;?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Yearly Fee</label>
  <div class="col-md-6">
    <input type="number" name="y_fee" value="<?php echo $result->y_price; ?>" class="form-control required">
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Total Fee</label>
  <div class="col-md-6">
    <input type="number" name="t_fee" value="<?php echo $result->t_price; ?>" class="form-control required">
  </div>
</div>
<?php //echo $result->period; ?>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Duration</label>
  <div class="col-md-6">
    <input type="radio" name="duration" class="required" value="Semester" <?php if($result->period == "Semester") echo 'checked="checked"';?>> Semester &nbsp; &nbsp; &nbsp;
     <input type="radio" name="duration" class="required" value="Tri-semester" <?php if($result->period == "Tri-semester") echo 'checked="checked"';?>>Tri-Semester &nbsp; &nbsp; &nbsp;
    <input type="radio" name="duration" class="required" value="Yearly" <?php if($result->period == "Yearly") echo 'checked="checked"';?>> Yearly &nbsp; &nbsp; &nbsp;
    <input type="radio" name="duration" class="required" value="Total" <?php if($result->period == "Total") echo 'checked="checked"';?>> Total
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-3">
   <table class="table table-bordered table-striped mb-none" >
    <tr>
      <th><input type="checkbox" id="chk_all_list"></th>
      <th>Offer letter checklist</th>
    </tr>
    <tbody>
      <?php 
      foreach ($checklist->result() as $row) {
        $num = $this->course_feemodel->checkChecklist($row->type_id,$result->fee_id);
        ?>
        <tr>
          <td><input type="checkbox" class="chk_list" name="chk_list[]" value="<?php echo $row->type_id;?>" <?php if($num > 0) echo 'checked="checked"';?>></td>
          <td> <?php echo $row->type_name;?></td>
        </tr>
        <?php
      }
      ?>


    </tbody>
  </table>
</div>
<div class="col-md-3">
   <table class="table table-bordered table-striped mb-none" >
    <tr>
      <th><input type="checkbox" id="chk_all_coe_list"></th>
      <th>Coe processing checklist</th>
    </tr>
    <tbody>
      <?php 
      foreach ($checklist->result() as $row) {
        $num = $this->course_feemodel->checkChecklist($row->type_id,$result->fee_id,"ceo-processing");
        ?>
        <tr>
          <td><input type="checkbox" class="chk_coe_list" name="chk_coe_list[]" value="<?php echo $row->type_id;?>" <?php if($num > 0) echo 'checked="checked"';?>></td>
          <td> <?php echo $row->type_name;?></td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>

<div class="col-md-3">
  <table class="table table-bordered table-striped mb-none" >
    <thead>
      <tr>
        <th><input type="checkbox" id="chk_all_form"></th>
        <th>Downloadable Form</th>
        <th>Type</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach ($downloads->result() as $acc) {
        $num = $this->course_feemodel->checkFormlist($acc->type_id,$result->fee_id);
        $publish = ($acc->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
        ?>
        <tr class="gradeX">
         <td><input type="checkbox" class="chk_form" name="chk_form[]" value="<?php echo $acc->type_id;?>" <?php if($num > 0) echo 'checked="checked"';?>></td>
         <td><a href="<?php echo SITE_URL."uploads/student_documents/".$acc->doc_name;?>" target="_blank"><?php echo $acc->typename;?></a></td>
         <td><?php echo $acc->type_name;?></td>

       </tr>
       <?php
     } ?>


   </tbody>
 </table>
</div>
</div>


<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="type_id" value="<?php echo $result->fee_id;?>">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("course_fee");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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

  
  $('#chk_all_coe_list').on('click', function () {
      $(".chk_coe_list").prop('checked', this.checked);
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
   $("#degree").change(function(){
    var degree = $(this).val();
    $.ajax({
      url: '<?php echo base_url() ?>course_fee/getCourse',
      type: "POST",
      data: "degree=" + degree,
      success: function(data) { 
        if(data != ""){
          $("#course").html(data);
        }
      }        
    });
  });
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
   $("#country").change(function(){
    var country = $(this).val();
    $.ajax({
      url: '<?php echo base_url() ?>course_fee/getColleges',
      type: "POST",
      data: "country=" + country,
      success: function(data) { 
        if(data != ""){
          $("#college").html(data);
        }
      }        
    });
  });
   $('#chk_all_list').on('click', function () {
    $(".chk_list").prop('checked', this.checked);
  });

   $('#chk_all_form').on('click', function () {
    $(".chk_form").prop('checked', this.checked);
  });
 });
</script>