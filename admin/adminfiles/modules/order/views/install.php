

<div id="custom-content" class="white-popup-block white-popup-block-md">
	<div class="form-group">
			<header class="panel-heading">
				<h2 class="panel-title"> Job Allocation Center</h2>
			</header>
	</div>

	<div class="form-group">
		
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table invoice-items">
				
				
					<tbody>
						<?php 
						
						foreach ($order_notes as $row) {
							?>
							<tr>
								
								<td class=" text-dark">
									<?php echo $row->notes;?>
									<br>
									Added By: <?php echo $row->first_name.' '.$row->last_name;?> &nbsp;&nbsp; Added Date: <?php echo date("d/m/Y",$row->added_date);?>
								</td>
							</tr>
							<?php
						}

						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<hr>
	
	<form method="post"  action="<?php echo base_url("order/install");?>" id="form_install">
		<div class="form-group">
			<label class="col-md-3 control-label">Address</label>
			<div class="col-md-9">
				<?php echo $customer->address;?>

			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Nature of project</label>
			<div class="col-md-9">
				<?php echo $result->product;?>

			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Assigned To</label>
			<div class="col-md-4">
				<select name="installer[]" data-plugin-selectTwo id="installer" class="form-control" required multiple>
					<option value="">Select</option>
					<?php 
					foreach ($installers as $row) {
						$is_exist = $this->ordermodel->getAssignedOrderInstallers($row->threatre_id,$result->order_id)->num_rows();
					?>
					<option value="<?php echo $row->threatre_id?>" rel="<?php echo $row->hourly_rate?>" <?php if($is_exist > 0) echo 'selected="selected"';?>><?php echo $row->first_name. ' ' .$row->last_name;?></option>
					<?php 
				}
				?>
			</select>

		</div>
		<label class="col-md-2 control-label">Job Type</label>
		<div class="col-md-4">
			<select name="install_type" data-plugin-selectTwo id="install_type" class="form-control" required>
				<option value="">Select</option>
				<?php 
				foreach ($installer_type as $row) {?>
				<option value="<?php echo $row->threatre_id?>" <?php if(@$order_installer->install_type == $row->threatre_id) echo 'selected="selected"';?>><?php echo $row->name;?></option>
				<?php 
			}
			?>
		</select>

	</div>
</div>
<?php 
if(isset($order_installer->installed_date))
	$date = date("d/m/Y",strtotime($order_installer->installed_date));
else
	$date='';

if(isset($order_installer->installed_date))
	$deadline_date = date("d/m/Y",strtotime($order_installer->deadline_date));
else
	$deadline_date='';
?>

<div class="form-group">
	<label class="col-md-2 control-label">Start Date</label>
	<div class="col-md-4">
		<div class="input-group">
			<span class="input-group-addon">
				<i class="fa fa-calendar"></i>
			</span>
			<input type="text" autocomplete="off" value="<?php echo $date;?>" name="reminder_date" id="reminder_date" class="form-control" required>
		</div>
	</div>
	<label class="col-md-2 control-label">Start Time</label>
	<div class="col-md-4">
		<div class="input-group">
			<span class="input-group-addon">
				<i class="fa fa-clock-o"></i>
			</span>
			<input type="text" data-plugin-timepicker=""  autocomplete="off"  name="time" value="<?php echo @$order_installer->installed_time; ?>" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }">
		</div>
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">Project Deadline Date</label>
	<div class="col-md-4">
		<div class="input-group">
			<span class="input-group-addon">
				<i class="fa fa-calendar"></i>
			</span>
			<input type="text" value="<?php echo $deadline_date;?>" autocomplete="off"  name="deadline_date" id="deadline_date" class="form-control datepicker" required>
		</div>
	</div>
	<label class="col-md-2 control-label">Project Deadline Time</label>
	<div class="col-md-4">
		<div class="input-group">
			<span class="input-group-addon">
				<i class="fa fa-clock-o"></i>
			</span>
			<input type="text" data-plugin-timepicker="" autocomplete="off"  name="deadline_time" value="<?php echo @$order_installer->deadline_time; ?>" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }">
		</div>
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">Allocate Time by</label>
	<div class="col-md-6">
		<div class="input-group">
			<input type="radio" name="allocate_by" id="employer" value="Employer" <?php if(@$order_installer->time_allocate_by == 'Employer') echo 'checked="checked"';?>> Employer &nbsp;&nbsp;
			<input type="radio" name="allocate_by" id="employee" value="Employee" <?php if(@$order_installer->time_allocate_by == 'Employee') echo 'checked="checked"';?>> Employee
		</div>
	</div>
</div>
<div class="form-group" <?php echo @$order_installer->time_allocate_by == 'Employer' ? '':'style="display: none"'?>; id="div_employer">
	<div class="form-group" >
		<label class="col-md-2 control-label">Payment Method</label>
		<div class="col-md-10">
			<select name="payment_method" data-plugin-selectTwo id="payment_method" class="form-control required">
				<option value="">Payment Method</option>
				<option value="Hourly Rate" <?php echo @$order_installer->payment_method == 'Hourly Rate' ? 'selected="selected"':''?>>Hourly Rate</option>
				<option value="Flat Rate" <?php echo @$order_installer->payment_method == 'Flat Rate' ? 'selected="selected"':''?>>Flat Rate</option>
			</select>
		</div>
	</div>
	
	<div class="form-group" id="div_hourly" <?php echo @$order_installer->payment_method == 'Hourly Rate' ? '':'style="display: none;"'?>>
		<label class="col-md-2 control-label">Hourly Rate</label>
		<div class="col-md-4">
			<input type="text" value="<?php echo @$order_installer->hrate ? $order_installer->hrate:0;?>" name="hourly_rate" id="hourly_rate" class="form-control">
		</div>
		<label class="col-md-2 control-label">Total Hours</label>
		<div class="col-md-4">
			<input type="text" value="<?php echo @$order_installer->total_hour ? $order_installer->total_hour:0;?>" name="install_time" id="install_time" class="number form-control required">
		</div>
	</div>
	<div class="form-group" id="div_flat" <?php echo trim(@$order_installer->payment_method) == 'Flat Rate' ? '':'style="display: none;"'?> >
		<div class="form-group" >
			<label class="col-md-2 control-label">Install time</label>
			<div class="col-md-4">
				<input type="text" value="<?php echo @$order_installer->allocated_time;?>" name="flat_install_time" id="flat_install_time" class="form-control  required">
			</div>
			<label class="col-md-2 control-label">Amount</label>
			<div class="col-md-4">
				<input type="text" value="<?php echo @$order_installer->flat_amount ? $order_installer->flat_amount : 0;?>" name="flat_amount" id="flat_amount" class="form-control number required flat_amount">
			</div>
		</div>
	</div>
	<div class="form-group" id="div_total_amount" <?php echo @$order_installer->payment_method != '' ? '':'style="display: none;"'?>>
		<div class="form-group" >
			<label class="col-md-2 control-label">Fuel</label>
			<div class="col-md-4">
				<input type="text" value="<?php echo @$order_installer->fuel_amount ? $order_installer->fuel_amount : 0;?>" name="fuel_amount" id="fuel_amount" class="form-control number  all_amount">
			</div>
			<label class="col-md-2 control-label">Transport</label>
			<div class="col-md-4">
				<input type="text" value="<?php echo @$order_installer->transport_amount ? $order_installer->transport_amount : 0;?>" name="transport_amount" id="transport_amount" class="form-control number  all_amount">
			</div>
		</div>
		<div class="form-group" >
			<label class="col-md-2 control-label">Others</label>
			<div class="col-md-4">
				<input type="text" value="<?php echo @$order_installer->others_amount ? $order_installer->others_amount : 0;?>" name="others_amount" id="others_amount" class="form-control number all_amount">
			</div>
		</div>
		<label class="col-md-2 control-label">Total Amount</label>
		<div class="col-md-10">
			<input type="text" name="total_amount" id="total_amount" value="<?php echo @$order_installer->total_amount ? $order_installer->total_amount : 0;?>" class="form-control number" value="0" >
		</div>
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">Special Note</label>
	<div class="col-md-10">
		<textarea name="note" id="note" class="form-control"></textarea>
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">Job Assigned by</label>
	<div class="col-md-10">
		<input type="text" name="assign_by" id="assign_by" value="<?php echo @$order_installer->assign_by?>" class="form-control">
		
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label"></label>
	<div class="col-md-9">
		<input type="checkbox" name="send_mail" value="1" checked=""> Send email to Installer. <br/>
		<input type="checkbox" name="copy_me" value="1" checked=""> Send copy of email to me. <br />
		<input type="checkbox" name="pdf_attachment" value="1" > Send pdf attachment
	</div>
</div>
<div class="row mb-lg">
<label class="col-md-2 control-label"></label>
	<div class="col-md-9 ">
		<input type="hidden" name="project" value="<?php echo $this->input->get("project")??0;?>">
		<input type="hidden" value="<?php echo $result->order_id;?>" name="order_id">
		<input type="submit" value="Submit" name="submit" class="btn btn-primary">
		<button type="reset" class="btn btn-default">Reset</button>
	</div>
</div>

</form>

</div>

<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>



