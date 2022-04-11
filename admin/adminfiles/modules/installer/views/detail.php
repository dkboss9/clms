

<div id="custom-content" class="white-popup-block white-popup-block-md">
	<div class="form-group">
		<label class="col-md-3 control-label">Contracter Name:</label>
		<div class="col-sm-6">
			<?php echo $installer->first_name.' '.$installer->last_name;?>

		</div>
	</div>


	<div class="form-group">
		<label class="col-md-3 control-label">Email:</label>
		<div class="col-sm-6">
			<?php echo $installer->email;?>

		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label">Phone:</label>
		<div class="col-sm-6">
			<?php echo $installer->phone;?>

		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label">Description:</label>
		<div class="col-sm-6">
			<?php echo $installer->description;?>
		</div>
	</div>


	
</div>

<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>


