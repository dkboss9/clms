<p>Name: <?php echo $user->first_name.' '.$user->last_name;?></p>
<p>Date: <?php echo date("d F, Y");?></p>
<h3>
	To Do List -<?php echo $company->company_name;?> <?php echo date("d-m-Y") ?> <?php if(file_exists("../assets/uploads/users/thumb/".$company->thumbnail) && $company->thumbnail != ""){ ?>
				- <img src="<?php echo "/home2/x9z5w2g0/public_html/www.thokyo.com/assets/uploads/users/thumb/".$company->thumbnail;?>" alt="" />
				<?php } ?>
</h3>
<table border="0" width="100%"  style="border-collapse: collapse;">
	
	<tr>
		<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
			SN.
		</td>
		<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
			Tasks
		</td>
		<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
			Action
		</td>
	</tr>

	<?php
	$balance = 0;
	foreach ($todos as $key => $row ) {
		?>
		<tr>
			<td  style="border-right:1px solid #000000;border-left:1px solid #000000;border-bottom:1px solid #000000;">
				<?php echo ++$key;?>
			</td>

			<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;"><?php echo $row->task_name;?></td>
			<td style="border-right:1px solid #000000;border-bottom:1px solid #000000;"></td>
		</tr>
		<?php } ?>


	</table>
	<p>&nbsp;</p>

	<table border="0" width="100%"  style="border-collapse: collapse;">

		<tr>
			<td  style="font-weight:bold;background:#35a6da;color:#ffffff;">
				Comment
			</td>

		</tr>


		<tr>
			<td  style="border:1px solid #000000;height: 200px;">
				
			</td>
		</tr>
	</table>
	<span style="page-break-after:always;"></span>
	
