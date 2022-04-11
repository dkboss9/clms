


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

        <h2 class="panel-title">Institute : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("college/add");?>" method="post" enctype='multipart/form-data'>

        <div class="form-group">
            <label class="col-md-2 control-label" for="inputDefault">Name</label>
            <div class="col-md-3">
              <input type="text" name="name" value=""  class="form-control required" id="inputDefault" >
            </div>
            <label class="col-md-3 control-label" for="inputDefault">Trading Name</label>
            <div class="col-md-3">
              <input type="text" name="trading_name" value=""  class="form-control" id="inputDefault" required>
            </div>
        </div>

       
         <div class="form-group">
           <label class="col-md-2 control-label" for="country">Country</label>
           <div class="col-md-3">
             <select class="form-control country" data-plugin-selectTwo  name="country"  required>
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
         <label class="col-md-3 control-label" for="city">City</label>
           <div class="col-md-3">
             <select class="form-control " data-plugin-selectTwo  name="city"  id="city">
              <option value="">Select</option>
             
           </select>
         </div>
       </div>

      <div class="form-group">
        <label class="col-md-2 control-label" for="inputDefault">Agreement expiry date</label>
        <div class="col-md-3">
          <input type="text" name="expiry_date" value=""  class="form-control datepicker" id="" required>
        </div>
        <label class="col-md-3 control-label" for="inputDefault">Contact person name</label>
        <div class="col-md-3">
          <input type="text" name="contact_name" value=""  class="form-control" id="" required>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-2 control-label" for="inputDefault">Email</label>
        <div class="col-md-3">
          <input type="email" name="contact_email" value=""  class="form-control email" id="" required>
        </div>
        <label class="col-md-3 control-label" for="inputDefault">Contact Number</label>
        <div class="col-md-3">
        <input type="text" name="contact_number" value=""  class="form-control" id="" >
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-2 control-label" for="inputDefault">ABN</label>
        <div class="col-md-3">
          <input type="text" name="abn" value=""  class="form-control " id="" required>
        </div>
        <label class="col-md-3 control-label" for="inputDefault">Description</label>
        <div class="col-md-3">
          <textarea name="txt_desc" class="form-control" ></textarea>
        </div>
      </div>

    
      <div class="form-group">
        <label class="col-md-2 control-label" for="inputDefault">Level of College</label>
        <div class="col-md-3">
        <select class="form-control required" data-plugin-selectTwo  name="college_level">
              <option value="">Select</option>
              <?php 
                foreach($levels as $level){
                  ?>
                  <option value="<?php echo $level->id;?>"><?php echo $level->name;?></option>
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
          <a href="<?php echo base_url("college");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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

<script>
  $(document).ready(function(){
    $( ".datepicker" ).datepicker({ format: 'dd-mm-yyyy',
      startDate: '-0d',
      autoclose: true });
    $(".country").change(function(){
      var country = $(this).val();
      $.ajax({
        method: "POST",
        url: "<?php echo base_url("college/getcity")?>",
        data: { country: country}
      })
        .done(function( msg ) {
          $("#city").html(msg);
          $("#city").select2();
        });
    });
  });
</script>