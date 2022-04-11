<div class="container">
  <div class="row">
    <div class="col-md-2 visible-lg">
      <div class="affix">
        <?php echo $this->mylibrary->getsublinks(24);?>
      </div>
    </div>
    <div class="col-md-10">
      <?php createBreadcrumb($this->uri->segment(1), $this->uri->segment(2))?>
      <div class="clearBoth"></div>
      <div style="margin-top:10px;">
        <div class="col-md-12" >
          <?php echo form_open('industry/add');?>
            <div style="min-height: 70px;">
              <div class="page-header" data-spy="affix" data-offset-top="52" id="fix-page-header">
                <div>
                  <button class="btn btn-danger pull-right" type="button" onclick="window.location.assign('<?php echo base_url();?>index.php/industry/listall');"> <span class="glyphicon glyphicon-floppy-remove"></span> Cancel </button>
                  <button style="margin-right:10px;" class="btn btn-primary pull-right" value="submit" name="submit" type="submit"> <span class="glyphicon glyphicon-floppy-disk"></span> Save </button>
                  <h2>Add Industry</h2>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <table cellpadding="5" cellspacing="0" border="0" width="100%" class="table-tab">
                <tbody>
                  <tr>
                    <td width="30%"><label for="industry_name">Industry Name </label></td>
                    <td><input type="text" name="industry_name" id="industry_name" value="" class="form-control input-sm" required /></td>
                  </tr>
                </tbody>
              </table>
            </div>
          <?php echo form_close();?>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
<script>
	$(function() {
		$('form').each(function() {
			$(this).find('input').keypress(function(e) {
				// Enter pressed?
				if(e.which == 10 || e.which == 13) {
					this.form.submit();
				}
			});
		});
	});
</script>
