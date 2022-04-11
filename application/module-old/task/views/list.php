<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>


  <!-- start: page -->
  <section class="panel">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle></a>
        <a href="#" class="" data-panel-dismiss></a>
      </div>

      <h2 class="panel-title">Task List</h2>
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
                <li><a onclick="cascade('publish');">Mark as Published
</a></li>
                <li><a onclick="cascade('unpublish');">Mark as Unpublished
</a></li>
              </ul>
            </div>
          </h2>
          
        </div>
      </div>
      <div class="col-lg-12">
        <section class="panel">

          <div class="panel-body">
            <form class="form-inline" method="get" action="<?php echo current_url();?>">
            
              <div class="form-group">
                <select name="reps" class="form-control">
                  <option value="">Sale reps</option>
                  <?php 
                  foreach ($users as $user ) {
                    ?>
                    <option <?php if($search_reps == $user->id) echo 'selected="selected"'; ?> value="<?php echo $user->id;?>"><?php echo $user->first_name." ".$user->last_name;?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <select name="status" class="form-control">
                  <option value="">Status</option>
                  <?php 
                  foreach ($status as $row) {
                   ?>
                   <option <?php if($search_status == $row->status_id) echo 'selected="selected"'; ?> value="<?php echo $row->status_id;?>"><?php echo $row->status_name;?></option>
                   <?php
                 }
                 ?>
               </select>
             </div>
             <div class="form-group">
              <select name="priority" class="form-control">
                <option value="">Priority</option>
                <option <?php if($search_priority == 'Normal') echo 'selected="selected"'; ?> value="Normal">Normal</option>
                <option <?php if($search_priority == 'High') echo 'selected="selected"'; ?> value="High">High</option>
                <option <?php if($search_priority == 'Urgent') echo 'selected="selected"'; ?> value="Urgent">Urgent</option>
              </select>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </span>
                <input type="text"  placeholder="Start Date" name="start_date" value="<?php echo $search_start_date;?>" class="form-control datepicker" autocomplete="off">
              </div>

            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </span>
                <input type="text"   placeholder="End Date" name="end_date" value="<?php echo $search_end_date;?>" class="form-control datepicker" autocomplete="off">
              </div>
            </div>

            <div class="form-group">
            <button type="submit" class="btn btn-primary">Search</button>
            </div>
        
          </form>
        </div>
      </section>
    </div>
  </div>

  <table class="table table-bordered table-striped mb-none" id="datatable-default">
    <thead>
      <tr>
        <th><input type="checkbox" name="all" id="checkall" ></th>
        <th>Task Title</th>
        <th>Assign To</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Added By</th>
        <th>Priority</th>
        <th>Status</th>
        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach ($tasks->result() as $task) {
       $publish = ($task->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
       ?>
       <tr class="gradeX">
         <td><input type="checkbox" class="checkone" value="<?php echo $task->task_id; ?>" /></td>
         <td>
           <a class="simple-ajax-popup123 btn-default" class="todo-label" for="todoListItem<?php echo $task->task_id;?>" href="<?php echo base_url("task/task_detail/".$task->task_id);?>">
             <?php echo $task->tasktitle;?></td>
           </a>
          
           <td>
             <?php echo $task->first_name.' '.$task->last_name; ?>
          </td>
          <td><?php echo date("d/m/Y",$task->start_date);?></td>
          <td><?php echo date("d/m/Y",$task->end_date);?></td>
          <?php 
          $handler = $this->taskmodel->getusers($task->added_by);
          ?>
          <td><?php echo $handler->first_name.' '.$handler->last_name;?></td>
          <td><?php echo $task->priority;?></td>
          <td><?php echo $task->status_name;?></td>
          <td class="actions">

            <?php echo anchor('task/edit/'.$task->task_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;';
            if($this->session->userdata("clms_front_user_group") == 1)
              echo anchor('task/delete/'.$task->task_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
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
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>task/add");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
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
          url:"<?php echo base_url(); ?>task/cascadeAction",
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

<script>
  $(document).ready(function(){
    $(".datepicker").datepicker({  format: 'dd-mm-yyyy'});
  });
</script>