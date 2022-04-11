	<table border="0" width="100%" style="border-collapse: collapse;">
		<tr>
			<td colspan="2" style="">
				<h2>Quote No: #<?php echo $result->quote_number; ?></h2>
			</td>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align:right;font-size:14px;">
				<?php if(file_exists("../assets/uploads/users/thumb/".$company->thumbnail) && $company->thumbnail != ""){ ?>
				<img src="<?php echo "/home2/x9z5w2g0/public_html/www.thokyo.com/assets/uploads/users/thumb/".$company->thumbnail;?>"
					alt="<?php echo $company->company_name;?>" />
				<?php } ?><br />
				<?php echo $company->company_name;?>
				<br />
				<?php echo $company->address;?>
				<br />
				<?php if($company->phone != ""){ ?>
				Phone: <?php echo $company->phone;?>
				<br />
				<?php } ?>
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
				<br />
			
				<?php 
				
					echo @$cutomer->address;
				?>
				<br>
				<?php 
				if($cutomer->mobile!="")
				{
					?>
				<strong>Phone:</strong> <?php echo $cutomer->mobile;?>
				<br />
				<?php 
				}
				// if($cutomer->hide_email == '0')
					echo '<strong>Email:</strong> '.$cutomer->email;
				?>
			</td>
			<td colspan="3" style="text-align:right;font-size:14px;">
				<?php 
				if($company->display_abn == '1')
					echo '<strong>'.@$account_setting->abn_title.':</strong> '.$company->abn;
				?>
				<br />
				<br />
				<br />
				<strong>Date:</strong> <?php echo date("d/m/Y",$result->added_date);?>
				<br />
				<span style="color:red;"><strong>Quote Valid until:</strong>
					<?php echo date("d/m/Y",$result->expiry_date);?></span>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				&nbsp;
				<br />
				&nbsp;
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
			<td colspan="4">
				<strong>Nature of Project:</strong> <?php echo $result->product;?>
			</td>
		</tr>
		<!-- <tr>
			<td >
				&nbsp;
			</td>
			<td colspan="4">
				<strong>Package Type:</strong><?php echo $package->name;?>
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
			<td colspan="2" style="font-weight:bold;background: #35a6da;color:#ffffff;">
				Description
			</td>
			<td style="font-weight:bold;background: #35a6da;color:#ffffff;">
				Quantity
			</td>
			<td style="font-weight:bold;background: #35a6da;color:#ffffff;">
				Price (<?php echo @$account_setting->currency_code;?>)
			</td>
			<td style="font-weight:bold;background: #35a6da;color:#ffffff;">
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
			<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;">
				<?php echo number_format($row->amount,2);?></td>

		</tr>
		<?php } ?>







		<tr>

			<td colspan="5" style="text-align:right;font-size:12px;">
				<p><span style="border-bottom:1px dotted #0000000;">Regular Price:
						<?php echo number_format($result->price,2);?> (<?php echo @$account_setting->currency_code;?>)
					</span></p>
				<?php
					if($result->discount > 0){
						?>
				<p><span style="border-bottom:1px dotted #0000000;">Discount:
						<?php echo $result->is_flat > 0 ? $result->discount : number_format($result->discount,2);?><?php if($result->is_flat > 0) echo '%'; else echo '('.@$account_setting->currency_code.')'; ?></span>
				</p>
				<?php
					}
					?>
				<?php
					if($result->is_included == 1){
						$subtotal = $result->total_price - $result->gst;
					}else{
						$subtotal = $result->total_price;
					}

					?>
				<p><span style="border-bottom:1px dotted #0000000;">Sub Total:
						<?php echo number_format($subtotal,2);?>(<?php echo @$account_setting->currency_code;?>) </span>
				</p>
				<?php if($result->gst_applicable == 1){ ?>
				<p><span style="border-bottom:1px dotted #0000000;"><?php echo $result->is_included == 1 ? '':'Including'; ?>
						<?php echo @$account_setting->gst_title;?>: <?php echo number_format($result->gst,2);?>
						(<?php echo @$account_setting->currency_code;?>)</span></p>
				<?php }else{
						?>
				<p><span style="border-bottom:1px dotted #0000000;"> <?php echo @$account_setting->gst_title;?>: - </span>
				</p>
				<?php
					} ?>
				<p><span style="border-bottom:1px dotted #0000000;">Total Price:
						<?php echo number_format($result->total_price,2);?>
						(<?php echo @$account_setting->currency_code;?>)</span></p>
				<?php if($result->finance_option == '1'){ ?>
				<p><span style="border-bottom:1px dotted #0000000;">Payment Terms:
						<?php echo $result->payment_term; if($result->payment_term == '1') echo ' month'; else echo ' months';?>
					</span></p>
				<p><span style="border-bottom:1px dotted #0000000;">Repayment/Month:
						<?php echo $result->total_price/$result->payment_term;?>
						(<?php echo @$account_setting->currency_code;?>)</span></p>
				<?php } ?>
			</td>
		</tr>




		<?php if($result->chk_timeline == 0){?>
		<tr>
			<td><strong>Timeline:</strong></td>
			<td colspan="4">
				<?php echo $timeline->name;?>
			</td>
		</tr>
		<?php }  ?>

		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<?php if($result->chk_test == 0){?>
		<tr>

			<td colspan="5">
				<strong> Project Testing: </strong> <?php echo $result->testing;?>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<?php if($result->chk_payment == 0){?>
		<tr>

			<td colspan="5">
				<strong>Payment Terms: </strong><?php echo $result->payment_terms;?>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<?php if($result->note != ""){?>
		<tr>

			<td colspan="5" style="color:red;">
				<strong>Note: </strong><?php echo $result->note;?>
			</td>
		</tr>
		<?php } ?>

		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5">
				<br />
				Kind Regards <br />
				<br />
				Bivek Chhetri
			</td>
		</tr>

		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5"
				style="text-align:center;font-style:italic;border_top:1px dotted #000000;border_bottom:1px dotted #000000;">
				<strong>
					Thank you for the opportunity to quote on the above project
				</strong>
			</td>
		</tr>

	</table>