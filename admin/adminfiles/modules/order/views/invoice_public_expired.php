
<!doctype html>
<html class="fixed">
<head>
	<style type="text/css">
	.today{
		background-color: #0088cc;
	}
</style>
<!-- Basic -->
<meta charset="UTF-8">

<?php
//$site_name = $this->generalsettingsmodel->getConfigData(20)->row();
$site_title = $this->generalsettingsmodel->getConfigData(20)->row();
$site_keyword = $this->generalsettingsmodel->getConfigData(44)->row();
$site_desc = $this->generalsettingsmodel->getConfigData(45)->row();

?>
<title><?php echo $site_title->config_value; ?></title>
<meta name="keywords" content="<?php echo $site_keyword->config_value; ?>" />
<meta name="description" content="<?php echo $site_desc->config_value; ?>">
<meta name="author" content="ausnep.com.au">

<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<!-- Web Fonts  -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

<!-- Vendor CSS -->
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap/css/bootstrap.css" />

<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/font-awesome/css/font-awesome.css" />
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/magnific-popup/magnific-popup.css" />
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
<!-- Specific Page Vendor CSS -->
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/morris/morris.css" />
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/select2/select2.css" />
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />

<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/fullcalendar/fullcalendar.css" />
<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/fullcalendar/fullcalendar.print.css" media="print" />
<!-- Theme CSS -->
<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/theme.css" />

<!-- Skin CSS -->
<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/skins/default.css" />

<!-- Theme Custom CSS -->
<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/theme-custom.css">

<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/colorbox.css">
<!-- Head Libs -->
<script src="<?php echo  base_url("");?>assets/vendor/modernizr/modernizr.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/jquery/jquery.js"></script>
<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
<!-- Invoice Print Style -->
<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/invoice-print.css" />


<style>
@media only screen and (min-width: 768px){
	html.fixed .content-body {
		margin-left: 0px;}

		html.fixed .page-header
		{
			left: 0;
			top:0;
			z-index: 1;
		}
		html.fixed .header {
			position: fixed;
			z-index: 1020;
			top: 48px;
		}
		html.fixed .inner-wrapper {
			padding-top: 140px;
		}


	}

	.inner-wrapper .invoice-wrap .fixed .content-body{
		margin-left: 0px !important;
	}

	.invoice {
		padding: 0 15px 15px;
		background: white;
		border: 1px solid #ddd;
	}

	.inner-wrapper .invoice-wrap .content-body
	{

		padding:0;
	}
	.page-header h2
	{
		padding: 0px 20px;
	}

	.payment-strip {
		width: 100%;
		padding: 100px 0;
		background: #fff;
		display: flex;
		align-items: center;
	}
	.payment-strip .pay-container
	{
		float: left;
	}
	.payment-strip .pay-container, .payment-strip .save-buttons {
		display: flex;
		align-items: center;
	}
	.payment-strip .pay-btn {
		min-width: 150px;
		margin-right: 20px;
	}
	.payment-strip .amount {
		font-size: 26px;
		display: flex;
		flex-direction: column;
		white-space: nowrap;
		font-weight: bold;
	}
	.payment-strip .amount .currency {
		font-weight: normal;
		font-size: 20px;
		color: #7e90a2;
	}
	a#button-1010 {
		color: white;
		text-align: center;
		padding-left: 39px;
	}
	span.status.due.in-future {
		font-size: 14px;
		font-weight: normal;
	}
	.download-file
	{
		float:right;

	}
	.download-file ul li {
		list-style: none;
		float: left;
		margin-left:20px;
	}

	.download-file ul li a


	{
		background:#47a447;
		color:white;
		padding:8px 30px ;
		text-decoration:none;
		display: inline-block;
		transition:05s;
		-webkit-transition:0.5s;
		-moz-transition:0.5s;

	}

	.download-file ul li a:hover
	{
		background:#47a447;
		color:white;
	}

	@media only screen and (max-device-width: 480px){
		.download-file
		{
			float:none;
			text-align: center;
			margin-top:10px;
		}
		.download-file ul li
		{
			margin-left:5px;
		}
		.download-file ul li a
		{
			padding:5px 20px;
		}
		.payment-strip .amount
		{
			font-size: 14px;
		}


		.page-header{
			position: fixed;
			width: 100%;
		}

		.header{
			position: fixed;
			top: 52px;
		}


		.inner-wrapper .invoice-wrap .content-body{
			margin-left: 0px !important;
			top: 169px !important;
		}


	}
</style>


</head>
<body>
	<section class="body">

		<!-- start: header -->
		<?php
		$row = $this->generalsettingsmodel->getConfigData(24)->row();
		?>
		<header class="page-header">
			<h2><?php echo $site_title->config_value; ?> </h2>

		</header>


		<header class="header">
			<div class="payment-strip">
				<div class="container">
					<div class="pay-container">

						<div  id="ext-gen1026">
							<h4>Sorry, this link has been expired Please login to view in details</h4>
						</div>
						<div class="download-file ">
							<ul>
								<li><a href="<?php echo base_url();?>">Login</a></li>
							</ul>
						</div>
					</div>
					
					<div class="clearfix"></div>
				</div>
			</div>
			<?php
			$row = $this->generalsettingsmodel->getConfigData(24)->row();
			?>
			<div class="container">
				<div style="text-align:center;margin:20px 0;">
					<a href="<?php echo base_url("");?>" >
						<img src="<?php echo SITE_URL."uploads/logo/".$row->config_value;?>" />
					</a>
				</div>
			</div>
		</header>



		<script src="<?php echo base_url("");?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

		<!-- Specific Page Vendor -->
		<script src="<?php echo base_url("");?>assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-appear/jquery.appear.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/raphael/raphael.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/morris/morris.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/gauge/gauge.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/snap-svg/snap.svg.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jqvmap/jquery.vmap.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-autosize/jquery.autosize.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/bootstrap-markdown/js/markdown.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/bootstrap-markdown/js/to-markdown.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-validation/jquery.validate.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/pnotify/pnotify.custom.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/fullcalendar/lib/moment.min.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/fullcalendar/fullcalendar.js"></script>
		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo base_url("");?>assets/javascripts/theme.js"></script>
		<script src="<?php echo base_url("");?>themes/ckeditor/ckeditor.js"></script>

		<!-- Theme Custom -->
		<script src="<?php echo base_url("");?>assets/javascripts/theme.custom.js"></script>

		<!-- Theme Initialization Files -->
		<script src="<?php echo base_url("");?>assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<?php if($this->uri->segment(1) == "dashboard"){?>
		<script src="<?php echo base_url("");?>assets/javascripts/dashboard/examples.dashboard.js"></script>
		<?php } ?>
		<script src="<?php echo base_url("");?>assets/vendor/select2/select2.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo base_url("");?>assets/javascripts/theme.js"></script>

		<!-- Theme Custom -->
		<script src="<?php echo base_url("");?>assets/javascripts/theme.custom.js"></script>

		<!-- Theme Initialization Files -->
		<script src="<?php echo base_url("");?>assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="<?php echo base_url("");?>assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="<?php echo base_url("");?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="<?php echo base_url("");?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>
		<script src="<?php echo base_url("");?>assets/javascripts/forms/examples.validation.js"></script>
		<script src="<?php echo base_url("");?>assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>
		<?php if($this->uri->segment(1) != 'upgrade'){?>
		<script src="<?php echo base_url("");?>assets/javascripts/forms/examples.advanced.form.js"></script>
		<?php } ?>
		<script src="<?php echo base_url("");?>assets/javascripts/ui-elements/examples.lightbox.js"></script>
		<script src="<?php echo base_url("");?>assets/javascripts/forms/examples.wizard.js"></script>
		<script src="<?php echo base_url("");?>assets/javascripts/jquery.colorbox.js"></script>
		<script src="<?php echo base_url("");?>themes/js/main.js"></script>

	</body>
	</html>