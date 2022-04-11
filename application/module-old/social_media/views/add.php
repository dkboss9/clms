



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
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("social_media/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>
          
          <div class="form-group">
           <label class="col-md-3 control-label">Content</label>
           <div class="col-md-9">
             <textarea name="details"   class="form-control" rows="8" id="text" required></textarea>
             <div  id="counter"></div>
           </div>
         </div>
         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Images</label>
          <div class="col-md-6" id="div_document">
            <input type="file" name="document1" class="form-control doccuments"> 
          </div>
          <a href="javascript:void(0);" id="add_more">Add</a>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Tweet Time</label>
          <div class="col-md-6" >
            <div class="radio-custom radio-primary">
              <input type="radio" id="now" name="tweet_time" value="1" checked="">
              <label for="now">Now</label>
            </div>
            <div class="radio-custom radio-primary">
              <input type="radio" id="schedule" value="2" name="tweet_time">
              <label for="schedule">As Schedule Time</label>
            </div>
            <div class="radio-custom radio-primary">
              <input type="radio" id="draft" value="3" name="tweet_time">
              <label for="draft">Save as Draft</label>
            </div>
          </div>
          
        </div>
        
        <div class="form-group" style="display:none;" id="div_date">
          <label class="col-md-3 control-label"> Date</label>
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </span>
              <input type="text" data-plugin-datepicker="" name="date" value="<?php echo date("d/m/Y");?>" required class="form-control">
            </div>
          </div>
        </div>
        <div class="form-group"  style="display:none;" id="div_time">
          <label class="col-md-3 control-label">Time</label>
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-clock-o"></i>
              </span>
              <input type="text" data-plugin-timepicker="" value="<?php echo date("H:i");?>" name="event_time" id="event_time" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }" required>
            </div>
          </div>
        </div>     

        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault"></label>
          <div class="col-md-6">
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
    $("#counter").append("You have  <strong>"+ characters+"</strong> characters remaining");
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

    $("#schedule").click(function(){
      $("#div_date").show();
      $("#div_time").show();
    });
    $("#draft").click(function(){
      $("#div_date").show();
      $("#div_time").show();
    });
    $("#now").click(function(){
      $("#div_date").hide();
      $("#div_time").hide();
    });

    $("#draft").trigger("click");
  });
</script>
