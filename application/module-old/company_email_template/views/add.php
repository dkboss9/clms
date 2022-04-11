<script type="text/javascript">
	$(document).ready(function(){
		$(".alert-danger").hide();
		<?php if($this->session->flashdata('error')){?>
			$(".alert-danger").show();
			$(".alert-danger").html('<?php echo $this->session->flashdata('error');?>');
			$(".alert-danger").delay(4000).slideUp('slow',function(){
				$(".alert-danger").html('');
			});
		<?php } ?>
	});
	window.onload = function(){
		CKEDITOR.replace('newsdetails');
	};
</script>
<div class="container">
  <div class="row">
    <div class="col-md-2 visible-lg">
      <div class="affix">
            <?php echo $this->mylibrary->getsublinks(2);?>
      </div>
    </div>
    <div class="col-md-10 col-md-offset-2">
    <?php createBreadcrumb($this->uri->segment(1), $this->uri->segment(2)) ?>
      <div class="clearBoth"></div>
      <div style="margin-top:10px;">
        <div class="col-md-12" > <?php echo form_open('news/add',array('id'=>'client'));?>
          <div class="alert alert-danger"></div>
          <div style="min-height: 70px;">
            <div class="page-header" data-spy="affix" data-offset-top="52" id="fix-page-header">
              <div class="container">
                <div class="row">
                  <div class="col-md-12" style="width:100%!important;">
                      <button class="btn btn-danger pull-right" type="button" onclick="window.location.assign('<?php echo base_url(); ?>index.php/email_template/');"> <span class="glyphicon glyphicon-floppy-remove"></span> Cancel </button>
                      <button style="margin-right:10px;" class="btn btn-primary pull-right" value="submit" name="submit" type="submit" id="submitAddressBook"> <span class="glyphicon glyphicon-floppy-disk"></span> Save </button>
                      <h2>Add News</h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div>
            <div class="clearBoth"></div>
            <div style="margin-top:10px;"> 
              <div class="col-md-12" >
                <table width="100%" cellspacing="0" cellpadding="2" class="table">
                  <tr>
                    <td><label>News Title*</label></td>
                    <td><input type="text" name="title" id="title" class="form-control" required /></td>
                  </tr>
                  <tr>
                    <td valign="top"><label>Description*</label></td>
                    <td><textarea name="newsdetails" id="newsdetails" class="form-control"></textarea></td>
                  </tr>
                </table>
              </div>
              <div class="clearfix"></div>
              <div style="margin-bottom: 20px;"></div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
