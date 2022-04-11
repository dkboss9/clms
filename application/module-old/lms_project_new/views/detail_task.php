

<div id="custom-content" class="white-popup-block white-popup-block-md">
	<div class="row">
		<div class="col-md-12">
			<h5><?php echo $result->task_name;?></h5>
			<p><?php echo $result->task_detail;?></p>
		</div>
	</div>
	
	<div class="row">
		
		<div class="col-md-12">
			<?php echo '<p> Priority: '.$result->priority.'</p>';?>
			<?php echo '<p> Status: '.$result->status_name.'</p>';?>
			<?php echo '<p> Start Date: '.date('d M Y',$result->start_date).'</p>';?>
			<?php echo '<p> End Date: '.date('d M Y',$result->end_date).'</p>';?>
		</div>
	</div>
	<?php 
	$updates = $this->taskmodel->get_updates($result->task_id);
	//echo $this->db->last_query();
	foreach ($updates as $update) { ?>
	<hr>
	<div class="row">
		
		<div class="col-md-12">
			<?php echo '<h6>'.$update->content.'</h6>';?>
			<?php echo '<p> Added by : '.$update->first_name.' '.$update->last_name.' at '.date("d M Y",$update->added_date).'</p>';?>
			
		</div>
	</div>
	<?php }	?>
	<hr>
	
	<form method="post"  action="<?php echo base_url("task/add_update");?>">

		<div class="row">
			<div class="col-sm-12">
				<h3>Add Update</h3>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-12">
				<textarea name="details123"  class="form-control" rows="6" required></textarea>
			</div>
		</div>
		<div class="row mb-lg">
			<div class="col-sm-9 col-sm-offset-3">
				<input type="hidden" value="<?php echo $result->task_id;?>" name="task_id">
				<input type="submit" value="Submit" name="submit" class="btn btn-primary">
				<button type="reset" class="btn btn-default">Reset</button>
			</div>
		</div>

	</form>

</div>

