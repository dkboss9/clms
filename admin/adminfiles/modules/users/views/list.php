<style type="text/css">
  .modal-footer {
    padding: 15px;
    text-align: right;
    border-top: 1px solid #e5e5e5;
    margin-top: 50px;
  }
</style>
<script type="text/javascript">
  $(document).ready(function(){
 
 
        $(".edit").click(function(){
          var groupid = $(this).attr('id');
          
          var jsonData = {"groupid":groupid,"action":"edit"};
          $.ajax({
            type : "POST",
            url    : "<?php echo base_url(); ?>index.php/users/editgroup",
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
              $('.edit-chk').hide();
              $('.edit-chk-checked').show();
            },
            error:function(){
                    //show some error message
                  }
                });
        });
        $('#editgroup').on('hidden.bs.modal', function (e) {
       //   location.reload();
        }); 

      });
</script>
<?php if($this->session->flashdata("success_message")){?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?>
</div>
<?php
}
?>

  <!-- start: page -->
  <section class="panel">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle></a>
        <a href="#" class="" data-panel-dismiss></a>
      </div>

      <h2 class="panel-title">Group List</h2>
    </header>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-6">
          <div class="mb-md">
            <h2>User Groups <a href data-toggle="modal" title="Add New Group" type="button" class="btn btn-primary" data-target="#adduser"> Add <i class="fa fa-plus"></i></a> </h2>
          </div>
        </div>
      </div>
      <table class="table table-bordered table-striped mb-none" id="datatable-default">
        <thead>
          <tr>
            <th>SN</th>
            <th>Group Name</th>
            <th>Parent</th>
            <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i=1;
         // print_r($groups);die();
          foreach ($groups->result() as $group) {?>
          <tr class="gradeX">
            <td><?php echo $i; ?></td>
            <td><?php echo $group->group_name;?></td>
            <td><?php echo $group->parent;?></td>
            <td class="actions">

              <a href="<?php echo base_url("users/edit_group_perm/". $group->groupid); ?> " title="Set Group Permission"><span class="glyphicon glyphicon-th-large"></span></a>
              <a href="javascript:void(0);" title="Edit Group Details" class="edit" id="<?php echo $group->groupid; ?>"><span class="glyphicon glyphicon-edit"></span></a>
            </td>
          </tr>
          <?php
          $i++;
        } ?>


      </tbody>
    </table>
  </div>
</section>




</section>
</div>


</section>
<div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
  <script type="text/javascript">
    function addPermission(){
      var group = $("#groupname").val();
      var parentid = $("#parent_group").val();
      if($("#all_data").prop("checked"))
          var all_data = 1;
          else
          var all_data = 0;
      var jsonData = {"group":group,"all_data":all_data,"parentid":parentid,"action":"add"}; 
      $.ajax({
        type  : "POST",
        url   : "<?php echo base_url(); ?>index.php/users/addgroup",
        data  : jsonData,
        success : function(msg){
          if(msg=='yes'){
            location.reload();
            $("#success-message").show();
            $("#success-message").html('Group added successfully');
            $("#success-message").delay(4000).slideUp('slow',function(){
              $("#success-message").html('');
            });
            $("#groupname").val('');
            $('.modules').each(function(){
              $(this).prop('checked','');
            });
          }else{
            $("#error-message").show();
            $("#error-message").html(msg);
            $("#error-message").delay(5000).slideUp('slow',function(){
              $("#error-message").html('');
            });
          }
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
}

</script>
<div class="modal-dialog" style="width:550px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title" id="myModalLabel">Add Group</h4>
    </div>
    <form action="javascript:addPermission();" method="post" id="addgrouppopupform">
      <div class="modal-body overflow">
        <div>
          <div class="clearBoth"></div>
          <div style="margin-top: 12px;">
            <div class="col-md-12">
              <div class="error-message" id="error-message"></div>
              <div class="success-message" id="success-message"></div>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><label>Parent Group</label></td>
                  <td>
                    <select name="parent_group" id="parent_group" class="form-control">
                      <option></option>
                      <?php
                       foreach($parents as $parent){
                         ?>
                          <option value="<?php echo $parent->groupid; ?>"><?php echo $parent->group_name; ?></option>
                         <?php
                       }
                        ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label>Name</label></td>
                  <td><input type="text" name="groupname" id="groupname" class="form-control" required/></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><label>Allow all Data</label></td>
                  <td><input type="checkbox" value="1" name="all_data" id="all_data"></td>
                </tr>
              </table>
            </div>
            <div class="clearBoth"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="submit" name="save" value="Save Details" class="btn btn-primary" />
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<!-- /.modal --> 
</div>
<div class="modal fade" id="divloader" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  style="width:100%;height:100%;background:#ccc;opacity: .55;">
  <div class="divloader" style="left: 50%; top: 50%; z-index:1000; width: 30px; height:30px; position: fixed; background:url('<?php echo base_url(); ?>themes/images/loader.gif') no-repeat center center;opacity:1;"></div>
</div>
<div class="modal fade" id="editgroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" > 
  <script type="text/javascript">
    function editPermission(){
      var group     = $("#usergroupname").val();
      var parentid = $('#parent_group_edit').val();
      var group_id  = $("#user_groupid").val();
      if($("#all_data_edit").prop("checked"))
          var all_data = 1;
          else
          var all_data = 0;
      // var jsonData = 
      $.ajax({
        type  : "POST",
        url   : "<?php echo base_url(); ?>index.php/users/editgroup",
        data  : "group="+group+"&all_data="+all_data+"&action=update&group_id="+group_id+"&parentid="+parentid,
        success : function(msg){
          if(msg=='yes'){
           location.reload();
          }
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

}
</script>
<div class="modal-dialog" style="width:550px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">Edit Group</h4>
    </div>
    <form action="javascript:editPermission();" method="post" id="editgrouppopupform">
      <div class="modal-body overflow">
        <div>
          <div class="clearBoth"></div>
          <div style="margin-top: 12px;">
            <div class="col-md-12" id="content">
              <div class="error-message" id="error-message-edit"></div>
              <div class="success-message" id="success-message-edit"></div>
            </div>
            <div class="clearBoth"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="submit" name="save" value="Save Details" class="btn btn-primary" />
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
</div>