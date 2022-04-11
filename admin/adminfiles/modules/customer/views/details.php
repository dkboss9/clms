

<div id="custom-content" class="white-popup-block white-popup-block-md">

	
<div class="form-group">
	<label class="col-md-3 control-label">Customer Name:</label>
	<div class="col-sm-6">
		<?php echo $customer->first_name;?> 	<?php echo $customer->first_name;?>

	</div>
</div>



<div class="form-group">
	<label class="col-md-3 control-label">Contact Number:</label>
	<div class="col-sm-6">
		<?php echo $customer->mobile;?>

	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label">Email:</label>
	<div class="col-md-6">
		<?php echo $customer->email;?>
	</div>
</div>
<div class="form-group">
	<label class="col-md-3 control-label">Address:</label>
	<div class="col-md-6">
		<?php echo $customer->address;?>
	</div>
</div>


</div>

<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>


