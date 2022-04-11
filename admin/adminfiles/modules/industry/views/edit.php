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
            <?php $formAttribute = array('id' => 'editindustry');
             echo form_open('industry/edit',$formAttribute) ?>
            <div style="min-height: 70px;">
              <div class="page-header" data-spy="affix" data-offset-top="52" id="fix-page-header">
                <div>
                  <button class="btn btn-danger pull-right" type="button" onclick="window.location.assign('<?php echo base_url();?>index.php/options/listall');"> <span class="glyphicon glyphicon-floppy-remove"></span> Cancel </button>
                  <button class="btn btn-primary pull-right" style="margin-right:10px;" value="submit" name="submit" type="submit" id="submitAddressBook"> <span class="glyphicon glyphicon-floppy-disk"></span> Update</button>
                  <h2>Edit Industry</h2>
                </div>
              </div>
            </div>
            <input type="hidden" name="id" id="id" value="<?php echo $result->industry_id; ?>" />
            <div class="col-md-6">
              <table cellspacing="0" cellpadding="5" border="0" width="100%">
                <tr>
                    <td width="30%"><label for="industry_name">Industry Name </label></td>
                    <td><input type="text" name="industry_name" id="industry_name" value="<?php echo $result->industry_name;?>" class="form-control input-sm" required /></td>
                </tr>
                <tr>
                  <td><label>Status </label></td>
                  <td><select name="status" class="form-control input-sm" >
                      <option value="1" <?php if($result->status === '1'){ echo 'selected';} ?>>Active</option>
                      <option value="0" <?php if($result->status === '0'){ echo 'selected';} ?>>Inactive</option>
                    </select></td>
                </tr>
              </table>
            </div>
            <?php echo form_close() ?> </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
