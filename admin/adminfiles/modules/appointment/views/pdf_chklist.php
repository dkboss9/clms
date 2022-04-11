<html>
<head>
	<title>Payment Summary</title>
	<meta charset="utf-8">
	<!-- Web Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap/css/bootstrap.css" />

	<!-- Invoice Print Style -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/invoice-print.css" media="print" />
	<style type="text/css">
		.first-invoice-preview h2{
			color: #4c5357;
			margin-bottom: 0; 
			font-size: 31px;
		}	
		.first-invoice-preview tr.second-row{
			line-height: 25px;
			text-align: right;
		}	
		.first-invoice-preview tr.second-row strong,
		.first-invoice-preview tr.third-row{
			font-size: 14px;
		}
		.first-invoice-preview tr.third-row{
			background:#35a6da;
			color:#fff;
		}
		.first-invoice-preview tr.third-row td{
			padding: 10px;
			text-transform: uppercase;

		}
		.first-invoice-preview tr.fourth-row{
			font-size: 14px;
			font-weight: bold;
			color: #4c5357;
		}
	</style>
</head>
<body style="font-family: 'Open Sans', 'Helvetica Neue', sans-serif;font-size:15px;background: #fff;">
	
	<table style="width:100%">
		<tr>
			<td >
				<p>Checklist</p>
			</td>
		</tr>
		
		
		<?php 
		$i = 1;
		foreach ($checklist->result() as $row) {
			?>
			<tr>
				<td ><?php echo $i;?>. <?php echo $row->type_name;?></td>
			</tr>
			<?php
			$i++;
		}
		?>

	</table>

</body>
</html>
