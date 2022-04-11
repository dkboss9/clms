
<!-- start: page -->
<section class="panel">
  <header class="panel-heading">
    <div class="panel-actions">
      <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
      <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
    </div>

    <h2 class="panel-title">Refferals List</h2>
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
    <div class="col-sm-6">
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
              <li><a onclick="cascade('publish');">Mark as Publish</a></li>
              <li><a onclick="cascade('unpublish');">Mark as Unpublish</a></li>
            </ul>
          </div>
        </h2>
      </div>
    </div>
  </div>
  <table class="table table-bordered table-striped mb-none" id="datatable-default">
    <thead>
      <tr>
        <th style="width:10%"><input type="checkbox" name="all" id="checkall" ></th>
        <th>Title</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Date</th>
       
        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach ($referals->result() as $row) {
        $publish = ($row->status == 1 ? '<span class="glyphicon glyphicon-ok-sign btn list-btn btn-success" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign btn list-btn btn-success" data-toggle="tooltip" title="Unpublished"></span>');
        ?>
        <tr class="gradeX">
         <td><input type="checkbox" class="checkone" value="<?php echo $row->userid; ?>" /></td>
         <td><a href="<?php echo base_url("referals/dashboard/".$row->userid);?>"><?php echo $row->first_name.' '.$row->last_name;?></a></td>
         <td><?php echo $row->phone;?></td>
         <td><?php echo $row->email;?></td>
         <td><?php echo $row->added_date;?></td>
      
        <td class="actions">
         <?php
         echo $publish.'&nbsp;';
         echo anchor('referals/edit/'.$row->userid,'<span class="glyphicon glyphicon-edit"></span>',array("class"=>"list-btn btn-primary btn"));

         if($row->user_group!='1'){
          echo  ' <a  class="icons deleteIcon" id="'.$row->userid.'"><span class="glyphicon glyphicon-eye">&nbsp;</span></a>';
        }

        if($row->user_group!='1' && $row->user_group!='2'){
          echo ' <a href="'. base_url(""). 'users/perm_modify/'. $row->userid .'"  class="list-btn btn-primary btn"><span class="glyphicon glyphicon-asterisk">&nbsp;</span></a>';
        }
        ?>
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
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>referals/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Announcement?'))
        return false;
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
          url:"<?php echo base_url(); ?>referals/cascadeAction",
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