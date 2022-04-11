<div class="row">
	<div class="col-md-12">
		<section class="panel">

			<div class="panel-body">
				<h3><?php echo $result->task_name;?></h3>
				<p><?php echo $result->task_detail;?></p>
				<p> 
					Project start: <?php echo date("d/m/Y",$result->start_date);?>  &nbsp;&nbsp;Expiry date: <?php echo date("d/m/Y",$result->end_date);?>
					&nbsp;&nbsp; Status: <span class="label" style="background-color:<?php echo $result->code;?>"><?php echo $result->status_name; ?></span>
				</p>
				<?php 
				$users = $this->lms_projectmodel->getProjectAssignUsers($result->task_id);
				?>
				<p>
					Assign to: 
					<?php 
					foreach ($users as $row ) {
						?>
						<span style="margin-right:20px;"><?php echo $row->first_name.' '.$row->last_name;?></span>
						<?php
					}
					?>
				</p>
				

			</div>
		</section>
	</div>
</div> 
<div class="row">
	<div class="col-md-12">
		<section class="panel">

			<div class="panel-body">
				<a class="mb-xs mt-xs mr-xs modal-basic btn <?php echo $this->uri->segment(2) == "task"? 'btn-active': 'btn-default';?>" href="<?php echo base_url("lms_project/task/".$this->uri->segment(3));?>">Task (<?php echo $this->lms_projectmodel->counttask($result->task_id);?>)</a>
				<a class="mb-xs mt-xs mr-xs modal-basic btn  <?php echo $this->uri->segment(2) == "discussion"? 'btn-active': 'btn-default';?>" href="<?php echo base_url("lms_project/discussion/".$this->uri->segment(3));?>">Discussion (<?php echo $this->lms_projectmodel->countdiscussion($result->task_id);?>)</a>
				<a class="mb-xs mt-xs mr-xs modal-basic btn <?php echo $this->uri->segment(2) == "testing"? 'btn-active': 'btn-default';?> " href="<?php echo base_url("lms_project/testing/".$this->uri->segment(3));?>">Testing (<?php echo $this->lms_projectmodel->counttesting($result->task_id);?>)</a>
				<a class="mb-xs mt-xs mr-xs modal-basic btn <?php echo $this->uri->segment(2) == "file"? 'btn-active': 'btn-default';?>" href="<?php echo base_url("lms_project/file/".$this->uri->segment(3));?>">Upload File (<?php echo $this->lms_projectmodel->countfiles($result->task_id);?>)</a>
				<a class="mb-xs mt-xs mr-xs modal-basic btn <?php echo $this->uri->segment(2) == "callendar"? 'btn-active': 'btn-default';?>" href="<?php echo base_url("lms_project/callendar/".$this->uri->segment(3));?>">Calendar</a>
				<a class="mb-xs mt-xs mr-xs modal-basic btn btn-default" href="<?php echo base_url("lms_project/");?>">Manage Projects</a>

			</div>
		</section>
	</div>
</div> 