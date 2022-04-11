




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

<table class="table table-bordered table-striped mb-none" id="datatable-default1">
  <thead>
    <tr>
      <th>Qualification</th>
      <th>Institution</th>
      <th>Country</th>
      <th>Year of commencement</th>
      <th>Year of Completion</th>
      <th>Obtained (%)</th>
      <th>document attachment</th>
      <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
    </tr>
  </thead>
  <tbody>
   <?php
   $qualifications = $this->studentmodel->getQualifications($result->id);
   
   foreach ($qualifications as $qual) {
     ?>
     <tr class="gradeX">
       <td>
         <?php echo $qual->qualification_name;?>
       </td>
       <td><?php echo $qual->institution_name;?></td>
       <td><?php echo $qual->country;?></td>
       <td><?php echo $qual->commence_date;?></td>
       <td><?php echo $qual->complete_year;?></td>
       <td><?php echo $qual->percent;?></td>
       <td><?php if($qual->doc_attached == '1') echo 'Yes'; else echo 'No';?></td>
       <td>
         <?php echo anchor('student/edit_qualification/'.$qual->id.'/'.$result->id,'<span class="glyphicon glyphicon-edit"></span>',array('class'=>"link_edit"));?>
         <?php echo anchor('student/delete_qualification/'.$qual->id.'/'.$result->id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
       </td>

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

        <h2 class="panel-title">Client : Qualification : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form_discussion" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>

         <div class="form-group">
           <label class="col-md-3 control-label" for="discussion_title"> Qualification </label>
           <div class="col-md-6">
             <input type="text" name="qualifaction" class="form-control required">
           </div>
         </div>

         <div class="form-group">
           <label class="col-md-3 control-label" for="discussion_title"> Institution </label>
           <div class="col-md-6">
            <input type="text" name="institution" class="form-control required"> 
          </div>
        </div>

        <div class="form-group">
         <label class="col-md-3 control-label" for="discussion_title"> Country </label>
         <div class="col-md-6">
          <input type="text" name="country" class="form-control required"> 
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="discussion_title"> Year of commencement </label>
       <div class="col-md-6">
        <input type="text" name="commence_date" class="form-control required">
      </div>
    </div>

    <div class="form-group">
     <label class="col-md-3 control-label" for="discussion_title"> Year of Completion </label>
     <div class="col-md-6">
      <input type="text" name="complete_date" class="form-control required">
    </div>
  </div>

  <div class="form-group">
     <label class="col-md-3 control-label" for="percent"> Obtained (%) </label>
     <div class="col-md-6">
      <input type="text" name="percent" class="form-control required">
    </div>
  </div>

  <div class="form-group">
   <label class="col-md-3 control-label" for="discussion_title"> Document attachment </label>
   <div class="col-md-6">
     <input type="checkbox" name="is_attached" value="1">
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