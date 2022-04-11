
<div id="custom-content" class="white-popup-block white-popup-block-md">
	<div class="row">
		<div class="col-md-12">
			<h5>Assign Company</h5>
		</div>
	</div>
	<hr>
	<form id="form" method="post" action="<?php echo base_url("employee/add");?>" enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
		
	</form>
	<form method="post"  action="<?php echo base_url("users/assign_company");?>">


		<div class="form-group">
			<label class="col-md-3 control-label">Add Employee</label>
			<div class="col-md-6">
				<div class="input-group">

					<?php 
					foreach ($result as $row) {
						$num = $this->usermodel->getAssignedCompany($userid,$row->userid);
						?>
						<div class="checkbox-custom checkbox-primary">
							<input type="checkbox" value="<?php echo $row->userid;?>" name="company[]" <?php if($num > 0) echo 'checked="checked"';?> >
							<label for="checkboxExample2"><?php echo $row->company_name; ?></label>
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
