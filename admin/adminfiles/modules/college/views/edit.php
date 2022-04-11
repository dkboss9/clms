



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Institute : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("college/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-2 control-label" for="inputDefault">Name</label>
            <div class="col-md-3">
              <input type="text" name="name" value="<?php echo $result->type_name;?>"  class="form-control required" id="inputDefault" >
            </div>
            <label class="col-md-3 control-label" for="inputDefault">Trading Name</label>
            <div class="col-md-3">
              <input type="text" name="trading_name" value="<?php echo $result->trading_name;?>"  class="form-control" id="inputDefault" required>
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
               <option value="<?php echo $row->country_id;?>" <?php if($row->country_id == $result->country_id) echo 'selected="selected"';?>><?php echo $row->country_name;?></option>
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
          <input type="text" name="expiry_date" value="<?php echo $result->expiry_date ? date("d-m-Y",strtotime($result->expiry_date)):'';?>"  class="form-control datepicker" id="" required>
        </div>
        <label class="col-md-3 control-label" for="inputDefault">Contact person name</label>
        <div class="col-md-3">
          <input type="text" name="contact_name" value="<?php echo $result->contact_name;?>"  class="form-control" id="" required>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-2 control-label" for="inputDefault">Email</label>
        <div class="col-md-3">
          <input type="email" name="contact_email" value="<?php echo $result->contact_email;?>"  class="form-control email" id="" required>
        </div>
        <label class="col-md-3 control-label" for="inputDefault">Contact Number</label>
        <div class="col-md-3">
        <input type="text" name="contact_number" value="<?php echo $result->contact_number;?>"  class="form-control" id="" >
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-2 control-label" for="inputDefault">ABN</label>
        <div class="col-md-3">
          <input type="text" name="abn" value="<?php echo $result->abn;?>"  class="form-control " id="" required>
        </div>
        <label class="col-md-3 control-label" for="inputDefault">Description</label>
        <div class="col-md-3">
          <textarea name="txt_desc" class="form-control" ><?php echo $result->college_desc;?></textarea>
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
                  <option value="<?php echo $level->id;?>" <?php echo $result->level_of_college == $level->id ? 'selected':''?>><?php echo $level->name;?></option>
                  <?php
                }
              ?>
                        
           </select>
        </div>
      
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault"></label>
        <div class="col-md-6">
          <input type="hidden" name="type_id" value="<?php echo $result->type_id;?>">
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
    var country = '<?php echo $result->country_id;?>';
    var city = '<?php echo $result->city;?>';
    $( ".datepicker" ).datepicker({ format: 'dd-mm-yyyy',
      startDate: '-0d',
      autoclose: true });
    $(".country").change(function(){
      var country = $(this).val();
      $.ajax({
        method: "POST",
        url: "<?php echo base_url("college/getcity")?>",
        data: { country: country,city:city}
      })
        .done(function( msg ) {
          $("#city").html(msg);
          $("#city").select2();
        });
    });
    $(".country").trigger("change");
  });
</script>