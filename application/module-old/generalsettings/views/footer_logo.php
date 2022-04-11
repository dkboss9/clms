<script type="text/javascript">
	$(document).ready(function(){
		<?php if($this->session->flashdata('error')!=''){?>
			$(".alert-danger").show();
			$(".alert-danger").html('<?php echo $this->session->flashdata('error');?>');
			$(".alert-danger").delay(4000).slideUp('slow',function(){
				$(".alert-danger").html('');
			});
		<?php } ?>
		<?php if($this->session->flashdata('success')!=''){?>
			$(".alert-success").show();
			$(".alert-success").html('<?php echo $this->session->flashdata('success');?>');
			$(".alert-success").delay(4000).slideUp('slow',function(){
				$(".alert-success").html('');
			});
		<?php } ?>	
	});

</script>
<div class="container">
  <div class="row">
    <div class="col-md-2 visible-lg">
      <div class="affix">
        <?php echo $this->mylibrary->getsublinks(24);?>
      </div>
    </div>
    <div class="col-md-10">
      <?php createBreadcrumb($this->uri->segment(1), $this->uri->segment(2))?>
      <div>
        <div class="clearBoth"></div>
        <div style="margin-top:10px;">
          <div class="col-md-12" >
          <div class="alert alert-danger"></div>
          <div class="alert alert-success"></div>
            <?php $formAttribute = array('id' => 'editrootcompany');
             echo form_open_multipart('generalsettings/edit',$formAttribute) ?>
            <div style="min-height: 70px;">
              <div class="page-header" data-spy="affix" data-offset-top="52" id="fix-page-header">
                <div>
                  <button class="btn btn-danger pull-right" type="button" onclick="window.location.assign('<?php echo base_url();?>index.php/generalsettings');"> <span class="glyphicon glyphicon-floppy-remove"></span> Cancel </button>
                  <button class="btn btn-primary pull-right" style="margin-right:10px;" value="submit" name="submit" type="submit" id="submitAddressBook"> <span class="glyphicon glyphicon-floppy-disk"></span> Update</button>
                  <h2>Upload Logo</h2>
                </div>
              </div>
            </div>
            <input type="hidden" name="config_id" id="config_id" value="<?php echo $row->config_id; ?>" />
            <div class="col-md-7">
              <table cellpadding="5" cellspacing="0" border="0" width="100%" class="table-tab">
                <tbody>
                  <?php if($row->config_value!='' || $row->config_valuelogo!='0'){?>
                  <tr>
                    <td width="30%"><label for="variable_name">Old Logo:</label></td>
                    <td><img src="./uploads/logo_footer/<?php echo $row->config_value;?>" /></td><td>&nbsp;</td>
                  </tr>
                   <tr>
                    <td width="30%"><label for="config_value">Replace Logo:</label></td>
                    <td><input type="file" name="new_logo" required  /><strong>[PNG, GIF, JPG]</strong></td><td><strong> [214 X 50]</strong></td>
                  </tr>
                  <?php }else{ ?>
                   <tr>
                    <td width="30%"><label for="config_value">Add Logo:</label></td>
                    <td><input type="file" name="new_logo" required  /> <strong>[PNG, GIF, JPG]</strong></td><td><strong>[214 X 50]</strong></td>
                  </tr>
                  
                  <?php } ?>
				  
                  
                </tbody>
              </table>
            </div>
            <?php echo form_close() ?> </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
