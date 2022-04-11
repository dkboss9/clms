	<table border="0" width="100%"  style="border-collapse: collapse;">
		<tr>
			<td colspan="3" >
				
				
			</td>
			<td >&nbsp;</td>
			<td colspan="3" style="text-align:right;font-size:14px;">
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
			</td>
		</tr>

	
	
		<tr>
			<td colspan="7">
				&nbsp;
				<br/>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="7">
				<strong>Attendence List:</strong> 
			</td>
		</tr>
		
		<tr>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Sn.
			</td>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Name
			</td>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
                Date
			</td>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Check In Time
            </td>
            
            <td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
                Check Out Time
            </td>
            
            <td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
                Daily Standup
            </td>
            
            <td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
                Updates
			</td>
		</tr>
		
		<?php
		foreach ($attendences as $key => $row ) {
			?>
			<tr>
				<td  style="border-left:1px solid #000000;border-bottom:1px solid #000000;"> <?php echo ++$key;?></td>
				<td style="border-bottom:1px solid #000000;"><?php echo $row->first_name;?> <?php echo $row->last_name;?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo date("d-m-Y",strtotime($row->register_date));?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo  $row->checkin_at ? date("h:i a",strtotime($row->checkin_at)) : '';?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo $row->checkout_at ? date("h:i a",strtotime($row->checkout_at)):'';?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo nl2br($row->checkin_note);?></td>
				<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;"><?php echo nl2br($row->checkout_note);?></td>
			</tr>
			<?php } ?>
	</table>