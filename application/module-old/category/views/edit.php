<div class="container">
  <div class="row">
    <div class="col-md-2 visible-lg">
      <div class="affix">
        <?php echo $this->mylibrary->getsublinks(46);?>
      </div>
    </div>
    <div class="col-md-10">
      <?php createBreadcrumb($this->uri->segment(1), $this->uri->segment(2))?>
      <div>
        <div class="clearBoth"></div>
        <div style="margin-top:10px;">
          <div class="col-md-12" >
            <?php $formAttribute = array('id' => 'editdepartment');
             echo form_open('category/edit',$formAttribute) ?>
            <div style="min-height: 70px;">
              <div class="page-header" data-spy="affix" data-offset-top="52" id="fix-page-header">
                <div>
                  <button class="btn btn-danger pull-right" type="button" onclick="window.location.assign('<?php echo base_url();?>index.php/category/listall');"> <span class="glyphicon glyphicon-floppy-remove"></span> Cancel </button>
                  <button class="btn btn-primary pull-right" style="margin-right:10px;" value="submit" name="submit" type="submit" id="submitAddressBook"> <span class="glyphicon glyphicon-floppy-disk"></span> Update</button>
                  <h2>Edit Category</h2>
                </div>
              </div>
            </div>
            <input type="hidden" name="id" id="id" value="<?php echo $result->category_id; ?>" />
            <div class="col-md-6">
              <table cellspacing="0" cellpadding="5" border="0" width="100%">
                <tr>
                  <td width="30%"><label for="department_name">Parent Category</label></td>
                  <td><select name="parent_category" class="form-control">
                      <option value="0">Self Parent</option>
                      <?php echo $this->categorymodel->listParentCategory($result->parent_id);?>
                    </select></td>
                </tr>
                <tr>
                  <td width="30%"><label>Category Name </label></td>
                  <td><input type="text" name="category_name" id="category_name" value="<?php echo $result->category_name; ?>" class="form-control input-sm" required /></td>
                </tr>
                <tr>
                  <td width="30%"  valign="top"><label for="description">Description </label></td>
                  <td><textarea name="description" id="description"class="form-control input-sm"><?php echo $result->category_details; ?></textarea></td>
                </tr>
                <tr>
                  <td><label>Status </label></td>
                  <td><select name="status" class="form-control input-sm" >
                      <option value="1" <?php if($result->cat_status === '1'){ echo 'selected';} ?>>Active</option>
                      <option value="0" <?php if($result->cat_status === '0'){ echo 'selected';} ?>>Inactive</option>
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
