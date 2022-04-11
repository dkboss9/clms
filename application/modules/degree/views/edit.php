



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Degree : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("degree/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
           <label class="col-md-3 control-label" for="country">Country</label>
           <div class="col-md-6">
             <select class="form-control required" data-plugin-selectTwo name="country" id="country">
              <option value="">Select</option>
              <?php
              foreach ($countries as $row) {
               ?>
               <option value="<?php echo $row->country_id;?>" <?php if($row->country_id == $result->country_id) echo 'selected="seleted"';?>><?php echo $row->country_name;?></option>
               <?php
             }
             ?>
           </select>
         </div>
       </div>
       <?php
       $colleges = $this->course_feemodel->getColleges($result->country_id);
       ?>

       <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">College</label>
        <div class="col-md-6">
         <select class="form-control required" data-plugin-selectTwo name="college" id="college">
          <option value="">Select</option>
          <?php
          foreach ($colleges as $row) {
           ?>
           <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $result->college_id) echo 'selected="seleted"';?>><?php echo $row->type_name;?></option>
           <?php
         }
         ?>
       </select>
     </div>
   </div>


   <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Name</label>
    <div class="col-md-6">
      <input type="text" name="name" value="<?php echo $result->type_name;?>"  class="form-control" id="inputDefault" required>
      <?php echo form_error("name");?>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Description</label>
    <div class="col-md-6">
     <textarea name="txt_desc" class="form-control" ><?php echo $result->degree_desc; ?></textarea>
   </div>
 </div>


 <div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="type_id" value="<?php echo $result->type_id;?>">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("degree");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
   
 });
</script>
