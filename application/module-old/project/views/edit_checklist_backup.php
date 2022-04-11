




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

<?php 
$this->load->view('detail');
?>

<table class="table table-bordered table-striped mb-none" id="datatable-default">
  <thead>
    <tr>
      <th>Check list</th>
      <th>File</th>
      <th>Status</th>
      <th>Received Date</th>
      <th>Received By</th>
      <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
    </tr>
  </thead>
  <tbody>
   <?php
   //print_r($enroll); die();
   $checklists = $this->appointmentmodel->listChecklist($enroll->fee_id);
   
   foreach ($checklists->result() as $row) {
    $enroll_check = $this->projectmodel->checkChecklist($row->type_id,$result->project_id)->row();
    $user = $this->projectmodel->getUserDetail(@$enroll_check->added_by);
    ?>
    <tr class="gradeX">
     <td>
       <?php echo $row->type_name;?>
     </td>

     <td>
      <a href="<?php echo SITE_URL."uploads/student_documents/".@$enroll_check->file_name; ?>" target="_blank"><?php echo @$enroll_check->file_name;?></a>
    </td>

    <td>
      <?php echo @$enroll_check->checklist_status;?>
    </td>

    <td>
      <?php echo @$enroll_check->received_date;?>
    </td>

    <td>
      <?php echo @$user->first_name.' '.@$user->last_name;?>
    </td>

    <td>
      <a class="btn btn-primary" href="<?php echo base_url("project/edit_checklist/".$row->checklist_id.'/'.$result->project_id);?>">Update</a>
    </td>

  </tr>
  <?php
}
?>

</tbody>
</table>

<!-- start: page -->
<div class="row" id="div_task">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Client : Checklist : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form_discussion" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>

         <div class="form-group">
           <label class="col-md-3 control-label" for="discussion_title"> Checklist Status </label>
           <div class="col-md-6">
            <select name="status" class="form-control">
              <option value="Pending" <?php if(@$enroll_checklist->checklist_status == 'Pending') echo 'selected="selected"';?>>Pending</option>
              <option value="In Progress" <?php if(@$enroll_checklist->checklist_status == 'In Progress') echo 'selected="selected"';?>>In Progress</option>
              <option value="Received" <?php if(@$enroll_checklist->checklist_status == 'Received') echo 'selected="selected"';?>>Received</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="discussion_description">Received Date</label>
          <div class="col-md-6">
            <input type="text" data-plugin-datepicker="" name="received_date" value="<?php echo isset($enroll_checklist->received_date)? $enroll_checklist->received_date : date("d/m/Y");?>" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="discussion_description">File Upload</label>
          <div class="col-md-6">
            <input type="file" name="document"  class="form-control">
            <a href="<?php echo SITE_URL."uploads/student_documents/".@$enroll_checklist->file_name; ?>" target="_blank"><?php echo @$enroll_checklist->file_name;?></a>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="discussion_description">Note</label>
          <div class="col-md-6">
            <textarea name="note" id="note" class="form-control" rows="6"><?php echo @$enroll_checklist->note;?></textarea>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault"></label>
          <div class="col-md-6">
            <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
            <a href="<?php echo base_url("dashboard/enroll");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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