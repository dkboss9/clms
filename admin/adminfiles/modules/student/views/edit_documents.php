




<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#trumbowyg').trumbowyg();

  });
</script>


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
<?php if($this->session->flashdata("success_message")){?>
<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
</div>
<?php
}
?>

<?php 
$this->load->view('detail');
?>

<table class="table table-bordered table-striped mb-none" id="datatable-default">
  <thead>
    <tr>
      <th>Document Type</th>
      <th>Document</th>
      <th>Description</th>
      <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
    </tr>
  </thead>
  <tbody>
   <?php
   $documents = $this->studentmodel->getDoccuments($result->id);
   
   foreach ($documents as $docs) {
     ?>
     <tr class="gradeX">
       <td>
        <?php
        foreach ($doc_type as $row) {
         ?>
         <?php if($row->type_id == $docs->doc_type) echo $row->type_name;?>
         <?php
       }
       ?>
     </td>
     <td><a href="<?php echo SITE_URL."uploads/student_documents/".$docs->doc_name; ?>" target="_blank"><?php echo $docs->doc_name;?></a></td>
     <td> <?php echo $docs->doc_desc;?></td>
     <td>
       <?php echo anchor('student/edit_documents/'.$docs->id.'/'.$result->id,'<span class="glyphicon glyphicon-edit"></span>',array('class'=>"link_edit"));?>
       <?php echo anchor('student/delete_documents/'.$docs->id.'/'.$result->id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
     </td>

   </tr>
   <?php
 }
 ?>

</tbody>
</table>

<!-- start: page -->
<div class="row" id="div_task" >
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Client : Documents : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form_discussion" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>

         <div class="form-group">
           <label class="col-md-3 control-label" for="discussion_title">Document Type </label>
           <div class="col-md-6">
            <select name="doc_type" class="form-control">
              <option value="">Select</option>
              <?php
              foreach ($doc_type as $row) {
               ?>
               <option value="<?php echo $row->type_id;?>" <?php if($docs_detail->doc_type == $row->type_id) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
               <?php
             }
             ?>
           </select>
         </div>
       </div>

       <div class="form-group">
         <label class="col-md-3 control-label" for="discussion_description"> File</label>
         <div class="col-md-6">
           <input type="file" name="document" class="form-control" />
           <a href="<?php echo SITE_URL."uploads/student_documents/".$docs_detail->doc_name; ?>" target="_blank"><?php echo $docs_detail->doc_name;?></a>
         </div>
       </div>

       <div class="form-group">
         <label class="col-md-3 control-label" for="discussion_description"> Descriptions</label>
         <div class="col-md-6">
           <textarea name="description" class="form-control"><?php echo $docs_detail->doc_desc;?></textarea>
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