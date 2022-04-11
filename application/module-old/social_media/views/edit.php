



<!-- start: page -->
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
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Tweet : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("social_media/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          

          <div class="form-group">
           <label class="col-md-3 control-label">Content</label>
           <div class="col-md-9">
             <textarea name="details"   class="form-control" rows="8" id="text" required><?php echo $result->content;?></textarea>
             <div  id="counter"></div>
           </div>
         </div>
         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Images</label>
          <div class="col-md-6">
            <?php 
            $docs = $this->social_mediamodel->get_documents($result->id);
            if(count($docs) >0){
              foreach ($docs as $doc) {
                echo '<div id="file_'.$doc->id.'" style="float:left;"><img src="'.SITE_URL.'uploads/media/'.$doc->filename.'" width="100" height="100">&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" rel="'.$doc->id.'" class="link_delete"><span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a>&nbsp;&nbsp;&nbsp; </div>';
              }}else{
                echo "No Image added yet.";
              }
              ?>

            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Add More Images</label>
            <div class="col-md-6" id="div_document">
              <input type="file" name="document1" class="form-control doccuments"> 
            </div>
            <a href="javascript:void(0);" id="add_more">Add</a>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Tweet Time</label>
            <div class="col-md-6" >
              <div class="radio-custom radio-primary">
                <input type="radio" id="now" name="tweet_time" value="1" <?php if($result->tweet_time == 1) echo 'checked="checked"';?>>
                <label for="now">Now</label>
              </div>
              <div class="radio-custom radio-primary">
                <input type="radio" id="schedule" value="2" name="tweet_time" <?php if($result->tweet_time == 2) echo 'checked="checked"';?>>
                <label for="schedule">As Schedule Time</label>
              </div>
              <div class="radio-custom radio-primary">
                <input type="radio" id="draft" value="3" name="tweet_time" <?php if($result->tweet_time == 3) echo 'checked="checked"';?>>
                <label for="draft">Save as Draft</label>
              </div>
            </div>

          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"> Date</label>
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </span>
                <input type="text" data-plugin-datepicker="" name="date" value="<?php echo date("d/m/Y",$result->shedule_date);?>" required class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Time</label>
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-clock-o"></i>
                </span>
                <input type="text" data-plugin-timepicker="" value="<?php echo $result->schedule_time;?>" name="event_time" id="event_time" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }" required>
              </div>
            </div>
          </div>     

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="hidden" name="media_id" value="<?php echo $result->id;?>">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("social_media");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
    var characters= 116;
    $("#counter").html("You have  <strong>"+ parseInt(characters-$("#text").val().length)+"</strong> characters remaining");
    $("#text").keyup(function(){ //alert($(this).val().length);
      if($(this).val().length > characters){
        $(this).val($(this).val().substr(0, characters));
      }
      $("#counter").html("You have  <strong>"+ parseInt(characters-$(this).val().length)+"</strong> characters remaining");
    });
    $("#add_more").click(function(){
      var len = $(".doccuments").length;
      len = len + 1;
      $("#div_document").append('<input type="file" name="document'+len+'" class="form-control doccuments" style="margin-top:10px;">');
    });
    $(".link_delete").click(function(){
      if(!confirm("Are you sure to delete this file?"))
        return false;
      var id = $(this).attr("rel");
      $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>social_media/delete_documents",
        data: "id="+id,
        success: function (msg) {
          $("#file_"+id).remove();
        }
      });
    });
  });
</script>
