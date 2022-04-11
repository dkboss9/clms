<script language="javascript">
	$(document).ready(function(){
		$("#userform").validate();
	});
	window.onload = function(){
		CKEDITOR.replace('pagedetails');
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
      <div class="clearBoth"></div>
      <div style="margin-top:10px;">
        <div class="col-md-12" > <?php echo form_open('article/edit');?>
          <div style="min-height: 70px;">
            <div class="page-header" data-spy="affix" data-offset-top="52" id="fix-page-header">
              <div>
                <button class="btn btn-danger pull-right" type="button" onclick="window.location.assign('<?php echo base_url();?>index.php/article/');"> <span class="glyphicon glyphicon-floppy-remove"></span> Cancel </button>
                <button style="margin-right:10px;" class="btn btn-primary pull-right" value="submit" name="submit" type="submit"> <span class="glyphicon glyphicon-floppy-disk"></span> Update </button>
                <h2>Edit Page</h2>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <table cellpadding="5" cellspacing="0" border="0" width="100%" class="table-tab">
              <tbody>
                <tr>
                  <td width="12%" valign="top"><label for="description">Parent*</label></td>
                  <td><select name="parent_id" class="form-control input-sm">
                    <option value="0">_Self</option>
                    <?php echo $this->articlemodel->getparent($parent);?>
                  </select></td>
                </tr>
                <tr>
                  <td width="12%"><label for="department_name">Page Name *</label></td>
                  <td><input type="text" name="title" class="form-control" value="<?php echo $title;?>" required />
                    <input type="hidden" name="articleid" value="<?php echo $articleid;?>" /></td>
                  </tr>
                  <tr>
                    <td width="10%"><label for="keywords">Site Title</label></td>
                    <td><input type="text" name="site_title" class="form-control" value="<?php if(isset($site_title)) echo $site_title;?>" /></td>
                  </tr>
                  <tr>
                    <td width="10%"><label for="keywords">Meta Keywords</label></td>
                    <td><input type="text" name="keywords" class="form-control" value="<?php if(isset($keywords)) echo $keywords;?>" /></td>
                  </tr>
                  <tr>
                    <td width="10%" valign="top"><label for="meta_desc">Meta Description</label></td>
                    <td><textarea name="meta_desc" id="meta_desc" class="form-control"><?php if(isset($description)) echo $description;?></textarea></td>
                  </tr>
                  <tr>
                    <td width="10%" valign="top"><label for="category_name">Page Details</label></td>
                    <td><textarea name="pagedetails" id="pagedetails" class="form-control"><?php echo $details;?></textarea></td>
                  </tr>
                  <tr>
                    <td width="10%" valign="top"><label for="description">Position </label></td>
                    <td><select name="position" class="form-control">
                      <option value="1" <?php if($position=='1') echo 'selected="selected"';?>>Navigation</option>
                      <option value="2" <?php if($position=='2') echo 'selected="selected"';?>>Bottom</option>
                      <option value="3" <?php if($position=='3') echo 'selected="selected"';?>>Bottom & Top</option>
                      <option value="4" <?php if($position=='4') echo 'selected="selected"';?>>Top</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td width="10%" valign="top"><label for="description">Page Type * </label></td>
                    <td><select name="page_type" class="form-control">
                      <option value="content" <?php if($type=='content') echo 'selected="selected"';?>>Content</option>
                      <option value="faq" <?php if($type=='faq') echo 'selected="selected"';?>>FAQ</option>
                      <option value="contact" <?php if($type=='contact') echo 'selected="selected"';?>>Contact</option>
                      <option value="feedback" <?php if($type=='feedback') echo 'selected="selected"';?>>Feedback</option>
                      <option value="products" <?php if($type=='products') echo 'selected="selected"';?>>Products</option>
                      <option value="deals" <?php if($type=='deals') echo 'selected="selected"';?>>Hot Deals</option>
                      <option value="quote" <?php if($type=='quote') echo 'selected="selected"';?>>Quote</option>
                      <option value="custom" <?php if($type=='custom') echo 'selected="selected"';?>>Custom Order</option>
                    </select></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <?php echo form_close();?> </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
