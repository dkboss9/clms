

<div id="custom-content" class="white-popup-block white-popup-block-md">
	<div class="row">
		<div class="col-md-12">
			<p><?php 
				//print_r($discussion);
				echo $discussion->test_description;?></p>
			</div>
		</div>


		<?php 
		$updates = $this->lms_projectmodel->get_testingupdates($discussion->test_id);
	//echo $this->db->last_query();
		foreach ($updates as $update) { ?>
		<hr>
		<div class="row">

			<div class="col-md-12">
				<?php echo '<h6>'.$update->test_description.'</h6>';?>
				<?php if(file_exists("../uploads/lms_project/".$update->testing_file ) && $update->testing_file!=""){ ?>
				<a href="<?php echo SITE_URL."/uploads/lms_project/".$update->testing_file;?>" target="_blank">Download File</a>
				<?php } ?>
				<p style="font-style:italic;font-size: 11px;">Added by : <?php echo $update->first_name.' '.$update->last_name;?> at <?php echo date("d M Y",$update->added_date);?>  </p>

			</div>
		</div>
		<?php }	 ?>
		<hr>

		<form method="post" id="form_task"  action="<?php echo base_url("lms_project/add_testingupdate");?>" enctype='multipart/form-data'>

			<div class="row">
				<div class="col-sm-12">
					<h3>Add Update</h3>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-12">
					<textarea name="details123" id="details123" class="form-control required" rows="6" ></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<input type="file" name="task_file" class="form-control">
				</div>
			</div>
			<div class="row mb-lg">
				<div class="col-sm-9 col-sm-offset-3">
					<input type="hidden" value="<?php echo $discussion->test_id;?>" name="discussion_id">
					<input type="hidden" value="<?php echo $discussion->project_id;?>" name="project_id">
					<input type="submit" value="Submit" name="submit" class="btn btn-primary">
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>

		</form>

	</div>


