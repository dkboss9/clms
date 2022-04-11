

<div id="custom-content" class="white-popup-block white-popup-block-md">
	<div class="row">
		<div class="col-md-12">
			<h5><?php echo $discussion->discussion_title;?></h5>
			<p><?php echo $discussion->discussion_description;?></p>
		</div>
	</div>
	
	
	<?php 
	$updates = $this->lms_projectmodel->get_discussionupdates($discussion->discussion_id);
	//echo $this->db->last_query();
	foreach ($updates as $update) { ?>
	<hr>
	<div class="row">
		
		<div class="col-md-12">
			<?php echo '<h6>'.$update->discussion_description.'</h6>';?>
			<?php if(file_exists("./uploads/lms_project/".$update->file_name ) && $update->file_name!=""){ ?>
			<a href="<?php echo SITE_URL."/uploads/lms_project/".$update->file_name;?>" target="_blank">Download File</a>
			<?php } ?>
			<p style="font-style:italic;font-size: 11px;"> Added by : <?php echo $update->first_name.' '.$update->last_name;?> at <?php echo date("d M Y",$update->added_date);?>  </p>
			
		</div>
	</div>
	<?php }	 ?>
	<hr>
	
	<form method="post" id="form_task"  action="<?php echo base_url("lms_project/add_discussionupdate");?>" enctype='multipart/form-data'>

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
				<input type="hidden" value="<?php echo $discussion->discussion_id;?>" name="discussion_id">
				<input type="hidden" value="<?php echo $discussion->project_id;?>" name="project_id">
				<input type="hidden" value="<?php echo $discussion->discussion_title;?>" name="discussion_name">
				<input type="submit" value="Submit" name="submit" class="btn btn-primary">
				<button type="reset" class="btn btn-default">Reset</button>
			</div>
		</div>

	</form>

</div>


