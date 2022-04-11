<!doctype html>
<!--[if lt IE 7]>   <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>      <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>      <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js" lang=""> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="google-site-verification" content="F3FR2MzCG2t7cJKVQevNv0BPaMekwqz8lAQLT5rmSZE" />

  <title><?php if(isset($heading)) echo $heading; else echo 'Classi Bazaar - Free Classified Ads';?></title>
 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:url"                content="<?php echo current_url();?>" />
  <meta property="og:type"               content="article" />
  <?php if(@$type == 'quiz'){?>
     <meta name="description" content="<?php echo @$campaign_answer->name; ?> recently participated in Classibazaar Quiz.">
  <meta property="og:title" content="<?php echo @$campaign_answer->campaign_name; ?>" />
  <meta property="og:description"   content="<?php echo @$campaign_answer->name; ?> recently participated in Classibazaar Quiz." />
<?php }else{ ?>
   <meta name="description" content="<?php echo @$campaign->camp_prefix;?><?php echo @$user->id;?> and some text goes here.">
  <meta property="og:title" content="Classi Bazaar - Free Classified Ads" />
  <meta property="og:description"   content="<?php echo @$campaign->camp_prefix;?><?php echo @$user->id;?> and some text goes here." />
<?php } ?>
  <meta property="og:image"         content="<?php echo base_url(); ?>logo-classibazaar.jpg" />

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

  p#div_error{
    color: red !important;
    padding-left: 15px !important;
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
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.1&appId=304808066993739&autoLogAppEvents=1';
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
          <div class="tg-topbar campaign">
            <div class="container">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                 <?php /* <ul class="tg-navcurrency">
                  <li><a href="#" data-toggle="modal" data-target="#tg-modalselectcurrency">select currency</a></li>
                  <li><a href="#" data-toggle="modal" data-target="#tg-modalpriceconverter">Price converter</a></li>
                </ul> */ ?>
                <div class="dropdown tg-themedropdown tg-userdropdown">

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
                <strong class="tg-logo"><a href="<?php echo base_url(""); ?>"> <img src="<?php echo $config->config_value;?>" alt="Classibazzar" style="max-height:100px;width: auto;"/></a></strong>

                <nav id="tg-nav" class="tg-nav">

                  <div id="tg-navigation" class="collapse navbar-collapse tg-navigation">

                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </header>