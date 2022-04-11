<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/trumbowyg.min.css">
<script src="<?php echo base_url("");?>assets/javascripts/trumbowyg.js"></script>
<script type="text/javascript">


  $(document).ready(function(){
    $('#details123').trumbowyg();
  });
</script>


	<div class="row">
		<div class="col-sm-9 mt-md">
			<div class="panel-body">
				<div class="invoice">


					<header class="clearfix">
						<div class="row">
							<div class="col-sm-6 mt-md">
								<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">QUOTE</h2>
								<h4 class="h4 m-none text-dark text-weight-bold">#<?php echo $result->quote_number; ?>
								</h4>
							</div>
							<div class="col-sm-6 text-right mt-md mb-md">
								<address class="ib mr-xlg">
									<?php echo $company->company_name;?>
									<br />
									<?php echo $company->address;?>
									<br />
									Phone: <?php echo $company->phone;?>
									<br />
									<?php echo $company->email;?>

									<?php 
									if($company->chk_field3 == 1 && $company->license_no != ''){
										echo '<br/>';
										echo $company->license_no_label == ''?'License No.':$company->license_no_label.': '.$company->license_no;
									} ?>
								</address>
								<div class="ib">
									<?php if(file_exists("./assets/uploads/users/thumb/".$company->thumbnail) && $company->thumbnail != ""){ ?>
									<img src="<?php echo SITE_URL."assets/uploads/users/thumb/".$company->thumbnail;?>"
										alt="OKLER Themes" />
									<?php } ?>
								</div>
							</div>
						</div>
					</header>

					<div class="bill-info">
						<div class="row">
							<div class="col-md-6">
								<div class="bill-to">
									<p class="h5 mb-xs text-dark text-weight-semibold">Attn:</p>
									<address>
										<?php echo $cutomer->first_name;?> <?php echo $cutomer->last_name;?>
										<br />

										<?php 
											echo $cutomer->address.'<br/>';
										?>
										Phone: <?php echo $cutomer->mobile;?>
										<br />
										<?php echo $cutomer->email;?>
									</address>
								</div>
							</div>
							<div class="col-md-6">
								<div class="bill-data text-right">
									<p class="mb-none">
										<span class="text-dark">Quote Date:</span>
										<span class="value"><?php echo date("d/m/Y",$result->added_date);?></span>
									</p>
									<p class="mb-none">
										<span class="text-dark">Quote expiry date :</span>
										<span class="value"><?php echo date("d/m/Y",$result->expiry_date);?></span>
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
									<p><span class="h5 mb-xs text-dark text-weight-semibold">Nature of Project:</span>
										<?php echo $result->product;?> </p>

								</div>
							</div>

						</div>


					</div>

					<div class="table-responsive">
						<table class="table invoice-items">
							<thead>

								<tr>

									<td colspan="6"><strong>Project Features: </strong></td>

								</tr>
								<tr>
									<td>&nbsp;</td>
									<td colspan="5"><?php echo $result->description;?></td>

								</tr>

							</thead>

							<tbody>
								<tr>

									<td colspan="2"><strong>Descriptions: </strong></td>
									<td colspan="2"><strong>Quantity: </strong></td>
									<td><strong>Price: (<?php echo @$account_setting->currency_code;?>)</strong></td>
									<td><strong>Total: (<?php echo @$account_setting->currency_code;?>)</strong></td>

								</tr>
								<?php
								foreach ($quote_inverters as $row ) {
									?>
								<tr>
									<td colspan="2">
										<?php echo $row->descriptions;?></br>
										<span
											style="font-size:10px;"><?php if($row->short_desc != "") echo '('.$row->short_desc.')'; ?></span>
									</td>
									<td colspan="2"><?php echo $row->quantity;?></td>
									<td><?php echo number_format($row->price, 2);?></td>
									<td><?php echo number_format($row->amount, 2);?></td>

								</tr>
								<?php } ?>

								<tr>
									<td colspan="6" style="text-align:right;"><strong>Regular Price:</strong>
										<?php echo number_format($result->price, 2);?>(<?php echo @$account_setting->currency_code;?>)
									</td>
								</tr>
								<?php if($result->discount > 0){?>
								<tr>
									<td colspan="6" style="text-align:right;"><strong>Discount :
										</strong><?php echo $result->is_flat > 0 ? $result->discount : number_format($result->discount,2);?>
										<?php if($result->is_flat > 0) echo '%'; else echo '('.@$account_setting->currency_code.')'; ?>
									</td>
								</tr>
								<?php } ?>

								<?php
									if($result->is_included == 1){
										$subtotal = $result->total_price - $result->gst;
									}else{
										$subtotal = $result->total_price;
									}

									?>
								<tr>
									<td colspan="6" style="text-align:right;"><strong>Sub Total :
										</strong><?php echo number_format($subtotal,2);?>(<?php echo @$account_setting->currency_code;?>)
									</td>
								</tr>
								<?php if($result->gst_applicable == 1){ ?>
								<tr>
									<td colspan="6" style="text-align:right;">
										<strong><?php echo $result->is_included == 1 ? '':'Including'; ?>
											<?php echo @$account_setting->gst_title;?>:
										</strong><?php echo number_format($result->gst,2);?>
										(<?php echo @$account_setting->currency_code;?>)</td>
								</tr>
								<?php }else{
										?>
								<tr>
									<td colspan="6" style="text-align:right;"><strong>
											<?php echo @$account_setting->gst_title;?>: </strong>: </strong> - </td>
								</tr>
								<?php

									} ?>
								<tr>
									<td colspan="6" style="text-align:right;"><strong>Total Price:
										</strong><?php echo number_format($result->total_price,2);?>
										(<?php echo @$account_setting->currency_code;?>)</td>
								</tr>

								<?php if($result->finance_option == '1'){ ?>
								<tr>

									<td colspan="6" style="text-align:right;">
										<strong>Payment Terms:
										</strong><?php echo $result->payment_term; if($result->payment_term == '1') echo ' month'; else echo ' months';?>
									</td>
								</tr>

								<tr>
									<td colspan="6" style="text-align:right;">
										<strong>Repayment/Month:
										</strong><?php echo $result->total_price/$result->payment_term;?>
										(<?php echo @$account_setting->currency_code;?>)
									</td>
								</tr>

								<?php 
								}
								?>

								<?php if($result->chk_timeline == 0){?>
								<tr>
									<td colspan="6"><strong>Timeline: </strong><?php echo @$timeline->name;?></td>
								</tr>
								<?php }  ?>
								<?php if($result->chk_test == 0){?>
								<tr>
									<td colspan="6">
										<?php echo $company->project_test_label == ''?'Project Testing':$company->project_test_label; ?>
										: <?php echo $result->testing;?></td>
								</tr>
								<?php } ?>
								<?php if($result->chk_payment == 0){?>
								<tr>
									<td colspan="6">
										<strong><?php echo $company->payment_term_label == ''?'Payment Terms':$company->payment_term_label; ?>:
										</strong><?php echo $result->payment_terms;?></td>
								</tr>
								<?php } ?>
								<?php if($result->note != ""){?>
								<tr>
									<td colspan="6" style="color:red;"><strong>Note:
										</strong><?php echo $result->note;?></td>
								</tr>
								<?php } ?>
								<tr>
									<td colspan="6">
										<strong>
											Thank you for the opportunity to quote on the above project
										</strong>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>

				<div class="text-right mr-lg">
					<a href="<?php echo base_url("quote/download_quote/".$result->quote_id);?>"
						class="btn btn-default">Download Quote</a>
					<a href="<?php echo base_url("quote/mail_preview/".$result->quote_id);?>?tab=1"
						class="link_email simple-ajax-popup123 btn btn-default ">Submit Quote</a>
					<a href="<?php echo base_url("quote/print_report/".$result->quote_id);?>" target="_blank"
						class="btn btn-primary ml-sm"><i class="fa fa-print"></i> Print</a>
				</div>
			</div>
		</div>

		<div class="col-sm-3 mt-md">
			<form name="form_comment" id="form_comment" method="post" action="<?php echo current_url();?>">
				<div class="table-responsive">
					<table class="table invoice-items">
						<thead>
							<tr>
								<td><strong>Add Comment: </strong></td>
							</tr>
						</thead>
						<tbody>
							<tr>

								<td>
									<textarea name="comment" class="form-control required"></textarea>
								</td>

							</tr>
							<tr>

								<td>
									<input type="submit" name="submit" value="submit"
										class="mb-xs mt-xs mr-xs btn btn-success">
								</td>

							</tr>
						</tbody>
					</table>

					<table class="table invoice-items">
						<thead>
							<tr>
								<td><strong>Comments(<?php echo count($comments);?>): </strong></td>
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach ($comments as $row) {
								?>
							<tr>
								<td>
									<?php if($row->from_id == $result->company_id){?>
									<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown" style="background: #FFF;
										border-radius: 50%;
										box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.3);
										display: inline-block;
										height: 30px;
										position: relative;
										width: 30px;
										color:#ffffff;

										padding-top: 3px;
										text-align: center;font-weight:bold; background:#0088cc">
										A <span class="badge"></span>
									</a>
									<?php 
								}else{
									?>
									<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown" style="background: #FFF;
									border-radius: 50%;
									box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.3);
									display: inline-block;
									height: 30px;
									position: relative;
									width: 30px;
									color:#ffffff;

									padding-top: 3px;
									text-align: center;font-weight:bold; background:#47a447">
										C <span class="badge"></span>
									</a>
									<?php
							} 
							?>

									<?php echo $row->comment; ?>
								</td>

							</tr>
							<?php
				}?>


						</tbody>
					</table>
				</div>
			</form>
		</div>

	</div>

</section>
</div>
</section>