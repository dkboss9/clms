

<div id="custom-content" class="white-popup-block white-popup-block-md">
	<div class="row">
		<div class="col-md-12">
			<h5><?php echo $discussion->file_title;?></h5>
			<?php
			if($discussion->file_name != "" && file_exists("./uploads/comments/".$discussion->file_name)){
				?>
				<p> <a href="<?php echo SITE_URL."uploads/comments/".$discussion->file_name;?>" target="_blank"><?php echo 'Download File';?></a></p>
				<?php
			}
			?>
		</div>
	</div>


	<?php 
	$updates = $this->ordermodel->get_fileupdates($discussion->file_id);
	//echo $this->db->last_query();
	foreach ($updates as $update) { ?>
	<hr>
	<div class="row">

		<div class="col-md-12">
			<?php echo '<h6>'.$update->file_title.'</h6>';?>
			<?php if(file_exists("./uploads/comments/".$update->file_name ) && $update->file_name!=""){ ?>
			<a href="<?php echo SITE_URL."/uploads/comments/".$update->file_name;?>" target="_blank">Download File</a>
			<?php } ?>
			<p style="font-style:italic;font-size: 11px;">Added by : <?php echo $update->first_name.' '.$update->last_name;?> at <?php echo date("d M Y",$update->added_date);?>  </p>

		</div>
	</div>
	<?php }	 ?>
	<hr>

	<form method="post" id="form_task"  action="<?php echo base_url("order/add_fileupdate");?>" enctype='multipart/form-data'>

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

				<input type="hidden" value="<?php echo $discussion->file_id;?>" name="discussion_id">
				<input type="submit" value="Submit" name="submit" class="btn btn-primary">
				<button type="reset" class="btn btn-default">Reset</button>
			</div>
		</div>

	</form>

</div>


