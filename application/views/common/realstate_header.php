<!doctype html>
<!--[if lt IE 7]>   <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>      <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>      <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js" lang=""> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="google-site-verification" content="F3FR2MzCG2t7cJKVQevNv0BPaMekwqz8lAQLT5rmSZE" />
  <title><?php if(isset($heading)) echo $heading; else 'ClassiBazaar - Free Classified Ads';?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon" />
  <base href="<?php echo base_url();?>" />
  <?php /*<link rel="apple-touch-icon" href="<?php echo base_url();?>assets/images/favicon.ico"> */ ?>
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/normalize.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/icomoon.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/transitions.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/flags.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/owl.carousel.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/prettyPhoto.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/jquery-ui.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/scrollbar.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/chartist.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/main.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/color.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/responsive.css">

  <style type="text/css">
  input.error{
    border: 1px solid red;
  }
  textarea.error{
    border: 1px solid red;
  }
  input[type=checkbox].error {
    outline: 1px solid red;
  }

  input[type=radio].error {
    outline: 1px solid red;
  }



</style>

<?php if(isset($root_id) && $root_id == 6){?>
<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/job.css">
<?php
}
?>

<?php if(isset($root_id) && $root_id == 8){?>
<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/realstate.css">
<?php
}
?>

<?php 
if(isset($root_id) && $root_id == 1){
  if(isset($mycatid) && $mycatid == 14){
    ?>
    <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/bike.css">
    <?php
  }else{
    ?>
    <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/car.css">
    <?php
  }
}
?>

<?php
if($this->uri->segment(1) == "xx-automotive"){
  ?>
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/car.css">
  <?php
}
?>

<?php
if($this->uri->segment(1) == "xx-jobs"){
  ?>
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/job.css">
  <?php
}
?>

<?php
if($this->uri->segment(1) == "xx-real-estate"){
  ?>
  <link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/realstate.css">
  <?php
}
?>

<script src="<?php echo base_url("assets/");?>/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
	<script src="<?php echo base_url("assets/");?>/js/vendor/jquery-library.js"></script>
	<script src="<?php echo base_url("assets/");?>/js/vendor/bootstrap.min.js"></script>
	<script src="<?php echo base_url("assets/");?>/js/bootstrap-datepicker.js"></script>
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


<script type="text/javascript">
 
  
  $(document).ready(function(){
    $("#states").change(function(){
      var url1 = $(this).val().split('_');
      url ='location/'+url1[0]+'/'+url1[1].replace(/ /g,'-');
      window.location = url;

    });
  });
</script>
<?php if($this->uri->segment(1) !="post-ad.html"){?>
<script type="text/javascript">
  $(function() {
    $('#callus').bind('click', function(e) {
      e.preventDefault();
      $('#call-us-form').bPopup({
        content:'iframe', //'ajax', 'iframe' or 'image'
        contentContainer:'.contentform',
        loadUrl:'<?php echo base_url();?>call-us/contact.php' //Uses jQuery.load()
      });
    });
  });
</script>
<?php }?>
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
<body class="tg-home tg-homeone">
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=560393677334341";
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
        <header id="tg-header" class="tg-header tg-haslayout">
          <div class="tg-topbar">
            <div class="container">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
             <?php /* <ul class="tg-navcurrency">
                <li><a href="#" data-toggle="modal" data-target="#tg-modalselectcurrency">select currency</a></li>
                <li><a href="#" data-toggle="modal" data-target="#tg-modalpriceconverter">Price converter</a></li>
              </ul> */ ?>
              <div class="dropdown tg-themedropdown tg-userdropdown">
                <?php if($this->session->userdata('bazar_userid')){
                  $header_users = $this->users_model->getUserDetails($this->session->userdata('bazar_userid'));
                  ?>
                  <a href="javascript:void(0);" id="tg-adminnav" class="tg-btndropdown" data-toggle="dropdown">
                    <span class="tg-userdp"><?php if(file_exists('./assets/uploads/users/thumb/'.$header_users->thumbnail) && $header_users->thumbnail !=""){ ?>
                      <img src="<?php echo base_url().'assets/uploads/users/'.$header_users->image;?>" style="width:35px;height: 35px;" >
                      <?php }else{?>
                      <img src="<?php echo base_url("");?>assets/images/!logged-user.jpg"  class="rounded img-responsive" data-lock-picture="<?php base_url("");?>assets/images/!logged-user.jpg" style="width:35px;height: 35px;"  />
                      <?php }?></span>
                      <span class="tg-name">Hi! <?php echo $this->session->userdata('bazar_firstname')?></span>
                      <!-- <span class="tg-role">Administrator</span>-->
                    </a>
                    <ul class="dropdown-menu tg-themedropdownmenu" aria-labelledby="tg-adminnav">
                      <li>
                        <a href="<?php echo base_url("dashboard.html");?>">
                          <i class="icon-chart-bars"></i>
                          <span>Insights</span>
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo base_url("profile-setting.html");?>">
                          <i class="icon-cog"></i>
                          <span>Profile Settings</span>
                        </a>
                      </li>
                      <li class="menu-item-has-children">
                        <a href="javascript:void(0);">
                          <i class="icon-layers"></i>
                          <span>My Ads</span>
                        </a>
                        <ul>
                          <li><a href="<?php echo base_url("my-ad.html");?>">All Ads</a></li>
                          <li><a href="<?php echo base_url("my-ad.html?featured=1");?>">Featured Ads</a></li>
                          <li><a href="<?php echo base_url("my-ad.html?status=active");?>">Active Ads</a></li>
                          <li><a href="<?php echo base_url("my-ad.html?status=inactive");?>">Inactive Ads</a></li>
                        </ul>
                      </li>
                      <li>
                        <a href="<?php echo base_url("verify_mobile.html");?>">
                          <i class="icon-layers"></i>
                          <span>Dashboard Post Ad</span>
                        </a>
                      </li>
                      <li class="menu-item-has-children">
                        <a href="javascript:void(0);">
                          <i class="icon-envelope"></i>
                          <span>Offers/Messages</span>
                        </a>
                        <ul>
                          <li><a href="<?php echo base_url("offermessages.html?status=received"); ?>">Offer Received</a></li>
                          <li><a href="<?php echo base_url("offermessages.html?status=sent"); ?>">Offer Sent</a></li>
                        </ul>
                      </li>
                      <li>
                        <a href="<?php echo base_url("adpost/myad_payment"); ?>">
                          <i class="icon-cart"></i>
                          <span>Payments</span>
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo base_url("myfavourites.html"); ?>">
                          <i class="icon-heart"></i>
                          <span>My Favourite</span>
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo base_url("privacy-setting.html");?>">
                          <i class="icon-star"></i>
                          <span>Privacy Settings</span>
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo base_url("users/logout");?>">
                          <i class="icon-exit"></i>
                          <span>Logout</span>
                        </a>
                      </li>
                    </ul>
                    <?php
                  }else{
                    ?>
                    <a href="<?php echo base_url("login.html");?>" class="login-signup" style="" >
                      <span class="tg-name">Login</span>   
                    </a>

                    <a href="<?php echo base_url("sign-up.html");?>" class="login-signup" style="" >
                      <span class="tg-name">Sign up</span>   
                    </a>
                    <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
        $config = $this->commonmodel->get_config(24);
        ?>
        <div class="tg-navigationarea">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <strong class="tg-logo"><a href="<?php echo base_url(""); ?>"> <img src="<?php echo base_url()."assets/uploads/logo/".$config->config_value;?>" alt="Classibazzar" style="max-height:100px;width: auto;"/></a></strong>
                <a class="tg-btn" href="<?php echo base_url("verify_mobile.html"); ?>">
                  <i class="icon-bookmark"></i>
                  <span>post an ad</span>
                </a>
                <nav id="tg-nav" class="tg-nav">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#tg-navigation" aria-expanded="false" style="background: #800080 !important;">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <?php if(isset($list_view)){?>
                    <button type="button" class="navbar-toggle collapsed link_top_search" id="link_mob" style="margin-right: 5px;color: #fff;background: #800080 !important;">
                      <i class="fa fa-filter" aria-hidden="true"></i>
                    </button>
                    <?php } ?>
                    <?php if($this->uri->segment(1) != "" && $this->uri->segment("1") != 'realstate') { ?>
                    <button type="button" class="navbar-toggle collapsed link_top_search" id="link_mob_search"  style="margin-right: 5px;color: #fff;background: #800080 !important;">
                      <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                    <?php } ?>
                  </div>
                  <div id="tg-navigation" class="collapse navbar-collapse tg-navigation">
                    <ul>
                      <li class="current-menu-item">
                        <a href="<?php echo base_url();?>">Home </a>
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
                      <li >
                        <a href="<?php echo base_url("campaign");?>">Campaign</a>
                      </li>
                    </ul>
                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </header>