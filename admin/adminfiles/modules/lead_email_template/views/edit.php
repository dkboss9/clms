
<script type="text/javascript">

  window.onload = function(){
   //CKEDITOR.replace('email_details');
  };
</script>

<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
          <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Lead Email Template : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("lead_email_template/edit");?>" method="post" enctype='multipart/form-data'>
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
             <textarea name="details123" id="details123" class="form-control"><?php  echo $news['email_desc'];?></textarea>

           </div>
         </div>

         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Message</label>
          <div class="col-md-9">
           <textarea name="email_details" id="email_details" class="form-control"><?php  echo $news['details'];?></textarea>

         </div>
       </div>

     
       <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Is Active</label>
        <div class="col-md-9">
         <input type="checkbox" name="active" id="active" value="1" <?php if($news['status'] == '1') echo 'checked="checked"';?>>
       </div>
     </div>

     


   <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault"></label>
    <div class="col-md-6">
     <input type="hidden" name="email_id" value="<?php echo $news['emailid'];?>" />
     <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
     <a href="<?php echo base_url("company_email_template");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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

<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/trumbowyg.min.css">
<script src="<?php echo base_url();?>/assets/javascripts/trumbowyg.js"></script>
<script type="text/javascript">


  $(document).ready(function(){
    $('#email_details').trumbowyg();
  });
</script>