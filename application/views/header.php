<?php
//session_start();
$_SESSION['username'] = $this->session->userdata("clms_chatname");
?>
<!doctype html>
<html class="fixed">

<head>
	<style type="text/css">
		.today {
			background-color: #0088cc;
		}

		.header-title {
			font-weight: bold;
			font-size: 30px;
			margin-right: 200px;
		}

		@media(max-width: 767px) {
			.header-title {
				font-size: 20px;
				margin-left: 7%;
			}
		}
	</style>

	<!-- Basic -->
	<meta charset="UTF-8">
	<?php

$site_title = $this->generalsettingsmodel->getConfigData(43)->row();
$site_keyword = $this->generalsettingsmodel->getConfigData(44)->row();
$site_desc = $this->generalsettingsmodel->getConfigData(45)->row();

?>
	<title><?php echo $site_title->config_value; ?></title>
	<meta name="keywords" content="<?php echo $site_keyword->config_value; ?>" />
	<meta name="description" content="<?php echo $site_desc->config_value; ?>">
	<meta name="author" content="">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
		rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap/css/bootstrap.css" />

	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	<link rel="stylesheet"
		href="<?php echo base_url("");?>assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
	<link rel="stylesheet"
		href="<?php echo base_url("");?>assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet"
		href="<?php echo base_url("");?>assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
	<link rel="stylesheet"
		href="<?php echo base_url("");?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/morris/morris.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/select2/select2.css" />
	<link rel="stylesheet"
		href="<?php echo base_url("");?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
	<link rel="stylesheet"
		href="<?php echo base_url("");?>assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
	<link rel="stylesheet"
		href="<?php echo base_url("");?>assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />

	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/fullcalendar/fullcalendar.css" />
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/vendor/fullcalendar/fullcalendar.print.css"
		media="print" />
	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/colorbox.css">

	<link rel="apple-touch-icon" href="<?php echo base_url("");?>assets/images/alms.png" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url("");?>assets/images/alms.png" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url("");?>assets/images/alms.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url("");?>assets/images/alms.png" />
	<link rel="apple-touch-icon" sizes="58x58" href="<?php echo base_url("");?>assets/images/alms.png" />

	<link type="text/css" rel="stylesheet" media="all" href="<?php echo base_url()?>chat/css/chat.css" />





	<script src="<?php echo  base_url("");?>assets/vendor/modernizr/modernizr.js"></script>
	<script src="<?php echo base_url("");?>assets/vendor/jquery/jquery.js"></script>


	<script type="text/javascript" src="<?php echo SITE_URL; ?>assets/js/plupload/plupload.full.min.js"></script>
	<script type="text/javascript">
		var webpath = "<?php echo base_url();?>themes/";
	</script>
</head>

<body>

	<section class="body">

		<!-- start: header -->
		<?php
		$row = $this->generalsettingsmodel->getConfigData(24)->row();
		?>
		<header class="header">
			<div class="logo-container">
				<a href="#" class="logo">
					<img src="<?php echo SITE_URL."uploads/logo/".$row->config_value;?>" />
				</a>
				<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html"
					data-fire-event="sidebar-left-opened">
					<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
				</div>
			</div>
			<?php

		
			$profile = $this->usermodel->getuser($this->session->userdata('clms_front_userid'))->row();
		
			?>
			<!-- start: search & user box -->
			<div class="header-right">
				

				<span class="separator"></span>

				<?php echo $this->load->view("notifications");?>

				<span class="separator"></span>

				<div id="userbox" class="userbox">
					<a href="#" data-toggle="dropdown">
						<figure class="profile-picture">
							<figure class="profile-picture">
								<?php if(file_exists('./uploads/document/'.$profile->picture) && $profile->picture !=""){ ?>
								<img src="<?php echo base_url().'uploads/document/'.$profile->picture;?>"
									class="img-circle">
								<?php }else{?>
								<img src="<?php echo base_url("");?>assets/images/!logged-user.jpg" alt="Joseph Doe"
									class="img-circle"
									data-lock-picture="<?php base_url("");?>assets/images/!logged-user.jpg" />
								<?php } ?>
							</figure>
						</figure>
						<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
							<span class="name"><?php echo $this->session->userdata('clms_front_username');?></span>
							<span class="role"><?php echo $this->session->userdata('clms_front_company_group');?></span>
						</div>

						<i class="fa custom-caret"></i>
					</a>

					<div class="dropdown-menu">
						<ul class="list-unstyled">
							<li class="divider"></li>
							<li>
								<a href="<?php echo base_url("project/profile/");?>" title="My Profile" role="menuitem"
									tabindex="-1"><i class="fa fa-user"></i> My Profile</a>
							</li>

							<li>
								<a role="menuitem" tabindex="-1" href="<?php echo base_url("logout");?>"><i
										class="fa fa-power-off"></i> Logout</a>
							</li>


						</ul>
					</div>
				</div>
			</div>
			<!-- end: search & user box -->
		</header>


		<div class="inner-wrapper">
			<!-- start: sidebar -->
			<aside id="sidebar-left" class="sidebar-left">

				<div class="sidebar-header">
					<div class="sidebar-title">

					</div>
					<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html"
						data-fire-event="sidebar-left-toggle">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>

				<div class="nano">
					<div class="nano-content">
						<nav id="menu" class="nav-main" role="navigation">

							<ul class="nav nav-main">
								<li class="nav-active">
									<!-- <a href="<?php echo base_url("student/notes/".$this->session->userdata("clms_front_userid"));?>">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Dashboard</span>
										</a> -->
									<a href="<?php echo base_url("project/dashboard");?>">
										<i class="fa fa-home" aria-hidden="true"></i>
										<span>Dashboard</span>
									</a>
								</li>
								<?php
							
												$user_group_company_id = $this->session->userdata("clms_front_user_group_company_id");
												$menus = $this->commonmodel->get_adminmenu_users(0,$user_group_company_id,1);
												foreach($menus as $menu){
														$children_menus = $this->commonmodel->get_adminmenu_users($menu->menuid,$user_group_company_id,4);
														?>
								<li class="nav-parent">
									<a>
										<i class="<?php  echo $menu->icons;?>" aria-hidden="true"></i>
										<span><?php echo $menu->menu_name;?></span>
									</a>



									<ul class="nav nav-children">
										<?php foreach($children_menus as $child_menu){ ?>
										<li>
											<a href="<?php echo base_url($child_menu->menu_link);?>">
												<?php echo $child_menu->menu_name;?>
											</a>
										</li>
										<?php } ?>
									</ul>
								</li>
								<?php
													}
											?>
							</ul>
						</nav>
					</div>
				</div>
			</aside>
			<!-- end: sidebar -->
		

			<section role="main" class="content-body">
				<header class="page-header">
					<h2></h2>
					<div class="right-wrapper pull-right">
						<a class="sidebar-right-toggle" href="<?php echo base_url("logout");?>"><i
								class="fa fa-power-off"></i></a>
					</div>
				</header>