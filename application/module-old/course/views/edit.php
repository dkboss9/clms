



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">course : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("course/edit");?>" method="post" enctype='multipart/form-data'>
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
               <option value="<?php echo $row->country_id;?>" <?php if($row->country_id == $result->country_id) echo 'selected="selected"';?>><?php echo $row->country_name;?></option>
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
        <label class="col-md-3 control-label" for="inputDefault">Degree</label>
        <div class="col-md-6">
          <select name="degree" id="degree" data-plugin-selectTwo class="form-control required">
            <option value="">Select</option>
            <?php foreach ($degree as $row) {
              ?>
              <option value="<?php echo $row->type_id;?>" <?php if($row->type_id==$result->degree_id) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
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
          <textarea name="txt_desc" class="form-control"><?php echo $result->course_desc;?></textarea>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Course Duration</label>
        <div class="col-md-6">
          <select name="period" id="period" data-plugin-selectTwo class="form-control required">
            <option value="">Select</option>
            <option value="6 Months" <?php if($result->period == '6 Months') echo 'selected="selected"';?>>6 Months</option>
            <option value="1 Year" <?php if($result->period == '1 Year') echo 'selected="selected"';?>>1 Year</option>
            <option value="1 Year and 6 Months" <?php if($result->period == '1 Year and 6 Months') echo 'selected="selected"';?>>1 Year and 6 Months</option>
            <option value="2 Years" <?php if($result->period == '2 Years') echo 'selected="selected"';?>>2 Years</option>
            <option value="2 Years and 6 Months" <?php if($result->period == '2 Years and 6 Months') echo 'selected="selected"';?>>2 Years and 6 Months</option>
            <option value="3 Years" <?php if($result->period == '3 Years') echo 'selected="selected"';?>>3 Years</option>
            <option value="4 Years" <?php if($result->period == '4 Years') echo 'selected="selected"';?>>4 Years</option>
            <option value="5 Years" <?php if($result->period == '5 Years') echo 'selected="selected"';?>>5 Years</option>
          </select>
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault"></label>
        <div class="col-md-6">
          <input type="hidden" name="type_id" value="<?php echo $result->type_id;?>">
          <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
          <a href="<?php echo base_url("course");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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


  });
</script>