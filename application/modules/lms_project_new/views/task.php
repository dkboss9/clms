



<?php 
$this->load->view("tab");
?>
<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#trumbowyg').trumbowyg();

  });
</script>


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
<?php if($this->session->flashdata("success_message")){?>
<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
</div>
<?php
}
?>
<table class="table table-bordered table-striped mb-none" id="datatable-default">
  <thead>
    <tr>
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
       <td>
        <a class="simple-ajax-popup123 btn-default" class="todo-label" for="todoListItem<?php echo $task->task_id;?>" href="<?php echo base_url("task/task_detail/".$task->task_id);?>">
         <?php echo $task->task_name;?>
       </a>
     </td>
     
     <?php 
     $assigned = $this->taskmodel->get_Assignedusers($task->task_id);
     ?>
     <td>
       <?php 
       foreach ($assigned as $ass) {
        echo $ass->first_name.' '.$ass->last_name.'<br>';
      }
      ?>
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
     <a class="simple-ajax-popup btn-default" class="todo-label" for="todoListItem<?php echo $task->task_id;?>" href="<?php echo base_url("lms_project/edit_task/".$task->task_id);?>">
      <span class="glyphicon glyphicon-edit"></span>
    </a>
    <?php 
    if($this->session->userdata("clms_front_user_group") == 1)
      echo anchor('task/delete/'.$task->task_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
  </td>
</tr>
<?php
} ?>


</tbody>
</table>
<button 
id="addButton"
data-toggle="tooltip" 
title="Add New Record"
type="button" 
class="btn btn-primary"> Add <i class="fa fa-plus"></i> </button>
<!-- start: page -->
<div class="row" id="div_task" style="display:none;">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Project : Task : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Task Title</label>
            <div class="col-md-6">
              <input type="text" name="name" value=""  class="form-control" id="inputDefault" required>
            </div>
          </div>


          <div class="form-group">
           <label class="col-md-3 control-label">Task Details</label>
           <div class="col-md-9">
            <textarea name="details" id="trumbowyg"  class="form-control" rows="8" required></textarea>
          </div>
        </div>
        <?php if($this->session->userdata("clms_front_user_group") == 1 || $this->session->userdata("clms_front_user_group") == 7){ ?>
        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Assign To</label>
          <div class="col-md-6">
          <?php /*
            <select class="form-control" name="assign_to" required>
              <option value="">Select</option>
              <?php 
              foreach ($users as $user ) {
                ?>
                <option value="<?php echo $user->userid;?>"><?php echo $user->first_name." ".$user->last_name;?></option>
                <?php
              }
              ?>
            </select> 
            */
            ?>
            <?php 
            foreach ($users as $user ) {
              ?>
              <div style="float:left;margin-right:20px;width:200px;">
                <input type="checkbox" name="assign_to[]" value="<?php echo $user->userid;?>"><?php echo $user->first_name." ".$user->last_name;?>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
        <?php } ?>
        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Status</label>
          <div class="col-md-6">
            <select class="form-control" name="status" required>
              <option value="">Select</option>
              <?php 
              foreach ($status as $row) {
               ?>
               <option value="<?php echo $row->status_id;?>"><?php echo $row->status_name;?></option>
               <?php
             }
             ?>
           </select>
         </div>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Priority</label>
        <div class="col-md-6">
          <select class="form-control" name="priority" required>
            <option value="">Select</option>
            <option value="Normal">Normal</option>
            <option value="High">High</option>
            <option value="Urgent">Urgent</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Start Date</label>
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </span>
            <input type="text" data-plugin-datepicker="" name="start_date" class="form-control">
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">End Date</label>
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </span>
            <input type="text" data-plugin-datepicker="" name="end_date" class="form-control">
          </div>
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault"></label>
        <div class="col-md-6">
          <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
          <a href="<?php echo base_url("task");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
   $("#addButton").click(function(){
    $("#div_task").toggle();
  });
   $(".link_delete").click(function(){
    if(!confirm('Are you sure to delete this Lead?'))
      return false;
  });
 });
</script>