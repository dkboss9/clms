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
      <th>Discussion Details</th>
      <th>Discussion File</th>
      <th>Added By</th>
      <th>Added Date</th>
      <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
    </tr>
  </thead>
  <tbody>
   <?php
   //$discussions = $this->lms_projectmodel->getdiscussion($result->task_id);
   
   foreach ($comments as $row) {
     ?>
     <tr class="gradeX">
       <td>
         <a class="simple-ajax-popup123 btn-default" class="todo-label" for="todoListItem<?php echo $row->comment_id;?>" href="<?php echo base_url("order/discussion_detail/".$row->comment_id);?>">
           <?php echo $row->comment_description;?>
         </a>
       </td> 
       
       <td>
         <?php if(file_exists("./uploads/comments/".$row->file_name) && $row->file_name != "")?>
         <a href="<?php echo SITE_URL."uploads/comments/".$row->file_name;?>" target="_blank"><?php echo $row->file_name;?></a>
       </td>
       <td><?php echo $row->first_name.' '.$row->last_name;?></td>
       <td><?php echo date("d/m/Y",$row->added_date);?></td>
       <td><?php echo anchor('order/edit_comment/'.$row->comment_id,'<span class="glyphicon glyphicon-edit"></span>',array("class"=>"simple-ajax-popup123 btn btn-default")).' '.anchor('order/delete_comment/'.$row->comment_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?></td>

     </tr>
     <?php
   }
   ?>

 </tbody>
</table>
<button 
id="addButton"
data-toggle="tooltip" 
title="Add New Record"
type="button" 
class="btn btn-primary"> Add Comment<i class="fa fa-plus"></i> </button>
<!-- start: page -->
<div class="row" id="div_task" style="display:none;">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
          <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Order : Comment : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form_discussion" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>



          <div class="form-group">
            <label class="col-md-3 control-label" for="discussion_description">Comment</label>
            <div class="col-md-6">
              <textarea name="discussion_description" id="trumbowyg" class="form-control required"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="discussion_status">File</label>
            <div class="col-md-6">
              <input type="file" name="comment_file" class="form-control">
            </div>

          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"> Date</label>
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </span>
                <input type="text" value="<?php echo date("d/m/Y");?>" data-plugin-datepicker="" name="comment_date" class="form-control">
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
   $("#form_discussion").validate();
   $(".link_delete").click(function(){
    if(!confirm('Are you sure to delete this Record?'))
      return false;
  });
 });
</script>