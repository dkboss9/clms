
<div id="custom-content" class="white-popup-block white-popup-block-md" >


  <form method="post"  action="<?php echo current_url();?>">

    <div class="row">
      <div class="col-sm-12">
        <h3>Send Email</h3>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Subject</label>

    </div>

    <div class="form-group">
      <div class="col-md-12">
        <input type="text" name="subject" value="<?php echo $subject;?>" class="form-control" required>

      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Description</label>

    </div>

    <div class="form-group">
      <div class="col-sm-12">
        <textarea name="details123" id="details123" class="form-control required" rows="6" ><?php echo $email;?></textarea>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault"><input type="checkbox" name="chk_sms" id="chk_sms"> Send Sms</label>
    </div>


    <div class="form-group div_sms" style="display: none;">
      <div class="col-sm-12">
        <textarea name="sms" id="sms" class="form-control " rows="6" ><?php echo $sms;?></textarea>
      </div>
    </div>
    <div class="row mb-lg">
      <div class="col-sm-9 col-sm-offset-3">
        <input type="submit" value="Send" name="submit" class="btn btn-primary">
        <button type="reset" class="btn btn-default">Reset</button>
      </div>
    </div>

  </form>

</div>

<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>

