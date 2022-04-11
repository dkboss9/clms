


<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">General Config Value : [Edit]</h2>
      </header>
      <div class="panel-body">
        <?php $formAttribute = array('id' => 'editrootcompany');
        echo form_open_multipart('generalsettings/edit',$formAttribute) ?>


        <div class="form-group">
          <label class="col-md-3 control-label" for="variable_name">Config Option:</label>
          <div class="col-md-6">
            <input type="text" name="variable_name" id="variable_name"  value="<?php echo $row->config_option; ?>" required readonly  class="form-control" required>
            
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="variable_name">Config Value:</label>
          <div class="col-md-6">
            <?php
            if($row->variable_name == 'auto_activate'){
              ?>
              <input type="checkbox" name="config_value" id="config_value" value="1" <?php if($row->config_value == '1') echo 'checked="checked"';?> />
              <?php
            }else{
              ?>
              <input type="text" name="config_value" id="config_value" class="form-control input-sm" value="<?php echo $row->config_value; ?>" required />
              <?php
            }
            ?>
          </div>
        </div>


        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault"></label>
          <div class="col-md-6">
            <input type="hidden" name="config_id" id="config_id" value="<?php echo $row->config_id; ?>" />
            <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
            <a href="<?php echo base_url("generalsettings");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
