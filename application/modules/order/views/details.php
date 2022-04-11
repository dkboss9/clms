
<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/trumbowyg.min.css">
<script src="<?php echo base_url("");?>assets/javascripts/trumbowyg.js"></script>
<script type="text/javascript">


  $(document).ready(function(){
    $('#details123').trumbowyg();
  });
</script>


 <?php if($this->session->flashdata("success_message")){?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
    </div>
    <?php
  }
  ?>


	<div class="modal fade" id="expiryDate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title" id="exampleModalLabel">Change Expiry Date:</h5>
			
			</div>
			<form method="post" action="<?php echo base_url("order/change_expiry_date");?>" name="form_expiry" id="form_expiry">
			<div class="modal-body">
			
			<div class="row">
					<div class="col-sm-6 mt-md">
						<h6 class="h4 m-none text-dark text-weight-bold">#New Date</h4>
					</div>
					<div class="col-sm-6 mt-md">
						<input type="text" name="expiry_date" class="form-control datepicker required" readonly="" value="<?php //echo date("d/m/Y",strtotime($result->expiry_date));?>">
					</div>
			</div>
			</div>
			<div class="modal-footer" style="margin-top:0;">
				<input type="hidden" name="order_id" value="<?php echo $order_id;?>">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" name="btn-submit" class="btn btn-primary">Save changes</button>
			</div>
			</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Get paid on time by scheduling payment reminders for your customer:</h5>
     
	  </div>
	  <form method="post" action="<?php echo current_url();?>" name="form_reminder" id="form_reminder">
      <div class="modal-body">
	  <table class="table table-bordered table-striped mb-none" >
			<thead>
				<tr>
					<!-- <th style="width:2%;">SN.</th> -->
					<th>Reminder Dates</th>
					<th>Is Sent</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($reminder_dates as $key => $date){
				?>
					<tr class="tr_<?php echo $date->id;?>">
						<!-- <td><?php echo $key+1;?></td> -->
						<td><?php echo date("d-m-Y",strtotime($date->reminder_date));?></td>
						<td><?php echo $date->is_sent == 1 ? 'Sent' : 'Not sent';?></td>
						<td>
							<a class="todo-remove  link_remove " rel="<?php echo $date->id;?>" href="javascript:void(0);" style="font-size: 10px;">
								<span class="glyphicon glyphicon-trash" data-original-title="" title=""></span>
							</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
	  </table>
	  <div class="row">
			<div class="col-sm-6 mt-md">
				<h6 class="h4 m-none text-dark text-weight-bold">#Add Reminder Date</h4>
			</div>
			<div class="col-sm-6 mt-md">
				<input type="text" name="reminder_date" class="form-control datepicker required" readonly="">
			</div>
	  </div>
      </div>
      <div class="modal-footer" style="margin-top:0;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="btn-submit" class="btn btn-primary">Save changes</button>
	  </div>
	  </form>
    </div>
  </div>
</div>
<section class="panel">
	<div class="panel-body">
		<div class="invoice">
			<header class="clearfix">
				<div class="row">
					<div class="col-sm-6 mt-md">
						<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">Invoice</h2>
						<h4 class="h4 m-none text-dark text-weight-bold">#<?php echo $result->order_number; ?></h4>
					</div>
					<div class="col-sm-6 text-right mt-md mb-md">
						<address class="ib mr-xlg">
							<?php echo $company->company_name;?>
							<br/>
							<?php echo $company->address;?>
							<br/>
							Phone: <?php echo $company->phone;?>
							<br/>
							<?php echo $company->email;?>
							<?php 
							if($company->chk_field3 == 1 && $company->license_no != ''){
								echo '<br/>';
								echo $company->license_no_label == ''?'License No.':$company->license_no_label.': '.$company->license_no;
							} ?>
						</address>
						<div class="ib">
							<?php if(file_exists("./assets/uploads/users/thumb/".$company->thumbnail) && $company->thumbnail != ""){ ?>
							<img src="<?php echo SITE_URL."assets/uploads/users/thumb/".$company->thumbnail;?>" alt="OKLER Themes" />
							<?php } ?>
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
								<?php echo $cutomer->first_name;?> <?php echo $cutomer->last_name;?>
								<br/>
								<?php echo $cutomer->address;?>
								<br/>
								Phone: <?php echo $cutomer->mobile;?>
								<br/>
								<?php echo $cutomer->email;?>
							</address>
						</div>
					</div>
					<div class="col-md-6">
						<div class="bill-data text-right">
							<p class="mb-none">
								<span class="text-dark">Order Date:</span>
								<span class="value"><?php echo date("d/m/Y",$result->added_date);?></span>
							</p>

							<p class="mb-none">
								<span class="text-dark">Due Date:</span>
								<span class="value"><?php echo date("d/m/Y",strtotime($result->expiry_date));?></span>
							</p>
							
						</div>
					</div>
				</div>
				<?php
				$package = $this->quotemodel->getpackage($result->package);
				$timeline = $this->quotemodel->gettimeline($result->timeline);
				?>
				<div class="row">
					<div class="col-md-12">
						<div class="bill-to">
							<p ><span class="h5 mb-xs text-dark text-weight-semibold">Nature of Project:</span> <?php echo $result->product;?> </p>
							
						</div>
					</div>
					
				</div>

			<!-- 	<div class="row">
					<div class="col-md-12">
						<div class="bill-to">
							<p ><span class="h5 mb-xs text-dark text-weight-semibold">Package Type:</span> <?php echo $package->name;?> </p>
							
						</div>
					</div>
					
				</div> -->
			</div>
			

			<div class="table-responsive">
				<table class="table invoice-items">
					<thead>
						
						<tr >
							
							<td colspan="6"><strong>Project Features: </strong></td>
							
						</tr>
						<tr >
							<td>&nbsp;</td>
							<td colspan="5"><?php echo $result->description;?></td>
							
						</tr>
						
					</thead>
					
					<tbody>
						<tr>
							<td colspan="2">Description</td>
							<td colspan="2">Quantity</td>
							<td colspan="1">Price (<?php echo @$account_setting->currency_code;?>)</td>
							<td colspan="1">Total (<?php echo @$account_setting->currency_code;?>)</td>
						</tr>
						<?php
						foreach ($quote_inverters as $row ) {
							?>
							<tr>
								<td colspan="2"><?php echo $row->descriptions;?>
									<p style="font-size:10px;"><?php if($row->short_desc != "") echo '('.$row->short_desc.')'; ?></p>
								</td>
								<td colspan="2"><?php echo $row->quantity;?></td>
								<td ><?php echo number_format($row->price,2);?></td>
								<td ><?php echo number_format($row->amount,2);?></td>
							</tr>
							<?php } ?>

							<tr>
								<td colspan="6" style="text-align:right;"><strong>Regular Price:</strong> <?php echo number_format($result->qprice,2);?>(<?php echo @$account_setting->currency_code;?>)</td>
							</tr>
							<?php if($result->discount > 0){ ?>
							<tr>
								<td colspan="6" style="text-align:right;"><strong>Discount : </strong><?php echo $result->is_flat > 0 ? $result->discount : number_format($result->discount,2); ?> <?php if($result->is_flat > 0) echo '%'; else echo '('.@$account_setting->currency_code.')'; ?></td>
							</tr>
							<?php } ?>
							<?php
							if($result->is_included == 1){
								$subtotal = $result->price - $result->gst;
							}else{
								$subtotal = $result->price;
							}
							?>
							<tr>
								<td colspan="6" style="text-align:right;"><strong>Sub Total : </strong><?php echo number_format($subtotal,2);?>(<?php echo @$account_setting->currency_code;?>) </td>
							</tr>
							<?php if($result->gst_applicable == 1){ ?>
							<tr>
								<td colspan="6" style="text-align:right;"><strong><?php echo $result->is_included == 1 ? '':'Including'; ?> <?php echo @$account_setting->gst_title; ?> : </strong><?php echo number_format($result->gst,2);?>(<?php echo @$account_setting->currency_code;?>) </td>
							</tr>
							<?php }else{
								?>
								<tr>
									<td colspan="6" style="text-align:right;"><strong> <?php echo @$account_setting->gst_title; ?> : -</strong> </td>
								</tr>
								<?php
							} 
							?>
							<tr>
								<td colspan="6" style="text-align:right;"><strong>Total Price: </strong><?php echo number_format($result->price,2);?>(<?php echo @$account_setting->currency_code;?>)</td>
							</tr>

							<tr>
								<td colspan="6" style="text-align:right;"><strong>Paid: </strong><?php echo number_format($result->price-$result->due_amount,2);?>(<?php echo @$account_setting->currency_code;?>)</td>
							</tr>

							<tr>
								<td colspan="6" style="text-align:right;"><strong>Due: </strong><?php echo number_format($result->due_amount,2);?>(<?php echo @$account_setting->currency_code;?>)</td>
							</tr>
							<?php if($result->chk_timeline == 0){?>
							<tr>
								<td colspan="6"><strong>Timeline: </strong><?php echo $timeline->name;?></td>
							</tr>
							<?php }  ?>
							<?php if($result->chk_test == 0 && $company->chk_field1 == 1){?>
							<tr>
								<td colspan="6"><strong><?php echo $company->project_test_label == ''?'Project Testing':$company->project_test_label; ?>:</strong> <?php echo $result->testing;?></td>
							</tr>
							<?php } ?>
							<?php if($result->chk_payment == 0 && $company->chk_field2 == 1){?>
							<tr>
								<td colspan="6"><strong><?php echo $company->payment_term_label == ''?'Payment Terms':$company->payment_term_label; ?>: </strong><?php echo $result->payment_terms;?></td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan="6" style="color:red;"><strong>Note: </strong><?php echo $result->note;?></td>
							</tr>

							
						</tbody>
					</table>
				</div>


			</div>

			<div class="text-right mr-lg">
			
				<a href="<?php echo base_url("order/preview_order/".$result->order_id."?project=".$this->input->get("project")??0);?>" class="btn btn-default">Download Invoice</a>
				<a href="<?php echo base_url("order/print_invoice/".$result->order_id."?project=".$this->input->get("project")??0);?>" target="_blank" class="btn btn-primary ml-sm"><i class="fa fa-print"></i> Print</a>
			</div>
		</div>
	</section>
	<script type="text/javascript">
		$( function() {
			$("#form_expiry").validate();
			$("#form_reminder").validate();
			$( ".datepicker" ).datepicker({ format: 'dd/mm/yyyy' });

			$(".link_remove").click(function(){
				if(!confirm("Are you sure to delete this reminder data?"))
					return false;

				var id = $(this).attr("rel");
				

				$.ajax({
					url: '<?php echo base_url() ?>order/remove_reminder_date',
					type: "POST",
					data: "reminder_id=" + id,
					success: function(data) { 
						$(".tr_"+id).remove();
					}        
				});
			});
		});
	</script>
