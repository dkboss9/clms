<!doctype html>
<!--[if lt IE 7]>   <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>      <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>      <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js" lang=""> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if(isset($heading)) echo $heading; else 'Classi Bazaar - Free Classified Ads';?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon" />
  <base href="<?php echo base_url();?>" />

  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="mobile-web-app-capable" content="yes">

  <meta name="apple-mobile-web-app-title" content="Add to Home">

  <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url("assets/images/logo.png");?>">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?php echo base_url("assets/images/logo.png");?>">
  <meta name="theme-color" content="#ffffff">

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url("assets/images/logo.png");?>">
  <?php /* <link rel="shortcut icon" href="<?php echo base_url("assets");?>/img/favicon.ico" type="image/x-icon" /> */ ?>
  <link rel="apple-touch-icon" href="<?php echo base_url("assets/images/logo.png");?>">

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Web Fonts  -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/addtohomescreen.css">
  <script src="<?php echo base_url();?>assets/js/addtohomescreen.js"></script>
  <?php if(isset($add_to_home)){?>
  <script>
    addToHomescreen();
  </script>
  <?php } ?>
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

    .tg-navigationarea .tg-btn {
     margin-top: 0; 
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

<script type="text/javascript" src="<?php echo base_url();?>assets/js-old/jquery-1.8.3.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js-old/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js-old/amazon_scroller.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js-old/jquery.colorbox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js-old/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css-old/colorbox.css" media="screen" />
<script type='text/javascript' src="<?php echo base_url();?>assets/js-old/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="<?php echo base_url("assets/");?>/css/jquery.autocomplete.css">
<?php if(isset($map)) echo $map['js'];?>
<script src="<?php echo base_url();?>assets/js-old/ddaccordion.js" type="text/javascript"></script>
<?php if($this->uri->segment(1) !="post-ad.html"){?>
<script type='text/javascript' src="<?php echo base_url();?>assets/js-old/home.js"></script>
<script src="<?php echo base_url();?>assets/js-old/jquery.bpopup.min.js" type="text/javascript"></script>
<?php } ?>

<script src="http://maps.google.com/maps/api/js?key=AIzaSyCR-KEWAVCn52mSdeVeTqZjtqbmVJyfSus&language=en"></script>
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

<script src="<?php echo base_url("assets/");?>/js/countTo.js"></script>
<script src="<?php echo base_url("assets/");?>/js/appear.js"></script>
<script src="<?php echo base_url("assets/");?>/js/gmap3.js"></script>
<script src="<?php echo base_url("assets/");?>/js/main.js"></script>

<script>
 if ('serviceWorker' in navigator) { 
    console.log("Will the service worker register?");
    navigator.serviceWorker.register('/service-worker.js')
      .then(function(reg){
        console.log("Yes, it did.");
     }).catch(function(err) {
        console.log("No it didn't. This happened:", err)
    });
 }
</script>

<link rel="manifest" href="/manifest.json">

<script type="text/javascript">
  ddaccordion.init({ //top level headers initialization
    headerclass: "expandable", //Shared CSS class name of headers group that are expandable
    contentclass: "categoryitems", //Shared CSS class name of contents group
    revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
    mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
    collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
    defaultexpanded: [0], //index of content(s) open by default [index1, index2, etc]. [] denotes no content
    onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
    animatedefault: false, //Should contents open by default be animated into view?
    persiststate: true, //persist state of opened contents within browser session?
    toggleclass: ["", "openheader"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
    togglehtml: ["prefix", "<img src='<?php echo base_url();?>assets/images/plus.gif' class='statusicon' />", "<img src='<?php echo base_url();?>assets/images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
    animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
    oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
      //do nothing
    },
    onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
      //do nothing
    }
  })

  ddaccordion.init({ //2nd level headers initialization
    headerclass: "subexpandable", //Shared CSS class name of sub headers group that are expandable
    contentclass: "subcategoryitems", //Shared CSS class name of sub contents group
    revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click" or "mouseover
    mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
    collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
    defaultexpanded: [], //index of content(s) open by default [index1, index2, etc]. [] denotes no content
    onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
    animatedefault: false, //Should contents open by default be animated into view?
    persiststate: true, //persist state of opened contents within browser session?
    toggleclass: ["opensubheader", "closedsubheader"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
    togglehtml: ["prefix", "<img src='<?php echo base_url();?>assets/images/plus.gif' class='statusicon' />&nbsp;&nbsp;", "<img src='<?php echo base_url();?>assets/images/minus.gif' class='statusicon' />&nbsp;&nbsp;"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
    animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
    oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
      //do nothing
    },
    onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
      //do nothing
    }
  });
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
           
            <div class="tg-navigationarea">
              <div class="container">
                <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                   <a class="tg-btn" href='<?php echo $_SERVER["HTTP_REFERER"]; ?>'>
                    <i class="fa fa-arrow-left"></i>
                    <span>Back</span>
                  </a>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <nav id="tg-nav" class="tg-nav">
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#tg-navigation" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <?php if(isset($list_view)){?>
                      <button type="button" class="navbar-toggle collapsed link_top_search" id="link_mob" style="margin-right: 5px;color: #fff;">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                      </button>
                      <?php } ?>
                      <?php if($this->uri->segment(1) != "" && $this->uri->segment(1) != "job" && $this->uri->segment(1) != "realstate" && $this->uri->segment(1) != "car" ) { ?>
                      <button type="button" class="navbar-toggle collapsed link_top_search" id="link_mob_search"  style="margin-right: 5px;color: #fff;">
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
                      </ul>
                    </div>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </header>