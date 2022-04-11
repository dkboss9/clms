<table border="0" width="100%"  style="border-collapse: collapse;">
		<tr>
			<td colspan="2" >
				<h2>Order Confirmation : #<?php echo $order->order_number; ?></h2>
			</td>
			<td >&nbsp;</td>
			<td colspan="2" style="text-align:right;font-size:14px;">
				<?php //if(file_exists("./uploads/logo/".$row->config_value) && $row->config_value != ""){ ?>
				<img src='<?php echo "/home2/x9z5w2g0/public_html/".base_url("/")."assets/images/logo.png";?>' alt="Classibazaar" />
				<?php //} ?><br/>
				<?php echo "Classibazaar.com.au";?>
				<br/>
				<?php echo "info@classibazaar.com.au";?>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="font-size:15px;">
				<strong>Attn:</strong> <?php echo $order->first_name;?> <?php echo $order->last_name;?>
				<br/>
				<strong>Phone:</strong> <?php echo $order->phone;?>
				<br/>
				<?php 
				echo '<strong>Email:</strong> '.$order->email;
				?>
			</td>
			<td colspan="3" style="text-align:right;font-size:14px;">
				<strong>Order Date:</strong> <?php echo date("d/m/Y",strtotime($order->order_date));?>
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
				<strong>Voucher codes:</strong> 
				<?php
				$code = '';
				$i = 1;
				foreach ($vouchers->result() as $voucher) {
					if($i % 8 == 0)
						$code .= '<br>';
						$code .= $voucher->code.',';

					$i++;
				}
				echo substr($code,0,-1);
				?>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="2" style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Deal
			</td>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Quantity
			</td>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Price 
			</td>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Total
			</td>
		</tr>
		<tr>
			<td colspan="2" style="border-left:1px solid #000000;border-right:1px solid #000000;border-bottom:1px solid #000000;">
				 <?php echo $deal->dealstitle;?>
				 <p><?php echo $product->product_name??''; ?></p>
			</td>
			<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;">
				<?php echo $order->qty;?>
			</td>
			<td style="border-right:1px solid #000000;"><?php echo $order->price;?></td>
				<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;"><?php echo $order->total_price+$order->discount;?></td>
				</tr>
				<tr  >
					<td style="border-top:1px solid #000000;" colspan="5">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3" style="width:50%;font-size:12px;" >
						<p><strong>Payment's Accepted</strong></p>
					</td>
					<td  colspan="2" style="text-align:right;font-size:12px;">
						<p><span style="border-bottom:1px dotted #0000000;">Sub Total Price: AUD <?php echo number_format($order->total_price + $order->discount,2);?></span></p>
						<p><span style="border-bottom:1px dotted #0000000;">
						Discount Price: AUD <?php echo number_format($order->discount,2);?></span></p>
						<p><span style="border-bottom:1px dotted #0000000;">Total Price: AUD <?php echo number_format($order->total_price,2);?></span></p>
						<p><span style="border-bottom:1px dotted #0000000;">Payment Method: <?php echo $order->payment_method;?></span></p>
						<p><span style="border-bottom:1px dotted #0000000;color:red;">Status:	<?php echo $order->is_paid;?></span></p>
					</td>
				</tr>
				<tr>
					<td colspan="5">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td colspan="5" style="text-align:center;border_top:1px dotted #000000;border_bottom:1px dotted #000000;" >
						Thank You 
					</td>
				</tr>
			</table>