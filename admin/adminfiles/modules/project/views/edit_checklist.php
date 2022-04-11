

<div id="custom-content" class="white-popup-block white-popup-block-md">
  <h2 class="panel-title">Client : Checklist : [Edit]</h2>
  <hr>
  <?php
  if(isset($enroll_checklist->id)){
  $notes = $this->projectmodel->getchecklistnote($enroll_checklist->id);

  foreach ($notes as $note) {
    ?>

    <div class="form-group" >

      <label class="col-md-12 " for="payment_method">
        <?php echo $note->note;?>
        <br>
        <span style="font-style:italic;">Added by: <?php echo $note->first_name.' '.$note->last_name;?> at <?php echo date("d-m-Y",strtotime($note->added_date));?></span>
      </label>

    </div>

    <?php } }?>
    <div class="panel-body">
      <form class="form-horizontal form-bordered" id="form_discussion" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>

       <div class="form-group">
         <label class="col-md-3 control-label" for="discussion_title"> Checklist Status </label>
         <div class="col-md-9">
          <select name="status" class="form-control">
            <option value="Pending / Not verified" <?php if(@$enroll_checklist->checklist_status == 'Pending / Not verified') echo 'selected="selected"';?>>Pending / Not verified</option>
            <option value="In Progress" <?php if(@$enroll_checklist->checklist_status == 'In Progress') echo 'selected="selected"';?>>In Progress</option>
            <option value="Received and Verified" <?php if(@$enroll_checklist->checklist_status == 'Received and Verified') echo 'selected="selected"';?>>Received and Verified</option>
            <option value="Cancel" <?php if(@$enroll_checklist->checklist_status == 'Cancel') echo 'selected="selected"';?>>Cancel</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="discussion_description">Received Date</label>
        <div class="col-md-9">
          <input type="text" data-plugin-datepicker="" name="received_date" value="<?php echo isset($enroll_checklist->received_date)? $enroll_checklist->received_date : date("d/m/Y");?>" class="form-control">
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="discussion_description">File Upload</label>
        <div class="col-md-9">
          <input type="file" name="profile_pic" id="profile_pic" class="form-control">    
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="discussion_description"></label>
        <div class="col-md-9">
                <table id="post_img_profile">
                  
                </table>
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label" for="discussion_description">Note</label>
        <div class="col-md-9">
          <textarea name="note" id="note" class="form-control" rows="6"></textarea>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault"></label>
        <div class="col-md-9">
          <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
          <a href="<?php echo base_url("dashboard/enroll");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="<?php echo base_url("admin/assets/javascripts/theme.init.js");?>"></script>

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