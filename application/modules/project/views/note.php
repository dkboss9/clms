
<!-- start: page -->
<section class="panel">
	<header class="panel-heading">


		<h2 class="panel-title">Add Notes</h2>
	</header>

	<div class="panel-body">
		<form class="form-horizontal form-bordered" id="form" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>
			<table class="table table-bordered table-striped mb-none" id="datatable-example">
				<thead>
					<tr>
						<th style="width:2%;"><input type="checkbox" name="all" id="checkall" ></th>
						<th>Order Number</th>
						<th>Client</th>
						<th>Sales Rep</th>
						<th>Grand Total</th>
						<th>Commission Rate</th>
						<th>Commission</th>
						<th>Added Date</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Lead Type</th>
						<th>Is Assigned</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach ($project->result() as $row) {
						$assign = 0;
						$emps = $this->projectmodel->get_projectEmployee($row->project_id);
						if(count($emps) > 0)
							$assign = 1;
						$sups = $this->projectmodel->get_projectSupplier($row->project_id);
						if(count($sups) > 0)
							$assign = 1;
						$publish = ($row->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
						?>
						<tr class="gradeX">
							<td><input type="checkbox" class="checkone" value="<?php echo $row->project_id; ?>" /></td>
							<td><?php echo $row->order_no;?></td>
							<td><?php echo $row->fname.' '.$row->lname;?></td>
							<td><?php echo $row->first_name.' '.$row->last_name;?></td>
							<td>$<?php echo $row->grand_total;?></td>
							<td>$<?php echo $row->commission_rate;?>%</td>
							<td>$<?php echo $row->commission;?></td>
							<td><?php echo date("d/m/Y",$row->added_date);?></td>
							<td><?php echo date("d/m/Y",$row->start_date);?></td>
							<td><?php echo date("d/m/Y",$row->end_date);?></td>
							<td><?php echo $row->type_name;?></td>
							<td><?php

								if($assign == 0){
									?>
									<a class="simple-ajax-popup btn-default"   href="<?php echo base_url("project/employee_assign/".$row->project_id.'?project='.$this->input->get("project")??0);?>"><img src="<?php echo base_url("assets/images/notdone.png");?>"></a>
									<?php
								}else{
									?>
									<a class="simple-ajax-popup btn-default"   href="<?php echo base_url("project/employee_assign/".$row->project_id.'?project='.$this->input->get("project")??0);?>"><img src="<?php echo base_url("assets/images/done.png");?>"></a>
									<?php
								}
								?>
							</td>
							<td><?php echo $row->status_name;?></td>
						</tr>
						<?php
					} ?>


				</tbody>
			</table>
			<br>

			<?php if($this->session->flashdata("success_message")){?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
			</div>
			<?php
		}
		?>
		<?php
		foreach ($notes as $note) {
			?>

			<div class="form-group" >
				<label class="col-md-3 control-label" for="payment_method"></label>

				<label class="col-md-6 " for="payment_method">
					<?php echo $note->note;?>
					<br>
					<span style="font-style:italic;">Added by: <?php echo $note->first_name.' '.$note->last_name;?> at <?php echo date("d-m-Y",strtotime($note->added_date));?></span>
				</label>

			</div>

			<?php } ?>
			<div class="form-group" >
				<label class="col-md-3 control-label" for="payment_method">Special Note:</label>
				<div class="col-md-6">
					<textarea name="note" id="note" rows="6" class="form-control"></textarea>

				</div>
				<?php //echo form_error("sex");?>
			</div>

<?php /*
			<div class="form-group">
				<label class="col-md-3 control-label" for="price"></label>
				<div class="col-md-6">
					<input type="checkbox" name="send_email" value="1" checked=""> Send email automatically
				</div>
			</div>
			*/ ?>
			<div class="form-group">
				<label class="col-md-3 control-label" for="inputDefault"></label>
				<div class="col-md-6">
					<input type="hidden" name="project" value="<?php echo $this->input->get("project")??0;?>">		
					<input type="hidden" name="project_id" value="<?php echo $project_id;?>">
					<input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
					<?php if($this->input->get("project")){ ?>
						<a href="<?php echo base_url("project/cases/".$row->student_id);?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
					<?php }else{ ?>
						<a href="<?php echo base_url("dashboard/enroll");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
					<?php	} ?>
				</div>
			</div>
		</form>
	</div>
</section>




</section>
</div>


</section>
