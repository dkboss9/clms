

<?php 
if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
  ?>
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>We must tell you! </strong> Please select company to add this data.
  </div>
  <?php
}
?>
<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
          <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title"> Payment receipts : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("payment_receipts/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
		
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table invoice-items">
					<thead>
						<tr class="h4 text-dark" >
							<th id="cell-item" class="text-weight-semibold" colspan="4">Payment Info</th>
						</tr>
						<tr class="h4 text-dark">
							<th id="cell-item" class="text-weight-semibold">Received Date</th>
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
								<td><?php echo date("d/m/Y",strtotime($row->received_on));?></td>
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
					<input type="text" class="form-control " value="" name="paid" id="paid" required>
				</div>
			</div>

			<div class="form-group" >
				<label class="col-md-3 control-label" for="payment_method">Payment Method:</label>
				<div class="col-md-6">
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



		

			<div class="form-group">
				<label class="col-md-3 control-label" for="price">Bank account no</label>
				<div class="col-md-6">
					<input type="text" name="account_no" class="form-control" value="">
				</div>
			</div>

			<div class="form-group" >
				<label class="col-md-3 control-label" for="payment_method">Receipted by:</label>
				<div class="col-md-6">
					<select name="staff_id" class="form-control" data-plugin-selectTwo required>
                    <option value="">Select</option>
                    <?php 
					foreach ($employees as $row) {
						?>
						<option value="<?php echo $row->id;?>" ><?php echo $row->first_name.' '.$row->last_name;?></option>
						<?php
					}
					?>
					</select>
				</div>
				<?php //echo form_error("sex");?>
            </div>
            
            <div class="form-group">
				<label class="col-md-3 control-label" for="price">Rreceived on</label>
				<div class="col-md-6">
					<input type="text" name="received_date" class="form-control datepicker" value="" required>
				</div>
			</div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
                <input type="hidden" name="invoice_id" value="<?php echo $result->order_id;?>">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("payment_receipts");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
            </div>
          </div>
        </form>
      </div>
    </section>
  </div>
</div>
<!-- end: page -->
</section>
</div>
</section>

<script>
    $(document).ready(function(){
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            
        });
    });
</script>