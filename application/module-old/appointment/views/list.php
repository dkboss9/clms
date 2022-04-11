

  
  <!-- start: page -->
  <section class="panel">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle></a>
        <a href="#" class="" data-panel-dismiss></a>
      </div>

      <h2 class="panel-title">Appointments</h2>
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

        </div>
      </div>
    </div>
    <table class="table table-bordered table-striped mb-none" id="datatable-default">
      <thead>
        <tr>
          <th><input type="checkbox" name="all" id="checkall" ></th>
          <th>Project </th>
          <th>Mobile</th>

          <th>Appointment date</th>
          <th>Appointment time</th>
          <th>Email</th>
          <th>Country</th>
          <th>Lead By</th>
          <th>Status History</th>
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

          <td><?php echo date("d/m/Y",strtotime($lead->booking_date));?></td>
          <td><?php echo $lead->booking_time;?></td>
          <td><?php echo $lead->email;?></td>
          <td><?php echo $lead->country;?></td>
          <?php 
          $handler = $this->appointmentmodel->getusers($lead->handle);
          ?>
          <td><?php echo @$handler->user_name;?></td>
          <td>
            <?php 
            $updates = $this->appointmentmodel->get_updates($lead->lead_id);
            if(count($updates)>0){
              ?>
              <a class="simple-ajax-popup-reminder btn-default"   href="<?php echo base_url("appointment/detail/".$lead->lead_id);?>"><img src="<?php echo base_url()."assets/images/history.png";?>"></a>
              <?php }else{ ?>
              <a class="simple-ajax-popup-reminder btn-default"   href="<?php echo base_url("appointment/detail/".$lead->lead_id);?>">N/A</a>
              <?php   }?>
            </td>

            <td class="actions">
              <?php 
              echo anchor('appointment/edit/'.$lead->lead_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;';
              if($this->session->userdata("clms_front_user_group") == 1)
                echo anchor('appointment/delete/'.$lead->lead_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
              <?php if($this->session->userdata("clms_front_user_group") == 1){ ?>
              <a href="<?php echo base_url("lms/send_email/".$lead->lead_id);?>" class="mail"><i class="fa fa-mail-forward"></i></a>
              <?php } ?>
              <a href="<?php echo base_url("student/add/".$lead->lead_id);?>">  <i class="fa fa-user-md"></i></a>
              <?php if($lead->consultant > 0){ ?>
              <a href="<?php echo base_url("appointment/counselling/".$lead->lead_id);?>"><i class="fa fa-book" aria-hidden="true"></i></a>
              <?php } ?>
              <a class="simple-ajax-popup-reminder btn-default"   href="<?php echo base_url("appointment/add_consultant/".$lead->lead_id);?>"> <i class="fa fa-user-plus"></i></a>
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
    $('.fa-mail-forward').tooltip({'placement': 'bottom','title':'Email'});
    $(".fa-user-md").tooltip({'placement': 'bottom','title':'Add Client'});
    $(".fa-book").tooltip({'placement': 'bottom','title':'Add counselling'});
    $(".fa-user-plus").tooltip({'placement': 'bottom','title':'Add consultant'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>appointment/add");})
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
        url    : "<?php echo base_url(); ?>appointment/status_update",
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
        url    : "<?php echo base_url(); ?>appointment/lead_doc",
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
          url:"<?php echo base_url(); ?>index.php/appointment/cascadeAction",
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

