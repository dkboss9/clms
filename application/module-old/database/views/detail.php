
<div id="custom-content" class="white-popup-block white-popup-block-md">
	<?php 
	if(count($result)>0){
		foreach ($result as $note) { ?>
		<hr>
		<div class="row">

			<div class="col-md-12">
				<?php echo '<h6>'.$note->details.'</h6>';?>
				<?php 
				$users = $this->databasemodel->getuser($note->added_by)->row();
				echo '<p> Added by : '.$users->first_name.' '.$users->last_name.' at '.date("d M Y",$note->added_date).'</p>';
				?>

			</div>
		</div>
		<?php }}else{
			?>
			<div class="row">

				<div class="col-md-12">
					<?php echo '<h6>No note found.</h6>';?>
				</div>
			</div>
			<?php
		} ?>
		<hr>

		<form method="post"  action="<?php echo base_url("database/add_note");?>">

			<div class="row">
				<div class="col-sm-12">
				<h3>Add Note</h3>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-3 control-label" for="inputDefault">Notes</label>
				<div class="col-sm-9">
					<textarea name="note"  class="form-control" rows="6" required></textarea>
				</div>
			</div>
			<div class="row mb-lg">
				<div class="col-sm-9 col-sm-offset-3">
					<input type="hidden" value="<?php echo $db_id;?>" name="db_id">
					<input type="submit" value="Submit" name="submit" class="btn btn-primary">
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>

		</form>

	</div>


	<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>
