<?php
$importData = unserialize($form->forms_template);

?>

<link href="<?php echo base_url();?>assets/themes/css/jquery.pdsformbuilder.css" rel="stylesheet" media="screen" />
<link href="<?php echo base_url();?>assets/themes/css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" media="screen" />
<script src="<?php echo base_url();?>assets/themes/js/extend.objects.js"></script>
<script src="<?php echo base_url();?>assets/themes/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/themes/js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript">
  var base_url = '<?php echo base_url($this->uri->uri_string()); ?>';
  jQuery.noConflict();
  jQuery(function($) {
    $("#formbuilder-sidebar").scrollFollow({
      speed: 500,
      container: 'form-builder'
    });
    var $formbuilder = $("#form-builder").pdsformbuilder({
      paramKey: 'form',
      imagebase: '<?php echo base_url();?>assets/themes/images/form-icons/',
      importData: <?php echo json_encode($importData); ?>
    });

  });
</script>
<style>
  input.input,textarea.textarea{
    width: 100%;
  }
</style>


<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Form : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form action="<?php echo base_url($this->uri->uri_string());?>" method="post">
          <div id="form-builder-holder">
            <div id="form-builder">

              <div id="formbuilder-output">

               Category: <select name="maincat" id="maincat" class="form-control" required>
               <option value="">--Top Category--</option>
               <option value="Lead" <?php if($form->module_name == 'Lead') echo 'selected="selected"';?>>Lead</option>
               <option value="Order" <?php if($form->module_name == 'Order') echo 'selected="selected"';?>>Order</option>
               <option value="Project" <?php if($form->module_name == 'Project') echo 'selected="selected"';?>>Project</option>
             </select>
             <input type="hidden" name="form_id" value="<?php echo $form->forms_id;?>">
             <div id="form-header" class="form-description"></div>
             <div id="form-contents" class="form-body">
              <ul id="form-builder-sortable" title="Click field to edit. Drag to reorder."></ul>
            </div>
            <div id="form-footer"></div>
            <input type="submit" name="submit" value="Save Form" />
          </div>
          <div id="formbuilder-sidebar">
            <div id="builder-tabs">
              <ul id="builder_tabs_btn">
                <li id="btn_add_field"><a href="#form-items">Add a Field</a></li>
                <li id="btn_field_properties"><a href="#form-item-property">Field Properties</a></li>
                <li id="btn_form_properties"><a href="#form-property">Form Properties</a></li>
              </ul>
              <div id="form-items"></div>
              <div id="form-item-property"></div>
              <div id="form-property"></div>
            </div>
          </div>
          <div class="clear"></div>
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
<script src="<?php echo base_url();?>assets/themes/js/jquery.scrollfollow.js"></script>
<script src="<?php echo base_url();?>assets/themes/js/jquery.pdsutils.js"></script>
<script src="<?php echo base_url();?>assets/themes/js/jquery.syncedit.js"></script>
<script src="<?php echo base_url();?>assets/themes/js/jquery.pdsformbuilder.js"></script>