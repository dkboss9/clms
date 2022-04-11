
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

        <h2 class="panel-title">Email Template : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("email_template/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Subject</label>
            <div class="col-md-6">
              <input type="text" name="title" value="<?php echo $news['subject'];?>"  class="form-control" id="inputDefault" required>
              
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Description</label>
            <div class="col-md-6">
             <textarea name="description" id="description" class="form-control"><?php  echo $news['email_desc'];?></textarea>

           </div>
         </div>

         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Message</label>
          <div class="col-md-9">
           <textarea name="email_details" id="email_details" class="form-control"><?php  echo $news['details'];?></textarea>

         </div>
       </div>


       <?php if($this->mylibrary->getSiteEmail(54) == 1) {?>
       <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">SMS enabled</label>
        <div class="col-md-9">
         <input type="checkbox" name="sms" id="sms" value="1" <?php if($news['sms'] == '1') echo 'checked="checked"';?>>
       </div>
     </div>

     <div class="form-group"  <?php if($news['sms'] == '0') echo 'style="display:none;"'; ?> id="tr_sms">
      <label class="col-md-3 control-label" for="inputDefault">SMS Text *</label>
      <div class="col-md-9">
       <textarea name="sms_text" id="sms_text" class="form-control"><?php  echo $news['sms_text'];?></textarea>
     </div>
   </div>

   <?php } ?>


   <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault"></label>
    <div class="col-md-6">
     <input type="hidden" name="email_id" value="<?php echo $news['emailid'];?>" />
     <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
     <a href="<?php echo base_url("chat_id");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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