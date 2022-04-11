<?php
$query = $this->ordermodel->getdata($order_id);

$result  = $query->row();
$cutomer = $this->quotemodel->getCustomer($result->customer_id);
$invoice = $this->ordermodel->getinvoicestatus($result->invoice_status);

?>


<div id="custom-content" class="white-popup-block white-popup-block-md">

	<div class="form-group">
		
		<div class="col-md-12">
			<div class="table-responsive">
			
				<table class="table invoice-items" width="100%">
					
					<tbody>
						
						<tr>
							<td>Order no</td>
							<td><?php echo $order->order_number;?></td>
							<td>Customer</td>
							<td><?php echo $cutomer->customer_name;?></td>
							
						</tr>

						<tr>
							<td>Installer</td>
							<td colspan="3"> <?php foreach($installers as $key => $installer1){?>
                    <?php echo $key + 1; ?>.  <a class="simple-ajax-popup btn-default" href="<?php echo base_url("installer/details/".$installer1->threatre_id);?>"><?php echo $installer1->first_name.' '.$installer1->last_name;?>(<?php echo $installer1->position_type;?>)</a>
                    <br> 
                  <?php } ?></td>
							
						</tr>

						<tr>
							<td>Installed date</td>
							<td><?php echo date("D d/m/Y",strtotime($order->installed_date));?></td>
							<td>Installed Time</td>
							<td><?php echo $order->installed_time;?></td>
							
						</tr>

						<tr>
							<td>Deadline date</td>
							<td><?php echo date("D d/m/Y",strtotime($order->deadline_date));?></td>
							<td>Allocated Time</td>
							<td><?php echo $order->deadline_time;?></td>
						</tr>

						<tr>
							<td>Job  Assigned by</td>
							<td><?php echo $order->assign_by;?></td>
							<td></td>
							<td></td>
						</tr>


					</tbody>
				</table>
				<table class="table invoice-items" width="100%">
					<thead>
						<tr class="h4 text-dark">

							<th id="cell-item" class="text-weight-semibold">Special note</th>
							

						</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($order_notes)){
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
						}

						?>
						
						<tr>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<hr>
	<form method="post"  action="<?php echo base_url("order/notes");?>">

		<div class="form-group">
			<label class="col-md-3 control-label">Special Note</label>
			<div class="col-sm-6">
				<textarea name="note" id="note" class="form-control" required></textarea>
			</div>
		</div>

		<div class="row mb-lg">
			<div class="col-sm-9 col-sm-offset-3">
				<input type="hidden" value="<?php echo $order->order_id;?>" name="order_id">
				<input type="submit" value="Submit" name="submit" class="btn btn-primary">
				<button type="reset" class="btn btn-default">Reset</button>
			</div>
		</div>


	</form>
	

</div>

<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>


