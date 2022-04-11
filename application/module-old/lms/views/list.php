

  
  <!-- start: page -->
  <section class="panel">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle></a>
        <a href="#" class="" data-panel-dismiss></a>
      </div>

      <h2 class="panel-title">Lead List</h2>
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
            <button 
            id="addButton"
            data-toggle="tooltip" 
            title="Add New Record"
            type="button" 
            class="btn btn-primary"> Add <i class="fa fa-plus"></i> </button>

            <!-- Single button -->
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> More <span class="caret"></span> </button>
              <ul class="dropdown-menu" role="menu">
                <li><a onclick="cascade('delete');">Delete Marked</a></li>
                <li><a onclick="cascade('publish');">Mark as Published
</a></li>
                <li><a onclick="cascade('unpublish');">Mark as Unpublished
</a></li>
              </ul>
            </div>
          </h2>
          <form method="get" action="<?php echo current_url();?>">
            <h2>
              <div class="btn-group">
                <select class="form-control mb-md" data-plugin-selectTwo  name="handle">
                  <option value="">Lead By</option>
                  <?php
                  foreach ($users as $user) {
                    ?>
                    <option <?php if($search_handle == $user->id) echo 'selected="selected"';?> value="<?php echo $user->id;?>"><?php echo $user->user_name;?></option>
                    <?php
                  }
                  ?>
                </select>

              </div>
              <div class="btn-group">
                <select class="form-control mb-md" data-plugin-selectTwo  name="country">
                  <option value="">Country</option>
                  <?php
                  foreach ($countries as $country) {
                   ?>
                   <option <?php if($search_country == $country->country_name) echo 'selected="selected"';?> value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
                   <?php
                 }
                 ?>
               </select>

             </div>
             <div class="btn-group">
              <select class="form-control mb-md" name="weightage">
                <option value="">Weightage</option>
                <?php 
                foreach ($weightage as $wt) {
                  ?>
                  <option <?php if($search_weightage == $wt->weightage_id) echo 'selected="selected"';?> value="<?php echo $wt->weightage_id;?>"><?php echo $wt->name;?></option>
                  <?php
                }
                ?>
              </select>

            </div>
            <div class="btn-group">
              <select class="form-control mb-md" data-plugin-selectTwo  name="status">
                <option value="">Status</option>
                <?php 
                foreach ($status as $st) {
                  ?>
                  <option <?php if($search_status == $st->status_id) echo 'selected="selected"';?> value="<?php echo $st->status_id;?>"><?php echo $st->status_name;?></option>
                  <?php
                }
                ?>
              </select>

            </div>
            <div class="btn-group">
              <select class="form-control mb-md" data-plugin-selectTwo  name="category">
                <option value="">Category</option>
                <?php 
                foreach ($category as $cat) {
                  ?>
                  <option <?php if($search_category == $cat->cat_id) echo 'selected="selected"';?> value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
                  <?php
                }
                ?>
              </select>

            </div>
            <div class="btn-group">
              <select class="form-control mb-md" data-plugin-selectTwo  name="access">
                <option value="">Access</option>
                <?php 
                foreach ($access as $acc) {
                  ?>
                  <option <?php if($search_access == $acc->access_id) echo 'selected="selected"';?> value="<?php echo $acc->access_id;?>"><?php echo $acc->access_name;?></option>
                  <?php
                }
                ?>
              </select>

            </div>
            <div class="btn-group">
              <select class="form-control mb-md" data-plugin-selectTwo  name="language">
                <option value="">Language</option>
                <?php 
                foreach ($languages as $lang) {
                  ?>
                  <option <?php if($search_language == $lang->language_id) echo 'selected="selected"';?> value="<?php echo $lang->language_id;?>"><?php echo $lang->language_name;?></option>
                  <?php
                }
                ?>
              </select>

            </div>
            <div class="btn-group mb-md">
              <input type="submit" name="search" value="search" class="btn btn-primary">

            </div>
          </h2>
        </form>
      </div>
    </div>
  </div>
  <table class="table table-bordered table-striped mb-none" id="datatable-default">
    <thead>
      <tr>
        <th><input type="checkbox" name="all" id="checkall" ></th>
        <th>Project </th>
        <th>Phone</th>
        <th>Sales Rep</th>
        <th>Reminder</th>
        <th>Added Date</th>
        <th>Status</th>
        <th>Email</th>
        <th>Country</th>
        <th>Lead By</th>
        <th>Status History</th>
        <th>Files</th>
        <th class="sorting_disabled"  aria-label="Actions" >Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php 

      foreach ($leads->result() as $lead) {
       $publish = ($lead->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
       ?>
       <tr class="gradeX">
        <td><input type="checkbox" class="checkone" value="<?php echo $lead->lead_id; ?>" /></td>
        <td><?php echo $lead->lead_name.' '.$lead->lead_lname;?></td>
        <td><?php echo $lead->phone_number;?></td>
        <td><?php echo $lead->first_name!=""? $lead->first_name.' '.$lead->last_name:"N/A";?></td>
        <td><?php echo date("d/m/Y",$lead->reminder_date);?></td>
        <td><?php echo date("d/m/Y",$lead->added_date);?></td>
        <td><?php echo $lead->status_name;?></td>
        <td><?php echo $lead->email;?></td>
        <td><?php echo $lead->country;?></td>
        <?php 
        $handler = $this->lmsmodel->getusers($lead->handle);
        ?>
        <td><?php echo @$handler->user_name;?></td>
        <td>
          <?php 
          $updates = $this->lmsmodel->get_updates($lead->lead_id);
          if(count($updates)>0){
            ?>
            <a class="simple-ajax-popup-reminder btn-default"   href="<?php echo base_url("lms/detail/".$lead->lead_id);?>"><img src="<?php echo base_url()."assets/images/history.png";?>"></a>
            <?php }else{ ?>
            <a class="simple-ajax-popup-reminder btn-default"   href="<?php echo base_url("lms/detail/".$lead->lead_id);?>">N/A</a>
            <?php   }?>
          </td>
          <td>
            <?php 
            $docs = $this->lmsmodel->get_documents($lead->lead_id);
            if(count($docs)>0){
              ?>
              <a class="doc_link" id="<?php echo $lead->lead_id;?>"><img src="<?php echo base_url()."assets/images/file.png";?>"></a>
              <?php }else{
                echo 'N/A';
              }?>
            </td>
            <td class="actions">
              <a href="<?php echo base_url("lms/project/".$lead->lead_id);?>"> <img src="<?php echo base_url("assets/images/convert.png");?>" width="20" height="20"></a>
              <?php 
              echo anchor('lms/edit/'.$lead->lead_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;';
              if($this->session->userdata("clms_front_user_group") == 1)
                echo anchor('lms/delete/'.$lead->lead_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
              <?php if($this->session->userdata("clms_front_user_group") == 1){ ?>
              <a href="<?php echo base_url("lms/send_email/".$lead->lead_id);?>" class="mail"><img src="<?php echo base_url("assets/images/mail.png");?>" width="16"></a>
              <?php } ?>
              <a href="<?php echo base_url("student/add/".$lead->lead_id);?>">  <i class="glyphicon glyphicon-user" aria-hidden="true" data-original-title="" title=""></i></a>
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
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>lms/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
        return false;
    });
    $(".mail").click(function(){
      if(!confirm('Are you sure to send Email?'))
        return false;
    });
    $(".update_link").click(function(){ 
      $("#content").html("");
      var leadid = $(this).attr('id'); 
      var jsonData = {"leadid":leadid,"action":"edit"};
      $.ajax({
        type : "POST",
        url    : "<?php echo base_url(); ?>lms/status_update",
        data   : jsonData,
        success:function(msg){
          $("#content").html(msg);
          $("#editgroup").modal('show');
        },
        beforeSend:function(){
          $("#divloader").modal('show');
        },
        complete:function(){
          $("#divloader").modal('hide');
        },
        error:function(){
          //show some error message
        }
      });

    });
    $(".doc_link").click(function(){ 
      $("#content").html("");
      var leadid = $(this).attr('id'); 
      var jsonData = {"leadid":leadid,"action":"edit"};
      $.ajax({
        type : "POST",
        url    : "<?php echo base_url(); ?>lms/lead_doc",
        data   : jsonData,
        success:function(msg){
          $("#content").html(msg);
          $("#editgroup").modal('show');
        },
        beforeSend:function(){
          $("#divloader").modal('show');
        },
        complete:function(){
          $("#divloader").modal('hide');
        },
        error:function(){
          //show some error message
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
          url:"<?php echo base_url(); ?>index.php/lms/cascadeAction",
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

  <div class="modal fade" id="editgroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" > 
    <div class="modal-dialog" style="width:550px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Detail:</h4>
        </div>
        <form action="javascript:editPermission();" method="post" id="editgrouppopupform">
          <div class="modal-body overflow">
            <div>
              <div class="clearBoth"></div>
              <div style="margin-top: 12px;">
                <div class="col-md-12" id="content">

                </div>

                <div class="clearBoth"></div>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="border:none;">
           <!-- <input type="submit" name="save" value="Save Details" class="btn btn-primary" /> -->
           <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
       </form>
       <!-- /.modal-content --> 
     </div>
     <!-- /.modal-dialog --> 
   </div>
 </div>

