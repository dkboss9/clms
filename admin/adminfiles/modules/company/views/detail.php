
<?php
$companies = $this->companymodel->getdata(42)->row();

?>
<section role="main" class="content-body">
	<header class="page-header">
		<h2>Effective Lead Management System</h2>
		<div class="right-wrapper pull-right">
			<a class="sidebar-right-toggle" href="<?php echo base_url("logout");?>"><i class="fa fa-power-off"></i></a>
		</div>

	</header>

	 <?php if($this->session->flashdata("success_message")){?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
      </div>
      <?php
    }
    ?>

	<!-- start: page -->

	<section class="panel">
		<div class="panel-body">
			<div class="invoice">
				<header class="clearfix">
					<div class="row">
						<div class="col-sm-6 mt-md">
							<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">INVOICE</h2>
							<h4 class="h4 m-none text-dark text-weight-bold">#<?php echo $result->userid;?></h4>
						</div>
						<div class="col-sm-6 text-right mt-md mb-md">
							<address class="ib mr-xlg">
								<?php echo $companies->company_name;?>
								<br>
								<?php echo $companies->address;?>
								<br>
								Phone: <?php echo $companies->phone;?>
								<br>
								<?php echo $companies->email;?>
							</address>
							<div class="ib">
								<?php if($companies->thumbnail != "" && file_exists("../assets/uploads/users/thumb/".$companies->thumbnail)) echo '<img src="'.SITE_URL."assets/uploads/users/thumb/".$companies->thumbnail.'" >';?>
							</div>
						</div>
					</div>
				</header>
				<div class="bill-info">
					<div class="row">
						<div class="col-md-6">
							<div class="bill-to">
								<p class="h5 mb-xs text-dark text-weight-semibold">To:</p>
								<address>
									<?php echo $result->company_name;?>
									<br>
									<?php echo $result->address;?>
									<br>
									Phone: <?php echo $result->phone;?>
									<br>
									<?php echo $result->email;?>
								</address>
							</div>
						</div>
						<div class="col-md-6">
							<div class="bill-data text-right">
								<p class="mb-none">
									<span class="text-dark">Invoice Date:</span>
									<span class="value"><?php echo date("d/m/Y",$result->join_date);?></span>
								</p>
								<p class="mb-none">
									<span class="text-dark">Due Date:</span>
									<span class="value"><?php echo date("d/m/Y",$result->expiry_date);?></span>
								</p>
							</div>
						</div>
					</div>
				</div>
				<?php 
    /// echo $result->invoice_id;
				$projects = $this->companymodel->getinvoiceDetails($result->userid);

				if(isset($projects)){ ?>
				<div class="table-responsive">
					<table class="table invoice-items">
						<thead>
							<tr class="h4 text-dark">
								<th id="cell-id" class="text-weight-semibold">#</th>
								<th id="cell-item" class="text-weight-semibold">Item</th>
								<th id="cell-desc" class="text-weight-semibold">Description</th>
								<th id="cell-price" class="text-center text-weight-semibold">Price</th>
								<th id="cell-qty" class="text-center text-weight-semibold">Quantity</th>
								<th id="cell-total" class="text-center text-weight-semibold">Total</th>
							</tr>
						</thead>
						<tbody>
							<?php 

							foreach ($projects as $row) {
								?>
								<tr>
									<td> <?php echo $row->package_id;?></td>
									<td class="text-weight-semibold text-dark"><?php echo $row->package_name;?></td>
									<td><?php echo $row->details;?></td>
									<td class="text-center"><?php echo $row->unit_price;?></td>
									<td class="text-center"><?php echo $row->qty;?></td>
									<td class="text-center"><?php echo $row->total_price;?></td>
								</tr>
								<?php
							}

							?>
							
						</tbody>
					</table>
				</div>
				<?php } ?>
				<div class="invoice-summary">
					<div class="row">
						<div class="col-sm-4">
							<?php if($result->invoice_status == "Paid"){?>
							<span style="color: green;font-size: 30px;padding: 50px;">PAID</span>
							<?php } ?>

							<?php if($result->invoice_status == "Due"){?>
							<span style="color: red;font-size: 30px;padding: 50px;">DUE</span>
							<?php } ?>
						</div>
						<div class="col-sm-4 col-sm-offset-8">

							<table class="table h5 text-dark">
								<tbody>
									<tr class="b-top-none">
										<td colspan="2">Subtotal</td>
										<td class="text-left">$<?php echo $result->total;?></td>
									</tr>
									<tr>
										<td colspan="2">Shipping</td>
										<td class="text-left">$<?php echo $result->shipping;?></td>
									</tr>
									<tr class="h4">
										<td colspan="2">Grand Total</td>
										<td class="text-left">$<?php echo $result->grand_total;?></td>
									</tr>
									<tr class="h4">
										<td colspan="2">Including GST of</td>
										<td class="text-left">$<?php echo round(($result->grand_total/11),2);?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				
				<address class="ib mr-xlg">
					Thank you for your Business with us. </br>
					<?php echo $companies->company_name;?>
					<br>
					<?php echo $companies->address;?>
					<br>
					Phone: <?php echo $companies->phone;?>
					<br>
					<?php echo $companies->email;?>
				</address>
				<address class="ib mr-xlg">
					<?php echo $result->note;?>
				</address>
				
			</div>

			<div class="text-right mr-lg">
				<a href="<?php echo base_url("company");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
				<a href="<?php echo base_url("company/print_report/".$result->userid);?>" target="_blank" class="btn btn-primary ml-sm"><i class="fa fa-print"></i> Print</a>
				<a href="<?php echo base_url("company/send_email/".$result->userid);?>" class="btn btn-primary ml-sm"><i class="fa fa-mail-forward"></i> Send Email</a>
			</div>
		</div>
	</section>

	<!-- end: page -->
</section>