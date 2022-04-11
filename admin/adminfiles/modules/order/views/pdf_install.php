<table border="0" width="100%"  style="border-collapse: collapse;">
		<tr>
			<td colspan="2" >
				<h2>Job Assignment</h2>
				
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
				<?php if($company->phone != ""){
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

		<tr>
			<td colspan="2" style="font-size:15px;">
				<strong>Attn:</strong> <?php echo $installer->first_name.' '.$installer->last_name;?>
				<br/>
				<strong>Position:</strong> <?php echo $installer->position_type;?>
				<br/>
				<?php if($installer->company != ""){
					?>
					<strong>Company Name:</strong> <?php echo $installer->company;?>
					<br/>
					<?php
				}
				?>
				<?php if($installer->phone != ""){ ?>
				<strong>Phone:</strong> <?php echo $installer->phone;?>
				<br/>
				<?php } ?>
				<?php 
				echo '<strong>Email:</strong> '.$installer->email;
				?>

				<?php 
				if($installer->abn != '')
					echo '<br><strong>'.@$customer_account_setting->abn_title.':</strong> '.$installer->abn.'<br>';
				?>
				<strong>Address:</strong> <?php echo $installer->address.', '.$installer->suburb.', '.$installer->postcode;?>
			</td>
			<td colspan="3" style="text-align:right;font-size:14px;">

				<?php 
				if($company->display_abn == '1')
					echo '<strong>'.@$account_setting->abn_title.':</strong> '.$company->abn;
				?>
				<br/>
				<br/>
				<br/>
				<strong>Install Date:</strong> <?php echo date("D, d/m/Y",strtotime($INSTALL_DATE)); ?>
				<br/>
				<strong>Install Time:</strong> <?php echo $INSTALL_TIME; ?>
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

		<tr>
			<td colspan="5">
				&nbsp;
				<br/>
				&nbsp;
			</td>
		</tr>

		<tr>
			<td colspan="2" style="font-size:15px;">
				
				
				<strong>Customer name:</strong> <?php echo $cutomer->customer_name;?>
				<br/>
				<?php if($cutomer->company_name != ""){
					?>
					<strong>Company Name:</strong> <?php echo $cutomer->company_name;?>
					<br/>
					<?php
				}
				?>
				<?php if($cutomer->contact_number != "") { ?>
				<strong>Phone:</strong> <?php echo $cutomer->contact_number;?>
				<br/>
				<?php } ?>
				<?php 
				if($cutomer->hide_email == '0')
					echo '<strong>Email:</strong> '.$cutomer->email;
				?>

				<?php 
				if($cutomer->abn != '')
					echo '<br><strong>'.@$customer_account_setting->abn_title.':</strong> '.$cutomer->abn;
				?>

				<?php 
				echo '<br><strong>'.@$cutomer->delivery_address1.', '.$cutomer->delivery_suburb;
				?>
				
				
			</td>
			<td colspan="3" style="text-align:right;font-size:14px;">
				
				
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
			<td colspan="5" style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Description
			</td>
			
		</tr>
		
		<?php
		if(!empty($quote_inverters)){
			foreach ($quote_inverters as $row ) {
				?>
				<tr>
					<td colspan="5" style="border-left:1px solid #000000;border-bottom:1px solid #000000;border-right:1px solid #000000;">
						<?php echo $row->descriptions;?>
						<p style="font-size:10px;"><?php if($row->short_desc != "") echo '('.$row->short_desc.')'; ?></p>
					</td>
				</tr>
				<?php }} ?>

				<tr  >
					<td style="border-top:1px solid #000000;" colspan="5">&nbsp;</td>
				</tr>

				<tr>
					<td colspan="5">
						&nbsp;
						<br/>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td colspan="1" style="font-weight:bold;background:#35a6da;color:#ffffff;">
						Title
					</td>

					<td colspan="4" style="font-weight:bold;background:#35a6da;color:#ffffff;">
						Value
					</td>
				</tr>

				<tr>
					<td colspan="1" style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
						Job Type:
					</td>
					<td colspan="4" style="border-right:1px solid #000000;border-bottom:1px solid #000000;">
						<?php echo $INSTALL_TYPE; ?>
					</td>
				</tr>

				<tr>
					<td colspan="1" style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
						Allocated By:
					</td>
					<td colspan="4" style="border-right:1px solid #000000;border-bottom:1px solid #000000;">
						<?php echo $ALLOCATE_BY; ?>
					</td>
				</tr>
				<tr>
					<td colspan="1" style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
						Payment Method:
					</td>
					<td colspan="4" style="border-right:1px solid #000000;border-bottom:1px solid #000000;">
						<?php echo $installation['payment_method']; ?>
					</td>
				</tr>
				<?php 
				if($installation['time_allocate_by'] == 'Employer'){ 
					if($installation['payment_method'] == 'Hourly Rate'){ 
						?>
						<tr>
							<td colspan="1" style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
								Hourly Rate:
							</td>
							<td colspan="4" style="border-right:1px solid #000000;border-bottom:1px solid #000000;">
								<?php echo $installation['hourly_rate']; ?>
							</td>
						</tr>
						<tr>
							<td colspan="1" style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
								Total Hour:
							</td>
							<td colspan="4" style="border-right:1px solid #000000;border-bottom:1px solid #000000;">
								<?php echo $installation['total_hour']; ?>
							</td>
						</tr>
						<tr>
							<td colspan="1" style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
								Total Amount:
							</td>
							<td colspan="4" style="border-right:1px solid #000000;border-bottom:1px solid #000000;">
								<?php echo $installation['total_amount']; ?>
							</td>
						</tr>


						<?php 
					}else{
						?>
						<tr>
							<td colspan="1" style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
								Allocated Time:
							</td>
							<td colspan="4" style="border-right:1px solid #000000;border-bottom:1px solid #000000;">
								<?php echo $installation['allocated_time']; ?>
							</td>
						</tr>
						<tr>
							<td colspan="1" style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
								Fuel Amount:
							</td>
							<td colspan="4" style="border-right:1px solid #000000;border-bottom:1px solid #000000;">
								<?php echo $installation['fuel_amount']; ?>
							</td>
						</tr>
						<tr>
							<td colspan="1" style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
								Transport Amount:
							</td>
							<td colspan="4" style="border-right:1px solid #000000;border-bottom:1px solid #000000;">
								<?php echo $installation['transport_amount']; ?>
							</td>
						</tr>
						<tr>
							<td colspan="1" style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
								Others Amount:
							</td>
							<td colspan="4" style="border-right:1px solid #000000;border-bottom:1px solid #000000;">
								<?php echo $installation['others_amount']; ?>
							</td>
						</tr>
						<tr>
							<td colspan="1" style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
								Total Amount:
							</td>
							<td colspan="4" style="border-right:1px solid #000000;border-bottom:1px solid #000000;">
								<?php echo $installation['total_amount']; ?>
							</td>
						</tr>
						<?php
					}} ?>

					<tr>
						<td colspan="5">
							&nbsp;
						</td>
					</tr>

					<tr>
						<td colspan="5">
							Note : <span style="color:red;"><?php echo $NOTE; ?></span>
						</td>
					</tr>

					<tr>
						<td colspan="5">
							&nbsp;
						</td>
					</tr>

					<tr>
						<td colspan="5" >
							Job Assigned by: <?php echo $installation['assign_by']; ?>
						</td>
					</tr>
					<tr>
						<td colspan="5">
							&nbsp;
						</td>
					</tr>
					<tr >
						<td colspan="5" style="text-align:center;border_top:1px dotted #000000;border_bottom:1px dotted #000000;" >
							Thank You 
						</td>
					</tr>
				</table>
