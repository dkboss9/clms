
<div id="custom-content" class="white-popup-block white-popup-block-md">
	<div class="row">
		<div class="col-md-12">
			<?php  //print_r($this->session->userdata);?>
			<h5><?php echo $result->lead_name;?></h5>
			<p><?php echo $result->company_name;?></p>

			<?php 
			$status = $this->dashboardmodel->get_leadstatus($result->status_id);
			if($result->status_id == 1)
				$class = 'label-warning';
			elseif($result->status_id == 4)
				$class = 'label-danger';
			else
				$class = 'label-success';
			?>
			<p>Status: <span class="label <?php echo $class;?>"><?php echo @$status->status_name;?></span></p>
		</div>
	</div>
	<hr>

	<?php 
	$updates = $this->appointmentmodel->get_updates($result->lead_id);
  //echo $this->db->last_query();
	foreach ($updates as $update) { ?>
	<hr>
	<div class="row">

		<div class="col-md-12">
			<?php echo '<h6>'.$update->content.'</h6>';?>
			<?php echo '<p> Added by : '.$update->first_name.' '.$update->last_name.' at '.date("d M Y",$update->added_date).'</p>';?>

		</div>
	</div>
	<?php } ?>
	<div class="row">
		<div class="col-sm-12">
		<h3>Add Consultant</h3>
		</div>
	</div>

	<hr>

	<form method="post"  action="<?php echo base_url("appointment/add_consultant/".$result->lead_id);?>">

		



		<div class="form-group">
			<label class="col-md-3 control-label" for="inputDefault">Consultant</label>
			<div class="col-md-9">
				<select name="consultant" id="consultant" class="form-control ">
					<option value="">Select</option>
					<?php 
					foreach ($employees as $row) {
						?>
						<option value="<?php echo $row->id;?>" <?php if($row->id == $result->consultant) echo 'selected="selected"';?>><?php echo $row->first_name.' '.$row->last_name;?></option>
						<?php
					}
					?>
				</select>
			</div>
		</div>


		

		<div class="form-group">
			<label class="col-md-3 control-label" for="inputDefault">Today's Update</label>
			<div class="col-sm-9">
				<textarea name="details123"  class="form-control" required></textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="inputDefault">Status</label>
			<div class="col-md-9">
				<select name="status" class="form-control mb-md">

					<?php 
      //  if($this->session->userdata == 7){
					foreach($leadstatus as $stat){
						?>
						<option <?php if($result->status_id == $stat->status_id) echo 'selected="selected"';?>value="<?php echo $stat->status_id;?>"><?php echo $stat->status_name;?></option>
						<?php
					}
      /*  }else{
          ?>
          <option value="2">Processing</option>
          <?php
      }*/
      ?>
  </select>
</div>
</div>

<div class="row mb-lg">
	<div class="col-sm-9 col-sm-offset-3">
		<input type="hidden" value="<?php echo $result->lead_id;?>" name="lead_id">
		<input type="hidden" value="<?php echo $this->input->get("project")??0;?>" name="project">
		<input type="submit" value="Submit" name="submit" class="btn btn-primary">
		<button type="reset" class="btn btn-default">Reset</button>
	</div>
</div>

</form>

</div>


<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>
