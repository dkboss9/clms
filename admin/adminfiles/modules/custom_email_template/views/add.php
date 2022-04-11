
<script type="text/javascript">

window.onload = function(){
  CKEDITOR.replace('email_details');
};
</script>


<!-- start: page -->
<div class="row">
<div class="col-lg-12">
  <section class="panel">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle></a>
        <a href="#" class="" data-panel-dismiss></a>
      </div>
      <h2 class="panel-title">Email Template : [Add]</h2>
    </header>
    <div class="panel-body">
      <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("custom_email_template/add");?>" method="post" enctype='multipart/form-data'>
        <?php if(isset($error)){ ?>
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

          <?php echo $error; ?>
        </div>
        <?php  } ?>

        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Subject</label>
          <div class="col-md-6">
            <input type="text" name="title" value="<?php echo set_value('title'); ?>"  class="form-control" id="inputDefault" required>
            
          </div>
          <label class="col-md-3 control-label" for="inputDefault" style="color:red;"><?php echo form_error("title");?></label>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Description</label>
          <div class="col-md-6">
           <textarea name="description" id="description" class="form-control"><?php echo set_value('description'); ?></textarea>

         </div>
         <label class="col-md-3 control-label" for="inputDefault"><?php echo form_error("description");?></label>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Message</label>
        <div class="col-md-6">
         <textarea name="email_details" id="email_details" class="form-control"><?php echo set_value('email_details'); ?></textarea>
       </div>
       <label class="col-md-3 control-label" for="inputDefault" style="color:red;"><?php echo form_error("email_details");?></label>
     </div>


     <?php if($this->mylibrary->getSiteEmail(54) == 1) {?>
     <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">SMS enabled</label>
      <div class="col-md-9">
       <input type="checkbox" name="sms" id="sms" value="1" <?php //if($news['sms'] == '1') echo 'checked="checked"';?>>
     </div>
   </div>

   <div class="form-group"  <?php echo 'style="display:none;"'; ?> id="tr_sms">
    <label class="col-md-3 control-label" for="inputDefault">SMS Text *</label>
    <div class="col-md-9">
     <textarea name="sms_text" id="sms_text" class="form-control"><?php echo set_value('sms_text'); ?></textarea>
   </div>
 </div>

 <?php } ?>


 <div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
   <input type="hidden" name="email_id" value="<?php //echo $news['emailid'];?>" />
   <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
   <a href="<?php echo base_url("custom_email_template");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
  $("#sms").click(function(){
    if($(this).prop("checked"))
      $("#tr_sms").show();
    else
      $("#tr_sms").hide();
  });
});
</script>