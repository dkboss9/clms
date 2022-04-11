<!doctype html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->	<html class="no-js" lang=""> <!--<![endif]-->
<head>
<?php
        $header_title = $this->commonmodel->get_config(43)->config_value;
        $header_desc = $this->commonmodel->get_config(45)->config_value;
        $header_keyword = $this->commonmodel->get_config(44)->config_value;
        ?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php 
  echo $site_title ?? $header_title;
  ?></title>
  <meta name="description" content="<?php  echo $meta_desc ?? $header_desc;?>">
  <meta name="keyword" content="<?php   echo $meta_keyword ?? $header_keyword; ?>">
	<meta name="google-site-verification" content="F3FR2MzCG2t7cJKVQevNv0BPaMekwqz8lAQLT5rmSZE" />
	<meta property="og:title" content="Classibazaar - Invitation">
	<meta property="og:description" content="Please register in classibazaar.">
	<meta property="og:image" content="<?php echo base_url("logo-classibazaar.jpg");?>">
	<?php if(isset($signuplink)){ ?>
		<meta property="og:url" content="<?php echo base_url("sign-up.html/".md5($signuplink));?>">
	<?php } ?>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/normalize.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/icomoon.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/transitions.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/flags.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/prettyPhoto.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/scrollbar.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/chartist.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/main.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/dashboard.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/color.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/responsive.css">
	<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/dbresponsive.css">
	<link href="http://ausnepit.com.au/proviewims_new/assets/vendors/bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css"/>
	<style type="text/css">
	input.error{
		border: 1px solid red;
	}
	select.error{
		border: 1px solid red;
	}
	textarea.error{
		border: 1px solid red;
	}
	input[type=checkbox].error {
		outline: 1px solid red;
	}

	.error{
		color:red;
	}

</style>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/sell.css">

<script src="<?php echo base_url("assets/");?>/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
<script src="<?php echo base_url("assets/");?>/js/vendor/jquery-library.js"></script>
<script src="<?php echo base_url("assets/");?>/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo base_url("assets/");?>/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url("assets/");?>/js/bootstrap-colorpicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js-old/jquery.validate.js"></script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCR-KEWAVCn52mSdeVeTqZjtqbmVJyfSus&language=en"></script>
<script src="<?php echo base_url("assets/");?>/js/tinymce/tinymce.min.js?apiKey=4cuu2crphif3fuls3yb1pe4qrun9pkq99vltezv2lv6sogci"></script>
<script src="<?php echo base_url("assets/");?>/js/responsivethumbnailgallery.js"></script>
<script src="<?php echo base_url("assets/");?>/js/jquery.flagstrap.min.js"></script>
<script src="<?php echo base_url("assets/");?>/js/backgroundstretch.js"></script>
<script src="<?php echo base_url("assets/");?>/js/owl.carousel.min.js"></script>
<script src="<?php echo base_url("assets/");?>/js/jquery.vide.min.js"></script>
<script src="<?php echo base_url("assets/");?>/js/jquery.collapse.js"></script>
<script src="<?php echo base_url("assets/");?>/js/scrollbar.min.js"></script>
<script src="<?php echo base_url("assets/");?>/js/chartist.min.js"></script>
<script src="<?php echo base_url("assets/");?>/js/prettyPhoto.js"></script>
<script src="<?php echo base_url("assets/");?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/");?>/js/countTo.js"></script>
<script src="<?php echo base_url("assets/");?>/js/appear.js"></script>
<script src="<?php echo base_url("assets/");?>/js/gmap3.js"></script>
<script src="<?php echo base_url("assets/");?>/js/main.js"></script>

</head>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
	(adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-8296573405536019",
		enable_page_level_ads: true
	});
</script>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '236144560646027');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=236144560646027&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<body>
	<div id="fb-root"></div>
 <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.1&appId=126225711384355&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<!--************************************
			Wrapper Start
			*************************************-->
			<div id="tg-wrapper" class="tg-wrapper tg-haslayout">
		<!--************************************
				Header Start
				*************************************-->
				<header id="tg-dashboardheader" class="tg-dashboardheader tg-haslayout">
					<nav id="tg-nav" class="tg-nav">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#tg-navigation" aria-expanded="false">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div id="tg-navigation" class="collapse navbar-collapse tg-navigation">
							<ul>
								<li>
									<a href="<?php echo base_url();?>">Home</a>

								</li>
								<li class="">
									<a href="<?php echo base_url("pd-about-us.html");?>">About Us</a>
								</li>
								<li >
									<a href="<?php echo base_url("pd-contact.html");?>">Contact</a>

								</li>
								<li >
									<a href="<?php echo base_url("xx-all");?>">Browse Ads</a>
								</li>
								
							</ul>
						</div>
					</nav>
					<div class="tg-rghtbox">
						<a class="tg-btn" href="<?php echo base_url("buy_sell/verify_mobile.html");?>">
							<i class="icon-bookmark"></i>
							<span>post an ad</span>
						</a>
						<?php
						$unread = $this->users_model->get_notification("0");
						$notifications = $this->users_model->get_notification();
						?>
						<div class="dropdown tg-themedropdown tg-notification">
							<button class="tg-btndropdown" id="tg-notificationdropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="icon-alarm"></i>
								<?php if($unread->num_rows()>0){ ?>
								<span class="tg-badge"><?php echo $unread->num_rows();?></span>
								<?php } ?>
							</button>
							<ul class="dropdown-menu tg-dropdownmenu" aria-labelledby="tg-notificationdropdown">
								<?php 
								foreach ($notifications->result() as $note) {
									?>
									<li <?php if($note->status == 0) echo 'class="active"';?>><p><a href="<?php echo base_url($note->link);?>" class="note_link" rel="<?php echo $note->id;?>"><?php echo $note->content;?></a></p></li>
									<?php
								}?>
								
							</ul>
						</div>
					</div>
					<?php 
					$header_users = $this->users_model->getUserDetails($this->session->userdata('bazar_userid'));
					?>
					<div id="tg-sidebarwrapper" class="tg-sidebarwrapper">
						<span id="tg-btnmenutoggle" class="tg-btnmenutoggle">
							<i class="fa fa-angle-left"></i>
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="67" viewBox="0 0 20 67">
								<metadata>
									<x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.6-c138 79.159824, 2016/09/14-01:09:01">
									<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
									<rdf:Description rdf:about=""/>
								</rdf:RDF>
							</x:xmpmeta>
						</metadata>
						<path id="bg" class="cls-1" d="M20,27.652V39.4C20,52.007,0,54.728,0,67.265,0,106.515.026-39.528,0-.216-0.008,12.32,20,15.042,20,27.652Z"/>
					</svg>
				</span>
				<?php
            $config = $this->commonmodel->get_config(25);
            ?>
				<div id="tg-verticalscrollbar" class="tg-verticalscrollbar">
					<strong class="tg-logo"> <a href="<?php echo base_url(""); ?>"> <img src="<?php echo $config->config_value;?>" alt="Classibazaar" style="max-height:100px;width: auto;"/></a></strong>
					<div class="tg-user">
						<figure>

							<a href="javascript:void(0);">
								<?php
								if($header_users->thumbnail != '' && @fopen($header_users->thumbnail, 'r')){ ?>
								<img src="<?php echo $header_users->image;?>" style="width:60px" >
								<?php }else{?>
								<img src="<?php echo base_url("");?>assets/images/!logged-user.jpg"  class="rounded img-responsive" data-lock-picture="<?php base_url("");?>assets/images/!logged-user.jpg" width="60px" />
								<?php }?>
							</a>
						</figure>
						<div class="tg-usercontent">
							<h3>Hi! <?php echo $this->session->userdata("bazar_firstname");?> <?php echo $this->session->userdata("bazar_lastname");?></h3>
							<!--<h4>Administrator</h4>-->
						</div>
						<a class="tg-btnedit" href="<?php echo base_url("buy_sell/profile-setting.html");?>"><i class="icon-pencil"></i></a>
					</div>
					<nav id="tg-navdashboard" class="tg-navdashboard">
						<ul>
							<li class="tg-active">
								<a href="<?php echo base_url("buy_sell/");?>">
									<i class="icon-chart-bars"></i>
									<span> Insights</span>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url("buy_sell/profile-setting.html");?>">
									<i class="icon-cog"></i>
									<span>Profile Settings</span>
								</a>
							</li>
							<!-- <li>
								<a href="<?php echo base_url("buy_sell/agents");?>">
									<i class="icon-user"></i>
									<span>Agents</span>
								</a>
							</li> -->
							<li>
								<a href="<?php echo base_url("buy_sell/coupon-offers");?>">
									<i class="icon-star"></i>
									<span>Coupon</span>
								</a>
							</li>
							<li class="menu-item-has-children">
								<a href="javascript:void(0);">
									<i class="icon-layers"></i>
									<span>My Ad Posts</span>
								</a>
								<ul class="sub-menu">
									<li><a href="<?php echo base_url("buy_sell/my-ad.html");?>">All Ad Posts</a></li>
									<li><a href="<?php echo base_url("buy_sell/my-ad.html?featured=1");?>">Featured Ad Posts</a></li>
									<li><a href="<?php echo base_url("buy_sell/my-ad.html?status=active");?>">Active Ad Posts</a></li>
									<li><a href="<?php echo base_url("buy_sell/my-ad.html?status=inactive");?>">Inactive Ad Posts</a></li>
								</ul>

							</li>
							<li class="menu-item-has-children">
								<a href="javascript:void(0);">
									<i class="icon-envelope"></i>
									<span>Offers/Messages</span>
								</a>
								<ul class="sub-menu">
									<li><a href="<?php echo base_url("buy_sell/offermessages?status=received");?>">Offer Received</a></li>
									<li><a href="<?php echo base_url("buy_sell/offermessages?status=sent");?>">Offer Sent</a></li>
								</ul>
							</li>
						
							<li>
								<a href="<?php echo base_url("buy_sell/myad_payment"); ?>">
									<i class="icon-cart"></i>
									<span>Payments</span>
								</a>
							</li>
						
							<li>
								<a href="<?php echo base_url("buy_sell/privacy-setting.html");?>">
									<i class="icon-star"></i>
									<span>Privacy Settings</span>
								</a>
							</li>
							<li class="menu-item-has-children">
								<a href="javascript:void(0);">
									<i class="icon-envelope"></i>
									<span>Referral Management</span>
								</a>
								<ul class="sub-menu">
									<li><a href="<?php echo base_url("buy_sell/invite-friend.html");?>">Invite Friends</a></li>
									<li><a href="<?php echo base_url("buy_sell/referral_dashboard");?>">Referral Dashboard</a></li>
								</ul>
							</li>
							<li>
								<a href="<?php echo base_url("users/logout");?>">
									<i class="icon-exit"></i>
									<span>Logout</span>
								</a>
							</li>
						</ul>
					</nav>
					<?php
					$signuplink = $this->session->userdata("bazar_userid")."-".$this->session->userdata("bazar_username");
					?>
					<div class="tg-socialandappicons">
						<ul class="tg-socialicons">
							<li class="tg-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(base_url("sign-up.html/".md5($signuplink)));?>&amp;src=sdkpreparse" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li class="tg-twitter"><a href="http://www.twitter.com/share?url=<?php echo urlencode(base_url("sign-up.html/".md5($signuplink)));?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
						<!-- 	<li class="tg-linkedin"><a href="javascript:void(0);"><i class="fa fa-linkedin"></i></a></li>
							<li class="tg-googleplus"><a href="javascript:void(0);"><i class="fa fa-google-plus"></i></a></li>
							<li class="tg-rss"><a href="javascript:void(0);"><i class="fa fa-rss"></i></a></li> -->
						</ul>
						<!-- <ul class="tg-appstoreicons">
							<li><a href="javascript:void"><img src="<?php echo base_url("assets/");?>/images/icons/app-01.png" alt="image description"></a></li>
							<li><a href="javascript:void"><img src="<?php echo base_url("assets/");?>/images/icons/app-02.png" alt="image description"></a></li>
						</ul> -->
					</div>
				</div>
			</div>
		</header>
		<!--************************************
				Header End
				*************************************-->

				<script type="text/javascript">
					$(document).ready(function(){
						$(".note_link").click(function(){
							var noteid = $(this).attr("rel");
							var link = $(this).attr("href");
							//alert(link);
							$.ajax({
								url: '<?php echo base_url("home/note_seen");?>',
								type: "POST",
								data: "noteid=" + noteid,
								success: function(data) { 
									window.location.href  = link;
								}        
							});
							return false;
						});
					});
				</script>