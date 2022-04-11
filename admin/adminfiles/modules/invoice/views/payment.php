

<div id="custom-content" class="white-popup-block white-popup-block-md">

	<div class="form-group">
		<label class="col-md-3 control-label">Payment Info</label>
		<div class="col-md-6">
			<div class="table-responsive">
				<table class="table invoice-items">
					<thead>
						<tr class="h4 text-dark">

							<th id="cell-item" class="text-weight-semibold">Date</th>
							<th id="cell-desc" class="text-weight-semibold">Amount</th>

						</tr>
					</thead>
					<tbody>
						<?php 
						$payments = $this->invoicemodel->getPayments($result->invoice_id);
						foreach ($payments as $row) {
							?>
							<tr>
								<td><?php echo date("d/m/Y",$row->paid_date);?></td>
								<td class="text-weight-semibold text-dark"><?php echo $row->amount;?></td>
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
	
	<form method="post"  action="<?php echo base_url("invoice/payment");?>">

		<div class="form-group">
			<label class="col-md-3 control-label">Due Amount</label>
			<div class="col-sm-6">
				<?php echo $result->due_amount;?>
				<input type="hidden" name="due" value="<?php echo $result->due_amount;?>">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Amount Paid</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" value="" name="paid" id="paid" requried>
			</div>
		</div>
		<div class="row mb-lg">
			<div class="col-sm-9 col-sm-offset-3">
				<input type="hidden" value="<?php echo $result->invoice_id;?>" name="invoice_id">
				<input type="submit" value="Submit" name="submit" class="btn btn-primary">
				<button type="reset" class="btn btn-default">Reset</button>
			</div>
		</div>

	</form>

</div>

