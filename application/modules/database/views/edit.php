



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Database : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("database/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Name</label>
            <div class="col-md-6">
              <input type="text" name="name" value="<?php echo $result->database_name;?>"  class="form-control" id="inputDefault" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Address</label>
            <div class="col-md-6">
              <input type="text" name="address" value="<?php echo $result->address;?>"  class="form-control" id="inputDefault">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Phone</label>
            <div class="col-md-6">
              <input type="text" name="phone" value="<?php echo $result->phone;?>"  class="form-control" id="phone">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Email Address</label>
            <div class="col-md-6">
              <input type="email" name="email" value="<?php echo $result->email;?>"  class="form-control" id="email">
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Notes</label>
            <div class="col-md-9">
              <?php
              foreach ($notes as $note ) {
               ?>
               <p><?php echo $note->details;?></p>
               <?php
               $users = $this->databasemodel->getuser($note->added_by)->row();
              // echo $this->db->last_query();
              // print_r($users);
               ?>
               <p>Added By: <?php echo $users->first_name.' '.$users->last_name;?> at <?php echo date("d M, Y",$note->added_date);?> </p>
               <hr>
               <?php
             }
             ?>
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
            <select name="category" id="category" class="form-control mb-md" >
              <option value="">Select</option>
              <?php 
              foreach ($category as $cat) {
                ?>
                <option <?php if($result->category == $cat->cat_id) echo 'selected="selected"';?> value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
                <?php 
              }
              ?>
            </select>
          </div>
        </div>

        <?php
        $subs = $this->lmsmodel->get_category($result->category);
        if(count($subs) > 0 && $result->category > 0)
          $display = '';
        else
          $display = 'style="display:none;"';
        ?>
        <div class="form-group" id="div_sub_category" <?php echo $display;?>>
          <label class="col-md-3 control-label" for="inputDefault">Sub Category</label>
          <div class="col-md-6">
           <select name="sub_category" id="sub_category" class="form-control mb-md" >
            <option value="">Select</option>
            <?php 

            foreach ($subs as $sub) {
             ?>
             <option <?php if($result->subcategory == $sub->cat_id) echo 'selected="selected"';?> value="<?php echo $sub->cat_id;?>"><?php echo $sub->cat_name;?></option>
             <?php 
           }
           ?>
         </select>
       </div>
     </div>
     <?php
     $subs2 = $this->lmsmodel->get_category($result->subcategory);
     if(count($subs2) > 0 && $result->subcategory > 0)
      $display = '';
    else
      $display = 'style="display:none;"';
    ?>
    <div class="form-group" id="div_sub_category2" <?php echo $display;?>>
      <label class="col-md-3 control-label" for="inputDefault">Sub Category 2nd</label>
      <div class="col-md-6">
        <select name="sub_category2" id="sub_category2" class="form-control mb-md" >
          <option value="">Select</option>
          <?php 

          foreach ($subs2 as $sub2) {
           ?>
           <option <?php if($result->subcategory2 == $sub2->cat_id) echo 'selected="selected"';?> value="<?php echo $sub2->cat_id;?>"><?php echo $sub2->cat_name;?></option>
           <?php 
         }
         ?>
       </select>
     </div>
   </div>

   <?php
   $subs3 = $this->lmsmodel->get_category($result->subcategory2);
   if(count($subs3) > 0 && $result->subcategory2 > 0)
    $display = '';
  else
    $display = 'style="display:none;"';
  ?>
  <div class="form-group" id="div_sub_category3" <?php echo $display;?>>
    <label class="col-md-3 control-label" for="inputDefault">Sub Category 3rd</label>
    <div class="col-md-6">
      <select name="sub_category3" id="sub_category3" class="form-control mb-md" >
        <option value="">Select</option>
        <?php 

        foreach ($subs3 as $sub3) {
         ?>
         <option <?php if($result->subcategory3 == $sub3->cat_id) echo 'selected="selected"';?> value="<?php echo $sub3->cat_id;?>"><?php echo $sub3->cat_name;?></option>
         <?php 
       }
       ?>
     </select>
   </div>
 </div>

 <?php
 $subs4 = $this->lmsmodel->get_category($result->subcategory3);
 if(count($subs4) > 0 && $result->subcategory3 > 0)
  $display = '';
else
  $display = 'style="display:none;"';
?>
<div class="form-group" id="div_sub_category4" <?php echo $display;?>>
  <label class="col-md-3 control-label" for="inputDefault">Sub Category 4th</label>
  <div class="col-md-6">
    <select name="sub_category4" id="sub_category4" class="form-control mb-md" >
      <option value="">Select</option>
      <?php 

      foreach ($subs4 as $sub4) {
       ?>
       <option <?php if($result->subcategory4 == $sub4->cat_id) echo 'selected="selected"';?> value="<?php echo $sub4->cat_id;?>"><?php echo $sub4->cat_name;?></option>
       <?php 
     }
     ?>
   </select>
 </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault">Business Category</label>
  <div class="col-md-6">
    <select name="businesscategory" id="businesscategory" class="form-control mb-md" >
      <option value="">Select</option>
      <?php 
      foreach ($business_category as $cat) {
        ?>
        <option <?php if($result->businesscategory == $cat->cat_id) echo 'selected="selected"';?> value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
        <?php 
      }
      ?>
    </select>
  </div>
</div>

<?php
$subs = $this->databasemodel->get_businesscategory($result->businesscategory);
if(count($subs) > 0 && $result->businesscategory > 0)
  $display = '';
else
  $display = 'style="display:none;"';
?>
<div class="form-group" id="div_sub_businesscategory" <?php echo $display;?>>
  <label class="col-md-3 control-label" for="inputDefault">Sub Category</label>
  <div class="col-md-6">
   <select name="sub_businesscategory" id="sub_businesscategory" class="form-control mb-md" >
    <option value="">Select</option>
    <?php 

    foreach ($subs as $sub) {
     ?>
     <option <?php if($result->businesssubcategory == $sub->cat_id) echo 'selected="selected"';?> value="<?php echo $sub->cat_id;?>"><?php echo $sub->cat_name;?></option>
     <?php 
   }
   ?>
 </select>
</div>
</div>
<?php
$subs2 = $this->databasemodel->get_businesscategory($result->businesssubcategory);
if(count($subs2) > 0 && $result->businesssubcategory > 0)
  $display = '';
else
  $display = 'style="display:none;"';
?>
<div class="form-group" id="div_sub_businesscategory2" <?php echo $display;?>>
  <label class="col-md-3 control-label" for="inputDefault">Sub Category 2nd</label>
  <div class="col-md-6">
    <select name="sub_businesscategory2" id="sub_businesscategory2" class="form-control mb-md" >
      <option value="">Select</option>
      <?php 

      foreach ($subs2 as $sub2) {
       ?>
       <option <?php if($result->businesssubcategory2 == $sub2->cat_id) echo 'selected="selected"';?> value="<?php echo $sub2->cat_id;?>"><?php echo $sub2->cat_name;?></option>
       <?php 
     }
     ?>
   </select>
 </div>
</div>

<?php
$subs3 = $this->databasemodel->get_businesscategory($result->businesssubcategory2);
if(count($subs3) > 0 && $result->businesssubcategory2 > 0)
  $display = '';
else
  $display = 'style="display:none;"';
?>
<div class="form-group" id="div_sub_businesscategory3" <?php echo $display;?>>
  <label class="col-md-3 control-label" for="inputDefault">Sub Category 3rd</label>
  <div class="col-md-6">
    <select name="sub_businesscategory3" id="sub_businesscategory3" class="form-control mb-md" >
      <option value="">Select</option>
      <?php 

      foreach ($subs3 as $sub3) {
       ?>
       <option <?php if($result->businesssubcategory3 == $sub3->cat_id) echo 'selected="selected"';?> value="<?php echo $sub3->cat_id;?>"><?php echo $sub3->cat_name;?></option>
       <?php 
     }
     ?>
   </select>
 </div>
</div>

<?php
$subs4 = $this->databasemodel->get_businesscategory($result->businesssubcategory3);
if(count($subs4) > 0 && $result->businesssubcategory3 > 0)
  $display = '';
else
  $display = 'style="display:none;"';
?>
<div class="form-group" id="div_sub_businesscategory4" <?php echo $display;?>>
  <label class="col-md-3 control-label" for="inputDefault">Sub Category 4th</label>
  <div class="col-md-6">
    <select name="sub_businesscategory4" id="sub_businesscategory4" class="form-control mb-md" >
      <option value="">Select</option>
      <?php 

      foreach ($subs4 as $sub4) {
       ?>
       <option <?php if($result->businesssubcategory4 == $sub4->cat_id) echo 'selected="selected"';?> value="<?php echo $sub4->cat_id;?>"><?php echo $sub4->cat_name;?></option>
       <?php 
     }
     ?>
   </select>
 </div>
</div>

<div class="form-group" >
  <label class="col-md-3 control-label" for="inputDefault">Access</label>
  <div class="col-md-6">
    <select name="access" id="access" class="form-control mb-md" >
      <option <?php if($result->db_access == "Private") echo 'selected="selected"';?> value="Private">Private</option>
      <option <?php if($result->db_access == "Public") echo 'selected="selected"';?> value="Public">Public</option>

    </select>
  </div>
</div> 
<?php
if($result->db_access == "Private")
  $display = 'style="display:none;"';
else
  $display = '';
?>
<div class="form-group" <?php echo $display;?>   id="div_public">
  <label class="col-md-3 control-label" for="inputDefault">Select Users</label>
  <div class="col-md-9">
    <?php 

    $users = $this->databasemodel->listuser();
    foreach ($users->result() as $user) {
      $access = $this->databasemodel->cheackAccess($user->userid,$result->db_id);
      ?>
      <div class="checkbox">
        <label>
          <input type="checkbox" name="users[]" <?php if($access > 0) echo 'checked="checked"';?> value="<?php echo $user->userid;?>">
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
    <input type="hidden" name="db_id" value="<?php echo $result->db_id;?>">
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
