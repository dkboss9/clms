



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Degree : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("degree/add");?>" method="post" enctype='multipart/form-data'>

         <div class="form-group">
           <label class="col-md-3 control-label" for="country">Country</label>
           <div class="col-md-6">
             <select class="form-control required" data-plugin-selectTwo  name="country" id="country">
              <option value="">Select</option>
              <?php
              foreach ($countries as $row) {
               ?>
               <option value="<?php echo $row->country_id;?>"><?php echo $row->country_name;?></option>
               <?php
             }
             ?>
           </select>
         </div>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">College</label>
        <div class="col-md-6">
         <select class="form-control required" data-plugin-selectTwo name="college" id="college">
          <option value="">Select</option>

        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Name</label>
      <div class="col-md-6">
        <input type="text" name="name" value=""  class="form-control" id="inputDefault" required>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Description</label>
      <div class="col-md-6">
       <textarea name="txt_desc" class="form-control" ></textarea>
     </div>
   </div>


   <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault"></label>
    <div class="col-md-6">
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
