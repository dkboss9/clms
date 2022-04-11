


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
        <?php if($row->config_value!='' || $row->config_valuelogo!='0'){?>
        <div class="form-group">
          <label class="col-md-3 control-label" for="variable_name">Old Logo:</label>
          <div class="col-md-6">
            <img src="<?php echo SITE_URL."uploads/logo/".$row->config_value;?>" />

          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label" for="variable_name">Replace Logo:</label>
          <div class="col-md-6">
            <input type="file" name="new_logo" class="form-control" required  /><strong>[PNG, GIF, JPG]</strong>

          </div>
        </div>


        <?php }else{ ?>
        <div class="form-group">
          <label class="col-md-3 control-label" for="variable_name">Replace Logo:</label>
          <div class="col-md-6">
            <input type="file" name="new_logo" class="form-control" required  /><strong>[PNG, GIF, JPG]</strong>

          </div>
        </div>

        <?php } ?>
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
