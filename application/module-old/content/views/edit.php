
<script language="javascript">
  $(document).ready(function(){
    $("#editfaq").validate();
  });
  window.onload = function(){
    CKEDITOR.replace('faq_content');
  };
</script>
<div class="container">
  <div class="row">
    <div class="col-md-2 visible-lg">
      <div class="affix">
        <?php echo $this->mylibrary->getsublinks(1);?>
      </div>
    </div>
    <div class="col-md-10">
      <?php createBreadcrumb($this->uri->segment(1), $this->uri->segment(2))?>
      <div>
        <div class="clearBoth"></div>
        <div style="margin-top:10px;">
          <div class="col-md-12" >
            <?php $formAttribute = array('id' => 'editfaq');
            echo form_open_multipart('content/edit',$formAttribute) ?>
            <div style="min-height: 70px;">
              <div class="page-header" data-spy="affix" data-offset-top="52" id="fix-page-header">
                <div>
                  <button class="btn btn-danger pull-right" type="button" onclick="window.location.assign('<?php echo base_url();?>index.php/faq/listall');"> <span class="glyphicon glyphicon-floppy-remove"></span> Cancel </button>
                  <button class="btn btn-primary pull-right" style="margin-right:10px;" value="submit" name="submit" type="submit" id="submitAddressBook"> <span class="glyphicon glyphicon-floppy-disk"></span> Update</button>
                  <h2>Edit Login content</h2>
                </div>
              </div>
            </div>
            <input type="hidden" name="catid" value="<?php echo $slider->id;?>" />
            <div class="col-md-12">
              <table cellspacing="0" cellpadding="5" border="0" width="100%">
                <tr>
                  <td width="10%"><label for="category_id">Title * :</label></td>
                  <td>

                    <input type="text" name="slider_title" class="inputbox" value="<?php echo $slider->title; ?>" />
                  </td>
                </tr>

                <tr>
                  <td width="10%"><label for="faq_title">Content * :</label></td>
                  <td><textarea name="content" required rows="6" cols="60"><?php echo $slider->content;?></textarea></td>
                </tr>
                <td><label>Status </label></td>
                <td><select name="slider_status" class="form-control input-sm" >
                  <option value="1" <?php if($slider->status === '1'){ echo 'selected';} ?>>Active</option>
                  <option value="0" <?php if($slider->status === '0'){ echo 'selected';} ?>>Inactive</option>
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
