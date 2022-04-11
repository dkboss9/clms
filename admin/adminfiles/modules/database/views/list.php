


  <!-- database: page -->
  <section class="panel">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle></a>
        <a href="#" class="" data-panel-dismiss></a>
      </div>

      <h2 class="panel-title">Database List</h2>
    </header>

    <div class="panel-body">
      <?php if($this->session->flashdata("success_message")){?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
      </div>
      <?php
    }
    ?>
    <div class="row">
      <div class="col-sm-12">
        <div class="mb-md">
          <h2>
            <?php if($this->session->userdata("usergroup")==1 || $this->session->userdata("usergroup")==7){ ?>
            <a href="<?php echo base_url("database/csv");?>" class="btn btn-primary">Export</a>
            <?php } ?>
            <button 
            id="addButton"
            data-toggle="tooltip" usergroup
            title="Add New Record"
            type="button" 
            class="btn btn-primary"> Add <i class="fa fa-plus"></i> </button>

            <!-- Single button -->
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> More <span class="caret"></span> </button>
              <ul class="dropdown-menu" role="menu">
                <li><a onclick="cascade('delete');">Delete Marked</a></li>
                <li><a onclick="cascade('call');">Mark as Called</a></li>
                <li><a onclick="cascade('notcall');">Mark as Not Called</a></li>
                <li><a onclick="cascade('publish');">Mark as Published
</a></li>
                <li><a onclick="cascade('unpublish');">Mark as Unpublished
</a></li>
              </ul>
            </div>
          </h2>
          <?php if($this->session->userdata("usergroup")==1 || $this->session->userdata("usergroup")==7){ ?>
          <form method="post" action="<?php echo base_url() ?>database/importcsv" enctype="multipart/form-data">
            <h2>
              <div class="btn-group">
                <input type="file" name="userfile" class="form-control mb-md" >
              </div>
              <div class="btn-group">
                <input type="submit" name="submit" value="Import" class="btn btn-primary">

              </div>
            </h2>
          </form>
          <?php } ?>
          <form method="get" action="<?php echo base_url() ?>database/listall" enctype="multipart/form-data">

            <div class="btn-group">
              <select name="category" id="category" class="form-control mb-md">
                <option value="">Select Category</option>
                <?php 
                foreach ($category as $cat) {
                  ?>
                  <option <?php if($search_category == $cat->cat_id) echo 'selected="selected"';?> value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
                  <?php 
                }
                ?>
              </select>
            </div>
            <?php
            $subs = $this->lmsmodel->get_category($search_category);
            if(count($subs) > 0 && $search_category > 0)
              $display = '';
            else
              $display = 'style="display:none;"';
            ?>
            <div class="btn-group" id="div_sub_category" <?php echo $display;?>>
              <select name="sub_category" id="sub_category" class="form-control mb-md" >
                <option value="">Select</option>
                <?php 

                foreach ($subs as $sub) {
                 ?>
                 <option <?php if($search_sub_category == $sub->cat_id) echo 'selected="selected"';?> value="<?php echo $sub->cat_id;?>"><?php echo $sub->cat_name;?></option>
                 <?php 
               }
               ?>
             </select>
           </div>

           <?php
           $subs2 = $this->lmsmodel->get_category($search_sub_category);
           if(count($subs2) > 0 && $search_sub_category > 0)
            $display = '';
          else
            $display = 'style="display:none;"';
          ?>
          <div class="btn-group" id="div_sub_category2" <?php echo $display;?>>
            <select name="sub_category2" id="sub_category2" class="form-control mb-md" >
              <option value="">Select</option>
              <?php 

              foreach ($subs2 as $sub2) {
               ?>
               <option <?php if($search_sub_category2 == $sub2->cat_id) echo 'selected="selected"';?> value="<?php echo $sub2->cat_id;?>"><?php echo $sub2->cat_name;?></option>
               <?php 
             }
             ?>
           </select>
         </div>
         <?php
         $subs3 = $this->lmsmodel->get_category($search_sub_category2);
         if(count($subs3) > 0 && $search_sub_category2 > 0)
          $display = '';
        else
          $display = 'style="display:none;"';
        ?>
        <div class="btn-group" id="div_sub_category3" <?php echo $display;?>>
          <select name="sub_category3" id="sub_category3" class="form-control mb-md" >
            <option value="">Select</option>
            <?php 

            foreach ($subs3 as $sub3) {
             ?>
             <option <?php if($search_sub_category3 == $sub3->cat_id) echo 'selected="selected"';?> value="<?php echo $sub3->cat_id;?>"><?php echo $sub3->cat_name;?></option>
             <?php 
           }
           ?>
         </select>
       </div> 
       <!-- business category -->
       <div class="btn-group">
        <select name="businesscategory" id="businesscategory" class="form-control mb-md">
          <option value="">Select Business Category</option>
          <?php 
          foreach ($business_category as $cat) {
            ?>
            <option <?php if($search_businesscategory == $cat->cat_id) echo 'selected="selected"';?> value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
            <?php 
          }
          ?>
        </select>
      </div>
      <?php
      $subs = $this->databasemodel->get_businesscategory($search_businesscategory);
      if(count($subs) > 0 && $search_businesscategory > 0)
        $display = '';
      else
        $display = 'style="display:none;"';
      ?>
      <div class="btn-group" id="div_sub_businesscategory" <?php echo $display;?>>
        <select name="sub_businesscategory" id="sub_businesscategory" class="form-control mb-md" >
          <option value="">Select</option>
          <?php 

          foreach ($subs as $sub) {
           ?>
           <option <?php if($search_sub_businesscategory == $sub->cat_id) echo 'selected="selected"';?> value="<?php echo $sub->cat_id;?>"><?php echo $sub->cat_name;?></option>
           <?php 
         }
         ?>
       </select>
     </div>

     <?php
   //  echo $search_sub_businesscategory2;
     $subs2 = $this->databasemodel->get_businesscategory($search_sub_businesscategory);
     if(count($subs2) > 0 && $search_sub_businesscategory > 0)
      $display = '';
    else
      $display = 'style="display:none;"';
    ?>
    <div class="btn-group" id="div_sub_businesscategory2" <?php echo $display;?>>
      <select name="sub_businesscategory2" id="sub_businesscategory2" class="form-control mb-md" >
        <option value="">Select</option>
        <?php 

        foreach ($subs2 as $sub2) {
         ?>
         <option <?php if($search_sub_businesscategory2 == $sub2->cat_id) echo 'selected="selected"';?> value="<?php echo $sub2->cat_id;?>"><?php echo $sub2->cat_name;?></option>
         <?php 
       }
       ?>
     </select>
   </div>
   <?php
   $subs3 = $this->databasemodel->get_businesscategory($search_sub_businesscategory2);
   if(count($subs3) > 0 && $search_sub_businesscategory2 > 0)
    $display = '';
  else
    $display = 'style="display:none;"';
  ?>
  <div class="btn-group" id="div_sub_businesscategory3" <?php echo $display;?>>
    <select name="sub_businesscategory3" id="sub_businesscategory3" class="form-control mb-md" >
      <option value="">Select</option>
      <?php 

      foreach ($subs3 as $sub3) {
       ?>
       <option <?php if($search_sub_businesscategory3 == $sub3->cat_id) echo 'selected="selected"';?> value="<?php echo $sub3->cat_id;?>"><?php echo $sub3->cat_name;?></option>
       <?php 
     }
     ?>
   </select>
 </div> 
 <div class="btn-group mb-md">
   <input type="submit" name="submit" value="Search" class="btn btn-primary">
 </div>

</form>
</div>
</div>
</div>
<table class="table table-bordered table-striped mb-none" id="datatable-default">
  <thead>
    <tr>
      <th><input type="checkbox" name="all" id="checkall" ></th>
      <th>Name</th>
      <th>Address</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Date</th>
      <th>Added By</th>
      <th>Is called</th>
      <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach ($databases->result() as $database) {
     $publish = ($database->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
     ?>
     <tr class="gradeX">
       <td><input type="checkbox" class="checkone" value="<?php echo $database->db_id; ?>" /></td>
        <td><?php echo $database->database_name;?></td>
       <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("database/detail/".$database->db_id);?>"><?php echo $database->address;?></a></td>
       <td><?php echo $database->phone;?></td>
       <td><?php echo $database->email;?></td>
       <td><?php echo date("d-m-Y",$database->added_date);?></td>
       <td><?php echo $database->first_name." ".$database->last_name;?></td>
       <td> <div id="div_status<?php echo $database->db_id; ?>">
         <?php
         if($database->is_called == 0){
          ?>
          <a href="javascript:void(0);" id="<?php echo $database->db_id; ?>" rel="<?php echo $database->is_called;?>" class="link_status"><img src="<?php echo base_url("assets/images/notdone.png");?>"></a>
          <?php
        }else{
          ?>
          <a href="javascript:void(0);" id="<?php echo $database->db_id; ?>" rel="<?php echo $database->is_called;?>" class="link_status"><img src="<?php echo base_url("assets/images/done.png");?>"></a>
          <?php
        }
        ?>
      </div>
    </td>
    <td class="actions">
     <a href="<?php echo base_url("lms/add/".$database->db_id);?>"> <img src="<?php echo base_url("assets/images/convert.png");?>" width="20" height="20"></a>
     <?php echo anchor('database/edit/'.$database->db_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;';
     if($this->session->userdata("usergroup") == 1)
       echo anchor('database/delete/'.$database->db_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
   </td>
 </tr>
 <?php
} ?>


</tbody>
</table>
</div>
</section>




</section>
</div>


</section>
<script type="text/javascript">
  $(document).ready(function(){
    $(".link_status").click(function(){
      if(!confirm("Are you sure to change status?"))
        return false;
      var id = $(this).attr("id");
      var status = $(this).attr("rel");
      $.ajax({
        url: '<?php echo base_url(); ?>database/change_status',
        type: "POST",
        data: "db_id=" +id+"&status="+status,
        success: function(data) { 
         $("#div_status"+id).html(data);
       }        
     });
    });
    $(document.body).on('click', '.link_status' ,function(){
      var id = $(this).attr("id");
      var status = $(this).attr("rel");
      $.ajax({
        url: '<?php echo base_url(); ?>database/change_status',
        type: "POST",
        data: "db_id=" +id+"&status="+status,
        success: function(data) { 
         $("#div_status"+id).html(data);
       }        
     });
    });
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>database/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
        return false;
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
    //This function is used for making a json data for cascade delete, publish and unpublish and call ajax
    function cascade(action){
      if(confirm('Are you sure to proceed this action?')){
        var ids = checkedCheckboxId();
      if(ids.length == 0){
        alert("Select atleast one data to proceed this action");
        return false;
      }
        var jsonData ={"object":{"ids":ids,"action":action}};
        $.ajax({
          url:"<?php echo base_url(); ?>database/cascadeAction",
          type:"post",
          data:jsonData,
          success: function(msg){
            location.reload();
          }
        });
      }else{
        return false; 
      }
    }

  </script> 