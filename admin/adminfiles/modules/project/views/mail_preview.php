

<div id="custom-content" class="white-popup-block white-popup-block-md">

<div class="form-group">
    
    <div class="col-md-12">
        <div class="table-responsive">
            <header class="panel-heading">
                <h2 class="panel-title">Mail Preview</h2>
            </header>
        </div>
    </div>
</div>
<hr>

<form method="post" action="<?php echo current_url();?>">
    <div class="form-group">
        <label class="col-md-2 control-label">Subject</label>
        <div class="col-sm-10">
            <input type="text" name="subject" id="subject" class="form-control" value="<?php echo $subject;?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Content</label>
        <div class="col-sm-10">
            <textarea name="details123" id="details123" class="form-control"><?php echo $message;?></textarea>

        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Contact Emails</label>
        <div class="col-sm-10">
        <input type="checkbox" name="useremails[]" value="<?php echo $customer_arr['email']; ?>" checked=""> <?php echo $customer_arr['name']; ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">Other Emails</label>
        <div class="col-sm-10">
            <textarea name="other_email" id="other_email" class="form-control"></textarea>
            Add the valid email address seperated by comma.
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-sm-10">
            <input type="checkbox" name="copy_me" value="1" checked=""> Send copy of email to me. <br />
            <!-- <input type="checkbox" name="chk_pdf" value="1"> Send pdf attachment -->
        </div>
    </div>


    <div class="row mb-lg">
        <div class="col-sm-9 col-sm-offset-2">
            <input type="hidden" name="email_slug" value="<?php echo @$email_slug;?>">
            <input type="hidden" name="tab" value="<?php echo $this->input->get("tab");?>">
            <input type="hidden" value="<?php //echo $leadid;?>" name="lead_id">
            <input type="submit" value="Send" name="submit" class="btn btn-primary">
        </div>
    </div>

</form>

</div>

<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>


