<!doctype html>
<html class="fixed">
<head>
  <?php 
  //echo date("h:i a");
  ?>
  <!-- Basic -->
  <meta charset="UTF-8">

  <meta name="keywords" content="HTML5 Admin Template" />
  <meta name="description" content="Porto Admin - Responsive HTML5 Template">
  <meta name="author" content="okler.net">

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

  <!-- Web Fonts  -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.css" />

  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/magnific-popup/magnific-popup.css" />
  <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

  <!-- Theme CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/theme.css" />

  <!-- Skin CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/skins/default.css" />

  <!-- Theme Custom CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/theme-custom.css">

  <!-- Head Libs -->
  <script src="<?php echo base_url();?>assets/vendor/modernizr/modernizr.js"></script>
</head>
<body style="background-color:#333333">
  <!-- start: page -->
  
  <section class="body-sign" >
    <div class="center-sign">



      <section id="LockScreenInline" class="body-sign body-locked body-locked-inline">
        <div class="center-sign">
          <div class="panel panel-sign">
            <div class="panel-body">
              <form action="<?php echo base_url("login/checkpasscode");?>" id="form" method="post">
                <div class="current-user text-center">
                  <?php if(file_exists('../assets/uploads/users/thumb/'.$users->thumbnail) && $users->thumbnail !=""){ ?>
                  <img src="<?php echo SITE_URL.'assets/uploads/users/thumb/'.$users->thumbnail;?>" class="img-circle user-image" >
                  <?php }else{?>
                  <img src="<?php echo base_url("");?>assets/images/!logged-user.jpg" alt="Joseph Doe" class="img-circle user-image" data-lock-picture="<?php base_url("");?>assets/images/!logged-user.jpg" />
                  <?php }?>

                  <h2 id="LockUserName" class="user-name text-dark m-none"><?php echo $users->user_name;?></h2>
                  <p  id="LockUserEmail" class="user-email m-none"><?php echo $users->email;?></p>
                </div>
                <div class="form-group mb-lg">
                  <div class="input-group input-group-icon">
                    <input id="pwd" name="pwd" type="password" class="form-control input-lg" placeholder="Pass Code" required />
                    <span class="input-group-addon">
                      <span class="icon icon-lg">
                        <i class="fa fa-lock"></i>
                      </span>
                    </span>

                  </div>
                  <?php 
                  if(isset($error)) echo '<br><label for="pwd" class="error">Invalide Pass Code.</label>';
                  ?>
                </div>

                <div class="row">
                  <div class="col-xs-6">
                    <p class="mt-xs mb-none">
                      <a href="<?php echo base_url("login?user=no");?>">Not <?php echo $users->first_name.' '.$users->last_name;?>?</a>
                    </p>
                  </div>
                  <div class="col-xs-6 text-right">
                   <input type="submit" name="submit" class="btn btn-primary hidden-xs" value="Unlock">
                   <input type="submit" name="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg" value="Unlock">
                 </div>
               </div>
             </form>
           </div>
         </div>
       </div>
     </section>



     <p class="text-center text-muted mt-md mb-md">&copy; Copyright <?php echo date("Y");?>. All Rights Reserved.</p>
   </div>
 </section>
 <!-- end: page -->

 <!-- Vendor -->
 <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.js"></script>
 <script src="<?php echo base_url();?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
 <script src="<?php echo base_url();?>/vendor/bootstrap/js/bootstrap.js"></script>
 <script src="<?php echo base_url();?>assets/vendor/nanoscroller/nanoscroller.js"></script>
 <script src="<?php echo base_url();?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
 <script src="<?php echo base_url();?>assets/vendor/magnific-popup/magnific-popup.js"></script>
 <script src="<?php echo base_url();?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
 <script src="<?php echo base_url("");?>assets/vendor/jquery-validation/jquery.validate.js"></script>
 <script src="<?php echo base_url("");?>assets/javascripts/forms/examples.validation.js"></script>

 <!-- Theme Base, Components and Settings -->
 <script src="<?php echo base_url();?>assets/javascripts/theme.js"></script>

 <!-- Theme Custom -->
 <script src="<?php echo base_url();?>assets/javascripts/theme.custom.js"></script>

 <!-- Theme Initialization Files -->
 <script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>

</body>
</html>