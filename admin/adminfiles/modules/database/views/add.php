


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

        <h2 class="panel-title">Database : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("database/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Name</label>
            <div class="col-md-6">
              <input type="text" name="name" value=""  class="form-control" id="inputDefault" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Address</label>
            <div class="col-md-6">
              <input type="text" name="address" value=""  class="form-control" id="inputDefault">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Phone</label>
            <div class="col-md-6">
              <input type="text" name="phone" value=""  class="form-control" id="phone">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Email Address</label>
            <div class="col-md-6">
              <input type="email" name="email" value=""  class="form-control" id="email">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Note</label>
            <div class="col-md-6">
              <textarea class="form-control" name="note"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Category</label>
            <div class="col-md-6">
              <select name="category" id="category" class="form-control mb-md">
                <option value="">Select</option>
                <?php 
                foreach ($category as $cat) {
                  ?>
                  <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
                  <?php 
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group" id="div_sub_category" style="display:none;">
            <label class="col-md-3 control-label" for="inputDefault">Sub Category</label>
            <div class="col-md-6">
              <select name="sub_category" id="sub_category" class="form-control mb-md" >
                <option value="">Select</option>

              </select>
            </div>
          </div>
          <div class="form-group" id="div_sub_category2" style="display:none;">
            <label class="col-md-3 control-label" for="inputDefault">Sub Category 2nd</label>
            <div class="col-md-6">
              <select name="sub_category2" id="sub_category2" class="form-control mb-md" >
                <option value="">Select</option>

              </select>
            </div>
          </div>

          <div class="form-group" id="div_sub_category3" style="display:none;">
            <label class="col-md-3 control-label" for="inputDefault">Sub Category 3rd</label>
            <div class="col-md-6">
              <select name="sub_category3" id="sub_category3" class="form-control mb-md" >
                <option value="">Select</option>

              </select>
            </div>
          </div> 

          <div class="form-group" id="div_sub_category4" style="display:none;">
            <label class="col-md-3 control-label" for="inputDefault">Sub Category 4th</label>
            <div class="col-md-6">
              <select name="sub_category4" id="sub_category4" class="form-control mb-md" >
                <option value="">Select</option>

              </select>
            </div>
          </div> 

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Business Category</label>
            <div class="col-md-6">
              <select name="businesscategory" id="businesscategory" class="form-control mb-md">
                <option value="">Select</option>
                <?php 
                foreach ($business_category as $cat) {
                  ?>
                  <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
                  <?php 
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group" id="div_sub_businesscategory" style="display:none;">
            <label class="col-md-3 control-label" for="inputDefault">Sub Category</label>
            <div class="col-md-6">
              <select name="sub_businesscategory" id="sub_businesscategory" class="form-control mb-md" >
                <option value="">Select</option>

              </select>
            </div>
          </div>
          <div class="form-group" id="div_sub_businesscategory2" style="display:none;">
            <label class="col-md-3 control-label" for="inputDefault">Sub Category 2nd</label>
            <div class="col-md-6">
              <select name="sub_businesscategory2" id="sub_businesscategory2" class="form-control mb-md" >
                <option value="">Select</option>

              </select>
            </div>
          </div>

          <div class="form-group" id="div_sub_businesscategory3" style="display:none;">
            <label class="col-md-3 control-label" for="inputDefault">Sub Category 3rd</label>
            <div class="col-md-6">
              <select name="sub_businesscategory3" id="sub_businesscategory3" class="form-control mb-md" >
                <option value="">Select</option>

              </select>
            </div>
          </div> 

          <div class="form-group" id="div_sub_businesscategory4" style="display:none;">
            <label class="col-md-3 control-label" for="inputDefault">Sub Category 4th</label>
            <div class="col-md-6">
              <select name="sub_businesscategory4" id="sub_businesscategory4" class="form-control mb-md" >
                <option value="">Select</option>

              </select>
            </div>
          </div> 


          <div class="form-group" >
            <label class="col-md-3 control-label" for="inputDefault">Access</label>
            <div class="col-md-6">
              <select name="access" id="access" class="form-control mb-md" >
                <option value="Private">Private</option>
                <option value="Public">Public</option>
                
              </select>
            </div>
          </div> 

          <div class="form-group" style="display:none;" id="div_public">
            <label class="col-md-3 control-label" for="inputDefault">Select Users</label>
            <div class="col-md-9">
              <?php 

              $users = $this->databasemodel->listuser();
              foreach ($users->result() as $user) {
                ?>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="users[]" value="<?php echo $user->userid;?>">
                    <?php echo $user->first_name.' '.$user->last_name;?>
                  </label>
                </div>
                <?php
              }

              ?>
            </div>
          </div> 


          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("database");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
    $("#access").change(function(){
      var data = $(this).val();
      if(data == "Public")
        $("#div_public").show();
      else
        $("#div_public").hide();
    });
    $("#category").change(function(){
     $("#div_sub_category").hide();
     $("#div_sub_category2").hide();
     $("#div_sub_category3").hide();
     $("#div_sub_category4").hide();
     jQuery("#sub_category option[value='']").attr('selected', 'selected');
     jQuery("#sub_category2 option[value='']").attr('selected', 'selected');
     jQuery("#sub_category3 option[value='']").attr('selected', 'selected');
     jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
     var catid = $(this).val();
     $.ajax({
      url: '<?php echo base_url() ?>lms/get_subcategory',
      type: "POST",
      data: "catid=" + catid,
      success: function(data) { 
        if(data != ""){
          $("#sub_category").html(data);
          $("#div_sub_category").show();
        }
      }        
    });
   });

    $("#sub_category").on("change",function(){
      $("#div_sub_category2").hide();
      $("#div_sub_category3").hide();
      $("#div_sub_category4").hide();
      jQuery("#sub_category2 option[value='']").attr('selected', 'selected');
      jQuery("#sub_category3 option[value='']").attr('selected', 'selected');
      jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
      var catid = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>lms/get_subcategory',
        type: "POST",
        data: "catid=" + catid,
        success: function(data) { 
          if(data != ""){
            $("#sub_category2").html(data);
            $("#div_sub_category2").show();
          }
        }        
      });
    });

    $("#sub_category2").on("change",function(){
      $("#div_sub_category3").hide();
      $("#div_sub_category4").hide();

      jQuery("#sub_category3 option[value='']").attr('selected', 'selected');
      jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
      var catid = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>lms/get_subcategory',
        type: "POST",
        data: "catid=" + catid,
        success: function(data) { 
          if(data != ""){
            $("#sub_category3").html(data);
            $("#div_sub_category3").show();
          }
        }        
      });
    });

    $("#sub_category3").on("change",function(){
      $("#div_sub_category4").hide();
      jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
      var catid = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>lms/get_subcategory',
        type: "POST",
        data: "catid=" + catid,
        success: function(data) { 
          if(data != ""){
            $("#sub_category4").html(data);
            $("#div_sub_category4").show();
          }
        }        
      });
    });

    //Business category

    $("#businesscategory").change(function(){
     $("#div_sub_businesscategory").hide();
     $("#div_sub_businesscategory2").hide();
     $("#div_sub_businesscategory3").hide();
     $("#div_sub_businesscategory4").hide();
     jQuery("#sub_businesscategory option[value='']").attr('selected', 'selected');
     jQuery("#sub_businesscategory2 option[value='']").attr('selected', 'selected');
     jQuery("#sub_businesscategory3 option[value='']").attr('selected', 'selected');
     jQuery("#sub_businesscategory4 option[value='']").attr('selected', 'selected');
     var catid = $(this).val();
     $.ajax({
      url: '<?php echo base_url() ?>database/get_businesssubcategory',
      type: "POST",
      data: "catid=" + catid,
      success: function(data) { 
        if(data != ""){
          $("#sub_businesscategory").html(data);
          $("#div_sub_businesscategory").show();
        }
      }        
    });
   });

    $("#sub_businesscategory").on("change",function(){
      $("#div_sub_businesscategory2").hide();
      $("#div_sub_businesscategory3").hide();
      $("#div_sub_businesscategory4").hide();
      jQuery("#sub_businesscategory2 option[value='']").attr('selected', 'selected');
      jQuery("#sub_businesscategory3 option[value='']").attr('selected', 'selected');
      jQuery("#sub_businesscategory4 option[value='']").attr('selected', 'selected');
      var catid = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>database/get_businesssubcategory',
        type: "POST",
        data: "catid=" + catid,
        success: function(data) { 
          if(data != ""){
            $("#sub_businesscategory2").html(data);
            $("#div_sub_businesscategory2").show();
          }
        }        
      });
    });

    $("#sub_businesscategory2").on("change",function(){
      $("#div_sub_businesscategory3").hide();
      $("#div_sub_businesscategory4").hide();

      jQuery("#sub_businesscategory3 option[value='']").attr('selected', 'selected');
      jQuery("#sub_businesscategory4 option[value='']").attr('selected', 'selected');
      var catid = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>database/get_businesssubcategory',
        type: "POST",
        data: "catid=" + catid,
        success: function(data) { 
          if(data != ""){
            $("#sub_businesscategory3").html(data);
            $("#div_sub_businesscategory3").show();
          }
        }        
      });
    });

    $("#sub_businesscategory3").on("change",function(){
      $("#div_sub_businesscategory4").hide();
      jQuery("#sub_businesscategory4 option[value='']").attr('selected', 'selected');
      var catid = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>database/get_businesssubcategory',
        type: "POST",
        data: "catid=" + catid,
        success: function(data) { 
          if(data != ""){
            $("#sub_businesscategory4").html(data);
            $("#div_sub_businesscategory4").show();
          }
        }        
      });
    });



    
  });
</script>
