
<div id="custom-content" class="white-popup-block white-popup-block-md">
	<div class="row">
		<div class="col-md-12">
			<h5>Assign Dashboard Sections</h5>
		</div>
	</div>
	<hr>
	
	<form method="post"  action="<?php echo base_url("users/assign_dashboard");?>">


		<div class="form-group">
			<label class="col-md-3 control-label">Dashboard Sections</label>
			<div class="col-md-6">
				<div class="input-group">

					<?php 
					foreach ($result as $row) {
						$num = $this->usermodel->getAssignedDashboard($userid,$row->id);
						?>
						<div class="checkbox-custom checkbox-primary">
							<input type="checkbox" value="<?php echo $row->id;?>" name="section[]" <?php if($num > 0) echo 'checked="checked"';?> >
							<label for="checkboxExample2"><?php echo $row->section_name; ?></label>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>



		<div class="row mb-lg">
			<div class="col-sm-9 col-sm-offset-3">
				<input type="hidden" value="<?php echo $userid;?>" name="user_id">
				<input type="submit" value="Submit" name="submit" class="btn btn-primary">
				<button type="reset" class="btn btn-default">Reset</button>
			</div>
		</div>

	</form>

	<hr>


</div>


<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>
