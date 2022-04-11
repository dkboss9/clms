
<div id="custom-content" class="white-popup-block white-popup-block-md">

<form class="form-horizontal form-bordered"  action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>

  <div class="row">
    <div class="col-sm-12">
      <h3>Edit Comment</h3>
    </div>
  </div>

  

  <div class="form-group">
    <label class="col-md-3 control-label" for="discussion_description">Comment</label>
    <div class="col-md-6">
      <textarea name="discussion_description" id="details123" class="form-control required"><?php echo $comment->comment_description;?></textarea>
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
        <input type="text" value="<?php echo date("d/m/Y",$comment->added_date);?>" data-plugin-datepicker="" name="comment_date" class="form-control">
      </div>
    </div>
  </div>

  <div class="row mb-lg">
    <div class="col-sm-9 col-sm-offset-3">
      <input type="submit" value="Submit" name="submit" class="btn btn-primary">
      <button type="reset" class="btn btn-default">Reset</button>
    </div>
  </div>

</form>

</div>


