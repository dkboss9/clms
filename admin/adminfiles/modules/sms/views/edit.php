 <?php if($this->session->flashdata("success_message")){?>
 <div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
</div>
<?php
}
?>

<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
          <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title"> Sms Credentials : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("sms/listall");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">SMS From</label>
            <div class="col-md-6">
              <input type="text" name="sms_from" value="<?php echo @set_value('sms_from',$result->sms_from);?>"  class="form-control" id="sms_from" maxlength="11" required>
              <label class="error"> <?php echo form_error('sms_from');?></label>
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="checkbox" value="1" name="is_active" <?php if(@$result->is_active == 1) echo 'checked="checked"';?>>
              Enable SMS
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <?php if(isset($result->sms_credit)){ ?>
              <a href="<?php echo base_url("sms/get_sms_credits/".$this->session->userdata("clms_company"));?>" class="mb-xs mt-xs mr-xs btn btn-primary">Buy Credit</a>
              <?php } ?>
              <input type="submit" name="submit" value="Save" class="mb-xs mt-xs mr-xs btn btn-success">

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
