

<div id="custom-content" class="white-popup-block white-popup-block-md">
<div class="form-group">
			<header class="panel-heading">
				<h2 class="panel-title"> Payment Info</h2>
			</header>
	</div>
	<div class="form-group">
		
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table invoice-items">
					<thead>
					
						<tr class="h4 text-dark">
							<th id="cell-item" class="text-weight-semibold">Date</th>
							<th id="cell-desc" class="text-weight-semibold">Amount</th>
							<th id="cell-desc" class="text-weight-semibold">Payment Method</th>
							<th id="cell-desc" class="text-weight-semibold">Note</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$payments = $this->ordermodel->getPayments($result->order_id);
						foreach ($payments as $row) {
							?>
							<tr>
								<td><?php echo date("d/m/Y",$row->paid_date);?></td>
								<td class="text-weight-semibold text-dark"><?php echo $row->amount;?></td>
								<td class="text-weight-semibold text-dark"><?php echo $row->payment_method;?></td>
								<td class="text-weight-semibold text-dark"><?php echo $row->note;?></td>							</tr>
								<?php
							}

							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<hr>

		<form method="post" id="form_payment" action="<?php echo base_url("order/payment");?>">

			<div class="form-group">
				<label class="col-md-3 control-label">Due Amount</label>
				<div class="col-md-9">
					<?php echo $result->due_amount;?>
					<input type="hidden" name="due" value="<?php echo $result->due_amount;?>">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">Amount Paid</label>
				<div class="col-md-9">
					<input type="text" class="form-control " value="" name="paid" id="paid" required>
				</div>
			</div>

			<div class="form-group" >
				<label class="col-md-3 control-label" for="payment_method">Payment Method:</label>
				<div class="col-md-9">
					<select name="payment_method" data-plugin-selectTwo id="payment_method" class="form-control" required>
						<option value="">Select</option>
						<option value="Bank Transfer">Bank Transfer</option>
						<option value="COD">COD</option>
						<option value="Credit Card">Credit Card</option>
						<option value="Eway">Eway</option>
					</select>

				</div>
				<?php //echo form_error("sex");?>
			</div>



			<div style="display:none;" id="div_eway">

				<div class="form-group" >
					<label class="col-md-3 control-label" for="card_name">Card Name *:</label>
					<div class="col-md-9">
						<input type="text"  value="" id="card_name" name="card_name" placeholder="Enter Your Card Name" class="form-control" >
					</div>
				</div>

				<div class="form-group" >
					<label class="col-md-3 control-label" for="card_number">Card Number *:</label>
					<div class="col-md-9">
						<input type="text"  value="" id="card_number" name="card_number" placeholder="Enter Your Card Number" class="form-control " >

					</div>
				</div>

				<div class="form-group" >
					<label class="col-md-3 control-label" for="expiry_month">Expiry Date *:</label>
					<div class="col-md-3">
						<select name="expiry_month" data-plugin-selectTwo id="expiry_month" data-plugin-selectTwo class="form-control" >
							<option value="">Month</option>
							<option value="01">01</option>
							<option value="02">02</option>
							<option value="03">03</option>
							<option value="04">04</option>
							<option value="05">05</option>
							<option value="06">06</option>
							<option value="07">07</option>
							<option value="08">08</option>
							<option value="09">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>

					</div>
					<div class="col-md-3">
						<select name="expiry_year" id="expiry_year" data-plugin-selectTwo class="form-control" >
							<option value="">Year</option>
							<option value="17">2017</option>
							<option value="18">2018</option>
							<option value="19">2019</option>
							<option value="20">2020</option>
							<option value="21">2021</option>
							<option value="22">2022</option>
							<option value="23">2023</option>
							<option value="24">2024</option>
							<option value="25">2025</option>
							<option value="26">2026</option>
							<option value="27">2027</option>
							<option value="28">2028</option>
							<option value="29">2029</option>
							<option value="30">2030</option>
						</select>

					</div>
				</div>

				<div class="form-group" >
					<label class="col-md-3 control-label" for="ccv">CVV*</label>
					<div class="col-md-9">
						<input type="text"  value="" id="ccv" name="ccv" placeholder="Enter CCV" class="form-control" >

					</div>
					<?php //echo form_error("sex");?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label" for="price">Invoice</label>
				<div class="col-md-9">
					<select name="invoice_status" data-plugin-selectTwo id="invoice_status" data-plugin-selectTwo class="form-control required" >
						<option value=""></option>
						<?php 
						foreach ($invoices as $row){
							?>
							<option value="<?php echo $row->status_id;?>" <?php if(@$result->invoice_status == $row->status_id) echo 'selected="selected"';?>><?php echo $row->status_name;?></option>
							<?php
						}
						?>

					</select>

				</div>
			</div>

			<div class="form-group" >
				<label class="col-md-3 control-label" for="payment_method">Special Note:</label>
				<div class="col-md-9">
					<textarea name="note" id="note" class="form-control"></textarea>

				</div>
				<?php //echo form_error("sex");?>
			</div>
			<div class="form-group" >
				<label class="col-md-3 control-label" for="payment_method"></label>
				<div class="col-md-9">
					<input type="checkbox" name="sendmail" value="1" checked=""> Send email automatically. <br />
					<input type="checkbox" name="copy_me" value="1" > Send copy of email to me. 

				</div>
				<?php //echo form_error("sex");?>
			</div>
			<div class="row mb-lg">
				<div class="col-sm-9 col-sm-offset-3">
					<input type="hidden" name="project" value="<?php echo $this->input->get("project")??0;?>">
					<input type="hidden" value="<?php echo $result->order_id;?>" name="invoice_id">
					<input type="submit" value="Submit" name="submit" class="btn btn-primary">
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>

		</form>

	</div>

<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>