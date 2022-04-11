<?php
$companies = $this->invoicemodel->getCompanyDetails($result->company_id);
$customers = $this->invoicemodel->getStudentDetails($result->customer_id);
?>
<html>
<head>
	<title><?php echo $companies->company_name;?> - Invoice Print</title>
	<meta charset="utf-8">
	<!-- Web Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap/css/bootstrap.css" />

	<!-- Invoice Print Style -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/invoice-print.css" />
</head>
<body style="font-family: 'Abel', 'Noto', sans-serif;font-size:15px;">
	
	<table border="0" width="100%"  style="border-collapse: collapse;">
		<tr>
			<td colspan="2" >
				<h2>Invoice : #<?php echo $result->invoice_no; ?></h2>
				
			</td>
			<td >&nbsp;</td>
			<td colspan="2" style="text-align:right;font-size:14px;">
				<?php if(file_exists("./assets/uploads/users/thumb/".$companies->thumbnail) && $companies->thumbnail != ""){ ?>
				<img src="<?php echo "/home2/x9z5w2g0/public_html/ausnepit.com.au/clms/assets/uploads/users/thumb/".$companies->thumbnail;?>" alt="<?php echo $companies->company_name;?>" />
				<?php } ?><br/>
				<?php echo $companies->company_name;?>
				<br/>
				<?php echo $companies->address;?>
				<br/>
				<?php echo $companies->phone;?>
				<br/>
				<?php echo $companies->email;?>
			</td>
		</tr>

		
		
		<tr>
			<td colspan="2" style="font-size:15px;">
				
				
				<strong>Attn:</strong> <?php echo $customers->first_name.' '.$customers->last_name;?>
				<br/>
				<strong>Address:</strong> <?php echo $customers->address;?>
				<br>
				<strong>Phone:</strong> <?php echo $customers->phone;?>
				<br/>
				<?php 
				//if($customers->hide_email == '0')
				echo '<strong>Email:</strong> '.$customers->email;
				?>
				
				
			</td>
			<td colspan="3" style="text-align:right;font-size:14px;">
				
				<strong>Invoice Date:</strong> <?php echo date("d/m/Y",$result->invoice_date);?>
				<br/>
				<br/>
				<br/>
				<strong>Due Date:</strong> <?php echo date("d/m/Y",$result->due_date);?>
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
				&nbsp;
			</td>
		</tr>


		<tr>
			
			<td colspan="" style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Item
			</td>
			<td colspan="" style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Description
			</td>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Price
			</td>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Quantity
			</td>

			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Total
			</td>
		</tr>
		
		<?php 
		$projects = $this->invoicemodel->getinvoiceDetails($result->invoice_id);
		foreach ($projects as $row) {
			?>
			<tr>
				<td  style="border-left:1px solid #000000;border-bottom:1px solid #000000;">
					<?php echo $row->project_no;?> <?php echo $row->title;?>
				</td>
				<td style="border-bottom:1px solid #000000;"><?php echo $row->description;?></td>
				<td style="border-bottom:1px solid #000000;"><?php echo $row->price;?></td>
				<td style="border-bottom:1px solid #000000;"><?php echo $row->qty;?></td>
				<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;"><?php echo $row->total;?></td>

			</tr>
			<?php } ?>




			<tr>
				<td colspan="3" style="width:50%;font-size:12px;" >
					&nbsp;

				</td>
				<td  colspan="2" style="text-align:right;font-size:12px;">
					<p ><span style="border-bottom:1px dotted #0000000;">Subtotal: <?php echo $result->sub_total;?></span></p>
					
					<p><span style="border-bottom:1px dotted #0000000;">Shipping: <?php echo $result->shipping;?></span> </p>
					<p><span style="border-bottom:1px dotted #0000000;">Grand Total: <?php echo $result->grand;?> </span></p>
					<?php 
					$payments = $this->invoicemodel->getPayments($result->invoice_id);
					$paid = 0;
					foreach ($payments as $row) {
						$paid+=$row->amount;

					}

					?>
					<p><span style="border-bottom:1px dotted #0000000;">Amount Paid: <?php echo $paid;?></span></p>
					<p><span style="border-bottom:1px dotted #0000000;">Amount Due: <?php echo $result->due_amount;?></span></p>
					<p><span style="border-bottom:1px dotted #0000000;color:red;">Including GST of:	<?php echo round(($result->grand/11),2);?></span></p>

				</p>
			</p>

		</td>
	</tr>


	<tr>
		<td colspan="5">
			&nbsp;
		</td>
	</tr>

	<?php if($result->customer_note != ""){?>
	<tr  >

		<td colspan="5" style="color:red;" >
			<strong>Note: </strong><?php echo $result->customer_note;?>
		</td>
	</tr>
	<?php } ?>

	<tr  >

		<td colspan="5" style="text-align:center;border_top:1px dotted #000000;border_bottom:1px dotted #000000;" >
			Thank You 
		</td>
	</tr>
</table>

</body>
</html>
