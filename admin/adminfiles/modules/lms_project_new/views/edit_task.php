

<div id="custom-content" class="white-popup-block white-popup-block-md">
	<h2 class="panel-title">Project : Task : [Edit]</h2>
	<p>&nbsp;</p>
	<form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("task/edit");?>" method="post" enctype='multipart/form-data'>

		<div class="form-group">
			<label class="col-md-3 control-label" for="inputDefault">Task Title</label>
			<div class="col-md-6">
				<input type="text" name="name" value="<?php echo $result->task_name;?>"  class="form-control" id="inputDefault" required>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Task Details</label>
			<div class="col-md-9">
				<textarea name="details" id="trumbowyg" rows="10" class="form-control" required><?php echo $result->task_detail;?></textarea>
			</div>
		</div>
		<?php if($this->session->userdata("usergroup") == 1 || $this->session->userdata("usergroup") == 7){ ?>
		<div class="form-group">
			<label class="col-md-3 control-label" for="inputDefault">Assign To</label>
			<div class="col-md-6">
			<?php /*
				<select class="form-control" name="assign_to" required>
					<option value="">Select</option>
					<?php 
					foreach ($users as $user ) {
						?>
						<option <?php if($user->userid == $result->user_id) echo 'selected="selected"';?> value="<?php echo $user->userid;?>"><?php echo $user->first_name." ".$user->last_name;?></option>
						<?php
					}
					?>
				</select>
				*/
				?>
				<?php 
				foreach ($users as $user ) {
					$taskuser = $this->taskmodel->get_taskusers($user->userid,$result->task_id);
					?>
					<div style="float:left;margin-right:20px;width:200px;">
						<input type="checkbox" name="assign_to[]" value="<?php echo $user->userid;?>" <?php if($taskuser > 0) echo 'checked="checked"';?>><?php echo $user->first_name." ".$user->last_name;?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php } ?>
		<div class="form-group">
			<label class="col-md-3 control-label" for="inputDefault">Status</label>
			<div class="col-md-6">
				<select class="form-control" name="status" required>
					<option value="">Select</option>
					<?php 
					foreach ($status as $row) {
						?>
						<option <?php if($row->status_id == $result->task_status) echo 'selected="selected"';?> value="<?php echo $row->status_id;?>"><?php echo $row->status_name;?></option>
						<?php
					}
					?>

				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="inputDefault">Priority</label>
			<div class="col-md-6">
				<select class="form-control" name="priority" required>
					<option value="">Select</option>
					<option <?php if("Normal" == $result->priority) echo 'selected="selected"';?> "Normal">Normal</option>
					<option <?php if("High" == $result->priority) echo 'selected="selected"';?> "High">High</option>
					<option <?php if("Urgent" == $result->priority) echo 'selected="selected"';?> "Urgent">Urgent</option>

				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Start Date</label>
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</span>
					<input type="text" data-plugin-datepicker="" value="<?php echo date("d/m/Y",$result->start_date);?>" name="start_date" class="form-control">
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">End Date</label>
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</span>
					<input type="text" data-plugin-datepicker="" name="end_date" value="<?php echo date("d/m/Y",$result->end_date);?>" class="form-control">
				</div>
			</div>
		</div>


		<div class="form-group">
			<label class="col-md-3 control-label" for="inputDefault"></label>
			<div class="col-md-6">
				<input type="hidden" name="task_id" value="<?php echo $result->task_id;?>">
				<input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
				<a href="<?php echo base_url("task");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
			</div>
		</div>
	</form>

</div>

