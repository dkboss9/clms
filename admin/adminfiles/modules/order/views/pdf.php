	<table border="0" width="100%"  style="border-collapse: collapse;">
		<tr>
			<td colspan="2" >
				<h2>Order Confirmation : #<?php echo $result->order_number; ?></h2>
				
			</td>
			<td >&nbsp;</td>
			<td colspan="2" style="text-align:right;font-size:14px;">
				<?php if(file_exists("../assets/uploads/users/thumb/".$company->thumbnail) && $company->thumbnail != ""){ ?>
				<img src="<?php echo "/home2/x9z5w2g0/public_html/www.thokyo.com/assets/uploads/users/thumb/".$company->thumbnail;?>" alt="OKLER Themes" />
				<?php } ?><br/>
				<?php echo $company->company_name;?>
				<br/>
				<?php echo $company->mail_to_address;?>
				<br/>
				<?php if($company->phone != "") { 
					echo $company->phone;
					echo '<br/>';
				}         
				?>
				<?php echo $company->email;?>
				<?php 
				if($company->chk_field3 == 1 && $company->license_no != ''){
					echo '<br/>';
					echo $company->license_no_label == ''?'License No.':$company->license_no_label.': '.$company->license_no;
				} ?>
			</td>
		</tr>

		<?php
		$package = $this->quotemodel->getpackage($result->package);
		$timeline = $this->quotemodel->gettimeline($result->timeline);
		?>
		
		<tr>
			<td colspan="2" style="font-size:15px;">
				
				
				<strong>Attn:</strong> <?php echo $cutomer->first_name;?> <?php echo $cutomer->last_name;?>
				<br/>
			
				<?php if($cutomer->mobile != "") { ?>
				<strong>Phone:</strong> <?php echo $cutomer->mobile;?>
				<br/>
				<?php } ?>
				<?php 
				// if($cutomer->hide_email == '0')
					echo '<strong>Email:</strong> '.$cutomer->email;
				?>

				
				
			</td>
			<td colspan="3" style="text-align:right;font-size:14px;">
				
				<?php 
				if($company->display_abn == '1')
					echo '<strong>'.@$account_setting->abn_title.':</strong> '.$company->abn;
				?>
				<br/>
				<br/>
				<br/>
				<strong>Order Date:</strong> <?php echo date("d/m/Y",$result->added_date);?>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				&nbsp;
				<br/>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="5">
				<strong>Nature of Project:</strong> <?php echo $result->product;?>
			</td>
		</tr>
		<!-- <tr>
			<td colspan="5">
				<strong>Package Type:</strong> <?php echo $package->name;?>
			</td>
		</tr> -->

		<tr>
			<td colspan="5">
				&nbsp;
			</td>
		</tr>

		<tr>
			<td colspan="5">
				<strong>Project Features: </strong>
			</td>
		</tr>

		<tr>
			<td>
				&nbsp;
			</td>
			<td colspan="4">
				<?php echo $result->description;?>
			</td>
		</tr>

		<tr>
			<td colspan="5">
				&nbsp;
			</td>
		</tr>


		<tr>
			<td colspan="2" style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Description
			</td>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Quantity
			</td>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Price (<?php echo @$account_setting->currency_code;?>)
			</td>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Total (<?php echo @$account_setting->currency_code;?>)
			</td>
		</tr>
		
		<?php
		foreach ($quote_inverters as $row ) {
			?>
			<tr>
				<td colspan="2" style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
					<?php echo $row->descriptions;?>
					<p style="font-size:10px;"><?php if($row->short_desc != "") echo '('.$row->short_desc.')'; ?></p>
				</td>
				<td style="border-bottom:1px solid #000000;"><?php echo $row->quantity;?></td>
				<td style="border-bottom:1px solid #000000;"><?php echo number_format($row->price,2);?></td>
				<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;"><?php echo number_format($row->amount,2);?></td>

			</tr>
			<?php } ?>

			<tr  >
				<td style="border-top:1px solid #000000;" colspan="5">&nbsp;</td>
			</tr>



			<tr>
				<td colspan="3" style="width:50%;font-size:12px;" >
					<p><strong>Payment's Accepted</strong></p>
					<table>
						<?php if($company->chk_credit_phone =="1"){ ?>
						<tr>
							<td><img src="<?php echo '/home2/x9z5w2g0/public_html/www.thokyo.com/assets/images/visa.jpg'?>" ></td>
							<td>
								<strong>Phone</strong><br>
								Call: <span ><?php echo $company->pay_via_phone;?></span>
							</td>
						</tr>
						<?php 
					}
					?>
					<?php if($company->chk_credit_online =="1"){ ?>
					<tr>
						<td><img src="<?php echo '/home2/x9z5w2g0/public_html/www.thokyo.com/assets/images/master.jpg'?>" ></td>
						<td>
							<strong>Web</strong><br>
							Visit: <?php echo $company->pay_via_online;?>
						</td>
					</tr>
					<?php } ?>
					<?php if($company->chk_bank == 1) { ?>
					<tr>
						<td><img src="<?php echo '/home2/x9z5w2g0/public_html/www.thokyo.com/assets/images/bank_transfer.jpg'?>" ></td>
						<td>
							<strong> <?php echo $company->bank;?></strong><br>
							BSB: <?php echo $company->bsb;?> <br>
							Account Number: <?php echo $company->account_no;?>
						</td>
					</tr>
					<?php } ?>
					<?php if($company->chk_post == 1) { ?>
					<tr>
						<td><img src="<?php echo '/home2/x9z5w2g0/public_html/www.thokyo.com/assets/images/cheque.jpg'?>" ></td>
						<td>
							<strong> Mail to</strong><br>
							<?php echo $company->mail_to;?><br>
							<?php echo $company->mail_to_address;?>
						</td>
					</tr>
					<?php } ?>

					<?php if($company->chk_credit_paypal == 1) { ?>
					<tr>
						<td><img src="<?php echo '/home2/x9z5w2g0/public_html/www.thokyo.com/assets/images/paypal.jpg'?>" ></td>
						<td>
							<strong>Paypal </strong><br>
							<?php echo $company->cc_via_paypal;?>
						</td>
					</tr>
					<?php } ?>
				</table>
			</td>
			<td  colspan="2" style="text-align:right;font-size:12px;">
				<p ><span style="border-bottom:1px dotted #0000000;">Regular Price: <?php echo number_format($result->qprice,2);?></span></p>
				<?php
				if($result->discount > 0){
					?>
					<p><span style="border-bottom:1px dotted #0000000;">Discount: <?php echo $result->is_flat > 0 ? $result->discount : number_format($result->discount,2);?> <?php if($result->is_flat > 0) echo '%'; else echo '('.@$account_setting->currency_code.')'; ?></span></p>
					<?php
				}
				?>
				<?php
				if($result->is_included == 1){
					$subtotal = $result->price - $result->gst;
				}else{
					$subtotal = $result->price;
				}
				?>
				<p><span style="border-bottom:1px dotted #0000000;">Sub Total: <?php echo number_format($subtotal,2);?></span> </p>
				<?php if($result->gst_applicable == 1){ ?>
				<p><span style="border-bottom:1px dotted #0000000;"><?php echo $result->is_included == 1 ? '':'Including'; ?> <?php echo @$account_setting->gst_title; ?>: <?php echo number_format($result->gst,2);?> </span></p>
				<?php }else{
					?>
					<p><span style="border-bottom:1px dotted #0000000;"> <?php echo @$account_setting->gst_title; ?>: - </span></p>
					<?php
				} ?>
				<p><span style="border-bottom:1px dotted #0000000;">Total Price: <?php echo number_format($result->price,2);?></span></p>
				<p><span style="border-bottom:1px dotted #0000000;">Paid: <?php echo number_format($result->price - $result->due_amount,2);?></span></p>
				<p><span style="border-bottom:1px dotted #0000000;color:red;">Due:	<?php echo number_format($result->due_amount,2);?></span></p>
				<?php if($company->credit_card_charge > 0) 
				echo "<p>(Credit Card payment's will incur a ".$company->credit_card_charge."% surcharge)</p>";
				?>
				<?php if($result->finance_option > 0){?>
				<p style="border:1px solid red;text-align:center;">With Deposit of <?php echo number_format($result->price/$result->payment_term,2); ?> will go over <?php echo $result->payment_term;?> months.</p>
				<?php } ?>
				<p>If you are making a Bank Transfer, please ensure you have put your invoice number as the title or reference for the transaction.
				</p>
				<?php if($result->minimum_deposit > 0 && $result->price - $result->due_amount == 0){ ?>
				<p>A minimum deposit of <?php echo $result->minimum_deposit;?>% (<?php echo number_format(($result->price * $result->minimum_deposit)/100,2); ?>) is required to proceed with this invoice.
				</p>
				<?php } ?>

			</td>
		</tr>


		<tr>
			<td colspan="5">
				&nbsp;
			</td>
		</tr>

		<?php if($result->chk_timeline == 0){?>
		<tr>
			<td colspan="5"><strong>Timeline: </strong><?php echo $timeline->name;?></td>
		</tr>
		<tr>
			<td colspan="5">
				&nbsp;
			</td>
		</tr>
		<?php }  ?>
		<?php if($result->chk_test == 0 && $company->chk_field1 == 1){?>
		<tr>
			<td colspan="5"><strong><?php echo $company->project_test_label == ''?'Project Testing':$company->project_test_label; ?>:</strong> <?php echo $result->testing;?></td>
		</tr>
		<tr>
			<td colspan="5">
				&nbsp;
			</td>
		</tr>
		<?php } ?>
		<?php if($result->chk_payment == 0 && $company->chk_field2 == 1){?>
		<tr>
			<td colspan="5"><strong><?php echo $company->payment_term_label == ''?'Payment Terms':$company->payment_term_label; ?>: </strong><?php echo $result->payment_terms;?></td>
		</tr>
		<tr>
			<td colspan="5">
				&nbsp;
			</td>
		</tr>
		<?php } ?>

		<?php if($result->note != ""){?>
		<tr  >

			<td colspan="5" style="color:red;" >
				<strong>Note: </strong><?php echo $result->note;?>
			</td>
		</tr>
		<?php } ?>

		<tr  >

			<td colspan="5" style="text-align:center;border_top:1px dotted #000000;border_bottom:1px dotted #000000;" >
				Thank You 
			</td>
		</tr>
	</table>

